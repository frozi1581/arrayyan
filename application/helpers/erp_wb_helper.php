<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('genJQWFilterSQL'))
{
	function genJQWFilterSQL($paramsGrid) 
	{
		
		$fieldIsDate = false;	
		$where = "";
		// filter data.
		if (isset($_GET['filterscount']))
		{
			$filterscount = $_GET['filterscount'];
			
			if ($filterscount > 0)
			{
				#$where = " WHERE (";
				$where = " AND (";
				$tmpdatafield = "";
				$tmpfilteroperator = "";
				for ($i=0; $i < $filterscount; $i++)
				{
					// get the filter's value.
					$filtervalue = $_GET["filtervalue" . $i];
					// get the filter's condition.
					$filtercondition = $_GET["filtercondition" . $i];
					// get the filter's column.
					$filterdatafield = $_GET["filterdatafield" . $i];
					// get the filter's operator.
					$filteroperator = $_GET["filteroperator" . $i];
					
					if ($tmpdatafield == "")
					{
						$tmpdatafield = $filterdatafield;			
					}
					else if ($tmpdatafield <> $filterdatafield)
					{
						$where .= ")AND(";
					}
					else if ($tmpdatafield == $filterdatafield)
					{
						if ($tmpfilteroperator == 0)
						{
							$where .= " AND ";
						}
						else $where .= " OR ";	
					}
					
					foreach($paramsGrid["source"]["datafields"] as $key=>$value){
						if($value["name"]==$filterdatafield){
							$filterdatafield = $value["dbfieldname"];
							if($value["type"]=="date"){
								$fieldIsDate = true;
								$filterdatafield = "trim(".$value["dbfieldname"].")";
							}
							if($value["type"]=="bool"){
								if($filtervalue=='false'){
									$filtervalue='0';
								}else{
									$filtervalue='1';
								}
							}
							break;
						}
					}
					
					
					//var_dump($paramsGrid["source"]["datafields"][$i]["type"]);
					
					if(!$fieldIsDate){
						// build the "WHERE" clause depending on the filter's condition, value and datafield.
						switch($filtercondition)
						{
							case "CONTAINS":
								$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";
								break;
							case "DOES_NOT_CONTAIN":
								$where .= " " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";
								break;
							case "EQUAL":
								$where .= " " . $filterdatafield . " = '" . $filtervalue ."'";
								break;
							case "NOT_EQUAL":
								$where .= " " . $filterdatafield . " <> '" . $filtervalue ."'";
								break;
							case "GREATER_THAN":
								$where .= " " . $filterdatafield . " > '" . $filtervalue ."'";
								break;
							case "LESS_THAN":
								$where .= " " . $filterdatafield . " < '" . $filtervalue ."'";
								break;
							case "GREATER_THAN_OR_EQUAL":
								$where .= " " . $filterdatafield . " >= '" . $filtervalue ."'";
								break;
							case "LESS_THAN_OR_EQUAL":
								$where .= " " . $filterdatafield . " <= '" . $filtervalue ."'";
								break;
							case "STARTS_WITH":
								$where .= " " . $filterdatafield . " LIKE '" . $filtervalue ."%'";
								break;
							case "ENDS_WITH":
								$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."'";
								break;
						}
					}else{
						// build the "WHERE" clause depending on the filter's condition, value and datafield.
						switch($filtercondition)
						{
							case "EQUAL":
								$where .= " " . $filterdatafield . " = STR_TO_DATE('" . $filtervalue ."','%d-%m-%Y')";
								break;
							case "NOT_EQUAL":
								$where .= " " . $filterdatafield . " <> STR_TO_DATE('" . $filtervalue ."','%d-%m-%Y')";
								break;
							case "GREATER_THAN":
								$where .= " " . $filterdatafield . " > STR_TO_DATE('" . $filtervalue ."','%d-%m-%Y')";
								break;
							case "LESS_THAN":
								$where .= " " . $filterdatafield . " < STR_TO_DATE('" . $filtervalue ."','%d-%m-%Y')";
								break;
							case "GREATER_THAN_OR_EQUAL":
								$where .= " " . $filterdatafield . " >= STR_TO_DATE('" . $filtervalue ."','%d-%m-%Y')";
								break;
							case "LESS_THAN_OR_EQUAL":
								$where .= " " . $filterdatafield . " <= STR_TO_DATE('" . $filtervalue ."','%d-%m-%Y')";
								break;
							
						}
					}
					
					if ($i == $filterscount - 1)
					{
						$where .= ")";
					}
					
					$tmpfilteroperator = $filteroperator;
					$tmpdatafield = $filterdatafield;			
				}
			}
		}
		
		if(isset($_GET["sortdatafield"])){
			$where.=" order by ".$_GET["sortdatafield"]." ".$_GET["sortorder"];	
		}
		
		return $where;
	}
}

