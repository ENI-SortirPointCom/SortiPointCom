# PROJET SORTIR.COM

configurer git pour le proxy :
```bash
git config --global http.proxy http://user:password@proxy-cdb.ad.campus-eni.fr:8080
```

pour creer une Entity :
```
php bin/console make:entity
```
## Symfony
utliser composer pour demarer un projet .
dans le rep du projet : 
``` php 
    composer create-project symfony/skeleton nom_du_projet
```
une fois creer on lance le server symfony 4 par : 
```
symfony server:start
```
demarer symfony 5
```bash
php -S 127.0.0.1:8080 -t public
```
pour regenerer les entity
```
php bin/console make:entity --regenerate
## Doctrine

ORM comme JPA.
on peur creer des entity column par annotation comme dans  Spring
voir doc : [doctrine](https://www.doctrine-project.org/projects/doctrine-annotations/en/1.6/index.html)
creer la base
```
php bin/console doctrine:database:create
```
creer les entity
```
php bin/console make:entity
```
creer des entity a partir d'une base de donnee
```
php bin/console doctrine:mapping:import "App\Entity" annotation --path=src/Entity
```

puis dans composer toujours dans le rep racine du projet :
```doctrine
php bin/console doctrine:schema:update --dump-sql to dump the SQL statements to the screen
```
pour valider a chaque changement la modification de la table :
```doctrine
php bin/console doctrine:schema:update --force

 ```
pour les requetes utiliser les repository
* declarer dans le controller  :
```php
$bookRepository = $em->getRepository(nom_de_la_classe::class);
```
* utiliser $bookRepository pour acceder aux différentes méthodes fournies par doctrine par ex :
    + $bookRepository->findAll();
    + $bookRepository->findBy(['pages' => 300]);
    + $bookRepository->count(); 
    
    pour limiter le nombre de resultat : setMaxResult
    
on peut personnaliser les requettes en definissant notre propre repository. voir BookRepository.
## FORMULAIRES
creation de formulaires automatique
```
 php bin/console make:form
```

## JSON
Pour rendre une classe serialisable :
```php
class Idea implements \JsonSerializable{/**
* @inheritDoc
*/public function jsonSerialize(){
 // TODO: Implement jsonSerialize() method.
}}
```
## SECURITE
creer le User
```
php bin/console make:user
php bin/console doctrine:schema:update --force
```
creer formulaire :
```
php bin/console make:auth
```
## api platform
* Create a new Symfony Flex project
```
$ composer create-project symfony/skeleton bookshop-api
```
* Enter the project folder
```
$ cd bookshop-api
```
* Install the API Platform's server component in this skeleton
```
$ composer req api
$ bin/console doctrine:database:create
$ bin/console doctrine:schema:create
symfony server:start
```
* les tables
```
php bin/console make:entity --api-resource
```
## REST
pour ajouter un element au moyen d'une jointure il faut ajouter la route a la variable :
```json
"type": "/api/animal_types/1"
```
**Si on fait un GET il n'y a pas de FLUSH() !!!!**
## EASY ADMIN
utilitaire pour generer des formulaires.
Il suffit de declarer les classes dans  :
packages\easy_admin.yaml
```yaml
easy_admin:
    entities:
        # List the entity class name you want to manage
        - App\Entity\Animal
        - App\Entity\AnimalType
        - App\Entity\AnimalFeedHistory
        - App\Entity\DailyAnimalNeeds
        - App\Entity\FoodStock
        - App\Entity\FoodType
```
 [voir la doc](https://symfony.com/doc/master/bundles/EasyAdminBundle/book/installation.html)  