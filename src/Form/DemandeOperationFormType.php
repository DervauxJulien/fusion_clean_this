<?php

 namespace App\Form;
 
 use Symfony\Component\Form\AbstractType;
 use App\Form\ClientType;
 use App\Form\AdresseType;
 use App\Form\OperationType;
 use Symfony\Component\Form\FormBuilderInterface;
 use Symfony\Component\OptionsResolver\OptionsResolver;

 class DemandeOperationFormType extends AbstractType{
    
public function buildForm(FormBuilderInterface $builder, array $option){
        $builder 
        ->add('nom', ClientType::class)
        // ->add('prenom', ClientType::class)
        // ->add('email', ClientType::class)
        ->add('N_rue', AdresseType::class)
        // ->add('Nom_Rue', AdresseType::class)
        // ->add('Nom_Ville', AdresseType::class)
        // ->add('CP', AdresseType::class)
        ->add('description_Op', OperationType::class);
        // ->add('img', OperationType::class);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CLientType::class,
        ]);
    }
    

}

