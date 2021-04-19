<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$users_delete = NULL; // Initialize page object first

class cusers_delete extends cusers {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (users)
		if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == "cusers") {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'users', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->nama_pegawai->SetVisibility();
		$this->username->SetVisibility();
		$this->kode_unit_organisasi->SetVisibility();
		$this->kode_unit_kerja->SetVisibility();
		$this->jabatan->SetVisibility();
		$this->user_group->SetVisibility();
		$this->status->SetVisibility();
		$this->nomor_anggota->SetVisibility();
		$this->nip->SetVisibility();
		$this->nip_lama->SetVisibility();
		$this->gelar_depan->SetVisibility();
		$this->gelar_belakang->SetVisibility();
		$this->pendidikan_terakhir->SetVisibility();
		$this->nama_lembaga->SetVisibility();
		$this->warga_negara->SetVisibility();
		$this->tempat_lahir->SetVisibility();
		$this->tanggal_lahir->SetVisibility();
		$this->jenis_kelamin->SetVisibility();
		$this->status_perkawinan->SetVisibility();
		$this->agama->SetVisibility();
		$this->nama_bank->SetVisibility();
		$this->no_rekening->SetVisibility();
		$this->change_date->SetVisibility();
		$this->change_by->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $users;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($users);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("userslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in users class, usersinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("userslist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->id->setDbValue($row['id']);
		$this->nama_pegawai->setDbValue($row['nama_pegawai']);
		$this->username->setDbValue($row['username']);
		$this->kode_unit_organisasi->setDbValue($row['kode_unit_organisasi']);
		$this->kode_unit_kerja->setDbValue($row['kode_unit_kerja']);
		$this->jabatan->setDbValue($row['jabatan']);
		$this->password->setDbValue($row['password']);
		$this->user_group->setDbValue($row['user_group']);
		$this->status->setDbValue($row['status']);
		$this->photo->setDbValue($row['photo']);
		$this->nomor_anggota->setDbValue($row['nomor_anggota']);
		$this->nip->setDbValue($row['nip']);
		$this->nip_lama->setDbValue($row['nip_lama']);
		$this->gelar_depan->setDbValue($row['gelar_depan']);
		$this->gelar_belakang->setDbValue($row['gelar_belakang']);
		$this->pendidikan_terakhir->setDbValue($row['pendidikan_terakhir']);
		$this->nama_lembaga->setDbValue($row['nama_lembaga']);
		$this->warga_negara->setDbValue($row['warga_negara']);
		$this->tempat_lahir->setDbValue($row['tempat_lahir']);
		$this->tanggal_lahir->setDbValue($row['tanggal_lahir']);
		$this->jenis_kelamin->setDbValue($row['jenis_kelamin']);
		$this->status_perkawinan->setDbValue($row['status_perkawinan']);
		$this->agama->setDbValue($row['agama']);
		$this->nama_bank->setDbValue($row['nama_bank']);
		$this->no_rekening->setDbValue($row['no_rekening']);
		$this->change_date->setDbValue($row['change_date']);
		$this->change_by->setDbValue($row['change_by']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['nama_pegawai'] = NULL;
		$row['username'] = NULL;
		$row['kode_unit_organisasi'] = NULL;
		$row['kode_unit_kerja'] = NULL;
		$row['jabatan'] = NULL;
		$row['password'] = NULL;
		$row['user_group'] = NULL;
		$row['status'] = NULL;
		$row['photo'] = NULL;
		$row['nomor_anggota'] = NULL;
		$row['nip'] = NULL;
		$row['nip_lama'] = NULL;
		$row['gelar_depan'] = NULL;
		$row['gelar_belakang'] = NULL;
		$row['pendidikan_terakhir'] = NULL;
		$row['nama_lembaga'] = NULL;
		$row['warga_negara'] = NULL;
		$row['tempat_lahir'] = NULL;
		$row['tanggal_lahir'] = NULL;
		$row['jenis_kelamin'] = NULL;
		$row['status_perkawinan'] = NULL;
		$row['agama'] = NULL;
		$row['nama_bank'] = NULL;
		$row['no_rekening'] = NULL;
		$row['change_date'] = NULL;
		$row['change_by'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->nama_pegawai->DbValue = $row['nama_pegawai'];
		$this->username->DbValue = $row['username'];
		$this->kode_unit_organisasi->DbValue = $row['kode_unit_organisasi'];
		$this->kode_unit_kerja->DbValue = $row['kode_unit_kerja'];
		$this->jabatan->DbValue = $row['jabatan'];
		$this->password->DbValue = $row['password'];
		$this->user_group->DbValue = $row['user_group'];
		$this->status->DbValue = $row['status'];
		$this->photo->DbValue = $row['photo'];
		$this->nomor_anggota->DbValue = $row['nomor_anggota'];
		$this->nip->DbValue = $row['nip'];
		$this->nip_lama->DbValue = $row['nip_lama'];
		$this->gelar_depan->DbValue = $row['gelar_depan'];
		$this->gelar_belakang->DbValue = $row['gelar_belakang'];
		$this->pendidikan_terakhir->DbValue = $row['pendidikan_terakhir'];
		$this->nama_lembaga->DbValue = $row['nama_lembaga'];
		$this->warga_negara->DbValue = $row['warga_negara'];
		$this->tempat_lahir->DbValue = $row['tempat_lahir'];
		$this->tanggal_lahir->DbValue = $row['tanggal_lahir'];
		$this->jenis_kelamin->DbValue = $row['jenis_kelamin'];
		$this->status_perkawinan->DbValue = $row['status_perkawinan'];
		$this->agama->DbValue = $row['agama'];
		$this->nama_bank->DbValue = $row['nama_bank'];
		$this->no_rekening->DbValue = $row['no_rekening'];
		$this->change_date->DbValue = $row['change_date'];
		$this->change_by->DbValue = $row['change_by'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

		// user_group
		$this->user_group->ViewValue = $this->user_group->CurrentValue;
		$this->user_group->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

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

			// user_group
			$this->user_group->LinkCustomAttributes = "";
			$this->user_group->HrefValue = "";
			$this->user_group->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("userslist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($users_delete)) $users_delete = new cusers_delete();

// Page init
$users_delete->Page_Init();

// Page main
$users_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fusersdelete = new ew_Form("fusersdelete", "delete");

// Form_CustomValidate event
fusersdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fusersdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $users_delete->ShowPageHeader(); ?>
<?php
$users_delete->ShowMessage();
?>
<form name="fusersdelete" id="fusersdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($users_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $users_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($users_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($users->id->Visible) { // id ?>
		<th class="<?php echo $users->id->HeaderCellClass() ?>"><span id="elh_users_id" class="users_id"><?php echo $users->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->nama_pegawai->Visible) { // nama_pegawai ?>
		<th class="<?php echo $users->nama_pegawai->HeaderCellClass() ?>"><span id="elh_users_nama_pegawai" class="users_nama_pegawai"><?php echo $users->nama_pegawai->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->username->Visible) { // username ?>
		<th class="<?php echo $users->username->HeaderCellClass() ?>"><span id="elh_users_username" class="users_username"><?php echo $users->username->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->kode_unit_organisasi->Visible) { // kode_unit_organisasi ?>
		<th class="<?php echo $users->kode_unit_organisasi->HeaderCellClass() ?>"><span id="elh_users_kode_unit_organisasi" class="users_kode_unit_organisasi"><?php echo $users->kode_unit_organisasi->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->kode_unit_kerja->Visible) { // kode_unit_kerja ?>
		<th class="<?php echo $users->kode_unit_kerja->HeaderCellClass() ?>"><span id="elh_users_kode_unit_kerja" class="users_kode_unit_kerja"><?php echo $users->kode_unit_kerja->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->jabatan->Visible) { // jabatan ?>
		<th class="<?php echo $users->jabatan->HeaderCellClass() ?>"><span id="elh_users_jabatan" class="users_jabatan"><?php echo $users->jabatan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->user_group->Visible) { // user_group ?>
		<th class="<?php echo $users->user_group->HeaderCellClass() ?>"><span id="elh_users_user_group" class="users_user_group"><?php echo $users->user_group->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->status->Visible) { // status ?>
		<th class="<?php echo $users->status->HeaderCellClass() ?>"><span id="elh_users_status" class="users_status"><?php echo $users->status->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->nomor_anggota->Visible) { // nomor_anggota ?>
		<th class="<?php echo $users->nomor_anggota->HeaderCellClass() ?>"><span id="elh_users_nomor_anggota" class="users_nomor_anggota"><?php echo $users->nomor_anggota->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->nip->Visible) { // nip ?>
		<th class="<?php echo $users->nip->HeaderCellClass() ?>"><span id="elh_users_nip" class="users_nip"><?php echo $users->nip->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->nip_lama->Visible) { // nip_lama ?>
		<th class="<?php echo $users->nip_lama->HeaderCellClass() ?>"><span id="elh_users_nip_lama" class="users_nip_lama"><?php echo $users->nip_lama->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->gelar_depan->Visible) { // gelar_depan ?>
		<th class="<?php echo $users->gelar_depan->HeaderCellClass() ?>"><span id="elh_users_gelar_depan" class="users_gelar_depan"><?php echo $users->gelar_depan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->gelar_belakang->Visible) { // gelar_belakang ?>
		<th class="<?php echo $users->gelar_belakang->HeaderCellClass() ?>"><span id="elh_users_gelar_belakang" class="users_gelar_belakang"><?php echo $users->gelar_belakang->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->pendidikan_terakhir->Visible) { // pendidikan_terakhir ?>
		<th class="<?php echo $users->pendidikan_terakhir->HeaderCellClass() ?>"><span id="elh_users_pendidikan_terakhir" class="users_pendidikan_terakhir"><?php echo $users->pendidikan_terakhir->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->nama_lembaga->Visible) { // nama_lembaga ?>
		<th class="<?php echo $users->nama_lembaga->HeaderCellClass() ?>"><span id="elh_users_nama_lembaga" class="users_nama_lembaga"><?php echo $users->nama_lembaga->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->warga_negara->Visible) { // warga_negara ?>
		<th class="<?php echo $users->warga_negara->HeaderCellClass() ?>"><span id="elh_users_warga_negara" class="users_warga_negara"><?php echo $users->warga_negara->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->tempat_lahir->Visible) { // tempat_lahir ?>
		<th class="<?php echo $users->tempat_lahir->HeaderCellClass() ?>"><span id="elh_users_tempat_lahir" class="users_tempat_lahir"><?php echo $users->tempat_lahir->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->tanggal_lahir->Visible) { // tanggal_lahir ?>
		<th class="<?php echo $users->tanggal_lahir->HeaderCellClass() ?>"><span id="elh_users_tanggal_lahir" class="users_tanggal_lahir"><?php echo $users->tanggal_lahir->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->jenis_kelamin->Visible) { // jenis_kelamin ?>
		<th class="<?php echo $users->jenis_kelamin->HeaderCellClass() ?>"><span id="elh_users_jenis_kelamin" class="users_jenis_kelamin"><?php echo $users->jenis_kelamin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->status_perkawinan->Visible) { // status_perkawinan ?>
		<th class="<?php echo $users->status_perkawinan->HeaderCellClass() ?>"><span id="elh_users_status_perkawinan" class="users_status_perkawinan"><?php echo $users->status_perkawinan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->agama->Visible) { // agama ?>
		<th class="<?php echo $users->agama->HeaderCellClass() ?>"><span id="elh_users_agama" class="users_agama"><?php echo $users->agama->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->nama_bank->Visible) { // nama_bank ?>
		<th class="<?php echo $users->nama_bank->HeaderCellClass() ?>"><span id="elh_users_nama_bank" class="users_nama_bank"><?php echo $users->nama_bank->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->no_rekening->Visible) { // no_rekening ?>
		<th class="<?php echo $users->no_rekening->HeaderCellClass() ?>"><span id="elh_users_no_rekening" class="users_no_rekening"><?php echo $users->no_rekening->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->change_date->Visible) { // change_date ?>
		<th class="<?php echo $users->change_date->HeaderCellClass() ?>"><span id="elh_users_change_date" class="users_change_date"><?php echo $users->change_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->change_by->Visible) { // change_by ?>
		<th class="<?php echo $users->change_by->HeaderCellClass() ?>"><span id="elh_users_change_by" class="users_change_by"><?php echo $users->change_by->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$users_delete->RecCnt = 0;
$i = 0;
while (!$users_delete->Recordset->EOF) {
	$users_delete->RecCnt++;
	$users_delete->RowCnt++;

	// Set row properties
	$users->ResetAttrs();
	$users->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$users_delete->LoadRowValues($users_delete->Recordset);

	// Render row
	$users_delete->RenderRow();
?>
	<tr<?php echo $users->RowAttributes() ?>>
<?php if ($users->id->Visible) { // id ?>
		<td<?php echo $users->id->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_id" class="users_id">
<span<?php echo $users->id->ViewAttributes() ?>>
<?php echo $users->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->nama_pegawai->Visible) { // nama_pegawai ?>
		<td<?php echo $users->nama_pegawai->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_nama_pegawai" class="users_nama_pegawai">
<span<?php echo $users->nama_pegawai->ViewAttributes() ?>>
<?php echo $users->nama_pegawai->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->username->Visible) { // username ?>
		<td<?php echo $users->username->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_username" class="users_username">
<span<?php echo $users->username->ViewAttributes() ?>>
<?php echo $users->username->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->kode_unit_organisasi->Visible) { // kode_unit_organisasi ?>
		<td<?php echo $users->kode_unit_organisasi->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_kode_unit_organisasi" class="users_kode_unit_organisasi">
<span<?php echo $users->kode_unit_organisasi->ViewAttributes() ?>>
<?php echo $users->kode_unit_organisasi->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->kode_unit_kerja->Visible) { // kode_unit_kerja ?>
		<td<?php echo $users->kode_unit_kerja->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_kode_unit_kerja" class="users_kode_unit_kerja">
<span<?php echo $users->kode_unit_kerja->ViewAttributes() ?>>
<?php echo $users->kode_unit_kerja->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->jabatan->Visible) { // jabatan ?>
		<td<?php echo $users->jabatan->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_jabatan" class="users_jabatan">
<span<?php echo $users->jabatan->ViewAttributes() ?>>
<?php echo $users->jabatan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->user_group->Visible) { // user_group ?>
		<td<?php echo $users->user_group->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_user_group" class="users_user_group">
<span<?php echo $users->user_group->ViewAttributes() ?>>
<?php echo $users->user_group->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->status->Visible) { // status ?>
		<td<?php echo $users->status->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_status" class="users_status">
<span<?php echo $users->status->ViewAttributes() ?>>
<?php echo $users->status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->nomor_anggota->Visible) { // nomor_anggota ?>
		<td<?php echo $users->nomor_anggota->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_nomor_anggota" class="users_nomor_anggota">
<span<?php echo $users->nomor_anggota->ViewAttributes() ?>>
<?php echo $users->nomor_anggota->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->nip->Visible) { // nip ?>
		<td<?php echo $users->nip->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_nip" class="users_nip">
<span<?php echo $users->nip->ViewAttributes() ?>>
<?php echo $users->nip->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->nip_lama->Visible) { // nip_lama ?>
		<td<?php echo $users->nip_lama->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_nip_lama" class="users_nip_lama">
<span<?php echo $users->nip_lama->ViewAttributes() ?>>
<?php echo $users->nip_lama->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->gelar_depan->Visible) { // gelar_depan ?>
		<td<?php echo $users->gelar_depan->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_gelar_depan" class="users_gelar_depan">
<span<?php echo $users->gelar_depan->ViewAttributes() ?>>
<?php echo $users->gelar_depan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->gelar_belakang->Visible) { // gelar_belakang ?>
		<td<?php echo $users->gelar_belakang->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_gelar_belakang" class="users_gelar_belakang">
<span<?php echo $users->gelar_belakang->ViewAttributes() ?>>
<?php echo $users->gelar_belakang->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->pendidikan_terakhir->Visible) { // pendidikan_terakhir ?>
		<td<?php echo $users->pendidikan_terakhir->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_pendidikan_terakhir" class="users_pendidikan_terakhir">
<span<?php echo $users->pendidikan_terakhir->ViewAttributes() ?>>
<?php echo $users->pendidikan_terakhir->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->nama_lembaga->Visible) { // nama_lembaga ?>
		<td<?php echo $users->nama_lembaga->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_nama_lembaga" class="users_nama_lembaga">
<span<?php echo $users->nama_lembaga->ViewAttributes() ?>>
<?php echo $users->nama_lembaga->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->warga_negara->Visible) { // warga_negara ?>
		<td<?php echo $users->warga_negara->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_warga_negara" class="users_warga_negara">
<span<?php echo $users->warga_negara->ViewAttributes() ?>>
<?php echo $users->warga_negara->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->tempat_lahir->Visible) { // tempat_lahir ?>
		<td<?php echo $users->tempat_lahir->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_tempat_lahir" class="users_tempat_lahir">
<span<?php echo $users->tempat_lahir->ViewAttributes() ?>>
<?php echo $users->tempat_lahir->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->tanggal_lahir->Visible) { // tanggal_lahir ?>
		<td<?php echo $users->tanggal_lahir->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_tanggal_lahir" class="users_tanggal_lahir">
<span<?php echo $users->tanggal_lahir->ViewAttributes() ?>>
<?php echo $users->tanggal_lahir->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->jenis_kelamin->Visible) { // jenis_kelamin ?>
		<td<?php echo $users->jenis_kelamin->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_jenis_kelamin" class="users_jenis_kelamin">
<span<?php echo $users->jenis_kelamin->ViewAttributes() ?>>
<?php echo $users->jenis_kelamin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->status_perkawinan->Visible) { // status_perkawinan ?>
		<td<?php echo $users->status_perkawinan->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_status_perkawinan" class="users_status_perkawinan">
<span<?php echo $users->status_perkawinan->ViewAttributes() ?>>
<?php echo $users->status_perkawinan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->agama->Visible) { // agama ?>
		<td<?php echo $users->agama->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_agama" class="users_agama">
<span<?php echo $users->agama->ViewAttributes() ?>>
<?php echo $users->agama->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->nama_bank->Visible) { // nama_bank ?>
		<td<?php echo $users->nama_bank->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_nama_bank" class="users_nama_bank">
<span<?php echo $users->nama_bank->ViewAttributes() ?>>
<?php echo $users->nama_bank->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->no_rekening->Visible) { // no_rekening ?>
		<td<?php echo $users->no_rekening->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_no_rekening" class="users_no_rekening">
<span<?php echo $users->no_rekening->ViewAttributes() ?>>
<?php echo $users->no_rekening->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->change_date->Visible) { // change_date ?>
		<td<?php echo $users->change_date->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_change_date" class="users_change_date">
<span<?php echo $users->change_date->ViewAttributes() ?>>
<?php echo $users->change_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->change_by->Visible) { // change_by ?>
		<td<?php echo $users->change_by->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_change_by" class="users_change_by">
<span<?php echo $users->change_by->ViewAttributes() ?>>
<?php echo $users->change_by->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$users_delete->Recordset->MoveNext();
}
$users_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $users_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fusersdelete.Init();
</script>
<?php
$users_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$users_delete->Page_Terminate();
?>
