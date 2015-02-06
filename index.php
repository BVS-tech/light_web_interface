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

/* Affiche tous les scenarios disponible dans la bdd */

echo '<div><h3>Liste des sc&eacute;narios :</h3>';
$sql = "SELECT * FROM scenario";
$result = mysql_query($sql, $connection);

if(!$result){
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}
if(mysql_num_rows($result)){
    echo '<table cellpadding="0" cellspacing="0" class="db-table">';
    echo '<tr><th>Identifiant S&eacute;nario</th><th>Description</th><th>Activ&eacute;</th></tr>';
    while($row = mysql_fetch_row($result)) {
        echo '<tr>';    
        foreach($row as $key=>$value) {
            echo '<td>',$value,'</td>';
            }
        echo '<td><form action="" method="post"><button type="submit" name="buttonScenarioOn',$countScenario,'">ON</button></form></td>';
        $buttonScenarioOn = "buttonScenarioOn".$countScenario;
        /* Appel pour executer le code qui permet de changer de scenario*/
        /*if (isset($_POST[$buttonScenarioOn]))
            exec('code');*/
        echo '</tr>';
        $countScenario++;
        }
    echo '</table></div><br />';
    }

/* Affiche le scenario en cours */
 
$sql = "SELECT * FROM rasplight";
$result = mysql_query($sql, $connection);

if(!$result){
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}
if(mysql_num_rows($result)){
    echo '<div><table cellpadding="0" cellspacing="0" class="db-table">';
    echo '<tr><th>S&eacute;nario en cours</th><th>PID</th></tr>';
    while($row = mysql_fetch_row($result)) {
        echo '<tr>';
        foreach($row as $key=>$value) {
            if($key == 0){
                if($value == NULL)
                    echo '<td>Aucun</td>';
                else echo '<td>Sc&eacute;nario ',$value,'</td>';
            }
            else{
                if($value == NULL)
                    echo '<td></td>';
                else echo '<td>',$value,'</td>';
                }
        }
        echo '</tr>';
        }
    echo '</table></div>';
    }

/* show table light */

echo '<div><h3>Liste des lampes :</h3>';
$sql = "SELECT * FROM light";
$result = mysql_query($sql, $connection);

if(!$result){
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}
if(mysql_num_rows($result)){
	echo '<table cellpadding="0" cellspacing="0" class="db-table">';
	echo '<tr><th>Identifiant Lampe</th><th>&Eacute;tat</th><th>Appair&eacute;</th><th>Puissance</th><th>Xmin</th><th>Xmax</th><th>Ymin</th><th>Ymax</th></tr>';
	while($row = mysql_fetch_row($result)) {
		echo '<tr>';
		foreach($row as $key=>$value) {
			if($key == 0){
			    $lightID = $value;
			    echo '<td>',$value,'</td>';
			    }
			else if($key == 1){
				echo '<td>';
				if($value == 0)
				    echo 'OFF';
				else echo 'ON';
				echo '<form action="" method="post">
				<button type="submit" name="buttonLightOn',$countLight,'">ON</button>
				<button type="submit" name="buttonLightOff',$countLight,'">OFF</button>
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
                echo '<td>';
                if($value == 0)
				    echo 'OFF';
				else echo 'ON';
                echo '<form action="" method="post">
				<button type="submit" name="buttonPairOn',$countLight,'">ON</button>
				<button type="submit" name="buttonPairOff',$countLight,'">OFF</button>
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
	echo '</table></div><br />';
	}
	
echo '</body></html>';
mysql_free_result($result);

?>
