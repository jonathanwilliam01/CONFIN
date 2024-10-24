<?php

include("conexao.php");


// $sql_tot_saidas = "select sum(valor) as total_saidas from saidas";
// $sql_query = $mysqli->query($sql_tot_saidas) or die("Erro ao consultar" . $mysqli ->error);

// $tot_saidas = $sql_query ->fetch_assoc();


$saidas = "select * from saidas order by categoria, referencial";
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
        <div class="content" id="conteudo">

             <!-- TITULO -->
             <div class="header-dash">
            <h1 class="titulo-pag"> Saidas </h1>
            </div>
            
            <div class="conteudos">
                <div class="novo-gasto">
                <form method="post">
                    <input type="text" placeholder="Descrição do gasto" name="descricao">
                    <input type="number" placeholder="Valor R$" name="valor">

                    <select id="categoria" name="categoria">
                        <option value="" disabled selected>Categoria</option>
                        <option value="Fixo">Fixo</option>
                        <option value="Compras">Compras</option>
                        <option value="Alimentação">Alimentação</option>
                        <option value="Moto">Moto</option>
                        <option value="Mercado">Mercado</option>
                    </select>

                    <select id="mes" name="mes">
                        <option value="" disabled selected>Mês</option>
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

                    <button type="submit" name="add">Registrar</button>
                </form>

                <?php
                if(isset($_POST["add"])){
                    $descricao = $_POST['descricao'];
                    $valor = $_POST['valor'];
                    $categoria = $_POST['categoria'];
                    $mes = $_POST['mes'];

                    $sql_code = "INSERT INTO saidas(descricao, valor, categoria, mes) VALUES ('$descricao', '$valor', '$categoria','$mes')";

                    if(mysqli_query($mysqli, $sql_code)) {
                        echo "<script>window.location.href = window.location.href;</script>";
                    } else {
                        echo "<script>alert('Erro ao cadastrar gasto: " . mysqli_error($mysqli) . "');</script>";
                    }
                    }
                ?>
                </div>

                <div class="exibe-gastos">
                <table border="1px solid black">
                    <thead>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Categoria</th>
                    <th>Mês</th>
                    </thead>

                    <?php
                    while($dados = $sql_saidas->fetch_assoc()) {
                        ?>
                    <tbody>
                        <td><?php echo $dados['descricao']; ?></td>
                        <td><?php echo $dados['valor']; ?></td>
                        <td><?php echo $dados['categoria']; ?></td>
                        <td><?php echo $dados['mes']; ?></td>
                    </tbody>
                    <?php
                    }
                    ?>
                </table>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
