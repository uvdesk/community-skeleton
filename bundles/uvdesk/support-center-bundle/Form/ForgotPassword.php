<?php
namespace Webkul\UVDesk\SupportCenterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ForgotPassword extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {     
        $builder->add('email', 'email', array('label' => 'Email Address'));
        $builder->add('save', 'submit',array(
                                            'label'=>'Send Mail',
                                            'attr'=> array(
                                                        'class' => 'btn btn-info btn-md'
                                                        )
                                            )
                );   
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'forgot_password_form';
    }
}