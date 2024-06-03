<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Operation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description_client')
            ->add('img', FileType::class, [
                'label' => 'Ajoutez vos fichier photos',
                'attr' => [
                    'class' => 'form form-control',
                    'placeholder' => 'Ajoutez vos fichiers photos',
                ],
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
