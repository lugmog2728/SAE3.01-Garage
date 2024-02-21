<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
      <link rel="stylesheet" href="/Style/style.css">
      <!-- Fontawesome version : 6.2.0 -->
      <script src="https://kit.fontawesome.com/9f4e11af91.js" crossorigin="anonymous"></script>
  </head>
  <!-- Header/Nav (Same on all pages but not in connexion) -->
  <header>
    <?php
      require "header.php";
      createHeader();
    ?>
  </header>
  <body>
    <br>
    <!-- Main (that's where the code is modified) -->
    <main>
      <table class="table table-striped">
        <thead class="table-dark">
          <tr>
            <th scope="col">Libelle</th>
            <th scope="col">Code Produit</th>
            <th scope="col">Quantité</th>
            <th scope="col">Prix</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td colspan="2">Larry the Bird</td>
            <td>@twitter</td>
          </tr>
        </tbody>
      </table>
    </main>
  </body>
  <!-- Same on all pages -->
  <?php
    require "footer.php";
    createFooter();
  ?>
</html>