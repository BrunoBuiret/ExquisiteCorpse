<?php

namespace ExquisiteCorpse\Controller;

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
 */
class CommonController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home()
    {
        return $this->render(
            'common/home.html.twig',
            array(
                'lastGames' => array()
            )
        );
    }

    /**
     * @param int $id
     */
    public function game($id)
    {

    }

    /**
     * @param Request $request
     */
    public function add(Request $request)
    {

    }
}