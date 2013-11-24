<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Expensekind
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Expensekind
{


	/**
	 * @ORM\OneToMany(targetEntity="Expense", mappedBy="expensekind")
	 */
	protected $expense;

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

	public function __construct()
	{
		$this->expense = new ArrayCollection();
	}

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
     * @return Expensekind
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
     * Add expense
     *
     * @param \Sir\OtBundle\Entity\Expense $expense
     * @return Expensekind
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
}