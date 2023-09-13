<?php
/**
 * Post Detail
 */
    $posts = new apps_models_posts();
    $category = new apps_models_categories();
    $user = new apps_libs_userIdentity();
    $router = new apps_libs_router();
    
    $id = intval($router->getGET("id"));
    
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
    $checkError = true;
    if($router->getPOST("submit")){
        if($router->getPOST("name")
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
        if($id && $router->getPOST("submit") == "Edit"){
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
    }else
        $checkError = false;
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="../CSS/detail.css">
        <title>Post Detail</title>
        <?php include 'head.php'?>
        <script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <style>
            .form form{
                width: 100vh;
            }
            select, textarea{
                font-size: 15px;
                border: none;
                outline: none;
                border-bottom: 2px solid gray;
            }
            select{
                height: 40px;
                cursor: pointer;
                overflow-y: scroll; 
            }
            textarea{
                margin-left: 15px;
                padding: 10px;
                width: 90%;
                height: 100px;
            }
        </style>
    </head>
    <body>
        <div>
            <h1><?= $id ? "View " : "Create New " ?>Post:&ensp;<i><?= $postDetail["name"]?></i></h1>
        </div>
        <div class='form'>
            <form action="<?php echo $router->createUrl('posts/detail', ["id"=>$postDetail["id"]])?>" method="POST">
                <div id='form-text'>
                    <p id='name'>Title:</p>
                    <?php
                        if($router->getPOST("submit") && !$checkError){
                            ?>
                                <p id="error">Enter Full Form</p>
                            <?php
                        }
                    ?>
                    <input type="text" name="name" value="<?= $postDetail["name"]?>">
                </div>
                <div id='form-text'>
                    <p id='name'>Category:</p>
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
                    </select>
                </div>
                <div id='form-text'>
                    <p id='name'>Description:</p>
                    <textarea name="description"><?= $postDetail["description"]?></textarea>
                </div>
                <div id='form-text'>
                    <p id='name'>Content:</p>
                    <textarea name="post-content" id="post-content"><?= $postDetail["content"]?></textarea>
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
                    <input type="button" value="Cancel" onclick="window.location.href = '<?= $router->createUrl("posts/index")?>'">
                </div>
            </form>
        </div>
    </body>
    <script>
        CKEDITOR.replace('post-content');
    </script>
</html>