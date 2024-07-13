
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ZKTECO</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  
</head>

<body>
  <main>
    <!-- Header Start -->
    <header>
      <nav class="nav container">
        <h2 class="nav_logo">
          <a href="index.html">
            <!-- <img src="images/in-web.jpg" alt="Logo" width="220px"> -->
            ZKTECO
          </a>
        </h2>

        <ul class="menu_items">
          <img src="{{ asset('images/times.svg') }}" alt="timesicon" id="menu_toggle" />
          <li><a href="/presence_employes" class="">Présence</a></li>
          <li class="nav_item">
            <a href="/action_test_zkteco" class="">Action</a>
            <ul class="dropdown_menu">
              <li><a href="/action_test_zkteco/restart">Redémarrer</a></li>
              <li><a href="/action_test_zkteco/alarm">Alarme</a></li>
              <li><a href="/action_test_zkteco/shutdown">Éteindre</a></li>
            </ul>
          </li>
        
        </ul>
        <img src="{{ asset('images/bars.svg') }}" alt="timesicon" id="menu_toggle" />
      </nav>
    </header>
    
    <section class="hero">
      <div class="row container">
        <div class="column">
          <h2>Bienvenue sur la plateforme<br/>de gestion de présence</h2>
          <p>
           Contrôlez facilement la présence de vos employés au service. 
          </p> <br>
          <div class="buttons">
            <a href="connexion.html">
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                            <a href="/getAttendance" class="btn btn-primary rounded-pill" >Gestion presence</a>
                    </div>
            </a>
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
              <a href="/addUser" class="btn btn-primary rounded-pill" >Ajouter un employé</a>
              
           </div>
          </div>
        </div>
        <div class="column">
          <img src="{{ asset('images/zkteco.png') }}" alt="heroImg" class="hero_img" />
        </div>
      </div>
      <img src="{{ asset('images/bg-bottom-hero.png') }}" alt="" class="curveImg" />
    </section>
    <!-- Hero End-->
  </main>

  <script>
    const header = document.querySelector("header");
    const menuToggler = document.querySelectorAll("#menu_toggle");

    menuToggler.forEach(toggler => {
      toggler.addEventListener("click", () => header.classList.toggle("showMenu"));
    });
  </script>
</body>

</html>
