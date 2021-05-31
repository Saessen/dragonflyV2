<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserEntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class, ['label'=>'Username', 'attr'=>['placeholder'=>'Entrez votre username']])
            ->remove('roles')
            ->add('password', PasswordType::class)
            ->add('nom',TextType::class, ['label'=>'Nom', 'attr'=>['placeholder'=>'Entrez votre nom']])
            ->add('prenom',TextType::class, ['label'=>'Prénom', 'attr'=>['placeholder'=>'Entrez votre prénom']])
            ->add('sexe', ChoiceType::class, ['placeholder'=>'Vous êtes de sexe : ', 'choices'=>['Féminin'=>1, 'Masculin'=>2]])
            ->add('email', EmailType::class)
            ->add('poste',TextType::class, ['label'=>'Poste', 'attr'=>['placeholder'=>'Quel poste occupez-vous?']])
            ->add('numero_rue',TextType::class, ['label'=>'Numéro de rue ', 'attr'=>['placeholder'=>'Entrez votre numéro de rue']])
            ->add('rue',TextType::class, ['label'=>'Rue', 'attr'=>['placeholder'=>'Entrez votre rue']])
            ->add('code_postal',TextType::class, ['label'=>'Code postal', 'attr'=>['placeholder'=>'Entrez votre code postal']])
            ->add('ville',TextType::class, ['label'=>'Ville', 'attr'=>['placeholder'=>'Entrez votre ville']])
            ->add('pays',TextType::class, ['label'=>'Pays', 'attr'=>['placeholder'=>'France']])
            ->remove('latitude')
            ->remove('longitude')
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
