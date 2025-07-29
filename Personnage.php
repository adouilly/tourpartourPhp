<?php

// CLASSE PARENTE : Personnage
class Personnage
{
    protected $nom;
    protected $vie;
    protected $force;

    public function __construct($nom, $vie, $force)
    {
        $this->nom = $nom;
        $this->vie = $vie;
        $this->force = $force;
    }

    public function attaquer($adversaire)
    {
        $degats = $this->force;
        echo $this->nom . " attaque " . $adversaire->nom . " et inflige " . $degats . " dégâts\n";
        $adversaire->recevoirDegats($degats);
    }

    public function recevoirDegats($degats)
    {
        $this->vie -= $degats;
        if ($this->vie < 0) {
            $this->vie = 0;
        }
    }

    public function afficherEtat()
    {
        echo $this->nom . " : " . $this->vie . " PV\n";
    }

    public function estVivant()
    {
        return $this->vie > 0;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getVie()
    {
        return $this->vie;
    }

    public function getForce()
    {
        return $this->force;
    }

    public function setNom($nouveauNom)
    {
        $this->nom = $nouveauNom;
    }

    public function setVie($nouvelleVie)
    {
        $this->vie = $nouvelleVie;
    }

    public function setForce($nouvelleForce)
    {
        $this->force = $nouvelleForce;
    }
}

// CLASSE FILLE : Guerrier
class Guerrier extends Personnage
{
    public function __construct($nom)
    {
        parent::__construct($nom, 120, 15);
    }
}

// CLASSE FILLE : Voleur
class Voleur extends Personnage
{
    public function __construct($nom)
    {
        parent::__construct($nom, 100, 12);
    }

    public function recevoirDegats($degats)
    {
        if (rand(1, 100) <= 30) {
            echo $this->nom . " esquive l'attaque !\n";
            return;
        }
        parent::recevoirDegats($degats);
    }
}

// CLASSE FILLE : Magicien
class Magicien extends Personnage
{
    public function __construct($nom)
    {
        parent::__construct($nom, 90, 8);
    }

    public function attaquer($adversaire)
    {
        $degats = $this->force;
        
        if (rand(1, 100) <= 50) {
            $degats *= 2;
            echo $this->nom . " lance un sort spécial ! ";
        }
        
        echo $this->nom . " attaque " . $adversaire->nom . " et inflige " . $degats . " dégâts\n";
        $adversaire->recevoirDegats($degats);
    }
}
