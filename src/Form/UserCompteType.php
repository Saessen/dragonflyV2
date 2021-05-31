<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class, ['label'=>'Username', 'attr'=>['placeholder'=>'Entrer un username']])
            ->add('roles', ChoiceType::class, ['choices'=>['Admin'=>"ROLE_ADMIN", 'User'=>"ROLE_USER"]])
            ->add('password', PasswordType::class)
            ->add('nom', TextType::class, ['label'=>'Nom', 'attr'=>['placeholder'=>'Entrer un nom']])
            ->add('prenom', TextType::class, ['label'=>'Prénom', 'attr'=>['placeholder'=>'Entrer un prénom']])
            ->add('sexe', ChoiceType::class, ['placeholder'=>'L\'utilisateur est de sexe : ', 'choices'=>['Féminin'=>1, 'Masculin'=>2]])
            ->add('email', EmailType::class)
            ->add('poste', TextType::class, ['label'=>'Poste', 'attr'=>['placeholder'=>'Entrer un poste']])
            ->remove('numero_rue')
            ->remove('rue')
            ->remove('code_postal')
            ->remove('ville')
            ->remove('pays')
            ->remove('latitude')
            ->remove('longitude')
            ->remove('entreprise')
            ->remove('events')
        ;

        //Les roles utilisateurs sont sous forme d'array. Il doit etre transformé en chaines de caractères pour être lu dans le ChoiceType.
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(function ($rolesArray)
            {
                 // transforme l'array en string
                return count($rolesArray)? $rolesArray[0]: null;
            },
            function ($rolesString) 
            {
                 // retransforme le string en array
                return [$rolesString];
            }
    ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
