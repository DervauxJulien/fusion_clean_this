<?php

 namespace App\Form;
 
 use Symfony\Component\Form\AbstractType;
 use App\Form\ClientType;
 use App\Form\AdresseType;
 use App\Form\OperationType;
 use Symfony\Component\Form\FormBuilderInterface;
 use Symfony\Component\OptionsResolver\OptionsResolver;

 class DemandeOperationFormType extends AbstractType{
public function buildForm(FormBuilderInterface $builderClient, array $option){
        $builder 
        ->add('nom', Client::class)
        ->add('prenom', Client::class)
        ->add('email', Client::class)
        ->add('N_rue', Adresse::class)
        ->add('Nom_Rue', Adresse::class)
        ->add('Nom_Ville', Adresse::class)
        ->add('CP', Adresse::class)
        ->add('description_Op', Operation::class)
        ->add('img', Operation::class);
        
    }}