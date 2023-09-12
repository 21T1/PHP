<?php
    $user = new apps_libs_userIdentity();
    $router = new apps_libs_router();
?>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;1,200;1,300&display=swap');

            :root{
                --dark-color: #232946;
                --light-color: #fffffe;
                --effect-color: #eebbc3;
                --border-color: #121629;
                --read-color: #d4d8f0;
            }
            body{
                font-family: 'poppins';
                background-color: var(--read-color); 
                color: var(--dark-color);
            }
            p{
               font-size: 20px; 
               padding: 0 25px;
               color: currentColor;
            }
            .head{
                display: flex;
                justify-content: space-between;
                align-content: center;
            }
            .head a{
                text-decoration: none;
                color: currentColor;
            }
            h1{
                display: flex;
                justify-content: center;
                align-content: center;
                margin: 20px 0 30px;
            }
            .head i{
                cursor: pointer;
            }
            .head i:hover{
                color: var(--effect-color);
            }
        </style>
    </head>
    <body>
        <div class="head">
            <p>Hi <i><?= $user->getSESSION('username')?></i>, welcome to Demo&ensp;
                <i onclick="location.href='<?= $router->createUrl('home')?>'" class="fa-solid fa-house"></i>
            <p>
            <p><a href="<?= $router->createUrl('logout')?>">Logout?</a></p>
            
        </div>
    </body>
</html>
