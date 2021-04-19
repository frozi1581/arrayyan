<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tb_gasinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tb_gas_edit = NULL; // Initialize page object first

class ctb_gas_edit extends ctb_gas {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'tb_gas';

	// Page object name
	var $PageObjName = 'tb_gas_edit';

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

		// Table object (tb_gas)
		if (!isset($GLOBALS["tb_gas"]) || get_class($GLOBALS["tb_gas"]) == "ctb_gas") {
			$GLOBALS["tb_gas"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_gas"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_gas', TRUE);

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
		$this->kd_gas->SetVisibility();
		$this->ket->SetVisibility();
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();
		$this->parent_kd_gas->SetVisibility();
		$this->old_kd_gas->SetVisibility();
		$this->old_ket_gas->SetVisibility();
		$this->status->SetVisibility();

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
		global $EW_EXPORT, $tb_gas;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_gas);
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
					if ($pageName == "tb_gasview.php")
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_kd_gas")) {
				$this->kd_gas->setFormValue($objForm->GetValue("x_kd_gas"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["kd_gas"])) {
				$this->kd_gas->setQueryStringValue($_GET["kd_gas"]);
				$loadByQuery = TRUE;
			} else {
				$this->kd_gas->CurrentValue = NULL;
			}
		}

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("tb_gaslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "tb_gaslist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->kd_gas->FldIsDetailKey) {
			$this->kd_gas->setFormValue($objForm->GetValue("x_kd_gas"));
		}
		if (!$this->ket->FldIsDetailKey) {
			$this->ket->setFormValue($objForm->GetValue("x_ket"));
		}
		if (!$this->created_by->FldIsDetailKey) {
			$this->created_by->setFormValue($objForm->GetValue("x_created_by"));
		}
		if (!$this->created_date->FldIsDetailKey) {
			$this->created_date->setFormValue($objForm->GetValue("x_created_date"));
			$this->created_date->CurrentValue = ew_UnFormatDateTime($this->created_date->CurrentValue, 0);
		}
		if (!$this->last_update_by->FldIsDetailKey) {
			$this->last_update_by->setFormValue($objForm->GetValue("x_last_update_by"));
		}
		if (!$this->last_update_date->FldIsDetailKey) {
			$this->last_update_date->setFormValue($objForm->GetValue("x_last_update_date"));
			$this->last_update_date->CurrentValue = ew_UnFormatDateTime($this->last_update_date->CurrentValue, 0);
		}
		if (!$this->parent_kd_gas->FldIsDetailKey) {
			$this->parent_kd_gas->setFormValue($objForm->GetValue("x_parent_kd_gas"));
		}
		if (!$this->old_kd_gas->FldIsDetailKey) {
			$this->old_kd_gas->setFormValue($objForm->GetValue("x_old_kd_gas"));
		}
		if (!$this->old_ket_gas->FldIsDetailKey) {
			$this->old_ket_gas->setFormValue($objForm->GetValue("x_old_ket_gas"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->kd_gas->CurrentValue = $this->kd_gas->FormValue;
		$this->ket->CurrentValue = $this->ket->FormValue;
		$this->created_by->CurrentValue = $this->created_by->FormValue;
		$this->created_date->CurrentValue = $this->created_date->FormValue;
		$this->created_date->CurrentValue = ew_UnFormatDateTime($this->created_date->CurrentValue, 0);
		$this->last_update_by->CurrentValue = $this->last_update_by->FormValue;
		$this->last_update_date->CurrentValue = $this->last_update_date->FormValue;
		$this->last_update_date->CurrentValue = ew_UnFormatDateTime($this->last_update_date->CurrentValue, 0);
		$this->parent_kd_gas->CurrentValue = $this->parent_kd_gas->FormValue;
		$this->old_kd_gas->CurrentValue = $this->old_kd_gas->FormValue;
		$this->old_ket_gas->CurrentValue = $this->old_ket_gas->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
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
		$this->kd_gas->setDbValue($row['kd_gas']);
		$this->ket->setDbValue($row['ket']);
		$this->created_by->setDbValue($row['created_by']);
		$this->created_date->setDbValue($row['created_date']);
		$this->last_update_by->setDbValue($row['last_update_by']);
		$this->last_update_date->setDbValue($row['last_update_date']);
		$this->parent_kd_gas->setDbValue($row['parent_kd_gas']);
		$this->old_kd_gas->setDbValue($row['old_kd_gas']);
		$this->old_ket_gas->setDbValue($row['old_ket_gas']);
		$this->status->setDbValue($row['status']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['kd_gas'] = NULL;
		$row['ket'] = NULL;
		$row['created_by'] = NULL;
		$row['created_date'] = NULL;
		$row['last_update_by'] = NULL;
		$row['last_update_date'] = NULL;
		$row['parent_kd_gas'] = NULL;
		$row['old_kd_gas'] = NULL;
		$row['old_ket_gas'] = NULL;
		$row['status'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->kd_gas->DbValue = $row['kd_gas'];
		$this->ket->DbValue = $row['ket'];
		$this->created_by->DbValue = $row['created_by'];
		$this->created_date->DbValue = $row['created_date'];
		$this->last_update_by->DbValue = $row['last_update_by'];
		$this->last_update_date->DbValue = $row['last_update_date'];
		$this->parent_kd_gas->DbValue = $row['parent_kd_gas'];
		$this->old_kd_gas->DbValue = $row['old_kd_gas'];
		$this->old_ket_gas->DbValue = $row['old_ket_gas'];
		$this->status->DbValue = $row['status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("kd_gas")) <> "")
			$this->kd_gas->CurrentValue = $this->getKey("kd_gas"); // kd_gas
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
		// kd_gas
		// ket
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// parent_kd_gas
		// old_kd_gas
		// old_ket_gas
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// kd_gas
		$this->kd_gas->ViewValue = $this->kd_gas->CurrentValue;
		$this->kd_gas->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

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

		// parent_kd_gas
		$this->parent_kd_gas->ViewValue = $this->parent_kd_gas->CurrentValue;
		$this->parent_kd_gas->ViewCustomAttributes = "";

		// old_kd_gas
		$this->old_kd_gas->ViewValue = $this->old_kd_gas->CurrentValue;
		$this->old_kd_gas->ViewCustomAttributes = "";

		// old_ket_gas
		$this->old_ket_gas->ViewValue = $this->old_ket_gas->CurrentValue;
		$this->old_ket_gas->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

			// kd_gas
			$this->kd_gas->LinkCustomAttributes = "";
			$this->kd_gas->HrefValue = "";
			$this->kd_gas->TooltipValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";
			$this->ket->TooltipValue = "";

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

			// parent_kd_gas
			$this->parent_kd_gas->LinkCustomAttributes = "";
			$this->parent_kd_gas->HrefValue = "";
			$this->parent_kd_gas->TooltipValue = "";

			// old_kd_gas
			$this->old_kd_gas->LinkCustomAttributes = "";
			$this->old_kd_gas->HrefValue = "";
			$this->old_kd_gas->TooltipValue = "";

			// old_ket_gas
			$this->old_ket_gas->LinkCustomAttributes = "";
			$this->old_ket_gas->HrefValue = "";
			$this->old_ket_gas->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// kd_gas
			$this->kd_gas->EditAttrs["class"] = "form-control";
			$this->kd_gas->EditCustomAttributes = "";
			$this->kd_gas->EditValue = $this->kd_gas->CurrentValue;
			$this->kd_gas->ViewCustomAttributes = "";

			// ket
			$this->ket->EditAttrs["class"] = "form-control";
			$this->ket->EditCustomAttributes = "";
			$this->ket->EditValue = ew_HtmlEncode($this->ket->CurrentValue);
			$this->ket->PlaceHolder = ew_RemoveHtml($this->ket->FldCaption());

			// created_by
			$this->created_by->EditAttrs["class"] = "form-control";
			$this->created_by->EditCustomAttributes = "";
			$this->created_by->EditValue = ew_HtmlEncode($this->created_by->CurrentValue);
			$this->created_by->PlaceHolder = ew_RemoveHtml($this->created_by->FldCaption());

			// created_date
			$this->created_date->EditAttrs["class"] = "form-control";
			$this->created_date->EditCustomAttributes = "";
			$this->created_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->created_date->CurrentValue, 8));
			$this->created_date->PlaceHolder = ew_RemoveHtml($this->created_date->FldCaption());

			// last_update_by
			$this->last_update_by->EditAttrs["class"] = "form-control";
			$this->last_update_by->EditCustomAttributes = "";
			$this->last_update_by->EditValue = ew_HtmlEncode($this->last_update_by->CurrentValue);
			$this->last_update_by->PlaceHolder = ew_RemoveHtml($this->last_update_by->FldCaption());

			// last_update_date
			$this->last_update_date->EditAttrs["class"] = "form-control";
			$this->last_update_date->EditCustomAttributes = "";
			$this->last_update_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->last_update_date->CurrentValue, 8));
			$this->last_update_date->PlaceHolder = ew_RemoveHtml($this->last_update_date->FldCaption());

			// parent_kd_gas
			$this->parent_kd_gas->EditAttrs["class"] = "form-control";
			$this->parent_kd_gas->EditCustomAttributes = "";
			$this->parent_kd_gas->EditValue = ew_HtmlEncode($this->parent_kd_gas->CurrentValue);
			$this->parent_kd_gas->PlaceHolder = ew_RemoveHtml($this->parent_kd_gas->FldCaption());

			// old_kd_gas
			$this->old_kd_gas->EditAttrs["class"] = "form-control";
			$this->old_kd_gas->EditCustomAttributes = "";
			$this->old_kd_gas->EditValue = ew_HtmlEncode($this->old_kd_gas->CurrentValue);
			$this->old_kd_gas->PlaceHolder = ew_RemoveHtml($this->old_kd_gas->FldCaption());

			// old_ket_gas
			$this->old_ket_gas->EditAttrs["class"] = "form-control";
			$this->old_ket_gas->EditCustomAttributes = "";
			$this->old_ket_gas->EditValue = ew_HtmlEncode($this->old_ket_gas->CurrentValue);
			$this->old_ket_gas->PlaceHolder = ew_RemoveHtml($this->old_ket_gas->FldCaption());

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = ew_HtmlEncode($this->status->CurrentValue);
			$this->status->PlaceHolder = ew_RemoveHtml($this->status->FldCaption());

			// Edit refer script
			// kd_gas

			$this->kd_gas->LinkCustomAttributes = "";
			$this->kd_gas->HrefValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";

			// created_by
			$this->created_by->LinkCustomAttributes = "";
			$this->created_by->HrefValue = "";

			// created_date
			$this->created_date->LinkCustomAttributes = "";
			$this->created_date->HrefValue = "";

			// last_update_by
			$this->last_update_by->LinkCustomAttributes = "";
			$this->last_update_by->HrefValue = "";

			// last_update_date
			$this->last_update_date->LinkCustomAttributes = "";
			$this->last_update_date->HrefValue = "";

			// parent_kd_gas
			$this->parent_kd_gas->LinkCustomAttributes = "";
			$this->parent_kd_gas->HrefValue = "";

			// old_kd_gas
			$this->old_kd_gas->LinkCustomAttributes = "";
			$this->old_kd_gas->HrefValue = "";

			// old_ket_gas
			$this->old_ket_gas->LinkCustomAttributes = "";
			$this->old_ket_gas->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
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
		if (!$this->kd_gas->FldIsDetailKey && !is_null($this->kd_gas->FormValue) && $this->kd_gas->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kd_gas->FldCaption(), $this->kd_gas->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->created_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->created_date->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->last_update_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->last_update_date->FldErrMsg());
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// kd_gas
			// ket

			$this->ket->SetDbValueDef($rsnew, $this->ket->CurrentValue, NULL, $this->ket->ReadOnly);

			// created_by
			$this->created_by->SetDbValueDef($rsnew, $this->created_by->CurrentValue, NULL, $this->created_by->ReadOnly);

			// created_date
			$this->created_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->created_date->CurrentValue, 0), NULL, $this->created_date->ReadOnly);

