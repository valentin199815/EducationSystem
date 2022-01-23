<?php
include('./config.php');
session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            .maincontainer{width: 50%; margin: auto;}
            input{width: 100%; padding: 5px 0; margin-bottom: 30px;}
            button{background-color: lightseagreen; color: white; 
                padding: 16px 20px; outline: 0; border: 0; border-radius: 5px; cursor: pointer;}
        </style>
    </head>
    <body>
        <div class="maincontainer">
            <h2>Login</h2>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?addr=login.php' ?>">
                <label>Username / Email</label>
                <input type="text" name="email">
                <label>Password</label>
                <input type="password" name="pass">
                <button type="submit">Login</button>
            </form>
        </div>
        <?php
            if($_SERVER['REQUEST_METHOD']=="POST"){
                $UserEmail = $_POST['email'];
                $UserPass = $_POST['pass'];
                $admin = "admin";
                $teacher = "teacher";
                $student = "student";
           
                #connect to my database
                $dbserver = "localhost";
                $dbusername = "root";
                $dbpassword = "";
                $database = "manager_system";
                $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);
               
                
                $select_admin = "SELECT * FROM user_tb where 
                email='".$UserEmail."' AND password='".$UserPass."' AND user_type='".$admin."'";

                $select_teacher = "SELECT * FROM user_tb where 
                email='".$UserEmail."' AND password='".$UserPass."' AND user_type='".$teacher."'";

                $select_student = "SELECT * FROM user_tb where 
                email='".$UserEmail."' AND password='".$UserPass."' AND user_type='".$student."'";

                $result = $dbConnect->query($select_admin);
                $result1 = $dbConnect->query($select_teacher);
                $result2 = $dbConnect->query($select_student);

                            if($result->num_rows>0){
                                while($row = $result->fetch_assoc()){
                                $_SESSION['user_id'] = $row['user_id'];
                                }
                                    header("Location: indexAdmin.php?addr=home.php");
                                    exit();
                                    $result->close();
                                    $dbConnect->close();
                                    
                                    
                            }elseif($result1->num_rows>0){
                                while($row = $result1->fetch_assoc()){
                                    $_SESSION['user_id'] = $row['user_id'];
                                    $_SESSION['email'] = $row['email'];
                                    
                                }
                                header("Location: indexTeacher.php?addr=home.php");
                                exit();
                                    $result1->close();
                                    $dbConnect->close();
                                    
                            }elseif($result2->num_rows>0){
                                while($row = $result2->fetch_assoc()){
                                    $_SESSION['user_id'] = $row['user_id'];
                                   
                                }   
                                header("Location: indexStudent.php?addr=home.php");
                                    exit();
                                    $result2->close();
                                    $dbConnect->close();
                                    
                            } else{
                                echo "Wrong Username/Password";
                            }
                    

            }
        ?>
    </body>
</html>