<?php
    if(isset($_POST["name"]) && isset($_POST["age"]))
    {   // ERROR: Do not access superglobal $_POST array directly.
        echo "Welcome ".$_POST["name"].",<br/>";
        echo "You are ".$_POST["age"]." year old.<br/>";
        
        die();
    }   
?>

<html>
    <body>
        <form action="vdPost.php" method="POST">
            Name: <input type="text" name="name"/>
            Age: <input type="text" name="age"/>
            <input type="submit"/>
        </form>
    </body>
</html>