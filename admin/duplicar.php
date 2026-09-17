<?php
// admin/duplicar.php
require 'db.php';
require_once 'seguranca.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // 1. Busca o card original
    $stmt = $pdo->prepare("SELECT * FROM cards WHERE id = ?");
    $stmt->execute([$id]);
    $card = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($card) {
        // 2. Copia os dados (adicionando "Cópia" no título para você identificar)
        $titulo      = $card['titulo'] . ' (Cópia)';
        $link        = $card['link'];
        $pagina_slug = $card['pagina_slug'] ?? 'home';
        $tamanho     = $card['tamanho'];
        $gradiente   = $card['gradiente'];
        $font_family = $card['font_family'];
        $font_size   = $card['font_size'];
        $font_weight = $card['font_weight'];
        $font_style  = $card['font_style'];
        $text_color  = $card['text_color'];
        $icone       = $card['icone'];
        
        $imagem_bg   = '';
        
        // 3. Lógica para clonar a imagem/vídeo físico (para não quebrar se um for apagado)
        if (!empty($card['imagem_bg'])) {
            $caminho_antigo = '../uploads/' . $card['imagem_bg'];
            
            if (file_exists($caminho_antigo)) {
                $extensao = strtolower(pathinfo($caminho_antigo, PATHINFO_EXTENSION));
                $novo_nome_arquivo = uniqid('bg_copy_') . '.' . $extensao;
                $caminho_novo = '../uploads/' . $novo_nome_arquivo;
                
                // Se a cópia física der certo, salvamos o novo nome
                if (copy($caminho_antigo, $caminho_novo)) {
                    $imagem_bg = $novo_nome_arquivo;
                }
            }
        }

        // 4. Insere o clone no banco de dados
        try {
            $stmtInsert = $pdo->prepare("INSERT INTO cards (titulo, link, pagina_slug, tamanho, gradiente, font_family, font_size, font_weight, font_style, text_color, icone, imagem_bg) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtInsert->execute([$titulo, $link, $pagina_slug, $tamanho, $gradiente, $font_family, $font_size, $font_weight, $font_style, $text_color, $icone, $imagem_bg]);
        } catch (Exception $e) {
            die("Erro ao duplicar no banco: " . $e->getMessage());
        }
    }
}

// Volta para o painel
header('Location: index.php');
exit;
?>