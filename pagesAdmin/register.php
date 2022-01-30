<!DOCTYPE html>
    <html>
        <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <style>
            .maincontainer{margin: 50px 0;}
            .maincontainer h1{margin-bottom: 30px;}
            
        </style>
        </head>
        <body>
        <div class="maincontainer">
            <h1>Register new User</h1>
            <form class="row g-3" method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?addr=register.php' ?>" enctype="multipart/form-data">
                <div class="col-md-4">
                    <label for="inputState" class="form-label">User Type</label>
                    <select id="inputState" class="form-select" name="usertype">
                        <option selected  value="teacher">Teacher</option>
                        <option selected  value="student">Student</option>
                        <option selected  value="admin">Admin</option>
                    </select>
                </div>    
                <div class="col-md-4">
                    <label for="inputEmail4" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="inputEmail4" name="fname">
                </div>
                <div class="col-md-4">
                    <label for="inputEmail4" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="inputEmail4" name="lname">
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputPassword4" name="email">
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="inputPassword4" name="dob">
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Profile Picture</label>
                    <input type="file" class="form-control" id="inputPassword4" name="picture">
                </div>
                <div class="col-md-3">
                    <label for="inputState" class="form-label">Vaccine</label>
                        <select id="inputState" class="form-select" name="vaci">
                            <option selected value="Yes"  >Yes</option>
                            <option  value="No" >No</option>
                            <option  value="Rather don't say" >I don't know</option>
                        </select>
                    
                </div>
                <div class="col-md-3">
                    <label for="inputState" class="form-label">Gender</label>
                        <select id="inputState" class="form-select" name="gender">
                            <option  value="Male"  >Male</option>
                            <option selected value="Female"  >Female</option>
                            <option  value="Other" >Other</option>
                        </select>
                </div>
                <div class="col-12">
                    <label for="inputAddress2" class="form-label">Address</label>
                    <input type="text" class="form-control" id="inputAddress2" placeholder="1234 Main St" name="address">
                </div>
                <div class="col-md-6">
                    <label for="inputCity" class="form-label">Country</label>
                    <input type="text" class="form-control" id="inputCity" name="country">
                </div>
                <div class="col-md-6">
                    <label for="inputCity" class="form-label">Position</label>
                    <input type="text" class="form-control" id="inputCity" name="position">
                </div>
                <div class="col-md-6">
                    <label for="inputCity" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputCity" name="pass">
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
            
        </div>

        <?php
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                if(isset($_POST['vaci'])){
                    $vaci =  $_POST['vaci'];
                }
                if(isset($_POST['usertype'])){
                    $usertype =  $_POST['usertype'];
                }
                if(isset($_POST['gender'])){
                    $gender =  $_POST['gender'];
                }
               
               $fname =  $_POST['fname'];
               $lname =  $_POST['lname'];
               $email =  $_POST['email'];
               $dob =  $_POST['dob'];
               $picture = './usersimg/' .$_FILES['picture']['name'];
               
              
               $address =  $_POST['address'];
               $country =  $_POST['country'];
               $position =  $_POST['position'];
               $pass =  $_POST['pass'];
               
               

               function upload($sourcefile,$destfile){ #function to move the file into the folder
                if(move_uploaded_file($sourcefile,$destfile)){
                    
                    return true;
                }else{
                    
                    return false;
                }
            }

                $targetdir = './usersimg/'.basename($_FILES['picture']['name']);
                $imgdetails = getimagesize($_FILES['picture']['tmp_name']);
                if($imgdetails !== false){
                    upload($_FILES['picture']['tmp_name'],$targetdir);
                }

                $dbserver = "localhost";
                $dbusername = "root";
                $dbpassword = "";
                $database = "manager_system";
                $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);
                    if($dbConnect->connect_error){
                        die("Connection failed: " .$dbConnect->connect_error);
                    }else{
                        $selectemail = "select * from user_tb where email='".$email."'";
                        $result = $dbConnect->query($selectemail);
                            if($result->num_rows>0){
                                echo "<p>Sorry, this user already exists";
                            }else{
                                $salt = rand();
                                $mypass = md5($pass.$salt);
                                

                                $inserttable = "INSERT INTO `user_tb`(`email`, `password`, `fname`, `lname`, `DOB`, 
                                `profile_picture`, `vaccine`, `gender`, `address`, `country`, `position`, `salt`, 
                                `user_type`) VALUES ('$email','$mypass','$fname','$lname','$dob','$picture','$vaci',
                                '$gender','$address',' $country','$position','$salt',' $usertype')";

                                
                                    if($dbConnect->query($inserttable)=== TRUE){
                                        echo "<p style='text-align:center;'> Succesfully registered </p>";
                                        
                                    }else{
                                        echo "<p>There was a problem, please try again later</p>";
                                    }
                                   
                            }
                        $dbConnect->close();
                             
                    }
            }
        ?>
            
        
        </body>
    </html>
