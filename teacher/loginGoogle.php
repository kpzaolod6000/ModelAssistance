<?php

session_start();
require_once '../vendor/autoload.php';
				
// init configuration
$clientID = '861680822725-eiumdr62e5guqblb818naquemu6mqh4u.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost:81/AssistanceControl/teacher/home.php';
// $redirectUri = 'https://assistancecontrol.herokuapp.com/teacher/home.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");    
// echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";

?>