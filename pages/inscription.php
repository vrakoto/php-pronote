<div class="mt-5">
    <?php if (isset($erreur)) : ?>
        <div class="container alert alert-danger" style="width: 290px;">
            <div class="text-center"><?= $erreur ?></div>
            <ul class="mt-3">
                <?php foreach ($erreurs as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <div class="d-flex justify-content-center" id="espaceConnexion">
        <div class="card">
            <a href="/<?= $espace ?>"><i class="fas fa-arrow-left"></i> Revenir</a>

            <div class="text-center">
                <div class="card-body">
                    <h5 class="card-title">Créer un compte : <?= $espace ?></h5>
                    <?= $icone ?>
                </div>
                <img src="../img/SeparateurBulle.png" alt="">

                <form class="mb-0 mt-3" method="POST" action="/inscription">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="id" placeholder="Insérer un identifiant" autofocus>
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control" name="nom" placeholder="Insérer votre nom" autofocus>
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control" name="prenom" placeholder="Insérer votre prénom" autofocus>
                    </div>

                    <div class="mb-3">
                        <input type="password" class="form-control" name="mdp" placeholder="Mot de passe">
                    </div>

                    <div class="mb-3">
                        <input type="password" class="form-control" name="mdp_confirm" placeholder="Confirmer Mot de passe">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 p-3">S'inscrire</button>
                </form>
            </div>

        </div>
    </div>
</div>