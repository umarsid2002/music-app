<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    include 'partials/db_connect.php';
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $sql = "SELECT * FROM `users` WHERE `user_name` = '$username'";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)){
        if (password_verify($pass, $row['user_pass'])){
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header('Location: http://localhost/uamusic?login=true');
        }
    }
}

?>