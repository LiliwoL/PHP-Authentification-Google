<?php

// Composer dependancies
require_once 'vendor/autoload.php';

// Config
require_once 'config/config.php';

// Initialize Google Client class
// $config is defined in config.php
$adapter = new Hybridauth\Provider\Google( $config );

try {
    if ($adapter->isConnected())
    {
        $adapter->disconnect();
        echo 'Logged out the user';
        echo '<p><a href="index.php">Retour à la page de login</a></p>';
    }
}
catch( Exception $e ){
    echo $e->getMessage() ;
}