<?php

include("conexao.php");

$sql_tot_entradas = "select sum(valor) as total_entradas from entradas";
$sql_query = $mysqli->query($sql_tot_entradas) or die("Erro ao consultar" . $mysqli ->error);
$tot_entradas = $sql_query ->fetch_assoc();

$qtd_tot_entradas = "select count(referencial) as qtd_entradas from entradas";
$sql_query = $mysqli->query($qtd_tot_entradas) or die("Erro ao consultar" . $mysqli ->error);
$qtd_entradas = $sql_query ->fetch_assoc();

$entradas = "select e.referencial, e.entrada, e.valor, 
m.mes, date_format(e.data, '%d/%m/%Y') as data
from entradas e
left join meses m on m.id = e.mes
order by e.entrada, e.referencial";
$sql_entradas = $mysqli->query(query: $entradas) or die("Erro ao consultar" . $mysqli ->error);

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
            <h1 class="titulo-pag"> Entradas </h1>
            </div>
            
            <div class="conteudos">
                <div class="novo-gasto">
                <form method="post">
                    <input type="text" placeholder="Descrição" name="entrada">
                    <input type="number" step="0.01" placeholder="Valor R$" name="valor">

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

                    <button type="submit" name="add" class="registrar">Registrar</button>
                </form>

                <?php
                if(isset($_POST["add"])){
                    $gasto = $_POST['entrada'];
                    $valor = $_POST['valor'];
                    $mes = $_POST['mes'];

                    $sql_code = "INSERT INTO entradas(entrada, valor, mes) VALUES ('$gasto', '$valor', '$mes')";

                    if(mysqli_query($mysqli, $sql_code)) {
                        echo "<script>window.location.href = window.location.href;</script>";
                    } else {
                        echo "<script>alert('Erro ao cadastrar gasto: " . mysqli_error($mysqli) . "');</script>";
                    }
                    }
                ?>
                </div>

                <div class="exibe-gastos">
                <table class="saidas">
                    <thead>
                    <th>Entrada</th>
                    <th>Valor</th>
                    <th>Mês</th>
                    <th>Data inserção</th>
                    <th colspan="2"></th>
                    </thead>

                    <?php
                    while($dados = $sql_entradas->fetch_assoc()) {
                        ?>
                    <tbody>
                        <td><?php echo $dados['entrada']; ?></td>
                        <td>R$ <?php echo $dados['valor']; ?></td>
                        <td><?php echo $dados['mes']; ?></td>
                        <td><?php echo $dados['data']; ?></td>
                        <td><form method="GET">
                                <input type="hidden" name="referencial" value="<?php echo $dados['referencial']; ?>">
                                <button type="submit" class="crud-bot" name="delete" style="cursor:pointer;"><span class="material-icons" style="font-size: 3ch; color:red;">delete</span></button>
                            </form></td>

                        <?php
                        if (isset($_GET["delete"]) && isset($_GET["referencial"])) {
                            $referencial = intval($_GET["referencial"]); 
                        
                            if ($referencial > 0) { 
                                $sql_delete = "DELETE FROM entradas WHERE referencial = $referencial";
                            
                                if ($mysqli->query($sql_delete) === TRUE) {
                                    echo "<script>window.location.href = 'saidas.php';</script>"; 
                                } else {
                                    echo "<script>alert('Erro ao deletar gasto: " . $mysqli->error . "');</script>";
                                }
                            } else {
                                echo "<script>alert('ID inválido para exclusão');</script>";
                            }
                        }
                        ?>
                
                        
                        <td><a href="editar_saida.php?referencial=<?php echo $dados['referencial']?>">
                                <span class="material-icons" style="font-size: 3ch; cursor:pointer">edit</span>
                            </a></td>
                    </tbody>
                    <?php
                    }
                    ?>

                    <tfoot>
                      <tr>
                        <td>Total</td>
                        <td>R$ <?php echo $tot_entradas['total_entradas']?></td>
                        <td>Qtd. <?php echo $qtd_entradas['qtd_entradas'] ?></td>
                        <td colspan="5"></td>
                      </tr>
                    </tfoot>
                </table>
                </div>

            </div>
        </div>
    </div>
</body>
</html>