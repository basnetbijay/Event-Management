<?php 
session_start();

?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--=============== FAVICON ===============-->
        <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

        <!--=============== BOXICONS ===============-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

        <!--=============== SWIPER CSS ===============--> 
        <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">

        <!--=============== CSS ===============--> 
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/popup.css">

        <title>ACEM Event Management</title>
<style>
/* Popup menu style */
.popup-menu {
    display: none; /* Initially hidden */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Dim background */
    z-index: 1000;
}

.popup-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    width: 300px;
    border-radius: 5px;
    position: relative;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
}

.popup-options {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

button {
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #ccc;
}
.new__img {
    width: 120px;            /* Set a fixed width */
    height: 120px;           /* Set a fixed height */
    object-fit: cover;       /* Crop the image to fit the container */
    margin-bottom: var(--mb-0-5);
    transition: .3s;
}
.new__container {             /* Allow wrapping of items */
    gap: 20px;                   /* Adjust the gap size as needed */
}

.new__content {
    flex: 0 1 calc(33.333% - 20px); /* Adjust the percentage to fit your layout, accounting for the gap */
}


    </style>
       
  
    </head>
    <body>
        
        <?php
        if(isset($_SESSION['is_logged_in'])){
            $email = $_SESSION['email']; // Assuming the user ID is stored in the session
            $userID = $_SESSION['user_id'];
        }else{
            $email = "test";
            $userID=999999;
        }
  // Assuming the user ID is stored in the session

  // Connect to the database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "event";
  
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  
// Fetch the current event ID (replace with your dynamic event ID logic)
$event_id = 1; // You should replace this with dynamic logic

// 1. Check if the user has submitted an event (is the host)
$sql_host = "SELECT COUNT(*) FROM events WHERE email = ?";
$stmt_host = $conn->prepare($sql_host);
$stmt_host->bind_param("s", $email);
$stmt_host->execute();
$stmt_host->bind_result($event_count);
$stmt_host->fetch();
$stmt_host->close();

// 2. Check if the user is added as a member by the host
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    echo $email; // Fetch email from session

    // Query to check if the user is a member of any event in the event_member table
    $sql_member = "SELECT COUNT(*) FROM event_member WHERE email = ?";
    $stmt_member = $conn->prepare($sql_member);
    $stmt_member->bind_param("s", $email);
    $stmt_member->execute();
    $stmt_member->bind_result($member_count);
    $stmt_member->fetch();
    $stmt_member->close();

    // Check if the user is an added member of any event
    $userInList = ($event_count>0 || $member_count > 0); 

} else {
    // User is not logged in, so set the flag to false
    $userInList = false;
}

//for recommendation using content based filtering

?>

        <!--==================== HEADER ====================-->
        <header class="header" id="header">
            <nav class="nav containerr">
                <a href="#" class="nav__logo">
                    <img src="assets/img/logo.png" alt="" class="nav__logo-img">
                    Event Manager
                </a>

                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="#home" class="nav__link">Home</a>
                        </li>

                        <li class="nav__item">
                            <a href="#new" class="nav__link">Events</a>
                        </li>
                        <?php if ($userInList): ?>
            <li class="nav__item">
                <a href="http://localhost:8080/eventMgmt/TeamCollab/chats.php" style="text-decoration: none; color: white;" class="nav__link">Chat</a>
            </li>
        <?php endif; ?>
        <script>
        // Check if user is allowed to access the chat (via PHP)
        const userInList = <?php echo json_encode($userInList); ?>;
        console.log(userInList);
        
        if (showChat) {
            // Show the chat box if the user is added by the event host
            document.getElementById("chat-box").style.display = "block";
        }
    </script>

                        <li class="nav__item">
                        <?php if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']): ?>
                            <a href="http://localhost:8080/eventMgmt/EventSubmission/index.php" class="nav__link">Submit Idea</a>
                        <?php else: ?>
                            <a href="#" class="nav__link" id="login-popup-trigger">Submit Idea</a>
                        <?php endif; ?>
                    </li>


      

