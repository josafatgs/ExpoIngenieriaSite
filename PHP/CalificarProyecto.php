<?php

	require_once 'dataBase.php';

	session_name("EngineerXpoWeb");
	session_start();

	if (!isset($_SESSION['logged_in'])) {
		header("Location: ../index.php");
		exit();
	}

	$id = null;
	
	$p1 = null; $p2 = null; $p3 = null; $p4 = null; $p5 = null;

	if (!empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// keep track validation errors
		$p1Error   = null;
		$p2Error   = null;
		$p3Error   = null;
		$p4Error   = null;
		$p5Error   = null;

		// keep track post values
		$id = $_POST['id'];
		$p1 = $_POST['p_1'];
		$p2 = $_POST['p_2'];
		$p3 = $_POST['p_3'];
		$p4 = $_POST['p_4'];
		$p5 = $_POST['p_5'];

		/// validate input
		$valid = true;

		if (empty($p1)) {
			$p1Error = 'Por favor complete este campo';
			$valid = false;
		}

		if (empty($p2)) {
			$p2Error = 'Por favor complete este campo';
			$valid = false;
		}

		if (empty($p3)) {
			$p3Error = 'Por favor complete este campo';
			$valid = false;
		}

		if (empty($p4)) {
			$p4Error = 'Por favor complete este campo';
			$valid = false;
		}

		if (empty($p5)) {
			$p5Error = 'Por favor complete este campo';
			$valid = false;
		}

		// update data
		if ($valid) {
			$user_id = $_SESSION['id'];
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT * 
			        FROM EVALUACION 
			        WHERE co_correo = ? AND p_id = ?';
			$q = $pdo->prepare($sql);
			$q->execute(array($user_id, $id));
			$evaluacion = $q->fetch(PDO::FETCH_ASSOC);
			$number_of_evaluations = $q->rowCount();
			if ($number_of_evaluations != 0) {
				$sql = 'UPDATE EVALUACION 
						SET 
							ev_criterio_1 = ?,
							ev_criterio_2 = ?,
							ev_criterio_3 = ?,
							ev_criterio_4 = ?,
							ev_criterio_5 = ?
				        WHERE co_correo = ? AND p_id = ?';
				$q = $pdo->prepare($sql);
				$q->execute(array($p1, $p2, $p3, $p4, $p5, $user_id, $id));
				Database::disconnect();
				header("Location: CalificarProyecto.php?id=$id");
				exit();
			}
			Database::disconnect();

			//Datos Alumnos
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT * 
					FROM PROYECTO_ALUMNO 
					NATURAL JOIN ALUMNO 
					WHERE p_id = ?';
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$alumno = $q->fetchAll(PDO::FETCH_ASSOC);

			/*$q = $pdo->prepare($sql);
			$acq = ($ac=="S")?1:0;
			$q->execute(array($id,$subm,$marc,$acq, $id));
			Database::disconnect();

			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE auto  set idauto = ?, nombrec = ?, idmarca =?, ac= ? WHERE idauto = ?";
			$q = $pdo->prepare($sql);
			$acq = ($ac=="S")?1:0;
			$q->execute(array($id,$subm,$marc,$acq, $id));
			Database::disconnect();
			header("Location: index.php");
			*/
		}
		else {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT * 
			        FROM PROYECTO 
			        NATURAL JOIN CATEGORIA 
			        WHERE p_id = ?';
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$project = $q->fetch(PDO::FETCH_ASSOC);
			Database::disconnect();

			//Datos Alumnos
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT * 
					FROM PROYECTO_ALUMNO 
					NATURAL JOIN ALUMNO 
					WHERE p_id = ?';
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$alumno = $q->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	else {
		if ($id == null) {
			// Dependiendo del tipo de usuario es la ruta a la que se enviará
			// Pagina anterior alojada en la sesion
			header("Location: ProyectosACalificar.php");
			exit();
		}

		// Obtener datos del proyecto
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = 'SELECT * 
		        FROM PROYECTO 
		        NATURAL JOIN CATEGORIA 
		        WHERE p_id = ?';
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$project = $q->fetch(PDO::FETCH_ASSOC);

		//Datos Alumnos
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = 'SELECT * 
		        FROM PROYECTO_ALUMNO 
		        NATURAL JOIN ALUMNO 
		        WHERE p_id = ?';
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$alumno = $q->fetchAll(PDO::FETCH_ASSOC);

		// Obtener datos de la evaluación
		// del docente sobre proyecto
		$user_id = $_SESSION['id']; // Cambiar para el id del usuario en la sesión
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = 'SELECT * 
		        FROM EVALUACION 
		        WHERE co_correo = ? AND p_id = ?';
		$q = $pdo->prepare($sql);
		$q->execute(array($user_id, $id));
		$evaluation = $q->fetch(PDO::FETCH_ASSOC);
		$number_of_evaluations = $q->rowCount();

		if ($number_of_evaluations != 0) {
			$p1 = $evaluation['ev_criterio_1'];
			$p2 = $evaluation['ev_criterio_2'];
			$p3 = $evaluation['ev_criterio_3'];
			$p4 = $evaluation['ev_criterio_4'];
			$p5 = $evaluation['ev_criterio_5'];
		}


		Database::disconnect();

		// Aquí irá el chequeo del login del usuario para obtener el registro de su calificacion
		// sobre el proyecto (si no hay una calificacion de este jurado para el proyecto, no
		// se modifica nada del formulario, en caso contrario, se crearan variables con el puntaje de
		// cada uno de los criterios y posteriormente se asignará a los radio buttons)
		//$id = $project['p_id'];
		//$subm = $project['nombrec'];
		//$marc = $project['idmarca'];
		#$ac   = ($project['ac'])?"S":"N";
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/ico" href="../media/favicon.ico"/>
		<title>Calificar proyecto | EngineerXpoWeb</title>

		<link rel="stylesheet" href="../CSS/estructuraProyecto.css">
		<link rel="stylesheet" href="../CSS/HeaderFooterStructure.css">
		<link rel="stylesheet" href="../CSS/CalificarProyectoView.css">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
	</head>
	<body>
		<header>
            <a href="../index.php"><img class="Logo__Expo" src="../media/logo-expo.svg" alt="Logotipo de Expo ingenierías"></a>
            <ul>
				<li><a href="../PHP/DashboardColaboradoresJurado.php">Dashboard</a></li>
                <li><a href="../PHP/Mapa.php">Mapa de proyectos</a></li>
            </ul>
            <nav>
                <ul>
                    <li><a href="../PHP/logout.php">Cerrar Sesion</a></li>
                </ul>
            </nav>
        </header>

	    <main>
	    	<div class="container">
				<div class="row">
					<div class="col-md-6 text-center">
						<iframe
							width="80%";
							height="50%";
								<?php
								preg_match('/^https:\/\/drive.google.com\/file\/d\/(.*?)\/view\?usp=sharing/', $project['p_video'], $match);
								$video_id = $match[1];
								$video_full_link = "https://drive.google.com/file/d/".$video_id."/preview";
								echo 'src="'.$video_full_link.'" title="YouTube video player" frameborder="0" allow="accelerometer"; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share allowfullscreen';
								?>
						></iframe>
						<iframe
							width="80%";
							height="100%";
								<?php
								preg_match('/^https:\/\/drive.google.com\/file\/d\/(.*?)\/view\?usp=sharing/', $project['p_poster'], $match);
								$image_id = $match[1];
								$image_full_link = "https://drive.google.com/file/d/".$image_id."/preview";
								echo 'src="'.$image_full_link.'" allow="autoplay"';
								?>
						></iframe>
					</div>
					<div class="col-md-6">
						<?php
							// Aquí va el código PHP para obtener la información del proyecto
							$project_name = $project['p_nombre'];
							$category = $project['ca_nombre'];
							$level = $project['n_nombre'];
							$description = $project['p_descripcion'];
							$edition = $project['ed_nombre'];
							$status = $project['p_estado'];
							$students = $alumno;

							// Imprime la información del proyecto
							echo "<h2>$project_name</h2>";
							echo "<h3>Edicion: </h3> <p>$edition</p>";
							echo "<h3>Estado: </h3> <p>$status</p>";
							echo "<h3>Categoría: </h3> <p>$category</p>";
							echo "<h3>Nivel: </h3><p>$level</p>";
							echo "<h3>Descripcion: </h3> <p>$description</p>";
							echo "<h3>Alumnos:</h3>";
							echo "<ol>";
							foreach ($students as $student) {
								echo "<li>".$student['a_nombre']." ".$student['a_apellido']."</li>";
							}
							echo "</ol>";
						?>
						<a href="../PHP/ProyectosACalificar.php" class="btn btn-primary mx-2" style="background-color: #0033A0;">Regresar</a>
					</div>

				</div>

				<div class="row">
					
						<form action="CalificarProyecto.php?id=<?php echo $id?>" method="post">
							<input type="hidden" name="id" value="<?php echo $id;?>"/>
							<fieldset class="rubric-container">
								<legend><strong>Rúbrica de evaluación</strong></legend>
								<br>
								<hr>
								<div class="rubric-elements">
									<table>
										<thead>
											<tr>
												<th>&nbsp;</th>
												<th>Deficiente</th>
												<th>Regular</th>
												<th>Bueno</th>
												<th>Excelente</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><b>Utilidad:</b>
													<p>El proyecto resuelve un problema actual en el área de interés y/o el proyecto da alta prioridad al cliente quien queda ampliamente satisfecho.</p>
												</td>
												<?php 
													if ($p1 === '1') {
														echo '<td><input type="radio" name="p_1" value="1" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_1" value="1"></td>';
													}
													if ($p1 === '2') {
														echo '<td><input type="radio" name="p_1" value="2" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_1" value="2"></td>';
													}
													if ($p1 === '3') {
														echo '<td><input type="radio" name="p_1" value="3" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_1" value="3"></td>';
													}
													if ($p1 === '4') {
														echo '<td><input type="radio" name="p_1" value="4" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_1" value="4"></td>';
													}
												?>
											</tr>
											<?php if (!empty($p1Error)): ?>
												<tr><td colspan="5" class="project-rubric-score"><?php echo $p1Error;?></td></tr>
											<?php endif;?>
											<tr>
												<td>
													<b>Impacto e innovación:</b>
													<p>El proyecto presenta una idea nueva e impacta positivamente en el área de interés y/o el producto presenta una idea nueva e incrementa la productividad.</p>
												</td>
												<?php 
													if ($p2 === '1') {
														echo '<td><input type="radio" name="p_2" value="1" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_2" value="1"></td>';
													}
													if ($p2 === '2') {
														echo '<td><input type="radio" name="p_2" value="2" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_2" value="2"></td>';
													}
													if ($p2 === '3') {
														echo '<td><input type="radio" name="p_2" value="3" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_2" value="3"></td>';
													}
													if ($p2 === '4') {
														echo '<td><input type="radio" name="p_2" value="4" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_2" value="4"></td>';
													}
												?>
											</tr>
											<?php if (!empty($p2Error)): ?>
												<tr><td colspan="5" class="project-rubric-score"><?php echo $p2Error;?></td></tr>
											<?php endif;?>
											<tr>
												<td>
													<b>Desarrollo experimental o técnico y/o resultados o producto final:</b>
													<p>Ausencia de errores técnicos los resultados y/o producto resuelven el problema propuesto.</p>
												</td>
												<?php 
													if ($p3 === '1') {
														echo '<td><input type="radio" name="p_3" value="1" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_3" value="1"></td>';
													}
													if ($p3 === '2') {
														echo '<td><input type="radio" name="p_3" value="2" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_3" value="2"></td>';
													}
													if ($p3 === '3') {
														echo '<td><input type="radio" name="p_3" value="3" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_3" value="3"></td>';
													}
													if ($p3 === '4') {
														echo '<td><input type="radio" name="p_3" value="4" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_3" value="4"></td>';
													}
												?>
											</tr>
											<?php if (!empty($p3Error)): ?>
												<tr><td colspan="5" class="project-rubric-score"><?php echo $p3Error;?></td></tr>
											<?php endif;?>
											<tr>
												<td>
													<b>Claridad y precisión de ideas:</b>
													<p>La presentación es concreta y clara.</p>
												</td>
												<?php 
													if ($p4 === '1') {
														echo '<td><input type="radio" name="p_4" value="1" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_4" value="1"></td>';
													}
													if ($p4 === '2') {
														echo '<td><input type="radio" name="p_4" value="2" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_4" value="2"></td>';
													}
													if ($p4 === '3') {
														echo '<td><input type="radio" name="p_4" value="3" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_4" value="3"></td>';
													}
													if ($p4 === '4') {
														echo '<td><input type="radio" name="p_4" value="4" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_4" value="4"></td>';
													}
												?>
											</tr>
											<?php if (!empty($p4Error)): ?>
												<tr><td colspan="5" class="project-rubric-score"><?php echo $p4Error;?></td></tr>
											<?php endif;?>
											<tr>
												<td>
													<b>Respuestas a preguntas:</b>
													<p>Respuestas precisas de acuerdo al diseño, al estado de avance del proyecto, al impacto y a los resultados obtenidos.</p>
												</td>
												<?php 
													if ($p5 === '1') {
														echo '<td><input type="radio" name="p_5" value="1" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_5" value="1"></td>';
													}
													if ($p5 === '2') {
														echo '<td><input type="radio" name="p_5" value="2" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_5" value="2"></td>';
													}
													if ($p5 === '3') {
														echo '<td><input type="radio" name="p_5" value="3" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_5" value="3"></td>';
													}
													if ($p5 === '4') {
														echo '<td><input type="radio" name="p_5" value="4" checked></td>';
													}
													else {
														echo '<td><input type="radio" name="p_5" value="4"></td>';
													}
												?>
											</tr>
											<?php if (!empty($p5Error)): ?>
												<tr><td colspan="5" class="project-rubric-score"><?php echo $p5Error;?></td></tr>
											<?php endif;?>
										</tbody>
									</table>
								</div>
							</fieldset>
							<div class="submit-btn-container">
								<input type="submit" class="submit-btn" value="Confirmar calificación"> 
							</div>
						</form>
				</div>
				
			</div>
	    </main>
	</body>
</html>