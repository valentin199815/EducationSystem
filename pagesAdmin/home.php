<!DOCTYPE html>
<html>
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        #form{
            width: 400px;
           
            border-radius: 10px;
            padding: 20px;
            position: absolute;
            top: 20%;
            margin: auto;
            background-color: white;
            border: 1px solid gray;
        } 
        #form h2{
            margin: 0 0 20 0px; padding: 0;
            font-size: 25px;
        }
        #form input,  #form select{width: 50%; margin-left: 30px; }
        
    </style>
    </head>
    <body ng-app="myapp" ng-controller="myctrl">
        <div class="maincontainer">
        <h1>Current courses</h1>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Course id</th>
                    <th scope="col">Course Name</th>
                    <th scope="col">Min Capacity</th>
                    <th scope="col">Max Capacity</th>
                </tr>
            </thead>
            <tbody>
            
        <?php 
             $dbserver = "localhost";
             $dbusername = "root";
             $dbpassword = "";
             $database = "manager_system";
             $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);
             

             $selectCourses = "SELECT * FROM `course_tb` WHERE 1";
             $result = $dbConnect->query($selectCourses);
            
             if($result->num_rows>0){
                while($row = $result->fetch_assoc()){
                    
                    echo "<tr> <th scope='row'> #" .$row['course_id']. "</th>";
                    echo "<td>  " .$row['course_name']. "</td>";
                    echo "<td>  " .$row['min_capacity']. "</td>";
                    echo "<td>  " .$row['max_capacity']. "</td></tr>";
                    $_SESSION['course_id'] = $row['course_id'];
                }
                
                
            }else{
                echo "No courses to show";
            }
        ?>
            
            </tbody>
            </table>
            <button type="button" ng-click="display();" ng-show="button"  class="btn btn-primary">Add new course</button>
            
        </div>
            
                <form id="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?addr=home.php' ?>" ng-show="addcourse" >
                    <h2>Add New User</h2>
                    <label>Course Name</label>
                    <input type="text" name="coursename"><br>
                    <label>Teacher Name</label>
                    
                        <select name="optionteacher" >
                        <?php
                        $dbserver = "localhost";
                        $dbusername = "root";
                        $dbpassword = "";
                        $database = "manager_system";
                        $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);

                        $selecteacher = "SELECT * FROM `user_tb` WHERE user_type='teacher'";
                        $result = $dbConnect->query($selecteacher);
                            if($result->num_rows>0){
                                
                                
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['fname']. " ".$row['lname']."'> <button type='submit'>"  .$row['fname']. " ".$row['lname']. "</button></option>" ;
                                }
    
                            }
                            $dbConnect->close();
                        ?>
                        </select>
                    
                                          

                    
                    <br><label>Min capacity</label>
                    <input type="text" name="min"><br>
                    <label>Max capacity</label>
                    <input type="text" name="max"><br>

                    
                    <button type="submit" class="btn btn-primary">Add Course</button>
                    
                    
                </form>
            
            <?php
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $dbserver = "localhost";
                $dbusername = "root";
                $dbpassword = "";
                $database = "manager_system";
                $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);
     
                if(isset($_POST['optionteacher'])){
                    $myteacher = $_POST['optionteacher'];
                    $newstring = explode(" ", $myteacher);

                    $selecteacher = "SELECT * FROM `user_tb` WHERE user_type='teacher' AND fname='$newstring[0]' AND
                    lname='$newstring[1]'";
                    $result = $dbConnect->query($selecteacher);
                        if($result->num_rows>0){
                            while($row = $result->fetch_assoc()){
                                $_GET['myid'] = $row['user_id'];
                                
                            }
                        }
                        $dbConnect->close();
                    }
                $coursename = $_POST["coursename"];
                $teachername = $_POST["optionteacher"];
                $min = $_POST["min"];
                $max = $_POST["max"];
                $courseid = intval($_SESSION['course_id']) + 1 ;
                $id = $_GET['myid'];
                           
                $dbserver = "localhost";
                $dbusername = "root";
                $dbpassword = "";
                $database = "manager_system";
                $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);

                $insert1 = "INSERT INTO `course_tb`(`course_name`, `min_capacity`, `max_capacity`,`teacher_name`,`teacher_email`) 
                VALUES ('$coursename','$min','$max', '$teachername', '$id')";
                // $insert2 = "INSERT INTO `marks_tb`(`student_id`, `teacher_id`, `course_id`,) 
                // VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')";
                    if($dbConnect->query($insert1) === TRUE){
                        echo "<p style='text-align:center; font-size:20px;'> Course Succesfully Added!</p>";
                    }else{
                        echo "<p>There was a problem, please try again later</p>";
                    }
                    // if($dbConnect->query($insert2) === TRUE){
                    //     echo "<p style='text-align:center;'> Course Succesfully Added!</p>";
                        
                    // }else{
                    //     echo "<p>There was a problem, please try again later</p>";
                    // }
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
            
            $scope.submit = function(){
                $scope.addcourse = true;
                $scope.button = true;
                
            }
        })
    </script>
    
</html>