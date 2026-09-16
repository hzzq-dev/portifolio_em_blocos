<?php
// admin/db.php

$db_file = __DIR__ . '/database.sqlite';
$pdo = new PDO('sqlite:' . $db_file);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Cria a tabela de Páginas (O Menu Dinâmico)
$pdo->exec("CREATE TABLE IF NOT EXISTS paginas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT NOT NULL,
    slug TEXT UNIQUE NOT NULL,
    ordem INTEGER DEFAULT 0
)");

// Garante que a página 'Home' (Início) sempre exista
$pdo->exec("INSERT OR IGNORE INTO paginas (id, titulo, slug, ordem) VALUES (1, 'Início', 'home', 0)");

// Cria a tabela principal de cards
$pdo->exec("CREATE TABLE IF NOT EXISTS cards (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT NOT NULL,
    link TEXT NOT NULL,
    tamanho TEXT DEFAULT 'normal',
    gradiente TEXT DEFAULT 'grad-pride',
    imagem_bg TEXT,
    ordem INTEGER DEFAULT 0,
    pagina_slug TEXT DEFAULT 'home'
)");

// ROTINA DE ATUALIZAÇÃO (Adiciona as novas colunas e a ligação com as páginas)
$colunas_novas = [
    'font_family' => "TEXT DEFAULT 'Inter'",
    'font_size'   => "TEXT DEFAULT '1.8rem'",
    'font_weight' => "TEXT DEFAULT '900'",
    'font_style'  => "TEXT DEFAULT 'normal'",
    'text_color'  => "TEXT DEFAULT '#ffffff'",
    'icone'       => "TEXT DEFAULT ''",
    'pagina_slug' => "TEXT DEFAULT 'home'" // Nova coluna para o card saber de qual página ele é
];

foreach ($colunas_novas as $coluna => $tipo) {
    try {
        $pdo->exec("ALTER TABLE cards ADD COLUMN $coluna $tipo");
    } catch (Exception $e) {
        // Ignora silenciosamente se a coluna já existir
    }
}

try {
    $pdo->exec("ALTER TABLE cards ADD COLUMN ordem INTEGER DEFAULT 0");
} catch (PDOException $e) {}
?>