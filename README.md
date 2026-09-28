# APP Scholar

## Sobre o projeto
O projeto consiste na criação de um aplicativo de cadastro, consulta e edição de dados de docentes e estudantes de uma escola.

## Funcionalidades
- Cadastro de alunos, responsáveis, professores, coordenadores, matrículas, turmas, disciplinas, avaliações, boletins;
- Consulta de alunos, responsáveis, professores, coordenadores, matrículas, turmas, disciplinas, avaliações, boletins;
- Atualização de informações já inseridas no banco de dados do app;
- Navegação entre as principais telas;
- Exclusão de registros.

## Tecnologias Utilizadas
- React Native;
- JavaScript;
- GitHub;
- MySQL;
- PHP;
- CSS.

## Estrutura do Projeto
A pasta principal do aplicativo, sendo a que contêm todo o código do APP Scholar é a pasta `App.js`, nela está todo o código mais recente no momento, onde estão feitos a tela principal do app, o botão de sobre (que tem uma breve descrição do aplicativo e para quê ele serve), esse arquivo está na pasta principal 'app-scholar snack', mais específicamente na pasta 'components' dentro dela. A logo do app (logo.png) está localizado na segunda pasta dentro da principal, sendo ela a pasta 'assets'. A pasta 'app_scholar_api-derick' é onde se encontram as conexões para fazer o cadastro, consulta e edição funcionarem. Além de um arquivo de código que possibilita a conexão do app com o banco de dados na rede localhost. O arquivo 'bd_escola.sql' é o código do banco de dados do app, ele é de extrema importância para que o app funcione corretamente.

## Como Executar
Primeiro, baixe o zip das pastas 'app-scholar snack' e 'app_scholar_api-derick'. Em seguida descompacte os arquivos e ligue apache e MySQL no XAMPP, coloque toda a api na pasta php do seu XAMPP e depois importe o código do app no Snack Expo ou VSCode para poder visualizar e interagir com a tela principal do APP.

## Autor
Derick Campos Silva
