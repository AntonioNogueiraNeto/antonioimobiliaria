<?php

include('conexao.php');
// Handle form submission
if (isset($_POST['submit'])) {
    // Sanitize user input
    $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $valor = mysqli_real_escape_string($conn, $_POST['valor']);
    $endereco = mysqli_real_escape_string($conn, $_POST['endereco']);

    // Validate user input
    if (empty($tipo) || empty($descricao) || empty($area) || empty($valor) || empty($endereco)) {
        $msg = "Por favor, preencha todos os campos.";
    } elseif (!is_numeric($area) || !is_numeric($valor)) {
        $msg = "Por favor, insira um valor numérico para área e valor.";
    } else {
        // Upload image
        $target_dir = "./imagens/";
        $target_file = $target_dir . basename($_FILES["pic"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $newFileName = md5(time()) . '.' . $imageFileType;

        if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_dir . $newFileName)) {
            // Insert data into database
            $stmt = $conn->prepare("INSERT INTO imoveis (tipo, descricao, endereco, area, imagem, valor) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $tipo, $descricao, $endereco, $area, $newFileName, $valor);
            if ($stmt->execute()) {
                $msg = "Imóvel adicionado com sucesso!";
            } else {
                $msg = "Erro ao adicionar imóvel: " . mysqli_error($conn);
            }
            $stmt->close();
        } else {
            $msg = "Erro ao enviar imagem.";
        }
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

<section class="contato" id="contato">

   <h1 class="heading">Adicionar Imóvel</h1>

   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">


      <span>Tipo :</span>
      <input type="text" name="tipo" placeholder="tipo de imovel" class="box" >

      <span>descricao:</span>
      <input type="text" name="descricao" placeholder="descricao do imovel" class="box" >
      
      <span>endereco:</span>
      <input type="text" name="endereco" placeholder="endereco" class="box" >
      
      <span>area:</span>
      <input type="number" name="area" placeholder="area" class="box" >

      <span>valor:</span>
      <input type="number" name="valor" placeholder="valor" class="box" >

      <span>imagem:</span>
      <input type="file" name="pic" class="box" accept="image/*">

      <input type="submit" value="Upload" name="submit" class="link-btn">
   </form>  

</section>
    
</body>
</html>