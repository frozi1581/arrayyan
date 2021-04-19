<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ciri_ciri_jasmaniinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$ciri_ciri_jasmani_add = NULL; // Initialize page object first

class cciri_ciri_jasmani_add extends cciri_ciri_jasmani {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'ciri_ciri_jasmani';

	// Page object name
	var $PageObjName = 'ciri_ciri_jasmani_add';

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

		// Table object (ciri_ciri_jasmani)
		if (!isset($GLOBALS["ciri_ciri_jasmani"]) || get_class($GLOBALS["ciri_ciri_jasmani"]) == "cciri_ciri_jasmani") {
			$GLOBALS["ciri_ciri_jasmani"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ciri_ciri_jasmani"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ciri_ciri_jasmani', TRUE);

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
		$this->tinggi_badan->SetVisibility();
		$this->berat->SetVisibility();
		$this->bentuk_hidung->SetVisibility();
		$this->bentuk_muka->SetVisibility();
		$this->warna_kulit->SetVisibility();
		$this->warna_rambut->SetVisibility();
		$this->hobi->SetVisibility();
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
		global $EW_EXPORT, $ciri_ciri_jasmani;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ciri_ciri_jasmani);
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
					if ($pageName == "ciri_ciri_jasmaniview.php")
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
					$this->Page_Terminate("ciri_ciri_jasmanilist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "ciri_ciri_jasmanilist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "ciri_ciri_jasmaniview.php")
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
		$this->tinggi_badan->CurrentValue = NULL;
		$this->tinggi_badan->OldValue = $this->tinggi_badan->CurrentValue;
		$this->berat->CurrentValue = NULL;
		$this->berat->OldValue = $this->berat->CurrentValue;
		$this->bentuk_hidung->CurrentValue = NULL;
		$this->bentuk_hidung->OldValue = $this->bentuk_hidung->CurrentValue;
		$this->bentuk_muka->CurrentValue = NULL;
		$this->bentuk_muka->OldValue = $this->bentuk_muka->CurrentValue;
		$this->warna_kulit->CurrentValue = NULL;
		$this->warna_kulit->OldValue = $this->warna_kulit->CurrentValue;
		$this->warna_rambut->CurrentValue = NULL;
		$this->warna_rambut->OldValue = $this->warna_rambut->CurrentValue;
		$this->hobi->CurrentValue = NULL;
		$this->hobi->OldValue = $this->hobi->CurrentValue;
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
		if (!$this->tinggi_badan->FldIsDetailKey) {
			$this->tinggi_badan->setFormValue($objForm->GetValue("x_tinggi_badan"));
		}
		if (!$this->berat->FldIsDetailKey) {
			$this->berat->setFormValue($objForm->GetValue("x_berat"));
		}
		if (!$this->bentuk_hidung->FldIsDetailKey) {
			$this->bentuk_hidung->setFormValue($objForm->GetValue("x_bentuk_hidung"));
		}
		if (!$this->bentuk_muka->FldIsDetailKey) {
			$this->bentuk_muka->setFormValue($objForm->GetValue("x_bentuk_muka"));
		}
		if (!$this->warna_kulit->FldIsDetailKey) {
			$this->warna_kulit->setFormValue($objForm->GetValue("x_warna_kulit"));
		}
		if (!$this->warna_rambut->FldIsDetailKey) {
			$this->warna_rambut->setFormValue($objForm->GetValue("x_warna_rambut"));
		}
		if (!$this->hobi->FldIsDetailKey) {
			$this->hobi->setFormValue($objForm->GetValue("x_hobi"));
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
		$this->tinggi_badan->CurrentValue = $this->tinggi_badan->FormValue;
		$this->berat->CurrentValue = $this->berat->FormValue;
		$this->bentuk_hidung->CurrentValue = $this->bentuk_hidung->FormValue;
		$this->bentuk_muka->CurrentValue = $this->bentuk_muka->FormValue;
		$this->warna_kulit->CurrentValue = $this->warna_kulit->FormValue;
		$this->warna_rambut->CurrentValue = $this->warna_rambut->FormValue;
		$this->hobi->CurrentValue = $this->hobi->FormValue;
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
		$this->tinggi_badan->setDbValue($row['tinggi_badan']);
		$this->berat->setDbValue($row['berat']);
		$this->bentuk_hidung->setDbValue($row['bentuk_hidung']);
		$this->bentuk_muka->setDbValue($row['bentuk_muka']);
		$this->warna_kulit->setDbValue($row['warna_kulit']);
		$this->warna_rambut->setDbValue($row['warna_rambut']);
		$this->hobi->setDbValue($row['hobi']);
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
		$row['tinggi_badan'] = $this->tinggi_badan->CurrentValue;
		$row['berat'] = $this->berat->CurrentValue;
		$row['bentuk_hidung'] = $this->bentuk_hidung->CurrentValue;
		$row['bentuk_muka'] = $this->bentuk_muka->CurrentValue;
		$row['warna_kulit'] = $this->warna_kulit->CurrentValue;
		$row['warna_rambut'] = $this->warna_rambut->CurrentValue;
		$row['hobi'] = $this->hobi->CurrentValue;
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
		$this->tinggi_badan->DbValue = $row['tinggi_badan'];
		$this->berat->DbValue = $row['berat'];
		$this->bentuk_hidung->DbValue = $row['bentuk_hidung'];
		$this->bentuk_muka->DbValue = $row['bentuk_muka'];
		$this->warna_kulit->DbValue = $row['warna_kulit'];
		$this->warna_rambut->DbValue = $row['warna_rambut'];
		$this->hobi->DbValue = $row['hobi'];
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
		// tinggi_badan
		// berat
		// bentuk_hidung
		// bentuk_muka
		// warna_kulit
		// warna_rambut
		// hobi
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

		// tinggi_badan
		$this->tinggi_badan->ViewValue = $this->tinggi_badan->CurrentValue;
		$this->tinggi_badan->ViewCustomAttributes = "";

		// berat
		$this->berat->ViewValue = $this->berat->CurrentValue;
		$this->berat->ViewCustomAttributes = "";

		// bentuk_hidung
		$this->bentuk_hidung->ViewValue = $this->bentuk_hidung->CurrentValue;
		$this->bentuk_hidung->ViewCustomAttributes = "";

		// bentuk_muka
		$this->bentuk_muka->ViewValue = $this->bentuk_muka->CurrentValue;
		$this->bentuk_muka->ViewCustomAttributes = "";

		// warna_kulit
		$this->warna_kulit->ViewValue = $this->warna_kulit->CurrentValue;
		$this->warna_kulit->ViewCustomAttributes = "";

		// warna_rambut
		$this->warna_rambut->ViewValue = $this->warna_rambut->CurrentValue;
		$this->warna_rambut->ViewCustomAttributes = "";

		// hobi
		$this->hobi->ViewValue = $this->hobi->CurrentValue;
		$this->hobi->ViewCustomAttributes = "";

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

			// tinggi_badan
			$this->tinggi_badan->LinkCustomAttributes = "";
			$this->tinggi_badan->HrefValue = "";
			$this->tinggi_badan->TooltipValue = "";

			// berat
			$this->berat->LinkCustomAttributes = "";
			$this->berat->HrefValue = "";
			$this->berat->TooltipValue = "";

			// bentuk_hidung
			$this->bentuk_hidung->LinkCustomAttributes = "";
			$this->bentuk_hidung->HrefValue = "";
			$this->bentuk_hidung->TooltipValue = "";

			// bentuk_muka
			$this->bentuk_muka->LinkCustomAttributes = "";
			$this->bentuk_muka->HrefValue = "";
			$this->bentuk_muka->TooltipValue = "";

			// warna_kulit
			$this->warna_kulit->LinkCustomAttributes = "";
			$this->warna_kulit->HrefValue = "";
			$this->warna_kulit->TooltipValue = "";

			// warna_rambut
			$this->warna_rambut->LinkCustomAttributes = "";
			$this->warna_rambut->HrefValue = "";
			$this->warna_rambut->TooltipValue = "";

			// hobi
			$this->hobi->LinkCustomAttributes = "";
			$this->hobi->HrefValue = "";
			$this->hobi->TooltipValue = "";

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

			// tinggi_badan
			$this->tinggi_badan->EditAttrs["class"] = "form-control";
			$this->tinggi_badan->EditCustomAttributes = "";
			$this->tinggi_badan->EditValue = ew_HtmlEncode($this->tinggi_badan->CurrentValue);
			$this->tinggi_badan->PlaceHolder = ew_RemoveHtml($this->tinggi_badan->FldCaption());

			// berat
			$this->berat->EditAttrs["class"] = "form-control";
			$this->berat->EditCustomAttributes = "";
			$this->berat->EditValue = ew_HtmlEncode($this->berat->CurrentValue);
			$this->berat->PlaceHolder = ew_RemoveHtml($this->berat->FldCaption());

			// bentuk_hidung
			$this->bentuk_hidung->EditAttrs["class"] = "form-control";
			$this->bentuk_hidung->EditCustomAttributes = "";
			$this->bentuk_hidung->EditValue = ew_HtmlEncode($this->bentuk_hidung->CurrentValue);
			$this->bentuk_hidung->PlaceHolder = ew_RemoveHtml($this->bentuk_hidung->FldCaption());

			// bentuk_muka
			$this->bentuk_muka->EditAttrs["class"] = "form-control";
			$this->bentuk_muka->EditCustomAttributes = "";
			$this->bentuk_muka->EditValue = ew_HtmlEncode($this->bentuk_muka->CurrentValue);
			$this->bentuk_muka->PlaceHolder = ew_RemoveHtml($this->bentuk_muka->FldCaption());

			// warna_kulit
			$this->warna_kulit->EditAttrs["class"] = "form-control";
			$this->warna_kulit->EditCustomAttributes = "";
			$this->warna_kulit->EditValue = ew_HtmlEncode($this->warna_kulit->CurrentValue);
			$this->warna_kulit->PlaceHolder = ew_RemoveHtml($this->warna_kulit->FldCaption());

			// warna_rambut
			$this->warna_rambut->EditAttrs["class"] = "form-control";
			$this->warna_rambut->EditCustomAttributes = "";
			$this->warna_rambut->EditValue = ew_HtmlEncode($this->warna_rambut->CurrentValue);
			$this->warna_rambut->PlaceHolder = ew_RemoveHtml($this->warna_rambut->FldCaption());

			// hobi
			$this->hobi->EditAttrs["class"] = "form-control";
			$this->hobi->EditCustomAttributes = "";
			$this->hobi->EditValue = ew_HtmlEncode($this->hobi->CurrentValue);
			$this->hobi->PlaceHolder = ew_RemoveHtml($this->hobi->FldCaption());

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

			// tinggi_badan
			$this->tinggi_badan->LinkCustomAttributes = "";
			$this->tinggi_badan->HrefValue = "";

			// berat
			$this->berat->LinkCustomAttributes = "";
			$this->berat->HrefValue = "";

			// bentuk_hidung
			$this->bentuk_hidung->LinkCustomAttributes = "";
			$this->bentuk_hidung->HrefValue = "";

			// bentuk_muka
			$this->bentuk_muka->LinkCustomAttributes = "";
			$this->bentuk_muka->HrefValue = "";

			// warna_kulit
			$this->warna_kulit->LinkCustomAttributes = "";
			$this->warna_kulit->HrefValue = "";

			// warna_rambut
			$this->warna_rambut->LinkCustomAttributes = "";
			$this->warna_rambut->HrefValue = "";

			// hobi
			$this->hobi->LinkCustomAttributes = "";
			$this->hobi->HrefValue = "";

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
		if (!ew_CheckInteger($this->tinggi_badan->FormValue)) {
			ew_AddMessage($gsFormError, $this->tinggi_badan->FldErrMsg());
		}
		if (!ew_CheckInteger($this->berat->FormValue)) {
			ew_AddMessage($gsFormError, $this->berat->FldErrMsg());
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

		// tinggi_badan
		$this->tinggi_badan->SetDbValueDef($rsnew, $this->tinggi_badan->CurrentValue, NULL, FALSE);

		// berat
		$this->berat->SetDbValueDef($rsnew, $this->berat->CurrentValue, NULL, FALSE);

		// bentuk_hidung
		$this->bentuk_hidung->SetDbValueDef($rsnew, $this->bentuk_hidung->CurrentValue, NULL, FALSE);

		// bentuk_muka
		$this->bentuk_muka->SetDbValueDef($rsnew, $this->bentuk_muka->CurrentValue, NULL, FALSE);

		// warna_kulit
		$this->warna_kulit->SetDbValueDef($rsnew, $this->warna_kulit->CurrentValue, NULL, FALSE);

		// warna_rambut
		$this->warna_rambut->SetDbValueDef($rsnew, $this->warna_rambut->CurrentValue, NULL, FALSE);

		// hobi
		$this->hobi->SetDbValueDef($rsnew, $this->hobi->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ciri_ciri_jasmanilist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ciri_ciri_jasmani_add)) $ciri_ciri_jasmani_add = new cciri_ciri_jasmani_add();

// Page init
$ciri_ciri_jasmani_add->Page_Init();

// Page main
$ciri_ciri_jasmani_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ciri_ciri_jasmani_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fciri_ciri_jasmaniadd = new ew_Form("fciri_ciri_jasmaniadd", "add");

// Validate form
fciri_ciri_jasmaniadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tinggi_badan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ciri_ciri_jasmani->tinggi_badan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_berat");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ciri_ciri_jasmani->berat->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_stat_validasi");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ciri_ciri_jasmani->stat_validasi->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_change_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ciri_ciri_jasmani->change_date->FldErrMsg()) ?>");

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
fciri_ciri_jasmaniadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fciri_ciri_jasmaniadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $ciri_ciri_jasmani_add->ShowPageHeader(); ?>
<?php
$ciri_ciri_jasmani_add->ShowMessage();
?>
<form name="fciri_ciri_jasmaniadd" id="fciri_ciri_jasmaniadd" class="<?php echo $ciri_ciri_jasmani_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ciri_ciri_jasmani_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ciri_ciri_jasmani_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ciri_ciri_jasmani">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($ciri_ciri_jasmani_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($ciri_ciri_jasmani->nip->Visible) { // nip ?>
	<div id="r_nip" class="form-group">
		<label id="elh_ciri_ciri_jasmani_nip" for="x_nip" class="<?php echo $ciri_ciri_jasmani_add->LeftColumnClass ?>"><?php echo $ciri_ciri_jasmani->nip->FldCaption() ?></label>
		<div class="<?php echo $ciri_ciri_jasmani_add->RightColumnClass ?>"><div<?php echo $ciri_ciri_jasmani->nip->CellAttributes() ?>>
<span id="el_ciri_ciri_jasmani_nip">
<input type="text" data-table="ciri_ciri_jasmani" data-field="x_nip" name="x_nip" id="x_nip" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ciri_ciri_jasmani->nip->getPlaceHolder()) ?>" value="<?php echo $ciri_ciri_jasmani->nip->EditValue ?>"<?php echo $ciri_ciri_jasmani->nip->EditAttributes() ?>>
</span>
<?php echo $ciri_ciri_jasmani->nip->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ciri_ciri_jasmani->tinggi_badan->Visible) { // tinggi_badan ?>
	<div id="r_tinggi_badan" class="form-group">
		<label id="elh_ciri_ciri_jasmani_tinggi_badan" for="x_tinggi_badan" class="<?php echo $ciri_ciri_jasmani_add->LeftColumnClass ?>"><?php echo $ciri_ciri_jasmani->tinggi_badan->FldCaption() ?></label>
		<div class="<?php echo $ciri_ciri_jasmani_add->RightColumnClass ?>"><div<?php echo $ciri_ciri_jasmani->tinggi_badan->CellAttributes() ?>>
<span id="el_ciri_ciri_jasmani_tinggi_badan">
<input type="text" data-table="ciri_ciri_jasmani" data-field="x_tinggi_badan" name="x_tinggi_badan" id="x_tinggi_badan" size="30" placeholder="<?php echo ew_HtmlEncode($ciri_ciri_jasmani->tinggi_badan->getPlaceHolder()) ?>" value="<?php echo $ciri_ciri_jasmani->tinggi_badan->EditValue ?>"<?php echo $ciri_ciri_jasmani->tinggi_badan->EditAttributes() ?>>
</span>
<?php echo $ciri_ciri_jasmani->tinggi_badan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ciri_ciri_jasmani->berat->Visible) { // berat ?>
	<div id="r_berat" class="form-group">
		<label id="elh_ciri_ciri_jasmani_berat" for="x_berat" class="<?php echo $ciri_ciri_jasmani_add->LeftColumnClass ?>"><?php echo $ciri_ciri_jasmani->berat->FldCaption() ?></label>
		<div class="<?php echo $ciri_ciri_jasmani_add->RightColumnClass ?>"><div<?php echo $ciri_ciri_jasmani->berat->CellAttributes() ?>>
<span id="el_ciri_ciri_jasmani_berat">
<input type="text" data-table="ciri_ciri_jasmani" data-field="x_berat" name="x_berat" id="x_berat" size="30" placeholder="<?php echo ew_HtmlEncode($ciri_ciri_jasmani->berat->getPlaceHolder()) ?>" value="<?php echo $ciri_ciri_jasmani->berat->EditValue ?>"<?php echo $ciri_ciri_jasmani->berat->EditAttributes() ?>>
</span>
<?php echo $ciri_ciri_jasmani->berat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ciri_ciri_jasmani->bentuk_hidung->Visible) { // bentuk_hidung ?>
	<div id="r_bentuk_hidung" class="form-group">
		<label id="elh_ciri_ciri_jasmani_bentuk_hidung" for="x_bentuk_hidung" class="<?php echo $ciri_ciri_jasmani_add->LeftColumnClass ?>"><?php echo $ciri_ciri_jasmani->bentuk_hidung->FldCaption() ?></label>
		<div class="<?php echo $ciri_ciri_jasmani_add->RightColumnClass ?>"><div<?php echo $ciri_ciri_jasmani->bentuk_hidung->CellAttributes() ?>>
<span id="el_ciri_ciri_jasmani_bentuk_hidung">
<input type="text" data-table="ciri_ciri_jasmani" data-field="x_bentuk_hidung" name="x_bentuk_hidung" id="x_bentuk_hidung" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($ciri_ciri_jasmani->bentuk_hidung->getPlaceHolder()) ?>" value="<?php echo $ciri_ciri_jasmani->bentuk_hidung->EditValue ?>"<?php echo $ciri_ciri_jasmani->bentuk_hidung->EditAttributes() ?>>
</span>
<?php echo $ciri_ciri_jasmani->bentuk_hidung->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ciri_ciri_jasmani->bentuk_muka->Visible) { // bentuk_muka ?>
	<div id="r_bentuk_muka" class="form-group">
		<label id="elh_ciri_ciri_jasmani_bentuk_muka" for="x_bentuk_muka" class="<?php echo $ciri_ciri_jasmani_add->LeftColumnClass ?>"><?php echo $ciri_ciri_jasmani->bentuk_muka->FldCaption() ?></label>
		<div class="<?php echo $ciri_ciri_jasmani_add->RightColumnClass ?>"><div<?php echo $ciri_ciri_jasmani->bentuk_muka->CellAttributes() ?>>
<span id="el_ciri_ciri_jasmani_bentuk_muka">
<input type="text" data-table="ciri_ciri_jasmani" data-field="x_bentuk_muka" name="x_bentuk_muka" id="x_bentuk_muka" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($ciri_ciri_jasmani->bentuk_muka->getPlaceHolder()) ?>" value="<?php echo $ciri_ciri_jasmani->bentuk_muka->EditValue ?>"<?php echo $ciri_ciri_jasmani->bentuk_muka->EditAttributes() ?>>
</span>
<?php echo $ciri_ciri_jasmani->bentuk_muka->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ciri_ciri_jasmani->warna_kulit->Visible) { // warna_kulit ?>
	<div id="r_warna_kulit" class="form-group">
		<label id="elh_ciri_ciri_jasmani_warna_kulit" for="x_warna_kulit" class="<?php echo $ciri_ciri_jasmani_add->LeftColumnClass ?>"><?php echo $ciri_ciri_jasmani->warna_kulit->FldCaption() ?></label>
		<div class="<?php echo $ciri_ciri_jasmani_add->RightColumnClass ?>"><div<?php echo $ciri_ciri_jasmani->warna_kulit->CellAttributes() ?>>
<span id="el_ciri_ciri_jasmani_warna_kulit">
<input type="text" data-table="ciri_ciri_jasmani" data-field="x_warna_kulit" name="x_warna_kulit" id="x_warna_kulit" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($ciri_ciri_jasmani->warna_kulit->getPlaceHolder()) ?>" value="<?php echo $ciri_ciri_jasmani->warna_kulit->EditValue ?>"<?php echo $ciri_ciri_jasmani->warna_kulit->EditAttributes() ?>>
</span>
<?php echo $ciri_ciri_jasmani->warna_kulit->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ciri_ciri_jasmani->warna_rambut->Visible) { // warna_rambut ?>
	<div id="r_warna_rambut" class="form-group">
		<label id="elh_ciri_ciri_jasmani_warna_rambut" for="x_warna_rambut" class="<?php echo $ciri_ciri_jasmani_add->LeftColumnClass ?>"><?php echo $ciri_ciri_jasmani->warna_rambut->FldCaption() ?></label>
		<div class="<?php echo $ciri_ciri_jasmani_add->RightColumnClass ?>"><div<?php echo $ciri_ciri_jasmani->warna_rambut->CellAttributes() ?>>
<span id="el_ciri_ciri_jasmani_warna_rambut">
<input type="text" data-table="ciri_ciri_jasmani" data-field="x_warna_rambut" name="x_warna_rambut" id="x_warna_rambut" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($ciri_ciri_jasmani->warna_rambut->getPlaceHolder()) ?>" value="<?php echo $ciri_ciri_jasmani->warna_rambut->EditValue ?>"<?php echo $ciri_ciri_jasmani->warna_rambut->EditAttributes() ?>>
</span>
<?php echo $ciri_ciri_jasmani->warna_rambut->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ciri_ciri_jasmani->hobi->Visible) { // hobi ?>
	<div id="r_hobi" class="form-group">
		<label id="elh_ciri_ciri_jasmani_hobi" for="x_hobi" class="<?php echo $ciri_ciri_jasmani_add->LeftColumnClass ?>"><?php echo $ciri_ciri_jasmani->hobi->FldCaption() ?></label>
		<div class="<?php echo $ciri_ciri_jasmani_add->RightColumnClass ?>"><div<?php echo $ciri_ciri_jasmani->hobi->CellAttributes() ?>>
<span id="el_ciri_ciri_jasmani_hobi">
<input type="text" data-table="ciri_ciri_jasmani" data-field="x_hobi" name="x_hobi" id="x_hobi" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($ciri_ciri_jasmani->hobi->getPlaceHolder()) ?>" value="<?php echo $ciri_ciri_jasmani->hobi->EditValue ?>"<?php echo $ciri_ciri_jasmani->hobi->EditAttributes() ?>>
</span>
<?php echo $ciri_ciri_jasmani->hobi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ciri_ciri_jasmani->stat_validasi->Visible) { // stat_validasi ?>
	<div id="r_stat_validasi" class="form-group">
		<label id="elh_ciri_ciri_jasmani_stat_validasi" for="x_stat_validasi" class="<?php echo $ciri_ciri_jasmani_add->LeftColumnClass ?>"><?php echo $ciri_ciri_jasmani->stat_validasi->FldCaption() ?></label>
		<div class="<?php echo $ciri_ciri_jasmani_add->RightColumnClass ?>"><div<?php echo $ciri_ciri_jasmani->stat_validasi->CellAttributes() ?>>
<span id="el_ciri_ciri_jasmani_stat_validasi">
<input type="text" data-table="ciri_ciri_jasmani" data-field="x_stat_validasi" name="x_stat_validasi" id="x_stat_validasi" size="30" placeholder="<?php echo ew_HtmlEncode($ciri_ciri_jasmani->stat_validasi->getPlaceHolder()) ?>" value="<?php echo $ciri_ciri_jasmani->stat_validasi->EditValue ?>"<?php echo $ciri_ciri_jasmani->stat_validasi->EditAttributes() ?>>
</span>
<?php echo $ciri_ciri_jasmani->stat_validasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ciri_ciri_jasmani->change_date->Visible) { // change_date ?>
	<div id="r_change_date" class="form-group">
		<label id="elh_ciri_ciri_jasmani_change_date" for="x_change_date" class="<?php echo $ciri_ciri_jasmani_add->LeftColumnClass ?>"><?php echo $ciri_ciri_jasmani->change_date->FldCaption() ?></label>
		<div class="<?php echo $ciri_ciri_jasmani_add->RightColumnClass ?>"><div<?php echo $ciri_ciri_jasmani->change_date->CellAttributes() ?>>
<span id="el_ciri_ciri_jasmani_change_date">
<input type="text" data-table="ciri_ciri_jasmani" data-field="x_change_date" name="x_change_date" id="x_change_date" placeholder="<?php echo ew_HtmlEncode($ciri_ciri_jasmani->change_date->getPlaceHolder()) ?>" value="<?php echo $ciri_ciri_jasmani->change_date->EditValue ?>"<?php echo $ciri_ciri_jasmani->change_date->EditAttributes() ?>>
</span>
<?php echo $ciri_ciri_jasmani->change_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ciri_ciri_jasmani->change_by->Visible) { // change_by ?>
	<div id="r_change_by" class="form-group">
		<label id="elh_ciri_ciri_jasmani_change_by" for="x_change_by" class="<?php echo $ciri_ciri_jasmani_add->LeftColumnClass ?>"><?php echo $ciri_ciri_jasmani->change_by->FldCaption() ?></label>
		<div class="<?php echo $ciri_ciri_jasmani_add->RightColumnClass ?>"><div<?php echo $ciri_ciri_jasmani->change_by->CellAttributes() ?>>
<span id="el_ciri_ciri_jasmani_change_by">
<input type="text" data-table="ciri_ciri_jasmani" data-field="x_change_by" name="x_change_by" id="x_change_by" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($ciri_ciri_jasmani->change_by->getPlaceHolder()) ?>" value="<?php echo $ciri_ciri_jasmani->change_by->EditValue ?>"<?php echo $ciri_ciri_jasmani->change_by->EditAttributes() ?>>
</span>
<?php echo $ciri_ciri_jasmani->change_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$ciri_ciri_jasmani_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $ciri_ciri_jasmani_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ciri_ciri_jasmani_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fciri_ciri_jasmaniadd.Init();
</script>
<?php
$ciri_ciri_jasmani_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ciri_ciri_jasmani_add->Page_Terminate();
?>
