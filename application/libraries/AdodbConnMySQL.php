<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AdodbConnMySQL {
	protected $CI;
	// We'll use a constructor, as you can't directly call a function
        // from a property definition.
        public function __construct()
        {
                // Assign the CodeIgniter super-object
                $this->CI =& get_instance();
        }
		
        public function getMySQLConn($schema="")
        {
			
			$host = $this->CI->db->hostname;
			
			$user = $this->CI->db->username;
			$passwd = $this->CI->db->password;
			
			$dbname = $this->CI->db->database;
			include "adodb5/adodb.inc.php";
			$conn = NewADOConnection("mysqli");
			$conn->Connect($host, $user, $passwd,$dbname);

			$conn->SetFetchMode(ADODB_FETCH_ASSOC);
			return $conn;
        }
		
		public function gettotalrec($conn,$query, $arrParamData)
		{
			$query = "select count(*) as jml from ($query) as a ";
			
			$rst=$conn->Execute($query, $arrParamData);
			
			return $rst->fields["jml"];
			
		}
}