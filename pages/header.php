<!--
  - This page is included from index.php. It
  - is a fixed header that displays the Sign In
  - button that leads to the Shibboleth Identity
  - Provider, or the currenly logged in student
  - number (with the option to log out through 
  - logout.php).
  -
  - File: header.php
  - Author: Chris Wright
  - Last updated: 2014/04/14
  - Last updated by: Chris W.
-->

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

