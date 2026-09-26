
# Obras da Cidade — Projeto Integrador

Sistema de acompanhamento e gestão de obras da cidade, desenvolvido com **C#, PHP, JavaScript, HTML, CSS e MySQL/MariaDB**. O projeto reúne uma aplicação web com front-end e back-end e um aplicativo desktop em Windows Forms, integrados pelo mesmo banco de dados.

O site permite consultar obras por status e enviar solicitações de alteração. O desktop oferece telas para gerenciar obras e usuários, além de aprovar ou rejeitar os pedidos registrados no site.

## Objetivo

Centralizar informações sobre obras, facilitar a consulta de prazos e localizações e organizar a participação dos usuários por meio de solicitações. Como projeto integrador, reúne desenvolvimento web, programação desktop, persistência de dados e regras de negócio.

## Como o projeto está dividido

| Parte | Responsabilidade |
| --- | --- |
| **Front-end web** | Apresenta cards de obras, abas por status, formulários e modais. |
| **Back-end PHP** | Processa formulários, sessões, uploads e operações no banco. |
| **Aplicativo C#** | Oferece telas de gestão de obras, contas e pedidos. |
| **Banco de dados** | Armazena informações compartilhadas pelas duas aplicações. |

O PHP acessa o banco por **MySQLi** e o C# por **MySql.Data**. A integração encontrada no código acontece pelo banco compartilhado; não há uma API HTTP intermediária entre esses módulos.

## Funcionalidades

### Aplicação web

- Consulta pública de obras nas abas **Planejadas**, **Em andamento** e **Concluídas**.
- Cards com nome, descrição, imagem, prazo, localização e status.
- Cadastro de usuários, login e encerramento de sessão.
- Cadastro de obras por usuários autenticados no fluxo atual do modal “Nova Obra”.
- Edição e exclusão direta apresentadas na interface para administradores.
- Solicitações de edição e exclusão por usuários comuns.
- Upload de imagens de obras e de imagens sugeridas em solicitações.
- Script separado para solicitar criação de obra.
- Script de envio de contato por e-mail com PHPMailer, dependente de configuração SMTP.

### Aplicativo desktop

- Login usando os usuários do banco compartilhado.
- Menu com identificação do usuário conectado.
- Consulta de obras em tabela.
- Cadastro e edição de obras, com seleção de status.
- Seleção e visualização local de imagens.
- Cadastro, edição e exclusão de contas de usuários.
- Definição de nível de acesso nas contas.
- Listagem de solicitações pendentes.
- Aprovação de pedidos de criação, edição e exclusão de obras.
- Rejeição de pedidos, alterando sua situação para `negado`.
- Uso de transação na aprovação para aplicar a ação e atualizar a situação do pedido em conjunto.

## Tecnologias

| Tecnologia | Uso no projeto |
| --- | --- |
| C# e Windows Forms | Interface e lógica da aplicação desktop. |
| .NET Framework 4.7.2 | Framework definido no projeto C#. |
| PHP | Processamento das requisições web. |
| HTML e CSS | Estrutura e apresentação das páginas. |
| JavaScript | Interações no navegador. |
| Bootstrap 5.3.3 | Layout, modais, abas e outros componentes da página principal. |
| Font Awesome 6.4.0 | Ícones da interface web. |
| MySQL/MariaDB | Banco relacional compartilhado. |
| MySQLi | Acesso ao banco pelo PHP. |
| MySql.Data 9.4.0 | Biblioteca de acesso ao banco referenciada no projeto C#. |
| PHPMailer 6.10.0 | Dependência registrada em `composer.lock` para envio de e-mail. |
| NuGet e Composer | Gerenciamento de dependências do desktop e do módulo PHP. |

O ZIP também contém `css/estilo.css` e `javascript/script.js`. O `index.php` atual carrega Bootstrap por CDN e não referencia esses dois arquivos próprios; o JavaScript separado usa seletores de uma estrutura diferente da página atual.

