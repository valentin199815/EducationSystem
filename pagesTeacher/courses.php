<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
    <div>
        
        <?php
            
            // echo "<h2> Hi " .$_SESSION['fname']. " " .$_SESSION['fname']. "</h2>";
            // echo "These are the courses you are currently teaching";
              $dbserver = "localhost";
              $dbusername = "root";
              $dbpassword = "";
              $database = "manager_system";
              $email = $_SESSION['email'];
              $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);

              $selectcourses = "SELECT * FROM `course_tb` WHERE teacher_email='$email'";
              $result = $dbConnect->query($selectcourses);
                  if($result->num_rows>0){
                      echo "<ul>";
                      while($row = $result->fetch_assoc()){
                          echo "<p>" .$row['course_name']. "</p>" ;
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

