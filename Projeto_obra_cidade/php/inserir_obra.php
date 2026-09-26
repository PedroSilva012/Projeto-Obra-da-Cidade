<?php
session_start();
include("conn.php");
mysqli_set_charset($conn, "utf8");

// Verifica login
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php?msgErro=Você precisa estar logado para adicionar uma obra.");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome        = $_POST['nome'] ?? '';
    $descricao   = $_POST['descricao'] ?? '';
    $prazo       = $_POST['prazo'] ?? null;
    $localizacao = $_POST['localizacao'] ?? '';
    $id_status   = intval($_POST['id_status']); // agora vem do select do form

    // Upload da imagem (opcional)
    $imagem = null;
    if (!empty($_FILES['imagem']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($_FILES["imagem"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $targetFilePath)) {
            $imagem = $fileName;
        }
    }

    // Prepara SQL
    if ($imagem) {
        $sql = "INSERT INTO tab_obras (nome, descricao, prazo, localizacao, imagem, id_status) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nome, $descricao, $prazo, $localizacao, $imagem, $id_status);
    } else {
        $sql = "INSERT INTO tab_obras (nome, descricao, prazo, localizacao, id_status) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nome, $descricao, $prazo, $localizacao, $id_status);
    }

    // Executa e redireciona
    if ($stmt->execute()) {
        header("Location: index.php?msg=Obra adicionada com sucesso");
        exit;
    } else {
        // Em caso de erro, mostra mensagem amigável
        echo "<div style='margin:20px; padding:15px; border:1px solid red; color:red;'>
                <strong>Erro ao inserir obra:</strong> " . htmlspecialchars($stmt->error, ENT_QUOTES) . "
              </div>";
    }
}

// Valida se não está vazio
if (empty($nome) || empty($endereco)) {
    echo "<script>alert('Preencha todos os campos obrigatórios!'); window.history.back();</script>";
    exit;
}

// 1. Verifica duplicidade
$sql = "SELECT id FROM tab_obras WHERE nome = ? AND endereco = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $nome, $endereco);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    // Já existe obra igual
    echo "<script>alert('Já existe uma obra com esse nome e endereço!'); window.history.back();</script>";
    exit;
}
?>
