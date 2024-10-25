# README

## Refresh Token

Pour utiliser le refresh token, suivez ces instructions :

### Endpoint

- **URL** : `http://localhost:8000/api/token/refresh`

### Authentification

Ajoutez votre token dans l'en-tête `Authorization`.

### Corps de la requête

Dans le corps de la requête, incluez le JSON suivant :

```json
{
    "refreshToken": "384e454891e82fd825993204a5461e4117ba07c24405cf221fd806e3e4161a185772eb4aaeeab0de82494134545ee552ada234b8447e3b303e6e5ebf0ba9a33c"
}
```

### Réponse

En cas de succès, vous recevrez un token régénéré. La durée de vie de nos tokens est de **3600 secondes**.

#### Exemple de réponse :

```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3Mjk4NDM5MjksImV4cCI6MTcyOTg0NzUyOSwianRpIjoiNTMyZDQ3YTY0NGJjZmIyMGU5MmIxNjBjOTZkOWQwZjYiLCJyb2xlcyI6WyJST0xFX0NMSUVOVCIsIlBVQkxJQ19BQ0NFU1MiXSwidXNlcm5hbWUiOiJ0ZXN0M0BuYXJpaHkubWcifQ.SfW6bQhv_PKW-bDsHsxSl7USEGgx9eonhD9vMSs8h3hnx61LzmYPUWx9Gywo09zTlTP9fq81-G9fQ0Jiiza8yF937A4xHeQjeI0ul8CQNiSkV9GZ40mf0Gm0DUKASjuxXatU93nH4LtSb_2Ffm5obYUxcIm5wRKR1PC8wz_UODfz5xbZX3j2anaaf2ScSfpLlhPgIHktKXwucHe1Br7Vg-e5EOaZJ5CATct9kBrrrBfJ2va50LDtndImUjW8SKL8YfDgBm-XrHEFXMWx3ObF5-Z3w-4i4cgEYV0pO4m9Pewk3Ywlod-Zlm1-O4N8ppqhSAMaznUJXlM3pvSOnHl1Tg",
    "refreshToken": "384e454891e82fd825993204a5461e4117ba07c24405cf221fd806e3e4161a185772eb4aaeeab0de82494134545ee552ada234b8447e3b303e6e5ebf0ba9a33c"
}
```

### Notes

- Assurez-vous que le `refreshToken` utilisé est valide.
- La régénération du token est essentielle pour maintenir l'accès à l'API sans nécessiter une nouvelle authentification.