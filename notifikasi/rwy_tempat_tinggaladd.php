<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "rwy_tempat_tinggalinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$rwy_tempat_tinggal_add = NULL; // Initialize page object first

class crwy_tempat_tinggal_add extends crwy_tempat_tinggal {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'rwy_tempat_tinggal';

	// Page object name
	var $PageObjName = 'rwy_tempat_tinggal_add';

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

		// Table object (rwy_tempat_tinggal)
		if (!isset($GLOBALS["rwy_tempat_tinggal"]) || get_class($GLOBALS["rwy_tempat_tinggal"]) == "crwy_tempat_tinggal") {
			$GLOBALS["rwy_tempat_tinggal"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["rwy_tempat_tinggal"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rwy_tempat_tinggal', TRUE);

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
		$this->propinsi->SetVisibility();
		$this->kab_kota->SetVisibility();
		$this->kelurahan->SetVisibility();
		$this->alamat->SetVisibility();
		$this->tanggal_mulai_ditempati->SetVisibility();
		$this->tanggal_berakhir_ditempati->SetVisibility();
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
		global $EW_EXPORT, $rwy_tempat_tinggal;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($rwy_tempat_tinggal);
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
					if ($pageName == "rwy_tempat_tinggalview.php")
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
					$this->Page_Terminate("rwy_tempat_tinggallist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "rwy_tempat_tinggallist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "rwy_tempat_tinggalview.php")
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
		$this->propinsi->CurrentValue = NULL;
		$this->propinsi->OldValue = $this->propinsi->CurrentValue;
		$this->kab_kota->CurrentValue = NULL;
		$this->kab_kota->OldValue = $this->kab_kota->CurrentValue;
		$this->kelurahan->CurrentValue = NULL;
		$this->kelurahan->OldValue = $this->kelurahan->CurrentValue;
		$this->alamat->CurrentValue = NULL;
		$this->alamat->OldValue = $this->alamat->CurrentValue;
		$this->tanggal_mulai_ditempati->CurrentValue = "0000-00-00";
		$this->tanggal_berakhir_ditempati->CurrentValue = "0000-00-00";
		$this->stat_validasi->CurrentValue = 0;
		$this->change_date->CurrentValue = "0000-00-00 00:00:00";
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
		if (!$this->propinsi->FldIsDetailKey) {
			$this->propinsi->setFormValue($objForm->GetValue("x_propinsi"));
		}
		if (!$this->kab_kota->FldIsDetailKey) {
			$this->kab_kota->setFormValue($objForm->GetValue("x_kab_kota"));
		}
		if (!$this->kelurahan->FldIsDetailKey) {
			$this->kelurahan->setFormValue($objForm->GetValue("x_kelurahan"));
		}
		if (!$this->alamat->FldIsDetailKey) {
			$this->alamat->setFormValue($objForm->GetValue("x_alamat"));
		}
		if (!$this->tanggal_mulai_ditempati->FldIsDetailKey) {
			$this->tanggal_mulai_ditempati->setFormValue($objForm->GetValue("x_tanggal_mulai_ditempati"));
			$this->tanggal_mulai_ditempati->CurrentValue = ew_UnFormatDateTime($this->tanggal_mulai_ditempati->CurrentValue, 0);
		}
		if (!$this->tanggal_berakhir_ditempati->FldIsDetailKey) {
			$this->tanggal_berakhir_ditempati->setFormValue($objForm->GetValue("x_tanggal_berakhir_ditempati"));
			$this->tanggal_berakhir_ditempati->CurrentValue = ew_UnFormatDateTime($this->tanggal_berakhir_ditempati->CurrentValue, 0);
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
		$this->propinsi->CurrentValue = $this->propinsi->FormValue;
		$this->kab_kota->CurrentValue = $this->kab_kota->FormValue;
		$this->kelurahan->CurrentValue = $this->kelurahan->FormValue;
		$this->alamat->CurrentValue = $this->alamat->FormValue;
		$this->tanggal_mulai_ditempati->CurrentValue = $this->tanggal_mulai_ditempati->FormValue;
		$this->tanggal_mulai_ditempati->CurrentValue = ew_UnFormatDateTime($this->tanggal_mulai_ditempati->CurrentValue, 0);
		$this->tanggal_berakhir_ditempati->CurrentValue = $this->tanggal_berakhir_ditempati->FormValue;
		$this->tanggal_berakhir_ditempati->CurrentValue = ew_UnFormatDateTime($this->tanggal_berakhir_ditempati->CurrentValue, 0);
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
		$this->propinsi->setDbValue($row['propinsi']);
		$this->kab_kota->setDbValue($row['kab_kota']);
		$this->kelurahan->setDbValue($row['kelurahan']);
		$this->alamat->setDbValue($row['alamat']);
		$this->tanggal_mulai_ditempati->setDbValue($row['tanggal_mulai_ditempati']);
		$this->tanggal_berakhir_ditempati->setDbValue($row['tanggal_berakhir_ditempati']);
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
		$row['propinsi'] = $this->propinsi->CurrentValue;
		$row['kab_kota'] = $this->kab_kota->CurrentValue;
		$row['kelurahan'] = $this->kelurahan->CurrentValue;
		$row['alamat'] = $this->alamat->CurrentValue;
		$row['tanggal_mulai_ditempati'] = $this->tanggal_mulai_ditempati->CurrentValue;
		$row['tanggal_berakhir_ditempati'] = $this->tanggal_berakhir_ditempati->CurrentValue;
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
		$this->propinsi->DbValue = $row['propinsi'];
		$this->kab_kota->DbValue = $row['kab_kota'];
		$this->kelurahan->DbValue = $row['kelurahan'];
		$this->alamat->DbValue = $row['alamat'];
		$this->tanggal_mulai_ditempati->DbValue = $row['tanggal_mulai_ditempati'];
		$this->tanggal_berakhir_ditempati->DbValue = $row['tanggal_berakhir_ditempati'];
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
		// propinsi
		// kab_kota
		// kelurahan
		// alamat
		// tanggal_mulai_ditempati
		// tanggal_berakhir_ditempati
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

		// propinsi
		$this->propinsi->ViewValue = $this->propinsi->CurrentValue;
		$this->propinsi->ViewCustomAttributes = "";

		// kab_kota
		$this->kab_kota->ViewValue = $this->kab_kota->CurrentValue;
		$this->kab_kota->ViewCustomAttributes = "";

		// kelurahan
		$this->kelurahan->ViewValue = $this->kelurahan->CurrentValue;
		$this->kelurahan->ViewCustomAttributes = "";

		// alamat
		$this->alamat->ViewValue = $this->alamat->CurrentValue;
		$this->alamat->ViewCustomAttributes = "";

		// tanggal_mulai_ditempati
		$this->tanggal_mulai_ditempati->ViewValue = $this->tanggal_mulai_ditempati->CurrentValue;
		$this->tanggal_mulai_ditempati->ViewValue = ew_FormatDateTime($this->tanggal_mulai_ditempati->ViewValue, 0);
		$this->tanggal_mulai_ditempati->ViewCustomAttributes = "";

		// tanggal_berakhir_ditempati
		$this->tanggal_berakhir_ditempati->ViewValue = $this->tanggal_berakhir_ditempati->CurrentValue;
		$this->tanggal_berakhir_ditempati->ViewValue = ew_FormatDateTime($this->tanggal_berakhir_ditempati->ViewValue, 0);
		$this->tanggal_berakhir_ditempati->ViewCustomAttributes = "";

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

			// propinsi
			$this->propinsi->LinkCustomAttributes = "";
			$this->propinsi->HrefValue = "";
			$this->propinsi->TooltipValue = "";

			// kab_kota
			$this->kab_kota->LinkCustomAttributes = "";
			$this->kab_kota->HrefValue = "";
			$this->kab_kota->TooltipValue = "";

			// kelurahan
			$this->kelurahan->LinkCustomAttributes = "";
			$this->kelurahan->HrefValue = "";
			$this->kelurahan->TooltipValue = "";

			// alamat
			$this->alamat->LinkCustomAttributes = "";
			$this->alamat->HrefValue = "";
			$this->alamat->TooltipValue = "";

			// tanggal_mulai_ditempati
			$this->tanggal_mulai_ditempati->LinkCustomAttributes = "";
			$this->tanggal_mulai_ditempati->HrefValue = "";
			$this->tanggal_mulai_ditempati->TooltipValue = "";

			// tanggal_berakhir_ditempati
			$this->tanggal_berakhir_ditempati->LinkCustomAttributes = "";
			$this->tanggal_berakhir_ditempati->HrefValue = "";
			$this->tanggal_berakhir_ditempati->TooltipValue = "";

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

			// propinsi
			$this->propinsi->EditAttrs["class"] = "form-control";
			$this->propinsi->EditCustomAttributes = "";
			$this->propinsi->EditValue = ew_HtmlEncode($this->propinsi->CurrentValue);
			$this->propinsi->PlaceHolder = ew_RemoveHtml($this->propinsi->FldCaption());

			// kab_kota
			$this->kab_kota->EditAttrs["class"] = "form-control";
			$this->kab_kota->EditCustomAttributes = "";
			$this->kab_kota->EditValue = ew_HtmlEncode($this->kab_kota->CurrentValue);
			$this->kab_kota->PlaceHolder = ew_RemoveHtml($this->kab_kota->FldCaption());

			// kelurahan
			$this->kelurahan->EditAttrs["class"] = "form-control";
			$this->kelurahan->EditCustomAttributes = "";
			$this->kelurahan->EditValue = ew_HtmlEncode($this->kelurahan->CurrentValue);
			$this->kelurahan->PlaceHolder = ew_RemoveHtml($this->kelurahan->FldCaption());

			// alamat
			$this->alamat->EditAttrs["class"] = "form-control";
			$this->alamat->EditCustomAttributes = "";
			$this->alamat->EditValue = ew_HtmlEncode($this->alamat->CurrentValue);
			$this->alamat->PlaceHolder = ew_RemoveHtml($this->alamat->FldCaption());

			// tanggal_mulai_ditempati
			$this->tanggal_mulai_ditempati->EditAttrs["class"] = "form-control";
			$this->tanggal_mulai_ditempati->EditCustomAttributes = "";
			$this->tanggal_mulai_ditempati->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tanggal_mulai_ditempati->CurrentValue, 8));
			$this->tanggal_mulai_ditempati->PlaceHolder = ew_RemoveHtml($this->tanggal_mulai_ditempati->FldCaption());

			// tanggal_berakhir_ditempati
			$this->tanggal_berakhir_ditempati->EditAttrs["class"] = "form-control";
			$this->tanggal_berakhir_ditempati->EditCustomAttributes = "";
			$this->tanggal_berakhir_ditempati->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tanggal_berakhir_ditempati->CurrentValue, 8));
			$this->tanggal_berakhir_ditempati->PlaceHolder = ew_RemoveHtml($this->tanggal_berakhir_ditempati->FldCaption());

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

