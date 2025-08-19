CREATE TABLE IF NOT EXISTS articles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    title VARCHAR(50),
    content TEXT,
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id)
);