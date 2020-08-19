$(function() {

   /*******************************
  *      HIDE ERROR MESSAGE       *
  *******************************/

  $(".btn-error").click(function(){
    $(".error_alert").hide();
  });

  /*******************************
  *      PAGE NAMES & FILES      *
  *******************************/

  // Assign values to variables
  var $list, $newItemForm;
  $list = $('#newItemFormField');
  $newItemForm = $('#newItemForm');

  // Listen to the event submit the form (always put preventDefault)
  $newItemForm.on('click','#add', function(e) {
      e.preventDefault();
      // Get the value of the imput with val()
      var text = $('.itemField').val();
      // Check if the value of the input has enough characters
      if(text.length < 3) {
          alert('Le nom de la page doit comporter au moins 3 caractères');
      } else {
          // Add the retrieved value in the end of the list
          $list.append('<div class="input-group page-name-file"><input class="item-name form-control my-2" value="'+ text +'" name="itemField[]"/><div class="custom-file my-2"><input name="userfile[]" id="userfile"  class="custom-file-input item-file form-control" type="file" multiple/><label class="custom-file-label label_fileName" for="userfile" data-browse="Parcourir">Choisissez un jpg</label></div><div class="m-auto pl-2"><button type="button" class="close remove" aria-label="Close" title="Cliquer pour supprimer"><span aria-hidden="true">&times;</span></button></div></div>');

          $('.itemField').val('');

          // Put the name of the uploaded file in the label
          $(".item-file").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".label_fileName").addClass("selected").html(fileName).css('color','#e64827');
          });

          // Remove newly created inputs
          $('.page-name-file .remove').on('click', function() {
            var parent =  $(this).closest($('.page-name-file'));
            console.log(parent);
            $(parent).remove();
          });

      }
  });

  // Remove the default input
  $('.page-name-file .remove').on('click', function() {
    var parent =  $(this).closest($('.page-name-file'));
    console.log(parent);
    $(parent).remove();
  });

  /****************************
  *     Uploaded file names    *
  ****************************/

  $(".item-file").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".label_fileName").addClass("selected").html(fileName).css('color','#e64827');
  });

  $(".logo_file").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".label_logo").addClass("selected").html(fileName).css('color','#e64827');
  });


  /****************************
  * Launch Ajax to create zip *
  ****************************/


  $('#download').click(function(){
      $.ajax({
          url: 'ajaxfile.php',
          type: 'post',
          success: function(response){
            window.location = response;
          }
      });
  });

  /********************************
  * Launch Ajax to erase the zip  *
  ********************************/

  $('#return').click(function(){
    $.ajax({
        url: 'ajaxremovefile.php',
        type: 'post',
        success: function(response){
          window.location = response;
        },
    });
  });

   /********************************
  *       Launch welcome modal     *
  ********************************/

  $('.welcome').modal('show');


});




