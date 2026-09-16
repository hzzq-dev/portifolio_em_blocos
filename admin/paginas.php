<?php
// admin/paginas.php
require_once 'seguranca.php';
require_once 'db.php';

$mensagem = '';

// ==========================================
// 1. LÓGICA PARA ADICIONAR NOVA PÁGINA
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'adicionar') {
    $titulo = trim($_POST['titulo']);
    
    // Cria um 'slug' automático (URL amigável) baseado no título
    // Ex: "Meus Textos" vira "meus-textos"
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titulo)));
    
    if (!empty($titulo) && !empty($slug)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO paginas (titulo, slug) VALUES (?, ?)");
            $stmt->execute([$titulo, $slug]);
            $mensagem = '<div class="notification is-success">Página adicionada com sucesso!</div>';
        } catch (Exception $e) {
            $mensagem = '<div class="notification is-danger">Erro: Uma página com esse nome ou link já existe.</div>';
        }
    }
}

// ==========================================
// 2. LÓGICA PARA DELETAR PÁGINA (EFEITO CASCATA)
// ==========================================
if (isset($_GET['deletar'])) {
    $id_del = (int)$_GET['deletar'];
    
    // Busca a página para ter certeza de qual é o slug dela
    $stmt = $pdo->prepare("SELECT slug FROM paginas WHERE id = ?");
    $stmt->execute([$id_del]);
    $pag_del = $stmt->fetch(PDO::FETCH_ASSOC);

    // Trava de segurança: Nunca deletar a página principal (home)
    if ($pag_del && $pag_del['slug'] !== 'home') {
        
        // CASCATA 1: Deleta todos os cards associados a esta página
        $stmtCards = $pdo->prepare("DELETE FROM cards WHERE pagina_slug = ?");
        $stmtCards->execute([$pag_del['slug']]);

        // CASCATA 2: Deleta a página em si
        $stmtDel = $pdo->prepare("DELETE FROM paginas WHERE id = ?");
        $stmtDel->execute([$id_del]);
        
        header("Location: paginas.php");
        exit;
    } else {
         $mensagem = '<div class="notification is-warning">A página Home não pode ser deletada.</div>';
    }
}

// ==========================================
// 3. LISTAR AS PÁGINAS EXISTENTES
// ==========================================
$stmtList = $pdo->query("SELECT * FROM paginas ORDER BY ordem ASC, id ASC");
$paginas = $stmtList->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Páginas | Painel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<section class="section">
  <div class="container" style="max-width: 800px;">
    
    <div class="level">
        <div class="level-left">
            <h2 class="title">Gerenciar Menus e Páginas</h2>
        </div>
        <div class="level-right">
            <a href="index.php" class="button is-light">Voltar ao Painel de Cards</a>
        </div>
    </div>

    <?= $mensagem ?>

    <div class="columns mt-4">
        
        <!-- COLUNA ESQUERDA: Formulário para criar -->
        <div class="column is-one-third">
            <div class="box">
                <h3 class="subtitle is-5">Nova Página</h3>
                <form action="paginas.php" method="POST">
                    <input type="hidden" name="acao" value="adicionar">
                    
                    <div class="field">
                        <label class="label">Título no Menu</label>
                        <div class="control">
                            <input class="input" type="text" name="titulo" placeholder="Ex: Meus Textos" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="button is-link is-fullwidth mt-4">Criar Página</button>
                </form>
            </div>
        </div>

        <!-- COLUNA DIREITA: Lista de páginas criadas -->
        <div class="column">
            <div class="box">
                <h3 class="subtitle is-5">Páginas Atuais</h3>
                
                <table class="table is-fullwidth is-striped">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Link (Slug)</th>
                            <th class="has-text-centered">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($paginas as $pag): ?>
                        <tr>
                            <td class="is-vcentered"><strong><?= htmlspecialchars($pag['titulo']) ?></strong></td>
                            <td class="is-vcentered"><code>?p=<?= htmlspecialchars($pag['slug']) ?></code></td>
                            <td class="has-text-centered is-vcentered">
                                <?php if ($pag['slug'] === 'home'): ?>
                                    <span class="tag is-light">Página Fixa</span>
                                <?php else: ?>
                                    <a href="?deletar=<?= $pag['id'] ?>" 
                                       class="button is-danger is-small" 
                                       onclick="return confirm('ATENÇÃO: Deletar esta página apagará TODOS os cards que estão dentro dela. Tem certeza?');">
                                       <i class="fa-solid fa-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="help mt-3">Para mudar a ordem, crie as páginas na sequência que deseja que apareçam no menu.</p>
            </div>
        </div>
        
    </div>

  </div>
</section>
</body>
</html>