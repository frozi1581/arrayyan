<?php

// Global variable for table object
$personal = NULL;

//
// Table class for personal
//
class cpersonal extends cTable {
	var $employee_id;
	var $first_name;
	var $last_name;
	var $first_title;
	var $last_title;
	var $init;
	var $tpt_lahir;
	var $tgl_lahir;
	var $jk;
	var $kd_agama;
	var $tgl_masuk;
	var $tpt_masuk;
	var $stkel;
	var $alamat;
	var $kota;
	var $kd_pos;
	var $kd_propinsi;
	var $telp;
	var $telp_area;
	var $hp;
	var $alamat_dom;
	var $kota_dom;
	var $kd_pos_dom;
	var $kd_propinsi_dom;
	var $telp_dom;
	var $telp_dom_area;
	var $_email;
	var $kd_st_emp;
	var $skala;
	var $gp;
	var $upah_tetap;
	var $tgl_honor;
	var $honor;
	var $premi_honor;
	var $tgl_gp;
	var $skala_95;
	var $gp_95;
	var $tgl_gp_95;
	var $kd_indx;
	var $indx_lok;
	var $gol_darah;
	var $kd_jbt;
	var $tgl_kd_jbt;
	var $kd_jbt_pgs;
	var $tgl_kd_jbt_pgs;
	var $kd_jbt_pjs;
	var $tgl_kd_jbt_pjs;
	var $kd_jbt_ps;
	var $tgl_kd_jbt_ps;
	var $kd_pat;
	var $kd_gas;
	var $pimp_empid;
	var $stshift;
	var $no_rek;
	var $kd_bank;
	var $kd_jamsostek;
	var $acc_astek;
	var $acc_dapens;
	var $acc_kes;
	var $st;
	var $signature;
	var $created_by;
	var $created_date;
	var $last_update_by;
	var $last_update_date;
	var $fgr_print_id;
	var $kd_jbt_eselon;
	var $npwp;
	var $paraf;
	var $tgl_keluar;
	var $nama_nasabah;
	var $no_ktp;
	var $no_kokar;
	var $no_bmw;
	var $no_bpjs_ketenagakerjaan;
	var $no_bpjs_kesehatan;
	var $eselon;
	var $kd_jenjang;
	var $kd_jbt_esl;
	var $tgl_jbt_esl;
	var $org_id;
	var $picture;
	var $kd_payroll;
	var $id_wn;
	var $no_anggota_kkms;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'personal';
		$this->TableName = 'personal';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`personal`";
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

