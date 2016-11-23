<?php

namespace ExquisiteCorpse\Controller;

use DDesrosiers\SilexAnnotations\Annotations as SLX;
use ExquisiteCorpse\Entity\Game;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CommonController
 *
 * @package ExquisiteCorpse\Controller
 * @author Thomas Arnaud <thomas.arnaud@etu.univ-lyon1.fr>
 * @author Bruno Buiret <bruno.buiret@etu.univ-lyon1.fr>
 * @author Bastien Guyl <bastien.guyl@etu.univ-lyon1.fr>
 * @author Alexis Rabilloud <alexis.rabilloud@etu.univ-lyon1.fr>
 * @version 1.0
 * @SLX\Controller
 */
class CommonController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @SLX\Route(
     *  @SLX\Request(method="GET", uri="/"),
     *  @SLX\Bind(routeName="home")
     * )
     */
    public function home()
    {
        return $this->render(
            'common/home.html.twig',
            array(
                "games" => array(new Game())
            )
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @SLX\Route(
     *  @SLX\Request(method="GET", uri="/about"),
     *  @SLX\Bind(routeName="about")
     * )
     */
    public function about()
    {
        return $this->render(
            'common/about.html.twig',
            array()
        );
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @SLX\Route(
     *  @SLX\Request(method="GET", uri="/games/{id}"),
     *  @SLX\Bind(routeName="game")
     * )
     */
    public function game($id)
    {
        return $this->render(
          'common/game.html.twig',
            array(

            )
        );
    }

    /**
     * @param Request $request
     */
    public function add(Request $request)
    {

    }
}