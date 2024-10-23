<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: ../cnx/cnx.php");
}
?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../css/bootstrap.min.css">
     <link rel="stylesheet" href="../css/style.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
     <title>Medecin</title>
 </head>

 <body>

     <?php
        require_once '../menu.php';
        require_once '../db/conn.php';
        require_once '../db/maladies_chrs.php';

        $categories = liste_categories($conn);
        ?>

     <div class="container m-5">
         <div>
             <ul id="categories">
                 <?php
                    foreach ($categories as $index => $categorie) :
                    ?>
                     <li id="cat_<?= $categorie['num_categorie'] ?>" class="categorie">
                         <span><?= $categorie['categorie'] ?></span>
                         <ul>
                             <?php
                                $maladies_chrs = liste_maladies_chroniques($conn, $categorie['num_categorie']);
                                foreach ($maladies_chrs as $index => $maladies_chr) :
                                ?>
                                 <li id="mal_<?= $maladies_chr['num_maladie'] ?>" class="maladie">
                                     <span><?= $maladies_chr['maladie'] ?></span>
                                 </li>
                             <?php
                                endforeach;
                                ?>
                         </ul>
                     </li>
                 <?php
                    endforeach;
                    ?>
             </ul>
         </div>
     </div>
 </body>
 <script type="text/javascript">
     function createNewCategorie() {
         const catUl = $("#categories");

         const el = $('<li>')
             .attr('id', 'cat_999999')
             .addClass('categorie')
             .appendTo(catUl);

         const span = $('<span>')
             .text("Nouvelle catégorie")
             .appendTo(el);

         const ul = $('<ul>')
             .appendTo(el);

         createCategorie(el);

         dbInsertCategorie(el, "Nouvelle catégorie");
     }

     function createCategorie(el) {
         const cat_id = el.attr('id').substr(4);
         const span = el.find('span').eq(0);

         const mainDiv = $('<div>')
             .prependTo(el);

         const spanDiv = $('<div>')
             .appendTo(mainDiv);
         span.appendTo(spanDiv);

         const inpDiv = $('<div>')
             .appendTo(mainDiv);

         const input = $('<input>')
             .attr('name', 'categorie_' + cat_id)
             .attr('id', 'categorie_' + cat_id)
             .val(span.text())
             .keypress((e) => {
                 const cat_el = $(e.target).parents('li.categorie');
                 if (e.which == 13) {
                     saveCategorie(cat_el);
                 }
             })
             .appendTo(inpDiv);

         const saveBtn = $('<a>')
             .attr('href', '#')
             .attr('title', 'Enregistrer')
             .addClass('mx-2')
             .html('<i class="fas fa-save"></i>')
             .appendTo(inpDiv)
             .click((e) => {
                 const cat_el = $(e.target).parents('li.categorie');
                 saveCategorie(cat_el);
             });
         inpDiv.hide()

         const btnSpan = $('<span>')
             .appendTo(spanDiv);
         const editAnchor = $('<a>')
             .attr('href', '#')
             .attr('title', 'Modifier')
             .addClass('mx-2')
             .html('<i class="fas fa-pencil-alt"></i>')
             .appendTo(btnSpan)
             .click(() => {
                 inpDiv.show();
                 spanDiv.hide();
             });
         const delAnchor = $('<a>')
             .attr('href', '#')
             .attr('title', 'Supprimer')
             .addClass('mx-2')
             .html('<i class="fas fa-trash-alt"></i>')
             .click((e) => {
                 const cat_el = $(e.target).parents('li.categorie');
                 if (confirm("Etes-vous sûr de vouloir supprimer cette catégorie ?")) {
                     deleteCategorie(cat_el);
                 }
             })
             .appendTo(btnSpan);

         $('<a>')
             .attr('href', '#')
             .html('<i class="fas fa-plus-circle"></i> Nouvelle maladie')
             .click((e) => {
                 const thisObj = $(e.target);
                 const cat_el = thisObj.parent('li');
                 createNewMaladie(cat_el);
             })
             .appendTo(el);
     }

     function saveCategorie(cat_el) {
         const divs = cat_el.find('div');

         const spanDiv = divs.eq(1);
         const span = spanDiv.find('span').eq(0);
         const inpDiv = divs.eq(2);
         const input = inpDiv.find('input');

         const categorie = input.val();
         const cat_id = cat_el.attr('id').substr(4);

         span.text(categorie);
         inpDiv.hide();
         spanDiv.show();
        
         dbUpdateCategorie(cat_id, categorie);
     }

     function deleteCategorie(cat_el) {
         const cat_id = cat_el.attr('id').substr(4);
         dbDeleteCategorie(cat_el, cat_id);
     }
