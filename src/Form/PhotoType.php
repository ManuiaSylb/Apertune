<?php

namespace App\Form;

use App\Entity\Photo;
use App\Repository\AlbumRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $photo = $options['data'] ?? null;
        $membre = $photo->getAuteur();

        $builder
            ->add('Titre')
            ->add('Auteur', null, [
                'disabled'   => true,])
            ->add('Description')
            ->add('ISO')
            ->add('Ouverture')
            ->add('ShutterSpeed')
            ->add('Albums',
                //EntityType::class,
                null,
                // options :
                [
                    // avec 'by_reference' => false, sauvegarde les modifications
                    'by_reference' => false,
                    // classe pas obligatoire
                    //'class' => [Object]::class,
                    // permet sélection multiple
                    'multiple' => true,
                    // affiche sous forme de checkboxes
                    'expanded' => true,

                    'query_builder' => function (AlbumRepository $er) use ($membre) {
                        return $er->createQueryBuilder('o')
                            ->leftJoin('o.Auteur', 'i')
                            ->andWhere('i = :membre')
                            ->setParameter('membre', $membre)
                            ;
                    }
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
