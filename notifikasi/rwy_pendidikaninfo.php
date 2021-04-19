<?php

// Global variable for table object
$rwy_pendidikan = NULL;

//
// Table class for rwy_pendidikan
//
class crwy_pendidikan extends cTable {
	var $id;
	var $nip;
	var $pendidikan_terakhir;
	var $jurusan;
	var $nama_lembaga;
	var $no_ijazah;
	var $tanggal_ijazah;
	var $lokasi_pendidikan;
	var $stat_validasi;
	var $change_date;
	var $change_by;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'rwy_pendidikan';
		$this->TableName = 'rwy_pendidikan';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`rwy_pendidikan`";
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
		$this->id = new cField('rwy_pendidikan', 'rwy_pendidikan', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// nip
		$this->nip = new cField('rwy_pendidikan', 'rwy_pendidikan', 'x_nip', 'nip', '`nip`', '`nip`', 200, -1, FALSE, '`nip`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip->Sortable = TRUE; // Allow sort
		$this->fields['nip'] = &$this->nip;

		// pendidikan_terakhir
		$this->pendidikan_terakhir = new cField('rwy_pendidikan', 'rwy_pendidikan', 'x_pendidikan_terakhir', 'pendidikan_terakhir', '`pendidikan_terakhir`', '`pendidikan_terakhir`', 200, -1, FALSE, '`pendidikan_terakhir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pendidikan_terakhir->Sortable = TRUE; // Allow sort
		$this->fields['pendidikan_terakhir'] = &$this->pendidikan_terakhir;

		// jurusan
		$this->jurusan = new cField('rwy_pendidikan', 'rwy_pendidikan', 'x_jurusan', 'jurusan', '`jurusan`', '`jurusan`', 200, -1, FALSE, '`jurusan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jurusan->Sortable = TRUE; // Allow sort
		$this->fields['jurusan'] = &$this->jurusan;

		// nama_lembaga
		$this->nama_lembaga = new cField('rwy_pendidikan', 'rwy_pendidikan', 'x_nama_lembaga', 'nama_lembaga', '`nama_lembaga`', '`nama_lembaga`', 200, -1, FALSE, '`nama_lembaga`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_lembaga->Sortable = TRUE; // Allow sort
		$this->fields['nama_lembaga'] = &$this->nama_lembaga;

		// no_ijazah
		$this->no_ijazah = new cField('rwy_pendidikan', 'rwy_pendidikan', 'x_no_ijazah', 'no_ijazah', '`no_ijazah`', '`no_ijazah`', 200, -1, FALSE, '`no_ijazah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_ijazah->Sortable = TRUE; // Allow sort
		$this->fields['no_ijazah'] = &$this->no_ijazah;

		// tanggal_ijazah
		$this->tanggal_ijazah = new cField('rwy_pendidikan', 'rwy_pendidikan', 'x_tanggal_ijazah', 'tanggal_ijazah', '`tanggal_ijazah`', ew_CastDateFieldForLike('`tanggal_ijazah`', 0, "DB"), 133, 0, FALSE, '`tanggal_ijazah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tanggal_ijazah->Sortable = TRUE; // Allow sort
		$this->tanggal_ijazah->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tanggal_ijazah'] = &$this->tanggal_ijazah;

		// lokasi_pendidikan
		$this->lokasi_pendidikan = new cField('rwy_pendidikan', 'rwy_pendidikan', 'x_lokasi_pendidikan', 'lokasi_pendidikan', '`lokasi_pendidikan`', '`lokasi_pendidikan`', 200, -1, FALSE, '`lokasi_pendidikan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->lokasi_pendidikan->Sortable = TRUE; // Allow sort
		$this->fields['lokasi_pendidikan'] = &$this->lokasi_pendidikan;

		// stat_validasi
		$this->stat_validasi = new cField('rwy_pendidikan', 'rwy_pendidikan', 'x_stat_validasi', 'stat_validasi', '`stat_validasi`', '`stat_validasi`', 3, -1, FALSE, '`stat_validasi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->stat_validasi->Sortable = TRUE; // Allow sort
		$this->stat_validasi->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['stat_validasi'] = &$this->stat_validasi;

		// change_date
		$this->change_date = new cField('rwy_pendidikan', 'rwy_pendidikan', 'x_change_date', 'change_date', '`change_date`', ew_CastDateFieldForLike('`change_date`', 0, "DB"), 135, 0, FALSE, '`change_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->change_date->Sortable = TRUE; // Allow sort
		$this->change_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['change_date'] = &$this->change_date;

		// change_by
		$this->change_by = new cField('rwy_pendidikan', 'rwy_pendidikan', 'x_change_by', 'change_by', '`change_by`', '`change_by`', 200, -1, FALSE, '`change_by`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->change_by->Sortable = TRUE; // Allow sort
		$this->fields['change_by'] = &$this->change_by;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`rwy_pendidikan`";
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
			return "rwy_pendidikanlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "rwy_pendidikanview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "rwy_pendidikanedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "rwy_pendidikanadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "rwy_pendidikanlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("rwy_pendidikanview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("rwy_pendidikanview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "rwy_pendidikanadd.php?" . $this->UrlParm($parm);
		else
			$url = "rwy_pendidikanadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("rwy_pendidikanedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("rwy_pendidikanadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("rwy_pendidikandelete.php", $this->UrlParm());
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
		$this->nip->setDbValue($rs->fields('nip'));
		$this->pendidikan_terakhir->setDbValue($rs->fields('pendidikan_terakhir'));
		$this->jurusan->setDbValue($rs->fields('jurusan'));
		$this->nama_lembaga->setDbValue($rs->fields('nama_lembaga'));
		$this->no_ijazah->setDbValue($rs->fields('no_ijazah'));
		$this->tanggal_ijazah->setDbValue($rs->fields('tanggal_ijazah'));
		$this->lokasi_pendidikan->setDbValue($rs->fields('lokasi_pendidikan'));
		$this->stat_validasi->setDbValue($rs->fields('stat_validasi'));
		$this->change_date->setDbValue($rs->fields('change_date'));
		$this->change_by->setDbValue($rs->fields('change_by'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// nip
		// pendidikan_terakhir
		// jurusan
		// nama_lembaga
		// no_ijazah
		// tanggal_ijazah
		// lokasi_pendidikan
		// stat_validasi
		// change_date
		// change_by
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nip
		$this->nip->ViewValue = $this->nip->CurrentValue;
		$this->nip->ViewCustomAttributes = "";

		// pendidikan_terakhir
		$this->pendidikan_terakhir->ViewValue = $this->pendidikan_terakhir->CurrentValue;
		$this->pendidikan_terakhir->ViewCustomAttributes = "";

		// jurusan
		$this->jurusan->ViewValue = $this->jurusan->CurrentValue;
		$this->jurusan->ViewCustomAttributes = "";

		// nama_lembaga
		$this->nama_lembaga->ViewValue = $this->nama_lembaga->CurrentValue;
		$this->nama_lembaga->ViewCustomAttributes = "";

		// no_ijazah
		$this->no_ijazah->ViewValue = $this->no_ijazah->CurrentValue;
		$this->no_ijazah->ViewCustomAttributes = "";

		// tanggal_ijazah
		$this->tanggal_ijazah->ViewValue = $this->tanggal_ijazah->CurrentValue;
		$this->tanggal_ijazah->ViewValue = ew_FormatDateTime($this->tanggal_ijazah->ViewValue, 0);
		$this->tanggal_ijazah->ViewCustomAttributes = "";

		// lokasi_pendidikan
		$this->lokasi_pendidikan->ViewValue = $this->lokasi_pendidikan->CurrentValue;
		$this->lokasi_pendidikan->ViewCustomAttributes = "";

		// stat_validasi
		$this->stat_validasi->ViewValue = $this->stat_validasi->CurrentValue;
		$this->stat_validasi->ViewCustomAttributes = "";

		// change_date
		$this->change_date->ViewValue = $this->change_date->CurrentValue;
		$this->change_date->ViewValue = ew_FormatDateTime($this->change_date->ViewValue, 0);
		$this->change_date->ViewCustomAttributes = "";

		// change_by
		$this->change_by->ViewValue = $this->change_by->CurrentValue;
		$this->change_by->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// nip
		$this->nip->LinkCustomAttributes = "";
		$this->nip->HrefValue = "";
		$this->nip->TooltipValue = "";

		// pendidikan_terakhir
		$this->pendidikan_terakhir->LinkCustomAttributes = "";
		$this->pendidikan_terakhir->HrefValue = "";
		$this->pendidikan_terakhir->TooltipValue = "";

		// jurusan
		$this->jurusan->LinkCustomAttributes = "";
		$this->jurusan->HrefValue = "";
		$this->jurusan->TooltipValue = "";

		// nama_lembaga
		$this->nama_lembaga->LinkCustomAttributes = "";
		$this->nama_lembaga->HrefValue = "";
		$this->nama_lembaga->TooltipValue = "";

		// no_ijazah
		$this->no_ijazah->LinkCustomAttributes = "";
		$this->no_ijazah->HrefValue = "";
		$this->no_ijazah->TooltipValue = "";

		// tanggal_ijazah
		$this->tanggal_ijazah->LinkCustomAttributes = "";
		$this->tanggal_ijazah->HrefValue = "";
		$this->tanggal_ijazah->TooltipValue = "";

		// lokasi_pendidikan
		$this->lokasi_pendidikan->LinkCustomAttributes = "";
		$this->lokasi_pendidikan->HrefValue = "";
		$this->lokasi_pendidikan->TooltipValue = "";

		// stat_validasi
		$this->stat_validasi->LinkCustomAttributes = "";
		$this->stat_validasi->HrefValue = "";
		$this->stat_validasi->TooltipValue = "";

		// change_date
		$this->change_date->LinkCustomAttributes = "";
		$this->change_date->HrefValue = "";
		$this->change_date->TooltipValue = "";

		// change_by
		$this->change_by->LinkCustomAttributes = "";
		$this->change_by->HrefValue = "";
		$this->change_by->TooltipValue = "";

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

		// nip
		$this->nip->EditAttrs["class"] = "form-control";
		$this->nip->EditCustomAttributes = "";
		$this->nip->EditValue = $this->nip->CurrentValue;
		$this->nip->PlaceHolder = ew_RemoveHtml($this->nip->FldCaption());

		// pendidikan_terakhir
		$this->pendidikan_terakhir->EditAttrs["class"] = "form-control";
		$this->pendidikan_terakhir->EditCustomAttributes = "";
		$this->pendidikan_terakhir->EditValue = $this->pendidikan_terakhir->CurrentValue;
		$this->pendidikan_terakhir->PlaceHolder = ew_RemoveHtml($this->pendidikan_terakhir->FldCaption());

		// jurusan
		$this->jurusan->EditAttrs["class"] = "form-control";
		$this->jurusan->EditCustomAttributes = "";
		$this->jurusan->EditValue = $this->jurusan->CurrentValue;
		$this->jurusan->PlaceHolder = ew_RemoveHtml($this->jurusan->FldCaption());

		// nama_lembaga
		$this->nama_lembaga->EditAttrs["class"] = "form-control";
		$this->nama_lembaga->EditCustomAttributes = "";
		$this->nama_lembaga->EditValue = $this->nama_lembaga->CurrentValue;
		$this->nama_lembaga->PlaceHolder = ew_RemoveHtml($this->nama_lembaga->FldCaption());

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

		// lokasi_pendidikan
		$this->lokasi_pendidikan->EditAttrs["class"] = "form-control";
		$this->lokasi_pendidikan->EditCustomAttributes = "";
		$this->lokasi_pendidikan->EditValue = $this->lokasi_pendidikan->CurrentValue;
		$this->lokasi_pendidikan->PlaceHolder = ew_RemoveHtml($this->lokasi_pendidikan->FldCaption());

		// stat_validasi
		$this->stat_validasi->EditAttrs["class"] = "form-control";
		$this->stat_validasi->EditCustomAttributes = "";
		$this->stat_validasi->EditValue = $this->stat_validasi->CurrentValue;
		$this->stat_validasi->PlaceHolder = ew_RemoveHtml($this->stat_validasi->FldCaption());

		// change_date
		$this->change_date->EditAttrs["class"] = "form-control";
		$this->change_date->EditCustomAttributes = "";
		$this->change_date->EditValue = ew_FormatDateTime($this->change_date->CurrentValue, 8);
		$this->change_date->PlaceHolder = ew_RemoveHtml($this->change_date->FldCaption());

		// change_by
		$this->change_by->EditAttrs["class"] = "form-control";
		$this->change_by->EditCustomAttributes = "";
		$this->change_by->EditValue = $this->change_by->CurrentValue;
		$this->change_by->PlaceHolder = ew_RemoveHtml($this->change_by->FldCaption());

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
					if ($this->nip->Exportable) $Doc->ExportCaption($this->nip);
					if ($this->pendidikan_terakhir->Exportable) $Doc->ExportCaption($this->pendidikan_terakhir);
					if ($this->jurusan->Exportable) $Doc->ExportCaption($this->jurusan);
					if ($this->nama_lembaga->Exportable) $Doc->ExportCaption($this->nama_lembaga);
					if ($this->no_ijazah->Exportable) $Doc->ExportCaption($this->no_ijazah);
					if ($this->tanggal_ijazah->Exportable) $Doc->ExportCaption($this->tanggal_ijazah);
					if ($this->lokasi_pendidikan->Exportable) $Doc->ExportCaption($this->lokasi_pendidikan);
					if ($this->stat_validasi->Exportable) $Doc->ExportCaption($this->stat_validasi);
					if ($this->change_date->Exportable) $Doc->ExportCaption($this->change_date);
					if ($this->change_by->Exportable) $Doc->ExportCaption($this->change_by);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->nip->Exportable) $Doc->ExportCaption($this->nip);
					if ($this->pendidikan_terakhir->Exportable) $Doc->ExportCaption($this->pendidikan_terakhir);
					if ($this->jurusan->Exportable) $Doc->ExportCaption($this->jurusan);
					if ($this->nama_lembaga->Exportable) $Doc->ExportCaption($this->nama_lembaga);
					if ($this->no_ijazah->Exportable) $Doc->ExportCaption($this->no_ijazah);
					if ($this->tanggal_ijazah->Exportable) $Doc->ExportCaption($this->tanggal_ijazah);
					if ($this->lokasi_pendidikan->Exportable) $Doc->ExportCaption($this->lokasi_pendidikan);
					if ($this->stat_validasi->Exportable) $Doc->ExportCaption($this->stat_validasi);
					if ($this->change_date->Exportable) $Doc->ExportCaption($this->change_date);
					if ($this->change_by->Exportable) $Doc->ExportCaption($this->change_by);
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
						if ($this->nip->Exportable) $Doc->ExportField($this->nip);
						if ($this->pendidikan_terakhir->Exportable) $Doc->ExportField($this->pendidikan_terakhir);
						if ($this->jurusan->Exportable) $Doc->ExportField($this->jurusan);
						if ($this->nama_lembaga->Exportable) $Doc->ExportField($this->nama_lembaga);
						if ($this->no_ijazah->Exportable) $Doc->ExportField($this->no_ijazah);
						if ($this->tanggal_ijazah->Exportable) $Doc->ExportField($this->tanggal_ijazah);
						if ($this->lokasi_pendidikan->Exportable) $Doc->ExportField($this->lokasi_pendidikan);
						if ($this->stat_validasi->Exportable) $Doc->ExportField($this->stat_validasi);
						if ($this->change_date->Exportable) $Doc->ExportField($this->change_date);
						if ($this->change_by->Exportable) $Doc->ExportField($this->change_by);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->nip->Exportable) $Doc->ExportField($this->nip);
						if ($this->pendidikan_terakhir->Exportable) $Doc->ExportField($this->pendidikan_terakhir);
						if ($this->jurusan->Exportable) $Doc->ExportField($this->jurusan);
						if ($this->nama_lembaga->Exportable) $Doc->ExportField($this->nama_lembaga);
						if ($this->no_ijazah->Exportable) $Doc->ExportField($this->no_ijazah);
						if ($this->tanggal_ijazah->Exportable) $Doc->ExportField($this->tanggal_ijazah);
						if ($this->lokasi_pendidikan->Exportable) $Doc->ExportField($this->lokasi_pendidikan);
						if ($this->stat_validasi->Exportable) $Doc->ExportField($this->stat_validasi);
						if ($this->change_date->Exportable) $Doc->ExportField($this->change_date);
						if ($this->change_by->Exportable) $Doc->ExportField($this->change_by);
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
