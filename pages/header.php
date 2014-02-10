<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">
        <img src="images/cis.png" />
      </a>
    </div>


    <?php
      if ( $_SESSION['loggedIn'] ) {
    ?>
      <!-- show currently logged in user -->
      <p class="navbar-text navbar-right">Signed in as <?php echo $_SESSION['username'];?> (<a href="php/logout.php">logout</a>)</p>

    <?php
      } else {
    ?>
      <!-- show login boxes if not already logged in -->
      <div class="navbar-collapse collapse">
        <form class="navbar-form navbar-right" role="form" method="post" action="php/login.php">
          <div class="form-group">
            <input type="text" name="name" placeholder="Username" class="form-control">
          </div>
          <div class="form-group">
            <input type="password" name="pass" placeholder="Password" class="form-control">
          </div>
          <button class="btn btn-success" type="submit">Sign in</button>
        </form>
      </div>
    <?php
      }
    ?>
    
  </div>
</div>

