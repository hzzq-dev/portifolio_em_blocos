# 🚀 Portfólio em Blocos (Bento Grid CMS)

Um sistema de portfólio dinâmico, leve e totalmente personalizável, construído com PHP e SQLite. Inspirado no conceito de "Bento Grid", este projeto permite a criação de páginas e blocos de conteúdo estilizados através de um painel de controlo administrativo próprio, dispensando o uso de ferramentas pesadas como o WordPress.

---

## ✨ Principais Funcionalidades

* **Grid Responsivo Dinâmico:** Blocos com tamanhos variados (1x1, 2x1, 1x2, 2x2) que se reorganizam de forma inteligente em telemóveis e computadores, utilizando `grid-auto-flow: dense`.
* **Mídias e Cores de Fundo:** Suporte para carregamento de imagens estáticas, GIFs, vídeos em loop nativo (MP4/WebM) ou degradês temáticos (Pride, Trans, Bi, Pan).
* **Personalização Tipográfica e Visual:** Integração direta com Google Fonts e FontAwesome 6 para alterar a fonte, peso, estilo, cor, tamanho e ícones de cada cartão individualmente.
* **Menu e Navegação Inteligentes:** Criação de rotas dinâmicas no painel com eliminação em cascata. O menu superior possui efeito "vidro embaçado" (backdrop-filter) e opções configuráveis na área de administração (fixo/sticky e estilo de botões em pílula).
* **Painel Administrativo Intuitivo:** Interface construída com Bulma CSS, agrupando blocos por página com visualização em sanfona (Collapse).
* **Organização Drag-and-Drop:** Reordenação da posição dos cartões no site bastando clicar e arrastar no painel (SortableJS), com gravação assíncrona.
* **Contacto Seguro:** Formulário de e-mail utilizando PHPMailer e protegido contra robôs com integração nativa do Google reCAPTCHA.
* **Sincronização com o GitHub:** Botão dedicado no painel para realizar o envio das atualizações diretamente do servidor em produção para o repositório via API.

---

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP 8+ (PDO para segurança nas queries)
* **Base de Dados:** SQLite (Portátil, leve e sem necessidade de configurações de servidor)
* **Frontend Público:** HTML5 e CSS3 (Personalizado com CSS Variables e CSS Grid)
* **Frontend do Painel:** Bulma CSS e SortableJS
* **E-mail e Segurança:** PHPMailer e Google API (reCAPTCHA)

---

## 🚀 Como Instalar e Executar

* Faça o clone deste repositório no seu ambiente local (XAMPP/MAMP) ou servidor de alojamento (como a Hostinger).
* Mude o nome do ficheiro de modelo `config.example.php` para `config.php`.
* Preencha as credenciais no `config.php` (Utilizador/Palavra-passe do painel, dados de envio do e-mail, Token do GitHub e Chaves do reCAPTCHA).
* Aceda ao diretório `/admin` através do navegador para realizar o login e iniciar o registo de informações.
* O ficheiro da base de dados (`database.sqlite`) será lido e atualizado automaticamente pelo sistema sem exigir scripts externos de SQL (as novas colunas de tipografia e configuração são geradas de forma autónoma).

---

## 🔒 Notas de Segurança e Privacidade

* O ficheiro `config.php` está obrigatoriamente incluído no `.gitignore`. Palavras-passe, chaves privadas do Google e Tokens de versionamento nunca devem ser enviados para o repositório público.
* A página principal identifica a origem dos links dinamicamente, abrindo páginas de terceiros num novo separador visando a retenção do utilizador, enquanto a navegação em links do próprio domínio mantém o tráfego na mesma janela.

---

Veja em tempo real aqui: [https://visentini.com.br](https://visentini.com.br) - Dúvidas, sugestões ou pedidos: 📧 github@hzzq.com.br

<img width="1358" height="916" alt="image" src="https://github.com/user-attachments/assets/df1df1a9-1783-4508-8f43-5ab1d2d6a2b9" />
