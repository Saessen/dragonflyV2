<?php

namespace App\Form;

use App\Entity\Entreprise;
use App\Form\UserEntrepriseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('siren')
            ->add('denomination')
            ->add('admin', UserEntrepriseType::class)
            ->add('Inscription', SubmitType::class, ['attr'=>["class"=>"mt-3 btn-dark btn_list"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
