<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->remove('roles', ['attr'=>["class"=>"d-none"]])
            ->add('password', PasswordType::class)
            ->add('nom')
            ->add('prenom')
            ->add('sexe')
            ->add('email', EmailType::class)
            ->add('poste')
            ->add('numero_rue')
            ->add('rue')
            ->add('code_postal')
            ->add('ville')
            ->add('pays')
            ->remove('latitude')
            ->remove('longitude')
            ->add('entreprise')
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
