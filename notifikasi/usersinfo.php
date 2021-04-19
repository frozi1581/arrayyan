<?php

// Global variable for table object
$users = NULL;

//
// Table class for users
//
class cusers extends cTable {
	var $id;
	var $nama_pegawai;
	var $username;
	var $kode_unit_organisasi;
	var $kode_unit_kerja;
	var $jabatan;
	var $password;
	var $user_group;
	var $status;
	var $photo;
	var $nomor_anggota;
	var $nip;
	var $nip_lama;
	var $gelar_depan;
	var $gelar_belakang;
	var $pendidikan_terakhir;
	var $nama_lembaga;
	var $warga_negara;
	var $tempat_lahir;
	var $tanggal_lahir;
	var $jenis_kelamin;
	var $status_perkawinan;
	var $agama;
	var $nama_bank;
	var $no_rekening;
	var $change_date;
	var $change_by;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'users';
		$this->TableName = 'users';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`users`";
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
		$this->id = new cField('users', 'users', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// nama_pegawai
		$this->nama_pegawai = new cField('users', 'users', 'x_nama_pegawai', 'nama_pegawai', '`nama_pegawai`', '`nama_pegawai`', 200, -1, FALSE, '`nama_pegawai`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_pegawai->Sortable = TRUE; // Allow sort
		$this->fields['nama_pegawai'] = &$this->nama_pegawai;

		// username
		$this->username = new cField('users', 'users', 'x_username', 'username', '`username`', '`username`', 200, -1, FALSE, '`username`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->username->Sortable = TRUE; // Allow sort
		$this->fields['username'] = &$this->username;

		// kode_unit_organisasi
		$this->kode_unit_organisasi = new cField('users', 'users', 'x_kode_unit_organisasi', 'kode_unit_organisasi', '`kode_unit_organisasi`', '`kode_unit_organisasi`', 200, -1, FALSE, '`kode_unit_organisasi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kode_unit_organisasi->Sortable = TRUE; // Allow sort
		$this->fields['kode_unit_organisasi'] = &$this->kode_unit_organisasi;

		// kode_unit_kerja
		$this->kode_unit_kerja = new cField('users', 'users', 'x_kode_unit_kerja', 'kode_unit_kerja', '`kode_unit_kerja`', '`kode_unit_kerja`', 200, -1, FALSE, '`kode_unit_kerja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kode_unit_kerja->Sortable = TRUE; // Allow sort
		$this->fields['kode_unit_kerja'] = &$this->kode_unit_kerja;

		// jabatan
		$this->jabatan = new cField('users', 'users', 'x_jabatan', 'jabatan', '`jabatan`', '`jabatan`', 200, -1, FALSE, '`jabatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jabatan->Sortable = TRUE; // Allow sort
		$this->fields['jabatan'] = &$this->jabatan;

		// password
		$this->password = new cField('users', 'users', 'x_password', 'password', '`password`', '`password`', 201, -1, FALSE, '`password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->password->Sortable = TRUE; // Allow sort
		$this->fields['password'] = &$this->password;

		// user_group
		$this->user_group = new cField('users', 'users', 'x_user_group', 'user_group', '`user_group`', '`user_group`', 3, -1, FALSE, '`user_group`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_group->Sortable = TRUE; // Allow sort
		$this->user_group->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['user_group'] = &$this->user_group;

		// status
		$this->status = new cField('users', 'users', 'x_status', 'status', '`status`', '`status`', 3, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status->Sortable = TRUE; // Allow sort
		$this->status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status'] = &$this->status;

		// photo
		$this->photo = new cField('users', 'users', 'x_photo', 'photo', '`photo`', '`photo`', 201, -1, FALSE, '`photo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->photo->Sortable = TRUE; // Allow sort
		$this->fields['photo'] = &$this->photo;

		// nomor_anggota
		$this->nomor_anggota = new cField('users', 'users', 'x_nomor_anggota', 'nomor_anggota', '`nomor_anggota`', '`nomor_anggota`', 200, -1, FALSE, '`nomor_anggota`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomor_anggota->Sortable = TRUE; // Allow sort
		$this->fields['nomor_anggota'] = &$this->nomor_anggota;

		// nip
		$this->nip = new cField('users', 'users', 'x_nip', 'nip', '`nip`', '`nip`', 200, -1, FALSE, '`nip`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip->Sortable = TRUE; // Allow sort
		$this->fields['nip'] = &$this->nip;

		// nip_lama
		$this->nip_lama = new cField('users', 'users', 'x_nip_lama', 'nip_lama', '`nip_lama`', '`nip_lama`', 200, -1, FALSE, '`nip_lama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip_lama->Sortable = TRUE; // Allow sort
		$this->fields['nip_lama'] = &$this->nip_lama;

		// gelar_depan
		$this->gelar_depan = new cField('users', 'users', 'x_gelar_depan', 'gelar_depan', '`gelar_depan`', '`gelar_depan`', 200, -1, FALSE, '`gelar_depan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->gelar_depan->Sortable = TRUE; // Allow sort
		$this->fields['gelar_depan'] = &$this->gelar_depan;

		// gelar_belakang
		$this->gelar_belakang = new cField('users', 'users', 'x_gelar_belakang', 'gelar_belakang', '`gelar_belakang`', '`gelar_belakang`', 200, -1, FALSE, '`gelar_belakang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->gelar_belakang->Sortable = TRUE; // Allow sort
		$this->fields['gelar_belakang'] = &$this->gelar_belakang;

		// pendidikan_terakhir
		$this->pendidikan_terakhir = new cField('users', 'users', 'x_pendidikan_terakhir', 'pendidikan_terakhir', '`pendidikan_terakhir`', '`pendidikan_terakhir`', 200, -1, FALSE, '`pendidikan_terakhir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pendidikan_terakhir->Sortable = TRUE; // Allow sort
		$this->fields['pendidikan_terakhir'] = &$this->pendidikan_terakhir;

		// nama_lembaga
		$this->nama_lembaga = new cField('users', 'users', 'x_nama_lembaga', 'nama_lembaga', '`nama_lembaga`', '`nama_lembaga`', 200, -1, FALSE, '`nama_lembaga`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_lembaga->Sortable = TRUE; // Allow sort
		$this->fields['nama_lembaga'] = &$this->nama_lembaga;

		// warga_negara
		$this->warga_negara = new cField('users', 'users', 'x_warga_negara', 'warga_negara', '`warga_negara`', '`warga_negara`', 200, -1, FALSE, '`warga_negara`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->warga_negara->Sortable = TRUE; // Allow sort
		$this->fields['warga_negara'] = &$this->warga_negara;

		// tempat_lahir
		$this->tempat_lahir = new cField('users', 'users', 'x_tempat_lahir', 'tempat_lahir', '`tempat_lahir`', '`tempat_lahir`', 200, -1, FALSE, '`tempat_lahir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tempat_lahir->Sortable = TRUE; // Allow sort
		$this->fields['tempat_lahir'] = &$this->tempat_lahir;

		// tanggal_lahir
		$this->tanggal_lahir = new cField('users', 'users', 'x_tanggal_lahir', 'tanggal_lahir', '`tanggal_lahir`', ew_CastDateFieldForLike('`tanggal_lahir`', 0, "DB"), 133, 0, FALSE, '`tanggal_lahir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tanggal_lahir->Sortable = TRUE; // Allow sort
		$this->tanggal_lahir->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tanggal_lahir'] = &$this->tanggal_lahir;

		// jenis_kelamin
		$this->jenis_kelamin = new cField('users', 'users', 'x_jenis_kelamin', 'jenis_kelamin', '`jenis_kelamin`', '`jenis_kelamin`', 200, -1, FALSE, '`jenis_kelamin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jenis_kelamin->Sortable = TRUE; // Allow sort
		$this->fields['jenis_kelamin'] = &$this->jenis_kelamin;

		// status_perkawinan
		$this->status_perkawinan = new cField('users', 'users', 'x_status_perkawinan', 'status_perkawinan', '`status_perkawinan`', '`status_perkawinan`', 200, -1, FALSE, '`status_perkawinan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status_perkawinan->Sortable = TRUE; // Allow sort
		$this->fields['status_perkawinan'] = &$this->status_perkawinan;

		// agama
		$this->agama = new cField('users', 'users', 'x_agama', 'agama', '`agama`', '`agama`', 200, -1, FALSE, '`agama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->agama->Sortable = TRUE; // Allow sort
		$this->fields['agama'] = &$this->agama;

		// nama_bank
		$this->nama_bank = new cField('users', 'users', 'x_nama_bank', 'nama_bank', '`nama_bank`', '`nama_bank`', 200, -1, FALSE, '`nama_bank`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_bank->Sortable = TRUE; // Allow sort
		$this->fields['nama_bank'] = &$this->nama_bank;

		// no_rekening
		$this->no_rekening = new cField('users', 'users', 'x_no_rekening', 'no_rekening', '`no_rekening`', '`no_rekening`', 200, -1, FALSE, '`no_rekening`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_rekening->Sortable = TRUE; // Allow sort
		$this->fields['no_rekening'] = &$this->no_rekening;

		// change_date
		$this->change_date = new cField('users', 'users', 'x_change_date', 'change_date', '`change_date`', ew_CastDateFieldForLike('`change_date`', 0, "DB"), 135, 0, FALSE, '`change_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->change_date->Sortable = TRUE; // Allow sort
		$this->change_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['change_date'] = &$this->change_date;

		// change_by
		$this->change_by = new cField('users', 'users', 'x_change_by', 'change_by', '`change_by`', '`change_by`', 200, -1, FALSE, '`change_by`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`users`";
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
			return "userslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "usersview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "usersedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "usersadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "userslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("usersview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("usersview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "usersadd.php?" . $this->UrlParm($parm);
		else
			$url = "usersadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("usersedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("usersadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("usersdelete.php", $this->UrlParm());
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
		$this->nama_pegawai->setDbValue($rs->fields('nama_pegawai'));
		$this->username->setDbValue($rs->fields('username'));
		$this->kode_unit_organisasi->setDbValue($rs->fields('kode_unit_organisasi'));
		$this->kode_unit_kerja->setDbValue($rs->fields('kode_unit_kerja'));
		$this->jabatan->setDbValue($rs->fields('jabatan'));
		$this->password->setDbValue($rs->fields('password'));
		$this->user_group->setDbValue($rs->fields('user_group'));
		$this->status->setDbValue($rs->fields('status'));
		$this->photo->setDbValue($rs->fields('photo'));
		$this->nomor_anggota->setDbValue($rs->fields('nomor_anggota'));
		$this->nip->setDbValue($rs->fields('nip'));
		$this->nip_lama->setDbValue($rs->fields('nip_lama'));
		$this->gelar_depan->setDbValue($rs->fields('gelar_depan'));
		$this->gelar_belakang->setDbValue($rs->fields('gelar_belakang'));
		$this->pendidikan_terakhir->setDbValue($rs->fields('pendidikan_terakhir'));
		$this->nama_lembaga->setDbValue($rs->fields('nama_lembaga'));
		$this->warga_negara->setDbValue($rs->fields('warga_negara'));
		$this->tempat_lahir->setDbValue($rs->fields('tempat_lahir'));
		$this->tanggal_lahir->setDbValue($rs->fields('tanggal_lahir'));
		$this->jenis_kelamin->setDbValue($rs->fields('jenis_kelamin'));
		$this->status_perkawinan->setDbValue($rs->fields('status_perkawinan'));
		$this->agama->setDbValue($rs->fields('agama'));
		$this->nama_bank->setDbValue($rs->fields('nama_bank'));
		$this->no_rekening->setDbValue($rs->fields('no_rekening'));
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
		// nama_pegawai
		// username
		// kode_unit_organisasi
		// kode_unit_kerja
		// jabatan
		// password
		// user_group
		// status
		// photo
		// nomor_anggota
		// nip
		// nip_lama
		// gelar_depan
		// gelar_belakang
		// pendidikan_terakhir
		// nama_lembaga
		// warga_negara
		// tempat_lahir
		// tanggal_lahir
		// jenis_kelamin
		// status_perkawinan
		// agama
		// nama_bank
		// no_rekening
		// change_date
		// change_by
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nama_pegawai
		$this->nama_pegawai->ViewValue = $this->nama_pegawai->CurrentValue;
		$this->nama_pegawai->ViewCustomAttributes = "";

		// username
		$this->username->ViewValue = $this->username->CurrentValue;
		$this->username->ViewCustomAttributes = "";

		// kode_unit_organisasi
		$this->kode_unit_organisasi->ViewValue = $this->kode_unit_organisasi->CurrentValue;
		$this->kode_unit_organisasi->ViewCustomAttributes = "";

		// kode_unit_kerja
		$this->kode_unit_kerja->ViewValue = $this->kode_unit_kerja->CurrentValue;
		$this->kode_unit_kerja->ViewCustomAttributes = "";

		// jabatan
		$this->jabatan->ViewValue = $this->jabatan->CurrentValue;
		$this->jabatan->ViewCustomAttributes = "";

		// password
		$this->password->ViewValue = $this->password->CurrentValue;
		$this->password->ViewCustomAttributes = "";

		// user_group
		$this->user_group->ViewValue = $this->user_group->CurrentValue;
		$this->user_group->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

		// photo
		$this->photo->ViewValue = $this->photo->CurrentValue;
		$this->photo->ViewCustomAttributes = "";

		// nomor_anggota
		$this->nomor_anggota->ViewValue = $this->nomor_anggota->CurrentValue;
		$this->nomor_anggota->ViewCustomAttributes = "";

		// nip
		$this->nip->ViewValue = $this->nip->CurrentValue;
		$this->nip->ViewCustomAttributes = "";

		// nip_lama
		$this->nip_lama->ViewValue = $this->nip_lama->CurrentValue;
		$this->nip_lama->ViewCustomAttributes = "";

		// gelar_depan
		$this->gelar_depan->ViewValue = $this->gelar_depan->CurrentValue;
		$this->gelar_depan->ViewCustomAttributes = "";

		// gelar_belakang
		$this->gelar_belakang->ViewValue = $this->gelar_belakang->CurrentValue;
		$this->gelar_belakang->ViewCustomAttributes = "";

		// pendidikan_terakhir
		$this->pendidikan_terakhir->ViewValue = $this->pendidikan_terakhir->CurrentValue;
		$this->pendidikan_terakhir->ViewCustomAttributes = "";

		// nama_lembaga
		$this->nama_lembaga->ViewValue = $this->nama_lembaga->CurrentValue;
		$this->nama_lembaga->ViewCustomAttributes = "";

		// warga_negara
		$this->warga_negara->ViewValue = $this->warga_negara->CurrentValue;
		$this->warga_negara->ViewCustomAttributes = "";

		// tempat_lahir
		$this->tempat_lahir->ViewValue = $this->tempat_lahir->CurrentValue;
		$this->tempat_lahir->ViewCustomAttributes = "";

		// tanggal_lahir
		$this->tanggal_lahir->ViewValue = $this->tanggal_lahir->CurrentValue;
		$this->tanggal_lahir->ViewValue = ew_FormatDateTime($this->tanggal_lahir->ViewValue, 0);
		$this->tanggal_lahir->ViewCustomAttributes = "";

		// jenis_kelamin
		$this->jenis_kelamin->ViewValue = $this->jenis_kelamin->CurrentValue;
		$this->jenis_kelamin->ViewCustomAttributes = "";

		// status_perkawinan
		$this->status_perkawinan->ViewValue = $this->status_perkawinan->CurrentValue;
		$this->status_perkawinan->ViewCustomAttributes = "";

		// agama
		$this->agama->ViewValue = $this->agama->CurrentValue;
		$this->agama->ViewCustomAttributes = "";

		// nama_bank
		$this->nama_bank->ViewValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->ViewCustomAttributes = "";

		// no_rekening
		$this->no_rekening->ViewValue = $this->no_rekening->CurrentValue;
		$this->no_rekening->ViewCustomAttributes = "";

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

		// nama_pegawai
		$this->nama_pegawai->LinkCustomAttributes = "";
		$this->nama_pegawai->HrefValue = "";
		$this->nama_pegawai->TooltipValue = "";

		// username
		$this->username->LinkCustomAttributes = "";
		$this->username->HrefValue = "";
		$this->username->TooltipValue = "";

		// kode_unit_organisasi
		$this->kode_unit_organisasi->LinkCustomAttributes = "";
		$this->kode_unit_organisasi->HrefValue = "";
		$this->kode_unit_organisasi->TooltipValue = "";

		// kode_unit_kerja
		$this->kode_unit_kerja->LinkCustomAttributes = "";
		$this->kode_unit_kerja->HrefValue = "";
		$this->kode_unit_kerja->TooltipValue = "";

		// jabatan
		$this->jabatan->LinkCustomAttributes = "";
		$this->jabatan->HrefValue = "";
		$this->jabatan->TooltipValue = "";

		// password
		$this->password->LinkCustomAttributes = "";
		$this->password->HrefValue = "";
		$this->password->TooltipValue = "";

		// user_group
		$this->user_group->LinkCustomAttributes = "";
		$this->user_group->HrefValue = "";
		$this->user_group->TooltipValue = "";

		// status
		$this->status->LinkCustomAttributes = "";
		$this->status->HrefValue = "";
		$this->status->TooltipValue = "";

		// photo
		$this->photo->LinkCustomAttributes = "";
		$this->photo->HrefValue = "";
		$this->photo->TooltipValue = "";

		// nomor_anggota
		$this->nomor_anggota->LinkCustomAttributes = "";
		$this->nomor_anggota->HrefValue = "";
		$this->nomor_anggota->TooltipValue = "";

		// nip
		$this->nip->LinkCustomAttributes = "";
		$this->nip->HrefValue = "";
		$this->nip->TooltipValue = "";

		// nip_lama
		$this->nip_lama->LinkCustomAttributes = "";
		$this->nip_lama->HrefValue = "";
		$this->nip_lama->TooltipValue = "";

		// gelar_depan
		$this->gelar_depan->LinkCustomAttributes = "";
		$this->gelar_depan->HrefValue = "";
		$this->gelar_depan->TooltipValue = "";

		// gelar_belakang
		$this->gelar_belakang->LinkCustomAttributes = "";
		$this->gelar_belakang->HrefValue = "";
		$this->gelar_belakang->TooltipValue = "";

		// pendidikan_terakhir
		$this->pendidikan_terakhir->LinkCustomAttributes = "";
		$this->pendidikan_terakhir->HrefValue = "";
		$this->pendidikan_terakhir->TooltipValue = "";

		// nama_lembaga
		$this->nama_lembaga->LinkCustomAttributes = "";
		$this->nama_lembaga->HrefValue = "";
		$this->nama_lembaga->TooltipValue = "";

		// warga_negara
		$this->warga_negara->LinkCustomAttributes = "";
		$this->warga_negara->HrefValue = "";
		$this->warga_negara->TooltipValue = "";

		// tempat_lahir
		$this->tempat_lahir->LinkCustomAttributes = "";
		$this->tempat_lahir->HrefValue = "";
		$this->tempat_lahir->TooltipValue = "";

		// tanggal_lahir
		$this->tanggal_lahir->LinkCustomAttributes = "";
		$this->tanggal_lahir->HrefValue = "";
		$this->tanggal_lahir->TooltipValue = "";

		// jenis_kelamin
		$this->jenis_kelamin->LinkCustomAttributes = "";
		$this->jenis_kelamin->HrefValue = "";
		$this->jenis_kelamin->TooltipValue = "";

		// status_perkawinan
		$this->status_perkawinan->LinkCustomAttributes = "";
		$this->status_perkawinan->HrefValue = "";
		$this->status_perkawinan->TooltipValue = "";

		// agama
		$this->agama->LinkCustomAttributes = "";
		$this->agama->HrefValue = "";
		$this->agama->TooltipValue = "";

		// nama_bank
		$this->nama_bank->LinkCustomAttributes = "";
		$this->nama_bank->HrefValue = "";
		$this->nama_bank->TooltipValue = "";

		// no_rekening
		$this->no_rekening->LinkCustomAttributes = "";
		$this->no_rekening->HrefValue = "";
		$this->no_rekening->TooltipValue = "";

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

		// nama_pegawai
		$this->nama_pegawai->EditAttrs["class"] = "form-control";
		$this->nama_pegawai->EditCustomAttributes = "";
		$this->nama_pegawai->EditValue = $this->nama_pegawai->CurrentValue;
		$this->nama_pegawai->PlaceHolder = ew_RemoveHtml($this->nama_pegawai->FldCaption());

		// username
		$this->username->EditAttrs["class"] = "form-control";
		$this->username->EditCustomAttributes = "";
		$this->username->EditValue = $this->username->CurrentValue;
		$this->username->PlaceHolder = ew_RemoveHtml($this->username->FldCaption());

		// kode_unit_organisasi
		$this->kode_unit_organisasi->EditAttrs["class"] = "form-control";
		$this->kode_unit_organisasi->EditCustomAttributes = "";
		$this->kode_unit_organisasi->EditValue = $this->kode_unit_organisasi->CurrentValue;
		$this->kode_unit_organisasi->PlaceHolder = ew_RemoveHtml($this->kode_unit_organisasi->FldCaption());

		// kode_unit_kerja
		$this->kode_unit_kerja->EditAttrs["class"] = "form-control";
		$this->kode_unit_kerja->EditCustomAttributes = "";
		$this->kode_unit_kerja->EditValue = $this->kode_unit_kerja->CurrentValue;
		$this->kode_unit_kerja->PlaceHolder = ew_RemoveHtml($this->kode_unit_kerja->FldCaption());

		// jabatan
		$this->jabatan->EditAttrs["class"] = "form-control";
		$this->jabatan->EditCustomAttributes = "";
		$this->jabatan->EditValue = $this->jabatan->CurrentValue;
		$this->jabatan->PlaceHolder = ew_RemoveHtml($this->jabatan->FldCaption());

		// password
		$this->password->EditAttrs["class"] = "form-control";
		$this->password->EditCustomAttributes = "";
		$this->password->EditValue = $this->password->CurrentValue;
		$this->password->PlaceHolder = ew_RemoveHtml($this->password->FldCaption());

		// user_group
		$this->user_group->EditAttrs["class"] = "form-control";
		$this->user_group->EditCustomAttributes = "";
		$this->user_group->EditValue = $this->user_group->CurrentValue;
		$this->user_group->PlaceHolder = ew_RemoveHtml($this->user_group->FldCaption());

		// status
		$this->status->EditAttrs["class"] = "form-control";
		$this->status->EditCustomAttributes = "";
		$this->status->EditValue = $this->status->CurrentValue;
		$this->status->PlaceHolder = ew_RemoveHtml($this->status->FldCaption());

		// photo
		$this->photo->EditAttrs["class"] = "form-control";
		$this->photo->EditCustomAttributes = "";
		$this->photo->EditValue = $this->photo->CurrentValue;
		$this->photo->PlaceHolder = ew_RemoveHtml($this->photo->FldCaption());

		// nomor_anggota
		$this->nomor_anggota->EditAttrs["class"] = "form-control";
		$this->nomor_anggota->EditCustomAttributes = "";
		$this->nomor_anggota->EditValue = $this->nomor_anggota->CurrentValue;
		$this->nomor_anggota->PlaceHolder = ew_RemoveHtml($this->nomor_anggota->FldCaption());

		// nip
		$this->nip->EditAttrs["class"] = "form-control";
		$this->nip->EditCustomAttributes = "";
		$this->nip->EditValue = $this->nip->CurrentValue;
		$this->nip->PlaceHolder = ew_RemoveHtml($this->nip->FldCaption());

		// nip_lama
		$this->nip_lama->EditAttrs["class"] = "form-control";
		$this->nip_lama->EditCustomAttributes = "";
		$this->nip_lama->EditValue = $this->nip_lama->CurrentValue;
		$this->nip_lama->PlaceHolder = ew_RemoveHtml($this->nip_lama->FldCaption());

		// gelar_depan
		$this->gelar_depan->EditAttrs["class"] = "form-control";
		$this->gelar_depan->EditCustomAttributes = "";
		$this->gelar_depan->EditValue = $this->gelar_depan->CurrentValue;
		$this->gelar_depan->PlaceHolder = ew_RemoveHtml($this->gelar_depan->FldCaption());

		// gelar_belakang
		$this->gelar_belakang->EditAttrs["class"] = "form-control";
		$this->gelar_belakang->EditCustomAttributes = "";
		$this->gelar_belakang->EditValue = $this->gelar_belakang->CurrentValue;
		$this->gelar_belakang->PlaceHolder = ew_RemoveHtml($this->gelar_belakang->FldCaption());

		// pendidikan_terakhir
		$this->pendidikan_terakhir->EditAttrs["class"] = "form-control";
		$this->pendidikan_terakhir->EditCustomAttributes = "";
		$this->pendidikan_terakhir->EditValue = $this->pendidikan_terakhir->CurrentValue;
		$this->pendidikan_terakhir->PlaceHolder = ew_RemoveHtml($this->pendidikan_terakhir->FldCaption());

		// nama_lembaga
		$this->nama_lembaga->EditAttrs["class"] = "form-control";
		$this->nama_lembaga->EditCustomAttributes = "";
		$this->nama_lembaga->EditValue = $this->nama_lembaga->CurrentValue;
		$this->nama_lembaga->PlaceHolder = ew_RemoveHtml($this->nama_lembaga->FldCaption());

		// warga_negara
		$this->warga_negara->EditAttrs["class"] = "form-control";
		$this->warga_negara->EditCustomAttributes = "";
		$this->warga_negara->EditValue = $this->warga_negara->CurrentValue;
		$this->warga_negara->PlaceHolder = ew_RemoveHtml($this->warga_negara->FldCaption());

		// tempat_lahir
		$this->tempat_lahir->EditAttrs["class"] = "form-control";
		$this->tempat_lahir->EditCustomAttributes = "";
		$this->tempat_lahir->EditValue = $this->tempat_lahir->CurrentValue;
		$this->tempat_lahir->PlaceHolder = ew_RemoveHtml($this->tempat_lahir->FldCaption());

		// tanggal_lahir
		$this->tanggal_lahir->EditAttrs["class"] = "form-control";
		$this->tanggal_lahir->EditCustomAttributes = "";
		$this->tanggal_lahir->EditValue = ew_FormatDateTime($this->tanggal_lahir->CurrentValue, 8);
		$this->tanggal_lahir->PlaceHolder = ew_RemoveHtml($this->tanggal_lahir->FldCaption());

		// jenis_kelamin
		$this->jenis_kelamin->EditAttrs["class"] = "form-control";
		$this->jenis_kelamin->EditCustomAttributes = "";
		$this->jenis_kelamin->EditValue = $this->jenis_kelamin->CurrentValue;
		$this->jenis_kelamin->PlaceHolder = ew_RemoveHtml($this->jenis_kelamin->FldCaption());

		// status_perkawinan
		$this->status_perkawinan->EditAttrs["class"] = "form-control";
		$this->status_perkawinan->EditCustomAttributes = "";
		$this->status_perkawinan->EditValue = $this->status_perkawinan->CurrentValue;
		$this->status_perkawinan->PlaceHolder = ew_RemoveHtml($this->status_perkawinan->FldCaption());

		// agama
		$this->agama->EditAttrs["class"] = "form-control";
		$this->agama->EditCustomAttributes = "";
		$this->agama->EditValue = $this->agama->CurrentValue;
		$this->agama->PlaceHolder = ew_RemoveHtml($this->agama->FldCaption());

		// nama_bank
		$this->nama_bank->EditAttrs["class"] = "form-control";
		$this->nama_bank->EditCustomAttributes = "";
		$this->nama_bank->EditValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->PlaceHolder = ew_RemoveHtml($this->nama_bank->FldCaption());

		// no_rekening
		$this->no_rekening->EditAttrs["class"] = "form-control";
		$this->no_rekening->EditCustomAttributes = "";
		$this->no_rekening->EditValue = $this->no_rekening->CurrentValue;
		$this->no_rekening->PlaceHolder = ew_RemoveHtml($this->no_rekening->FldCaption());

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
					if ($this->nama_pegawai->Exportable) $Doc->ExportCaption($this->nama_pegawai);
					if ($this->username->Exportable) $Doc->ExportCaption($this->username);
					if ($this->kode_unit_organisasi->Exportable) $Doc->ExportCaption($this->kode_unit_organisasi);
					if ($this->kode_unit_kerja->Exportable) $Doc->ExportCaption($this->kode_unit_kerja);
					if ($this->jabatan->Exportable) $Doc->ExportCaption($this->jabatan);
					if ($this->password->Exportable) $Doc->ExportCaption($this->password);
					if ($this->user_group->Exportable) $Doc->ExportCaption($this->user_group);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->photo->Exportable) $Doc->ExportCaption($this->photo);
					if ($this->nomor_anggota->Exportable) $Doc->ExportCaption($this->nomor_anggota);
					if ($this->nip->Exportable) $Doc->ExportCaption($this->nip);
					if ($this->nip_lama->Exportable) $Doc->ExportCaption($this->nip_lama);
					if ($this->gelar_depan->Exportable) $Doc->ExportCaption($this->gelar_depan);
					if ($this->gelar_belakang->Exportable) $Doc->ExportCaption($this->gelar_belakang);
					if ($this->pendidikan_terakhir->Exportable) $Doc->ExportCaption($this->pendidikan_terakhir);
					if ($this->nama_lembaga->Exportable) $Doc->ExportCaption($this->nama_lembaga);
					if ($this->warga_negara->Exportable) $Doc->ExportCaption($this->warga_negara);
					if ($this->tempat_lahir->Exportable) $Doc->ExportCaption($this->tempat_lahir);
					if ($this->tanggal_lahir->Exportable) $Doc->ExportCaption($this->tanggal_lahir);
					if ($this->jenis_kelamin->Exportable) $Doc->ExportCaption($this->jenis_kelamin);
					if ($this->status_perkawinan->Exportable) $Doc->ExportCaption($this->status_perkawinan);
					if ($this->agama->Exportable) $Doc->ExportCaption($this->agama);
					if ($this->nama_bank->Exportable) $Doc->ExportCaption($this->nama_bank);
					if ($this->no_rekening->Exportable) $Doc->ExportCaption($this->no_rekening);
					if ($this->change_date->Exportable) $Doc->ExportCaption($this->change_date);
					if ($this->change_by->Exportable) $Doc->ExportCaption($this->change_by);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->nama_pegawai->Exportable) $Doc->ExportCaption($this->nama_pegawai);
					if ($this->username->Exportable) $Doc->ExportCaption($this->username);
					if ($this->kode_unit_organisasi->Exportable) $Doc->ExportCaption($this->kode_unit_organisasi);
					if ($this->kode_unit_kerja->Exportable) $Doc->ExportCaption($this->kode_unit_kerja);
					if ($this->jabatan->Exportable) $Doc->ExportCaption($this->jabatan);
					if ($this->user_group->Exportable) $Doc->ExportCaption($this->user_group);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->nomor_anggota->Exportable) $Doc->ExportCaption($this->nomor_anggota);
					if ($this->nip->Exportable) $Doc->ExportCaption($this->nip);
					if ($this->nip_lama->Exportable) $Doc->ExportCaption($this->nip_lama);
					if ($this->gelar_depan->Exportable) $Doc->ExportCaption($this->gelar_depan);
					if ($this->gelar_belakang->Exportable) $Doc->ExportCaption($this->gelar_belakang);
					if ($this->pendidikan_terakhir->Exportable) $Doc->ExportCaption($this->pendidikan_terakhir);
					if ($this->nama_lembaga->Exportable) $Doc->ExportCaption($this->nama_lembaga);
					if ($this->warga_negara->Exportable) $Doc->ExportCaption($this->warga_negara);
					if ($this->tempat_lahir->Exportable) $Doc->ExportCaption($this->tempat_lahir);
					if ($this->tanggal_lahir->Exportable) $Doc->ExportCaption($this->tanggal_lahir);
					if ($this->jenis_kelamin->Exportable) $Doc->ExportCaption($this->jenis_kelamin);
					if ($this->status_perkawinan->Exportable) $Doc->ExportCaption($this->status_perkawinan);
					if ($this->agama->Exportable) $Doc->ExportCaption($this->agama);
					if ($this->nama_bank->Exportable) $Doc->ExportCaption($this->nama_bank);
					if ($this->no_rekening->Exportable) $Doc->ExportCaption($this->no_rekening);
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
						if ($this->nama_pegawai->Exportable) $Doc->ExportField($this->nama_pegawai);
						if ($this->username->Exportable) $Doc->ExportField($this->username);
						if ($this->kode_unit_organisasi->Exportable) $Doc->ExportField($this->kode_unit_organisasi);
						if ($this->kode_unit_kerja->Exportable) $Doc->ExportField($this->kode_unit_kerja);
						if ($this->jabatan->Exportable) $Doc->ExportField($this->jabatan);
						if ($this->password->Exportable) $Doc->ExportField($this->password);
						if ($this->user_group->Exportable) $Doc->ExportField($this->user_group);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->photo->Exportable) $Doc->ExportField($this->photo);
						if ($this->nomor_anggota->Exportable) $Doc->ExportField($this->nomor_anggota);
						if ($this->nip->Exportable) $Doc->ExportField($this->nip);
						if ($this->nip_lama->Exportable) $Doc->ExportField($this->nip_lama);
						if ($this->gelar_depan->Exportable) $Doc->ExportField($this->gelar_depan);
						if ($this->gelar_belakang->Exportable) $Doc->ExportField($this->gelar_belakang);
						if ($this->pendidikan_terakhir->Exportable) $Doc->ExportField($this->pendidikan_terakhir);
						if ($this->nama_lembaga->Exportable) $Doc->ExportField($this->nama_lembaga);
						if ($this->warga_negara->Exportable) $Doc->ExportField($this->warga_negara);
						if ($this->tempat_lahir->Exportable) $Doc->ExportField($this->tempat_lahir);
						if ($this->tanggal_lahir->Exportable) $Doc->ExportField($this->tanggal_lahir);
						if ($this->jenis_kelamin->Exportable) $Doc->ExportField($this->jenis_kelamin);
						if ($this->status_perkawinan->Exportable) $Doc->ExportField($this->status_perkawinan);
						if ($this->agama->Exportable) $Doc->ExportField($this->agama);
						if ($this->nama_bank->Exportable) $Doc->ExportField($this->nama_bank);
						if ($this->no_rekening->Exportable) $Doc->ExportField($this->no_rekening);
						if ($this->change_date->Exportable) $Doc->ExportField($this->change_date);
						if ($this->change_by->Exportable) $Doc->ExportField($this->change_by);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->nama_pegawai->Exportable) $Doc->ExportField($this->nama_pegawai);
						if ($this->username->Exportable) $Doc->ExportField($this->username);
						if ($this->kode_unit_organisasi->Exportable) $Doc->ExportField($this->kode_unit_organisasi);
						if ($this->kode_unit_kerja->Exportable) $Doc->ExportField($this->kode_unit_kerja);
						if ($this->jabatan->Exportable) $Doc->ExportField($this->jabatan);
						if ($this->user_group->Exportable) $Doc->ExportField($this->user_group);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->nomor_anggota->Exportable) $Doc->ExportField($this->nomor_anggota);
						if ($this->nip->Exportable) $Doc->ExportField($this->nip);
						if ($this->nip_lama->Exportable) $Doc->ExportField($this->nip_lama);
						if ($this->gelar_depan->Exportable) $Doc->ExportField($this->gelar_depan);
						if ($this->gelar_belakang->Exportable) $Doc->ExportField($this->gelar_belakang);
						if ($this->pendidikan_terakhir->Exportable) $Doc->ExportField($this->pendidikan_terakhir);
						if ($this->nama_lembaga->Exportable) $Doc->ExportField($this->nama_lembaga);
						if ($this->warga_negara->Exportable) $Doc->ExportField($this->warga_negara);
						if ($this->tempat_lahir->Exportable) $Doc->ExportField($this->tempat_lahir);
						if ($this->tanggal_lahir->Exportable) $Doc->ExportField($this->tanggal_lahir);
						if ($this->jenis_kelamin->Exportable) $Doc->ExportField($this->jenis_kelamin);
						if ($this->status_perkawinan->Exportable) $Doc->ExportField($this->status_perkawinan);
						if ($this->agama->Exportable) $Doc->ExportField($this->agama);
						if ($this->nama_bank->Exportable) $Doc->ExportField($this->nama_bank);
						if ($this->no_rekening->Exportable) $Doc->ExportField($this->no_rekening);
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
