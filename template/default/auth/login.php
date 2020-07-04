<!DOCTYPE html>
<html>
<head>
	<title><?= app()['application_name'] ?> | Login</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/css/login.css">
  <style type="text/css">
  .card-signin {
    border-radius: 0px;
  }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
          	<center>
          	<img src="<?= base_url() ?>/public/assets/logo.png" width="150px">
          	</center>
            <h5 class="card-title text-center"><?= app()['application_name'] ?> LOGIN</h5>
            <?php $old_email=""; if(session()->get('error')): $old_email = session()->get('old_email');?>
            <div class="alert alert-danger"><?=session()->get('error')?></div>
            <?php session()->reset('error');session()->reset('old_email'); endif ?>
            <form class="form-signin" method="post" action="<?= base_url() ?>/auth/doLogin">
              <input type="hidden" name="act" value="login">
              <div class="form-label-group">
                <input type="text" name="user_login" value="<?= $old_email; ?>" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
                <label for="inputEmail">Username</label>
              </div>

              <div class="form-label-group">
                <input type="password" name="user_pass" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>

              <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Remember password</label>
              </div>
              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit"><i class="fa fa-sign-in"></i> Sign in</button>
              <hr class="my-4">
              <button class="btn btn-lg btn-google btn-block text-uppercase" type="button"><i class="fa fa-google mr-2"></i> Sign in with Google</button>
              <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="button"><i class="fa fa-facebook-f mr-2"></i> Sign in with Facebook</button>
              <br>
              <center>Oleh Luxor Indonesia</center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>