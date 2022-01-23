<!DOCTYPE html>
<html>
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    </head>
    <body ng-app="myapp" ng-controller="myctrl">
        <h1>My information</h1>
        <?php
                
                    $dbserver = "localhost";
                    $dbusername = "root";
                    $dbpassword = "";
                    $database = "manager_system";
                    $userid = $_SESSION['user_id'];
                    $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);

                    $selectinfo = "SELECT * FROM `user_tb` WHERE user_id='$userid'";
                    $result = $dbConnect->query($selectinfo);
                    if($result->num_rows>0)
                        echo "<table><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Date of bith</th><th>Vaccine</th>
                        <th>Picture</th><th>Gender</th><th>Address</th><th>Country</th><th>Position</th></tr>";
                        while($row = $result->fetch_assoc()){
                            echo "<tr>";
                            echo "<td>  " .$row['fname']. "</td>";
                            echo "<td>  " .$row['lname']. "</td>";
                            echo "<td>  " .$row['email']. "</td>";
                            echo "<td>  " .$row['DOB']. "</td>";
                            echo "<td>  " .$row['vaccine']. "</td>";
                            echo "<td><img src=''>";
                            echo "<td>  " .$row['gender']. "</td>";
                            echo "<td>  " .$row['address']. "</td>";
                            echo "<td>  " .$row['country']. "</td>";
                            echo "<td>  " .$row['position']. "</td>";
                            
                        }
                    
                    echo "</tr></table>";
                        $dbConnect->close();
                ?>
            <button type="button" ng-click="display();" ng-show="button"  >Update Info</button>
            <div ng-show="addcourse">
                <form method="POST"  action="<?php echo $_SERVER['PHP_SELF'].'?addr=home.php' ?>">
                    <label>First Name</label>
                    <input type="text" name="newfname"><br>
                    <label>Last name</label>
                    <input type="text" name="newlname"><br>
                    <label>Date of birth</label>
                    <input type="text" name="newdob"><br>
                    <label>Email</label>
                    <input type="text" name="newemail"><br>
                    <label>Vaccine</label><br>
                Yes<input type="radio" name="newvac" value="Yes">
                No<input type="radio" name="newvac" value="No"><br>
                    <label>Gender</label>
                    <input type="text" name="newgender"><br>
                    
                    <label>Address</label>
                    <input type="text" name="newaddress"><br>
                    <label>Country</label>
                    <input type="text" name="newcountry"><br>
                    <label>Position</label>
                    <input type="text" name="newposition"><br>

                    
                    <button type="submit">Update</button>
                </form>
            </div>
            <?php
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $newfname =  $_POST['newfname'];
                $newlname =  $_POST['newlname'];
                $newemail =  $_POST['newemail'];
                $newdob =  $_POST['newdob'];
                
                $newvaci =  $_POST['newvac'];
                $newgender =  $_POST['newgender'];
                $newaddress =  $_POST['newaddress'];
                $newcountry =  $_POST['newcountry'];
                $newposition =  $_POST['newposition'];
                
                    

                $dbserver = "localhost";
                $dbusername = "root";
                $dbpassword = "";
                $database = "manager_system";
                $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);

                
                        $updateinfo = "UPDATE `user_tb` SET `email`='$newemail',`fname`='$newfname',`lname`='$newlname',`DOB`='$newdob',
                        `vaccine`='$newvaci',`gender`='$newgender',`address`='$newaddress',`country`='$newcountry',
                        `position`='$newposition' WHERE user_id='$userid'";
                            if($dbConnect->query($updateinfo) === TRUE){
                                echo "<p style='text-align:center;'> Information Succesfully updated!</p>";
                            }else{
                                echo "<p>There was a problem, please try again later</p>";
                            }
                    // }
                    $dbConnect->close();
                    
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