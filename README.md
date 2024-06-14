# MSPR 2 Developpement back end d'une application web ou web mobile

## Contexte 

Mettre en place une solution backend de gestion de contenus pour un site web et web mobile du festival NationSound. 

Contenus concernés :
- Notification des messages importants 
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

Routes publics pour lire via le front end les données concerts, artistes, actualités, faq et partenaire, coordonnées points cartes .

Routes jwt pour pour profils utilisateur via le front end register, login, update, delete.

Routes backoffice backend symfony pour création, modication, supression des concerts, artistes, actualités, faq et partenaire, coordonnées points cartes via formulaires- Identification par sessions. 



## Harmonisation des réponses de l'API

Pour les parties API Public et USer la plupart des réponses JSON vont se présenter sous les formats qui suivent. Dans toutes les réponses un code HTTP est passé via le header.

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

#### Routes de gestion de contenu et d'admnistration

Ces routes permettent d'accès à la partie de gestion de contenu et sont sécurisés via session.

Les routes d'administration derrière /admin/ nécessitent à minima le rôle EDITOR. Si un rôle USER tente de se connecter il sera redirigé automatiquement vers le frontend.

Au moment du login le controlleur va vérifier si l'utilisateur n'est pas bloqué. Si c'est le cas, la procédure de LOGIN va échouer.

Après LOGIN l'utilisateur va être dirigé vers une page d'acceuil avec une menu latéral lui permettant de gérer (ajout/modification/suppression):
- Les Artistes et Styles musicaux 
- Les Concerts et Les scènes
- Les Informations Générales et FAQ
- Les Partenaires et Catégories de Partenaires
- Les actualités et évènements
- Les points sur la carte interractive, ainsi que les catégorie de point.

L'administrateur dispose également d'une page permettante de gérer les éditeur (création, blocage.déblocage, suppression). Il n'y pas de procédure de register direct pour un éditeur. 
Seul l'administrateur peut créer un éditeur via l'interface dédiée. Lors de cette création un email porteur d'un Token de vérification va être envoyé à l'éditeur qui devra cliquer sur un lien qui va le renvoyer vers un formulaire de création de mot de passe.  Le mot de passe sera validé ou non par le service PasswordValidatorService.

##### Gestion des images

Les images sont stockées dans le répertoire public/images et les sous repertoires bands, icons et logos.

L'upload des images pour les parties Artistes et Paternaires va être gérée par le service  FileUploader Service qui va se chargér de renommer le fichier d'une manière unique pour l'enregistrement en BDD. Ce service va également rédimensionner l'image en plusieurs formats pour permettre la mise en place d'un SrcSet par le front END.

Lors de la suppression ou de la modification d'un ITEM Artiste ou Partenaire le service DeleteImageService va se charger d'effacer l'ancien fichier du serveur ainsi que ses variantes pour optimiser l'espace de stockage et ne pas laisser de fichier utilisés dans le répertoire public/images et ses sous dossiers.


#### Routes API publique

Les routes publiques sont librement accessibles derrière la route /api/public 

Les routes publiques vont être consommées par un client front-end, le site https://www.nationsound2024-festival.fr/.

Toutefois l'architecture de l'API permet la consommation par d'autres clients si nécessaire.

Il s'agit de route de "lecture" uniquement, aucune donnée ne peut être modifiée via une route publique. 

##### Routes publics programmation 

Route pour récupérer la programmation. Cette route va permettre de récupérer la programmation par jours
https://backend.nationsound2024-festival.fr/api/public/concert 
Méthode GET

