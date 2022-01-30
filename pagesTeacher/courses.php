<!DOCTYPE html>
<html>
    <head>
        <style>
            .buttons{text-align: center;}
            .buttons a{
                color: black;
                display: block;
                font-size: 25px;
                text-decoration: none;
            }
            .buttons a:hover{
                background-color: white;
                text-decoration: underline;
            }
            .maincontainer{                
                text-align: center;
                margin-top: 30px;
            }
        </style>
    </head>
    <body>
    <div class="maincontainer">
        <h2>Choose a course to set marks and comments to students</h2>
        <?php
            
            // echo "<h2> Hi " .$_SESSION['fname']. " " .$_SESSION['fname']. "</h2>";
            // echo "These are the courses you are currently teaching";
              $dbserver = "localhost";
              $dbusername = "root";
              $dbpassword = "";
              $database = "manager_system";
              $email = $_SESSION['user_id'];
              $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);

              $selectcourses = "SELECT * FROM `course_tb` WHERE teacher_email='$email'";
              $result = $dbConnect->query($selectcourses);
                  if($result->num_rows>0){
                      echo "<ul>";
                      while($row = $result->fetch_assoc()){
                          echo "<div class='buttons'><a  href='#'>" .$row['course_name']. "</a></div>" ;
                          
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

