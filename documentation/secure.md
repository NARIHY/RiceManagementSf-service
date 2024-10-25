# Documentation d'Accès API

## Verrouillage de l'Accès

L'accès à toutes les ressources sous le chemin `/api/` est strictement contrôlé. Seules les requêtes provenant d'utilisateurs pleinement authentifiés sont autorisées. 

### Détails d'Accès

- **Chemin protégé** : `^/api/`
- **Rôle requis** : `IS_AUTHENTICATED_FULLY`

### Conséquences

Toute tentative d'accès à ce chemin sans une authentification adéquate entraînera un refus de la requête. Assurez-vous d'être connecté et d'avoir les droits nécessaires avant d'effectuer des appels API.

### Authentification

Pour vous authentifier, veuillez suivre le processus d'authentification standard de notre application. Une fois authentifié, vous pourrez accéder aux ressources protégées sous `/api/`.

Pour toute question ou problème d'accès, veuillez contacter notre équipe de support.

Merci de votre compréhension.
