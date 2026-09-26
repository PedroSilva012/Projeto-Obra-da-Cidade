<?php
session_start();
require 'conn.php';

// 1. Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

// 2. Apenas usuários com nível de acesso 2 (USER) podem solicitar
if ($_SESSION['nivel_acesso'] != 2) {
    die("Acesso negado. Apenas usuários comuns podem solicitar a exclusão de obras.");
}

// 3. Verifica se o formulário foi enviado (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 4. Pega os dados necessários (ID da obra do formulário e ID do usuário da sessão)
    $id_obra    = intval($_POST['id_obra'] ?? 0);
    $id_usuario = $_SESSION['id_usuario'];

    // Validação básica
    if ($id_obra <= 0) {
        die("ID da obra inválido.");
    }

    // 5. Prepara e executa a inserção na tabela de pedidos
    // O tipo do pedido será 'apagar', conforme definido no seu banco de dados
    $sql = "INSERT INTO tab_pedidos (id_usuario, id_obra, tipo_pedido) VALUES (?, ?, 'apagar')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_usuario, $id_obra);

    if ($stmt->execute()) {
        // 6. Se deu certo, redireciona de volta para a página inicial com uma mensagem de sucesso
        header("Location: index.php?msg=solicitacao_exclusao_enviada");
        exit;
    } else {
        // Se deu erro, exibe uma mensagem
        echo "Ocorreu um erro ao registrar sua solicitação. Por favor, tente novamente.";
        // Em um ambiente de produção, seria ideal logar este erro: error_log($conn->error);
    }

} else {
    // Se alguém tentar acessar o arquivo diretamente, redireciona para a página inicial
    header("Location: index.php");
    exit;
}
?>