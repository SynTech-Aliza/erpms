<?php
// Define root (project folder)
define('ROOT_PATH', dirname(__DIR__));

// Define server path
// define('SERVER_PATH', ROOT_PATH . '../app/');
define('SERVER_PATH', ROOT_PATH . '/app/');

// Define assets path
define('BASE_URL', '../'); // assets

// Define views path
define('VIEWS_PATH', ROOT_PATH . '/views');

// Define partial path
define('PARTIALS_PATH', VIEWS_PATH . '/partials');
define('HEADER_PATH', PARTIALS_PATH . '/header.php');
define('MENU_PATH', PARTIALS_PATH . '/menu.php');
define('FOOTER_PATH', PARTIALS_PATH . '/footer.php');
?>