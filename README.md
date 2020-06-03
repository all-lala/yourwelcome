# YourWelcome

Projet de création d'une solution de gestion et génération d'affichage et de fléchage pour accueil de mariages.

## Déploiement
[https://symfony.com/doc/current/deployment.html](https://symfony.com/doc/current/deployment.html)

Créer les clé JWT 
	
	openssl genrsa -out config/jwt/private.pem -aes256 4096
	openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

Installer Symfony et VueJS

    composer install
    npm install
    npm build

Créer les variables d'environement

	APP_ENV
	APP_SECRET
	DATABASE_URL
	JWT_SECRET_KEY
	JWT_PUBLIC_KEY
	JWT_PASSPHRASE

Créer la DB et jouer les migrations

	php bin/console doctrine:database:create
	php bin/console doctrine:schema:create
	php bin/console doctrine:migration:migrate

## TODO:
- Theme :
	- Roue de la fiortune
	- Image Fixe
	- Images Scindés
	- Video
	- ...
- Pré-configuration sélectionnables dans une liste (exemple table/thème/animation)
- Player:
	- Export des données
	- Connexion BT
- Wedding-planner:
	- Gestion multimariage
	- Lien vers player uniquement
	- Inviter utilisateurs
- Comptes :
	- Supprimer
	- Modifier (email/password)
