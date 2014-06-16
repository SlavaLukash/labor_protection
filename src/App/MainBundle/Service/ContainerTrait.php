<?php

namespace App\MainBundle\Service;

use Admitad\Api\Api;
use App\MainBundle\Entity\User;
use App\MainBundle\Mail\MailSender;
use App\MainBundle\Security\UserProvider;
use App\MainBundle\Service\ContainerAwareTrait;
use Knp\Component\Pager\Paginator;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Security\Core\SecurityContext;

trait ContainerTrait
{
    use ContainerAwareTrait;


    /**
     * @return SecurityContext
     */
    public function getSecurityContext()
    {
        return $this->getContainer()->get('security.context');
    }

    /**
     * @return Paginator
     */
    public function getPaginator()
    {
        return $this->getContainer()->get('knp_paginator');
    }
}