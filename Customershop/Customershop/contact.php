<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact page</title>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />

        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    </head>

    <body>

    <section id="header">
            <a href="#"><img src="img/logo.png" alt="" height="75px" class ="round-img"></a>

            <div>
                <ul id="navbar">
                    <li><a  href="home.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a class= "active" href="contact.php">Contact</a></li>
                    <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></i></a></li>
                    <li><a href="index.php"><i class="fa-solid fa-user"></i></a></li>
                </ul>
            </div>

            <style>
                .round-img {
                    border-radius : 10px;               
                 }
            </style>

        </section>

        <section id="c-header" class="about-header">
            
          <h2>#let's_talk</h2>
          <p>LEAVE A MESSAGE, We love to hear from you!</p>
         
      </section>

      <section id="contact-details" class="section-p1">
        <div class="details">
          <span>GET IN TOUCH</span>
          <h2>Visit one of our agency locations or contact us today</h2>
          <h3>Head Office</h3>
          <div>
            
            <li>
              <i class="far fa-envelope"></i>
              <p>No.293/10,Dikwela Road,Siyambalape</p>
            </li>
            <li>
              <i class="fas fa-phone-alt"></i>
              <p>0714411044 / 0714202806</p>
            </li>
            <li>
            <i class="fa-solid fa-envelope"></i>
              <p>dilfashionlanka@gmail.com</p>
            </li>
          </div>
        </div>

        <div class="map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.2743084054764!2d79.98618470000002!3d6.976926700000017!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae256229e9c1967%3A0xd13074367d2a588d!2s293%2C%2010%20Dikwela%20Rd%2C%2011607!5e0!3m2!1sen!2slk!4v1714468335173!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="yes" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        </div>
      </section>

      <section id="form-details">
        <form id = "contactform" method ="post" action = "submit_contact.php" >
          <span>LEAVE A MESSAGE</span>
          <h2>We love to hear from you!</h2>
          <input type="text" name = "name"  placeholder="Your Name" required>
          <input type="text" name = "email" placeholder="Your Email" required>
          <input type="text" placeholder="Subject">
          <textarea name="message" id="" cols="30" rows="10" placeholder="Your Message"></textarea>
          <button class="normal" type="submit">Submit</button>
        </form>

        <div class="people">
          <div>
            <img src="product_images/malindu.jpg" alt="">
            <p><span>Malindu Ekanayaka</span>Senior developer <br> Phone: +94 71 420 2806 <br> Email: imalka@gmail.com </p>

          </div>
          <div>
            <img src="product_images/kenura.jpg" alt="">
            <p><span>Kenura Ransidu</span>Senior developer <br> Phone: 0715841849 <br> Email: kenurar@gmail.com </p>

          </div>
          <div>
            <img src="product_images/chanuka.jpg" alt="">
            <p><span>Chanuka Dissanayaka</span>Senior developer <br> Phone: 0713925252 <br> Email: chanuka@gmail.com </p>

          </div>
          <div>
            <img src="product_images/mihiri.jpg" alt="">
            <p><span>Mihiri Karunanayaka</span>Senior developer <br> Phone: 0755880055 <br> Email: mihiri@gmail.com </p>

          </div>
        </div>
      </section>

        <section id="newsletter" class="section-p1 section-m1">
          <div class="newstext">
              <h4>Sign Up For Newsletters</h4>
              <p>Get E-mail updates about our latest shop and <span>special offers.</span></p>
          </div>
          <div class="form">
              <input type="text" placeholder="Your E-mail address">
              <button class="normal">Sign Up</button>
          </div>
      </section>



      <footer class="section-p1">
            <div class="col">
                <img class="logo"src="img/logo.png" height="75px" alt="">
                <h4>Contact</h4>
                <p><strong>Address : 293/10,Dikwela Road,Siyambalape</strong></p>
                <p><strong>Phone : 0714411044</strong></p>
                <p><strong>Working Hours : 8AM - 5PM</strong></p>
                <div class="follow">
                    <h4>Follow Us</h4>
                    <div class="icon">
                        <i class="fab fa-facebook-f"></i>
                        <i class="fab fa-instagram"></i>
                    </div>
                </div>
            </div>

            <div class="col">
                <h4>About</h4>
                <a href="#">About Us</a>
                <a href="#">Delivery Information</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms & Conditions</a>
                <a href="#">Contact Us</a>
            </div>

            <div class="col">
                <h4>My Account</h4>
                <a href="#">Sign In</a>
                <a href="#">View cart</a>
                <a href="#">My Wishlist</a>
                <a href="#">Track My Order</a>
                <a href="#">Help</a>
            </div>

            <div class="col install">
                <p>Secured Payment Gateways</p>
                <img src="img/pay/pay.png" alt="">
            </div>

            <div class="copyright">
                <p>2024, DilFashion etc</p>
            </div>

        </footer>


        <script>
          document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var name = document.getElementById('name').value.trim();
    var email = document.getElementById('email').value.trim();
    var message = document.getElementById('message').value.trim();

    if (name === '' || email === '' || message === '') {
        alert('Please fill out all fields.');
        return;
    }

   
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Please enter a valid email address.');
        return;
    }

    this.submit();
});

    </script>
    



        
    </body>

</html>
</html>