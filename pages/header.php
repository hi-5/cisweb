<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">

    <!-- cis & uofl logo -->
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">
        <img src="images/cis.png" />
      </a>
    </div>

    <?php
      if ( $_SESSION['loggedIn'] ) {
    ?>

      <!-- show user name and logout button if logged in -->
      <p class="navbar-text navbar-right">Signed in as <?php echo $_SESSION['studentId'];?> (<a href="php/logout.php">logout</a>)</p>

    <?php
      } else {
    ?>

      <!-- show login button if logged out -->
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#">Sign In</a></li>
        </ul>
      </div>

    <?php
      }
    ?>
    
  </div>
</div>

