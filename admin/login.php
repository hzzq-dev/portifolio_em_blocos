<?php
// admin/login.php
session_start();

// Chama o cofre de senhas (voltar uma pasta)
require_once '../config.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Verifica batendo com as constantes do config.php
    if ($usuario === ADMIN_USUARIO && $senha === ADMIN_SENHA) {
        $_SESSION['logado'] = true;
        header('Location: index.php'); // Ou './' se estiver usando URLs amigáveis
        exit;
    } else {
        $erro = 'Usuário ou senha incorretos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Admin @gusvisentini</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <style>
        body { background-color: #f4f4f4; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-box { max-width: 400px; width: 100%; padding: 2rem; background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="login-box">
        <h1 class="title has-text-centered mb-5">Área Restrita</h1>
        
        <?php if ($erro): ?>
            <div class="notification is-danger is-light"><?= $erro ?></div>
        <?php endif; ?>

        <form action="login" method="POST">
            <div class="field">
                <label class="label">Usuário</label>
                <div class="control">
                    <input class="input" type="text" name="usuario" required autofocus>
                </div>
            </div>
            <div class="field">
                <label class="label">Senha</label>
                <div class="control">
                    <input class="input" type="password" name="senha" required>
                </div>
            </div>
            <div class="control mt-5">
                <button type="submit" class="button is-link is-fullwidth">Entrar</button>
            </div>
        </form>
    </div>
</body>
</html>