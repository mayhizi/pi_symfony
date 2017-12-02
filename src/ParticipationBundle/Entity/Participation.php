<?php
namespace ParticipationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="participation")
 */
class Participation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getRandonnee()
    {
        return $this->randonnee;
    }

    /**
     * @param mixed $randonnee
     */
    public function setRandonnee($randonnee)
    {
        $this->randonnee = $randonnee;
    }
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="participation")
     * @ORM\JoinColumn
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="RandonneeBundle\Entity\Randonnee", inversedBy="participation")
     * @ORM\JoinColumn
     */
    private $randonnee;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


}