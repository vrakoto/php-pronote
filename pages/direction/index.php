<?php

switch ($currentPage) {
    case 'accueil':
        require_once 'pages' . DIRECTORY_SEPARATOR . 'accueil.php';
    break;

    case 'etablissement':
        require_once 'pages' . DIRECTORY_SEPARATOR . 'etablissement.php';
    break;
}