$(function() {
  $("button[type='submit']").click(function(){
      let $fileUpload = $("input[type='file']");
      if (parseInt($fileUpload.get(0).files.length)>3){
       alert("You can only upload a maximum of 3 files");
       event.preventDefault();
      }
  });
});
