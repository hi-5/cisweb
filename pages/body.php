<br /><br /><br /><br />

<div id="wrapper">

  <?php
    if ( $_SESSION['loggedIn'] ) {
  ?>

    <div class="row">

      <!-- user menu -->
      <div class="col-md-2">

        <?php
          include 'pages/menu.php';
        ?>

      </div>

      <!-- page content -->
      <div class="col-md-10">

        <?php
          if ( isset($_GET['p']) ) {
            switch ( $_GET['p'] ) {
              case 'regi' : $file = 'register.php'; break;
              case 'veri' : $file = 'verify.php';   break;
              case 'reqs' : $file = 'requests.php'; break;       
              case 'sett' : $file = 'settings.php'; break;  
            }
          } else {
            $file = 'home.php';
          }
          include 'pages/' . $file;
        ?>

      </div>
    </div>

  <?php
    } else {
      include 'pages/home.php';
    }
  ?>
  
</div>