<?php
session_start();

    function createUrl($route){
        return $_SERVER['PHP_SELF']."?addr=".$route;
    }
    if(!isset($_GET['addr'])){
        $_GET['addr']='home.php';
    }
    if(!isset($_SESSION["user_id"])){
      header("Location: login.php");
      exit();
    }
    if(isset($_GET["sout"])){
      session_unset();
      session_destroy();
      header("Location: login.php?err=loggedout");
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Dashboard</title>
 

    <!-- Bootstrap core CSS -->
<link href="./CSS/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="./CSS/dashboard.css" rel="stylesheet">
  </head>
  <body>
   <!-- top menu start -->
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Latin Code</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="<?php echo $_SERVER["PHP_SELF"]."?sout=1"; ?>">Sign out</a>
    </div>
  </div>
</header>
 <!-- top menu end -->

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?php echo createUrl('home.php') ?>">
              <span data-feather="home"></span>
              Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="<?php echo createUrl('courses.php') ?>">
              <span data-feather="file"></span>
              Courses
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <?php
                include('./pagesTeacher/'.$_GET['addr'])
            ?>
      
    </main>
  </div>
</div>


    <script src="./JS/bootstrap.bundle.min.js"></script>
      <script src="./JS/dashboard.js"></script>
  </body>
</html>
