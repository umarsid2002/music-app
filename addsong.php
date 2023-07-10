<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Add Song</title>
</head>
<body>
    <div class="container">
        <h1>Add your song</h1>
<form class='py-3' action='addsong.php' method='post' enctype='multipart/form-data'>
<div class="form-group">
    <label for="sName">Song Name</label>
    <input type="text" class="form-control" id="sName" name="sName" placeholder="song name">
  </div>

  <div class="form-group">
    <label for="sAudio">Upload song audio here</label>
    <input type="file" class="form-control-file" id="sAudio" name="sAudio">
  </div>

  <div class="form-group">
    <label for="sCover">Upload song cover here</label>
    <input type="file" class="form-control-file" id="sCover" name="sCover">
  </div>

  <button type="submit" class='btn btn-primary'>Add Song</button>
</form>
</div>

<?php
error_reporting(E_ERROR | E_PARSE);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $song_name = $_POST['sName'];
    if(isset($_FILES['sAudio']) and isset($_FILES['sCover'])){
        $audio_name = $_FILES['sAudio']['name'];
        $audio_tmp = $_FILES['sAudio']['tmp_name'];
        $cover_name = $_FILES['sCover']['name'];
        $cover_tmp = $_FILES['sCover']['tmp_name'];
    
        $path = "audio/".$song_name;
        mkdir($path);
    
        move_uploaded_file($audio_tmp, $path.'/'.$audio_name);
        $audio_path = $path.'/'.$audio_name;
        move_uploaded_file($cover_tmp, $path.'/'.$cover_name);
        $cover_path = $path.'/'.$cover_name;

        echo $audio_path. '<br>';
        echo $cover_path. '<br>';
        echo $song_name;

        include 'partials/db_connect.php';

        $sql = "INSERT INTO `songs` (`song_name`, `song_audio_path`, `song_cover_path`) VALUES ('$song_name', '$audio_path', '$cover_path')";
        $result = mysqli_query($conn, $sql);
        if($result){
            echo 'Audio uploaded';
            header('Location: http://localhost/uamusic');
        }
        else{
            echo 'Audio failed';
        }
    }
    
}


?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>