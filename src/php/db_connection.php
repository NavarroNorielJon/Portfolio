<?php
    DEFINE ('DB_HOST', 'localhost');
    DEFINE ('DB_USER', 'root');
    DEFINE ('DB_PASSWORD', NULL);
    DEFINE ('DB_NAME', 'portfolio');
    
    $database_connect = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    OR DIE ('Failed to connect to the database' . mysqli_connect_error());
    
?>