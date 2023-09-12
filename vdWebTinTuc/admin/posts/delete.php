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
    <head>
        <link rel="stylesheet" href="../CSS/delete.css">
        <title>Delete Post</title>
        <?php include 'head.php'?>
    </head>
    <body>
        <div>
            <h1>Do you want to delete&ensp;<i><?= $postDetail["name"]?></i></h1>
        </div>
        <div class="form">
            <form action="<?php echo $router->createUrl('posts/delete', ["id"=>$id])?>" method="POST">
                <input id='btn' type="submit" name="submit" value="Yes">
                <input id='btn' type="button" value="No" onclick="window.location.href = '<?= $router->createUrl("posts/index")?>'">
            </form>
        </div>
    </body>
</html>
