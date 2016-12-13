<?php

namespace ExquisiteCorpse;

use DDesrosiers\SilexAnnotations\AnnotationServiceProvider;
use Doctrine\Common\Cache\FilesystemCache;
use ExquisiteCorpse\Repository\GameRepository;
use ExquisiteCorpse\Type\EntryType;
use MongoDB\Driver\Manager;
use Monolog\Logger;
use Silex\Application as BaseApplication;
use Silex\Provider\CsrfServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Loader\YamlFileLoader;

/**
 * Class Application
 *
 * @package ExquisiteCorpse
 * @author Thomas Arnaud <thomas.arnaud@etu.univ-lyon1.fr>
 * @author Bruno Buiret <bruno.buiret@etu.univ-lyon1.fr>
 * @author Bastien Guyl <bastien.guyl@etu.univ-lyon1.fr>
 * @author Alexis Rabilloud <alexis.rabilloud@etu.univ-lyon1.fr>
 * @version 1.0
 */
class Application extends BaseApplication
{
    /**
     * Creates a new Exquisite Corpse application.
     *
     * @param string $environment The current environment.
     * @param bool $debug Should debugging informations be logged?
     * @param array $values The parameters or objects.
     */
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
        // @see http://silex.sensiolabs.org/doc/master/providers/twig.html
        $this->register(
            new TwigServiceProvider(),
            array(
                'twig.path'    => __DIR__.'/Resources/views',
                'twig.options' => array(
                    'debug'   => $this['debug'],
                    'charset' => 'UTF-8',
                    'cache'   => $this->getCacheDir().'twig/',
                )
            )
        );

        // @see http://silex.sensiolabs.org/doc/master/providers/monolog.html
        $this->register(
            new MonologServiceProvider(),
            array(
                'monolog.name'    => 'exquisite-corpse',
                'monolog.logfile' => $this->getLogDir().$this['environment'].'.log',
                'monolog.level'   => $this['debug'] ? Logger::DEBUG : Logger::INFO,
            )
        );

        // @see http://silex.sensiolabs.org/doc/master/providers/session.html
        $this->register(
            new SessionServiceProvider()
        );

        // @see http://silex.sensiolabs.org/doc/master/providers/locale.html
        $this->register(
            new LocaleServiceProvider()
        );

        // @see http://silex.sensiolabs.org/doc/master/providers/translation.html
        $this->register(
            new TranslationServiceProvider(),
            array(
                'locale_fallbacks' => array('fr'),
            )
        );
        $this->extend(
            'translator',
            function($translator, $app)
            {
                $translator->addLoader('yaml', new YamlFileLoader());

                if(is_dir(__DIR__.'/Resources/locales/'))
                {
                    $finder = new Finder();
                    $finder
                        ->in(__DIR__.'/Resources/locales/')
                        ->files()
                        ->name('*.yml')
                        ->ignoreDotFiles(true)
                    ;

                    foreach($finder as $file)
                    {
                        $parts = explode('.', $file->getFilename());
                        $translator->addResource(
                            'yaml',
                            $file->getRealPath(),
                            $parts[0]
                        );
                    }
                }

                return $translator;
            }
        );

        // @see http://silex.sensiolabs.org/doc/master/providers/validator.html
        $this->register(
            new ValidatorServiceProvider()
        );

        // @see http://silex.sensiolabs.org/doc/master/providers/form.html
        $this->register(
            new FormServiceProvider()
        );

        // @see http://silex.sensiolabs.org/doc/master/providers/csrf.html
        $this->register(
            new CsrfServiceProvider()
        );

        // @see https://github.com/danadesrosiers/silex-annotation-provider
        $this->register(
            new AnnotationServiceProvider(),
            array(
                'annot.cache'               => new FilesystemCache($this->getCacheDir().'annotations/'),
                'annot.controllerDir'       => __DIR__.'/Controller/',
                'annot.controllerNamespace' => 'ExquisiteCorpse\\Controller\\',
            )
        );

        // Register more services
        // @see http://silex.sensiolabs.org/doc/master/services.html
        $this['db'] = new Manager('mongodb://mongo');

        // @see \ExquisiteCorpse\Repository\GameRepository
        $this['repository.games'] = function()
        {
            return new GameRepository($this['db'], $this['monolog']);
        };
    }

    /**
     * Gets the application's cache dir.
     *
     * @return string The application's cache dir.
     */
    public function getCacheDir()
    {
        return __DIR__.'/../../var/cache/';
    }

    /**
     * Gets the application's log dir.
     *
     * @return string The application's log dir.
     */
    public function getLogDir()
    {
        return __DIR__.'/../../var/logs/';
    }
}