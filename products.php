<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products</title>
    <link rel="stylesheet" href="./css/global.css" />

    <!-- Bootstrap CDN's -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg navbar-custom">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Brand</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="products.php">Products</a>
            </li>
          </ul>
          <form class="d-flex">
            <button class="btn btn-outline-light me-2" type="button">
              Login
            </button>
            <button
              class="btn btn-outline-light"
              type="button"
              id="cart-button"
            >
              <a href="cart.php"
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-cart"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 6H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 15H4a.5.5 0 0 1-.491-.408L1.01 2H.5a.5.5 0 0 1-.5-.5zM4.415 14h8.17l1.28-6.875-9.463-.375L4.415 14zm1.63-8l-1-5h7.961l-1 5H6.045z"
                  />
                </svg>
                <span id="cart-count" class="badge bg-danger">0</span></a
              >
            </button>
          </form>
        </div>
      </div>
    </nav>

    <!-- Products List -->
    <div class="container mt-5">
      <h2 class="mb-4">Our Products</h2>
      <div class="row">
        <?php
        // Include your database connection configuration
        include('config.php');

        try {
            // Query to fetch products from the database
            $query = "SELECT * FROM products";
            $stmt = $conn->query($query);

            // Check if there are products in the database
            if ($stmt->rowCount() > 0) {
                // Loop through each row (product) in the result set
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="col-md-4 product">
                        <div class="card">
                            <img
                                src="<?php echo $row['image_url']; ?>"
                                class="card-img-top"
                                alt="<?php echo $row['name']; ?>"
                            />
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <p class="card-text"><?php echo $row['description']; ?></p>
                                <p class="card-text">$<?php echo $row['price']; ?></p>
                                <button
                                    class="btn btn-primary add-to-cart"
                                    data-name="<?php echo $row['name']; ?>"
                                    data-price="<?php echo $row['price']; ?>"
                                >
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No products found</p>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Close the database connection
        $conn = null;
        ?>
    </div>

    </div>

    <!-- Footer -->
    <div class="footer mt-5">
      <p>&copy; 2024 Brand. All rights reserved.</p>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.add-to-cart').forEach((button) => {
          button.addEventListener('click', function () {
            let name = this.getAttribute('data-name');
            let price = parseFloat(this.getAttribute('data-price'));
            let image = this.closest('.card').querySelector('img').src;
            let description =
              this.closest('.card').querySelector('.card-text').innerText;

            let item = { name, price, image, description };

            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push(item);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            alert('Item added to cart');
          });
        });

        function updateCartCount() {
          let cart = JSON.parse(localStorage.getItem('cart')) || [];
          document.getElementById('cart-count').innerText = cart.length;
        }
        updateCartCount();
      });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
