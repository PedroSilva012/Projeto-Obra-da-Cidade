<?php
session_start();
include("conn.php");
mysqli_set_charset($conn, "utf8");

$erroLogin = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuarioDigitado = $_POST["usuario"] ?? '';
    $senhaDigitada   = $_POST["senha"] ?? '';

    if ($usuarioDigitado && $senhaDigitada) {
        // Busca o usuário pelo campo 'usuario' (não pelo e-mail)
        $sql = "SELECT * FROM tab_usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $usuarioDigitado);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 1) {
                $row = $resultado->fetch_assoc();

                // Aqui você pode trocar por password_verify se usar senhas criptografadas
                if ($senhaDigitada === $row["senha"]) {
                    // Login bem-sucedido -> salva dados na sessão
                    $_SESSION["id_usuario"]   = $row["id"];
                    $_SESSION["usuario"]      = $row["usuario"];
                    $_SESSION["nivel_acesso"] = $row["nivel_acesso"];

                    header("Location: index.php");
                    exit;
                } else {
                    $erroLogin = "Senha incorreta.";
                }
            } else {
                $erroLogin = "Usuário não encontrado.";
            }
        } else {
            $erroLogin = "Erro na consulta: " . $conn->error;
        }
    } else {
        $erroLogin = "Preencha todos os campos.";
    }
}
?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body class="bg-dark-subtle d-flex align-items-center justify-content-center vh-100">

<div class="card shadow-sm p-4" style="max-width:400px; width:100%;">
  <h3 class="text-center mb-3">Login</h3>
  <?php if (!empty($erro)): ?>
    <div class="alert alert-danger py-2"><?=$erro?></div>
  <?php endif; ?>
  <form method="POST" action="">
    <div class="mb-3">
      <label class="form-label">Usuário</label>
      <input type="text" name="usuario" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Senha</label>
      <input type="password" name="senha" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Entrar</button>
    <a href="cadastro.php" class="d-block mt-3 text-center">Não tem login? Cadastre-se</a>
  </form>
</div>

</body>
</html>
