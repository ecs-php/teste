CREATE TABLE `users` (
 `id` int(10) PRIMARY KEY  NOT NULL AUTO_INCREMENT,
 `username` varchar(32) NOT NULL,
 `password` varchar(64) NOT NULL,
 `email` varchar(50) NOT NULL,
 `profile_icon` varchar(255) NOT NULL,
 `apikey` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


INSERT INTO `users` (`id`, `username`, `password`, `email`, `profile_icon`, `apikey`) VALUES
(1, 'user1', '000c285457fc971f862a79b786476c78812c8897063c6fa9c045f579a3b2d63f', 'user1@example.com', 'user1.jpg', 'd0763edaa9d9bd2a9516280e9044d885'),
(2, 'user2', '4d6b96d1e8f9bfcd28169bafe2e17da6e1a95f71e8ca6196d3affb4f95ca809f', 'user2@example.com', 'user2.jpg', 'd0763edaa9d9bd2a9516280e9044d885'),
(3, 'user3', '81ba24935dd9a720826155382938610f1b74ba226e85a7b4ca2ad58cf06664fa', 'user3@example.com', 'user3.jpg', 'd0763edaa9d9bd2a9516280e9044d885'),
(4, 'user4', 'ef1b839067281c41a6abdf36ff2346700f9cd5f17d8d4e486be9e81c67779258', 'user4@example.com', 'user4.jpg', 'd0763edaa9d9bd2a9516280e9044d885');

CREATE TABLE `tasks` (
 `id` int(10) PRIMARY KEY  NOT NULL AUTO_INCREMENT,
 `title` varchar(255) NOT NULL,
 `description` varchar(255) NOT NULL,
 `estimation_time` time NULL,
 `development_time` time NULL,
 `priority` varchar(10) NOT NULL,
 `created_at` datetime NOT NULL,
 `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `tasks` (`title`, `description`, `estimation_time`, `development_time`, `priority`, `created_at`, `updated_at`) VALUES
('Task 1', 'Description 1', '01:00:00', null, 'low',NOW(),NOW()),
('Task 2', 'Description 2', '01:30:00', null, 'low',NOW(),NOW()),
('Task 3', 'Description 3', '02:00:00', '01:48:00', 'mid',NOW(),NOW()),
('Task 4', 'Description 4', '02:20:00', '02:40:00', 'high',NOW(),NOW());