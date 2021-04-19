<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "hst_kerjainfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$hst_kerja_edit = NULL; // Initialize page object first

class chst_kerja_edit extends chst_kerja {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'hst_kerja';

	// Page object name
	var $PageObjName = 'hst_kerja_edit';

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

		// Table object (hst_kerja)
		if (!isset($GLOBALS["hst_kerja"]) || get_class($GLOBALS["hst_kerja"]) == "chst_kerja") {
			$GLOBALS["hst_kerja"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hst_kerja"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hst_kerja', TRUE);

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
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->employee_id->SetVisibility();
		$this->kd_jbt->SetVisibility();
		$this->kd_pat->SetVisibility();
		$this->kd_jenjang->SetVisibility();
		$this->tgl_mulai->SetVisibility();
		$this->tgl_akhir->SetVisibility();
		$this->no_sk->SetVisibility();
		$this->ket->SetVisibility();
		$this->company->SetVisibility();
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();
		$this->st->SetVisibility();
		$this->kd_jbt_eselon->SetVisibility();

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
		global $EW_EXPORT, $hst_kerja;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($hst_kerja);
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
					if ($pageName == "hst_kerjaview.php")
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
			if ($objForm->HasValue("x_id")) {
				$this->id->setFormValue($objForm->GetValue("x_id"));
			}
			if ($objForm->HasValue("x_employee_id")) {
				$this->employee_id->setFormValue($objForm->GetValue("x_employee_id"));
			}
			if ($objForm->HasValue("x_kd_jbt")) {
				$this->kd_jbt->setFormValue($objForm->GetValue("x_kd_jbt"));
			}
			if ($objForm->HasValue("x_kd_pat")) {
				$this->kd_pat->setFormValue($objForm->GetValue("x_kd_pat"));
			}
			if ($objForm->HasValue("x_kd_jenjang")) {
				$this->kd_jenjang->setFormValue($objForm->GetValue("x_kd_jenjang"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["id"])) {
				$this->id->setQueryStringValue($_GET["id"]);
				$loadByQuery = TRUE;
			} else {
				$this->id->CurrentValue = NULL;
			}
			if (isset($_GET["employee_id"])) {
				$this->employee_id->setQueryStringValue($_GET["employee_id"]);
				$loadByQuery = TRUE;
			} else {
				$this->employee_id->CurrentValue = NULL;
			}
			if (isset($_GET["kd_jbt"])) {
				$this->kd_jbt->setQueryStringValue($_GET["kd_jbt"]);
				$loadByQuery = TRUE;
			} else {
				$this->kd_jbt->CurrentValue = NULL;
			}
			if (isset($_GET["kd_pat"])) {
				$this->kd_pat->setQueryStringValue($_GET["kd_pat"]);
				$loadByQuery = TRUE;
			} else {
				$this->kd_pat->CurrentValue = NULL;
			}
			if (isset($_GET["kd_jenjang"])) {
				$this->kd_jenjang->setQueryStringValue($_GET["kd_jenjang"]);
				$loadByQuery = TRUE;
			} else {
				$this->kd_jenjang->CurrentValue = NULL;
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
					$this->Page_Terminate("hst_kerjalist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "hst_kerjalist.php")
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
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->employee_id->FldIsDetailKey) {
			$this->employee_id->setFormValue($objForm->GetValue("x_employee_id"));
		}
		if (!$this->kd_jbt->FldIsDetailKey) {
			$this->kd_jbt->setFormValue($objForm->GetValue("x_kd_jbt"));
		}
		if (!$this->kd_pat->FldIsDetailKey) {
			$this->kd_pat->setFormValue($objForm->GetValue("x_kd_pat"));
		}
		if (!$this->kd_jenjang->FldIsDetailKey) {
			$this->kd_jenjang->setFormValue($objForm->GetValue("x_kd_jenjang"));
		}
		if (!$this->tgl_mulai->FldIsDetailKey) {
			$this->tgl_mulai->setFormValue($objForm->GetValue("x_tgl_mulai"));
			$this->tgl_mulai->CurrentValue = ew_UnFormatDateTime($this->tgl_mulai->CurrentValue, 0);
		}
		if (!$this->tgl_akhir->FldIsDetailKey) {
			$this->tgl_akhir->setFormValue($objForm->GetValue("x_tgl_akhir"));
			$this->tgl_akhir->CurrentValue = ew_UnFormatDateTime($this->tgl_akhir->CurrentValue, 0);
		}
		if (!$this->no_sk->FldIsDetailKey) {
			$this->no_sk->setFormValue($objForm->GetValue("x_no_sk"));
		}
		if (!$this->ket->FldIsDetailKey) {
			$this->ket->setFormValue($objForm->GetValue("x_ket"));
		}
		if (!$this->company->FldIsDetailKey) {
			$this->company->setFormValue($objForm->GetValue("x_company"));
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
		if (!$this->st->FldIsDetailKey) {
			$this->st->setFormValue($objForm->GetValue("x_st"));
		}
		if (!$this->kd_jbt_eselon->FldIsDetailKey) {
			$this->kd_jbt_eselon->setFormValue($objForm->GetValue("x_kd_jbt_eselon"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->employee_id->CurrentValue = $this->employee_id->FormValue;
		$this->kd_jbt->CurrentValue = $this->kd_jbt->FormValue;
		$this->kd_pat->CurrentValue = $this->kd_pat->FormValue;
		$this->kd_jenjang->CurrentValue = $this->kd_jenjang->FormValue;
		$this->tgl_mulai->CurrentValue = $this->tgl_mulai->FormValue;
		$this->tgl_mulai->CurrentValue = ew_UnFormatDateTime($this->tgl_mulai->CurrentValue, 0);
		$this->tgl_akhir->CurrentValue = $this->tgl_akhir->FormValue;
		$this->tgl_akhir->CurrentValue = ew_UnFormatDateTime($this->tgl_akhir->CurrentValue, 0);
		$this->no_sk->CurrentValue = $this->no_sk->FormValue;
		$this->ket->CurrentValue = $this->ket->FormValue;
		$this->company->CurrentValue = $this->company->FormValue;
		$this->created_by->CurrentValue = $this->created_by->FormValue;
		$this->created_date->CurrentValue = $this->created_date->FormValue;
		$this->created_date->CurrentValue = ew_UnFormatDateTime($this->created_date->CurrentValue, 0);
		$this->last_update_by->CurrentValue = $this->last_update_by->FormValue;
		$this->last_update_date->CurrentValue = $this->last_update_date->FormValue;
		$this->last_update_date->CurrentValue = ew_UnFormatDateTime($this->last_update_date->CurrentValue, 0);
		$this->st->CurrentValue = $this->st->FormValue;
		$this->kd_jbt_eselon->CurrentValue = $this->kd_jbt_eselon->FormValue;
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
		$this->employee_id->setDbValue($row['employee_id']);
		$this->kd_jbt->setDbValue($row['kd_jbt']);
		$this->kd_pat->setDbValue($row['kd_pat']);
		$this->kd_jenjang->setDbValue($row['kd_jenjang']);
		$this->tgl_mulai->setDbValue($row['tgl_mulai']);
		$this->tgl_akhir->setDbValue($row['tgl_akhir']);
		$this->no_sk->setDbValue($row['no_sk']);
		$this->ket->setDbValue($row['ket']);
		$this->company->setDbValue($row['company']);
		$this->created_by->setDbValue($row['created_by']);
		$this->created_date->setDbValue($row['created_date']);
		$this->last_update_by->setDbValue($row['last_update_by']);
		$this->last_update_date->setDbValue($row['last_update_date']);
		$this->st->setDbValue($row['st']);
		$this->kd_jbt_eselon->setDbValue($row['kd_jbt_eselon']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['employee_id'] = NULL;
		$row['kd_jbt'] = NULL;
		$row['kd_pat'] = NULL;
		$row['kd_jenjang'] = NULL;
		$row['tgl_mulai'] = NULL;
		$row['tgl_akhir'] = NULL;
		$row['no_sk'] = NULL;
		$row['ket'] = NULL;
		$row['company'] = NULL;
		$row['created_by'] = NULL;
		$row['created_date'] = NULL;
		$row['last_update_by'] = NULL;
		$row['last_update_date'] = NULL;
		$row['st'] = NULL;
		$row['kd_jbt_eselon'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->employee_id->DbValue = $row['employee_id'];
		$this->kd_jbt->DbValue = $row['kd_jbt'];
		$this->kd_pat->DbValue = $row['kd_pat'];
		$this->kd_jenjang->DbValue = $row['kd_jenjang'];
		$this->tgl_mulai->DbValue = $row['tgl_mulai'];
		$this->tgl_akhir->DbValue = $row['tgl_akhir'];
		$this->no_sk->DbValue = $row['no_sk'];
		$this->ket->DbValue = $row['ket'];
		$this->company->DbValue = $row['company'];
		$this->created_by->DbValue = $row['created_by'];
		$this->created_date->DbValue = $row['created_date'];
		$this->last_update_by->DbValue = $row['last_update_by'];
		$this->last_update_date->DbValue = $row['last_update_date'];
		$this->st->DbValue = $row['st'];
		$this->kd_jbt_eselon->DbValue = $row['kd_jbt_eselon'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("employee_id")) <> "")
			$this->employee_id->CurrentValue = $this->getKey("employee_id"); // employee_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("kd_jbt")) <> "")
			$this->kd_jbt->CurrentValue = $this->getKey("kd_jbt"); // kd_jbt
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("kd_pat")) <> "")
			$this->kd_pat->CurrentValue = $this->getKey("kd_pat"); // kd_pat
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("kd_jenjang")) <> "")
			$this->kd_jenjang->CurrentValue = $this->getKey("kd_jenjang"); // kd_jenjang
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
		// employee_id
		// kd_jbt
		// kd_pat
		// kd_jenjang
		// tgl_mulai
		// tgl_akhir
		// no_sk
		// ket
		// company
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// st
		// kd_jbt_eselon

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// employee_id
		$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
		$this->employee_id->ViewCustomAttributes = "";

		// kd_jbt
		$this->kd_jbt->ViewValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// kd_pat
		$this->kd_pat->ViewValue = $this->kd_pat->CurrentValue;
		$this->kd_pat->ViewCustomAttributes = "";

		// kd_jenjang
		$this->kd_jenjang->ViewValue = $this->kd_jenjang->CurrentValue;
		$this->kd_jenjang->ViewCustomAttributes = "";

		// tgl_mulai
		$this->tgl_mulai->ViewValue = $this->tgl_mulai->CurrentValue;
		$this->tgl_mulai->ViewValue = ew_FormatDateTime($this->tgl_mulai->ViewValue, 0);
		$this->tgl_mulai->ViewCustomAttributes = "";

		// tgl_akhir
		$this->tgl_akhir->ViewValue = $this->tgl_akhir->CurrentValue;
		$this->tgl_akhir->ViewValue = ew_FormatDateTime($this->tgl_akhir->ViewValue, 0);
		$this->tgl_akhir->ViewCustomAttributes = "";

		// no_sk
		$this->no_sk->ViewValue = $this->no_sk->CurrentValue;
		$this->no_sk->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

		// company
		$this->company->ViewValue = $this->company->CurrentValue;
		$this->company->ViewCustomAttributes = "";

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

		// st
		$this->st->ViewValue = $this->st->CurrentValue;
		$this->st->ViewCustomAttributes = "";

		// kd_jbt_eselon
		$this->kd_jbt_eselon->ViewValue = $this->kd_jbt_eselon->CurrentValue;
		$this->kd_jbt_eselon->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// employee_id
			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";
			$this->employee_id->TooltipValue = "";

			// kd_jbt
			$this->kd_jbt->LinkCustomAttributes = "";
			$this->kd_jbt->HrefValue = "";
			$this->kd_jbt->TooltipValue = "";

			// kd_pat
			$this->kd_pat->LinkCustomAttributes = "";
			$this->kd_pat->HrefValue = "";
			$this->kd_pat->TooltipValue = "";

			// kd_jenjang
			$this->kd_jenjang->LinkCustomAttributes = "";
			$this->kd_jenjang->HrefValue = "";
			$this->kd_jenjang->TooltipValue = "";

			// tgl_mulai
			$this->tgl_mulai->LinkCustomAttributes = "";
			$this->tgl_mulai->HrefValue = "";
			$this->tgl_mulai->TooltipValue = "";

			// tgl_akhir
			$this->tgl_akhir->LinkCustomAttributes = "";
			$this->tgl_akhir->HrefValue = "";
			$this->tgl_akhir->TooltipValue = "";

			// no_sk
			$this->no_sk->LinkCustomAttributes = "";
			$this->no_sk->HrefValue = "";
			$this->no_sk->TooltipValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";
			$this->ket->TooltipValue = "";

			// company
			$this->company->LinkCustomAttributes = "";
			$this->company->HrefValue = "";
			$this->company->TooltipValue = "";

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

			// st
			$this->st->LinkCustomAttributes = "";
			$this->st->HrefValue = "";
			$this->st->TooltipValue = "";

			// kd_jbt_eselon
			$this->kd_jbt_eselon->LinkCustomAttributes = "";
			$this->kd_jbt_eselon->HrefValue = "";
			$this->kd_jbt_eselon->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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

			// kd_jbt
			$this->kd_jbt->EditAttrs["class"] = "form-control";
			$this->kd_jbt->EditCustomAttributes = "";
			$this->kd_jbt->EditValue = $this->kd_jbt->CurrentValue;
			$this->kd_jbt->ViewCustomAttributes = "";

			// kd_pat
			$this->kd_pat->EditAttrs["class"] = "form-control";
			$this->kd_pat->EditCustomAttributes = "";
			$this->kd_pat->EditValue = $this->kd_pat->CurrentValue;
			$this->kd_pat->ViewCustomAttributes = "";

			// kd_jenjang
			$this->kd_jenjang->EditAttrs["class"] = "form-control";
			$this->kd_jenjang->EditCustomAttributes = "";
			$this->kd_jenjang->EditValue = $this->kd_jenjang->CurrentValue;
			$this->kd_jenjang->ViewCustomAttributes = "";

			// tgl_mulai
			$this->tgl_mulai->EditAttrs["class"] = "form-control";
			$this->tgl_mulai->EditCustomAttributes = "";
			$this->tgl_mulai->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_mulai->CurrentValue, 8));
			$this->tgl_mulai->PlaceHolder = ew_RemoveHtml($this->tgl_mulai->FldCaption());

			// tgl_akhir
			$this->tgl_akhir->EditAttrs["class"] = "form-control";
			$this->tgl_akhir->EditCustomAttributes = "";
			$this->tgl_akhir->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_akhir->CurrentValue, 8));
			$this->tgl_akhir->PlaceHolder = ew_RemoveHtml($this->tgl_akhir->FldCaption());

			// no_sk
			$this->no_sk->EditAttrs["class"] = "form-control";
			$this->no_sk->EditCustomAttributes = "";
			$this->no_sk->EditValue = ew_HtmlEncode($this->no_sk->CurrentValue);
			$this->no_sk->PlaceHolder = ew_RemoveHtml($this->no_sk->FldCaption());

			// ket
			$this->ket->EditAttrs["class"] = "form-control";
			$this->ket->EditCustomAttributes = "";
			$this->ket->EditValue = ew_HtmlEncode($this->ket->CurrentValue);
			$this->ket->PlaceHolder = ew_RemoveHtml($this->ket->FldCaption());

			// company
			$this->company->EditAttrs["class"] = "form-control";
			$this->company->EditCustomAttributes = "";
			$this->company->EditValue = ew_HtmlEncode($this->company->CurrentValue);
			$this->company->PlaceHolder = ew_RemoveHtml($this->company->FldCaption());

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

			// st
			$this->st->EditAttrs["class"] = "form-control";
			$this->st->EditCustomAttributes = "";
			$this->st->EditValue = ew_HtmlEncode($this->st->CurrentValue);
			$this->st->PlaceHolder = ew_RemoveHtml($this->st->FldCaption());

			// kd_jbt_eselon
			$this->kd_jbt_eselon->EditAttrs["class"] = "form-control";
			$this->kd_jbt_eselon->EditCustomAttributes = "";
			$this->kd_jbt_eselon->EditValue = ew_HtmlEncode($this->kd_jbt_eselon->CurrentValue);
			$this->kd_jbt_eselon->PlaceHolder = ew_RemoveHtml($this->kd_jbt_eselon->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// employee_id
			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";

			// kd_jbt
			$this->kd_jbt->LinkCustomAttributes = "";
			$this->kd_jbt->HrefValue = "";

			// kd_pat
			$this->kd_pat->LinkCustomAttributes = "";
			$this->kd_pat->HrefValue = "";

			// kd_jenjang
			$this->kd_jenjang->LinkCustomAttributes = "";
			$this->kd_jenjang->HrefValue = "";

			// tgl_mulai
			$this->tgl_mulai->LinkCustomAttributes = "";
			$this->tgl_mulai->HrefValue = "";

			// tgl_akhir
			$this->tgl_akhir->LinkCustomAttributes = "";
			$this->tgl_akhir->HrefValue = "";

			// no_sk
			$this->no_sk->LinkCustomAttributes = "";
			$this->no_sk->HrefValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";

			// company
			$this->company->LinkCustomAttributes = "";
			$this->company->HrefValue = "";

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

			// st
			$this->st->LinkCustomAttributes = "";
			$this->st->HrefValue = "";

			// kd_jbt_eselon
			$this->kd_jbt_eselon->LinkCustomAttributes = "";
			$this->kd_jbt_eselon->HrefValue = "";
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
		if (!$this->employee_id->FldIsDetailKey && !is_null($this->employee_id->FormValue) && $this->employee_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->employee_id->FldCaption(), $this->employee_id->ReqErrMsg));
		}
		if (!$this->kd_jbt->FldIsDetailKey && !is_null($this->kd_jbt->FormValue) && $this->kd_jbt->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kd_jbt->FldCaption(), $this->kd_jbt->ReqErrMsg));
		}
		if (!$this->kd_pat->FldIsDetailKey && !is_null($this->kd_pat->FormValue) && $this->kd_pat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kd_pat->FldCaption(), $this->kd_pat->ReqErrMsg));
		}
		if (!$this->kd_jenjang->FldIsDetailKey && !is_null($this->kd_jenjang->FormValue) && $this->kd_jenjang->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kd_jenjang->FldCaption(), $this->kd_jenjang->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->tgl_mulai->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_mulai->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_akhir->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_akhir->FldErrMsg());
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

			// employee_id
			// kd_jbt
			// kd_pat
			// kd_jenjang
			// tgl_mulai

			$this->tgl_mulai->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_mulai->CurrentValue, 0), NULL, $this->tgl_mulai->ReadOnly);

			// tgl_akhir
			$this->tgl_akhir->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_akhir->CurrentValue, 0), NULL, $this->tgl_akhir->ReadOnly);

			// no_sk
			$this->no_sk->SetDbValueDef($rsnew, $this->no_sk->CurrentValue, NULL, $this->no_sk->ReadOnly);

			// ket
			$this->ket->SetDbValueDef($rsnew, $this->ket->CurrentValue, NULL, $this->ket->ReadOnly);

			// company
			$this->company->SetDbValueDef($rsnew, $this->company->CurrentValue, NULL, $this->company->ReadOnly);

			// created_by
			$this->created_by->SetDbValueDef($rsnew, $this->created_by->CurrentValue, NULL, $this->created_by->ReadOnly);

			// created_date
			$this->created_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->created_date->CurrentValue, 0), NULL, $this->created_date->ReadOnly);

			// last_update_by
			$this->last_update_by->SetDbValueDef($rsnew, $this->last_update_by->CurrentValue, NULL, $this->last_update_by->ReadOnly);

			// last_update_date
			$this->last_update_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->last_update_date->CurrentValue, 0), NULL, $this->last_update_date->ReadOnly);

			// st
			$this->st->SetDbValueDef($rsnew, $this->st->CurrentValue, NULL, $this->st->ReadOnly);

			// kd_jbt_eselon
			$this->kd_jbt_eselon->SetDbValueDef($rsnew, $this->kd_jbt_eselon->CurrentValue, NULL, $this->kd_jbt_eselon->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hst_kerjalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hst_kerja_edit)) $hst_kerja_edit = new chst_kerja_edit();

