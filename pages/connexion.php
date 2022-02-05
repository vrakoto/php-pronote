<div class="mt-5">
    <?php if (isset($erreur)) : ?>
        <div class="container alert alert-danger text-center" style="width: 290px;">
            <?= $erreur ?>
        </div>
    <?php endif ?>

    <div class="d-flex justify-content-center" id="espaceConnexion">
        <div class="card">
            <a href="/menu"><i class="fas fa-arrow-left"></i> Revenir</a>

            <div class="text-center">
                <div class="card-body">
                    <h5 class="card-title">Espace <?= $espace ?></h5>
                    <?= $icone ?>
                </div>
                <img src="../img/SeparateurBulle.png" alt="">

                <form class="mb-0 mt-3" method="POST" action="/verifierConnexion">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="id" placeholder="Identifiant" autofocus>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="mdp" placeholder="Mot de passe">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 p-3">Connexion</button>
                </form>
            </div>

        </div>
    </div>
</div>