<!-- Nav item for Team Collab -->

<?php if ($event_count > 0): ?>
                <li><a href="http://localhost:8080/eventMgmt/TeamCollab/add_member.php"  style="text-decoration: none; color: white;">Team Collaboration</a></li>
            <?php else: ?>
                <li><span style="color:grey;">Team Collaboration (Disabled)</span></li>
            <?php endif; ?>


<!-- Popup Menu for Login/Cancel -->
<div id="login-popups" class="popup-menu" style="display: none;">
    <div class="popup-content">
        <span class="close" id="close-popups">&times;</span>
        <h2>Login Required</h2>
        <div class="popup-options">
            <button onclick="http://localhost:8080/eventMgmt/src/loginsignup/login.php">Login</button>
            <button id="cancel-btn">Cancel</button>
        </div>
    </div>
</div>



                     

                        <li class="nav__item">
                            <a href="http://localhost:8080/eventMgmt/Registration/index.php" class="nav__link">Participation</a>
                        </li>

                                           </ul>

                    <div class="nav__close" id="nav-close">
                        <i class='bx bx-x'></i>
                    </div>

                    <img src="assets/img/nav-img.png" alt="" class="nav__img">
                </div>
                <div class="nav-buttons">
                    
                <?php if(isset($_SESSION['is_logged_in'])){ ?>

                <div class="sign-up"><a href="http://localhost:8080/eventMgmt/src/loginsignup/logout.php" class="button button--ghost">Log Out</a></div>
                <?php

             }
             
              else { ?>
                <div class="login">
                    <a href="http://localhost:8080/eventMgmt/src/loginsignup/login.php" class="button button--ghost">LOG IN</a>
                </div>
                <div class="signup">
                    <a href="http://localhost:8080/eventMgmt/src/loginsignup/signup.php" class="button button--ghost">SIGN UP</a>
                </div>

                <?php }
                 ?>
                            
                         </div>

                <div class="nav__toggle" id="nav-toggle">
                    <i class='bx bx-grid-alt'></i>
                </div>

            </nav>
        </header>

        <main class="main">
            <!--==================== HOME ====================-->
            <section class="home container" id="home">
                <div class="swiper home-swiper">
                    <div class="swiper-wrapper">
                        <!-- HOME SLIDER 1 -->
                        <section class="swiper-slide">
                            <div class="home__content grid">
                                <div class="home__group">
                                    <img src="assets/img/lion.png" alt="" class="home__img">
                                    <div class="home__indicator"></div>
    
                                    <div class="home__details-img">
                                        <h4 class="home__details-title">Most Succesful</h4>
                                        <span class="home__details-subtitle">Event till the date</span>
                                    </div>
                                </div>
    
                                <div class="home__data">
                                    <h3 class="home__subtitle">#1 Event </h3>
                                    <h1 class="home__title">Making  <br>Every Event <br>Extraordinary</h1>
                                    <p class="home__description">It all starts here and ends here
                                    </p>

                                    <div class="home__buttons">
                                        <!-- <a href="#" class="button">Book Now</a> -->
                                        <!-- <a href="#" class="button--link button--flex">Track Record <i class='bx bx-right-arrow-alt button__icon'></i></a> -->
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- HOME SLIDER 2 -->
                        <section class="swiper-slide">
                            <div class="home__content grid">
                                <div class="home__group">
                                    <img src="assets/img/home2-img.png" alt="" class="home__img">
                                    <div class="home__indicator"></div>
    
                                    <div class="home__details-img">
                                        <h4 class="home__details-title">Adino & Grahami</h4>
                                        <span class="home__details-subtitle">No words can describe them</span>
                                    </div>
                                </div>
    
                                <div class="home__data">
                                    <h3 class="home__subtitle">#2 top Best duo</h3>
                                    <h1 class="home__title">BRING BACK <br> MY COTTON <br> CANDY</h1>
                                    <p class="home__description">Adino steals cotton candy from his brother and eats them all in one bite, 
                                        a hungry beast. Grahami can no longer contain his anger towards Adino.
                                    </p>

                                    <div class="home__buttons">
                                        <a href="#" class="button">Book Now</a>
                                        <a href="#" class="button--link button--flex">Track Record <i class='bx bx-right-arrow-alt button__icon'></i></a>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- HOME SLIDER 3 -->
                        <section class="swiper-slide">
                            <div class="home__content grid">
                                <div class="home__group">
                                    <img src="assets/img/home3-img.png" alt="" class="home__img">
                                    <div class="home__indicator"></div>
    
                                    <div class="home__details-img">
                                        <h4 class="home__details-title">Captain Sem</h4>
                                        <span class="home__details-subtitle">Veteran Spooky Ghost</span>
                                    </div>
                                </div>
    
                                <div class="home__data">
                                    <h3 class="home__subtitle">#3 Top Scariest  Ghost</h3>
                                    <h1 class="home__title">RESPAWN <br> THE SPOOKY <br> SKULL</h1>
                                    <p class="home__description">In search for cute little puppy, Captain Sem has come back from his tragic death. 
                                        With his hogwarts certified power he promise to be a hero for all of ghostkind.
                                    </p>

                                    <div class="home__buttons">
                                        <!-- <a href="#" class="button">Book Now</a> -->
                                        <a href="#" class="button--link button--flex">Track Record <i class='bx bx-right-arrow-alt button__icon'></i></a>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </section>
            
            <!--==================== CATEGORY ====================-->
            <section class="section category">
                <h2 class="section__title">Popular Events And<br> Programs</h2>

                <div class="category__container container grid">
                    <div class="category__data">
                        <img src="assets/img/exchange_program.png" alt="" class="category__img">
                        <h3 class="category__title">Exchange program</h3>
                        <p class="category__description">An exchange program offers cultural, educational, or professional experiences abroad..</p>
                    </div>

                    <div class="category__data">
                        <img src="assets/img/category2-img.png" alt="" class="category__img">
                        <h3 class="category__title">Welcome and Farewell</h3>
                        <p class="category__description">You look at the enjoyable Events there is.</p>
                    </div>

                    <div class="category__data">
                        <img src="assets/img/robots.png" alt="" class="category__img">
                        <h3 class="category__title">Robotics</h3>
                        <p class="category__description">A robotics event showcases and competes with robots in various challenges..</p>
                    </div>
                </div>
            </section>

            <!--==================== ABOUT ====================-->
            <section class="section about" id="about">
                <div class="about__container container grid">
                    <div class="about__data">
                        <h2 class="section__title about__title">About Musical <br> Nights</h2>
                        <p class="about__description">
                            Musical nights bring together melodies and rhythms, creating an enchanting atmosphere where emotions are expressed through harmonies and tunes. These evenings offer a magical escape, celebrating the beauty of live performances and the power of music to unite people.
                            
                        </p>
                        
                    </div>

                    <img src="assets/img/musical_night.png" alt="" class="about__img">
                </div>
            </section>

     
            <!--==================== NEW ARRIVALS ====================-->
            <?php
