-- Usuário admin
INSERT INTO users (name, email, password)
VALUES (
    'admin', 
    'admin@gmail.com', 
    '$2y$10$wHj5b/2b8hYqJd6ExY4FQeQ0f7rC1vZFrRIXYjFp7eqZ9HjM1nQv6'
    -- Hash para 'OSJDIJHQ)@e9eu09ufa09u2ehqhf08eufs80erh3w98hf89q03h4'
);

-- Artigo inicial
INSERT INTO articles (user_id, title, content, created_at)
VALUES (
    1,
    'First notice',
    'Lorem ipsum dolor sit amet',
    NOW()
);

-- Token de acesso inicial
INSERT INTO access_tokens (user_id, token, expiration)
VALUES (
    1, 
    'JDIAJWDIAIWJDOAJWDJWAOIJEiej2jjjfaj0jadjwa', 
    DATE_ADD(NOW(), INTERVAL 1 HOUR)
);
