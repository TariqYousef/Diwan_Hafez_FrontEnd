<?

class DbConnection
{

	private static $host="localhost";
	private static $Dbname="tariqy_caligner";
	private static $username="tariqy_caligner";
	private static $password="Tariq@caligner";
	
	private static $con;

	// Protected constructor to prevent creating a new instance of the
    // DbConnection via the `new` operator from outside of this class.
	protected function __construct()
    {
    }
    
    //  Private clone method to prevent cloning of the instance of the DbConnection instance.
    private function __clone()
    {
    }
    
	// implementation of Singleton design pattern
	public static function getInstance(){
		if (null === self::$con) {
			self::$con= new mysqli(self::$host, self::$username, self::$password, self::$Dbname);
			self::$con->set_charset("utf8");
        }
        return self::$con;	
	}
	
}

/* testing 
$con=DbConnection::getInstance();
$res=$con->query("select hdwd,pofs from WN_lemmas_grc limit 0,10");
print_r($res);
*/
?>