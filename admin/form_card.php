<?php
// admin/form_card.php
require_once 'seguranca.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Card | Painel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
<section class="section">
  <div class="container" style="max-width: 700px;">
    <div class="level">
        <div class="level-left">
            <h2 class="title">Adicionar Novo Card</h2>
        </div>
        <div class="level-right">
            <a href="index.php" class="button is-light">Voltar</a>
        </div>
    </div>
    
    <form action="processa.php" method="POST" enctype="multipart/form-data">
      
      <div class="field">
        <label class="label">Título</label>
        <div class="control">
          <input class="input" type="text" name="titulo" required>
        </div>
      </div>

      <div class="field">
        <label class="label">Link URL</label>
        <div class="control">
          <input class="input" type="url" name="link" required>
        </div>
      </div>

      <div class="columns">
        <div class="column">
          <div class="field">
            <label class="label">Tamanho no Grid</label>
            <div class="select is-fullwidth">
              <select name="tamanho">
                <option value="normal">Normal (1x1)</option>
                <option value="span-col-2">Largo (2x1)</option>
                <option value="span-row-2">Alto (1x2)</option>
                <option value="span-large">Gigante (2x2)</option>
              </select>
            </div>
          </div>
        </div>
        
        <div class="column">
          <div class="field">
            <label class="label">Cores / Identidade</label>
            <div class="select is-fullwidth">
              <select name="gradiente">
                <option value="grad-pride">Arco-íris (Pride)</option>
                <option value="grad-trans">Trans</option>
                <option value="grad-bi">Bi</option>
                <option value="grad-pan">Pan</option>
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
                  <option value="Inter">Inter (Moderna)</option>
                  <option value="Montserrat">Montserrat (Clássica)</option>
                  <option value="Poppins">Poppins (Arredondada)</option>
                  <option value="Oswald">Oswald (Condensada)</option>
                  <option value="Playfair Display">Playfair (Elegante)</option>
                </select>
              </div>
            </div>
          </div>

          <div class="column is-half">
            <div class="field">
              <label class="label">Tamanho do Texto</label>
              <div class="select is-fullwidth">
                <select name="font_size">
                  <option value="1.2rem">Pequeno</option>
                  <option value="1.8rem" selected>Normal</option>
                  <option value="2.5rem">Grande</option>
                  <option value="3.5rem">Gigante</option>
                </select>
              </div>
            </div>
          </div>

          <div class="column is-one-third">
            <div class="field">
              <label class="label">Peso</label>
              <div class="select is-fullwidth">
                <select name="font_weight">
                  <option value="400">Normal</option>
                  <option value="700">Negrito</option>
                  <option value="900" selected>Black (Pesado)</option>
                </select>
              </div>
            </div>
          </div>

          <div class="column is-one-third">
            <div class="field">
              <label class="label">Estilo</label>
              <div class="select is-fullwidth">
                <select name="font_style">
                  <option value="normal">Normal</option>
                  <option value="italic">Itálico</option>
                </select>
              </div>
            </div>
          </div>

          <div class="column is-one-third">
            <div class="field">
              <label class="label">Cor do Texto</label>
              <div class="control">
                <input class="input" type="color" name="text_color" value="#ffffff" style="padding: 0; height: 40px;">
              </div>
            </div>
          </div>

          <div class="column is-full">
            <div class="field">
              <label class="label">Ícone (FontAwesome)</label>
              <div class="control">
                <input class="input" type="text" name="icone" placeholder="ex: fa-brands fa-instagram">
              </div>
              <p class="help">Copie a classe no site <a href="https://fontawesome.com/search?o=r&m=free" target="_blank">FontAwesome</a>.</p>
            </div>
          </div>

        </div>
      </div>
      <!-- FIM: NOVOS CAMPOS -->

      <div class="field mt-5">
        <label class="label">Mídia de Fundo (Imagem ou Vídeo MP4/WebM)</label>
<div class="control">
    <input class="input" type="file" name="imagem_bg" accept="image/*,video/mp4,video/webm">
</div>

      <div class="control mt-6 mb-5">
        <button type="submit" class="button is-link is-medium is-fullwidth">Salvar Novo Card</button>
      </div>
      
    </form>
  </div>
</section>
</body>
</html>