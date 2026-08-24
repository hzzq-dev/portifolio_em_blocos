<?php
// admin/deletar.php
require 'db.php';
require_once 'seguranca.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Primeiro, busca a imagem para apagar do servidor
    $stmt = $pdo->prepare("SELECT imagem_bg FROM cards WHERE id = ?");
    $stmt->execute([$id]);
    $card = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se tiver imagem associada, deleta o arquivo físico da pasta uploads
    if ($card && !empty($card['imagem_bg'])) {
        $caminho_imagem = '../uploads/' . $card['imagem_bg'];
        if (file_exists($caminho_imagem)) {
            unlink($caminho_imagem);
        }
    }

    // Deleta o registro do banco de dados SQLite
    $stmt = $pdo->prepare("DELETE FROM cards WHERE id = ?");
    $stmt->execute([$id]);
}

// Volta para o painel
header('Location: index.php');
exit;
?>