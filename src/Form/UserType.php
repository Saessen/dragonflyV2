<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->remove('roles', ['attr'=>["class"=>"d-none"]])
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('sexe')
            ->add('email')
            ->add('poste')
            ->add('numero_rue')
            ->add('rue')
            ->add('code_postal')
            ->add('ville')
            ->add('pays')
            ->add('latitude')
            ->add('longitude')
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
