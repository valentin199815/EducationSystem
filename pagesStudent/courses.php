<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            .maindiv{
                padding: 50px 0;
                display: grid;
                grid-template-columns: 50% 50%;
            }
            .mybtn{
                text-align: center;
                margin: 30px auto;
            }
            
            
        </style>
    </head>
    <body>
        <div class="maindiv">
            <div class="mycourses">
                <h2>My enrolled courses</h2>                   
            
        <?php
              $dbserver = "localhost";
              $dbusername = "root";
              $dbpassword = "";
              $database = "manager_system";
              $userid = $_SESSION['user_id'];
              $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);

              $selectcourses = "SELECT * FROM `registration_tb` WHERE student_id='$userid'";
              $result = $dbConnect->query($selectcourses);
                  if($result->num_rows>0){
                      echo "<ul>";
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
        <div class="row g-3">

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?addr=courses.php' ?>" >
                    <h2>Register to a new course</h2>
                    <p>Available Courses</p>
                    <select id="inputState" class="form-select" name="pipo">
                    <?php
                        $dbserver = "localhost";
                        $dbusername = "root";
                        $dbpassword = "";
                        $database = "manager_system";
                        $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);

                        $selectcourses = "SELECT * FROM `course_tb` WHERE 1";
                        $result = $dbConnect->query($selectcourses);
                            if($result->num_rows>0){
                                
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['course_name']."'>" .$row['course_name']. "</option>" ;
                                    $_GET['coursename'] = $row['course_name'];
                                }
                                
                            }
                            
                    ?>
                    </select>
                    <div class="mybtn"><button type="submit" class="btn btn-primary">Register</button></div>
                    
                    
            </form>
        </div>
        </div>
        <?php
            if($_SERVER['REQUEST_METHOD']=="POST"){
                if(isset($_POST['pipo'])){
                    $myteacher = $_POST['pipo'];
                
                        $dbserver = "localhost";
                        $dbusername = "root";
                        $dbpassword = "";
                        $database = "manager_system";
                        $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);
                        $selectteacher = "SELECT * FROM `course_tb` WHERE course_name='$myteacher'";
                   
                        $result1 = $dbConnect->query($selectteacher);
                        if($result1->num_rows>0){
                            
                            while($row = $result1->fetch_assoc()){
                                $_GET['tid'] = $row['teacher_email'];
                                $_GET['cid'] = $row['course_id'];                                
                            }
                           
                        }else{
                            echo "nothing found";
                        }
                        $dbConnect->close();
                    } 
                $dbserver = "localhost";
                $dbusername = "root";
                $dbpassword = "";
                $database = "manager_system";
                //$option = $_POST['option'];
                $userid = $_SESSION['user_id'];
                $tid = $_GET['tid'];
                $cid =  $_GET['cid'];
                $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);
                $selectreg = "select * from registration_tb where student_id='".$userid."' AND course_name='".$myteacher."' " ;
                $result = $dbConnect->query($selectreg);
                    if($result->num_rows>0){
                        echo "<p style='text-align:center;'>Sorry, you are already registered in this course</p>";
                    }else{
                        $sendData  = "INSERT INTO `registration_tb`(`student_id`, `course_name`) 
                        VALUES ('$userid','$myteacher')";
                            if($dbConnect->query($sendData) === TRUE){
                                echo "<p style='text-align:center;'> Succesfully registered </p>";
                                
                            }else{
                                echo "<p style='text-align:center;'> Not Succesfully registered </p>";
                            }
                            
                    }
                    $dbConnect->close();


                
            }

        ?>
    </body>
</html>