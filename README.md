# Tasko - Plateforme de Gestion de Projet Agile

## Fonctionnalités

- **Gestion de Projets** : Création de projets avec codes d'accès uniques.
- **Rôles Utilisateurs** : Étudiant, Chef de Projet, et Enseignant avec des permissions spécifiques (via Laravel Policies).
- **Tableau de Bord Agile** : Gestion des Sprints et Roadmap.
- **Suivi des Tâches** : Création, modification et suppression de tâches avec pièces jointes.
- **Releases & Epics** : Organisation du travail à haut niveau.

## Prérequis

Avant l'installation, assurez-vous d'avoir :
- PHP >= 8.1
- Composer
- Node.js & NPM
- Un serveur de base de données (MySQL, PostgreSQL ou SQLite)

## Installation en local

1. **Cloner le dépôt**
   ```bash
   git clone https://github.com/votre-utilisateur/tasko.git
   cd tasko
   ```

2. **Installer les dépendances PHP**
   ```bash
   composer install
   ```

3. **Installer les dépendances JavaScript**
   ```bash
   npm install
   npm run build
   ```

4. **Configuration de l'environnement**
   Copiez le fichier d'exemple pour créer votre fichier `.env` :
   ```bash
   cp .env.example .env
   ```
   *Note : Modifiez le fichier `.env` pour configurer vos accès à la base de données (DB_DATABASE, DB_USERNAME, DB_PASSWORD).*

5. **Générer la clé d'application**
   ```bash
   php artisan key:generate
   ```

6. **Lancer les migrations**
   ```bash
   php artisan migrate
   ```

7. **Lancer le serveur de développement**
   ```bash
   php artisan serve
   ```
   L'application sera disponible sur `http://localhost:8000`.
