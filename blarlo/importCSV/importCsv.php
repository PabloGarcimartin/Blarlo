<?php

	session_start();
	include_once('../connect/connect.php');
	$database = new Connect();


  if (isset($_POST["load"]) && isset($_FILES["csv"])) {

      $fileName = $_FILES["csv"]["tmp_name"];

      if ($_FILES["csv"]["size"] > 0) {

          $file = fopen($fileName, "r");

          if ($file !== FALSE)
          {
            $i = 0;
            while (($row = fgetcsv($file, 0, ",")) !== FALSE)
            {
              $values = '';
              if( $i > 0 ){ // no cargamos la línea de títulos

                $categoria = $row[1];

                if( $row[0] == '' ){  // si no hay nombre, es una categoría

                  //Check para ver si la categoría ya existe y guardar el id
                  $sql = "SELECT *  FROM categorias WHERE categoria='".$categoria."'";
                  $idCategoria = '';
                  foreach ($database->mbd->query($sql) as $row) {
                    $idCategoria = $row['idCategoria'];
                  }

                  //Si la categoría no existe, la creamos y guardamos el id
                  if( $idCategoria == '' ){
                    $stmt = $database->mbd->prepare("INSERT INTO categorias (categoria) VALUES (:categoria)");
                    // declaración if-else en la ejecución de nuestra declaración preparada
                    $_SESSION['message'] = ( $stmt->execute(array(':categoria' => $categoria )) ) ? 'Categoria agregada correctamente' : 'No se pudo cargar la categoria';

                    if( $_SESSION['message'] == 'Categoria agregada correctamente' ){
                      $idCategoria =  $database->mbd->lastInsertId();
                    }
                  }


                } else if( $row[0] != '' ) { // sino es un producto

                  // echo "INSERT INTO productos (idCategoria, idIdioma, nombre, descripcion, precio, stock, fecha_ultima_venta) VALUES ($idCategoria, ".$_POST['lang'].", $row[1], $row[2], $row[3], $row[4], $row[5])";
                  $stmt = $database->mbd->prepare("INSERT INTO productos (idCategoria, idIdioma, nombre, descripcion, precio, stock, fecha_ultima_venta) VALUES (:idCategoria, :idIdioma, :nombre, :descripcion, :precio, :stock, :fecha_ultima_venta)");
                  // declaración if-else en la ejecución de nuestra declaración preparada
                  $_SESSION['message'] = ( $stmt->execute(array(':idCategoria' => $idCategoria,':idIdioma' => $_POST['lang'],':nombre' => $row[1],':descripcion' => $row[2],':precio' => $row[3], ':stock' => 	$row[4], ':fecha_ultima_venta' => $row[5] )) )
                   ? 'CSV agregado correctamente' : 'No se pudo cargar el csv';
                }

              }
              $i++;
            }

            // Close the file
            fclose($file);
          }


      }
  }

	header('location: ../../index.php');
?>
