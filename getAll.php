function db_connect(){
	$db = new mysqli("localhost", "ICT", "password", "my_ICT");
    return $db;
}

function articolo($db,$art){
  $stmt = $db->prepare("SELECT * from articoli WHERE id=?");
  $stmt->bind_param("i", $art); 
  $stmt->execute();
  $result = $stmt->get_result();
  $ris=array();
  while($row = $result->fetch_assoc()) $ris[]=$row;
  return $ris;
}

function articoliByCat($db,$cat){
  $stmt = $db->prepare("SELECT * from articoli WHERE categoria=? ORDER BY data DESC");
  $stmt->bind_param("i", $cat); 
  $stmt->execute();
  $result = $stmt->get_result();
  $ris=array();
  while($row = $result->fetch_assoc()) $ris[]=$row;
  return $ris;
}

function articoli($db,$page=0,$perPage=All){
  $stmt = $db->prepare("SELECT * from articoli ORDER BY data DESC");
  $stmt->execute();
  $result = $stmt->get_result();
  $ris=array();
  while($row = $result->fetch_assoc()) $ris[]=$row;
  return $ris;
}
