<?php

namespace App\Controller\Admin;

use App\Controller\AlbumController;
use App\Entity\Photo;
use App\Entity\Gallerie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
class PhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photo::class;
    }



    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('Titre'),
            //DateField::new('')
            AssociationField::new('Auteur'),
            TextEditorField::new('description'),
            IntegerField::new('ISO'),
            TextField::new("Ouverture"),
            TextField::new("ShutterSpeed"),
            AssociationField::new("Albums"),
            AssociationField::new('gallerie')
        ];
    }
}
