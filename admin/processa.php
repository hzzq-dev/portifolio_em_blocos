<?php
// admin/processa.php
require 'db.php';
require_once 'seguranca.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $link = $_POST['link'] ?? '';
    $tamanho = $_POST['tamanho'] ?? 'normal';
    $gradiente = $_POST['gradiente'] ?? 'grad-pride';
    $font_family = $_POST['font_family'] ?? 'Inter';
    $font_size = $_POST['font_size'] ?? '1.8rem';
    $font_weight = $_POST['font_weight'] ?? '900';
    $font_style = $_POST['font_style'] ?? 'normal';
    $text_color = $_POST['text_color'] ?? '#ffffff';
    $icone = $_POST['icone'] ?? '';

    $imagem_bg = '';

    if (isset($_FILES['imagem_bg']) && $_FILES['imagem_bg']['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($_FILES['imagem_bg']['name'], PATHINFO_EXTENSION));
        // AGORA ACEITA VÍDEOS!
        $tipos_permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm'];
        
        if (in_array($extensao, $tipos_permitidos)) {
            $nome_arquivo = uniqid('bg_') . '.' . $extensao;
            $destino = '../uploads/' . $nome_arquivo;
            
            if (move_uploaded_file($_FILES['imagem_bg']['tmp_name'], $destino)) {
                $imagem_bg = $nome_arquivo;
            }
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO cards (titulo, link, tamanho, gradiente, font_family, font_size, font_weight, font_style, text_color, icone, imagem_bg) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $link, $tamanho, $gradiente, $font_family, $font_size, $font_weight, $font_style, $text_color, $icone, $imagem_bg]);
    } catch (Exception $e) {
        die("Erro ao salvar no banco: " . $e->getMessage());
    }

    header('Location: index.php');
    exit;
}
?>