<?php
// admin/seguranca.php
session_start();

// Se não existir a sessão 'logado' ou for falsa, redireciona para o login
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: login.php');
    exit;
}
?>