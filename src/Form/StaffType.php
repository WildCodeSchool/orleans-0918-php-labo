<?php

namespace App\Form;

use App\Entity\Staff;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, array('label' => 'Nom:', 'error_bubbling' => false))
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom:', 'required' => false, 'error_bubbling' => false))
            ->add('isActive', TextType::class, array('label' => 'active', 'attr' =>['class' => 'btn-group-toggle']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Staff::class,
        ]);
    }
}
