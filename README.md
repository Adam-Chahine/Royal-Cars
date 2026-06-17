# 🚗 Royal Cars – Full-Stack Car Rental Platform

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5">
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3">
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
</p>

## 🌐 Démo en ligne
Le projet est entièrement déployé et accessible en ligne à l'adresse suivante :  
🔗 **[rentroyalcars.42web.io](https://rentroyalcars.42web.io/)**

---

## 📝 Présentation du Projet
**Royal Cars** est une plateforme web full-stack de location de voitures[cite: 1]. Loin d'être un simple site vitrine en HTML, il s'agit d'une application dynamique complète dotée d'une logique métier réelle, incluant un catalogue client interactif, un système de réservation automatisé[cite: 1] et un **panneau d'administration sécurisé** pour la gestion de la flotte et des commandes[cite: 1].

---

## 🚀 Fonctionnalités Clés

### 👥 Côté Client (Front-End)
* **Interface Moderne & Épurée :** Navigation fluide avec une section de présentation de la marque et des services.
* **Catalogue de Véhicules Dynamique :** Présentation des voitures disponibles avec photos, descriptions et tarifs.
* **Système de Réservation Intuitif :** Formulaire de réservation en ligne.
* **Design 100% Responsive :** Entièrement optimisé pour tous les écrans (Smartphones, Tablettes et Ordinateurs) grâce aux Media Queries.

### 🔐 Panneau d'Administration (Back-End)
* **Authentification Sécurisée :** Espace admin protégé par une gestion rigoureuse des sessions PHP pour empêcher tout accès non autorisé.
* **Gestion de la Flotte (CRUD Automobile) :** Contrôle total pour ajouter, modifier, supprimer ou masquer temporairement des véhicules du catalogue.
* **Suivi des Réservations :** 
  * Tableau de bord centralisant les demandes clients enregistrées en base de données.
  * Système de validation : après confirmation téléphonique avec le client, l'admin valide la session qui bascule automatiquement dans l'état "Confirmé".
* **Automation des E-mails :** Envoi automatique d'un e-mail de confirmation personnalisé au client via **PHPMailer** dès la validation de sa réservation.

---

## 🛠️ Technologies & Outils Utilisés
* **Frontend :** HTML5, CSS3, JavaScript
* **Backend :** PHP (Architecture serveur et traitement logique)
* **Base de données :** MySQL (Persistance et requêtage sécurisé via PDO)
* **Sécurité :** Validation et nettoyage des entrées de formulaires (`XSS`), requêtes préparées (`SQL Injection`) et gestion des sessions applicatives.
* **Gestion des mails :** Librairie PHPMailer (Intégration SMTP).

---

## 🎨 Expérience Utilisateur (UX) & Sécurité
* **Indicateurs Visuels :** Boutons colorés dynamiques et icônes de verrouillage pour guider intuitivement l'administrateur.
* **Statuts en Temps Réel :** Mise à jour instantanée de l'état des véhicules (*Réservé*, *Masqué*, *Disponible*).
* **Tri des Données :** Tableaux de bord de l'administration triables par dates et catégories pour une gestion fluide.

---

## 🏁 Conclusion
**Royal Cars** reflète des compétences sérieuses en ingénierie web, combinant design moderne, logique métier backend robuste, automatisation des communications et sécurité logicielle. 

C'est une application prête pour la production et parfaitement représentative d'un projet professionnel.
