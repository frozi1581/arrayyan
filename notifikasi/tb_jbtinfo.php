<?php

// Global variable for table object
$tb_jbt = NULL;

//
// Table class for tb_jbt
//
class ctb_jbt extends cTable {
	var $kd_jbt;
	var $ket;
	var $tjb;
	var $koef;
	var $created_by;
	var $created_date;
	var $last_update_by;
	var $last_update_date;
	var $kd_jbt_old;
	var $ket_old;
	var $jbt_type;
	var $org_id;
	var $parent_kd_jbt;
	var $eselon_num;
	var $jns_jbt;
	var $status;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tb_jbt';
		$this->TableName = 'tb_jbt';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`tb_jbt`";
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

		// kd_jbt
		$this->kd_jbt = new cField('tb_jbt', 'tb_jbt', 'x_kd_jbt', 'kd_jbt', '`kd_jbt`', '`kd_jbt`', 200, -1, FALSE, '`kd_jbt`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jbt->Sortable = TRUE; // Allow sort
		$this->fields['kd_jbt'] = &$this->kd_jbt;

		// ket
		$this->ket = new cField('tb_jbt', 'tb_jbt', 'x_ket', 'ket', '`ket`', '`ket`', 200, -1, FALSE, '`ket`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket->Sortable = TRUE; // Allow sort
		$this->fields['ket'] = &$this->ket;

		// tjb
		$this->tjb = new cField('tb_jbt', 'tb_jbt', 'x_tjb', 'tjb', '`tjb`', '`tjb`', 200, -1, FALSE, '`tjb`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tjb->Sortable = TRUE; // Allow sort
		$this->fields['tjb'] = &$this->tjb;

		// koef
		$this->koef = new cField('tb_jbt', 'tb_jbt', 'x_koef', 'koef', '`koef`', '`koef`', 131, -1, FALSE, '`koef`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->koef->Sortable = TRUE; // Allow sort
		$this->koef->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['koef'] = &$this->koef;

		// created_by
		$this->created_by = new cField('tb_jbt', 'tb_jbt', 'x_created_by', 'created_by', '`created_by`', '`created_by`', 200, -1, FALSE, '`created_by`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->created_by->Sortable = TRUE; // Allow sort
		$this->fields['created_by'] = &$this->created_by;

		// created_date
		$this->created_date = new cField('tb_jbt', 'tb_jbt', 'x_created_date', 'created_date', '`created_date`', ew_CastDateFieldForLike('`created_date`', 0, "DB"), 135, 0, FALSE, '`created_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->created_date->Sortable = TRUE; // Allow sort
		$this->created_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['created_date'] = &$this->created_date;

		// last_update_by
		$this->last_update_by = new cField('tb_jbt', 'tb_jbt', 'x_last_update_by', 'last_update_by', '`last_update_by`', '`last_update_by`', 200, -1, FALSE, '`last_update_by`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_update_by->Sortable = TRUE; // Allow sort
		$this->fields['last_update_by'] = &$this->last_update_by;

		// last_update_date
		$this->last_update_date = new cField('tb_jbt', 'tb_jbt', 'x_last_update_date', 'last_update_date', '`last_update_date`', ew_CastDateFieldForLike('`last_update_date`', 0, "DB"), 135, 0, FALSE, '`last_update_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_update_date->Sortable = TRUE; // Allow sort
		$this->last_update_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['last_update_date'] = &$this->last_update_date;

		// kd_jbt_old
		$this->kd_jbt_old = new cField('tb_jbt', 'tb_jbt', 'x_kd_jbt_old', 'kd_jbt_old', '`kd_jbt_old`', '`kd_jbt_old`', 200, -1, FALSE, '`kd_jbt_old`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jbt_old->Sortable = TRUE; // Allow sort
		$this->fields['kd_jbt_old'] = &$this->kd_jbt_old;

		// ket_old
		$this->ket_old = new cField('tb_jbt', 'tb_jbt', 'x_ket_old', 'ket_old', '`ket_old`', '`ket_old`', 200, -1, FALSE, '`ket_old`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_old->Sortable = TRUE; // Allow sort
		$this->fields['ket_old'] = &$this->ket_old;

		// jbt_type
		$this->jbt_type = new cField('tb_jbt', 'tb_jbt', 'x_jbt_type', 'jbt_type', '`jbt_type`', '`jbt_type`', 200, -1, FALSE, '`jbt_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jbt_type->Sortable = TRUE; // Allow sort
		$this->fields['jbt_type'] = &$this->jbt_type;

		// org_id
		$this->org_id = new cField('tb_jbt', 'tb_jbt', 'x_org_id', 'org_id', '`org_id`', '`org_id`', 200, -1, FALSE, '`org_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->org_id->Sortable = TRUE; // Allow sort
		$this->fields['org_id'] = &$this->org_id;

		// parent_kd_jbt
		$this->parent_kd_jbt = new cField('tb_jbt', 'tb_jbt', 'x_parent_kd_jbt', 'parent_kd_jbt', '`parent_kd_jbt`', '`parent_kd_jbt`', 200, -1, FALSE, '`parent_kd_jbt`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->parent_kd_jbt->Sortable = TRUE; // Allow sort
		$this->fields['parent_kd_jbt'] = &$this->parent_kd_jbt;

		// eselon_num
		$this->eselon_num = new cField('tb_jbt', 'tb_jbt', 'x_eselon_num', 'eselon_num', '`eselon_num`', '`eselon_num`', 5, -1, FALSE, '`eselon_num`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eselon_num->Sortable = TRUE; // Allow sort
		$this->eselon_num->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['eselon_num'] = &$this->eselon_num;

		// jns_jbt
		$this->jns_jbt = new cField('tb_jbt', 'tb_jbt', 'x_jns_jbt', 'jns_jbt', '`jns_jbt`', '`jns_jbt`', 200, -1, FALSE, '`jns_jbt`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jns_jbt->Sortable = TRUE; // Allow sort
		$this->fields['jns_jbt'] = &$this->jns_jbt;

		// status
		$this->status = new cField('tb_jbt', 'tb_jbt', 'x_status', 'status', '`status`', '`status`', 200, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status->Sortable = TRUE; // Allow sort
		$this->fields['status'] = &$this->status;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tb_jbt`";
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
			if (array_key_exists('kd_jbt', $rs))
				ew_AddFilter($where, ew_QuotedName('kd_jbt', $this->DBID) . '=' . ew_QuotedValue($rs['kd_jbt'], $this->kd_jbt->FldDataType, $this->DBID));
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
		return "`kd_jbt` = '@kd_jbt@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (is_null($this->kd_jbt->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@kd_jbt@", ew_AdjustSql($this->kd_jbt->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "tb_jbtlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "tb_jbtview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "tb_jbtedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "tb_jbtadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "tb_jbtlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tb_jbtview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tb_jbtview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tb_jbtadd.php?" . $this->UrlParm($parm);
		else
			$url = "tb_jbtadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("tb_jbtedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("tb_jbtadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tb_jbtdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "kd_jbt:" . ew_VarToJson($this->kd_jbt->CurrentValue, "string", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->kd_jbt->CurrentValue)) {
			$sUrl .= "kd_jbt=" . urlencode($this->kd_jbt->CurrentValue);
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
			if ($isPost && isset($_POST["kd_jbt"]))
				$arKeys[] = $_POST["kd_jbt"];
			elseif (isset($_GET["kd_jbt"]))
				$arKeys[] = $_GET["kd_jbt"];
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
			$this->kd_jbt->CurrentValue = $key;
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
		$this->kd_jbt->setDbValue($rs->fields('kd_jbt'));
		$this->ket->setDbValue($rs->fields('ket'));
		$this->tjb->setDbValue($rs->fields('tjb'));
		$this->koef->setDbValue($rs->fields('koef'));
		$this->created_by->setDbValue($rs->fields('created_by'));
		$this->created_date->setDbValue($rs->fields('created_date'));
		$this->last_update_by->setDbValue($rs->fields('last_update_by'));
		$this->last_update_date->setDbValue($rs->fields('last_update_date'));
		$this->kd_jbt_old->setDbValue($rs->fields('kd_jbt_old'));
		$this->ket_old->setDbValue($rs->fields('ket_old'));
		$this->jbt_type->setDbValue($rs->fields('jbt_type'));
		$this->org_id->setDbValue($rs->fields('org_id'));
		$this->parent_kd_jbt->setDbValue($rs->fields('parent_kd_jbt'));
		$this->eselon_num->setDbValue($rs->fields('eselon_num'));
		$this->jns_jbt->setDbValue($rs->fields('jns_jbt'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// kd_jbt
		// ket
		// tjb
		// koef
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// kd_jbt_old
		// ket_old
		// jbt_type
		// org_id
		// parent_kd_jbt
		// eselon_num
		// jns_jbt
		// status
		// kd_jbt

		$this->kd_jbt->ViewValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

		// tjb
		$this->tjb->ViewValue = $this->tjb->CurrentValue;
		$this->tjb->ViewCustomAttributes = "";

		// koef
		$this->koef->ViewValue = $this->koef->CurrentValue;
		$this->koef->ViewCustomAttributes = "";

		// created_by
		$this->created_by->ViewValue = $this->created_by->CurrentValue;
		$this->created_by->ViewCustomAttributes = "";

		// created_date
		$this->created_date->ViewValue = $this->created_date->CurrentValue;
		$this->created_date->ViewValue = ew_FormatDateTime($this->created_date->ViewValue, 0);
		$this->created_date->ViewCustomAttributes = "";

		// last_update_by
		$this->last_update_by->ViewValue = $this->last_update_by->CurrentValue;
		$this->last_update_by->ViewCustomAttributes = "";

		// last_update_date
		$this->last_update_date->ViewValue = $this->last_update_date->CurrentValue;
		$this->last_update_date->ViewValue = ew_FormatDateTime($this->last_update_date->ViewValue, 0);
		$this->last_update_date->ViewCustomAttributes = "";

		// kd_jbt_old
		$this->kd_jbt_old->ViewValue = $this->kd_jbt_old->CurrentValue;
		$this->kd_jbt_old->ViewCustomAttributes = "";

		// ket_old
		$this->ket_old->ViewValue = $this->ket_old->CurrentValue;
		$this->ket_old->ViewCustomAttributes = "";

		// jbt_type
		$this->jbt_type->ViewValue = $this->jbt_type->CurrentValue;
		$this->jbt_type->ViewCustomAttributes = "";

		// org_id
		$this->org_id->ViewValue = $this->org_id->CurrentValue;
		$this->org_id->ViewCustomAttributes = "";

		// parent_kd_jbt
		$this->parent_kd_jbt->ViewValue = $this->parent_kd_jbt->CurrentValue;
		$this->parent_kd_jbt->ViewCustomAttributes = "";

		// eselon_num
		$this->eselon_num->ViewValue = $this->eselon_num->CurrentValue;
		$this->eselon_num->ViewCustomAttributes = "";

		// jns_jbt
		$this->jns_jbt->ViewValue = $this->jns_jbt->CurrentValue;
		$this->jns_jbt->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

		// kd_jbt
		$this->kd_jbt->LinkCustomAttributes = "";
		$this->kd_jbt->HrefValue = "";
		$this->kd_jbt->TooltipValue = "";

		// ket
		$this->ket->LinkCustomAttributes = "";
		$this->ket->HrefValue = "";
		$this->ket->TooltipValue = "";

		// tjb
		$this->tjb->LinkCustomAttributes = "";
		$this->tjb->HrefValue = "";
		$this->tjb->TooltipValue = "";

		// koef
		$this->koef->LinkCustomAttributes = "";
		$this->koef->HrefValue = "";
		$this->koef->TooltipValue = "";

		// created_by
		$this->created_by->LinkCustomAttributes = "";
		$this->created_by->HrefValue = "";
		$this->created_by->TooltipValue = "";

		// created_date
		$this->created_date->LinkCustomAttributes = "";
		$this->created_date->HrefValue = "";
		$this->created_date->TooltipValue = "";

		// last_update_by
		$this->last_update_by->LinkCustomAttributes = "";
		$this->last_update_by->HrefValue = "";
		$this->last_update_by->TooltipValue = "";

		// last_update_date
		$this->last_update_date->LinkCustomAttributes = "";
		$this->last_update_date->HrefValue = "";
		$this->last_update_date->TooltipValue = "";

		// kd_jbt_old
		$this->kd_jbt_old->LinkCustomAttributes = "";
		$this->kd_jbt_old->HrefValue = "";
		$this->kd_jbt_old->TooltipValue = "";

		// ket_old
		$this->ket_old->LinkCustomAttributes = "";
		$this->ket_old->HrefValue = "";
		$this->ket_old->TooltipValue = "";

		// jbt_type
		$this->jbt_type->LinkCustomAttributes = "";
		$this->jbt_type->HrefValue = "";
		$this->jbt_type->TooltipValue = "";

		// org_id
		$this->org_id->LinkCustomAttributes = "";
		$this->org_id->HrefValue = "";
		$this->org_id->TooltipValue = "";

		// parent_kd_jbt
		$this->parent_kd_jbt->LinkCustomAttributes = "";
		$this->parent_kd_jbt->HrefValue = "";
		$this->parent_kd_jbt->TooltipValue = "";

		// eselon_num
		$this->eselon_num->LinkCustomAttributes = "";
		$this->eselon_num->HrefValue = "";
		$this->eselon_num->TooltipValue = "";

		// jns_jbt
		$this->jns_jbt->LinkCustomAttributes = "";
		$this->jns_jbt->HrefValue = "";
		$this->jns_jbt->TooltipValue = "";

		// status
		$this->status->LinkCustomAttributes = "";
		$this->status->HrefValue = "";
		$this->status->TooltipValue = "";

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

		// kd_jbt
		$this->kd_jbt->EditAttrs["class"] = "form-control";
		$this->kd_jbt->EditCustomAttributes = "";
		$this->kd_jbt->EditValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// ket
		$this->ket->EditAttrs["class"] = "form-control";
		$this->ket->EditCustomAttributes = "";
		$this->ket->EditValue = $this->ket->CurrentValue;
		$this->ket->PlaceHolder = ew_RemoveHtml($this->ket->FldCaption());

		// tjb
		$this->tjb->EditAttrs["class"] = "form-control";
		$this->tjb->EditCustomAttributes = "";
		$this->tjb->EditValue = $this->tjb->CurrentValue;
		$this->tjb->PlaceHolder = ew_RemoveHtml($this->tjb->FldCaption());

		// koef
		$this->koef->EditAttrs["class"] = "form-control";
		$this->koef->EditCustomAttributes = "";
		$this->koef->EditValue = $this->koef->CurrentValue;
		$this->koef->PlaceHolder = ew_RemoveHtml($this->koef->FldCaption());
		if (strval($this->koef->EditValue) <> "" && is_numeric($this->koef->EditValue)) $this->koef->EditValue = ew_FormatNumber($this->koef->EditValue, -2, -1, -2, 0);

		// created_by
		$this->created_by->EditAttrs["class"] = "form-control";
		$this->created_by->EditCustomAttributes = "";
		$this->created_by->EditValue = $this->created_by->CurrentValue;
		$this->created_by->PlaceHolder = ew_RemoveHtml($this->created_by->FldCaption());

		// created_date
		$this->created_date->EditAttrs["class"] = "form-control";
		$this->created_date->EditCustomAttributes = "";
		$this->created_date->EditValue = ew_FormatDateTime($this->created_date->CurrentValue, 8);
		$this->created_date->PlaceHolder = ew_RemoveHtml($this->created_date->FldCaption());

		// last_update_by
		$this->last_update_by->EditAttrs["class"] = "form-control";
		$this->last_update_by->EditCustomAttributes = "";
		$this->last_update_by->EditValue = $this->last_update_by->CurrentValue;
		$this->last_update_by->PlaceHolder = ew_RemoveHtml($this->last_update_by->FldCaption());

		// last_update_date
		$this->last_update_date->EditAttrs["class"] = "form-control";
		$this->last_update_date->EditCustomAttributes = "";
		$this->last_update_date->EditValue = ew_FormatDateTime($this->last_update_date->CurrentValue, 8);
		$this->last_update_date->PlaceHolder = ew_RemoveHtml($this->last_update_date->FldCaption());

		// kd_jbt_old
		$this->kd_jbt_old->EditAttrs["class"] = "form-control";
		$this->kd_jbt_old->EditCustomAttributes = "";
		$this->kd_jbt_old->EditValue = $this->kd_jbt_old->CurrentValue;
		$this->kd_jbt_old->PlaceHolder = ew_RemoveHtml($this->kd_jbt_old->FldCaption());

		// ket_old
		$this->ket_old->EditAttrs["class"] = "form-control";
		$this->ket_old->EditCustomAttributes = "";
		$this->ket_old->EditValue = $this->ket_old->CurrentValue;
		$this->ket_old->PlaceHolder = ew_RemoveHtml($this->ket_old->FldCaption());

		// jbt_type
		$this->jbt_type->EditAttrs["class"] = "form-control";
		$this->jbt_type->EditCustomAttributes = "";
		$this->jbt_type->EditValue = $this->jbt_type->CurrentValue;
		$this->jbt_type->PlaceHolder = ew_RemoveHtml($this->jbt_type->FldCaption());

		// org_id
		$this->org_id->EditAttrs["class"] = "form-control";
		$this->org_id->EditCustomAttributes = "";
		$this->org_id->EditValue = $this->org_id->CurrentValue;
		$this->org_id->PlaceHolder = ew_RemoveHtml($this->org_id->FldCaption());

		// parent_kd_jbt
		$this->parent_kd_jbt->EditAttrs["class"] = "form-control";
		$this->parent_kd_jbt->EditCustomAttributes = "";
		$this->parent_kd_jbt->EditValue = $this->parent_kd_jbt->CurrentValue;
		$this->parent_kd_jbt->PlaceHolder = ew_RemoveHtml($this->parent_kd_jbt->FldCaption());

		// eselon_num
		$this->eselon_num->EditAttrs["class"] = "form-control";
		$this->eselon_num->EditCustomAttributes = "";
		$this->eselon_num->EditValue = $this->eselon_num->CurrentValue;
		$this->eselon_num->PlaceHolder = ew_RemoveHtml($this->eselon_num->FldCaption());
		if (strval($this->eselon_num->EditValue) <> "" && is_numeric($this->eselon_num->EditValue)) $this->eselon_num->EditValue = ew_FormatNumber($this->eselon_num->EditValue, -2, -1, -2, 0);

		// jns_jbt
		$this->jns_jbt->EditAttrs["class"] = "form-control";
		$this->jns_jbt->EditCustomAttributes = "";
		$this->jns_jbt->EditValue = $this->jns_jbt->CurrentValue;
		$this->jns_jbt->PlaceHolder = ew_RemoveHtml($this->jns_jbt->FldCaption());

		// status
		$this->status->EditAttrs["class"] = "form-control";
		$this->status->EditCustomAttributes = "";
		$this->status->EditValue = $this->status->CurrentValue;
		$this->status->PlaceHolder = ew_RemoveHtml($this->status->FldCaption());

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
					if ($this->kd_jbt->Exportable) $Doc->ExportCaption($this->kd_jbt);
					if ($this->ket->Exportable) $Doc->ExportCaption($this->ket);
					if ($this->tjb->Exportable) $Doc->ExportCaption($this->tjb);
					if ($this->koef->Exportable) $Doc->ExportCaption($this->koef);
					if ($this->created_by->Exportable) $Doc->ExportCaption($this->created_by);
					if ($this->created_date->Exportable) $Doc->ExportCaption($this->created_date);
					if ($this->last_update_by->Exportable) $Doc->ExportCaption($this->last_update_by);
					if ($this->last_update_date->Exportable) $Doc->ExportCaption($this->last_update_date);
					if ($this->kd_jbt_old->Exportable) $Doc->ExportCaption($this->kd_jbt_old);
					if ($this->ket_old->Exportable) $Doc->ExportCaption($this->ket_old);
					if ($this->jbt_type->Exportable) $Doc->ExportCaption($this->jbt_type);
					if ($this->org_id->Exportable) $Doc->ExportCaption($this->org_id);
					if ($this->parent_kd_jbt->Exportable) $Doc->ExportCaption($this->parent_kd_jbt);
					if ($this->eselon_num->Exportable) $Doc->ExportCaption($this->eselon_num);
					if ($this->jns_jbt->Exportable) $Doc->ExportCaption($this->jns_jbt);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
				} else {
					if ($this->kd_jbt->Exportable) $Doc->ExportCaption($this->kd_jbt);
					if ($this->ket->Exportable) $Doc->ExportCaption($this->ket);
					if ($this->tjb->Exportable) $Doc->ExportCaption($this->tjb);
					if ($this->koef->Exportable) $Doc->ExportCaption($this->koef);
					if ($this->created_by->Exportable) $Doc->ExportCaption($this->created_by);
					if ($this->created_date->Exportable) $Doc->ExportCaption($this->created_date);
					if ($this->last_update_by->Exportable) $Doc->ExportCaption($this->last_update_by);
					if ($this->last_update_date->Exportable) $Doc->ExportCaption($this->last_update_date);
					if ($this->kd_jbt_old->Exportable) $Doc->ExportCaption($this->kd_jbt_old);
					if ($this->ket_old->Exportable) $Doc->ExportCaption($this->ket_old);
					if ($this->jbt_type->Exportable) $Doc->ExportCaption($this->jbt_type);
					if ($this->org_id->Exportable) $Doc->ExportCaption($this->org_id);
					if ($this->parent_kd_jbt->Exportable) $Doc->ExportCaption($this->parent_kd_jbt);
					if ($this->eselon_num->Exportable) $Doc->ExportCaption($this->eselon_num);
					if ($this->jns_jbt->Exportable) $Doc->ExportCaption($this->jns_jbt);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
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
						if ($this->kd_jbt->Exportable) $Doc->ExportField($this->kd_jbt);
						if ($this->ket->Exportable) $Doc->ExportField($this->ket);
						if ($this->tjb->Exportable) $Doc->ExportField($this->tjb);
						if ($this->koef->Exportable) $Doc->ExportField($this->koef);
						if ($this->created_by->Exportable) $Doc->ExportField($this->created_by);
						if ($this->created_date->Exportable) $Doc->ExportField($this->created_date);
						if ($this->last_update_by->Exportable) $Doc->ExportField($this->last_update_by);
						if ($this->last_update_date->Exportable) $Doc->ExportField($this->last_update_date);
						if ($this->kd_jbt_old->Exportable) $Doc->ExportField($this->kd_jbt_old);
						if ($this->ket_old->Exportable) $Doc->ExportField($this->ket_old);
						if ($this->jbt_type->Exportable) $Doc->ExportField($this->jbt_type);
						if ($this->org_id->Exportable) $Doc->ExportField($this->org_id);
						if ($this->parent_kd_jbt->Exportable) $Doc->ExportField($this->parent_kd_jbt);
						if ($this->eselon_num->Exportable) $Doc->ExportField($this->eselon_num);
						if ($this->jns_jbt->Exportable) $Doc->ExportField($this->jns_jbt);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
					} else {
						if ($this->kd_jbt->Exportable) $Doc->ExportField($this->kd_jbt);
						if ($this->ket->Exportable) $Doc->ExportField($this->ket);
						if ($this->tjb->Exportable) $Doc->ExportField($this->tjb);
						if ($this->koef->Exportable) $Doc->ExportField($this->koef);
						if ($this->created_by->Exportable) $Doc->ExportField($this->created_by);
						if ($this->created_date->Exportable) $Doc->ExportField($this->created_date);
						if ($this->last_update_by->Exportable) $Doc->ExportField($this->last_update_by);
						if ($this->last_update_date->Exportable) $Doc->ExportField($this->last_update_date);
						if ($this->kd_jbt_old->Exportable) $Doc->ExportField($this->kd_jbt_old);
						if ($this->ket_old->Exportable) $Doc->ExportField($this->ket_old);
						if ($this->jbt_type->Exportable) $Doc->ExportField($this->jbt_type);
						if ($this->org_id->Exportable) $Doc->ExportField($this->org_id);
						if ($this->parent_kd_jbt->Exportable) $Doc->ExportField($this->parent_kd_jbt);
						if ($this->eselon_num->Exportable) $Doc->ExportField($this->eselon_num);
						if ($this->jns_jbt->Exportable) $Doc->ExportField($this->jns_jbt);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
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
