<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use Doctrine\DBAL\Query\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;


class AlbumCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Album::class;
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ;
    }


    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('Nom'),
            AssociationField::new('Auteur'),
            BooleanField::new('Publie')
                ->onlyOnForms()
                ->hideWhenCreating(),
            TextField::new('Description'),

            AssociationField::new('Objets')
                ->onlyOnForms()
                ->hideWhenCreating()
                ->setTemplatePath('admin/fields/Gallerie_Photo.html.twig')
                ->setQueryBuilder(
                    function (QueryBuilder $queryBuilder) {
                        $currentAlbum = $this->getContext()->getEntity()->getInstance();
                        $Membre = $currentAlbum->getMembre();
                        $memberId = $Membre->getId();
                        $queryBuilder->leftJoin('entity.Gallerie', 'i')
                            ->leftJoin('i.owner', 'm')
                            ->andWhere('m.id = :member_id')
                            ->setParameter('member_id', $memberId);
                        return $queryBuilder;
                    }
                ),
        ];
    }
}