<?php
error_reporting(0);
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$isLoggedIn = isset($_SESSION['login']) && $_SESSION['login'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- <link rel="stylesheet" href="./public/css/header.css"> -->
    <style>
        /* Header styles */
    header {
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    header .container {
        min-height: 65px;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 0;
    }
    
    .logo {
      font-size: 1.5rem;
      font-weight: bold;
    }
    
    .nav-links {
      display: flex;
      list-style: none;
      align-items: center;
      justify-content: center;
      flex-grow: 1;
    }
    a {
    text-decoration: none;
    color: inherit;
  }

    .nav-links > li {
      position: relative;
      margin: 0 1rem;
    }
    
    .nav-links > li > a {
      display: block;
      padding: 0.5rem 1rem;
    }
    
    .nav-links a:hover {
      color: #141616;
      text-decoration: underline;
      text-decoration-thickness: 0.5px;
      text-underline-offset: 6px;
    }
    
    .submenu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: #000000c6;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      min-width: 200px;
      z-index: 1000;
    }
    
    .nav-links > li:hover .submenu {
      display: block;
    }
    
    .submenu li {
      list-style: none;
    }
    
    .submenu a {
      display: block;
      padding: 0.5rem 1rem;
      color: #fff;
    }
    
    .submenu a:hover {
      background-color: #f8f9fa;
    }
    
    .nav-right {
      display: flex;
      align-items: center;
    }
    
    
    .icon-button {
      background: none;
      border: none;
      font-size: 1.2rem;
      cursor: pointer;
      color: #333;
      transition: color 0.3s ease;
      margin-left: 1rem;
    }
    
    .icon-button:hover {
      color: #007bff;
    }
    .dropdown {
      position: relative;
      display: inline-block;
  }

  .dropdown-menu {
      display: none;
      position: absolute;
      left: 0;
      top: 22px;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
      z-index: 1000;
      border-radius: 5px;
      overflow: hidden;
      min-width: 200px;
  }

  .dropdown-menu a {
      display: block;
      padding: 10px;
      text-decoration: none;
      color: #333;
      font-size: 0.9rem;
  }

  .dropdown-menu a:hover {
      background-color: #f1f1f1;
  }

  .user-icon:hover + .dropdown-menu, 
  .dropdown-menu:hover {
      display: block;
  }
  .search-container {
    position: relative;
    display: flex;
    align-items: center;
    margin-right: 1rem;
}

.search-container input {
    padding: 0.5rem 2.5rem 0.5rem 0.5rem;
    border: 1px solid #ccc;
    border-radius: 15px;
    width: 100%;
    max-width: 300px; /* Giới hạn chiều rộng */
    box-sizing: border-box;
}

.search-container button {
    position: absolute;
    right: 10px; /* Điều chỉnh vị trí nút tìm kiếm */
    top: 50%;
    transform: translateY(-50%);
    color: #333;
    font-size: 1rem;
    background: none;
    border: none;
    cursor: pointer;
}

.search-suggestions {
    position: absolute;
    top: calc(100% + 5px); /* Hiển thị ngay bên dưới input */
    left: 0;
    right: 0;
    width: 400px;
    background: white;
    border: 1px solid #ccc;
    border-radius: 0 0 8px 8px;
    max-height: 500px;
    overflow-y: auto;
    list-style: none;
    padding: 0;
    margin: 0;
    z-index: 1000;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Thêm hiệu ứng đổ bóng */
}

.search-suggestions li {
    padding: 10px;
    cursor: pointer;
    font-size: 0.9rem;
}

.search-suggestions li:hover {
    background: #f1f1f1;
}

    </style>
</head>
<body>
<header>
  <nav class="container">
      <div class="logo">
          <a href="index.php">DirtyXu</a>
      </div>
      <ul class="nav-links">
          <li>
              <a href="index.php">Home</a>
          </li>
          <li>
              <a href="#" aria-haspopup="true">Products</a>
              <ul class="submenu">
                  <li><a href="index.php?maloai=3">Áo</a></li>
                  <li><a href="index.php?maloai=2">Quần</a></li>
                  <li><a href="index.php?maloai=4">Áo khoác</a></li>
              </ul>
          </li>
         
          <li>
              <a href="#" aria-haspopup="true">Contact</a>
              <ul class="submenu">
                  <li><a href="#">Customer Support</a></li>
                  <li><a href="#">Store Locations</a></li>
                  <li><a href="#">Feedback</a></li>
                  <li><a href="#">Partnerships</a></li>
              </ul>
          </li>
      </ul>
      <div class="nav-right">
        <div class="search-container">
            <div class="search-container">
              <input type="text" id="search-input" placeholder="Search..." aria-label="Search">
              <button class="icon-button" aria-label="Search">
                  <i class="fas fa-search"></i>
              </button>
              <ul id="search-suggestions" class="search-suggestions"></ul>
            </div>

        </div>
        <button class="icon-button" aria-label="Shopping Cart" onclick="location.href='./cart.php'">
            <i class="fas fa-shopping-cart"></i>
        </button>
        
            <div class="dropdown">
                <button class="icon-button user-icon" aria-label="User Account">
                    <i class="fas fa-user"></i>
                </button>
                <?php if ($isLoggedIn): ?>
                <div class="dropdown-menu">
                    <a href="./my_orders.php">Thông tin người dùng</a>
                    <a href="./public/modules/login/logout.php">Đăng xuất</a>
                </div>
            </div>
            <span style="margin-left: 1rem;">
                Hello, <?= isset($_SESSION['hoten']) ? htmlspecialchars($_SESSION['hoten']) : "User"; ?>!
            </span>
        <?php else: ?>
            <button class="icon-button" id="login-button" onclick="location.href='./public/modules/login/login.php'">Đăng nhập</button>
        <?php endif; ?>
      </div>

  </nav>
</header>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const userIcon = document.querySelector(".user-icon");
    const dropdownMenu = document.querySelector(".dropdown-menu");

    userIcon.addEventListener("click", function (e) {
      e.stopPropagation();
      dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
    });

    document.addEventListener("click", function () {
      if (dropdownMenu.style.display === "block") {
          dropdownMenu.style.display = "none";
      }
    });

  const searchInput = document.getElementById('search-input');
    const searchSuggestions = document.getElementById('search-suggestions');

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();

        if (query.length > 0) {
            fetch(`search.php?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    searchSuggestions.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(product => {
                            const li = document.createElement('li');
                            
                            // Tạo thẻ <a> để bao quanh toàn bộ nội dung của mỗi item
                            const a = document.createElement('a');
                            a.href = `product_detail.php?masp=${product.masp}`;
                            a.classList.add('product-suggestion');
                            a.style.display = 'block'; // Đảm bảo <a> chiếm toàn bộ chiều rộng của <li>

                            // Cấu trúc nội dung trong mỗi item (bao gồm hình ảnh và tên sản phẩm)
                            a.innerHTML = `
                                <div style="display: flex; align-items: center;">
                                    <img src="${product.hinh}" alt="${product.tensp}" width="50" style="margin-right: 10px;">
                                    <span>${product.tensp}</span>
                                </div>
                            `;
                            li.appendChild(a);
                            searchSuggestions.appendChild(li);
                        });
                    } else {
                        searchSuggestions.innerHTML = '<li>No products found</li>';
                    }
                });
        } else {
            searchSuggestions.innerHTML = '';
        }
    });

});



</script>
</body>
</html>
