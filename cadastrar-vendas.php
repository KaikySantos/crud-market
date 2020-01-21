<?php
	require_once 'class-mercado.php';
	$m = new Mercado('db_mercado', 'localhost', 'root', '');
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!-- CSS -->
	<link rel="stylesheet" href="css/estilo.css">

    <!-- Fonts de Texto -->
	<link href="https://fonts.googleapis.com/css?family=Bree+Serif&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Sanchez&display=swap" rel="stylesheet">
	
	<!-- FONT AWESONE - ICONES -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <title>Mercado</title>

  </head>
  <body>

	<img class="background" src="img/backgroundimgedit.jpg">

<!-- Modais -->
  <!-- MODAL 1 -->
  <div class="modal fade" id="modal1">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
			<img class="mr-2" src="img/erro.svg" width="43px" height="43px">
          	<h4 class="modal-title"> Preencha os dados corretamente! </h4>
          	<button type="button" class="close" data-dismiss="modal"> x </button>
        </div>
    
      </div>
    </div>
  </div>

  <!-- MODAL 2 -->
  <div class="modal fade" id="modal2">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
			<img class="mr-2" src="img/erro.svg" width="60px" height="60px">
          	<h4 class="modal-title"> Nome ou Código de Barras já cadastrado! </h4>
          	<button type="button" class="close" data-dismiss="modal"> x </button>
        </div>
        
      </div>
    </div>
  </div>


	<?php

		//VERIFICAR SE O USER CLICOU PARA CADASTRAR ou EDITAR
		if(isset($_POST['comprador'])){

			// ------------EDITAR--------------
			if(isset($_GET['id_up']) && !empty($_GET['id_up'])){
				$id_upd = addslashes($_GET['id_up']);
				$comprador = addslashes($_POST['comprador']);
				$preco = addslashes($_POST['preco']);
				$quantidade = addslashes($_POST['quantidade']);
				$produto = addslashes($_POST['produto']);

				if(!empty($comprador) && !empty($preco) && !empty($quantidade)){
					//EDITAR
					$m->atualizarVenda($id_upd, $comprador, $preco, $quantidade, $produto);
					header("location: cadastrar-vendas.php");
				}else{
					echo "	<script>
								$('#modal1').modal();
				  			</script>
						";
				}
			}
			//---------------CADASTRAR-----------
			else{
				$comprador = addslashes($_POST['comprador']);
				$preco = addslashes($_POST['preco']);
				$quantidade = addslashes($_POST['quantidade']);
				$produto = addslashes($_POST['produto']);

				//VERIFICAR SE AS VARIAVEIS ESTÃO VAZIAS
				if(!empty($comprador) && !empty($preco) && !empty($quantidade) && !empty($produto)){
					if(!$m->cadastrarVenda($comprador, $preco, $quantidade, $produto)){
						echo"<script>
									$('#modal2').modal();
					  			</script>
							";
					}
				}else{
					echo "	<script>
								$('#modal1').modal();
						  	</script>
					";
				}
			}
			
		}
	?>

  	<!-- ---------- NAV BAR -------------- -->
	<nav class="navbar navbar-expand-lg bg-navbar navbar-light">

	<div class="container">
	  <a class="navbar-brand text-white" href="index.php"> <h2> <img style="filter: invert(100%)" width="35px" src="img/logo.webp"> <b style="text-shadow: 0px 0px 5px black">Mercado</b> </h2> </a>

	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
	    <ul class="navbar-nav">
	      <li class="nav-item">
	        <a style="background-color: green; border: 0; box-shadow: 0px 0px 5px black" class="nav-link text-white btn btn-dark" href="cadastrar-vendas.php">Vendas</a>
	      </li>
	    </ul>
	  </div>
	</div>
	</nav>

	  
