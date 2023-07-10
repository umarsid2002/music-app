<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="style.css">
    <title>Hello, world!</title>
  </head>
  <body>

  <?php

$insert = false;
$exists = false;
session_start();
error_reporting(E_ERROR | E_PARSE);
$isLogin = $_GET['login'];
$username = $_SESSION['username'];
$loggedin = $_SESSION['loggedin'];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    include 'partials/db_connect.php';
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $cPass = $_POST['cPass'];

    $sql = "SELECT * FROM `users` WHERE `user_name` = '$username'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows == 1){
        $exists = true;
    }
    else{
        if($pass == $cPass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_name`, `user_pass`) VALUES ('$username', '$hash')";
            $result = mysqli_query($conn, $sql);
            if ($result){
                $insert = true;
            }
        }
    }
}

if($insert){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> You signed up to this website
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
}

if($exists){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Failed!</strong> Username already exists. Try another username
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
}

if($isLogin and $loggedin){
  echo '<div class="jumbotron text-center">
  <h1 class="display-4">Hello '.$_SESSION['username'].'</h1>
  <p class="lead">Now you can add your desired song</p>
  <a class="btn btn-primary btn-lg" href="addsong.php" role="button">Add song</a>
</div>';
}

?>

    <div class="container-fluid bg-dark m-0">
        <h1 class='text-center text-white py-2 m-0'>Welcome to UaMusic</h1>
    </div>
    <div class="container-fluid bg-danger">
        <div class="row d-flex align-items-center">
            <div class="col-md-6">
                <h5 class='text-white py-2'>Want to add your desired song?</h5>
            </div>
            <div class="col-md-6 text-right">
                <?php
                if($username and $loggedin){
                    echo '<a href="logout.php"><button type="button" class="btn btn-primary">Logout</button></a>';
                }else{
                    echo '<a href="signup.php"><button type="button" class="btn btn-primary">Signup</button></a>
                    <a href="login.php"><button type="button" class="btn btn-primary">Login</button></a>';
                }
                
                ?>
            </div>
        </div>
    </div>

    <div class="container my-3">
        <div class="row">
            <div class="col-md-12 btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-secondary">Hindi Songs</button>
  <button type="button" class="btn btn-secondary">English Songs</button>
  <button type="button" class="btn btn-secondary">English + Hindi Songs</button>
            </div>
        </div>

        <div class="music d-flex my-4 flex-wrap" id='music'>
            <?php

include 'partials/db_connect.php';
$sql = "SELECT * FROM `songs`";
$result = mysqli_query($conn, $sql);

$index = 0;
while ($row = mysqli_fetch_assoc($result)) {
$song_id = $row['song_id'];
$song_name = $row['song_name'];
$song_audio_path = $row['song_audio_path'];
$song_cover_path = $row['song_cover_path'];
$uploaded = $row['uploaded_time'];

echo "<div id='music-box".$index."' class='music-box d-flex align-items-center border border-success'>
<div id='music-cover".$index."' class='music-cover px-3'><img class='w-100' src='".$song_cover_path."'></div>
<div id='music-title".$index."' class='music-title'>".$song_name."</div>
<div id='music-btn".$index."' class='music-btn px-3'><i class='fa-sharp fa-regular fa-circle-play fa-lg'></i></div>
<input type='hidden' id='song_audio_path".$index."' class='song_audio_path' value='".$song_audio_path."'>
<input type='hidden' class='song_cover_path' id='song_cover_path".$index."' value='".$song_cover_path."'>
</div>";
// id='song_audio_path".$song_id."' in song audio path is removed
$index++;

}

            ?>
        </div>
    </div>

    <div id="audio-container">

    </div>
    

    <script src='logic.js'></script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>