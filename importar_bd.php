<?php
$host = 'localhost';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS biblioteca";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados criado com sucesso ou já existente.<br>";
} else {
    echo "Erro ao criar banco de dados: " . $conn->error . "<br>";
    exit;
}

$conn->select_db("biblioteca");

$sql_file = file_get_contents('BANCO DE DADOS/biblioteca.sql');

$sql_file = preg_replace('/\/\*.*?\*\//s', '', $sql_file);
$sql_file = preg_replace('/--.*?\n/', '\n', $sql_file);
$sql_file = preg_replace('/\n\n/', '\n', $sql_file);

$commands = explode(';', $sql_file);

$success = true;
foreach ($commands as $command) {
    $command = trim($command);
    if (!empty($command)) {
        if ($conn->query($command) === FALSE) {
            echo "Erro ao executar comando: " . $conn->error . "<br>";
            echo "Comando: " . $command . "<br><br>";
            $success = false;
        }
    }
}

if ($success) {
    echo "<h2>Banco de dados importado com sucesso!</h2>";
    echo "<p>O banco de dados 'biblioteca' foi criado e todas as tabelas foram importadas.</p>";
    echo "<p>Agora você pode acessar o sistema normalmente.</p>";
    echo "<p><a href='index.php'>Ir para o sistema</a></p>";
} else {
    echo "<h2>Houve alguns erros durante a importação.</h2>";
    echo "<p>Verifique as mensagens acima para mais detalhes.</p>";
}

$conn->close();
?>