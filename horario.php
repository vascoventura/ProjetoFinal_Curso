<?php
	include_once 'includes/dbh.inc.php';
	session_start();	
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>	
  <title>Horário</title>
  <meta charset="UTF-8">
  <link rel="icon" href="img/logoHead.jpg" type="image/jpg">
  <style>
		<?php include 'css/estilo.css'; ?>
  </style>
  
  <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/fontawesome.css" />
  <link rel="stylesheet" href="css/solid.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="30">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Lato:ital@1&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@1,700&display=swap" rel="stylesheet">

</head>			  
<body>

	<!--Navbar-->

		<nav class="navbar navbar-expand-md bg-dark navbar-dark">
		  <!-- Brand/logo -->
		  <a class="navbar-brand" href="projetoFinal.php">
			<img src="img/logo.jpg" alt="Logo" style="width:80px;">
		  </a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
		  
		  <?php
		  	if(isset($_SESSION['aluno'])){
		  	
	           $nome = "select Nome_Aluno 
	           from alunos, users where alunos.Id_Aluno = users.AlunoId and Id_User = " .$_SESSION['aluno'];" "; 
	                   $nome_numero_linhas = mysqli_query($conn, $nome);
	                   $nome_registos = mysqli_num_rows($nome_numero_linhas);
	           
	           	if ($nome_registos > 0){
	           		while ($row1 = mysqli_fetch_assoc($nome_numero_linhas)){ 
	                	$nome_user = $row1['Nome_Aluno'];
	                }
	         	}	             
	       ?>
	           <div class="collapse navbar-collapse" id="collapsibleNavbar">
		  		<ul class="navbar-nav">
					<li class="nav-item">
					  <a class="nav-link" href="pagina_presencas.php">Presenças</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="horario.php">Horário</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="docentes.php">Docentes</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="logout.php">Logout</a>
					</li>
				    <li class="saudacao"><a class="nome_link" href="palavra-passe.php">Olá, <?php echo ($nome_user);?></a>
					</li>
				</ul>
				</div> 
			
			<?php
			} elseif(isset($_SESSION['professor'])){ 
				
	                   $nome = "select Nome_Professor from professores, users where professores.Id_Professor = users.ProfessorId and Id_User = " .$_SESSION['professor'];" ";
	                   $nome_numero_linhas = mysqli_query($conn, $nome);
	                   $nome_registos = mysqli_num_rows($nome_numero_linhas);
	           
	           	if ($nome_registos > 0){
	           		while ($row1 = mysqli_fetch_assoc($nome_numero_linhas)){ 
	                	$nome_user = $row1['Nome_Professor'];
	                }
	         	} 
	        

	        ?> 
	            <div class="collapse navbar-collapse" id="collapsibleNavbar">
			  		<ul class="navbar-nav">
						<li class="nav-item">
						  <a class="nav-link" href="meusalunos.php">Meus Alunos</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="horario.php">Horário</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="salas.php">Salas</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="logout.php">Logout</a>
						</li>
					    <li class="saudacao"><a class="nome_link" href="palavra-passe.php">Olá, prof. <?php echo ($nome_user);?></a>
						</li>
					</ul>
				</div>
			<?php 

			} else {

			?>
			     <div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav"> 
					<li class="nav-item">
			  			<a class="nav-link" href="login.php">Login</a>
					</li>
				</ul>
				</div>

			<?php			

			}

		  ?>
		</nav>

		<article class="all-browsers">
		  <h1>Horário</h1>

		  	<?php
	  	if(isset($_SESSION['aluno'])){
	  		$sql = "select
						disciplinas.Nome_Disciplina,
					    aulas.Hora_Inicio,
					    aulas.Hora_Fim,
					    salas.Numero_Sala,
					    users.Id_User
					    from inscricoes,
					    disciplinas,
					    aulas,
					    salas,
					    users
					    where inscricoes.DisciplinaId = disciplinas.Id_Disciplina
					    and aulas.SalaId = salas.Id_Sala
					    and aulas.DisciplinaId = disciplinas.Id_Disciplina
					    and inscricoes.AlunoId = users.AlunoId
						and users.Id_User = '".$_SESSION['aluno']."'
						order by STR_TO_DATE(aulas.Hora_Inicio, '%W') ASC;";

	  	
		} else if(isset($_SESSION['professor'])){
			$sql = "select
						disciplinas.Nome_Disciplina,
					    aulas.Hora_Inicio,
					    aulas.Hora_Fim,
					    salas.Numero_Sala,
					    users.Id_User
					    from disciplinas,
					    aulas,
					    salas,
					    users
					    where aulas.SalaId = salas.Id_Sala
					    and aulas.DisciplinaId = disciplinas.Id_Disciplina
					    and aulas.ProfessorId = users.ProfessorId
                        and users.Id_User = " .$_SESSION['professor'];" "; 
		} 
				
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				
				  
				
						if ($resultCheck > 0) {
							while ($row = mysqli_fetch_assoc($result)): ?> 
									<article class='browser bg-dark' style="color:white">
										<h2 class='Nome-Disciplina'><?= $row['Nome_Disciplina']?></h2>
										<h2 class='Nome-Disciplina'><?= $row['Hora_Inicio']?></h2>
										<h2 class='Nome-Disciplina'><?= $row['Hora_Fim']?></h2>
									    <span class='NumeroSala' style="color:black">
											<h1><?= $row['Numero_Sala']?></h1>
										</span>
									</article>
							<?php endwhile;
						} else {
						 ?>
						 <h2>Não Foram Encontrados Resultados!</h2>
						 <?php
						}
						?>	
							
		  
		</article>
		
		<div class="page-wrapper">
		</div>	
		

		<div class="footer">
			<p>&copy; 2020 - Sistema de Horários</p>
		</div>	
		
		
</body> 
</html>