<?php

namespace YodaEventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name, $count)
    {

        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('YodaEventBundle:Event');
        $event = $repo->findOneBy([
            'name' => 'Darth birthday'
        ]);

        return $this->render("YodaEventBundle:Default:index.html.twig",
            ['event' => $event]);

    }
}
