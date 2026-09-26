<?php
session_start();
require 'conn.php';

// Apenas usuários comuns (nível != 1) podem solicitar
if (!isset($_SESSION['usuario']) || $_SESSION['nivel_acesso'] == 1) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $novo_nome  = $_POST['nome'] ?? null;
    $nova_desc  = $_POST['descricao'] ?? null;
    $novo_prazo = $_POST['prazo'] ?? null;
    $nova_loc   = $_POST['localizacao'] ?? null;
    $nova_imagem = null;
    
    // Para uma nova sugestão, o status inicial será sempre 'planejada' (id_status = 2 no seu banco)
    $id_status_sugerido = 2; 

    // Lógica para tratar o upload da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = uniqid() . '-' . basename($_FILES["imagem"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $targetFilePath)) {
            $nova_imagem = $fileName;
        }
    }

    // Insere o pedido de CRIAÇÃO. Note que id_obra é NULL.
    $sql = "INSERT INTO tab_pedidos 
            (id_usuario, id_obra, tipo_pedido, novo_nome, nova_descricao, novo_prazo, nova_localizacao, nova_imagem, id_status)
            VALUES (?, NULL, 'criar', ?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    // Bind dos 7 parâmetros (1 integer, 6 strings)
    $stmt->bind_param("isssssi", $id_usuario, $novo_nome, $nova_desc, $novo_prazo, $nova_loc, $nova_imagem, $id_status_sugerido);

    if ($stmt->execute()) {
        header("Location: index.php?msg=pedido_criacao_enviado");
        exit;
    } else {
        echo "Erro ao solicitar criação: " . $conn->error;
    }
}