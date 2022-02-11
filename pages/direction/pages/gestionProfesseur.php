<div class="carteAccueil p-3 d-flex flex-wrap justify-content-center">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Liste des professeurs ajoutés</h5>
            <select id="lesProfesseursAjoutes" class="form-select" multiple aria-label="multiple select example"></select>
        </div>

        <hr>

        <div class="card-body">
            <h5 class="card-title">Liste des professeurs en attente</h5>
            <select id="lesProfesseursAttente" class="form-select" multiple aria-label="multiple select example"></select>
        </div>

        <hr>

        <div class="card-body">
            <h5 class="card-title">Ajouter un nouveau professeur</h5>

            <button class="btn btn-primary mt-3" onclick="ajouterProfesseur()">Créer</button>
            <button class="btn btn-danger mt-3 remove" onclick="supprimerEtablissement()" id="supprimerEtablissement">Supprimer</button>
        </div>
    </div>
</div>