<!DOCTYPE html>
    <html>
        <head>
        <style>
            .maincontainer{width: 50%; margin: auto;}
            input{width: 100%; padding: 5px 0; margin-bottom: 30px;}
            button{background-color: lightseagreen; color: white; 
                padding: 16px 20px; outline: 0; border: 0; border-radius: 5px; cursor: pointer;}
            input[type=radio]{width: 10%; padding: 0; margin: 0 50 0 0px}
        </style>
        </head>
        <body>
        <div class="maincontainer">
            <h1>Register new User</h1>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?addr=register.php' ?>" enctype="multipart/form-data">
                <label>User Type</label><br>

                Teacher<input type="radio" name="usertype" value="teacher">
                Student<input type="radio" name="usertype" value="student">
                Admin<input type="radio" name="usertype" value="admin"><br>
                <label>First Name</label>
                <input type="text" name="fname">
                <label>Last Name</label>
                <input type="text" name="lname">
                <label>Email</label>
                <input type="email" name="email">
                <label>Date of Birth</label>
                <input type="text" name="dob">
                <label>Profile Picture</label>
                <input type="file" name="picture">
                <label>Vaccine</label><br>
                Yes<input type="radio" name="vaci" value="Yes">
                No<input type="radio" name="vaci" value="No"><br>
                <label>Gender</label>
                <input type="text" name="gender">
                <label>Address</label>
                <input type="text" name="address">
                <label>Country</label>
                <input type="text" name="country">
                <label>Position</label>
                <input type="text" name="position">
                <label>Password</label>
                <input type="password" name="pass">
                
                <button type="submit">Register</button>
                <span></span>
            </form>
        </div>

        <?php
            if($_SERVER['REQUEST_METHOD'] == "POST"){
               $usertype =  $_POST['usertype'];
               $fname =  $_POST['fname'];
               $lname =  $_POST['lname'];
               $email =  $_POST['email'];
               $dob =  $_POST['dob'];
               $picture = './usersimg/' .$_FILES['picture']['name'];
               $vaci =  $_POST['vaci'];
               $gender =  $_POST['gender'];
               $address =  $_POST['address'];
               $country =  $_POST['country'];
               $position =  $_POST['position'];
               $pass =  $_POST['pass'];
               
               

               function upload($sourcefile,$destfile){ #function to move the file into the folder
                if(move_uploaded_file($sourcefile,$destfile)){
                    echo "<p style='color:blue;'>File has been uploaded </p>";
                    return true;
                }else{
                    echo "<p style='color:red;'>File has not been uploaded </p>";
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
                                // $mypass = md5($pass.$salt);
                                

                                $inserttable = "INSERT INTO `user_tb`(`email`, `password`, `fname`, `lname`, `DOB`, 
                                `profile_picture`, `vaccine`, `gender`, `address`, `country`, `position`, `salt`, 
                                `user_type`) VALUES ('$email','$pass','$fname','$lname','$dob','$picture','$vaci',
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
