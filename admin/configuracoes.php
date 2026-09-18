<?php
// admin/configuracoes.php
require 'db.php';

$mensagem = '';

// Se enviou o formulário, atualiza no banco
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se o checkbox não for marcado, o POST não envia a variável, então usamos '0'
    $menu_fixo = isset($_POST['menu_fixo']) ? '1' : '0';
    $estilo_menu_bloco = isset($_POST['estilo_menu_bloco']) ? '1' : '0';

    $stmt = $pdo->prepare("UPDATE configuracoes SET valor = ? WHERE chave = ?");
    $stmt->execute([$menu_fixo, 'menu_fixo']);
    $stmt->execute([$estilo_menu_bloco, 'estilo_menu_bloco']);
    
    $mensagem = "Configurações salvas com sucesso!";
}

// Busca os valores atuais
$stmt = $pdo->query("SELECT chave, valor FROM configuracoes");
$configs = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$is_menu_fixo = ($configs['menu_fixo'] ?? '1') === '1';
$is_estilo_bloco = ($configs['estilo_menu_bloco'] ?? '1') === '1';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações Visuais | Painel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
<section class="section">
  <div class="container" style="max-width: 600px;">
    <div class="level">
        <div class="level-left">
            <h2 class="title">Configurações Visuais</h2>
        </div>
        <div class="level-right">
            <a href="index.php" class="button is-light">Voltar</a>
        </div>
    </div>
    
    <?php if ($mensagem): ?>
        <div class="notification is-success is-light">
            <?= $mensagem ?>
        </div>
    <?php endif; ?>

    <form action="configuracoes.php" method="POST" class="box">
        
        <h3 class="subtitle is-5 mb-4">Comportamento do Menu</h3>
        
        <div class="field">
            <label class="checkbox" style="font-weight: bold; font-size: 1.1rem;">
                <input type="checkbox" name="menu_fixo" value="1" <?= $is_menu_fixo ? 'checked' : '' ?>>
                Fixar Menu no Topo
            </label>
            <p class="help mb-4">O cabeçalho e o menu vão acompanhar o usuário ao rolar a página com um efeito de vidro.</p>
        </div>

        <div class="field">
            <label class="checkbox" style="font-weight: bold; font-size: 1.1rem;">
                <input type="checkbox" name="estilo_menu_bloco" value="1" <?= $is_estilo_bloco ? 'checked' : '' ?>>
                Estilo de Botões Arredondados
            </label>
            <p class="help mb-4">Desmarque para voltar ao estilo antigo com texto simples e barra inferior.</p>
        </div>

        <div class="control mt-5">
            <button type="submit" class="button is-link is-fullwidth">Salvar Configurações</button>
        </div>

    </form>
  </div>
</section>
</body>
</html>