<?php

echo "PHP Funcionando para scripts";

$dir    = './';
$files1 = scandir($dir);

echo '<ul>';
foreach ($files1 as $key => $value) {
	if (strlen($value) > 2) {
		$arquivo = str_replace('.php', '', $value);
		echo "<li><a target='_blank' href='$value'>Abrir $arquivo - ($value)</a></li>";
	}
}
echo '</ul>';



echo 'Versão Atual do PHP: ' . phpversion();

$servername = "db";
$username = "root";
$password = "brasil";

// Create connection
$conn = new mysqli($servername, $username, $password, 'contato');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<br /> Connected successfully";
?>

</html>