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
        body { background-color: var(--bg-color); color: var(--text-color); font-family: 'Inter', sans-serif; margin: 0; padding: 2rem; min-height: 100vh; display: flex; flex-direction: column; align-items: center; }
        
        /* HEADER (Mesmo da Home) */
        header { text-align: center; margin-bottom: 4rem; margin-top: 2rem; width: 100%; max-width: 1200px; }
        h1 { font-size: 3.5rem; font-weight: 900; letter-spacing: -2px; margin: 0; background: var(--grad-pride); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .subtitle { font-size: 1.1rem; color: #888; margin-top: 0.5rem; margin-bottom: 2rem; }
        nav a { color: #fff; text-decoration: none; font-weight: 700; font-size: 1.1rem; margin: 0 1rem; padding-bottom: 5px; border-bottom: 2px solid transparent; transition: border-color 0.3s ease, color 0.3s ease; }
        nav a:hover { color: #FFD800; border-bottom: 2px solid #FFD800; }

        /* LAYOUT SOBRE */
        .sobre-container {
            display: flex;
            gap: 4rem;
            max-width: 1000px;
            width: 100%;
            align-items: center;
        }

        .sobre-foto {
            flex: 1;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            position: relative;
        }

        /* Degradê sutil em cima da foto */
        .sobre-foto::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top right, rgba(255,0,24,0.2), rgba(0,0,249,0.2));
            pointer-events: none;
        }

        .sobre-foto img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .sobre-texto {
            flex: 1.5;
            font-size: 1.2rem;
            line-height: 1.8;
            color: #d1d1d1;
        }

        .sobre-texto h2 {
            font-size: 2.5rem;
            color: #fff;
            margin-top: 0;
            margin-bottom: 1.5rem;
            font-weight: 900;
            letter-spacing: -1px;
        }

        .highlight {
            color: #fff;
            font-weight: bold;
            background: var(--grad-pride);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @media (max-width: 768px) {
            .sobre-container { flex-direction: column; gap: 2rem; }
            h1 { font-size: 2.5rem; }
            .sobre-foto { width: 100%; max-width: 400px; margin: 0 auto; }
        }
    </style>
</head>
<body>

    <header>
        <a href="index.php" style="text-decoration: none;"><h1>@gusvisentini</h1></a>
        <p class="subtitle">Mídia, Código e Ideias.</p>
        <nav>
            <a href="/">Início</a>
            <a href="sobre" style="border-bottom: 2px solid #FFD800; color: #FFD800;">Sobre</a>
            <a href="contato">Contato</a>
        </nav>
    </header>

    <main class="sobre-container">
        <div class="sobre-foto">
            <!-- Coloque sua foto na mesma pasta ou crie uma pasta imagens/ -->
            <img src="foto-perfil.jpg" alt="Foto de Gustavo Visentini">
        </div>
        
        <div class="sobre-texto">
            <h2>Prazer,<span class="highlight"> ;)</span>.</h2>
            <p>Publicitário de formação, estudante de História e aspirante a escritor. Simpático, querido e, às vezes, um pouco delirante? <i>Maybe</i>.
            <p>Em breve, mais sobre mim por aqui ;)</p>
        </div>
    </main>

</body>
</html>