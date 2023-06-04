<?php
    session_start();

    require_once('PDO_connect.php');
    require_once('model.php');
    require_once('controller.php');

    data_remove($pdo);
?>

<!DOCTYPE html>

<html>
    <head><title>Kasimov Viacheslav</title></head>
    <body>
        <div>
            <h1>Deleteing Profile</h1>
            <p>
                First Name: <?= get_row($pdo)['first_name'] ?>
            </p>
            <p>
                Last Name: <?= get_row($pdo)['last_name'] ?>
            </p>
        </div>
        <form method="post">
            <?='<input type="hidden" name="profile_id" value="'.htmlentities($_GET['profile_id']).'">'?>
            <input type="submit" value="Delete" name="delete">
            <a href="index.php">Cancel</a>
        </form>
    </body>
</html>