<?php


namespace Diside\StaticPageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

class StaticPage
{
    use ORMBehaviors\Translatable\Translatable;

    /** @var int */
    private $id;

    /** @var string */
    private $slug;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getTitle()
    {
        return $this->proxyCurrentLocaleTranslation("getTitle");
    }

    public function getContent()
    {
        return $this->proxyCurrentLocaleTranslation("getContent");
    }
}