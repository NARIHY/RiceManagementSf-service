# README

## Login

Pour vous connecter et obtenir un token d'authentification, suivez ces étapes :

### Endpoint

- **URL** : `http://localhost:8000/api/login`

### Corps de la requête

Envoyez les informations d'identification de l'utilisateur dans le corps de la requête sous forme de JSON :

```json
{
    "username": "test3@narihy.mg",
    "password": "0000"
}
```

### Réponse

En cas de succès, vous recevrez un token d'accès et un refresh token. 

#### Exemple de réponse :

```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3Mjk4NDM4NjYsImV4cCI6MTcyOTg0NzQ2NiwianRpIjoiNjEzMTIwOWRkYWIyZjk0YWFlOTQ3MjZjNzgwYjFhYjUiLCJyb2xlcyI6WyJST0xFX0NMSUVOVCIsIlBVQkxJQ19BQ0NFU1MiXSwidXNlcm5hbWUiOiJ0ZXN0M0BuYXJpaHkubWcifQ.kCoBbBFo6nHnA155TotXTVn-XBb0OvwapniEy5b__HQeJU52pRinMHw_uoO2HPphwXpLHc6c07uZODeLzb30ZjnZn5oIfmeqg6vNiK9yNVFwjWh9UiaI7F0sTFY4Nu7pqxc1Yy4OGJTCytd5zg7ssM1z1D6QhyT-ujPt9KGt2jrdj4pOWxj-GINkX-c7YGCSUP1JbhvtjdHSVbb18yXn3u8jO3C0UA03KAGvI-uWzrKOXyL3nJJUbWOzaSx_83NVMPpwDErh4JfNPAbA0MOEWjf_H_iaEIUD7eUDz6J7xsljrsYJn-YadUSCQ7rUmtAabwbtMp49kDABQsAAm6-OyQ",
    "refreshToken": "384e454891e82fd825993204a5461e4117ba07c24405cf221fd806e3e4161a185772eb4aaeeab0de82494134545ee552ada234b8447e3b303e6e5ebf0ba9a33c"
}
```

### Notes

- Assurez-vous que le nom d'utilisateur et le mot de passe sont corrects.
- Le token d'accès doit être utilisé pour authentifier les requêtes vers les endpoints protégés de l'API.
- Le refresh token peut être utilisé pour obtenir un nouveau token d'accès lorsque celui-ci expire.