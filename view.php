<?php
    session_start();

    require_once('PDO_connect.php');
    require_once('model.php');
    require_once('controller.php');
?>

<!DOCTYPE html>

<html>
    <head><title>Kasimov Viacheslav</title></head>
    <body>
        <div>
            <h1>Profile information</h1>
            <div>
                <?=profile_info($pdo)?>
            </div>
            <a href="index.php">Done</a>
        </div>
    </body>
</html>