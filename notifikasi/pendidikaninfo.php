<?php

// Global variable for table object
$pendidikan = NULL;

//
// Table class for pendidikan
//
class cpendidikan extends cTable {
	var $id;
	var $employee_id;
	var $kd_jenjang;
	var $kd_jurusan;
	var $kd_lmbg;
	var $ipk;
	var $ket;
	var $th_mulai;
	var $th_akhir;
	var $no_ijazah;
	var $tanggal_ijazah;
	var $upload_ijazah;
	var $lokasi_pendidikan;
	var $app;
	var $app_empid;
	var $app_jbt;
	var $app_date;
	var $created_by;
	var $created_date;
	var $last_update_by;
	var $last_update_date;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'pendidikan';
		$this->TableName = 'pendidikan';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`pendidikan`";
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
		$this->id = new cField('pendidikan', 'pendidikan', 'x_id', 'id', '`id`', '`id`', 20, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// employee_id
		$this->employee_id = new cField('pendidikan', 'pendidikan', 'x_employee_id', 'employee_id', '`employee_id`', '`employee_id`', 200, -1, FALSE, '`employee_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->employee_id->Sortable = TRUE; // Allow sort
		$this->fields['employee_id'] = &$this->employee_id;

		// kd_jenjang
		$this->kd_jenjang = new cField('pendidikan', 'pendidikan', 'x_kd_jenjang', 'kd_jenjang', '`kd_jenjang`', '`kd_jenjang`', 200, -1, FALSE, '`kd_jenjang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jenjang->Sortable = TRUE; // Allow sort
		$this->fields['kd_jenjang'] = &$this->kd_jenjang;

		// kd_jurusan
		$this->kd_jurusan = new cField('pendidikan', 'pendidikan', 'x_kd_jurusan', 'kd_jurusan', '`kd_jurusan`', '`kd_jurusan`', 200, -1, FALSE, '`kd_jurusan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jurusan->Sortable = TRUE; // Allow sort
		$this->fields['kd_jurusan'] = &$this->kd_jurusan;

		// kd_lmbg
		$this->kd_lmbg = new cField('pendidikan', 'pendidikan', 'x_kd_lmbg', 'kd_lmbg', '`kd_lmbg`', '`kd_lmbg`', 200, -1, FALSE, '`kd_lmbg`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_lmbg->Sortable = TRUE; // Allow sort
		$this->fields['kd_lmbg'] = &$this->kd_lmbg;

		// ipk
		$this->ipk = new cField('pendidikan', 'pendidikan', 'x_ipk', 'ipk', '`ipk`', '`ipk`', 5, -1, FALSE, '`ipk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ipk->Sortable = TRUE; // Allow sort
		$this->ipk->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['ipk'] = &$this->ipk;

		// ket
		$this->ket = new cField('pendidikan', 'pendidikan', 'x_ket', 'ket', '`ket`', '`ket`', 200, -1, FALSE, '`ket`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket->Sortable = TRUE; // Allow sort
		$this->fields['ket'] = &$this->ket;

		// th_mulai
		$this->th_mulai = new cField('pendidikan', 'pendidikan', 'x_th_mulai', 'th_mulai', '`th_mulai`', '`th_mulai`', 200, -1, FALSE, '`th_mulai`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->th_mulai->Sortable = TRUE; // Allow sort
		$this->fields['th_mulai'] = &$this->th_mulai;

		// th_akhir
		$this->th_akhir = new cField('pendidikan', 'pendidikan', 'x_th_akhir', 'th_akhir', '`th_akhir`', '`th_akhir`', 200, -1, FALSE, '`th_akhir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->th_akhir->Sortable = TRUE; // Allow sort
		$this->fields['th_akhir'] = &$this->th_akhir;

		// no_ijazah
		$this->no_ijazah = new cField('pendidikan', 'pendidikan', 'x_no_ijazah', 'no_ijazah', '`no_ijazah`', '`no_ijazah`', 200, -1, FALSE, '`no_ijazah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_ijazah->Sortable = TRUE; // Allow sort
		$this->fields['no_ijazah'] = &$this->no_ijazah;

		// tanggal_ijazah
		$this->tanggal_ijazah = new cField('pendidikan', 'pendidikan', 'x_tanggal_ijazah', 'tanggal_ijazah', '`tanggal_ijazah`', ew_CastDateFieldForLike('`tanggal_ijazah`', 0, "DB"), 133, 0, FALSE, '`tanggal_ijazah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tanggal_ijazah->Sortable = TRUE; // Allow sort
		$this->tanggal_ijazah->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tanggal_ijazah'] = &$this->tanggal_ijazah;

		// upload_ijazah
		$this->upload_ijazah = new cField('pendidikan', 'pendidikan', 'x_upload_ijazah', 'upload_ijazah', '`upload_ijazah`', '`upload_ijazah`', 200, -1, FALSE, '`upload_ijazah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->upload_ijazah->Sortable = TRUE; // Allow sort
		$this->fields['upload_ijazah'] = &$this->upload_ijazah;

		// lokasi_pendidikan
		$this->lokasi_pendidikan = new cField('pendidikan', 'pendidikan', 'x_lokasi_pendidikan', 'lokasi_pendidikan', '`lokasi_pendidikan`', '`lokasi_pendidikan`', 200, -1, FALSE, '`lokasi_pendidikan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->lokasi_pendidikan->Sortable = TRUE; // Allow sort
		$this->fields['lokasi_pendidikan'] = &$this->lokasi_pendidikan;

		// app
		$this->app = new cField('pendidikan', 'pendidikan', 'x_app', 'app', '`app`', '`app`', 200, -1, FALSE, '`app`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->app->Sortable = TRUE; // Allow sort
		$this->fields['app'] = &$this->app;

		// app_empid
		$this->app_empid = new cField('pendidikan', 'pendidikan', 'x_app_empid', 'app_empid', '`app_empid`', '`app_empid`', 200, -1, FALSE, '`app_empid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->app_empid->Sortable = TRUE; // Allow sort
		$this->fields['app_empid'] = &$this->app_empid;

		// app_jbt
		$this->app_jbt = new cField('pendidikan', 'pendidikan', 'x_app_jbt', 'app_jbt', '`app_jbt`', '`app_jbt`', 200, -1, FALSE, '`app_jbt`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->app_jbt->Sortable = TRUE; // Allow sort
		$this->fields['app_jbt'] = &$this->app_jbt;

		// app_date
		$this->app_date = new cField('pendidikan', 'pendidikan', 'x_app_date', 'app_date', '`app_date`', ew_CastDateFieldForLike('`app_date`', 0, "DB"), 135, 0, FALSE, '`app_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->app_date->Sortable = TRUE; // Allow sort
		$this->app_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['app_date'] = &$this->app_date;

		// created_by
		$this->created_by = new cField('pendidikan', 'pendidikan', 'x_created_by', 'created_by', '`created_by`', '`created_by`', 200, -1, FALSE, '`created_by`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->created_by->Sortable = TRUE; // Allow sort
		$this->fields['created_by'] = &$this->created_by;

		// created_date
		$this->created_date = new cField('pendidikan', 'pendidikan', 'x_created_date', 'created_date', '`created_date`', ew_CastDateFieldForLike('`created_date`', 0, "DB"), 135, 0, FALSE, '`created_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->created_date->Sortable = TRUE; // Allow sort
		$this->created_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['created_date'] = &$this->created_date;

		// last_update_by
		$this->last_update_by = new cField('pendidikan', 'pendidikan', 'x_last_update_by', 'last_update_by', '`last_update_by`', '`last_update_by`', 200, -1, FALSE, '`last_update_by`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_update_by->Sortable = TRUE; // Allow sort
		$this->fields['last_update_by'] = &$this->last_update_by;

		// last_update_date
		$this->last_update_date = new cField('pendidikan', 'pendidikan', 'x_last_update_date', 'last_update_date', '`last_update_date`', ew_CastDateFieldForLike('`last_update_date`', 0, "DB"), 135, 0, FALSE, '`last_update_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_update_date->Sortable = TRUE; // Allow sort
		$this->last_update_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['last_update_date'] = &$this->last_update_date;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`pendidikan`";
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
		return "`id` = @id@ AND `employee_id` = '@employee_id@' AND `kd_jenjang` = '@kd_jenjang@'";
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
			return "pendidikanlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "pendidikanview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "pendidikanedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "pendidikanadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "pendidikanlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("pendidikanview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("pendidikanview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "pendidikanadd.php?" . $this->UrlParm($parm);
		else
			$url = "pendidikanadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("pendidikanedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("pendidikanadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("pendidikandelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		$json .= ",employee_id:" . ew_VarToJson($this->employee_id->CurrentValue, "string", "'");
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
				if (!is_array($key) || count($key) <> 3)
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
			$this->kd_jenjang->CurrentValue = $key[2];
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
		$this->kd_jenjang->setDbValue($rs->fields('kd_jenjang'));
		$this->kd_jurusan->setDbValue($rs->fields('kd_jurusan'));
		$this->kd_lmbg->setDbValue($rs->fields('kd_lmbg'));
		$this->ipk->setDbValue($rs->fields('ipk'));
		$this->ket->setDbValue($rs->fields('ket'));
		$this->th_mulai->setDbValue($rs->fields('th_mulai'));
		$this->th_akhir->setDbValue($rs->fields('th_akhir'));
		$this->no_ijazah->setDbValue($rs->fields('no_ijazah'));
		$this->tanggal_ijazah->setDbValue($rs->fields('tanggal_ijazah'));
		$this->upload_ijazah->setDbValue($rs->fields('upload_ijazah'));
		$this->lokasi_pendidikan->setDbValue($rs->fields('lokasi_pendidikan'));
		$this->app->setDbValue($rs->fields('app'));
		$this->app_empid->setDbValue($rs->fields('app_empid'));
		$this->app_jbt->setDbValue($rs->fields('app_jbt'));
		$this->app_date->setDbValue($rs->fields('app_date'));
		$this->created_by->setDbValue($rs->fields('created_by'));
		$this->created_date->setDbValue($rs->fields('created_date'));
		$this->last_update_by->setDbValue($rs->fields('last_update_by'));
		$this->last_update_date->setDbValue($rs->fields('last_update_date'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// employee_id
		// kd_jenjang
		// kd_jurusan
		// kd_lmbg
		// ipk
		// ket
		// th_mulai
		// th_akhir
		// no_ijazah
		// tanggal_ijazah
		// upload_ijazah
		// lokasi_pendidikan
		// app
		// app_empid
		// app_jbt
		// app_date
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// employee_id
		$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
		$this->employee_id->ViewCustomAttributes = "";

		// kd_jenjang
		$this->kd_jenjang->ViewValue = $this->kd_jenjang->CurrentValue;
		$this->kd_jenjang->ViewCustomAttributes = "";

		// kd_jurusan
		$this->kd_jurusan->ViewValue = $this->kd_jurusan->CurrentValue;
		$this->kd_jurusan->ViewCustomAttributes = "";

		// kd_lmbg
		$this->kd_lmbg->ViewValue = $this->kd_lmbg->CurrentValue;
		$this->kd_lmbg->ViewCustomAttributes = "";

		// ipk
		$this->ipk->ViewValue = $this->ipk->CurrentValue;
		$this->ipk->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

		// th_mulai
		$this->th_mulai->ViewValue = $this->th_mulai->CurrentValue;
		$this->th_mulai->ViewCustomAttributes = "";

		// th_akhir
		$this->th_akhir->ViewValue = $this->th_akhir->CurrentValue;
		$this->th_akhir->ViewCustomAttributes = "";

		// no_ijazah
		$this->no_ijazah->ViewValue = $this->no_ijazah->CurrentValue;
		$this->no_ijazah->ViewCustomAttributes = "";

		// tanggal_ijazah
		$this->tanggal_ijazah->ViewValue = $this->tanggal_ijazah->CurrentValue;
		$this->tanggal_ijazah->ViewValue = ew_FormatDateTime($this->tanggal_ijazah->ViewValue, 0);
		$this->tanggal_ijazah->ViewCustomAttributes = "";

		// upload_ijazah
		$this->upload_ijazah->ViewValue = $this->upload_ijazah->CurrentValue;
		$this->upload_ijazah->ViewCustomAttributes = "";

		// lokasi_pendidikan
		$this->lokasi_pendidikan->ViewValue = $this->lokasi_pendidikan->CurrentValue;
		$this->lokasi_pendidikan->ViewCustomAttributes = "";

		// app
		$this->app->ViewValue = $this->app->CurrentValue;
		$this->app->ViewCustomAttributes = "";

		// app_empid
		$this->app_empid->ViewValue = $this->app_empid->CurrentValue;
		$this->app_empid->ViewCustomAttributes = "";

		// app_jbt
		$this->app_jbt->ViewValue = $this->app_jbt->CurrentValue;
		$this->app_jbt->ViewCustomAttributes = "";

		// app_date
		$this->app_date->ViewValue = $this->app_date->CurrentValue;
		$this->app_date->ViewValue = ew_FormatDateTime($this->app_date->ViewValue, 0);
		$this->app_date->ViewCustomAttributes = "";

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

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// employee_id
		$this->employee_id->LinkCustomAttributes = "";
		$this->employee_id->HrefValue = "";
		$this->employee_id->TooltipValue = "";

		// kd_jenjang
		$this->kd_jenjang->LinkCustomAttributes = "";
		$this->kd_jenjang->HrefValue = "";
		$this->kd_jenjang->TooltipValue = "";

		// kd_jurusan
		$this->kd_jurusan->LinkCustomAttributes = "";
		$this->kd_jurusan->HrefValue = "";
		$this->kd_jurusan->TooltipValue = "";

		// kd_lmbg
		$this->kd_lmbg->LinkCustomAttributes = "";
		$this->kd_lmbg->HrefValue = "";
		$this->kd_lmbg->TooltipValue = "";

		// ipk
		$this->ipk->LinkCustomAttributes = "";
		$this->ipk->HrefValue = "";
		$this->ipk->TooltipValue = "";

		// ket
		$this->ket->LinkCustomAttributes = "";
		$this->ket->HrefValue = "";
		$this->ket->TooltipValue = "";

		// th_mulai
		$this->th_mulai->LinkCustomAttributes = "";
		$this->th_mulai->HrefValue = "";
		$this->th_mulai->TooltipValue = "";

		// th_akhir
		$this->th_akhir->LinkCustomAttributes = "";
		$this->th_akhir->HrefValue = "";
		$this->th_akhir->TooltipValue = "";

		// no_ijazah
		$this->no_ijazah->LinkCustomAttributes = "";
		$this->no_ijazah->HrefValue = "";
		$this->no_ijazah->TooltipValue = "";

		// tanggal_ijazah
		$this->tanggal_ijazah->LinkCustomAttributes = "";
		$this->tanggal_ijazah->HrefValue = "";
		$this->tanggal_ijazah->TooltipValue = "";

		// upload_ijazah
		$this->upload_ijazah->LinkCustomAttributes = "";
		$this->upload_ijazah->HrefValue = "";
		$this->upload_ijazah->TooltipValue = "";

		// lokasi_pendidikan
		$this->lokasi_pendidikan->LinkCustomAttributes = "";
		$this->lokasi_pendidikan->HrefValue = "";
		$this->lokasi_pendidikan->TooltipValue = "";

		// app
		$this->app->LinkCustomAttributes = "";
		$this->app->HrefValue = "";
		$this->app->TooltipValue = "";

		// app_empid
		$this->app_empid->LinkCustomAttributes = "";
		$this->app_empid->HrefValue = "";
		$this->app_empid->TooltipValue = "";

		// app_jbt
		$this->app_jbt->LinkCustomAttributes = "";
		$this->app_jbt->HrefValue = "";
		$this->app_jbt->TooltipValue = "";

		// app_date
		$this->app_date->LinkCustomAttributes = "";
		$this->app_date->HrefValue = "";
		$this->app_date->TooltipValue = "";

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

		// kd_jenjang
		$this->kd_jenjang->EditAttrs["class"] = "form-control";
		$this->kd_jenjang->EditCustomAttributes = "";
		$this->kd_jenjang->EditValue = $this->kd_jenjang->CurrentValue;
		$this->kd_jenjang->ViewCustomAttributes = "";

		// kd_jurusan
		$this->kd_jurusan->EditAttrs["class"] = "form-control";
		$this->kd_jurusan->EditCustomAttributes = "";
		$this->kd_jurusan->EditValue = $this->kd_jurusan->CurrentValue;
		$this->kd_jurusan->PlaceHolder = ew_RemoveHtml($this->kd_jurusan->FldCaption());

		// kd_lmbg
		$this->kd_lmbg->EditAttrs["class"] = "form-control";
		$this->kd_lmbg->EditCustomAttributes = "";
		$this->kd_lmbg->EditValue = $this->kd_lmbg->CurrentValue;
		$this->kd_lmbg->PlaceHolder = ew_RemoveHtml($this->kd_lmbg->FldCaption());

		// ipk
		$this->ipk->EditAttrs["class"] = "form-control";
		$this->ipk->EditCustomAttributes = "";
		$this->ipk->EditValue = $this->ipk->CurrentValue;
		$this->ipk->PlaceHolder = ew_RemoveHtml($this->ipk->FldCaption());
		if (strval($this->ipk->EditValue) <> "" && is_numeric($this->ipk->EditValue)) $this->ipk->EditValue = ew_FormatNumber($this->ipk->EditValue, -2, -1, -2, 0);

		// ket
		$this->ket->EditAttrs["class"] = "form-control";
		$this->ket->EditCustomAttributes = "";
		$this->ket->EditValue = $this->ket->CurrentValue;
		$this->ket->PlaceHolder = ew_RemoveHtml($this->ket->FldCaption());

		// th_mulai
		$this->th_mulai->EditAttrs["class"] = "form-control";
		$this->th_mulai->EditCustomAttributes = "";
		$this->th_mulai->EditValue = $this->th_mulai->CurrentValue;
		$this->th_mulai->PlaceHolder = ew_RemoveHtml($this->th_mulai->FldCaption());

		// th_akhir
		$this->th_akhir->EditAttrs["class"] = "form-control";
		$this->th_akhir->EditCustomAttributes = "";
		$this->th_akhir->EditValue = $this->th_akhir->CurrentValue;
		$this->th_akhir->PlaceHolder = ew_RemoveHtml($this->th_akhir->FldCaption());

		// no_ijazah
		$this->no_ijazah->EditAttrs["class"] = "form-control";
		$this->no_ijazah->EditCustomAttributes = "";
		$this->no_ijazah->EditValue = $this->no_ijazah->CurrentValue;
		$this->no_ijazah->PlaceHolder = ew_RemoveHtml($this->no_ijazah->FldCaption());

		// tanggal_ijazah
		$this->tanggal_ijazah->EditAttrs["class"] = "form-control";
		$this->tanggal_ijazah->EditCustomAttributes = "";
		$this->tanggal_ijazah->EditValue = ew_FormatDateTime($this->tanggal_ijazah->CurrentValue, 8);
		$this->tanggal_ijazah->PlaceHolder = ew_RemoveHtml($this->tanggal_ijazah->FldCaption());

		// upload_ijazah
		$this->upload_ijazah->EditAttrs["class"] = "form-control";
		$this->upload_ijazah->EditCustomAttributes = "";
		$this->upload_ijazah->EditValue = $this->upload_ijazah->CurrentValue;
		$this->upload_ijazah->PlaceHolder = ew_RemoveHtml($this->upload_ijazah->FldCaption());

		// lokasi_pendidikan
		$this->lokasi_pendidikan->EditAttrs["class"] = "form-control";
		$this->lokasi_pendidikan->EditCustomAttributes = "";
		$this->lokasi_pendidikan->EditValue = $this->lokasi_pendidikan->CurrentValue;
		$this->lokasi_pendidikan->PlaceHolder = ew_RemoveHtml($this->lokasi_pendidikan->FldCaption());

		// app
		$this->app->EditAttrs["class"] = "form-control";
		$this->app->EditCustomAttributes = "";
		$this->app->EditValue = $this->app->CurrentValue;
		$this->app->PlaceHolder = ew_RemoveHtml($this->app->FldCaption());

		// app_empid
		$this->app_empid->EditAttrs["class"] = "form-control";
		$this->app_empid->EditCustomAttributes = "";
		$this->app_empid->EditValue = $this->app_empid->CurrentValue;
		$this->app_empid->PlaceHolder = ew_RemoveHtml($this->app_empid->FldCaption());

		// app_jbt
		$this->app_jbt->EditAttrs["class"] = "form-control";
		$this->app_jbt->EditCustomAttributes = "";
		$this->app_jbt->EditValue = $this->app_jbt->CurrentValue;
		$this->app_jbt->PlaceHolder = ew_RemoveHtml($this->app_jbt->FldCaption());

		// app_date
		$this->app_date->EditAttrs["class"] = "form-control";
		$this->app_date->EditCustomAttributes = "";
		$this->app_date->EditValue = ew_FormatDateTime($this->app_date->CurrentValue, 8);
		$this->app_date->PlaceHolder = ew_RemoveHtml($this->app_date->FldCaption());

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
					if ($this->kd_jenjang->Exportable) $Doc->ExportCaption($this->kd_jenjang);
					if ($this->kd_jurusan->Exportable) $Doc->ExportCaption($this->kd_jurusan);
					if ($this->kd_lmbg->Exportable) $Doc->ExportCaption($this->kd_lmbg);
					if ($this->ipk->Exportable) $Doc->ExportCaption($this->ipk);
					if ($this->ket->Exportable) $Doc->ExportCaption($this->ket);
					if ($this->th_mulai->Exportable) $Doc->ExportCaption($this->th_mulai);
					if ($this->th_akhir->Exportable) $Doc->ExportCaption($this->th_akhir);
					if ($this->no_ijazah->Exportable) $Doc->ExportCaption($this->no_ijazah);
					if ($this->tanggal_ijazah->Exportable) $Doc->ExportCaption($this->tanggal_ijazah);
					if ($this->upload_ijazah->Exportable) $Doc->ExportCaption($this->upload_ijazah);
					if ($this->lokasi_pendidikan->Exportable) $Doc->ExportCaption($this->lokasi_pendidikan);
					if ($this->app->Exportable) $Doc->ExportCaption($this->app);
					if ($this->app_empid->Exportable) $Doc->ExportCaption($this->app_empid);
					if ($this->app_jbt->Exportable) $Doc->ExportCaption($this->app_jbt);
					if ($this->app_date->Exportable) $Doc->ExportCaption($this->app_date);
					if ($this->created_by->Exportable) $Doc->ExportCaption($this->created_by);
					if ($this->created_date->Exportable) $Doc->ExportCaption($this->created_date);
					if ($this->last_update_by->Exportable) $Doc->ExportCaption($this->last_update_by);
					if ($this->last_update_date->Exportable) $Doc->ExportCaption($this->last_update_date);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->employee_id->Exportable) $Doc->ExportCaption($this->employee_id);
					if ($this->kd_jenjang->Exportable) $Doc->ExportCaption($this->kd_jenjang);
					if ($this->kd_jurusan->Exportable) $Doc->ExportCaption($this->kd_jurusan);
					if ($this->kd_lmbg->Exportable) $Doc->ExportCaption($this->kd_lmbg);
					if ($this->ipk->Exportable) $Doc->ExportCaption($this->ipk);
					if ($this->ket->Exportable) $Doc->ExportCaption($this->ket);
					if ($this->th_mulai->Exportable) $Doc->ExportCaption($this->th_mulai);
					if ($this->th_akhir->Exportable) $Doc->ExportCaption($this->th_akhir);
					if ($this->no_ijazah->Exportable) $Doc->ExportCaption($this->no_ijazah);
					if ($this->tanggal_ijazah->Exportable) $Doc->ExportCaption($this->tanggal_ijazah);
					if ($this->upload_ijazah->Exportable) $Doc->ExportCaption($this->upload_ijazah);
					if ($this->lokasi_pendidikan->Exportable) $Doc->ExportCaption($this->lokasi_pendidikan);
					if ($this->app->Exportable) $Doc->ExportCaption($this->app);
					if ($this->app_empid->Exportable) $Doc->ExportCaption($this->app_empid);
					if ($this->app_jbt->Exportable) $Doc->ExportCaption($this->app_jbt);
					if ($this->app_date->Exportable) $Doc->ExportCaption($this->app_date);
					if ($this->created_by->Exportable) $Doc->ExportCaption($this->created_by);
					if ($this->created_date->Exportable) $Doc->ExportCaption($this->created_date);
					if ($this->last_update_by->Exportable) $Doc->ExportCaption($this->last_update_by);
					if ($this->last_update_date->Exportable) $Doc->ExportCaption($this->last_update_date);
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
						if ($this->kd_jenjang->Exportable) $Doc->ExportField($this->kd_jenjang);
						if ($this->kd_jurusan->Exportable) $Doc->ExportField($this->kd_jurusan);
						if ($this->kd_lmbg->Exportable) $Doc->ExportField($this->kd_lmbg);
						if ($this->ipk->Exportable) $Doc->ExportField($this->ipk);
						if ($this->ket->Exportable) $Doc->ExportField($this->ket);
						if ($this->th_mulai->Exportable) $Doc->ExportField($this->th_mulai);
						if ($this->th_akhir->Exportable) $Doc->ExportField($this->th_akhir);
						if ($this->no_ijazah->Exportable) $Doc->ExportField($this->no_ijazah);
						if ($this->tanggal_ijazah->Exportable) $Doc->ExportField($this->tanggal_ijazah);
						if ($this->upload_ijazah->Exportable) $Doc->ExportField($this->upload_ijazah);
						if ($this->lokasi_pendidikan->Exportable) $Doc->ExportField($this->lokasi_pendidikan);
						if ($this->app->Exportable) $Doc->ExportField($this->app);
						if ($this->app_empid->Exportable) $Doc->ExportField($this->app_empid);
						if ($this->app_jbt->Exportable) $Doc->ExportField($this->app_jbt);
						if ($this->app_date->Exportable) $Doc->ExportField($this->app_date);
						if ($this->created_by->Exportable) $Doc->ExportField($this->created_by);
						if ($this->created_date->Exportable) $Doc->ExportField($this->created_date);
						if ($this->last_update_by->Exportable) $Doc->ExportField($this->last_update_by);
						if ($this->last_update_date->Exportable) $Doc->ExportField($this->last_update_date);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->employee_id->Exportable) $Doc->ExportField($this->employee_id);
						if ($this->kd_jenjang->Exportable) $Doc->ExportField($this->kd_jenjang);
						if ($this->kd_jurusan->Exportable) $Doc->ExportField($this->kd_jurusan);
						if ($this->kd_lmbg->Exportable) $Doc->ExportField($this->kd_lmbg);
						if ($this->ipk->Exportable) $Doc->ExportField($this->ipk);
						if ($this->ket->Exportable) $Doc->ExportField($this->ket);
						if ($this->th_mulai->Exportable) $Doc->ExportField($this->th_mulai);
						if ($this->th_akhir->Exportable) $Doc->ExportField($this->th_akhir);
						if ($this->no_ijazah->Exportable) $Doc->ExportField($this->no_ijazah);
						if ($this->tanggal_ijazah->Exportable) $Doc->ExportField($this->tanggal_ijazah);
						if ($this->upload_ijazah->Exportable) $Doc->ExportField($this->upload_ijazah);
						if ($this->lokasi_pendidikan->Exportable) $Doc->ExportField($this->lokasi_pendidikan);
						if ($this->app->Exportable) $Doc->ExportField($this->app);
						if ($this->app_empid->Exportable) $Doc->ExportField($this->app_empid);
						if ($this->app_jbt->Exportable) $Doc->ExportField($this->app_jbt);
						if ($this->app_date->Exportable) $Doc->ExportField($this->app_date);
						if ($this->created_by->Exportable) $Doc->ExportField($this->created_by);
						if ($this->created_date->Exportable) $Doc->ExportField($this->created_date);
						if ($this->last_update_by->Exportable) $Doc->ExportField($this->last_update_by);
						if ($this->last_update_date->Exportable) $Doc->ExportField($this->last_update_date);
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
