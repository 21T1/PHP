<?php
    $router = new apps_libs_router();
    
    $account = trim($router->getPOST('account'));
    $password = trim($router->getPOST('password'));
  
    $identity = new apps_libs_userIdentity();
    // Check login or not
    if($identity->isLogin())
        $router->homePage();

    if($router->getPOST('submit') && $account && $password){
        $identity->username = $account;
        $identity->password = $password;
        if($identity->login())
            $router->homePage();
    }
?>

<html>
    <head>
        <title>Admin Login</title>
        <link rel="stylesheet" href="../CSS/login.css" type="text/css">
    </head>
    <body>
        <div class="login">
            <p>Login Demo</p>
            <form action="<?php echo $router->createUrl('login') ?>" method="POST">
                <div id="form-text">
                    <input type="text" name="account" placeholder="Username"><br>
                </div>
                <div id="form-text">
                    <input type="password" name="password" placeholder="Password"><br>
                </div>
                <div id="error">
                    <?php
                    if($router->getPOST('submit') && !$identity->login()){
                        ?>

                            <p>Username or Password incorrect</p>

                        <?php
                    }else{
                        ?>
                            <p></p>
                        <?php
                    }
                    ?>
                </div>
                <div id="form-btn">
                    <input type="submit" name="submit" value="login">
                </div>
            
            
                </form>
        </div>
    </body>
</html>
