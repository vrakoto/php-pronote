<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= $css ?>">
    <title>Projet - Pronote</title>
</head>

<body>

<?php if (!empty($id)) : ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><?= $id ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?= nav_item('/accueil', 'Accueil') ?>

                    <?php if ($pdo->getUtilisateur($id)['espace'] === 'direction') : ?>
                        <?= nav_item('/etablissement', 'Administration établissement') ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Administration utilisateur
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/professeurs">Les professeurs</a></li>
                                <li><a class="dropdown-item" href="/etudiants">Les étudiants</a></li>
                            </ul>
                        </li>
                    <?php endif ?>


                    <?php if ($pdo->getUtilisateur($id)['espace'] === 'professeur') : ?>
                        <?= nav_item('/eleves', 'Administrer élève') ?>
                        <?= nav_item('/cours', 'Administrer cours') ?>
                    <?php endif ?>


                    <?php if ($pdo->getUtilisateur($id)['espace'] === 'etudiant') : ?>
                        <?= nav_item('/donnees', 'Mes données') ?>
                        <?= nav_item('/devoirs', 'Cahier de texte') ?>
                        <?= nav_item('/notes', 'Notes') ?>
                        <?= nav_item('/communication', 'Communication') ?>
                    <?php endif ?>
                </ul>
                <form class="d-flex">
                    <a href="/deconnexion" class="btn btn-danger">Deconnexion</a>
                </form>
            </div>
        </div>
    </nav>
<?php endif ?>

<div class="modal fade" id="message" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>