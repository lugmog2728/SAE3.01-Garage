<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
      <link rel="stylesheet" href="../Style/style.css">
      <!-- Fontawesome version : 6.2.0 -->
      <script src="https://kit.fontawesome.com/9f4e11af91.js" crossorigin="anonymous"></script>
  </head>
  <!-- Header/Nav (Same on all pages but not in connexion) -->
  <?php
    require "../autoload.php";
    //DEBUG DISPLAY
    ini_set('display_errors', 'stderr');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL); 
  ?>
  <body>
    <br>
    <!-- Main (that's where the code is modified) -->
    <main>
        <div id="loginbox">
            <div id="log">
                <!-- Login Form -->
                <form method="POST" onsubmit="return gotoa()">
                <input type="text" id="login" name="login" placeholder="login">
                <input type="text" id="password"  name="password" placeholder="password">
                <input type="submit" value="Log In">
                </form>
            </div>
        </div>
    </main>
    <script>
      function gotoa() {
        console.log("aaaa")
        window.location.href = "http://localhost:3000/Structure/accueil.php";
      }
    </script>
  </body>
  <!-- Same on all pages -->
  <?php
    require "footer.php";
    createFooter();
  ?>
</html>