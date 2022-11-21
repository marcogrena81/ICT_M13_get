function rispondi_json($data){
	http_response_code(200);
	echo json_encode($data,JSON_INVALID_UTF8_IGNORE);
}

class risposta{
    public $method;
    public $action;
    public $data;

    public function __construct($m,$a,$d) {
        $this->method = $m;
        $this->action = $a;
        $this->data = $d;
    }

}

function permessi(){
// Allow from any origin
if(isset($_SERVER["HTTP_ORIGIN"]))
{
    // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}
else
{
    //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
    header("Access-Control-Allow-Origin: *");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 600");    // cache for 10 minutes

if($_SERVER["REQUEST_METHOD"] == "OPTIONS")
{
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT"); //Make sure you remove those you do not want to support

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
    exit(0);
}
//From here, handle the request as it is ok
  
}

function risposta(){
//header("Access-Control-Allow-Credentials: true");
//header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
//header("Access-Control-Allow-Methods: GET,POST, OPTIONS");

header("Content-Type: application/json; charset= utf-8");

$oggetto=null;


if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Grena ICT"');
    header('HTTP/1.0 401 Unauthorized');
    errore(401,"Basic Auth not sent");
    exit;
} 
else {
    if ($_SERVER['PHP_AUTH_USER']!="test" || $_SERVER['PHP_AUTH_PW']!="test")
    	errore(401,"Basic Auth error. Auth_user or password not valid");
    else{
		$parametri=gestisci_URI();
        if (is_null($parametri))
          documentazione();
        
                
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        	if (!isset($parametri[0]))
              errore(400,"title and description expexted");
            if ($parametri[0]=="partita"){
            	if (!isset($parametri[1]))
                  errore(400,"description expected");
                else { 
            	//inserisci partita
                $articolo["id"]=insert_articolo(db_connect(),$parametri[1]);
				$oggetto=new risposta("POST","New article created",$articolo);
                }
            }
        
        }
        else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        	if (!isset($parametri[0]))
              //restituisci tutti;
            if ($parametri[0]=="articolo"){
            	$art=array();
            	$articoli=articoli(db_connect());
				$oggetto=new risposta("GET","articoli",$articoli);
			}
            else if ($parametri[0]=="cat"){
				...
             }
           

		array_push($parametri,$oggetto);
        rispondi_json($oggetto);

	}
}