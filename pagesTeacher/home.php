<!DOCTYPE html>
<html>
    <head>
        <style>
            .maincontainer{text-align: center; margin-top: 30px;}
            #myul{width: 10%; margin: auto; font-size: 20px;}
        </style>
    </head>
    <body>
    <div class="maincontainer">
        
        <?php
            
            
            echo "<h1>These are the courses you are currently teaching</h1>";
              $dbserver = "localhost";
              $dbusername = "root";
              $dbpassword = "";
              $database = "manager_system";
              $id = $_SESSION['user_id'];
              
              $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);

              $selectcourses = "SELECT * FROM `course_tb` WHERE teacher_email='$id'";
              $result = $dbConnect->query($selectcourses);
                  if($result->num_rows>0){
                      echo "<ul id='myul'>";
                      while($row = $result->fetch_assoc()){
                          echo "<li>" .$row['course_name']. "</li>" ;
                      }
                      echo "</ul>";
                  }else{
                      echo "You dont have any courses in this moment.";
                  }
                  $dbConnect->close();
        ?>
        </div>
    </body>
</html>
