<?php
// admin/index.php
require 'db.php';
require_once 'seguranca.php'; // Recuperado!

// 1. Busca os nomes das páginas para nomear os grupos
$stmtPages = $pdo->query("SELECT slug, titulo FROM paginas");
$titulos_paginas = $stmtPages->fetchAll(PDO::FETCH_KEY_PAIR) ?: [];
$titulos_paginas['home'] = 'Página Inicial (Home)';

// 2. Busca todos os cards
$stmtCards = $pdo->query("SELECT * FROM cards ORDER BY ordem ASC, id DESC");
$todos_cards = $stmtCards->fetchAll(PDO::FETCH_ASSOC);

// 3. Agrupa os cards pelo slug da página
$grupos_cards = [];
foreach ($todos_cards as $card) {
    $slug = !empty($card['pagina_slug']) ? $card['pagina_slug'] : 'home';
    
    if (!isset($titulos_paginas[$slug])) {
        $titulos_paginas[$slug] = "Página: " . $slug;
    }
    
    $grupos_cards[$slug][] = $card;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel | @gusvisentini</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .group-header { transition: background-color 0.2s ease; user-select: none; }
        .group-header:hover { background-color: #e8e8e8 !important; }
        .group-content table { margin-bottom: 0; border-top: none; }
    </style>
</head>
<body>
    <section class="section">
        <div class="container" style="max-width: 1100px;">
            
            <div class="level">
                <div class="level-left">
                    <h1 class="title">Gerenciar Cards</h1>
                </div>
                <div class="level-right">
                    <!-- Recuperado: Botão do GitHub -->
                    <a href="github" class="button is-dark ml-2">
                        <i class="fa-brands fa-github mr-2"></i> Enviar p/ GitHub
                    </a>
                    
                    <a href="form_card" class="button is-link ml-2"><b>+ Novo Card</b></a>
                    
                    <a href="paginas.php" class="button is-info is-light ml-2">
                        <i class="fa-solid fa-folder-tree" style="margin-right: 8px;"></i> Gerenciar Páginas
                    </a>

                    <!-- NOVO: Botão de Configurações Visuais -->
                    <a href="configuracoes.php" class="button is-primary is-light ml-2">
                        <i class="fa-solid fa-sliders" style="margin-right: 8px;"></i> Configurações
                    </a>
                    
                    <a href="../" class="button is-light ml-2" target="_blank">Ver Site</a>
                    
                    <!-- Recuperado: Botão de Sair -->
                    <a href="logout" class="button is-danger is-light ml-2">Sair</a>
                </div>
            </div>

            <!-- Recuperado: Avisos de sucesso (GitHub, etc) -->
            <?php if (isset($_SESSION['git_msg'])): ?>
                <div class="notification is-success is-light">
                    <button class="delete"></button>
                    <?= $_SESSION['git_msg'] ?>
                </div>
                <?php unset($_SESSION['git_msg']); ?>
            <?php endif; ?>

            <?php if (empty($todos_cards)): ?>
                <div class="box">
                    <p class="has-text-centered has-text-grey">Nenhum card cadastrado. Clique em "+ Novo Card" para começar.</p>
                </div>
            <?php else: ?>
                
                <!-- Laço que cria os agrupadores -->
                <?php foreach ($titulos_paginas as $slug => $titulo): ?>
                    <?php 
                        if (!isset($grupos_cards[$slug])) continue; 
                        $cards = $grupos_cards[$slug];
                    ?>
                    
                    <div class="box p-0 mb-5" style="overflow: hidden; border: 1px solid #ddd;">
                        
                        <!-- Cabeçalho Clicável do Grupo (+ e -) -->
                        <div class="has-background-light p-4 is-clickable group-header" data-target="grupo-<?= $slug ?>">
                            <div class="level is-mobile mb-0">
                                <div class="level-left">
                                    <span class="icon is-medium has-text-link mr-2">
                                        <i class="fa-solid fa-folder-open fa-lg"></i>
                                    </span>
                                    <strong class="is-size-5"><?= htmlspecialchars($titulo) ?></strong>
                                    <span class="tag is-rounded ml-3"><?= count($cards) ?> card(s)</span>
                                </div>
                                <div class="level-right">
                                    <span class="icon toggle-icon has-text-grey">
                                        <i class="fa-solid fa-minus"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Conteúdo do Grupo (A Tabela) -->
                        <div class="group-content" id="grupo-<?= $slug ?>" style="display: block;">
                            <table class="table is-fullwidth is-striped is-hoverable">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">#</th>
                                        <th>Título</th>
                                        <th>Tamanho</th>
                                        <th>Fundo</th>
                                        <th class="has-text-centered" style="width: 250px;">Ações</th>
                                    </tr>
                                </thead>
                                <!-- Adicionada a classe 'lista-cards-sortable' para o JS reconhecer -->
                                <tbody class="lista-cards-sortable">
                                    <?php foreach ($cards as $card): ?>
                                    <!-- Recuperado: data-id e cursor grab para arrastar -->
                                    <tr data-id="<?= $card['id'] ?>" style="cursor: grab;">
                                        <td class="is-vcentered">
                                            <i class="fa-solid fa-grip-vertical has-text-grey-light mr-2"></i>
                                            <?= $card['id'] ?>
                                        </td>
                                        <td class="is-vcentered">
                                            <strong>
                                                <?php if (!empty($card['icone'])): ?>
                                                    <i class="<?= htmlspecialchars($card['icone']) ?> mr-1"></i>
                                                <?php endif; ?>
                                                <?= htmlspecialchars($card['titulo']) ?>
                                            </strong><br>
                                            <small><a href="<?= htmlspecialchars($card['link']) ?>" target="_blank" class="has-text-grey"><?= htmlspecialchars($card['link']) ?></a></small>
                                        </td>
                                        <td class="is-vcentered"><code><?= htmlspecialchars($card['tamanho']) ?></code></td>
                                        <td class="is-vcentered">
                                            <?php if (!empty($card['imagem_bg'])): ?>
                                                <span class="tag is-success is-light">Imagem</span>
                                            <?php else: ?>
                                                <span class="tag is-info is-light"><?= htmlspecialchars($card['gradiente']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="has-text-centered is-vcentered">
                                            <a href="editar?id=<?= $card['id'] ?>" class="button is-warning is-small">Editar</a>
                                            <a href="deletar?id=<?= $card['id'] ?>" class="button is-danger is-small" onclick="return confirm('Tem certeza que deseja apagar este card?');">Excluir</a>
                                            <a href="duplicar.php?id=<?= $card['id'] ?>" class="button is-info is-small">Copiar</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
                
            <?php endif; ?>
        </div>
    </section>

    <!-- SCRIPTS RECUPERADOS E ADAPTADOS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        // 1. Script de Sanfona (Abrir/Fechar grupos)
        document.addEventListener('DOMContentLoaded', () => {
            const headers = document.querySelectorAll('.group-header');
            headers.forEach(header => {
                header.addEventListener('click', () => {
                    const targetId = header.getAttribute('data-target');
                    const content = document.getElementById(targetId);
                    const icon = header.querySelector('.toggle-icon i');
                    
                    if (content.style.display === 'none') {
                        content.style.display = 'block';
                        icon.classList.replace('fa-plus', 'fa-minus');
                    } else {
                        content.style.display = 'none';
                        icon.classList.replace('fa-minus', 'fa-plus');
                    }
                });
            });
        });

        // 2. Script de Arrastar e Soltar (SortableJS adaptado para múltiplos grupos)
        document.querySelectorAll('.lista-cards-sortable').forEach(function(lista) {
            new Sortable(lista, {
                animation: 150, 
                ghostClass: 'has-background-light', 
                
                onEnd: function () {
                    // Pega TODOS os cards da tela inteira (de todos os grupos) na ordem visual atual
                    const todosTrs = document.querySelectorAll('.lista-cards-sortable tr');
                    const novaOrdem = Array.from(todosTrs).map(tr => tr.getAttribute('data-id'));
                    
                    fetch('reordenar.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
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
        });

        // 3. Script para fechar as notificações (Verdes/Vermelhas)
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