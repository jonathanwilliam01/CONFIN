<?php

include("conexao.php");


$sql_tot_saidas = "select sum(valor) as total_saidas from saidas";
$sql_query = $mysqli->query($sql_tot_saidas) or die("Erro ao consultar" . $mysqli ->error);
$tot_saidas = $sql_query ->fetch_assoc();

$sql_tot_entradas = "select sum(valor) as total_entradas from entradas";
$sql_query = $mysqli->query($sql_tot_entradas) or die("Erro ao consultar" . $mysqli ->error);
$tot_entradas = $sql_query ->fetch_assoc();

$sql_tot_saldo = "select abs(sum(s.valor) - (select sum(e.valor) from entradas e)) as saldo from saidas s";
$sql_query = $mysqli->query($sql_tot_saldo) or die("Erro ao consultar" . $mysqli ->error);
$tot_saldo = $sql_query ->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="pt-br">
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

    <!-- DASHBOARD -->

        <div class="conteudo" id="conteudo">

            <!-- TITULO -->
            <div class="header-dash">
            <h1 class="titulo-pag"> Dashboard </h1>
            </div>

            <!-- TOTALIZADORES -->
            <div class="infos-dash">
                <div class="dash-entradas">
                    <h3 class="tit-dash">Entradas</h3>
                    <div class="val-dash">
                    <p> R$ <?php echo $tot_entradas['total_entradas']?> </p>
                    </div>
                </div>

                <div class="dash-saidas">
                    <h3 class="tit-dash">Saidas</h3>
                    <div class="val-dash">
                    <p> R$ <?php echo $tot_saidas['total_saidas']?> </p>
                    </div>
                </div>

                <div class="dash-saldo">
                    <h3 class="tit-dash">Saldo</h3>
                    <div class="val-dash">
                    <p> R$ <?php echo $tot_saldo['saldo']?> </p>
                    </div>
                </div>
            </div>

            <!-- RELATORIOS RAPIDOS -->
            <div class="relatorios">

            <div class="tit-rels">
                <p style="margin-left:2%;"> Relatorios </p>
            </div>

            <div class="rel-saidas">
                <h4>Saidas</h4>
            </div>

            </div>
            
    </div>

    </div>

</div>

    <script>
        // Seleciona todos os itens de lista
        const listItems = document.querySelectorAll('.li');
        const contentDiv = document.getElementById('conteudo');

        // Adiciona evento de clique em cada item
        listItems.forEach(item => {
            item.addEventListener('click', () => {
                // Pega o nome do arquivo PHP a ser carregado
                const panel = item.getAttribute('pagina');
                
                // Faz a requisição AJAX
                if (panel) {
                    fetch(panel)
                        .then(response => response.text())
                        .then(data => {
                            // Insere o conteúdo retornado na div de conteúdo
                            contentDiv.innerHTML = data;
                        })
                        .catch(error => console.log('Erro ao carregar o conteúdo: ', error));
                }
            });
        });
    </script>

</body>
</html>
