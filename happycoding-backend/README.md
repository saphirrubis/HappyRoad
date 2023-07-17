# happyRoad-backend

happyRoad-backend

**Description**: [API du covoiturage ]

## Configuration requise

    - PHP 8
    - GIT
    - Composer 2.5
    - MySQL
    - Xampp control 3.3.0
    - Symfony CLI 5.5.2
    - PHPMyAdmin 5.2.0

## Conception de projet

    Lien des fichiers partagés en ligne :
    - figma : wireframe, maquette : 
    - Miro : use case, parcours utilisateur : 
    - Jira :  backlog, user story : 

    Fichiers de développement dans le projet :
    - Dossier contenant tous les fichiers pour le développement : Development
    - schéma de la BDD : hr.svg
    - Contenu table brand : brand.sql
    - Contenu table model (à insérer après avoir inséré le contenu de la table brand) : model.sql
    - Contenu table type_address : type_address.sql
    - Contenu toutes tables (La BDD doit être vide (Sans table) pour insérer les données): hr_data.sql

## Installation et configuration

    Pour installer et configurer le projet, veuillez suivre les étapes suivantes :

    - `git clone `

    - `git switch dev`

    - `git pull origin dev`

    - `composer install`

    - Le projet a plusieurs fichiers de configuration, voir notamment le dossier config et ses sous-dossiers
        Ces fichiers de configuration viennent chercher des valeurs dans les fichiers de configuration.
        Nous pouvons notamment voir le fichier .env qui est disponible dès le clone du projet et qui est un
        template de ce que nous devons fournir. Veuillez lire les explications du fichier .env pour plus
        d'informations. Voici un exemple de configuration que l'on peut mettre dans un fichier d'environment local :

    - Connexion à la base de données:
       ********************************************

    - Pour la suite, si vous n'avez pas installé Symfony CLI, vous pouvez remplacer `symfony` par `bin/console`

    - Création de la base de données :
        `symfony console doctrine:database:create`

    - Vérifier que le mapping est correct (vérifier que les Entity sont bien transformables en schéma de base de données par l'ORM )
        `symfony console doctrine:mapping:info`

    - Avec cette commande, nous voyons que l'Entity Product a une erreur, il est indiqué dans la console qu'im y a un problème avec la clé      primaire. Il faudra le résoudre afin que l'ORM puisse créer le schéma de la base de données.
        ```
    [OK]   App\Entity\Order

    [OK] App\Entity\OrderDetails
    [FAIL] App\Entity\Product
    No identifier/primary key specified for Entity "App\Entity\Product". Every Entity must have an identifier/primary key.

    [OK] App\Entity\Promo
    [OK] App\Entity\Rate
    ```

    - Vérifier que la base de données est bien synchronisée avec le mapping des Entity:
        `symfony console doctrine:schema:validate`


    - `symfony console doctrine:schema:create`

    - Lancez la commande suivante afin de générer un fichier migration que l'on pourra utiliser pour créer les tables dans la base de données.
        Cela permet aussi de revenir en arrière et de rejouer une ou plusieurs migrations.
        `symfony console doctrine:migrations:dump-sql`

    - La commande suivante permet de mettre les données dans la base de données.
        `symfony console doctrine:fixtures:load`

    - Cette commande permet de générer les clés qui sont utilisés pour créer les tokens d'accés.
        `symfony console lexik:jwt:generate-keypair`

    - Etant donné que le projet est accesssible via HTTPS, il faut générer le certificat via cette commande:
        `symfony server:ca:install`

    - Pour lancer le projet, il faut faire:
        `symfony server:start
        [Nous conseillons d'utiliser l'executable symfony afin de lancer les commandes nécessaires au bon fonctionnement du projet ainsi que pour lancer le serveur.
    Pour la configuration, veuillez vous référer au fichier .env et au dossier config à la racine du projet.]

## initialisation du mailer:

pour mettre en place le mailer, utilisez la commande "composer require symfony/mailer " qui mettra en place les composant du mailer.
Ensuite, créez le controller avec php bin/console make:controller et appelez-le mailerControler (ou ici:"ContactController vu qu'il permet l'envoi d'un mail pour un formualaire de contact).
Pour le DSN, allez sur "Mailtrap.io" créez votre compte.
Ensuite allez sur "Inboxes", puis "My iinbox".
sous "integrations", dans l'onglet "cURL" choisir le langage et framework que vous utilisés ici "PHP", "Symfony 5+", vous allez obtenir le DSN qu'il faudra copier.
Allez dans ".env" et décommantez

  <!-- ###> symfony/mailer ###
     # MAILER_DSN=null://null
    ###< symfony/mailer ### -->

collez le "MAILER_DSN" copier sur mailtrap et collez le entre les deux "### symfony/mailer ###" (Ligne 158 ici).

Pour rappel ne JAMAIS mettre sur GIT le .env !!!!  
Dans ce cas, utilisez ".en.local" cela permmettra de faire les commits mais sans que vos données soient divulguées. (ici le dsn est sur un site de test, mais si vous mettez vos infos de boite mail perso, vous serez piraté.)
Dans le ".gitignore", ajoutez
" /.env.local
/.env.local.php
/.env.\*.local "
cela indique à GIT de ne pas publier les données.
