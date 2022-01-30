<?php
include('./config.php');
session_start();

?>
<!DOCTYPE html>
<html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- <link rel="stylesheet" href="style.css"> -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
            <title>Login</title>
            <style>
                .container{width: 50%; margin: 5% auto;}
                h2{text-align: center; margin-bottom: 30px;}
            </style>
        
    </head>
    <body>
    <div class="container">
        <h2>Welcome to LatinCode Education System</h2>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?addr=login.php' ?>">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="pass" class="form-control" id="exampleInputPassword1">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
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

                $selectsalt = "SELECT salt FROM user_tb WHERE email='".$UserEmail."'";
                $result0 = $con->query($selectsalt);
                if($result0->num_rows>0){
                    while($row = $result0->fetch_assoc()){
                        $code = $row['salt'];
                    }
                    $tmppass = md5($UserPass.$code);
                
                $select_admin = "SELECT * FROM user_tb where 
                email='".$UserEmail."' AND password='".$tmppass."' AND user_type='".$admin."'";

                $select_teacher = "SELECT * FROM user_tb where 
                email='".$UserEmail."' AND password='".$tmppass."' AND user_type='".$teacher."'";

                $select_student = "SELECT * FROM user_tb where 
                email='".$UserEmail."' AND password='".$tmppass."' AND user_type='".$student."'";

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

            }
        ?>
    </body>
</html>