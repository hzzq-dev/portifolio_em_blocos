<?php
// admin/editar.php
require 'db.php';
require_once 'seguranca.php';
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: ./');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM cards WHERE id = ?");
$stmt->execute([$id]);
$card = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$card) {
    header('Location: ./');
    exit;
}

// Valores padrão caso as novas colunas ainda estejam vazias
$font_family = $card['font_family'] ?? 'Inter';
$font_size = $card['font_size'] ?? '1.8rem';
$font_weight = $card['font_weight'] ?? '900';
$font_style = $card['font_style'] ?? 'normal';
$text_color = $card['text_color'] ?? '#ffffff';
$icone = $card['icone'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Card | Painel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
<section class="section">
  <div class="container" style="max-width: 700px;">
    <div class="level">
        <div class="level-left">
            <h2 class="title">Editar Card #<?= $card['id'] ?></h2>
        </div>
        <div class="level-right">
            <a href="./" class="button is-light">Voltar</a>
        </div>
    </div>
    
    <form action="atualizar.php" method="POST" enctype="multipart/form-data">
      
      <input type="hidden" name="id" value="<?= $card['id'] ?>">
      
      <div class="field">
        <label class="label">Título</label>
        <div class="control">
          <input class="input" type="text" name="titulo" value="<?= htmlspecialchars($card['titulo']) ?>" required>
        </div>
      </div>

      <div class="field">
        <label class="label">Link URL</label>
        <div class="control">
          <input class="input" type="url" name="link" value="<?= htmlspecialchars($card['link']) ?>" required>
        </div>
      </div>

      <div class="columns">
        <div class="column">
          <div class="field">
            <label class="label">Tamanho no Grid</label>
            <div class="select is-fullwidth">
              <select name="tamanho">
                <option value="normal" <?= $card['tamanho'] == 'normal' ? 'selected' : '' ?>>Normal (1x1)</option>
                <option value="span-col-2" <?= $card['tamanho'] == 'span-col-2' ? 'selected' : '' ?>>Largo (2x1)</option>
                <option value="span-row-2" <?= $card['tamanho'] == 'span-row-2' ? 'selected' : '' ?>>Alto (1x2)</option>
                <option value="span-large" <?= $card['tamanho'] == 'span-large' ? 'selected' : '' ?>>Gigante (2x2)</option>
              </select>
            </div>
          </div>
        </div>
        
        <div class="column">
          <div class="field">
            <label class="label">Cores / Identidade</label>
            <div class="select is-fullwidth">
              <select name="gradiente">
                <option value="grad-pride" <?= $card['gradiente'] == 'grad-pride' ? 'selected' : '' ?>>Arco-íris (Pride)</option>
                <option value="grad-trans" <?= $card['gradiente'] == 'grad-trans' ? 'selected' : '' ?>>Trans</option>
                <option value="grad-bi" <?= $card['gradiente'] == 'grad-bi' ? 'selected' : '' ?>>Bi</option>
                <option value="grad-pan" <?= $card['gradiente'] == 'grad-pan' ? 'selected' : '' ?>>Pan</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- INÍCIO: NOVOS CAMPOS DE TEXTO E TIPOGRAFIA -->
      <div class="box mt-4 mb-4" style="background-color: #f9f9f9; border-radius: 12px;">
        <h3 class="subtitle is-5">Aparência do Texto e Ícone</h3>
        
        <div class="columns is-multiline">
          
          <div class="column is-half">
            <div class="field">
              <label class="label">Fonte (Google Fonts)</label>
              <div class="select is-fullwidth">
                <select name="font_family">
                  <option value="Inter" <?= $font_family == 'Inter' ? 'selected' : '' ?>>Inter (Moderna)</option>
                  <option value="Montserrat" <?= $font_family == 'Montserrat' ? 'selected' : '' ?>>Montserrat (Clássica)</option>
                  <option value="Poppins" <?= $font_family == 'Poppins' ? 'selected' : '' ?>>Poppins (Arredondada)</option>
                  <option value="Oswald" <?= $font_family == 'Oswald' ? 'selected' : '' ?>>Oswald (Condensada)</option>
                  <option value="Playfair Display" <?= $font_family == 'Playfair Display' ? 'selected' : '' ?>>Playfair (Elegante)</option>
                </select>
              </div>
            </div>
          </div>

          <div class="column is-half">
            <div class="field">
              <label class="label">Tamanho do Texto</label>
              <div class="select is-fullwidth">
                <select name="font_size">
                  <option value="1.2rem" <?= $font_size == '1.2rem' ? 'selected' : '' ?>>Pequeno</option>
                  <option value="1.8rem" <?= $font_size == '1.8rem' ? 'selected' : '' ?>>Normal</option>
                  <option value="2.5rem" <?= $font_size == '2.5rem' ? 'selected' : '' ?>>Grande</option>
                  <option value="3.5rem" <?= $font_size == '3.5rem' ? 'selected' : '' ?>>Gigante</option>
                </select>
              </div>
            </div>
          </div>

          <div class="column is-one-third">
            <div class="field">
              <label class="label">Peso</label>
              <div class="select is-fullwidth">
                <select name="font_weight">
                  <option value="400" <?= $font_weight == '400' ? 'selected' : '' ?>>Normal</option>
                  <option value="700" <?= $font_weight == '700' ? 'selected' : '' ?>>Negrito</option>
                  <option value="900" <?= $font_weight == '900' ? 'selected' : '' ?>>Black (Pesado)</option>
                </select>
              </div>
            </div>
          </div>

          <div class="column is-one-third">
            <div class="field">
              <label class="label">Estilo</label>
              <div class="select is-fullwidth">
                <select name="font_style">
                  <option value="normal" <?= $font_style == 'normal' ? 'selected' : '' ?>>Normal</option>
                  <option value="italic" <?= $font_style == 'italic' ? 'selected' : '' ?>>Itálico</option>
                </select>
              </div>
            </div>
          </div>

          <div class="column is-one-third">
            <div class="field">
              <label class="label">Cor do Texto</label>
              <div class="control">
                <input class="input" type="color" name="text_color" value="<?= htmlspecialchars($text_color) ?>" style="padding: 0; height: 40px;">
              </div>
            </div>
          </div>

          <div class="column is-full">
            <div class="field">
              <label class="label">Ícone (FontAwesome)</label>
              <div class="control">
                <input class="input" type="text" name="icone" placeholder="ex: fa-brands fa-instagram" value="<?= htmlspecialchars($icone) ?>">
              </div>
              <p class="help">Copie a classe no site <a href="https://fontawesome.com/search?o=r&m=free" target="_blank">FontAwesome</a> (ex: <code>fa-brands fa-youtube</code>).</p>
            </div>
          </div>

        </div>
      </div>
      <!-- FIM: NOVOS CAMPOS -->

      <div class="field mt-5">
        <label class="label">Imagem de Fundo (Deixe em branco para manter a atual)</label>
        
        <?php if (!empty($card['imagem_bg'])): ?>
            <div class="notification is-light mb-3">
                <p class="help mb-2">Imagem atual: <strong><?= htmlspecialchars($card['imagem_bg']) ?></strong></p>
                <label class="checkbox has-text-danger" style="font-weight: bold;">
                  <input type="checkbox" name="remover_imagem" value="1">
                  Remover imagem atual e voltar a usar o degradê colorido
                </label>
            </div>
        <?php endif; ?>

      <label class="label">Mídia de Fundo (Imagem ou Vídeo MP4/WebM)</label>
<div class="control">
    <input class="input" type="file" name="imagem_bg" accept="image/*,video/mp4,video/webm">
</div>

      <div class="control mt-6 mb-5">
        <button type="submit" class="button is-warning is-medium is-fullwidth">Atualizar Card</button>
      </div>
      
    </form>
  </div>
</section>
</body>
</html>