			// propinsi
			$this->propinsi->LinkCustomAttributes = "";
			$this->propinsi->HrefValue = "";

			// kab_kota
			$this->kab_kota->LinkCustomAttributes = "";
			$this->kab_kota->HrefValue = "";

			// kelurahan
			$this->kelurahan->LinkCustomAttributes = "";
			$this->kelurahan->HrefValue = "";

			// alamat
			$this->alamat->LinkCustomAttributes = "";
			$this->alamat->HrefValue = "";

			// tanggal_mulai_ditempati
			$this->tanggal_mulai_ditempati->LinkCustomAttributes = "";
			$this->tanggal_mulai_ditempati->HrefValue = "";

			// tanggal_berakhir_ditempati
			$this->tanggal_berakhir_ditempati->LinkCustomAttributes = "";
			$this->tanggal_berakhir_ditempati->HrefValue = "";

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
		if (!ew_CheckDateDef($this->tanggal_mulai_ditempati->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal_mulai_ditempati->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tanggal_berakhir_ditempati->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal_berakhir_ditempati->FldErrMsg());
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

		// propinsi
		$this->propinsi->SetDbValueDef($rsnew, $this->propinsi->CurrentValue, NULL, FALSE);

		// kab_kota
		$this->kab_kota->SetDbValueDef($rsnew, $this->kab_kota->CurrentValue, NULL, FALSE);

		// kelurahan
		$this->kelurahan->SetDbValueDef($rsnew, $this->kelurahan->CurrentValue, NULL, FALSE);

		// alamat
		$this->alamat->SetDbValueDef($rsnew, $this->alamat->CurrentValue, NULL, FALSE);

		// tanggal_mulai_ditempati
		$this->tanggal_mulai_ditempati->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal_mulai_ditempati->CurrentValue, 0), NULL, strval($this->tanggal_mulai_ditempati->CurrentValue) == "");

		// tanggal_berakhir_ditempati
		$this->tanggal_berakhir_ditempati->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal_berakhir_ditempati->CurrentValue, 0), NULL, strval($this->tanggal_berakhir_ditempati->CurrentValue) == "");

		// stat_validasi
		$this->stat_validasi->SetDbValueDef($rsnew, $this->stat_validasi->CurrentValue, NULL, strval($this->stat_validasi->CurrentValue) == "");

		// change_date
		$this->change_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->change_date->CurrentValue, 0), NULL, strval($this->change_date->CurrentValue) == "");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("rwy_tempat_tinggallist.php"), "", $this->TableVar, TRUE);
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
if (!isset($rwy_tempat_tinggal_add)) $rwy_tempat_tinggal_add = new crwy_tempat_tinggal_add();

