<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dynamic Navbar Background</title>
  <style>
    /* CSS Styling */
    .navbar {
      background-color: transparent;
      transition: background-color 0.3s ease;
      padding-top: 2ch;
      padding-bottom: 2ch;
    }

    .navbar.fixed-top {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
    }

    .navbar.navbar-custom {
      background-color: #333; /* Background color when scrolled */
    }

    .navbar-brand {
      font-size: 2.5ch;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="navbar">
    <a class="navbar-brand p-3" style="letter-spacing: 2px;" href="#page-top">PTPN IV REGIONAL III</a>
    {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button> --}}
    {{-- <div class="collapse navbar-collapse p-3" id="navbarResponsive"> --}}
      {{-- <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" style="letter-spacing: 2px; color:white" href="#!">LOGIN</a></li>
      </ul>
    </div> --}}
</nav>

<script>
  // JavaScript to handle adding/removing custom class on navbar on scroll
  window.addEventListener('scroll', function() {
    var navbar = document.getElementById("navbar");
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if (scrollTop > 50) {
      navbar.classList.add("navbar-custom");
    } else {
      navbar.classList.remove("navbar-custom");
    }
  });
</script>

</body>
</html>
