<!DOCTYPE html>
<html>
    <head>
        <style>
            .mycourses, .addnewcourse{
                width: 50%;
                margin: auto;
                text-align: center;
            }
            
            
        </style>
    </head>
    <body>
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
                          echo "<p>" .$row['course_name']. "</p>" ;
                      }
                      echo "</ul>";
                  }else{
                      echo "You dont have any courses in this moment.";
                  }
                  $dbConnect->close();
        ?>
        </div>
        <div class="addnewcourse">

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?addr=courses.php' ?>" >
                    <h1>Register to a new course</h1>
                    <p>Available Courses</p>
                    
                    <?php
                    
                        $dbserver = "localhost";
                        $dbusername = "root";
                        $dbpassword = "";
                        $database = "manager_system";
                        $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);

                        $selectcourses = "SELECT * FROM `course_tb` WHERE 1";
                        $result = $dbConnect->query($selectcourses);
                            if($result->num_rows>0){
                                echo "<select name='option'>";
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['course_name']."'>" .$row['course_name']. "</option>" ;
                                    $_GET['coursename'] = $row['course_name'];
                                }
                                echo "</select>";
                            }

                        $selectteacher = "SELECT * FROM `course_tb` WHERE course_name='".$_GET['coursename']."'";
                        echo $_GET['coursename'];
                        $result1 = $dbConnect->query($selectteacher);
                            if($result1->num_rows>0){
                                echo "<select name='option'>";
                                while($row = $result->fetch_assoc()){
                                    echo $row['teacher_name'];
                                    // echo "<option value='".$row['course_name']."'>" .$row['teacher_name']. "</option>" ;
                                    
                                }
                                echo "</select>";
                            }
                            $dbConnect->close();
                    ?>
                    <button type="submit">Register</button>
            </form>
        </div>
        <?php
            if($_SERVER['REQUEST_METHOD']=="POST"){
                $dbserver = "localhost";
                $dbusername = "root";
                $dbpassword = "";
                $database = "manager_system";
                $option = $_POST['option'];
                $userid = $_SESSION['user_id'];
                $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);
                $selectreg = "select * from registration_tb where student_id='".$userid."' AND course_name='".$option."' " ;
                $result = $dbConnect->query($selectreg);
                    if($result->num_rows>0){
                        echo "<p>Sorry, you are already registered in this course";
                    }else{
                        $sendData  = "INSERT INTO `registration_tb`(`student_id`, `course_name`) 
                        VALUES ('$userid','$option')";
                         $result1 = $dbConnect->query($sendData);
                            if($dbConnect->query($result1) === TRUE){
                                echo "<p style='text-align:center;'> Succesfully registered </p>";
                                
                            }else{
                                echo "<p style='text-align:center;'> Succesfully registered </p>";
                            }
                    }
                    $dbConnect->close();


                
            }

        ?>
    </body>
</html>