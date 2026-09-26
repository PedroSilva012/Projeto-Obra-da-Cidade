<?php
// segurança mínima: garante que $obra está definido
if (!isset($obra) || !is_array($obra)) return;

// campos
$id = intval($obra['id'] ?? 0);
$nome = htmlspecialchars($obra['nome'] ?? '');
$descricao = htmlspecialchars($obra['descricao'] ?? '');
$prazo = htmlspecialchars($obra['prazo'] ?? '');
$localizacao = htmlspecialchars($obra['localizacao'] ?? '');
$status = htmlspecialchars($obra['status'] ?? 'Não definido');
$imagem = $obra['imagem'] ?? null;
$imgTag = '';
if ($imagem) {
    $path = 'uploads/' . $imagem;
    if (file_exists(__DIR__ . '/' . $path)) {
        $imgTag = "<img src=\"{$path}\" alt=\"{$nome}\">";
    } else {
        // placeholder simples
        $imgTag = "<div style=\"height:160px;background:#eee;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#999\">Sem imagem</div>";
    }
} else {
    $imgTag = "<div style=\"height:160px;background:#eee;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#999\">Sem imagem</div>";
}
?>
<div class="card">
  <?=$imgTag?>
  <h3 style="margin:8px 0 4px;"><?= $nome ?></h3>
  <p style="margin:0 0 8px;"><?= (strlen($descricao) > 140) ? substr($descricao,0,140).'...' : $descricao ?></p>
  <p style="margin:0 0 8px;font-size:13px"><strong>Local:</strong> <?= $localizacao ?></p>
  <p style="margin:0 0 8px;font-size:13px"><strong>Prazo:</strong> <?= $prazo ?></p>
  <div style="margin-top:8px">
    <span class="badge" style="background:#f0f0f0"><?= $status ?></span>
    <a href="editar_obra_form.php?id=<?=$id?>" style="margin-left:8px">Editar</a>
    <a href="detalhes_obra.php?id=<?=$id?>" style="margin-left:8px">Ver</a>
  </div>
</div>
