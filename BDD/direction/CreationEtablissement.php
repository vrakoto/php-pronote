<?php

class CreationEtablissement extends Direction {
    private $idDirection;
    private $nomEtablissement;
    private $effectif;

    function __construct(string $nomEtablissement, int $effectif)
    {
        parent::__construct(); // Hériter le PDO
        $this->idDirection = $_SESSION['id'];
        $this->nomEtablissement = $nomEtablissement;
        $this->effectif = $effectif;
    }

    function isValid(): bool
    {
        return empty($this->getErreurs());
    }

    function getErreurs(): array
    {
        $erreurs = [];

        if (strlen($this->nomEtablissement) < 2) {
            $erreurs['nom'] = "Le nom de l'établissement est trop court";
        }

        if ($this->effectif < 1 || $this->effectif > 5000) {
            $erreurs['effectif'] = "L'effectif ne doit pas être inférieur ou égal à 0 ni supérieur à 5.000";
        }

        return $erreurs;
    }

    function inscrire(): bool
    {
        $req = "INSERT INTO etablissement (idDirecteur, nom, effectif) VALUES (:idDirecteur, :nom, :effectif)";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'idDirecteur' => $this->idDirection,
            'nom' => ucfirst(strtolower($this->nomEtablissement)),
            'effectif' => $this->effectif
        ]);
    }

    function creerOption(): bool
    {
        $req = "INSERT INTO etablissement_options (idEtablissement) 
                VALUES
                (
                    (SELECT id FROM etablissement
                    WHERE idDirecteur = :id
                    ORDER BY dateCreation DESC LIMIT 1
                    )
                )";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'id' => $this->idDirection
        ]);
    }
}