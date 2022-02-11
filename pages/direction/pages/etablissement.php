<?php if (isset($erreur)) : ?>
    <div class="container alert alert-danger" style="width: 290px;">
        <div class="text-center"><?= $erreur ?></div>
        <ul class="mt-3">
            <?php foreach ($erreurs as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<div class="carteAccueil p-3 d-flex flex-wrap justify-content-center">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Sélectionner un établissement</h5>
            <select id="mesEtablissements" class="form-select" multiple aria-label="multiple select example"></select>
        </div>

        <hr>

        <div class="card-body">
            <h5 class="card-title">Créer un nouvel établissement</h5>
            <input type="text" class="form-control" name="nomEtablissement" id="nomEtablissement" placeholder="Insérer un nom pour l'établissement">
            <input type="number" class="form-control mt-3" name="effectif" id="effectif" placeholder="Insérer l'effectif maximal">

            <button class="btn btn-primary mt-3" onclick="creerEtablissement()">Créer</button>
            <button class="btn btn-danger mt-3 remove" onclick="supprimerEtablissement()" id="supprimerEtablissement">Supprimer</button>
        </div>
    </div>
</div>

<div class="carteAccueil p-3 d-flex flex-wrap justify-content-center swap" id="cartesEtablissement">

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Modification textuelle</h5>

            <div class="mb-3">
                <label for="changerNom" class="form-label">Modifier le nom</label>
                <input type="text" class="form-control" id="changerNom">
            </div>

            <div class="mb-3">
                <label for="changerEffectif" class="form-label">Modifier l'effectif maximal</label>
                <input type="number" class="form-control" id="changerEffectif" min="1" max="5000">
            </div>

            <div class="mb-3">
                <label for="changerDescription" class="form-label">Modifier la description</label>
                <textarea id="changerDescription" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" onclick="modifierTextuelleEtablissement()">Modifier</button>
        </div>
    </div>

    <div class="card" id="optionsEtablissement">
        <div class="card-body">
            <h5 class="card-title mb-4">Options</h5>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="accesTous" value="tous">
                <label class="form-check-label" for="accesTous">
                    Autoriser l'accès étudiant pour tous
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="accesInvitation" value="invitation">
                <label class="form-check-label" for="accesInvitation">
                    Autoriser l'accès étudiant uniquement sur invitation
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="accesSelection" value="selectivement">
                <label class="form-check-label" for="accesSelection">
                    Autoriser l'accès étudiant sélectivement
                </label>
            </div>

            <button type="submit" class="btn btn-primary" onclick="modifierOptionsEtablissement()">Modifier</button>
        </div>
    </div>
</div>