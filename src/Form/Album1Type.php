<?php

namespace App\Form;

use App\Entity\Album;
use App\Repository\PhotoRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Album1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $Album = $options['data'] ?? null;
        $membre = $Album->getAuteur();

        $builder
            ->add('Description')
            ->add('Publie')
            ->add('Nom')
            ->add('Auteur', null, [
            'disabled'   => true,])
            ->add('Objets',
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

                'query_builder' => function (PhotoRepository $er) use ($membre) {
                                                return $er->createQueryBuilder('o')
                                                    ->leftJoin('o.gallerie', 'i')
                                                    ->andWhere('i.Auteur = :membre')
                                                    ->setParameter('membre', $membre)
                                                    ;
                                        }
                                ])
                ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
