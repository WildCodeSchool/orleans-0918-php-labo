<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CustomerType
 * @package App\Form
 */
class CustomerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, array(
                'label' => 'Nom de Famille : ' , 'error_bubbling' => false))
            ->add('firstName', TextType::class, array (
                'label' => 'Prénom : ', 'required' => false, 'error_bubbling' => false,))
            ->add('phoneNumber', TelType::class, array (
                'label' => 'N° de Téléphone : ', 'required' => false, 'error_bubbling' => false,))
            ->add('mailAddress', EmailType::class, array (
                'label' =>'Adresse Mail : ', 'required' => false , 'error_bubbling' => false))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class
        ]);
    }
}
