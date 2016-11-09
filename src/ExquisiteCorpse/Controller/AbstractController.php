<?php

/**
 * Class AbstractController
 *
 * @author Thomas Arnaud <thomas.arnaud@etu.univ-lyon1.fr>
 * @author Bruno Buiret <bruno.buiret@etu.univ-lyon1.fr>
 * @author Bastien Guyl <bastien.guyl@etu.univ-lyon1.fr>
 * @author Alexis Rabilloud <alexis.rabilloud@etu.univ-lyon1.fr>
 * @version 1.0
 */
abstract class AbstractController
{
    protected $app;

    public function render($viewPath, $vars = array())
    {
        return $this->app['twig']->render($viewPath, $vars);
    }

    public function redirect()
    {

    }
}