<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Entity\Vote;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class VoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('JouerVote',EntityType::class ,[
                'class'=>'App\Entity\Joueur',
                'choice_label'=>'nom' ,
                'placeholder' => 'Select an Joueur', // Optional, adds an empty option at the top

            ])

            ->add('noteVote',ChoiceType::class, [
                'choices' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4'=> '4',
                    '5'=> '5',
              
                ],
                'expanded'=>true,
                'multiple'=>false
            ])
            ->add('vote',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vote::class,
        ]);
    }
}