## Organização das pastas

Os caminhos abaixo são relativos à pasta `Projeto Obras da Cidade` extraída do ZIP.

| Caminho | Conteúdo |
| --- | --- |
| `Projeto_obra_cidade/` | Aplicação web em PHP. |
| `Projeto_obra_cidade/css/` | Estilos próprios. |
| `Projeto_obra_cidade/javascript/` | Script próprio de interface. |
| `Projeto_obra_cidade/img/` | Imagens de apoio, incluindo perfil e imagem padrão. |
| `Projeto_obra_cidade/uploads/` | Imagens utilizadas pelas obras na aplicação web. |
| `Projeto_obra_cidade/vendor/` | Dependências PHP incluídas no ZIP. |
| `Projeto_obra_cidade/composer.json` e `composer.lock` | Declaração e versões das dependências PHP. |
| `Obrasdacidade/Obrasdacidade.sln` | Solução a abrir no Visual Studio. |
| `Obrasdacidade/Obrasdacidade/` | Código-fonte e projeto Windows Forms. |
| `obrasdacidade (7).sql` | Estrutura e dados exportados do banco. |

## Principais arquivos PHP

| Arquivo | Função |
| --- | --- |
| `index.php` | Lista obras, organiza as abas e contém os modais de cadastro e alterações. |
| `conn.php` | Configura a conexão com o banco. |
| `login.php` e `logout.php` | Iniciam e encerram a sessão web. |
| `cadastro.php` e `processa_cadastro.php` | Exibem e processam o cadastro de usuários. |
| `inserir_obra.php` | Grava obras enviadas pelo modal principal. |
| `atualizar_obra.php` | Atualiza obras diretamente. |
| `excluir_obra.php` | Remove uma obra e sua imagem, quando existente. |
| `solicitar_edicao.php` | Registra os dados propostos em um pedido de edição. |
| `solicitar_exclusao.php` | Registra um pedido do tipo `apagar`. |
| `solicitar_criacao.php` | Registra um pedido do tipo `criar`, sem obra associada. |
| `enviar_contato.php` | Processa o envio de mensagens por SMTP. |

Há também fluxos alternativos em `cadastro_obra.php`, `editar_obra.php`, `editar_obra_form.php`, `obra_card.php` e `aprovar_edicao.php`. Eles apresentam diferenças em relação ao fluxo principal e ao esquema atual do banco, descritas ao final deste README.

## Principais classes e telas C#

| Arquivo | Função |
| --- | --- |
| `Program.cs` | Inicia o aplicativo em `FrmLogin` e cria a pasta local `imagens`, se necessário. |
| `ClassConexao.cs` | Abre e fecha a conexão MySQL. |
| `ClassGeral.cs` | Executa consultas e retorna os resultados em um `DataTable`. |
| `ClassAdicionar.cs` | Centraliza inserção e atualização de obras e criação, atualização e exclusão de usuários. |
| `ClassSessao.cs` | Armazena informações do usuário durante a execução do desktop. |
| `FrmLogin.cs` | Realiza a autenticação. |
| `FrmMenu.cs` | Controla a navegação entre as telas. |
| `FrmObras.cs` | Exibe a lista de obras. |
| `FrmInserir.cs` | Cadastra obras e permite escolher uma imagem local. |
| `FrmEditar.cs` | Carrega e atualiza os dados de uma obra selecionada. |
| `FrmContas.cs` | Gerencia contas e níveis de acesso. |
| `FrmPedidos.cs` | Consulta, aprova e rejeita solicitações. |
| `FrmUsuario.cs` | Formulário com inicialização básica, sem lógica de gestão adicional implementada no arquivo. |

Os arquivos `.Designer.cs` definem os controles e eventos das telas; os `.resx` armazenam seus recursos. Eles devem acompanhar os formulários ao transferir o projeto.

## Banco de dados

Nome utilizado: **`obrasdacidade`**.

