<?php

// Include init file
require_once ('init.php');

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
        // Récupération des informations du profil
        $userProfile = $adapter->getUserProfile();

        // Getting user profile details
        $googleUserData                    = array();
        $googleUserData['oauth_uid']       = !empty($userProfile->identifier)?$userProfile->identifier:'';
        $googleUserData['name']            = !empty($userProfile->displayName)?$userProfile->displayName:'';
        $googleUserData['username']        = !empty($userProfile->emailVerified)?$userProfile->emailVerified:'';
        $googleUserData['email']           = !empty($userProfile->email)?$userProfile->email:'';
        $googleUserData['location']        = !empty($userProfile->city)?$userProfile->city:''; // @TODO: Utiliser city zip region et country
        $googleUserData['picture']         = !empty($userProfile->photoURL)?$userProfile->photoURL:'';
        $googleUserData['link']            = !''; // @TODO: Lien google?

        // Insert or update user data to the database
        $googleUserData['oauth_provider'] = 'google';
        $userData = $user->checkUser($googleUserData);

        // Render Google profile data
        $output .= '<h2>Google Account Details</h2>';
        $output .= '<div class="ac-data">';
            $output .= '<img src="'.$userProfile->photoURL.'">';
            $output .= '<p><b>ID:</b> '.$userProfile->identifier.'</p>';

            $output .= '<p><b>DisplayName:</b> ' . $userProfile->displayName . '</p>';
            $output .= '<p><b>Description:</b> ' . $userProfile->description . '</p>';

            $output .= '<p><b>FirstName:</b> ' . $userProfile->firstName . '</p>';
            $output .= '<p><b>lastName:</b> ' . $userProfile->lastName . '</p>';

            $output .= '<p><b>Gender:</b> ' . $userProfile->gender . '</p>';

            $output .= '<p><b>Age:</b> ' . $userProfile->age . '</p>';
            $output .= '<p><b>BirthDay:</b> ' . $userProfile->birthDay . '</p>';
            $output .= '<p><b>BirthDay:</b> ' . $userProfile->birthMonth . '</p>';
            $output .= '<p><b>BirthDay:</b> ' . $userProfile->birthYear . '</p>';

            $output .= '<p><b>Email:</b> ' . $userProfile->email . '</p>';
            $output .= '<p><b>Email Verified:</b> ' . $userProfile->emailVerified . '</p>';

            $output .= '<p><b>Phone:</b> ' . $userProfile->phone . '</p>';
            $output .= '<p><b>Address:</b> ' . $userProfile->address . '</p>';
            $output .= '<p><b>Country:</b> ' . $userProfile->country . '</p>';

            $output .= '<p><b>Region:</b> ' . $userProfile->region . '</p>';
            $output .= '<p><b>City:</b> ' . $userProfile->city . '</p>';
            $output .= '<p><b>Zip:</b> ' . $userProfile->zip . '</p>';

            $output .= '<p><b>Data:</b> ' . print_r($userProfile->data, true) . '</p>';

            $output .= '<p>Logout from <a href="logout.php">Google</a></p>';
        $output .= '</div>';

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
?>

<div class="container">
    <!-- Display login button / GitHub profile information -->
    <?php echo $output; ?>
</div>