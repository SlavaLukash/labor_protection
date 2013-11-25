<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Medicaltype
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Medicaltype
{


	/**
	 * @ORM\OneToMany(targetEntity="Medical", mappedBy="medicaltype")
	 */
	protected $medical;

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
     * Constructor
     */
    public function __construct()
    {
        $this->medical = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * @return Medicaltype
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
     * Add medical
     *
     * @param \Sir\OtBundle\Entity\Medical $medical
     * @return Medicaltype
     */
    public function addMedical(\Sir\OtBundle\Entity\Medical $medical)
    {
        $this->medical[] = $medical;
    
        return $this;
    }

    /**
     * Remove medical
     *
     * @param \Sir\OtBundle\Entity\Medical $medical
     */
    public function removeMedical(\Sir\OtBundle\Entity\Medical $medical)
    {
        $this->medical->removeElement($medical);
    }

    /**
     * Get medical
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedical()
    {
        return $this->medical;
    }

	public function __toString()
	{
		return $this->name;
	}
}