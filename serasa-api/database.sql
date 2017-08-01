CREATE TABLE `winners` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL,
  `winnerName` varchar(255) NOT NULL,
  `winnerEmail` varchar(100) NOT NULL,
  `winnerCpf` varchar(11) NOT NULL,
  `winnerCity` varchar(50) NOT NULL,
  `winnerState` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

INSERT INTO winners VALUES(NULL, 1, 'Luiza', 'luiza@teste.com.br', '11122233344', 'Bauru', 'SP', NULL, NULL);
INSERT INTO winners VALUES(NULL, 1, 'Bruno', 'bruno@teste.com.br', '55566677788', 'Campinas', 'SP', NULL, NULL);

CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `apikey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

INSERT INTO users VALUES(NULL, 'teste', '698dc19d489c4e4db73e28a713eab07b', 'anderson.com@gmail.com', 'aacba679caf6b32ae486698c44ff7d19');


