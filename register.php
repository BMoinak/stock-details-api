<?php
    
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'flutura';
    
    extract($_POST);
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $conn = mysqli_connect($server, $username, $password, $dbname);

        if(!$conn) {
            die("Connection failed: ".mysqli_connect_error());
        }

        
        
        $sql = "INSERT INTO user_data (name, psw, email, date) VALUES('$user', '$pass', '$email', '$date')";


        if(mysqli_query($conn,$sql)) {
            header("Location: index.php", true, 301);
            exit();
        }
        else {
            echo "Error".$sql."<br>".mysqli_error($conn);
        }
        mysqli_close($conn);
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <meta charset="utf-8">
       
    </head>
    
    <body>
       
        <div >
            <h1>Sign Up</h1>
            <form action="register.php" method="post">
                    <input class="inputstyle" type="text" name="user" placeholder="Enter name" required><br>
                    <input class="inputstyle" type="password" name="pass" placeholder="Enter Password" required><br>
                    <input class="inputstyle" type="email" name="email" placeholder="Enter email" required><br>
                    <label>Enter Date of Birth</label><br>
                    <input class="inputstyle" type="date" name="date" required><br>
                    <input type="submit" value="Sign Up" name="adduser"><br>
            </form>
             <a href="login.php">Already a user? Sign In!</a>

        </div>
    </body>