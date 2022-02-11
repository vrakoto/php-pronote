<?php

class Direction extends Commun {
    protected $id;
    function __construct()
    {
        parent::__construct(); // Hériter le PDO
        $this->id = $_SESSION['id'];
    }
    
    function getMesEtablissements(): array
    {
        $req = "SELECT * FROM etablissement
                WHERE idDirecteur = :idDirecteur
                ORDER by nom";
        $p = $this->pdo->prepare($req);
        $p->execute(['idDirecteur' => $this->id]);

        return $p->fetchAll();
    }

    function modifierTextuelleEtablissement(int $idEtablissement, string $nomEtablissement, int $effectif, string $description): bool
    {
        $req = "UPDATE etablissement
                SET nom = :nom, effectif = :effectif, description = :description
                WHERE id = :idEtablissement AND idDirecteur = :idDirecteur";
        $p = $this->pdo->prepare($req);
        
        return $p->execute([
            'idEtablissement' => $idEtablissement,
            'idDirecteur' => $this->id,
            'nom' => ucfirst(strtolower($nomEtablissement)),
            'effectif' => $effectif,
            'description' => $description
        ]);
    }

    function modifierOptionsEtablissement(int $idEtablissement, string $option): bool
    {
        $req = "UPDATE etablissement_options
                SET acces = :option
                WHERE idEtablissement = :idEtablissement";
        $p = $this->pdo->prepare($req);
        
        return $p->execute([
            'idEtablissement' => $idEtablissement,
            'option' => $option
        ]);
    }

    function supprimerEtablissement(int $idEtablissement): bool
    {
        $req = "DELETE FROM etablissement WHERE id = :idEtablissement AND idDirecteur = :idDirecteur";
        $p = $this->pdo->prepare($req);
        
        return $p->execute([
            'idEtablissement' => $idEtablissement,
            'idDirecteur' => $this->id,
        ]);
    }


    /* Partie professeurs de l'etablissement */
    function getLesProfesseurs(): array
    {
        $req = "SELECT * FROM etablissement_professeurs ep
                JOIN etablissement e ON e.id = ep.idEtablissement
                JOIN professeur p ON p.idUtilisateur = ep.idProfesseur
                ORDER by p.nom";
        $p = $this->pdo->prepare($req);

        return $p->fetchAll();
    }
}