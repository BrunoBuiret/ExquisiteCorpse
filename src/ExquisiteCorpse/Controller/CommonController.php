<?php

namespace ExquisiteCorpse\Controller;

use DDesrosiers\SilexAnnotations\Annotations as SLX;
use ExquisiteCorpse\Entity\Entry;
use ExquisiteCorpse\Entity\Game;
use ExquisiteCorpse\Type\EntryType;
use ExquisiteCorpse\Type\GameType;
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
            [
                'games' => $this->app['repository.games']->fetchAll()
            ]
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
            'common/about.html.twig'
        );
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @SLX\Route(
     *  @SLX\Request(method="GET|POST", uri="/games/{id}"),
     *  @SLX\Bind(routeName="game")
     * )
     */
    public function game($id, Request $request)
    {
        $game = $this->app['repository.games']->fetch($id);
        $entry = new Entry();
        $form = $this->app['form.factory']->create(EntryType::class, $entry);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entry
                ->setCreatedAt(new \DateTime())
                ->setGame($game)
                ->setId($this->app['repository.games']->getNextEntryId($id))
            ;

            $game->addEntry($entry);
            if(count($game->getEntries()) == 10)
            {
                $game->setFinished(true);
            }
            
            $this->app['repository.games']->save($game);
            $this->addFlash(
                'success',
                sprintf(
                    'Votre participation a été enregistrée !'
                )
            );
            return $this->redirect('home');
        }

        return $this->render(
            'common/game.html.twig',
            [
                'game' => $game,
                'form' => [
                    'data'   => $form->createView(),
                    'action' => $this->generatePath('game', ['id' => $id])
                ]
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @SLX\Route(
     *  @SLX\Request(method="GET|POST", uri="/newGame"),
     *  @SLX\Bind(routeName="newGame")
     * )
     */
    public function newGame(Request $request)
    {
        $game = new Game();
        $form = $this->app['form.factory']->create(GameType::class, $game);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $game
                ->setCreatedAt(new \DateTime())
                ->setFinished(false)
            ;

            $this->app['repository.games']->save($game);
            $this->addFlash(
                'success',
                sprintf(
                    'Votre partie a été créée !'
                )
            );

            return $this->redirect('home');
        }

        return $this->render(
            'common/newGame.html.twig',
            [
                'form' => [
                    'data'   => $form->createView(),
                    'action' => $this->generatePath('newGame')
                ]
            ]
        );
    }
}