<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "rwy_pendidikaninfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$rwy_pendidikan_add = NULL; // Initialize page object first

class crwy_pendidikan_add extends crwy_pendidikan {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'rwy_pendidikan';

	// Page object name
	var $PageObjName = 'rwy_pendidikan_add';

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

		// Table object (rwy_pendidikan)
		if (!isset($GLOBALS["rwy_pendidikan"]) || get_class($GLOBALS["rwy_pendidikan"]) == "crwy_pendidikan") {
			$GLOBALS["rwy_pendidikan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["rwy_pendidikan"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rwy_pendidikan', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->nip->SetVisibility();
		$this->pendidikan_terakhir->SetVisibility();
		$this->jurusan->SetVisibility();
		$this->nama_lembaga->SetVisibility();
		$this->no_ijazah->SetVisibility();
		$this->tanggal_ijazah->SetVisibility();
		$this->lokasi_pendidikan->SetVisibility();
		$this->stat_validasi->SetVisibility();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $rwy_pendidikan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($rwy_pendidikan);
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "rwy_pendidikanview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("rwy_pendidikanlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "rwy_pendidikanlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "rwy_pendidikanview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
		$this->nip->CurrentValue = NULL;
		$this->nip->OldValue = $this->nip->CurrentValue;
		$this->pendidikan_terakhir->CurrentValue = NULL;
		$this->pendidikan_terakhir->OldValue = $this->pendidikan_terakhir->CurrentValue;
		$this->jurusan->CurrentValue = NULL;
		$this->jurusan->OldValue = $this->jurusan->CurrentValue;
		$this->nama_lembaga->CurrentValue = NULL;
		$this->nama_lembaga->OldValue = $this->nama_lembaga->CurrentValue;
		$this->no_ijazah->CurrentValue = NULL;
		$this->no_ijazah->OldValue = $this->no_ijazah->CurrentValue;
		$this->tanggal_ijazah->CurrentValue = NULL;
		$this->tanggal_ijazah->OldValue = $this->tanggal_ijazah->CurrentValue;
		$this->lokasi_pendidikan->CurrentValue = NULL;
		$this->lokasi_pendidikan->OldValue = $this->lokasi_pendidikan->CurrentValue;
		$this->stat_validasi->CurrentValue = NULL;
		$this->stat_validasi->OldValue = $this->stat_validasi->CurrentValue;
		$this->change_date->CurrentValue = NULL;
		$this->change_date->OldValue = $this->change_date->CurrentValue;
		$this->change_by->CurrentValue = NULL;
		$this->change_by->OldValue = $this->change_by->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nip->FldIsDetailKey) {
			$this->nip->setFormValue($objForm->GetValue("x_nip"));
		}
		if (!$this->pendidikan_terakhir->FldIsDetailKey) {
			$this->pendidikan_terakhir->setFormValue($objForm->GetValue("x_pendidikan_terakhir"));
		}
		if (!$this->jurusan->FldIsDetailKey) {
			$this->jurusan->setFormValue($objForm->GetValue("x_jurusan"));
		}
		if (!$this->nama_lembaga->FldIsDetailKey) {
			$this->nama_lembaga->setFormValue($objForm->GetValue("x_nama_lembaga"));
		}
		if (!$this->no_ijazah->FldIsDetailKey) {
			$this->no_ijazah->setFormValue($objForm->GetValue("x_no_ijazah"));
		}
		if (!$this->tanggal_ijazah->FldIsDetailKey) {
			$this->tanggal_ijazah->setFormValue($objForm->GetValue("x_tanggal_ijazah"));
			$this->tanggal_ijazah->CurrentValue = ew_UnFormatDateTime($this->tanggal_ijazah->CurrentValue, 0);
		}
		if (!$this->lokasi_pendidikan->FldIsDetailKey) {
			$this->lokasi_pendidikan->setFormValue($objForm->GetValue("x_lokasi_pendidikan"));
		}
		if (!$this->stat_validasi->FldIsDetailKey) {
			$this->stat_validasi->setFormValue($objForm->GetValue("x_stat_validasi"));
		}
		if (!$this->change_date->FldIsDetailKey) {
			$this->change_date->setFormValue($objForm->GetValue("x_change_date"));
			$this->change_date->CurrentValue = ew_UnFormatDateTime($this->change_date->CurrentValue, 0);
		}
		if (!$this->change_by->FldIsDetailKey) {
			$this->change_by->setFormValue($objForm->GetValue("x_change_by"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->nip->CurrentValue = $this->nip->FormValue;
		$this->pendidikan_terakhir->CurrentValue = $this->pendidikan_terakhir->FormValue;
		$this->jurusan->CurrentValue = $this->jurusan->FormValue;
		$this->nama_lembaga->CurrentValue = $this->nama_lembaga->FormValue;
		$this->no_ijazah->CurrentValue = $this->no_ijazah->FormValue;
		$this->tanggal_ijazah->CurrentValue = $this->tanggal_ijazah->FormValue;
		$this->tanggal_ijazah->CurrentValue = ew_UnFormatDateTime($this->tanggal_ijazah->CurrentValue, 0);
		$this->lokasi_pendidikan->CurrentValue = $this->lokasi_pendidikan->FormValue;
		$this->stat_validasi->CurrentValue = $this->stat_validasi->FormValue;
		$this->change_date->CurrentValue = $this->change_date->FormValue;
		$this->change_date->CurrentValue = ew_UnFormatDateTime($this->change_date->CurrentValue, 0);
		$this->change_by->CurrentValue = $this->change_by->FormValue;
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
		$this->nip->setDbValue($row['nip']);
		$this->pendidikan_terakhir->setDbValue($row['pendidikan_terakhir']);
		$this->jurusan->setDbValue($row['jurusan']);
		$this->nama_lembaga->setDbValue($row['nama_lembaga']);
		$this->no_ijazah->setDbValue($row['no_ijazah']);
		$this->tanggal_ijazah->setDbValue($row['tanggal_ijazah']);
		$this->lokasi_pendidikan->setDbValue($row['lokasi_pendidikan']);
		$this->stat_validasi->setDbValue($row['stat_validasi']);
		$this->change_date->setDbValue($row['change_date']);
		$this->change_by->setDbValue($row['change_by']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['nip'] = $this->nip->CurrentValue;
		$row['pendidikan_terakhir'] = $this->pendidikan_terakhir->CurrentValue;
		$row['jurusan'] = $this->jurusan->CurrentValue;
		$row['nama_lembaga'] = $this->nama_lembaga->CurrentValue;
		$row['no_ijazah'] = $this->no_ijazah->CurrentValue;
		$row['tanggal_ijazah'] = $this->tanggal_ijazah->CurrentValue;
		$row['lokasi_pendidikan'] = $this->lokasi_pendidikan->CurrentValue;
		$row['stat_validasi'] = $this->stat_validasi->CurrentValue;
		$row['change_date'] = $this->change_date->CurrentValue;
		$row['change_by'] = $this->change_by->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->nip->DbValue = $row['nip'];
		$this->pendidikan_terakhir->DbValue = $row['pendidikan_terakhir'];
		$this->jurusan->DbValue = $row['jurusan'];
		$this->nama_lembaga->DbValue = $row['nama_lembaga'];
		$this->no_ijazah->DbValue = $row['no_ijazah'];
		$this->tanggal_ijazah->DbValue = $row['tanggal_ijazah'];
		$this->lokasi_pendidikan->DbValue = $row['lokasi_pendidikan'];
		$this->stat_validasi->DbValue = $row['stat_validasi'];
		$this->change_date->DbValue = $row['change_date'];
		$this->change_by->DbValue = $row['change_by'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nip
			$this->nip->EditAttrs["class"] = "form-control";
			$this->nip->EditCustomAttributes = "";
			$this->nip->EditValue = ew_HtmlEncode($this->nip->CurrentValue);
			$this->nip->PlaceHolder = ew_RemoveHtml($this->nip->FldCaption());

			// pendidikan_terakhir
			$this->pendidikan_terakhir->EditAttrs["class"] = "form-control";
			$this->pendidikan_terakhir->EditCustomAttributes = "";
			$this->pendidikan_terakhir->EditValue = ew_HtmlEncode($this->pendidikan_terakhir->CurrentValue);
			$this->pendidikan_terakhir->PlaceHolder = ew_RemoveHtml($this->pendidikan_terakhir->FldCaption());

			// jurusan
			$this->jurusan->EditAttrs["class"] = "form-control";
			$this->jurusan->EditCustomAttributes = "";
			$this->jurusan->EditValue = ew_HtmlEncode($this->jurusan->CurrentValue);
			$this->jurusan->PlaceHolder = ew_RemoveHtml($this->jurusan->FldCaption());

			// nama_lembaga
			$this->nama_lembaga->EditAttrs["class"] = "form-control";
			$this->nama_lembaga->EditCustomAttributes = "";
			$this->nama_lembaga->EditValue = ew_HtmlEncode($this->nama_lembaga->CurrentValue);
			$this->nama_lembaga->PlaceHolder = ew_RemoveHtml($this->nama_lembaga->FldCaption());

			// no_ijazah
			$this->no_ijazah->EditAttrs["class"] = "form-control";
			$this->no_ijazah->EditCustomAttributes = "";
			$this->no_ijazah->EditValue = ew_HtmlEncode($this->no_ijazah->CurrentValue);
			$this->no_ijazah->PlaceHolder = ew_RemoveHtml($this->no_ijazah->FldCaption());

			// tanggal_ijazah
			$this->tanggal_ijazah->EditAttrs["class"] = "form-control";
			$this->tanggal_ijazah->EditCustomAttributes = "";
			$this->tanggal_ijazah->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tanggal_ijazah->CurrentValue, 8));
			$this->tanggal_ijazah->PlaceHolder = ew_RemoveHtml($this->tanggal_ijazah->FldCaption());

			// lokasi_pendidikan
			$this->lokasi_pendidikan->EditAttrs["class"] = "form-control";
			$this->lokasi_pendidikan->EditCustomAttributes = "";
			$this->lokasi_pendidikan->EditValue = ew_HtmlEncode($this->lokasi_pendidikan->CurrentValue);
			$this->lokasi_pendidikan->PlaceHolder = ew_RemoveHtml($this->lokasi_pendidikan->FldCaption());

			// stat_validasi
			$this->stat_validasi->EditAttrs["class"] = "form-control";
			$this->stat_validasi->EditCustomAttributes = "";
			$this->stat_validasi->EditValue = ew_HtmlEncode($this->stat_validasi->CurrentValue);
			$this->stat_validasi->PlaceHolder = ew_RemoveHtml($this->stat_validasi->FldCaption());

			// change_date
			$this->change_date->EditAttrs["class"] = "form-control";
			$this->change_date->EditCustomAttributes = "";
			$this->change_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->change_date->CurrentValue, 8));
			$this->change_date->PlaceHolder = ew_RemoveHtml($this->change_date->FldCaption());

			// change_by
			$this->change_by->EditAttrs["class"] = "form-control";
			$this->change_by->EditCustomAttributes = "";
			$this->change_by->EditValue = ew_HtmlEncode($this->change_by->CurrentValue);
			$this->change_by->PlaceHolder = ew_RemoveHtml($this->change_by->FldCaption());

			// Add refer script
			// nip

			$this->nip->LinkCustomAttributes = "";
			$this->nip->HrefValue = "";

			// pendidikan_terakhir
			$this->pendidikan_terakhir->LinkCustomAttributes = "";
			$this->pendidikan_terakhir->HrefValue = "";

			// jurusan
			$this->jurusan->LinkCustomAttributes = "";
			$this->jurusan->HrefValue = "";

			// nama_lembaga
			$this->nama_lembaga->LinkCustomAttributes = "";
			$this->nama_lembaga->HrefValue = "";

			// no_ijazah
			$this->no_ijazah->LinkCustomAttributes = "";
			$this->no_ijazah->HrefValue = "";

			// tanggal_ijazah
			$this->tanggal_ijazah->LinkCustomAttributes = "";
			$this->tanggal_ijazah->HrefValue = "";

			// lokasi_pendidikan
			$this->lokasi_pendidikan->LinkCustomAttributes = "";
			$this->lokasi_pendidikan->HrefValue = "";

			// stat_validasi
			$this->stat_validasi->LinkCustomAttributes = "";
			$this->stat_validasi->HrefValue = "";

			// change_date
			$this->change_date->LinkCustomAttributes = "";
			$this->change_date->HrefValue = "";

			// change_by
			$this->change_by->LinkCustomAttributes = "";
			$this->change_by->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckDateDef($this->tanggal_ijazah->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal_ijazah->FldErrMsg());
		}
		if (!ew_CheckInteger($this->stat_validasi->FormValue)) {
			ew_AddMessage($gsFormError, $this->stat_validasi->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->change_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->change_date->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// nip
		$this->nip->SetDbValueDef($rsnew, $this->nip->CurrentValue, NULL, FALSE);

		// pendidikan_terakhir
		$this->pendidikan_terakhir->SetDbValueDef($rsnew, $this->pendidikan_terakhir->CurrentValue, NULL, FALSE);

		// jurusan
		$this->jurusan->SetDbValueDef($rsnew, $this->jurusan->CurrentValue, NULL, FALSE);

		// nama_lembaga
		$this->nama_lembaga->SetDbValueDef($rsnew, $this->nama_lembaga->CurrentValue, NULL, FALSE);

		// no_ijazah
		$this->no_ijazah->SetDbValueDef($rsnew, $this->no_ijazah->CurrentValue, NULL, FALSE);

		// tanggal_ijazah
		$this->tanggal_ijazah->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal_ijazah->CurrentValue, 0), NULL, FALSE);

		// lokasi_pendidikan
		$this->lokasi_pendidikan->SetDbValueDef($rsnew, $this->lokasi_pendidikan->CurrentValue, NULL, FALSE);

		// stat_validasi
		$this->stat_validasi->SetDbValueDef($rsnew, $this->stat_validasi->CurrentValue, NULL, FALSE);

		// change_date
		$this->change_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->change_date->CurrentValue, 0), NULL, FALSE);

		// change_by
		$this->change_by->SetDbValueDef($rsnew, $this->change_by->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("rwy_pendidikanlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($rwy_pendidikan_add)) $rwy_pendidikan_add = new crwy_pendidikan_add();

// Page init
$rwy_pendidikan_add->Page_Init();

// Page main
$rwy_pendidikan_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$rwy_pendidikan_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = frwy_pendidikanadd = new ew_Form("frwy_pendidikanadd", "add");

// Validate form
frwy_pendidikanadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_tanggal_ijazah");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_pendidikan->tanggal_ijazah->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_stat_validasi");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_pendidikan->stat_validasi->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_change_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_pendidikan->change_date->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
frwy_pendidikanadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
frwy_pendidikanadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $rwy_pendidikan_add->ShowPageHeader(); ?>
<?php
$rwy_pendidikan_add->ShowMessage();
?>
<form name="frwy_pendidikanadd" id="frwy_pendidikanadd" class="<?php echo $rwy_pendidikan_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($rwy_pendidikan_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $rwy_pendidikan_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="rwy_pendidikan">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($rwy_pendidikan_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($rwy_pendidikan->nip->Visible) { // nip ?>
	<div id="r_nip" class="form-group">
		<label id="elh_rwy_pendidikan_nip" for="x_nip" class="<?php echo $rwy_pendidikan_add->LeftColumnClass ?>"><?php echo $rwy_pendidikan->nip->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_add->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->nip->CellAttributes() ?>>
<span id="el_rwy_pendidikan_nip">
<input type="text" data-table="rwy_pendidikan" data-field="x_nip" name="x_nip" id="x_nip" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->nip->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->nip->EditValue ?>"<?php echo $rwy_pendidikan->nip->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->nip->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->pendidikan_terakhir->Visible) { // pendidikan_terakhir ?>
	<div id="r_pendidikan_terakhir" class="form-group">
		<label id="elh_rwy_pendidikan_pendidikan_terakhir" for="x_pendidikan_terakhir" class="<?php echo $rwy_pendidikan_add->LeftColumnClass ?>"><?php echo $rwy_pendidikan->pendidikan_terakhir->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_add->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->pendidikan_terakhir->CellAttributes() ?>>
<span id="el_rwy_pendidikan_pendidikan_terakhir">
<input type="text" data-table="rwy_pendidikan" data-field="x_pendidikan_terakhir" name="x_pendidikan_terakhir" id="x_pendidikan_terakhir" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->pendidikan_terakhir->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->pendidikan_terakhir->EditValue ?>"<?php echo $rwy_pendidikan->pendidikan_terakhir->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->pendidikan_terakhir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->jurusan->Visible) { // jurusan ?>
	<div id="r_jurusan" class="form-group">
		<label id="elh_rwy_pendidikan_jurusan" for="x_jurusan" class="<?php echo $rwy_pendidikan_add->LeftColumnClass ?>"><?php echo $rwy_pendidikan->jurusan->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_add->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->jurusan->CellAttributes() ?>>
<span id="el_rwy_pendidikan_jurusan">
<input type="text" data-table="rwy_pendidikan" data-field="x_jurusan" name="x_jurusan" id="x_jurusan" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->jurusan->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->jurusan->EditValue ?>"<?php echo $rwy_pendidikan->jurusan->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->jurusan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->nama_lembaga->Visible) { // nama_lembaga ?>
	<div id="r_nama_lembaga" class="form-group">
		<label id="elh_rwy_pendidikan_nama_lembaga" for="x_nama_lembaga" class="<?php echo $rwy_pendidikan_add->LeftColumnClass ?>"><?php echo $rwy_pendidikan->nama_lembaga->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_add->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->nama_lembaga->CellAttributes() ?>>
<span id="el_rwy_pendidikan_nama_lembaga">
<input type="text" data-table="rwy_pendidikan" data-field="x_nama_lembaga" name="x_nama_lembaga" id="x_nama_lembaga" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->nama_lembaga->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->nama_lembaga->EditValue ?>"<?php echo $rwy_pendidikan->nama_lembaga->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->nama_lembaga->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->no_ijazah->Visible) { // no_ijazah ?>
	<div id="r_no_ijazah" class="form-group">
		<label id="elh_rwy_pendidikan_no_ijazah" for="x_no_ijazah" class="<?php echo $rwy_pendidikan_add->LeftColumnClass ?>"><?php echo $rwy_pendidikan->no_ijazah->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_add->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->no_ijazah->CellAttributes() ?>>
<span id="el_rwy_pendidikan_no_ijazah">
<input type="text" data-table="rwy_pendidikan" data-field="x_no_ijazah" name="x_no_ijazah" id="x_no_ijazah" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->no_ijazah->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->no_ijazah->EditValue ?>"<?php echo $rwy_pendidikan->no_ijazah->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->no_ijazah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->tanggal_ijazah->Visible) { // tanggal_ijazah ?>
	<div id="r_tanggal_ijazah" class="form-group">
		<label id="elh_rwy_pendidikan_tanggal_ijazah" for="x_tanggal_ijazah" class="<?php echo $rwy_pendidikan_add->LeftColumnClass ?>"><?php echo $rwy_pendidikan->tanggal_ijazah->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_add->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->tanggal_ijazah->CellAttributes() ?>>
<span id="el_rwy_pendidikan_tanggal_ijazah">
<input type="text" data-table="rwy_pendidikan" data-field="x_tanggal_ijazah" name="x_tanggal_ijazah" id="x_tanggal_ijazah" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->tanggal_ijazah->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->tanggal_ijazah->EditValue ?>"<?php echo $rwy_pendidikan->tanggal_ijazah->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->tanggal_ijazah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->lokasi_pendidikan->Visible) { // lokasi_pendidikan ?>
	<div id="r_lokasi_pendidikan" class="form-group">
		<label id="elh_rwy_pendidikan_lokasi_pendidikan" for="x_lokasi_pendidikan" class="<?php echo $rwy_pendidikan_add->LeftColumnClass ?>"><?php echo $rwy_pendidikan->lokasi_pendidikan->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_add->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->lokasi_pendidikan->CellAttributes() ?>>
<span id="el_rwy_pendidikan_lokasi_pendidikan">
<input type="text" data-table="rwy_pendidikan" data-field="x_lokasi_pendidikan" name="x_lokasi_pendidikan" id="x_lokasi_pendidikan" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->lokasi_pendidikan->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->lokasi_pendidikan->EditValue ?>"<?php echo $rwy_pendidikan->lokasi_pendidikan->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->lokasi_pendidikan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->stat_validasi->Visible) { // stat_validasi ?>
	<div id="r_stat_validasi" class="form-group">
		<label id="elh_rwy_pendidikan_stat_validasi" for="x_stat_validasi" class="<?php echo $rwy_pendidikan_add->LeftColumnClass ?>"><?php echo $rwy_pendidikan->stat_validasi->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_add->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->stat_validasi->CellAttributes() ?>>
<span id="el_rwy_pendidikan_stat_validasi">
<input type="text" data-table="rwy_pendidikan" data-field="x_stat_validasi" name="x_stat_validasi" id="x_stat_validasi" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->stat_validasi->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->stat_validasi->EditValue ?>"<?php echo $rwy_pendidikan->stat_validasi->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->stat_validasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->change_date->Visible) { // change_date ?>
	<div id="r_change_date" class="form-group">
		<label id="elh_rwy_pendidikan_change_date" for="x_change_date" class="<?php echo $rwy_pendidikan_add->LeftColumnClass ?>"><?php echo $rwy_pendidikan->change_date->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_add->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->change_date->CellAttributes() ?>>
<span id="el_rwy_pendidikan_change_date">
<input type="text" data-table="rwy_pendidikan" data-field="x_change_date" name="x_change_date" id="x_change_date" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->change_date->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->change_date->EditValue ?>"<?php echo $rwy_pendidikan->change_date->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->change_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->change_by->Visible) { // change_by ?>
	<div id="r_change_by" class="form-group">
		<label id="elh_rwy_pendidikan_change_by" for="x_change_by" class="<?php echo $rwy_pendidikan_add->LeftColumnClass ?>"><?php echo $rwy_pendidikan->change_by->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_add->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->change_by->CellAttributes() ?>>
<span id="el_rwy_pendidikan_change_by">
<input type="text" data-table="rwy_pendidikan" data-field="x_change_by" name="x_change_by" id="x_change_by" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->change_by->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->change_by->EditValue ?>"<?php echo $rwy_pendidikan->change_by->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->change_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$rwy_pendidikan_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $rwy_pendidikan_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $rwy_pendidikan_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
frwy_pendidikanadd.Init();
</script>
<?php
$rwy_pendidikan_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$rwy_pendidikan_add->Page_Terminate();
?>
