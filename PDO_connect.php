<?php

#connecting to database
$pdo = new PDO(
    'mysql:host=localhost; port=3306; dbname=php_js_asg',
    'user',
    'inspiron'
);

#Setting errormode to exception so web application will die if error occurred
$pdo->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);

?>