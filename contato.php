<?php
// Inclui os arquivos essenciais do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// Chama o cofre de senhas (mesma pasta)
require_once 'config.php';

$mensagem_feedback = '';
$tipo_feedback = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = htmlspecialchars($_POST['nome'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $mensagem_texto = htmlspecialchars($_POST['mensagem'] ?? '');

    if (!empty($nome) && !empty($email) && !empty($mensagem_texto)) {
        
        $mail = new PHPMailer(true);

        try {
            // Configurações do Servidor da Hostinger
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            // Usa a constante do e-mail
            $mail->Username   = MAIL_USER;
            // Usa a constante da senha
            $mail->Password   = MAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->CharSet    = 'UTF-8';

            // Usa as constantes para remetente e destino
            $mail->setFrom(MAIL_USER, 'Site Portfólio');
            $mail->addAddress(MAIL_DESTINO, 'Gustavo');     
            
            // Quando você clicar em "Responder", vai direto para o e-mail do visitante
            $mail->addReplyTo($email, $nome);

            // Conteúdo do E-mail
            $mail->isHTML(false);
            $mail->Subject = 'Novo contato no Portfólio - ' . $nome;
            $mail->Body    = "Você recebeu uma nova mensagem do seu Portfólio.\n\n" .
                             "Nome: $nome\n" .
                             "E-mail: $email\n\n" .
                             "Mensagem:\n$mensagem_texto\n";

            // Envia o e-mail
            $mail->send();
            
            $mensagem_feedback = "Sua mensagem foi enviada com sucesso! Te respondo em breve.";
            $tipo_feedback = 'sucesso';

        } catch (Exception $e) {
            $mensagem_feedback = "Ops! Erro ao enviar: {$mail->ErrorInfo}";
            $tipo_feedback = 'erro';
        }
    } else {
        $mensagem_feedback = "Por favor, preencha todos os campos do formulário.";
        $tipo_feedback = 'erro';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato | @gusvisentini</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    
    <!-- Ícones do FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-color: #0f0f11;
            --text-color: #ffffff;
            --grad-pride: linear-gradient(135deg, #FF0018, #FFA52C, #FFFF41, #008018, #0000F9, #86007D);
        }

        * { box-sizing: border-box; }
        body { background-color: var(--bg-color); color: var(--text-color); font-family: 'Inter', sans-serif; margin: 0; padding: 2rem; min-height: 100vh; display: flex; flex-direction: column; align-items: center; }
        
        header { text-align: center; margin-bottom: 4rem; margin-top: 2rem; width: 100%; max-width: 1200px; }
        h1 { font-size: 3.5rem; font-weight: 900; letter-spacing: -2px; margin: 0; background: var(--grad-pride); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .subtitle { font-size: 1.1rem; color: #888; margin-top: 0.5rem; margin-bottom: 2rem; }
        nav a { color: #fff; text-decoration: none; font-weight: 700; font-size: 1.1rem; margin: 0 1rem; padding-bottom: 5px; border-bottom: 2px solid transparent; transition: border-color 0.3s ease, color 0.3s ease; }
        nav a:hover { color: #FFD800; border-bottom: 2px solid #FFD800; }

        .contato-container {
            max-width: 600px; width: 100%; background-color: #1a1a1d; padding: 3rem;
            border-radius: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.05);
        }

        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 700; color: #bbb; }
        
        input, textarea {
            width: 100%; background-color: #0f0f11; border: 2px solid #333; color: #fff;
            padding: 1rem; border-radius: 12px; font-family: 'Inter', sans-serif; font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus { outline: none; border-color: #0000F9; box-shadow: 0 0 15px rgba(0,0,249, 0.3); }
        textarea { resize: vertical; min-height: 150px; }

        button {
            width: 100%; padding: 1rem; border: none; border-radius: 12px;
            background: var(--grad-pride); color: white; font-size: 1.2rem; font-weight: 900;
            cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(255,0,24,0.4); }

        .feedback { padding: 1rem; border-radius: 12px; margin-bottom: 2rem; font-weight: 700; text-align: center; }
        .feedback.sucesso { background-color: rgba(0, 128, 24, 0.2); border: 1px solid #008018; color: #4ade80; }
        .feedback.erro { background-color: rgba(255, 0, 24, 0.2); border: 1px solid #FF0018; color: #f87171; }

        /* DIVISOR DE TEXTO */
        .divisor { display: flex; align-items: center; text-align: center; color: #777; margin: 2.5rem 0 1.5rem 0; font-size: 0.9rem; font-weight: 700; text-transform: uppercase; }
        .divisor::before, .divisor::after { content: ''; flex: 1; border-bottom: 1px solid #333; }
        .divisor:not(:empty)::before { margin-right: 1rem; }
        .divisor:not(:empty)::after { margin-left: 1rem; }

        /* BOTÕES SOCIAIS */
        .social-buttons { display: flex; gap: 1rem; }
        .btn-social { flex: 1; padding: 1rem; border-radius: 12px; text-decoration: none; color: #fff; font-weight: 700; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .btn-whats { background-color: #25D366; }
        .btn-telegram { background-color: #0088cc; }
        .btn-social:hover { transform: translateY(-3px); }
        .btn-whats:hover { box-shadow: 0 10px 20px rgba(37, 211, 102, 0.3); }
        .btn-telegram:hover { box-shadow: 0 10px 20px rgba(0, 136, 204, 0.3); }

        /* CONSERTO DA RESPONSIVIDADE MOBILE */
        @media (max-width: 768px) {
            body { padding: 1.5rem 1rem; }
            header { margin-bottom: 2rem; }
            h1 { font-size: 2.2rem; }
            nav a { margin: 0 0.5rem; font-size: 1rem; }
            .contato-container { padding: 2rem 1.5rem; }
            .social-buttons { flex-direction: column; }
        }
    </style>
</head>
<body>

    <header>
        <a href="/" style="text-decoration: none;"><h1>@gusvisentini</h1></a>
        <p class="subtitle">Mídia, Código e Ideias.</p>
        <nav>
            <a href="/">Início</a>
            <a href="sobre">Sobre</a>
            <a href="contato" style="border-bottom: 2px solid #FFD800; color: #FFD800;">Contato</a>
        </nav>
    </header>

    <main class="contato-container">
        
        <?php if (!empty($mensagem_feedback)): ?>
            <div class="feedback <?= $tipo_feedback ?>">
                <?= $mensagem_feedback ?>
            </div>
        <?php endif; ?>

        <form action="contato" method="POST">
            <div class="form-group">
                <label for="nome">Como você se chama?</label>
                <input type="text" id="nome" name="nome" placeholder="Seu nome" required>
            </div>
            
            <div class="form-group">
                <label for="email">Seu melhor e-mail</label>
                <input type="email" id="email" name="email" placeholder="nome@exemplo.com" required>
            </div>
            
            <div class="form-group">
                <label for="mensagem">No que posso ajudar?</label>
                <textarea id="mensagem" name="mensagem" placeholder="Escreva sua mensagem aqui..." required></textarea>
            </div>
            
            <button type="submit">Enviar Mensagem</button>
        </form>

        <div class="divisor">ou mande uma DM</div>

        <div class="social-buttons">
            <a href="https://wa.me/gusvisentini" target="_blank" class="btn-social btn-whats">
                <i class="fa-brands fa-whatsapp"></i> WhatsApp
            </a>
            <a href="https://t.me/visentini" target="_blank" class="btn-social btn-telegram">
                <i class="fa-brands fa-telegram"></i> Telegram
            </a>
        </div>
    </main>

</body>
</html>