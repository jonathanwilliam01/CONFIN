<?php

include("conexao.php");

$referencial = intval($_GET["referencial"]);

$sql_tot_saidas = "select sum(valor) as total_saidas from saidas where referencial = $referencial";
$sql_query = $mysqli->query($sql_tot_saidas) or die("Erro ao consultar" . $mysqli ->error);
$tot_saidas = $sql_query ->fetch_assoc();

$saidas = "select 
s.referencial, 
s.gasto, 
s.valor, 
s.categoria as id_categoria, ca.categoria, 
s.mes as id_mes, m.mes, 
s.origem as id_origem, o.origem
from saidas s
left join meses m on m.id = s.mes
left join categorias ca on ca.id = s.categoria
left join origens o on o.id = s.origem
where s.referencial = $referencial
order by s.categoria, s.referencial";
$sql_saidas = $mysqli->query(query: $saidas) or die("Erro ao consultar" . $mysqli ->error);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <title>Controle Financeiro</title>
</head>
<body>
<div class="container">
<!-- MENU LATERAL -->
    <?php
        require_once('view-lateral-menu.php')
        ?>

<div class="conteudo">

   <!-- MENU LATERAL -->

             <!-- TITULO -->
             <div class="header-dash">
             <?php
                    while($dados = $sql_saidas->fetch_assoc()) {
                        ?>
            <h1 class="titulo-pag"> Editar saida - "<?php echo $dados['gasto']?>" </h1>
            </div>
            
            <div class="conteudos">
                <div class="editar-gasto">
                <form method="post">
                    <input type="text" placeholder="Descrição do gasto" name="gasto" value="<?php echo $dados['gasto'] ?>">
                    <input type="number" placeholder="Valor R$" name="valor" value="<?php echo $dados['valor'] ?>">
                    
                    <select id="categoria" name="categoria">
                        <option value="<?php echo $dados['id_categoria'] ?>" selected><?php echo $dados['categoria'] ?></option>
                        <option value="1">Fixo</option>
                        <option value="2">Compras</option>
                        <option value="3">Alimentação</option>
                        <option value="4">Moto</option>
                        <option value="5">Mercado</option>
                    </select>

                    <select id="mes" name="mes">
                        <option value="<?php echo $dados['id_mes'] ?>" selected><?php echo $dados['mes'] ?></option>
                        <option value="01">Janeiro</option>
                        <option value="02">Fevereiro</option>
                        <option value="03">Março</option>
                        <option value="04">Abril</option>
                        <option value="05">Maio</option>
                        <option value="06">Junho</option>
                        <option value="07">Julho</option>
                        <option value="08">Agosto</option>
                        <option value="09">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>

                    <select id="origem" name="origem">
                        <option value="<?php echo $dados['id_origem'] ?>" selected><?php echo $dados['origem'] ?></option>
                        <option value="1">Crédito</option>
                        <option value="2">Débito</option>
                    </select>
                    <?php
                    }
                    ?>

                    <button type="submit" name="edit" class="registrar">Editar</button>
                    <button name="back" class="cancelar"><a href="saidas.php">Cancelar</a></button>
                </form>

                <?php
                if(isset($_POST["edit"])){
                    $gasto = $_POST['gasto'];
                    $valor = $_POST['valor'];
                    $categoria = $_POST['categoria'];
                    $mes = $_POST['mes'];
                    $origem = $_POST['origem'];

                    $sql_code = "update saidas set gasto = '$gasto', valor = $valor, categoria = '$categoria', mes = '$mes', origem = '$origem' where referencial = $referencial";

                    if(mysqli_query($mysqli, $sql_code)) {
                        echo "<script>window.location.href = 'saidas.php';</script>";
                    } else {
                        echo "<script>alert('Erro ao editar gasto: " . mysqli_error($mysqli) . "');</script>";
                    }
                    }
                ?>
                </div>

                
        </div>
    </div>
</body>
</html>