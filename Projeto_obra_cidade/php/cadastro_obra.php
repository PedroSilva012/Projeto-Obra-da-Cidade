<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header('location:login.php?msgErro=3');
    exit;
}

include("conn.php");
mysqli_set_charset($conn, "utf8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Receber os campos do formulário
    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $descricao = mysqli_real_escape_string($conn, $_POST["descricao"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);
    $prazo = mysqli_real_escape_string($conn, $_POST["prazo"]);
    $localizacao = mysqli_real_escape_string($conn, $_POST["localizacao"]);
    
    // Upload da imagem (opcional)
    $imagemPath = null;
    if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid("obra_") . "." . $extensao;
        $caminhoDestino = "uploads/" . $nomeArquivo;

        // Cria pasta se não existir
        if (!is_dir("uploads")) {
            mkdir("uploads", 0755, true);
        }

        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoDestino)) {
            $imagemPath = $caminhoDestino;
        }
    }

    // Inserir no banco
    $sql = "INSERT INTO tab_obras (nome, descricao, status, prazo, localizacao, imagem)
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $nome, $descricao, $status, $prazo, $localizacao, $imagemPath);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?msgSucesso=Obra cadastrada com sucesso");
        exit;
    } else {
        echo "Erro ao cadastrar obra: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Método inválido.";
}

mysqli_close($conn);
?>