<div class="container">

	<!-- FORMULÁRIO -->

		<!-- SCRIPS PARA COLOCAR DADOS NO FORM AO CLICAR NO BOTÃO EDITAR -->
		<?php
			//VERIFICAR SE O BOTÂO EDITAR FOI CLICADO
			if(isset($_GET['id_up'])){
				$id_update = addslashes($_GET['id_up']);
				$res = $m->buscarDadosVendaEsp($id_update);
			}
		?>


	<form method="POST" class="mt-4 ml-5 mr-5 pl-5 pr-5">
	
		  	<div class="form-group">
				<label class="sr-only" for="inlineFormInputGroup">Nome do Comprador</label>
				<div class="input-group mb-2">
			  		<div class="input-group-prepend">
						<div class="input-group-text bg-produto"> <img style="filter: invert(100%)" class="img-form" src="img/user.png" width="23px" height="23px"> </div>
			  		</div>
					  <!-- INPUT 1 -->
			  		<input type="text" autocomplete="off" name="comprador" class="form-control" id="inlineFormInputGroup" placeholder="Comprador" value="<?php if(isset($res)){echo $res['comprador'];} ?>">
				</div>
			</div>
			
			<div class="form-group">
				<label class="sr-only" for="inlineFormInputGroup">Preço</label>
				<div class="input-group mb-2">
			  		<div class="input-group-prepend">
						<div class="input-group-text bg-codigo"> <img style="filter: invert(100%)" class="img-form" src="img/money.svg" width="23px" height="23px"> </div>
			  		</div>
					  <!-- INPUT 2 -->
			  		<input type="text" autocomplete="off" name="preco" maxlength="6" class="form-control" id="inlineFormInputGroup" placeholder="Preço, exemplo: 1.70"
					  value="<?php if(isset($res)){echo $res['preco'];} ?>">
				</div>
			</div>


			<div class="form-group">
				<label class="sr-only" for="inlineFormInputGroup">Quantidade</label>
				<div class="input-group mb-2">
			  		<div class="input-group-prepend">
						<div class="input-group-text bg-codigo"> <img style="filter: invert(100%)" class="img-form" src="img/qnt.png" width="23px" height="23px"> </div>
			  		</div>
					  <!-- INPUT 2 -->
			  		<input type="number" autocomplete="off" name="quantidade" maxlength="6" class="form-control" id="inlineFormInputGroup" placeholder="Quantidade"
					  value="<?php if(isset($res)){echo $res['quantidade'];} ?>">
				</div>
			</div>

			<div class="input-group mb-3">
			  <div class="input-group-prepend">
			    <label class="input-group-text bg-codigo" for="inputGroupSelect01"> <img style="filter: invert(100%)" class="img-form" src="img/bottle.svg" width="23px" height="23px"> </label>
			  </div>
			  <select class="custom-select" name="produto" id="inputGroupSelect01">
		        <?php
		          $produtos = $m->buscarDadosProdutos();
		          if(count($produtos) > 0){

		            $validacao = true;
		            for($i = 0; $i < count($produtos); $i++){
		              echo "<option ";
		              foreach($produtos[$i] as $k => $v){
		                if($k == "id_produto"){
		                  echo "value = $v ";
		                  if(isset($res)){ 
		                    if($v == $res['cod_produto']){
		                      echo "selected";} 
		                    };
		                  echo ">";
		                }
		                if($k == "nome_produto"){
		                  echo $v;
		                }
		              }
		              echo "</option>";
		            }
		          }else{
		            $validacao = false;
		            echo "<option>Nenhum produto cadastrado!</option>";
		          }
		        ?>
			  </select>
			</div>

			<div class="row d-flex justify-content-center">

			<button type="submit" <?php if(!$validacao){ echo "disabled"; } ?> class="btn bg-btn mt-3 mb-3 pl-5 pr-5 shadow"> 

			<?php
				if(isset($res)){
					echo "<img style='filter: invert(100%)' class='img-form' src='img/edit.svg' width='20px' height='20px'>";
				}else{
					echo "<img style='filter: invert(100%)' class='img-form' src='img/add.svg' width='20px' height='20px'>";
				}
			?>

				 
			</button>

			</div>
	</form>
	

	<!-- TABELA -->

	<table class="table table-borderless mt-4 mb-5 shadow-lg text-white">
		
		<thead class="bg-thead">
			<tr>
				<th scope="col" style="text-shadow: 0px 0px 5px black;">#</th>
				<th scope="col" style="text-shadow: 0px 0px 5px black;">Comprador</th>
				<th scope="col" style="text-shadow: 0px 0px 5px black;">Preço</th>
				<th scope="col" style="text-shadow: 0px 0px 5px black;">Quantidade</th>
				<th scope="col" style="text-shadow: 0px 0px 5px black;">Produto</th>
				<th scope="col" style="text-shadow: 0px 0px 5px black;">Código de Barra</th>
				<th scope="col" style="text-shadow: 0px 0px 5px black;">Alterações</th>
			</tr>
		</thead>

		<tbody>

	<?php
		$vendas = $m->buscarDadosVendas();
		if(count($vendas) > 0){
			for($i = 0; $i < count($vendas); $i++){
				echo "<tr>";
				foreach($vendas[$i] as $k => $v){
					if($k == "id_venda"){
						echo "<td>". ($i + 1) ."</td>";
					}elseif($k == 'preco'){
						echo "<td> R$ ".number_format($v, 2, ',', '.') ."</td>";
					}elseif($k != 'cod_produto' && $k != 'id_produto'){
						echo "<td>".$v."</td>";
					}
				}
				?>
		<td> 
			<a href="cadastrar-vendas.php?id_up=<?php echo $vendas[$i]['id_venda'];?>"> <img class="options bg-info" src="img/edit.svg" width="30px" height="30px"> </a> 
			<a href="cadastrar-vendas.php?id_dl=<?php echo $vendas[$i]['id_venda'];?>"> <img class="options bg-danger" src="img/delete.svg" width="30px" height="30px"> </a> 
		</td>
				<?php
				echo "</tr>";
			}
		}else{
			echo "<span class='msg-p'> <img src='img/interrogacao.svg' width='25px'> Ainda não há vendas realizadas!</span>";
		}
	?>

		</tbody>

	</table>

</div>
<!-- FIM CONTAINER -->	


  </body>
</html>

<?php

	if(isset($_GET['id_dl'])){
		$id_venda = addslashes($_GET['id_dl']);
		$m->excluirVenda($id_venda);

		//ATUALIZAT PG
		// header("location: index.php");
		//ESSE MÉTODO ACIMA DEU ERRO =( , ENTÃO, OPTEI POR ESSA MANEIRA:

		echo "
			<script>
				window.location.replace('cadastrar-vendas.php')
			</script>
		";
	}

?>