<?php
/**
 * Post Detail
 */
    $posts = new apps_models_posts();
    $category = new apps_models_categories();
    $user = new apps_libs_userIdentity();
    $router = new apps_libs_router();
    
    $id = intval($router->getGET("id"));
    
    //
    if($id){
        // SELECT * FROM posts WHERE id = $id LIMIT 1
        $postDetail = $posts->buildQueryParams([
            "WHERE"=>"id=:id",
            "params"=>[":id"=>$id]
        ])->selectOne();
        if(!$postDetail)
            $router->pageNotFound();
    }else
        $postDetail = [
            "id"=>"",
            "name"=>"",
            "content"=>"",
            "description"=>"",
            "cate_id"=>""
        ];   
    //Add new 
    if($router->getPOST("submit") && $router->getPOST("name")
            && $router->getPOST("content") 
            && $router->getPOST("description")
            && $router->getPOST("category")){
        $params = [
            ":name"=>$router->getPOST("name"),
            ":content"=>$router->getPOST("content"),
            ":description"=>$router->getPOST("description"),
            ":category"=>$router->getPOST("category")
        ];
    
        $result = false;
        if($id){
            $params[':id'] = $id;
            $result = $posts->buildQueryParams([
                "value"=>"name=:name, content=:content, description=:description, cate_id=:category",
                "WHERE"=>"id=:id",
                "params"=>$params
            ])->update();
        } else
            $result = $posts->buildQueryParams([
                "field"=>"(cate_id, name, content, description, created_by) VALUES (?, ?, ?, ?, ?)",
                "value"=>[$params[":category"], $params[":name"], $params[":content"], $params[":description"], $user->getId()]
            ])->insert();
    
        if($result)
            $router->redirect('posts/index');
        else
            $router->pageError('Cannot update db');
    }
?>
<html>
    <body>
        <div>
            <p>Hi <?= $user->getSESSION('username')?>,</p> 
            <p>Welcome to Demo, <a href="<?= $router->createUrl('logout')?>">Logout?</a></p>
            <h1><?= $id ? "View " : "Create New " ?>Post: <?= $postDetail["name"]?></h1>
        </div>
        <form action="<?php echo $router->createUrl('posts/detail', ["id"=>$postDetail["id"]])?>" method="POST">
            Title:<br>
            <input type="text" name="name" value="<?= $postDetail["name"]?>"><br>
            Category:<br>
            <select name="category">
                <?php
                    $listCate = $category->buildSelectBox();
                    foreach($listCate as $key=>$value){
                        ?>
                        <!--Select category-->
                        <option <?= $key == $postDetail["cate_id"] ? "selected" : ""?> value="<?= $key?>"><?= $value?></option>
                        <?php
                    }
                ?>
            </select><br>
            Description:<br>
            <textarea name="description"><?= $postDetail["description"]?></textarea><br>
            Content:<br>
            <textarea name="content"><?= $postDetail["content"]?></textarea><br>
            <input type="submit" name="submit" value="Post">
            <input type="button" value="Cancel" onclick="window.location.href = '<?= $router->createUrl("posts/index")?>'">
        </form>
    </body>
</html>