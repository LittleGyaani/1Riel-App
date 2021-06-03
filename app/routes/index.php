<?php

/**
  * Main Index File 
  * Copyright (C) 2021 Little Gyaani.
  * Company : 1Riel
  * Domain : 1riel.com
  * Package : Main
  * Source : Main
  * DTStamp : 03/06/2021 13:19:47
**/

//All Necessary Includes

/* Global Configuration */
include_once BASE_PATH . '/app/config/global.config.php';

/*------------------------------------------------------------*/


/* Define Routes for the APP */

/* Website Routes */

//Index Page Route
$router->map('GET', '/', BASE_PATH . '/app/pages/home.php','index');

//Match Routes
$match = $router->match();

// call closure or throw 404 status
if($match) {
  require $match['target'];
}
else {
  header("HTTP/1.0 404 Not Found");
  //header('Location:' . $router -> generate('error-404'));
}