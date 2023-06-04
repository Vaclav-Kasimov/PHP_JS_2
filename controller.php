<?php
function login($pdo){
        $salt = 'XyZzy12*_';
        if  (isset($_POST['dopost']) && $_POST['dopost'] == "Log In"){
            unset($_SESSION['name']); //Если каким-то образом есть информация о залогиненном пользователе, выходим из аккаунта
            $statement = $pdo->query("select * from users where email = '".$_POST['email']."'");
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            print(print_r($row));
            if (isset($row['password'])){
                if  (hash('md5', $salt.htmlentities($_POST['pass'])) != $row['password']){
                    $_SESSION['error'] = 'Incorrect password';
                    error_log("Login fail ".$_POST['email'].' '.hash('md5', $salt.htmlentities($_POST['pass'])));
                    header('Location: login.php');
                    return;
                }   else    {
                    $_SESSION['name'] = $_POST['email'];
                    $_SESSION['user_id'] = $row['user_id'];
                    header("Location: index.php");
                    error_log("Login success ".$_SESSION['email']);
                    return;
                }
            }else{
                $_SESSION['error'] = 'Incorrect email';
                    error_log("Login fail ".$_POST['email'].' '.hash('md5', $salt.htmlentities($_POST['pass'])));
                    header('Location: login.php');
                    return;
            }
        }
    }


    function validatePos() {
        for($i=1; $i<=9; $i++) {
            if ( ! isset($_POST['year'.$i]) ) continue;
            if ( ! isset($_POST['desc'.$i]) ) continue;
            $year = $_POST['year'.$i];
            $desc = $_POST['desc'.$i];
            if ( strlen($year) == 0 || strlen($desc) == 0 ) {
                return "All fields are required";
            }
    
            if ( ! is_numeric($year) ) {
                return "Position year must be numeric";
            }
        }
        return true;
    }

function data_insert($pdo){
    if (isset($_POST['dopost'])){
        if (error_handler_insert_edit()){
            header('Location: '.$_SERVER['PHP_SELF']);
            return;
        }
        else{
            $stmt = $pdo->prepare('INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary)VALUES ( :uid, :fn, :ln, :em, :he, :su)');
            $stmt->execute(array(
                ':uid' => $_SESSION['user_id'],
                ':fn' => htmlentities($_POST['first_name']),
                ':ln' => htmlentities($_POST['last_name']),
                ':em' => htmlentities($_POST['email']),
                ':he' => htmlentities($_POST['headline']),
                ':su' => htmlentities($_POST['summary']))
            );
            $profile_id = $pdo->lastInsertId();
            $rank = 1;
            for($i=1; $i<=9; $i++) {
                if (isset($_POST['year'.$i]) && isset($_POST['desc'.$i])) {
                    $stmt = $pdo->prepare('INSERT INTO Position
                        (profile_id, `rank`, year, description) 
                    VALUES ( :pid, :rank, :year, :desc)');
                    $stmt->execute(array(
                        ':pid' => $profile_id,
                        ':rank' => $rank,
                        ':year' => $_POST['year'.$i],
                        ':desc' => $_POST['desc'.$i])
                    );
                    $rank++;
                }
            }
            header('location: index.php');
            $_SESSION['success'] = 'Record added';
            return;
        }
    }
}

function data_edit($pdo){
    if (isset($_POST['dopost'])){
        if (error_handler_insert_edit()){
            header('Location: '.$_SERVER['PHP_SELF']);
            return;
        }
        else{
            $stmt = $pdo->prepare('UPDATE Profile SET first_name = :fn, last_name = :ln, email = :em, headline = :he, summary = :su WHERE profile_id = :id');
            $stmt->execute(array(
                ':id' => $_GET['profile_id'],
                ':fn' => htmlentities($_POST['first_name']),
                ':ln' => htmlentities($_POST['last_name']),
                ':em' => htmlentities($_POST['email']),
                ':he' => htmlentities($_POST['headline']),
                ':su' => htmlentities($_POST['summary']))
            );
            $profile_id = $_GET['profile_id'];

            $stmt = $pdo->prepare('DELETE FROM Position
                WHERE profile_id=:pid');
            $stmt->execute(array( ':pid' => $_REQUEST['profile_id']));

            
            $rank = 1;
            for($i=1; $i<=9; $i++) {
                if (isset($_POST['year'.$i]) && isset($_POST['desc'.$i])) {
                    $stmt = $pdo->prepare('INSERT INTO Position
                        (profile_id, `rank`, year, description) 
                    VALUES ( :pid, :rank, :year, :desc)');
                    $stmt->execute(array(
                        ':pid' => $profile_id,
                        ':rank' => $rank,
                        ':year' => $_POST['year'.$i],
                        ':desc' => $_POST['desc'.$i])
                    );
                    $rank++;
                }
            }

            header('location: index.php');
            $_SESSION['success'] = 'Profile updated';
            return;
        }
    }
}

function data_remove($pdo){
    if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
        $sql = "DELETE FROM Profile WHERE profile_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => $_POST['profile_id']));
        $_SESSION['success'] = 'Record deleted';
        header( 'Location: index.php' ) ;
        return;
    }
}

function find_by_primary_key($pdo,$key){
    $stmt = $pdo->prepare('SELECT * FROM Profile WHERE profile_id = :id');
    $stmt->execute(array(':id' => $key));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function check_user_id($pdo){
    if (!is_numeric($_GET['profile_id']) || !isset($_GET['profile_id'])){
        $_SESSION['error'] = 'Could not load profile';
        return false;
    }   else{
        $row = find_by_primary_key($pdo, $_GET['profile_id']);
        if ( $row === false ) {
            $_SESSION['error'] = 'Could not load profile';
            return false;
        }   else{
            return true;
        }
    }
}
?>