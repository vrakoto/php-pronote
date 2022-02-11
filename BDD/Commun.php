<?php

class Commun {
    protected $pdo;

    function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=pronote', 'root', null, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    function getUtilisateur(string $id): array
    {
        $req = "SELECT * FROM utilisateur WHERE id = :id";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'id' => $id
        ]);

        return $p->fetch();
    }

    function verifierAuth(string $id, string $mdp, string $espace): bool
    {
        $req = "SELECT * FROM utilisateur WHERE id = :id AND espace = :espace";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'id' => $id,
            'espace' => $espace
        ]);

        return !empty($p->fetch()) && password_verify($mdp, $this->getUtilisateur($id)['mdp']);
    }

    function getInfosEtablissement(int $idEtablissement): array
    {
        $req = "SELECT * FROM etablissement 
                JOIN etablissement_options on idEtablissement = etablissement.id
                WHERE etablissement.id = :id";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'id' => $idEtablissement
        ]);

        return $p->fetch();
    }
}