| Tabela | Dados armazenados |
| --- | --- |
| `tab_obras` | Nome, descrição, prazo, localização, imagem e status das obras. |
| `tab_status` | Classificações das obras. |
| `tab_usuarios` | Usuário, senha, nível de acesso, data de criação, e-mail e telefone. |
| `tab_acesso` | Perfis `ADM` e `USER`. |
| `tab_pedidos` | Solicitante, obra, tipo de pedido, alterações propostas, data e situação. |

### Status e perfis

| Categoria | Código | Significado |
| --- | --- | --- |
| Status da obra | `1` | Em andamento |
| Status da obra | `2` | Planejada |
| Status da obra | `3` | Concluída |
| Perfil | `1` | ADM |
| Perfil | `2` | USER |

Os tipos de pedido são `criar`, `editar` e `apagar`. A situação de um pedido pode ser `pendente`, `aprovado` ou `negado`.

## Fluxo de solicitações entre o site e o desktop

1. Um usuário comum, de nível `2`, solicita edição ou exclusão pelo site.
2. O PHP registra o pedido em `tab_pedidos`, inicialmente como `pendente`.
3. A tela `FrmPedidos` do desktop consulta os pedidos pendentes.
4. Ao aprovar, o C# aplica a ação em `tab_obras` e marca o pedido como `aprovado`, dentro de uma transação. Ao rejeitar, marca como `negado` sem aplicar as alterações à obra.
5. Ao recarregar o site, a consulta ao banco apresenta os dados atualizados.

A aprovação também aceita pedidos do tipo `criar`. Entretanto, o botão “Nova Obra” do site atual envia para `inserir_obra.php` e cadastra diretamente; ele não utiliza `solicitar_criacao.php`.

## Como executar

### 1. Preparar o banco

1. Inicie um servidor MySQL ou MariaDB.
2. Crie uma base chamada `obrasdacidade`.
3. Selecione essa base no gerenciador do banco e importe `obrasdacidade (7).sql`.

O SQL contém dados além da estrutura. Para publicar o repositório, prepare uma cópia com dados fictícios e sem credenciais de usuários.

### 2. Configurar a aplicação web

É necessário um servidor com PHP, MySQLi e suporte a `get_result()` por meio do mysqlnd. O cabeçalho do SQL registra uma exportação em ambiente com PHP 8.0.30 e MariaDB 10.4.32; essas versões são uma referência do ambiente original, não uma compatibilidade validada nesta análise.

1. Copie a pasta `Projeto_obra_cidade` para a pasta pública do servidor. Em uma instalação padrão do XAMPP no Windows, o caminho será:

   ```text
   C:\xampp\htdocs\Projeto_obra_cidade\
   ```

2. Ajuste `$host`, `$user`, `$password` e `$database` em `conn.php` conforme seu ambiente.
3. Preserve as pastas `img` e `uploads` e permita que o PHP grave em `uploads`.
4. Inicie o servidor web e acesse:

   ```text
   http://localhost/Projeto_obra_cidade/index.php
   ```

5. Para acessar áreas autenticadas, use uma conta de teste do banco configurado. Consulte as observações sobre o cadastro web ao final deste documento.

Bootstrap e Font Awesome são carregados por CDN e dependem de conexão com a internet. Os arquivos PHP devem ser acessados pelo servidor, não abertos diretamente como arquivos no navegador.

### 3. Configurar a aplicação desktop

Requisitos: Windows, Visual Studio com ferramentas de desenvolvimento para desktop .NET e suporte ao **.NET Framework 4.7.2**.

1. Abra `Obrasdacidade/Obrasdacidade.sln` no Visual Studio.
2. Restaure os pacotes NuGet definidos em `packages.config`, caso necessário.
3. Em `ClassConexao.cs`, ajuste a string de conexão, especialmente `Server`, `Database`, `Uid` e `Pwd`.
4. Use o mesmo servidor e banco configurados no PHP.
5. Compile a solução e execute o projeto `Obrasdacidade`.
6. Entre com uma conta de teste existente em `tab_usuarios`.

