<?php
	require 'dataBase.php';
	$id = 0;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}

	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM V2_EDICION WHERE ed_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		header("Location: EdicionView.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/ico" href="../media/favicon.ico"/>

        <title>Eliminar Edicion</title>

        <link rel="stylesheet" href="../CSS/HeaderFooterStructure.css">
        <link rel="stylesheet" href="../CSS/AdminPages.css">
        <link rel="stylesheet" href="../CSS/FormsStructure.css">
	</head>

	<body>

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

        <main>
            <h1>Eliminar Edición</h1>

            <form action="../PHP/EdicionDelete.php" method="post">

                <table>
                    <tr>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $id;?>"/>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">
                            <p>Estas seguro de eliminar esta edicion</p>
                            <p>Se eliminar todo aquello referenciado esta edicion <br> <br></p>
                            <p>Se borraran: <br> <br> Proyectos <br> Jurados <br> Docentes</p>
                        </td>
                    </tr>

                    <tr>
                        <td class="Td__Iniciar__Sesion">
                            <input class="Btn__Iniciar__Sesion" type="submit" value="Si" id="submit" name="submit">
                        </td>
                    </tr>
					
					<tr>
						<td>
                            <a class="Btn__Blue" href="EdicionView.php">Regresar</a>
                        </td>
					</tr>
                </table>

            </form>

        </main>
	</body>
</html>