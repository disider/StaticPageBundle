<?php


namespace Diside\StaticPageBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditStaticPageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('slug', 'text', array('label' => 'static_pages.form.slug', 'required' => false));
        $builder->add('translations', 'a2lix_translations', array(
            'locales' => array('en', 'it', 'fr'),
            'required_locales' => array('en'),
            'fields' => array(
                'title' => array(
                    'field_type' => 'text',
                    'label' => 'static_pages.form.title',
                    'required' => true,
                ),
                'content' => array(
                    'field_type' => 'textarea',
                    'label' => 'static_pages.form.content',
                    'required' => true,
                    'attr' => array(
                        'class' => 'tinymce',
                        'data-theme' => 'advanced'
                    )
                )
            )
        ));

        $builder->add('save', 'submit', array('label' => 'static_pages.form.save'));
    }

    public function getName()
    {
        return 'edit_static_page';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Diside\StaticPageBundle\Entity\StaticPage',
            'cascade_validation'=>true,
        ));
    }
}