<!DOCTYPE html>
<?php
	session_start();
	include_once('blarlo/connect/connect.php');
	$database = new Connect();

	$_SESSION['lang'] = '1';
?>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Blarlo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
     integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
  </head>
  <body>

    <nav class="navbar navbar-dark bg-dark">
      <span class="navbar-brand mb-0 h1">BLARLO</span>
		</nav>

    </br>

    <div class="content container">
			<div class="row">
				<form method="post" name="loadCSVForm" id="loadCSVForm" enctype="multipart/form-data" action="blarlo/importCSV/importCsv.php">
					<div class="form-group">
						<label for="csv">Carga tu CSV</label>
						<input type="file" class="form-control-file" name="csv" id="csv" accept=".csv">
					</div>
					<button type="submit" id="submit" name="load" class="btn btn-outline-primary">Cargar</button>
					<img src="img/es.png" class="img-fluid pull-xs-left" alt="Español" placeholder="Español"><input type="radio" name="lang" value="1" checked>
					<img src="img/en.png" class="img-fluid pull-xs-left" alt="Español" placeholder="Inglés"><input type="radio" name="lang" value="2">
					<img src="img/fr.png" class="img-fluid pull-xs-left" alt="Español" placeholder="Francés"><input type="radio" name="lang" value="3">
				</form>
			</div>
      </br>

			<!-- TABLA DE CATEGORIAS -->
      <div class="table-responsive">
        <table id='categoriesTable' class="table">
          <thead class="thead-dark">
            <tr>
              <th>ID Categoría</th>
							<th>Categoría</th>
              <th>Productos</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT c.idCategoria, c.categoria, count( distinct p.idProducto ) as productos FROM categorias c
										LEFT JOIN productos p ON p.idCategoria = c.idCategoria
										GROUP BY c.idCategoria";
            foreach ($database->mbd->query($sql) as $row) {
              ?>
              <tr>
                <td scope="row"><?php  echo $row['idCategoria']; ?></td>
                <td><?php  echo $row['categoria']; ?></td>
                <td><?php  echo $row['productos']; ?></td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>

			<!-- TABLA DE IDIOMAS -->
      <div class="table-responsive">
        <table id='langTable' class="table">
          <thead class="thead-dark">
            <tr>
              <th>ID Idioma</th>
							<th>Idioma</th>
              <th>Productos</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT i.idIdioma, i.idioma, count( distinct p.idProducto ) as productos FROM idiomas i
										LEFT JOIN productos p ON p.idIdioma = i.idIdioma
										GROUP BY i.idIdioma";
            foreach ($database->mbd->query($sql) as $row) {
              ?>
              <tr>
                <td scope="row"><?php  echo $row['idIdioma']; ?></td>
                <td><?php  echo $row['idioma']; ?></td>
                <td><?php  echo $row['productos']; ?></td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>

			<!-- TABLA DE PRODUCTOS -->
      <div class="table-responsive">
        <table id='productsTable' class="table">
          <thead class="thead-dark">
            <tr>
              <th>Product ID</th>
							<th>Idioma</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Categoría</th>
              <th>Precio</th>
              <th>Stock</th>
              <th>Fecha Última Venta</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT p.*, c.categoria, i.idioma  FROM productos p
										LEFT JOIN categorias c ON p.idCategoria = c.idCategoria
						        LEFT JOIN idiomas i ON p.idIdioma = i.idIdioma";
            foreach ($database->mbd->query($sql) as $row) {
              ?>
              <tr>
                <td scope="row"><?php  echo $row['idProducto']; ?></td>
                <td><?php  echo $row['idioma']; ?></td>
                <td><?php  echo $row['nombre']; ?></td>
                <td><?php  echo $row['descripcion']; ?></td>
                <td><?php  echo $row['categoria']; ?></td>
                <td><?php  echo $row['precio']; ?></td>
                <td><?php  echo $row['stock']; ?></td>
                <td><?php  echo $row['fecha_ultima_venta']; ?></td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- <canvas id="canvasExplore" width="300" height="300"></canvas> -->
    <script src="https://use.fontawesome.com/983d42deda.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript" type="module" src="js/index.js"></script>
  </body>
</html>
