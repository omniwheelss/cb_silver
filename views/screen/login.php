<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=Config::LOGIN_TITLE?></title>

    <!-- Bootstrap -->
    <link href="./follow/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="./follow/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="./follow/animate.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="./follow/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="./follow/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    
    <!-- Custom Theme Style -->
    <link href="./build/css/custom.css" rel="stylesheet">
		
		
  </head>

  <body class="login">
  <?php
	if (isset($message)) {
  ?>
	<div class="alert alert-danger alert-dismissible fade in" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
	  </button>
	  <?=$message?>
	</div>		
	<?php
	}
	?>
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
             <form class="form-horizontal form-label-left" novalidate method="post">
              <h1>Login Here</h1>
				<div class="item form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<input type="email" id="email" name="email" placeholder="Email Address" class="form-control col-md-7 col-xs-12" required="required">
					</div>
				</div>
				<div class="item form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<input id="password" type="password" name="password" placeholder="Password"  class="form-control col-md-7 col-xs-12" required="required"><!--data-validate-length="2,8"-->
					</div>
				</div>
			
				<div class="form-group">
					<div class="col-md-8 col-md-offset-3">
						<button id="send" type="submit" class="btn btn-success">Submit</button>
						<a class="reset_pass_" href="#">Lost your password?</a>
					</div>
				</div>
							

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> <?=Config::APP_NAME?></h1>
                  <p>&copy;<?=date('Y')." ".CONFIG::LOGIN_FOOTER_TITLE?> </p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
    <!-- jQuery -->
    <script src="./follow/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="./follow/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="./follow/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="./follow/nprogress/nprogress.js"></script>
    <!-- validator -->
    <script src="./follow/validator/validator.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="./build/js/custom.min.js"></script>

    <!-- validator -->
    <script>
      // initialize the validator function
      validator.message.date = 'not a real date';

      // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
      $('form')
        .on('blur', 'input[required], input.optional, select.required', validator.checkField)
        .on('change', 'select.required', validator.checkField)
        .on('keypress', 'input[required][pattern]', validator.keypress);

      $('.multi.required').on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
      });

      $('form').submit(function(e) {
        e.preventDefault();
        var submit = true;

        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
          submit = false;
        }

        if (submit)
          this.submit();

        return false;
      });
    </script>
    <!-- /validator -->
		
  </body>
</html>