{
	"status": "success",
	"data": {
		"2024-06-28": [
			{
				"id": 3,
				"date": "2024-06-28 14:00:00",
				"location": "Scène Marley",
				"description": "Formation rock aux sonorités sombres et intenses.",
				"artist": "Midnight Riot",
				"images": {
					"original": "https:\/\/backend.nationsound2024-festival.fr\/images\/bands\/midnightriot-6668661f0b133.jpg",
					"600": "https:\/\/backend.nationsound2024-festival.fr\/images\/bands\/600-midnightriot-6668661f0b133.jpg",
					"400": "https:\/\/backend.nationsound2024-festival.fr\/images\/bands\/400-midnightriot-6668661f0b133.jpg",
					"200": "https:\/\/backend.nationsound2024-festival.fr\/images\/bands\/200-midnightriot-6668661f0b133.jpg"
				}
			},
			{
				"id": 1,
				"date": "2024-06-28 21:00:00",
				"location": "Scène principale",
				"description": "Groupe de rock énergique avec des influences métalliques.",
				"artist": "Thunderstorm",
				"images": {
					"original": "https:\/\/backend.nationsound2024-festival.fr\/images\/bands\/thunderstorm-666865ef947b4.avif",
					"600": "https:\/\/backend.nationsound2024-festival.fr\/images\/bands\/600-thunderstorm-666865ef947b4.avif",
					"400": "https:\/\/backend.nationsound2024-festival.fr\/images\/bands\/400-thunderstorm-666865ef947b4.avif",
					"200": "https:\/\/backend.nationsound2024-festival.fr\/images\/bands\/200-thunderstorm-666865ef947b4.avif"
				}
			}
		],
		
        ...

	},
	"error": null
}

Il est possible d'appliquer des paramètres ?jour={filterJour}scene={filterScene}&horaire={filterHoraire}&genre={filterGenre} pour filtrer la programmation 

Exemple :
https://backend.nationsound2024-festival.fr/api/public/concert?scene=1 retourne tous les concerts sur la scène principale (1)

{
	"status": "success",
	"data": {
		"2024-06-28": [
			{
				"id": 1,
				"date": "2024-06-28 21:00:00",
				"location": "Scène principale",
				"description": "Groupe de rock énergique avec des influences métalliques.",
				"artist": "Thunderstorm",
				"images": {
					"original": "https:\/\/backend.nationsound2024-festival.fr\/images\/bands\/thunderstorm-666865ef947b4.avif",
					"600": "https:\/\/backend.nationsound2024-festival.fr\/images\/bands\/600-thunderstorm-666865ef947b4.avif",
					"400": "https:\/\/backend.nationsound2024-festival.fr\/images\/bands\/400-thunderstorm-666865ef947b4.avif",
					"200": "https:\/\/backend.nationsound2024-festival.fr\/images\/bands\/200-thunderstorm-666865ef947b4.avif"
				}
			}
		]
	},
	"error": null
}

Route pour récupérer les filtres 
Afin de filtrer la programmation il est nécessaire de récupérer au préalable les filtres.
https://backend.nationsound2024-festival.fr/api/public/concert/filters
Méthode GET

Résultat :
{
	"status": "success",
	"data": {
		"days": [
			{
				"day": 1,
				"date": "2024-06-28",
				"openingTime": "14:00",
				"closingTime": "00:00"
			},
			{
				"day": 2,
				"date": "2024-06-29",
				"openingTime": "14:00",
				"closingTime": "00:00"
			},
			{
				"day": 3,
				"date": "2024-06-30",
				"openingTime": "14:00",
				"closingTime": "00:00"
			}
		],
		"amplitudeHoraire": {
			"min": "14:00",
			"max": "00:00"
		},
		"musicStyles": [
			{
				"id": 1,
				"name": "Rock"
			},
			{
				"id": 2,
				"name": "Rap"
			},
		
                    ....

		],
		"stages": [
			{
				"id": 1,
				"name": "Scène principale"
			},
			{
				"id": 2,
				"name": "Scène Hendrix"
			},
		
                ...

		]
	},
	"error": null
}

##### Partenaires

Route permettant de récuperer les catégories de partenaires pour les filtrer.

https://backend.nationsound2024-festival.fr/api/public/partner/category
Méthode GET

Réponse :

{
	"status": "success",
	"data": [
		{
			"id": 5,
			"category": "Culturel"
		},
		{
			"id": 3,
			"category": "Financier"
		},
		{
			"id": 1,
			"category": "Institutionnel"
		},
		
        ...

	],
	"error": null
}

