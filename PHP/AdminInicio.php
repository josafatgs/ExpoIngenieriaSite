<?php 
    require_once 'dataBase.php';

    session_name("EngineerXpoWeb");
    session_start();

    if (!isset($_SESSION['logged_in'])) {
        header("Location: ../index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" type="image/ico" href="../media/favicon.ico" />

		<title>Admin Menu</title>

		<link rel="stylesheet" href="../CSS/HeaderFooterStructure.css" />
		<link rel="stylesheet" href="../CSS/FormsStructure.css" />
	</head>
	<body>
		<header>
			<img class="Logo__EscNegCie" src="../media/logotec-ings.svg" />
		</header>

		<main>
			<table class="Admin_Options">
				<tr>
					<td>
						<a class="Btn__Ancla" href="../PHP/ProyectosView.php"
							>Proyectos</a
						>
					</td>
				</tr>
				<tr>
					<td>
						<a class="Btn__Ancla" href="../PHP/UsuariosView.php"
							>Usuarios</a
						>
					</td>
				</tr>
				<tr>
					<td>
						<a class="Btn__Ancla" href="../PHP/EdicionView.php"
							>Ediciones</a
						>
					</td>
				</tr>
				<tr>
					<td>
						<a
							class="Btn__Ancla"
							href="../PHP/AdministradoresView.php"
							>Administradores</a
						>
					</td>
				</tr>
				<tr>
					<td>
						<a
							class="Btn__Ancla"
							href="../PHP/AdministradoresView.php"
							>Categorias</a
						>
					</td>
				</tr>
				<tr>
					<td>
						<a
							class="Btn__Ancla"
							href="../PHP/AdministradoresView.php"
							>Nivel</a
						>
					</td>
				</tr>
				<tr>
					<td>
						<a
							class="Btn__Ancla"
							href="../PHP/AdministradoresView.php"
							>Avisos</a
						>
					</td>
				</tr>
				<tr>
					<td>
						<a
							class="Btn__Ancla"
							href="../PHP/AdministradoresView.php"
							>Evaluaciones</a
						>
					</td>
				</tr>
			</table>
		</main>

		<footer>
			<img class="Logo__Tec" src="../media/LogoTec.png" alt="Logo Tec" />
		</footer>
	</body>
</html>
