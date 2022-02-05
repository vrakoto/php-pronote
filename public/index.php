<?php
session_start();
$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;
$bdd = $root . 'BDD' . DIRECTORY_SEPARATOR;
require_once $bdd . 'Commun.php';
$pdo = new Commun;

$pages = $root . 'pages' . DIRECTORY_SEPARATOR;
$elements = $root . 'elements' . DIRECTORY_SEPARATOR;

$css =  '../../../CSS/main.css';
require_once $elements . 'helper.php';

$removeSlash = explode('/', $_SERVER['REQUEST_URI']);
$urls = array_filter($removeSlash);
if (empty($urls)) {
    $currentPage = 'menu';
} else {
    $currentPage = $urls[1];
}

$id = $_SESSION['id'] ?? '';
$espace = $_SESSION['connexion'] ?? '';
$icone = $_SESSION['icone'] ?? '';

require_once $elements . 'header.php';

if (!$id) {
    switch ($currentPage) {
        case 'menu':
            require_once $pages . 'menu.php';
        break;
    
        case 'direction':
            $_SESSION['connexion'] = "direction";
            $_SESSION['icone'] = '<i class="iconeEspace fas fa-user-cog mt-3"></i>';
            $icone = $_SESSION['icone'];
            $espace = 'Direction';
            require_once $pages . 'connexion.php';
        break;
    
        case 'professeur':
            $_SESSION['connexion'] = "professeur";
            $_SESSION['icone'] = '<i class="iconeEspace fas fa-user-tie mt-3"></i>';
            $icone = $_SESSION['icone'];
            $espace = 'Professeur';
            require_once $pages . 'connexion.php';
        break;
    
        case 'etudiant':
            $_SESSION['connexion'] = "etudiant";
            $_SESSION['icone'] = '<i class="iconeEspace fas fa-user-graduate mt-3"></i>';
            $icone = $_SESSION['icone'];
            $espace = 'Etudiant';
            require_once $pages . 'connexion.php';
        break;
    
        case 'verifierConnexion':
            if (isset($_POST['id'], $_POST['mdp'])) {
                $id = htmlentities($_POST['id']);
                $mdp = htmlentities($_POST['mdp']);
    
                if (!$pdo->verifierAuth($id, $mdp, $espace)) {
                    $erreur = 'Authentication incorrecte';
                    require_once $pages . 'connexion.php';
                } else {
                    $_SESSION['id'] = $id;
                    unset($_SESSION['connexion']);
                    unset($_SESSION['icone']);
                    header("Location:/accueil");
                    exit();
                }
            }
        break;

        default:
            header('Location:/menu');
            exit();
        break;
    }
} else {
    $espace = $pdo->getUtilisateur($id)['espace'];
    switch ($espace) {
        case 'direction':
            require $pages . 'direction' . DIRECTORY_SEPARATOR . 'index.php';
        break;

        case 'professeur':
            require $pages . 'professeur' . DIRECTORY_SEPARATOR . 'index.php';
        break;

        case 'etudiant':
            require $pages . 'etudiant' . DIRECTORY_SEPARATOR . 'index.php';
        break;
    }

    switch ($currentPage) {
        case 'deconnexion':
            session_destroy();
            header('Location:/menu');
            exit();
        break;

        case '404':
            require_once $pages . '404.php';
        break;
    }
}

require_once $elements . 'footer.php';