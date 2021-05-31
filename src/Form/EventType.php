<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Messagerie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('categorie', TextType::class, ['attr'=>['autofocus'=>true]])
            ->add('nom',TextType::class, array('label'=>'Nom', 'attr'=>array('placeholder'=>'Entrez le nom de votre évènement')))
            ->add('date_debut')
            ->add('date_fin')
            ->add('heure_debut')
            ->add('heure_fin')
            ->add('pers_min',TextType::class, array('label'=>'participants', 'attr'=>array('placeholder'=>'Combien de participants minimum pour votre évènement?')))
            ->add('pers_max',TextType::class, array('label'=>'participants', 'attr'=>array('placeholder'=>'Combien de participants maximum pour votre évènement?')))
            ->add('numero_rue', HiddenType::class, ['data'=>'essai'])
            ->add('rue', HiddenType::class, ['data'=>'essai'])
            ->add('code_postal', HiddenType::class, ['data'=>'essai'])
            ->add('ville', HiddenType::class, ['data'=>'essai'])
            ->add('pays', HiddenType::class, ['data'=>'essai'])
            ->add('latitude', HiddenType::class, ['data'=>'essai'])
            ->add('longitude', HiddenType::class, ['data'=>'essai'])
            ->add('access',TextType::class, array('label'=>'Accessibilité', 'attr'=>array('placeholder'=>'Votre évènement est-il facilement accessible pour les personnes à mobilité réduite?')))
            ->add('message', TextareaType::class, array('label'=>'message', 'attr'=>array('placeholder'=>'Décrivez brievement l\'évènement')))
            ->remove('user')
            ->remove('entreprise')
            ;
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
