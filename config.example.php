<?php
// config.php
// ESTE ARQUIVO NUNCA VAI PARA O GITHUB

// Senhas do Admin
define('ADMIN_USUARIO', 'usuario_aqui');
define('ADMIN_SENHA', 'usenha_aqui');

// 2. Senhas do E-mail (Provedor)
define('MAIL_USER', 'email_aqui');
define('MAIL_PASS', 'senha_aqui');
define('MAIL_DESTINO', 'email_que_recebera_a_mensagem_aqui');

// 3. Credenciais do GitHub (Para o botão de sincronização)
// ⚠️ ATENÇÃO: Você PRECISA revogar o token antigo e gerar um novo!
// Acesse: https://github.com/settings/tokens
define('GIT_USER', 'usuario_aqui');
define('GIT_TOKEN', 'token_github_aqui'); // <-- COLOQUE SEU NOVO TOKEN AQUI
define('GIT_REPO', 'portifolio_em_blocos');

// 4. Google reCAPTCHA
// ⚠️ ATENÇÃO: Você PRECISA gerar NOVAS chaves no site do Google!
// Acesse: https://www.google.com/recaptcha/admin
// - Coloque a CHAVE SECRETA (SECRET KEY) aqui
// - Coloque a CHAVE DO SITE (SITE KEY) no HTML do contato.php
define('RECAPTCHA_SECRET', 'chave_aqui'); // <-- COLOQUE SUA CHAVE SECRET AQUI

?>