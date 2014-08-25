<?php

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

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

//Force UTF-8
$app['orm.em']->getEventManager()->addEventSubscriber(
    new \Doctrine\DBAL\Event\Listeners\MysqlSessionInit('utf8', 'utf8_unicode_ci')
);