<?php
require'././src/Users.php';
require'././src/Items.php';
require'././src/Orders.php';
require'././src/Categories.php';
require'././src/Admins.php';



class Workshop2BaseTest extends PHPUnit_Extensions_Database_TestCase{
	public function getConnection( ) {
		$conn= new PDO($GLOBALS['DB_DSN'],$GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
		return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_DBNAME']);
	}
	
	public function getDataSet( )
	{
		$dataXML= $this->createFlatXmlDataSet('tests/db.xml');
		return $dataXML;
	}
	
	public static function setUpBeforeClass()
	{
		$Item=Item::SetConnection(new mysqli('localhost' , $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']));
	}
	
	
	public function testDB()
	{
		
		$this->assertEquals(2,2);
	}
	
	
	
}