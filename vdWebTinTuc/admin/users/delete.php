<?php
/**
 * Delete User
 */
    $users = new apps_models_users();
    $user = new apps_libs_userIdentity();
    $router = new apps_libs_router();
    
    $id = intval($router->getGET("id"));
    $userDetail = $users->buildQueryParams([
        "WHERE"=>"id=:id",
        "params"=>[":id"=>$id]
    ])->selectOne();
    if(!$userDetail)
        $router->pageNotFound();
    if($id && $router->getPOST("submit"))
        if($users->delete('id=:id', ["id"=>$id]))
                $router->redirect('users/index');
        else
            $router->pageError("Cannot delete this user")
?>
<html>
    <body>
        <div>
            <p>Hi <?= $user->getSESSION('username')?>,</p> 
            <p>Welcome to Demo, <a href="<?= $router->createUrl('logout')?>">Logout?</a></p>
            <h1>Do you want to delete <?= $userDetail["username"]?></h1>
        </div>
        <form action="<?php echo $router->createUrl('users/delete', ["id"=>$id])?>" method="POST">
            <input type="submit" name="submit" value="Yes">
            <input type="button" value="No" onclick="window.location.href = '<?= $router->createUrl("users/index")?>'">
        </form>
    </body>
</html>
