<div class="container">
	<form class="form-signin" action="<?php echo $actionAuthPath;?>" method="post"> 
		<input type="hidden" name="refer" value="<?php echo $refer; ?>" ></input>
		<h2 class="form-signin-heading">Please sign in</h2>
    	<label for="inputEmail" class="sr-only">Email address</label>
     	<input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
     	<label for="inputPassword" class="sr-only">Password</label>
     	<input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
     	<div class="checkbox">
     	<label>
      		<input type="checkbox" value="remember-me"> Remember me
        </label>
        </div>
        <a href="<?php echo $actionJoinPath;?>">Join us</a>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
	</form>
</div> <!-- /container -->
