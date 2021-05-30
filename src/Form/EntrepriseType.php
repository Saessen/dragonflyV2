<?php

namespace App\Form;

use App\Entity\Entreprise;
use App\Form\UserEntrepriseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('siren',TextType::class, array('label'=>'Siren', 'attr'=>array('placeholder'=>'Entrez le numéro SIREN')))
            ->add('denomination',TextType::class, array('label'=>'Dénomination sociale', 'attr'=>array('placeholder'=>'Entrez la dénomination sociale')))
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
