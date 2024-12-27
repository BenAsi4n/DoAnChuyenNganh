
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="./public/css/footer.css"> -->
     <style>
        /* Footer styles */
footer {
    background-color: #ffffff;
    color: #000000;
  padding: 3rem 0;
}

.footer-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 2rem;
}

.footer-section h3 {
  font-size: 1.2rem;
  margin-bottom: 1rem;
}

.footer-section p,
.footer-section li {
  color: #000000;
}

.footer-section ul {
  list-style: none;
}

.footer-section li {
  margin-bottom: 0.5rem;
}

.footer-bottom {
  text-align: center;
  margin-top: 2rem;
  padding-top: 1rem;
  border-top: 1px solid #555;
}
     </style>
</head>
<body>
<footer>
        <hr style="max-width: 1400px; margin: 0 auto;">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <p>ShopNow is your one-stop destination for all your shopping needs.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>123 Shop Street, City, Country</p>
                    <p>Email: info@shopnow.com</p>
                    <p>Phone: +1 234 567 890</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 ShopNow. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>