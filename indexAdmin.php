<?php
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
            <a href="<?php echo createUrl('home.php') ?>">Home</a>
            <a href="<?php echo createUrl('register.php') ?>">Register</a>
            <a href="<?php echo createUrl('modify.php') ?>">Edit / Modify</a>
            <a href="<?php echo createUrl('list.php') ?>">List</a>
        </nav>
        <main>
            <?php
                include('./pagesAdmin/'.$_GET['addr'])
            ?>
        </main>
    </body>
</html>