Se o PHP e o desktop estiverem em computadores diferentes, `localhost` aponta para cada computador individualmente. Configure o endereço do servidor de banco correspondente nas duas aplicações.

### 4. Imagens compartilhadas

O site utiliza `Projeto_obra_cidade/uploads/`. Já o desktop copia e procura imagens na pasta `imagens` do seu diretório de execução. O banco armazena o nome do arquivo, e **não há sincronização automática dessas pastas no código**.

Para visualizar a mesma imagem nos dois módulos, mantenha o arquivo com o mesmo nome nas duas pastas ou implemente um armazenamento compartilhado. Aprovar uma imagem pelo desktop atualiza seu nome no banco, mas não transfere o arquivo entre as aplicações.

### 5. Envio de contato, se utilizado

O ZIP inclui PHPMailer, `vendor/autoload.php`, `composer.json` e `composer.lock`. Se precisar restaurar as dependências, execute na pasta web, com o Composer disponível:

```bash
composer install
```

Configure os dados SMTP, remetente e destinatário em `enviar_contato.php`. Os valores atuais são marcadores a preencher. O `index.php` enviado não contém um formulário de contato conectado a esse script.

## Pontos conhecidos para manutenção

A leitura do código identificou alguns pontos que precisam ser alinhados ao retomar o desenvolvimento:

- **Cadastro web:** `processa_cadastro.php` grava nível `0`, enquanto `tab_acesso` contém os níveis `1` e `2`, e não preenche o campo obrigatório `telefone`. Isso pode impedir o cadastro no esquema importado.
- **Permissões:** a interface web diferencia perfis, mas `atualizar_obra.php` não valida autenticação ou nível, e `excluir_obra.php` exige apenas login. No desktop, o login lê o nível, mas não o atribui a `ClassSessao.Nivel` nem restringe as telas administrativas por perfil.
- **Autenticação:** os dois módulos utilizam senhas em texto simples, e a consulta de login C# interpola os valores digitados diretamente no SQL. Para disponibilizar o sistema publicamente, alinhe os dois logins ao uso de hash de senha e consultas parametrizadas.
- **Aprovação PHP alternativa:** `aprovar_edicao.php` usa campos pendentes inexistentes no SQL, verifica uma chave de sessão diferente e redireciona para `admin_pendentes.php`, que não está no ZIP. O fluxo de aprovação compatível com `tab_pedidos` está em `FrmPedidos.cs`.
- **Rotas alternativas de obras:** `cadastro_obra.php` usa a coluna `status` em lugar de `id_status`; os formulários alternativos de edição atualizam diretamente a obra e fixam o status em `1`, apesar da mensagem de aprovação pendente. O trecho final de `inserir_obra.php` menciona `endereco`, ausente do esquema, e `obra_card.php` referencia `detalhes_obra.php`, ausente do ZIP.
- **Prazo no desktop:** `FrmInserir` grava `DateTime.Now` como prazo. A edição em `FrmEditar` utiliza a data escolhida no controle `dtpPrazo`.
- **Arquivos visuais:** o CSS e JavaScript próprios não estão ligados ao `index.php` atual, e as imagens web e desktop usam pastas separadas.

## Aprendizados envolvidos

- Desenvolvimento de front-end e back-end web.
- Interfaces desktop com Windows Forms.
- Integração entre aplicações por banco de dados compartilhado.
- Modelagem relacional e operações de cadastro, consulta, atualização e exclusão.
- Sessões, autenticação e perfis de usuários.
- Upload e manipulação de imagens.
- Fluxos de solicitação, aprovação e rejeição.
- Transações de banco de dados.

---

Documentação baseada na leitura do ZIP do projeto. O site, o banco e a aplicação Windows Forms não foram executados durante esta revisão; as funcionalidades descritas correspondem à implementação encontrada no código.
