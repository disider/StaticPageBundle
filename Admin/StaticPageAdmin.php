<?php


namespace Diside\StaticPageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class StaticPageAdmin extends Admin
{
    protected $baseRouteName = 'admin_static_page';
    protected $baseRoutePattern = 'static-page';
    protected $classnameLabel = 'static_page';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('slug')
            ->add('title', 'doctrine_orm_callback', array(
                'callback' => array($this, 'handleTitleFilter'),
                'field_type' => 'text'
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('slug')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array('template' => 'DisideStaticPageBundle:StaticPage:list__action_view.html.twig'),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('slug', null, array('required' => true))
            ->add('translations', 'a2lix_translations', array(
                'fields' => array(
                    'title' => array('field_type' => 'text'),
                    'content' => array('field_type' => 'genemu_tinymce')
                )
            ));
        ;
    }

    public function handleTitleFilter($queryBuilder, $alias, $field, $value)
    {
        if (!empty($value['value'])) {
            $queryBuilder
                ->join(sprintf('%s.translations', $alias), 't')
                ->andWhere('t.title LIKE :title')
                ->setParameter('title', $value['value'])
            ;
            return true;
        }
        return false;
    }
}