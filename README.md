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



## Force du mot de passe et sécurité 

Le mot de passe doit être d'au moins 8 caractères comprenant une majuscule, un chiffre et un caractère spécial. Au moment de l'enregistrement le service PasswordValidatorService permet de vérifier avec des expressions régulières la conformité du mot de passe. Le renvoi un message d'erreur indiquant les critères qui ne sont pas respectés.


Si procédure de reinitialisation de mot de passe en cours :

{
	"status": "error",
	"data": null,
	"error": {
		"code": "UNAUTHORIZED",
		"message": "Réinitialisation du mot de passe en cours. Veuillez vérifier vos emails pour terminer le processus. Tant que la procédure ne sera pas terminée, vous ne pourrez pas accéder à ces services"
	}
}

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
- Les points sur la carte interactive, ainsi que les catégorie de point.

L'administrateur dispose également d'une page permettante de gérer les éditeur (création, blocage.déblocage, suppression). Il n'y pas de procédure de register direct pour un éditeur. 
Seul l'administrateur peut créer un éditeur via l'interface dédiée. Lors de cette création un email porteur d'un Token de vérification va être envoyé à l'éditeur qui devra cliquer sur un lien qui va le renvoyer vers un formulaire de création de mot de passe.  Le mot de passe sera validé ou non par le service PasswordValidatorService.

##### Gestion des images

Les images sont stockées dans le répertoire public/images et les sous repertoires bands, icons et logos.

L'upload des images pour les parties Artistes et Paternaires va être gérée par le service  FileUploader Service qui va se chargér de renommer le fichier d'une manière unique pour l'enregistrement en BDD. Ce service va également rédimensionner l'image en plusieurs formats pour permettre la mise en place d'un SourceSet par le front END.

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

Routes pour récupérer les actualités du festival sauf les évènement de sécurité et météo

https://backend.nationsound2024-festival.fr/api/public/news

Avec paramètre : https://backend.nationsound2024-festival.fr/api/public/news?limit=10

Par défaut limit = 5

Méthode GET

Réponse :

{
	"status": "success",
	"data": [
		{
			"id": 2,
			"title": "Parking supplémentaire",
			"content": "En raison de nombre important de réservations, nous avons ajouté un parking P2, à consulter sur la carte interactive.",
			"newsDate": {
				"date": "2024-06-09 22:18:21.000000",
				"timezone_type": 3,
				"timezone": "Europe\/Paris"
			}
		},
		{
			"id": 1,
			"title": "Concert d'ouverture",
			"content": "C'est confirmé, Starlight Avenue assurera le concert d'ouverture du Festival à 21H sur la scène principale. Il sera suivi de Sonic Storm à 23H, toujours sur la scène principale.",
			"newsDate": {
				"date": "2024-06-09 22:17:56.000000",
				"timezone_type": 3,
				"timezone": "Europe\/Paris"
			}
		}
	],
	"error": null
}


Route qui permet de récupérer les évènement de securité et météo qui donneront lieu à alerte sur le front end.

https://backend.nationsound2024-festival.fr/api/public/news/alert

Méthode GET






##### Routes FAQ Informations 


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

##### Routes Map

Route pour récupérer les catégories de points pour mettre en place un filtre

https://backend.nationsound2024-festival.fr/api/public/map/points/category
Méthode Get 

Réponse :

{
	"status": "success",
	"data": [
		{
			"id": 5,
			"PointCategory": "Test"
		}
	],
	"error": null
}

Route pour récupérer les points 

https://backend.nationsound2024-festival.fr/api/public/map/marker/{id}

Par défaut le paramètre id est nulle et la route retourner la liste de tous les points.

Méthode GET


Réponse :

{
	"status": "success",
	"data": [
		{
			"title": "Test1",
			"description": "Test1",
			"latitude": "48.7644118",
			"longitude": "2.1016334",
			"type": "Test",
			"img": "https:\/\/backend.nationsound2024-festival.fr\/images\/bands\/triangle-exclamation-solid-666b41036321e.svg"
		}
	],
	"error": null
}




