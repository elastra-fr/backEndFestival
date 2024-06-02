# MSPR 2 Developpement back end d'une application web ou web mobile

## Contexte 

Routes publics pour lire via le front end les données concerts, artistes, actualités, faq et partenaire, coordonnées points cartes - Pas d'identification mais un clé d'api

Routes jwt pour pour profils utilisateur via le front end register, login, update, delete

Routes backoffice backebd symfony pour création, modication, supression des concerts, artistes, actualités, faq et partenaire, coordonnées points cartes - Identification par sessions.


## Environnement de developpement

PHP 8.2
Symfony 7
Maria DB


## Environnement de production


## Architecture générales

### Routes 

L'application comporte trois types de routes, pour répondre à différents usages, avec des mécanismes différends d'identification.

#### Routes API publique

Les routes publiques vont être consommées par un client front-end muni d'un clé d'API. 

Cette clé va être passée en header de chaque requête HTTP et le controlleur lié à la route public concernée va vérifier la régularité de cette clé.

#### Routes API Utilisateur

Les routes utilisateur vont être sécurisées via JWT. Elles vont permettre à l'utilisateur du front end de s'enregistrer, s'identifier et accéder à des services réservés aux utilisateurs identifiés. 


#### Routes de gestion de contenu et d'admnistration

Ces routes permettent d'accès à la partie de gestion de contenu et sont sécurisés via session.



### Roles

#### USER

#### EDITOR

#### ADMIN




