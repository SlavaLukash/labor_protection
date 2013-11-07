<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Technicalexaminationtype
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Technicalexaminationtype
{
	/**
	 * @ORM\OneToMany(targetEntity="Technicalexamination", mappedBy="technicalexaminationtype")
	 */
	protected $technicalexamination;

	public function __construct()
	{
		$this->technicalexamination = new ArrayCollection();
	}

	public function __toString()
	{
		return $this->name;
	}

	/**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Technicalexaminationtype
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add technicalexamination
     *
     * @param \Sir\OtBundle\Entity\Technicalexamination $technicalexamination
     * @return Technicalexaminationtype
     */
    public function addTechnicalexamination(\Sir\OtBundle\Entity\Technicalexamination $technicalexamination)
    {
        $this->technicalexamination[] = $technicalexamination;
    
        return $this;
    }

    /**
     * Remove technicalexamination
     *
     * @param \Sir\OtBundle\Entity\Technicalexamination $technicalexamination
     */
    public function removeTechnicalexamination(\Sir\OtBundle\Entity\Technicalexamination $technicalexamination)
    {
        $this->technicalexamination->removeElement($technicalexamination);
    }

    /**
     * Get technicalexamination
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTechnicalexamination()
    {
        return $this->technicalexamination;
    }
}