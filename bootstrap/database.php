<?php

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\ConstraintValidatorFactory;
use ServiceProvider\UniqueValidatorServiceProvider;

//DATABASE
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $app['config']['database']
));

//Set Annotations
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$app->register(new DoctrineOrmServiceProvider, array(
    "orm.proxies_dir" => __DIR__."/../src/Proxy",
    "orm.auto_generate_proxies" => true,
    "orm.em.options" => array(
        "mappings" => array(
            // Using actual filesystem paths
            array(
                "type" => "annotation",
                "namespace" => "Entity",
                "use_simple_annotation_reader" => false,
                "path" => __DIR__."/../src/Entity",
            )
        ),
    ),
));

$app->register(new UniqueValidatorServiceProvider());

$app->register(new Silex\Provider\ValidatorServiceProvider(), array(
    'validator.validator_factory' => new ConstraintValidatorFactory($app, array(
        'validator.unique' => $app['validator.unique']
    ))
));
