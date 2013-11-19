INTRO
=====

**Welcome to the Pix-art Silex Skeleton guide.**

In this guide i'll be explaining the basic on how to use the Skeleton and show you some neat tricks that have been implemented to make your all-day cases easier.

First of all I would suggest you to read the Silex Manual ([http://silex.sensiolabs.org/documentation](http://silex.sensiolabs.org/documentation)), I'll be using this documentation to quote or add examples to my documentation.

Silex is an MVC framework. The folder structure i use is optimized for a simple MVC structure. My inspiration is based on the folder structure used in Symfony2.

###Structure

	├── composer.json
	├── composer.lock
	├── index.php
	├── build.php
	├── .htaccess
	├── assets
	│   └── ...
	├── vendor
	│   └── ...
	└── src
	    └── .htaccess
	    └── Controller
	    └── Exceptions
	    └── Model
	    └── Resources
	    │ 	└── config
	    │ 	└── translations
	    │ 	└── view
	    └── Service

**Site:** [https://github.com/pix-art/Silex-Skeleton](https://github.com/pix-art/Silex-Skeleton)


THE SETUP
=========
Download the latest version from github

	git clone git@github.com:pix-art/Silex-Skeleton.git

Install your vendors

	curl -s http://getcomposer.org/installer | php
				  php composer.phar install

Crush your vendors (This is an extra, I use this to shred the size of the vendor folder)

	curl https://raw.github.com/carlosbuenosvinos/compify/master/compify.phar
				  php compify.phar crush

CONFIGURATION
=============

	└── src
    	└── Resources
			└── config
				└── settings.yml

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
    	name: Yunomi #Name used to push your data to google
    	
Facebook

	facebook_id: xxxxx

Database configuration
	
	database:
    	driver: pdo_mysql
    	host: localhost
    	dbname: dbname
    	user: user
    	password: password
    	
SERVICE
========

	└── src
	    └── Service
	    	└── ...

Services should be declared in index.php
	
Your service will contain all of your logic. I have an example service with validation and input for a form that gets written into a database. 

I use dependency injection in it's most basic form which means you'll have to inject all your services in other services via de constructor after you declared them. 

Example of database injection:

	$app['ExampleService'] = function ($app) {
    	return new Service\ExampleService($app['db']);
	};

EXCEPTIONS
==========

	└── src
	    └── Exceptions
	    	└── ValidationException

For easy form validation i've made a **ValidationException**. 

	use Exceptions\ValidationException;

This is an extension of the basic php **Exception**. But it has an extra variable that contains errors in the following form.
	
	array(
		'variable1' => 'not_found',
		'variable2' => 'incorrect_data'
	);
	
You can extract the error from this exception by doing the following
	
	try {
            
    } catch (ValidationException $e) {
    	$errors = $e->getErrors();
    }

MODEL
=====

	└── src
	    └── Model
	    	└── ...

Models are build like in most cases, with private variables and getters and setters per variable. In this skeleton I use a coding standard where we use the **uppercase version** of the **variable** as **column name** for the **database**. This allows you to use the magic functions **fromColumn($dbData)** and **toColumn()**.

###toColumn

	class Example
	{

		private $variable;
		
		...
	 
	 	public function toColumn()
    	{
    	    $array = array();
	        $class_vars = get_object_vars($this);

        	foreach ($class_vars as $name => $value) {
    	        $array[strtoupper($name)] = utf8_decode($value);
 	       }
        
        	return $array;
    	}
    	
    	...    	
	 
This Example model will allow you to call the function toColumn. Then it will convert every class variable into an uppercase and add it as a key to an array. The value of each key will be filled up with the value the variable contained. This way you can easy map your Model to your Database. 

###fromColumn

	class Example
	{

		private $variable;
		
		...
	 
	 	public function fromColumn(array $data)
    	{
       		foreach ($data as $key => $value) {
            	$ucfirst = ucfirst(strtolower($key));
	            $name = 'set'.$ucfirst;

    	        if (method_exists($this, $name)) {
        	        $this->$name(utf8_encode($value));
            	}
        	}
    	}
    	
    	...
	 
This Example model will allow you to call the function fromColumn($dbData) with your query data. Then it will convert your column name into a capitalized form and see if there is a setter function for this variable. If there is it will automagicly call this function and set the data it contains as a value.

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