<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "st_latihinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$st_latih_edit = NULL; // Initialize page object first

class cst_latih_edit extends cst_latih {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'st_latih';

	// Page object name
	var $PageObjName = 'st_latih_edit';

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

		// Table object (st_latih)
		if (!isset($GLOBALS["st_latih"]) || get_class($GLOBALS["st_latih"]) == "cst_latih") {
			$GLOBALS["st_latih"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["st_latih"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'st_latih', TRUE);

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
		$this->no_st->SetVisibility();
		$this->tgl_st->SetVisibility();
		$this->employee_id->SetVisibility();
		$this->kd_latih->SetVisibility();
		$this->tgl_mulai->SetVisibility();
		$this->tgl_akhir->SetVisibility();
		$this->kd_lmbg->SetVisibility();
		$this->kd_jbt->SetVisibility();
		$this->jam->SetVisibility();
		$this->tempat->SetVisibility();
		$this->app->SetVisibility();
		$this->app_empid->SetVisibility();
		$this->app_jbt->SetVisibility();
		$this->app_date->SetVisibility();
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();
		$this->sertifikat->SetVisibility();

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
		global $EW_EXPORT, $st_latih;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($st_latih);
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
					if ($pageName == "st_latihview.php")
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
			if ($objForm->HasValue("x_no_st")) {
				$this->no_st->setFormValue($objForm->GetValue("x_no_st"));
			}
			if ($objForm->HasValue("x_employee_id")) {
				$this->employee_id->setFormValue($objForm->GetValue("x_employee_id"));
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
			if (isset($_GET["no_st"])) {
				$this->no_st->setQueryStringValue($_GET["no_st"]);
				$loadByQuery = TRUE;
			} else {
				$this->no_st->CurrentValue = NULL;
			}
			if (isset($_GET["employee_id"])) {
				$this->employee_id->setQueryStringValue($_GET["employee_id"]);
				$loadByQuery = TRUE;
			} else {
				$this->employee_id->CurrentValue = NULL;
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
					$this->Page_Terminate("st_latihlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "st_latihlist.php")
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
		if (!$this->no_st->FldIsDetailKey) {
			$this->no_st->setFormValue($objForm->GetValue("x_no_st"));
		}
		if (!$this->tgl_st->FldIsDetailKey) {
			$this->tgl_st->setFormValue($objForm->GetValue("x_tgl_st"));
			$this->tgl_st->CurrentValue = ew_UnFormatDateTime($this->tgl_st->CurrentValue, 0);
		}
		if (!$this->employee_id->FldIsDetailKey) {
			$this->employee_id->setFormValue($objForm->GetValue("x_employee_id"));
		}
		if (!$this->kd_latih->FldIsDetailKey) {
			$this->kd_latih->setFormValue($objForm->GetValue("x_kd_latih"));
		}
		if (!$this->tgl_mulai->FldIsDetailKey) {
			$this->tgl_mulai->setFormValue($objForm->GetValue("x_tgl_mulai"));
			$this->tgl_mulai->CurrentValue = ew_UnFormatDateTime($this->tgl_mulai->CurrentValue, 0);
		}
		if (!$this->tgl_akhir->FldIsDetailKey) {
			$this->tgl_akhir->setFormValue($objForm->GetValue("x_tgl_akhir"));
			$this->tgl_akhir->CurrentValue = ew_UnFormatDateTime($this->tgl_akhir->CurrentValue, 0);
		}
		if (!$this->kd_lmbg->FldIsDetailKey) {
			$this->kd_lmbg->setFormValue($objForm->GetValue("x_kd_lmbg"));
		}
		if (!$this->kd_jbt->FldIsDetailKey) {
			$this->kd_jbt->setFormValue($objForm->GetValue("x_kd_jbt"));
		}
		if (!$this->jam->FldIsDetailKey) {
			$this->jam->setFormValue($objForm->GetValue("x_jam"));
		}
		if (!$this->tempat->FldIsDetailKey) {
			$this->tempat->setFormValue($objForm->GetValue("x_tempat"));
		}
		if (!$this->app->FldIsDetailKey) {
			$this->app->setFormValue($objForm->GetValue("x_app"));
		}
		if (!$this->app_empid->FldIsDetailKey) {
			$this->app_empid->setFormValue($objForm->GetValue("x_app_empid"));
		}
		if (!$this->app_jbt->FldIsDetailKey) {
			$this->app_jbt->setFormValue($objForm->GetValue("x_app_jbt"));
		}
		if (!$this->app_date->FldIsDetailKey) {
			$this->app_date->setFormValue($objForm->GetValue("x_app_date"));
			$this->app_date->CurrentValue = ew_UnFormatDateTime($this->app_date->CurrentValue, 0);
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
		if (!$this->sertifikat->FldIsDetailKey) {
			$this->sertifikat->setFormValue($objForm->GetValue("x_sertifikat"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->no_st->CurrentValue = $this->no_st->FormValue;
		$this->tgl_st->CurrentValue = $this->tgl_st->FormValue;
		$this->tgl_st->CurrentValue = ew_UnFormatDateTime($this->tgl_st->CurrentValue, 0);
		$this->employee_id->CurrentValue = $this->employee_id->FormValue;
		$this->kd_latih->CurrentValue = $this->kd_latih->FormValue;
		$this->tgl_mulai->CurrentValue = $this->tgl_mulai->FormValue;
		$this->tgl_mulai->CurrentValue = ew_UnFormatDateTime($this->tgl_mulai->CurrentValue, 0);
		$this->tgl_akhir->CurrentValue = $this->tgl_akhir->FormValue;
		$this->tgl_akhir->CurrentValue = ew_UnFormatDateTime($this->tgl_akhir->CurrentValue, 0);
		$this->kd_lmbg->CurrentValue = $this->kd_lmbg->FormValue;
		$this->kd_jbt->CurrentValue = $this->kd_jbt->FormValue;
		$this->jam->CurrentValue = $this->jam->FormValue;
		$this->tempat->CurrentValue = $this->tempat->FormValue;
		$this->app->CurrentValue = $this->app->FormValue;
		$this->app_empid->CurrentValue = $this->app_empid->FormValue;
		$this->app_jbt->CurrentValue = $this->app_jbt->FormValue;
		$this->app_date->CurrentValue = $this->app_date->FormValue;
		$this->app_date->CurrentValue = ew_UnFormatDateTime($this->app_date->CurrentValue, 0);
		$this->created_by->CurrentValue = $this->created_by->FormValue;
		$this->created_date->CurrentValue = $this->created_date->FormValue;
		$this->created_date->CurrentValue = ew_UnFormatDateTime($this->created_date->CurrentValue, 0);
		$this->last_update_by->CurrentValue = $this->last_update_by->FormValue;
		$this->last_update_date->CurrentValue = $this->last_update_date->FormValue;
		$this->last_update_date->CurrentValue = ew_UnFormatDateTime($this->last_update_date->CurrentValue, 0);
		$this->sertifikat->CurrentValue = $this->sertifikat->FormValue;
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
		$this->no_st->setDbValue($row['no_st']);
		$this->tgl_st->setDbValue($row['tgl_st']);
		$this->employee_id->setDbValue($row['employee_id']);
		$this->kd_latih->setDbValue($row['kd_latih']);
		$this->tgl_mulai->setDbValue($row['tgl_mulai']);
		$this->tgl_akhir->setDbValue($row['tgl_akhir']);
		$this->kd_lmbg->setDbValue($row['kd_lmbg']);
		$this->kd_jbt->setDbValue($row['kd_jbt']);
		$this->jam->setDbValue($row['jam']);
		$this->tempat->setDbValue($row['tempat']);
		$this->app->setDbValue($row['app']);
		$this->app_empid->setDbValue($row['app_empid']);
		$this->app_jbt->setDbValue($row['app_jbt']);
		$this->app_date->setDbValue($row['app_date']);
		$this->created_by->setDbValue($row['created_by']);
		$this->created_date->setDbValue($row['created_date']);
		$this->last_update_by->setDbValue($row['last_update_by']);
		$this->last_update_date->setDbValue($row['last_update_date']);
		$this->sertifikat->setDbValue($row['sertifikat']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['no_st'] = NULL;
		$row['tgl_st'] = NULL;
		$row['employee_id'] = NULL;
		$row['kd_latih'] = NULL;
		$row['tgl_mulai'] = NULL;
		$row['tgl_akhir'] = NULL;
		$row['kd_lmbg'] = NULL;
		$row['kd_jbt'] = NULL;
		$row['jam'] = NULL;
		$row['tempat'] = NULL;
		$row['app'] = NULL;
		$row['app_empid'] = NULL;
		$row['app_jbt'] = NULL;
		$row['app_date'] = NULL;
		$row['created_by'] = NULL;
		$row['created_date'] = NULL;
		$row['last_update_by'] = NULL;
		$row['last_update_date'] = NULL;
		$row['sertifikat'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->no_st->DbValue = $row['no_st'];
		$this->tgl_st->DbValue = $row['tgl_st'];
		$this->employee_id->DbValue = $row['employee_id'];
		$this->kd_latih->DbValue = $row['kd_latih'];
		$this->tgl_mulai->DbValue = $row['tgl_mulai'];
		$this->tgl_akhir->DbValue = $row['tgl_akhir'];
		$this->kd_lmbg->DbValue = $row['kd_lmbg'];
		$this->kd_jbt->DbValue = $row['kd_jbt'];
		$this->jam->DbValue = $row['jam'];
		$this->tempat->DbValue = $row['tempat'];
		$this->app->DbValue = $row['app'];
		$this->app_empid->DbValue = $row['app_empid'];
		$this->app_jbt->DbValue = $row['app_jbt'];
		$this->app_date->DbValue = $row['app_date'];
		$this->created_by->DbValue = $row['created_by'];
		$this->created_date->DbValue = $row['created_date'];
		$this->last_update_by->DbValue = $row['last_update_by'];
		$this->last_update_date->DbValue = $row['last_update_date'];
		$this->sertifikat->DbValue = $row['sertifikat'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("no_st")) <> "")
			$this->no_st->CurrentValue = $this->getKey("no_st"); // no_st
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("employee_id")) <> "")
			$this->employee_id->CurrentValue = $this->getKey("employee_id"); // employee_id
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
		// no_st
		// tgl_st
		// employee_id
		// kd_latih
		// tgl_mulai
		// tgl_akhir
		// kd_lmbg
		// kd_jbt
		// jam
		// tempat
		// app
		// app_empid
		// app_jbt
		// app_date
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// sertifikat

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// no_st
		$this->no_st->ViewValue = $this->no_st->CurrentValue;
		$this->no_st->ViewCustomAttributes = "";

		// tgl_st
		$this->tgl_st->ViewValue = $this->tgl_st->CurrentValue;
		$this->tgl_st->ViewValue = ew_FormatDateTime($this->tgl_st->ViewValue, 0);
		$this->tgl_st->ViewCustomAttributes = "";

		// employee_id
		$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
		$this->employee_id->ViewCustomAttributes = "";

		// kd_latih
		$this->kd_latih->ViewValue = $this->kd_latih->CurrentValue;
		$this->kd_latih->ViewCustomAttributes = "";

		// tgl_mulai
		$this->tgl_mulai->ViewValue = $this->tgl_mulai->CurrentValue;
		$this->tgl_mulai->ViewValue = ew_FormatDateTime($this->tgl_mulai->ViewValue, 0);
		$this->tgl_mulai->ViewCustomAttributes = "";

		// tgl_akhir
		$this->tgl_akhir->ViewValue = $this->tgl_akhir->CurrentValue;
		$this->tgl_akhir->ViewValue = ew_FormatDateTime($this->tgl_akhir->ViewValue, 0);
		$this->tgl_akhir->ViewCustomAttributes = "";

		// kd_lmbg
		$this->kd_lmbg->ViewValue = $this->kd_lmbg->CurrentValue;
		$this->kd_lmbg->ViewCustomAttributes = "";

		// kd_jbt
		$this->kd_jbt->ViewValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// jam
		$this->jam->ViewValue = $this->jam->CurrentValue;
		$this->jam->ViewCustomAttributes = "";

		// tempat
		$this->tempat->ViewValue = $this->tempat->CurrentValue;
		$this->tempat->ViewCustomAttributes = "";

		// app
		$this->app->ViewValue = $this->app->CurrentValue;
		$this->app->ViewCustomAttributes = "";

		// app_empid
		$this->app_empid->ViewValue = $this->app_empid->CurrentValue;
		$this->app_empid->ViewCustomAttributes = "";

		// app_jbt
		$this->app_jbt->ViewValue = $this->app_jbt->CurrentValue;
		$this->app_jbt->ViewCustomAttributes = "";

		// app_date
		$this->app_date->ViewValue = $this->app_date->CurrentValue;
		$this->app_date->ViewValue = ew_FormatDateTime($this->app_date->ViewValue, 0);
		$this->app_date->ViewCustomAttributes = "";

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

		// sertifikat
		$this->sertifikat->ViewValue = $this->sertifikat->CurrentValue;
		$this->sertifikat->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// no_st
			$this->no_st->LinkCustomAttributes = "";
			$this->no_st->HrefValue = "";
			$this->no_st->TooltipValue = "";

			// tgl_st
			$this->tgl_st->LinkCustomAttributes = "";
			$this->tgl_st->HrefValue = "";
			$this->tgl_st->TooltipValue = "";

			// employee_id
			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";
			$this->employee_id->TooltipValue = "";

			// kd_latih
			$this->kd_latih->LinkCustomAttributes = "";
			$this->kd_latih->HrefValue = "";
			$this->kd_latih->TooltipValue = "";

			// tgl_mulai
			$this->tgl_mulai->LinkCustomAttributes = "";
			$this->tgl_mulai->HrefValue = "";
			$this->tgl_mulai->TooltipValue = "";

			// tgl_akhir
			$this->tgl_akhir->LinkCustomAttributes = "";
			$this->tgl_akhir->HrefValue = "";
			$this->tgl_akhir->TooltipValue = "";

			// kd_lmbg
			$this->kd_lmbg->LinkCustomAttributes = "";
			$this->kd_lmbg->HrefValue = "";
			$this->kd_lmbg->TooltipValue = "";

			// kd_jbt
			$this->kd_jbt->LinkCustomAttributes = "";
			$this->kd_jbt->HrefValue = "";
			$this->kd_jbt->TooltipValue = "";

			// jam
			$this->jam->LinkCustomAttributes = "";
			$this->jam->HrefValue = "";
			$this->jam->TooltipValue = "";

			// tempat
			$this->tempat->LinkCustomAttributes = "";
			$this->tempat->HrefValue = "";
			$this->tempat->TooltipValue = "";

			// app
			$this->app->LinkCustomAttributes = "";
			$this->app->HrefValue = "";
			$this->app->TooltipValue = "";

			// app_empid
			$this->app_empid->LinkCustomAttributes = "";
			$this->app_empid->HrefValue = "";
			$this->app_empid->TooltipValue = "";

			// app_jbt
			$this->app_jbt->LinkCustomAttributes = "";
			$this->app_jbt->HrefValue = "";
			$this->app_jbt->TooltipValue = "";

			// app_date
			$this->app_date->LinkCustomAttributes = "";
			$this->app_date->HrefValue = "";
			$this->app_date->TooltipValue = "";

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

			// sertifikat
			$this->sertifikat->LinkCustomAttributes = "";
			$this->sertifikat->HrefValue = "";
			$this->sertifikat->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// no_st
			$this->no_st->EditAttrs["class"] = "form-control";
			$this->no_st->EditCustomAttributes = "";
			$this->no_st->EditValue = $this->no_st->CurrentValue;
			$this->no_st->ViewCustomAttributes = "";

			// tgl_st
			$this->tgl_st->EditAttrs["class"] = "form-control";
			$this->tgl_st->EditCustomAttributes = "";
			$this->tgl_st->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_st->CurrentValue, 8));
			$this->tgl_st->PlaceHolder = ew_RemoveHtml($this->tgl_st->FldCaption());

			// employee_id
			$this->employee_id->EditAttrs["class"] = "form-control";
			$this->employee_id->EditCustomAttributes = "";
			$this->employee_id->EditValue = $this->employee_id->CurrentValue;
			$this->employee_id->ViewCustomAttributes = "";

			// kd_latih
			$this->kd_latih->EditAttrs["class"] = "form-control";
			$this->kd_latih->EditCustomAttributes = "";
			$this->kd_latih->EditValue = ew_HtmlEncode($this->kd_latih->CurrentValue);
			$this->kd_latih->PlaceHolder = ew_RemoveHtml($this->kd_latih->FldCaption());

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

			// kd_lmbg
			$this->kd_lmbg->EditAttrs["class"] = "form-control";
			$this->kd_lmbg->EditCustomAttributes = "";
			$this->kd_lmbg->EditValue = ew_HtmlEncode($this->kd_lmbg->CurrentValue);
			$this->kd_lmbg->PlaceHolder = ew_RemoveHtml($this->kd_lmbg->FldCaption());

			// kd_jbt
			$this->kd_jbt->EditAttrs["class"] = "form-control";
			$this->kd_jbt->EditCustomAttributes = "";
			$this->kd_jbt->EditValue = ew_HtmlEncode($this->kd_jbt->CurrentValue);
			$this->kd_jbt->PlaceHolder = ew_RemoveHtml($this->kd_jbt->FldCaption());

			// jam
			$this->jam->EditAttrs["class"] = "form-control";
			$this->jam->EditCustomAttributes = "";
			$this->jam->EditValue = ew_HtmlEncode($this->jam->CurrentValue);
			$this->jam->PlaceHolder = ew_RemoveHtml($this->jam->FldCaption());

			// tempat
			$this->tempat->EditAttrs["class"] = "form-control";
			$this->tempat->EditCustomAttributes = "";
			$this->tempat->EditValue = ew_HtmlEncode($this->tempat->CurrentValue);
			$this->tempat->PlaceHolder = ew_RemoveHtml($this->tempat->FldCaption());

			// app
			$this->app->EditAttrs["class"] = "form-control";
			$this->app->EditCustomAttributes = "";
			$this->app->EditValue = ew_HtmlEncode($this->app->CurrentValue);
			$this->app->PlaceHolder = ew_RemoveHtml($this->app->FldCaption());

			// app_empid
			$this->app_empid->EditAttrs["class"] = "form-control";
			$this->app_empid->EditCustomAttributes = "";
			$this->app_empid->EditValue = ew_HtmlEncode($this->app_empid->CurrentValue);
			$this->app_empid->PlaceHolder = ew_RemoveHtml($this->app_empid->FldCaption());

			// app_jbt
			$this->app_jbt->EditAttrs["class"] = "form-control";
			$this->app_jbt->EditCustomAttributes = "";
			$this->app_jbt->EditValue = ew_HtmlEncode($this->app_jbt->CurrentValue);
			$this->app_jbt->PlaceHolder = ew_RemoveHtml($this->app_jbt->FldCaption());

			// app_date
			$this->app_date->EditAttrs["class"] = "form-control";
			$this->app_date->EditCustomAttributes = "";
			$this->app_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->app_date->CurrentValue, 8));
			$this->app_date->PlaceHolder = ew_RemoveHtml($this->app_date->FldCaption());

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

			// sertifikat
			$this->sertifikat->EditAttrs["class"] = "form-control";
			$this->sertifikat->EditCustomAttributes = "";
			$this->sertifikat->EditValue = ew_HtmlEncode($this->sertifikat->CurrentValue);
			$this->sertifikat->PlaceHolder = ew_RemoveHtml($this->sertifikat->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// no_st
			$this->no_st->LinkCustomAttributes = "";
			$this->no_st->HrefValue = "";

			// tgl_st
			$this->tgl_st->LinkCustomAttributes = "";
			$this->tgl_st->HrefValue = "";

			// employee_id
			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";

			// kd_latih
			$this->kd_latih->LinkCustomAttributes = "";
			$this->kd_latih->HrefValue = "";

			// tgl_mulai
			$this->tgl_mulai->LinkCustomAttributes = "";
			$this->tgl_mulai->HrefValue = "";

			// tgl_akhir
			$this->tgl_akhir->LinkCustomAttributes = "";
			$this->tgl_akhir->HrefValue = "";

			// kd_lmbg
			$this->kd_lmbg->LinkCustomAttributes = "";
			$this->kd_lmbg->HrefValue = "";

			// kd_jbt
			$this->kd_jbt->LinkCustomAttributes = "";
			$this->kd_jbt->HrefValue = "";

			// jam
			$this->jam->LinkCustomAttributes = "";
			$this->jam->HrefValue = "";

			// tempat
			$this->tempat->LinkCustomAttributes = "";
			$this->tempat->HrefValue = "";

			// app
			$this->app->LinkCustomAttributes = "";
			$this->app->HrefValue = "";

			// app_empid
			$this->app_empid->LinkCustomAttributes = "";
			$this->app_empid->HrefValue = "";

			// app_jbt
			$this->app_jbt->LinkCustomAttributes = "";
			$this->app_jbt->HrefValue = "";

			// app_date
			$this->app_date->LinkCustomAttributes = "";
			$this->app_date->HrefValue = "";

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

			// sertifikat
			$this->sertifikat->LinkCustomAttributes = "";
			$this->sertifikat->HrefValue = "";
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
		if (!$this->no_st->FldIsDetailKey && !is_null($this->no_st->FormValue) && $this->no_st->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->no_st->FldCaption(), $this->no_st->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->tgl_st->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_st->FldErrMsg());
		}
		if (!$this->employee_id->FldIsDetailKey && !is_null($this->employee_id->FormValue) && $this->employee_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->employee_id->FldCaption(), $this->employee_id->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->tgl_mulai->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_mulai->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_akhir->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_akhir->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->app_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->app_date->FldErrMsg());
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

			// no_st
			// tgl_st

			$this->tgl_st->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_st->CurrentValue, 0), NULL, $this->tgl_st->ReadOnly);

			// employee_id
			// kd_latih

			$this->kd_latih->SetDbValueDef($rsnew, $this->kd_latih->CurrentValue, NULL, $this->kd_latih->ReadOnly);

			// tgl_mulai
			$this->tgl_mulai->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_mulai->CurrentValue, 0), NULL, $this->tgl_mulai->ReadOnly);

