<?php

namespace App\Form;

use App\Entity\Operations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// Garder pour la page prendre opération.

// Création de la class opération via les commandes du terminal symfony console make:form après création de l'entité.


class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Description')
            ->add('Statut')
            ->add('Date_Creation', null, [
                'widget' => 'single_text',
            ])
            ->add('Date_Debut', null, [
                'widget' => 'single_text',
            ])
            ->add('Date_Fin', null, [
                'widget' => 'single_text',
            ])
            ->add('Photo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Operations::class,
        ]);
    }
}
