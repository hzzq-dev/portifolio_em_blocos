# 🚀 Portfólio em Blocos (Bento Grid CMS)

Um sistema de portfólio dinâmico, leve e totalmente customizável construído com PHP e SQLite. Inspirado no conceito de "Bento Grid", este projeto permite a criação de páginas e blocos de conteúdo estilizados através de um painel de controle administrativo próprio, dispensando o uso de ferramentas pesadas como o WordPress.

---

## ✨ Principais Funcionalidades

* **Grid Responsivo Dinâmico:** Blocos com tamanhos variados (1x1, 2x1, 1x2, 2x2) que se reorganizam de forma inteligente em dispositivos móveis e desktops.
* **Mídias e Cores de Fundo:** Suporte para upload de imagens, vídeos em loop (MP4/WebM) ou degradês temáticos personalizados.
* **Customização Tipográfica:** Integração direta com Google Fonts e FontAwesome para alterar fonte, peso, cor, tamanho e ícones de cada card individualmente.
* **Páginas e Menus Automáticos:** Criação de rotas dinâmicas no painel. O menu do site é gerado sozinho e a exclusão de uma página deleta todos os cards contidos nela (efeito cascata).
* **Painel Administrativo Intuitivo:** Interface construída com Bulma CSS, agrupando blocos por página com visualização em "sanfona" (Collapse).
* **Organização Drag-and-Drop:** Reordenação da posição dos blocos no site apenas clicando e arrastando no painel, com salvamento assíncrono via JavaScript.
* **Contato Seguro:** Formulário de e-mail utilizando PHPMailer e protegido contra robôs com integração nativa do Google reCAPTCHA.
* **Sincronização com GitHub:** Botão dedicado no painel para realizar o envio das atualizações direto do servidor em produção para o repositório via API.

---

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP 8+ (PDO para segurança de queries)
* **Banco de Dados:** SQLite (Portátil, leve e sem necessidade de configurações de servidor)
* **Frontend Público:** HTML5 e CSS3 (Customizado com CSS Variables e Grid Layout)
* **Frontend Painel:** Bulma CSS e SortableJS
* **E-mail e Segurança:** PHPMailer e Google API (reCAPTCHA)

---

## 🚀 Como Instalar e Executar

* Faça o clone deste repositório no seu ambiente local (XAMPP/MAMP) ou servidor de hospedagem (como Hostinger).
* Renomeie o arquivo de modelo `config.example.php` para `config.php`.
* Preencha as credenciais no `config.php` (Usuário/Senha do painel, dados de envio do e-mail, Token do GitHub e Chaves do reCAPTCHA).
* Acesse o diretório `/admin` através do navegador para realizar o login e iniciar o cadastro de informações.
* O arquivo do banco de dados (`database.sqlite`) será lido e atualizado automaticamente pelo sistema sem exigir scripts externos de SQL.

---

## 🔒 Notas de Segurança e Privacidade

* O arquivo `config.php` está obrigatoriamente incluído no arquivo `.gitignore`. Senhas, chaves privadas do Google e Tokens de versionamento nunca devem ser enviados para o repositório público.
* A página principal identifica a origem dos links dinamicamente, abrindo páginas de terceiros em novas abas visando retenção de usuário, enquanto a navegação em links do próprio domínio mantém o tráfego na mesma janela.

---

Você pode ver em tempo real aqui: [https://visentini.com.br](https://visentini.com.br) / Dúvidas, sugestões ou pedidos - 📧 github@hzzq.com.br

<img width="1364" height="896" alt="image" src="https://github.com/user-attachments/assets/07a34cfc-af6f-4bb2-bada-2a341b7eba35" />

