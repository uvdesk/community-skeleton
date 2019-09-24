<?php 
namespace Webkul\UVDesk\SupportCenterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SolutionModal extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('solutionImage', 'file', array(
            'label' => 'Folder Image',
            'required' => false,
            'data_class' => null, 
            'attr' => array(
                'class' => 'col-sm-3',
                'style' => 'display: none;',
                'isImage' => true,
                'accept' => 'image/*'
            )
        ));

        $builder->add('name', null, array(
                                            'label' => 'solution.name',
                                            'attr' => array(
                                                        'parent-div-class' => 'false',
                                                        )
                                        )
                    )
                ->add('description', 'textarea', array(
                                            'required' => false,
                                            'label' => 'solution.description',
                                            'attr' => array(
                                                        'placeholder' => 'solution.description.placeholder',
                                                        'parent-div-class' => 'false',
                                                        )
                                        )
                    )
                // ->add('visibility', 'choice', array(
                //             'required' => false,
                //             'label' => 'solution.visibility',
                //             'choices'  => array(
                //                             'public' => 'solution.public',
                //                             'private' => 'solution.private'
                //                         ),
                //             'attr' => array(
                //                         'parent-div-class' => 'false',
                //                         'class' => 'selectpicker'
                //                         )
                //         )
                //     )
                ->add('visibility', 'checkbox', array(
                            'required' => false,
                            'label' => 'Status',
                            'attr' => array(
                                    'class' => 'i-check',
                                    'brAfterLabel' => true
                                ),
                        )
                    )
                ->add('id', 'hidden')
                ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Webkul\SupportCenterBundle\Entity\Solutions',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'solution';
    }
}