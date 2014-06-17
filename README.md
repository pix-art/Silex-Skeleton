INTRO
=====
###Version 1.5 [![Build Status](https://travis-ci.org/pix-art/Silex-Skeleton.png?branch=master)](https://travis-ci.org/pix-art/Silex-Skeleton)

**Welcome to the Pix-art Silex Skeleton guide.**

In this guide i'll be explaining the basic on how to use the Skeleton and show you some neat tricks that have been implemented to make your all-day cases easier.

First of all I would suggest you to read the Silex Manual ([http://silex.sensiolabs.org/documentation](http://silex.sensiolabs.org/documentation)), I'll be using this documentation to quote or add examples to my documentation.

Silex is an MVC framework. The folder structure i use is optimized for a simple MVC structure. My inspiration is based on the folder structure used in Symfony2.

###Structure

	├── .travis.yml
	├── .jshintrc		
	├── .git-ftp-ignore
	├── .editorconfig
	├── .htaccess
	├── composer.json
	├── package.json
	├── gulpfile.js
	├── config.rb	
	├── phpunit.xml.dist
	├── cli-config.php
	├── index.php
	├── bootstrap
	│   └── config.php
	│   └── database.php
	│   └── general.php
	│   └── bootstrap.php
	├── assets (Auto created)
	│   └── ...
	├── vendor (Auto created)
	│   └── ...
	└── src
	    └── .htaccess
	    └── Controller
	    └── Constraint
	    └── Entity
	    └── Proxy
	    └── Resources
	    │ 	└── config
	    │ 	└── translations
	    │ 	└── view    
	    │ 	└── js    
	    │ 	└── sass
	    │ 	└── img     
	    └── Service
	    └── ServiceProvider
	    └── Tests
	    	└── BaseTest.php

**Site:** [https://github.com/pix-art/Silex-Skeleton](https://github.com/pix-art/Silex-Skeleton)


THE SETUP
=========
Download the latest version from github

	git clone git@github.com:pix-art/Silex-Skeleton.git

Install your vendors via composer (Backenders only)

	curl -s http://getcomposer.org/installer | php
				  php composer.phar install

Install your vendors via gulp/npm (Backend & Frontend)

	npm install (Will install all gulp dependencies + vendors)
	gulp
	
Crush your vendors (This is an extra, I use this to shred the size of the vendor folder)

	curl https://raw.github.com/carlosbuenosvinos/compify/master/compify.phar
				  php compify.phar crush

CONFIGURATION
=============

	└── src
    	└── Resources
			└── config
				└── default-settings.yml
				
####You have to copy the settings file into settings.yml and add your own information. More details below

Debug mode on/off

	debug: true

Base url is used for absolute pathing

	base_url: http://www.example.com

Languages
	
	default_language: nl
	languages: [nl, fr, en]
	
Google Analytics, these variables are needed for analytics.js found in assets

	google_analytics:
    	code: UA-XXXXXXX-1
    	id: XXX #Unique ID for your project added to each action
    	name: MyProject #Name used to push your data to google
    	
Database configuration
	
	database:
    	driver: pdo_mysql
    	host: localhost
    	dbname: dbname
    	user: user
    	password: password
    	
Facebook

	facebook:
    	app_id: xxx
    	secret: xxx
    	tab: https://www.facebook.com/xxxxxx/app_xxxxx #tab url if you want redirect action to work
    	start_route: index #The route you will be redirected to if mobile or if liked
    	
SERVICE
========

	└── src
	    └── Service
	    	└── ...

Services should be declared in index.php
	
Your service will contain all of your logic. 1 basic service has been provided: FormService.

**FormService** will be used to build your forms and comes with injection of the FormFactory and UrlGenerator.

I use dependency injection in it's most basic form which means you'll have to inject all your services in other services via de constructor after you declared them. This can be done in bootstrap.php.

Example FormService injection:

	$app['form_service'] = function ($app) {
    	return new Service\FormService($app['form.factory'], $app['url_generator']);
	};

VALIDATION
==========

	└── src
	    └── Constraint
	    	└── ...

This folder had an example of a custom validation constraint. Here you can declare any other custom constraints you would like to use in your project.

**No dependency example:**

I created a custom Alphanumeric check which can now be used by including the constraint in your Entity (For more info check the next chapter).

	use Constraint\ContainsAlphanumeric;

You can call this constraint in your loadValidatorMetadata function as following:

	public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('myfield', new ContainsAlphanumeric());
    }

**Dependency example:**

I created a Unique constraint that allows you to check if a field is already used in your database.

	use Constraint\Unique;
	
You can call this constraint in your loadValidatorMetadata function as following:

	$metadata->addPropertyConstraint('email', new Unique(array('field' => 'email', 'entity' => $metadata->getReflectionClass()->getName())));

For more information on how to do DI in a constraint read my protip:

https://coderwall.com/p/wz2tiq

ENTITY
=====

	└── src
	    └── Entity
	    	└── BaseEntityInterface.php
	    	└── ...

Entities are like Models, but they have a direct relation to your database schema. Via Anotations I declare all the fields. 

**Example:**

	/**
 	* @ORM\Entity
	* @ORM\HasLifecycleCallbacks()
	*/
	class Example implements BaseEntityInterface
	{
       /**
	    * @ORM\Column(type="integer")
	    * @ORM\Id
    	* @ORM\GeneratedValue(strategy="AUTO")
	    */
    	private $id;

    	/**
    	* @ORM\Column(type="datetime")
    	*/
    	private $last_updated;

    	/**
	     * @ORM\Column(type="string", length=250)
    	 */
	    private $name;

After you declared your fields you can use the doctrine tool set to generate your setters/getters.

	php vendor/bin/doctrine orm:generate-entities src/

You can also generate your schema by executing
	
	 php vendor/bin/doctrine orm:schema-tool:create


CONTROLLER
===========

	└── src
	    └── Controller
	    	└── ...


This class will be used to map your view with your model layer as MVC teaches us. There are 2 variables defined in each action which allow you to call your Request object ([more info](http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/Request.html)) and your Application object ([more info](http://silex.sensiolabs.org/api/Silex/Application.html)). Any extra parameter has to be added **after** these two. 

	public function exampleAction(Request $request, Application $app)
    {	
        return $app['twig']->render('example.html.twig', array());
    }

ROUTING
=======

	└── src
    	└── Resources
			└── config
				└── routing.yml

Routing is generated via yaml. This is based on Symfony2 so for more information look here: [http://symfony.com/doc/current/book/routing.html](http://symfony.com/doc/current/book/routing.html). 

	example:
  		path: /{_locale}/example
  		defaults: { _controller: 'Controller\ExampleController::exampleAction' }

I added one extra the RedirectController. This is made to make it possible to create routes that instantly redirect you. For example a if you visit / you'll be redirected to the dutch version /nl/index

	start:
    	pattern:   /
    	defaults:  { _controller: 'Controller\RedirectController::redirectAction', path: index, slugs: {_locale: nl} }


VIEW ([TWIG](twig.sensiolabs.org))
===========

	└── src
    	└── Resources
			└── view
				└── ...

Since Silex is a micro framework made by Sensiolabs they implemented Twig as the standard templating engine. Twig is automaticly available in the application by calling: **$app['twig']**. In the build.php everything is predefined together with your templating directory.

To render a template you can simply use this example in your controller. It will then automaticly look up the file example.html.twig in your view directory and render it.

	$app['twig']->render('example.html.twig', array());


TRANSLATIONS
============

	└── src
    	└── Resources
			└── translations
				└── ...

The symfony translations class is used, you can find more information about Symfony translations [here](http://symfony.com/doc/current/book/translation.html). In this skeleton everything is done by YAML, so the translation files are also loaded from a YAML format. You can change these but you'll have to change your build.php aswell.

The translations class brings extra twig plugins which make it easy for you to do translations in your templates.

You can print your locale at any time by fetching "locale" from the App. 
	
	{{ app.locale }}

**Example:**
This example translates hello and will replace the variable %name% with Anonymous.

	{{ 'hello'|trans|replace({'%name%' : 'Anonymous'}) }}

TESTING
============

	└── src
    	└── Tests

Testing should always be done by extending BaseTest. By doing so you get access to $this->app which is the bootstrap of our Silex Application exacly as you would use it in the normal run(). This also uses the MockArraySessionStorage provided by Symfony.

**Example:**
See FormServiceTest.php

FACEBOOK
============

Some default settings for facebook tab's have been added. 

	#Facebook Routing
	facebook_fangate:
	  path: /fangate
	  defaults: { _controller: 'Controller\FacebookController::fangateAction' }

	facebook_redirect:
	  path: /fbredirect
	  defaults: { _controller: 'Controller\FacebookController::redirectAction' }

**What does this do? **

/fangate is a default route that will work when you call this on your facebook tab. It will check if you "liked" the current page and if so will redirect you to the default route you selected in your settings.yml. (Yes it will also fetch your locale and add it)

/fbredirect is a default route that will determine if you're a mobile or a desktop user. If you're mobile you'll be redirected to the default route else you'll be redirected to the facebook tab defined in settings.yml.

GULP
============

Gulp is the cool version of grunt. This bad boy will cover all your frontend work. When doing frontend you can run **"gulp"** and this will start up the default watch task. It will cover 3 folders in your Resources (img/sass/js). All 3 have different watches. 

 - Images will be compiled and moved to assets/img
 - JS will be compiled and moved to assets/js
 - Sass will be compiled into CSS and dumped in assets/css
 
These are all for development which means css will not be compiled and js wont be minified. Once you're ready for production you can run **"gulp build"** this will do all of the above but also some extra's for your production env

 - JS will be minified
 - CSS will be minified
