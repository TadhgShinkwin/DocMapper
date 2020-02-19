<?php
/*
 * This view uses the following  PHP variables as content
 *
 * First - get the content from the $data array:
 */
extract($data);
 /*
  * Then use these values to fill in the 'blank' content of the view
  *
  */
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>DocMapper</title>

  <!-- Bootstrap core CSS -->
  <link href="css/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="css/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Plugin CSS -->
  <link href="css/vendor/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="css/freelancer.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/footer-basic-centered.css">
  <link rel="icon" type="image/jpg" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRsFtoyKpwmVhGiQwoRhmNoY2eYmYwISfQncTPe3r1OKwI5m0AOrg">

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top"><?php echo $pageHeading?></a>
      <button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav nav ml-auto">
          <?php echo $menuNav; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="masthead bg-primary text-white text-center nospace">
    <div class="row">
      <div class="container col-md-6">
        <h3 class="text-uppercase mb-0"><?php echo $panelHeadLHS; ?></h3><!--Possibly edit the h1 to be a div-->
        <hr class="star-light">
        <div class="font-weight-light mb-0 home-lhs"><?php echo $stringLHS; ?></div>
      </div>
      <div class="container col-md-6">
        <!--<h3 class="text-uppercase mb-0"><?php echo $panelHeadRHS; ?></h3>
        <hr class="star-light">-->
        <div class="img-holder"><?php echo $stringRHS; ?></div>
      </div>
    </div>
  </header>

  <footer class="footer-basic-centered">

    <p class="footer-company-motto">DocMapper</p>

    <p class="footer-links">
      <a href="index.php?pageID=home">Home</a>
      ·
      <a href="index.php?pageID=maps">Maps</a>
      ·
      <a href="index.php?pageID=documents">Documents</a>
      ·
      <a href="index.php?pageID=profile">Profile</a>

    </p>

    <p class="footer-company-name">DocMapper &copy; 2015</p>

  </footer>

  <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
  <div class="scroll-to-top d-lg-none position-fixed ">
    <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
      <i class="fa fa-chevron-up"></i>
    </a>
  </div>



  <!-- Bootstrap core JavaScript -->
  <script src="scripts/vendor/jquery/jquery.min.js"></script>
  <script src="scripts/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="scripts/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="scripts/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- Contact Form JavaScript -->
  <script src="scripts/js/jqBootstrapValidation.js"></script>
  <script src="scripts/js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="scripts/js/freelancer.min.js"></script>
  <script src="scripts/javascript.js"></script>

</body>

</html>
