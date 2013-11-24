<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Enterprise
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Enterprise
{

	/**
	 * @ORM\OneToMany(targetEntity="Expense", mappedBy="enterprise")
	 */
	protected $expense;

	/**
	 * @ORM\OneToMany(targetEntity="Subdivision", mappedBy="enterprise")
	 */
	protected $subdivision;

	public function __construct()
	{
		$this->subdivision = new ArrayCollection();
		$this->expense = new ArrayCollection();
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
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="okved", type="string", length=8)
     */
    private $okved;


	public function __toString()
	{
		return $this->name;
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
     * @return Enterprise
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
     * Set address
     *
     * @param string $address
     * @return Enterprise
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set okved
     *
     * @param string $okved
     * @return Enterprise
     */
    public function setOkved($okved)
    {
        $this->okved = $okved;
    
        return $this;
    }

    /**
     * Get okved
     *
     * @return string 
     */
    public function getOkved()
    {
        return $this->okved;
    }

    /**
     * Add expense
     *
     * @param \Sir\OtBundle\Entity\Expense $expense
     * @return Enterprise
     */
    public function addExpense(\Sir\OtBundle\Entity\Expense $expense)
    {
        $this->expense[] = $expense;
    
        return $this;
    }

    /**
     * Remove expense
     *
     * @param \Sir\OtBundle\Entity\Expense $expense
     */
    public function removeExpense(\Sir\OtBundle\Entity\Expense $expense)
    {
        $this->expense->removeElement($expense);
    }

    /**
     * Get expense
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExpense()
    {
        return $this->expense;
    }

    /**
     * Add subdivision
     *
     * @param \Sir\OtBundle\Entity\Subdivision $subdivision
     * @return Enterprise
     */
    public function addSubdivision(\Sir\OtBundle\Entity\Subdivision $subdivision)
    {
        $this->subdivision[] = $subdivision;
    
        return $this;
    }

    /**
     * Remove subdivision
     *
     * @param \Sir\OtBundle\Entity\Subdivision $subdivision
     */
    public function removeSubdivision(\Sir\OtBundle\Entity\Subdivision $subdivision)
    {
        $this->subdivision->removeElement($subdivision);
    }

    /**
     * Get subdivision
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubdivision()
    {
        return $this->subdivision;
    }
}