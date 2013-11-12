<?php
/**
 * @author Rustam Ibragimov
 * @mail Rustam.Ibragimov@softline.ru
 * @date 07.11.13
 */

namespace Sir\OtBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

	/**
	 * @ORM\ManyToMany(targetEntity="Subdivision", inversedBy="users")
	 * @ORM\JoinTable(name="usersubdivision")
	 **/
	private $usersubdivisions;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	public function __construct()
	{
		parent::__construct();
		$this->usersubdivisions = new ArrayCollection();
		// your own logic
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

	public function __toString()
	{
		return $this->username;
	}

    /**
     * Get usersubdivisions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsersubdivisions()
    {
        return $this->usersubdivisions;
    }

    /**
     * Add usersubdivisions
     *
     * @param \Sir\OtBundle\Entity\Subdivision $usersubdivisions
     * @return User
     */
    public function addUsersubdivision(\Sir\OtBundle\Entity\Subdivision $usersubdivisions)
    {
        $this->usersubdivisions[] = $usersubdivisions;
    
        return $this;
    }

    /**
     * Remove usersubdivisions
     *
     * @param \Sir\OtBundle\Entity\Subdivision $usersubdivisions
     */
    public function removeUsersubdivision(\Sir\OtBundle\Entity\Subdivision $usersubdivisions)
    {
        $this->usersubdivisions->removeElement($usersubdivisions);
    }
}