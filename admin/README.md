## .htaccess

Le fichier `.htaccess` (pour "HyperText Access") est un fichier de configuration utilisé par les serveurs web basés sur Apache. Il permet de définir des directives spécifiques pour le répertoire dans lequel il se trouve, ainsi que pour ses sous-répertoires. Dans notre cas nous l'utilisons pour le répertoire `admin`.

- **Contrôle d'accès** : Il peut autoriser ou interdire l'accès à certains fichiers. Il donne aussi la possibilité, que ce soit pour un fichier, un répertoire ou encore un sous-répertoire, de bloquer les utilisateurs qui ne se sont pas authentifiés grâce à un mot de passe.
- **Redirections d'URL** : Il peut permettre de mettre en place des redirections.
Personnalisation des messages d'erreur : Il permet de personnaliser les messages d'erreurs.
- **Réécriture d'URL** : Il permet également de réécrire les URL afin de les simplifier.

```shell
# Sécuriser l'accès au répertoire
AuthType Basic
AuthName "Accès restreint"
AuthUserFile "../../../www/wpharma/admin/config/wonderland.htpasswd"
Require valid-user

# Bloquer l'indexation par les robots
Options -Indexes
```

## .htpasswd
Le fichier `.htpasswd` est un fichier chargé de stocker les mots de passe sur un serveur Web Apache. Il est lié au fichier `.htaccess`. 

En résumé, le `.htpasswd` contient les mots de passe correspondant à chaque utilisateur autorisé, par le `.htaccess`, à accéder à un contenu

```shell
htpasswd -Bc wonderland.htpasswd username
```
**Resultat** :
```shell
C:\wamp64\www\wpharma\admin>htpasswd -Bc wonderland.htpasswd username
New password: ****
Re-type new password: ****
Adding password for user username
```