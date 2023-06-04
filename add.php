<?php
session_start();

require_once('PDO_connect.php');
require_once('model.php');
require_once('controller.php');

check_permission();
$err_msg = print_err();
data_insert($pdo);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Viacheslav Kasimov</title>
        <script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
    </head>
    
    <body>
        <h1>Adding Profile for UMSI</h1>
        <?= $err_msg ?>
        <form method="post">
            <p>First Name:
                <input type="text" name="first_name" size="60"/></p>
            <p>Last Name:
                <input type="text" name="last_name" size="60"/></p>
            <p>Email:
                <input type="text" name="email" size="30"/></p>
            <p>Headline:<br/>
                <input type="text" name="headline" size="80"/></p>
            <p>Summary:<br/>
                <textarea name="summary" rows="8" cols="80"></textarea>
            <p>
                <input type="submit" name="dopost" value="Add">
                <input type="button" name="cancel" onclick="location.href='/index.php'; return false;" value="cancel">
            </p>
            <p>
                Position: 
                <input type="submit" id="addPos" value="+">
                <div id="position_fields"></div>
                <p></p>
            </p>
        </form>
        <script>
            
            countPos = 0;
            $(document).ready(function(){
                window.console && console.log('Document ready called');
                $('#addPos').click(function(event){
                    event.preventDefault();
                    if ( countPos >= 9 ) {
                        alert("Maximum of nine position entries exceeded");
                        return;
                    }
                    countPos++;
                    window.console && console.log("Adding position "+countPos);
                    $('#position_fields').append(
                        '<div id="position'+countPos+'"> \
                        <p>Year: <input type="text" name="year'+countPos+'" value="" /> \
                        <input type="button" value="-" \
                            onclick="$(\'#position'+countPos+'\').remove();return false;"></p> \
                        <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
                        </div>');
                });
            });
        </script>
    </body>
</html>
