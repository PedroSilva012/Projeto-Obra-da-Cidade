<?php
session_start();
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario        = trim($_POST["usuario"]);
    $email          = trim($_POST["email"]);
    $senha          = trim($_POST["senha"]);
    $confirma_senha = trim($_POST["confirma_senha"]);

    // Verifica se senha e confirmação são iguais
    if ($senha !== $confirma_senha) {
        $_SESSION['erro'] = "As senhas não coincidem.";
        header("Location: cadastro.php");
        exit;
    }

    // Verifica se usuário já existe
    $sql_check = "SELECT id FROM tab_usuarios WHERE usuario = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt, "ss", $usuario, $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($res && $res->num_rows > 0) {
        $_SESSION['erro'] = "Usuário ou e-mail já cadastrado.";
        header("Location: cadastro.php");
        exit;
    }

    // Insere usuário no banco
    $sql_insert = "INSERT INTO tab_usuarios (usuario, email, senha, nivel_acesso) VALUES (?, ?, ?, 0)";
    $stmt = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt, "sss", $usuario, $email, $senha);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['msg'] = "Cadastro realizado com sucesso! Faça login.";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['erro'] = "Erro ao cadastrar. Tente novamente.";
        header("Location: cadastro.php");
        exit;
    }
} else {
    header("Location: cadastro.php");
    exit;
}