			// last_update_by
			$this->last_update_by->SetDbValueDef($rsnew, $this->last_update_by->CurrentValue, NULL, $this->last_update_by->ReadOnly);

			// last_update_date
			$this->last_update_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->last_update_date->CurrentValue, 0), NULL, $this->last_update_date->ReadOnly);

			// parent_kd_gas
			$this->parent_kd_gas->SetDbValueDef($rsnew, $this->parent_kd_gas->CurrentValue, NULL, $this->parent_kd_gas->ReadOnly);

			// old_kd_gas
			$this->old_kd_gas->SetDbValueDef($rsnew, $this->old_kd_gas->CurrentValue, NULL, $this->old_kd_gas->ReadOnly);

			// old_ket_gas
			$this->old_ket_gas->SetDbValueDef($rsnew, $this->old_ket_gas->CurrentValue, NULL, $this->old_ket_gas->ReadOnly);

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, NULL, $this->status->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_gaslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($tb_gas_edit)) $tb_gas_edit = new ctb_gas_edit();

// Page init
$tb_gas_edit->Page_Init();

// Page main
$tb_gas_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_gas_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ftb_gasedit = new ew_Form("ftb_gasedit", "edit");

// Validate form
ftb_gasedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_kd_gas");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_gas->kd_gas->FldCaption(), $tb_gas->kd_gas->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_created_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_gas->created_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_update_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_gas->last_update_date->FldErrMsg()) ?>");

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
ftb_gasedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftb_gasedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tb_gas_edit->ShowPageHeader(); ?>
<?php
$tb_gas_edit->ShowMessage();
?>
<form name="ftb_gasedit" id="ftb_gasedit" class="<?php echo $tb_gas_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_gas_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_gas_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_gas">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($tb_gas_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($tb_gas->kd_gas->Visible) { // kd_gas ?>
	<div id="r_kd_gas" class="form-group">
		<label id="elh_tb_gas_kd_gas" for="x_kd_gas" class="<?php echo $tb_gas_edit->LeftColumnClass ?>"><?php echo $tb_gas->kd_gas->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $tb_gas_edit->RightColumnClass ?>"><div<?php echo $tb_gas->kd_gas->CellAttributes() ?>>
<span id="el_tb_gas_kd_gas">
<span<?php echo $tb_gas->kd_gas->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_gas->kd_gas->EditValue ?></p></span>
</span>
<input type="hidden" data-table="tb_gas" data-field="x_kd_gas" name="x_kd_gas" id="x_kd_gas" value="<?php echo ew_HtmlEncode($tb_gas->kd_gas->CurrentValue) ?>">
<?php echo $tb_gas->kd_gas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_gas->ket->Visible) { // ket ?>
	<div id="r_ket" class="form-group">
		<label id="elh_tb_gas_ket" for="x_ket" class="<?php echo $tb_gas_edit->LeftColumnClass ?>"><?php echo $tb_gas->ket->FldCaption() ?></label>
		<div class="<?php echo $tb_gas_edit->RightColumnClass ?>"><div<?php echo $tb_gas->ket->CellAttributes() ?>>
<span id="el_tb_gas_ket">
<input type="text" data-table="tb_gas" data-field="x_ket" name="x_ket" id="x_ket" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tb_gas->ket->getPlaceHolder()) ?>" value="<?php echo $tb_gas->ket->EditValue ?>"<?php echo $tb_gas->ket->EditAttributes() ?>>
</span>
<?php echo $tb_gas->ket->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_gas->created_by->Visible) { // created_by ?>
	<div id="r_created_by" class="form-group">
		<label id="elh_tb_gas_created_by" for="x_created_by" class="<?php echo $tb_gas_edit->LeftColumnClass ?>"><?php echo $tb_gas->created_by->FldCaption() ?></label>
		<div class="<?php echo $tb_gas_edit->RightColumnClass ?>"><div<?php echo $tb_gas->created_by->CellAttributes() ?>>
<span id="el_tb_gas_created_by">
<input type="text" data-table="tb_gas" data-field="x_created_by" name="x_created_by" id="x_created_by" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($tb_gas->created_by->getPlaceHolder()) ?>" value="<?php echo $tb_gas->created_by->EditValue ?>"<?php echo $tb_gas->created_by->EditAttributes() ?>>
</span>
<?php echo $tb_gas->created_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_gas->created_date->Visible) { // created_date ?>
	<div id="r_created_date" class="form-group">
		<label id="elh_tb_gas_created_date" for="x_created_date" class="<?php echo $tb_gas_edit->LeftColumnClass ?>"><?php echo $tb_gas->created_date->FldCaption() ?></label>
		<div class="<?php echo $tb_gas_edit->RightColumnClass ?>"><div<?php echo $tb_gas->created_date->CellAttributes() ?>>
<span id="el_tb_gas_created_date">
<input type="text" data-table="tb_gas" data-field="x_created_date" name="x_created_date" id="x_created_date" placeholder="<?php echo ew_HtmlEncode($tb_gas->created_date->getPlaceHolder()) ?>" value="<?php echo $tb_gas->created_date->EditValue ?>"<?php echo $tb_gas->created_date->EditAttributes() ?>>
</span>
<?php echo $tb_gas->created_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_gas->last_update_by->Visible) { // last_update_by ?>
	<div id="r_last_update_by" class="form-group">
		<label id="elh_tb_gas_last_update_by" for="x_last_update_by" class="<?php echo $tb_gas_edit->LeftColumnClass ?>"><?php echo $tb_gas->last_update_by->FldCaption() ?></label>
		<div class="<?php echo $tb_gas_edit->RightColumnClass ?>"><div<?php echo $tb_gas->last_update_by->CellAttributes() ?>>
<span id="el_tb_gas_last_update_by">
<input type="text" data-table="tb_gas" data-field="x_last_update_by" name="x_last_update_by" id="x_last_update_by" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($tb_gas->last_update_by->getPlaceHolder()) ?>" value="<?php echo $tb_gas->last_update_by->EditValue ?>"<?php echo $tb_gas->last_update_by->EditAttributes() ?>>
</span>
<?php echo $tb_gas->last_update_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_gas->last_update_date->Visible) { // last_update_date ?>
	<div id="r_last_update_date" class="form-group">
		<label id="elh_tb_gas_last_update_date" for="x_last_update_date" class="<?php echo $tb_gas_edit->LeftColumnClass ?>"><?php echo $tb_gas->last_update_date->FldCaption() ?></label>
		<div class="<?php echo $tb_gas_edit->RightColumnClass ?>"><div<?php echo $tb_gas->last_update_date->CellAttributes() ?>>
<span id="el_tb_gas_last_update_date">
<input type="text" data-table="tb_gas" data-field="x_last_update_date" name="x_last_update_date" id="x_last_update_date" placeholder="<?php echo ew_HtmlEncode($tb_gas->last_update_date->getPlaceHolder()) ?>" value="<?php echo $tb_gas->last_update_date->EditValue ?>"<?php echo $tb_gas->last_update_date->EditAttributes() ?>>
</span>
<?php echo $tb_gas->last_update_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_gas->parent_kd_gas->Visible) { // parent_kd_gas ?>
	<div id="r_parent_kd_gas" class="form-group">
		<label id="elh_tb_gas_parent_kd_gas" for="x_parent_kd_gas" class="<?php echo $tb_gas_edit->LeftColumnClass ?>"><?php echo $tb_gas->parent_kd_gas->FldCaption() ?></label>
		<div class="<?php echo $tb_gas_edit->RightColumnClass ?>"><div<?php echo $tb_gas->parent_kd_gas->CellAttributes() ?>>
<span id="el_tb_gas_parent_kd_gas">
<input type="text" data-table="tb_gas" data-field="x_parent_kd_gas" name="x_parent_kd_gas" id="x_parent_kd_gas" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($tb_gas->parent_kd_gas->getPlaceHolder()) ?>" value="<?php echo $tb_gas->parent_kd_gas->EditValue ?>"<?php echo $tb_gas->parent_kd_gas->EditAttributes() ?>>
</span>
<?php echo $tb_gas->parent_kd_gas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_gas->old_kd_gas->Visible) { // old_kd_gas ?>
	<div id="r_old_kd_gas" class="form-group">
		<label id="elh_tb_gas_old_kd_gas" for="x_old_kd_gas" class="<?php echo $tb_gas_edit->LeftColumnClass ?>"><?php echo $tb_gas->old_kd_gas->FldCaption() ?></label>
		<div class="<?php echo $tb_gas_edit->RightColumnClass ?>"><div<?php echo $tb_gas->old_kd_gas->CellAttributes() ?>>
<span id="el_tb_gas_old_kd_gas">
<input type="text" data-table="tb_gas" data-field="x_old_kd_gas" name="x_old_kd_gas" id="x_old_kd_gas" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($tb_gas->old_kd_gas->getPlaceHolder()) ?>" value="<?php echo $tb_gas->old_kd_gas->EditValue ?>"<?php echo $tb_gas->old_kd_gas->EditAttributes() ?>>
</span>
<?php echo $tb_gas->old_kd_gas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_gas->old_ket_gas->Visible) { // old_ket_gas ?>
	<div id="r_old_ket_gas" class="form-group">
		<label id="elh_tb_gas_old_ket_gas" for="x_old_ket_gas" class="<?php echo $tb_gas_edit->LeftColumnClass ?>"><?php echo $tb_gas->old_ket_gas->FldCaption() ?></label>
		<div class="<?php echo $tb_gas_edit->RightColumnClass ?>"><div<?php echo $tb_gas->old_ket_gas->CellAttributes() ?>>
<span id="el_tb_gas_old_ket_gas">
<input type="text" data-table="tb_gas" data-field="x_old_ket_gas" name="x_old_ket_gas" id="x_old_ket_gas" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tb_gas->old_ket_gas->getPlaceHolder()) ?>" value="<?php echo $tb_gas->old_ket_gas->EditValue ?>"<?php echo $tb_gas->old_ket_gas->EditAttributes() ?>>
</span>
<?php echo $tb_gas->old_ket_gas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_gas->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_tb_gas_status" for="x_status" class="<?php echo $tb_gas_edit->LeftColumnClass ?>"><?php echo $tb_gas->status->FldCaption() ?></label>
		<div class="<?php echo $tb_gas_edit->RightColumnClass ?>"><div<?php echo $tb_gas->status->CellAttributes() ?>>
<span id="el_tb_gas_status">
<input type="text" data-table="tb_gas" data-field="x_status" name="x_status" id="x_status" size="30" maxlength="1" placeholder="<?php echo ew_HtmlEncode($tb_gas->status->getPlaceHolder()) ?>" value="<?php echo $tb_gas->status->EditValue ?>"<?php echo $tb_gas->status->EditAttributes() ?>>
</span>
<?php echo $tb_gas->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$tb_gas_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $tb_gas_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_gas_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ftb_gasedit.Init();
</script>
<?php
$tb_gas_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_gas_edit->Page_Terminate();
?>
