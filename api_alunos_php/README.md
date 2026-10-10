# API de alunos em PHP — XAMPP

Estes arquivos usam os nomes reais das tabelas e colunas do `bd_escola.sql` fornecido.

## 1. Instalar no XAMPP
1. Inicie **Apache** e **MySQL** no painel do XAMPP.
2. No phpMyAdmin, confirme que o banco `bd_escola` foi importado.
3. Copie a pasta `api_alunos_php` para `C:\xampp\htdocs\`.
4. Confira `conexao.php`. O padrão é usuário `root` sem senha, como na instalação comum do XAMPP. Se configurou uma senha, atualize `$senha`.
5. Abra `http://localhost/api_alunos_php/teste_conexao.php`. A resposta deve conter `"sucesso":true`.

## 2. Endpoints
- `GET http://localhost/api_alunos_php/alunos.php` — lista alunos.
- `GET http://localhost/api_alunos_php/alunos.php?id=1` — consulta um aluno pelo ID.
- `POST http://localhost/api_alunos_php/cadastrar_aluno.php` — cadastra aluno.
- `PUT http://localhost/api_alunos_php/editar_aluno.php` — edita aluno; envie `idAlunos` no JSON.
- `GET http://localhost/api_alunos_php/ruas.php` — lista IDs e nomes de ruas para preencher `idRuas`.

### JSON para cadastrar (POST) e editar (PUT)
```json
{
  "nome": "Maria da Silva",
  "dataNascimento": "2008-04-23",
  "idRuas": 1,
  "cpf": "12345678901",
  "email": "maria@example.com",
  "telefone": "12987654321"
}
```
Para editar, inclua também `"idAlunos": 1`.
A data deve estar no formato `AAAA-MM-DD`. `idRuas` precisa existir na tabela `ruas`; consulte `ruas.php` antes de usar um ID.

## 3. Testar a partir do React Native
O emulador Android normalmente acessa o computador por `http://10.0.2.2`; o caminho do endpoint será, por exemplo:
`http://10.0.2.2/api_alunos_php/cadastrar_aluno.php`

Em celular físico, use o IP local do computador (por exemplo `http://192.168.1.10/api_alunos_php/...`) e mantenha o computador e o celular na mesma rede. Não use `localhost` no celular, pois ele aponta para o próprio celular.

**Importante:** o `App.js` original ainda chama uma API Node em `http://10.0.2.2:3000/api/alunos`. Esses PHPs ficam prontos para uso, mas o `App.js` precisa apontar para os URLs acima e ter telas/ações de consulta e edição para que essas funções apareçam no aplicativo. O SQL enviado não contém campos de endereço textual no aluno: o cadastro recebe `idRuas`, que deve corresponder a uma rua já cadastrada.
