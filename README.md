# Gestion de Stock de Riz - API SYMFONY

## Introduction

Bienvenue dans le système de gestion de stock de riz. Cette API Laravel permet de gérer efficacement les stocks de riz, les transactions financières, les commandes clients et les informations relatives aux fournisseurs. Ce README fournit une vue d'ensemble des fonctionnalités, des instructions d'installation et des exemples d'utilisation.

## Fonctionnalités

### 1. **Gestion des Stocks**
- **Ajout d'Arrivages :** Permet d'ajouter de nouveaux arrivages de riz avec des informations telles que le type de riz, la qualité, le prix, et la quantité en sacs.
- **Suivi des Stocks :** Visualisation des stocks disponibles par étiquette, gestion des quantités de sacs et mise à jour après chaque vente.
- **Inventaire :** Enregistrement des inventaires réguliers pour vérifier l'état des stocks.

### 2. **Gestion Financière**
- **Enregistrement des Transactions :** Suivi des entrées et sorties de fonds, associées aux arrivages et aux clients.
- **Comptes Vendeurs et Clients :** Gestion distincte des transactions pour les vendeurs et les clients.
- **Facilités de Paiement :** Gestion des options de paiement immédiat ou différé, suivi des créances et des paiements partiels.

### 3. **Gestion des Commandes Clients**
- **Passer des Commandes :** Enregistrement des commandes clients avec détails de la commande, modalités de paiement, et informations client.
- **Suivi des Commandes :** Mise à jour du stock après chaque vente, vérification des paiements et des statuts de livraison.

### 4. **Gestion des Informations**
- **Archivage des Actions :** Enregistrement des actions importantes comme les achats, les ventes, et les ajustements de stock.
- **Vue d’Ensemble des Stocks :** Tableau de bord pour visualiser les stocks disponibles, les stocks vendus, et les commandes en cours.
- **Sécurité des Données :** Sauvegarde régulière des données financières et de gestion des stocks.

## Installation

### Prérequis
- PHP 8.x
- Composer
- Laravel 11.x
- MariaDb (Prod)
- Sqllite (dev)

### Étapes d'Installation

1. **Cloner le Repository**
   ```bash
   git clone https://github.com/NARIHY/RiceManagement-service.git
   cd RiceManagement-service
   ```

2. **Installer les Dépendances**
   ```bash
   composer install
   ```

3. **Configurer l'Environnement**
   Renommez le fichier `.env.example` en `.env` et configurez les variables d'environnement pour la base de données et les autres paramètres :
   ```bash
   cp .env.example .env
   ```

4. **Générer la Clé de l'Application**
   ```bash
   php artisan key:generate
   ```

5. **Migrer la Base de Données**
   ```bash
   php artisan migrate
   ```

6. **Lancer le Serveur**
   ```bash
   php artisan serve
   ```

## Utilisation

### API Endpoints

- **Ajouter un Arrivage**
  - **URL:** `POST /api/arrivages`
  - **Body:**
    ```json
    {
      "type": "Basmati",
      "qualite": "Premium",
      "prix": 50.00,
      "quantite_sacs": 100
    }
    ```

- **Consulter les Stocks**
  - **URL:** `GET /api/stocks`
  - **Response:**
    ```json
    {
      "type": "Basmati",
      "qualite": "Premium",
      "quantite_disponible": 90
    }
    ```

- **Passer une Commande**
  - **URL:** `POST /api/commandes`
  - **Body:**
    ```json
    {
      "client_id": 1,
      "type_riz": "Basmati",
      "quantite_sacs": 10,
      "mode_paiement": "immédiat"
    }
    ```

- **Consulter les Commandes**
  - **URL:** `GET /api/commandes`
  - **Response:**
    ```json
    {
      "id": 1,
      "client_id": 1,
      "type_riz": "Basmati",
      "quantite_sacs": 10,
      "status": "livrée"
    }
    ```

- **Enregistrer une Transaction**
  - **URL:** `POST /api/transactions`
  - **Body:**
    ```json
    {
      "type": "entrée",
      "montant": 500.00,
      "description": "Achat de riz"
    }
    ```

### Exemple d'Authentification

Pour accéder aux endpoints protégés, utilisez le token d'authentification Bearer dans les en-têtes de requête.

```bash
curl -H "Authorization: Bearer YOUR_TOKEN" http://localhost:8000/api/stocks
```

## Contribution

Si vous souhaitez contribuer à ce projet, veuillez suivre ces étapes :
1. Fork le repository.
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/nouvelle-fonctionnalité`).
3. Faites vos modifications et committez (`git commit -am 'Ajoute nouvelle fonctionnalité'`).
4. Poussez vos changements (`git push origin feature/nouvelle-fonctionnalité`).
5. Créez une pull request.

## Contact

Pour toute question ou support, veuillez contacter :
- **Nom** : RANDRIANARISOA Mahenina
- **Email** : maheninarandrianarisoa@gmail.com


## Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.
