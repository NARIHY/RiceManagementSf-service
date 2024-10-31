## Problème sur le Client

### Contexte

Nous rencontrons un problème lié à l'affichage du genre associé à chaque client dans notre système. Il est essentiel de garantir que les informations de genre soient correctement affichées tout en respectant les contraintes d'impossibilité de modification.

### Détails du Problème

1. **Association Genre-Client :**
   - Chaque client doit être lié à un genre spécifique.
   - Le genre d'un client ne peut pas être modifié une fois qu'il est défini.

2. **Affichage des Données du Client :**
   - Nous devons assurer un affichage conforme aux spécifications suivantes :
   ```json
   {
     "@context": "string",
     "@id": "string",
     "@type": "string",
     "id": 0,
     "name": "string",
     "lastName": "string",
     "cin": "string",
     "address": "string",
     "gender": {
       "@context": "string",
       "@id": "string",
       "@type": "string",
       "id": 0,
       "genderName": "string"
     }
   }
   ```

### Problème de Récupération

Nous avons également identifié un problème lors de la récupération des données d'un client, qui renvoie une erreur 403 (Accès refusé). Ce problème doit être corrigé pour permettre aux utilisateurs autorisés d'accéder aux informations des clients.

### Actions Requises

1. **Vérifier et corriger l'implémentation de l'affichage du genre du client** pour s'assurer qu'il soit toujours correctement associé et visible dans le format spécifié.

2. **Diagnostiquer et résoudre l'erreur 403** pour permettre la récupération des données clients, en s'assurant que les permissions d'accès soient correctement configurées.

Nous vous prions de bien vouloir traiter ces problèmes avec diligence. Si vous avez besoin d'informations supplémentaires ou d'assistance, n'hésitez pas à me contacter.

Cordialement