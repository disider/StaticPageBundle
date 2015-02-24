<?php


namespace Diside\StaticPageBundle\Form\Processor;

use Diside\StaticPageBundle\Entity\StaticPage;
use Diside\StaticPageBundle\Form\EditStaticPageForm;
use Diside\StaticPageBundle\Helper\SlugGenerator;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class EditStaticPageFormProcessor
{
    /** @var array */
    protected $errors;

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var FormInterface */
    protected $form;

    /** @var EntityManager */
    private $entityManager;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $entityManager)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
    }

    public function process(Request $request, $staticPage = null)
    {
        $this->form = $this->formFactory->create(new EditStaticPageForm());
        if ($staticPage){
            $this->form->setData($staticPage);
        }

        if ($request->getMethod() == 'POST'){
            $this->form->handleRequest($request);
            if ($this->form->isValid()){
                /** @var StaticPage $staticPage */
                $staticPage = $this->form->getData();
                $this->setPageSlug($staticPage);

                $this->entityManager->persist($staticPage);
                $this->entityManager->flush();
            }
        }
    }

    public function isValid()
    {
        return empty($this->errors);
    }

    public function getForm()
    {
        return $this->form;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setPageSlug($staticPage)
    {
        $slug = $staticPage->getSlug();
        if (empty($slug)){
            $title = $staticPage->translate('en')->getTitle();
            $slug = SlugGenerator::slugify($title);
            $staticPage->setSlug($slug);
        }
    }
}