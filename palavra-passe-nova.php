<?php
include_once 'includes/dbh.inc.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mudar Palavra-Passe</title>
    <meta charset="UTF-8">
  <link rel="icon" href="img/logoHead.jpg" type="image/jpg" />
  <style>
		<?php include 'css/estilo.css'; ?>

	.search-container button {
	  padding: 6px 10px;
	  margin-right: 16px;
	  margin-bottom: 10px;
	  background: #ffffff;
	  font-size: 17px;
	  border: none;
	  cursor: pointer;
	}

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
					  <a class="nav-link" href="presencas.php">Presenças</a>
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
    
    
    
  	<div class="all-browsers article">
    
<?php

if((empty($_POST['psw1'])) || (empty($_POST['psw2'])) || (empty($_POST['psw3']))){
	header('Location: palavra-passe.php');
	exit();
}

$palavra_passe1 = hash('md5', mysqli_real_escape_string($conn, $_POST['psw1']));
$palavra_passe2 = hash('md5', mysqli_real_escape_string($conn, $_POST['psw2']));
$palavra_passe3 = hash('md5', mysqli_real_escape_string($conn, $_POST['psw3']));

if($palavra_passe2 == $palavra_passe3){
    if($_SESSION['aluno']){ //se for aluno
       $sql_select = "select password from users where users.Id_User = '".$_SESSION['aluno']."';";
        $query_select = mysqli_query($conn, $sql_select);
	    $registos = mysqli_num_rows($query_select);
	    
	    if ($registos > 0){
	        while ($row1 = mysqli_fetch_assoc($query_select)){
	            $passworddb = $row1['password'];
	        }
	    }
	 
        if($passworddb == $palavra_passe1){ //se a passe e igual entao muda
            $sql = "update users set users.password = '".$palavra_passe3."' where users.Id_User ='".$_SESSION['aluno']."'";
            
           	    
            if ($conn->query($sql) === TRUE) {
                 ?>
                <h1>Palavra-Passe Alterada!</h1>
                <button type="submit" name="submit-search" class="btn btn-dark" style=margin:10px;>
        		    <a style="text-decoration:none; color:white" href="projetoFinal.php">Voltar</a>
    		    </button>
    		    <?php
            }
            
        }else{
            $_SESSION['nao autenticado'] = "Palavra-passe Atual Incorreta!" ; //verificar esta linha
    		header('Location: palavra-passe.php');
    		exit();
        }
    }else if($_SESSION['professor']){ //se for professor
        $sql_select = "select password from users where users.Id_User = '".$_SESSION['professor']."';";
        $query_select = mysqli_query($conn, $sql_select);
	    $registos = mysqli_num_rows($query_select);
	    
	    if ($registos > 0){
	        while ($row1 = mysqli_fetch_assoc($query_select)){ 
	                	$passworddb = $row1['password'];
	        }
	    }
	 
        if($passworddb == $palavra_passe1){ //se a passe e igual entao muda
            $sql = "update users set users.password = '".$palavra_passe3."' where users.Id_User ='".$_SESSION['professor']."'";
            
           	    
            if ($conn->query($sql) === TRUE) {
                ?>
                <h1>Palavra-Passe Alterada Com Sucesso!</h1>
                <button type="submit" name="submit-search" class="btn btn-dark" style=margin:10px;>
        		    <a style="text-decoration:none; color:white" href="projetoFinal.php">Voltar</a>
    		    </button>
    		    <?php
            }
            
        }else{
            ?>
                <h1>Palavra-Passe Não Alterada!</h1>
                <button type="submit" name="submit-search" class="btn btn-dark" style=margin:10px;>
        		    <a style="text-decoration:none; color:white" href="palavra-passe.php">Voltar</a>
    		    </button>
    		 <?php
        }
	}
    
}else{
    ?>
        <h1>Os Campos Não Coincidem!</h1>
        <button type="submit" name="submit-search" class="btn btn-dark" style=margin:10px;>
    	    <a style="text-decoration:none; color:white" href="palavra-passe.php">Voltar</a>
        </button>
    <?php

}

?>
    </div>

</body>
</html>