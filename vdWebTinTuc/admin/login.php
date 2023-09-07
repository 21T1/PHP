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
        else
            echo "Username or Password incorrect";
    }
?>

<html>
    <body>
        <div>
            <p>Login Demo</p>
        </div>
        <form action="<?php echo $router->createUrl('login') ?>" method="POST">
            Account:<br>
            <input type="text" name="account"><br>
            Password:<br>
            <input type="password" name="password"><br>
            <input type="submit" name="submit" value="login">
        </form>
    </body>
</html>
