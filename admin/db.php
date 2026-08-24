<?php
// admin/db.php

$db_file = __DIR__ . '/database.sqlite';
$pdo = new PDO('sqlite:' . $db_file);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Cria a tabela principal (se não existir)
$pdo->exec("CREATE TABLE IF NOT EXISTS cards (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT NOT NULL,
    link TEXT NOT NULL,
    tamanho TEXT DEFAULT 'normal',
    gradiente TEXT DEFAULT 'grad-pride',
    imagem_bg TEXT,
    ordem INTEGER DEFAULT 0
)");

// ROTINA DE ATUALIZAÇÃO (Adiciona as novas colunas)
$colunas_novas = [
    'font_family' => "TEXT DEFAULT 'Inter'",
    'font_size'   => "TEXT DEFAULT '1.8rem'",
    'font_weight' => "TEXT DEFAULT '900'",
    'font_style'  => "TEXT DEFAULT 'normal'",
    'text_color'  => "TEXT DEFAULT '#ffffff'",
    'icone'       => "TEXT DEFAULT ''"
];

foreach ($colunas_novas as $coluna => $tipo) {
    try {
        $pdo->exec("ALTER TABLE cards ADD COLUMN $coluna $tipo");
    } catch (Exception $e) {
        // Ignora silenciosamente se a coluna já existir
    }
}

// Adiciona a coluna 'ordem' caso ela ainda não exista (ignora o erro se já existir)
try {
    $pdo->exec("ALTER TABLE cards ADD COLUMN ordem INTEGER DEFAULT 0");
} catch (PDOException $e) {
    // A coluna já existe, seguimos a vida.
}
?>