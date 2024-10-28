<?php
// require_once 'xampp\htdocs\eventMgmt\db\db.php';
// require_once '../includes/header.php';
// require_once '../utils/auth.php';
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }
// $conn = getDB();
require_once '../db/db.php';

//$conn = getDB();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROSPERIA</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="boxicons-2.0.9/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source Sans Pro:wght@400;600&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Georama:wght@600&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bebas Neue:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" />

</head>

<body id="home">
    <?php //session_start(); ?>

    <div class="scroll-up-btn">
        <i class="bx bx-up-arrow-alt bx-sm"></i>
    </div>
    <div class="showcase">

        <!-- navbar-->
        <div class="navbar-bottom">
            <a href="#home" class="brand-left">Event Management</a>
            <ul class="menu-right">
                <li><a href="#home">Home</a></li>
                <li><a href="#blog">Services</a></li>
                <li><a href="#teams">Program</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>

            <div class="log-sign">
                <?php if(isset($_SESSION['loggedin'])){ ?>
                    <?php echo "<a class ='log-in' href='http://localhost/PROSPERIA/dashboard.php'>". $_SESSION['username'] ."</a>"; ?>
                <div class="sign-up"><a href="http://localhost:8080/PROSPERIA/logout.php">Log Out</a></div>

                <?php } else { ?>
                <div class="log-in"><a href="http://localhost:8080/eventMgmt/src/loginsignup/login.php">LOG IN</a></div>
                <div class="sign-up"><a href="http://localhost:8080/eventMgmt/src/loginsignup/signup.php">SIGN UP</a></div>
                <?php } ?>
            </div>
        </div>

        <!-- Showcase content Section -->
        <div class="showcase-content">
            <h1>FINANCIAL FREEDOM?<br> MAKE <span>DREAMS COME TRUE</span></h1>
            <p>Let us help you build a brighter financial future with us.</p>
            <a href="#portfolio" class="btn btn-left">EXPLORE MORE</a>
            <a href="#contact" class="btn btn-right">GET IN TOUCH</a>
        </div>
    </div>

    <!-- Notice Section -->
    <section id="portfolio" class="portfolio py-3">
        <h3 class="text-center">WEBSITE NOTICE</h3>
        <h2 class="text-center">We want you <span class="text-secondary">to hear this out</span> </h2>
        <p class="text-center">We currently don't have the feature to directly connect with your bank account for
            seamless tracking of your finances. <br>
            Entering your savings honestly helps us track and provide valuable financial reports for your jouney in
            prosperia.</p>
    </section>

    <!-- Service Section -->
    <section id="blog" class="blog py-3">
        <div class="wrapper">
            <div class="header">
                <span></span>
                <h4>MAIN ATTRACTION</h4>
            </div>
            <div class="blog-info">
                <h2>OUR<span class="text-secondary"> SERVICES</span></h2>
                <a href="#">More in future..</a>
            </div>
            <div class="blog-card">
                <div class="card">
                    <div class="card-header">
                        <img src="pic.jpg">
                    </div>
                    <div class="card-body">
                        <span class="tag tag-yellow">INVESTMENT</span>
                        <h4>Invesments ensure you can do as you wish</h4>
                        <div class="footer">
                            <small>June 6, 2023</small>
                            <a href="#"><i class="bx bx-right-arrow-alt bx-sm"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <img src="pic.jpg">
                    </div>
                    <div class="card-body">
                        <span class="tag tag-purple">Job/Internship</span>
                        <h4>The first step always feels harder</h4>
                        <div class="footer">
                            <small>June 6, 2023</small>
                            <a href="#"><i class="bx bx-right-arrow-alt bx-sm"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <img src="pic.jpg">
                    </div>
                    <div class="card-body">
                        <span class="tag tag-pink">Finance Education</span>
                        <h4>The learning part never ends</h4>
                        <div class="footer">
                            <small>June 6, 2023</small>
                            <a href="#"><i class="bx bx-right-arrow-alt bx-sm"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="teams" class="teams bg-light py-3">
        <h3 class="text-center">We will be there for you</h3>
        <h2 class="text-center">Meet Our <span class="text-secondary">Project Team</span></h2>
        <p class="text-center">We help you realize the power of finance, discover opportunities you may never have <br>
            imagined and achieve results that bridge what is with what can be</p>
        <div class="wrapper">
            <div class="card-items">
                <div class="card">
                    <div class="card-header">
                        <img src="bj.JPG">
                    </div>
                    <div class="card-body">
                        <h3>BIJAY SYANGTAN</h3>
                        <h4>DEVELOPER & DESIGNER</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <img src="basnet.jpg">
                    </div>
                    <div class="card-body">
                        <h3>BIJAY BASNET</h3>
                        <h4>DEVELOPER & MANAGER</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <img src="chatgpt.png">
                    </div>
                    <div class="card-body">
                        <h3>CHATGPT</h3>
                        <h4>RESEARCHER & ENHANCER</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <img src="google.png">
                    </div>
                    <div class="card-body">
                        <h3>GOOGLE</h3>
                        <h4>RESEACHER & ADMINISTRATOR</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <!-- <section id="contact" class="contact bg-secondary py-3">
        <h2 class="text-center">Subscribe To Our Newsletter</h2>
        <p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio,<br> quam asperiores
            qui illum tenetur atque.</p>
        <div class="wrapper">
            <form class="text-center">
                <input type="email" name="email" id="email" placeholder="Enter Email Address" required>
                <button class="button">Submit</button>
            </form>
        </div>
    </section> -->

    <!-- Footer Section -->
    <footer class="footer-bottom py-3 text-center">
        <p>Copyright &copy; 2023 PROSPERIA. All Rights Reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="app.js"></script>
</body>

</html>