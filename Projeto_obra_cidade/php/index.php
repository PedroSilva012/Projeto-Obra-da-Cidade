<?php
session_start();

// DEBUG: enquanto estiver testando, habilite para ver erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("conn.php");
$nivelAcesso = $_SESSION['nivel_acesso'] ?? 0;

// consulta obras (verifica $conn)
if (!isset($conn)) {
  die("Erro: conexão com o banco não encontrada (conn.php).");
}

$sql = "SELECT o.*, s.status AS status 
        FROM tab_obras o 
        LEFT JOIN tab_status s ON o.id_status = s.id_status 
        ORDER BY o.id DESC";
$res = $conn->query($sql);

$obras = ['planejada' => [], 'em andamento' => [], 'concluida' => []];

if ($res) {
  while ($obra = $res->fetch_assoc()) {
    $statusRaw = strtolower(trim($obra['status'] ?? ''));
    // normaliza variações possíveis
    if (strpos($statusRaw, 'andamento') !== false) $key = 'em andamento';
    elseif (strpos($statusRaw, 'planej') !== false) $key = 'planejada';
    elseif (strpos($statusRaw, 'concl') !== false) $key = 'concluida';
    else $key = 'planejada';
    $obras[$key][] = $obra;
  }
}

// função para renderizar um card (usa sempre $_SESSION['nivel_acesso'])
function renderObra($obra)
{
  global $conn;
  $nivelAcesso = $_SESSION['nivel_acesso'] ?? 0;

  $id   = isset($obra['id']) ? (int)$obra['id'] : 0;
  $nome = $obra['nome'] ?? '';
  $descricao = $obra['descricao'] ?? '';
  $prazo = $obra['prazo'] ?? '';
  $local = $obra['localizacao'] ?? '';
  $status = $obra['status'] ?? '';
  $imagem = !empty($obra['imagem']) ? "uploads/" . $obra['imagem'] : "img/fundo_default.png";

  // Define cor do badge
  $statusKey = strtolower(trim($status));
  switch ($statusKey) {
    case 'planejada':
      $badgeClass = 'bg-primary';
      break;
    case 'em andamento':
      $badgeClass = 'bg-warning text-dark';
      break;
    case 'concluida':
    case 'concluída':
      $badgeClass = 'bg-success';
      break;
    default:
      $badgeClass = 'bg-secondary';
  }

  ob_start();
?>
  <div class="col-md-4 mb-4">
  <div class="card h-100 shadow-sm">
    <img src="<?= htmlspecialchars($imagem, ENT_QUOTES) ?>" class="card-img-top" alt="Imagem da Obra">
    <div class="card-body d-flex flex-column">
      <h5 class="card-title"><?= htmlspecialchars($nome, ENT_QUOTES) ?></h5>
      <p class="card-text flex-grow-1"><?= nl2br(htmlspecialchars($descricao, ENT_QUOTES)) ?></p>
      <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($status, ENT_QUOTES) ?></span>
    </div>
    <div class="card-footer small">
      <div><strong>Prazo:</strong> <?= htmlspecialchars($prazo, ENT_QUOTES) ?></div>
      <div><strong>Localização:</strong> <?= htmlspecialchars($local, ENT_QUOTES) ?></div>

      <div class="mt-2 d-flex gap-2">
        <?php if (!empty($_SESSION['usuario'])): ?>

          <?php if ($nivelAcesso == 1): ?>
            <!-- Admin pode editar e excluir direto -->
            <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editarObra<?= $id ?>">
              <i class="fas fa-edit"></i> Editar
            </button>

            <form action="excluir_obra.php" method="POST" onsubmit="return confirm('Deseja apagar esta obra?');" class="d-inline">
              <input type="hidden" name="id" value="<?= $id ?>">
              <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-trash"></i> Apagar
              </button>
            </form>

            <!-- Modal de Edição (só para admin) -->
            <div class="modal fade" id="editarObra<?= $id ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="atualizar_obra.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                      <h5 class="modal-title">Editar <?= htmlspecialchars($nome, ENT_QUOTES) ?></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="id" value="<?= $id ?>">

                      <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($nome, ENT_QUOTES) ?>" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" required><?= htmlspecialchars($descricao, ENT_QUOTES) ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="id_status" class="form-control" required>
                          <?php
                          $sqlStatus = "SELECT * FROM tab_status";
                          $resStatus = mysqli_query($conn, $sqlStatus);
                          while ($st = mysqli_fetch_assoc($resStatus)) {
                            $selected = ($st['id_status'] == $obra['id_status']) ? "selected" : "";
                            echo "<option value='{$st['id_status']}' $selected>{$st['status']}</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Prazo</label>
                        <input type="date" name="prazo" class="form-control" value="<?= htmlspecialchars($prazo, ENT_QUOTES) ?>">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Localização</label>
                        <input type="text" name="localizacao" class="form-control" value="<?= htmlspecialchars($local, ENT_QUOTES) ?>">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Imagem</label>
                        <input type="file" name="imagem" class="form-control" accept="image/*">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <?php else: ?>
    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#solicitarEdicao<?= $id ?>">
        <i class="fas fa-edit"></i> Solicitar Edição
    </button>

    <div class="modal fade" id="solicitarEdicao<?= $id ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="solicitar_edicao.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Solicitar Edição de <?= htmlspecialchars($nome, ENT_QUOTES) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_obra" value="<?= $id ?>">

                        <div class="mb-3">
                            <label class="form-label">Nome da Obra</label>
                            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($nome, ENT_QUOTES) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" class="form-control" rows="4" required><?= htmlspecialchars($descricao, ENT_QUOTES) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prazo</label>
                            <input type="date" name="prazo" class="form-control" value="<?= htmlspecialchars($prazo, ENT_QUOTES) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Localização</label>
                            <input type="text" name="localizacao" class="form-control" value="<?= htmlspecialchars($local, ENT_QUOTES) ?>">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Sugerir Nova Imagem (Opcional)</label>
                          <input type="file" name="imagem" class="form-control" accept="image/*">
                        </div>
                        <p class="small text-muted">Sua solicitação de edição será enviada para aprovação de um administrador.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Enviar Pedido de Edição</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#solicitarExclusao<?= $id ?>">
        <i class="fas fa-trash"></i> Solicitar Exclusão
    </button>

    <div class="modal fade" id="solicitarExclusao<?= $id ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="solicitar_exclusao.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Solicitar Exclusão de <?= htmlspecialchars($nome, ENT_QUOTES) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_obra" value="<?= $id ?>">
                        <p>Tem certeza que deseja solicitar a exclusão desta obra?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Enviar Solicitação</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

        <?php else: ?>
          <!-- Visitante não logado -->
          <button class="btn btn-sm btn-outline-secondary" onclick="window.location.href='login.php';">
            <i class="fas fa-sign-in-alt"></i> Entrar para editar
          </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php
  return ob_get_clean();
}
?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Obras da Cidade</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <!-- Cabeçalho -->
  <header class="mb-4">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="#"><i class="fas fa-hard-hat me-2"></i>Obras da Cidade</a>

        <!-- Botão Nova Obra (visível para todos) -->
        <?php if (isset($_SESSION['usuario'])): ?>
          <!-- Se estiver logado, abre o modal de Nova Obra -->
          <a class="btn btn-light ms-3" data-bs-toggle="modal" data-bs-target="#novaObraModal">
            <i class="fas fa-plus"></i> Nova Obra
          </a>
        <?php else: ?>
          <!-- Se não estiver logado, manda para o login -->
          <a class="btn btn-light ms-3" href="login.php">
            <i class="fas fa-plus"></i> Nova Obra
          </a>
        <?php endif; ?>


        <!-- Campo onde mostra o usuario -->
        <div class="collapse navbar-collapse justify-content-end">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                <img class="rounded-circle" src="img/undraw_profile.svg" width="32">
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <span class="dropdown-item">
                    <?php echo !empty($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario'], ENT_QUOTES) : 'Convidado'; ?>
                  </span>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <?php if (!empty($_SESSION['usuario'])): ?>
                    <a class="dropdown-item" href="logout.php" data-bs-toggle="modal" data-bs-target="#logoutModal">Sair</a>
                  <?php else: ?>
                    <a class="dropdown-item" href="login.php">Entrar</a>
                  <?php endif; ?>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>


  <div class="container mt-3">
    <?php
    // Verifica se existe alguma mensagem na URL para ser exibida
    $mensagemPopup = null;
    $classePopup = '';

    if (isset($_GET['msg'])) {
        $classePopup = 'alert-success'; // Cor verde para sucesso
        switch ($_GET['msg']) {
            case 'pedido_enviado':
                $mensagemPopup = 'Sua solicitação de edição foi enviada com sucesso e aguarda aprovação!';
                break;
            case 'solicitacao_exclusao_enviada':
                $mensagemPopup = 'Sua solicitação de exclusão foi enviada com sucesso e aguarda aprovação!';
                break;
            case 'Obra atualizada com sucesso':
                $mensagemPopup = 'A obra foi atualizada com sucesso!';
                break;
        }
    } elseif (isset($_GET['msgSucesso'])) {
        $classePopup = 'alert-success'; // Cor verde para sucesso
        $mensagemPopup = htmlspecialchars($_GET['msgSucesso']);
    } elseif (isset($_GET['msgErro'])) {
        $classePopup = 'alert-danger'; // Cor vermelha para erro
        $mensagemPopup = htmlspecialchars($_GET['msgErro']);
    }

    // Se uma mensagem foi definida, exibe o alerta
    if ($mensagemPopup):
    ?>
      <div class="alert <?= $classePopup ?> alert-dismissible fade show" role="alert">
        <?= $mensagemPopup ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php 
    endif; 
    ?>
  </div>

  <!-- Modal Nova Obra (somente admin) -->
  <?php if (isset($_SESSION['usuario'])): ?>
    <div class="modal fade" id="novaObraModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="inserir_obra.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Adicionar Nova Obra</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" required></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="id_status" class="form-select" required>
                  <?php
                  $sqlStatus = "SELECT * FROM tab_status";
                  $resStatus = mysqli_query($conn, $sqlStatus);
                  while ($st = mysqli_fetch_assoc($resStatus)) {
                    echo "<option value='{$st['id_status']}'>{$st['status']}</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Prazo</label>
                <input type="date" name="prazo" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Localização</label>
                <input type="text" name="localizacao" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Imagem</label>
                <input type="file" name="imagem" class="form-control" accept="image/*">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Adicionar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Conteudo Principal -->
  <main class="container">
    <!-- abas -->
    <ul class="nav nav-tabs" id="tabs">
      <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabPlanejada">Planejadas</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabAndamento">Em Andamento</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabConcluida">Concluídas</button></li>
    </ul>

    <div class="tab-content bg-white p-4 border rounded">
      <div class="tab-pane fade show active" id="tabPlanejada">
        <div class="row">
          <?php if (!empty($obras['planejada'])): foreach ($obras['planejada'] as $obra) echo renderObra($obra);
          endif; ?>
        </div>
      </div>
      <div class="tab-pane fade" id="tabAndamento">
        <div class="row">
          <?php if (!empty($obras['em andamento'])): foreach ($obras['em andamento'] as $obra) echo renderObra($obra);
          endif; ?>
        </div>
      </div>
      <div class="tab-pane fade" id="tabConcluida">
        <div class="row">
          <?php if (!empty($obras['concluida'])): foreach ($obras['concluida'] as $obra) echo renderObra($obra);
          endif; ?>
        </div>
      </div>
    </div>
  </main>

  <!-- modal logout -->
  <div class="modal fade" id="logoutModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Sair</h5>
          <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">Deseja realmente sair?</div>
        <div class="modal-footer justify-content-center">
          <a href="logout.php" class="btn btn-danger">Sair</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php $conn->close(); ?>