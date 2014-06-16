<?php

namespace App\MainBundle\Service;

use App\MainBundle\Entity\UserRepository;
use Doctrine\ORM\EntityManager;

trait DoctrineTrait
{
    use ContainerAwareTrait;

    /**
     * @return Registry
     */
    public function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    /**
     * @param null $name
     * @return EntityManager
     */
    public function getEntityManager($name = null)
    {
        return $this->getDoctrine()->getManager($name);
    }

    /**
     * @param $name
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository($name)
    {
        return $this->getDoctrine()->getRepository('MainBundle:' . $name);
    }


    /**
     * @return UserRepository
     */
    public function getUserRepository()
    {
        return $this->getRepository('User');
    }

    /**
     * @return EnterpriseRepository
     */
    public function getEnterpriseRepository()
    {
        return $this->getRepository('Enterprise');
    }

    /**
     * @return SubdivisionRepository
     */
    public function getSubdivisionRepository()
    {
        return $this->getRepository('Subdivision');
    }

    /**
     * @return ProfessionRepository
     */
    public function getProfessionRepository()
    {
        return $this->getRepository('Profession');
    }

    /**
     * @return ProfessionkindRepository
     */
    public function getProfessionkindRepository()
    {
        return $this->getRepository('Professionkind');
    }

    /**
     * @return MedicalkindRepository
     */
    public function getMedicalkindRepository()
    {
        return $this->getRepository('Medicalkind');
    }
}