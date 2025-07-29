<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu de Combat Simple</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>🗡️ Jeu de Combat Simple 🛡️</h1>
        
        <!-- FORMULAIRE SIMPLE -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="personnage">Choisissez votre personnage :</label>
                <select name="personnage" id="personnage" required>
                    <option value="">-- Sélectionnez un personnage --</option>
                    <option value="guerrier">🛡️ Guerrier (120 PV, 15 Force)</option>
                    <option value="voleur">🗡️ Voleur (100 PV, 12 Force)</option>
                    <option value="magicien">🔮 Magicien (90 PV, 8 Force)</option>
                </select>
            </div>
            
            <button type="submit">⚔️ LANCER LE COMBAT !</button>
        </form>

<?php
// ========================================
// CLASSES DIRECTEMENT DANS LE FICHIER (pas de require_once)
// ========================================

// CLASSE PARENTE : Personnage
// Cette classe contient tout ce qui est commun à tous les personnages
class Personnage
{
    // PROPRIÉTÉS (variables de la classe)
    // protected = accessible dans cette classe ET dans les classes filles
    protected $nom;     // Le nom du personnage
    protected $vie;     // Les points de vie du personnage  
    protected $force;   // La force d'attaque du personnage

    // CONSTRUCTEUR : fonction appelée automatiquement quand on crée un personnage
    // Exemple : new Personnage("Jean", 100, 10)
    public function __construct($nom, $vie, $force)
    {
        $this->nom = $nom;       // $this = l'objet en cours de création
        $this->vie = $vie;       // On assigne les valeurs reçues
        $this->force = $force;   // aux propriétés de l'objet
    }

    // MÉTHODE : fonction pour attaquer un autre personnage
    public function attaquer($adversaire)
    {
        $degats = $this->force;  // Les dégâts = la force du personnage
        echo $this->nom . " attaque " . $adversaire->nom . " et inflige " . $degats . " dégâts\n";
        $adversaire->recevoirDegats($degats);  // On dit à l'adversaire qu'il subit des dégâts
    }

    // MÉTHODE : fonction pour recevoir des dégâts
    public function recevoirDegats($degats)
    {
        $this->vie = $this->vie - $degats;    // On enlève les dégâts de la vie
        if ($this->vie < 0) {                 // Si la vie devient négative
            $this->vie = 0;                   // On la remet à 0 (pas de vie négative)
        }
    }

    // MÉTHODE : fonction pour afficher l'état du personnage
    public function afficherEtat()
    {
        echo $this->nom . " : " . $this->vie . " PV\n";
    }

    // MÉTHODE : fonction pour savoir si le personnage est encore vivant
    // Retourne true (vrai) si vie > 0, false (faux) sinon
    public function estVivant()
    {
        return $this->vie > 0;
    }

    // GETTER : fonction pour récupérer le nom du personnage
    // Les getters permettent d'accéder aux propriétés protected depuis l'extérieur
    public function getNom()
    {
        return $this->nom;
    }

    // GETTER : fonction pour récupérer la vie du personnage
    public function getVie()
    {
        return $this->vie;
    }
}

// CLASSE FILLE : Guerrier
// "extends Personnage" = le Guerrier hérite de tout ce que fait Personnage
class Guerrier extends Personnage
{
    // CONSTRUCTEUR spécial pour le Guerrier
    // Il ne demande que le nom, car les stats sont fixes (120 PV, 15 Force)
    public function __construct($nom)
    {
        // parent::__construct() = on appelle le constructeur de la classe parente (Personnage)
        // On donne les valeurs spécifiques au Guerrier
        parent::__construct($nom, 120, 15);
    }
    // Le Guerrier n'a pas de capacité spéciale
    // Il utilise toutes les méthodes de Personnage sans les modifier
}

// CLASSE FILLE : Voleur  
// Le Voleur hérite de Personnage mais a une capacité spéciale : esquiver
class Voleur extends Personnage
{
    // CONSTRUCTEUR du Voleur (100 PV, 12 Force)
    public function __construct($nom)
    {
        parent::__construct($nom, 100, 12);
    }

    // MÉTHODE REDÉFINIE : le Voleur a sa propre version de recevoirDegats()
    // Cette méthode remplace celle de Personnage pour le Voleur
    public function recevoirDegats($degats)
    {
        // rand(1, 100) = nombre aléatoire entre 1 et 100
        // Si le nombre est <= 30, alors esquive (30% de chance)
        if (rand(1, 100) <= 30) {
            echo $this->nom . " esquive l'attaque !\n";
            return; // On sort de la fonction sans subir de dégâts
        }
        
        // Si pas d'esquive, on utilise la méthode normale de Personnage
        parent::recevoirDegats($degats);
    }
}

// CLASSE FILLE : Magicien
// Le Magicien hérite de Personnage mais a une capacité spéciale : sort puissant
class Magicien extends Personnage
{
    // CONSTRUCTEUR du Magicien (90 PV, 8 Force - le plus faible mais avec magie)
    public function __construct($nom)
    {
        parent::__construct($nom, 90, 8);
    }

    // MÉTHODE REDÉFINIE : le Magicien a sa propre version d'attaquer()
    // Cette méthode remplace celle de Personnage pour le Magicien
    public function attaquer($adversaire)
    {
        $degats = $this->force; // On commence avec la force de base (8)
        
        // 50% de chance de lancer un sort spécial
        if (rand(1, 100) <= 50) {
            $degats = $degats * 2; // On multiplie les dégâts par 2
            echo $this->nom . " lance un sort spécial ! ";
        }
        
        // On affiche l'attaque et on applique les dégâts
        echo $this->nom . " attaque " . $adversaire->nom . " et inflige " . $degats . " dégâts\n";
        $adversaire->recevoirDegats($degats);
    }
}

