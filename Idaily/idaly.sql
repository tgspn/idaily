CREATE DATABASE idaily;
USE idaily;

CREATE TABLE papel
(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(1000)
);

CREATE TABLE usuario
(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    papel_id INT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(100) NOT NULL,
	FOREIGN KEY (papel_id) REFERENCES papel(id)
);

CREATE TABLE diaria_tipo
(
	  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL UNIQUE,
    descricao VARCHAR(1000),
    valor DECIMAL(10,2) 
);

CREATE TABLE diaria
(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    diaria_tipo_id INT NOT NULL,
    solicitante_id INT NOT NULL,
    quantidade INT NOT NULL,
    data_criacao DATETIME DEFAULT NOW(),    
    status VARCHAR(1),
    pedido VARCHAR(1000),
    FOREIGN KEY (diaria_tipo_id) REFERENCES diaria_tipo(id),
    FOREIGN KEY (solicitante_id) REFERENCES usuario(id)
);

CREATE TABLE situacao
(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    situacao VARCHAR(100) NOT NULL
);

CREATE TABLE diaria_situacao
(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    situacao_id INT NOT NULL,
    diaria_id INT NOT NULL,
    usuario_id INT NOT NULL,
    data_criacao DATETIME NOT NULL DEFAULT NOW(),
    observacao VARCHAR(1000),
    
    FOREIGN KEY (situacao_id) REFERENCES situacao(id),
    FOREIGN KEY(diaria_id) REFERENCES diaria(id),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
    
);

INSERT INTO papel(nome,descricao)VALUES('admin','Administrador do sistema');

INSERT INTO papel(nome,descricao)VALUES('Auditor','Responsável por executar auditorias no sistema');
INSERT INTO papel(nome,descricao)VALUES('Aprovador','Responsável por aprovar as diárias');
INSERT INTO papel(nome,descricao)VALUES('Solicitante','Usuário comum que faz a solicitação das diárias');

INSERT INTO usuario(papel_id,nome,usuario,senha)VALUES(1,'Administrador','admin',md5('123'));

INSERT INTO situacao(situacao) VALUES("Aguardando");
INSERT INTO situacao(situacao) VALUES("Aprovado");
INSERT INTO situacao(situacao) VALUES("Pago");


DELIMITER $

CREATE TRIGGER tgr_diaria_situacao_insert AFTER INSERT
ON diaria
FOR EACH ROW
BEGIN
	INSERT INTO diaria_situacao (situacao_id,diaria_id,usuario_id) VALUES(1,NEW.id,NEW.solicitante_id);
END$

DELIMITER ;

CREATE VIEW view_diaria_situacao
AS
  select ds.id, ds.data_criacao as data_situacao,ds.observacao, situacao_id, situacao, usuario_id, us.nome as usuario, solicitante_id, diaria_id, so.nome as solicitante, quantidade, di.data_criacao as data_pedido, di.status, pedido
  from diaria_situacao ds
    inner join situacao si on si.id=situacao_id
    inner join diaria di on di.id=diaria_id
    inner join usuario us on us.id=usuario_id
    inner join usuario so on so.id=solicitante_id
    inner join diaria_tipo dt on dt.id=di.diaria_tipo_id