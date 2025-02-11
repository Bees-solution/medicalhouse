 <!-- Top Header -->
 <div class="top-header">
    <!-- Left: Contact Info -->
    <div class="left">
        <p class="subtext uppercase text-gray-400 text-sm font-bold">CONTACT US</p>
        <p class="contact text-blue-600 font-bold text-lg">+1 (800) 450 7550</p>
    </div>

    <!-- Center: Logo -->
    <div class="center flex flex-col items-center">
        <img src="/images/logo.jpg" alt="Logo" class="h-16 md:h-20">
        <p class="clinic-name text-blue-700 font-bold text-lg">SHANTHI <span class="text-blue-400">MEDICAL HOME</span></p>
    </div>

    <!-- Right: Online Consultation -->
    <div class="right">
        <p class="subtext">ONLINE CONSULTATION</p>
        <p class="email">SHANTHI@GMAIL.COM</p>
    </div>
</div>

<!-- Mobile Menu Button -->
<button id="menuToggle" class="mobile-menu-btn">☰</button>

<!-- Sticky Navigation Bar -->
<nav id="mobileMenu" class="nav-menu">
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ url('/pharmacy') }}">Pharmacy</a>
    <a href="{{ url('/channeling') }}">Channeling</a>
    <a href="{{ url('/laboratory') }}">Laboratory</a>
    <a href="{{ url('/about') }}">About Us</a>
    <a href="{{ url('/contact') }}">Contact Us</a>
</nav>


<script>
    // Toggle Mobile Menu
    document.getElementById('menuToggle').addEventListener('click', function () {
        let menu = document.getElementById('mobileMenu');
        menu.classList.toggle('open');
    });

</script>

