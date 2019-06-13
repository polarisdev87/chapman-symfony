<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\SoftDeleteTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Quiz.
 *
 * @ORM\Entity(repositoryClass="App\Repository\QuizRepository")
 * @ORM\Table(name="quiz")
 * @ORM\HasLifecycleCallbacks
 * @ApiResource()
 */
class Quiz
{
    use TimestampTrait;
    use SoftDeleteTrait;

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @Groups({"list","detail"})
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name",type="string",length=50,nullable=false)
     * @Groups({"list","detail"})
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="description",type="text",nullable=false)
     * @Groups({"list","detail"})
     */
    protected $description;

    /**
     * @var PersistentCollection
     * @ORM\OneToMany(targetEntity="QuizSession",mappedBy="quiz")
     * @Groups({"quiz_sessions"})
     */
    protected $quizSessions;

    /**
     * @var PersistentCollection
     * @ORM\OneToMany(targetEntity="QuizQuestion",mappedBy="quiz")
     * @Groups({"detail"})
     * @Groups({"quiz_questions"})
     */
    protected $questions;

    /**
     * One product has many features. This is the inverse side.
     *
     * @ORM\OneToMany(targetEntity="QuizAccess", mappedBy="quiz")
     */
    protected $access;

    /**
     * @Groups({"list","detail"})
     **/
    public function getNumQuestions()
    {
        return $this->getQuestions()->count();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): Quiz
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): Quiz
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getQuestions(): PersistentCollection
    {
        return $this->questions;
    }

    /**
     * @return PersistentCollection
     */
    public function getQuizSessions(): PersistentCollection
    {
        return $this->quizSessions;
    }

    /**
     * @param $user
     *
     * @return ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getQuizSessionsByUser($user)
    {
        return $this->quizSessions->matching(Criteria::create()->where(Criteria::expr()->eq('owner', $user)));
    }
}
