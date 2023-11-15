<?php

namespace App\Form;

use App\Entity\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre')
            ->add('Auteur', null, [
                'disabled'   => true,])
            ->add('Description')
            ->add('ISO')
            ->add('Ouverture')
            ->add('ShutterSpeed')
            ->add('Albums', null, [
            'multiple' => true,
            'expanded' => true
        ])
            ->add('gallerie', null, [
                'disabled'   => true,])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
