<?php
// admin/reordenar.php
require_once 'seguranca.php';
require_once 'db.php';

// Recebe os dados em formato JSON enviados pelo Javascript
$dados = json_decode(file_get_contents('php://input'), true);

if (isset($dados['ordem']) && is_array($dados['ordem'])) {
    // Prepara a query para atualizar a ordem de cada card
    $stmt = $pdo->prepare("UPDATE cards SET ordem = :ordem WHERE id = :id");
    
    // Roda um loop atualizando a posição (index) de cada ID
    foreach ($dados['ordem'] as $index => $id) {
        $stmt->execute([
            ':ordem' => $index,
            ':id' => $id
        ]);
    }
    
    echo json_encode(['sucesso' => true]);
} else {
    echo json_encode(['sucesso' => false]);
}
?>