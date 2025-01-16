CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE users_infos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    bio TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE users_connexions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    last_login DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO users (username, email, password) VALUES
('Ruchita', 'ruchita@example.com', 'password1'),
('Max', 'max@example.com', 'password2'),
('Yoan', 'yoan@example.com', 'password3');

INSERT INTO users_infos (user_id, bio) VALUES
(1, 'Je suis Ruchita, développeuse web.'),
(2, 'Max, passionné par le cloud computing.'),
(3, 'Yoan, adepte du devops.');