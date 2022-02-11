<?php

switch ($currentPage) {
    case 'accueil':
        require_once 'pages' . DIRECTORY_SEPARATOR . 'accueil.php';
    break;

    case 'etablissement':
        $mesEtablissement = $direction->getMesEtablissements();
        require_once 'pages' . DIRECTORY_SEPARATOR . 'etablissement.php';
    break;

    case 'professeurs':
        require_once 'pages' . DIRECTORY_SEPARATOR . 'gestionProfesseur.php';
    break;

    case 'ajax':
        switch ($urls[2]) {
            
            case 'getMesEtablissements':
                $mesEtablissement = $direction->getMesEtablissements();
                foreach ($mesEtablissement as $etablissement) {
                    $id = (int)$etablissement['id'];
                    $nom = htmlentities($etablissement['nom']);
                    echo "<option value='$id' onclick='getInfosEtablissement($id)'>$nom</option>";
                }
            break;

            case 'getInfosEtablissement':
                $idEtablissement = (int)$_GET['idEtablissement'];
                $etablissement = $pdo->getInfosEtablissement($idEtablissement);

                echo json_encode($etablissement);
            break;

            case 'modifierTextuelleEtablissement':
                if (isset($_POST['id'], $_POST['nom'], $_POST['effectif'], $_POST['description'])) {
                    $erreurs = [];
                    $idEtablissement = (int)$_POST['id'];
                    $nom = htmlentities($_POST['nom']);
                    $effectif = (int)$_POST['effectif'];
                    $description = htmlentities($_POST['description']);

                    if (strlen($nom) <= 2) {
                        $erreurs['nom'] = 'Le nom est trop court';
                    }

                    if ($effectif < 1 || $effectif > 5000) {
                        $erreurs['effectif'] = 'Effectif supérieur ou égal à 0 ou supérieur à 5 000';
                    }

                    if (empty($erreurs)) {
                        $direction->modifierTextuelleEtablissement($idEtablissement, $nom, $effectif, $description);
                    } else {
                        $erreurs['general'] = 'Formulaire incorrect';
                    }

                    echo json_encode(['erreurs' => $erreurs]);
                }
            break;

            case 'modifierOptionsEtablissement':
                if (isset($_POST['idEtablissement'], $_POST['option'])) {
                    $erreurs = [];
                    $idEtablissement = (int)$_POST['idEtablissement'];
                    $option = htmlentities($_POST['option']);

                    if (empty($erreurs)) {
                        $direction->modifierOptionsEtablissement($idEtablissement, $option);
                    } else {
                        $erreurs['general'] = 'Problème Option';
                    }

                    echo json_encode(['erreurs' => $erreurs]);
                }
            break;

            case 'creerEtablissement':
                if (isset($_POST['nom'], $_POST['effectif'])) {
                    $erreurs = [];
                    $nom = htmlentities($_POST['nom']);
                    $effectif = (int)$_POST['effectif'];
                    
                    $etablissement = new CreationEtablissement($nom, $effectif);
                    if (!$etablissement->isValid()) {
                        $erreurs = $etablissement->getErreurs();
                    } else {
                        $etablissement->inscrire();
                        $etablissement->creerOption();
                    }

                    echo json_encode(['erreurs' => $erreurs]);
                }
            break;

            case 'supprimerEtablissement':
                if (isset($_POST['idEtablissement'])) {
                    $erreurs = [];
                    $idEtablissement = (int)$_POST['idEtablissement'];

                    if (empty($erreurs)) {
                        $direction->supprimerEtablissement($idEtablissement);
                    } else {
                        $erreurs['general'] = 'Erreur suppression';
                    }

                    echo json_encode(['erreurs' => $erreurs]);
                }
            break;



            /* Partie professeur */
            case 'getLesProfesseurs':
                $lesProfesseurs = $direction->getLesProfesseurs();
                foreach ($lesProfesseurs as $professeur) {
                    $id = (int)$professeur['id'];
                    $prenom = htmlentities($professeur['prenom']);
                    $nom = htmlentities($professeur['nom']);
                    echo "<option value='$id' onclick='getInfosProfesseur($id)'>$nom</option>";
                }
            break;

            case 'getInfosProfesseursAjoutes':
                
            break;
        }
    break;
}