<?php

require dirname(__DIR__, 2) . '/bootstrap.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
    $conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);

    $users_table = file_get_contents(dirname(__DIR__, 1) . '/database/tables/users.sql');

    $conn->query($users_table);

    echo "Tabela users criada com sucesso.";

}catch(Exception $e){
    die('Erro ao realizar as migrations: ' . $e->getMessage());
}