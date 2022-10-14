<?php 
namespace Webkul\UVDesk\AutomationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Webkul\CoreFrameworkBundle\Entity\Workflow;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;



class DefaultForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('submit', ButtonType::class, array(
                        'label' => 'Add Workflow',
                        'attr' => array('class' => 'btn btn-md btn-info'),
                        )
                    );
    }

    public function configureOptions(OptionsResolver $resolver)
    {   
        $resolver->setDefaults(array(
            'data_class' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}