// Database connection
require_once '/xampp/htdocs/eventMgmt/db/db.php';
$conn= getDB();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch approved events with assigned venues
$sql = "SELECT e.event_name, e.event_description, e.event_picture, v.location
        FROM events e
        JOIN venues v ON e.venue_id = v.id
        WHERE e.status = 'approved'
        AND e.event_date >= CURDATE()
        ORDER BY e.created_at DESC
        LIMIT 3";
// Assuming there's a 'created_at' column for sorting
$result = $conn->query($sql);
?>
            <section class="section new" id="new">
                <h2 class="section__title">New Arrivals</h2>

                <div class="new__container container">
                    <div class="swiper new-swiper">
                    <div class="swiper-wrapper">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $image_path = htmlspecialchars($row['event_picture']);
            echo '<div class="new__content swiper-slide">';
            echo '<div class="new__tag">New</div>';
            echo '<img src="/eventMgmt/EventSubmission/' . $image_path . '" alt="Event Image" class="new__img">';
            echo '<h3 class="new__title">' . htmlspecialchars($row['event_name']) . '</h3>';
            echo '<span class="new__subtitle">' . htmlspecialchars($row['event_description']) . '</span>';
            echo '<span class="new__location">Location: ' . htmlspecialchars($row['location']) . '</span>';
            echo '<div class="new__prices">';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="new__content swiper-slide">';
        echo '<span class="new__subtitle">No approved events with assigned venues available</span>';
        echo '</div>';
    }

    ?>
    
