# A tarefa
Sua tarefa consiste em desenvolver uma API RESTful para manipular um determinado recurso. Deverá ser utilizado o framework Silex.

# Requisitos
A escolha do recurso deverá ser feita pelo desenvolvedor, atendendo apenas os requisitos mínimos abaixo:

* OK - Deverá conter um ID
* OK - Deverá conter pelo menos quatro propriedades (exemplos: nome, email, etc.)
* OK - Deverá conter campos que armazenem as datas de criação e alteração do recurso

A API deverá atender às seguintes exigências:

* OK - Listagem de todos os recursos
* OK - Busca de um recurso pelo ID
* OK - Criação de um novo recurso
* OK - Alteração de um recurso existente
* OK - Exclusão de um recurso
* OK - Aceitar e retornar apenas JSON
* OK - Deverá possuir algum método de autenticação para utilização de seus endpoints

# Ferramentas
* PHP
* Banco de dados MySQL
* Framework Silex

# Fluxo de desenvolvimento
1. Faça um fork deste repositório
2. Crie uma nova branch e nomeie-a com seu usuário do Github
3. Quando o desenvolvimento estiver concluído, faça um pull request

# Padrões de nomenclatura
1. Código fonte, nome do banco de dados, tabelas e campos devem estar em inglês

**Inclua no seu commit todos os arquivos necessários para que possamos testar o código.**


# Implementação


# Endpoints públicos
* GET api/v1/users
** Obter lista com todos usuários
* GET api/v1/users/{id}
** Obter usuário específico
* POST api/v1/users
** Incluir novo usuário
* PUT api/v1/users
** Alterar usuário
* DELETE api/v1/users/{id}
** Excluir usuário
* POST auth
** Obter token de acesso

# Endpoints privados
* GET api/v1/contacts
** Obter lista com todos contatos
* GET api/v1/contacts/{id}
** Obter contato específico
* POST api/v1/contacts
** Incluir novo contato
* PUT api/v1/contacts
** Alterar contato
* DELETE api/v1/contacts/{id}
** Excluir contato

# Criar banco de dados
```
CREATE DATABASE IF NOT EXISTS `test_rest` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `test_rest`;

DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id_contact` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `info` text,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `contact`
  ADD PRIMARY KEY (`id_contact`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

ALTER TABLE `contact`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;
```

# Executar aplicação

```
# git clone https://github.com/VagnerFP/teste.git

# cd teste/

#  composer install

# php -S localhost:8000 -t ./

```

# Testar aplicação

* Ferramenta
** Postman (https://www.getpostman.com/).
*** Arquivo com as requisições para o Postman (TesteRest.postman_collection.json)