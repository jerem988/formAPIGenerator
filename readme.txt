Mode de déploiement

- Outil nécéssaires pour faire tourner l'application:

	- Une plateforme de développement Web comportant PHP >=7.3, Apache et MySQL >= 5.7
		=> Exemple: Wamp, Mamp, Xamp
	- Une base de données fonctionnelle et accessible en locale
	- npm
	- composer
	- un invité de ligne de commande en mode console
		=> Ex cmd, terminal, POWERSHELL
	- un accès internet

- Migrer l'application sur son pc en local:

	1/ Cloner le répertoire du git avec la commande une commande git clone "https://url_du_git"
	2/ Créér un base de données sur son environement locale (exemple "questionnaire_db")
	3/ Renommer le fichier .env.example en .env
	4/ Renseigner sa configuration dans le fichier env notamment la partie connection à la base de donnée et la partie mail
	5/ Dans un invité de commande se positionner à la racine du projet et lancer les commandes suivantes:
		- composer install
		- npm install
		- php artisan optimize
		- php artisan migrate
		- npm run development ou npm run production
		- php artisan serve

	6/ L'adresse racine du serveur web s'affiche exemple "http://127.0.0.1:8000", se rendre à cette adresse
	7/ Welcome !

Une fois sur l'application, il faut s'enregistrer en cliquant sur "Registrer" puis, une fois fait, le Back-Office apparait.

- Tests unitaire

Il faut lancer la commande "vendor/bin/phpunit" pour lancer les tests.

