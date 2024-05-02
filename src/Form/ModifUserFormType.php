<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('username')
        ->add('roles', ChoiceType::class ,[
            'choices' =>[
                "Expert" => "ROLE_EXPERT",
                "Senior" => "ROLE_SENIOR",
                "Apprenti" => "ROLE_APPRENTI"
            ]
        ])
        
        ->add('nom')
        ->add('prenom')
    ;

    $builder->get('roles')
        ->addModelTransformer(new CallbackTransformer(
            function ($roleAsArray): string {
                return implode(', ' , $roleAsArray);
            },
            function($roleAsArray): array {
                return explode(', ', $roleAsArray);
            }
        ))
    ;
}

public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        'data_class' => User::class,
    ]);
}
}
