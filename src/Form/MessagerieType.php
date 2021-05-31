<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Messagerie;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MessagerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message',CKEditorType::class, ['label'=>'Message', 'attr'=>['placeholder'=>'Vous pouvez écrire votre message ICI! Celui-ci sera vu par l\'ensemble des participants à l\'évènement']])
            ->remove('createdAt')
            ->remove('isRead')
            ->remove('event')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Messagerie::class,
        ]);
    }
}
