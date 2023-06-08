# Projet Le Blog de Batman

### Cloner le projet

```
git clone https://github.com/Grrayan/leblogdebatman.git
```

### Déplacer le terminal dans le dossier cloné
```
cd leblogdebatman_2027
```

### Installer les vendors (pour recréer le dossier vendor)
```
composer install
```

### Création base de données
configurer la connexion à la base de données dans le fichier .env (voir cours)
puis taper les commandes suivantes :
```
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
```


### Lancer le serveur
```
symfony serve
```