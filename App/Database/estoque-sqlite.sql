begin;
/*create database estoque;*/
use estoque;
create table produto(id integer primary key not null,
descricao text,
estoque float,
preco_custo float,
preco_venda float,
codigo_barra text,
data_cadastro date,
origem char(1)
);
commit;