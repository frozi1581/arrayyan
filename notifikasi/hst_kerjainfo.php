<?php

// Global variable for table object
$hst_kerja = NULL;

//
// Table class for hst_kerja
//
class chst_kerja extends cTable {
	var $id;
	var $employee_id;
	var $kd_jbt;
	var $kd_pat;
	var $kd_jenjang;
	var $tgl_mulai;
	var $tgl_akhir;
	var $no_sk;
	var $ket;
	var $company;
	var $created_by;
	var $created_date;
	var $last_update_by;
	var $last_update_date;
	var $st;
	var $kd_jbt_eselon;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'hst_kerja';
		$this->TableName = 'hst_kerja';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`hst_kerja`";
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

		// id
		$this->id = new cField('hst_kerja', 'hst_kerja', 'x_id', 'id', '`id`', '`id`', 20, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// employee_id
		$this->employee_id = new cField('hst_kerja', 'hst_kerja', 'x_employee_id', 'employee_id', '`employee_id`', '`employee_id`', 200, -1, FALSE, '`employee_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->employee_id->Sortable = TRUE; // Allow sort
		$this->fields['employee_id'] = &$this->employee_id;

		// kd_jbt
		$this->kd_jbt = new cField('hst_kerja', 'hst_kerja', 'x_kd_jbt', 'kd_jbt', '`kd_jbt`', '`kd_jbt`', 200, -1, FALSE, '`kd_jbt`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jbt->Sortable = TRUE; // Allow sort
		$this->fields['kd_jbt'] = &$this->kd_jbt;

		// kd_pat
		$this->kd_pat = new cField('hst_kerja', 'hst_kerja', 'x_kd_pat', 'kd_pat', '`kd_pat`', '`kd_pat`', 200, -1, FALSE, '`kd_pat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_pat->Sortable = TRUE; // Allow sort
		$this->fields['kd_pat'] = &$this->kd_pat;

		// kd_jenjang
		$this->kd_jenjang = new cField('hst_kerja', 'hst_kerja', 'x_kd_jenjang', 'kd_jenjang', '`kd_jenjang`', '`kd_jenjang`', 200, -1, FALSE, '`kd_jenjang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jenjang->Sortable = TRUE; // Allow sort
		$this->fields['kd_jenjang'] = &$this->kd_jenjang;

		// tgl_mulai
		$this->tgl_mulai = new cField('hst_kerja', 'hst_kerja', 'x_tgl_mulai', 'tgl_mulai', '`tgl_mulai`', ew_CastDateFieldForLike('`tgl_mulai`', 0, "DB"), 135, 0, FALSE, '`tgl_mulai`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_mulai->Sortable = TRUE; // Allow sort
		$this->tgl_mulai->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_mulai'] = &$this->tgl_mulai;

		// tgl_akhir
		$this->tgl_akhir = new cField('hst_kerja', 'hst_kerja', 'x_tgl_akhir', 'tgl_akhir', '`tgl_akhir`', ew_CastDateFieldForLike('`tgl_akhir`', 0, "DB"), 135, 0, FALSE, '`tgl_akhir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_akhir->Sortable = TRUE; // Allow sort
		$this->tgl_akhir->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_akhir'] = &$this->tgl_akhir;

		// no_sk
		$this->no_sk = new cField('hst_kerja', 'hst_kerja', 'x_no_sk', 'no_sk', '`no_sk`', '`no_sk`', 200, -1, FALSE, '`no_sk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_sk->Sortable = TRUE; // Allow sort
		$this->fields['no_sk'] = &$this->no_sk;

		// ket
		$this->ket = new cField('hst_kerja', 'hst_kerja', 'x_ket', 'ket', '`ket`', '`ket`', 200, -1, FALSE, '`ket`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket->Sortable = TRUE; // Allow sort
		$this->fields['ket'] = &$this->ket;

		// company
		$this->company = new cField('hst_kerja', 'hst_kerja', 'x_company', 'company', '`company`', '`company`', 200, -1, FALSE, '`company`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->company->Sortable = TRUE; // Allow sort
		$this->fields['company'] = &$this->company;

		// created_by
		$this->created_by = new cField('hst_kerja', 'hst_kerja', 'x_created_by', 'created_by', '`created_by`', '`created_by`', 200, -1, FALSE, '`created_by`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->created_by->Sortable = TRUE; // Allow sort
		$this->fields['created_by'] = &$this->created_by;

		// created_date
		$this->created_date = new cField('hst_kerja', 'hst_kerja', 'x_created_date', 'created_date', '`created_date`', ew_CastDateFieldForLike('`created_date`', 0, "DB"), 135, 0, FALSE, '`created_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->created_date->Sortable = TRUE; // Allow sort
		$this->created_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['created_date'] = &$this->created_date;

		// last_update_by
		$this->last_update_by = new cField('hst_kerja', 'hst_kerja', 'x_last_update_by', 'last_update_by', '`last_update_by`', '`last_update_by`', 200, -1, FALSE, '`last_update_by`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_update_by->Sortable = TRUE; // Allow sort
		$this->fields['last_update_by'] = &$this->last_update_by;

		// last_update_date
		$this->last_update_date = new cField('hst_kerja', 'hst_kerja', 'x_last_update_date', 'last_update_date', '`last_update_date`', ew_CastDateFieldForLike('`last_update_date`', 0, "DB"), 135, 0, FALSE, '`last_update_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_update_date->Sortable = TRUE; // Allow sort
		$this->last_update_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['last_update_date'] = &$this->last_update_date;

		// st
		$this->st = new cField('hst_kerja', 'hst_kerja', 'x_st', 'st', '`st`', '`st`', 200, -1, FALSE, '`st`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->st->Sortable = TRUE; // Allow sort
		$this->fields['st'] = &$this->st;

		// kd_jbt_eselon
		$this->kd_jbt_eselon = new cField('hst_kerja', 'hst_kerja', 'x_kd_jbt_eselon', 'kd_jbt_eselon', '`kd_jbt_eselon`', '`kd_jbt_eselon`', 200, -1, FALSE, '`kd_jbt_eselon`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jbt_eselon->Sortable = TRUE; // Allow sort
		$this->fields['kd_jbt_eselon'] = &$this->kd_jbt_eselon;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`hst_kerja`";
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

			// Get insert id if necessary
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
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
			if (array_key_exists('kd_jbt', $rs))
				ew_AddFilter($where, ew_QuotedName('kd_jbt', $this->DBID) . '=' . ew_QuotedValue($rs['kd_jbt'], $this->kd_jbt->FldDataType, $this->DBID));
			if (array_key_exists('kd_pat', $rs))
				ew_AddFilter($where, ew_QuotedName('kd_pat', $this->DBID) . '=' . ew_QuotedValue($rs['kd_pat'], $this->kd_pat->FldDataType, $this->DBID));
			if (array_key_exists('kd_jenjang', $rs))
				ew_AddFilter($where, ew_QuotedName('kd_jenjang', $this->DBID) . '=' . ew_QuotedValue($rs['kd_jenjang'], $this->kd_jenjang->FldDataType, $this->DBID));
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
		return "`id` = @id@ AND `employee_id` = '@employee_id@' AND `kd_jbt` = '@kd_jbt@' AND `kd_pat` = '@kd_pat@' AND `kd_jenjang` = '@kd_jenjang@'";
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
		if (is_null($this->kd_jbt->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@kd_jbt@", ew_AdjustSql($this->kd_jbt->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (is_null($this->kd_pat->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@kd_pat@", ew_AdjustSql($this->kd_pat->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (is_null($this->kd_jenjang->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@kd_jenjang@", ew_AdjustSql($this->kd_jenjang->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "hst_kerjalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "hst_kerjaview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "hst_kerjaedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "hst_kerjaadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "hst_kerjalist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("hst_kerjaview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("hst_kerjaview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "hst_kerjaadd.php?" . $this->UrlParm($parm);
		else
			$url = "hst_kerjaadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("hst_kerjaedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("hst_kerjaadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("hst_kerjadelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		$json .= ",employee_id:" . ew_VarToJson($this->employee_id->CurrentValue, "string", "'");
		$json .= ",kd_jbt:" . ew_VarToJson($this->kd_jbt->CurrentValue, "string", "'");
		$json .= ",kd_pat:" . ew_VarToJson($this->kd_pat->CurrentValue, "string", "'");
		$json .= ",kd_jenjang:" . ew_VarToJson($this->kd_jenjang->CurrentValue, "string", "'");
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
		if (!is_null($this->kd_jbt->CurrentValue)) {
			$sUrl .= "&kd_jbt=" . urlencode($this->kd_jbt->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->kd_pat->CurrentValue)) {
			$sUrl .= "&kd_pat=" . urlencode($this->kd_pat->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->kd_jenjang->CurrentValue)) {
			$sUrl .= "&kd_jenjang=" . urlencode($this->kd_jenjang->CurrentValue);
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
			if ($isPost && isset($_POST["kd_jbt"]))
				$arKey[] = $_POST["kd_jbt"];
			elseif (isset($_GET["kd_jbt"]))
				$arKey[] = $_GET["kd_jbt"];
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["kd_pat"]))
				$arKey[] = $_POST["kd_pat"];
			elseif (isset($_GET["kd_pat"]))
				$arKey[] = $_GET["kd_pat"];
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["kd_jenjang"]))
				$arKey[] = $_POST["kd_jenjang"];
			elseif (isset($_GET["kd_jenjang"]))
				$arKey[] = $_GET["kd_jenjang"];
			else
				$arKeys = NULL; // Do not setup
			if (is_array($arKeys)) $arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_array($key) || count($key) <> 5)
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
			$this->kd_jbt->CurrentValue = $key[2];
			$this->kd_pat->CurrentValue = $key[3];
			$this->kd_jenjang->CurrentValue = $key[4];
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
		$this->kd_jbt->setDbValue($rs->fields('kd_jbt'));
		$this->kd_pat->setDbValue($rs->fields('kd_pat'));
		$this->kd_jenjang->setDbValue($rs->fields('kd_jenjang'));
		$this->tgl_mulai->setDbValue($rs->fields('tgl_mulai'));
		$this->tgl_akhir->setDbValue($rs->fields('tgl_akhir'));
		$this->no_sk->setDbValue($rs->fields('no_sk'));
		$this->ket->setDbValue($rs->fields('ket'));
		$this->company->setDbValue($rs->fields('company'));
		$this->created_by->setDbValue($rs->fields('created_by'));
		$this->created_date->setDbValue($rs->fields('created_date'));
		$this->last_update_by->setDbValue($rs->fields('last_update_by'));
		$this->last_update_date->setDbValue($rs->fields('last_update_date'));
		$this->st->setDbValue($rs->fields('st'));
		$this->kd_jbt_eselon->setDbValue($rs->fields('kd_jbt_eselon'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// employee_id
		// kd_jbt
		// kd_pat
		// kd_jenjang
		// tgl_mulai
		// tgl_akhir
		// no_sk
		// ket
		// company
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// st
		// kd_jbt_eselon
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// employee_id
		$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
		$this->employee_id->ViewCustomAttributes = "";

		// kd_jbt
		$this->kd_jbt->ViewValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// kd_pat
		$this->kd_pat->ViewValue = $this->kd_pat->CurrentValue;
		$this->kd_pat->ViewCustomAttributes = "";

		// kd_jenjang
		$this->kd_jenjang->ViewValue = $this->kd_jenjang->CurrentValue;
		$this->kd_jenjang->ViewCustomAttributes = "";

		// tgl_mulai
		$this->tgl_mulai->ViewValue = $this->tgl_mulai->CurrentValue;
		$this->tgl_mulai->ViewValue = ew_FormatDateTime($this->tgl_mulai->ViewValue, 0);
		$this->tgl_mulai->ViewCustomAttributes = "";

		// tgl_akhir
		$this->tgl_akhir->ViewValue = $this->tgl_akhir->CurrentValue;
		$this->tgl_akhir->ViewValue = ew_FormatDateTime($this->tgl_akhir->ViewValue, 0);
		$this->tgl_akhir->ViewCustomAttributes = "";

		// no_sk
		$this->no_sk->ViewValue = $this->no_sk->CurrentValue;
		$this->no_sk->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

		// company
		$this->company->ViewValue = $this->company->CurrentValue;
		$this->company->ViewCustomAttributes = "";

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

		// st
		$this->st->ViewValue = $this->st->CurrentValue;
		$this->st->ViewCustomAttributes = "";

		// kd_jbt_eselon
		$this->kd_jbt_eselon->ViewValue = $this->kd_jbt_eselon->CurrentValue;
		$this->kd_jbt_eselon->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// employee_id
		$this->employee_id->LinkCustomAttributes = "";
		$this->employee_id->HrefValue = "";
		$this->employee_id->TooltipValue = "";

		// kd_jbt
		$this->kd_jbt->LinkCustomAttributes = "";
		$this->kd_jbt->HrefValue = "";
		$this->kd_jbt->TooltipValue = "";

		// kd_pat
		$this->kd_pat->LinkCustomAttributes = "";
		$this->kd_pat->HrefValue = "";
		$this->kd_pat->TooltipValue = "";

		// kd_jenjang
		$this->kd_jenjang->LinkCustomAttributes = "";
		$this->kd_jenjang->HrefValue = "";
		$this->kd_jenjang->TooltipValue = "";

		// tgl_mulai
		$this->tgl_mulai->LinkCustomAttributes = "";
		$this->tgl_mulai->HrefValue = "";
		$this->tgl_mulai->TooltipValue = "";

		// tgl_akhir
		$this->tgl_akhir->LinkCustomAttributes = "";
		$this->tgl_akhir->HrefValue = "";
		$this->tgl_akhir->TooltipValue = "";

		// no_sk
		$this->no_sk->LinkCustomAttributes = "";
		$this->no_sk->HrefValue = "";
		$this->no_sk->TooltipValue = "";

		// ket
		$this->ket->LinkCustomAttributes = "";
		$this->ket->HrefValue = "";
		$this->ket->TooltipValue = "";

		// company
		$this->company->LinkCustomAttributes = "";
		$this->company->HrefValue = "";
		$this->company->TooltipValue = "";

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

		// st
		$this->st->LinkCustomAttributes = "";
		$this->st->HrefValue = "";
		$this->st->TooltipValue = "";

		// kd_jbt_eselon
		$this->kd_jbt_eselon->LinkCustomAttributes = "";
		$this->kd_jbt_eselon->HrefValue = "";
		$this->kd_jbt_eselon->TooltipValue = "";

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
		$this->employee_id->ViewCustomAttributes = "";

		// kd_jbt
		$this->kd_jbt->EditAttrs["class"] = "form-control";
		$this->kd_jbt->EditCustomAttributes = "";
		$this->kd_jbt->EditValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// kd_pat
		$this->kd_pat->EditAttrs["class"] = "form-control";
		$this->kd_pat->EditCustomAttributes = "";
		$this->kd_pat->EditValue = $this->kd_pat->CurrentValue;
		$this->kd_pat->ViewCustomAttributes = "";

		// kd_jenjang
		$this->kd_jenjang->EditAttrs["class"] = "form-control";
		$this->kd_jenjang->EditCustomAttributes = "";
		$this->kd_jenjang->EditValue = $this->kd_jenjang->CurrentValue;
		$this->kd_jenjang->ViewCustomAttributes = "";

		// tgl_mulai
		$this->tgl_mulai->EditAttrs["class"] = "form-control";
		$this->tgl_mulai->EditCustomAttributes = "";
		$this->tgl_mulai->EditValue = ew_FormatDateTime($this->tgl_mulai->CurrentValue, 8);
		$this->tgl_mulai->PlaceHolder = ew_RemoveHtml($this->tgl_mulai->FldCaption());

		// tgl_akhir
		$this->tgl_akhir->EditAttrs["class"] = "form-control";
		$this->tgl_akhir->EditCustomAttributes = "";
		$this->tgl_akhir->EditValue = ew_FormatDateTime($this->tgl_akhir->CurrentValue, 8);
		$this->tgl_akhir->PlaceHolder = ew_RemoveHtml($this->tgl_akhir->FldCaption());

		// no_sk
		$this->no_sk->EditAttrs["class"] = "form-control";
		$this->no_sk->EditCustomAttributes = "";
		$this->no_sk->EditValue = $this->no_sk->CurrentValue;
		$this->no_sk->PlaceHolder = ew_RemoveHtml($this->no_sk->FldCaption());

		// ket
		$this->ket->EditAttrs["class"] = "form-control";
		$this->ket->EditCustomAttributes = "";
		$this->ket->EditValue = $this->ket->CurrentValue;
		$this->ket->PlaceHolder = ew_RemoveHtml($this->ket->FldCaption());

		// company
		$this->company->EditAttrs["class"] = "form-control";
		$this->company->EditCustomAttributes = "";
		$this->company->EditValue = $this->company->CurrentValue;
		$this->company->PlaceHolder = ew_RemoveHtml($this->company->FldCaption());

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

		// st
		$this->st->EditAttrs["class"] = "form-control";
		$this->st->EditCustomAttributes = "";
		$this->st->EditValue = $this->st->CurrentValue;
		$this->st->PlaceHolder = ew_RemoveHtml($this->st->FldCaption());

		// kd_jbt_eselon
		$this->kd_jbt_eselon->EditAttrs["class"] = "form-control";
		$this->kd_jbt_eselon->EditCustomAttributes = "";
		$this->kd_jbt_eselon->EditValue = $this->kd_jbt_eselon->CurrentValue;
		$this->kd_jbt_eselon->PlaceHolder = ew_RemoveHtml($this->kd_jbt_eselon->FldCaption());

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
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->employee_id->Exportable) $Doc->ExportCaption($this->employee_id);
					if ($this->kd_jbt->Exportable) $Doc->ExportCaption($this->kd_jbt);
					if ($this->kd_pat->Exportable) $Doc->ExportCaption($this->kd_pat);
					if ($this->kd_jenjang->Exportable) $Doc->ExportCaption($this->kd_jenjang);
					if ($this->tgl_mulai->Exportable) $Doc->ExportCaption($this->tgl_mulai);
					if ($this->tgl_akhir->Exportable) $Doc->ExportCaption($this->tgl_akhir);
					if ($this->no_sk->Exportable) $Doc->ExportCaption($this->no_sk);
					if ($this->ket->Exportable) $Doc->ExportCaption($this->ket);
					if ($this->company->Exportable) $Doc->ExportCaption($this->company);
					if ($this->created_by->Exportable) $Doc->ExportCaption($this->created_by);
					if ($this->created_date->Exportable) $Doc->ExportCaption($this->created_date);
					if ($this->last_update_by->Exportable) $Doc->ExportCaption($this->last_update_by);
					if ($this->last_update_date->Exportable) $Doc->ExportCaption($this->last_update_date);
					if ($this->st->Exportable) $Doc->ExportCaption($this->st);
					if ($this->kd_jbt_eselon->Exportable) $Doc->ExportCaption($this->kd_jbt_eselon);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->employee_id->Exportable) $Doc->ExportCaption($this->employee_id);
					if ($this->kd_jbt->Exportable) $Doc->ExportCaption($this->kd_jbt);
					if ($this->kd_pat->Exportable) $Doc->ExportCaption($this->kd_pat);
					if ($this->kd_jenjang->Exportable) $Doc->ExportCaption($this->kd_jenjang);
					if ($this->tgl_mulai->Exportable) $Doc->ExportCaption($this->tgl_mulai);
					if ($this->tgl_akhir->Exportable) $Doc->ExportCaption($this->tgl_akhir);
					if ($this->no_sk->Exportable) $Doc->ExportCaption($this->no_sk);
					if ($this->ket->Exportable) $Doc->ExportCaption($this->ket);
					if ($this->company->Exportable) $Doc->ExportCaption($this->company);
					if ($this->created_by->Exportable) $Doc->ExportCaption($this->created_by);
					if ($this->created_date->Exportable) $Doc->ExportCaption($this->created_date);
					if ($this->last_update_by->Exportable) $Doc->ExportCaption($this->last_update_by);
					if ($this->last_update_date->Exportable) $Doc->ExportCaption($this->last_update_date);
					if ($this->st->Exportable) $Doc->ExportCaption($this->st);
					if ($this->kd_jbt_eselon->Exportable) $Doc->ExportCaption($this->kd_jbt_eselon);
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
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->employee_id->Exportable) $Doc->ExportField($this->employee_id);
						if ($this->kd_jbt->Exportable) $Doc->ExportField($this->kd_jbt);
						if ($this->kd_pat->Exportable) $Doc->ExportField($this->kd_pat);
						if ($this->kd_jenjang->Exportable) $Doc->ExportField($this->kd_jenjang);
						if ($this->tgl_mulai->Exportable) $Doc->ExportField($this->tgl_mulai);
						if ($this->tgl_akhir->Exportable) $Doc->ExportField($this->tgl_akhir);
						if ($this->no_sk->Exportable) $Doc->ExportField($this->no_sk);
						if ($this->ket->Exportable) $Doc->ExportField($this->ket);
						if ($this->company->Exportable) $Doc->ExportField($this->company);
						if ($this->created_by->Exportable) $Doc->ExportField($this->created_by);
						if ($this->created_date->Exportable) $Doc->ExportField($this->created_date);
						if ($this->last_update_by->Exportable) $Doc->ExportField($this->last_update_by);
						if ($this->last_update_date->Exportable) $Doc->ExportField($this->last_update_date);
						if ($this->st->Exportable) $Doc->ExportField($this->st);
						if ($this->kd_jbt_eselon->Exportable) $Doc->ExportField($this->kd_jbt_eselon);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->employee_id->Exportable) $Doc->ExportField($this->employee_id);
						if ($this->kd_jbt->Exportable) $Doc->ExportField($this->kd_jbt);
						if ($this->kd_pat->Exportable) $Doc->ExportField($this->kd_pat);
						if ($this->kd_jenjang->Exportable) $Doc->ExportField($this->kd_jenjang);
						if ($this->tgl_mulai->Exportable) $Doc->ExportField($this->tgl_mulai);
						if ($this->tgl_akhir->Exportable) $Doc->ExportField($this->tgl_akhir);
						if ($this->no_sk->Exportable) $Doc->ExportField($this->no_sk);
						if ($this->ket->Exportable) $Doc->ExportField($this->ket);
						if ($this->company->Exportable) $Doc->ExportField($this->company);
						if ($this->created_by->Exportable) $Doc->ExportField($this->created_by);
						if ($this->created_date->Exportable) $Doc->ExportField($this->created_date);
						if ($this->last_update_by->Exportable) $Doc->ExportField($this->last_update_by);
						if ($this->last_update_date->Exportable) $Doc->ExportField($this->last_update_date);
						if ($this->st->Exportable) $Doc->ExportField($this->st);
						if ($this->kd_jbt_eselon->Exportable) $Doc->ExportField($this->kd_jbt_eselon);
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
