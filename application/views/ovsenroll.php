
    <div class="container">
      <form class="form-signin" action="<?php echo $actionJoinPath;?>" method="post">
        <h2 class="form-signin-heading">Enter User information</h2>
          <label for="inputName" class="sr-only">User name</label>
            <input id="usrName" name="usrName" type="text" id="inputName" class="form-control" placeholder="User name" required autofocus>
            <label for="inputEmail" class="sr-only">Email address</label>
            <span id="emailFocus"><input name="usrEmail" type="email" id="usrEmail" class="form-control" placeholder="Email address" required autofocus></span>

            <label for="inputPassword" class="sr-only">Password</label>
            <input name="usrPass" type="password" id="inputPassword" class="form-control" placeholder="Password" required>

            <label for="inputPasswordw" class="sr-only">Repeat Password</label>
            <input name="usrPass2" type="password" id="inputPasswordw" class="form-control" placeholder="Repeat Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit">Sign in</button>
          </form>

        </div> <!-- /container -->

<script>
$(document).ready ( function () {

  $('#emailFocus').focusout( function() {
    $('#checkedEmail').hide();
    if($('#usrEmail').val().match(/@/)) {
      var fncCheck = $.post("<?php echo $actionEmailCheck;?>", {'usrEmail': $('#usrEmail').val()});
      fncCheck.done(function (data){
          if(data >= 1){
              $('#usrEmail').after('<span id="checkedEmail" class=\"error\"> This email is already join.</span>');
          } else {
              $('#usrEmail').after('<span id="checkedEmail" class=\"notice\"> This email can use.</span>');
          }
      });

      fncCheck.fail(function (data){
        alert('fail')
      });
    }

  });

  $('#submit').click( function () {
    $('#errorTextPw').hide();
    var hasError = false;
    var opass = $('#inputPassword').val();
    var vpass = $('#inputPasswordw').val();
    if(opass === vpass) {
      hasError = true;
    } else if (opass !== vpass) {
      $('#inputPassword').addClass('error');
      $('#inputPasswordw').addClass('error').after("<span id=\"errorTextPw\" class=\"errorText\">Password is not match</span> ");
      hasError = false;
    } else {
        hasError = false;
    }
    return hasError;
  });
  $('input[type=password]').click(function (){
      $(this).val('');
      $(this).removeClass('error');
      $('#errorTextPw').hide();
  });
});
</script>
