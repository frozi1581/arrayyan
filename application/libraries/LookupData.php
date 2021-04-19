<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LookupData {
	protected $CI;
	
	var $oraConn="HR";
	var $sql="";
	var $ID="";
	var $urlData="";
	var $arrDisplayNames=array();
	var $retVal=array();
	var $extraJS=array();
	var $paramsGrid=array();
	var $customParamsGrid=array();
	var $paramsDD=array();
	var $customParamsDD=array();
	var $arrParamData=array();
	var $where="";
	var $query="";
	// We'll use a constructor, as you can't directly call a function
        // from a property definition.
		
		public function setClearVars()
		{
			 $this->oraConn="HR";
			 $this->sql="";
			 $this->ID="";
			 $this->urlData="";
			 $this->arrDisplayNames=array();
			 $this->retVal=array();
			 $this->extraJS=array();
			 $this->paramsGrid=array();
			 $this->customParamsGrid=array();
			 $this->arrParamData=array();
			 $this->where="";
			 $this->query="";
		}
		
        public function __construct()
        {
            // Assign the CodeIgniter super-object
            $this->CI =& get_instance();
			
        }
		
		public function initGridLookUp()
		{
			
			$paramsGrid["source"]["ID"] = $this->ID;
			$paramsGrid["url"]=$this->urlData;
			$paramsGrid["retVal"]=$this->retVal;
			$paramsGrid["extraJS"]=$this->extraJS;
			
			$this->CI->load->library('AdodbConn');
			$conn = $this->CI->adodbconn->getOraConn($this->oraConn);
			
			$this->query=$this->sql; //print_r($query);
			
			$arrParamData = array();
			$rst=$conn->PageExecute($this->query,"1","1",$this->arrParamData);
			if($rst)
			{
				if($rst->recordCount()>0)
				{
					$i=0;
					//var_dump($this->customParamsGrid);
					foreach($rst->fields as $key=>$value){
						$arrFields[] = $key;	
						$paramsGrid["source"]["datafields"][$i]["dbfieldname"]=$key;
						$paramsGrid["source"]["datafields"][$i]["name"]=$key;
						$paramsGrid["source"]["datafields"][$i]["type"]="string";
						$paramsGrid["columns"][$i]["text"] = isset($this->customParamsGrid["columns"][$i]["text"])?$this->customParamsGrid["columns"][$i]["text"]:$key;
						$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
						$paramsGrid["columns"][$i]["width"] = isset($this->customParamsGrid["columns"][$i]["width"])?$this->customParamsGrid["columns"][$i]["width"]:"10%";
						$paramsGrid["columns"][$i]["hidden"] = isset($this->customParamsGrid["columns"][$i]["hidden"])?$this->customParamsGrid["columns"][$i]["hidden"]:"false";
						$i++;
					}
									
				}
			}else{
				$errMsg = $conn->ErrorMsg();
			}
			
			return $paramsGrid;
		}
		
		public function getGridData()
		{	
			$arrData = array(); $total_rows = 0;	
			$errMsg = "";$recPerPage = 10;$currPage = 1;$where = "";
			if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
			if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);

			$this->CI->load->library('AdodbConn');
			$conn = $this->CI->adodbconn->getOraConn($this->oraConn);
			
			$this->CI->load->helper('erp_wb_helper');
			
			if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGridLookUp()) ;
			//var_dump($where);
			$this->query=$this->sql.$where; //print_r($query);
			$this->arrParamData = array();
			$rst=$conn->PageExecute($this->query,$recPerPage,$currPage, $this->arrParamData);
			if($rst)
			{
				if($rst->recordCount()>0)
				{
					$total_rows = $this->CI->adodbconn->gettotalrec($conn, $this->query, $this->arrParamData);
					foreach($rst->fields as $key=>$value){
						$arrFields[] = $key;	
					}
					$i=0;
					while(!$rst->EOF)
					{
						
						foreach($arrFields as $keyindex=>$fieldname)
						{
							$arrData[$i][$fieldname] = $rst->fields[$fieldname]; 
						}
						$i++;
						$rst->moveNext();
					}				
				}
			}else{
				$errMsg = $conn->ErrorMsg();
			}

			$data[] = array(
			   'TotalRows' => $total_rows,
			   'Rows' => $arrData,
			   'ErrorMsg'=>$errMsg
			);
			print_r(json_encode($data,JSON_PRETTY_PRINT));

		} 
		
		
		public function initDDLookUp()
		{
			
			$paramsDD["source"]["ID"] = $this->ID;
			$paramsDD["url"]=$this->urlData;
			$paramsDD["retVal"]=$this->retVal;
			$paramsDD["extraJS"]=$this->extraJS;
			
			$this->CI->load->library('AdodbConn');
			$conn = $this->CI->adodbconn->getOraConn($this->oraConn);
			
			$this->query=$this->sql; //print_r($query);
			
			$arrParamData = array();
			$rst=$conn->PageExecute($this->query,"1","1",$this->arrParamData);
			if($rst)
			{
				if($rst->recordCount()>0)
				{
					$i=0;
					//var_dump($this->customParamsGrid);
					foreach($rst->fields as $key=>$value){
						$arrFields[] = $key;	
						$paramsDD["source"]["datafields"][$i]["dbfieldname"]=$key;
						$paramsDD["source"]["datafields"][$i]["name"]=$key;
						//$paramsDD["source"]["datafields"][$i]["type"]="string";
						//$paramsDD["columns"][$i]["text"] = isset($this->customParamsGrid["columns"][$i]["text"])?$this->customParamsGrid["columns"][$i]["text"]:$key;
						//$paramsDD["columns"][$i]["datafield"]=$paramsDD["source"]["datafields"][$i]["name"];
						//$paramsDD["columns"][$i]["width"] = isset($this->customParamsGrid["columns"][$i]["width"])?$this->customParamsGrid["columns"][$i]["width"]:"10%";
						//$paramsDD["columns"][$i]["hidden"] = isset($this->customParamsGrid["columns"][$i]["hidden"])?$this->customParamsGrid["columns"][$i]["hidden"]:"false";
						$i++;
					}
									
				}
			}else{
				$errMsg = $conn->ErrorMsg();
			}
			
			return $paramsDD;
		}
		
		public function getDropDownData()
		{	
			$arrData = array(); $total_rows = 0;	
			$errMsg = "";
			$this->CI->load->library('AdodbConn');
			$conn = $this->CI->adodbconn->getOraConn($this->oraConn);
			
			$this->query=$this->sql; //print_r($query);
			$this->arrParamData = array();
			$rst=$conn->Execute($this->query, $this->arrParamData);
			if($rst)
			{
				if($rst->recordCount()>0)
				{
					foreach($rst->fields as $key=>$value){
						$arrFields[] = $key;	
					}
					$i=0;
					while(!$rst->EOF)
					{
						
						foreach($arrFields as $keyindex=>$fieldname)
						{
							$arrData[$i][$fieldname] = $rst->fields[$fieldname]; 
						}
						$i++;
						$rst->moveNext();
					}				
				}
			}else{
				$errMsg = $conn->ErrorMsg();
			}

			$data[] =  $arrData;

			print_r(json_encode($data,JSON_PRETTY_PRINT));

		}
	
		public function getSelect2Data($allowAddNew=false, $addNewText='')
		{
			$arrData = array(); $total_rows = 0;
			$errMsg = "";
			$this->CI->load->library('AdodbConnMySQL');
			$conn = $this->CI->adodbconnmysql->getMySQLConn("HR");
			
			
			$conn->SetFetchMode(ADODB_FETCH_ASSOC);
			
			$this->query=$this->sql; //print_r($query);
			$this->arrParamData = array();
			$rst=$conn->Execute($this->query, $this->arrParamData);
			
			
			if($rst)
			{
				if($rst->recordCount()>0)
				{
					
					$i=0;
					$arrData[$i]['id'] = "";
					$arrData[$i]['text'] = "";
					$i++;
					while(!$rst->EOF)
					{
						$arrData[$i]['id'] = $rst->fields["ID"];
						$arrData[$i]['text'] = $rst->fields["TEXT"];
						$i++;
						$rst->moveNext();
					}
				}else{
					if($allowAddNew){
						$i=0;
						$arrData[$i]['id'] = "NEW";
						$arrData[$i]['text'] = $addNewText;
					}
				}
			}else{
				$errMsg = $conn->ErrorMsg();
			}
			
			$data['results'] =  $arrData;
			
			print_r(json_encode($data,JSON_PRETTY_PRINT));
			
		}
	
	public function getJQXInputData()
	{
		$arrData = array(); $total_rows = 0;
		$errMsg = "";
		$this->CI->load->library('AdodbConnMySQL');
		$conn = $this->CI->adodbconnmysql->getMySQLConn("HR");
		
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		$this->query=$this->sql; //print_r($query);
		$this->arrParamData = array();
		$rst=$conn->Execute($this->query, $this->arrParamData);
		
		if($rst)
		{
			if($rst->recordCount()>0)
			{
				
				$i=0;
				$arrData[$i]['id'] = "";
				$arrData[$i]['text'] = "";
				$i++;
				while(!$rst->EOF)
				{
					$arrData[$i]['id'] = $rst->fields["ID"];
					$arrData[$i]['text'] = $rst->fields["TEXT"];
					$i++;
					$rst->moveNext();
				}
			}
		}else{
			$errMsg = $conn->ErrorMsg();
		}
		
		//$data['results'] =  $arrData;
		
		print_r(json_encode($arrData,JSON_PRETTY_PRINT));
		
	}
}