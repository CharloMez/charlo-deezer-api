# charlo-deezer-api

## Environnement

Ce projet a été fait avec: 
* php 5.5.10
* Apache
* Mysql

Il requiert l'activation:
* url rewriting
* PDO


## MySQL

Un script `create_sql.sql` contient la requête pour créer la structure de la base de donnée

le projet nécessite un fichier `.env` pour fonctionner.
Pour cela il suffit de copier le `.env.dist` et le renommer `.env`, puis remplacer les variables selon votre environement
Le `.env.dist` contient les variable par défault d'une connection MySQL en local avec MAMP


## Les routes

Ce projet permet de manipuler les utilisateurs, les musiques, ainsi que les favoris.

les fichiers JSON:
* postman_request_users.json
* postman_request_songs.json

sont des collections de requêtes à importer via postman, et permettent de voir l'étendu des possibilités de l'api.


## Vhosts

Les requêtes postman stocké ont comme host `deezer.local`, libre à vous de le modifier.
En revanche le Vhost doit pointer à la base du projet.

## Tests

Les tests unitaires ont été fait avec la version 5.5.4 de phpunit
Pour les lancer, tapez seulement `phpunit` à la base du projet

## Evolution

Par manque de temps, un certains nombres de choses n'ont pu être ajouté:

* Optimisation des requêtes via des index dans la base de données
* Une documentation d'api (par exemple avec blueprint)
* Des tests fonctionnelles
* Cacher certaines requêtes d'api, comme par exemple les playlists d'utilisateur via un calcule d'Etag
* ...