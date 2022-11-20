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
    if ($adapter->isConnected())
    {
        $userProfile = $adapter->getUserProfile();
        print_r($userProfile);
        echo '<a href="logout.php">Logout</a>';
    }else{

        if ( isset($_GET['state'])){
            $adapter->authenticate();
            $userProfile = $adapter->getUserProfile();
            print_r($userProfile);
            echo '<a href="logout.php">Logout</a>';
        }else{
            // Affichage de l'image de login
            echo '<a href="login.php">
                <img src="' . REDIRECT_URL . '/images/google-login.png" alt="Google Login"/>
            </a>';
        }
    }
}
catch( Exception $e ){
    echo $e->getMessage() ;
}