<?php

namespace Sir\OtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
		$oUser = $this->getUser();
		$arRoles = $oUser->getRoles();
		$oO = $this->getDoctrine();
		$oA = $oO->getRepository('SirOtBundle:Marriagekind')->find('1');
		echo '<pre>';
		print_r($oA->getName());
		echo '</pre>';
		if(in_array('ROLE_ADMIN', $arRoles))
		{
			echo 1;
		}
		return $this->render('SirOtBundle:Admin:dashboard.html.php');
    }
}
