<?php
session_start();
include("conn.php");

// Verifica se o usuário é admin
if (!isset($_SESSION['usuario']) || $_SESSION['nivel'] != 1) {
    header("Location: index.php?erro=sem_acesso");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['acao'])) {
    $id = intval($_POST['id']);
    $acao = $_POST['acao']; // "aprovar" ou "rejeitar"

    if ($acao === "aprovar") {
        // Aplica os campos pendentes nos campos principais
        $sql = "UPDATE tab_obras SET 
                    nome = nome_pendente,
                    descricao = descricao_pendente,
                    prazo = prazo_pendente,
                    localizacao = localizacao_pendente,
                    id_status = id_status_pendente,
                    nome_pendente=NULL,
                    descricao_pendente=NULL,
                    prazo_pendente=NULL,
                    localizacao_pendente=NULL,
                    id_status_pendente=NULL,
                    pendente_edicao=0
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    } elseif ($acao === "rejeitar") {
        // Limpa os campos pendentes sem aplicar
        $sql = "UPDATE tab_obras SET 
                    nome_pendente=NULL,
                    descricao_pendente=NULL,
                    prazo_pendente=NULL,
                    localizacao_pendente=NULL,
                    id_status_pendente=NULL,
                    pendente_edicao=0
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    } else {
        header("Location: index.php?erro=acao_invalida");
        exit;
    }

    if ($stmt->execute()) {
        header("Location: admin_pendentes.php?sucesso=acao_realizada");
        exit;
    } else {
        echo "Erro ao processar ação.";
        exit;
    }
} else {
    header("Location: index.php?erro=requisição_invalida");
    exit;
}
?>
