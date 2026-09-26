<?php
session_start();
include("conn.php");

$erro = "";
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-info d-flex align-items-center justify-content-center vh-100">

<div class="card shadow-sm p-4" style="max-width:400px; width:100%;">
  <h3 class="text-center mb-3">Cadastro</h3>
  <?php if (!empty($erro)): ?>
    <div class="alert alert-danger py-2"><?=$erro?></div>
  <?php endif; ?>

  <form method="POST" action="processa_cadastro.php">
  <?php if (!empty($_SESSION['erro'])): ?>
  <div class="alert alert-danger py-2"><?=$_SESSION['erro']?></div>
  <?php unset($_SESSION['erro']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['msg'])): ?>
  <div class="alert alert-success py-2"><?=$_SESSION['msg']?></div>
  <?php unset($_SESSION['msg']); ?>
<?php endif; ?>

    <div class="mb-3">
      <label class="form-label">Usuário</label>
      <input type="text" name="usuario" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">E-mail</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Senha</label>
      <input type="password" name="senha" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Confirmar Senha</label>
      <input type="password" name="confirma_senha" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success w-100">Cadastrar</button>
    <a href="login.php" class="d-block mt-3 text-center">Já tem conta? Faça login</a>
  </form>
</div>




</body>
</html>
