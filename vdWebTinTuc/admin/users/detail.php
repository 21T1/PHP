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
            if($router->getPOST("username") > $row['username'])
                break;
            else if($router->getPOST("username") === $row['username']){
                $checkName = false;
                break;
            }
    }
    if($router->getPOST("submit") && $router->getPOST("username") && $checkName && $router->getPOST("password")){
        $params = [
            ":username"=>$router->getPOST("username"),
            ":password"=>md5($router->getPOST("password")),
        ];
    
        $result = false;
        if($id){
            $params[':id'] = $id;
            $result = $users->buildQueryParams([
                "value"=>"username=:username, password=:password",
                "WHERE"=>"id=:id",
                "params"=>$params
            ])->update();
        } else
            $result = $users->buildQueryParams([
                "field"=>"(username, password) VALUES (?, ?)",
                "value"=>[$params[":username"], $params[":password"]]
            ])->insert();
    
        if($result)
            $router->redirect('users/index');
        else
            $router->pageError('Cannot update user');
    }
?>
<html>
    <body>
        <div>
            <p>Hi <?= $user->getSESSION('username')?>,</p> 
            <p>Welcome to Demo, <a href="<?= $router->createUrl('logout')?>">Logout?</a></p>
            <h1><?= $id ? "View " : "Create New " ?>User: <?= $userDetail["username"]?></h1>
        </div>
        <form action="<?php echo $router->createUrl('users/detail', ["id"=>$userDetail["id"]])?>" method="POST">
            Username:<br >
            <input type="text" name="username" value="<?= $userDetail["username"]?>">
            <p style="display: inline"><?= $checkName ? "" : "ERROR: Username exists"?></p><br>
            Password:<br>
            <input type="password" name="password" value="<?= $userDetail["password"]?>"><br>
            <input type="submit" name="submit" value="Add">
            <input type="button" value="Cancel" onclick="window.location.href = '<?= $router->createUrl("users/index")?>'">
        </form>
    </body>
</html>
