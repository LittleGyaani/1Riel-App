
<?php

//Set Header for Router Page
header("Content-Type: text/html");

/**
 * Main Route Controller File 
 * Copyright (C) 2021 Little Gyaani.
 * Company : 1Riel
 * Domain : 1riel.com
 * Package : Main
 * Source : Main
 * DTStamp : 03/06/2021 13:19:47
**/

//All Necessary Includes

/* Global Configuration */
include_once __DIR__ . '/app/config/global.config.php';

/* Include Routing */

/* All Web APP Routes */

//Include Global Routes
include_once BASE_PATH . '/app/routes/index.php';
