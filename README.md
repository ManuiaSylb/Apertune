# Apertune By Manuia Sylvestre-Baron


_Apertune est une application web destinée à partager des photographies entre amateurs et professionels._
_Les galleries sont propre à un membre et contient plusieurs photos uniques à gallerie._

_Ainsi, un membre a une unique gallerie de photos. Cette galerie contient toutes les photos propres du propriétaire_
Les albums permettent à l'utilisateur de répartir ses photos en fonction de ses goûts. Une photo peut avoir plusieurs albums.
Les albums peuvent être partagés ou mis en privé.

Un rôle ADMIN ou un rôle USER sont attribués à chaque membre. Une relation en Membre et User permette des partager les infos entre les profils et les informations nécessaire à la création du compte.
Les administrateur peuvent gérer des fonctionnalités réservées au propriétaire de chaque profil.

Pour s'authentifier, voir UserFixtures afin avoir l'accès avec l'un des 4 comptes déjà crées. Manuia et Anna sont administrateur. Il est également possible de s'inscrire et créer son profil.
Le front-office permet toute la gestion des photos (création,modification et suppression) avec les autorisations et permissions ajustées.










## Annexes

Voici les différentes entités du projet :



*   ### Gallerie
  *     Nom propriété : Id | Type : Integrer | notnull
  *     Nom propriété : Auteur | Type : String | notnull
  *     Nom propriété : Nom | Type : String | notnull
  *     Nom propriété : Photo | Type : OneToManya | nullable


*    ### Photo

  *     Nom propriété : Id | Type : Intergrer | notnull      

  *     Nom propriété : Titre | Type : String | notnull

  *     Nom propriété : Auteur | Type : String | notnull

  *     Nom propriété : ShutterSpeed | Type : String | nullable

  *     Nom propriété : Ouverture | Type : String | nullable

  *     Nom propriété : ISO | Type : String | nullable

  *     Nom propriété : Description | Type : String | nullable

  *     Nom propriété : gallerie | Type : ManyToOne | notnull

  *      Nom propriété : Albums | Type : ManyToMany | notnull

*   ### Membre

  *     Nom propriété : Id | Type : Intergrer | notnull      

  *     Nom propriété : Pseudo | Type : String | notnull

  *     Nom propriété : Annee | Type : String | notnull

  *     Nom propriété : Pays | Type : String | notnull
  
  *     Nom propriété : User | Type : String | notnull

  *     Nom propriété : Gallerie | Type : OneToOne | notnull

  *     Nom propriété : Albums | Type : OneToMany | notnull

  *     Nom propriété : Photo | Type : OneToMany | notnull

*   ### User

  *     Nom propriété : Id | Type : Intergrer | notnull      

  *     Nom propriété : email | Type : String | notnull

  *     Nom propriété : roles | Type : Array | notnull

  *     Nom propriété : password | Type : String | notnull

  *     Nom propriété : Membre | Type : OneToOne | notnull

  *     Nom propriété : pseudo | Type : String | notnull

  *     Nom propriété : Annee | Type : Intergrer | notnull

  *     Nom propriété : Pays | Type : String | notnull

