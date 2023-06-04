<!DOCTYPE html>

<?php
    session_start();
    require_once('PDO_connect.php');
    require_once('model.php');
    require_once('controller.php');
    $err_msg = print_err();
?>

<html>
    <head>
        <title>Kasimov Viacheslav</title>
    </head>
    <body> 
        <h1>
            Viacheslav Kasimov's Resume Registry
        </h1>
        <?= $err_msg ?>
        <?= generate_html_index($pdo) ?>

    </body>
</html>