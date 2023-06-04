<!DOCTYPE html>

<?php
    session_start();
    require_once('PDO_connect.php');
    require_once('model.php');
    require_once('controller.php');
    $err_msg=print_err();
    login($pdo);
?>

<html>
    <head>
        <title>Kasimov Viacheslav</title>
        <script src=email-validation.js></script>
    </head>
    <body>
        <h1>Please log in</h1>
        <?= $err_msg ?>
        <!-- <?= isset(($pdo->query("select password from users where email = 'umsi@umich.edu'"))->fetch(PDO::FETCH_ASSOC)['password'])?> -->
        <form method="post">
            <div>
                <span>Email </span>
                <input type="text" name="email" id="email" size="40">
            </div>
            <div>
                <span>Password </span>
                <input type="password" name="pass" id="pass" size="40">
            </div>
            <div>
                <input type="submit" name="dopost" id="dopost" onclick="return doValidate();" value="Log In">
                <input type="button" name="escape" onclick="location.href='/index.php'; return false;" value="Cancel">
            </div>
        </form>
    </body>
</html>