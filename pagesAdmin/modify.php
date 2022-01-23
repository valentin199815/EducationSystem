<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
    <h1>Current Students</h1>
        <?php 
             $dbserver = "localhost";
             $dbusername = "root";
             $dbpassword = "";
             $database = "manager_system";
             $dbConnect = new mysqli($dbserver, $dbusername, $dbpassword, $database);
             

             $selectStudent = "SELECT * FROM `user_tb` WHERE user_type='student'";
             $result = $dbConnect->query($selectStudent);
            
             if($result->num_rows>0){
                echo "<table><tr><th>First Name</th><th>Last Name</th><th>Date of bith</th><th>Vaccine</th>
                <th>Gender</th><th>Address</th><th>Country</th><th>Position</th></tr>";
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>  " .$row['fname']. "</td>";
                    echo "<td>  " .$row['lname']. "</td>";
                    echo "<td>  " .$row['DOB']. "</td>";
                    echo "<td>  " .$row['vaccine']. "</td>";
                    echo "<td>  " .$row['gender']. "</td>";
                    echo "<td>  " .$row['address']. "</td>";
                    echo "<td>  " .$row['country']. "</td>";
                    echo "<td>  " .$row['position']. "</td>";
                    $_SESSION['user_id'] = $row['user_id'];
                }
                
                echo "</tr></table>";
            }else{
                echo "No courses to show";
            }
        ?>
    </body>
</html>