			// tgl_akhir
			$this->tgl_akhir->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_akhir->CurrentValue, 0), NULL, $this->tgl_akhir->ReadOnly);

			// kd_lmbg
			$this->kd_lmbg->SetDbValueDef($rsnew, $this->kd_lmbg->CurrentValue, NULL, $this->kd_lmbg->ReadOnly);

			// kd_jbt
			$this->kd_jbt->SetDbValueDef($rsnew, $this->kd_jbt->CurrentValue, NULL, $this->kd_jbt->ReadOnly);

			// jam
			$this->jam->SetDbValueDef($rsnew, $this->jam->CurrentValue, NULL, $this->jam->ReadOnly);

			// tempat
			$this->tempat->SetDbValueDef($rsnew, $this->tempat->CurrentValue, NULL, $this->tempat->ReadOnly);

			// app
			$this->app->SetDbValueDef($rsnew, $this->app->CurrentValue, NULL, $this->app->ReadOnly);

			// app_empid
			$this->app_empid->SetDbValueDef($rsnew, $this->app_empid->CurrentValue, NULL, $this->app_empid->ReadOnly);

			// app_jbt
			$this->app_jbt->SetDbValueDef($rsnew, $this->app_jbt->CurrentValue, NULL, $this->app_jbt->ReadOnly);

			// app_date
			$this->app_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->app_date->CurrentValue, 0), NULL, $this->app_date->ReadOnly);

			// created_by
			$this->created_by->SetDbValueDef($rsnew, $this->created_by->CurrentValue, NULL, $this->created_by->ReadOnly);

			// created_date
			$this->created_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->created_date->CurrentValue, 0), NULL, $this->created_date->ReadOnly);

			// last_update_by
			$this->last_update_by->SetDbValueDef($rsnew, $this->last_update_by->CurrentValue, NULL, $this->last_update_by->ReadOnly);

			// last_update_date
			$this->last_update_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->last_update_date->CurrentValue, 0), NULL, $this->last_update_date->ReadOnly);

			// sertifikat
			$this->sertifikat->SetDbValueDef($rsnew, $this->sertifikat->CurrentValue, NULL, $this->sertifikat->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("st_latihlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($st_latih_edit)) $st_latih_edit = new cst_latih_edit();

// Page init
$st_latih_edit->Page_Init();

// Page main
$st_latih_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$st_latih_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fst_latihedit = new ew_Form("fst_latihedit", "edit");

// Validate form
fst_latihedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_no_st");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $st_latih->no_st->FldCaption(), $st_latih->no_st->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tgl_st");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($st_latih->tgl_st->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_employee_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $st_latih->employee_id->FldCaption(), $st_latih->employee_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tgl_mulai");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($st_latih->tgl_mulai->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_akhir");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($st_latih->tgl_akhir->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_app_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($st_latih->app_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_created_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($st_latih->created_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_update_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($st_latih->last_update_date->FldErrMsg()) ?>");

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
fst_latihedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fst_latihedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $st_latih_edit->ShowPageHeader(); ?>
<?php
$st_latih_edit->ShowMessage();
?>
<form name="fst_latihedit" id="fst_latihedit" class="<?php echo $st_latih_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($st_latih_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $st_latih_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="st_latih">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($st_latih_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($st_latih->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_st_latih_id" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->id->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->id->CellAttributes() ?>>
<span id="el_st_latih_id">
<span<?php echo $st_latih->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $st_latih->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="st_latih" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($st_latih->id->CurrentValue) ?>">
<?php echo $st_latih->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->no_st->Visible) { // no_st ?>
	<div id="r_no_st" class="form-group">
		<label id="elh_st_latih_no_st" for="x_no_st" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->no_st->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->no_st->CellAttributes() ?>>
<span id="el_st_latih_no_st">
<span<?php echo $st_latih->no_st->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $st_latih->no_st->EditValue ?></p></span>
</span>
<input type="hidden" data-table="st_latih" data-field="x_no_st" name="x_no_st" id="x_no_st" value="<?php echo ew_HtmlEncode($st_latih->no_st->CurrentValue) ?>">
<?php echo $st_latih->no_st->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->tgl_st->Visible) { // tgl_st ?>
	<div id="r_tgl_st" class="form-group">
		<label id="elh_st_latih_tgl_st" for="x_tgl_st" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->tgl_st->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->tgl_st->CellAttributes() ?>>
<span id="el_st_latih_tgl_st">
<input type="text" data-table="st_latih" data-field="x_tgl_st" name="x_tgl_st" id="x_tgl_st" placeholder="<?php echo ew_HtmlEncode($st_latih->tgl_st->getPlaceHolder()) ?>" value="<?php echo $st_latih->tgl_st->EditValue ?>"<?php echo $st_latih->tgl_st->EditAttributes() ?>>
</span>
<?php echo $st_latih->tgl_st->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->employee_id->Visible) { // employee_id ?>
	<div id="r_employee_id" class="form-group">
		<label id="elh_st_latih_employee_id" for="x_employee_id" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->employee_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->employee_id->CellAttributes() ?>>
<span id="el_st_latih_employee_id">
<span<?php echo $st_latih->employee_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $st_latih->employee_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="st_latih" data-field="x_employee_id" name="x_employee_id" id="x_employee_id" value="<?php echo ew_HtmlEncode($st_latih->employee_id->CurrentValue) ?>">
<?php echo $st_latih->employee_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->kd_latih->Visible) { // kd_latih ?>
	<div id="r_kd_latih" class="form-group">
		<label id="elh_st_latih_kd_latih" for="x_kd_latih" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->kd_latih->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->kd_latih->CellAttributes() ?>>
<span id="el_st_latih_kd_latih">
<input type="text" data-table="st_latih" data-field="x_kd_latih" name="x_kd_latih" id="x_kd_latih" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($st_latih->kd_latih->getPlaceHolder()) ?>" value="<?php echo $st_latih->kd_latih->EditValue ?>"<?php echo $st_latih->kd_latih->EditAttributes() ?>>
</span>
<?php echo $st_latih->kd_latih->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->tgl_mulai->Visible) { // tgl_mulai ?>
	<div id="r_tgl_mulai" class="form-group">
		<label id="elh_st_latih_tgl_mulai" for="x_tgl_mulai" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->tgl_mulai->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->tgl_mulai->CellAttributes() ?>>
<span id="el_st_latih_tgl_mulai">
<input type="text" data-table="st_latih" data-field="x_tgl_mulai" name="x_tgl_mulai" id="x_tgl_mulai" placeholder="<?php echo ew_HtmlEncode($st_latih->tgl_mulai->getPlaceHolder()) ?>" value="<?php echo $st_latih->tgl_mulai->EditValue ?>"<?php echo $st_latih->tgl_mulai->EditAttributes() ?>>
</span>
<?php echo $st_latih->tgl_mulai->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->tgl_akhir->Visible) { // tgl_akhir ?>
	<div id="r_tgl_akhir" class="form-group">
		<label id="elh_st_latih_tgl_akhir" for="x_tgl_akhir" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->tgl_akhir->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->tgl_akhir->CellAttributes() ?>>
<span id="el_st_latih_tgl_akhir">
<input type="text" data-table="st_latih" data-field="x_tgl_akhir" name="x_tgl_akhir" id="x_tgl_akhir" placeholder="<?php echo ew_HtmlEncode($st_latih->tgl_akhir->getPlaceHolder()) ?>" value="<?php echo $st_latih->tgl_akhir->EditValue ?>"<?php echo $st_latih->tgl_akhir->EditAttributes() ?>>
</span>
<?php echo $st_latih->tgl_akhir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->kd_lmbg->Visible) { // kd_lmbg ?>
	<div id="r_kd_lmbg" class="form-group">
		<label id="elh_st_latih_kd_lmbg" for="x_kd_lmbg" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->kd_lmbg->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->kd_lmbg->CellAttributes() ?>>
<span id="el_st_latih_kd_lmbg">
<input type="text" data-table="st_latih" data-field="x_kd_lmbg" name="x_kd_lmbg" id="x_kd_lmbg" size="30" maxlength="4" placeholder="<?php echo ew_HtmlEncode($st_latih->kd_lmbg->getPlaceHolder()) ?>" value="<?php echo $st_latih->kd_lmbg->EditValue ?>"<?php echo $st_latih->kd_lmbg->EditAttributes() ?>>
</span>
<?php echo $st_latih->kd_lmbg->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->kd_jbt->Visible) { // kd_jbt ?>
	<div id="r_kd_jbt" class="form-group">
		<label id="elh_st_latih_kd_jbt" for="x_kd_jbt" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->kd_jbt->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->kd_jbt->CellAttributes() ?>>
<span id="el_st_latih_kd_jbt">
<input type="text" data-table="st_latih" data-field="x_kd_jbt" name="x_kd_jbt" id="x_kd_jbt" size="30" maxlength="7" placeholder="<?php echo ew_HtmlEncode($st_latih->kd_jbt->getPlaceHolder()) ?>" value="<?php echo $st_latih->kd_jbt->EditValue ?>"<?php echo $st_latih->kd_jbt->EditAttributes() ?>>
</span>
<?php echo $st_latih->kd_jbt->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->jam->Visible) { // jam ?>
	<div id="r_jam" class="form-group">
		<label id="elh_st_latih_jam" for="x_jam" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->jam->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->jam->CellAttributes() ?>>
<span id="el_st_latih_jam">
<input type="text" data-table="st_latih" data-field="x_jam" name="x_jam" id="x_jam" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($st_latih->jam->getPlaceHolder()) ?>" value="<?php echo $st_latih->jam->EditValue ?>"<?php echo $st_latih->jam->EditAttributes() ?>>
</span>
<?php echo $st_latih->jam->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->tempat->Visible) { // tempat ?>
	<div id="r_tempat" class="form-group">
		<label id="elh_st_latih_tempat" for="x_tempat" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->tempat->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->tempat->CellAttributes() ?>>
<span id="el_st_latih_tempat">
<input type="text" data-table="st_latih" data-field="x_tempat" name="x_tempat" id="x_tempat" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($st_latih->tempat->getPlaceHolder()) ?>" value="<?php echo $st_latih->tempat->EditValue ?>"<?php echo $st_latih->tempat->EditAttributes() ?>>
</span>
<?php echo $st_latih->tempat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->app->Visible) { // app ?>
	<div id="r_app" class="form-group">
		<label id="elh_st_latih_app" for="x_app" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->app->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->app->CellAttributes() ?>>
<span id="el_st_latih_app">
<input type="text" data-table="st_latih" data-field="x_app" name="x_app" id="x_app" size="30" maxlength="1" placeholder="<?php echo ew_HtmlEncode($st_latih->app->getPlaceHolder()) ?>" value="<?php echo $st_latih->app->EditValue ?>"<?php echo $st_latih->app->EditAttributes() ?>>
</span>
<?php echo $st_latih->app->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->app_empid->Visible) { // app_empid ?>
	<div id="r_app_empid" class="form-group">
		<label id="elh_st_latih_app_empid" for="x_app_empid" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->app_empid->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->app_empid->CellAttributes() ?>>
<span id="el_st_latih_app_empid">
<input type="text" data-table="st_latih" data-field="x_app_empid" name="x_app_empid" id="x_app_empid" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($st_latih->app_empid->getPlaceHolder()) ?>" value="<?php echo $st_latih->app_empid->EditValue ?>"<?php echo $st_latih->app_empid->EditAttributes() ?>>
</span>
<?php echo $st_latih->app_empid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->app_jbt->Visible) { // app_jbt ?>
	<div id="r_app_jbt" class="form-group">
		<label id="elh_st_latih_app_jbt" for="x_app_jbt" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->app_jbt->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->app_jbt->CellAttributes() ?>>
<span id="el_st_latih_app_jbt">
<input type="text" data-table="st_latih" data-field="x_app_jbt" name="x_app_jbt" id="x_app_jbt" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($st_latih->app_jbt->getPlaceHolder()) ?>" value="<?php echo $st_latih->app_jbt->EditValue ?>"<?php echo $st_latih->app_jbt->EditAttributes() ?>>
</span>
<?php echo $st_latih->app_jbt->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->app_date->Visible) { // app_date ?>
	<div id="r_app_date" class="form-group">
		<label id="elh_st_latih_app_date" for="x_app_date" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->app_date->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->app_date->CellAttributes() ?>>
<span id="el_st_latih_app_date">
<input type="text" data-table="st_latih" data-field="x_app_date" name="x_app_date" id="x_app_date" placeholder="<?php echo ew_HtmlEncode($st_latih->app_date->getPlaceHolder()) ?>" value="<?php echo $st_latih->app_date->EditValue ?>"<?php echo $st_latih->app_date->EditAttributes() ?>>
</span>
<?php echo $st_latih->app_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->created_by->Visible) { // created_by ?>
	<div id="r_created_by" class="form-group">
		<label id="elh_st_latih_created_by" for="x_created_by" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->created_by->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->created_by->CellAttributes() ?>>
<span id="el_st_latih_created_by">
<input type="text" data-table="st_latih" data-field="x_created_by" name="x_created_by" id="x_created_by" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($st_latih->created_by->getPlaceHolder()) ?>" value="<?php echo $st_latih->created_by->EditValue ?>"<?php echo $st_latih->created_by->EditAttributes() ?>>
</span>
<?php echo $st_latih->created_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->created_date->Visible) { // created_date ?>
	<div id="r_created_date" class="form-group">
		<label id="elh_st_latih_created_date" for="x_created_date" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->created_date->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->created_date->CellAttributes() ?>>
<span id="el_st_latih_created_date">
<input type="text" data-table="st_latih" data-field="x_created_date" name="x_created_date" id="x_created_date" placeholder="<?php echo ew_HtmlEncode($st_latih->created_date->getPlaceHolder()) ?>" value="<?php echo $st_latih->created_date->EditValue ?>"<?php echo $st_latih->created_date->EditAttributes() ?>>
</span>
<?php echo $st_latih->created_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->last_update_by->Visible) { // last_update_by ?>
	<div id="r_last_update_by" class="form-group">
		<label id="elh_st_latih_last_update_by" for="x_last_update_by" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->last_update_by->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->last_update_by->CellAttributes() ?>>
<span id="el_st_latih_last_update_by">
<input type="text" data-table="st_latih" data-field="x_last_update_by" name="x_last_update_by" id="x_last_update_by" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($st_latih->last_update_by->getPlaceHolder()) ?>" value="<?php echo $st_latih->last_update_by->EditValue ?>"<?php echo $st_latih->last_update_by->EditAttributes() ?>>
</span>
<?php echo $st_latih->last_update_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->last_update_date->Visible) { // last_update_date ?>
	<div id="r_last_update_date" class="form-group">
		<label id="elh_st_latih_last_update_date" for="x_last_update_date" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->last_update_date->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->last_update_date->CellAttributes() ?>>
<span id="el_st_latih_last_update_date">
<input type="text" data-table="st_latih" data-field="x_last_update_date" name="x_last_update_date" id="x_last_update_date" placeholder="<?php echo ew_HtmlEncode($st_latih->last_update_date->getPlaceHolder()) ?>" value="<?php echo $st_latih->last_update_date->EditValue ?>"<?php echo $st_latih->last_update_date->EditAttributes() ?>>
</span>
<?php echo $st_latih->last_update_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($st_latih->sertifikat->Visible) { // sertifikat ?>
	<div id="r_sertifikat" class="form-group">
		<label id="elh_st_latih_sertifikat" for="x_sertifikat" class="<?php echo $st_latih_edit->LeftColumnClass ?>"><?php echo $st_latih->sertifikat->FldCaption() ?></label>
		<div class="<?php echo $st_latih_edit->RightColumnClass ?>"><div<?php echo $st_latih->sertifikat->CellAttributes() ?>>
<span id="el_st_latih_sertifikat">
<input type="text" data-table="st_latih" data-field="x_sertifikat" name="x_sertifikat" id="x_sertifikat" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($st_latih->sertifikat->getPlaceHolder()) ?>" value="<?php echo $st_latih->sertifikat->EditValue ?>"<?php echo $st_latih->sertifikat->EditAttributes() ?>>
</span>
<?php echo $st_latih->sertifikat->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$st_latih_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $st_latih_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $st_latih_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fst_latihedit.Init();
</script>
<?php
$st_latih_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$st_latih_edit->Page_Terminate();
?>
