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
     * Displays the home page with every available game.
     *
     * @return \Symfony\Component\HttpFoundation\Response The response to send to the client.
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
     * Displays the "About" page.
     *
     * @return \Symfony\Component\HttpFoundation\Response The response to send to the client.
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
     * Displays a game page, whether to add a word or to read the sentence.
     *
     * @param Request $request The user's request.
     * @param string $id The game's id.
     * @return \Symfony\Component\HttpFoundation\Response The response to send to the client.
     * @SLX\Route(
     *  @SLX\Request(method="GET|POST", uri="/games/{id}"),
     *  @SLX\Bind(routeName="game")
     * )
     */
    public function game(Request $request, $id)
    {
        // Initialize vars
        $game = $this->app['repository.games']->fetch($id);
        $entry = new Entry();
        $form = $this->app['form.factory']->create(EntryType::class, $entry);

        // Handle request
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
                    'Votre participation à "%s" a été enregistrée !',
                    $game->getTitle()
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
     * Displays a form to create a new game.
     *
     * @param Request $request The user's request.
     * @return \Symfony\Component\HttpFoundation\Response The response to send to the client.
     * @SLX\Route(
     *  @SLX\Request(method="GET|POST", uri="/newGame"),
     *  @SLX\Bind(routeName="newGame")
     * )
     */
    public function newGame(Request $request)
    {
        // Initialize vars
        $game = new Game();
        $form = $this->app['form.factory']->create(GameType::class, $game);

        // Handle request
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
                    'Votre partie "%s" a été créée !',
                    $game->getTitle()
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