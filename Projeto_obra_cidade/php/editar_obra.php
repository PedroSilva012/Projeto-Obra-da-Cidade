<?php
session_start();
include("conn.php");

// Verifica se está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Pega o ID da obra
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo "<p>ID inválido. <a href='index.php'>Voltar</a></p>";
    exit;
}

// Inicializa variáveis
$nome = $descricao = $prazo = $localizacao = '';
$id_status = 0;
$mensagem = '';

// Se o formulário foi enviado, processa a atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recebe e limpa os dados
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $prazo = trim($_POST['prazo'] ?? '');
    $localizacao = trim($_POST['localizacao'] ?? '');
    $status = intval($_POST['status'] ?? 0);
    $id_status = $status;

    // Validação
    $erros = [];
    if ($nome === '') $erros[] = "Nome é obrigatório.";
    if ($descricao === '') $erros[] = "Descrição é obrigatória.";
    if ($status <= 0) $erros[] = "Status inválido.";
    if ($prazo !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $prazo)) {
        $erros[] = "Data inválida. Use o formato YYYY-MM-DD.";
    }

    if (count($erros) === 0) {
        // Marca como pendente (ex: id_status = 1)
        $pendente_status = 1;

        $stmt = $conn->prepare("
            UPDATE tab_obras 
            SET nome=?, descricao=?, prazo=?, localizacao=?, id_status=?
            WHERE id=?
        ");
        $stmt->bind_param("ssssii", $nome, $descricao, $prazo, $localizacao, $pendente_status, $id);

        if ($stmt->execute()) {
            $mensagem = "<p style='color:green;'>Obra atualizada com sucesso! A edição ficará pendente de aprovação do administrador.</p>";
        } else {
            $mensagem = "<p style='color:red;'>Erro ao atualizar obra: " . htmlspecialchars($stmt->error) . "</p>";
        }

        $stmt->close();
    } else {
        // Mostra erros
        $mensagem = '';
        foreach ($erros as $e) {
            $mensagem .= "<p style='color:red;'>$e</p>";
        }
    }
}

// Busca os dados atuais da obra (ou atualizados)
$stmt = $conn->prepare("SELECT nome, descricao, prazo, localizacao, id_status FROM tab_obras WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($nome_db, $descricao_db, $prazo_db, $localizacao_db, $id_status_db);
$stmt->fetch();
$stmt->close();

// Se o formulário não foi enviado, preenche os campos com os valores do banco
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $nome = $nome_db;
    $descricao = $descricao_db;
    $prazo = $prazo_db;
    $localizacao = $localizacao_db;
    $id_status = $id_status_db;
}
?>

<h2>Editar Obra</h2>

<?= $mensagem ?>

<form action="" method="POST">
    <input type="hidden" name="id" value="<?= $id ?>">

    <label>Nome:</label><br>
    <input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" required><?= htmlspecialchars($descricao) ?></textarea><br><br>

    <label>Prazo:</label><br>
    <input type="date" name="prazo" value="<?= $prazo ?>"><br><br>

    <label>Localização:</label><br>
    <input type="text" name="localizacao" value="<?= htmlspecialchars($localizacao) ?>"><br><br>

    <label>Status:</label><br>
    <select name="status" required>
        <?php
        $res = $conn->query("SELECT id_status, status FROM tab_status");
        while ($row = $res->fetch_assoc()) {
            $sel = ($row['id_status'] == $current) ? "selected" : "";
            echo "<option value='"
                 . htmlspecialchars($row['id_status'], ENT_QUOTES)
                 . "' $sel>"
                 . htmlspecialchars($row['status'], ENT_QUOTES)
                 . "</option>";
          }
          
        ?>
    </select><br><br>

    <button type="submit">Enviar Edição</button>
</form>

<p>Após enviar, a edição ficará <b>pendente</b> de aprovação do administrador.</p>
