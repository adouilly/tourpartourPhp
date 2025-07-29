# 🗡️ Jeu de Combat Tour par Tour

Un mini-jeu de combat développé en PHP avec interface web utilisant la Programmation Orientée Objet (OOP).

## 📁 Structure des fichiers

- **`index.php`** - Version complète avec classes intégrées et CSS externe
- **`jeu_simple.php`** - Version éducative avec commentaires détaillés (si créée)
- **`style.css`** - Feuille de style CSS externe
- **`EXPLICATION_CODE.md`** - Guide détaillé des concepts OOP utilisés
- **`README.md`** - Documentation du projet

## 🚀 Installation et utilisation

1. Placez tous les fichiers dans un serveur web (XAMPP, WAMP, etc.)
2. Ouvrez `index.php` dans un navigateur
3. Choisissez votre personnage dans la liste déroulante
4. Cliquez sur "⚔️ LANCER LE COMBAT !"
5. Le combat se déroule automatiquement contre un adversaire aléatoire
6. Cliquez sur "🔄 Rejouer" pour recommencer

## ⚔️ Personnages disponibles

- 🛡️ **Guerrier** (120 PV, 15 Force) - Robuste et puissant, pas de capacité spéciale
- 🗡️ **Voleur** (100 PV, 12 Force) - 30% de chance d'esquiver les attaques
- 🔮 **Magicien** (90 PV, 8 Force) - 50% de chance de lancer un sort spécial (x2 dégâts)

## 🏗️ Concepts PHP OOP utilisés

- **Héritage** (`extends`) - Les classes filles héritent de la classe `Personnage`
- **Constructeurs** (`__construct`) - Initialisation automatique des objets
- **Appel au parent** (`parent::__construct`) - Réutilisation du code parent
- **Méthodes redéfinies** - Chaque classe peut avoir sa propre version d'une méthode
- **Encapsulation** (`protected`) - Protection des propriétés internes
- **Getters** - Accès contrôlé aux propriétés privées/protégées

## 🎮 Fonctionnalités

- Interface web responsive avec CSS
- Combat tour par tour automatique
- Adversaire généré aléatoirement
- Mécaniques spéciales par classe (esquive, sorts)
- Affichage détaillé du combat
- Possibilité de rejouer facilement

## 📚 Pour apprendre

Consultez le fichier `EXPLICATION_CODE.md` pour une explication détaillée de tous les concepts utilisés dans ce projet. 
