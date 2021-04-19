<?php

// Global variable for table object
$tb_notifikasi_d = NULL;

//
// Table class for tb_notifikasi_d
//
class ctb_notifikasi_d extends cTable {
	var $id;
	var $employee_id;
	var $bagian;
	var $lokasi_kerja;
	var $notif_active;
	var $status_notif;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tb_notifikasi_d';
		$this->TableName = 'tb_notifikasi_d';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`tb_notifikasi_d`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('tb_notifikasi_d', 'tb_notifikasi_d', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// employee_id
		$this->employee_id = new cField('tb_notifikasi_d', 'tb_notifikasi_d', 'x_employee_id', 'employee_id', '`employee_id`', '`employee_id`', 200, -1, FALSE, '`employee_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->employee_id->Sortable = TRUE; // Allow sort
		$this->fields['employee_id'] = &$this->employee_id;

		// bagian
		$this->bagian = new cField('tb_notifikasi_d', 'tb_notifikasi_d', 'x_bagian', 'bagian', '`bagian`', '`bagian`', 200, -1, FALSE, '`bagian`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bagian->Sortable = TRUE; // Allow sort
		$this->fields['bagian'] = &$this->bagian;

		// lokasi_kerja
		$this->lokasi_kerja = new cField('tb_notifikasi_d', 'tb_notifikasi_d', 'x_lokasi_kerja', 'lokasi_kerja', '`lokasi_kerja`', '`lokasi_kerja`', 200, -1, FALSE, '`lokasi_kerja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->lokasi_kerja->Sortable = TRUE; // Allow sort
		$this->fields['lokasi_kerja'] = &$this->lokasi_kerja;

		// notif_active
		$this->notif_active = new cField('tb_notifikasi_d', 'tb_notifikasi_d', 'x_notif_active', 'notif_active', '`notif_active`', '`notif_active`', 200, -1, FALSE, '`notif_active`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->notif_active->Sortable = TRUE; // Allow sort
		$this->notif_active->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->notif_active->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->notif_active->OptionCount = 2;
		$this->fields['notif_active'] = &$this->notif_active;

		// status_notif
		$this->status_notif = new cField('tb_notifikasi_d', 'tb_notifikasi_d', 'x_status_notif', 'status_notif', 'case when notif_active=\'Y\' then \'Belum Dibaca\' else \'Sudah Dibaca\' end', 'case when notif_active=\'Y\' then \'Belum Dibaca\' else \'Sudah Dibaca\' end', 200, -1, FALSE, 'case when notif_active=\'Y\' then \'Belum Dibaca\' else \'Sudah Dibaca\' end', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status_notif->FldIsCustom = TRUE; // Custom field
		$this->status_notif->Sortable = TRUE; // Allow sort
		$this->fields['status_notif'] = &$this->status_notif;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "tb_notifikasi") {
			if ($this->id->getSessionValue() <> "")
				$sMasterFilter .= "`id`=" . ew_QuotedValue($this->id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "tb_notifikasi") {
			if ($this->id->getSessionValue() <> "")
				$sDetailFilter .= "`id`=" . ew_QuotedValue($this->id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_tb_notifikasi() {
		return "`id`=@id@";
	}

	// Detail filter
	function SqlDetailFilter_tb_notifikasi() {
		return "`id`=@id@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tb_notifikasi_d`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT *, case when notif_active='Y' then 'Belum Dibaca' else 'Sudah Dibaca' end AS `status_notif` FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
			if (array_key_exists('employee_id', $rs))
				ew_AddFilter($where, ew_QuotedName('employee_id', $this->DBID) . '=' . ew_QuotedValue($rs['employee_id'], $this->employee_id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@ AND `employee_id` = '@employee_id@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (is_null($this->employee_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@employee_id@", ew_AdjustSql($this->employee_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "tb_notifikasi_dlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "tb_notifikasi_dview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "tb_notifikasi_dedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "tb_notifikasi_dadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "tb_notifikasi_dlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tb_notifikasi_dview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tb_notifikasi_dview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tb_notifikasi_dadd.php?" . $this->UrlParm($parm);
		else
			$url = "tb_notifikasi_dadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("tb_notifikasi_dedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("tb_notifikasi_dadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tb_notifikasi_ddelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "tb_notifikasi" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		$json .= ",employee_id:" . ew_VarToJson($this->employee_id->CurrentValue, "string", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->employee_id->CurrentValue)) {
			$sUrl .= "&employee_id=" . urlencode($this->employee_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["id"]))
				$arKey[] = $_POST["id"];
			elseif (isset($_GET["id"]))
				$arKey[] = $_GET["id"];
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["employee_id"]))
				$arKey[] = $_POST["employee_id"];
			elseif (isset($_GET["employee_id"]))
				$arKey[] = $_GET["employee_id"];
			else
				$arKeys = NULL; // Do not setup
			if (is_array($arKeys)) $arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_array($key) || count($key) <> 2)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[0])) // id
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key[0];
			$this->employee_id->CurrentValue = $key[1];
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->employee_id->setDbValue($rs->fields('employee_id'));
		$this->bagian->setDbValue($rs->fields('bagian'));
		$this->lokasi_kerja->setDbValue($rs->fields('lokasi_kerja'));
		$this->notif_active->setDbValue($rs->fields('notif_active'));
		$this->status_notif->setDbValue($rs->fields('status_notif'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// employee_id

		$this->employee_id->CellCssStyle = "white-space: nowrap;";

		// bagian
		// lokasi_kerja
		// notif_active
		// status_notif
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// employee_id
		$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
		if (strval($this->employee_id->CurrentValue) <> "") {
			$sFilterWrk = "a.employee_id" . ew_SearchString("=", $this->employee_id->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `employee_id`, `name` AS `DispFld`, `lok_kerja` AS `Disp2Fld`, `bagian` AS `Disp3Fld`, '' AS `Disp4Fld` FROM ( SELECT a.employee_id, CASE WHEN a.first_name <> '' AND a.last_name <> '' THEN Concat(a.first_name, ' ', a.last_name) WHEN a.first_name IS NULL AND a.last_name IS NULL THEN a.first_title WHEN a.first_name <> '' THEN a.first_name ELSE a.last_name END AS name, b.KET lok_kerja, c.ket bagian FROM personal a LEFT JOIN tb_pat b ON a.kd_pat = b.KD_PAT LEFT JOIN tb_gas c ON a.kd_gas = c.kd_gas ORDER BY a.kd_pat )a";
		$sWhereWrk = "";
		$this->employee_id->LookupFilters = array("dx1" => 'a.name', "dx2" => 'a.lok_kerja', "dx3" => 'a.bagian');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->employee_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->employee_id->ViewValue = $this->employee_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
			}
		} else {
			$this->employee_id->ViewValue = NULL;
		}
		$this->employee_id->ViewCustomAttributes = "";

		// bagian
		$this->bagian->ViewValue = $this->bagian->CurrentValue;
		$this->bagian->ViewCustomAttributes = "";

		// lokasi_kerja
		$this->lokasi_kerja->ViewValue = $this->lokasi_kerja->CurrentValue;
		$this->lokasi_kerja->ViewCustomAttributes = "";

		// notif_active
		if (strval($this->notif_active->CurrentValue) <> "") {
			$this->notif_active->ViewValue = $this->notif_active->OptionCaption($this->notif_active->CurrentValue);
		} else {
			$this->notif_active->ViewValue = NULL;
		}
		$this->notif_active->ViewCustomAttributes = "";

		// status_notif
		$this->status_notif->ViewValue = $this->status_notif->CurrentValue;
		$this->status_notif->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// employee_id
		$this->employee_id->LinkCustomAttributes = "";
		$this->employee_id->HrefValue = "";
		$this->employee_id->TooltipValue = "";

		// bagian
		$this->bagian->LinkCustomAttributes = "";
		$this->bagian->HrefValue = "";
		$this->bagian->TooltipValue = "";

		// lokasi_kerja
		$this->lokasi_kerja->LinkCustomAttributes = "";
		$this->lokasi_kerja->HrefValue = "";
		$this->lokasi_kerja->TooltipValue = "";

		// notif_active
		$this->notif_active->LinkCustomAttributes = "";
		$this->notif_active->HrefValue = "";
		$this->notif_active->TooltipValue = "";

		// status_notif
		$this->status_notif->LinkCustomAttributes = "";
		$this->status_notif->HrefValue = "";
		$this->status_notif->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// employee_id
		$this->employee_id->EditAttrs["class"] = "form-control";
		$this->employee_id->EditCustomAttributes = "";
		$this->employee_id->EditValue = $this->employee_id->CurrentValue;
		if (strval($this->employee_id->CurrentValue) <> "") {
			$sFilterWrk = "a.employee_id" . ew_SearchString("=", $this->employee_id->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `employee_id`, `name` AS `DispFld`, `lok_kerja` AS `Disp2Fld`, `bagian` AS `Disp3Fld`, '' AS `Disp4Fld` FROM ( SELECT a.employee_id, CASE WHEN a.first_name <> '' AND a.last_name <> '' THEN Concat(a.first_name, ' ', a.last_name) WHEN a.first_name IS NULL AND a.last_name IS NULL THEN a.first_title WHEN a.first_name <> '' THEN a.first_name ELSE a.last_name END AS name, b.KET lok_kerja, c.ket bagian FROM personal a LEFT JOIN tb_pat b ON a.kd_pat = b.KD_PAT LEFT JOIN tb_gas c ON a.kd_gas = c.kd_gas ORDER BY a.kd_pat )a";
		$sWhereWrk = "";
		$this->employee_id->LookupFilters = array("dx1" => 'a.name', "dx2" => 'a.lok_kerja', "dx3" => 'a.bagian');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->employee_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->employee_id->EditValue = $this->employee_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->employee_id->EditValue = $this->employee_id->CurrentValue;
			}
		} else {
			$this->employee_id->EditValue = NULL;
		}
		$this->employee_id->ViewCustomAttributes = "";

		// bagian
		$this->bagian->EditAttrs["class"] = "form-control";
		$this->bagian->EditCustomAttributes = "";
		$this->bagian->EditValue = $this->bagian->CurrentValue;
		$this->bagian->ViewCustomAttributes = "";

		// lokasi_kerja
		$this->lokasi_kerja->EditAttrs["class"] = "form-control";
		$this->lokasi_kerja->EditCustomAttributes = "";
		$this->lokasi_kerja->EditValue = $this->lokasi_kerja->CurrentValue;
		$this->lokasi_kerja->ViewCustomAttributes = "";

		// notif_active
		$this->notif_active->EditAttrs["class"] = "form-control";
		$this->notif_active->EditCustomAttributes = "";
		$this->notif_active->EditValue = $this->notif_active->Options(TRUE);

		// status_notif
		$this->status_notif->EditAttrs["class"] = "form-control";
		$this->status_notif->EditCustomAttributes = "";
		$this->status_notif->EditValue = $this->status_notif->CurrentValue;
		$this->status_notif->PlaceHolder = ew_RemoveHtml($this->status_notif->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->employee_id->Exportable) $Doc->ExportCaption($this->employee_id);
					if ($this->bagian->Exportable) $Doc->ExportCaption($this->bagian);
					if ($this->lokasi_kerja->Exportable) $Doc->ExportCaption($this->lokasi_kerja);
					if ($this->notif_active->Exportable) $Doc->ExportCaption($this->notif_active);
					if ($this->status_notif->Exportable) $Doc->ExportCaption($this->status_notif);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->employee_id->Exportable) $Doc->ExportCaption($this->employee_id);
					if ($this->bagian->Exportable) $Doc->ExportCaption($this->bagian);
					if ($this->lokasi_kerja->Exportable) $Doc->ExportCaption($this->lokasi_kerja);
					if ($this->notif_active->Exportable) $Doc->ExportCaption($this->notif_active);
					if ($this->status_notif->Exportable) $Doc->ExportCaption($this->status_notif);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->employee_id->Exportable) $Doc->ExportField($this->employee_id);
						if ($this->bagian->Exportable) $Doc->ExportField($this->bagian);
						if ($this->lokasi_kerja->Exportable) $Doc->ExportField($this->lokasi_kerja);
						if ($this->notif_active->Exportable) $Doc->ExportField($this->notif_active);
						if ($this->status_notif->Exportable) $Doc->ExportField($this->status_notif);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->employee_id->Exportable) $Doc->ExportField($this->employee_id);
						if ($this->bagian->Exportable) $Doc->ExportField($this->bagian);
						if ($this->lokasi_kerja->Exportable) $Doc->ExportField($this->lokasi_kerja);
						if ($this->notif_active->Exportable) $Doc->ExportField($this->notif_active);
						if ($this->status_notif->Exportable) $Doc->ExportField($this->status_notif);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;
		if (preg_match('/^x(\d)*_employee_id$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `bagian` AS FIELD0, `lok_kerja` AS FIELD1 FROM ( SELECT a.employee_id, CASE WHEN a.first_name <> '' AND a.last_name <> '' THEN Concat(a.first_name, ' ', a.last_name) WHEN a.first_name IS NULL AND a.last_name IS NULL THEN a.first_title WHEN a.first_name <> '' THEN a.first_name ELSE a.last_name END AS name, b.KET lok_kerja, c.ket bagian FROM personal a LEFT JOIN tb_pat b ON a.kd_pat = b.KD_PAT LEFT JOIN tb_gas c ON a.kd_gas = c.kd_gas ORDER BY a.kd_pat )a";
			$sWhereWrk = "(a.employee_id = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->employee_id->LookupFilters = array("dx1" => 'a.name', "dx2" => 'a.lok_kerja', "dx3" => 'a.bagian');
			$this->Lookup_Selecting($this->employee_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->bagian->setDbValue($rs->fields[0]);
					$this->lokasi_kerja->setDbValue($rs->fields[1]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->bagian->AutoFillOriginalValue) ? $this->bagian->CurrentValue : $this->bagian->EditValue;
					$ar[] = ($this->lokasi_kerja->AutoFillOriginalValue) ? $this->lokasi_kerja->CurrentValue : $this->lokasi_kerja->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here

	/*	if (isset($_SESSION['u_id'])){
			ew_AddFilter($filter, "`tb_notifikasi_d`.`employee_id` IN ('" . $_SESSION['u_id'] . "')");
		}else{
			ew_AddFilter($filter, "`tb_notifikasi_d`.`employee_id` IN ('')");
		}
	*/
		if(isset( $_REQUEST["u_id"])){ 
			$id=$_REQUEST["u_id"];
			$_SESSION['u_id']=$id;
		}
		if(isset($_REQUEST["back"])){
			$_SESSION['home']=$_REQUEST["back"];
		}
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		$rsnew['notif_active']='Y';
		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
		$query="select a.id,a.topic,a.isi_notif,a.action,b.employee_id,c.device_id from tb_notifikasi a
				inner join tb_notifikasi_d b on a.id=b.id
				inner join m_users c on c.user_id=b.employee_id 
				where a.id=".$rsnew['id']." and length(c.device_id)>3";
		$rs = ew_LoadRecordset($query);
		$rows = $rs->GetRows();
		foreach ($rows as $data) {
				$reg_Id  = $data['device_id'];
				$title   = $data['topic'];
				$message = $data['isi_notif'];
				$idNotif = $data['id'];

	//	 $send_notif_url = "http://hcis.wika-beton.net/wbs/firebase/send_notif.php?reg_Id=
	//	   ".$reg_Id."&title=".$title."&message=".$message."&idNotif=".$idNotif;        
	//$query_string = 'foo=' . urlencode($foo) . '&bar=' . urlencode($bar);

	$query_string = 'reg_Id=' . urlencode($reg_Id) . '&title=' . urlencode($bar)
		.'&message'.urlencode($message)."&idNotif=".urlencode($idNotif);

	//echo '<a href="mycgi?' . htmlentities($query_string) . '">';
	   	   $send_notif_url = "http://hcis.wika-beton.net/wbs/firebase/send_notif.php?".htmlentities($query_string); 
		   $ch = curl_init($send_notif_url);
		   curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        

		   // Execute post
		   $result = curl_exec($ch);
		   if ($result === FALSE) {
		   		die('Curl failed: ' . curl_error($ch));
		   }else{
		   		var_dump($result);
		   }

		   // Close connection
		   curl_close($ch);
		 }
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

		if (CurrentPageID() == "add" && $this->CurrentAction != "F") {
			$this->bagian->ReadOnly = TRUE;
			$this->lokasi_kerja->ReadOnly = TRUE;
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
