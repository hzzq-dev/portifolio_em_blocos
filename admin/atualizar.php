<?php
// admin/atualizar.php
require 'db.php';
require_once 'seguranca.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
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

    $remover_imagem = $_POST['remover_imagem'] ?? '0'; 
    $campos = "titulo = ?, link = ?, tamanho = ?, gradiente = ?, font_family = ?, font_size = ?, font_weight = ?, font_style = ?, text_color = ?, icone = ?";
    $parametros = [$titulo, $link, $tamanho, $gradiente, $font_family, $font_size, $font_weight, $font_style, $text_color, $icone];

    $nova_imagem_enviada = isset($_FILES['imagem_bg']) && $_FILES['imagem_bg']['error'] === UPLOAD_ERR_OK;

    if ($remover_imagem === '1' && !$nova_imagem_enviada) {
        $stmt = $pdo->prepare("SELECT imagem_bg FROM cards WHERE id = ?");
        $stmt->execute([$id]);
        $card_antigo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($card_antigo && !empty($card_antigo['imagem_bg'])) {
            $caminho_antigo = '../uploads/' . $card_antigo['imagem_bg'];
            if (file_exists($caminho_antigo)) {
                unlink($caminho_antigo);
            }
        }
        
        $campos .= ", imagem_bg = ?";
        $parametros[] = '';
    } 
    elseif ($nova_imagem_enviada) {
        $extensao = strtolower(pathinfo($_FILES['imagem_bg']['name'], PATHINFO_EXTENSION));
        // AGORA ACEITA VÍDEOS!
        $tipos_permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm'];
        
        if (in_array($extensao, $tipos_permitidos)) {
            $nome_arquivo = uniqid('bg_') . '.' . $extensao;
            $destino = '../uploads/' . $nome_arquivo;
            
            if (move_uploaded_file($_FILES['imagem_bg']['tmp_name'], $destino)) {
                $campos .= ", imagem_bg = ?";
                $parametros[] = $nome_arquivo;

                $stmt = $pdo->prepare("SELECT imagem_bg FROM cards WHERE id = ?");
                $stmt->execute([$id]);
                $card_antigo = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($card_antigo && !empty($card_antigo['imagem_bg'])) {
                    $caminho_antigo = '../uploads/' . $card_antigo['imagem_bg'];
                    if (file_exists($caminho_antigo)) {
                        unlink($caminho_antigo);
                    }
                }
            }
        }
    }

    $parametros[] = $id;

    try {
        $stmt = $pdo->prepare("UPDATE cards SET $campos WHERE id = ?");
        $stmt->execute($parametros);
    } catch (Exception $e) {
        die("Erro ao atualizar: " . $e->getMessage());
    }

    header('Location: index.php');
    exit;
}
?>