		// employee_id
		$this->employee_id = new cField('personal', 'personal', 'x_employee_id', 'employee_id', '`employee_id`', '`employee_id`', 200, -1, FALSE, '`employee_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->employee_id->Sortable = TRUE; // Allow sort
		$this->fields['employee_id'] = &$this->employee_id;

		// first_name
		$this->first_name = new cField('personal', 'personal', 'x_first_name', 'first_name', '`first_name`', '`first_name`', 200, -1, FALSE, '`first_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->first_name->Sortable = TRUE; // Allow sort
		$this->fields['first_name'] = &$this->first_name;

		// last_name
		$this->last_name = new cField('personal', 'personal', 'x_last_name', 'last_name', '`last_name`', '`last_name`', 200, -1, FALSE, '`last_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_name->Sortable = TRUE; // Allow sort
		$this->fields['last_name'] = &$this->last_name;

		// first_title
		$this->first_title = new cField('personal', 'personal', 'x_first_title', 'first_title', '`first_title`', '`first_title`', 200, -1, FALSE, '`first_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->first_title->Sortable = TRUE; // Allow sort
		$this->fields['first_title'] = &$this->first_title;

		// last_title
		$this->last_title = new cField('personal', 'personal', 'x_last_title', 'last_title', '`last_title`', '`last_title`', 200, -1, FALSE, '`last_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_title->Sortable = TRUE; // Allow sort
		$this->fields['last_title'] = &$this->last_title;

		// init
		$this->init = new cField('personal', 'personal', 'x_init', 'init', '`init`', '`init`', 200, -1, FALSE, '`init`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->init->Sortable = TRUE; // Allow sort
		$this->fields['init'] = &$this->init;

		// tpt_lahir
		$this->tpt_lahir = new cField('personal', 'personal', 'x_tpt_lahir', 'tpt_lahir', '`tpt_lahir`', '`tpt_lahir`', 200, -1, FALSE, '`tpt_lahir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tpt_lahir->Sortable = TRUE; // Allow sort
		$this->fields['tpt_lahir'] = &$this->tpt_lahir;

		// tgl_lahir
		$this->tgl_lahir = new cField('personal', 'personal', 'x_tgl_lahir', 'tgl_lahir', '`tgl_lahir`', ew_CastDateFieldForLike('`tgl_lahir`', 0, "DB"), 135, 0, FALSE, '`tgl_lahir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_lahir->Sortable = TRUE; // Allow sort
		$this->tgl_lahir->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_lahir'] = &$this->tgl_lahir;

		// jk
		$this->jk = new cField('personal', 'personal', 'x_jk', 'jk', '`jk`', '`jk`', 200, -1, FALSE, '`jk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jk->Sortable = TRUE; // Allow sort
		$this->fields['jk'] = &$this->jk;

		// kd_agama
		$this->kd_agama = new cField('personal', 'personal', 'x_kd_agama', 'kd_agama', '`kd_agama`', '`kd_agama`', 200, -1, FALSE, '`kd_agama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_agama->Sortable = TRUE; // Allow sort
		$this->fields['kd_agama'] = &$this->kd_agama;

		// tgl_masuk
		$this->tgl_masuk = new cField('personal', 'personal', 'x_tgl_masuk', 'tgl_masuk', '`tgl_masuk`', ew_CastDateFieldForLike('`tgl_masuk`', 0, "DB"), 135, 0, FALSE, '`tgl_masuk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_masuk->Sortable = TRUE; // Allow sort
		$this->tgl_masuk->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_masuk'] = &$this->tgl_masuk;

		// tpt_masuk
		$this->tpt_masuk = new cField('personal', 'personal', 'x_tpt_masuk', 'tpt_masuk', '`tpt_masuk`', '`tpt_masuk`', 200, -1, FALSE, '`tpt_masuk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tpt_masuk->Sortable = TRUE; // Allow sort
		$this->fields['tpt_masuk'] = &$this->tpt_masuk;

		// stkel
		$this->stkel = new cField('personal', 'personal', 'x_stkel', 'stkel', '`stkel`', '`stkel`', 200, -1, FALSE, '`stkel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->stkel->Sortable = TRUE; // Allow sort
		$this->fields['stkel'] = &$this->stkel;

		// alamat
		$this->alamat = new cField('personal', 'personal', 'x_alamat', 'alamat', '`alamat`', '`alamat`', 200, -1, FALSE, '`alamat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->alamat->Sortable = TRUE; // Allow sort
		$this->fields['alamat'] = &$this->alamat;

		// kota
		$this->kota = new cField('personal', 'personal', 'x_kota', 'kota', '`kota`', '`kota`', 200, -1, FALSE, '`kota`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kota->Sortable = TRUE; // Allow sort
		$this->fields['kota'] = &$this->kota;

		// kd_pos
		$this->kd_pos = new cField('personal', 'personal', 'x_kd_pos', 'kd_pos', '`kd_pos`', '`kd_pos`', 200, -1, FALSE, '`kd_pos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_pos->Sortable = TRUE; // Allow sort
		$this->fields['kd_pos'] = &$this->kd_pos;

		// kd_propinsi
		$this->kd_propinsi = new cField('personal', 'personal', 'x_kd_propinsi', 'kd_propinsi', '`kd_propinsi`', '`kd_propinsi`', 200, -1, FALSE, '`kd_propinsi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_propinsi->Sortable = TRUE; // Allow sort
		$this->fields['kd_propinsi'] = &$this->kd_propinsi;

		// telp
		$this->telp = new cField('personal', 'personal', 'x_telp', 'telp', '`telp`', '`telp`', 200, -1, FALSE, '`telp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->telp->Sortable = TRUE; // Allow sort
		$this->fields['telp'] = &$this->telp;

		// telp_area
		$this->telp_area = new cField('personal', 'personal', 'x_telp_area', 'telp_area', '`telp_area`', '`telp_area`', 200, -1, FALSE, '`telp_area`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->telp_area->Sortable = TRUE; // Allow sort
		$this->fields['telp_area'] = &$this->telp_area;

		// hp
		$this->hp = new cField('personal', 'personal', 'x_hp', 'hp', '`hp`', '`hp`', 200, -1, FALSE, '`hp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hp->Sortable = TRUE; // Allow sort
		$this->fields['hp'] = &$this->hp;

		// alamat_dom
		$this->alamat_dom = new cField('personal', 'personal', 'x_alamat_dom', 'alamat_dom', '`alamat_dom`', '`alamat_dom`', 200, -1, FALSE, '`alamat_dom`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->alamat_dom->Sortable = TRUE; // Allow sort
		$this->fields['alamat_dom'] = &$this->alamat_dom;

		// kota_dom
		$this->kota_dom = new cField('personal', 'personal', 'x_kota_dom', 'kota_dom', '`kota_dom`', '`kota_dom`', 200, -1, FALSE, '`kota_dom`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kota_dom->Sortable = TRUE; // Allow sort
		$this->fields['kota_dom'] = &$this->kota_dom;

		// kd_pos_dom
		$this->kd_pos_dom = new cField('personal', 'personal', 'x_kd_pos_dom', 'kd_pos_dom', '`kd_pos_dom`', '`kd_pos_dom`', 200, -1, FALSE, '`kd_pos_dom`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_pos_dom->Sortable = TRUE; // Allow sort
		$this->fields['kd_pos_dom'] = &$this->kd_pos_dom;

		// kd_propinsi_dom
		$this->kd_propinsi_dom = new cField('personal', 'personal', 'x_kd_propinsi_dom', 'kd_propinsi_dom', '`kd_propinsi_dom`', '`kd_propinsi_dom`', 200, -1, FALSE, '`kd_propinsi_dom`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_propinsi_dom->Sortable = TRUE; // Allow sort
		$this->fields['kd_propinsi_dom'] = &$this->kd_propinsi_dom;

		// telp_dom
		$this->telp_dom = new cField('personal', 'personal', 'x_telp_dom', 'telp_dom', '`telp_dom`', '`telp_dom`', 200, -1, FALSE, '`telp_dom`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->telp_dom->Sortable = TRUE; // Allow sort
		$this->fields['telp_dom'] = &$this->telp_dom;

		// telp_dom_area
		$this->telp_dom_area = new cField('personal', 'personal', 'x_telp_dom_area', 'telp_dom_area', '`telp_dom_area`', '`telp_dom_area`', 200, -1, FALSE, '`telp_dom_area`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->telp_dom_area->Sortable = TRUE; // Allow sort
		$this->fields['telp_dom_area'] = &$this->telp_dom_area;

		// email
		$this->_email = new cField('personal', 'personal', 'x__email', 'email', '`email`', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_email->Sortable = TRUE; // Allow sort
		$this->fields['email'] = &$this->_email;

		// kd_st_emp
		$this->kd_st_emp = new cField('personal', 'personal', 'x_kd_st_emp', 'kd_st_emp', '`kd_st_emp`', '`kd_st_emp`', 200, -1, FALSE, '`kd_st_emp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_st_emp->Sortable = TRUE; // Allow sort
		$this->fields['kd_st_emp'] = &$this->kd_st_emp;

		// skala
		$this->skala = new cField('personal', 'personal', 'x_skala', 'skala', '`skala`', '`skala`', 200, -1, FALSE, '`skala`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->skala->Sortable = TRUE; // Allow sort
		$this->fields['skala'] = &$this->skala;

		// gp
		$this->gp = new cField('personal', 'personal', 'x_gp', 'gp', '`gp`', '`gp`', 5, -1, FALSE, '`gp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->gp->Sortable = TRUE; // Allow sort
		$this->gp->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['gp'] = &$this->gp;

		// upah_tetap
		$this->upah_tetap = new cField('personal', 'personal', 'x_upah_tetap', 'upah_tetap', '`upah_tetap`', '`upah_tetap`', 131, -1, FALSE, '`upah_tetap`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->upah_tetap->Sortable = TRUE; // Allow sort
		$this->upah_tetap->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['upah_tetap'] = &$this->upah_tetap;

		// tgl_honor
		$this->tgl_honor = new cField('personal', 'personal', 'x_tgl_honor', 'tgl_honor', '`tgl_honor`', ew_CastDateFieldForLike('`tgl_honor`', 0, "DB"), 135, 0, FALSE, '`tgl_honor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_honor->Sortable = TRUE; // Allow sort
		$this->tgl_honor->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_honor'] = &$this->tgl_honor;

		// honor
		$this->honor = new cField('personal', 'personal', 'x_honor', 'honor', '`honor`', '`honor`', 5, -1, FALSE, '`honor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->honor->Sortable = TRUE; // Allow sort
		$this->honor->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['honor'] = &$this->honor;

		// premi_honor
		$this->premi_honor = new cField('personal', 'personal', 'x_premi_honor', 'premi_honor', '`premi_honor`', '`premi_honor`', 131, -1, FALSE, '`premi_honor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->premi_honor->Sortable = TRUE; // Allow sort
		$this->premi_honor->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['premi_honor'] = &$this->premi_honor;

		// tgl_gp
		$this->tgl_gp = new cField('personal', 'personal', 'x_tgl_gp', 'tgl_gp', '`tgl_gp`', ew_CastDateFieldForLike('`tgl_gp`', 0, "DB"), 135, 0, FALSE, '`tgl_gp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_gp->Sortable = TRUE; // Allow sort
		$this->tgl_gp->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_gp'] = &$this->tgl_gp;

		// skala_95
		$this->skala_95 = new cField('personal', 'personal', 'x_skala_95', 'skala_95', '`skala_95`', '`skala_95`', 200, -1, FALSE, '`skala_95`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->skala_95->Sortable = TRUE; // Allow sort
		$this->fields['skala_95'] = &$this->skala_95;

		// gp_95
		$this->gp_95 = new cField('personal', 'personal', 'x_gp_95', 'gp_95', '`gp_95`', '`gp_95`', 5, -1, FALSE, '`gp_95`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->gp_95->Sortable = TRUE; // Allow sort
		$this->gp_95->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['gp_95'] = &$this->gp_95;

		// tgl_gp_95
		$this->tgl_gp_95 = new cField('personal', 'personal', 'x_tgl_gp_95', 'tgl_gp_95', '`tgl_gp_95`', ew_CastDateFieldForLike('`tgl_gp_95`', 0, "DB"), 135, 0, FALSE, '`tgl_gp_95`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_gp_95->Sortable = TRUE; // Allow sort
		$this->tgl_gp_95->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_gp_95'] = &$this->tgl_gp_95;

		// kd_indx
		$this->kd_indx = new cField('personal', 'personal', 'x_kd_indx', 'kd_indx', '`kd_indx`', '`kd_indx`', 200, -1, FALSE, '`kd_indx`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_indx->Sortable = TRUE; // Allow sort
		$this->fields['kd_indx'] = &$this->kd_indx;

		// indx_lok
		$this->indx_lok = new cField('personal', 'personal', 'x_indx_lok', 'indx_lok', '`indx_lok`', '`indx_lok`', 131, -1, FALSE, '`indx_lok`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->indx_lok->Sortable = TRUE; // Allow sort
		$this->indx_lok->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['indx_lok'] = &$this->indx_lok;

		// gol_darah
		$this->gol_darah = new cField('personal', 'personal', 'x_gol_darah', 'gol_darah', '`gol_darah`', '`gol_darah`', 200, -1, FALSE, '`gol_darah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->gol_darah->Sortable = TRUE; // Allow sort
		$this->fields['gol_darah'] = &$this->gol_darah;

		// kd_jbt
		$this->kd_jbt = new cField('personal', 'personal', 'x_kd_jbt', 'kd_jbt', '`kd_jbt`', '`kd_jbt`', 200, -1, FALSE, '`kd_jbt`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jbt->Sortable = TRUE; // Allow sort
		$this->fields['kd_jbt'] = &$this->kd_jbt;

		// tgl_kd_jbt
		$this->tgl_kd_jbt = new cField('personal', 'personal', 'x_tgl_kd_jbt', 'tgl_kd_jbt', '`tgl_kd_jbt`', ew_CastDateFieldForLike('`tgl_kd_jbt`', 0, "DB"), 135, 0, FALSE, '`tgl_kd_jbt`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_kd_jbt->Sortable = TRUE; // Allow sort
		$this->tgl_kd_jbt->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_kd_jbt'] = &$this->tgl_kd_jbt;

		// kd_jbt_pgs
		$this->kd_jbt_pgs = new cField('personal', 'personal', 'x_kd_jbt_pgs', 'kd_jbt_pgs', '`kd_jbt_pgs`', '`kd_jbt_pgs`', 200, -1, FALSE, '`kd_jbt_pgs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jbt_pgs->Sortable = TRUE; // Allow sort
		$this->fields['kd_jbt_pgs'] = &$this->kd_jbt_pgs;

		// tgl_kd_jbt_pgs
		$this->tgl_kd_jbt_pgs = new cField('personal', 'personal', 'x_tgl_kd_jbt_pgs', 'tgl_kd_jbt_pgs', '`tgl_kd_jbt_pgs`', ew_CastDateFieldForLike('`tgl_kd_jbt_pgs`', 0, "DB"), 135, 0, FALSE, '`tgl_kd_jbt_pgs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_kd_jbt_pgs->Sortable = TRUE; // Allow sort
		$this->tgl_kd_jbt_pgs->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_kd_jbt_pgs'] = &$this->tgl_kd_jbt_pgs;

		// kd_jbt_pjs
		$this->kd_jbt_pjs = new cField('personal', 'personal', 'x_kd_jbt_pjs', 'kd_jbt_pjs', '`kd_jbt_pjs`', '`kd_jbt_pjs`', 200, -1, FALSE, '`kd_jbt_pjs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jbt_pjs->Sortable = TRUE; // Allow sort
		$this->fields['kd_jbt_pjs'] = &$this->kd_jbt_pjs;

		// tgl_kd_jbt_pjs
		$this->tgl_kd_jbt_pjs = new cField('personal', 'personal', 'x_tgl_kd_jbt_pjs', 'tgl_kd_jbt_pjs', '`tgl_kd_jbt_pjs`', ew_CastDateFieldForLike('`tgl_kd_jbt_pjs`', 0, "DB"), 135, 0, FALSE, '`tgl_kd_jbt_pjs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_kd_jbt_pjs->Sortable = TRUE; // Allow sort
		$this->tgl_kd_jbt_pjs->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_kd_jbt_pjs'] = &$this->tgl_kd_jbt_pjs;

		// kd_jbt_ps
		$this->kd_jbt_ps = new cField('personal', 'personal', 'x_kd_jbt_ps', 'kd_jbt_ps', '`kd_jbt_ps`', '`kd_jbt_ps`', 200, -1, FALSE, '`kd_jbt_ps`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jbt_ps->Sortable = TRUE; // Allow sort
		$this->fields['kd_jbt_ps'] = &$this->kd_jbt_ps;

		// tgl_kd_jbt_ps
		$this->tgl_kd_jbt_ps = new cField('personal', 'personal', 'x_tgl_kd_jbt_ps', 'tgl_kd_jbt_ps', '`tgl_kd_jbt_ps`', ew_CastDateFieldForLike('`tgl_kd_jbt_ps`', 0, "DB"), 135, 0, FALSE, '`tgl_kd_jbt_ps`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_kd_jbt_ps->Sortable = TRUE; // Allow sort
		$this->tgl_kd_jbt_ps->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_kd_jbt_ps'] = &$this->tgl_kd_jbt_ps;

		// kd_pat
		$this->kd_pat = new cField('personal', 'personal', 'x_kd_pat', 'kd_pat', '`kd_pat`', '`kd_pat`', 200, -1, FALSE, '`kd_pat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_pat->Sortable = TRUE; // Allow sort
		$this->fields['kd_pat'] = &$this->kd_pat;

		// kd_gas
		$this->kd_gas = new cField('personal', 'personal', 'x_kd_gas', 'kd_gas', '`kd_gas`', '`kd_gas`', 200, -1, FALSE, '`kd_gas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_gas->Sortable = TRUE; // Allow sort
		$this->fields['kd_gas'] = &$this->kd_gas;

		// pimp_empid
		$this->pimp_empid = new cField('personal', 'personal', 'x_pimp_empid', 'pimp_empid', '`pimp_empid`', '`pimp_empid`', 200, -1, FALSE, '`pimp_empid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pimp_empid->Sortable = TRUE; // Allow sort
		$this->fields['pimp_empid'] = &$this->pimp_empid;

		// stshift
		$this->stshift = new cField('personal', 'personal', 'x_stshift', 'stshift', '`stshift`', '`stshift`', 200, -1, FALSE, '`stshift`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->stshift->Sortable = TRUE; // Allow sort
		$this->fields['stshift'] = &$this->stshift;

		// no_rek
		$this->no_rek = new cField('personal', 'personal', 'x_no_rek', 'no_rek', '`no_rek`', '`no_rek`', 200, -1, FALSE, '`no_rek`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_rek->Sortable = TRUE; // Allow sort
		$this->fields['no_rek'] = &$this->no_rek;

		// kd_bank
		$this->kd_bank = new cField('personal', 'personal', 'x_kd_bank', 'kd_bank', '`kd_bank`', '`kd_bank`', 200, -1, FALSE, '`kd_bank`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_bank->Sortable = TRUE; // Allow sort
		$this->fields['kd_bank'] = &$this->kd_bank;

		// kd_jamsostek
		$this->kd_jamsostek = new cField('personal', 'personal', 'x_kd_jamsostek', 'kd_jamsostek', '`kd_jamsostek`', '`kd_jamsostek`', 200, -1, FALSE, '`kd_jamsostek`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jamsostek->Sortable = TRUE; // Allow sort
		$this->fields['kd_jamsostek'] = &$this->kd_jamsostek;

		// acc_astek
		$this->acc_astek = new cField('personal', 'personal', 'x_acc_astek', 'acc_astek', '`acc_astek`', '`acc_astek`', 200, -1, FALSE, '`acc_astek`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->acc_astek->Sortable = TRUE; // Allow sort
		$this->fields['acc_astek'] = &$this->acc_astek;

		// acc_dapens
		$this->acc_dapens = new cField('personal', 'personal', 'x_acc_dapens', 'acc_dapens', '`acc_dapens`', '`acc_dapens`', 200, -1, FALSE, '`acc_dapens`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->acc_dapens->Sortable = TRUE; // Allow sort
		$this->fields['acc_dapens'] = &$this->acc_dapens;

		// acc_kes
		$this->acc_kes = new cField('personal', 'personal', 'x_acc_kes', 'acc_kes', '`acc_kes`', '`acc_kes`', 200, -1, FALSE, '`acc_kes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->acc_kes->Sortable = TRUE; // Allow sort
		$this->fields['acc_kes'] = &$this->acc_kes;

		// st
		$this->st = new cField('personal', 'personal', 'x_st', 'st', '`st`', '`st`', 200, -1, FALSE, '`st`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->st->Sortable = TRUE; // Allow sort
		$this->fields['st'] = &$this->st;

		// signature
		$this->signature = new cField('personal', 'personal', 'x_signature', 'signature', '`signature`', '`signature`', 205, -1, TRUE, '`signature`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'FILE');
		$this->signature->Sortable = TRUE; // Allow sort
		$this->fields['signature'] = &$this->signature;

		// created_by
		$this->created_by = new cField('personal', 'personal', 'x_created_by', 'created_by', '`created_by`', '`created_by`', 200, -1, FALSE, '`created_by`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->created_by->Sortable = TRUE; // Allow sort
		$this->fields['created_by'] = &$this->created_by;

		// created_date
		$this->created_date = new cField('personal', 'personal', 'x_created_date', 'created_date', '`created_date`', ew_CastDateFieldForLike('`created_date`', 0, "DB"), 135, 0, FALSE, '`created_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->created_date->Sortable = TRUE; // Allow sort
		$this->created_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['created_date'] = &$this->created_date;

		// last_update_by
		$this->last_update_by = new cField('personal', 'personal', 'x_last_update_by', 'last_update_by', '`last_update_by`', '`last_update_by`', 200, -1, FALSE, '`last_update_by`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_update_by->Sortable = TRUE; // Allow sort
		$this->fields['last_update_by'] = &$this->last_update_by;

		// last_update_date
		$this->last_update_date = new cField('personal', 'personal', 'x_last_update_date', 'last_update_date', '`last_update_date`', ew_CastDateFieldForLike('`last_update_date`', 0, "DB"), 135, 0, FALSE, '`last_update_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_update_date->Sortable = TRUE; // Allow sort
		$this->last_update_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['last_update_date'] = &$this->last_update_date;

		// fgr_print_id
		$this->fgr_print_id = new cField('personal', 'personal', 'x_fgr_print_id', 'fgr_print_id', '`fgr_print_id`', '`fgr_print_id`', 5, -1, FALSE, '`fgr_print_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fgr_print_id->Sortable = TRUE; // Allow sort
		$this->fgr_print_id->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['fgr_print_id'] = &$this->fgr_print_id;

		// kd_jbt_eselon
		$this->kd_jbt_eselon = new cField('personal', 'personal', 'x_kd_jbt_eselon', 'kd_jbt_eselon', '`kd_jbt_eselon`', '`kd_jbt_eselon`', 200, -1, FALSE, '`kd_jbt_eselon`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jbt_eselon->Sortable = TRUE; // Allow sort
		$this->fields['kd_jbt_eselon'] = &$this->kd_jbt_eselon;

		// npwp
		$this->npwp = new cField('personal', 'personal', 'x_npwp', 'npwp', '`npwp`', '`npwp`', 200, -1, FALSE, '`npwp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->npwp->Sortable = TRUE; // Allow sort
		$this->fields['npwp'] = &$this->npwp;

		// paraf
		$this->paraf = new cField('personal', 'personal', 'x_paraf', 'paraf', '`paraf`', '`paraf`', 205, -1, TRUE, '`paraf`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'FILE');
		$this->paraf->Sortable = TRUE; // Allow sort
		$this->fields['paraf'] = &$this->paraf;

		// tgl_keluar
		$this->tgl_keluar = new cField('personal', 'personal', 'x_tgl_keluar', 'tgl_keluar', '`tgl_keluar`', ew_CastDateFieldForLike('`tgl_keluar`', 0, "DB"), 135, 0, FALSE, '`tgl_keluar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_keluar->Sortable = TRUE; // Allow sort
		$this->tgl_keluar->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_keluar'] = &$this->tgl_keluar;

		// nama_nasabah
		$this->nama_nasabah = new cField('personal', 'personal', 'x_nama_nasabah', 'nama_nasabah', '`nama_nasabah`', '`nama_nasabah`', 200, -1, FALSE, '`nama_nasabah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_nasabah->Sortable = TRUE; // Allow sort
		$this->fields['nama_nasabah'] = &$this->nama_nasabah;

		// no_ktp
		$this->no_ktp = new cField('personal', 'personal', 'x_no_ktp', 'no_ktp', '`no_ktp`', '`no_ktp`', 200, -1, FALSE, '`no_ktp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_ktp->Sortable = TRUE; // Allow sort
		$this->fields['no_ktp'] = &$this->no_ktp;

		// no_kokar
		$this->no_kokar = new cField('personal', 'personal', 'x_no_kokar', 'no_kokar', '`no_kokar`', '`no_kokar`', 200, -1, FALSE, '`no_kokar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_kokar->Sortable = TRUE; // Allow sort
		$this->fields['no_kokar'] = &$this->no_kokar;

		// no_bmw
		$this->no_bmw = new cField('personal', 'personal', 'x_no_bmw', 'no_bmw', '`no_bmw`', '`no_bmw`', 200, -1, FALSE, '`no_bmw`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_bmw->Sortable = TRUE; // Allow sort
		$this->fields['no_bmw'] = &$this->no_bmw;

		// no_bpjs_ketenagakerjaan
		$this->no_bpjs_ketenagakerjaan = new cField('personal', 'personal', 'x_no_bpjs_ketenagakerjaan', 'no_bpjs_ketenagakerjaan', '`no_bpjs_ketenagakerjaan`', '`no_bpjs_ketenagakerjaan`', 200, -1, FALSE, '`no_bpjs_ketenagakerjaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_bpjs_ketenagakerjaan->Sortable = TRUE; // Allow sort
		$this->fields['no_bpjs_ketenagakerjaan'] = &$this->no_bpjs_ketenagakerjaan;

		// no_bpjs_kesehatan
		$this->no_bpjs_kesehatan = new cField('personal', 'personal', 'x_no_bpjs_kesehatan', 'no_bpjs_kesehatan', '`no_bpjs_kesehatan`', '`no_bpjs_kesehatan`', 200, -1, FALSE, '`no_bpjs_kesehatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_bpjs_kesehatan->Sortable = TRUE; // Allow sort
		$this->fields['no_bpjs_kesehatan'] = &$this->no_bpjs_kesehatan;

		// eselon
		$this->eselon = new cField('personal', 'personal', 'x_eselon', 'eselon', '`eselon`', '`eselon`', 200, -1, FALSE, '`eselon`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eselon->Sortable = TRUE; // Allow sort
		$this->fields['eselon'] = &$this->eselon;

		// kd_jenjang
		$this->kd_jenjang = new cField('personal', 'personal', 'x_kd_jenjang', 'kd_jenjang', '`kd_jenjang`', '`kd_jenjang`', 200, -1, FALSE, '`kd_jenjang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jenjang->Sortable = TRUE; // Allow sort
		$this->fields['kd_jenjang'] = &$this->kd_jenjang;

		// kd_jbt_esl
		$this->kd_jbt_esl = new cField('personal', 'personal', 'x_kd_jbt_esl', 'kd_jbt_esl', '`kd_jbt_esl`', '`kd_jbt_esl`', 200, -1, FALSE, '`kd_jbt_esl`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_jbt_esl->Sortable = TRUE; // Allow sort
		$this->fields['kd_jbt_esl'] = &$this->kd_jbt_esl;

		// tgl_jbt_esl
		$this->tgl_jbt_esl = new cField('personal', 'personal', 'x_tgl_jbt_esl', 'tgl_jbt_esl', '`tgl_jbt_esl`', ew_CastDateFieldForLike('`tgl_jbt_esl`', 0, "DB"), 135, 0, FALSE, '`tgl_jbt_esl`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_jbt_esl->Sortable = TRUE; // Allow sort
		$this->tgl_jbt_esl->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_jbt_esl'] = &$this->tgl_jbt_esl;

		// org_id
		$this->org_id = new cField('personal', 'personal', 'x_org_id', 'org_id', '`org_id`', '`org_id`', 200, -1, FALSE, '`org_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->org_id->Sortable = TRUE; // Allow sort
		$this->fields['org_id'] = &$this->org_id;

		// picture
		$this->picture = new cField('personal', 'personal', 'x_picture', 'picture', '`picture`', '`picture`', 205, -1, TRUE, '`picture`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'FILE');
		$this->picture->Sortable = TRUE; // Allow sort
		$this->fields['picture'] = &$this->picture;

		// kd_payroll
		$this->kd_payroll = new cField('personal', 'personal', 'x_kd_payroll', 'kd_payroll', '`kd_payroll`', '`kd_payroll`', 200, -1, FALSE, '`kd_payroll`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_payroll->Sortable = TRUE; // Allow sort
		$this->fields['kd_payroll'] = &$this->kd_payroll;

		// id_wn
		$this->id_wn = new cField('personal', 'personal', 'x_id_wn', 'id_wn', '`id_wn`', '`id_wn`', 200, -1, FALSE, '`id_wn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_wn->Sortable = TRUE; // Allow sort
		$this->fields['id_wn'] = &$this->id_wn;

		// no_anggota_kkms
		$this->no_anggota_kkms = new cField('personal', 'personal', 'x_no_anggota_kkms', 'no_anggota_kkms', '`no_anggota_kkms`', '`no_anggota_kkms`', 200, -1, FALSE, '`no_anggota_kkms`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_anggota_kkms->Sortable = TRUE; // Allow sort
		$this->fields['no_anggota_kkms'] = &$this->no_anggota_kkms;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`personal`";
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
		return "`employee_id` = '@employee_id@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "personallist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "personalview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "personaledit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "personaladd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "personallist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("personalview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("personalview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "personaladd.php?" . $this->UrlParm($parm);
		else
			$url = "personaladd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("personaledit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("personaladd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("personaldelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "employee_id:" . ew_VarToJson($this->employee_id->CurrentValue, "string", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->employee_id->CurrentValue)) {
			$sUrl .= "employee_id=" . urlencode($this->employee_id->CurrentValue);
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
			if ($isPost && isset($_POST["employee_id"]))
				$arKeys[] = $_POST["employee_id"];
			elseif (isset($_GET["employee_id"]))
				$arKeys[] = $_GET["employee_id"];
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
			$this->employee_id->CurrentValue = $key;
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
		$this->employee_id->setDbValue($rs->fields('employee_id'));
		$this->first_name->setDbValue($rs->fields('first_name'));
		$this->last_name->setDbValue($rs->fields('last_name'));
		$this->first_title->setDbValue($rs->fields('first_title'));
		$this->last_title->setDbValue($rs->fields('last_title'));
		$this->init->setDbValue($rs->fields('init'));
		$this->tpt_lahir->setDbValue($rs->fields('tpt_lahir'));
		$this->tgl_lahir->setDbValue($rs->fields('tgl_lahir'));
		$this->jk->setDbValue($rs->fields('jk'));
		$this->kd_agama->setDbValue($rs->fields('kd_agama'));
		$this->tgl_masuk->setDbValue($rs->fields('tgl_masuk'));
		$this->tpt_masuk->setDbValue($rs->fields('tpt_masuk'));
		$this->stkel->setDbValue($rs->fields('stkel'));
		$this->alamat->setDbValue($rs->fields('alamat'));
		$this->kota->setDbValue($rs->fields('kota'));
		$this->kd_pos->setDbValue($rs->fields('kd_pos'));
		$this->kd_propinsi->setDbValue($rs->fields('kd_propinsi'));
		$this->telp->setDbValue($rs->fields('telp'));
		$this->telp_area->setDbValue($rs->fields('telp_area'));
		$this->hp->setDbValue($rs->fields('hp'));
		$this->alamat_dom->setDbValue($rs->fields('alamat_dom'));
		$this->kota_dom->setDbValue($rs->fields('kota_dom'));
		$this->kd_pos_dom->setDbValue($rs->fields('kd_pos_dom'));
		$this->kd_propinsi_dom->setDbValue($rs->fields('kd_propinsi_dom'));
		$this->telp_dom->setDbValue($rs->fields('telp_dom'));
		$this->telp_dom_area->setDbValue($rs->fields('telp_dom_area'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->kd_st_emp->setDbValue($rs->fields('kd_st_emp'));
		$this->skala->setDbValue($rs->fields('skala'));
		$this->gp->setDbValue($rs->fields('gp'));
		$this->upah_tetap->setDbValue($rs->fields('upah_tetap'));
		$this->tgl_honor->setDbValue($rs->fields('tgl_honor'));
		$this->honor->setDbValue($rs->fields('honor'));
		$this->premi_honor->setDbValue($rs->fields('premi_honor'));
		$this->tgl_gp->setDbValue($rs->fields('tgl_gp'));
		$this->skala_95->setDbValue($rs->fields('skala_95'));
		$this->gp_95->setDbValue($rs->fields('gp_95'));
		$this->tgl_gp_95->setDbValue($rs->fields('tgl_gp_95'));
		$this->kd_indx->setDbValue($rs->fields('kd_indx'));
		$this->indx_lok->setDbValue($rs->fields('indx_lok'));
		$this->gol_darah->setDbValue($rs->fields('gol_darah'));
		$this->kd_jbt->setDbValue($rs->fields('kd_jbt'));
		$this->tgl_kd_jbt->setDbValue($rs->fields('tgl_kd_jbt'));
		$this->kd_jbt_pgs->setDbValue($rs->fields('kd_jbt_pgs'));
		$this->tgl_kd_jbt_pgs->setDbValue($rs->fields('tgl_kd_jbt_pgs'));
		$this->kd_jbt_pjs->setDbValue($rs->fields('kd_jbt_pjs'));
		$this->tgl_kd_jbt_pjs->setDbValue($rs->fields('tgl_kd_jbt_pjs'));
		$this->kd_jbt_ps->setDbValue($rs->fields('kd_jbt_ps'));
		$this->tgl_kd_jbt_ps->setDbValue($rs->fields('tgl_kd_jbt_ps'));
		$this->kd_pat->setDbValue($rs->fields('kd_pat'));
		$this->kd_gas->setDbValue($rs->fields('kd_gas'));
		$this->pimp_empid->setDbValue($rs->fields('pimp_empid'));
		$this->stshift->setDbValue($rs->fields('stshift'));
		$this->no_rek->setDbValue($rs->fields('no_rek'));
		$this->kd_bank->setDbValue($rs->fields('kd_bank'));
		$this->kd_jamsostek->setDbValue($rs->fields('kd_jamsostek'));
		$this->acc_astek->setDbValue($rs->fields('acc_astek'));
		$this->acc_dapens->setDbValue($rs->fields('acc_dapens'));
		$this->acc_kes->setDbValue($rs->fields('acc_kes'));
		$this->st->setDbValue($rs->fields('st'));
		$this->signature->Upload->DbValue = $rs->fields('signature');
		$this->created_by->setDbValue($rs->fields('created_by'));
		$this->created_date->setDbValue($rs->fields('created_date'));
		$this->last_update_by->setDbValue($rs->fields('last_update_by'));
		$this->last_update_date->setDbValue($rs->fields('last_update_date'));
		$this->fgr_print_id->setDbValue($rs->fields('fgr_print_id'));
		$this->kd_jbt_eselon->setDbValue($rs->fields('kd_jbt_eselon'));
		$this->npwp->setDbValue($rs->fields('npwp'));
		$this->paraf->Upload->DbValue = $rs->fields('paraf');
		$this->tgl_keluar->setDbValue($rs->fields('tgl_keluar'));
		$this->nama_nasabah->setDbValue($rs->fields('nama_nasabah'));
		$this->no_ktp->setDbValue($rs->fields('no_ktp'));
		$this->no_kokar->setDbValue($rs->fields('no_kokar'));
		$this->no_bmw->setDbValue($rs->fields('no_bmw'));
		$this->no_bpjs_ketenagakerjaan->setDbValue($rs->fields('no_bpjs_ketenagakerjaan'));
		$this->no_bpjs_kesehatan->setDbValue($rs->fields('no_bpjs_kesehatan'));
		$this->eselon->setDbValue($rs->fields('eselon'));
		$this->kd_jenjang->setDbValue($rs->fields('kd_jenjang'));
		$this->kd_jbt_esl->setDbValue($rs->fields('kd_jbt_esl'));
		$this->tgl_jbt_esl->setDbValue($rs->fields('tgl_jbt_esl'));
		$this->org_id->setDbValue($rs->fields('org_id'));
		$this->picture->Upload->DbValue = $rs->fields('picture');
		$this->kd_payroll->setDbValue($rs->fields('kd_payroll'));
		$this->id_wn->setDbValue($rs->fields('id_wn'));
		$this->no_anggota_kkms->setDbValue($rs->fields('no_anggota_kkms'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// employee_id
		// first_name
		// last_name
		// first_title
		// last_title
		// init
		// tpt_lahir
		// tgl_lahir
		// jk
		// kd_agama
		// tgl_masuk
		// tpt_masuk
		// stkel
		// alamat
		// kota
		// kd_pos
		// kd_propinsi
		// telp
		// telp_area
		// hp
		// alamat_dom
		// kota_dom
		// kd_pos_dom
		// kd_propinsi_dom
		// telp_dom
		// telp_dom_area
		// email
		// kd_st_emp
		// skala
		// gp
		// upah_tetap
		// tgl_honor
		// honor
		// premi_honor
		// tgl_gp
		// skala_95
		// gp_95
		// tgl_gp_95
		// kd_indx
		// indx_lok
		// gol_darah
		// kd_jbt
		// tgl_kd_jbt
		// kd_jbt_pgs
		// tgl_kd_jbt_pgs
		// kd_jbt_pjs
		// tgl_kd_jbt_pjs
		// kd_jbt_ps
		// tgl_kd_jbt_ps
		// kd_pat
		// kd_gas
		// pimp_empid
		// stshift
		// no_rek
		// kd_bank
		// kd_jamsostek
		// acc_astek
		// acc_dapens
		// acc_kes
		// st
		// signature
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// fgr_print_id
		// kd_jbt_eselon
		// npwp
		// paraf
		// tgl_keluar
		// nama_nasabah
		// no_ktp
		// no_kokar
		// no_bmw
		// no_bpjs_ketenagakerjaan
		// no_bpjs_kesehatan
		// eselon
		// kd_jenjang
		// kd_jbt_esl
		// tgl_jbt_esl
		// org_id
		// picture
		// kd_payroll
		// id_wn
		// no_anggota_kkms
		// employee_id

		$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
		$this->employee_id->ViewCustomAttributes = "";

		// first_name
		$this->first_name->ViewValue = $this->first_name->CurrentValue;
		$this->first_name->ViewCustomAttributes = "";

		// last_name
		$this->last_name->ViewValue = $this->last_name->CurrentValue;
		$this->last_name->ViewCustomAttributes = "";

		// first_title
		$this->first_title->ViewValue = $this->first_title->CurrentValue;
		$this->first_title->ViewCustomAttributes = "";

		// last_title
		$this->last_title->ViewValue = $this->last_title->CurrentValue;
		$this->last_title->ViewCustomAttributes = "";

		// init
		$this->init->ViewValue = $this->init->CurrentValue;
		$this->init->ViewCustomAttributes = "";

		// tpt_lahir
		$this->tpt_lahir->ViewValue = $this->tpt_lahir->CurrentValue;
		$this->tpt_lahir->ViewCustomAttributes = "";

		// tgl_lahir
		$this->tgl_lahir->ViewValue = $this->tgl_lahir->CurrentValue;
		$this->tgl_lahir->ViewValue = ew_FormatDateTime($this->tgl_lahir->ViewValue, 0);
		$this->tgl_lahir->ViewCustomAttributes = "";

		// jk
		$this->jk->ViewValue = $this->jk->CurrentValue;
		$this->jk->ViewCustomAttributes = "";

		// kd_agama
		$this->kd_agama->ViewValue = $this->kd_agama->CurrentValue;
		$this->kd_agama->ViewCustomAttributes = "";

		// tgl_masuk
		$this->tgl_masuk->ViewValue = $this->tgl_masuk->CurrentValue;
		$this->tgl_masuk->ViewValue = ew_FormatDateTime($this->tgl_masuk->ViewValue, 0);
		$this->tgl_masuk->ViewCustomAttributes = "";

		// tpt_masuk
		$this->tpt_masuk->ViewValue = $this->tpt_masuk->CurrentValue;
		$this->tpt_masuk->ViewCustomAttributes = "";

		// stkel
		$this->stkel->ViewValue = $this->stkel->CurrentValue;
		$this->stkel->ViewCustomAttributes = "";

		// alamat
		$this->alamat->ViewValue = $this->alamat->CurrentValue;
		$this->alamat->ViewCustomAttributes = "";

		// kota
		$this->kota->ViewValue = $this->kota->CurrentValue;
		$this->kota->ViewCustomAttributes = "";

		// kd_pos
		$this->kd_pos->ViewValue = $this->kd_pos->CurrentValue;
		$this->kd_pos->ViewCustomAttributes = "";

		// kd_propinsi
		$this->kd_propinsi->ViewValue = $this->kd_propinsi->CurrentValue;
		$this->kd_propinsi->ViewCustomAttributes = "";

		// telp
		$this->telp->ViewValue = $this->telp->CurrentValue;
		$this->telp->ViewCustomAttributes = "";

		// telp_area
		$this->telp_area->ViewValue = $this->telp_area->CurrentValue;
		$this->telp_area->ViewCustomAttributes = "";

		// hp
		$this->hp->ViewValue = $this->hp->CurrentValue;
		$this->hp->ViewCustomAttributes = "";

		// alamat_dom
		$this->alamat_dom->ViewValue = $this->alamat_dom->CurrentValue;
		$this->alamat_dom->ViewCustomAttributes = "";

		// kota_dom
		$this->kota_dom->ViewValue = $this->kota_dom->CurrentValue;
		$this->kota_dom->ViewCustomAttributes = "";

		// kd_pos_dom
		$this->kd_pos_dom->ViewValue = $this->kd_pos_dom->CurrentValue;
		$this->kd_pos_dom->ViewCustomAttributes = "";

		// kd_propinsi_dom
		$this->kd_propinsi_dom->ViewValue = $this->kd_propinsi_dom->CurrentValue;
		$this->kd_propinsi_dom->ViewCustomAttributes = "";

		// telp_dom
		$this->telp_dom->ViewValue = $this->telp_dom->CurrentValue;
		$this->telp_dom->ViewCustomAttributes = "";

		// telp_dom_area
		$this->telp_dom_area->ViewValue = $this->telp_dom_area->CurrentValue;
		$this->telp_dom_area->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// kd_st_emp
		$this->kd_st_emp->ViewValue = $this->kd_st_emp->CurrentValue;
		$this->kd_st_emp->ViewCustomAttributes = "";

		// skala
		$this->skala->ViewValue = $this->skala->CurrentValue;
		$this->skala->ViewCustomAttributes = "";

		// gp
		$this->gp->ViewValue = $this->gp->CurrentValue;
		$this->gp->ViewCustomAttributes = "";

		// upah_tetap
		$this->upah_tetap->ViewValue = $this->upah_tetap->CurrentValue;
		$this->upah_tetap->ViewCustomAttributes = "";

		// tgl_honor
		$this->tgl_honor->ViewValue = $this->tgl_honor->CurrentValue;
		$this->tgl_honor->ViewValue = ew_FormatDateTime($this->tgl_honor->ViewValue, 0);
		$this->tgl_honor->ViewCustomAttributes = "";

		// honor
		$this->honor->ViewValue = $this->honor->CurrentValue;
		$this->honor->ViewCustomAttributes = "";

		// premi_honor
		$this->premi_honor->ViewValue = $this->premi_honor->CurrentValue;
		$this->premi_honor->ViewCustomAttributes = "";

		// tgl_gp
		$this->tgl_gp->ViewValue = $this->tgl_gp->CurrentValue;
		$this->tgl_gp->ViewValue = ew_FormatDateTime($this->tgl_gp->ViewValue, 0);
		$this->tgl_gp->ViewCustomAttributes = "";

		// skala_95
		$this->skala_95->ViewValue = $this->skala_95->CurrentValue;
		$this->skala_95->ViewCustomAttributes = "";

		// gp_95
		$this->gp_95->ViewValue = $this->gp_95->CurrentValue;
		$this->gp_95->ViewCustomAttributes = "";

		// tgl_gp_95
		$this->tgl_gp_95->ViewValue = $this->tgl_gp_95->CurrentValue;
		$this->tgl_gp_95->ViewValue = ew_FormatDateTime($this->tgl_gp_95->ViewValue, 0);
		$this->tgl_gp_95->ViewCustomAttributes = "";

		// kd_indx
		$this->kd_indx->ViewValue = $this->kd_indx->CurrentValue;
		$this->kd_indx->ViewCustomAttributes = "";

		// indx_lok
		$this->indx_lok->ViewValue = $this->indx_lok->CurrentValue;
		$this->indx_lok->ViewCustomAttributes = "";

		// gol_darah
		$this->gol_darah->ViewValue = $this->gol_darah->CurrentValue;
		$this->gol_darah->ViewCustomAttributes = "";

		// kd_jbt
		$this->kd_jbt->ViewValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// tgl_kd_jbt
		$this->tgl_kd_jbt->ViewValue = $this->tgl_kd_jbt->CurrentValue;
		$this->tgl_kd_jbt->ViewValue = ew_FormatDateTime($this->tgl_kd_jbt->ViewValue, 0);
		$this->tgl_kd_jbt->ViewCustomAttributes = "";

		// kd_jbt_pgs
		$this->kd_jbt_pgs->ViewValue = $this->kd_jbt_pgs->CurrentValue;
		$this->kd_jbt_pgs->ViewCustomAttributes = "";

		// tgl_kd_jbt_pgs
		$this->tgl_kd_jbt_pgs->ViewValue = $this->tgl_kd_jbt_pgs->CurrentValue;
		$this->tgl_kd_jbt_pgs->ViewValue = ew_FormatDateTime($this->tgl_kd_jbt_pgs->ViewValue, 0);
		$this->tgl_kd_jbt_pgs->ViewCustomAttributes = "";

		// kd_jbt_pjs
		$this->kd_jbt_pjs->ViewValue = $this->kd_jbt_pjs->CurrentValue;
		$this->kd_jbt_pjs->ViewCustomAttributes = "";

		// tgl_kd_jbt_pjs
		$this->tgl_kd_jbt_pjs->ViewValue = $this->tgl_kd_jbt_pjs->CurrentValue;
		$this->tgl_kd_jbt_pjs->ViewValue = ew_FormatDateTime($this->tgl_kd_jbt_pjs->ViewValue, 0);
		$this->tgl_kd_jbt_pjs->ViewCustomAttributes = "";

		// kd_jbt_ps
		$this->kd_jbt_ps->ViewValue = $this->kd_jbt_ps->CurrentValue;
		$this->kd_jbt_ps->ViewCustomAttributes = "";

		// tgl_kd_jbt_ps
		$this->tgl_kd_jbt_ps->ViewValue = $this->tgl_kd_jbt_ps->CurrentValue;
		$this->tgl_kd_jbt_ps->ViewValue = ew_FormatDateTime($this->tgl_kd_jbt_ps->ViewValue, 0);
		$this->tgl_kd_jbt_ps->ViewCustomAttributes = "";

		// kd_pat
		$this->kd_pat->ViewValue = $this->kd_pat->CurrentValue;
		$this->kd_pat->ViewCustomAttributes = "";

		// kd_gas
		$this->kd_gas->ViewValue = $this->kd_gas->CurrentValue;
		$this->kd_gas->ViewCustomAttributes = "";

		// pimp_empid
		$this->pimp_empid->ViewValue = $this->pimp_empid->CurrentValue;
		$this->pimp_empid->ViewCustomAttributes = "";

		// stshift
		$this->stshift->ViewValue = $this->stshift->CurrentValue;
		$this->stshift->ViewCustomAttributes = "";

		// no_rek
		$this->no_rek->ViewValue = $this->no_rek->CurrentValue;
		$this->no_rek->ViewCustomAttributes = "";

		// kd_bank
		$this->kd_bank->ViewValue = $this->kd_bank->CurrentValue;
		$this->kd_bank->ViewCustomAttributes = "";

		// kd_jamsostek
		$this->kd_jamsostek->ViewValue = $this->kd_jamsostek->CurrentValue;
		$this->kd_jamsostek->ViewCustomAttributes = "";

		// acc_astek
		$this->acc_astek->ViewValue = $this->acc_astek->CurrentValue;
		$this->acc_astek->ViewCustomAttributes = "";

		// acc_dapens
		$this->acc_dapens->ViewValue = $this->acc_dapens->CurrentValue;
		$this->acc_dapens->ViewCustomAttributes = "";

		// acc_kes
		$this->acc_kes->ViewValue = $this->acc_kes->CurrentValue;
		$this->acc_kes->ViewCustomAttributes = "";

		// st
		$this->st->ViewValue = $this->st->CurrentValue;
		$this->st->ViewCustomAttributes = "";

		// signature
		if (!ew_Empty($this->signature->Upload->DbValue)) {
			$this->signature->ViewValue = "personal_signature_bv.php?" . "employee_id=" . $this->employee_id->CurrentValue;
			$this->signature->IsBlobImage = ew_IsImageFile(ew_ContentExt(substr($this->signature->Upload->DbValue, 0, 11)));
		} else {
			$this->signature->ViewValue = "";
		}
		$this->signature->ViewCustomAttributes = "";

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

		// fgr_print_id
		$this->fgr_print_id->ViewValue = $this->fgr_print_id->CurrentValue;
		$this->fgr_print_id->ViewCustomAttributes = "";

		// kd_jbt_eselon
		$this->kd_jbt_eselon->ViewValue = $this->kd_jbt_eselon->CurrentValue;
		$this->kd_jbt_eselon->ViewCustomAttributes = "";

		// npwp
		$this->npwp->ViewValue = $this->npwp->CurrentValue;
		$this->npwp->ViewCustomAttributes = "";

		// paraf
		if (!ew_Empty($this->paraf->Upload->DbValue)) {
			$this->paraf->ViewValue = "personal_paraf_bv.php?" . "employee_id=" . $this->employee_id->CurrentValue;
			$this->paraf->IsBlobImage = ew_IsImageFile(ew_ContentExt(substr($this->paraf->Upload->DbValue, 0, 11)));
		} else {
			$this->paraf->ViewValue = "";
		}
		$this->paraf->ViewCustomAttributes = "";

		// tgl_keluar
		$this->tgl_keluar->ViewValue = $this->tgl_keluar->CurrentValue;
		$this->tgl_keluar->ViewValue = ew_FormatDateTime($this->tgl_keluar->ViewValue, 0);
		$this->tgl_keluar->ViewCustomAttributes = "";

		// nama_nasabah
		$this->nama_nasabah->ViewValue = $this->nama_nasabah->CurrentValue;
		$this->nama_nasabah->ViewCustomAttributes = "";

		// no_ktp
		$this->no_ktp->ViewValue = $this->no_ktp->CurrentValue;
		$this->no_ktp->ViewCustomAttributes = "";

		// no_kokar
		$this->no_kokar->ViewValue = $this->no_kokar->CurrentValue;
		$this->no_kokar->ViewCustomAttributes = "";

		// no_bmw
		$this->no_bmw->ViewValue = $this->no_bmw->CurrentValue;
		$this->no_bmw->ViewCustomAttributes = "";

		// no_bpjs_ketenagakerjaan
		$this->no_bpjs_ketenagakerjaan->ViewValue = $this->no_bpjs_ketenagakerjaan->CurrentValue;
		$this->no_bpjs_ketenagakerjaan->ViewCustomAttributes = "";

		// no_bpjs_kesehatan
		$this->no_bpjs_kesehatan->ViewValue = $this->no_bpjs_kesehatan->CurrentValue;
		$this->no_bpjs_kesehatan->ViewCustomAttributes = "";

		// eselon
		$this->eselon->ViewValue = $this->eselon->CurrentValue;
		$this->eselon->ViewCustomAttributes = "";

		// kd_jenjang
		$this->kd_jenjang->ViewValue = $this->kd_jenjang->CurrentValue;
		$this->kd_jenjang->ViewCustomAttributes = "";

		// kd_jbt_esl
		$this->kd_jbt_esl->ViewValue = $this->kd_jbt_esl->CurrentValue;
		$this->kd_jbt_esl->ViewCustomAttributes = "";

		// tgl_jbt_esl
		$this->tgl_jbt_esl->ViewValue = $this->tgl_jbt_esl->CurrentValue;
		$this->tgl_jbt_esl->ViewValue = ew_FormatDateTime($this->tgl_jbt_esl->ViewValue, 0);
		$this->tgl_jbt_esl->ViewCustomAttributes = "";

		// org_id
		$this->org_id->ViewValue = $this->org_id->CurrentValue;
		$this->org_id->ViewCustomAttributes = "";

		// picture
		if (!ew_Empty($this->picture->Upload->DbValue)) {
			$this->picture->ViewValue = "personal_picture_bv.php?" . "employee_id=" . $this->employee_id->CurrentValue;
			$this->picture->IsBlobImage = ew_IsImageFile(ew_ContentExt(substr($this->picture->Upload->DbValue, 0, 11)));
		} else {
			$this->picture->ViewValue = "";
		}
		$this->picture->ViewCustomAttributes = "";

		// kd_payroll
		$this->kd_payroll->ViewValue = $this->kd_payroll->CurrentValue;
		$this->kd_payroll->ViewCustomAttributes = "";

		// id_wn
		$this->id_wn->ViewValue = $this->id_wn->CurrentValue;
		$this->id_wn->ViewCustomAttributes = "";

		// no_anggota_kkms
		$this->no_anggota_kkms->ViewValue = $this->no_anggota_kkms->CurrentValue;
		$this->no_anggota_kkms->ViewCustomAttributes = "";

		// employee_id
		$this->employee_id->LinkCustomAttributes = "";
		$this->employee_id->HrefValue = "";
		$this->employee_id->TooltipValue = "";

		// first_name
		$this->first_name->LinkCustomAttributes = "";
		$this->first_name->HrefValue = "";
		$this->first_name->TooltipValue = "";

		// last_name
		$this->last_name->LinkCustomAttributes = "";
		$this->last_name->HrefValue = "";
		$this->last_name->TooltipValue = "";

		// first_title
		$this->first_title->LinkCustomAttributes = "";
		$this->first_title->HrefValue = "";
		$this->first_title->TooltipValue = "";

		// last_title
		$this->last_title->LinkCustomAttributes = "";
		$this->last_title->HrefValue = "";
		$this->last_title->TooltipValue = "";

		// init
		$this->init->LinkCustomAttributes = "";
		$this->init->HrefValue = "";
		$this->init->TooltipValue = "";

		// tpt_lahir
		$this->tpt_lahir->LinkCustomAttributes = "";
		$this->tpt_lahir->HrefValue = "";
		$this->tpt_lahir->TooltipValue = "";

		// tgl_lahir
		$this->tgl_lahir->LinkCustomAttributes = "";
		$this->tgl_lahir->HrefValue = "";
		$this->tgl_lahir->TooltipValue = "";

		// jk
		$this->jk->LinkCustomAttributes = "";
		$this->jk->HrefValue = "";
		$this->jk->TooltipValue = "";

		// kd_agama
		$this->kd_agama->LinkCustomAttributes = "";
		$this->kd_agama->HrefValue = "";
		$this->kd_agama->TooltipValue = "";

		// tgl_masuk
		$this->tgl_masuk->LinkCustomAttributes = "";
		$this->tgl_masuk->HrefValue = "";
		$this->tgl_masuk->TooltipValue = "";

		// tpt_masuk
		$this->tpt_masuk->LinkCustomAttributes = "";
		$this->tpt_masuk->HrefValue = "";
		$this->tpt_masuk->TooltipValue = "";

		// stkel
		$this->stkel->LinkCustomAttributes = "";
		$this->stkel->HrefValue = "";
		$this->stkel->TooltipValue = "";

		// alamat
		$this->alamat->LinkCustomAttributes = "";
		$this->alamat->HrefValue = "";
		$this->alamat->TooltipValue = "";

		// kota
		$this->kota->LinkCustomAttributes = "";
		$this->kota->HrefValue = "";
		$this->kota->TooltipValue = "";

		// kd_pos
		$this->kd_pos->LinkCustomAttributes = "";
		$this->kd_pos->HrefValue = "";
		$this->kd_pos->TooltipValue = "";

		// kd_propinsi
		$this->kd_propinsi->LinkCustomAttributes = "";
		$this->kd_propinsi->HrefValue = "";
		$this->kd_propinsi->TooltipValue = "";

		// telp
		$this->telp->LinkCustomAttributes = "";
		$this->telp->HrefValue = "";
		$this->telp->TooltipValue = "";

		// telp_area
		$this->telp_area->LinkCustomAttributes = "";
		$this->telp_area->HrefValue = "";
		$this->telp_area->TooltipValue = "";

		// hp
		$this->hp->LinkCustomAttributes = "";
		$this->hp->HrefValue = "";
		$this->hp->TooltipValue = "";

		// alamat_dom
		$this->alamat_dom->LinkCustomAttributes = "";
		$this->alamat_dom->HrefValue = "";
		$this->alamat_dom->TooltipValue = "";

		// kota_dom
		$this->kota_dom->LinkCustomAttributes = "";
		$this->kota_dom->HrefValue = "";
		$this->kota_dom->TooltipValue = "";

		// kd_pos_dom
		$this->kd_pos_dom->LinkCustomAttributes = "";
		$this->kd_pos_dom->HrefValue = "";
		$this->kd_pos_dom->TooltipValue = "";

		// kd_propinsi_dom
		$this->kd_propinsi_dom->LinkCustomAttributes = "";
		$this->kd_propinsi_dom->HrefValue = "";
		$this->kd_propinsi_dom->TooltipValue = "";

		// telp_dom
		$this->telp_dom->LinkCustomAttributes = "";
		$this->telp_dom->HrefValue = "";
		$this->telp_dom->TooltipValue = "";

		// telp_dom_area
		$this->telp_dom_area->LinkCustomAttributes = "";
		$this->telp_dom_area->HrefValue = "";
		$this->telp_dom_area->TooltipValue = "";

		// email
		$this->_email->LinkCustomAttributes = "";
		$this->_email->HrefValue = "";
		$this->_email->TooltipValue = "";

		// kd_st_emp
		$this->kd_st_emp->LinkCustomAttributes = "";
		$this->kd_st_emp->HrefValue = "";
		$this->kd_st_emp->TooltipValue = "";

		// skala
		$this->skala->LinkCustomAttributes = "";
		$this->skala->HrefValue = "";
		$this->skala->TooltipValue = "";

		// gp
		$this->gp->LinkCustomAttributes = "";
		$this->gp->HrefValue = "";
		$this->gp->TooltipValue = "";

		// upah_tetap
		$this->upah_tetap->LinkCustomAttributes = "";
		$this->upah_tetap->HrefValue = "";
		$this->upah_tetap->TooltipValue = "";

		// tgl_honor
		$this->tgl_honor->LinkCustomAttributes = "";
		$this->tgl_honor->HrefValue = "";
		$this->tgl_honor->TooltipValue = "";

		// honor
		$this->honor->LinkCustomAttributes = "";
		$this->honor->HrefValue = "";
		$this->honor->TooltipValue = "";

		// premi_honor
		$this->premi_honor->LinkCustomAttributes = "";
		$this->premi_honor->HrefValue = "";
		$this->premi_honor->TooltipValue = "";

		// tgl_gp
		$this->tgl_gp->LinkCustomAttributes = "";
		$this->tgl_gp->HrefValue = "";
		$this->tgl_gp->TooltipValue = "";

		// skala_95
		$this->skala_95->LinkCustomAttributes = "";
		$this->skala_95->HrefValue = "";
		$this->skala_95->TooltipValue = "";

		// gp_95
		$this->gp_95->LinkCustomAttributes = "";
		$this->gp_95->HrefValue = "";
		$this->gp_95->TooltipValue = "";

		// tgl_gp_95
		$this->tgl_gp_95->LinkCustomAttributes = "";
		$this->tgl_gp_95->HrefValue = "";
		$this->tgl_gp_95->TooltipValue = "";

		// kd_indx
		$this->kd_indx->LinkCustomAttributes = "";
		$this->kd_indx->HrefValue = "";
		$this->kd_indx->TooltipValue = "";

		// indx_lok
		$this->indx_lok->LinkCustomAttributes = "";
		$this->indx_lok->HrefValue = "";
		$this->indx_lok->TooltipValue = "";

		// gol_darah
		$this->gol_darah->LinkCustomAttributes = "";
		$this->gol_darah->HrefValue = "";
		$this->gol_darah->TooltipValue = "";

		// kd_jbt
		$this->kd_jbt->LinkCustomAttributes = "";
		$this->kd_jbt->HrefValue = "";
		$this->kd_jbt->TooltipValue = "";

		// tgl_kd_jbt
		$this->tgl_kd_jbt->LinkCustomAttributes = "";
		$this->tgl_kd_jbt->HrefValue = "";
		$this->tgl_kd_jbt->TooltipValue = "";

		// kd_jbt_pgs
		$this->kd_jbt_pgs->LinkCustomAttributes = "";
		$this->kd_jbt_pgs->HrefValue = "";
		$this->kd_jbt_pgs->TooltipValue = "";

		// tgl_kd_jbt_pgs
		$this->tgl_kd_jbt_pgs->LinkCustomAttributes = "";
		$this->tgl_kd_jbt_pgs->HrefValue = "";
		$this->tgl_kd_jbt_pgs->TooltipValue = "";

		// kd_jbt_pjs
		$this->kd_jbt_pjs->LinkCustomAttributes = "";
		$this->kd_jbt_pjs->HrefValue = "";
		$this->kd_jbt_pjs->TooltipValue = "";

		// tgl_kd_jbt_pjs
		$this->tgl_kd_jbt_pjs->LinkCustomAttributes = "";
		$this->tgl_kd_jbt_pjs->HrefValue = "";
		$this->tgl_kd_jbt_pjs->TooltipValue = "";

		// kd_jbt_ps
		$this->kd_jbt_ps->LinkCustomAttributes = "";
		$this->kd_jbt_ps->HrefValue = "";
		$this->kd_jbt_ps->TooltipValue = "";

		// tgl_kd_jbt_ps
		$this->tgl_kd_jbt_ps->LinkCustomAttributes = "";
		$this->tgl_kd_jbt_ps->HrefValue = "";
		$this->tgl_kd_jbt_ps->TooltipValue = "";

		// kd_pat
		$this->kd_pat->LinkCustomAttributes = "";
		$this->kd_pat->HrefValue = "";
		$this->kd_pat->TooltipValue = "";

		// kd_gas
		$this->kd_gas->LinkCustomAttributes = "";
		$this->kd_gas->HrefValue = "";
		$this->kd_gas->TooltipValue = "";

		// pimp_empid
		$this->pimp_empid->LinkCustomAttributes = "";
		$this->pimp_empid->HrefValue = "";
		$this->pimp_empid->TooltipValue = "";

		// stshift
		$this->stshift->LinkCustomAttributes = "";
		$this->stshift->HrefValue = "";
		$this->stshift->TooltipValue = "";

		// no_rek
		$this->no_rek->LinkCustomAttributes = "";
		$this->no_rek->HrefValue = "";
		$this->no_rek->TooltipValue = "";

		// kd_bank
		$this->kd_bank->LinkCustomAttributes = "";
		$this->kd_bank->HrefValue = "";
		$this->kd_bank->TooltipValue = "";

		// kd_jamsostek
		$this->kd_jamsostek->LinkCustomAttributes = "";
		$this->kd_jamsostek->HrefValue = "";
		$this->kd_jamsostek->TooltipValue = "";

		// acc_astek
		$this->acc_astek->LinkCustomAttributes = "";
		$this->acc_astek->HrefValue = "";
		$this->acc_astek->TooltipValue = "";

		// acc_dapens
		$this->acc_dapens->LinkCustomAttributes = "";
		$this->acc_dapens->HrefValue = "";
		$this->acc_dapens->TooltipValue = "";

		// acc_kes
		$this->acc_kes->LinkCustomAttributes = "";
		$this->acc_kes->HrefValue = "";
		$this->acc_kes->TooltipValue = "";

		// st
		$this->st->LinkCustomAttributes = "";
		$this->st->HrefValue = "";
		$this->st->TooltipValue = "";

		// signature
		$this->signature->LinkCustomAttributes = "";
		if (!empty($this->signature->Upload->DbValue)) {
			$this->signature->HrefValue = "personal_signature_bv.php?employee_id=" . $this->employee_id->CurrentValue;
			$this->signature->LinkAttrs["target"] = "_blank";
			if ($this->Export <> "") $this->signature->HrefValue = ew_FullUrl($this->signature->HrefValue, "href");
		} else {
			$this->signature->HrefValue = "";
		}
		$this->signature->HrefValue2 = "personal_signature_bv.php?employee_id=" . $this->employee_id->CurrentValue;
		$this->signature->TooltipValue = "";

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

		// fgr_print_id
		$this->fgr_print_id->LinkCustomAttributes = "";
		$this->fgr_print_id->HrefValue = "";
		$this->fgr_print_id->TooltipValue = "";

		// kd_jbt_eselon
		$this->kd_jbt_eselon->LinkCustomAttributes = "";
		$this->kd_jbt_eselon->HrefValue = "";
		$this->kd_jbt_eselon->TooltipValue = "";

		// npwp
		$this->npwp->LinkCustomAttributes = "";
		$this->npwp->HrefValue = "";
		$this->npwp->TooltipValue = "";

		// paraf
		$this->paraf->LinkCustomAttributes = "";
		if (!empty($this->paraf->Upload->DbValue)) {
			$this->paraf->HrefValue = "personal_paraf_bv.php?employee_id=" . $this->employee_id->CurrentValue;
			$this->paraf->LinkAttrs["target"] = "_blank";
			if ($this->Export <> "") $this->paraf->HrefValue = ew_FullUrl($this->paraf->HrefValue, "href");
		} else {
			$this->paraf->HrefValue = "";
		}
		$this->paraf->HrefValue2 = "personal_paraf_bv.php?employee_id=" . $this->employee_id->CurrentValue;
		$this->paraf->TooltipValue = "";

		// tgl_keluar
		$this->tgl_keluar->LinkCustomAttributes = "";
		$this->tgl_keluar->HrefValue = "";
		$this->tgl_keluar->TooltipValue = "";

		// nama_nasabah
		$this->nama_nasabah->LinkCustomAttributes = "";
		$this->nama_nasabah->HrefValue = "";
		$this->nama_nasabah->TooltipValue = "";

		// no_ktp
		$this->no_ktp->LinkCustomAttributes = "";
		$this->no_ktp->HrefValue = "";
		$this->no_ktp->TooltipValue = "";

		// no_kokar
		$this->no_kokar->LinkCustomAttributes = "";
		$this->no_kokar->HrefValue = "";
		$this->no_kokar->TooltipValue = "";

		// no_bmw
		$this->no_bmw->LinkCustomAttributes = "";
		$this->no_bmw->HrefValue = "";
		$this->no_bmw->TooltipValue = "";

		// no_bpjs_ketenagakerjaan
		$this->no_bpjs_ketenagakerjaan->LinkCustomAttributes = "";
		$this->no_bpjs_ketenagakerjaan->HrefValue = "";
		$this->no_bpjs_ketenagakerjaan->TooltipValue = "";

		// no_bpjs_kesehatan
		$this->no_bpjs_kesehatan->LinkCustomAttributes = "";
		$this->no_bpjs_kesehatan->HrefValue = "";
		$this->no_bpjs_kesehatan->TooltipValue = "";

		// eselon
		$this->eselon->LinkCustomAttributes = "";
		$this->eselon->HrefValue = "";
		$this->eselon->TooltipValue = "";

		// kd_jenjang
		$this->kd_jenjang->LinkCustomAttributes = "";
		$this->kd_jenjang->HrefValue = "";
		$this->kd_jenjang->TooltipValue = "";

		// kd_jbt_esl
		$this->kd_jbt_esl->LinkCustomAttributes = "";
		$this->kd_jbt_esl->HrefValue = "";
		$this->kd_jbt_esl->TooltipValue = "";

		// tgl_jbt_esl
		$this->tgl_jbt_esl->LinkCustomAttributes = "";
		$this->tgl_jbt_esl->HrefValue = "";
		$this->tgl_jbt_esl->TooltipValue = "";

		// org_id
		$this->org_id->LinkCustomAttributes = "";
		$this->org_id->HrefValue = "";
		$this->org_id->TooltipValue = "";

		// picture
		$this->picture->LinkCustomAttributes = "";
		if (!empty($this->picture->Upload->DbValue)) {
			$this->picture->HrefValue = "personal_picture_bv.php?employee_id=" . $this->employee_id->CurrentValue;
			$this->picture->LinkAttrs["target"] = "_blank";
			if ($this->Export <> "") $this->picture->HrefValue = ew_FullUrl($this->picture->HrefValue, "href");
		} else {
			$this->picture->HrefValue = "";
		}
		$this->picture->HrefValue2 = "personal_picture_bv.php?employee_id=" . $this->employee_id->CurrentValue;
		$this->picture->TooltipValue = "";

		// kd_payroll
		$this->kd_payroll->LinkCustomAttributes = "";
		$this->kd_payroll->HrefValue = "";
		$this->kd_payroll->TooltipValue = "";

		// id_wn
		$this->id_wn->LinkCustomAttributes = "";
		$this->id_wn->HrefValue = "";
		$this->id_wn->TooltipValue = "";

		// no_anggota_kkms
		$this->no_anggota_kkms->LinkCustomAttributes = "";
		$this->no_anggota_kkms->HrefValue = "";
		$this->no_anggota_kkms->TooltipValue = "";

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

		// employee_id
		$this->employee_id->EditAttrs["class"] = "form-control";
		$this->employee_id->EditCustomAttributes = "";
		$this->employee_id->EditValue = $this->employee_id->CurrentValue;
		$this->employee_id->ViewCustomAttributes = "";

		// first_name
		$this->first_name->EditAttrs["class"] = "form-control";
		$this->first_name->EditCustomAttributes = "";
		$this->first_name->EditValue = $this->first_name->CurrentValue;
		$this->first_name->PlaceHolder = ew_RemoveHtml($this->first_name->FldCaption());

		// last_name
		$this->last_name->EditAttrs["class"] = "form-control";
		$this->last_name->EditCustomAttributes = "";
		$this->last_name->EditValue = $this->last_name->CurrentValue;
		$this->last_name->PlaceHolder = ew_RemoveHtml($this->last_name->FldCaption());

		// first_title
		$this->first_title->EditAttrs["class"] = "form-control";
		$this->first_title->EditCustomAttributes = "";
		$this->first_title->EditValue = $this->first_title->CurrentValue;
		$this->first_title->PlaceHolder = ew_RemoveHtml($this->first_title->FldCaption());

		// last_title
		$this->last_title->EditAttrs["class"] = "form-control";
		$this->last_title->EditCustomAttributes = "";
		$this->last_title->EditValue = $this->last_title->CurrentValue;
		$this->last_title->PlaceHolder = ew_RemoveHtml($this->last_title->FldCaption());

		// init
		$this->init->EditAttrs["class"] = "form-control";
		$this->init->EditCustomAttributes = "";
		$this->init->EditValue = $this->init->CurrentValue;
		$this->init->PlaceHolder = ew_RemoveHtml($this->init->FldCaption());

		// tpt_lahir
		$this->tpt_lahir->EditAttrs["class"] = "form-control";
		$this->tpt_lahir->EditCustomAttributes = "";
		$this->tpt_lahir->EditValue = $this->tpt_lahir->CurrentValue;
		$this->tpt_lahir->PlaceHolder = ew_RemoveHtml($this->tpt_lahir->FldCaption());

		// tgl_lahir
		$this->tgl_lahir->EditAttrs["class"] = "form-control";
		$this->tgl_lahir->EditCustomAttributes = "";
		$this->tgl_lahir->EditValue = ew_FormatDateTime($this->tgl_lahir->CurrentValue, 8);
		$this->tgl_lahir->PlaceHolder = ew_RemoveHtml($this->tgl_lahir->FldCaption());

		// jk
		$this->jk->EditAttrs["class"] = "form-control";
		$this->jk->EditCustomAttributes = "";
		$this->jk->EditValue = $this->jk->CurrentValue;
		$this->jk->PlaceHolder = ew_RemoveHtml($this->jk->FldCaption());

		// kd_agama
		$this->kd_agama->EditAttrs["class"] = "form-control";
		$this->kd_agama->EditCustomAttributes = "";
		$this->kd_agama->EditValue = $this->kd_agama->CurrentValue;
		$this->kd_agama->PlaceHolder = ew_RemoveHtml($this->kd_agama->FldCaption());

		// tgl_masuk
		$this->tgl_masuk->EditAttrs["class"] = "form-control";
		$this->tgl_masuk->EditCustomAttributes = "";
		$this->tgl_masuk->EditValue = ew_FormatDateTime($this->tgl_masuk->CurrentValue, 8);
		$this->tgl_masuk->PlaceHolder = ew_RemoveHtml($this->tgl_masuk->FldCaption());

		// tpt_masuk
		$this->tpt_masuk->EditAttrs["class"] = "form-control";
		$this->tpt_masuk->EditCustomAttributes = "";
		$this->tpt_masuk->EditValue = $this->tpt_masuk->CurrentValue;
		$this->tpt_masuk->PlaceHolder = ew_RemoveHtml($this->tpt_masuk->FldCaption());

		// stkel
		$this->stkel->EditAttrs["class"] = "form-control";
		$this->stkel->EditCustomAttributes = "";
		$this->stkel->EditValue = $this->stkel->CurrentValue;
		$this->stkel->PlaceHolder = ew_RemoveHtml($this->stkel->FldCaption());

		// alamat
		$this->alamat->EditAttrs["class"] = "form-control";
		$this->alamat->EditCustomAttributes = "";
		$this->alamat->EditValue = $this->alamat->CurrentValue;
		$this->alamat->PlaceHolder = ew_RemoveHtml($this->alamat->FldCaption());

		// kota
		$this->kota->EditAttrs["class"] = "form-control";
		$this->kota->EditCustomAttributes = "";
		$this->kota->EditValue = $this->kota->CurrentValue;
		$this->kota->PlaceHolder = ew_RemoveHtml($this->kota->FldCaption());

		// kd_pos
		$this->kd_pos->EditAttrs["class"] = "form-control";
		$this->kd_pos->EditCustomAttributes = "";
		$this->kd_pos->EditValue = $this->kd_pos->CurrentValue;
		$this->kd_pos->PlaceHolder = ew_RemoveHtml($this->kd_pos->FldCaption());

		// kd_propinsi
		$this->kd_propinsi->EditAttrs["class"] = "form-control";
		$this->kd_propinsi->EditCustomAttributes = "";
		$this->kd_propinsi->EditValue = $this->kd_propinsi->CurrentValue;
		$this->kd_propinsi->PlaceHolder = ew_RemoveHtml($this->kd_propinsi->FldCaption());

		// telp
		$this->telp->EditAttrs["class"] = "form-control";
		$this->telp->EditCustomAttributes = "";
		$this->telp->EditValue = $this->telp->CurrentValue;
		$this->telp->PlaceHolder = ew_RemoveHtml($this->telp->FldCaption());

		// telp_area
		$this->telp_area->EditAttrs["class"] = "form-control";
		$this->telp_area->EditCustomAttributes = "";
		$this->telp_area->EditValue = $this->telp_area->CurrentValue;
		$this->telp_area->PlaceHolder = ew_RemoveHtml($this->telp_area->FldCaption());

		// hp
		$this->hp->EditAttrs["class"] = "form-control";
		$this->hp->EditCustomAttributes = "";
		$this->hp->EditValue = $this->hp->CurrentValue;
		$this->hp->PlaceHolder = ew_RemoveHtml($this->hp->FldCaption());

		// alamat_dom
		$this->alamat_dom->EditAttrs["class"] = "form-control";
		$this->alamat_dom->EditCustomAttributes = "";
		$this->alamat_dom->EditValue = $this->alamat_dom->CurrentValue;
		$this->alamat_dom->PlaceHolder = ew_RemoveHtml($this->alamat_dom->FldCaption());

		// kota_dom
		$this->kota_dom->EditAttrs["class"] = "form-control";
		$this->kota_dom->EditCustomAttributes = "";
		$this->kota_dom->EditValue = $this->kota_dom->CurrentValue;
		$this->kota_dom->PlaceHolder = ew_RemoveHtml($this->kota_dom->FldCaption());

		// kd_pos_dom
		$this->kd_pos_dom->EditAttrs["class"] = "form-control";
		$this->kd_pos_dom->EditCustomAttributes = "";
		$this->kd_pos_dom->EditValue = $this->kd_pos_dom->CurrentValue;
		$this->kd_pos_dom->PlaceHolder = ew_RemoveHtml($this->kd_pos_dom->FldCaption());

		// kd_propinsi_dom
		$this->kd_propinsi_dom->EditAttrs["class"] = "form-control";
		$this->kd_propinsi_dom->EditCustomAttributes = "";
		$this->kd_propinsi_dom->EditValue = $this->kd_propinsi_dom->CurrentValue;
		$this->kd_propinsi_dom->PlaceHolder = ew_RemoveHtml($this->kd_propinsi_dom->FldCaption());

		// telp_dom
		$this->telp_dom->EditAttrs["class"] = "form-control";
		$this->telp_dom->EditCustomAttributes = "";
		$this->telp_dom->EditValue = $this->telp_dom->CurrentValue;
		$this->telp_dom->PlaceHolder = ew_RemoveHtml($this->telp_dom->FldCaption());

		// telp_dom_area
		$this->telp_dom_area->EditAttrs["class"] = "form-control";
		$this->telp_dom_area->EditCustomAttributes = "";
		$this->telp_dom_area->EditValue = $this->telp_dom_area->CurrentValue;
		$this->telp_dom_area->PlaceHolder = ew_RemoveHtml($this->telp_dom_area->FldCaption());

		// email
		$this->_email->EditAttrs["class"] = "form-control";
		$this->_email->EditCustomAttributes = "";
		$this->_email->EditValue = $this->_email->CurrentValue;
		$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

		// kd_st_emp
		$this->kd_st_emp->EditAttrs["class"] = "form-control";
		$this->kd_st_emp->EditCustomAttributes = "";
		$this->kd_st_emp->EditValue = $this->kd_st_emp->CurrentValue;
		$this->kd_st_emp->PlaceHolder = ew_RemoveHtml($this->kd_st_emp->FldCaption());

		// skala
		$this->skala->EditAttrs["class"] = "form-control";
		$this->skala->EditCustomAttributes = "";
		$this->skala->EditValue = $this->skala->CurrentValue;
		$this->skala->PlaceHolder = ew_RemoveHtml($this->skala->FldCaption());

		// gp
		$this->gp->EditAttrs["class"] = "form-control";
		$this->gp->EditCustomAttributes = "";
		$this->gp->EditValue = $this->gp->CurrentValue;
		$this->gp->PlaceHolder = ew_RemoveHtml($this->gp->FldCaption());
		if (strval($this->gp->EditValue) <> "" && is_numeric($this->gp->EditValue)) $this->gp->EditValue = ew_FormatNumber($this->gp->EditValue, -2, -1, -2, 0);

		// upah_tetap
		$this->upah_tetap->EditAttrs["class"] = "form-control";
		$this->upah_tetap->EditCustomAttributes = "";
		$this->upah_tetap->EditValue = $this->upah_tetap->CurrentValue;
		$this->upah_tetap->PlaceHolder = ew_RemoveHtml($this->upah_tetap->FldCaption());
		if (strval($this->upah_tetap->EditValue) <> "" && is_numeric($this->upah_tetap->EditValue)) $this->upah_tetap->EditValue = ew_FormatNumber($this->upah_tetap->EditValue, -2, -1, -2, 0);

		// tgl_honor
		$this->tgl_honor->EditAttrs["class"] = "form-control";
		$this->tgl_honor->EditCustomAttributes = "";
		$this->tgl_honor->EditValue = ew_FormatDateTime($this->tgl_honor->CurrentValue, 8);
		$this->tgl_honor->PlaceHolder = ew_RemoveHtml($this->tgl_honor->FldCaption());

		// honor
		$this->honor->EditAttrs["class"] = "form-control";
		$this->honor->EditCustomAttributes = "";
		$this->honor->EditValue = $this->honor->CurrentValue;
		$this->honor->PlaceHolder = ew_RemoveHtml($this->honor->FldCaption());
		if (strval($this->honor->EditValue) <> "" && is_numeric($this->honor->EditValue)) $this->honor->EditValue = ew_FormatNumber($this->honor->EditValue, -2, -1, -2, 0);

		// premi_honor
		$this->premi_honor->EditAttrs["class"] = "form-control";
		$this->premi_honor->EditCustomAttributes = "";
		$this->premi_honor->EditValue = $this->premi_honor->CurrentValue;
		$this->premi_honor->PlaceHolder = ew_RemoveHtml($this->premi_honor->FldCaption());
		if (strval($this->premi_honor->EditValue) <> "" && is_numeric($this->premi_honor->EditValue)) $this->premi_honor->EditValue = ew_FormatNumber($this->premi_honor->EditValue, -2, -1, -2, 0);

		// tgl_gp
		$this->tgl_gp->EditAttrs["class"] = "form-control";
		$this->tgl_gp->EditCustomAttributes = "";
		$this->tgl_gp->EditValue = ew_FormatDateTime($this->tgl_gp->CurrentValue, 8);
		$this->tgl_gp->PlaceHolder = ew_RemoveHtml($this->tgl_gp->FldCaption());

		// skala_95
		$this->skala_95->EditAttrs["class"] = "form-control";
		$this->skala_95->EditCustomAttributes = "";
		$this->skala_95->EditValue = $this->skala_95->CurrentValue;
		$this->skala_95->PlaceHolder = ew_RemoveHtml($this->skala_95->FldCaption());

		// gp_95
		$this->gp_95->EditAttrs["class"] = "form-control";
		$this->gp_95->EditCustomAttributes = "";
		$this->gp_95->EditValue = $this->gp_95->CurrentValue;
		$this->gp_95->PlaceHolder = ew_RemoveHtml($this->gp_95->FldCaption());
		if (strval($this->gp_95->EditValue) <> "" && is_numeric($this->gp_95->EditValue)) $this->gp_95->EditValue = ew_FormatNumber($this->gp_95->EditValue, -2, -1, -2, 0);

		// tgl_gp_95
		$this->tgl_gp_95->EditAttrs["class"] = "form-control";
		$this->tgl_gp_95->EditCustomAttributes = "";
		$this->tgl_gp_95->EditValue = ew_FormatDateTime($this->tgl_gp_95->CurrentValue, 8);
		$this->tgl_gp_95->PlaceHolder = ew_RemoveHtml($this->tgl_gp_95->FldCaption());

		// kd_indx
		$this->kd_indx->EditAttrs["class"] = "form-control";
		$this->kd_indx->EditCustomAttributes = "";
		$this->kd_indx->EditValue = $this->kd_indx->CurrentValue;
		$this->kd_indx->PlaceHolder = ew_RemoveHtml($this->kd_indx->FldCaption());

		// indx_lok
		$this->indx_lok->EditAttrs["class"] = "form-control";
		$this->indx_lok->EditCustomAttributes = "";
		$this->indx_lok->EditValue = $this->indx_lok->CurrentValue;
		$this->indx_lok->PlaceHolder = ew_RemoveHtml($this->indx_lok->FldCaption());
		if (strval($this->indx_lok->EditValue) <> "" && is_numeric($this->indx_lok->EditValue)) $this->indx_lok->EditValue = ew_FormatNumber($this->indx_lok->EditValue, -2, -1, -2, 0);

		// gol_darah
		$this->gol_darah->EditAttrs["class"] = "form-control";
		$this->gol_darah->EditCustomAttributes = "";
		$this->gol_darah->EditValue = $this->gol_darah->CurrentValue;
		$this->gol_darah->PlaceHolder = ew_RemoveHtml($this->gol_darah->FldCaption());

		// kd_jbt
		$this->kd_jbt->EditAttrs["class"] = "form-control";
		$this->kd_jbt->EditCustomAttributes = "";
		$this->kd_jbt->EditValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->PlaceHolder = ew_RemoveHtml($this->kd_jbt->FldCaption());

		// tgl_kd_jbt
		$this->tgl_kd_jbt->EditAttrs["class"] = "form-control";
		$this->tgl_kd_jbt->EditCustomAttributes = "";
		$this->tgl_kd_jbt->EditValue = ew_FormatDateTime($this->tgl_kd_jbt->CurrentValue, 8);
		$this->tgl_kd_jbt->PlaceHolder = ew_RemoveHtml($this->tgl_kd_jbt->FldCaption());

		// kd_jbt_pgs
		$this->kd_jbt_pgs->EditAttrs["class"] = "form-control";
		$this->kd_jbt_pgs->EditCustomAttributes = "";
		$this->kd_jbt_pgs->EditValue = $this->kd_jbt_pgs->CurrentValue;
		$this->kd_jbt_pgs->PlaceHolder = ew_RemoveHtml($this->kd_jbt_pgs->FldCaption());

		// tgl_kd_jbt_pgs
		$this->tgl_kd_jbt_pgs->EditAttrs["class"] = "form-control";
		$this->tgl_kd_jbt_pgs->EditCustomAttributes = "";
		$this->tgl_kd_jbt_pgs->EditValue = ew_FormatDateTime($this->tgl_kd_jbt_pgs->CurrentValue, 8);
		$this->tgl_kd_jbt_pgs->PlaceHolder = ew_RemoveHtml($this->tgl_kd_jbt_pgs->FldCaption());

		// kd_jbt_pjs
		$this->kd_jbt_pjs->EditAttrs["class"] = "form-control";
		$this->kd_jbt_pjs->EditCustomAttributes = "";
		$this->kd_jbt_pjs->EditValue = $this->kd_jbt_pjs->CurrentValue;
		$this->kd_jbt_pjs->PlaceHolder = ew_RemoveHtml($this->kd_jbt_pjs->FldCaption());

		// tgl_kd_jbt_pjs
		$this->tgl_kd_jbt_pjs->EditAttrs["class"] = "form-control";
		$this->tgl_kd_jbt_pjs->EditCustomAttributes = "";
		$this->tgl_kd_jbt_pjs->EditValue = ew_FormatDateTime($this->tgl_kd_jbt_pjs->CurrentValue, 8);
		$this->tgl_kd_jbt_pjs->PlaceHolder = ew_RemoveHtml($this->tgl_kd_jbt_pjs->FldCaption());

		// kd_jbt_ps
		$this->kd_jbt_ps->EditAttrs["class"] = "form-control";
		$this->kd_jbt_ps->EditCustomAttributes = "";
		$this->kd_jbt_ps->EditValue = $this->kd_jbt_ps->CurrentValue;
		$this->kd_jbt_ps->PlaceHolder = ew_RemoveHtml($this->kd_jbt_ps->FldCaption());

		// tgl_kd_jbt_ps
		$this->tgl_kd_jbt_ps->EditAttrs["class"] = "form-control";
		$this->tgl_kd_jbt_ps->EditCustomAttributes = "";
		$this->tgl_kd_jbt_ps->EditValue = ew_FormatDateTime($this->tgl_kd_jbt_ps->CurrentValue, 8);
		$this->tgl_kd_jbt_ps->PlaceHolder = ew_RemoveHtml($this->tgl_kd_jbt_ps->FldCaption());

		// kd_pat
		$this->kd_pat->EditAttrs["class"] = "form-control";
		$this->kd_pat->EditCustomAttributes = "";
		$this->kd_pat->EditValue = $this->kd_pat->CurrentValue;
		$this->kd_pat->PlaceHolder = ew_RemoveHtml($this->kd_pat->FldCaption());

		// kd_gas
		$this->kd_gas->EditAttrs["class"] = "form-control";
		$this->kd_gas->EditCustomAttributes = "";
		$this->kd_gas->EditValue = $this->kd_gas->CurrentValue;
		$this->kd_gas->PlaceHolder = ew_RemoveHtml($this->kd_gas->FldCaption());

		// pimp_empid
		$this->pimp_empid->EditAttrs["class"] = "form-control";
		$this->pimp_empid->EditCustomAttributes = "";
		$this->pimp_empid->EditValue = $this->pimp_empid->CurrentValue;
		$this->pimp_empid->PlaceHolder = ew_RemoveHtml($this->pimp_empid->FldCaption());

		// stshift
		$this->stshift->EditAttrs["class"] = "form-control";
		$this->stshift->EditCustomAttributes = "";
		$this->stshift->EditValue = $this->stshift->CurrentValue;
		$this->stshift->PlaceHolder = ew_RemoveHtml($this->stshift->FldCaption());

		// no_rek
		$this->no_rek->EditAttrs["class"] = "form-control";
		$this->no_rek->EditCustomAttributes = "";
		$this->no_rek->EditValue = $this->no_rek->CurrentValue;
		$this->no_rek->PlaceHolder = ew_RemoveHtml($this->no_rek->FldCaption());

		// kd_bank
		$this->kd_bank->EditAttrs["class"] = "form-control";
		$this->kd_bank->EditCustomAttributes = "";
		$this->kd_bank->EditValue = $this->kd_bank->CurrentValue;
		$this->kd_bank->PlaceHolder = ew_RemoveHtml($this->kd_bank->FldCaption());

		// kd_jamsostek
		$this->kd_jamsostek->EditAttrs["class"] = "form-control";
		$this->kd_jamsostek->EditCustomAttributes = "";
		$this->kd_jamsostek->EditValue = $this->kd_jamsostek->CurrentValue;
		$this->kd_jamsostek->PlaceHolder = ew_RemoveHtml($this->kd_jamsostek->FldCaption());

		// acc_astek
		$this->acc_astek->EditAttrs["class"] = "form-control";
		$this->acc_astek->EditCustomAttributes = "";
		$this->acc_astek->EditValue = $this->acc_astek->CurrentValue;
		$this->acc_astek->PlaceHolder = ew_RemoveHtml($this->acc_astek->FldCaption());

		// acc_dapens
		$this->acc_dapens->EditAttrs["class"] = "form-control";
		$this->acc_dapens->EditCustomAttributes = "";
		$this->acc_dapens->EditValue = $this->acc_dapens->CurrentValue;
		$this->acc_dapens->PlaceHolder = ew_RemoveHtml($this->acc_dapens->FldCaption());

		// acc_kes
		$this->acc_kes->EditAttrs["class"] = "form-control";
		$this->acc_kes->EditCustomAttributes = "";
		$this->acc_kes->EditValue = $this->acc_kes->CurrentValue;
		$this->acc_kes->PlaceHolder = ew_RemoveHtml($this->acc_kes->FldCaption());

		// st
		$this->st->EditAttrs["class"] = "form-control";
		$this->st->EditCustomAttributes = "";
		$this->st->EditValue = $this->st->CurrentValue;
		$this->st->PlaceHolder = ew_RemoveHtml($this->st->FldCaption());

		// signature
		$this->signature->EditAttrs["class"] = "form-control";
		$this->signature->EditCustomAttributes = "";
		if (!ew_Empty($this->signature->Upload->DbValue)) {
			$this->signature->EditValue = "personal_signature_bv.php?" . "employee_id=" . $this->employee_id->CurrentValue;
			$this->signature->IsBlobImage = ew_IsImageFile(ew_ContentExt(substr($this->signature->Upload->DbValue, 0, 11)));
		} else {
			$this->signature->EditValue = "";
		}

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

		// fgr_print_id
		$this->fgr_print_id->EditAttrs["class"] = "form-control";
		$this->fgr_print_id->EditCustomAttributes = "";
		$this->fgr_print_id->EditValue = $this->fgr_print_id->CurrentValue;
		$this->fgr_print_id->PlaceHolder = ew_RemoveHtml($this->fgr_print_id->FldCaption());
		if (strval($this->fgr_print_id->EditValue) <> "" && is_numeric($this->fgr_print_id->EditValue)) $this->fgr_print_id->EditValue = ew_FormatNumber($this->fgr_print_id->EditValue, -2, -1, -2, 0);

		// kd_jbt_eselon
		$this->kd_jbt_eselon->EditAttrs["class"] = "form-control";
		$this->kd_jbt_eselon->EditCustomAttributes = "";
		$this->kd_jbt_eselon->EditValue = $this->kd_jbt_eselon->CurrentValue;
		$this->kd_jbt_eselon->PlaceHolder = ew_RemoveHtml($this->kd_jbt_eselon->FldCaption());

		// npwp
		$this->npwp->EditAttrs["class"] = "form-control";
		$this->npwp->EditCustomAttributes = "";
		$this->npwp->EditValue = $this->npwp->CurrentValue;
		$this->npwp->PlaceHolder = ew_RemoveHtml($this->npwp->FldCaption());

		// paraf
		$this->paraf->EditAttrs["class"] = "form-control";
		$this->paraf->EditCustomAttributes = "";
		if (!ew_Empty($this->paraf->Upload->DbValue)) {
			$this->paraf->EditValue = "personal_paraf_bv.php?" . "employee_id=" . $this->employee_id->CurrentValue;
			$this->paraf->IsBlobImage = ew_IsImageFile(ew_ContentExt(substr($this->paraf->Upload->DbValue, 0, 11)));
		} else {
			$this->paraf->EditValue = "";
		}

		// tgl_keluar
		$this->tgl_keluar->EditAttrs["class"] = "form-control";
		$this->tgl_keluar->EditCustomAttributes = "";
		$this->tgl_keluar->EditValue = ew_FormatDateTime($this->tgl_keluar->CurrentValue, 8);
		$this->tgl_keluar->PlaceHolder = ew_RemoveHtml($this->tgl_keluar->FldCaption());

		// nama_nasabah
		$this->nama_nasabah->EditAttrs["class"] = "form-control";
		$this->nama_nasabah->EditCustomAttributes = "";
		$this->nama_nasabah->EditValue = $this->nama_nasabah->CurrentValue;
		$this->nama_nasabah->PlaceHolder = ew_RemoveHtml($this->nama_nasabah->FldCaption());

		// no_ktp
		$this->no_ktp->EditAttrs["class"] = "form-control";
		$this->no_ktp->EditCustomAttributes = "";
		$this->no_ktp->EditValue = $this->no_ktp->CurrentValue;
		$this->no_ktp->PlaceHolder = ew_RemoveHtml($this->no_ktp->FldCaption());

		// no_kokar
		$this->no_kokar->EditAttrs["class"] = "form-control";
		$this->no_kokar->EditCustomAttributes = "";
		$this->no_kokar->EditValue = $this->no_kokar->CurrentValue;
		$this->no_kokar->PlaceHolder = ew_RemoveHtml($this->no_kokar->FldCaption());

		// no_bmw
		$this->no_bmw->EditAttrs["class"] = "form-control";
		$this->no_bmw->EditCustomAttributes = "";
		$this->no_bmw->EditValue = $this->no_bmw->CurrentValue;
		$this->no_bmw->PlaceHolder = ew_RemoveHtml($this->no_bmw->FldCaption());

		// no_bpjs_ketenagakerjaan
		$this->no_bpjs_ketenagakerjaan->EditAttrs["class"] = "form-control";
		$this->no_bpjs_ketenagakerjaan->EditCustomAttributes = "";
		$this->no_bpjs_ketenagakerjaan->EditValue = $this->no_bpjs_ketenagakerjaan->CurrentValue;
		$this->no_bpjs_ketenagakerjaan->PlaceHolder = ew_RemoveHtml($this->no_bpjs_ketenagakerjaan->FldCaption());

		// no_bpjs_kesehatan
		$this->no_bpjs_kesehatan->EditAttrs["class"] = "form-control";
		$this->no_bpjs_kesehatan->EditCustomAttributes = "";
		$this->no_bpjs_kesehatan->EditValue = $this->no_bpjs_kesehatan->CurrentValue;
		$this->no_bpjs_kesehatan->PlaceHolder = ew_RemoveHtml($this->no_bpjs_kesehatan->FldCaption());

		// eselon
		$this->eselon->EditAttrs["class"] = "form-control";
		$this->eselon->EditCustomAttributes = "";
		$this->eselon->EditValue = $this->eselon->CurrentValue;
		$this->eselon->PlaceHolder = ew_RemoveHtml($this->eselon->FldCaption());

		// kd_jenjang
		$this->kd_jenjang->EditAttrs["class"] = "form-control";
		$this->kd_jenjang->EditCustomAttributes = "";
		$this->kd_jenjang->EditValue = $this->kd_jenjang->CurrentValue;
		$this->kd_jenjang->PlaceHolder = ew_RemoveHtml($this->kd_jenjang->FldCaption());

		// kd_jbt_esl
		$this->kd_jbt_esl->EditAttrs["class"] = "form-control";
		$this->kd_jbt_esl->EditCustomAttributes = "";
		$this->kd_jbt_esl->EditValue = $this->kd_jbt_esl->CurrentValue;
		$this->kd_jbt_esl->PlaceHolder = ew_RemoveHtml($this->kd_jbt_esl->FldCaption());

		// tgl_jbt_esl
		$this->tgl_jbt_esl->EditAttrs["class"] = "form-control";
		$this->tgl_jbt_esl->EditCustomAttributes = "";
		$this->tgl_jbt_esl->EditValue = ew_FormatDateTime($this->tgl_jbt_esl->CurrentValue, 8);
		$this->tgl_jbt_esl->PlaceHolder = ew_RemoveHtml($this->tgl_jbt_esl->FldCaption());

		// org_id
		$this->org_id->EditAttrs["class"] = "form-control";
		$this->org_id->EditCustomAttributes = "";
		$this->org_id->EditValue = $this->org_id->CurrentValue;
		$this->org_id->PlaceHolder = ew_RemoveHtml($this->org_id->FldCaption());

		// picture
		$this->picture->EditAttrs["class"] = "form-control";
		$this->picture->EditCustomAttributes = "";
		if (!ew_Empty($this->picture->Upload->DbValue)) {
			$this->picture->EditValue = "personal_picture_bv.php?" . "employee_id=" . $this->employee_id->CurrentValue;
			$this->picture->IsBlobImage = ew_IsImageFile(ew_ContentExt(substr($this->picture->Upload->DbValue, 0, 11)));
		} else {
			$this->picture->EditValue = "";
		}

		// kd_payroll
		$this->kd_payroll->EditAttrs["class"] = "form-control";
		$this->kd_payroll->EditCustomAttributes = "";
		$this->kd_payroll->EditValue = $this->kd_payroll->CurrentValue;
		$this->kd_payroll->PlaceHolder = ew_RemoveHtml($this->kd_payroll->FldCaption());

		// id_wn
		$this->id_wn->EditAttrs["class"] = "form-control";
		$this->id_wn->EditCustomAttributes = "";
		$this->id_wn->EditValue = $this->id_wn->CurrentValue;
		$this->id_wn->PlaceHolder = ew_RemoveHtml($this->id_wn->FldCaption());

		// no_anggota_kkms
		$this->no_anggota_kkms->EditAttrs["class"] = "form-control";
		$this->no_anggota_kkms->EditCustomAttributes = "";
		$this->no_anggota_kkms->EditValue = $this->no_anggota_kkms->CurrentValue;
		$this->no_anggota_kkms->PlaceHolder = ew_RemoveHtml($this->no_anggota_kkms->FldCaption());

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
					if ($this->first_name->Exportable) $Doc->ExportCaption($this->first_name);
					if ($this->last_name->Exportable) $Doc->ExportCaption($this->last_name);
					if ($this->first_title->Exportable) $Doc->ExportCaption($this->first_title);
					if ($this->last_title->Exportable) $Doc->ExportCaption($this->last_title);
					if ($this->init->Exportable) $Doc->ExportCaption($this->init);
					if ($this->tpt_lahir->Exportable) $Doc->ExportCaption($this->tpt_lahir);
					if ($this->tgl_lahir->Exportable) $Doc->ExportCaption($this->tgl_lahir);
					if ($this->jk->Exportable) $Doc->ExportCaption($this->jk);
					if ($this->kd_agama->Exportable) $Doc->ExportCaption($this->kd_agama);
					if ($this->tgl_masuk->Exportable) $Doc->ExportCaption($this->tgl_masuk);
					if ($this->tpt_masuk->Exportable) $Doc->ExportCaption($this->tpt_masuk);
					if ($this->stkel->Exportable) $Doc->ExportCaption($this->stkel);
					if ($this->alamat->Exportable) $Doc->ExportCaption($this->alamat);
					if ($this->kota->Exportable) $Doc->ExportCaption($this->kota);
					if ($this->kd_pos->Exportable) $Doc->ExportCaption($this->kd_pos);
					if ($this->kd_propinsi->Exportable) $Doc->ExportCaption($this->kd_propinsi);
					if ($this->telp->Exportable) $Doc->ExportCaption($this->telp);
					if ($this->telp_area->Exportable) $Doc->ExportCaption($this->telp_area);
					if ($this->hp->Exportable) $Doc->ExportCaption($this->hp);
					if ($this->alamat_dom->Exportable) $Doc->ExportCaption($this->alamat_dom);
					if ($this->kota_dom->Exportable) $Doc->ExportCaption($this->kota_dom);
					if ($this->kd_pos_dom->Exportable) $Doc->ExportCaption($this->kd_pos_dom);
					if ($this->kd_propinsi_dom->Exportable) $Doc->ExportCaption($this->kd_propinsi_dom);
					if ($this->telp_dom->Exportable) $Doc->ExportCaption($this->telp_dom);
					if ($this->telp_dom_area->Exportable) $Doc->ExportCaption($this->telp_dom_area);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->kd_st_emp->Exportable) $Doc->ExportCaption($this->kd_st_emp);
					if ($this->skala->Exportable) $Doc->ExportCaption($this->skala);
					if ($this->gp->Exportable) $Doc->ExportCaption($this->gp);
					if ($this->upah_tetap->Exportable) $Doc->ExportCaption($this->upah_tetap);
					if ($this->tgl_honor->Exportable) $Doc->ExportCaption($this->tgl_honor);
					if ($this->honor->Exportable) $Doc->ExportCaption($this->honor);
					if ($this->premi_honor->Exportable) $Doc->ExportCaption($this->premi_honor);
					if ($this->tgl_gp->Exportable) $Doc->ExportCaption($this->tgl_gp);
					if ($this->skala_95->Exportable) $Doc->ExportCaption($this->skala_95);
					if ($this->gp_95->Exportable) $Doc->ExportCaption($this->gp_95);
					if ($this->tgl_gp_95->Exportable) $Doc->ExportCaption($this->tgl_gp_95);
					if ($this->kd_indx->Exportable) $Doc->ExportCaption($this->kd_indx);
					if ($this->indx_lok->Exportable) $Doc->ExportCaption($this->indx_lok);
					if ($this->gol_darah->Exportable) $Doc->ExportCaption($this->gol_darah);
					if ($this->kd_jbt->Exportable) $Doc->ExportCaption($this->kd_jbt);
					if ($this->tgl_kd_jbt->Exportable) $Doc->ExportCaption($this->tgl_kd_jbt);
					if ($this->kd_jbt_pgs->Exportable) $Doc->ExportCaption($this->kd_jbt_pgs);
					if ($this->tgl_kd_jbt_pgs->Exportable) $Doc->ExportCaption($this->tgl_kd_jbt_pgs);
					if ($this->kd_jbt_pjs->Exportable) $Doc->ExportCaption($this->kd_jbt_pjs);
					if ($this->tgl_kd_jbt_pjs->Exportable) $Doc->ExportCaption($this->tgl_kd_jbt_pjs);
					if ($this->kd_jbt_ps->Exportable) $Doc->ExportCaption($this->kd_jbt_ps);
					if ($this->tgl_kd_jbt_ps->Exportable) $Doc->ExportCaption($this->tgl_kd_jbt_ps);
					if ($this->kd_pat->Exportable) $Doc->ExportCaption($this->kd_pat);
					if ($this->kd_gas->Exportable) $Doc->ExportCaption($this->kd_gas);
					if ($this->pimp_empid->Exportable) $Doc->ExportCaption($this->pimp_empid);
					if ($this->stshift->Exportable) $Doc->ExportCaption($this->stshift);
					if ($this->no_rek->Exportable) $Doc->ExportCaption($this->no_rek);
					if ($this->kd_bank->Exportable) $Doc->ExportCaption($this->kd_bank);
					if ($this->kd_jamsostek->Exportable) $Doc->ExportCaption($this->kd_jamsostek);
					if ($this->acc_astek->Exportable) $Doc->ExportCaption($this->acc_astek);
					if ($this->acc_dapens->Exportable) $Doc->ExportCaption($this->acc_dapens);
					if ($this->acc_kes->Exportable) $Doc->ExportCaption($this->acc_kes);
					if ($this->st->Exportable) $Doc->ExportCaption($this->st);
					if ($this->signature->Exportable) $Doc->ExportCaption($this->signature);
					if ($this->created_by->Exportable) $Doc->ExportCaption($this->created_by);
					if ($this->created_date->Exportable) $Doc->ExportCaption($this->created_date);
					if ($this->last_update_by->Exportable) $Doc->ExportCaption($this->last_update_by);
					if ($this->last_update_date->Exportable) $Doc->ExportCaption($this->last_update_date);
					if ($this->fgr_print_id->Exportable) $Doc->ExportCaption($this->fgr_print_id);
					if ($this->kd_jbt_eselon->Exportable) $Doc->ExportCaption($this->kd_jbt_eselon);
					if ($this->npwp->Exportable) $Doc->ExportCaption($this->npwp);
					if ($this->paraf->Exportable) $Doc->ExportCaption($this->paraf);
					if ($this->tgl_keluar->Exportable) $Doc->ExportCaption($this->tgl_keluar);
					if ($this->nama_nasabah->Exportable) $Doc->ExportCaption($this->nama_nasabah);
					if ($this->no_ktp->Exportable) $Doc->ExportCaption($this->no_ktp);
					if ($this->no_kokar->Exportable) $Doc->ExportCaption($this->no_kokar);
					if ($this->no_bmw->Exportable) $Doc->ExportCaption($this->no_bmw);
					if ($this->no_bpjs_ketenagakerjaan->Exportable) $Doc->ExportCaption($this->no_bpjs_ketenagakerjaan);
					if ($this->no_bpjs_kesehatan->Exportable) $Doc->ExportCaption($this->no_bpjs_kesehatan);
					if ($this->eselon->Exportable) $Doc->ExportCaption($this->eselon);
					if ($this->kd_jenjang->Exportable) $Doc->ExportCaption($this->kd_jenjang);
					if ($this->kd_jbt_esl->Exportable) $Doc->ExportCaption($this->kd_jbt_esl);
					if ($this->tgl_jbt_esl->Exportable) $Doc->ExportCaption($this->tgl_jbt_esl);
					if ($this->org_id->Exportable) $Doc->ExportCaption($this->org_id);
					if ($this->picture->Exportable) $Doc->ExportCaption($this->picture);
					if ($this->kd_payroll->Exportable) $Doc->ExportCaption($this->kd_payroll);
					if ($this->id_wn->Exportable) $Doc->ExportCaption($this->id_wn);
					if ($this->no_anggota_kkms->Exportable) $Doc->ExportCaption($this->no_anggota_kkms);
				} else {
					if ($this->employee_id->Exportable) $Doc->ExportCaption($this->employee_id);
					if ($this->first_name->Exportable) $Doc->ExportCaption($this->first_name);
					if ($this->last_name->Exportable) $Doc->ExportCaption($this->last_name);
					if ($this->first_title->Exportable) $Doc->ExportCaption($this->first_title);
					if ($this->last_title->Exportable) $Doc->ExportCaption($this->last_title);
					if ($this->init->Exportable) $Doc->ExportCaption($this->init);
					if ($this->tpt_lahir->Exportable) $Doc->ExportCaption($this->tpt_lahir);
					if ($this->tgl_lahir->Exportable) $Doc->ExportCaption($this->tgl_lahir);
					if ($this->jk->Exportable) $Doc->ExportCaption($this->jk);
					if ($this->kd_agama->Exportable) $Doc->ExportCaption($this->kd_agama);
					if ($this->tgl_masuk->Exportable) $Doc->ExportCaption($this->tgl_masuk);
					if ($this->tpt_masuk->Exportable) $Doc->ExportCaption($this->tpt_masuk);
					if ($this->stkel->Exportable) $Doc->ExportCaption($this->stkel);
					if ($this->alamat->Exportable) $Doc->ExportCaption($this->alamat);
					if ($this->kota->Exportable) $Doc->ExportCaption($this->kota);
					if ($this->kd_pos->Exportable) $Doc->ExportCaption($this->kd_pos);
					if ($this->kd_propinsi->Exportable) $Doc->ExportCaption($this->kd_propinsi);
					if ($this->telp->Exportable) $Doc->ExportCaption($this->telp);
					if ($this->telp_area->Exportable) $Doc->ExportCaption($this->telp_area);
					if ($this->hp->Exportable) $Doc->ExportCaption($this->hp);
					if ($this->alamat_dom->Exportable) $Doc->ExportCaption($this->alamat_dom);
					if ($this->kota_dom->Exportable) $Doc->ExportCaption($this->kota_dom);
					if ($this->kd_pos_dom->Exportable) $Doc->ExportCaption($this->kd_pos_dom);
					if ($this->kd_propinsi_dom->Exportable) $Doc->ExportCaption($this->kd_propinsi_dom);
					if ($this->telp_dom->Exportable) $Doc->ExportCaption($this->telp_dom);
					if ($this->telp_dom_area->Exportable) $Doc->ExportCaption($this->telp_dom_area);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->kd_st_emp->Exportable) $Doc->ExportCaption($this->kd_st_emp);
					if ($this->skala->Exportable) $Doc->ExportCaption($this->skala);
					if ($this->gp->Exportable) $Doc->ExportCaption($this->gp);
					if ($this->upah_tetap->Exportable) $Doc->ExportCaption($this->upah_tetap);
					if ($this->tgl_honor->Exportable) $Doc->ExportCaption($this->tgl_honor);
					if ($this->honor->Exportable) $Doc->ExportCaption($this->honor);
					if ($this->premi_honor->Exportable) $Doc->ExportCaption($this->premi_honor);
					if ($this->tgl_gp->Exportable) $Doc->ExportCaption($this->tgl_gp);
					if ($this->skala_95->Exportable) $Doc->ExportCaption($this->skala_95);
					if ($this->gp_95->Exportable) $Doc->ExportCaption($this->gp_95);
					if ($this->tgl_gp_95->Exportable) $Doc->ExportCaption($this->tgl_gp_95);
					if ($this->kd_indx->Exportable) $Doc->ExportCaption($this->kd_indx);
					if ($this->indx_lok->Exportable) $Doc->ExportCaption($this->indx_lok);
					if ($this->gol_darah->Exportable) $Doc->ExportCaption($this->gol_darah);
					if ($this->kd_jbt->Exportable) $Doc->ExportCaption($this->kd_jbt);
					if ($this->tgl_kd_jbt->Exportable) $Doc->ExportCaption($this->tgl_kd_jbt);
					if ($this->kd_jbt_pgs->Exportable) $Doc->ExportCaption($this->kd_jbt_pgs);
					if ($this->tgl_kd_jbt_pgs->Exportable) $Doc->ExportCaption($this->tgl_kd_jbt_pgs);
					if ($this->kd_jbt_pjs->Exportable) $Doc->ExportCaption($this->kd_jbt_pjs);
					if ($this->tgl_kd_jbt_pjs->Exportable) $Doc->ExportCaption($this->tgl_kd_jbt_pjs);
					if ($this->kd_jbt_ps->Exportable) $Doc->ExportCaption($this->kd_jbt_ps);
					if ($this->tgl_kd_jbt_ps->Exportable) $Doc->ExportCaption($this->tgl_kd_jbt_ps);
					if ($this->kd_pat->Exportable) $Doc->ExportCaption($this->kd_pat);
					if ($this->kd_gas->Exportable) $Doc->ExportCaption($this->kd_gas);
					if ($this->pimp_empid->Exportable) $Doc->ExportCaption($this->pimp_empid);
					if ($this->stshift->Exportable) $Doc->ExportCaption($this->stshift);
					if ($this->no_rek->Exportable) $Doc->ExportCaption($this->no_rek);
					if ($this->kd_bank->Exportable) $Doc->ExportCaption($this->kd_bank);
					if ($this->kd_jamsostek->Exportable) $Doc->ExportCaption($this->kd_jamsostek);
					if ($this->acc_astek->Exportable) $Doc->ExportCaption($this->acc_astek);
					if ($this->acc_dapens->Exportable) $Doc->ExportCaption($this->acc_dapens);
					if ($this->acc_kes->Exportable) $Doc->ExportCaption($this->acc_kes);
					if ($this->st->Exportable) $Doc->ExportCaption($this->st);
					if ($this->created_by->Exportable) $Doc->ExportCaption($this->created_by);
					if ($this->created_date->Exportable) $Doc->ExportCaption($this->created_date);
					if ($this->last_update_by->Exportable) $Doc->ExportCaption($this->last_update_by);
					if ($this->last_update_date->Exportable) $Doc->ExportCaption($this->last_update_date);
					if ($this->fgr_print_id->Exportable) $Doc->ExportCaption($this->fgr_print_id);
					if ($this->kd_jbt_eselon->Exportable) $Doc->ExportCaption($this->kd_jbt_eselon);
					if ($this->npwp->Exportable) $Doc->ExportCaption($this->npwp);
					if ($this->tgl_keluar->Exportable) $Doc->ExportCaption($this->tgl_keluar);
					if ($this->nama_nasabah->Exportable) $Doc->ExportCaption($this->nama_nasabah);
					if ($this->no_ktp->Exportable) $Doc->ExportCaption($this->no_ktp);
					if ($this->no_kokar->Exportable) $Doc->ExportCaption($this->no_kokar);
					if ($this->no_bmw->Exportable) $Doc->ExportCaption($this->no_bmw);
					if ($this->no_bpjs_ketenagakerjaan->Exportable) $Doc->ExportCaption($this->no_bpjs_ketenagakerjaan);
					if ($this->no_bpjs_kesehatan->Exportable) $Doc->ExportCaption($this->no_bpjs_kesehatan);
					if ($this->eselon->Exportable) $Doc->ExportCaption($this->eselon);
					if ($this->kd_jenjang->Exportable) $Doc->ExportCaption($this->kd_jenjang);
					if ($this->kd_jbt_esl->Exportable) $Doc->ExportCaption($this->kd_jbt_esl);
					if ($this->tgl_jbt_esl->Exportable) $Doc->ExportCaption($this->tgl_jbt_esl);
					if ($this->org_id->Exportable) $Doc->ExportCaption($this->org_id);
					if ($this->kd_payroll->Exportable) $Doc->ExportCaption($this->kd_payroll);
					if ($this->id_wn->Exportable) $Doc->ExportCaption($this->id_wn);
					if ($this->no_anggota_kkms->Exportable) $Doc->ExportCaption($this->no_anggota_kkms);
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
						if ($this->first_name->Exportable) $Doc->ExportField($this->first_name);
						if ($this->last_name->Exportable) $Doc->ExportField($this->last_name);
						if ($this->first_title->Exportable) $Doc->ExportField($this->first_title);
						if ($this->last_title->Exportable) $Doc->ExportField($this->last_title);
						if ($this->init->Exportable) $Doc->ExportField($this->init);
						if ($this->tpt_lahir->Exportable) $Doc->ExportField($this->tpt_lahir);
						if ($this->tgl_lahir->Exportable) $Doc->ExportField($this->tgl_lahir);
						if ($this->jk->Exportable) $Doc->ExportField($this->jk);
						if ($this->kd_agama->Exportable) $Doc->ExportField($this->kd_agama);
						if ($this->tgl_masuk->Exportable) $Doc->ExportField($this->tgl_masuk);
						if ($this->tpt_masuk->Exportable) $Doc->ExportField($this->tpt_masuk);
						if ($this->stkel->Exportable) $Doc->ExportField($this->stkel);
						if ($this->alamat->Exportable) $Doc->ExportField($this->alamat);
						if ($this->kota->Exportable) $Doc->ExportField($this->kota);
						if ($this->kd_pos->Exportable) $Doc->ExportField($this->kd_pos);
						if ($this->kd_propinsi->Exportable) $Doc->ExportField($this->kd_propinsi);
						if ($this->telp->Exportable) $Doc->ExportField($this->telp);
						if ($this->telp_area->Exportable) $Doc->ExportField($this->telp_area);
						if ($this->hp->Exportable) $Doc->ExportField($this->hp);
						if ($this->alamat_dom->Exportable) $Doc->ExportField($this->alamat_dom);
						if ($this->kota_dom->Exportable) $Doc->ExportField($this->kota_dom);
						if ($this->kd_pos_dom->Exportable) $Doc->ExportField($this->kd_pos_dom);
						if ($this->kd_propinsi_dom->Exportable) $Doc->ExportField($this->kd_propinsi_dom);
						if ($this->telp_dom->Exportable) $Doc->ExportField($this->telp_dom);
						if ($this->telp_dom_area->Exportable) $Doc->ExportField($this->telp_dom_area);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->kd_st_emp->Exportable) $Doc->ExportField($this->kd_st_emp);
						if ($this->skala->Exportable) $Doc->ExportField($this->skala);
						if ($this->gp->Exportable) $Doc->ExportField($this->gp);
						if ($this->upah_tetap->Exportable) $Doc->ExportField($this->upah_tetap);
						if ($this->tgl_honor->Exportable) $Doc->ExportField($this->tgl_honor);
						if ($this->honor->Exportable) $Doc->ExportField($this->honor);
						if ($this->premi_honor->Exportable) $Doc->ExportField($this->premi_honor);
						if ($this->tgl_gp->Exportable) $Doc->ExportField($this->tgl_gp);
						if ($this->skala_95->Exportable) $Doc->ExportField($this->skala_95);
						if ($this->gp_95->Exportable) $Doc->ExportField($this->gp_95);
						if ($this->tgl_gp_95->Exportable) $Doc->ExportField($this->tgl_gp_95);
						if ($this->kd_indx->Exportable) $Doc->ExportField($this->kd_indx);
						if ($this->indx_lok->Exportable) $Doc->ExportField($this->indx_lok);
						if ($this->gol_darah->Exportable) $Doc->ExportField($this->gol_darah);
						if ($this->kd_jbt->Exportable) $Doc->ExportField($this->kd_jbt);
						if ($this->tgl_kd_jbt->Exportable) $Doc->ExportField($this->tgl_kd_jbt);
						if ($this->kd_jbt_pgs->Exportable) $Doc->ExportField($this->kd_jbt_pgs);
						if ($this->tgl_kd_jbt_pgs->Exportable) $Doc->ExportField($this->tgl_kd_jbt_pgs);
						if ($this->kd_jbt_pjs->Exportable) $Doc->ExportField($this->kd_jbt_pjs);
						if ($this->tgl_kd_jbt_pjs->Exportable) $Doc->ExportField($this->tgl_kd_jbt_pjs);
						if ($this->kd_jbt_ps->Exportable) $Doc->ExportField($this->kd_jbt_ps);
						if ($this->tgl_kd_jbt_ps->Exportable) $Doc->ExportField($this->tgl_kd_jbt_ps);
						if ($this->kd_pat->Exportable) $Doc->ExportField($this->kd_pat);
						if ($this->kd_gas->Exportable) $Doc->ExportField($this->kd_gas);
						if ($this->pimp_empid->Exportable) $Doc->ExportField($this->pimp_empid);
						if ($this->stshift->Exportable) $Doc->ExportField($this->stshift);
						if ($this->no_rek->Exportable) $Doc->ExportField($this->no_rek);
						if ($this->kd_bank->Exportable) $Doc->ExportField($this->kd_bank);
						if ($this->kd_jamsostek->Exportable) $Doc->ExportField($this->kd_jamsostek);
						if ($this->acc_astek->Exportable) $Doc->ExportField($this->acc_astek);
						if ($this->acc_dapens->Exportable) $Doc->ExportField($this->acc_dapens);
						if ($this->acc_kes->Exportable) $Doc->ExportField($this->acc_kes);
						if ($this->st->Exportable) $Doc->ExportField($this->st);
						if ($this->signature->Exportable) $Doc->ExportField($this->signature);
						if ($this->created_by->Exportable) $Doc->ExportField($this->created_by);
						if ($this->created_date->Exportable) $Doc->ExportField($this->created_date);
						if ($this->last_update_by->Exportable) $Doc->ExportField($this->last_update_by);
						if ($this->last_update_date->Exportable) $Doc->ExportField($this->last_update_date);
						if ($this->fgr_print_id->Exportable) $Doc->ExportField($this->fgr_print_id);
						if ($this->kd_jbt_eselon->Exportable) $Doc->ExportField($this->kd_jbt_eselon);
						if ($this->npwp->Exportable) $Doc->ExportField($this->npwp);
						if ($this->paraf->Exportable) $Doc->ExportField($this->paraf);
						if ($this->tgl_keluar->Exportable) $Doc->ExportField($this->tgl_keluar);
						if ($this->nama_nasabah->Exportable) $Doc->ExportField($this->nama_nasabah);
						if ($this->no_ktp->Exportable) $Doc->ExportField($this->no_ktp);
						if ($this->no_kokar->Exportable) $Doc->ExportField($this->no_kokar);
						if ($this->no_bmw->Exportable) $Doc->ExportField($this->no_bmw);
						if ($this->no_bpjs_ketenagakerjaan->Exportable) $Doc->ExportField($this->no_bpjs_ketenagakerjaan);
						if ($this->no_bpjs_kesehatan->Exportable) $Doc->ExportField($this->no_bpjs_kesehatan);
						if ($this->eselon->Exportable) $Doc->ExportField($this->eselon);
						if ($this->kd_jenjang->Exportable) $Doc->ExportField($this->kd_jenjang);
						if ($this->kd_jbt_esl->Exportable) $Doc->ExportField($this->kd_jbt_esl);
						if ($this->tgl_jbt_esl->Exportable) $Doc->ExportField($this->tgl_jbt_esl);
						if ($this->org_id->Exportable) $Doc->ExportField($this->org_id);
						if ($this->picture->Exportable) $Doc->ExportField($this->picture);
						if ($this->kd_payroll->Exportable) $Doc->ExportField($this->kd_payroll);
						if ($this->id_wn->Exportable) $Doc->ExportField($this->id_wn);
						if ($this->no_anggota_kkms->Exportable) $Doc->ExportField($this->no_anggota_kkms);
					} else {
						if ($this->employee_id->Exportable) $Doc->ExportField($this->employee_id);
						if ($this->first_name->Exportable) $Doc->ExportField($this->first_name);
						if ($this->last_name->Exportable) $Doc->ExportField($this->last_name);
						if ($this->first_title->Exportable) $Doc->ExportField($this->first_title);
						if ($this->last_title->Exportable) $Doc->ExportField($this->last_title);
						if ($this->init->Exportable) $Doc->ExportField($this->init);
						if ($this->tpt_lahir->Exportable) $Doc->ExportField($this->tpt_lahir);
						if ($this->tgl_lahir->Exportable) $Doc->ExportField($this->tgl_lahir);
						if ($this->jk->Exportable) $Doc->ExportField($this->jk);
						if ($this->kd_agama->Exportable) $Doc->ExportField($this->kd_agama);
						if ($this->tgl_masuk->Exportable) $Doc->ExportField($this->tgl_masuk);
						if ($this->tpt_masuk->Exportable) $Doc->ExportField($this->tpt_masuk);
						if ($this->stkel->Exportable) $Doc->ExportField($this->stkel);
						if ($this->alamat->Exportable) $Doc->ExportField($this->alamat);
						if ($this->kota->Exportable) $Doc->ExportField($this->kota);
						if ($this->kd_pos->Exportable) $Doc->ExportField($this->kd_pos);
						if ($this->kd_propinsi->Exportable) $Doc->ExportField($this->kd_propinsi);
						if ($this->telp->Exportable) $Doc->ExportField($this->telp);
						if ($this->telp_area->Exportable) $Doc->ExportField($this->telp_area);
						if ($this->hp->Exportable) $Doc->ExportField($this->hp);
						if ($this->alamat_dom->Exportable) $Doc->ExportField($this->alamat_dom);
						if ($this->kota_dom->Exportable) $Doc->ExportField($this->kota_dom);
						if ($this->kd_pos_dom->Exportable) $Doc->ExportField($this->kd_pos_dom);
						if ($this->kd_propinsi_dom->Exportable) $Doc->ExportField($this->kd_propinsi_dom);
						if ($this->telp_dom->Exportable) $Doc->ExportField($this->telp_dom);
						if ($this->telp_dom_area->Exportable) $Doc->ExportField($this->telp_dom_area);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->kd_st_emp->Exportable) $Doc->ExportField($this->kd_st_emp);
						if ($this->skala->Exportable) $Doc->ExportField($this->skala);
						if ($this->gp->Exportable) $Doc->ExportField($this->gp);
						if ($this->upah_tetap->Exportable) $Doc->ExportField($this->upah_tetap);
						if ($this->tgl_honor->Exportable) $Doc->ExportField($this->tgl_honor);
						if ($this->honor->Exportable) $Doc->ExportField($this->honor);
						if ($this->premi_honor->Exportable) $Doc->ExportField($this->premi_honor);
						if ($this->tgl_gp->Exportable) $Doc->ExportField($this->tgl_gp);
						if ($this->skala_95->Exportable) $Doc->ExportField($this->skala_95);
						if ($this->gp_95->Exportable) $Doc->ExportField($this->gp_95);
						if ($this->tgl_gp_95->Exportable) $Doc->ExportField($this->tgl_gp_95);
						if ($this->kd_indx->Exportable) $Doc->ExportField($this->kd_indx);
						if ($this->indx_lok->Exportable) $Doc->ExportField($this->indx_lok);
						if ($this->gol_darah->Exportable) $Doc->ExportField($this->gol_darah);
						if ($this->kd_jbt->Exportable) $Doc->ExportField($this->kd_jbt);
						if ($this->tgl_kd_jbt->Exportable) $Doc->ExportField($this->tgl_kd_jbt);
						if ($this->kd_jbt_pgs->Exportable) $Doc->ExportField($this->kd_jbt_pgs);
						if ($this->tgl_kd_jbt_pgs->Exportable) $Doc->ExportField($this->tgl_kd_jbt_pgs);
						if ($this->kd_jbt_pjs->Exportable) $Doc->ExportField($this->kd_jbt_pjs);
						if ($this->tgl_kd_jbt_pjs->Exportable) $Doc->ExportField($this->tgl_kd_jbt_pjs);
						if ($this->kd_jbt_ps->Exportable) $Doc->ExportField($this->kd_jbt_ps);
						if ($this->tgl_kd_jbt_ps->Exportable) $Doc->ExportField($this->tgl_kd_jbt_ps);
						if ($this->kd_pat->Exportable) $Doc->ExportField($this->kd_pat);
						if ($this->kd_gas->Exportable) $Doc->ExportField($this->kd_gas);
						if ($this->pimp_empid->Exportable) $Doc->ExportField($this->pimp_empid);
						if ($this->stshift->Exportable) $Doc->ExportField($this->stshift);
						if ($this->no_rek->Exportable) $Doc->ExportField($this->no_rek);
						if ($this->kd_bank->Exportable) $Doc->ExportField($this->kd_bank);
						if ($this->kd_jamsostek->Exportable) $Doc->ExportField($this->kd_jamsostek);
						if ($this->acc_astek->Exportable) $Doc->ExportField($this->acc_astek);
						if ($this->acc_dapens->Exportable) $Doc->ExportField($this->acc_dapens);
						if ($this->acc_kes->Exportable) $Doc->ExportField($this->acc_kes);
						if ($this->st->Exportable) $Doc->ExportField($this->st);
						if ($this->created_by->Exportable) $Doc->ExportField($this->created_by);
						if ($this->created_date->Exportable) $Doc->ExportField($this->created_date);
						if ($this->last_update_by->Exportable) $Doc->ExportField($this->last_update_by);
						if ($this->last_update_date->Exportable) $Doc->ExportField($this->last_update_date);
						if ($this->fgr_print_id->Exportable) $Doc->ExportField($this->fgr_print_id);
						if ($this->kd_jbt_eselon->Exportable) $Doc->ExportField($this->kd_jbt_eselon);
						if ($this->npwp->Exportable) $Doc->ExportField($this->npwp);
						if ($this->tgl_keluar->Exportable) $Doc->ExportField($this->tgl_keluar);
						if ($this->nama_nasabah->Exportable) $Doc->ExportField($this->nama_nasabah);
						if ($this->no_ktp->Exportable) $Doc->ExportField($this->no_ktp);
						if ($this->no_kokar->Exportable) $Doc->ExportField($this->no_kokar);
						if ($this->no_bmw->Exportable) $Doc->ExportField($this->no_bmw);
						if ($this->no_bpjs_ketenagakerjaan->Exportable) $Doc->ExportField($this->no_bpjs_ketenagakerjaan);
						if ($this->no_bpjs_kesehatan->Exportable) $Doc->ExportField($this->no_bpjs_kesehatan);
						if ($this->eselon->Exportable) $Doc->ExportField($this->eselon);
						if ($this->kd_jenjang->Exportable) $Doc->ExportField($this->kd_jenjang);
						if ($this->kd_jbt_esl->Exportable) $Doc->ExportField($this->kd_jbt_esl);
						if ($this->tgl_jbt_esl->Exportable) $Doc->ExportField($this->tgl_jbt_esl);
						if ($this->org_id->Exportable) $Doc->ExportField($this->org_id);
						if ($this->kd_payroll->Exportable) $Doc->ExportField($this->kd_payroll);
						if ($this->id_wn->Exportable) $Doc->ExportField($this->id_wn);
						if ($this->no_anggota_kkms->Exportable) $Doc->ExportField($this->no_anggota_kkms);
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
