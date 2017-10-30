create database `test_thideoli`;

create table `test_thideoli`.`books` (
  `id` int not null auto_increment,
  `title` varchar(255) not null,
  `author` varchar(255) not null,
  `publishing_company` varchar(255) not null,
  `pages` varchar(255) not null,
  `inserted_in` datetime not null,
  `changed_in` datetime null,
  primary key (`id`)
);

use `test_thideoli`;
insert into `books` (`title`, `author`, `publishing_company`, `pages`, `inserted_in`)
         VALUES('Como ser um programador melhor', 'Pete Goodliffe', 'Novatec', 384, now());