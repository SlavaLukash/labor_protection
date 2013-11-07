<?php

namespace Sir\OtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SirOtBundle:Default:index.html.twig', array('name' => '11'));
    }
    public function helloAction($name)
    {
        return $this->render('SirOtBundle:Default:index.html.twig', array('name' => $name));
    }
}