#### Routes API Utilisateur

Les routes utilisateur vont être sécurisées via JWT (JSON Web Token). Elles vont permettre à l'utilisateur du front end de s'enregistrer, s'identifier et accéder à des services réservés aux utilisateurs identifiés. 

Les routes api utilisateurs derrière /api/user ne peuvent être utilisées que par un utilisateur porteur d'un token JWT à l'exception des routes suivants qui sont nécessairement publiques :
- /api/user/register qui permet l'enregistrement de tout nouvel utilisateur (role USER)
- /api/user/login qui permet l'authentification de l'utilisateur et l'obtention du token JWT

Le système d'authentification JWT mis en place avec lexik/jwt-authentication-bundle et extension open SSL pour création des clés publique et privée.
Durée de validité du token 3600 secondes (1h). Cette durée peut être modifiée dans \config\packages\lexik_jwt_authentication.yaml.

##### Vérification email utilisateur
Lors de l'enregistrement un message d'inscription est envoyé, grace à MailerService, à l'utilisateur pour confirmer son adresse mail et un token d'identification mail est généré et enregistré dans la base de données. Le mail contient un lien de vérification.

Ce lien contient pointe vers la route confirm-email/{token-genéré}.

Quand l'utilisateur clique sur le lien, le controlleur ConfirmEmailController vérifie si le token est valide. Si c'est le cas, le champ email_verified est passé à true  dans la base de données et le token est passé à null. Le contrôleur envoi la réponse :
{"status":"success","data":{"message":"Adresse email confirmée avec succès"},"error":null}

Si le token est invalide :
{"status":"error","data":null,"error":{"code":"INVALID_TOKEN","message":"Token invalide"}}

Le service IsMailVerifiedService et le subscriber IsMailVerifiedSubscriber vont vérifier si l'utilisateur porteur du token a bien validé son adresse mail. Si ce n'est pas le cas le subscriber va renvoyer le message :

{
	"status": "error",
	"data": null,
	"error": {
		"code": "email_not_verified",
		"message": "Email non vérifié. Veuillez cliquer sur lien de vérification dans l'email envoyé lors de l'inscription. Sans cette action vous ne pourrez pas accéder à ce service"
	}
}

Les routes concernées par ce contrôle sont listées dans la variable $routesRequiringVerification du subscriber IsMailVerifiedSubscriber. Cette liste permet de limiter ou non l'accès à certaines ressources si l'email n'est pas vérifié. Le client pourrait décider que certaines routes peuvent être accessibles en lecture même si l'utilisateur n'a pas encore validé son adress.

Si le token est invalide le controleur envoi la réponse {"status":false,"message":"Token invalide"}

##### Tentatives de connexion

En cas de multiples tentatives de connexions erronnées, l'utilisateur va recevoir un mail pour reinitialiser son mot de passe. Et cela via un Event Subscriber LoginFailureSubscriber qui va suivre l'évenement lexik_jwt_authentication.on_authentication_failure et mettre à jour le champs loginAttempts dans la base de données. Si le nombre dépasse 5 un email est envoyé via le service Mailer Service.
Le champ password_reset_in_progress est passé à true et un token password_reset_token est généré.
L'email de reset contient un lien vers un formulaire de reset du mot de passe. Le mot de passe fera l'objet de la même vérification qu'au moment du register.

Tant que la procédure de reset est en cours le Subscriber IsPasswordResetInProgressSubscriber empêche l'utilisateur d'atteindre les routes derrière /api/user et l'utilisateur recevra la réponse : 
{
	"status": "error",
	"data": null,
	"error": {
		"code": "UNAUTHORIZED",
		"message": "Réinitialisation du mot de passe en cours. Veuillez vérifier vos emails pour terminer le processus. Tant que la procédure ne sera pas terminée, vous ne pourrez pas accéder à ces services"
	}
}


Si la procédure de reset aboutie, le champ password_reset_in_progress est passé à false et le token password_reset_token est passé à null

##### Register 

https://backend.nationsound2024-festival.fr/api/user/register

