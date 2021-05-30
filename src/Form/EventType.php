<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Messagerie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie')
            ->add('nom')
            ->add('date_debut')
            ->add('date_fin')
            ->add('heure_debut')
            ->add('heure_fin')
            ->add('pers_min')
            ->add('pers_max')
            ->add('numero_rue')
            ->add('rue')
            ->add('code_postal')
            ->add('ville')
            ->add('pays')
            ->add('latitude')
            ->add('longitude')
            ->add('access')
            ->add('message')
            ->remove('user');
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
