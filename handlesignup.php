<?php
$insert = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    include 'partials/db_connect.php';
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $cPass = $_POST['cPass'];

    $sql = "SELECT * FROM `users` WHERE `user_name` = '$username'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows == 1){
        echo "Username already Exist";
    }
    else{
        if($pass == $cPass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_name`, `user_pass`) VALUES ('$username', '$hash')";
            $result = mysqli_query($conn, $sql);
            if ($result){
                session_start();
                $insert = true;
                header("location: http://localhost:8080/uamusic?signup=true");
            }
        }
    }
}

?>