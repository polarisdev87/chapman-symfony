<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Quiz.
 *
 * @ORM\Entity()
 * @ORM\Table(name="text_block_question")
 * @ORM\HasLifecycleCallbacks
 * @ApiResource()
 */
class TextBlockQuestion extends QuizQuestion
{
    /**
     * @var string
     * @ORM\Column(name="content",type="text",nullable=false)
     * @Groups({"detail","list"})
     */
    protected $content;

    /**
     * @param string $content
     *
     * @return TextBlockQuestion
     */
    public function setContent(string $content): TextBlockQuestion
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