Méthode POST

body :

{

	"email":"test@test.com",
	"password":"password",
	"firstName":"Jules",
	"lastName":"Cesars"

}

Le controlleur va vérifier si l'emai n'existe pas et si le mot de passe est conforme.

En cas d'email Existant :

{
	"status": "error",
	"data": null,
	"error": {
		"code": "email_already_exists",
		"message": "Cet email existe déjà !"
	}
}

En cas de mot de passe non conforme :

{
	"status": "error",
	"data": null,
	"error": {
		"code": "bad_password",
		"message": "Le mot de passe doit contenir au moins 8 caractères !"
	}
}

En cas d'email invalide :

{
	"status": "error",
	"data": null,
	"error": {
		"code": "invalid_email",
		"message": "Email invalide !"
	}
}

En cas de succès {
	"status": "success",
	"data": {
		"message": "Utilisateur enregistré avec succès!"
	},
	"error": null
}

Un email est envoyé  à l'utilisateur avec un lien pour vérifier son adresse email avec un token. Si le token est valide, l'utilisateur est considéré comme vérifié.


##### Login

https://backend.nationsound2024-festival.fr/api/user/login_check

Méthode POST

Body :

{
	"email" : "test@test.com",
	"password" : password"
}

En cas de succès un token est JWT est retourné :

{
	"token": "Token"
}

En cas d'erreurs de mot de passe ou d'email :

{
	"code": 401,
	"message": "Identifiants invalides."
}

##### Obtenir le profil utilisateur 

https://backend.nationsound2024-festival.fr/api/user/profil
Méthode Get
Header "Bearer Texte_du_token_jwt"

{
	"status": "success",
	"data": {
		"email": "test@test.com",
		"firstName": "Marc",
		"lastName": "Antoine",
		"newsletter": false,
		"eventNotification": false
	},
	"error": null
}

En cas de token invalide :

{
	"code": 401,
	"message": "Invalid JWT Token"
}


##### Modifier le profil utilisateur 

Ce chemin permet de modifier fistName, lastName et email ainsi que les préférences en matière d'abonnements (newsletter et évènements). Il n'est pas nécessaire de tous les modifier, la modification d'un seul paramètre est possible,.

https://backend.nationsound2024-festival.fr/api/user/profil/edit
Méthode DELETE
Header "Bearer Texte_du_token_jwt"

Modification adresse email 

Le endpoint update permet de changer d'email mais cette mise à jour va faire l'objet d'une procédure particulière.
Le nouvel email va être conservé provisoirement dans un champ new_email et un token email_change_token va être généré.

Un mail va être envoyé à l'ancienne adresse mail pour confirmer ou non le changement d'adresse email. Ce mail contient deux liens, un lien de confirmation de la procédure et un lien d'annulation de la procédure.

En cas de confirmation l'email est changé, new_email est effacé ainsi que le token. Un nouveau token est généré et mail pour valider la nouvelle adresse est envoyée à cette dernière avec un lien de validation comme pour la procédure de register.

En cas d'annulation de la procédure le token de changement ainsi que new-email sont effacés et par sécurité une procédure de reset du mot de passe est lancée.


{
	"status": "success",
	"data": {
		"message": "Utilisateur modifié avec succès",
		"emailChangeMessage": "Un email de confirmation a été envoyé à votre ancienne adresse email. Veuillez cliquer sur le lien qu'il contient pour confirmer la procédure de changement."
	},
	"error": null
}



##### Effacer le profil utilisateur

Cette procédure ne peut être utilisée que pour les rôles USER

https://backend.nationsound2024-festival.fr/api/user/profil/delete
Méthode DELETE
Header "Bearer Texte_du_token_jwt"

{
	"status": "success",
	"data": {
		"message": "Profil supprimé avec succès !"
	},
	"error": null
}

Si l'utilisateur à un rôle EDITOR ou ADMIN :

{
	"status": "error",
	"data": null,
	"error": {
		"code": "not_authorized",
		"message": "Vous n'êtes pas autorisé à effectuer cette action !"
	}
}
















