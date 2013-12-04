<?php

namespace Sir\OtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
		if($this->getUser()->hasRole('ROLE_ADMIN')) {
			$response = $this->forward('Sir\OtBundle\Controller\UserController::indexAction');
		} else {
			$response = $this->forward('Sir\OtBundle\Controller\EmployeeController::indexAction');
		}
		return $response;
    }
}
