<?php


namespace Diside\StaticPageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

class StaticPageTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @Assert\NotBlank(message="static_pages.error.empty_title")
     * @var string
     */
    private $title;

    /** @var string */
    private $content;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}