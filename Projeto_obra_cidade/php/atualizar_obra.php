<?php
session_start();
include("conn.php");
mysqli_set_charset($conn, "utf8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id          = intval($_POST['id']);
    $nome        = $_POST['nome'] ?? '';
    $descricao   = $_POST['descricao'] ?? '';
    $prazo       = $_POST['prazo'] ?? null;
    $localizacao = $_POST['localizacao'] ?? '';
    $id_status   = intval($_POST['id_status']); // vem do select do modal

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

    // Monta SQL de update
    if ($imagem) {
        $sql = "UPDATE tab_obras 
                   SET nome=?, descricao=?, prazo=?, localizacao=?, imagem=?, id_status=? 
                 WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $nome, $descricao, $prazo, $localizacao, $imagem, $id_status, $id);
    } else {
        $sql = "UPDATE tab_obras 
                   SET nome=?, descricao=?, prazo=?, localizacao=?, id_status=? 
                 WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $nome, $descricao, $prazo, $localizacao, $id_status, $id);
    }

    // Executa e redireciona
    if ($stmt->execute()) {
        header("Location: index.php?msg=Obra atualizada com sucesso");
        exit;
    } else {
        echo "<div style='margin:20px; padding:15px; border:1px solid red; color:red;'>
                <strong>Erro ao atualizar obra:</strong> " . htmlspecialchars($stmt->error, ENT_QUOTES) . "
              </div>";
    }
}
?>
