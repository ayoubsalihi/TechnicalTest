# To-Do List Professionnelle - Laravel & Vue.js

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel)
![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?logo=vuedotjs)

##  Description

Application full stack de gestion de tâches avec :
- Backend Laravel (API REST)
- Frontend Vue.js 3 (Composition API)
- Authentification JWT
- Notifications en temps réel via Pusher
- Architecture professionnelle (SOLID, Repository Pattern)

##  Fonctionnalités

###  Authentification
- Inscription utilisateur (nom, email, téléphone, adresse, photo, mot de passe)
- Connexion avec génération de JWT
- Middleware de protection des routes
- Gestion des permissions (un utilisateur ne voit que ses tâches)

###  Gestion des tâches (CRUD complet)
- Création, lecture, mise à jour et suppression de tâches
- Liste paginée des tâches
- Détail d'une tâche spécifique
- Validation des données côté serveur

###  Notifications temps réel
- Broadcast d'événements via Laravel Echo
- Réception des notifications via Pusher
- Page dédiée pour l'historique des notifications
- Notification à chaque création de tâche

##  Architecture Technique

### Backend (Laravel 10)
- **Authentification** : JWT
- **Base de données** : MySQL
- Voici la structure des table de la base de donnes


<img width="1136" height="507" alt="image" src="https://github.com/user-attachments/assets/c0331554-4fa2-4f91-bfbc-b6681201504c" />
<hr/>

- **WebSockets** : Pusher pour les événements temps réel
- **Patterns** : 
  - Repository Pattern
  - Service Layer
- **Validation** : Form Requests
- **Tests** : PEST
- Voici L'architecture technique du projet complet et plus en back end:
<img width="757" height="879" alt="image" src="https://github.com/user-attachments/assets/067c7f80-bf29-44df-adc6-64c223a504ae" />

### Frontend (Vue.js 3)
- **State Management** : Pinia
- **UI Components** : shadcn-vue
- **Routing** : Vue Router
- **HTTP Client** : Axios
- **Realtime** : Laravel Echo + Pusher-js
- **Styling** : Tailwind CSS

- Voici aussi l'architecture technique du projet en front end:
<img width="712" height="812" alt="image" src="https://github.com/user-attachments/assets/6a054962-5dea-4703-80a5-1b9e5909a7fe" />

##  Installation

### Prérequis
- PHP 8.2+
- Composer 2+
- Node.js 18+
- MySQL 8+
- Compte Pusher (pour les websockets)

### Étapes d'installation

1. Cloner le dépôt :
```bash
git clone https://github.com/votre-repo/todo-list-laravel-vue.git
cd todo-list-laravel-vue
```
2.Installer les dépendances PHP et JavaScript:
```bash
composer install
npm install
```

3.Générer la clé d'application et JWT :
```bash
php artisan key:generate
php artisan jwt:secret
```
4.Migrer et peupler la base de données :
```bash
php artisan migrate --seed
```
