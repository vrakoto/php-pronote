<?php
$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;
$css =  $root . 'src' . DIRECTORY_SEPARATOR . 'main.css';

$removeSlash = explode('/', $_SERVER['REQUEST_URI']);
$pages = array_filter($removeSlash);
if (empty($pages)) {
    $currentPage = 'accueil';
} else {
    $currentPage = $pages[1];
}
echo '<pre>';
print_r($pages);
echo '</pre>';

require_once '../elements/header.php';
switch ($currentPage) {
    case 'accueil':
        echo "bienvenu accueil";
    break;
    
    case 'inscription':
        echo "inscription";
    break;

    case 'connexion':
        echo "connexion";
    break;
    
    default:
        echo 404;
    break;
}
require_once '../elements/footer.php';