<?php
/**
 * Category Detail
 */
    $categories = new apps_models_categories();
    $user = new apps_libs_userIdentity();
    $router = new apps_libs_router();
    
    $id = intval($router->getGET("id"));
    
    //
    if($id){
        // SELECT * FROM categories WHERE id = $id LIMIT 1
        $cateDetail = $categories->buildQueryParams([
            "WHERE"=>"id=:id",
            "params"=>[":id"=>$id]
        ])->selectOne();
        if(!$cateDetail)
            $router->pageNotFound();
    }else
        $cateDetail = [
            "id"=>"",
            "name"=>""
        ];   
    //Add new category
    $checkName = true;
    if($router->getPOST("name")){
        $query = $categories->buildQueryParams(["OTHER"=>"ORDER BY name ASC"])->select();
        foreach($query as $row)
            if($router->getPOST("name") == $row['name'] && $row['id'] != $router->getGET("id")){
                $checkName = false;
                break;
            }
    }
    if($router->getPOST("submit") && $router->getPOST("name") && $checkName){
        $params = [
            ":name"=>$router->getPOST("name")
        ];
    
        $result = false;
        if($id && $router->getPOST("submit") == "Edit"){
            $params[':id'] = $id;
            $result = $categories->buildQueryParams([
                "value"=>"name=:name",
                "WHERE"=>"id=:id",
                "params"=>$params
            ])->update();
        } else
            $result = $categories->buildQueryParams([
                "field"=>"(name, created_by) VALUES (?, ?)",
                "value"=>[$params[":name"], $user->getId()]
            ])->insert();
    
        if($result)
            $router->redirect('categories/index');
        else
            $router->pageError('Cannot update db');
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="../CSS/detail.css">
        <title>Category Detail</title>
        <?php include 'head.php'?>
    </head>
    <body>
        <div>
            <h1><?= $id ? "View " : "Create New " ?>Category:&ensp;<i><?= $cateDetail["name"]?></i></h1>
        </div>
        <!-- Detail of category's id = $id  -->
        <div class="form">
            <form action="<?php echo $router->createUrl('categories/detail', ["id"=>$cateDetail["id"]])?>" method="POST">
                <div id="form-text">
                    <p id="name">Category: </p>
                    <?php
                    if($router->getPOST("submit")){
                        if(!$checkName){
                            ?>
                                <p id="error">Category exists</p>
                            <?php
                        }else if($cateDetail["name"] == ""){
                            ?>
                                <p id="error">Enter Name</p>
                            <?php
                        }
                    }
                    ?>
                    <input type="text" name="name" value="<?= $cateDetail["name"]?>">
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
                    <input type="button" value="Cancel" onclick="window.location.href = '<?= $router->createUrl("categories/index")?>'">
                </div>
            </form>
        </div>
    </body>
</html>
