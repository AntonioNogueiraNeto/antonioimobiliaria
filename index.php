<?php
include('conexao.php');

// mostrar os imoveis
function retrieveImoveisData($conn) {
   $query = mysqli_prepare($conn, "SELECT * FROM `imoveis` ORDER BY ID DESC");
   mysqli_stmt_execute($query);
   return mysqli_stmt_get_result($query);
}

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['nome']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = mysqli_real_escape_string($conn, $_POST['numero']);
   $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);

   $result_cadastro = "INSERT INTO clientes(nome, email, telefone, imovel_id) VALUES('$name','$email', '$number', '$tipo')";
   $resultado_cadastro_sucesso = mysqli_query($conn, $result_cadastro);
   
   if($resultado_cadastro_sucesso) {
      $message[] = 'Agendamento marcado com sucesso!';;
   } else {
      $message[] = 'falha no agendamento, tente novamente';
   }
}
   

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>AntônioNeto Imoveis</title>

   <!-- font link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- bootstrap link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">

   <!-- css link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>

<!-- header -->
<header class="header fixed-top">
   <div class="container">
      <div class="row align-items-center justify-content-between">
         <a href="#home" class="logo">AntônioNeto<span>Imóveis.</span></a>
         <nav class="nav">
            <a href="#home">home</a>
            <a href="#sobre">sobre</a>
            <a href="#imoveis">Imoveis</a>
            
            <a href="#contato">contato</a>
         </nav>
         <a href="#contato" class="link-btn">Fale com a gente</a>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>
   </div>
</header>

<!-- home section -->

<section class="home" id="home">

   <div class="container">

      <div class="row min-vh-100 align-items-center">
         <div class="content text-center text-md-left">
            <h3>Sua conquista, nosso compromisso</h3>
            <p>Somos um dos maiores portais imobiliários de Betim, com imóveis qualificados e sem repetição. Na AntônioNeto Imóveis você vende, aluga e compra o seu imóvel com muito mais segurança e agilidade.</p>
            <a href="#contato" class="link-btn">Fale Conosco</a>
         </div>
      </div>

   </div>

</section>

<!-- sobre section --> 
<section class="sobre" id="sobre">

   <div class="container">

   <div class="row align-items-center">

      <div class="col-md-6 image">
         <img src="imagens/logo.jpg" class="w-100 mb-5 mb-md-0" alt="">
      </div>

      <div class="col-md-6 content">
         <span>Sobre nós</span>
         <h3>Sua vida move a nossa</h3>
         <p>A AntônioNeto Imóveis é uma empresa que atua no mercado imobiliário de Betim desde 2012. Nesse período conseguimos ser um agente facilitador de realização de sonhos para centenas de famílias, além de proporcionar excelentes investimentos para clientes e parceiros. Temos sede própria e equipe qualificada o que garante ainda mais segurança e eficiência na hora de realizar seu negócio.</p>
         <a href="#contato" class="link-btn">fale conosco</a>
      </div>

   </div>

   </div>

</section>


<!-- imoveis section  -->

<section class="imoveis" id="imoveis">

   <h1 class="heading">Nossos Imóveis</h1>

   <div class="box-container container">
   <!-- dinamico -->
   <?php 
    $result_imagem = "SELECT * FROM imoveis ORDER BY ID DESC";
    $resultado_imagem = mysqli_query($conn, $result_imagem);

    while ($row = mysqli_fetch_assoc($resultado_imagem)) {
        ?>
        <div class='box'>
            <a href=''>
                <img src='imagens/<?php echo $row["imagem"]; ?>' alt=''>
                <h3><?php echo number_format($row["valor"], 2, ',', '.'); ?></h3>
                <h5><?php echo $row["tipo"]; ?></h5>
                <p><?php echo $row["descricao"]; ?></p>
                <p><?php echo $row["endereco"]; ?></p>
                <p><?php echo $row["area"] . "m²"; ?></p>
            </a>
        </div>
        <?php
    }
?>

   </div>

</section>


<!-- contato section  -->

<section class="contato" id="contato">

   <h1 class="heading">Fale Conosco</h1>

   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

   <?php 
         if(isset($message)){
          foreach($message as $message){
             
             echo '<p class="message">'.$message.'</p>';
          }
            
         }
      ?>

      <span>Nome :</span>
      <input type="text" name="nome" placeholder="digite seu nome" class="box" required>
      <span>E-mail :</span>
      <input type="email" name="email" placeholder="digite seu email" class="box" required>
      <span>Telefone :</span>
      <input type="number" name="numero" placeholder="digite seu telefone" class="box" required>
      <span>Enterece em qual tipo de imóvel :</span>
<!-- <div class="form-check">
       
    <?php 
        foreach($tiposdeimoveis as $imoveltipo):
    ?>
      <input type="checkbox" class=" form-check-input"  name="<?php echo $imoveltipo['name']?>" value="<?php echo $imoveltipo['id'] ?>">
      <label><?php echo $imoveltipo['name'] ?>
      </label>      
     <?php 
     endforeach;
     ?>
     </div> 

     <div> -->

      <select class="form-select" id="select" name="tipo" aria-label="Default select example">
          <option selected>Selecione o tipo no menu</option>
            <?php 
               $query = "SELECT * FROM tipoimoveis";  
               $resultado = mysqli_query($conn, $query); 
               while($row_imoveis = mysqli_fetch_assoc($resultado)){
             ?>
              
          <option value="<?php echo $row_imoveis['id']?>"><?php echo $row_imoveis['tipo']?></option>
            <?php 
               }
            ?>
         
      </select>
        
     </div>
     <br>


    <input type="submit" value="fale conosco" name="submit" class="link-btn btn-contato">
   </form>  

   

</section>
<!-- footer section  -->

<section class="footer">

   <div class="box-container container">

      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>Telefones:</h3>
         <p>(31)99999-9999</p>
         <p>(31)3434-3333</p>
      </div>
      
      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>Nosso Endereço</h3>
         <p>Av. Afonso Pena - 3001</p>
      </div>

      <div class="box">
         <i class="fas fa-clock"></i>
         <h3>Horario de atendimento</h3>
         <p>07:00 às 19:00</p>
      </div>

      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>email</h3>
         <p>antonionetoimoveis@gmail.com</p>
      </div>

   </div>

   <div class="credit"> &copy; copyright @ <?php echo date('Y'); ?> by <span>Antonio Henriques</span>  </div>

</section>

<!-- js link  -->
<script src="script/script.js"></script>

</body>
</html>