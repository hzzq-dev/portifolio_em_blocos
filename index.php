<?php
// index.php (RAIZ DO SITE)
require_once __DIR__ . '/admin/db.php';

// Descobre qual página o usuário quer acessar (se não tiver nada, é a 'home')
$pagina_atual = $_GET['p'] ?? 'home';

try {
    // ==========================================
    // ⚙️ CONFIGURAÇÕES VISUAIS DO MENU (Via Banco)
    // ==========================================
    $stmtConfig = $pdo->query("SELECT chave, valor FROM configuracoes");
    $configs = $stmtConfig->fetchAll(PDO::FETCH_KEY_PAIR);
    $menu_fixo = ($configs['menu_fixo'] ?? '1') === '1';
    $estilo_menu_bloco = ($configs['estilo_menu_bloco'] ?? '1') === '1';

    // 1. Busca os itens do menu dinâmico
    $stmtMenu = $pdo->query("SELECT * FROM paginas ORDER BY ordem ASC, id ASC");
    $menu_paginas = $stmtMenu->fetchAll(PDO::FETCH_ASSOC);

    // 2. Busca os cards APENAS da página selecionada
    $stmtCards = $pdo->prepare("SELECT * FROM cards WHERE pagina_slug = ? ORDER BY ordem ASC, id DESC");
    $stmtCards->execute([$pagina_atual]);
    $cards = $stmtCards->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    $cards = [];
    $menu_paginas = [];
    $menu_fixo = false;
    $estilo_menu_bloco = false;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@gusvisentini | Portfólio</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Montserrat:ital,wght@0,400;0,700;0,900;1,400&family=Oswald:wght@400;700&family=Playfair+Display:ital,wght@0,700;1,700&family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-color: #0f0f11;
            --text-color: #ffffff;
            --grad-pride: linear-gradient(135deg, #FF0018, #FFA52C, #FFFF41, #008018, #0000F9, #86007D);
            --grad-trans: linear-gradient(135deg, #5BCEFA, #F5A9B8, #FFFFFF, #F5A9B8, #5BCEFA);
            --grad-bi: linear-gradient(135deg, #D60270, #9B4F96, #0038A8);
            --grad-pan: linear-gradient(135deg, #FF218C, #FFD800, #21B1FF);
        }

        * { box-sizing: border-box; }
        
        body { background-color: var(--bg-color); color: var(--text-color); font-family: 'Inter', sans-serif; margin: 0; padding: 0 1rem 2rem 1rem; min-height: 100vh; display: flex; flex-direction: column; align-items: center; }
        
        /* ==========================================
           ESTILOS DO CABEÇALHO E MENU
           ========================================== */
        header { 
            text-align: center; margin-bottom: 2rem; width: 100%; max-width: 1200px; 
            padding-top: 2rem; padding-bottom: 1rem;
            transition: all 0.3s ease;
        }

        header.is-fixed {
            position: sticky; top: 0; z-index: 100;
            background-color: rgba(15, 15, 17, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding-top: 1rem;
        }

        h1 { font-size: 3rem; font-weight: 900; letter-spacing: -2px; margin: 0; background: var(--grad-pride); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .subtitle { font-size: 1rem; color: #888; margin-top: 0.2rem; margin-bottom: 1.5rem; }
        
        nav { display: flex; flex-wrap: wrap; justify-content: center; gap: 0.8rem; }
        nav a { color: #fff; text-decoration: none; font-weight: 700; font-size: 0.95rem; transition: all 0.3s ease; }
        
        /* ESTILO 1: BLOCOS ARREDONDADOS */
        .menu-blocos a {
            background-color: rgba(255, 255, 255, 0.08);
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .menu-blocos a:hover { background-color: rgba(255, 255, 255, 0.15); transform: translateY(-2px); }
        .menu-blocos a.active { background-color: #FFD800; color: #000; border-color: #FFD800; }

        /* ESTILO 2: TEXTO SIMPLES */
        .menu-simples a { margin: 0 0.5rem; padding-bottom: 5px; border-bottom: 2px solid transparent; }
        .menu-simples a:hover { color: #FFD800; border-bottom: 2px solid #FFD800; }
        .menu-simples a.active { color: #FFD800; border-bottom: 2px solid #FFD800; }

        /* ==========================================
           GRID DE CARDS (O seu layout original)
           ========================================== */
        .portfolio-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); grid-auto-rows: 220px; gap: 1rem; width: 100%; max-width: 1200px; grid-auto-flow: dense; }
        
        .card {
            border-radius: 24px; text-decoration: none; display: flex; align-items: flex-end; padding: 1.5rem;
            transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.3s ease;
            position: relative; overflow: hidden; background-size: cover; background-position: center; background-repeat: no-repeat;
        }
        
        .card:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5); z-index: 10; }
        
        .card.has-media::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.1) 70%); z-index: 1; }
        
        .card span {
            position: relative; z-index: 2; text-shadow: 0 2px 10px rgba(0,0,0,0.3);
            display: flex; align-items: center; gap: 0.5rem; line-height: 1.1;
        }

        .card span i { font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important; font-weight: 900; }

        .video-bg {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0; 
        }

        .normal { grid-column: span 1; grid-row: span 1; }
        .span-col-2 { grid-column: span 2; grid-row: span 1; }
        .span-row-2 { grid-column: span 1; grid-row: span 2; }
        .span-large { grid-column: span 2; grid-row: span 2; }

        @media (max-width: 768px) {
            header { padding-top: 1.5rem; margin-bottom: 1rem; }
            h1 { font-size: 2.2rem; }
            
            /* Grid mobile com 2 colunas e preenchimento automático (dense) */
            .portfolio-grid { 
                grid-template-columns: repeat(2, 1fr); 
                grid-auto-rows: 150px; 
                gap: 0.8rem;
            }
            
            /* 1x1 (Normal) e 2x2 (Gigante): Ficam quadrados (1 coluna), um do lado do outro */
            .card.normal, .card.span-large { 
                grid-column: span 1 !important; 
                grid-row: span 1 !important; 
            }

            /* 1x2 (Alto): Fica um do lado do outro (1 coluna), mas esticado para baixo (2 linhas) */
            .card.span-row-2 {
                grid-column: span 1 !important;
                grid-row: span 2 !important;
            }

            /* 2x1 (Largo): Ocupa as 2 colunas da tela mobile, forçando ficar um abaixo do outro */
            .card.span-col-2 {
                grid-column: span 2 !important;
                grid-row: span 1 !important;
            }
            
            .card {
                padding: 1rem; 
                border-radius: 18px; 
            }
            
            /* Mantendo quebra de texto para não vazar do bloco */
            .card span { 
                word-break: break-word; 
                white-space: normal;
            }
        }
    </style>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3592098846517685"
     crossorigin="anonymous"></script>
</head>
<body>

    <!-- A classe is-fixed é adicionada dinamicamente via banco de dados -->
    <header class="<?= $menu_fixo ? 'is-fixed' : '' ?>">
        <a href="?p=home" style="text-decoration: none;"><h1>@gusvisentini</h1></a>
        <p class="subtitle">Mídia, Código e Ideias.</p>
        
        <!-- A classe menu-blocos ou menu-simples é adicionada dinamicamente -->
        <nav class="<?= $estilo_menu_bloco ? 'menu-blocos' : 'menu-simples' ?>">
            <!-- 1. Puxa as páginas dinâmicas (Cards) do banco de dados -->
            <?php foreach($menu_paginas as $item): ?>
                <a href="?p=<?= htmlspecialchars($item['slug']) ?>" 
                   class="<?= $item['slug'] === $pagina_atual ? 'active' : '' ?>">
                    <?= htmlspecialchars($item['titulo']) ?>
                </a>
            <?php endforeach; ?>
            
            <!-- 2. Mantém as suas páginas físicas fixas no menu -->
            <a href="sobre" class="<?= $pagina_atual === 'sobre' ? 'active' : '' ?>">Sobre</a>
            <a href="contato" class="<?= $pagina_atual === 'contato' ? 'active' : '' ?>">Contato</a>
        </nav>
    </header>

    <main class="portfolio-grid">
        
        <?php if (empty($cards)): ?>
            <p style="text-align: center; width: 100%; grid-column: 1 / -1; color: #666;">
                Nenhum card cadastrado ainda nesta página. Acesse o <a href="admin/" style="color: #FFD800;">Painel</a> para começar.
            </p>
        <?php else: ?>
            
            <?php foreach ($cards as $card): 
                $arquivo_bg = $card['imagem_bg'];
                $tem_midia = !empty($arquivo_bg);
                
                $extensao = $tem_midia ? strtolower(pathinfo($arquivo_bg, PATHINFO_EXTENSION)) : '';
                $eh_video = in_array($extensao, ['mp4', 'webm']);
                
                $classe_media = $tem_midia ? 'has-media' : '';
                
                $estilo_bg = "";
                if ($tem_midia && !$eh_video) {
                    $estilo_bg = "background-image: url('uploads/" . htmlspecialchars($arquivo_bg) . "');";
                } elseif (!$tem_midia) {
                    $estilo_bg = "background: var(--" . htmlspecialchars($card['gradiente']) . ");";
                }

                $estilo_texto = sprintf(
                    "font-family: '%s', sans-serif; font-size: %s; font-weight: %s; font-style: %s; color: %s;",
                    htmlspecialchars($card['font_family'] ?? 'Inter'),
                    htmlspecialchars($card['font_size'] ?? '1.8rem'),
                    htmlspecialchars($card['font_weight'] ?? '900'),
                    htmlspecialchars($card['font_style'] ?? 'normal'),
                    htmlspecialchars($card['text_color'] ?? '#ffffff')
                );

                // ========================================================
                // LÓGICA DA ABA: Define se abre em nova aba ou na mesma
                // ========================================================
                $dominio_atual = $_SERVER['HTTP_HOST'];
                $target = "_blank"; // Padrão: abrir em nova aba
                
                // Se o link NÃO contiver 'http' (link interno) OU se tiver o seu domínio
                if (strpos($card['link'], 'http') === false || strpos($card['link'], $dominio_atual) !== false) {
                    $target = "_self"; // Abre na mesma aba
                }
            ?>
            
            <a href="<?= htmlspecialchars($card['link']) ?>" target="<?= $target ?>" class="card <?= htmlspecialchars($card['tamanho']) ?> <?= $classe_media ?>" style="<?= $estilo_bg ?>">
                
                <?php if ($eh_video): ?>
                    <video autoplay loop muted playsinline class="video-bg">
                        <source src="uploads/<?= htmlspecialchars($arquivo_bg) ?>" type="video/<?= $extensao ?>">
                    </video>
                <?php endif; ?>

                <span style="<?= $estilo_texto ?>">
                    <?php if (!empty($card['icone'])): ?>
                        <i class="<?= htmlspecialchars($card['icone']) ?>"></i>
                    <?php endif; ?>
                    <?= htmlspecialchars($card['titulo']) ?>
                </span>
            </a>

            <?php endforeach; ?>

        <?php endif; ?>

    </main>

</body>
</html>