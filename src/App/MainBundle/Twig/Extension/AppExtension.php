<?php

namespace App\MainBundle\Twig\Extension;

use App\MainBundle\DBAL\Types\Roles;
use Symfony\Component\HttpFoundation\Request;
use App\MainBundle\Twig\Extension\ContainerInterface;

/**
* A TWIG Extension which allows to show Controller and Action name in a TWIG view.
* The Controller/Action name will be shown in lowercase. For example: 'default' or 'index'
*/
class AppExtension extends \Twig_Extension
{
	/**
	* @var Request
	*/
	protected $request;

	/**
	* @var \Twig_Environment
	*/
	protected $environment;

	public function __construct(Request $request)
    {
        $this->setRequest($request);
    }


	public function setRequest(Request $request = null) {
		$this->request = $request;
	}

	public function initRuntime(\Twig_Environment $environment) {
		$this->environment = $environment;
	}

	public function getFunctions() {
		return array(
			'get_controller_name' => new \Twig_Function_Method($this, 'getControllerName'),
			'get_action_name' => new \Twig_Function_Method($this, 'getActionName'),
            'roles' => new \Twig_SimpleFunction('roles', [$this, 'rolesFunction']),
		);
	}

	/**
	* Get current controller name
	*/
	public function getControllerName() {
		if(null !== $this->request) {
			$pattern = "#Controller\\\([a-zA-Z]*)Controller#";
			$matches = array();
			preg_match($pattern, $this->request->get('_controller'), $matches);
			if(!empty($matches)) {
				return strtolower($matches[1]);
			}
			return NULL;
		}
	}

	/**
	* Get current action name
	*/
	public function getActionName() {
		if(null !== $this->request) {
			$pattern = "#::([a-zA-Z]*)Action#";
			$matches = array();
			preg_match($pattern, $this->request->get('_controller'), $matches);

			return $matches[1];
		}
	}

    public function rolesFunction($roles)
    {
        $result = [];
        foreach ((array)$roles as $role) {
            if (Roles::isValueExist($role)) {
                $result[] = Roles::getReadableValue($role);
            }
        }

        return implode(', ', $result);
    }

	public function getName() {
		return 'app_extension';
	}
}