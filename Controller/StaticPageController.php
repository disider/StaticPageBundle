<?php


namespace Diside\StaticPageBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/page")
 */
class StaticPageController extends Controller
{
    /**
     * @Route("/view/{slug}", name="static_page_view")
     * @Template
     */
    public function viewAction(Request $request, $slug)
    {
        $repository = $this->get('doctrine.orm.entity_manager')->getRepository('DisideStaticPageBundle:StaticPage');
        $page = $repository->findOneBySlug($slug);

        if ($page == null){
            throw $this->createNotFoundException();
        }

        return array(
            'page' => $page
        );
    }

    /**
     * @Route("/list", name="static_page_list")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template
     */
    public function listAction(Request $request)
    {
        $pageRepository = $this->get('doctrine.orm.entity_manager')->getRepository('DisideStaticPageBundle:StaticPage');
        $staticPages = $pageRepository->findAll();

        $page = $request->get('page', 1);
        $pageSize = $this->container->getParameter('static_pages_page_size');


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $staticPages,
            $page,
            $pageSize
        );

        return array(
            'pagination' => $pagination
        );
    }

    /**
     * @Route("/create", name="static_page_create")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template
     */
    public function createAction(Request $request)
    {
        $formProcessor = $this->get('edit_static_page_form_processor');
        $formProcessor->process($request);

        $form = $formProcessor->getForm();

        if ($form->isValid() && $request->getMethod() == 'POST') {
            $translator = $this->get('translator');
            $this->addFlash('success', $translator->trans('static_pages.create.success'));
            return $this->redirect($this->generateUrl('static_page_list'));
        }

        return array(
            'errors' => $formProcessor->getErrors(),
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/edit/{slug}", name="static_page_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template
     */
    public function editAction(Request $request, $slug)
    {
        $repository = $this->get('doctrine.orm.entity_manager')->getRepository('DisideStaticPageBundle:StaticPage');
        $page = $repository->findOneBySlug($slug);

        if ($page == null){
            throw $this->createNotFoundException();
        }

        $formProcessor = $this->get('edit_static_page_form_processor');
        $formProcessor->process($request, $page);

        $form = $formProcessor->getForm();

        if ($form->isValid() && $request->getMethod() == 'POST') {
            $translator = $this->get('translator');
            $this->addFlash('success', $translator->trans('static_pages.edit.success'));
            return $this->redirect($this->generateUrl('static_page_list'));
        }

        return array(
            'errors' => $formProcessor->getErrors(),
            'form' => $form->createView(),
            'slug' => $page->getSlug()
        );
    }

    /**
     * @Route("/delete/{slug}", name="static_page_delete")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $slug)
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $pageRepository = $entityManager->getRepository('DisideStaticPageBundle:StaticPage');
        $page = $pageRepository->findOneBySlug($slug);

        if ($page == null){
            throw $this->createNotFoundException();
        }

        $entityManager->remove($page);
        $entityManager->flush();

        $translator = $this->get('translator');
        $this->addFlash('success', $translator->trans('static_pages.delete_success'));
        return $this->redirect($this->generateUrl('static_page_list'));
    }
}