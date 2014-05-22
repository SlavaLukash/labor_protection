<?php

namespace App\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Technicalexaminationkind
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Technicalexaminationkind
{
	/**
	 * @ORM\OneToMany(targetEntity="Technicalexamination", mappedBy="technicalexaminationkind")
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
     * @return Technicalexaminationkind
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
     * @param \App\MainBundle\Entity\Technicalexamination $technicalexamination
     * @return Technicalexaminationkind
     */
    public function addTechnicalexamination(\App\MainBundle\Entity\Technicalexamination $technicalexamination)
    {
        $this->technicalexamination[] = $technicalexamination;
    
        return $this;
    }

    /**
     * Remove technicalexamination
     *
     * @param \App\MainBundle\Entity\Technicalexamination $technicalexamination
     */
    public function removeTechnicalexamination(\App\MainBundle\Entity\Technicalexamination $technicalexamination)
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