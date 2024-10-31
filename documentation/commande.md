## Système de Commande de Riz

### Fonctionnalités

1. **Passer une Commande de Riz :**
   - Les clients peuvent passer une ou plusieurs commandes de riz.
   - Chaque commande est associée à un type de riz spécifique.

2. **Gestion des Commandes :**
   - Les commandes ne peuvent pas être supprimées, mais elles peuvent être annulées par le client.
   - Une commande peut être modifiée jusqu'à une semaine avant la date de livraison (jour X) définie à l'avance.
   - Les administrateurs et les vendeurs peuvent consulter toutes les commandes, mais ne peuvent pas les supprimer.

3. **Modification des Commandes :**
   - Un client ne peut pas modifier une commande si la date de livraison (jour X) est dépassée.

4. **Statut des Commandes :**
   - Chaque commande a un statut qui peut être : 
     - **En cours** : La commande a été passée et est en traitement.
     - **Annulée** : La commande a été annulée par le client.
     - **Livrée** : La commande a été livrée au client.

### Structure de l'Entité Commande

- **Bag** : Référence à un sac de riz.
- **TypeRiz** : Référence à un type de riz, incluant le prix de base par sac.
- **Statut** : Indique l'état actuel de la commande.
- **Date de Création** : Date à laquelle la commande a été passée.
- **Date de Modification** : Date de la dernière modification apportée à la commande.
- **Client** : Informations sur le client ayant passé la commande.
- **Adresse de Livraison** : Adresse où le riz doit être livré.
- **Prix** : Calculé selon le prix d'un sac basé sur le type de riz commandé.

### Entité TypeRiz

- **Prix de Base** : Chaque type de riz doit avoir un prix de base par sac qui sera utilisé pour le calcul du prix total de la commande.

### Notes Importantes

- Les commandes sont distinctes des arrivages, qui sont des informations spécifiques à la gestion des stocks.
- La plateforme doit garantir que toutes les interactions respectent les règles établies pour une gestion efficace et fluide des commandes de riz.