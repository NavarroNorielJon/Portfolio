<?php
    require_once('db_connection.php');
    session_start();

    $usernameOrEmail = "";
    $password = "";

    verifyUser($usernameOrEmail, $password, $database_connect);

    function verifyUser($usernameOrEmail, $password, $database_connect) {
        if(isset($_POST['usernameOrEmail']) && isset($_POST['password']))
        {

            $usernameOrEmail = mysqli_real_escape_string($database_connect, $_POST['usernameOrEmail']);
            $password = mysqli_real_escape_string($database_connect, $_POST['password']);
            verifyUsernameOrEmail($usernameOrEmail, $database_connect);
            verifyPassword($usernameOrEmail, $password, $database_connect);

        }
    }

    function verifyUsernameOrEmail($usernameOrEmail, $database_connect)
    {
        $query = "SELECT username, email FROM user
        WHERE username = '$usernameOrEmail' or email = '$usernameOrEmail'";
        $result = mysqli_query($database_connect, $query);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if($count == 0)
        {
            echo "<script>alert('User does not exist')</script>";
            echo "<script>location.replace('../index.html?usernameOrEmail=not_found')</script>";
        }
    }

    function verifyPassword($usernameOrEmail, $password, $database_connect)
    {
        $query = "SELECT password FROM user 
        WHERE username = '$usernameOrEmail' or email = '$usernameOrEmail'";
        $result = mysqli_query($database_connect, $query);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        $verifyPassword = $row['password'];

        if(password_verify($password, $verifyPassword))
        {
           $_SESSION['user'] = $usernameOrEmail;
            header('Location:../user/home.php');
        } else 
        {
            echo "<script>alert('Incorrect password')</script>";
            echo "<script>location.replace('../index.html?password=incorrect')</script>";
        }
    }
    
?>