</div>
                    </div>
                </div>
            </section style="margin-right: 20px;">

            <?php
            $email = $_SESSION['email'];

            // Function to get user event categories
            function getUserEventCategories($conn, $email) {
                $categories = [];
                $sql = "SELECT e.category FROM registrations r JOIN events e ON r.event = e.id WHERE r.email = ?";
                
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($row = $result->fetch_assoc()) {
                    $categories[] = $row['category'];
                }
                
                $stmt->close();
                return array_unique($categories);
            }
            
            // Function to get events by category, excluding those already registered
            function getEventsByCategory($conn, $email, $categories) {
                $recommendations = [];
                
                // Prepare a placeholder string for the IN clause
                $placeholders = implode(',', array_fill(0, count($categories), '?'));
                
                // // Query to fetch recommended events
                // $sql = "SELECT id, event_name, event_picture, event_description FROM events WHERE category IN ($placeholders) AND id NOT IN (
                //             SELECT event FROM registrations WHERE email = ?
                //         )";
                $sql = "SELECT e.id, e.event_name, e.event_picture, e.event_description, v.location 
        FROM events e
        JOIN venues v ON e.venue_id = v.id
        WHERE e.category IN ($placeholders) 
        AND e.id NOT IN (
            SELECT event FROM registrations WHERE email = ?
        )";

                
                $stmt = $conn->prepare($sql);
                
                // Bind parameters
                $types = str_repeat('s', count($categories)) . 's'; // e.g., 'sss'
                $params = array_merge($categories, [$email]);
                $stmt->bind_param($types, ...$params);
                
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($row = $result->fetch_assoc()) {
                    $recommendations[] = $row;
                }
                
                $stmt->close();
                return $recommendations;
            }
            
            
            // Get user event categories
            $categories = getUserEventCategories($conn, $email);
            
            // Get recommended events based on user categories
            if (!empty($categories)) {
                $recommendedEvents = getEventsByCategory($conn, $email, $categories);
            } else {
                $recommendedEvents = [];
            }
            
            $conn->close();
            ?>

            <section class="section new" id="new">
        <h2 class="section__title">Recommended Events</h2>

        <div class="new__container container">
            <div class="swiper new-swiper">
                <div class="swiper-wrapper">
                    <?php
                    if (!empty($recommendedEvents)) {
                        foreach ($recommendedEvents as $event) {
                            $image_path = htmlspecialchars($event['event_picture']);
                            echo '<div class="new__content swiper-slide">';
                            echo '<img src="/eventMgmt/EventSubmission/' . $image_path . '" alt="Event Image" class="new__img">';
                            echo '<h3 class="new__title">' . htmlspecialchars($event['event_name']) . '</h3>';
                            echo '<span class="new__subtitle">' . htmlspecialchars($event['event_description']) . '</span>';
                          //  echo '<span class="new__location">Location: ' . htmlspecialchars($row['location']) . '</span>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="new__content swiper-slide">';
                        echo '<span class="new__subtitle">No recommended events available based on your interests.</span>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

            <!--==================== OUR NEWSLETTER ====================-->
        
        </main>

        <!--==================== FOOTER ====================-->
            <footer class="footer section">
                <div class="footer__container container grid">
                    <div class="footer__content">
                        <a href="#" class="footer__logo">
                            <img src="assets/img/logo.png" alt="" class="footer__logo-img">
                            Events
                        </a>

                        <p class="footer__description">Enjoy the Moment <br> </p>
                        
                        <div class="footer__social">
                            <a href="https://www.facebook.com/" target="_blank" class="footer__social-link">
                                <i class='bx bxl-facebook'></i>
                            </a>
                            <a href="https://www.instagram.com/" target="_blank" class="footer__social-link">
                                <i class='bx bxl-instagram-alt' ></i>
                            </a>
                            <a href="https://twitter.com/" target="_blank" class="footer__social-link">
                                <i class='bx bxl-twitter' ></i>
                            </a>
                        </div>
                    </div>

                    <div class="footer__content">
                        <h3 class="footer__title">About</h3>
                        
                        <ul class="footer__links">
                            <li>
                                <a href="#" class="footer__link">About Us</a>
                            </li>
                            <li>
                                <a href="#" class="footer__link">Features</a>
                            </li>
                            <li>
                                <a href="#" class="footer__link">News</a>
                            </li>
                        </ul>
                    </div>

                    <!-- <div class="footer__content"> -->
                        <!-- <h3 class="footer__title">Our Services</h3>
                        
                        <ul class="footer__links">
                            <li>
                                <a href="#" class="footer__link">Pricing</a>
                            </li>
                            <li>
                                <a href="#" class="footer__link">Discounts</a>
                            </li>
                            <li>
                                <a href="#" class="footer__link">Shipping mode</a>
                            </li>
                        </ul>
                    </div> -->

                    <!-- <div class="footer__content">
                        <h3 class="footer__title">Our Company</h3>
                        
                        <ul class="footer__links">
                            <li>
                                <a href="#" class="footer__link">Blog</a>
                            </li>
                            <li>
                                <a href="#" class="footer__link">About us</a>
                            </li>
                            <li>
                                <a href="#" class="footer__link">Our mision</a>
                            </li>
                        </ul>
                    </div> -->
                </div>

                <span class="footer__copy">&#169; Bedimcode. All rigths reserved</span>

                <img src="assets/img/footer1-img.png" alt="" class="footer__img-one">
                <img src="assets/img/footer2-img.png" alt="" class="footer__img-two">
            </footer>

            <!--=============== SCROLL UP ===============-->
            <a href="#" class="scrollup" id="scroll-up">
                <i class='bx bx-up-arrow-alt scrollup__icon'></i>
            </a>
        
        <!--=============== SCROLL REVEAL ===============-->
        <script src="assets/js/scrollreveal.min.js"></script>

        <!--=============== SWIPER JS ===============-->
        <script src="assets/js/swiper-bundle.min.js"></script>
        
        <!--=============== MAIN JS ===============-->
        <!-- <script src="assets/js/main.js"></script> -->
           <!--=============== POPUP LOGIC ===============-->
    <div id="login-popup" style="display: none;">
        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5);">
            <div style="position: relative; width: 300px; margin: 100px auto; padding: 20px; background: white; border-radius: 5px; color:black">
                <p>You need to log in to submit an event idea.</p>
               
                <a href="http://localhost:8080/eventMgmt/src/loginsignup/login.php" class="button button--ghost"  style="color:black">Log In</a>
                
                <button id="close-popup" class="button button--ghost" style="color:black ">Close</button>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('login-popup-trigger').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('login-popup').style.display = 'block';
        });

        document.getElementById('close-popup').addEventListener('click', function() {
            document.getElementById('login-popup').style.display = 'none';
        });
    </script>
    <!-- for the team collab navigation bar -->
    <script>
// Show popup when the "Team Collab" button is clicked
document.getElementById('login-popup-triggers').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('login-popups').style.display = 'block';
});

// Close the popup when the "Cancel" button or close icon is clicked
document.getElementById('cancel-btn').addEventListener('click', function() {
    document.getElementById('login-popups').style.display = 'none';
});

document.getElementById('close-popups').addEventListener('click', function() {
    document.getElementById('login-popups').style.display = 'none';
});


        </script>

    </body>
        
</html>