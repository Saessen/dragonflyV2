<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Messagerie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('categorie', ChoiceType::class, ['choices'=> ['Festif'=>1, 'Entraide'=>2, 'Familial'=>3, 'Loisirs/Détente'=>4, 'Sportif'=>5, 'Entreprise'=>6]])
            ->add('nom',TextType::class, ['label'=>'Nom', 'attr'=>['placeholder'=>'Entrez le nom de votre évènement']])
            ->add('date_debut', DateType::class, ['widget'=> 'single_text'], ['label'=>'Début de l\'évènement'])
            ->add('heure_debut', TimeType::class, ['widget'=>'single_text', 'label'=>'Heure du début'])
            ->add('date_fin', DateType::class, ['widget'=> 'single_text'], ['label'=>'Fin de l\'évènement', 'required'=>false])
            ->add('heure_fin', TimeType::class, ['widget'=>'single_text', 'label'=>'Heure de fin', 'required'=>false])
            ->add('pers_min',TextType::class, ['label'=>'Participants', 'attr'=>['placeholder'=>'Combien de participants minimum pour votre évènement?']])
            ->add('pers_max',TextType::class, ['label'=>'Participants', 'attr'=>['placeholder'=>'Combien de participants maximum pour votre évènement?', 'required'=>false]])
            ->add('numero_rue', HiddenType::class, ['data'=>'essai'])
            ->add('rue', HiddenType::class, ['data'=>'essai'])
            ->add('code_postal', HiddenType::class, ['data'=>'essai'])
            ->add('ville', HiddenType::class, ['data'=>'essai'])
            ->add('pays', HiddenType::class, ['data'=>'essai'])
            ->add('latitude', HiddenType::class, ['data'=>'essai'])
            ->add('longitude', HiddenType::class, ['data'=>'essai'])
            ->add('access', ChoiceType::class, ['placeholder'=>'Accessible facilement aux personnes à mobilité réduite?', 'choices'=>['Oui'=>0, 'Non'=>1]])
            ->add('message', TextareaType::class, ['label'=>'message', 'attr'=>['placeholder'=>'Informations complémentaires, conseils,... ', 'required'=>false]])
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
