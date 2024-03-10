<?php

// Include init file
require_once('init.php');

// Initialize user class
$user = new User();
$output = '';

// Initialize Google Client class
// $config is defined in config.php
$adapter = new Hybridauth\Provider\Google( $config );

try {
    if ($adapter->isConnected())
    {
        // Récupération du profil connecté
        $userProfile = $adapter->getUserProfile();

        // Affichage
        print_r($userProfile);
        echo "<br><br>";
        echo '<a href="logout.php">Logout</a>';
    }else{

        if ( isset($_GET['state'])){

            /* Redirection vers une page différente du même dossier*/
            $host       = $_SERVER['HTTP_HOST'];
            $qry        = $_SERVER['QUERY_STRING'];

            $uri        = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
            $extra      = 'login.php';

            // Redirection
            header("Location:http://$host$uri/$extra?$qry");
        }elseif( isset($_GET['purge']) ){

            // Purge de la base
            $user->purge();


            header('Location: ./');
        }else{
            // Affichage de l'image de login
            $output .= '<a href="login.php">';
                $output .= '<img src="' . REDIRECT_URL . '/images/google-login.png" alt="Google Login"/>';
            $output .= '</a>';

            // Display all existing users in database
            $output .= $user->displayAll();
        }
    }
}
catch( Exception $e ){
    echo $e->getMessage() ;
}
?>

<div class="container">
    <!-- Display login button / GitHub profile information -->
    <?php echo $output; ?>
</div>
