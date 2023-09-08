<?php
/**
 * Delete Post
 */
    $post = new apps_models_posts();
    $user = new apps_libs_userIdentity();
    $router = new apps_libs_router();
    
    $id = intval($router->getGET("id"));
    $postDetail = $post->buildQueryParams([
        "WHERE"=>"id=:id",
        "params"=>[":id"=>$id]
    ])->selectOne();
    if(!$postDetail)
        $router->pageNotFound();
    if($id && $router->getPOST("submit"))
        if($post->delete('id=:id', ["id"=>$id]))
                $router->redirect('posts/index');
        else
            $router->pageError("Cannot delete this post")
?>
<html>
    <body>
        <div>
            <p>Hi <?= $user->getSESSION('username')?>,</p> 
            <p>Welcome to Demo, <a href="<?= $router->createUrl('logout')?>">Logout?</a></p>
            <h1>Do you want to delete <?= $postDetail["name"]?></h1>
        </div>
        <form action="<?php echo $router->createUrl('posts/delete', ["id"=>$id])?>" method="POST">
            <input type="submit" name="submit" value="Yes">
            <input type="button" value="No" onclick="window.location.href = '<?= $router->createUrl("posts/index")?>'">
        </form>
    </body>
</html>
