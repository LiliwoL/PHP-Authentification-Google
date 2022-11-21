<?php

// Composer dependancies
require_once 'vendor/autoload.php';

// Config
require_once 'config/config.php';

// Include user class
require_once 'User.class.php';


// Initialize user class
$user = new User();
$output = '';

// Initialize Google Client class
// $config is defined in config.php
$adapter = new Hybridauth\Provider\Google( $config );

try {
    $adapter->authenticate();

    if ($adapter->isConnected())
    {
        $userProfile = $adapter->getUserProfile();
        print_r($userProfile);
        echo '<a href="logout.php">Logout</a>';
    }else{

        /* Redirection vers une page différente du même dossier*/
        $host = $_SERVER['HTTP_HOST'];

        $uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
        $extra='login.php';

        header("Location:http://$host$uri/$extra");

    }
}
catch( Exception $e ){
    echo $e->getMessage() ;
}