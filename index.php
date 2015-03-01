<?php

echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" charset="utf-8" />
    <title>Titre</title>
</head>
<body>';

/* Variables */

$server = "localhost";
$user_name = "root";
$password = "mysqlpi";
$dbname = "dblight";
$countScenario = 0;
$countLight = 0;

/* Connexion a la bdd */

$connection = mysql_connect($server, $user_name, $password) or die('Could not connect to mysql');
if (!mysql_select_db($dbname,$connection)) {
    echo "Could not connect to database $dbname";
    exit;
}

echo '<div><h3>Les sc&eacute;narios</h3>';
/* Affiche le scenario en cours */
 
$sql = "SELECT * FROM rasplight";
$result = mysql_query($sql, $connection);

if(!$result){
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}
if(mysql_num_rows($result)){
    echo '<div><table id="table-bvs">';
    echo '<thead><th>S&eacute;nario en cours</th><th>PID</th></thead><tbody>';
    while($row = mysql_fetch_row($result)) {
        echo '<tr>';
        foreach($row as $key=>$value) {
            if($key == 0){
                if($value == NULL)
                    echo '<td class="off">Aucun</td>';
                else echo '<td class="on">Sc&eacute;nario ',$value,'</td>';
            }
            else{
                if($value == NULL)
                    echo '<td></td>';
                else echo '<td>',$value,'</td>';
                }
        }
        echo '</tr>';
        }
    echo '</tbody></table></div><br />';
    }


/* Affiche tous les scenarios disponible dans la bdd */

$sql = "SELECT * FROM scenario";
$result = mysql_query($sql, $connection);

if(!$result){
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}
if(mysql_num_rows($result)){
    echo '<table id="table-bvs">';
    echo '<thead><th>Identifiant S&eacute;nario</th><th>Description</th><th>Activ&eacute;</th></thead><tbody>';
    while($row = mysql_fetch_row($result)) {
        echo '<tr>';    
        foreach($row as $key=>$value) {
            echo '<td>',$value,'</td>';
            }
        echo '<td><form action="" method="post"><button type="submit" name="buttonScenarioOn',$countScenario,'" class="on">ON</button></form></td>';
        $buttonScenarioOn = "buttonScenarioOn".$countScenario;
        /* Appel pour executer le code qui permet de changer de scenario*/
        /*if (isset($_POST[$buttonScenarioOn]))
            exec('code');*/
        echo '</tr>';
        $countScenario++;
        }
    echo '</tbody></table></div>';
    }

/* show table light */

echo '<div><h3>Les lampes</h3>';
$sql = "SELECT * FROM light ORDER BY light_pair DESC";
$result = mysql_query($sql, $connection);

if(!$result){
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}
if(mysql_num_rows($result)){
	echo '<table id="table-bvs">';
	echo '<thead><th>Identifiant Lampe</th><th>&Eacute;tat</th><th>Appair&eacute;</th><th>Puissance</th><th>Xmin</th><th>Xmax</th><th>Ymin</th><th>Ymax</th></thead><tbody>';
	while($row = mysql_fetch_row($result)) {
		echo '<tr>';
		foreach($row as $key=>$value) {
			if($key == 0){
			    $lightID = $value;
			    echo '<td>',$value,'</td>';
			    }
			else if($key == 1){
				if($value == 0)
				    echo '<td class="off">OFF';
				else echo '<td class="on">ON';
				echo '<form action="" method="post">
				<button type="submit" name="buttonLightOn',$countLight,'" class="on">ON</button>
				<button type="submit" name="buttonLightOff',$countLight,'" class="off">OFF</button>
				</form></td>';
				$buttonLightOn = "buttonLightOn".$countScenario;
				$buttonLightOff = "buttonLightOff".$countScenario;
                /* Appel pour executer le code qui permet de changer l'etat d'une lampe */
                /* L'id d'une lampe est dans la variable $lightID */
                /*if (isset($_POST[$buttonLightOn]))
                    exec('code');
                if (isset($_POST[$buttonLightOff]))
                    exec('code');*/
            }
            else if($key == 2){
                if($value == 0)
				    echo '<td class="off">OFF';
				else echo '<td class="on">ON';
                echo '<form action="" method="post">
				<button type="submit" name="buttonPairOn',$countLight,'" class="on">ON</button>
				<button type="submit" name="buttonPairOff',$countLight,'" class="off">OFF</button>
				</form></td>';
				$buttonPairOn = "buttonPairOn".$countScenario;
				$buttonPairOff = "buttonPairOff".$countScenario;
                /* Appel pour executer le code qui permet d'appairer/desappairer une lampe */
                /* L'id d'une lampe est dans la variable $lightID */
                /*if (isset($_POST[$buttonPairOn]))
                    exec('code');
                if (isset($_POST[$buttonPairOff]))
                    exec('code');*/
            }
            else
			    echo '<td>',$value,'</td>';
			$countLight++;
			}
		echo '</tr>';
		}
	echo '</tbody></table></div><br />';
	}
	
echo '</body></html>';
mysql_free_result($result);

?>
