
# Obras da Cidade

Projeto integrador que desenvolvi para acompanhar e gerenciar obras da cidade. Tem um site em PHP, com front-end em HTML, CSS e JavaScript, e um programa em C# com Windows Forms. Os dois usam o mesmo banco MySQL/MariaDB.

No site, é possível consultar obras planejadas, em andamento e concluídas, além de enviar pedidos de edição ou exclusão. No programa desktop, é possível gerenciar obras e usuários e aprovar ou rejeitar esses pedidos.

## Funcionalidades

- Consulta de obras com descrição, imagem, prazo e localização.
- Cadastro e login de usuários.
- Cadastro e edição de obras.
- Envio de solicitações pelo site e aprovação pelo desktop.
- Gerenciamento de contas no programa em C#.

## Tecnologias

- **Web:** PHP, HTML, CSS, JavaScript e Bootstrap.
- **Desktop:** C#, Windows Forms e .NET Framework 4.7.2.
- **Banco de dados:** MySQL/MariaDB, acessado pelo PHP com MySQLi e pelo C# com MySql.Data.

## Arquivos principais

| Caminho | Conteúdo |
| --- | --- |
| `Projeto_obra_cidade/` | Arquivos do site. |
| `Obrasdacidade/Obrasdacidade.sln` | Solução C# para abrir no Visual Studio. |
| `obrasdacidade (7).sql` | Estrutura e dados do banco. |

As conexões ficam em `conn.php`, no site, e `ClassConexao.cs`, no desktop. Os pedidos são salvos em `tab_pedidos` e processados pela tela `FrmPedidos`.

## Como executar

### Site

1. No XAMPP, inicie o Apache e o MySQL.
2. Coloque a pasta `Projeto_obra_cidade` dentro de `htdocs`.
3. No phpMyAdmin, crie o banco `obrasdacidade` e importe `obrasdacidade (7).sql`.
4. Ajuste os dados de conexão em `conn.php`.
5. Abra `http://localhost/Projeto_obra_cidade/index.php` no navegador.

Se o Apache estiver na porta **8080**, use `http://localhost:8080/Projeto_obra_cidade/index.php`.

### Desktop

1. Abra `Obrasdacidade.sln` no Visual Studio, com suporte a Windows Forms e .NET Framework 4.7.2.
2. Restaure os pacotes NuGet, se necessário.
3. Ajuste `ClassConexao.cs` para acessar o mesmo banco do site.
4. Compile e execute o projeto.

## Observações

As imagens do site ficam em `uploads/`, e as do desktop ficam em `imagens/`, no diretório de execução. Essas pastas não são sincronizadas automaticamente.

O projeto ainda tem ajustes pendentes no cadastro, nas permissões e no armazenamento de senhas. Foi desenvolvido para estudo e precisa dessas revisões antes de ser disponibilizado publicamente.
