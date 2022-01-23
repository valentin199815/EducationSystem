<?php
session_start();
    function createUrl($route){
        return $_SERVER['PHP_SELF']."?addr=".$route;
    }
    if(!isset($_GET['addr'])){
        $_GET['addr']='home.php';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            nav{background-color: lightseagreen; padding: 15px 0;}
            a{color: white; text-decoration: none; padding: 15px;}
            a:hover{background-color: lightskyblue;}
        </style>
    </head>
    <body>
        <nav>
            <a href="<?php echo createUrl('home.php') ?>">Dashboard</a>
            <a href="<?php echo createUrl('courses.php') ?>">My courses</a>
            
        </nav>
        <main>
            <?php
                include('./pagesStudent/'.$_GET['addr'])
            ?>
        </main>
    </body>
</html>