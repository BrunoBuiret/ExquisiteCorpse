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

    /**
     * Generates a redirection response to use.
     *
     * @param string $routeName The route's name.
     * @param array $parameters Parameters used to build the route.
     * @return RedirectResponse The response to send to the client.
     */
    protected function redirect($routeName, $parameters = array())
    {
        return new RedirectResponse($this->generatePath($routeName, $parameters));
    }
    /**
     * Sends data as JSON to the client.
     *
     * @param mixed $data The data to send.
     * @param int $status The response's status.
     * @param array $headers The response's additional headers.
     * @return JsonResponse The response to send to the client.
     */
    protected function json($data, $status = 200, $headers = array())
    {
        return new JsonResponse($data, $status, $headers);
    }

    /**
     * Generates a route's path.
     *
     * @param string $routeName The route's name.
     * @param array $parameters Parameters used to build the route.
     * @return string The route's path.
     */
    protected function generatePath($routeName, $parameters = array())
    {
        return $this->app['url_generator']->generate($routeName, $parameters, UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    /**
     * Generates a route's absolute URL.
     *
     * @param string $routeName The route's name.
     * @param array $parameters Parameters used to build the route.
     * @return string The route's absolute URL.
     */
    protected function generateUrl($routeName, $parameters = array())
    {
        return $this->app['url_generator']->generate($routeName, $parameters, UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * Adds a flash message to the current session.
     *
     * @param string $type The message's type.
     * @param string $contents The message's contents.
     */
    protected function addFlash($type, $contents)
    {
        $this->app['session']->getFlashBag()->add($type, $contents);
    }
}