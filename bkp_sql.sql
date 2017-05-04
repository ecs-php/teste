BEGIN TRANSACTION;
CREATE TABLE "user" (
	`user_id`	INTEGER PRIMARY KEY AUTOINCREMENT,
	`login`	TEXT,
	`password`	TEXT,
	`create_at`	NUMERIC,
	`update_at`	NUMERIC
);
CREATE TABLE `product` (
	`product_id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`name`	TEXT NOT NULL,
	`description`	BLOB NOT NULL,
	`price`	REAL DEFAULT '0.00',
	`category`	TEXT,
	`create_at`	NUMERIC,
	`update_at`	NUMERIC
);
CREATE TABLE `api_key` (
	`api_key_id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`user_id`	INTEGER,
	`key`	TEXT NOT NULL,
	`create_at`	NUMERIC NOT NULL,
	`expire_at`	NUMERIC NOT NULL,
 	FOREIGN KEY(user_id) REFERENCES user(user_id)
);
COMMIT;
