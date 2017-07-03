
[![Build Status](https://travis-ci.org/afpa-mx2016/tautof.svg?branch=master)](https://travis-ci.org/afpa-mx2016/tautof)

tautof
======

practical exercice with Symfony FW, release of an advert app.
- be able to search for an advert according to car maker/ model
- add an advert
- show basic security features ( register / login / protected area )


# install
`git clone this repo`
 - install dependencies :
 `composer install`
 - create a database 
 - copy `app/config/parameters.dist.yml` to `app/config/parameters.yml`and change your custom settings
 - import initial sql file: `php bin/console doctrine:fixtures:load --append --fixtures=src/AppBundle/DataFixtures/ORM/init`

