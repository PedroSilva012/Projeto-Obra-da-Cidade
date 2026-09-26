<?php
session_start();
require 'conn.php';

// Verifica login
if (!isset($_SESSION['usuario']) || $_SESSION['nivel_acesso'] != 2) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $id_obra    = intval($_POST['id_obra']);
    $novo_nome  = $_POST['nome'] ?? null;
    $nova_desc  = $_POST['descricao'] ?? null;
    $novo_prazo = $_POST['prazo'] ?? null;
    $nova_loc   = $_POST['localizacao'] ?? null;
    $nova_imagem = null;

    // LÓGICA PARA TRATAR O UPLOAD DA IMAGEM
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $targetDir = "uploads/";
        // Cria um nome de arquivo único para evitar conflitos
        $fileName = uniqid() . '-' . basename($_FILES["imagem"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        // Move o arquivo para a pasta de uploads
        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $targetFilePath)) {
            $nova_imagem = $fileName;
        }
    }

    $sql = "INSERT INTO tab_pedidos 
            (id_usuario, id_obra, tipo_pedido, novo_nome, nova_descricao, novo_prazo, nova_localizacao, nova_imagem)
            VALUES (?, ?, 'editar', ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . htmlspecialchars($conn->error));
    }
    
    // LINHA CORRIGIDA - Removido um 's' da string de tipos. Agora são 7 letras para 7 variáveis.
    $stmt->bind_param("iisssss", $id_usuario, $id_obra, $novo_nome, $nova_desc, $novo_prazo, $nova_loc, $nova_imagem);

    if ($stmt->execute()) {
        header("Location: index.php?msg=pedido_enviado");
        exit;
    } else {
        echo "Erro ao solicitar edição: " . $conn->error;
    }
} else {
    echo "Requisição inválida.";
}