// ========================================
// LOGIQUE SIMPLE DU JEU (avec commentaires détaillés)
// ========================================

// VÉRIFICATION : Est-ce qu'un personnage a été choisi ?
// $_POST['personnage'] contient la valeur du formulaire si il a été envoyé
// isset() vérifie si cette variable existe et n'est pas null
if (isset($_POST['personnage'])) {
            
            // RÉCUPÉRATION du choix de personnage depuis le formulaire
            $choix = $_POST['personnage'];
            
            echo '<div class="character-info">';
            echo '<h3>🎮 Début de la partie</h3>';
            
            // ========================================
            // CRÉATION DU PERSONNAGE DU JOUEUR
            // Utilisation de IF/ELSEIF au lieu de SWITCH pour plus de simplicité
            // ========================================
            
            if ($choix == "guerrier") {
                // new Guerrier() = on crée un nouvel objet de type Guerrier
                // Le constructeur va automatiquement donner 120 PV et 15 Force
                $joueur = new Guerrier("Héros");
                echo '<p><strong>Vous jouez avec :</strong> 🛡️ Guerrier (Robuste et puissant !)</p>';
                
            } elseif ($choix == "voleur") {
                // Le Voleur a 100 PV, 12 Force et peut esquiver les attaques
                $joueur = new Voleur("Héros");
                echo '<p><strong>Vous jouez avec :</strong> 🗡️ Voleur (Rapide et agile !)</p>';
                
            } elseif ($choix == "magicien") {
                // Le Magicien a 90 PV, 8 Force mais des sorts puissants
                $joueur = new Magicien("Héros");
                echo '<p><strong>Vous jouez avec :</strong> 🔮 Magicien (Magie puissante !)</p>';
                
            } else {
                // Si le choix n'est pas reconnu, on met un Guerrier par défaut
                $joueur = new Guerrier("Héros");
                echo '<p><strong>Erreur, Guerrier par défaut</strong></p>';
            }
            
            // ========================================
            // CRÉATION AUTOMATIQUE DE L'ADVERSAIRE
            // L'ordinateur choisit un ennemi au hasard
            // ========================================
            
            // rand(1, 3) = nombre aléatoire entre 1 et 3
            $numeroAdversaire = rand(1, 3);
            
            if ($numeroAdversaire == 1) {
                $adversaire = new Guerrier("Ennemi Guerrier");
                echo '<p><strong>Votre adversaire :</strong> ⚔️ Guerrier Ennemi</p>';
                
            } elseif ($numeroAdversaire == 2) {
                $adversaire = new Voleur("Ennemi Voleur");
                echo '<p><strong>Votre adversaire :</strong> 🗡️ Voleur Ennemi</p>';
                
            } else { // Si c'est 3 ou autre chose
                $adversaire = new Magicien("Ennemi Magicien");
                echo '<p><strong>Votre adversaire :</strong> 🔮 Magicien Ennemi</p>';
            }
            
            echo '</div>';
            
            // DÉBUT DU COMBAT
            ob_start();
    
    echo "\n=== DÉBUT DU COMBAT ===\n\n";
    
    echo "État initial :\n";
    $joueur->afficherEtat();
    $adversaire->afficherEtat();
    echo "\n----------------------------------------\n\n";
    
    // COMBAT SIMPLE
    $tour = 1;
    while ($joueur->estVivant() && $adversaire->estVivant()) {
        echo "=== TOUR " . $tour . " ===\n";
        
        // Tour du joueur
        echo "🎯 Votre attaque :\n";
        $joueur->attaquer($adversaire);
        
        if (!$adversaire->estVivant()) {
            echo "\n💀 " . $adversaire->getNom() . " est vaincu !\n";
            break;
        }
        
        echo "\n";
        
        // Tour de l'adversaire
        echo "🎯 Attaque de l'adversaire :\n";
        $adversaire->attaquer($joueur);
        
        if (!$joueur->estVivant()) {
            echo "\n💀 " . $joueur->getNom() . " est vaincu !\n";
            break;
        }
        
        echo "\nÉtat après le tour " . $tour . " :\n";
        $joueur->afficherEtat();
        $adversaire->afficherEtat();
        echo "\n----------------------------------------\n\n";
        
        $tour = $tour + 1;
        
        if ($tour > 50) {
            echo "Combat trop long, arrêt automatique.\n";
            break;
        }
    }
    
    echo "\n=== FIN DU COMBAT ===\n\n";
    
    $resultatClass = "";
    if ($joueur->estVivant()) {
        echo "🎉 VICTOIRE ! " . $joueur->getNom() . " gagne !\n";
        echo "PV restants : " . $joueur->getVie() . "\n";
        $resultatClass = "victory";
    } else {
        echo "💀 DÉFAITE ! " . $adversaire->getNom() . " gagne !\n";
        echo "PV restants de l'adversaire : " . $adversaire->getVie() . "\n";
        $resultatClass = "defeat";
    }
    
    echo "\n🎮 Rechargez pour rejouer !";
    
    $combatOutput = ob_get_clean();
    
    echo '<div class="combat-result ' . $resultatClass . '">';
    echo htmlspecialchars($combatOutput);
    echo '</div>';
    
    echo '<p><a href="' . $_SERVER['PHP_SELF'] . '">🔄 Rejouer</a></p>';
    
} else {
    // Affichage du message si aucun personnage n'a été sélectionné
    echo '<p>🎮 <strong>Sélectionnez un personnage pour commencer le combat !</strong></p>';
}
?>

    </div>
</body>
</html>
