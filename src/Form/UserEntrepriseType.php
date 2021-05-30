<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserEntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class, array('label'=>'Username', 'attr'=>array('placeholder'=>'Entrez votre username')))
            ->remove('roles', ['attr'=>["class"=>"d-none"]])
            ->add('password', PasswordType::class)
            ->add('nom',TextType::class, array('label'=>'Nom', 'attr'=>array('placeholder'=>'Entrez votre nom')))
            ->add('prenom',TextType::class, array('label'=>'Prénom', 'attr'=>array('placeholder'=>'Entrez votre prénom')))
            ->add('sexe')
            ->add('email', EmailType::class)
            ->add('poste',TextType::class, array('label'=>'Poste', 'attr'=>array('placeholder'=>'Quel poste occupez-vous?')))
            ->add('numero_rue',TextType::class, array('label'=>'Numéro de rue ', 'attr'=>array('placeholder'=>'Entrez votre numéro de rue')))
            ->add('rue',TextType::class, array('label'=>'Rue', 'attr'=>array('placeholder'=>'Entrez votre rue')))
            ->add('code_postal',TextType::class, array('label'=>'Code postal', 'attr'=>array('placeholder'=>'Entrez votre code postal')))
            ->add('ville',TextType::class, array('label'=>'Ville', 'attr'=>array('placeholder'=>'Entrez votre ville')))
            ->add('pays',TextType::class, array('label'=>'Pays', 'attr'=>array('placeholder'=>'France')))
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
