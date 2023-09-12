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
    <head>
        <link rel="stylesheet" href="../CSS/delete.css">
        <title>Delete User</title>
        <?php include 'head.php'?>
    </head>
    <body>
        <div>
            <h1>Do you want to delete&ensp;<i><?= $userDetail["username"]?></i></h1>
        </div>
        <div class="form">
            <form action="<?php echo $router->createUrl('users/delete', ["id"=>$id])?>" method="POST">
                <input id="btn" type="submit" name="submit" value="Yes">
                <input id="btn" type="button" value="No" onclick="window.location.href = '<?= $router->createUrl("users/index")?>'">
            </form>
        </div>
    </body>
</html>
