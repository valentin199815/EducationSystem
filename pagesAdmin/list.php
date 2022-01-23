
<!DOCTYPE html>
<html>
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    </head>
    <body ng-app="myapp" ng-controller="myctrl">
        <h1>Current courses</h1>
        <?php 
             $dbserver = "localhost";
             $dbusername = "root";
             $dbpassword = "";
             $database = "manager_system";
             $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);
             

             $selectCourses = "SELECT * FROM `course_tb` WHERE 1";
             $result = $dbConnect->query($selectCourses);
            
             if($result->num_rows>0){
                echo "<table><tr><th>Course Name</th><th>Course id</th><th>Min Capacity</th><th>Max Cpacity</th></tr>";
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>  " .$row['course_name']. "</td>";
                    echo "<td>  " .$row['course_id']. "</td>";
                    echo "<td>  " .$row['min_capacity']. "</td>";
                    echo "<td>  " .$row['max_capacity']. "</td>";
                    $_SESSION['course_id'] = $row['course_id'];
                }
                
                echo "</tr></table>";
            }else{
                echo "No courses to show";
            }
        ?>
            <button type="button" ng-click="display();" ng-show="button"  >Add new course</button>
            <div ng-show="addcourse" >
                <form method="POST"  action="<?php echo $_SERVER['PHP_SELF'].'?addr=list.php' ?>">
                    <label>Course Name</label>
                    <input type="text" name="coursename"><br>
                    <label>Teacher Name</label>

                    <?php
                    
                    $dbserver = "localhost";
                    $dbusername = "root";
                    $dbpassword = "";
                    $database = "manager_system";
                    $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);

                    $selecteacher = "SELECT * FROM `user_tb` WHERE user_type='teacher'";
                    $result = $dbConnect->query($selecteacher);
                        if($result->num_rows>0){
                            
                            echo "<select name='optionteacher'>";
                            while($row = $result->fetch_assoc()){
                                echo "<option value='".$row['fname']. " ".$row['lname']."'>" .$row['fname']. " ".$row['lname']. "</option>" ;
                                
                                
            
                            }
                            echo "</select>";
                            
                        }
                        
                        
                    ?>

                    
                    <br><label>Min capacity</label>
                    <input type="text" name="min"><br>
                    <label>Max capacity</label>
                    <input type="text" name="max"><br>
                    <button type="submit">Add Course</button>
                    
                    
                </form>
            </div>
            <?php
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $coursename = $_POST["coursename"];
                $teachername = $_POST["optionteacher"];
                $min = $_POST["min"];
                $max = $_POST["max"];
                $courseid = intval($_SESSION['course_id']) + 1 ;
                           
                $dbserver = "localhost";
                $dbusername = "root";
                $dbpassword = "";
                $database = "manager_system";
                $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);

                $insert1 = "INSERT INTO `course_tb`(`course_name`, `min_capacity`, `max_capacity`,`teacher_name`,`teacher_email`) 
                VALUES ('$coursename','$min','$max', '$teachername', '$id')";
                $insert2 = "INSERT INTO `teacher_table`(`teacher_name`, `course_id`) 
                VALUES ('$teachername','$courseid')";
                    if($dbConnect->query($insert1) === TRUE){
                        echo "<p style='text-align:center;'> Course Succesfully Added!</p>";
                    }else{
                        echo "<p>There was a problem, please try again later</p>";
                    }
                    if($dbConnect->query($insert2) === TRUE){
                        echo "<p style='text-align:center;'> Course Succesfully Added!</p>";
                        
                    }else{
                        echo "<p>There was a problem, please try again later</p>";
                    }
            }

            ?>
    </body>
    <script>
        var myapp = angular.module("myapp", []);
        myapp.controller("myctrl", function($scope){
            $scope.button = true;
            $scope.addcourse = false;
            $scope.display = function(){
                $scope.addcourse = true;
                $scope.button = false;
            }
        })
    </script>
    
</html>