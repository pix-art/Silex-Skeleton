CHANGELOG
=========

1.1.0 (2014-02-13)
------------------

* Implemented Flash bags standard


1.2.0 (2014-02-20)
------------------

* Implemented Symfony Forms and Validation
       
        "symfony/form": "~2.3"
        "symfony/validator": "~2.3"

* Removed ValidationExceptions
* Abstract BaseModel for all Models
* DatabaseService to handle basic calls

1.3.0 (2014-02-26)
------------------

* Removed Database service
* Removed Models
* Introduced Entities
* Implemented Doctrine ORM
       
        "dflydev/doctrine-orm-service-provider": "1.0.*@dev"
* Autogenerating database structure
* Refactored framework structure

