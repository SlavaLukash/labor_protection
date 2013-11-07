<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Professionkind
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Professionkind
{

	/**
	 * @ORM\OneToMany(targetEntity="Profession", mappedBy="professionkind")
	 */
	protected $profession;

	public function __construct()
	{
		$this->profession = new ArrayCollection();
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
     * @return Professionkind
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

	public function __toString()
	{
		return $this->name;
	}

    /**
     * Add profession
     *
     * @param \Sir\OtBundle\Entity\Profession $profession
     * @return Professionkind
     */
    public function addProfession(\Sir\OtBundle\Entity\Profession $profession)
    {
        $this->profession[] = $profession;
    
        return $this;
    }

    /**
     * Remove profession
     *
     * @param \Sir\OtBundle\Entity\Profession $profession
     */
    public function removeProfession(\Sir\OtBundle\Entity\Profession $profession)
    {
        $this->profession->removeElement($profession);
    }

    /**
     * Get profession
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProfession()
    {
        return $this->profession;
    }
}