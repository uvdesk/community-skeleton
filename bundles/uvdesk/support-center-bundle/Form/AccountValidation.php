<?php 

namespace Webkul\UVDesk\SupportCenterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountValidation extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('password', 'repeated', array(
                            'type' => 'password',
                            'invalid_message' => 'The password fields must match.',
                            'required' => false,
                            'first_options'  => array(
                                'label' => 'Password',
                            ),
                            'second_options' => array(
                                'label' => 'Confirm Password',
                            )
                        )
                    );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Webkul\UserBundle\Entity\User',
            'csrf_protection' => false, 
            'validation_groups' => 'userValidation',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'userValid';
    }
}