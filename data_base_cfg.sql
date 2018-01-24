CREATE SCHEMA `db_amcom` DEFAULT CHARACTER SET utf8 ;

CREATE TABLE `db_amcom`.`tb_drivers` (
  `id_driver` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NOT NULL,
  `age` INT NOT NULL,
  `city` VARCHAR(250) NOT NULL,
  `country` VARCHAR(250) NOT NULL,
  `creation_date` DATETIME NULL,
  `alteration_date` DATETIME NULL,
  PRIMARY KEY (`id_driver`))
COMMENT = 'Tabela que contém os motoristas cadastrados.';

INSERT INTO `db_amcom`.`tb_drivers` (`name`, `age`, `city`, `country`, `creation_date`) VALUES ('John Smith', '32', 'Oklahoma', 'USA', '2017-11-18 11:26:00');
INSERT INTO `db_amcom`.`tb_drivers` (`name`, `age`, `city`, `country`, `creation_date`) VALUES ('David York', '44', 'New York City', 'USA', '2017-11-16 22:00:00');

CREATE TABLE `db_amcom`.`tb_auth` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NOT NULL,
  `email` VARCHAR(250) NOT NULL,
  `pass` CHAR(32) NOT NULL,
  PRIMARY KEY (`id_user`))
COMMENT = 'Tabela de usuários autenticados que podem acessar a API.';

INSERT INTO `db_amcom`.`tb_auth` (`name`, `email`, `pass`) VALUES ('Diego', 'diegosimas@gmail.com', 'c6222e6abd860774f571883e317fbb7c');
