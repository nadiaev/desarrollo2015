<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Drive API Test</title>
</head>
<body>
<?php
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

define('APPLICATION_NAME', 'Drive API Quickstart');
define('CREDENTIALS_PATH', '~/.credentials/drive-api-quickstart.json');
define('CLIENT_SECRET_PATH', 'client_secret.json');

$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

$client = new Google_Client();

// Get your credentials from the console
$client->setClientId('477698375503-uuvtmiige0tf50uvkq4ehe4uivlir0nr.apps.googleusercontent.com');
$client->setClientSecret('jQYismqXOkaCqX4TU-mGWIQp');
$client->setRedirectUri($url);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));

$service = new Google_DriveService($client);

$authUrl = $client->createAuthUrl();

//Request authorization
//print "Please visit:\n$authUrl\n\n";
//print "Please enter the auth code:\n";
$authCode = trim(fgets(STDIN));

// Exchange authorization code for access token
$accessToken = $client->authenticate($authCode);
$client->setAccessToken($accessToken);


//////Function for getting all files from your drive

function retrieveAllFiles($service) {               
        $result = array();
        $pageToken = NULL;

        do {
            try {
              $parameters = array();
              if ($pageToken) {
                $parameters['pageToken'] = $pageToken;
              }
              $files = $service->files->listFiles($parameters);

              $result = array_merge($result, $files['items']); 

              $pageToken = $files['nextPageToken'];
            } catch (Exception $e) {
              print "An error occurred: " . $e->getMessage();
              $pageToken = NULL;
            }
        } while ($pageToken);           
        return $result;
    }   

$listado_documentos = retrieveAllFiles($service);
//echo '<pre>';
//print_r($listado_documentos);
//echo '</pre>';
include 'layout_con-logut.html';
?>
</body>
</html>