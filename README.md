# testeVaga

passos para configurar e abir a aplicação

1. baixar o xampp (https://www.apachefriends.org/pt_br/download.html)
2. após baixar e instalar, abra o aplicativo e de start no Apache e no MySQL
3. abra o admin na opção do MySQL, ele irá abrir o navegador no endereço http://localhost/phpmyadmin/
4. no phpmyadmin, clique em novo e crie uma nova base de dados com o nome de cadastrovagas
5. clique na base de dados criada e vá em SQL, execute os SQL a seguir:


CREATE TABLE vaga(
id int AUTO_INCREMENT,
nomevaga varchar(255) NOT NULL,
descricao varchar(255),
PRIMARY KEY (id)
);

CREATE TABLE candidato(
idcandidato int AUTO_INCREMENT,
nomecandidato varchar(255) NOT NULL,
cep int,
vagadeinteresse varchar(255),
PRIMARY KEY (idcandidato)
);

6.baixe o projeto do git e coloque na pasta onde o xampp foi instalado xampp\htdocs\testeVaga
7.abra o navegador e digite http://localhost/testeVaga/teste.php
8.pronto, agora é só executar a aplicação.
