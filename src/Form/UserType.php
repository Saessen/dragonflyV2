<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label'=>'Username', 'attr'=>['placeholder'=>'Entrez le username de l\'utilisateur']])
            ->remove('roles')
            ->add('password', PasswordType::class)
            ->add('nom', TextType::class, ['label'=>'Nom', 'attr'=>['placeholder'=>'Entrez le nom de l\'utilisateur']])
            ->add('prenom', TextType::class, ['label'=>'Prénom', 'attr'=>['placeholder'=>'Entrez le prénom de l\'utilisateur']])
            ->add('sexe', ChoiceType::class, ['placeholder'=>'L\'utilisateur est de sexe : ', 'choices'=>['Féminin'=>1, 'Masculin'=>2]])
            ->add('email', EmailType::class)
            ->add('poste', TextType::class, ['label'=>'Poste', 'attr'=>['placeholder'=>'Entrez le poste occupé par l\'utilisateur']])
            ->add('numero_rue', TextType::class, ['label'=>'N° de rue', 'attr'=>["required"=>false]] )
            ->add('rue', TextType::class, ['label'=>'Rue', 'attr'=>["required"=>false]] )
            ->add('code_postal', TextType::class, ['label'=>'Code postal', 'attr'=>["required"=>false]] )
            ->add('ville', TextType::class, ['label'=>'Ville', 'attr'=>["required"=>false]] )
            ->add('pays', TextType::class, ['label'=>'Pays', 'attr'=>["required"=>false]])
            
            ->remove('entreprise')
            ->remove('events')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
