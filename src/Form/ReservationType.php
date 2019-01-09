<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\ReservationEquipement;
use App\Entity\Room;
use App\Entity\Staff;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

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
            ->add('staff', EntityType::class, array(
                'class' => Staff::class,
                'choice_label' => 'firstname',
                'query_builder' => function (EntityRepository $er){
                    return $er -> createQueryBuilder('s')
                        ->where('s.isActive = true');
                }
            ))
            ->add('reservationEquipements', CollectionType::class, array(
                'entry_type'=> ReservationEquipementType::class,
            ))
            ->add(
                'signature',
                HiddenType::class,
                [
                    'constraints' => [new NotBlank()],
                    'attr' => [
                        'class' => 'signature'
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
