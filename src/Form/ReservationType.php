<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Entity\Staff;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('customer', CustomerType::class)
            ->add('company', CompanyType::class)
            ->add('comment', TextareaType::class, array('label'=> 'Commentaires : ', 'required' => false))
            ->add('rooms', EntityType::class, array(
                'class' => Room::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
