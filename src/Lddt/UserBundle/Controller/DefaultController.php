<?php

namespace Lddt\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LddtUserBundle:Default:index.html.twig');
    }
}
