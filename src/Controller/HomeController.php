<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Spatie\Ssr\Renderer;
use Spatie\Ssr\Engines\Node;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @Route("/home", name="home")
     * @Route("/posts", name="posts")
     */
    public function index(Request $request)
    {
        $uri = $request->getPathInfo();
        // string $nodePath, string $tempPath
        $engine = new Node('node', __DIR__.'/../../assets/js/server');
        $renderer = new Renderer($engine);

        $render =  $renderer
            // ->disabled(false)
            ->context('uri', $uri)
            ->context('fabian', ["name"=>"fabian", "lastname"=>"nino"])
            ->enabled(true)
            ->debug(true)
            // ->env('NODE_ENV', 'production')
            ->env('REACT_APP_FB_URL', '/home')
            ->fallback('<div id="app"></div>')
            ->entry(__DIR__.'/../../assets/js/server/index.js')
            ->render();
            

        return $this->render('home/index.html.twig', [
            'render' => $render,
        ]);
    }
}
