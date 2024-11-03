<?php

include("conexao.php");

$sql_tot_saidas = "select sum(valor) as total_saidas from saidas";
$sql_query = $mysqli->query($sql_tot_saidas) or die("Erro ao consultar" . $mysqli ->error);
$tot_saidas = $sql_query ->fetch_assoc();

$saidas = "select s.referencial, s.gasto, s.valor, ca.categoria, m.mes, o.origem
from saidas s
left join meses m on m.id = s.mes
left join categorias ca on ca.id = s.categoria
left join origens o on o.id = s.origem
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
<div class="lateral-menu">
            <div class="perfil">
                <div class="icone-perfil"><span class="material-icons" style="font-size: 40px;">account_circle</span></div>
                <p class="nome-perfil"><a href="">Meu Perfil </a></p>
            </div>

            <div class="opcoes">
                <a href="/projetos/sistema_financeiro/index.php"><div class="li"><div class="nome--menu">Dashboard</div><span class="material-icons" style="font-size: 2ch;">chevron_right</span></div></a>
                <a href="/projetos/sistema_financeiro/saidas.php"><div class="li"><div class="nome--menu">Saídas</div><span class="material-icons" style="font-size: 2ch;">chevron_right</span></div></a>
                <a href="/projetos/sistema_financeiro/entradas.php"><div class="li"><div class="nome--menu">Entradas</div><span class="material-icons" style="font-size: 2ch;">chevron_right</span></div></a>
                <div class="li" pagina="metas.php"><div class="nome--menu">Metas</div><span class="material-icons" style="font-size: 2ch;">chevron_right</span></div>
                <div class="li" pagina="relatorios.php"><div class="nome--menu">Relatórios</div><span class="material-icons" style="font-size: 2ch;">chevron_right</span></div>
                <div class="li" pagina="configuracoes.php"><div class="nome--menu">Configurações</div><span class="material-icons" style="font-size: 2ch;">settings</span></div>
            </div>
        </div>

<div class="conteudo">

   <!-- MENU LATERAL -->

             <!-- TITULO -->
             <div class="header-dash">
            <h1 class="titulo-pag"> Saidas </h1>
            </div>
            
            <div class="conteudos">
                <div class="novo-gasto">
                <form method="post">
                    <input type="text" placeholder="Descrição do gasto" name="gasto">
                    <input type="number" placeholder="Valor R$" name="valor">
                    
                    <select id="categoria" name="categoria">
                        <option value="" disabled selected>Categoria</option>
                        <option value="1">Fixo</option>
                        <option value="2">Compras</option>
                        <option value="3">Alimentação</option>
                        <option value="4">Moto</option>
                        <option value="5">Mercado</option>
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

                    <select id="origem" name="origem">
                        <option value="" disabled selected>Origem</option>
                        <option value="1">Crédito</option>
                        <option value="2">Débito</option>
                    </select>

                    <button type="submit" name="add">Registrar</button>
                </form>

                <?php
                if(isset($_POST["add"])){
                    $gasto = $_POST['gasto'];
                    $valor = $_POST['valor'];
                    $categoria = $_POST['categoria'];
                    $mes = $_POST['mes'];
                    $origem = $_POST['origem'];

                    $sql_code = "INSERT INTO saidas(gasto, valor, categoria, mes, origem) VALUES ('$gasto', '$valor', '$categoria','$mes', '$origem')";

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
                    <th>Gasto</th>
                    <th>Valor</th>
                    <th>Categoria</th>
                    <th>Mês</th>
                    <th>Origem</th>
                    <th>Data</th>
                    <th></th>
                    </thead>

                    <?php
                    while($dados = $sql_saidas->fetch_assoc()) {
                        ?>
                    <tbody>
                        <td><?php echo $dados['gasto']; ?></td>
                        <td>R$ <?php echo $dados['valor']; ?></td>
                        <td><?php echo $dados['categoria']; ?></td>
                        <td><?php echo $dados['mes']; ?></td>
                        <td><?php echo $dados['origem']; ?></td>
                        <td><?php echo $dados['mes']; ?></td>
                        <td><form method="GET">
                                <input type="hidden" name="referencial" value="<?php echo $dados['referencial']; ?>">
                                <button type="submit" name="delete"><span class="material-icons" style="font-size: 3ch; color:red;">delete</span></button>
                            </form></td>
                        <?php
                        if (isset($_GET["delete"]) && isset($_GET["referencial"])) {
                            $referencial = intval($_GET["referencial"]); 
                        
                            if ($referencial > 0) { 
                                $sql_delete = "DELETE FROM saidas WHERE referencial = $referencial";
                            
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
                    </tbody>
                    <?php
                    }
                    ?>

                    <tfoot>
                      <tr>
                        <td>Total</td>
                        <td colspan="6">R$ <?php echo $tot_saidas['total_saidas']?></td>
                      </tr>
                    </tfoot>
                </table>
                </div>

            </div>
        </div>
    </div>
</body>
</html>