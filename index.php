<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu de Combat Tour par Tour</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>🗡️ Jeu de Combat Tour par Tour 🛡️</h1>
        
        <!-- FORMULAIRE DE SÉLECTION DU PERSONNAGE -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="personnage">Choisissez votre personnage :</label>
                <select name="personnage" id="personnage" required>
                    <option value="">-- Sélectionnez un personnage --</option>
                    <option value="1" <?php echo (isset($_POST['personnage']) && $_POST['personnage'] == '1') ? 'selected' : ''; ?>>
                        🛡️ Guerrier (120 PV, 15 Force) - Dégâts constants, résistant
                    </option>
                    <option value="2" <?php echo (isset($_POST['personnage']) && $_POST['personnage'] == '2') ? 'selected' : ''; ?>>
                        🗡️ Voleur (100 PV, 12 Force) - 30% de chance d'esquiver
                    </option>
                    <option value="3" <?php echo (isset($_POST['personnage']) && $_POST['personnage'] == '3') ? 'selected' : ''; ?>>
                        🔮 Magicien (90 PV, 8 Force) - 50% de chance de sort spécial (x2 dégâts)
                    </option>
                </select>
            </div>
            
            <button type="submit">⚔️ LANCER LE COMBAT !</button>
        </form>

<?php
// ========================================
// LOGIQUE PHP DU JEU DE COMBAT
// ========================================

// VÉRIFICATION : Le combat ne se déclenche que si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['personnage']) && !empty($_POST['personnage'])) {
    
    // INCLUSION des classes de personnages
    require_once 'Personnage.php';
    
    // RÉCUPÉRATION du choix du joueur
    $choix = (int)$_POST['personnage'];
    
    // AFFICHAGE des informations de début de partie
    echo '<div class="character-info">';
    echo '<h3>🎮 Début de la partie</h3>';
    
    // CRÉATION du personnage du joueur selon son choix
    switch ($choix) {
        case 1:
            $joueur = new Guerrier("Héros");
            echo '<p><strong>Vous jouez avec :</strong> 🛡️ Guerrier (120 PV, 15 Force)</p>';
            break;
        case 2:
            $joueur = new Voleur("Héros");
            echo '<p><strong>Vous jouez avec :</strong> 🗡️ Voleur (100 PV, 12 Force, esquive 30%)</p>';
            break;
        case 3:
            $joueur = new Magicien("Héros");
            echo '<p><strong>Vous jouez avec :</strong> 🔮 Magicien (90 PV, 8 Force, sort spécial 50%)</p>';
            break;
        default:
            $joueur = new Guerrier("Héros");
            echo '<p><strong>Erreur, Guerrier sélectionné par défaut</strong></p>';
    }
    
    // CRÉATION de l'adversaire (choix aléatoire)
    $adversaires = [
        new Guerrier("Ennemi Guerrier"),
        new Voleur("Ennemi Voleur"),
        new Magicien("Ennemi Magicien")
    ];
    $adversaire = $adversaires[array_rand($adversaires)];
    
    echo '<p><strong>Votre adversaire :</strong> ' . $adversaire->getNom() . '</p>';
    echo '</div>';
    
    // DÉBUT DU COMBAT - Capture de toute la sortie du combat
    ob_start();
    
    echo "\n=== DÉBUT DU COMBAT ===\n\n";
    
    // AFFICHAGE de l'état initial des personnages
    echo "État initial :\n";
    $joueur->afficherEtat();
    $adversaire->afficherEtat();
    echo "\n" . str_repeat("-", 40) . "\n\n";
    
    // BOUCLE DE COMBAT tour par tour
    $tour = 1;
    while ($joueur->estVivant() && $adversaire->estVivant()) {
        echo "=== TOUR " . $tour . " ===\n";
        
        // TOUR DU JOUEUR
        echo "🎯 Votre attaque :\n";
        $joueur->attaquer($adversaire);
        
        // VÉRIFICATION : adversaire encore en vie ?
        if (!$adversaire->estVivant()) {
            echo "\n💀 " . $adversaire->getNom() . " est vaincu !\n";
            break;
        }
        
        echo "\n";
        
        // TOUR DE L'ADVERSAIRE
        echo "🎯 Attaque de l'adversaire :\n";
        $adversaire->attaquer($joueur);
        
        // VÉRIFICATION : joueur encore en vie ?
        if (!$joueur->estVivant()) {
            echo "\n💀 " . $joueur->getNom() . " est vaincu !\n";
            break;
        }
        
        // AFFICHAGE de l'état après le tour
        echo "\nÉtat après le tour " . $tour . " :\n";
        $joueur->afficherEtat();
        $adversaire->afficherEtat();
        echo "\n" . str_repeat("-", 40) . "\n\n";
        
        $tour++;
        
        // SÉCURITÉ : éviter les boucles infinies
        if ($tour > 50) {
            echo "Combat trop long, arrêt automatique.\n";
            break;
        }
    }
    
    // AFFICHAGE du résultat final
    echo "\n=== FIN DU COMBAT ===\n\n";
    
    // DÉTERMINATION du gagnant et classe CSS pour le style
    $resultatClass = "";
    if ($joueur->estVivant()) {
        echo "🎉 VICTOIRE ! " . $joueur->getNom() . " remporte le combat !\n";
        echo "PV restants : " . $joueur->getVie() . "\n";
        $resultatClass = "victory";
    } else {
        echo "💀 DÉFAITE ! " . $adversaire->getNom() . " remporte le combat !\n";
        echo "PV restants de l'adversaire : " . $adversaire->getVie() . "\n";
        $resultatClass = "defeat";
    }
    
    echo "\n🎮 Cliquez sur le bouton pour rejouer !";
    
    // RÉCUPÉRATION de toute la sortie capturée
    $combatOutput = ob_get_clean();
    
    // AFFICHAGE du résultat dans une div stylée
    echo '<div class="combat-result ' . $resultatClass . '">';
    echo htmlspecialchars($combatOutput);
    echo '</div>';
}
?>

    </div>
</body>
</html>
