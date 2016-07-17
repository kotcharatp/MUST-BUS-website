
<div align="right">
  <nav class="navbar navbar-inverse" role="navigation">
    <?php if($uid == false): ?>
      <button class="btn btn-primary" align = "right" type="button" onclick="location.href = '../login.php'">Sign In</button>
    <?php endif ?>


    <?php if($uid == true): ?>
      <button class="btn btn-danger" type="button" onclick="location.href = '../includes/logout.inc.php'">Sign Out</button>
    <?php endif ?>

  </nav>
</div>
<div>
  <div>
    <img src="../Header1.jpg" id="imglogo" align="left" style="width:103%; height: 5%; margin-left: -3%; margin-top: -3%; margin-bottom: 2%">    
  </div> 
  <div id="logotxt">
    <!-- <h1 style="font-family:verdana;" align="left">MUST BUS</h1> -->
    <!-- <h4 style="font-family:verdana; color: white;" align="center">IT IS A MUST FOR US - SUPPORT ANDROID APPLICATION AND WEBSITE</h4> -->
    <div align="right">
                  <!-- <button class="btn btn-primary" type="button" onclick="location.href = '../login.php'">Admin Login</button>
                  <button class="btn btn-danger" type="button" onclick="location.href = '../includes/logout.inc.php'">Logout</button> -->
                </div>
              </div>
            </div>


