CREATE TABLE `user`(
  id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(30),
  passwordHash VARCHAR(255),
  sessionHash VARCHAR(255),
  balance DECIMAL(10,2) DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO `user`
    (`username`, `passwordHash`, `balance`)
VALUES
    ('user', '$2y$10$pviYNrCqGfpLP0sDJ6tH5OVMNYMsNyBFX4YEVypGoc5cr1GaDrKQe', 100.00);