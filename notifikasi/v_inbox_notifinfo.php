<?php

// Global variable for table object
$v_inbox_notif = NULL;

//
// Table class for v_inbox_notif
//
class cv_inbox_notif extends cTable {
	var $id;
	var $employee_id;
	var $priority;
	var $topic;
	var $isi_notif;
	var $tgl_cr;
	var $USER_NAME;
	var $cr_by;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'v_inbox_notif';
		$this->TableName = 'v_inbox_notif';
		$this->TableType = 'CUSTOMVIEW';

		// Update Table
		$this->UpdateTable = "tb_notifikasi_d INNER JOIN tb_notifikasi ON tb_notifikasi.id = tb_notifikasi_d.id INNER JOIN m_users ON tb_notifikasi.cr_by = m_users.USER_ID";
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
		$this->id = new cField('v_inbox_notif', 'v_inbox_notif', 'x_id', 'id', 'tb_notifikasi_d.id', 'tb_notifikasi_d.id', 3, -1, FALSE, 'tb_notifikasi_d.id', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// employee_id
		$this->employee_id = new cField('v_inbox_notif', 'v_inbox_notif', 'x_employee_id', 'employee_id', 'tb_notifikasi_d.employee_id', 'tb_notifikasi_d.employee_id', 200, -1, FALSE, 'tb_notifikasi_d.employee_id', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->employee_id->Sortable = TRUE; // Allow sort
		$this->fields['employee_id'] = &$this->employee_id;

		// priority
		$this->priority = new cField('v_inbox_notif', 'v_inbox_notif', 'x_priority', 'priority', 'tb_notifikasi.priority', 'tb_notifikasi.priority', 200, -1, FALSE, 'tb_notifikasi.priority', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->priority->Sortable = TRUE; // Allow sort
		$this->priority->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->priority->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->priority->OptionCount = 3;
		$this->fields['priority'] = &$this->priority;

		// topic
		$this->topic = new cField('v_inbox_notif', 'v_inbox_notif', 'x_topic', 'topic', 'tb_notifikasi.topic', 'tb_notifikasi.topic', 200, -1, FALSE, 'tb_notifikasi.topic', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->topic->Sortable = TRUE; // Allow sort
		$this->topic->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->topic->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['topic'] = &$this->topic;

		// isi_notif
		$this->isi_notif = new cField('v_inbox_notif', 'v_inbox_notif', 'x_isi_notif', 'isi_notif', 'tb_notifikasi.isi_notif', 'tb_notifikasi.isi_notif', 200, -1, FALSE, 'tb_notifikasi.isi_notif', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->isi_notif->Sortable = TRUE; // Allow sort
		$this->fields['isi_notif'] = &$this->isi_notif;

		// tgl_cr
		$this->tgl_cr = new cField('v_inbox_notif', 'v_inbox_notif', 'x_tgl_cr', 'tgl_cr', 'tb_notifikasi.tgl_cr', ew_CastDateFieldForLike('tb_notifikasi.tgl_cr', 2, "DB"), 133, 2, FALSE, 'tb_notifikasi.tgl_cr', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_cr->Sortable = TRUE; // Allow sort
		$this->tgl_cr->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_cr'] = &$this->tgl_cr;

		// USER_NAME
		$this->USER_NAME = new cField('v_inbox_notif', 'v_inbox_notif', 'x_USER_NAME', 'USER_NAME', 'm_users.USER_NAME', 'm_users.USER_NAME', 200, -1, FALSE, 'm_users.USER_NAME', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->USER_NAME->Sortable = TRUE; // Allow sort
		$this->fields['USER_NAME'] = &$this->USER_NAME;

		// cr_by
		$this->cr_by = new cField('v_inbox_notif', 'v_inbox_notif', 'x_cr_by', 'cr_by', 'tb_notifikasi.cr_by', 'tb_notifikasi.cr_by', 200, -1, FALSE, 'tb_notifikasi.cr_by', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cr_by->Sortable = TRUE; // Allow sort
		$this->fields['cr_by'] = &$this->cr_by;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "tb_notifikasi_d INNER JOIN tb_notifikasi ON tb_notifikasi.id = tb_notifikasi_d.id INNER JOIN m_users ON tb_notifikasi.cr_by = m_users.USER_ID";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT tb_notifikasi_d.id, tb_notifikasi_d.employee_id, tb_notifikasi.priority, tb_notifikasi.topic, tb_notifikasi.isi_notif, tb_notifikasi.tgl_cr, m_users.USER_NAME, tb_notifikasi.cr_by FROM " . $this->getSqlFrom();
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
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "tb_notifikasi_d.id, tb_notifikasi.cr_by";
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
			return "v_inbox_notiflist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "v_inbox_notifview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "v_inbox_notifedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "v_inbox_notifadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "v_inbox_notiflist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("v_inbox_notifview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("v_inbox_notifview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "v_inbox_notifadd.php?" . $this->UrlParm($parm);
		else
			$url = "v_inbox_notifadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("v_inbox_notifedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("v_inbox_notifadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("v_inbox_notifdelete.php", $this->UrlParm());
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
		$this->id->setDbValue($rs->fields('id'));
		$this->employee_id->setDbValue($rs->fields('employee_id'));
		$this->priority->setDbValue($rs->fields('priority'));
		$this->topic->setDbValue($rs->fields('topic'));
		$this->isi_notif->setDbValue($rs->fields('isi_notif'));
		$this->tgl_cr->setDbValue($rs->fields('tgl_cr'));
		$this->USER_NAME->setDbValue($rs->fields('USER_NAME'));
		$this->cr_by->setDbValue($rs->fields('cr_by'));
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

		// priority
		// topic
		// isi_notif
		// tgl_cr
		// USER_NAME
		// cr_by
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

		// priority
		if (strval($this->priority->CurrentValue) <> "") {
			$this->priority->ViewValue = $this->priority->OptionCaption($this->priority->CurrentValue);
		} else {
			$this->priority->ViewValue = NULL;
		}
		$this->priority->ViewCustomAttributes = "";

		// topic
		if (strval($this->topic->CurrentValue) <> "") {
			$sFilterWrk = "`nama_referensi`" . ew_SearchString("=", $this->topic->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama_referensi`, `nama_referensi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM referensi";
		$sWhereWrk = "(id_ref=12)";
		$this->topic->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->topic, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->topic->ViewValue = $this->topic->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->topic->ViewValue = $this->topic->CurrentValue;
			}
		} else {
			$this->topic->ViewValue = NULL;
		}
		$this->topic->ViewCustomAttributes = "";

		// isi_notif
		$this->isi_notif->ViewValue = $this->isi_notif->CurrentValue;
		$this->isi_notif->ViewCustomAttributes = "";

		// tgl_cr
		$this->tgl_cr->ViewValue = $this->tgl_cr->CurrentValue;
		$this->tgl_cr->ViewValue = ew_FormatDateTime($this->tgl_cr->ViewValue, 2);
		$this->tgl_cr->ViewCustomAttributes = "";

		// USER_NAME
		$this->USER_NAME->ViewValue = $this->USER_NAME->CurrentValue;
		$this->USER_NAME->ViewCustomAttributes = "";

		// cr_by
		$this->cr_by->ViewValue = $this->cr_by->CurrentValue;
		$this->cr_by->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// employee_id
		$this->employee_id->LinkCustomAttributes = "";
		$this->employee_id->HrefValue = "";
		$this->employee_id->TooltipValue = "";

		// priority
		$this->priority->LinkCustomAttributes = "";
		$this->priority->HrefValue = "";
		$this->priority->TooltipValue = "";

		// topic
		$this->topic->LinkCustomAttributes = "";
		$this->topic->HrefValue = "";
		$this->topic->TooltipValue = "";

		// isi_notif
		$this->isi_notif->LinkCustomAttributes = "";
		$this->isi_notif->HrefValue = "";
		$this->isi_notif->TooltipValue = "";

		// tgl_cr
		$this->tgl_cr->LinkCustomAttributes = "";
		$this->tgl_cr->HrefValue = "";
		$this->tgl_cr->TooltipValue = "";

		// USER_NAME
		$this->USER_NAME->LinkCustomAttributes = "";
		$this->USER_NAME->HrefValue = "";
		$this->USER_NAME->TooltipValue = "";

		// cr_by
		$this->cr_by->LinkCustomAttributes = "";
		$this->cr_by->HrefValue = "";
		$this->cr_by->TooltipValue = "";

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
		$this->id->PlaceHolder = ew_RemoveHtml($this->id->FldCaption());

		// employee_id
		$this->employee_id->EditAttrs["class"] = "form-control";
		$this->employee_id->EditCustomAttributes = "";
		$this->employee_id->EditValue = $this->employee_id->CurrentValue;
		$this->employee_id->PlaceHolder = ew_RemoveHtml($this->employee_id->FldCaption());

		// priority
		$this->priority->EditAttrs["class"] = "form-control";
		$this->priority->EditCustomAttributes = "";
		$this->priority->EditValue = $this->priority->Options(TRUE);

		// topic
		$this->topic->EditAttrs["class"] = "form-control";
		$this->topic->EditCustomAttributes = "";

		// isi_notif
		$this->isi_notif->EditAttrs["class"] = "form-control";
		$this->isi_notif->EditCustomAttributes = "";
		$this->isi_notif->EditValue = $this->isi_notif->CurrentValue;
		$this->isi_notif->PlaceHolder = ew_RemoveHtml($this->isi_notif->FldCaption());

		// tgl_cr
		$this->tgl_cr->EditAttrs["class"] = "form-control";
		$this->tgl_cr->EditCustomAttributes = "";
		$this->tgl_cr->EditValue = ew_FormatDateTime($this->tgl_cr->CurrentValue, 2);
		$this->tgl_cr->PlaceHolder = ew_RemoveHtml($this->tgl_cr->FldCaption());

		// USER_NAME
		$this->USER_NAME->EditAttrs["class"] = "form-control";
		$this->USER_NAME->EditCustomAttributes = "";
		$this->USER_NAME->EditValue = $this->USER_NAME->CurrentValue;
		$this->USER_NAME->PlaceHolder = ew_RemoveHtml($this->USER_NAME->FldCaption());

		// cr_by
		$this->cr_by->EditAttrs["class"] = "form-control";
		$this->cr_by->EditCustomAttributes = "";
		$this->cr_by->EditValue = $this->cr_by->CurrentValue;
		$this->cr_by->PlaceHolder = ew_RemoveHtml($this->cr_by->FldCaption());

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
					if ($this->priority->Exportable) $Doc->ExportCaption($this->priority);
					if ($this->topic->Exportable) $Doc->ExportCaption($this->topic);
					if ($this->isi_notif->Exportable) $Doc->ExportCaption($this->isi_notif);
					if ($this->tgl_cr->Exportable) $Doc->ExportCaption($this->tgl_cr);
					if ($this->USER_NAME->Exportable) $Doc->ExportCaption($this->USER_NAME);
					if ($this->cr_by->Exportable) $Doc->ExportCaption($this->cr_by);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->employee_id->Exportable) $Doc->ExportCaption($this->employee_id);
					if ($this->priority->Exportable) $Doc->ExportCaption($this->priority);
					if ($this->topic->Exportable) $Doc->ExportCaption($this->topic);
					if ($this->isi_notif->Exportable) $Doc->ExportCaption($this->isi_notif);
					if ($this->tgl_cr->Exportable) $Doc->ExportCaption($this->tgl_cr);
					if ($this->USER_NAME->Exportable) $Doc->ExportCaption($this->USER_NAME);
					if ($this->cr_by->Exportable) $Doc->ExportCaption($this->cr_by);
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
						if ($this->priority->Exportable) $Doc->ExportField($this->priority);
						if ($this->topic->Exportable) $Doc->ExportField($this->topic);
						if ($this->isi_notif->Exportable) $Doc->ExportField($this->isi_notif);
						if ($this->tgl_cr->Exportable) $Doc->ExportField($this->tgl_cr);
						if ($this->USER_NAME->Exportable) $Doc->ExportField($this->USER_NAME);
						if ($this->cr_by->Exportable) $Doc->ExportField($this->cr_by);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->employee_id->Exportable) $Doc->ExportField($this->employee_id);
						if ($this->priority->Exportable) $Doc->ExportField($this->priority);
						if ($this->topic->Exportable) $Doc->ExportField($this->topic);
						if ($this->isi_notif->Exportable) $Doc->ExportField($this->isi_notif);
						if ($this->tgl_cr->Exportable) $Doc->ExportField($this->tgl_cr);
						if ($this->USER_NAME->Exportable) $Doc->ExportField($this->USER_NAME);
						if ($this->cr_by->Exportable) $Doc->ExportField($this->cr_by);
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
		//$_SESSION['user_id']
	//	if(isset($_SESSION['u_id'])===false){

		if(isset( $_REQUEST["u_id"])){ 
			$id=$_REQUEST["u_id"];
			$_SESSION['u_id']=$id;
		}

		//if(isset($_SESSION['home'])===false){
		if(isset($_REQUEST["back"])){
			$_SESSION['home']=$_REQUEST["back"];
		}
		if(isset( $_REQUEST["id_notif"])){
			ew_AddFilter($filter, "`tb_notifikasi`.`id` IN ('" . $_REQUEST["id_notif"] . "')");
		}else{
			ew_AddFilter($filter, "`tb_notifikasi`.`cr_by` IN ('" . $_SESSION['u_id'] . "')");
		}
	/*
	$currentPath = $_SERVER['PHP_SELF'];
	$postpath=strpos($currentPath,'/');
	$cek = substr($currentPath,0,$postpath);

	// output: localhost
		$hostName = $_SERVER['HTTP_HOST']; 

		// output: http://
		$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
	*/
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
