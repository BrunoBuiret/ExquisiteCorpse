<?php

namespace ExquisiteCorpse;

use Silex\Application as BaseApplication;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

class Application extends BaseApplication
{
    public function __construct($environment, $debug = false, $values = array())
    {
        // Initialize properties and call super-constructor
        $values['environment'] = $environment;
        $values['debug'] = $debug;

        parent::__construct($values);

        // Error and exceptions handling
        ErrorHandler::register();
        ExceptionHandler::register();

        if(function_exists('xdebug_disable'))
        {
            xdebug_disable();
        }

        // Register more providers
        $this->register(
            new TwigServiceProvider(),
            array(
                'twig.path' => __DIR__.'/Resources/views'
            )
        );
    }
}