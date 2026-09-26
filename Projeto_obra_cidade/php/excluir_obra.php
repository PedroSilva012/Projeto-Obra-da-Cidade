<?php
session_start();
include("conn.php"); // Conecta ao banco

// Redireciona se não estiver logado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]); // Garante que seja número

    // Pega nome da imagem antes de apagar a obra
    $res = $conn->prepare("SELECT imagem FROM tab_obras WHERE id = ?");
    $res->bind_param("i", $id);
    $res->execute();
    $res->bind_result($imagemNome);
    $res->fetch();
    $res->close();

    // Deleta a obra usando prepared statement
    $stmt = $conn->prepare("DELETE FROM tab_obras WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Apaga a imagem do servidor se existir
        if (!empty($imagemNome)) {
            $uploadDir = __DIR__ . '/uploads/';
            if (file_exists($uploadDir . $imagemNome)) {
                unlink($uploadDir . $imagemNome);
            }
        }

        header("Location: index.php?msgSucesso=Obra apagada com sucesso");
        exit;
    } else {
        header("Location: index.php?msgErro=Erro ao apagar obra");
        exit;
    }
} else {
    header("Location: index.php?msgErro=Requisição inválida");
    exit;
}
?>
