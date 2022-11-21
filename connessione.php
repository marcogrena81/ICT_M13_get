function db_connect(){
	$db = new mysqli("localhost", "ICT", "password", "my_ICT");
    return $db;
}
function db_close($conn){
    $conn->close();
}