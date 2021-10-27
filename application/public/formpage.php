<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FormPage</title>
    <script
src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
crossorigin="anonymous"></script>
<script>
$(document).ready(function(){
 
  $('input[type="radio"]').click(function(){
      
      if($(this).attr("value") == 'foreign'){
          $('#city').val('Other');
          $('#country').show();
      }
      else {
          $('#country').val('bulgarian');
          $('#country').hide();
          
      }
  });
});
</script>
</head>
<body>
<?php require_once __DIR__ . '/../app/includes/initForm.php'; ?>
</body>
