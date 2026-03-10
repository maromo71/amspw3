create database todo;

use todo;

create table tarefas(
	id INT auto_increment primary key,
    titulo varchar(255) not null,
    status ENUM('pendente', 'concluida') default 'pendente'
);