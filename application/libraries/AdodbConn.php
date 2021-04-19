<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AdodbConn {
	protected $CI;
	// We'll use a constructor, as you can't directly call a function
        // from a property definition.
        public function __construct()
        {
                // Assign the CodeIgniter super-object
                $this->CI =& get_instance();
        }
		
        public function getOraConn($schema="")
        {
			$this->CI->db->hostipaddr;
			$host = $this->CI->db->hostipaddr;
			switch($schema){
				case "HR":
					$user = $this->CI->db->usernameHR;
					$passwd = $this->CI->db->passwordHR;
					break;
				case "OS":
					$user = $this->CI->db->usernameOS;
					$passwd = $this->CI->db->passwordOS;
					break;	
				case "FN":
					$user = $this->CI->db->usernameFN;
					$passwd = $this->CI->db->passwordFN;
					break;
				default:
					$user = $this->CI->db->username;
					$passwd = $this->CI->db->password;
			}
			
			$dbname = $this->CI->db->database;
			include "adodb5/adodb.inc.php";
			$conn = NewADOConnection("oci8");
			$conn->Connect($host."/".$dbname, $user, $passwd);

			$conn->SetFetchMode(ADODB_FETCH_ASSOC);
			return $conn;
        }
		
		public function gettotalrec($conn,$query, $arrParamData)
		{
			$query = "select count(*) as jml from ($query) ";
			
			$rst=$conn->Execute($query, $arrParamData);
			
			return $rst->fields["JML"];
			
		}
}