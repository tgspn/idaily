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
    descricao VARCHAR(1000)
);

CREATE TABLE diaria
(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    diaria_tipo_id INT NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    data_criacao DATETIME DEFAULT NOW(),    
    status VARCHAR(1),
    pedido VARCHAR(1000),
    FOREIGN KEY (diaria_tipo_id) REFERENCES diaria_tipo(id)
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
    
    FOREIGN KEY (situacao_id) REFERENCES situacao(id),
    FOREIGN KEY(diaria_id) REFERENCES diaria(id),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
    
)
