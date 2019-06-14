<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionTagRepository")
 * @ORM\Table(name="question_tag")
 * @ApiResource()
 */
class QuestionTag
{
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
     * Many Users have Many Groups.
     *
     * @ORM\ManyToMany(targetEntity="QuizQuestion", mappedBy="tags" )
     * @ORM\JoinTable(name="quiz_question_question_tag")
     * @Groups({"questions"})
     */
    protected $questions;

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
    public function setName(string $name): QuestionTag
    {
        $this->name = $name;

        return $this;
    }
}
