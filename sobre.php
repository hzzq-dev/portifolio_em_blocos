<?php
require_once __DIR__ . '/admin/db.php';

try {
    $stmtConfig = $pdo->query("SELECT chave, valor FROM configuracoes");
    $configs = $stmtConfig->fetchAll(PDO::FETCH_KEY_PAIR);
    $menu_fixo = ($configs['menu_fixo'] ?? '1') === '1';
    $estilo_menu_bloco = ($configs['estilo_menu_bloco'] ?? '1') === '1';

    $stmtMenu = $pdo->query("SELECT * FROM paginas ORDER BY ordem ASC, id ASC");
    $menu_paginas = $stmtMenu->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $menu_paginas = [];
    $menu_fixo = false;
    $estilo_menu_bloco = false;
}

$pagina_atual = 'sobre';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre | @gusvisentini</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-color: #0f0f11;
            --text-color: #ffffff;
            --grad-pride: linear-gradient(135deg, #FF0018, #FFA52C, #FFFF41, #008018, #0000F9, #86007D);
        }

        * { box-sizing: border-box; }
        
        body { background-color: var(--bg-color); color: var(--text-color); font-family: 'Inter', sans-serif; margin: 0; padding: 1.5rem 1rem; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        
        /* CABEÇALHO E MENU CONFIGURÁVEIS */
        header { text-align: center; margin-bottom: 1.5rem; margin-top: 0; width: 100%; max-width: 1200px; padding-top: 1rem; padding-bottom: 1rem; transition: all 0.3s ease; }
        header.is-fixed { position: sticky; top: 0; z-index: 100; background-color: rgba(15, 15, 17, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.05); }
        h1 { font-size: 3rem; font-weight: 900; letter-spacing: -2px; margin: 0; background: var(--grad-pride); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .subtitle { font-size: 1rem; color: #888; margin-top: 0.2rem; margin-bottom: 1rem; }
        
        nav { display: flex; flex-wrap: wrap; justify-content: center; gap: 0.8rem; }
        nav a { color: #fff; text-decoration: none; font-weight: 700; font-size: 0.95rem; transition: all 0.3s ease; }
        
        .menu-blocos a { background-color: rgba(255, 255, 255, 0.08); padding: 0.6rem 1.2rem; border-radius: 50px; border: 1px solid rgba(255, 255, 255, 0.1); }
        .menu-blocos a:hover { background-color: rgba(255, 255, 255, 0.15); transform: translateY(-2px); }
        .menu-blocos a.active { background-color: #FFD800; color: #000; border-color: #FFD800; }
        
        .menu-simples a { margin: 0 0.5rem; padding-bottom: 5px; border-bottom: 2px solid transparent; }
        .menu-simples a:hover, .menu-simples a.active { color: #FFD800; border-bottom: 2px solid #FFD800; }

        .sobre-container { display: flex; gap: 2.5rem; max-width: 1000px; width: 100%; align-items: center; }
        .sobre-foto { flex: 1; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.5); position: relative; }
        .sobre-foto::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to top right, rgba(255,0,24,0.2), rgba(0,0,249,0.2)); pointer-events: none; }
        .sobre-foto img { width: 100%; height: auto; display: block; object-fit: cover; }
        .sobre-texto { flex: 1.5; font-size: 1.15rem; line-height: 1.7; color: #d1d1d1; }
        .sobre-texto h2 { font-size: 2.5rem; color: #fff; margin-top: 0; margin-bottom: 1.2rem; font-weight: 900; letter-spacing: -1px; }
        .highlight { color: #fff; font-weight: bold; background: var(--grad-pride); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        @media (max-width: 768px) {
            header { padding-top: 1rem; margin-bottom: 1rem; }
            .sobre-container { flex-direction: column; gap: 1.5rem; text-align: center; }
            h1 { font-size: 2.2rem; }
            .sobre-foto { width: 100%; max-width: 400px; margin: 0 auto; }
            .sobre-texto h2 { font-size: 2rem; }
        }
    </style>
</head>
<body>

    <header class="<?= $menu_fixo ? 'is-fixed' : '' ?>">
        <a href="/" style="text-decoration: none;"><h1>@gusvisentini</h1></a>
        <p class="subtitle">Mídia, Código e Ideias.</p>
        <nav class="<?= $estilo_menu_bloco ? 'menu-blocos' : 'menu-simples' ?>">
            <a href="/">Início</a>
            <?php foreach($menu_paginas as $item): ?>
                <a href="/?p=<?= htmlspecialchars($item['slug']) ?>">
                    <?= htmlspecialchars($item['titulo']) ?>
                </a>
            <?php endforeach; ?>
            <a href="sobre" class="<?= $pagina_atual === 'sobre' ? 'active' : '' ?>">Sobre</a>
            <a href="contato" class="<?= $pagina_atual === 'contato' ? 'active' : '' ?>">Contato</a>
        </nav>
    </header>

    <main class="sobre-container">
        <div class="sobre-foto">
            <img src="foto-perfil.png" alt="Foto de Gustavo Visentini">
        </div>
        
        <div class="sobre-texto">
            <h2>Prazer,<span class="highlight"> ;)</span>.</h2>
            <p>Publicitário de formação, estudante de História e aspirante a escritor. Simpático, querido e, às vezes, um pouco delirante? <i>Maybe</i>.
            <p>Em breve, mais sobre mim por aqui ;)</p>
        </div>
    </main>

</body>
</html>