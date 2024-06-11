# MSPR 2 Developpement back end d'une application web ou web mobile

## Contexte 

Mettre en place une solution backend de gestion de contenus pour un site web et web mobile du festival NationSound. 

Contenus concernés :
- Push notification des messages importants 
- Carte localisation des points d'intérêts et informations relatives à chaque point
- Programme du festival
- Horaires et lieux de rencontre avec les artistes


## Environnement de developpement

PHP 8.2
Symfony 7
Maria DB


## Environnement de production
PHP 8.2
Symfony 7
Maria DB
Herbergement O2 switch sur le sous-domaine : https://backend.nationsound2024-festival.fr/

### Roles

L'application prend en compte trois rôles :

- USER qui n'a accès qu'au frontend et à son espace utilisateur. 
- EDITOR qui hérite de USER et a accès à la partie administration sur la backend
- ADMIN qui hérite de EDITOR et qui a accès à des fonctionnalités supplémentaires sur le backend. 


## Architecture générales


Routes publics pour lire via le front end les données concerts, artistes, actualités, faq et partenaire, coordonnées points cartes - Pas d'identification mais un clé d'api

Routes jwt pour pour profils utilisateur via le front end register, login, update, delete

Routes backoffice backebd symfony pour création, modication, supression des concerts, artistes, actualités, faq et partenaire, coordonnées points cartes - Identification par sessions.

## Harmonisation des réponses 

La plupart des réponses JSON vont se présenter sous les formats qui suivent. Dans toutes les réponses un code HTTP est passé via le header.

En cas de succès :

{
    "status": "success",
    "data": {
        // Les données ou le message de la réponse vont se trouver ici
    },
    "error": null
}

En cas d'erreur :

{
    "status": "error",
    "data": null,
    "error": {
		"code":"ERROR_CODE",
		"message": "Détails de l'erreur"
	}
}


Ce format est normalisé grace au service JsonResponseNormalizer.  
Potentiellement cette standardisation peut faciliter la gestion des réponses par le front end.

Le Trait StandardResponsesTrait va fournir des réponses standard (toujours mises en forme avec JsonResponsesNormalizer).


### Routes 

L'application comporte trois types de routes, pour répondre à différents usages, avec des mécanismes différents d'authentification consultables dans le fichier config/packages/security.yaml


#### Routes API publique

Les routes publiques sont librement accessibles derrière la route /api/public 

Les routes publiques vont être consommées par un client front-end, le site https://www.nationsound2024-festival.fr/.

Toutefois l'architecture de l'API permet la consommation par d'autres clients si nécessaire.

Il s'agit de route de "lecture" uniquement, aucune donnée ne peut être modifiée via une route publique. 


#### Routes API Utilisateur

Les routes utilisateur vont être sécurisées via JWT. Elles vont permettre à l'utilisateur du front end de s'enregistrer, s'identifier et accéder à des services réservés aux utilisateurs identifiés. 

Les routes api utilisateurs derrière /api/user ne peuvent être utilisées que par un utilisateur porteur d'un token JWT à l'exception des routes suivants qui nécessairement publiques :
- /api/user/register qui permet l'enregistrement de tout nouvel utilisateur (role USER)
- /api/user/login qui permet l'authentification de l'utilisateur et l'obtention du token JWT

Le système d'authentification JWT mis en place avec lexik/jwt-authentication-bundle et extension open SSL pour création des clés publique et privée.
Durée de validité du token 3600 secondes (1h). Cette durée peut être modifiée dans \config\packages\lexik_jwt_authentication.yaml.


#### Routes de gestion de contenu et d'admnistration

Ces routes permettent d'accès à la partie de gestion de contenu et sont sécurisés via session.

Les routes d'administration derrière /admin/ nécessitent à minima le rôle EDITOR. Si un rôle USER tente de se connecter il sera redirigé automatiquement vers le frontend.



# Gestion des images

Entrée service upload

Service delete







