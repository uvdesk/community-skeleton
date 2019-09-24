<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Webkul\UVDesk\CoreFrameworkBundle\DataProxies\CreateTicketDataClass;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CreateTicket extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Customer Name
        $builder->add('name', TextType::class, [
            'required' => true,
            'label' => 'Customer Name',
            'attr' => [
                'placeholder' => 'Enter Name'
            ],
        ]);
        
        // Customer Email
        $builder->add('from', EmailType::class, [
            'required' => true,
            'label' => 'Your Email',
            'attr' => [
                'placeholder' => 'Enter Your Email'
            ],
        ]);
        
        // Ticket Type
        $builder->add('type', EntityType::class, [
            'class' => TicketType::class,
            'choice_name' => 'description',
            'multiple' => false,
            'attr' => [
                'data-role' => 'tagsinput',
                'class' => 'selectpicker form-control'
            ],
            'query_builder' => function (EntityRepository $ticketTypeRepository) {
                return $ticketTypeRepository->createQueryBuilder('ticketType')->where('ticketType.isActive = 1');
            },
            'placeholder' => 'Choose query type',
        ]);
        
        // Ticket Subject
        $builder->add('subject', TextType::class, [
            'required' => true,
            'label' => 'Subject',
            'attr' => [
                'placeholder' => 'Enter Subject'
            ],
        ]);

        // Ticket Query Message
        $builder->add('reply', TextareaType::class, [
            'label' => 'Message',
            'attr' => [
                'placeholder' => 'Brief Description about your query',
                'data-iconlibrary' => "fa",
                'data-height' => "250",
            ],
        ]);
        
        // // Ticket Attachments
        // $builder->add('attachments', 'file', [
        //     'label' => '+ Attach File',
        //     'required' => false,
        //     'multiple' => true,
        //     'attr' => [
        //         'mainLabel' => false,
        //         'infoLabel' => 'right',
        //         'infoLabelText' => '+ Attach File',
        //         'decorateFile' => true,
        //         'decorateCss' => 'attach-file',
        //         'enableRemoveOption' => true
        //     ],
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateTicketDataClass::class,
            'cascade_validation' => true,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }

    public function getName()
    {
        return '';
    }
}