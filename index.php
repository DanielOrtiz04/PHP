<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcial Final</title>
    <style>
      body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
}

h1 {
    text-align: center;
}

form {
    display: flex;
    flex-direction: column;
    max-width: 400px;
    margin: 20px auto;
}

form input[type="text"],
form button {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

form button {
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
}

table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
}

th,
td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #4CAF50;
    color: white;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 6px 12px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin: 2px;
    cursor: pointer;
    border-radius: 4px;
}
    </style>
</head>
<body>
    <?php
    //abrir la coneccion a la base datos
    $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
    $conexion = new PDO('mysql:host=localhost;dbname=final_0907_23_14054', 'root','',$pdo_options);
    
    if(isset($_POST["accion"])){
      //echo "Quieres" .$_POST["accion"];
      if($_POST["accion"] == "Crear"){
        $insert = $conexion->prepare("INSERT INTO final(codigo,nombre,precio,existencia) VALUES
        (:codigo,:nombre,:precio,:existencia)");
        $insert->bindValue('codigo', $_POST['codigo']);
        $insert->bindValue('nombre', $_POST['nombre']);
        $insert->bindValue('precio', $_POST['precio']);
        $insert->bindValue('existencia', $_POST['existencia']);
        $insert->execute();

      }
     if($_POST["accion"] == "Editado"){
        $update = $conexion->prepare("UPDATE final SET nombre=:nombre, precio=:precio,
        existencia=:existencia WHERE codigo=:codigo ");
        $update->bindValue('codigo', $_POST['codigo']);
        $update->bindValue('nombre', $_POST['nombre']);
        $update->bindValue('precio', $_POST['precio']);
        $update->bindValue('existencia', $_POST['existencia']);
        $update->execute();
        //header("Refresh: 0;");
  
      }
    }
  
    //ejecutamos la consulta
    $select = $conexion->query("SELECT codigo, nombre, precio, existencia From final");


   ?>

   <?php if(isset($_POST["accion"]) && $_POST["accion"] == "Editar" ) { ?>
   <form method="POST">
         <input type="text" name="codigo" value="<?php echo $_POST["codigo"]?>" placeholder="Ingresar el codigo"/>
         <input type="text" name="nombre" placeholder="Ingresar el nombre"/>
         <input type="text" name="precio" placeholder="Ingresar el precio"/>
         <input type="text" name="existencia" placeholder="Ingresar la existencia"/>
         <input type="hidden" name="accion" value="Editado"/>
         <button type="submit"> Guardar </button>
  
   </form>
  <?php } else { ?>
    <form method="POST">
         <input type="text" name="codigo" placeholder="Ingresar el codigo"/>
         <input type="text" name="nombre" placeholder="Ingresar el nombre"/>
         <input type="text" name="precio" placeholder="Ingresar el precio"/>
         <input type="text" name="existencia" placeholder="Ingresar la existencia"/>
         <input type="hidden" name="accion" value="Crear"/>
         <button type="submit"> Crear </button>
  
   </form>
  <?php } ?>

  <table border="1">
   <thead>
    <tr>
      <th>Codigo</th>
      <th>Nombre</th>
      <th>Precio</th>
      <th>Existencia</th>
      <th>Acciones</th>
</tr>
</head>
<tbody>
  <?php foreach($select ->fetchAll() as $final) { ?>
    <tr>
      <td> <?php echo$final ["codigo"] ?> </td>
      <td> <?php echo$final ["nombre"] ?> </td>
      <td> <?php echo$final ["precio"] ?> </td>
      <td> <?php echo$final ["existencia"] ?> </td>
      <td> <form method="POST">
          <button type="submit">Editar</button>
          <input type="hidden" name= "accion" value="Editar"/>
          <input type="hidden" name="codigo" value="<?php echo $final["codigo"]?>"/>
        </form>
     <?php } ?>
    </tbody>
  </table>
</body>
</html>