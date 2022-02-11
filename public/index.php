<?php
session_start();
$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;
$bdd = $root . 'BDD' . DIRECTORY_SEPARATOR;
require_once $bdd . 'Commun.php';
$pdo = new Commun;

$pages = $root . 'pages' . DIRECTORY_SEPARATOR;
$elements = $root . 'elements' . DIRECTORY_SEPARATOR;

$css =  '../../../CSS/main.css';
$js = '../../../JS/main.js';
require_once $elements . 'helper.php';

$urls = array_filter(explode('/', $_SERVER['REQUEST_URI']));
if (empty($urls)) {
    $currentPage = 'menu';
} else {
    $currentPage = $urls[1];
}

$id = $_SESSION['id'] ?? '';
$espace = $_SESSION['connexion'] ?? '';
$icone = $_SESSION['icone'] ?? '';

if (!in_array('ajax', $urls)) {
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
    
            case 'inscription':
                if ($espace) {
                    require_once $bdd . 'Inscription.php';
                    if (isset($_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['mdp'], $_POST['mdp_confirm'])) {
                        $id = htmlentities($_POST['id']);
                        $nom = htmlentities($_POST['nom']);
                        $prenom = htmlentities($_POST['prenom']);
                        $mdp = htmlentities($_POST['mdp']);
                        $mdp_confirm = htmlentities($_POST['mdp_confirm']);
    
                        $inscription = new Inscription($id, $nom, $prenom, $mdp, $mdp_confirm, $espace);
    
                        if (!$inscription->inscriptionCorrecte()) {
                            $erreur = 'Le formulaire est incorrect';
                            $erreurs = $inscription->getErreurs();
                        } else {
                            switch ($espace) {
                                case 'direction':
                                    # code...
                                break;
                                
                                case 'professeur':
                                    $inscription->inscrireProfesseur($age, $specialite);
                                break;

                                case 'etudiant':
                                    //$inscription->inscrireEtudiant($age, $niveau);
                                break;
                            }
                            $inscription->inscrire();
                            header("Location:/" . $espace);
                            exit();
                        }
                    }
                    require_once $pages . 'inscription.php';
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
                require_once $bdd . 'direction' . DIRECTORY_SEPARATOR . 'Direction.php';
                $direction = new Direction($id);
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

} else {
    // Ajax
    $urls = array_filter(explode('/', $_SERVER['REDIRECT_URL']));

    $espace = $pdo->getUtilisateur($id)['espace'];
    switch ($espace) {
        case 'direction':
            require_once $bdd . 'direction' . DIRECTORY_SEPARATOR . 'Direction.php';
            require_once $bdd . 'direction' . DIRECTORY_SEPARATOR . 'CreationEtablissement.php';
            $direction = new Direction($id);
            require $pages . 'direction' . DIRECTORY_SEPARATOR . 'index.php';
        break;

        case 'professeur':
            require $pages . 'professeur' . DIRECTORY_SEPARATOR . 'index.php';
        break;

        case 'etudiant':
            require $pages . 'etudiant' . DIRECTORY_SEPARATOR . 'index.php';
        break;
    }
}