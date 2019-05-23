$(function() {
  //lors du clic sur le bouton d'envoye de fichier
  $("button[type='submit']").click(function(){
      let $fileUpload = $("input[type='file']");

      //on verifie que l'utilisateur n'as pas uplauder plus de 3 fichier
      //sinon on annule l'evenement et on affiche un messsage d'erreur
      if (parseInt($fileUpload.get(0).files.length)>3){
       alert("You can only upload a maximum of 3 files");
       event.preventDefault();
      }
  });
});
