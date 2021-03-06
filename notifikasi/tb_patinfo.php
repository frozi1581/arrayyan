<?php

// Global variable for table object
$tb_pat = NULL;

//
// Table class for tb_pat
//
class ctb_pat extends cTable {
	var $KD_PAT;
	var $KET;
	var $ALAMAT;
	var $KOTA;
	var $SINGKATAN;
	var $CREATED_BY;
	var $CREATED_DATE;
	var $LAST_UPDATE_BY;
	var $LAST_UPDATE_DATE;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tb_pat';
		$this->TableName = 'tb_pat';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`tb_pat`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// KD_PAT
		$this->KD_PAT = new cField('tb_pat', 'tb_pat', 'x_KD_PAT', 'KD_PAT', '`KD_PAT`', '`KD_PAT`', 200, -1, FALSE, '`KD_PAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KD_PAT->Sortable = TRUE; // Allow sort
		$this->fields['KD_PAT'] = &$this->KD_PAT;

		// KET
		$this->KET = new cField('tb_pat', 'tb_pat', 'x_KET', 'KET', '`KET`', '`KET`', 200, -1, FALSE, '`KET`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KET->Sortable = TRUE; // Allow sort
		$this->fields['KET'] = &$this->KET;

		// ALAMAT
		$this->ALAMAT = new cField('tb_pat', 'tb_pat', 'x_ALAMAT', 'ALAMAT', '`ALAMAT`', '`ALAMAT`', 200, -1, FALSE, '`ALAMAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ALAMAT->Sortable = TRUE; // Allow sort
		$this->fields['ALAMAT'] = &$this->ALAMAT;

		// KOTA
		$this->KOTA = new cField('tb_pat', 'tb_pat', 'x_KOTA', 'KOTA', '`KOTA`', '`KOTA`', 200, -1, FALSE, '`KOTA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KOTA->Sortable = TRUE; // Allow sort
		$this->fields['KOTA'] = &$this->KOTA;

		// SINGKATAN
		$this->SINGKATAN = new cField('tb_pat', 'tb_pat', 'x_SINGKATAN', 'SINGKATAN', '`SINGKATAN`', '`SINGKATAN`', 200, -1, FALSE, '`SINGKATAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SINGKATAN->Sortable = TRUE; // Allow sort
		$this->fields['SINGKATAN'] = &$this->SINGKATAN;

		// CREATED_BY
		$this->CREATED_BY = new cField('tb_pat', 'tb_pat', 'x_CREATED_BY', 'CREATED_BY', '`CREATED_BY`', '`CREATED_BY`', 200, -1, FALSE, '`CREATED_BY`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CREATED_BY->Sortable = TRUE; // Allow sort
		$this->fields['CREATED_BY'] = &$this->CREATED_BY;

		// CREATED_DATE
		$this->CREATED_DATE = new cField('tb_pat', 'tb_pat', 'x_CREATED_DATE', 'CREATED_DATE', '`CREATED_DATE`', ew_CastDateFieldForLike('`CREATED_DATE`', 0, "DB"), 133, 0, FALSE, '`CREATED_DATE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CREATED_DATE->Sortable = TRUE; // Allow sort
		$this->CREATED_DATE->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['CREATED_DATE'] = &$this->CREATED_DATE;

		// LAST_UPDATE_BY
		$this->LAST_UPDATE_BY = new cField('tb_pat', 'tb_pat', 'x_LAST_UPDATE_BY', 'LAST_UPDATE_BY', '`LAST_UPDATE_BY`', '`LAST_UPDATE_BY`', 200, -1, FALSE, '`LAST_UPDATE_BY`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LAST_UPDATE_BY->Sortable = TRUE; // Allow sort
		$this->fields['LAST_UPDATE_BY'] = &$this->LAST_UPDATE_BY;

		// LAST_UPDATE_DATE
		$this->LAST_UPDATE_DATE = new cField('tb_pat', 'tb_pat', 'x_LAST_UPDATE_DATE', 'LAST_UPDATE_DATE', '`LAST_UPDATE_DATE`', ew_CastDateFieldForLike('`LAST_UPDATE_DATE`', 0, "DB"), 133, 0, FALSE, '`LAST_UPDATE_DATE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LAST_UPDATE_DATE->Sortable = TRUE; // Allow sort
		$this->LAST_UPDATE_DATE->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['LAST_UPDATE_DATE'] = &$this->LAST_UPDATE_DATE;
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

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tb_pat`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
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
			if (array_key_exists('KD_PAT', $rs))
				ew_AddFilter($where, ew_QuotedName('KD_PAT', $this->DBID) . '=' . ew_QuotedValue($rs['KD_PAT'], $this->KD_PAT->FldDataType, $this->DBID));
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
		return "`KD_PAT` = '@KD_PAT@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (is_null($this->KD_PAT->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@KD_PAT@", ew_AdjustSql($this->KD_PAT->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "tb_patlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "tb_patview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "tb_patedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "tb_patadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "tb_patlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tb_patview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tb_patview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tb_patadd.php?" . $this->UrlParm($parm);
		else
			$url = "tb_patadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("tb_patedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("tb_patadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tb_patdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "KD_PAT:" . ew_VarToJson($this->KD_PAT->CurrentValue, "string", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->KD_PAT->CurrentValue)) {
			$sUrl .= "KD_PAT=" . urlencode($this->KD_PAT->CurrentValue);
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
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["KD_PAT"]))
				$arKeys[] = $_POST["KD_PAT"];
			elseif (isset($_GET["KD_PAT"]))
				$arKeys[] = $_GET["KD_PAT"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
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
			$this->KD_PAT->CurrentValue = $key;
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
		$this->KD_PAT->setDbValue($rs->fields('KD_PAT'));
		$this->KET->setDbValue($rs->fields('KET'));
		$this->ALAMAT->setDbValue($rs->fields('ALAMAT'));
		$this->KOTA->setDbValue($rs->fields('KOTA'));
		$this->SINGKATAN->setDbValue($rs->fields('SINGKATAN'));
		$this->CREATED_BY->setDbValue($rs->fields('CREATED_BY'));
		$this->CREATED_DATE->setDbValue($rs->fields('CREATED_DATE'));
		$this->LAST_UPDATE_BY->setDbValue($rs->fields('LAST_UPDATE_BY'));
		$this->LAST_UPDATE_DATE->setDbValue($rs->fields('LAST_UPDATE_DATE'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// KD_PAT
		// KET
		// ALAMAT
		// KOTA
		// SINGKATAN
		// CREATED_BY
		// CREATED_DATE
		// LAST_UPDATE_BY
		// LAST_UPDATE_DATE
		// KD_PAT

		$this->KD_PAT->ViewValue = $this->KD_PAT->CurrentValue;
		$this->KD_PAT->ViewCustomAttributes = "";

		// KET
		$this->KET->ViewValue = $this->KET->CurrentValue;
		$this->KET->ViewCustomAttributes = "";

		// ALAMAT
		$this->ALAMAT->ViewValue = $this->ALAMAT->CurrentValue;
		$this->ALAMAT->ViewCustomAttributes = "";

		// KOTA
		$this->KOTA->ViewValue = $this->KOTA->CurrentValue;
		$this->KOTA->ViewCustomAttributes = "";

		// SINGKATAN
		$this->SINGKATAN->ViewValue = $this->SINGKATAN->CurrentValue;
		$this->SINGKATAN->ViewCustomAttributes = "";

		// CREATED_BY
		$this->CREATED_BY->ViewValue = $this->CREATED_BY->CurrentValue;
		$this->CREATED_BY->ViewCustomAttributes = "";

		// CREATED_DATE
		$this->CREATED_DATE->ViewValue = $this->CREATED_DATE->CurrentValue;
		$this->CREATED_DATE->ViewValue = ew_FormatDateTime($this->CREATED_DATE->ViewValue, 0);
		$this->CREATED_DATE->ViewCustomAttributes = "";

		// LAST_UPDATE_BY
		$this->LAST_UPDATE_BY->ViewValue = $this->LAST_UPDATE_BY->CurrentValue;
		$this->LAST_UPDATE_BY->ViewCustomAttributes = "";

		// LAST_UPDATE_DATE
		$this->LAST_UPDATE_DATE->ViewValue = $this->LAST_UPDATE_DATE->CurrentValue;
		$this->LAST_UPDATE_DATE->ViewValue = ew_FormatDateTime($this->LAST_UPDATE_DATE->ViewValue, 0);
		$this->LAST_UPDATE_DATE->ViewCustomAttributes = "";

		// KD_PAT
		$this->KD_PAT->LinkCustomAttributes = "";
		$this->KD_PAT->HrefValue = "";
		$this->KD_PAT->TooltipValue = "";

		// KET
		$this->KET->LinkCustomAttributes = "";
		$this->KET->HrefValue = "";
		$this->KET->TooltipValue = "";

		// ALAMAT
		$this->ALAMAT->LinkCustomAttributes = "";
		$this->ALAMAT->HrefValue = "";
		$this->ALAMAT->TooltipValue = "";

		// KOTA
		$this->KOTA->LinkCustomAttributes = "";
		$this->KOTA->HrefValue = "";
		$this->KOTA->TooltipValue = "";

		// SINGKATAN
		$this->SINGKATAN->LinkCustomAttributes = "";
		$this->SINGKATAN->HrefValue = "";
		$this->SINGKATAN->TooltipValue = "";

		// CREATED_BY
		$this->CREATED_BY->LinkCustomAttributes = "";
		$this->CREATED_BY->HrefValue = "";
		$this->CREATED_BY->TooltipValue = "";

		// CREATED_DATE
		$this->CREATED_DATE->LinkCustomAttributes = "";
		$this->CREATED_DATE->HrefValue = "";
		$this->CREATED_DATE->TooltipValue = "";

		// LAST_UPDATE_BY
		$this->LAST_UPDATE_BY->LinkCustomAttributes = "";
		$this->LAST_UPDATE_BY->HrefValue = "";
		$this->LAST_UPDATE_BY->TooltipValue = "";

		// LAST_UPDATE_DATE
		$this->LAST_UPDATE_DATE->LinkCustomAttributes = "";
		$this->LAST_UPDATE_DATE->HrefValue = "";
		$this->LAST_UPDATE_DATE->TooltipValue = "";

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

		// KD_PAT
		$this->KD_PAT->EditAttrs["class"] = "form-control";
		$this->KD_PAT->EditCustomAttributes = "";
		$this->KD_PAT->EditValue = $this->KD_PAT->CurrentValue;
		$this->KD_PAT->ViewCustomAttributes = "";

		// KET
		$this->KET->EditAttrs["class"] = "form-control";
		$this->KET->EditCustomAttributes = "";
		$this->KET->EditValue = $this->KET->CurrentValue;
		$this->KET->PlaceHolder = ew_RemoveHtml($this->KET->FldCaption());

		// ALAMAT
		$this->ALAMAT->EditAttrs["class"] = "form-control";
		$this->ALAMAT->EditCustomAttributes = "";
		$this->ALAMAT->EditValue = $this->ALAMAT->CurrentValue;
		$this->ALAMAT->PlaceHolder = ew_RemoveHtml($this->ALAMAT->FldCaption());

		// KOTA
		$this->KOTA->EditAttrs["class"] = "form-control";
		$this->KOTA->EditCustomAttributes = "";
		$this->KOTA->EditValue = $this->KOTA->CurrentValue;
		$this->KOTA->PlaceHolder = ew_RemoveHtml($this->KOTA->FldCaption());

		// SINGKATAN
		$this->SINGKATAN->EditAttrs["class"] = "form-control";
		$this->SINGKATAN->EditCustomAttributes = "";
		$this->SINGKATAN->EditValue = $this->SINGKATAN->CurrentValue;
		$this->SINGKATAN->PlaceHolder = ew_RemoveHtml($this->SINGKATAN->FldCaption());

		// CREATED_BY
		$this->CREATED_BY->EditAttrs["class"] = "form-control";
		$this->CREATED_BY->EditCustomAttributes = "";
		$this->CREATED_BY->EditValue = $this->CREATED_BY->CurrentValue;
		$this->CREATED_BY->PlaceHolder = ew_RemoveHtml($this->CREATED_BY->FldCaption());

		// CREATED_DATE
		$this->CREATED_DATE->EditAttrs["class"] = "form-control";
		$this->CREATED_DATE->EditCustomAttributes = "";
		$this->CREATED_DATE->EditValue = ew_FormatDateTime($this->CREATED_DATE->CurrentValue, 8);
		$this->CREATED_DATE->PlaceHolder = ew_RemoveHtml($this->CREATED_DATE->FldCaption());

		// LAST_UPDATE_BY
		$this->LAST_UPDATE_BY->EditAttrs["class"] = "form-control";
		$this->LAST_UPDATE_BY->EditCustomAttributes = "";
		$this->LAST_UPDATE_BY->EditValue = $this->LAST_UPDATE_BY->CurrentValue;
		$this->LAST_UPDATE_BY->PlaceHolder = ew_RemoveHtml($this->LAST_UPDATE_BY->FldCaption());

		// LAST_UPDATE_DATE
		$this->LAST_UPDATE_DATE->EditAttrs["class"] = "form-control";
		$this->LAST_UPDATE_DATE->EditCustomAttributes = "";
		$this->LAST_UPDATE_DATE->EditValue = ew_FormatDateTime($this->LAST_UPDATE_DATE->CurrentValue, 8);
		$this->LAST_UPDATE_DATE->PlaceHolder = ew_RemoveHtml($this->LAST_UPDATE_DATE->FldCaption());

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
					if ($this->KD_PAT->Exportable) $Doc->ExportCaption($this->KD_PAT);
					if ($this->KET->Exportable) $Doc->ExportCaption($this->KET);
					if ($this->ALAMAT->Exportable) $Doc->ExportCaption($this->ALAMAT);
					if ($this->KOTA->Exportable) $Doc->ExportCaption($this->KOTA);
					if ($this->SINGKATAN->Exportable) $Doc->ExportCaption($this->SINGKATAN);
					if ($this->CREATED_BY->Exportable) $Doc->ExportCaption($this->CREATED_BY);
					if ($this->CREATED_DATE->Exportable) $Doc->ExportCaption($this->CREATED_DATE);
					if ($this->LAST_UPDATE_BY->Exportable) $Doc->ExportCaption($this->LAST_UPDATE_BY);
					if ($this->LAST_UPDATE_DATE->Exportable) $Doc->ExportCaption($this->LAST_UPDATE_DATE);
				} else {
					if ($this->KD_PAT->Exportable) $Doc->ExportCaption($this->KD_PAT);
					if ($this->KET->Exportable) $Doc->ExportCaption($this->KET);
					if ($this->ALAMAT->Exportable) $Doc->ExportCaption($this->ALAMAT);
					if ($this->KOTA->Exportable) $Doc->ExportCaption($this->KOTA);
					if ($this->SINGKATAN->Exportable) $Doc->ExportCaption($this->SINGKATAN);
					if ($this->CREATED_BY->Exportable) $Doc->ExportCaption($this->CREATED_BY);
					if ($this->CREATED_DATE->Exportable) $Doc->ExportCaption($this->CREATED_DATE);
					if ($this->LAST_UPDATE_BY->Exportable) $Doc->ExportCaption($this->LAST_UPDATE_BY);
					if ($this->LAST_UPDATE_DATE->Exportable) $Doc->ExportCaption($this->LAST_UPDATE_DATE);
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
						if ($this->KD_PAT->Exportable) $Doc->ExportField($this->KD_PAT);
						if ($this->KET->Exportable) $Doc->ExportField($this->KET);
						if ($this->ALAMAT->Exportable) $Doc->ExportField($this->ALAMAT);
						if ($this->KOTA->Exportable) $Doc->ExportField($this->KOTA);
						if ($this->SINGKATAN->Exportable) $Doc->ExportField($this->SINGKATAN);
						if ($this->CREATED_BY->Exportable) $Doc->ExportField($this->CREATED_BY);
						if ($this->CREATED_DATE->Exportable) $Doc->ExportField($this->CREATED_DATE);
						if ($this->LAST_UPDATE_BY->Exportable) $Doc->ExportField($this->LAST_UPDATE_BY);
						if ($this->LAST_UPDATE_DATE->Exportable) $Doc->ExportField($this->LAST_UPDATE_DATE);
					} else {
						if ($this->KD_PAT->Exportable) $Doc->ExportField($this->KD_PAT);
						if ($this->KET->Exportable) $Doc->ExportField($this->KET);
						if ($this->ALAMAT->Exportable) $Doc->ExportField($this->ALAMAT);
						if ($this->KOTA->Exportable) $Doc->ExportField($this->KOTA);
						if ($this->SINGKATAN->Exportable) $Doc->ExportField($this->SINGKATAN);
						if ($this->CREATED_BY->Exportable) $Doc->ExportField($this->CREATED_BY);
						if ($this->CREATED_DATE->Exportable) $Doc->ExportField($this->CREATED_DATE);
						if ($this->LAST_UPDATE_BY->Exportable) $Doc->ExportField($this->LAST_UPDATE_BY);
						if ($this->LAST_UPDATE_DATE->Exportable) $Doc->ExportField($this->LAST_UPDATE_DATE);
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

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
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

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