if ( ! function_exists('genGrid'))
{	
	function genGrid($idGrid,$paramsGrid,$isDropDownButton=false,$gridHeight='99%')
	{
		if($isDropDownButton)
		{
			$strRetVal="<div id=\"jqxDDB".$idGrid."\"><div style=\"border-color: transparent;width:100%;\" id=\"".$idGrid."\"></div></div>";
		}else{
			$strRetVal="<div style=\"border-color: transparent;width:100%;\" id=\"".$idGrid."\"></div>";
		}		
		$strRetVal.="
		<script type=\"text/javascript\">
		$(document).ready(function () {
			var theme = 'darkblue';
			var source".$idGrid." =
            {
                 datatype: \"json\",
                 datafields: [";
		$i=0;
		foreach($paramsGrid["source"]["datafields"] as $key=>$value){
			if($i==(count($paramsGrid["source"]["datafields"])-1) ){
				$strRetVal .= "{name:'".$value["name"]."', type:'".$value["type"]."'}\n";
			}else{
				$strRetVal .= "{name:'".$value["name"]."', type:'".$value["type"]."'},\n";
			}
			$i++;
		}
					
		$strRetVal.="			
                ],
			    url: '".$paramsGrid["url"]."',
				root: 'Rows',
				id: '".$paramsGrid["source"]["ID"]."',
				filter: function()
				{
					// update the grid and send a request to the server.
					$(\"#".$idGrid."\").jqxGrid('updatebounddata', 'filter');
				},
				sort: function()
				{
					// update the grid and send a request to the server.
					$(\"#".$idGrid."\").jqxGrid('updatebounddata', 'sort');
				},
				beforeprocessing: function(data)
				{		
					
					if (data != null)
					{
						source".$idGrid.".totalrecords = data[0].TotalRows;	
						if(data[0].ErrorMsg!=''){
							alert(data[0].ErrorMsg);
						}
					}
				}
            };		";
		
		$strRetVal.=" var dataadapter".$idGrid." = new $.jqx.dataAdapter(source".$idGrid.", {
					loadError: function(xhr, status, error)
					{
						alert(error);
					}
				}
			);";
		
		$strRetVal.="
            $(\"#".$idGrid."\").jqxGrid(
            {	width: '".$gridHeight."',
				source: dataadapter".$idGrid.",
                theme: '".(isset($paramsGrid["theme"])?$paramsGrid["theme"]:'darkblue')."',
				filterable:'".(isset($paramsGrid["filterable"])?$paramsGrid["filterable"]:'true')."',
				showfilterrow: '".(isset($paramsGrid["showfilterrow"])?$paramsGrid["showfilterrow"]:'true')."',
				pageable: '".(isset($paramsGrid["pageable"])?$paramsGrid["pageable"]:"true")."',
				pagesize: ".(isset($paramsGrid["pagesize"])?$paramsGrid["pagesize"]:"10").",
				rowsheight: ".(isset($paramsGrid["rowsheight"])?$paramsGrid["rowsheight"]:"30").",
				sortable: '".(isset($paramsGrid["sortable"])?$paramsGrid["sortable"]:"true")."',
                virtualmode: true,
				altrows:true,
				rendergridrows: function () {
                    return dataadapter".$idGrid.".records;
                },					
			    columns: [
				
				";
		
		$i=0;
		foreach($paramsGrid["columns"] as $key=>$value){
			$strListColumns="{ align:'center',";
			foreach($value as $key2=>$value2){
				if($key2=='hidden' || $key2=='cellsrenderer' || $key2=='buttonclick' || $key2=='filterable' || $key2=='sortable'){
					$strListColumns .= $key2.":".$value2.",";
				}else{
					$strListColumns .= $key2.":'".$value2."',";
				}
			}
			$strListColumns = (substr($strListColumns,-1) == ',') ? substr($strListColumns, 0, -1) : $strListColumns;
				
			if($i==(count($paramsGrid["columns"])-1) ){
				$strListColumns.="}";
			}else{
				$strListColumns.="},";
			}
			$strRetVal.= $strListColumns."\n";
			$i++;
		}
					
		$strRetVal.="			
                  ]
            });	";
		
		if($isDropDownButton)
		{
			$strRetVal.="$(\"#jqxDDB".$idGrid."\").jqxDropDownButton({theme:theme, width: 350, height: 25});";
			$strRetVal.="$(\"#".$idGrid."\").on('rowselect', function (event) {
					var args = event.args;
					var row = $(\"#".$idGrid."\").jqxGrid('getrowdata', args.rowindex);
					var dropDownContent = '<div style=\"position: relative; margin-left: 3px; margin-top: 5px;\">' + row['".$paramsGrid["columns"][1]["datafield"]."'] + '</div>';
					$(\"#jqxDDB".$idGrid."\").jqxDropDownButton('setContent', dropDownContent);";
			if(isset($paramsGrid["retVal"])){		
				if(is_array($paramsGrid["retVal"]))
				{
					foreach($paramsGrid["retVal"] as $key=>$value)
					{	
						$strRetVal.=" var valuetoselect = row['".$value["targetDataField"]."'];";
						$strRetVal.=" $('#".$value["destCtrl"]."').val(valuetoselect);";
					}
				}
			}
			if(isset($paramsGrid["extraJS"])){
				if(is_array($paramsGrid["extraJS"])){
					foreach($paramsGrid["extraJS"] as $key=>$value){
						$strRetVal.= $value["extraJS"]."\n";
					}
				}
			}
			$strRetVal.=" $(\"#jqxDDB".$idGrid."\").jqxDropDownButton('close'); ";
			$strRetVal.="	});";
		}
		
		$strRetVal.="});";
		$strRetVal.="</script>";
		return $strRetVal;
	}
}

