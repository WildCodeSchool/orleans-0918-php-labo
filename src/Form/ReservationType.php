<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Entity\Staff;
use Doctrine\ORM\EntityRepository;
use App\Service\SignatureService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class ReservationType
 * @package App\Form
 */
class ReservationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
                'query_builder' => function (EntityRepository $er) {
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
                    'constraints' => [
                        new Callback([
                            'callback' => [$this, 'validate'],
                            'payload' => $options['base64_noimage']
                        ])
                    ],
                    'attr' => [
                        'class' => 'signature'
                    ]
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('base64_noimage');

        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }

    /**
     * @param $object
     * @param ExecutionContextInterface $context
     * @param $payload
     */
    public function validate($object, ExecutionContextInterface $context, $payload)
    {
        if (empty($object)) {
            $context->buildViolation("Vous n'avez pas signé.")
                ->atPath('signature')
                ->addViolation();
        }

        if ($payload === $object) {
            $context->buildViolation("Vous n'avez pas signé.")
                ->atPath('signature')
                ->addViolation();
        }
    }
}
