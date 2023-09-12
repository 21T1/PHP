<?php
/**
 * User Detail
 */
    $users = new apps_models_users();
    $user = new apps_libs_userIdentity();
    $router = new apps_libs_router();
    
    $id = intval($router->getGET("id"));
    
    //
    if($id){
        // SELECT * FROM users WHERE id = $id LIMIT 1
        $userDetail = $users->buildQueryParams([
            "WHERE"=>"id=:id",
            "params"=>[":id"=>$id]
        ])->selectOne();
        if(!$userDetail)
            $router->pageNotFound();
    }else
        $userDetail = [
            "id"=>"",
            "username"=>"",
            "password"=>""
        ];   
    //Add new
    $checkName = true;
    if($router->getPOST("username")){
        $query = $users->buildQueryParams(["OTHER"=>"ORDER BY username ASC"])->select();
        foreach($query as $row)
            if($router->getPOST("username") == $row['username'] && $row['id'] != $router->getGET("id")){
                $checkName = false;
                break;
            }
    }
    $checkError = true;
    if($router->getPOST("submit") && $router->getPOST("username") && $checkName && $router->getPOST("password")){
        $params = [
            ":username"=>$router->getPOST("username"),
            ":password"=>md5($router->getPOST("password")),
        ];
    
        $result = false;
        if($id && $router->getPOST("submit") == "Edit"){
            $params[':id'] = $id;
            $result = $users->buildQueryParams([
                "value"=>"username=:username, password=:password",
                "WHERE"=>"id=:id",
                "params"=>$params
            ])->update();
        } else{
            $result = $users->buildQueryParams([
                "field"=>"(username, password) VALUES (?, ?)",
                "value"=>[$params[":username"], $params[":password"]]
            ])->insert();
        }
        if($result)
            $router->redirect('users/index');
        else
            $router->pageError('Cannot update user');
    }else if($router->getPOST("username") == "" || $router->getPOST("password") == "")
        $checkError = false;
        
?>
<html>
    <head>
        <link rel="stylesheet" href="../CSS/detail.css">
        <title>User Detail</title>
        <?php include 'head.php'?>
    </head>
    <body>
        <div>
            <h1><?= $id ? "View " : "Create New " ?>User:&ensp;<i><?= $userDetail["username"]?></i></h1>
        </div>
        <div class="form">
            <form action="<?php echo $router->createUrl('users/detail', ["id"=>$userDetail["id"]])?>" method="POST">
                <div id="form-text">
                    <p id="name">Username:</p>
                    <?php
                        if($router->getPOST("submit") && !$checkName){
                            ?>
                                <p id="error">Username exists</p>
                            <?php
                        }
                        if(!$checkError){
                            ?>
                                <p id="error">Enter Full Form</p>
                            <?php
                        }
                    ?>
                    <input type="text" name="username" value="<?= $userDetail["username"]?>">
                </div>
                <div id="form-text">
                    <p id="name">Password:</p>
                    <input type="password" name="password" value="<?= $userDetail["password"]?>">
                </div>
                <div id='form-btn'>
                    <?php
                        if($id){
                            ?>
                                <input type="submit" name="submit" value="Edit">
                            <?php
                        }else{
                            ?>
                                <input type="submit" name="submit" value="Add">
                            <?php
                        }
                    ?>
                    <input type="button" value="Cancel" onclick="window.location.href = '<?= $router->createUrl("users/index")?>'">
                </div>
            </form>
        </div>
    </body>
</html>