Route permettant de récuperer la liste des partenaires .

https://backend.nationsound2024-festival.fr/api/public/partner/
Méthode GET

{
	"status": "success",
	"data": [
		{
			"id": 1,
			"name": "Transports SYMPA",
			"url_logo": null,
			"description": "Des transports sympa.",
			"category": "Logistique"
		},
		{
			"id": 2,
			"name": "Technologie Événementielle Pro",
			"url_logo": null,
			"description": "Fournisseur de solutions technologiques pour événements.",
			"category": "Technologique"
		},
		{
			"id": 3,
			"name": "Mobilité Écolo",
			"url_logo": null,
			"description": "Service de transport écologique pour les festivaliers.",
			"category": "Logistique"
		},
		{
			"id": 4,
			"name": "Éclat Son & Lumière",
			"url_logo": null,
			"description": "Entreprise spécialisée dans l'éclairage et le son pour événements.",
			"category": "Technologique"
		},
		
            ...


	],
	"error": null
}

Pour filtrer par Catégorie :
https://backend.nationsound2024-festival.fr/api/public/partner/category/{id}

Exemple : https://backend.nationsound2024-festival.fr/api/public/partner/category/4

Résultat :

{
	"status": "success",
	"data": [
		{
			"id": 1,
			"name": "Transports SYMPA",
			"url_logo": null,
			"description": "Des transports sympa.",
			"category": "Logistique"
		},
		{
			"id": 3,
			"name": "Mobilité Écolo",
			"url_logo": null,
			"description": "Service de transport écologique pour les festivaliers.",
			"category": "Logistique"
		}
	],
	"error": null
}

##### Routes Actualités



##### Routes FAQ Informations 

Route pour récupérer 



Route pour récupérer le contenu de la FAQ
https://backend.nationsound2024-festival.fr/api/public/faq
Méthode GET

{
	"status": "success",
	"data": [
		{
			"category": "Dates",
			"contents": [
				{
					"id": 1,
					"title": "Dates du Festival",
					"content": "Le festival aura lieu du 28 juin 2024 au 12 juin 2024.",
					"contentUpdate": {
						"date": "2024-06-12 17:30:21.000000",
						"timezone_type": 3,
						"timezone": "Europe\/Paris"
					}
				}
			]
		},
		{
			"category": "Lieu",
			"contents": [
				{
					"id": 2,
					"title": "Lieu",
					"content": "Le festival se tiendra sur la commune de XX. Vous pouvez consulter la carte interactive pour plus d'informations.",
					"contentUpdate": {
						"date": "2024-06-09 23:06:14.000000",
						"timezone_type": 3,
						"timezone": "Europe\/Paris"
					}
				}
			]
		},
		{
			"category": "Horaires",
			"contents": [
				{
					"id": 3,
					"title": "Horaires",
					"content": "Les portes ouvrent à 14h chaque jour du festival.\r\n\r\nPour les horaires des performances veuillez consulter le programme.",
					"contentUpdate": {
						"date": "2024-06-09 23:07:37.000000",
						"timezone_type": 3,
						"timezone": "Europe\/Paris"
					}
				}
			]
		},

        ...
		
	],
	"error": null
}






















#### Routes API Utilisateur

Les routes utilisateur vont être sécurisées via JWT (JSON Web Token). Elles vont permettre à l'utilisateur du front end de s'enregistrer, s'identifier et accéder à des services réservés aux utilisateurs identifiés. 

Les routes api utilisateurs derrière /api/user ne peuvent être utilisées que par un utilisateur porteur d'un token JWT à l'exception des routes suivants qui nécessairement publiques :
- /api/user/register qui permet l'enregistrement de tout nouvel utilisateur (role USER)
- /api/user/login qui permet l'authentification de l'utilisateur et l'obtention du token JWT

Le système d'authentification JWT mis en place avec lexik/jwt-authentication-bundle et extension open SSL pour création des clés publique et privée.
Durée de validité du token 3600 secondes (1h). Cette durée peut être modifiée dans \config\packages\lexik_jwt_authentication.yaml.