// Page init
$rwy_tempat_tinggal_add->Page_Init();

// Page main
$rwy_tempat_tinggal_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$rwy_tempat_tinggal_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = frwy_tempat_tinggaladd = new ew_Form("frwy_tempat_tinggaladd", "add");

// Validate form
frwy_tempat_tinggaladd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tanggal_mulai_ditempati");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_tempat_tinggal->tanggal_mulai_ditempati->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tanggal_berakhir_ditempati");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_tempat_tinggal->tanggal_berakhir_ditempati->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_stat_validasi");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_tempat_tinggal->stat_validasi->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_change_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_tempat_tinggal->change_date->FldErrMsg()) ?>");

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
frwy_tempat_tinggaladd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
frwy_tempat_tinggaladd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $rwy_tempat_tinggal_add->ShowPageHeader(); ?>
<?php
$rwy_tempat_tinggal_add->ShowMessage();
?>
<form name="frwy_tempat_tinggaladd" id="frwy_tempat_tinggaladd" class="<?php echo $rwy_tempat_tinggal_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($rwy_tempat_tinggal_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $rwy_tempat_tinggal_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="rwy_tempat_tinggal">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($rwy_tempat_tinggal_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($rwy_tempat_tinggal->nip->Visible) { // nip ?>
	<div id="r_nip" class="form-group">
		<label id="elh_rwy_tempat_tinggal_nip" for="x_nip" class="<?php echo $rwy_tempat_tinggal_add->LeftColumnClass ?>"><?php echo $rwy_tempat_tinggal->nip->FldCaption() ?></label>
		<div class="<?php echo $rwy_tempat_tinggal_add->RightColumnClass ?>"><div<?php echo $rwy_tempat_tinggal->nip->CellAttributes() ?>>
