<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * Class User
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Survey", mappedBy="user")
     */
    private $survey;

    public function __construct()
    {
        parent::__construct();
        $this->survey = new ArrayCollection();
    }

    /**
     * @return Collection|Survey[]
     */
    public function getSurvey(): Collection
    {
        return $this->survey;
    }

    public function addSurvey(Survey $survey): self
    {
        if (!$this->survey->contains($survey)) {
            $this->survey[] = $survey;
            $survey->setUser($this);
        }

        return $this;
    }

    public function removeSurvey(Survey $survey): self
    {
        if ($this->survey->contains($survey)) {
            $this->survey->removeElement($survey);
            // set the owning side to null (unless already changed)
            if ($survey->getUser() === $this) {
                $survey->setUser(null);
            }
        }

        return $this;
    }
    
}
