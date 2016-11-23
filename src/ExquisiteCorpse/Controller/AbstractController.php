<?php

namespace ExquisiteCorpse\Controller;

use ExquisiteCorpse\Application;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractController
 *
 * @package ExquisiteCorpse\Controller
 * @author Thomas Arnaud <thomas.arnaud@etu.univ-lyon1.fr>
 * @author Bruno Buiret <bruno.buiret@etu.univ-lyon1.fr>
 * @author Bastien Guyl <bastien.guyl@etu.univ-lyon1.fr>
 * @author Alexis Rabilloud <alexis.rabilloud@etu.univ-lyon1.fr>
 * @version 1.0
 */
abstract class AbstractController
{
    /**
     * @var Application A reference to the running app.
     */
    protected $app;

    /**
     * AbstractController constructor.
     *
     * @param Application $app A reference to the running app.
     */
    public function __construct(Application $app)
    {
        // Initialize properties
        $this->app = $app;
    }

    /**
     * Renders a twig view.
     *
     * @param string $viewPath The view's path.
     * @param array $vars The vars needed by the view.
     * @return Response The response to send to the client.
     */
    public function render($viewPath, $vars = array())
    {
        return new Response($this->app['twig']->render($viewPath, $vars));
    }
}