<?php
// index.php (RAIZ DO SITE)
require_once __DIR__ . '/admin/db.php';

try {
    $stmt = $pdo->query("SELECT * FROM cards ORDER BY ordem ASC, id DESC");
    $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $cards = [];
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
        body { background-color: var(--bg-color); color: var(--text-color); font-family: 'Inter', sans-serif; margin: 0; padding: 2rem; min-height: 100vh; display: flex; flex-direction: column; align-items: center; }
        header { text-align: center; margin-bottom: 4rem; margin-top: 2rem; width: 100%; max-width: 1200px; }
        h1 { font-size: 3.5rem; font-weight: 900; letter-spacing: -2px; margin: 0; background: var(--grad-pride); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .subtitle { font-size: 1.1rem; color: #888; margin-top: 0.5rem; margin-bottom: 2rem; }
        nav a { color: #fff; text-decoration: none; font-weight: 700; font-size: 1.1rem; margin: 0 1rem; padding-bottom: 5px; border-bottom: 2px solid transparent; transition: border-color 0.3s ease, color 0.3s ease; }
        nav a:hover { color: #FFD800; border-bottom: 2px solid #FFD800; }
        .portfolio-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); grid-auto-rows: 250px; gap: 1.5rem; width: 100%; max-width: 1200px; }
        
        .card {
            border-radius: 24px; text-decoration: none; display: flex; align-items: flex-end; padding: 1.5rem;
            transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.3s ease;
            position: relative; overflow: hidden; background-size: cover; background-position: center; background-repeat: no-repeat;
        }
        
        .card:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5); z-index: 10; }
        
        /* O overlay escuro serve tanto para imagens quanto para vídeos */
        .card.has-media::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.1) 70%); z-index: 1; }
        
        .card span {
            position: relative; z-index: 2; text-shadow: 0 2px 10px rgba(0,0,0,0.3);
            display: flex; align-items: center; gap: 0.5rem; line-height: 1.1;
        }

        .card span i { font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important; font-weight: 900; }

        /* Estilo do Vídeo de Fundo */
        .video-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0; /* Fica atrás do overlay e do texto */
        }

        .normal { grid-column: span 1; grid-row: span 1; }
        .span-col-2 { grid-column: span 2; grid-row: span 1; }
        .span-row-2 { grid-column: span 1; grid-row: span 2; }
        .span-large { grid-column: span 2; grid-row: span 2; }

        @media (max-width: 768px) {
            .portfolio-grid { grid-template-columns: 1fr; grid-auto-rows: 200px; }
            .span-col-2, .span-row-2, .span-large { grid-column: span 1; grid-row: span 1; }
            h1 { font-size: 2.5rem; }
        }
        
        /* CONSERTO DA RESPONSIVIDADE MOBILE */
        @media (max-width: 768px) {
            body { 
                padding: 1.5rem 1rem; /* Reduz margens nas laterais */
            }
            header { 
                margin-bottom: 2rem; 
            }
            h1 { 
                font-size: 2.2rem; /* Impede o título de quebrar a linha mal feito */
            }
            nav a {
                margin: 0 0.5rem;
                font-size: 1rem;
            }
            
            /* Ajustes do Bento Grid (Apenas para index.php) */
            .portfolio-grid { 
                grid-template-columns: 1fr; /* Força tudo a ficar em 1 coluna */
                grid-auto-rows: 180px; /* Reduz a altura dos cards no celular */
                gap: 1rem; 
            }
            
            /* O !important quebra as regras do painel para o celular não bugar */
            .card.span-col-2, .card.span-row-2, .card.span-large { 
                grid-column: span 1 !important; 
                grid-row: span 1 !important; 
            }
            
            /* Diminui fontes gigantes no celular e faz quebrar a palavra se for muito longa */
            .card span { 
                font-size: 1.5rem !important; 
                word-break: break-word; 
                white-space: normal;
            }

            /* Ajustes do Sobre e Contato (Para sobre.php e contato.php) */
            .sobre-container { 
                flex-direction: column; 
                gap: 2rem; 
                text-align: center;
            }
            .sobre-foto { 
                max-width: 100%; 
            }
            .sobre-texto h2 {
                font-size: 1.8rem;
            }
            .contato-container { 
                padding: 2rem 1.5rem; 
            }
            .social-buttons { 
                flex-direction: column; 
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>@gusvisentini</h1>
        <p class="subtitle">Mídia, Ideias, Papiros e IA.</p>
        <nav>
            <a href="sobre">Sobre</a>
            <a href="contato">Contato</a>
        </nav>
    </header>

    <main class="portfolio-grid">
        
        <?php if (empty($cards)): ?>
            <p style="text-align: center; width: 100%; grid-column: 1 / -1; color: #666;">
                Nenhum card cadastrado ainda. Acesse o <a href="admin/" style="color: #FFD800;">Painel</a> para começar.
            </p>
        <?php else: ?>
            
            <?php foreach ($cards as $card): 
                $arquivo_bg = $card['imagem_bg'];
                $tem_midia = !empty($arquivo_bg);
                
                // Descobre se é vídeo ou imagem pela extensão
                $extensao = $tem_midia ? strtolower(pathinfo($arquivo_bg, PATHINFO_EXTENSION)) : '';
                $eh_video = in_array($extensao, ['mp4', 'webm']);
                
                // Muda a classe para garantir o overlay
                $classe_media = $tem_midia ? 'has-media' : '';
                
                $estilo_bg = "";
                if ($tem_midia && !$eh_video) {
                    // É uma imagem ou GIF
                    $estilo_bg = "background-image: url('uploads/" . htmlspecialchars($arquivo_bg) . "');";
                } elseif (!$tem_midia) {
                    // Sem mídia, usa o degradê
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
            ?>
            
            <a href="<?= htmlspecialchars($card['link']) ?>" target="_blank" class="card <?= htmlspecialchars($card['tamanho']) ?> <?= $classe_media ?>" style="<?= $estilo_bg ?>">
                
                <?php if ($eh_video): ?>
                    <!-- Player de Vídeo em Loop -->
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