// Page init
$hst_kerja_edit->Page_Init();

// Page main
$hst_kerja_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hst_kerja_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fhst_kerjaedit = new ew_Form("fhst_kerjaedit", "edit");

// Validate form
fhst_kerjaedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_employee_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hst_kerja->employee_id->FldCaption(), $hst_kerja->employee_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kd_jbt");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hst_kerja->kd_jbt->FldCaption(), $hst_kerja->kd_jbt->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kd_pat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hst_kerja->kd_pat->FldCaption(), $hst_kerja->kd_pat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kd_jenjang");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hst_kerja->kd_jenjang->FldCaption(), $hst_kerja->kd_jenjang->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tgl_mulai");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hst_kerja->tgl_mulai->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_akhir");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hst_kerja->tgl_akhir->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_created_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hst_kerja->created_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_update_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hst_kerja->last_update_date->FldErrMsg()) ?>");

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
fhst_kerjaedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fhst_kerjaedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $hst_kerja_edit->ShowPageHeader(); ?>
<?php
$hst_kerja_edit->ShowMessage();
?>
<form name="fhst_kerjaedit" id="fhst_kerjaedit" class="<?php echo $hst_kerja_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hst_kerja_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hst_kerja_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hst_kerja">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($hst_kerja_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($hst_kerja->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_hst_kerja_id" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->id->FldCaption() ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->id->CellAttributes() ?>>
<span id="el_hst_kerja_id">
<span<?php echo $hst_kerja->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $hst_kerja->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="hst_kerja" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($hst_kerja->id->CurrentValue) ?>">
<?php echo $hst_kerja->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->employee_id->Visible) { // employee_id ?>
	<div id="r_employee_id" class="form-group">
		<label id="elh_hst_kerja_employee_id" for="x_employee_id" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->employee_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->employee_id->CellAttributes() ?>>
<span id="el_hst_kerja_employee_id">
<span<?php echo $hst_kerja->employee_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $hst_kerja->employee_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="hst_kerja" data-field="x_employee_id" name="x_employee_id" id="x_employee_id" value="<?php echo ew_HtmlEncode($hst_kerja->employee_id->CurrentValue) ?>">
<?php echo $hst_kerja->employee_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->kd_jbt->Visible) { // kd_jbt ?>
	<div id="r_kd_jbt" class="form-group">
		<label id="elh_hst_kerja_kd_jbt" for="x_kd_jbt" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->kd_jbt->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->kd_jbt->CellAttributes() ?>>
<span id="el_hst_kerja_kd_jbt">
<span<?php echo $hst_kerja->kd_jbt->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $hst_kerja->kd_jbt->EditValue ?></p></span>
</span>
<input type="hidden" data-table="hst_kerja" data-field="x_kd_jbt" name="x_kd_jbt" id="x_kd_jbt" value="<?php echo ew_HtmlEncode($hst_kerja->kd_jbt->CurrentValue) ?>">
<?php echo $hst_kerja->kd_jbt->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->kd_pat->Visible) { // kd_pat ?>
	<div id="r_kd_pat" class="form-group">
		<label id="elh_hst_kerja_kd_pat" for="x_kd_pat" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->kd_pat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->kd_pat->CellAttributes() ?>>
<span id="el_hst_kerja_kd_pat">
<span<?php echo $hst_kerja->kd_pat->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $hst_kerja->kd_pat->EditValue ?></p></span>
</span>
<input type="hidden" data-table="hst_kerja" data-field="x_kd_pat" name="x_kd_pat" id="x_kd_pat" value="<?php echo ew_HtmlEncode($hst_kerja->kd_pat->CurrentValue) ?>">
<?php echo $hst_kerja->kd_pat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->kd_jenjang->Visible) { // kd_jenjang ?>
	<div id="r_kd_jenjang" class="form-group">
		<label id="elh_hst_kerja_kd_jenjang" for="x_kd_jenjang" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->kd_jenjang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->kd_jenjang->CellAttributes() ?>>
<span id="el_hst_kerja_kd_jenjang">
<span<?php echo $hst_kerja->kd_jenjang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $hst_kerja->kd_jenjang->EditValue ?></p></span>
</span>
<input type="hidden" data-table="hst_kerja" data-field="x_kd_jenjang" name="x_kd_jenjang" id="x_kd_jenjang" value="<?php echo ew_HtmlEncode($hst_kerja->kd_jenjang->CurrentValue) ?>">
<?php echo $hst_kerja->kd_jenjang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->tgl_mulai->Visible) { // tgl_mulai ?>
	<div id="r_tgl_mulai" class="form-group">
		<label id="elh_hst_kerja_tgl_mulai" for="x_tgl_mulai" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->tgl_mulai->FldCaption() ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->tgl_mulai->CellAttributes() ?>>
<span id="el_hst_kerja_tgl_mulai">
<input type="text" data-table="hst_kerja" data-field="x_tgl_mulai" name="x_tgl_mulai" id="x_tgl_mulai" placeholder="<?php echo ew_HtmlEncode($hst_kerja->tgl_mulai->getPlaceHolder()) ?>" value="<?php echo $hst_kerja->tgl_mulai->EditValue ?>"<?php echo $hst_kerja->tgl_mulai->EditAttributes() ?>>
</span>
<?php echo $hst_kerja->tgl_mulai->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->tgl_akhir->Visible) { // tgl_akhir ?>
	<div id="r_tgl_akhir" class="form-group">
		<label id="elh_hst_kerja_tgl_akhir" for="x_tgl_akhir" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->tgl_akhir->FldCaption() ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->tgl_akhir->CellAttributes() ?>>
<span id="el_hst_kerja_tgl_akhir">
<input type="text" data-table="hst_kerja" data-field="x_tgl_akhir" name="x_tgl_akhir" id="x_tgl_akhir" placeholder="<?php echo ew_HtmlEncode($hst_kerja->tgl_akhir->getPlaceHolder()) ?>" value="<?php echo $hst_kerja->tgl_akhir->EditValue ?>"<?php echo $hst_kerja->tgl_akhir->EditAttributes() ?>>
</span>
<?php echo $hst_kerja->tgl_akhir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->no_sk->Visible) { // no_sk ?>
	<div id="r_no_sk" class="form-group">
		<label id="elh_hst_kerja_no_sk" for="x_no_sk" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->no_sk->FldCaption() ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->no_sk->CellAttributes() ?>>
<span id="el_hst_kerja_no_sk">
<input type="text" data-table="hst_kerja" data-field="x_no_sk" name="x_no_sk" id="x_no_sk" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($hst_kerja->no_sk->getPlaceHolder()) ?>" value="<?php echo $hst_kerja->no_sk->EditValue ?>"<?php echo $hst_kerja->no_sk->EditAttributes() ?>>
</span>
<?php echo $hst_kerja->no_sk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->ket->Visible) { // ket ?>
	<div id="r_ket" class="form-group">
		<label id="elh_hst_kerja_ket" for="x_ket" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->ket->FldCaption() ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->ket->CellAttributes() ?>>
<span id="el_hst_kerja_ket">
<input type="text" data-table="hst_kerja" data-field="x_ket" name="x_ket" id="x_ket" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($hst_kerja->ket->getPlaceHolder()) ?>" value="<?php echo $hst_kerja->ket->EditValue ?>"<?php echo $hst_kerja->ket->EditAttributes() ?>>
</span>
<?php echo $hst_kerja->ket->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->company->Visible) { // company ?>
	<div id="r_company" class="form-group">
		<label id="elh_hst_kerja_company" for="x_company" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->company->FldCaption() ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->company->CellAttributes() ?>>
<span id="el_hst_kerja_company">
<input type="text" data-table="hst_kerja" data-field="x_company" name="x_company" id="x_company" size="30" maxlength="40" placeholder="<?php echo ew_HtmlEncode($hst_kerja->company->getPlaceHolder()) ?>" value="<?php echo $hst_kerja->company->EditValue ?>"<?php echo $hst_kerja->company->EditAttributes() ?>>
</span>
<?php echo $hst_kerja->company->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->created_by->Visible) { // created_by ?>
	<div id="r_created_by" class="form-group">
		<label id="elh_hst_kerja_created_by" for="x_created_by" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->created_by->FldCaption() ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->created_by->CellAttributes() ?>>
<span id="el_hst_kerja_created_by">
<input type="text" data-table="hst_kerja" data-field="x_created_by" name="x_created_by" id="x_created_by" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($hst_kerja->created_by->getPlaceHolder()) ?>" value="<?php echo $hst_kerja->created_by->EditValue ?>"<?php echo $hst_kerja->created_by->EditAttributes() ?>>
</span>
<?php echo $hst_kerja->created_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->created_date->Visible) { // created_date ?>
	<div id="r_created_date" class="form-group">
		<label id="elh_hst_kerja_created_date" for="x_created_date" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->created_date->FldCaption() ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->created_date->CellAttributes() ?>>
<span id="el_hst_kerja_created_date">
<input type="text" data-table="hst_kerja" data-field="x_created_date" name="x_created_date" id="x_created_date" placeholder="<?php echo ew_HtmlEncode($hst_kerja->created_date->getPlaceHolder()) ?>" value="<?php echo $hst_kerja->created_date->EditValue ?>"<?php echo $hst_kerja->created_date->EditAttributes() ?>>
</span>
<?php echo $hst_kerja->created_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->last_update_by->Visible) { // last_update_by ?>
	<div id="r_last_update_by" class="form-group">
		<label id="elh_hst_kerja_last_update_by" for="x_last_update_by" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->last_update_by->FldCaption() ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->last_update_by->CellAttributes() ?>>
<span id="el_hst_kerja_last_update_by">
<input type="text" data-table="hst_kerja" data-field="x_last_update_by" name="x_last_update_by" id="x_last_update_by" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($hst_kerja->last_update_by->getPlaceHolder()) ?>" value="<?php echo $hst_kerja->last_update_by->EditValue ?>"<?php echo $hst_kerja->last_update_by->EditAttributes() ?>>
</span>
<?php echo $hst_kerja->last_update_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->last_update_date->Visible) { // last_update_date ?>
	<div id="r_last_update_date" class="form-group">
		<label id="elh_hst_kerja_last_update_date" for="x_last_update_date" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->last_update_date->FldCaption() ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->last_update_date->CellAttributes() ?>>
<span id="el_hst_kerja_last_update_date">
<input type="text" data-table="hst_kerja" data-field="x_last_update_date" name="x_last_update_date" id="x_last_update_date" placeholder="<?php echo ew_HtmlEncode($hst_kerja->last_update_date->getPlaceHolder()) ?>" value="<?php echo $hst_kerja->last_update_date->EditValue ?>"<?php echo $hst_kerja->last_update_date->EditAttributes() ?>>
</span>
<?php echo $hst_kerja->last_update_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->st->Visible) { // st ?>
	<div id="r_st" class="form-group">
		<label id="elh_hst_kerja_st" for="x_st" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->st->FldCaption() ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->st->CellAttributes() ?>>
<span id="el_hst_kerja_st">
<input type="text" data-table="hst_kerja" data-field="x_st" name="x_st" id="x_st" size="30" maxlength="1" placeholder="<?php echo ew_HtmlEncode($hst_kerja->st->getPlaceHolder()) ?>" value="<?php echo $hst_kerja->st->EditValue ?>"<?php echo $hst_kerja->st->EditAttributes() ?>>
</span>
<?php echo $hst_kerja->st->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hst_kerja->kd_jbt_eselon->Visible) { // kd_jbt_eselon ?>
	<div id="r_kd_jbt_eselon" class="form-group">
		<label id="elh_hst_kerja_kd_jbt_eselon" for="x_kd_jbt_eselon" class="<?php echo $hst_kerja_edit->LeftColumnClass ?>"><?php echo $hst_kerja->kd_jbt_eselon->FldCaption() ?></label>
		<div class="<?php echo $hst_kerja_edit->RightColumnClass ?>"><div<?php echo $hst_kerja->kd_jbt_eselon->CellAttributes() ?>>
<span id="el_hst_kerja_kd_jbt_eselon">
<input type="text" data-table="hst_kerja" data-field="x_kd_jbt_eselon" name="x_kd_jbt_eselon" id="x_kd_jbt_eselon" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($hst_kerja->kd_jbt_eselon->getPlaceHolder()) ?>" value="<?php echo $hst_kerja->kd_jbt_eselon->EditValue ?>"<?php echo $hst_kerja->kd_jbt_eselon->EditAttributes() ?>>
</span>
<?php echo $hst_kerja->kd_jbt_eselon->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$hst_kerja_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $hst_kerja_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hst_kerja_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fhst_kerjaedit.Init();
</script>
<?php
$hst_kerja_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hst_kerja_edit->Page_Terminate();
?>
