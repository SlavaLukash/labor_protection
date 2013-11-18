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
	 * @ORM\ManyToOne(targetEntity="Medical", inversedBy="medicaltype")
	 * @ORM\JoinColumn(name="medical", referencedColumnName="id")
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
     * Set medical
     *
     * @param \Sir\OtBundle\Entity\Medical $medical
     * @return Medicaltype
     */
    public function setMedical(\Sir\OtBundle\Entity\Medical $medical = null)
    {
        $this->medical = $medical;
    
        return $this;
    }

    /**
     * Get medical
     *
     * @return \Sir\OtBundle\Entity\Medical 
     */
    public function getMedical()
    {
        return $this->medical;
    }
}