<?php

namespace App\Form;

use App\Entity\Airline;
use App\Entity\Vol;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Datedepart')
            ->add('Datearrive')
            ->add('nom')
            ->add('heuredepart')
            ->add('heurearrive')
            ->add('destination')
            ->add('nbrplace')
            ->add('Airline' , EntityType::class,
                [
                    'class'=>Airline::class,
                    'choice_label' => 'nomairline'


                ])
            ->add('Submit',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}
