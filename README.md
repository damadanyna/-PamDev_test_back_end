
## Apropos du Truc

- /api/login : post
    - body : id => id de l'utilisateur, pass => mot de passe de l'utilisateur
    - valeur de retour fichier **JSON** contenant un objet status qui indique l'etat de la requête
- /api/register : post
    - description : permet d'enregistrer un utilisateur
    - body : id => id de l'utilisateur, pass => mot de passe de l'utilisateur
    - valeur de retour fichier **JSON** contenant un objet status qui indique l'etat de la requête
- /api/users : get
    - liste les utilisateurs
- /api/user/{id} : delete
    - supprime un utilisateur avec son **ID**

- /api/status : get
    - permet de savoir si l'utilisateur est connecté ou non

