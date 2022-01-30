<!DOCTYPE html>
<html>
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .maincontainer{
            margin: 40px 0;
        }
        
    </style>
    </head>
    <body ng-app="myapp" ng-controller="myctrl">
        <div class="maincontainer">
        <h1>My information</h1>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">Vaccine</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Address</th>
                    <th scope="col">Country</th>
                    <th scope="col">Position</th>
                </tr>
            </thead>
            <tbody>
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
                        while($row = $result->fetch_assoc()){
                            echo "<tr>";
                            echo "<th scope='row'>".$row['fname']. "</th>";
                            echo "<td>  " .$row['lname']. "</td>";
                            echo "<td>  " .$row['email']. "</td>";
                            echo "<td>  " .$row['DOB']. "</td>";
                            echo "<td>  " .$row['vaccine']. "</td>";
                            
                            echo "<td>  " .$row['gender']. "</td>";
                            echo "<td>  " .$row['address']. "</td>";
                            echo "<td>  " .$row['country']. "</td>";
                            echo "<td>  " .$row['position']. "</td>";
                            
                        }
                    
                    
                        $dbConnect->close();
                ?>
                </tbody>
                </table>
            <button type="button" ng-click="display();" class="btn btn-primary" ng-show="button"  >Update Info</button>
            <div ng-show="addcourse" class="addcourse">
                <form method="POST" class="row g-3"  action="<?php echo $_SERVER['PHP_SELF'].'?addr=home.php' ?>">
                <div class="col-md-4">
                    <label for="inputEmail4" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="inputEmail4" name="newfname">
                </div>
                <div class="col-md-4">
                    <label for="inputEmail4" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="inputEmail4" name="newlname">
                </div>
                <div class="col-md-4">
                    <label for="inputPassword4" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputPassword4" name="newemail">
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="inputPassword4" name="newdob">
                </div>
                <div class="col-md-3">
                    <label for="inputState" class="form-label">Vaccine</label>
                        <select id="inputState" class="form-select" name="newvac">
                            <option selected value="Yes"  >Yes</option>
                            <option  value="No" >No</option>
                            <option  value="Rather don't say" >I don't know</option>
                        </select>
                    
                </div>
                <div class="col-md-3">
                    <label for="inputState" class="form-label">Gender</label>
                        <select id="inputState" class="form-select" name="newgender">
                            <option  value="Male"  >Male</option>
                            <option selected value="Female"  >Female</option>
                            <option  value="Other" >Other</option>
                        </select>
                </div>
                <div class="col-12">
                    <label for="inputAddress2" class="form-label">Address</label>
                    <input type="text" class="form-control" id="inputAddress2" placeholder="1234 Main St" name="newaddress">
                </div>
                <div class="col-md-6">
                    <label for="inputCity" class="form-label">Country</label>
                    <input type="text" class="form-control" id="inputCity" name="newcountry">
                </div>
                <div class="col-md-6">
                    <label for="inputCity" class="form-label">Position</label>
                    <input type="text" class="form-control" id="inputCity" name="newposition">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                   
                </form>
            </div>
            </div>
            <?php
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                if(isset($_POST['newvac'])){
                    $newvaci =  $_POST['newvac'];
                }
                
                if(isset($_POST['newgender'])){
                    $newgender =  $_POST['newgender'];
                }
                $newfname =  $_POST['newfname'];
                $newlname =  $_POST['newlname'];
                $newemail =  $_POST['newemail'];
                $newdob =  $_POST['newdob'];                
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
                                echo "<p style='text-align:center;'> Information Succesfully updated! Refresh the page</p>";
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