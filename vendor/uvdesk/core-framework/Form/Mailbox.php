<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class Mailbox extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array(
            'label' => 'Mailbox Name',
            'attr' => array(
                    'placeholder' => 'Enter mailbox name'
                )
            )
        );

        $builder->add('email', TextType::class, array(
            'label' => 'Mailbox Address',
            'attr' => array(
                    'placeholder' => 'Enter mailbox address'
                )
            )
        );

        $builder->add('save', SubmitType::class, array(
            'label' => 'Next',
            'attr' => array(
                    'class'=>'btn btn-info btn-md pull-left'
                )
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {   
        $resolver->setDefaults([
            'data_class' => 'Webkul\UVDesk\CoreFrameworkBundle\Entity\Mailbox',
            'cascade_validation' => true,
            'csrf_protection' => false,
            'validation_groups' => ['Mailbox'],
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    public function getName()
    {
        return '';
    }
}