//////////////////////////////////
     function createNewMaladie(cat_el) {
         const ul = cat_el.find('ul').eq(0);
         const el = $('<li>')
             .attr('id', 'mal_999999')
             .addClass('maladie')
             .appendTo(ul);

         const span = $('<span>')
             .text("Nouvelle maladie")
             .appendTo(el);

         createMaladie(el);
         dbInsertMaladie(el , "Nouvelle maladie" );
     }

     function createMaladie(mal_el) {
         const mal_span = mal_el.find('span').eq(0);
         const mal_id = mal_el.attr('id').substr(4);

         const mainDiv = $('<div>')
             .prependTo(mal_el);

         const spanDiv = $('<div>')
             .appendTo(mainDiv);
         mal_span.appendTo(spanDiv);

         const inpDiv = $('<div>')
             .appendTo(mainDiv);

         const input = $('<input>')
             .attr('name', 'maladie_' + mal_id)
             .attr('id', 'maladie_' + mal_id)
             .val(mal_span.text())
             .keypress((e) => {
                 const mal_el = $(e.target).parents('li.maladie');
                 if (e.which == 13) {
                     saveMaladie(mal_el);
                 }
             })
             .appendTo(inpDiv);

         const saveBtn = $('<a>')
             .attr('href', '#')
             .attr('title', 'Enregistrer')
             .addClass('mx-2')
             .html('<i class="fas fa-save"></i>')
             .appendTo(inpDiv)
             .click((e) => {
                 saveMaladie(mal_el);
             });
         inpDiv.hide()

         const btnSpan = $('<span>')
             .appendTo(spanDiv);
         const editAnchor = $('<a>')
             .attr('href', '#')
             .attr('title', 'Modifier')
             .addClass('mx-2')
             .html('<i class="fas fa-pencil-alt"></i>')
             .appendTo(btnSpan)
             .click(() => {
                 inpDiv.show();
                 spanDiv.hide();
             });
         const delAnchor = $('<a>')
             .attr('href', '#')
             .attr('title', 'Supprimer')
             .addClass('mx-2')
             .html('<i class="fas fa-trash-alt"></i>')
             .click((e) => {
                 const mal_el = $(e.target).parents('li.maladie');
                 if (confirm("Etes-vous sûr de vouloir supprimer cette maladie ?")) {
                     deleteMaladie(mal_el);
                 }
             })
             .appendTo(btnSpan);
     }

     function deleteMaladie(mal_el) {
        const mal_id = mal_el.attr('id').substr(4);
         dbDeleteMaladie(mal_el, mal_id);
       
     }

     function saveMaladie(mal_el) {
         const divs = mal_el.find('div');

         const spanDiv = divs.eq(1);
         const mal_span = spanDiv.find('span').eq(0);
         const inpDiv = divs.eq(2);
         const input = inpDiv.find('input');

         const maladie = input.val();
         const mal_id = mal_el.attr('id').substr(4);


         mal_span.text(input.val());
         inpDiv.hide();
         spanDiv.show();

         dbUpdateMaladie(mal_id,maladie)
     }

     function dbInsertCategorie(cat_el, categorie) {
         $.post("operations.php", {
             'categorie': categorie,
             'table': 'categorie',
             'operation': 'insert'
         }, function(data) {
             console.log(data);
             cat_el.attr('id', 'cat_' + data);
         });
     }

     function dbUpdateCategorie(num_cat, categorie) {
        $.post("operations.php", {
             'categorie': categorie,
             'num_cat': num_cat,
             'table': 'categorie',
             'operation': 'update'
         }, function(data) {
             console.log(data);
         });
     }

     function dbDeleteCategorie(cat_el, num_cat) {
        $.post("operations.php", {
             'num_cat': num_cat,
             'table': 'categorie',
             'operation': 'delete'
         }, function(data) {
             console.log(data);
             cat_el.remove();
         });
     }
////////////////////////////////////////////////
     function dbInsertMaladie(mal_el, maladie) {
         const cat_el = mal_el.parents('li.categorie');
         const num_cat = cat_el.attr('id').substr(4);
         
         $.post("operations.php", {
             'maladie': maladie,
             'table': 'maladie',
             'num_cat': num_cat,
             'operation': 'insert'
         }, function(data) {
             console.log(data);
             mal_el.attr('id', 'mal_' + data);
         });
     }
     
     function dbDeleteMaladie(mal_el, num_mal) {
        $.post("operations.php", {
             'num_mal': num_mal,
             'table': 'maladie',
             'operation': 'delete'
         }, function(data) {
             console.log(data);
             mal_el.remove();
         });
     }

     function dbUpdateMaladie(num_mal,maladie) {
        $.post("operations.php", {
             'maladie': maladie,
             'num_mal': num_mal,
             'table': 'maladie',
             'operation': 'update'
         }, function(data) {
             console.log(data);
         });
     }

     $(document).ready(function() {
         const catUl = $('#categories');
         const parentDiv = catUl.parent('div');

         $('<a>')
             .attr('href', '#')
             .html('<i class="fas fa-plus-circle"></i> Nouvelle catégorie')
             .click(() => {
                 createNewCategorie();
             })
             .appendTo(parentDiv);

         $('.categorie').each((index, elem) => {
             const el = $(elem);
             createCategorie(el);

             ///////////
             el.find('.maladie').each((index, elem) => {
                 const mal_el = $(elem);
                 createMaladie(mal_el);
             });
         });
     });
 </script>
 <!-- script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

 </html>