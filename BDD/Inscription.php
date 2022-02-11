<?php

class Inscription extends Commun {
    private $id;
    private $nom;
    private $prenom;
    private $mdp;
    private $mdp_confirm;
    private $espace;

    function __construct(string $id, string $nom, string $prenom, string $mdp, string $mdp_confirm, string $espace)
    {
        parent::__construct(); // Hériter le PDO
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mdp = $mdp;
        $this->mdp_confirm = $mdp_confirm;
        $this->espace= $espace;
    }

    function inscriptionCorrecte(): bool
    {
        return empty($this->getErreurs());
    }

    function identifiantExistant(string $id): bool
    {
        $req = "SELECT id FROM utilisateur WHERE id = :id";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'id' => $id
        ]);

        return !empty($p->fetch());
    }

    function getErreurs(): array
    {
        $erreurs = [];
        if (strlen($this->id) < 2) {
            $erreurs['id'] = "Identifiant trop court";
        }

        if ($this->identifiantExistant($this->id)) {
            $erreurs['id'] = "Identifiant déjà prit";
        }
        
        if (strlen($this->nom) < 1) {
            $erreurs['nom'] = "Nom trop court";
        }
        
        if (strlen($this->prenom) < 1) {
            $erreurs['prenom'] = "Prénom trop court";
        }

        if (strlen($this->mdp) < 2) {
            $erreurs['mdp'] = "Mot de passe trop court";
        }

        if ($this->mdp !== $this->mdp_confirm) {
            $erreurs['mdp'] = "Les mots de passe ne correspondent pas";
        }

        return $erreurs;
    }

    function inscrire(): bool
    {
        $req = "INSERT INTO utilisateur (id, nom, prenom, mdp, espace) VALUES (:id, :nom, :prenom, :mdp, :espace)";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'id' => $this->id,
            'nom' => ucfirst(strtolower($this->nom)),
            'prenom' => ucfirst(strtolower($this->prenom)),
            'mdp' => password_hash($this->mdp,  PASSWORD_DEFAULT, ['cost' => 12]),
            'espace' => $this->espace
        ]);
    }

    function inscrireProfesseur(int $age, string $specialite): bool
    {
        $req = "INSERT INTO etablissement_professeurs (idUtilisateur, age, specialite) VALUES (:idUtilisateur, :age, :specialite)";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'idUtilisateur' => $this->id,
            'age' => $age,
            'specialite' => $specialite
        ]);
    }
}