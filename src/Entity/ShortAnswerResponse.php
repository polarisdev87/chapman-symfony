<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Quiz.
 *
 * @ORM\Entity()
 * @ORM\Table(name="short_answer_response")
 * @ORM\HasLifecycleCallbacks
 * @ApiResource(
 *   collectionOperations={"get"},
 *   itemOperations={"get"}
 * )
 */
class ShortAnswerResponse extends QuizResponse
{
    /**
     * @var string
     * @ORM\Column(name="content", type="text",nullable=true)
     * @Groups({"quiz_response:get"})
     */
    protected $content;

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): ShortAnswerResponse
    {
        $this->content = $content;

        return $this;
    }

    public function isCorrectResponse()
    {
       return false;
    }
}