<span id="el_rwy_tempat_tinggal_nip">
<input type="text" data-table="rwy_tempat_tinggal" data-field="x_nip" name="x_nip" id="x_nip" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($rwy_tempat_tinggal->nip->getPlaceHolder()) ?>" value="<?php echo $rwy_tempat_tinggal->nip->EditValue ?>"<?php echo $rwy_tempat_tinggal->nip->EditAttributes() ?>>
</span>
<?php echo $rwy_tempat_tinggal->nip->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_tempat_tinggal->propinsi->Visible) { // propinsi ?>
	<div id="r_propinsi" class="form-group">
		<label id="elh_rwy_tempat_tinggal_propinsi" for="x_propinsi" class="<?php echo $rwy_tempat_tinggal_add->LeftColumnClass ?>"><?php echo $rwy_tempat_tinggal->propinsi->FldCaption() ?></label>
		<div class="<?php echo $rwy_tempat_tinggal_add->RightColumnClass ?>"><div<?php echo $rwy_tempat_tinggal->propinsi->CellAttributes() ?>>
<span id="el_rwy_tempat_tinggal_propinsi">
<input type="text" data-table="rwy_tempat_tinggal" data-field="x_propinsi" name="x_propinsi" id="x_propinsi" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_tempat_tinggal->propinsi->getPlaceHolder()) ?>" value="<?php echo $rwy_tempat_tinggal->propinsi->EditValue ?>"<?php echo $rwy_tempat_tinggal->propinsi->EditAttributes() ?>>
</span>
<?php echo $rwy_tempat_tinggal->propinsi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_tempat_tinggal->kab_kota->Visible) { // kab_kota ?>
	<div id="r_kab_kota" class="form-group">
		<label id="elh_rwy_tempat_tinggal_kab_kota" for="x_kab_kota" class="<?php echo $rwy_tempat_tinggal_add->LeftColumnClass ?>"><?php echo $rwy_tempat_tinggal->kab_kota->FldCaption() ?></label>
		<div class="<?php echo $rwy_tempat_tinggal_add->RightColumnClass ?>"><div<?php echo $rwy_tempat_tinggal->kab_kota->CellAttributes() ?>>
<span id="el_rwy_tempat_tinggal_kab_kota">
<input type="text" data-table="rwy_tempat_tinggal" data-field="x_kab_kota" name="x_kab_kota" id="x_kab_kota" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_tempat_tinggal->kab_kota->getPlaceHolder()) ?>" value="<?php echo $rwy_tempat_tinggal->kab_kota->EditValue ?>"<?php echo $rwy_tempat_tinggal->kab_kota->EditAttributes() ?>>
</span>
<?php echo $rwy_tempat_tinggal->kab_kota->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_tempat_tinggal->kelurahan->Visible) { // kelurahan ?>
	<div id="r_kelurahan" class="form-group">
		<label id="elh_rwy_tempat_tinggal_kelurahan" for="x_kelurahan" class="<?php echo $rwy_tempat_tinggal_add->LeftColumnClass ?>"><?php echo $rwy_tempat_tinggal->kelurahan->FldCaption() ?></label>
		<div class="<?php echo $rwy_tempat_tinggal_add->RightColumnClass ?>"><div<?php echo $rwy_tempat_tinggal->kelurahan->CellAttributes() ?>>
<span id="el_rwy_tempat_tinggal_kelurahan">
<input type="text" data-table="rwy_tempat_tinggal" data-field="x_kelurahan" name="x_kelurahan" id="x_kelurahan" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_tempat_tinggal->kelurahan->getPlaceHolder()) ?>" value="<?php echo $rwy_tempat_tinggal->kelurahan->EditValue ?>"<?php echo $rwy_tempat_tinggal->kelurahan->EditAttributes() ?>>
</span>
<?php echo $rwy_tempat_tinggal->kelurahan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_tempat_tinggal->alamat->Visible) { // alamat ?>
	<div id="r_alamat" class="form-group">
		<label id="elh_rwy_tempat_tinggal_alamat" for="x_alamat" class="<?php echo $rwy_tempat_tinggal_add->LeftColumnClass ?>"><?php echo $rwy_tempat_tinggal->alamat->FldCaption() ?></label>
		<div class="<?php echo $rwy_tempat_tinggal_add->RightColumnClass ?>"><div<?php echo $rwy_tempat_tinggal->alamat->CellAttributes() ?>>
<span id="el_rwy_tempat_tinggal_alamat">
<textarea data-table="rwy_tempat_tinggal" data-field="x_alamat" name="x_alamat" id="x_alamat" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($rwy_tempat_tinggal->alamat->getPlaceHolder()) ?>"<?php echo $rwy_tempat_tinggal->alamat->EditAttributes() ?>><?php echo $rwy_tempat_tinggal->alamat->EditValue ?></textarea>
</span>
<?php echo $rwy_tempat_tinggal->alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_tempat_tinggal->tanggal_mulai_ditempati->Visible) { // tanggal_mulai_ditempati ?>
	<div id="r_tanggal_mulai_ditempati" class="form-group">
		<label id="elh_rwy_tempat_tinggal_tanggal_mulai_ditempati" for="x_tanggal_mulai_ditempati" class="<?php echo $rwy_tempat_tinggal_add->LeftColumnClass ?>"><?php echo $rwy_tempat_tinggal->tanggal_mulai_ditempati->FldCaption() ?></label>
		<div class="<?php echo $rwy_tempat_tinggal_add->RightColumnClass ?>"><div<?php echo $rwy_tempat_tinggal->tanggal_mulai_ditempati->CellAttributes() ?>>
<span id="el_rwy_tempat_tinggal_tanggal_mulai_ditempati">
<input type="text" data-table="rwy_tempat_tinggal" data-field="x_tanggal_mulai_ditempati" name="x_tanggal_mulai_ditempati" id="x_tanggal_mulai_ditempati" placeholder="<?php echo ew_HtmlEncode($rwy_tempat_tinggal->tanggal_mulai_ditempati->getPlaceHolder()) ?>" value="<?php echo $rwy_tempat_tinggal->tanggal_mulai_ditempati->EditValue ?>"<?php echo $rwy_tempat_tinggal->tanggal_mulai_ditempati->EditAttributes() ?>>
</span>
<?php echo $rwy_tempat_tinggal->tanggal_mulai_ditempati->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_tempat_tinggal->tanggal_berakhir_ditempati->Visible) { // tanggal_berakhir_ditempati ?>
	<div id="r_tanggal_berakhir_ditempati" class="form-group">
		<label id="elh_rwy_tempat_tinggal_tanggal_berakhir_ditempati" for="x_tanggal_berakhir_ditempati" class="<?php echo $rwy_tempat_tinggal_add->LeftColumnClass ?>"><?php echo $rwy_tempat_tinggal->tanggal_berakhir_ditempati->FldCaption() ?></label>
		<div class="<?php echo $rwy_tempat_tinggal_add->RightColumnClass ?>"><div<?php echo $rwy_tempat_tinggal->tanggal_berakhir_ditempati->CellAttributes() ?>>
<span id="el_rwy_tempat_tinggal_tanggal_berakhir_ditempati">
<input type="text" data-table="rwy_tempat_tinggal" data-field="x_tanggal_berakhir_ditempati" name="x_tanggal_berakhir_ditempati" id="x_tanggal_berakhir_ditempati" placeholder="<?php echo ew_HtmlEncode($rwy_tempat_tinggal->tanggal_berakhir_ditempati->getPlaceHolder()) ?>" value="<?php echo $rwy_tempat_tinggal->tanggal_berakhir_ditempati->EditValue ?>"<?php echo $rwy_tempat_tinggal->tanggal_berakhir_ditempati->EditAttributes() ?>>
</span>
<?php echo $rwy_tempat_tinggal->tanggal_berakhir_ditempati->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_tempat_tinggal->stat_validasi->Visible) { // stat_validasi ?>
	<div id="r_stat_validasi" class="form-group">
		<label id="elh_rwy_tempat_tinggal_stat_validasi" for="x_stat_validasi" class="<?php echo $rwy_tempat_tinggal_add->LeftColumnClass ?>"><?php echo $rwy_tempat_tinggal->stat_validasi->FldCaption() ?></label>
		<div class="<?php echo $rwy_tempat_tinggal_add->RightColumnClass ?>"><div<?php echo $rwy_tempat_tinggal->stat_validasi->CellAttributes() ?>>
<span id="el_rwy_tempat_tinggal_stat_validasi">
<input type="text" data-table="rwy_tempat_tinggal" data-field="x_stat_validasi" name="x_stat_validasi" id="x_stat_validasi" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_tempat_tinggal->stat_validasi->getPlaceHolder()) ?>" value="<?php echo $rwy_tempat_tinggal->stat_validasi->EditValue ?>"<?php echo $rwy_tempat_tinggal->stat_validasi->EditAttributes() ?>>
</span>
<?php echo $rwy_tempat_tinggal->stat_validasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_tempat_tinggal->change_date->Visible) { // change_date ?>
	<div id="r_change_date" class="form-group">
		<label id="elh_rwy_tempat_tinggal_change_date" for="x_change_date" class="<?php echo $rwy_tempat_tinggal_add->LeftColumnClass ?>"><?php echo $rwy_tempat_tinggal->change_date->FldCaption() ?></label>
		<div class="<?php echo $rwy_tempat_tinggal_add->RightColumnClass ?>"><div<?php echo $rwy_tempat_tinggal->change_date->CellAttributes() ?>>
<span id="el_rwy_tempat_tinggal_change_date">
<input type="text" data-table="rwy_tempat_tinggal" data-field="x_change_date" name="x_change_date" id="x_change_date" placeholder="<?php echo ew_HtmlEncode($rwy_tempat_tinggal->change_date->getPlaceHolder()) ?>" value="<?php echo $rwy_tempat_tinggal->change_date->EditValue ?>"<?php echo $rwy_tempat_tinggal->change_date->EditAttributes() ?>>
</span>
<?php echo $rwy_tempat_tinggal->change_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_tempat_tinggal->change_by->Visible) { // change_by ?>
	<div id="r_change_by" class="form-group">
		<label id="elh_rwy_tempat_tinggal_change_by" for="x_change_by" class="<?php echo $rwy_tempat_tinggal_add->LeftColumnClass ?>"><?php echo $rwy_tempat_tinggal->change_by->FldCaption() ?></label>
		<div class="<?php echo $rwy_tempat_tinggal_add->RightColumnClass ?>"><div<?php echo $rwy_tempat_tinggal->change_by->CellAttributes() ?>>
<span id="el_rwy_tempat_tinggal_change_by">
<input type="text" data-table="rwy_tempat_tinggal" data-field="x_change_by" name="x_change_by" id="x_change_by" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_tempat_tinggal->change_by->getPlaceHolder()) ?>" value="<?php echo $rwy_tempat_tinggal->change_by->EditValue ?>"<?php echo $rwy_tempat_tinggal->change_by->EditAttributes() ?>>
</span>
<?php echo $rwy_tempat_tinggal->change_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$rwy_tempat_tinggal_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $rwy_tempat_tinggal_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $rwy_tempat_tinggal_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
frwy_tempat_tinggaladd.Init();
</script>
<?php
$rwy_tempat_tinggal_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$rwy_tempat_tinggal_add->Page_Terminate();
?>
