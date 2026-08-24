<?php
// admin/github.php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config.php';
require_once 'seguranca.php';

if (!function_exists('shell_exec')) {
    die("Erro: Função shell_exec bloqueada pela hospedagem.");
}

$url_repo = "https://" . GIT_USER . ":" . GIT_TOKEN . "@github.com/" . GIT_USER . "/" . GIT_REPO . ".git";

// Muda o PHP para a pasta raiz do site
chdir(__DIR__ . '/../');

// 1. INICIA O REPOSITÓRIO PRIMEIRO
shell_exec('git init 2>&1');

// 2. CONFIGURA O USUÁRIO LOCALMENTE (Sem o --global para não bugar o usuário fantasma do servidor)
shell_exec('git config user.email "gustavo@visentini.com.br" 2>&1');
shell_exec('git config user.name "Painel Admin" 2>&1');
shell_exec('git rm -r --cached .private foto-perfil.jpg 2>&1');

// 3. ADICIONA OS ARQUIVOS
shell_exec('git add . 2>&1');

// 4. CRIA O PACOTE (COMMIT) E SALVA A RESPOSTA
$mensagem = "Atualizacao via Painel Admin - " . date('d/m/Y H:i:s');
$resultado_commit = shell_exec("git commit --allow-empty -m \"$mensagem\" 2>&1");

// 5. NOMEIA A BRANCH COMO MAIN E ENVIA FORÇADO
shell_exec("git branch -M main 2>&1");
$resultado_push = shell_exec("git push -u --force \"$url_repo\" main 2>&1");

// Formata a mensagem para vermos exatamente o que aconteceu nas duas etapas
$msg_commit = htmlspecialchars(trim(substr($resultado_commit, 0, 60)));
$msg_push = htmlspecialchars(trim(substr($resultado_push, 0, 60)));

$_SESSION['git_msg'] = "Código salvo e enviado para o GitHub com sucesso!";
header('Location: index'); 
exit;
?>