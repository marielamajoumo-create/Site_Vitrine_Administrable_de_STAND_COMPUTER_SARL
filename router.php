<?php

$url = $_GET['url'] ?? '';
$url = trim($url, '/');

$routes = [
    'Accueil'                     => 'index.php',
    'services'             => 'services.php',
    'formations'           => 'formations.php',
    'realisations'         => 'realisations.php',
    'realisationsdetails'  => 'realisationsdetails.php',
    'about'                => 'about.php',
    'blog'                 => 'blog.php',
    'login'                => 'login.php',
    'admin/dashboard'      => 'admin/dashboard.php',
];

if (isset($routes[$url])) {
    require $routes[$url];
} else {
    http_response_code(404);
    echo "<h1>404 - Page introuvable</h1>";
}
?>