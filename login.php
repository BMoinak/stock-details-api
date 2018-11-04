<?php
  session_start();
  $server = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'flutura';
  $usernameErr = $passwordErr = $user = $pass = $loginError = $userid = "";
  $countuser = $countpass = 0;

  $conn = mysqli_connect($server, $username, $password, $dbname);

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST['user'])) {
      $countuser = $countuser+1;
      $usernameErr= "Please Enter email";
    } else {
      $user = trim($_POST["user"]);
    }
    if(empty($_POST['pass'])) {
      $countpass = $countpass + 1;
      $passwordErr = "PLease Enter Password";
    } else {
      $pass = trim($_POST["pass"]);
    }
  }
  if(!$conn) {
      die("Connection failed: ".mysqli_connect_error());
  }

  if(!empty($user) && !empty($pass)) {
  	//echo ($user);echo( $pass);
    $sql = "SELECT * FROM  user_data WHERE email = '$user' AND psw = '$pass'";
    $result = mysqli_query($conn, $sql);
    $count =0;
    if($result !=false){
    $count = mysqli_num_rows($result);}
    if($count == 1) {
        $result = $result->fetch_all(MYSQLI_ASSOC);
        foreach($result as $names){
            $_SESSION['name'] = $names['name'];
            $_SESSION['userid'] = $names['email'];
            //echo($_SESSION['name']);
            // echo $_SESSION['name'];
        }

        // $_SESSION['username'] = $user;
        // $_SESSION['userid'] = $userid;
        // $_SESSION['name'] = $res['name'];
        header("Location: index.php", true, 301);
    } else {
      $loginError = "Username Or Password Doesn`t Match.";
    }}
  
  mysqli_close($conn);
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Login: Stock Prices</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
    </head>

    <body>
   
        <div class="login" >
            <h1 ">Login</h1>
            <form action="login.php" method="post">
                <!-- <label for="user">Username</label><br> -->
                <input class="inputstyle" type="email" name="user" placeholder="Enter Email-id"><br>
                <?php

                    echo "<p style='color:red; margin:0;'>$usernameErr</p>";
                ?>
                <!-- <label for="pass">Password</label><br> -->
                <input class="inputstyle" type="password" name="pass" placeholder="Enter Password"><br>
                <?php

                    echo "<p style='color:red;margin: 0;'>$passwordErr</p>";
                ?><br>
                
                <input type="submit" value="Login" class="loginstyle"><br>
                <?php
                  echo "<p style='color:red;'>$loginError</p>";
                ?>
            </form>
        </div>
        <a href="register.php">Not a user? Register here!</a>
    </body>
</html>
