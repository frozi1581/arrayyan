<?php

// Global variable for table object
$tb_notifikasi = NULL;

//
// Table class for tb_notifikasi
//
class ctb_notifikasi extends cTable {
	var $id;
	var $topic;
	var $priority;
	var $isi_notif;
	var $action;
	var $tgl_cr;
	var $cr_by;
	var $filter_penerima;
	var $tgl_upd;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tb_notifikasi';
		$this->TableName = 'tb_notifikasi';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`tb_notifikasi`";
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
		$this->id = new cField('tb_notifikasi', 'tb_notifikasi', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// topic
		$this->topic = new cField('tb_notifikasi', 'tb_notifikasi', 'x_topic', 'topic', '`topic`', '`topic`', 200, -1, FALSE, '`topic`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->topic->Sortable = TRUE; // Allow sort
		$this->topic->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->topic->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['topic'] = &$this->topic;

		// priority
		$this->priority = new cField('tb_notifikasi', 'tb_notifikasi', 'x_priority', 'priority', '`priority`', '`priority`', 200, -1, FALSE, '`priority`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->priority->Sortable = TRUE; // Allow sort
		$this->priority->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->priority->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->priority->OptionCount = 3;
		$this->fields['priority'] = &$this->priority;

		// isi_notif
		$this->isi_notif = new cField('tb_notifikasi', 'tb_notifikasi', 'x_isi_notif', 'isi_notif', '`isi_notif`', '`isi_notif`', 200, -1, FALSE, '`isi_notif`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->isi_notif->Sortable = TRUE; // Allow sort
		$this->fields['isi_notif'] = &$this->isi_notif;

		// action
		$this->action = new cField('tb_notifikasi', 'tb_notifikasi', 'x_action', 'action', '`action`', '`action`', 200, -1, FALSE, '`action`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->action->Sortable = TRUE; // Allow sort
		$this->fields['action'] = &$this->action;

		// tgl_cr
		$this->tgl_cr = new cField('tb_notifikasi', 'tb_notifikasi', 'x_tgl_cr', 'tgl_cr', '`tgl_cr`', ew_CastDateFieldForLike('`tgl_cr`', 2, "DB"), 133, 2, FALSE, '`tgl_cr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_cr->Sortable = TRUE; // Allow sort
		$this->tgl_cr->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_cr'] = &$this->tgl_cr;

		// cr_by
		$this->cr_by = new cField('tb_notifikasi', 'tb_notifikasi', 'x_cr_by', 'cr_by', '`cr_by`', '`cr_by`', 200, -1, FALSE, '`cr_by`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cr_by->Sortable = TRUE; // Allow sort
		$this->fields['cr_by'] = &$this->cr_by;

		// filter_penerima
		$this->filter_penerima = new cField('tb_notifikasi', 'tb_notifikasi', 'x_filter_penerima', 'filter_penerima', '\'\'', '\'\'', 201, -1, FALSE, '\'\'', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->filter_penerima->FldIsCustom = TRUE; // Custom field
		$this->filter_penerima->Sortable = TRUE; // Allow sort
		$this->fields['filter_penerima'] = &$this->filter_penerima;

		// tgl_upd
		$this->tgl_upd = new cField('tb_notifikasi', 'tb_notifikasi', 'x_tgl_upd', 'tgl_upd', '`tgl_upd`', ew_CastDateFieldForLike('`tgl_upd`', 0, "DB"), 133, 0, FALSE, '`tgl_upd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_upd->Sortable = TRUE; // Allow sort
		$this->tgl_upd->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_upd'] = &$this->tgl_upd;
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

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "tb_notifikasi_d") {
			$sDetailUrl = $GLOBALS["tb_notifikasi_d"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "tb_notifikasilist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tb_notifikasi`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT *, '' AS `filter_penerima` FROM " . $this->getSqlFrom();
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

		// Cascade Update detail table 'tb_notifikasi_d'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['id']) && $rsold['id'] <> $rs['id'])) { // Update detail field 'id'
			$bCascadeUpdate = TRUE;
			$rscascade['id'] = $rs['id']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["tb_notifikasi_d"])) $GLOBALS["tb_notifikasi_d"] = new ctb_notifikasi_d();
			$rswrk = $GLOBALS["tb_notifikasi_d"]->LoadRs("`id` = " . ew_QuotedValue($rsold['id'], EW_DATATYPE_NUMBER, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = array();
				$fldname = 'id';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$fldname = 'employee_id';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$rsdtlold = &$rswrk->fields;
				$rsdtlnew = array_merge($rsdtlold, $rscascade);

				// Call Row_Updating event
				$bUpdate = $GLOBALS["tb_notifikasi_d"]->Row_Updating($rsdtlold, $rsdtlnew);
				if ($bUpdate)
					$bUpdate = $GLOBALS["tb_notifikasi_d"]->Update($rscascade, $rskey, $rswrk->fields);
				if (!$bUpdate) return FALSE;

				// Call Row_Updated event
				$GLOBALS["tb_notifikasi_d"]->Row_Updated($rsdtlold, $rsdtlnew);
				$rswrk->MoveNext();
			}
		}
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

		// Cascade delete detail table 'tb_notifikasi_d'
		if (!isset($GLOBALS["tb_notifikasi_d"])) $GLOBALS["tb_notifikasi_d"] = new ctb_notifikasi_d();
		$rscascade = $GLOBALS["tb_notifikasi_d"]->LoadRs("`id` = " . ew_QuotedValue($rs['id'], EW_DATATYPE_NUMBER, "DB")); 
		$dtlrows = ($rscascade) ? $rscascade->GetRows() : array();

		// Call Row Deleting event
		foreach ($dtlrows as $dtlrow) {
			$bDelete = $GLOBALS["tb_notifikasi_d"]->Row_Deleting($dtlrow);
			if (!$bDelete) break;
		}
		if ($bDelete) {
			foreach ($dtlrows as $dtlrow) {
				$bDelete = $GLOBALS["tb_notifikasi_d"]->Delete($dtlrow); // Delete
				if ($bDelete === FALSE)
					break;
			}
		}

		// Call Row Deleted event
		if ($bDelete) {
			foreach ($dtlrows as $dtlrow) {
				$GLOBALS["tb_notifikasi_d"]->Row_Deleted($dtlrow);
			}
		}
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
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
			return "tb_notifikasilist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "tb_notifikasiview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "tb_notifikasiedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "tb_notifikasiadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "tb_notifikasilist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tb_notifikasiview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tb_notifikasiview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tb_notifikasiadd.php?" . $this->UrlParm($parm);
		else
			$url = "tb_notifikasiadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tb_notifikasiedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tb_notifikasiedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tb_notifikasiadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tb_notifikasiadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tb_notifikasidelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
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
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = $_POST["id"];
			elseif (isset($_GET["id"]))
				$arKeys[] = $_GET["id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
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
			$this->id->CurrentValue = $key;
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
		$this->topic->setDbValue($rs->fields('topic'));
		$this->priority->setDbValue($rs->fields('priority'));
		$this->isi_notif->setDbValue($rs->fields('isi_notif'));
		$this->action->setDbValue($rs->fields('action'));
		$this->tgl_cr->setDbValue($rs->fields('tgl_cr'));
		$this->cr_by->setDbValue($rs->fields('cr_by'));
		$this->filter_penerima->setDbValue($rs->fields('filter_penerima'));
		$this->tgl_upd->setDbValue($rs->fields('tgl_upd'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// topic
		// priority
		// isi_notif
		// action
		// tgl_cr
		// cr_by
		// filter_penerima
		// tgl_upd
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

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

		// priority
		if (strval($this->priority->CurrentValue) <> "") {
			$this->priority->ViewValue = $this->priority->OptionCaption($this->priority->CurrentValue);
		} else {
			$this->priority->ViewValue = NULL;
		}
		$this->priority->ViewCustomAttributes = "";

		// isi_notif
		$this->isi_notif->ViewValue = $this->isi_notif->CurrentValue;
		$this->isi_notif->ViewCustomAttributes = "";

		// action
		$this->action->ViewValue = $this->action->CurrentValue;
		$this->action->ViewCustomAttributes = "";

		// tgl_cr
		$this->tgl_cr->ViewValue = $this->tgl_cr->CurrentValue;
		$this->tgl_cr->ViewValue = ew_FormatDateTime($this->tgl_cr->ViewValue, 2);
		$this->tgl_cr->ViewCustomAttributes = "";

		// cr_by
		$this->cr_by->ViewValue = $this->cr_by->CurrentValue;
		$this->cr_by->ViewCustomAttributes = "";

		// filter_penerima
		$this->filter_penerima->ViewValue = $this->filter_penerima->CurrentValue;
		if (strval($this->filter_penerima->CurrentValue) <> "") {
			$sFilterWrk = "tb_pat.KD_PAT" . ew_SearchString("=", $this->filter_penerima->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `KD_PAT`, `KET` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM tb_pat";
		$sWhereWrk = "";
		$this->filter_penerima->LookupFilters = array("dx1" => 'tb_pat.KET');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->filter_penerima, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->filter_penerima->ViewValue = $this->filter_penerima->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->filter_penerima->ViewValue = $this->filter_penerima->CurrentValue;
			}
		} else {
			$this->filter_penerima->ViewValue = NULL;
		}
		$this->filter_penerima->ViewCustomAttributes = "";

		// tgl_upd
		$this->tgl_upd->ViewValue = $this->tgl_upd->CurrentValue;
		$this->tgl_upd->ViewValue = ew_FormatDateTime($this->tgl_upd->ViewValue, 0);
		$this->tgl_upd->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// topic
		$this->topic->LinkCustomAttributes = "";
		$this->topic->HrefValue = "";
		$this->topic->TooltipValue = "";

		// priority
		$this->priority->LinkCustomAttributes = "";
		$this->priority->HrefValue = "";
		$this->priority->TooltipValue = "";

		// isi_notif
		$this->isi_notif->LinkCustomAttributes = "";
		$this->isi_notif->HrefValue = "";
		$this->isi_notif->TooltipValue = "";

		// action
		$this->action->LinkCustomAttributes = "";
		$this->action->HrefValue = "";
		$this->action->TooltipValue = "";

		// tgl_cr
		$this->tgl_cr->LinkCustomAttributes = "";
		$this->tgl_cr->HrefValue = "";
		$this->tgl_cr->TooltipValue = "";

		// cr_by
		$this->cr_by->LinkCustomAttributes = "";
		$this->cr_by->HrefValue = "";
		$this->cr_by->TooltipValue = "";

		// filter_penerima
		$this->filter_penerima->LinkCustomAttributes = "";
		$this->filter_penerima->HrefValue = "";
		$this->filter_penerima->TooltipValue = "";

		// tgl_upd
		$this->tgl_upd->LinkCustomAttributes = "";
		$this->tgl_upd->HrefValue = "";
		$this->tgl_upd->TooltipValue = "";

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

		// topic
		$this->topic->EditAttrs["class"] = "form-control";
		$this->topic->EditCustomAttributes = "";

		// priority
		$this->priority->EditAttrs["class"] = "form-control";
		$this->priority->EditCustomAttributes = "";
		$this->priority->EditValue = $this->priority->Options(TRUE);

		// isi_notif
		$this->isi_notif->EditAttrs["class"] = "form-control";
		$this->isi_notif->EditCustomAttributes = "";
		$this->isi_notif->EditValue = $this->isi_notif->CurrentValue;
		$this->isi_notif->PlaceHolder = ew_RemoveHtml($this->isi_notif->FldCaption());

		// action
		$this->action->EditAttrs["class"] = "form-control";
		$this->action->EditCustomAttributes = "";
		$this->action->EditValue = $this->action->CurrentValue;
		$this->action->PlaceHolder = ew_RemoveHtml($this->action->FldCaption());

		// tgl_cr
		$this->tgl_cr->EditAttrs["class"] = "form-control";
		$this->tgl_cr->EditCustomAttributes = "";
		$this->tgl_cr->EditValue = ew_FormatDateTime($this->tgl_cr->CurrentValue, 2);
		$this->tgl_cr->PlaceHolder = ew_RemoveHtml($this->tgl_cr->FldCaption());

		// cr_by
		$this->cr_by->EditAttrs["class"] = "form-control";
		$this->cr_by->EditCustomAttributes = "";
		$this->cr_by->EditValue = $this->cr_by->CurrentValue;
		$this->cr_by->PlaceHolder = ew_RemoveHtml($this->cr_by->FldCaption());

		// filter_penerima
		$this->filter_penerima->EditAttrs["class"] = "form-control";
		$this->filter_penerima->EditCustomAttributes = "";
		$this->filter_penerima->EditValue = $this->filter_penerima->CurrentValue;
		$this->filter_penerima->PlaceHolder = ew_RemoveHtml($this->filter_penerima->FldCaption());

		// tgl_upd
		$this->tgl_upd->EditAttrs["class"] = "form-control";
		$this->tgl_upd->EditCustomAttributes = "";
		$this->tgl_upd->EditValue = ew_FormatDateTime($this->tgl_upd->CurrentValue, 8);
		$this->tgl_upd->PlaceHolder = ew_RemoveHtml($this->tgl_upd->FldCaption());

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
					if ($this->topic->Exportable) $Doc->ExportCaption($this->topic);
					if ($this->priority->Exportable) $Doc->ExportCaption($this->priority);
					if ($this->isi_notif->Exportable) $Doc->ExportCaption($this->isi_notif);
					if ($this->action->Exportable) $Doc->ExportCaption($this->action);
					if ($this->tgl_cr->Exportable) $Doc->ExportCaption($this->tgl_cr);
					if ($this->cr_by->Exportable) $Doc->ExportCaption($this->cr_by);
					if ($this->filter_penerima->Exportable) $Doc->ExportCaption($this->filter_penerima);
					if ($this->tgl_upd->Exportable) $Doc->ExportCaption($this->tgl_upd);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->topic->Exportable) $Doc->ExportCaption($this->topic);
					if ($this->priority->Exportable) $Doc->ExportCaption($this->priority);
					if ($this->isi_notif->Exportable) $Doc->ExportCaption($this->isi_notif);
					if ($this->action->Exportable) $Doc->ExportCaption($this->action);
					if ($this->tgl_cr->Exportable) $Doc->ExportCaption($this->tgl_cr);
					if ($this->cr_by->Exportable) $Doc->ExportCaption($this->cr_by);
					if ($this->tgl_upd->Exportable) $Doc->ExportCaption($this->tgl_upd);
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
						if ($this->topic->Exportable) $Doc->ExportField($this->topic);
						if ($this->priority->Exportable) $Doc->ExportField($this->priority);
						if ($this->isi_notif->Exportable) $Doc->ExportField($this->isi_notif);
						if ($this->action->Exportable) $Doc->ExportField($this->action);
						if ($this->tgl_cr->Exportable) $Doc->ExportField($this->tgl_cr);
						if ($this->cr_by->Exportable) $Doc->ExportField($this->cr_by);
						if ($this->filter_penerima->Exportable) $Doc->ExportField($this->filter_penerima);
						if ($this->tgl_upd->Exportable) $Doc->ExportField($this->tgl_upd);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->topic->Exportable) $Doc->ExportField($this->topic);
						if ($this->priority->Exportable) $Doc->ExportField($this->priority);
						if ($this->isi_notif->Exportable) $Doc->ExportField($this->isi_notif);
						if ($this->action->Exportable) $Doc->ExportField($this->action);
						if ($this->tgl_cr->Exportable) $Doc->ExportField($this->tgl_cr);
						if ($this->cr_by->Exportable) $Doc->ExportField($this->cr_by);
						if ($this->tgl_upd->Exportable) $Doc->ExportField($this->tgl_upd);
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
		ew_AddFilter($filter, "`tb_notifikasi`.`cr_by` IN ('" . $_SESSION['u_id'] . "')");
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

		$rsnew['tgl_cr']=date('Y/m/d');

	//	$rsnew['notif_active']='Y';
		$rsnew['cr_by'] = $_SESSION['u_id'];
		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
		$query="insert into tb_notifikasi_d(id,employee_id,bagian,lokasi_kerja,notif_active)
				 select  ".$rsnew['id'].",a.employee_id,b.ket ket_gas,c.ket ket_pat,'Y' from personal a
				 left join tb_gas b on b.kd_gas=a.kd_gas
				 left join tb_pat c on c.kd_pat=a.kd_pat
				 where a.kd_pat='".$rsnew['filter_penerima']."'";
		$GLOBALS["conn"]->Execute($query);     
		$GLOBALS["conn"]->Execute("COMMIT");

		//$send_notif_url = "http://hcis.wika-beton.net/wbs/firebase/send_notif.php?reg_Id=dKEjpampEJ8:APA91bFaWr5mD2I6TXsTH4j_MBNVeKe47-zVdGb_ugcWSXFhkt0Y5qQOhSi4tUmR49a0uyJLY9eezgO-saOyRgGQmBzYW7DFXSR2fNQpkN4Muinbf7VYyUxfZR9l84gAOIdJIrTk0zUb&title=TES&message=isi%20tes&idNotif=15";
		$_SESSION["redirect"] = "tb_notifikasilist.php";
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		$rsnew['tgl_upd']=date('Y/m/d');

		//$rsnew['notif_active']='Y';
		$query="update tb_notifikasi_d set notif_active='Y'
			where id=".$rsold['id'];
		$GLOBALS["conn"]->Execute($query);     
		$GLOBALS["conn"]->Execute("COMMIT");	
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
