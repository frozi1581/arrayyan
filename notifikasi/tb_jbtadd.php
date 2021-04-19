<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tb_jbtinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tb_jbt_add = NULL; // Initialize page object first

class ctb_jbt_add extends ctb_jbt {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'tb_jbt';

	// Page object name
	var $PageObjName = 'tb_jbt_add';

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

		// Table object (tb_jbt)
		if (!isset($GLOBALS["tb_jbt"]) || get_class($GLOBALS["tb_jbt"]) == "ctb_jbt") {
			$GLOBALS["tb_jbt"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_jbt"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_jbt', TRUE);

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
		$this->kd_jbt->SetVisibility();
		$this->ket->SetVisibility();
		$this->tjb->SetVisibility();
		$this->koef->SetVisibility();
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();
		$this->kd_jbt_old->SetVisibility();
		$this->ket_old->SetVisibility();
		$this->jbt_type->SetVisibility();
		$this->org_id->SetVisibility();
		$this->parent_kd_jbt->SetVisibility();
		$this->eselon_num->SetVisibility();
		$this->jns_jbt->SetVisibility();
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
		global $EW_EXPORT, $tb_jbt;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_jbt);
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
					if ($pageName == "tb_jbtview.php")
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
			if (@$_GET["kd_jbt"] != "") {
				$this->kd_jbt->setQueryStringValue($_GET["kd_jbt"]);
				$this->setKey("kd_jbt", $this->kd_jbt->CurrentValue); // Set up key
			} else {
				$this->setKey("kd_jbt", ""); // Clear key
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
					$this->Page_Terminate("tb_jbtlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tb_jbtlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "tb_jbtview.php")
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
		$this->kd_jbt->CurrentValue = NULL;
		$this->kd_jbt->OldValue = $this->kd_jbt->CurrentValue;
		$this->ket->CurrentValue = NULL;
		$this->ket->OldValue = $this->ket->CurrentValue;
		$this->tjb->CurrentValue = "N";
		$this->koef->CurrentValue = 0.00;
		$this->created_by->CurrentValue = NULL;
		$this->created_by->OldValue = $this->created_by->CurrentValue;
		$this->created_date->CurrentValue = NULL;
		$this->created_date->OldValue = $this->created_date->CurrentValue;
		$this->last_update_by->CurrentValue = NULL;
		$this->last_update_by->OldValue = $this->last_update_by->CurrentValue;
		$this->last_update_date->CurrentValue = NULL;
		$this->last_update_date->OldValue = $this->last_update_date->CurrentValue;
		$this->kd_jbt_old->CurrentValue = NULL;
		$this->kd_jbt_old->OldValue = $this->kd_jbt_old->CurrentValue;
		$this->ket_old->CurrentValue = NULL;
		$this->ket_old->OldValue = $this->ket_old->CurrentValue;
		$this->jbt_type->CurrentValue = NULL;
		$this->jbt_type->OldValue = $this->jbt_type->CurrentValue;
		$this->org_id->CurrentValue = NULL;
		$this->org_id->OldValue = $this->org_id->CurrentValue;
		$this->parent_kd_jbt->CurrentValue = NULL;
		$this->parent_kd_jbt->OldValue = $this->parent_kd_jbt->CurrentValue;
		$this->eselon_num->CurrentValue = 0;
		$this->jns_jbt->CurrentValue = "STRUKTURAL";
		$this->status->CurrentValue = "0";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->kd_jbt->FldIsDetailKey) {
			$this->kd_jbt->setFormValue($objForm->GetValue("x_kd_jbt"));
		}
		if (!$this->ket->FldIsDetailKey) {
			$this->ket->setFormValue($objForm->GetValue("x_ket"));
		}
		if (!$this->tjb->FldIsDetailKey) {
			$this->tjb->setFormValue($objForm->GetValue("x_tjb"));
		}
		if (!$this->koef->FldIsDetailKey) {
			$this->koef->setFormValue($objForm->GetValue("x_koef"));
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
		if (!$this->kd_jbt_old->FldIsDetailKey) {
			$this->kd_jbt_old->setFormValue($objForm->GetValue("x_kd_jbt_old"));
		}
		if (!$this->ket_old->FldIsDetailKey) {
			$this->ket_old->setFormValue($objForm->GetValue("x_ket_old"));
		}
		if (!$this->jbt_type->FldIsDetailKey) {
			$this->jbt_type->setFormValue($objForm->GetValue("x_jbt_type"));
		}
		if (!$this->org_id->FldIsDetailKey) {
			$this->org_id->setFormValue($objForm->GetValue("x_org_id"));
		}
		if (!$this->parent_kd_jbt->FldIsDetailKey) {
			$this->parent_kd_jbt->setFormValue($objForm->GetValue("x_parent_kd_jbt"));
		}
		if (!$this->eselon_num->FldIsDetailKey) {
			$this->eselon_num->setFormValue($objForm->GetValue("x_eselon_num"));
		}
		if (!$this->jns_jbt->FldIsDetailKey) {
			$this->jns_jbt->setFormValue($objForm->GetValue("x_jns_jbt"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->kd_jbt->CurrentValue = $this->kd_jbt->FormValue;
		$this->ket->CurrentValue = $this->ket->FormValue;
		$this->tjb->CurrentValue = $this->tjb->FormValue;
		$this->koef->CurrentValue = $this->koef->FormValue;
		$this->created_by->CurrentValue = $this->created_by->FormValue;
		$this->created_date->CurrentValue = $this->created_date->FormValue;
		$this->created_date->CurrentValue = ew_UnFormatDateTime($this->created_date->CurrentValue, 0);
		$this->last_update_by->CurrentValue = $this->last_update_by->FormValue;
		$this->last_update_date->CurrentValue = $this->last_update_date->FormValue;
		$this->last_update_date->CurrentValue = ew_UnFormatDateTime($this->last_update_date->CurrentValue, 0);
		$this->kd_jbt_old->CurrentValue = $this->kd_jbt_old->FormValue;
		$this->ket_old->CurrentValue = $this->ket_old->FormValue;
		$this->jbt_type->CurrentValue = $this->jbt_type->FormValue;
		$this->org_id->CurrentValue = $this->org_id->FormValue;
		$this->parent_kd_jbt->CurrentValue = $this->parent_kd_jbt->FormValue;
		$this->eselon_num->CurrentValue = $this->eselon_num->FormValue;
		$this->jns_jbt->CurrentValue = $this->jns_jbt->FormValue;
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
		$this->kd_jbt->setDbValue($row['kd_jbt']);
		$this->ket->setDbValue($row['ket']);
		$this->tjb->setDbValue($row['tjb']);
		$this->koef->setDbValue($row['koef']);
		$this->created_by->setDbValue($row['created_by']);
		$this->created_date->setDbValue($row['created_date']);
		$this->last_update_by->setDbValue($row['last_update_by']);
		$this->last_update_date->setDbValue($row['last_update_date']);
		$this->kd_jbt_old->setDbValue($row['kd_jbt_old']);
		$this->ket_old->setDbValue($row['ket_old']);
		$this->jbt_type->setDbValue($row['jbt_type']);
		$this->org_id->setDbValue($row['org_id']);
		$this->parent_kd_jbt->setDbValue($row['parent_kd_jbt']);
		$this->eselon_num->setDbValue($row['eselon_num']);
		$this->jns_jbt->setDbValue($row['jns_jbt']);
		$this->status->setDbValue($row['status']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['kd_jbt'] = $this->kd_jbt->CurrentValue;
		$row['ket'] = $this->ket->CurrentValue;
		$row['tjb'] = $this->tjb->CurrentValue;
		$row['koef'] = $this->koef->CurrentValue;
		$row['created_by'] = $this->created_by->CurrentValue;
		$row['created_date'] = $this->created_date->CurrentValue;
		$row['last_update_by'] = $this->last_update_by->CurrentValue;
		$row['last_update_date'] = $this->last_update_date->CurrentValue;
		$row['kd_jbt_old'] = $this->kd_jbt_old->CurrentValue;
		$row['ket_old'] = $this->ket_old->CurrentValue;
		$row['jbt_type'] = $this->jbt_type->CurrentValue;
		$row['org_id'] = $this->org_id->CurrentValue;
		$row['parent_kd_jbt'] = $this->parent_kd_jbt->CurrentValue;
		$row['eselon_num'] = $this->eselon_num->CurrentValue;
		$row['jns_jbt'] = $this->jns_jbt->CurrentValue;
		$row['status'] = $this->status->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->kd_jbt->DbValue = $row['kd_jbt'];
		$this->ket->DbValue = $row['ket'];
		$this->tjb->DbValue = $row['tjb'];
		$this->koef->DbValue = $row['koef'];
		$this->created_by->DbValue = $row['created_by'];
		$this->created_date->DbValue = $row['created_date'];
		$this->last_update_by->DbValue = $row['last_update_by'];
		$this->last_update_date->DbValue = $row['last_update_date'];
		$this->kd_jbt_old->DbValue = $row['kd_jbt_old'];
		$this->ket_old->DbValue = $row['ket_old'];
		$this->jbt_type->DbValue = $row['jbt_type'];
		$this->org_id->DbValue = $row['org_id'];
		$this->parent_kd_jbt->DbValue = $row['parent_kd_jbt'];
		$this->eselon_num->DbValue = $row['eselon_num'];
		$this->jns_jbt->DbValue = $row['jns_jbt'];
		$this->status->DbValue = $row['status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("kd_jbt")) <> "")
			$this->kd_jbt->CurrentValue = $this->getKey("kd_jbt"); // kd_jbt
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
		// Convert decimal values if posted back

		if ($this->koef->FormValue == $this->koef->CurrentValue && is_numeric(ew_StrToFloat($this->koef->CurrentValue)))
			$this->koef->CurrentValue = ew_StrToFloat($this->koef->CurrentValue);

		// Convert decimal values if posted back
		if ($this->eselon_num->FormValue == $this->eselon_num->CurrentValue && is_numeric(ew_StrToFloat($this->eselon_num->CurrentValue)))
			$this->eselon_num->CurrentValue = ew_StrToFloat($this->eselon_num->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// kd_jbt
		// ket
		// tjb
		// koef
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// kd_jbt_old
		// ket_old
		// jbt_type
		// org_id
		// parent_kd_jbt
		// eselon_num
		// jns_jbt
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// kd_jbt
		$this->kd_jbt->ViewValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

		// tjb
		$this->tjb->ViewValue = $this->tjb->CurrentValue;
		$this->tjb->ViewCustomAttributes = "";

		// koef
		$this->koef->ViewValue = $this->koef->CurrentValue;
		$this->koef->ViewCustomAttributes = "";

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

		// kd_jbt_old
		$this->kd_jbt_old->ViewValue = $this->kd_jbt_old->CurrentValue;
		$this->kd_jbt_old->ViewCustomAttributes = "";

		// ket_old
		$this->ket_old->ViewValue = $this->ket_old->CurrentValue;
		$this->ket_old->ViewCustomAttributes = "";

		// jbt_type
		$this->jbt_type->ViewValue = $this->jbt_type->CurrentValue;
		$this->jbt_type->ViewCustomAttributes = "";

		// org_id
		$this->org_id->ViewValue = $this->org_id->CurrentValue;
		$this->org_id->ViewCustomAttributes = "";

		// parent_kd_jbt
		$this->parent_kd_jbt->ViewValue = $this->parent_kd_jbt->CurrentValue;
		$this->parent_kd_jbt->ViewCustomAttributes = "";

		// eselon_num
		$this->eselon_num->ViewValue = $this->eselon_num->CurrentValue;
		$this->eselon_num->ViewCustomAttributes = "";

		// jns_jbt
		$this->jns_jbt->ViewValue = $this->jns_jbt->CurrentValue;
		$this->jns_jbt->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

			// kd_jbt
			$this->kd_jbt->LinkCustomAttributes = "";
			$this->kd_jbt->HrefValue = "";
			$this->kd_jbt->TooltipValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";
			$this->ket->TooltipValue = "";

			// tjb
			$this->tjb->LinkCustomAttributes = "";
			$this->tjb->HrefValue = "";
			$this->tjb->TooltipValue = "";

			// koef
			$this->koef->LinkCustomAttributes = "";
			$this->koef->HrefValue = "";
			$this->koef->TooltipValue = "";

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

			// kd_jbt_old
			$this->kd_jbt_old->LinkCustomAttributes = "";
			$this->kd_jbt_old->HrefValue = "";
			$this->kd_jbt_old->TooltipValue = "";

			// ket_old
			$this->ket_old->LinkCustomAttributes = "";
			$this->ket_old->HrefValue = "";
			$this->ket_old->TooltipValue = "";

			// jbt_type
			$this->jbt_type->LinkCustomAttributes = "";
			$this->jbt_type->HrefValue = "";
			$this->jbt_type->TooltipValue = "";

			// org_id
			$this->org_id->LinkCustomAttributes = "";
			$this->org_id->HrefValue = "";
			$this->org_id->TooltipValue = "";

			// parent_kd_jbt
			$this->parent_kd_jbt->LinkCustomAttributes = "";
			$this->parent_kd_jbt->HrefValue = "";
			$this->parent_kd_jbt->TooltipValue = "";

			// eselon_num
			$this->eselon_num->LinkCustomAttributes = "";
			$this->eselon_num->HrefValue = "";
			$this->eselon_num->TooltipValue = "";

			// jns_jbt
			$this->jns_jbt->LinkCustomAttributes = "";
			$this->jns_jbt->HrefValue = "";
			$this->jns_jbt->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// kd_jbt
			$this->kd_jbt->EditAttrs["class"] = "form-control";
			$this->kd_jbt->EditCustomAttributes = "";
			$this->kd_jbt->EditValue = ew_HtmlEncode($this->kd_jbt->CurrentValue);
			$this->kd_jbt->PlaceHolder = ew_RemoveHtml($this->kd_jbt->FldCaption());

			// ket
			$this->ket->EditAttrs["class"] = "form-control";
			$this->ket->EditCustomAttributes = "";
			$this->ket->EditValue = ew_HtmlEncode($this->ket->CurrentValue);
			$this->ket->PlaceHolder = ew_RemoveHtml($this->ket->FldCaption());

			// tjb
			$this->tjb->EditAttrs["class"] = "form-control";
			$this->tjb->EditCustomAttributes = "";
			$this->tjb->EditValue = ew_HtmlEncode($this->tjb->CurrentValue);
			$this->tjb->PlaceHolder = ew_RemoveHtml($this->tjb->FldCaption());

			// koef
			$this->koef->EditAttrs["class"] = "form-control";
			$this->koef->EditCustomAttributes = "";
			$this->koef->EditValue = ew_HtmlEncode($this->koef->CurrentValue);
			$this->koef->PlaceHolder = ew_RemoveHtml($this->koef->FldCaption());
			if (strval($this->koef->EditValue) <> "" && is_numeric($this->koef->EditValue)) $this->koef->EditValue = ew_FormatNumber($this->koef->EditValue, -2, -1, -2, 0);

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

			// kd_jbt_old
			$this->kd_jbt_old->EditAttrs["class"] = "form-control";
			$this->kd_jbt_old->EditCustomAttributes = "";
			$this->kd_jbt_old->EditValue = ew_HtmlEncode($this->kd_jbt_old->CurrentValue);
			$this->kd_jbt_old->PlaceHolder = ew_RemoveHtml($this->kd_jbt_old->FldCaption());

			// ket_old
			$this->ket_old->EditAttrs["class"] = "form-control";
			$this->ket_old->EditCustomAttributes = "";
			$this->ket_old->EditValue = ew_HtmlEncode($this->ket_old->CurrentValue);
			$this->ket_old->PlaceHolder = ew_RemoveHtml($this->ket_old->FldCaption());

			// jbt_type
			$this->jbt_type->EditAttrs["class"] = "form-control";
			$this->jbt_type->EditCustomAttributes = "";
			$this->jbt_type->EditValue = ew_HtmlEncode($this->jbt_type->CurrentValue);
			$this->jbt_type->PlaceHolder = ew_RemoveHtml($this->jbt_type->FldCaption());

			// org_id
			$this->org_id->EditAttrs["class"] = "form-control";
			$this->org_id->EditCustomAttributes = "";
			$this->org_id->EditValue = ew_HtmlEncode($this->org_id->CurrentValue);
			$this->org_id->PlaceHolder = ew_RemoveHtml($this->org_id->FldCaption());

			// parent_kd_jbt
			$this->parent_kd_jbt->EditAttrs["class"] = "form-control";
			$this->parent_kd_jbt->EditCustomAttributes = "";
			$this->parent_kd_jbt->EditValue = ew_HtmlEncode($this->parent_kd_jbt->CurrentValue);
			$this->parent_kd_jbt->PlaceHolder = ew_RemoveHtml($this->parent_kd_jbt->FldCaption());

			// eselon_num
			$this->eselon_num->EditAttrs["class"] = "form-control";
			$this->eselon_num->EditCustomAttributes = "";
			$this->eselon_num->EditValue = ew_HtmlEncode($this->eselon_num->CurrentValue);
			$this->eselon_num->PlaceHolder = ew_RemoveHtml($this->eselon_num->FldCaption());
			if (strval($this->eselon_num->EditValue) <> "" && is_numeric($this->eselon_num->EditValue)) $this->eselon_num->EditValue = ew_FormatNumber($this->eselon_num->EditValue, -2, -1, -2, 0);

			// jns_jbt
			$this->jns_jbt->EditAttrs["class"] = "form-control";
			$this->jns_jbt->EditCustomAttributes = "";
			$this->jns_jbt->EditValue = ew_HtmlEncode($this->jns_jbt->CurrentValue);
			$this->jns_jbt->PlaceHolder = ew_RemoveHtml($this->jns_jbt->FldCaption());

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = ew_HtmlEncode($this->status->CurrentValue);
			$this->status->PlaceHolder = ew_RemoveHtml($this->status->FldCaption());

			// Add refer script
			// kd_jbt

			$this->kd_jbt->LinkCustomAttributes = "";
			$this->kd_jbt->HrefValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";

			// tjb
			$this->tjb->LinkCustomAttributes = "";
			$this->tjb->HrefValue = "";

			// koef
			$this->koef->LinkCustomAttributes = "";
			$this->koef->HrefValue = "";

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

			// kd_jbt_old
			$this->kd_jbt_old->LinkCustomAttributes = "";
			$this->kd_jbt_old->HrefValue = "";

			// ket_old
			$this->ket_old->LinkCustomAttributes = "";
			$this->ket_old->HrefValue = "";

			// jbt_type
			$this->jbt_type->LinkCustomAttributes = "";
			$this->jbt_type->HrefValue = "";

			// org_id
			$this->org_id->LinkCustomAttributes = "";
			$this->org_id->HrefValue = "";

			// parent_kd_jbt
			$this->parent_kd_jbt->LinkCustomAttributes = "";
			$this->parent_kd_jbt->HrefValue = "";

			// eselon_num
			$this->eselon_num->LinkCustomAttributes = "";
			$this->eselon_num->HrefValue = "";

			// jns_jbt
			$this->jns_jbt->LinkCustomAttributes = "";
			$this->jns_jbt->HrefValue = "";

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
		if (!$this->kd_jbt->FldIsDetailKey && !is_null($this->kd_jbt->FormValue) && $this->kd_jbt->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kd_jbt->FldCaption(), $this->kd_jbt->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->koef->FormValue)) {
			ew_AddMessage($gsFormError, $this->koef->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->created_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->created_date->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->last_update_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->last_update_date->FldErrMsg());
		}
		if (!ew_CheckNumber($this->eselon_num->FormValue)) {
			ew_AddMessage($gsFormError, $this->eselon_num->FldErrMsg());
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

		// kd_jbt
		$this->kd_jbt->SetDbValueDef($rsnew, $this->kd_jbt->CurrentValue, "", FALSE);

		// ket
		$this->ket->SetDbValueDef($rsnew, $this->ket->CurrentValue, NULL, FALSE);

		// tjb
		$this->tjb->SetDbValueDef($rsnew, $this->tjb->CurrentValue, NULL, strval($this->tjb->CurrentValue) == "");

		// koef
		$this->koef->SetDbValueDef($rsnew, $this->koef->CurrentValue, NULL, strval($this->koef->CurrentValue) == "");

		// created_by
		$this->created_by->SetDbValueDef($rsnew, $this->created_by->CurrentValue, NULL, FALSE);

		// created_date
		$this->created_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->created_date->CurrentValue, 0), NULL, FALSE);

		// last_update_by
		$this->last_update_by->SetDbValueDef($rsnew, $this->last_update_by->CurrentValue, NULL, FALSE);

		// last_update_date
		$this->last_update_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->last_update_date->CurrentValue, 0), NULL, FALSE);

		// kd_jbt_old
		$this->kd_jbt_old->SetDbValueDef($rsnew, $this->kd_jbt_old->CurrentValue, NULL, FALSE);

		// ket_old
		$this->ket_old->SetDbValueDef($rsnew, $this->ket_old->CurrentValue, NULL, FALSE);

		// jbt_type
		$this->jbt_type->SetDbValueDef($rsnew, $this->jbt_type->CurrentValue, NULL, FALSE);

		// org_id
		$this->org_id->SetDbValueDef($rsnew, $this->org_id->CurrentValue, NULL, FALSE);

		// parent_kd_jbt
		$this->parent_kd_jbt->SetDbValueDef($rsnew, $this->parent_kd_jbt->CurrentValue, NULL, FALSE);

		// eselon_num
		$this->eselon_num->SetDbValueDef($rsnew, $this->eselon_num->CurrentValue, NULL, strval($this->eselon_num->CurrentValue) == "");

		// jns_jbt
		$this->jns_jbt->SetDbValueDef($rsnew, $this->jns_jbt->CurrentValue, NULL, strval($this->jns_jbt->CurrentValue) == "");

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, NULL, strval($this->status->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['kd_jbt']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_jbtlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($tb_jbt_add)) $tb_jbt_add = new ctb_jbt_add();

// Page init
$tb_jbt_add->Page_Init();

// Page main
$tb_jbt_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_jbt_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftb_jbtadd = new ew_Form("ftb_jbtadd", "add");

// Validate form
ftb_jbtadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_kd_jbt");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_jbt->kd_jbt->FldCaption(), $tb_jbt->kd_jbt->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_koef");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_jbt->koef->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_created_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_jbt->created_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_update_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_jbt->last_update_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_eselon_num");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_jbt->eselon_num->FldErrMsg()) ?>");

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
ftb_jbtadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftb_jbtadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tb_jbt_add->ShowPageHeader(); ?>
<?php
$tb_jbt_add->ShowMessage();
?>
<form name="ftb_jbtadd" id="ftb_jbtadd" class="<?php echo $tb_jbt_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_jbt_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_jbt_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_jbt">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($tb_jbt_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($tb_jbt->kd_jbt->Visible) { // kd_jbt ?>
	<div id="r_kd_jbt" class="form-group">
		<label id="elh_tb_jbt_kd_jbt" for="x_kd_jbt" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->kd_jbt->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->kd_jbt->CellAttributes() ?>>
<span id="el_tb_jbt_kd_jbt">
<input type="text" data-table="tb_jbt" data-field="x_kd_jbt" name="x_kd_jbt" id="x_kd_jbt" size="30" maxlength="7" placeholder="<?php echo ew_HtmlEncode($tb_jbt->kd_jbt->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->kd_jbt->EditValue ?>"<?php echo $tb_jbt->kd_jbt->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->kd_jbt->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->ket->Visible) { // ket ?>
	<div id="r_ket" class="form-group">
		<label id="elh_tb_jbt_ket" for="x_ket" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->ket->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->ket->CellAttributes() ?>>
<span id="el_tb_jbt_ket">
<input type="text" data-table="tb_jbt" data-field="x_ket" name="x_ket" id="x_ket" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tb_jbt->ket->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->ket->EditValue ?>"<?php echo $tb_jbt->ket->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->ket->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->tjb->Visible) { // tjb ?>
	<div id="r_tjb" class="form-group">
		<label id="elh_tb_jbt_tjb" for="x_tjb" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->tjb->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->tjb->CellAttributes() ?>>
<span id="el_tb_jbt_tjb">
<input type="text" data-table="tb_jbt" data-field="x_tjb" name="x_tjb" id="x_tjb" size="30" maxlength="1" placeholder="<?php echo ew_HtmlEncode($tb_jbt->tjb->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->tjb->EditValue ?>"<?php echo $tb_jbt->tjb->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->tjb->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->koef->Visible) { // koef ?>
	<div id="r_koef" class="form-group">
		<label id="elh_tb_jbt_koef" for="x_koef" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->koef->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->koef->CellAttributes() ?>>
<span id="el_tb_jbt_koef">
<input type="text" data-table="tb_jbt" data-field="x_koef" name="x_koef" id="x_koef" size="30" placeholder="<?php echo ew_HtmlEncode($tb_jbt->koef->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->koef->EditValue ?>"<?php echo $tb_jbt->koef->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->koef->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->created_by->Visible) { // created_by ?>
	<div id="r_created_by" class="form-group">
		<label id="elh_tb_jbt_created_by" for="x_created_by" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->created_by->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->created_by->CellAttributes() ?>>
<span id="el_tb_jbt_created_by">
<input type="text" data-table="tb_jbt" data-field="x_created_by" name="x_created_by" id="x_created_by" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($tb_jbt->created_by->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->created_by->EditValue ?>"<?php echo $tb_jbt->created_by->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->created_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->created_date->Visible) { // created_date ?>
	<div id="r_created_date" class="form-group">
		<label id="elh_tb_jbt_created_date" for="x_created_date" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->created_date->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->created_date->CellAttributes() ?>>
<span id="el_tb_jbt_created_date">
<input type="text" data-table="tb_jbt" data-field="x_created_date" name="x_created_date" id="x_created_date" placeholder="<?php echo ew_HtmlEncode($tb_jbt->created_date->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->created_date->EditValue ?>"<?php echo $tb_jbt->created_date->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->created_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->last_update_by->Visible) { // last_update_by ?>
	<div id="r_last_update_by" class="form-group">
		<label id="elh_tb_jbt_last_update_by" for="x_last_update_by" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->last_update_by->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->last_update_by->CellAttributes() ?>>
<span id="el_tb_jbt_last_update_by">
<input type="text" data-table="tb_jbt" data-field="x_last_update_by" name="x_last_update_by" id="x_last_update_by" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($tb_jbt->last_update_by->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->last_update_by->EditValue ?>"<?php echo $tb_jbt->last_update_by->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->last_update_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->last_update_date->Visible) { // last_update_date ?>
	<div id="r_last_update_date" class="form-group">
		<label id="elh_tb_jbt_last_update_date" for="x_last_update_date" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->last_update_date->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->last_update_date->CellAttributes() ?>>
<span id="el_tb_jbt_last_update_date">
<input type="text" data-table="tb_jbt" data-field="x_last_update_date" name="x_last_update_date" id="x_last_update_date" placeholder="<?php echo ew_HtmlEncode($tb_jbt->last_update_date->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->last_update_date->EditValue ?>"<?php echo $tb_jbt->last_update_date->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->last_update_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->kd_jbt_old->Visible) { // kd_jbt_old ?>
	<div id="r_kd_jbt_old" class="form-group">
		<label id="elh_tb_jbt_kd_jbt_old" for="x_kd_jbt_old" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->kd_jbt_old->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->kd_jbt_old->CellAttributes() ?>>
<span id="el_tb_jbt_kd_jbt_old">
<input type="text" data-table="tb_jbt" data-field="x_kd_jbt_old" name="x_kd_jbt_old" id="x_kd_jbt_old" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($tb_jbt->kd_jbt_old->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->kd_jbt_old->EditValue ?>"<?php echo $tb_jbt->kd_jbt_old->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->kd_jbt_old->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->ket_old->Visible) { // ket_old ?>
	<div id="r_ket_old" class="form-group">
		<label id="elh_tb_jbt_ket_old" for="x_ket_old" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->ket_old->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->ket_old->CellAttributes() ?>>
<span id="el_tb_jbt_ket_old">
<input type="text" data-table="tb_jbt" data-field="x_ket_old" name="x_ket_old" id="x_ket_old" size="30" maxlength="40" placeholder="<?php echo ew_HtmlEncode($tb_jbt->ket_old->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->ket_old->EditValue ?>"<?php echo $tb_jbt->ket_old->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->ket_old->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->jbt_type->Visible) { // jbt_type ?>
	<div id="r_jbt_type" class="form-group">
		<label id="elh_tb_jbt_jbt_type" for="x_jbt_type" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->jbt_type->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->jbt_type->CellAttributes() ?>>
<span id="el_tb_jbt_jbt_type">
<input type="text" data-table="tb_jbt" data-field="x_jbt_type" name="x_jbt_type" id="x_jbt_type" size="30" maxlength="4" placeholder="<?php echo ew_HtmlEncode($tb_jbt->jbt_type->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->jbt_type->EditValue ?>"<?php echo $tb_jbt->jbt_type->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->jbt_type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->org_id->Visible) { // org_id ?>
	<div id="r_org_id" class="form-group">
		<label id="elh_tb_jbt_org_id" for="x_org_id" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->org_id->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->org_id->CellAttributes() ?>>
<span id="el_tb_jbt_org_id">
<input type="text" data-table="tb_jbt" data-field="x_org_id" name="x_org_id" id="x_org_id" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tb_jbt->org_id->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->org_id->EditValue ?>"<?php echo $tb_jbt->org_id->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->org_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->parent_kd_jbt->Visible) { // parent_kd_jbt ?>
	<div id="r_parent_kd_jbt" class="form-group">
		<label id="elh_tb_jbt_parent_kd_jbt" for="x_parent_kd_jbt" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->parent_kd_jbt->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->parent_kd_jbt->CellAttributes() ?>>
<span id="el_tb_jbt_parent_kd_jbt">
<input type="text" data-table="tb_jbt" data-field="x_parent_kd_jbt" name="x_parent_kd_jbt" id="x_parent_kd_jbt" size="30" maxlength="7" placeholder="<?php echo ew_HtmlEncode($tb_jbt->parent_kd_jbt->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->parent_kd_jbt->EditValue ?>"<?php echo $tb_jbt->parent_kd_jbt->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->parent_kd_jbt->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->eselon_num->Visible) { // eselon_num ?>
	<div id="r_eselon_num" class="form-group">
		<label id="elh_tb_jbt_eselon_num" for="x_eselon_num" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->eselon_num->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->eselon_num->CellAttributes() ?>>
<span id="el_tb_jbt_eselon_num">
<input type="text" data-table="tb_jbt" data-field="x_eselon_num" name="x_eselon_num" id="x_eselon_num" size="30" placeholder="<?php echo ew_HtmlEncode($tb_jbt->eselon_num->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->eselon_num->EditValue ?>"<?php echo $tb_jbt->eselon_num->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->eselon_num->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->jns_jbt->Visible) { // jns_jbt ?>
	<div id="r_jns_jbt" class="form-group">
		<label id="elh_tb_jbt_jns_jbt" for="x_jns_jbt" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->jns_jbt->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->jns_jbt->CellAttributes() ?>>
<span id="el_tb_jbt_jns_jbt">
<input type="text" data-table="tb_jbt" data-field="x_jns_jbt" name="x_jns_jbt" id="x_jns_jbt" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($tb_jbt->jns_jbt->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->jns_jbt->EditValue ?>"<?php echo $tb_jbt->jns_jbt->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->jns_jbt->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_jbt->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_tb_jbt_status" for="x_status" class="<?php echo $tb_jbt_add->LeftColumnClass ?>"><?php echo $tb_jbt->status->FldCaption() ?></label>
		<div class="<?php echo $tb_jbt_add->RightColumnClass ?>"><div<?php echo $tb_jbt->status->CellAttributes() ?>>
<span id="el_tb_jbt_status">
<input type="text" data-table="tb_jbt" data-field="x_status" name="x_status" id="x_status" size="30" maxlength="1" placeholder="<?php echo ew_HtmlEncode($tb_jbt->status->getPlaceHolder()) ?>" value="<?php echo $tb_jbt->status->EditValue ?>"<?php echo $tb_jbt->status->EditAttributes() ?>>
</span>
<?php echo $tb_jbt->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$tb_jbt_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $tb_jbt_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_jbt_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ftb_jbtadd.Init();
</script>
<?php
$tb_jbt_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_jbt_add->Page_Terminate();
?>
