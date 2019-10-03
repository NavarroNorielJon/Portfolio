<?php
        require_once('db_connection.php');
        $email = ""; 
        $username = ""; 
        $registerPassword = "";
        $verifyPassword = "";
        $date = date("Y-m-d H:i:s");

        verifyUserInput($email, $username, $registerPassword, $verifyPassword, $database_connect);

        /*
            Verifies if all of the fields of the registration form are not null
            1. It checks if the email, username, and password field has values.
            2. The value from the registration form will be stored.
            3. It verifies if the email and/or username exists in the database by 
            calling other functions.
            4. It verifies if the password and verify password matches.
            5. It will insert the data from the database.
        */
        function verifyUserInput($email, $username, $registerPassword, $verifyPassword, $database_connect) 
        {
            if(isset($_POST['email']) 
            && isset($_POST['username']) 
            && isset($_POST['register-password']) 
            && isset($_POST['verify-password']))
            {
                
                $email = $_POST['email'];
                $username = $_POST['username'];
                $registerPassword = $_POST['register-password'];
                $verifyPassword = $_POST['verify-password'];
                $date = date("Y-m-d H:i:s");
                
                verifyEmail($email, $database_connect);
                verifyUsername($username, $database_connect);
                verifyPassword($registerPassword, $verifyPassword);
                insertUserData($database_connect, $email, $username, $registerPassword, $date);


                
            }else {
                echo "<script>alert('Something went wrong')</script>";
            }
        }
        
        //This function verifies if the email already exists in the database.
        function verifyEmail($email, $database_connect)
        {
            $query = "SELECT email FROM user WHERE email = '$email'";
            $result = mysqli_query($database_connect, $query);
            $count = mysqli_num_rows($result);

            if($count == 1)
            {
                
                echo "<script>alert('Email address already exists')</script>";
                echo "<script>location.replace('../index.html?emailVerification=failed')</script>";
                exit();
            }
        }

        //This function verifies if the username already exists in the database.
        function verifyUsername($username, $database_connect)
        {
            $query = "SELECT username FROM user WHERE username = 'username'";
            $result = mysqli_query($database_connect, $query);
            $count = mysqli_num_rows($result);

            if($count == 1)
            {
                echo "<script>alert('Username already exists')</script>";
                echo "<script>location.replace('../index.html?usernameVerification=failed')</script>";
                exit();
            }
        }

        /*
            This function verifies if the password and verify password field matches.
            If they match it will hash the password and then return the hased value
        */
        function verifyPassword($registerPassword, $verifyPassword)
        {
            if($registerPassword == $verifyPassword)
            {
                return $registerPassword;
            }else
            {
                echo "<script>alert('Password did not match, please try again')</script>";
                echo "<script>location.replace('../index.html?passwordVerification=failed')</script>";
                exit();
            }
        }

        //This function inserts the data from the registration form to the database
        function insertUserData($database_connect, $email, $username, $registerPassword, $date)
        {
            $registerPassword = password_hash($registerPassword, PASSWORD_DEFAULT);
            $query = "INSERT INTO user (user_id, email, username, password, user_type, date_created) 
            VALUES(DEFAULT,'$email','$username','$registerPassword',DEFAULT, '$date')";
            $result = mysqli_query($database_connect, $query);

            echo "<script>alert('Registration Success')</script>";
            echo "<script>location.replace('../index.html?registration=success')</script>";
        }
?>