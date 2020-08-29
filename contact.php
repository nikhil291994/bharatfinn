<?php
session_start();
error_reporting(0);
include('app/class/config.php');

if (isset($_POST['sendDetails'])) 
{
  $fullName = mysqli_real_escape_string($con, $_POST['fullName']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $phone = mysqli_real_escape_string($con, $_POST['phone']);
  $messsage = mysqli_real_escape_string($con, $_POST['message']);

  $header = "From: Bharat Finn Services\r\n";
  $header .= 'MIME-Version: 1.0' . "\r\n";
  //$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  //$header .= 'From: '.$email."\r\n".'Reply-To: '.$email."\r\n" . 'X-Mailer: PHP/' . phpversion();

  $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  $header .= "Reply-To: contact@bharatfinn.in";
  $message = "Hi,<br>";
  $message .= "<b>Full name :</b> ".$fullName."<br>";
  $message .= "<b>Email :</b> ".$email."<br>";
  $message .= "<b>Phone :</b> ".$phone."<br>";
  $message .= "<b>message :</b> ".$messsage."<br>";
  $message .= "<br>- New Enquiry From Contact Us Page<br>";
  $subject = "Bharat Finn";
  $message = wordwrap($message, 200);
  $senderEmail = 'contact@bharatfinn.in';

  if(mail($senderEmail, $subject, $message, $header))
  {
    echo '<script>alert("Enquiry Sent...!!!")</script>';
    //$msg = "<div class='alert bg-gradient2 text-white' role='alert'><strong></strong>Enquiry Sent...!!!</div>";
  }
  else
  {
    echo '<script>alert("Error...!!! Enquiry Not Sent.")</script>';
    //$msg = "<span class='alert bg-gradient1 text-white' role='alert'>Error...!!! Enquiry Not Sent.</span>";
  }
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bharat Finn Services</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Oswald:400,700|Work+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="shortcut icon" href="app/assets/images/bharat_finn_logo.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/mediaelementplayer.min.css">
    
    
    
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  
    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    
  </head>
  <body style="background-image: url('images/bg.jpg');">

    <div class="site-wrap">

  <div class="site-mobile-menu">
    <div class="site-mobile-menu-header">
      <div class="site-mobile-menu-close mt-3">
        <span class="icon-close2 js-menu-toggle"></span>
      </div>
    </div>
    <div class="site-mobile-menu-body"></div>
  </div> <!-- .site-mobile-menu -->
    
    
    <div class="site-navbar-wrap js-site-navbar bg-white">
      
      <div class="container">
        <div class="site-navbar bg-light">
          <div class="row align-items-center">
            <div class="col-2">
              <h2 class="mb-0 site-logo"><a href="index.php" class="font-weight-bold">
                <img src="images/bf_logo.jpg" style="height: 87px;"></a></h2>
            </div>
            <div class="col-10">
              <nav class="site-navigation text-right" role="navigation">
                <div class="container">
                  <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

                  <ul class="site-menu js-clone-nav d-none d-lg-block">
                    <li><a href="index.php">Home</a></li>
                    <li class="active"><a href="contact.php">Contact</a></li>
                    <li><a href="/app">Login</a></li>
                  </ul>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="site-blocks-cover inner-page overlay" style="background-image: url(images/hero_bg_44.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-7 text-center" data-aos="fade">
          <h1 class="text-uppercase">Contact Us</h1>
          <span class="caption d-block text-white">An Loan Company</span>
        </div>
      </div>
    </div>  

    <div class="py-5 bg-light">
      <div class="container">
        <div class="row">
       
          <div class="col-md-12 col-lg-8 mb-5">
          <?php echo $msg; ?>          
            
          
            <form method="POST" class="p-5 bg-white">

              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="font-weight-bold" for="fullname">Full Name</label>
                  <input type="text" name="fullName" id="fullname" class="form-control" placeholder="Full Name" required>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <label class="font-weight-bold" for="email">Email</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
                </div>
              </div>


              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="font-weight-bold" for="phone">Phone</label>
                  <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" required>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="font-weight-bold" for="message">Message</label> 
                  <textarea name="message" id="message" cols="30" rows="5" class="form-control" placeholder="Say hello to us" required></textarea>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" name="sendDetails" value="Send Message" class="btn btn-primary text-white px-4 py-2">
                </div>
              </div>

  
            </form>
          </div>

          <div class="col-lg-4">
            <div class="p-4 mb-3 bg-white">
              <h3 class="h5 text-black mb-3">Contact Info</h3>

              <p class="mb-0 font-weight-bold">Address</p>
              <p class="mb-4" style="color: #fd7e14;">Mumbai, Pune</p>

              <p class="mb-0 font-weight-bold">Phone</p>
              <p class="mb-4" style="color: #fd7e14;">+91 8267 253423</p>

              <p class="mb-0 font-weight-bold">Email Address</p>
              <p class="mb-0" style="color: #fd7e14;">contact@bharatfinn.in</p><br>

              <p class="mb-0 font-weight-bold">Office Timing</p>
              <p class="mb-4" style="color: #fd7e14;">Monday to Saturday <br> 10 AM to 6 PM</p>

            </div>
            
            
          </div>
        </div>
      </div>
    </div>
    
    <footer class="site-footer">
      <div class="container">
        

        <div class="row">
          <div class="col-md-4">
            <h3 class="footer-heading mb-4 text-white">About</h3>
            <p>An Loan Providing Company<br>UAM No. : MH19D0128976</p>
          </div>
          <div class="col-md-5 ml-auto">
            <div class="row">
              <div class="col-md-6">
                <h3 class="footer-heading mb-4 text-white">Quick Menu</h3>
                  <ul class="list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="contact.php">Contact</a></li>
                  </ul>
              </div>
              <div class="col-md-6">
                <h3 class="footer-heading mb-4 text-white">Loan</h3>
                  <ul class="list-unstyled">
                    <li><a href="#">Home Loan</a></li>
                    <li><a href="#">Personal Loan</a></li>
                    <li><a href="#">& More</a></li>
                  </ul>
              </div>
            </div>
          </div>

        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <p>
              <!--
              # Site Developed By: Mr. Nikhil M. Dange
              -->
              Copyright &copy; <script>document.write(new Date().getFullYear());</script> All Rights Reserved | Bharat Finn Services (A Division of Olakh Traders)
            </p>
          </div>
          
        </div>
      </div>
    </footer>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>

  </body>
</html>