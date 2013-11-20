<?php

namespace Sir\OtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
		$response = $this->forward('Sir\OtBundle\Controller\EnterpriseController::indexAction');
		return $response;

//		return $this->render('SirOtBundle:Default:index.html.twig');
    }
}
