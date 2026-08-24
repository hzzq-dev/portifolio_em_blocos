<?php
// admin/index.php
require 'db.php';
require_once 'seguranca.php';

// Busca os cards
$stmt = $pdo->query("SELECT * FROM cards ORDER BY ordem ASC, id DESC");
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel | @gusvisentini</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <!-- Trazendo o FontAwesome para ter o ícone de 'agarrar' -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <section class="section">
        <div class="container" style="max-width: 900px;">
            
            <div class="level">
                <div class="level-left">
                    <h1 class="title">Gerenciar Cards</h1>
                </div>
                <div class="level-right">
                    <!-- Novo botão do GitHub -->
                    <a href="github" class="button is-dark ml-2">
                        <i class="fa-brands fa-github mr-2"></i> Enviar p/ GitHub
                    </a>
                    
                    <a href="form_card" class="button is-link ml-2"><b>+ Novo Card</b></a>
                    <a href="/" class="button is-light ml-2" target="_blank">Ver Site</a>
                    <a href="logout" class="button is-danger is-light ml-2">Sair</a>
                </div>
            </div> <!-- Fim da div.level -->

            <!-- Avisa quando o envio der certo -->
            <?php if (isset($_SESSION['git_msg'])): ?>
                <div class="notification is-success is-light">
                    <button class="delete"></button>
                    <?= $_SESSION['git_msg'] ?>
                </div>
                <?php unset($_SESSION['git_msg']); ?>
            <?php endif; ?>

            <div class="box">
                <?php if (empty($cards)): ?>
                    <p class="has-text-centered has-text-grey">Nenhum card cadastrado. Clique em "+ Novo Card" para começar.</p>
                <?php else: ?>
                    <table class="table is-fullwidth is-striped is-hoverable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Título</th>
                                <th>Tamanho</th>
                                <th>Fundo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="lista-cards">
                            <?php foreach ($cards as $card): ?>
                            <!-- data-id e cursor: grab para arrastar -->
                            <tr data-id="<?= $card['id'] ?>" style="cursor: grab;">
                                <td>
                                    <i class="fa-solid fa-grip-vertical has-text-grey-light mr-2"></i>
                                    <?= $card['id'] ?>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($card['titulo']) ?></strong><br>
                                    <small><a href="<?= htmlspecialchars($card['link']) ?>" target="_blank" class="has-text-grey"><?= htmlspecialchars($card['link']) ?></a></small>
                                </td>
                                <td><code><?= htmlspecialchars($card['tamanho']) ?></code></td>
                                <td>
                                    <?php if (!empty($card['imagem_bg'])): ?>
                                        <span class="tag is-success is-light">Imagem</span>
                                    <?php else: ?>
                                        <span class="tag is-info is-light"><?= htmlspecialchars($card['gradiente']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="editar?id=<?= $card['id'] ?>" class="button is-warning is-small">Editar</a>
                                    <a href="deletar?id=<?= $card['id'] ?>" class="button is-danger is-small" onclick="return confirm('Tem certeza que deseja apagar este card?');">Excluir</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            
        </div> <!-- Fim do container -->
    </section>

    <!-- Scripts no final da página -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        const lista = document.getElementById('lista-cards');
        
        if(lista) {
            new Sortable(lista, {
                animation: 150, 
                ghostClass: 'has-background-light', 
                
                onEnd: function () {
                    const novaOrdem = Array.from(lista.children).map(tr => tr.getAttribute('data-id'));
                    
                    fetch('reordenar.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ ordem: novaOrdem })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(!data.sucesso) {
                            alert("Ops! Houve um erro ao salvar a nova ordem no banco de dados.");
                        }
                    });
                },
            });
        }
    </script>
    
    <script>
        // Script para fechar o aviso verde do GitHub
        document.addEventListener('DOMContentLoaded', () => {
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                const $notification = $delete.parentNode;
                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });
        });
    </script>
</body>
</html>