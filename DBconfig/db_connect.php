<?php
ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class DBconfig
{
	private $_username  = 	"root"; 		/* Place your User Name */
	private $_password  = 	"";				/*Place your Password*/
	private $_server    = 	"mysql:host=localhost;dbname=blog_post_db;charset=utf8"; /* Place your Host And Database*/
	private $_options   = 	array(
									PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
									PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
								);
	protected $connection;
	public $item_per_page = 5;
	public function __construct()	
	{
		if( !isset( $this->connection ) )
		{
			try
			{
				$this->connection = new PDO( $this->_server,$this->_username,$this->_password,$this->_options );
			}
			catch( PDOException $e )
			{
				echo 'Cannot connect to database server '. $e->getMessage();
				exit;
			}

		}
		date_default_timezone_set("Asia/Kolkata");
		return $this->connection;
	}
	public function prepare($query)
    {
        return $this->connection->prepare( $query );
    }
    public function last_id()
    {
        return $this->connection->lastInsertId();
    }
    public function to_auto_commit()
    {
        return $this->connection->beginTransaction();
    }
    public function to_roll_back()
    {
        return $this->connection->rollBack();
    }
    public function to_commit()
    {
        return $this->connection->commit();
    }
} 
?>