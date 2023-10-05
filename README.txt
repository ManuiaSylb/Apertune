#Apertune By Manuia Sylvestre-Baron


Apertune est une application web destinée à partager des photographies entre amateurs et professionels.
Les galleries sont propre à un membre et contient plusieurs photos uniques à gallerie.

Ainsi, un membre a une gallerie de photo (non obligatoire). Cette galerie contient plusieurs photos propres à elle et son propriétaire



Voici les différentes entités du projet :



*Gallerie
     * Nom propriété : Auteur | Type : String | notnull

     * Nom propriété : Nom | Type : String | notnull


*Photo
     * Nom propriété : Titre | Type : String | notnull

     * Nom propriété : Auteur | Type : String | notnull

     * Nom propriété : ShutterSpeed | Type : String | nullable

     * Nom propriété : Ouverture | Type : String | nullable

     * Nom propriété : ISO | Type : String | nullable

     * Nom propriété : Description | Type : String | nullable

     * Nom propriété : gallerie | Type : ManyToOne

*Membre
     * Nom propriété : Pseudo | Type : String | notnull

     * Nom propriété : Gallerie | Type : OneToOne

     * Nom propriété : Annee | Type : String | notnull

     * Nom propriété : Pays | Type : String | nullable
