<?php

namespace Sir\OtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
		$session = $this->getRequest()->getSession();
		$session->set('report_user_id', $this->getUser()->getId());
		
		if($this->getUser()->hasRole('ROLE_ADMIN')) {
			$response = $this->forward('Sir\OtBundle\Controller\UserController::indexAction');
		} else {
			$response = $this->forward('Sir\OtBundle\Controller\EmployeeController::indexAction');
		}
		return $response;
    }

	public function ajaxAction()
	{
		$request = $this->getRequest()->request->all();
		$em = $this->getDoctrine()->getManager();
		$ajaxResponse = array('action' => $request['action']);
		switch($request['action'])
		{
			case 'subdivision':
				$ajaxResponse['entities'] = $em->getRepository('SirOtBundle:Subdivision')->findBy(array('enterprise' => $request['id']));
				return $response = $this->render('SirOtBundle:Default:ajax_subdivision.html.twig', $ajaxResponse);
				break;
			case 'employee':
				$ajaxResponse['entities'] = $em->getRepository('SirOtBundle:Employee')->findBy(array('subdivision' => $request['id']));
				return $response = $this->render('SirOtBundle:Default:ajax_employee.html.twig', $ajaxResponse);
				break;
		}
	}
}
