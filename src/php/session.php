<?php
    require_once('db_connection.php');
    session_start();

    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
    }else
    {
        header('Location: ../index.html');
    }

    $query = "SELECT * FROM user 
    WHERE username = '$user' or email = '$user'";
    $result = mysqli_query($database_connect, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $username = $row['username'];
?>