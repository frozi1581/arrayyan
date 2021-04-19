<?php

// Global variable for table object
$m_users = NULL;

//
// Table class for m_users
//
class cm_users extends cTable {
	var $USER_ID;
	var $USER_NAME;
	var $PASSWD;
	var $_EMAIL;
	var $IS_ACTIVE;
	var $USER_LEVEL;
	var $PROFILE;
	var $SESSION_ID;
	var $LAST_LOGIN;
	var $LAST_LOGOUT;
	var $DEVICE_ID;
	var $INFO;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'm_users';
		$this->TableName = 'm_users';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`m_users`";
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

		// USER_ID
		$this->USER_ID = new cField('m_users', 'm_users', 'x_USER_ID', 'USER_ID', '`USER_ID`', '`USER_ID`', 200, -1, FALSE, '`USER_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->USER_ID->Sortable = TRUE; // Allow sort
		$this->fields['USER_ID'] = &$this->USER_ID;

		// USER_NAME
		$this->USER_NAME = new cField('m_users', 'm_users', 'x_USER_NAME', 'USER_NAME', '`USER_NAME`', '`USER_NAME`', 200, -1, FALSE, '`USER_NAME`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->USER_NAME->Sortable = TRUE; // Allow sort
		$this->fields['USER_NAME'] = &$this->USER_NAME;

		// PASSWD
		$this->PASSWD = new cField('m_users', 'm_users', 'x_PASSWD', 'PASSWD', '`PASSWD`', '`PASSWD`', 200, -1, FALSE, '`PASSWD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PASSWD->Sortable = TRUE; // Allow sort
		$this->fields['PASSWD'] = &$this->PASSWD;

		// EMAIL
		$this->_EMAIL = new cField('m_users', 'm_users', 'x__EMAIL', 'EMAIL', '`EMAIL`', '`EMAIL`', 200, -1, FALSE, '`EMAIL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_EMAIL->Sortable = TRUE; // Allow sort
		$this->fields['EMAIL'] = &$this->_EMAIL;

		// IS_ACTIVE
		$this->IS_ACTIVE = new cField('m_users', 'm_users', 'x_IS_ACTIVE', 'IS_ACTIVE', '`IS_ACTIVE`', '`IS_ACTIVE`', 200, -1, FALSE, '`IS_ACTIVE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IS_ACTIVE->Sortable = TRUE; // Allow sort
		$this->fields['IS_ACTIVE'] = &$this->IS_ACTIVE;

		// USER_LEVEL
		$this->USER_LEVEL = new cField('m_users', 'm_users', 'x_USER_LEVEL', 'USER_LEVEL', '`USER_LEVEL`', '`USER_LEVEL`', 3, -1, FALSE, '`USER_LEVEL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->USER_LEVEL->Sortable = TRUE; // Allow sort
		$this->USER_LEVEL->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['USER_LEVEL'] = &$this->USER_LEVEL;

		// PROFILE
		$this->PROFILE = new cField('m_users', 'm_users', 'x_PROFILE', 'PROFILE', '`PROFILE`', '`PROFILE`', 201, -1, FALSE, '`PROFILE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->PROFILE->Sortable = TRUE; // Allow sort
		$this->fields['PROFILE'] = &$this->PROFILE;

		// SESSION_ID
		$this->SESSION_ID = new cField('m_users', 'm_users', 'x_SESSION_ID', 'SESSION_ID', '`SESSION_ID`', '`SESSION_ID`', 200, -1, FALSE, '`SESSION_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SESSION_ID->Sortable = TRUE; // Allow sort
		$this->fields['SESSION_ID'] = &$this->SESSION_ID;

		// LAST_LOGIN
		$this->LAST_LOGIN = new cField('m_users', 'm_users', 'x_LAST_LOGIN', 'LAST_LOGIN', '`LAST_LOGIN`', ew_CastDateFieldForLike('`LAST_LOGIN`', 0, "DB"), 135, 0, FALSE, '`LAST_LOGIN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LAST_LOGIN->Sortable = TRUE; // Allow sort
		$this->LAST_LOGIN->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['LAST_LOGIN'] = &$this->LAST_LOGIN;

		// LAST_LOGOUT
		$this->LAST_LOGOUT = new cField('m_users', 'm_users', 'x_LAST_LOGOUT', 'LAST_LOGOUT', '`LAST_LOGOUT`', ew_CastDateFieldForLike('`LAST_LOGOUT`', 0, "DB"), 135, 0, FALSE, '`LAST_LOGOUT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LAST_LOGOUT->Sortable = TRUE; // Allow sort
		$this->LAST_LOGOUT->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['LAST_LOGOUT'] = &$this->LAST_LOGOUT;

		// DEVICE_ID
		$this->DEVICE_ID = new cField('m_users', 'm_users', 'x_DEVICE_ID', 'DEVICE_ID', '`DEVICE_ID`', '`DEVICE_ID`', 200, -1, FALSE, '`DEVICE_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DEVICE_ID->Sortable = TRUE; // Allow sort
		$this->fields['DEVICE_ID'] = &$this->DEVICE_ID;

		// INFO
		$this->INFO = new cField('m_users', 'm_users', 'x_INFO', 'INFO', '`INFO`', '`INFO`', 200, -1, FALSE, '`INFO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->INFO->Sortable = TRUE; // Allow sort
		$this->fields['INFO'] = &$this->INFO;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`m_users`";
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
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "m_userslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "m_usersview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "m_usersedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "m_usersadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "m_userslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("m_usersview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("m_usersview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "m_usersadd.php?" . $this->UrlParm($parm);
		else
			$url = "m_usersadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("m_usersedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("m_usersadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("m_usersdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
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
		$this->USER_ID->setDbValue($rs->fields('USER_ID'));
		$this->USER_NAME->setDbValue($rs->fields('USER_NAME'));
		$this->PASSWD->setDbValue($rs->fields('PASSWD'));
		$this->_EMAIL->setDbValue($rs->fields('EMAIL'));
		$this->IS_ACTIVE->setDbValue($rs->fields('IS_ACTIVE'));
		$this->USER_LEVEL->setDbValue($rs->fields('USER_LEVEL'));
		$this->PROFILE->setDbValue($rs->fields('PROFILE'));
		$this->SESSION_ID->setDbValue($rs->fields('SESSION_ID'));
		$this->LAST_LOGIN->setDbValue($rs->fields('LAST_LOGIN'));
		$this->LAST_LOGOUT->setDbValue($rs->fields('LAST_LOGOUT'));
		$this->DEVICE_ID->setDbValue($rs->fields('DEVICE_ID'));
		$this->INFO->setDbValue($rs->fields('INFO'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// USER_ID
		// USER_NAME
		// PASSWD
		// EMAIL
		// IS_ACTIVE
		// USER_LEVEL
		// PROFILE
		// SESSION_ID
		// LAST_LOGIN
		// LAST_LOGOUT
		// DEVICE_ID
		// INFO
		// USER_ID

		$this->USER_ID->ViewValue = $this->USER_ID->CurrentValue;
		$this->USER_ID->ViewCustomAttributes = "";

		// USER_NAME
		$this->USER_NAME->ViewValue = $this->USER_NAME->CurrentValue;
		$this->USER_NAME->ViewCustomAttributes = "";

		// PASSWD
		$this->PASSWD->ViewValue = $this->PASSWD->CurrentValue;
		$this->PASSWD->ViewCustomAttributes = "";

		// EMAIL
		$this->_EMAIL->ViewValue = $this->_EMAIL->CurrentValue;
		$this->_EMAIL->ViewCustomAttributes = "";

		// IS_ACTIVE
		$this->IS_ACTIVE->ViewValue = $this->IS_ACTIVE->CurrentValue;
		$this->IS_ACTIVE->ViewCustomAttributes = "";

		// USER_LEVEL
		$this->USER_LEVEL->ViewValue = $this->USER_LEVEL->CurrentValue;
		$this->USER_LEVEL->ViewCustomAttributes = "";

		// PROFILE
		$this->PROFILE->ViewValue = $this->PROFILE->CurrentValue;
		$this->PROFILE->ViewCustomAttributes = "";

		// SESSION_ID
		$this->SESSION_ID->ViewValue = $this->SESSION_ID->CurrentValue;
		$this->SESSION_ID->ViewCustomAttributes = "";

		// LAST_LOGIN
		$this->LAST_LOGIN->ViewValue = $this->LAST_LOGIN->CurrentValue;
		$this->LAST_LOGIN->ViewValue = ew_FormatDateTime($this->LAST_LOGIN->ViewValue, 0);
		$this->LAST_LOGIN->ViewCustomAttributes = "";

		// LAST_LOGOUT
		$this->LAST_LOGOUT->ViewValue = $this->LAST_LOGOUT->CurrentValue;
		$this->LAST_LOGOUT->ViewValue = ew_FormatDateTime($this->LAST_LOGOUT->ViewValue, 0);
		$this->LAST_LOGOUT->ViewCustomAttributes = "";

		// DEVICE_ID
		$this->DEVICE_ID->ViewValue = $this->DEVICE_ID->CurrentValue;
		$this->DEVICE_ID->ViewCustomAttributes = "";

		// INFO
		$this->INFO->ViewValue = $this->INFO->CurrentValue;
		$this->INFO->ViewCustomAttributes = "";

		// USER_ID
		$this->USER_ID->LinkCustomAttributes = "";
		$this->USER_ID->HrefValue = "";
		$this->USER_ID->TooltipValue = "";

		// USER_NAME
		$this->USER_NAME->LinkCustomAttributes = "";
		$this->USER_NAME->HrefValue = "";
		$this->USER_NAME->TooltipValue = "";

		// PASSWD
		$this->PASSWD->LinkCustomAttributes = "";
		$this->PASSWD->HrefValue = "";
		$this->PASSWD->TooltipValue = "";

		// EMAIL
		$this->_EMAIL->LinkCustomAttributes = "";
		$this->_EMAIL->HrefValue = "";
		$this->_EMAIL->TooltipValue = "";

		// IS_ACTIVE
		$this->IS_ACTIVE->LinkCustomAttributes = "";
		$this->IS_ACTIVE->HrefValue = "";
		$this->IS_ACTIVE->TooltipValue = "";

		// USER_LEVEL
		$this->USER_LEVEL->LinkCustomAttributes = "";
		$this->USER_LEVEL->HrefValue = "";
		$this->USER_LEVEL->TooltipValue = "";

		// PROFILE
		$this->PROFILE->LinkCustomAttributes = "";
		$this->PROFILE->HrefValue = "";
		$this->PROFILE->TooltipValue = "";

		// SESSION_ID
		$this->SESSION_ID->LinkCustomAttributes = "";
		$this->SESSION_ID->HrefValue = "";
		$this->SESSION_ID->TooltipValue = "";

		// LAST_LOGIN
		$this->LAST_LOGIN->LinkCustomAttributes = "";
		$this->LAST_LOGIN->HrefValue = "";
		$this->LAST_LOGIN->TooltipValue = "";

		// LAST_LOGOUT
		$this->LAST_LOGOUT->LinkCustomAttributes = "";
		$this->LAST_LOGOUT->HrefValue = "";
		$this->LAST_LOGOUT->TooltipValue = "";

		// DEVICE_ID
		$this->DEVICE_ID->LinkCustomAttributes = "";
		$this->DEVICE_ID->HrefValue = "";
		$this->DEVICE_ID->TooltipValue = "";

		// INFO
		$this->INFO->LinkCustomAttributes = "";
		$this->INFO->HrefValue = "";
		$this->INFO->TooltipValue = "";

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

		// USER_ID
		$this->USER_ID->EditAttrs["class"] = "form-control";
		$this->USER_ID->EditCustomAttributes = "";
		$this->USER_ID->EditValue = $this->USER_ID->CurrentValue;
		$this->USER_ID->PlaceHolder = ew_RemoveHtml($this->USER_ID->FldCaption());

		// USER_NAME
		$this->USER_NAME->EditAttrs["class"] = "form-control";
		$this->USER_NAME->EditCustomAttributes = "";
		$this->USER_NAME->EditValue = $this->USER_NAME->CurrentValue;
		$this->USER_NAME->PlaceHolder = ew_RemoveHtml($this->USER_NAME->FldCaption());

		// PASSWD
		$this->PASSWD->EditAttrs["class"] = "form-control";
		$this->PASSWD->EditCustomAttributes = "";
		$this->PASSWD->EditValue = $this->PASSWD->CurrentValue;
		$this->PASSWD->PlaceHolder = ew_RemoveHtml($this->PASSWD->FldCaption());

		// EMAIL
		$this->_EMAIL->EditAttrs["class"] = "form-control";
		$this->_EMAIL->EditCustomAttributes = "";
		$this->_EMAIL->EditValue = $this->_EMAIL->CurrentValue;
		$this->_EMAIL->PlaceHolder = ew_RemoveHtml($this->_EMAIL->FldCaption());

		// IS_ACTIVE
		$this->IS_ACTIVE->EditAttrs["class"] = "form-control";
		$this->IS_ACTIVE->EditCustomAttributes = "";
		$this->IS_ACTIVE->EditValue = $this->IS_ACTIVE->CurrentValue;
		$this->IS_ACTIVE->PlaceHolder = ew_RemoveHtml($this->IS_ACTIVE->FldCaption());

		// USER_LEVEL
		$this->USER_LEVEL->EditAttrs["class"] = "form-control";
		$this->USER_LEVEL->EditCustomAttributes = "";
		$this->USER_LEVEL->EditValue = $this->USER_LEVEL->CurrentValue;
		$this->USER_LEVEL->PlaceHolder = ew_RemoveHtml($this->USER_LEVEL->FldCaption());

		// PROFILE
		$this->PROFILE->EditAttrs["class"] = "form-control";
		$this->PROFILE->EditCustomAttributes = "";
		$this->PROFILE->EditValue = $this->PROFILE->CurrentValue;
		$this->PROFILE->PlaceHolder = ew_RemoveHtml($this->PROFILE->FldCaption());

		// SESSION_ID
		$this->SESSION_ID->EditAttrs["class"] = "form-control";
		$this->SESSION_ID->EditCustomAttributes = "";
		$this->SESSION_ID->EditValue = $this->SESSION_ID->CurrentValue;
		$this->SESSION_ID->PlaceHolder = ew_RemoveHtml($this->SESSION_ID->FldCaption());

		// LAST_LOGIN
		$this->LAST_LOGIN->EditAttrs["class"] = "form-control";
		$this->LAST_LOGIN->EditCustomAttributes = "";
		$this->LAST_LOGIN->EditValue = ew_FormatDateTime($this->LAST_LOGIN->CurrentValue, 8);
		$this->LAST_LOGIN->PlaceHolder = ew_RemoveHtml($this->LAST_LOGIN->FldCaption());

		// LAST_LOGOUT
		$this->LAST_LOGOUT->EditAttrs["class"] = "form-control";
		$this->LAST_LOGOUT->EditCustomAttributes = "";
		$this->LAST_LOGOUT->EditValue = ew_FormatDateTime($this->LAST_LOGOUT->CurrentValue, 8);
		$this->LAST_LOGOUT->PlaceHolder = ew_RemoveHtml($this->LAST_LOGOUT->FldCaption());

		// DEVICE_ID
		$this->DEVICE_ID->EditAttrs["class"] = "form-control";
		$this->DEVICE_ID->EditCustomAttributes = "";
		$this->DEVICE_ID->EditValue = $this->DEVICE_ID->CurrentValue;
		$this->DEVICE_ID->PlaceHolder = ew_RemoveHtml($this->DEVICE_ID->FldCaption());

		// INFO
		$this->INFO->EditAttrs["class"] = "form-control";
		$this->INFO->EditCustomAttributes = "";
		$this->INFO->EditValue = $this->INFO->CurrentValue;
		$this->INFO->PlaceHolder = ew_RemoveHtml($this->INFO->FldCaption());

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
					if ($this->USER_ID->Exportable) $Doc->ExportCaption($this->USER_ID);
					if ($this->USER_NAME->Exportable) $Doc->ExportCaption($this->USER_NAME);
					if ($this->PASSWD->Exportable) $Doc->ExportCaption($this->PASSWD);
					if ($this->_EMAIL->Exportable) $Doc->ExportCaption($this->_EMAIL);
					if ($this->IS_ACTIVE->Exportable) $Doc->ExportCaption($this->IS_ACTIVE);
					if ($this->USER_LEVEL->Exportable) $Doc->ExportCaption($this->USER_LEVEL);
					if ($this->PROFILE->Exportable) $Doc->ExportCaption($this->PROFILE);
					if ($this->SESSION_ID->Exportable) $Doc->ExportCaption($this->SESSION_ID);
					if ($this->LAST_LOGIN->Exportable) $Doc->ExportCaption($this->LAST_LOGIN);
					if ($this->LAST_LOGOUT->Exportable) $Doc->ExportCaption($this->LAST_LOGOUT);
					if ($this->DEVICE_ID->Exportable) $Doc->ExportCaption($this->DEVICE_ID);
					if ($this->INFO->Exportable) $Doc->ExportCaption($this->INFO);
				} else {
					if ($this->USER_ID->Exportable) $Doc->ExportCaption($this->USER_ID);
					if ($this->USER_NAME->Exportable) $Doc->ExportCaption($this->USER_NAME);
					if ($this->PASSWD->Exportable) $Doc->ExportCaption($this->PASSWD);
					if ($this->_EMAIL->Exportable) $Doc->ExportCaption($this->_EMAIL);
					if ($this->IS_ACTIVE->Exportable) $Doc->ExportCaption($this->IS_ACTIVE);
					if ($this->USER_LEVEL->Exportable) $Doc->ExportCaption($this->USER_LEVEL);
					if ($this->SESSION_ID->Exportable) $Doc->ExportCaption($this->SESSION_ID);
					if ($this->LAST_LOGIN->Exportable) $Doc->ExportCaption($this->LAST_LOGIN);
					if ($this->LAST_LOGOUT->Exportable) $Doc->ExportCaption($this->LAST_LOGOUT);
					if ($this->DEVICE_ID->Exportable) $Doc->ExportCaption($this->DEVICE_ID);
					if ($this->INFO->Exportable) $Doc->ExportCaption($this->INFO);
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
						if ($this->USER_ID->Exportable) $Doc->ExportField($this->USER_ID);
						if ($this->USER_NAME->Exportable) $Doc->ExportField($this->USER_NAME);
						if ($this->PASSWD->Exportable) $Doc->ExportField($this->PASSWD);
						if ($this->_EMAIL->Exportable) $Doc->ExportField($this->_EMAIL);
						if ($this->IS_ACTIVE->Exportable) $Doc->ExportField($this->IS_ACTIVE);
						if ($this->USER_LEVEL->Exportable) $Doc->ExportField($this->USER_LEVEL);
						if ($this->PROFILE->Exportable) $Doc->ExportField($this->PROFILE);
						if ($this->SESSION_ID->Exportable) $Doc->ExportField($this->SESSION_ID);
						if ($this->LAST_LOGIN->Exportable) $Doc->ExportField($this->LAST_LOGIN);
						if ($this->LAST_LOGOUT->Exportable) $Doc->ExportField($this->LAST_LOGOUT);
						if ($this->DEVICE_ID->Exportable) $Doc->ExportField($this->DEVICE_ID);
						if ($this->INFO->Exportable) $Doc->ExportField($this->INFO);
					} else {
						if ($this->USER_ID->Exportable) $Doc->ExportField($this->USER_ID);
						if ($this->USER_NAME->Exportable) $Doc->ExportField($this->USER_NAME);
						if ($this->PASSWD->Exportable) $Doc->ExportField($this->PASSWD);
						if ($this->_EMAIL->Exportable) $Doc->ExportField($this->_EMAIL);
						if ($this->IS_ACTIVE->Exportable) $Doc->ExportField($this->IS_ACTIVE);
						if ($this->USER_LEVEL->Exportable) $Doc->ExportField($this->USER_LEVEL);
						if ($this->SESSION_ID->Exportable) $Doc->ExportField($this->SESSION_ID);
						if ($this->LAST_LOGIN->Exportable) $Doc->ExportField($this->LAST_LOGIN);
						if ($this->LAST_LOGOUT->Exportable) $Doc->ExportField($this->LAST_LOGOUT);
						if ($this->DEVICE_ID->Exportable) $Doc->ExportField($this->DEVICE_ID);
						if ($this->INFO->Exportable) $Doc->ExportField($this->INFO);
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
