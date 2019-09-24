<?php
namespace Webkul\UVDesk\CoreFrameworkBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserProfile extends AbstractType
{

   

    public $userId;

    public $request;

   

    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        //$builder->add('profileImage', 'file', array(
        //         'required' => false, 
        //         'data_class' => null,  
        //         'attr' => array(
        //             'isImage' => true, 
        //             'info' => '(100px x 100px)', 
        //             'accept' => 'image/*', 
        //             'value' => file_exists(__DIR__.$builder->getData()->getProfileImage()) ? $builder->getData()->getProfileImage() : false 
        //         )
        //     )
        // );

        $builder->add('firstName', TextType::class);

        $builder->add('lastName', TextType::class);

        $builder->add('email', EmailType::class);

        // $builder->add('contactNumber', TextType::class);

        // $builder->add('timezone', TimezoneType::class);
        
        // if($this->request->get('_route') != 'webkul_support_center_front_account') {
        //     $builder->add('signature', 'textarea');
        // }

        $builder->add('password', RepeatedType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Webkul\UVDesk\CoreFrameworkBundle\Entity\User',
            'cascade_validation' => true,
            'allow_extra_fields' => true,
            'csrf_protection' => false,
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    public function getName()
    {
        return 'user_form';
    }
}