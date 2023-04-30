<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CRUD NIVEL</title>

        <link rel="stylesheet" href="../CSS/HeaderFooterStructure.css">
        <link rel="stylesheet" href="../CSS/galeria.css">
	</head>


    <header>
    <img class="Logo__EscNegCie" src="../media/logotec-ings.svg" alt="Logo__EscNegCie">
    <ul>
      <li>
        <a href="#">Layout Proyectos</a>
      </li>
    </ul>
    <nav>
      <ul>
        <li><a href="#">Cerrar Sesión</a></li>
      </ul>
    </nav>
  </header>
    <br>
    <br>
    <br>
	<body>
	    <div class="proyecto">

    		<div class="row">
    			<h3>Nivel Expo Ingenierias</h3>
    		</div>

				<div class="row">
					<p>
						<a href="createNivel.php" class="btn btn-success">Agregar un nivel</a>
					</p>

				<table class="table table-striped table-bordered">
	            <thead>
	                <tr>
	                	<th >ID	</th>
	                	<th>NOMBRE				</th>
	                  <!--<th>A/C 					</th> -->
	                </tr>
	            </thead>
                <br>
                <br>
	            <tbody>
	              	<?php
								   	include 'database.php';
								   	$pdo = Database::connect();
								   	$sql = 'SELECT * FROM NIVEL ORDER BY n_nombre';
				 				   	foreach ($pdo->query($sql) as $row) {
											echo '<tr>';
			    					   	echo '<td>'. $row['n_id'] . '</td>';
			    					  	echo '<td>'. $row['n_nombre'] . '</td>';
			                            //echo '<td>';    echo ($row['ac'])?"SI":"NO"; echo'</td>';
			                            echo '<td width=250>';
			    					   	echo '<a class="btn" href="readNivel.php?id='.$row['n_id'].'">Detalles</a>';
			    					   	echo '&nbsp;';
			    					  	echo '<a class="btn btn-success" href="updateNivel.php?id='.$row['n_id'].'">Actualizar</a>';
			    					   	echo '&nbsp;';
			    					   	echo '<a class="btn btn-danger" href="deleteNivel.php?id='.$row['n_id'].'">Eliminar</a>';
			    					   	echo '</td>';
										  echo '</tr>';
								    }
								   	Database::disconnect();
				  				?>
			    		</tbody>
		      </table>

		    </div>

	    </div> <!-- /container -->
        <br>
        <br>
        <br>
        <br>
        <br>
        <footer>
        <img class="Logo__Tec" src="../media/LogoTec.png" alt="Logo TEC">
        </footer>
	</body>
</html>