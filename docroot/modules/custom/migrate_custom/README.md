# Este módulo é um exemplo de migração de uma fonte não Drupal

# Coloque o seguinte código no settings.php:

Note the key 'migrate' here is important.

$databases['migrate']['default'] = array (
 'database' => 'database_name',
 'username' => 'user',
 'password' => 'pass',
 'prefix' => '',
 'host' => 'localhost',
 'port' => '3306',
 'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
 'driver' => 'mysql',
);


# Drush commands supported include:

migrate-status - Lists migrations and their status.

migrate-import - Performs import operations.

migrate-rollback - Performs rollback operations.

migrate-stop - Cleanly stops a running operation.

migrate-reset-status - Sets a migration status to Idle if it's gotten stuck.

migrate-messages - Lists any messages associated with a migration import.

Examples:

 migrate-import --all                      Perform all migrations      

 migrate-import --group=beer               Import all migrations in the beer group    

 migrate-import --tag=user                 Import all migrations with the user tag

 migrate-import --group=beer --tag=user    Import all migrations in the beer group and with the user tag 

 migrate-import beer_term,beer_node        Import new terms and nodes  

 migrate-import beer_user --limit=2        Import no more than 2 users  

 migrate-import beer_user --idlist=5       Import the user record with source ID 5

Argumentos:

 migration                                 ID of migration(s) to import. Delimit multiple using commas.

Opções:

 --all                                     Process all migrations.   

 --execute-dependencies                    Execute all dependent migrations first. 

 --feedback                                Frequency of progress messages, in items processed    

 --force                                   Force an operation to run, even if all dependencies are not satisfied    

 --group                                   A comma-separated list of migration groups to import      

 --idlist                                  Comma-separated list of IDs to import           

 --limit                                   Limit on the number of items to process in each migration  

 --tag                                     Name of the migration tag to import         

 --update                                   In addition to processing unprocessed items from the source, update previously-imported items with the current data

Aliases: mi


## DICA:

Habilite os módulos "config_update" e "config_update_ui" para registrar as alterações do install .yml


# Comandos para migrar os conteúdos

## Tags:

drush mi custom_tags

## User:

drush mi custom_user

## Files 

drush mi custom_files

## Content

drush mi custom_ct_page


# ESTRUTURA DO EXEMPLO UTILIZADA:

## Data base

create database oldsite;


## Categorias

CREATE TABLE categories (
	cid int,
	name varchar(255),
	description varchar(255)
);

INSERT INTO categories (cid,name,description)
VALUES (1,'educacão','desc educacão');

INSERT INTO categories (cid,name,description)
VALUES (2,'esporte','desc esporte');

INSERT INTO categories (cid,name,description)
VALUES (3,'economia','desc economia');

INSERT INTO categories (cid,name,description)
VALUES (4,'política','desc política');


## Usuários

CREATE TABLE users (
	uid int,
	name varchar(255),
	email varchar(255),
	pass varchar(255),
	login varchar(255)
);

INSERT INTO users (uid,name,email,pass,login)
VALUES (10,'Laura','laura@teste.com','123','laura');

INSERT INTO users (uid,name,email,pass,login)
VALUES (11,'Carol','carol@teste.com','1234','carol');


## Arquivos

CREATE TABLE files (
	fid int,
	file_name varchar(255),
	file_filepath varchar(255)
);

INSERT INTO files (fid,file_name,file_filepath) 
VALUES (18,'teste.jpg','sites/default/files/teste.jpg');


## Conteúdo

CREATE TABLE content (
	con_id int,
	title varchar(255),
	body varchar(255),
	status int,
	autor int
);

INSERT INTO content (con_id,title,body,status,autor) 
VALUES (1,'Teste Import 1','Corpo teste import',1,10);

## Tabela de relacionamento de files e content

CREATE TABLE content_files (
	id int,
	con_id int,
	fid int
);

INSERT INTO content_files (id,con_id,fid) 
VALUES (1,1,18);


## Tabela de relacionamento de categorias e content

CREATE TABLE content_cat (
	id int,
	con_id int,
	cid int
);

INSERT INTO content_cat (id,con_id,cid) 
VALUES (1,1,4);

INSERT INTO content_cat (id,con_id,cid) 
VALUES (2,1,3);

## EXERCÍCIO

Migrar os conteúdos da tabela abaixo para o tipo de conteúdo "page":

CREATE TABLE page (
	pid int,
	titulo varchar(255),
	content varchar(255),
	published int,
	user int
);

INSERT INTO page (pid,titulo,content,published,user) 
VALUES (1,'Page import test 1','Corpo teste import',1,10);

INSERT INTO page (pid,titulo,content,published,user) 
VALUES (2,'Page import test 2','Corpo teste import',0,11);