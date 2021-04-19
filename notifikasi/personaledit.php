<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "personalinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$personal_edit = NULL; // Initialize page object first

class cpersonal_edit extends cpersonal {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'personal';

	// Page object name
	var $PageObjName = 'personal_edit';

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

		// Table object (personal)
		if (!isset($GLOBALS["personal"]) || get_class($GLOBALS["personal"]) == "cpersonal") {
			$GLOBALS["personal"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["personal"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'personal', TRUE);

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
		$this->employee_id->SetVisibility();
		$this->first_name->SetVisibility();
		$this->last_name->SetVisibility();
		$this->first_title->SetVisibility();
		$this->last_title->SetVisibility();
		$this->init->SetVisibility();
		$this->tpt_lahir->SetVisibility();
		$this->tgl_lahir->SetVisibility();
		$this->jk->SetVisibility();
		$this->kd_agama->SetVisibility();
		$this->tgl_masuk->SetVisibility();
		$this->tpt_masuk->SetVisibility();
		$this->stkel->SetVisibility();
		$this->alamat->SetVisibility();
		$this->kota->SetVisibility();
		$this->kd_pos->SetVisibility();
		$this->kd_propinsi->SetVisibility();
		$this->telp->SetVisibility();
		$this->telp_area->SetVisibility();
		$this->hp->SetVisibility();
		$this->alamat_dom->SetVisibility();
		$this->kota_dom->SetVisibility();
		$this->kd_pos_dom->SetVisibility();
		$this->kd_propinsi_dom->SetVisibility();
		$this->telp_dom->SetVisibility();
		$this->telp_dom_area->SetVisibility();
		$this->_email->SetVisibility();
		$this->kd_st_emp->SetVisibility();
		$this->skala->SetVisibility();
		$this->gp->SetVisibility();
		$this->upah_tetap->SetVisibility();
		$this->tgl_honor->SetVisibility();
		$this->honor->SetVisibility();
		$this->premi_honor->SetVisibility();
		$this->tgl_gp->SetVisibility();
		$this->skala_95->SetVisibility();
		$this->gp_95->SetVisibility();
		$this->tgl_gp_95->SetVisibility();
		$this->kd_indx->SetVisibility();
		$this->indx_lok->SetVisibility();
		$this->gol_darah->SetVisibility();
		$this->kd_jbt->SetVisibility();
		$this->tgl_kd_jbt->SetVisibility();
		$this->kd_jbt_pgs->SetVisibility();
		$this->tgl_kd_jbt_pgs->SetVisibility();
		$this->kd_jbt_pjs->SetVisibility();
		$this->tgl_kd_jbt_pjs->SetVisibility();
		$this->kd_jbt_ps->SetVisibility();
		$this->tgl_kd_jbt_ps->SetVisibility();
		$this->kd_pat->SetVisibility();
		$this->kd_gas->SetVisibility();
		$this->pimp_empid->SetVisibility();
		$this->stshift->SetVisibility();
		$this->no_rek->SetVisibility();
		$this->kd_bank->SetVisibility();
		$this->kd_jamsostek->SetVisibility();
		$this->acc_astek->SetVisibility();
		$this->acc_dapens->SetVisibility();
		$this->acc_kes->SetVisibility();
		$this->st->SetVisibility();
		$this->signature->SetVisibility();
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();
		$this->fgr_print_id->SetVisibility();
		$this->kd_jbt_eselon->SetVisibility();
		$this->npwp->SetVisibility();
		$this->paraf->SetVisibility();
		$this->tgl_keluar->SetVisibility();
		$this->nama_nasabah->SetVisibility();
		$this->no_ktp->SetVisibility();
		$this->no_kokar->SetVisibility();
		$this->no_bmw->SetVisibility();
		$this->no_bpjs_ketenagakerjaan->SetVisibility();
		$this->no_bpjs_kesehatan->SetVisibility();
		$this->eselon->SetVisibility();
		$this->kd_jenjang->SetVisibility();
		$this->kd_jbt_esl->SetVisibility();
		$this->tgl_jbt_esl->SetVisibility();
		$this->org_id->SetVisibility();
		$this->picture->SetVisibility();
		$this->kd_payroll->SetVisibility();
		$this->id_wn->SetVisibility();
		$this->no_anggota_kkms->SetVisibility();

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
		global $EW_EXPORT, $personal;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($personal);
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
					if ($pageName == "personalview.php")
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
			if ($objForm->HasValue("x_employee_id")) {
				$this->employee_id->setFormValue($objForm->GetValue("x_employee_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
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
					$this->Page_Terminate("personallist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "personallist.php")
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
		$this->signature->Upload->Index = $objForm->Index;
		$this->signature->Upload->UploadFile();
		$this->paraf->Upload->Index = $objForm->Index;
		$this->paraf->Upload->UploadFile();
		$this->picture->Upload->Index = $objForm->Index;
		$this->picture->Upload->UploadFile();
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->employee_id->FldIsDetailKey) {
			$this->employee_id->setFormValue($objForm->GetValue("x_employee_id"));
		}
		if (!$this->first_name->FldIsDetailKey) {
			$this->first_name->setFormValue($objForm->GetValue("x_first_name"));
		}
		if (!$this->last_name->FldIsDetailKey) {
			$this->last_name->setFormValue($objForm->GetValue("x_last_name"));
		}
		if (!$this->first_title->FldIsDetailKey) {
			$this->first_title->setFormValue($objForm->GetValue("x_first_title"));
		}
		if (!$this->last_title->FldIsDetailKey) {
			$this->last_title->setFormValue($objForm->GetValue("x_last_title"));
		}
		if (!$this->init->FldIsDetailKey) {
			$this->init->setFormValue($objForm->GetValue("x_init"));
		}
		if (!$this->tpt_lahir->FldIsDetailKey) {
			$this->tpt_lahir->setFormValue($objForm->GetValue("x_tpt_lahir"));
		}
		if (!$this->tgl_lahir->FldIsDetailKey) {
			$this->tgl_lahir->setFormValue($objForm->GetValue("x_tgl_lahir"));
			$this->tgl_lahir->CurrentValue = ew_UnFormatDateTime($this->tgl_lahir->CurrentValue, 0);
		}
		if (!$this->jk->FldIsDetailKey) {
			$this->jk->setFormValue($objForm->GetValue("x_jk"));
		}
		if (!$this->kd_agama->FldIsDetailKey) {
			$this->kd_agama->setFormValue($objForm->GetValue("x_kd_agama"));
		}
		if (!$this->tgl_masuk->FldIsDetailKey) {
			$this->tgl_masuk->setFormValue($objForm->GetValue("x_tgl_masuk"));
			$this->tgl_masuk->CurrentValue = ew_UnFormatDateTime($this->tgl_masuk->CurrentValue, 0);
		}
		if (!$this->tpt_masuk->FldIsDetailKey) {
			$this->tpt_masuk->setFormValue($objForm->GetValue("x_tpt_masuk"));
		}
		if (!$this->stkel->FldIsDetailKey) {
			$this->stkel->setFormValue($objForm->GetValue("x_stkel"));
		}
		if (!$this->alamat->FldIsDetailKey) {
			$this->alamat->setFormValue($objForm->GetValue("x_alamat"));
		}
		if (!$this->kota->FldIsDetailKey) {
			$this->kota->setFormValue($objForm->GetValue("x_kota"));
		}
		if (!$this->kd_pos->FldIsDetailKey) {
			$this->kd_pos->setFormValue($objForm->GetValue("x_kd_pos"));
		}
		if (!$this->kd_propinsi->FldIsDetailKey) {
			$this->kd_propinsi->setFormValue($objForm->GetValue("x_kd_propinsi"));
		}
		if (!$this->telp->FldIsDetailKey) {
			$this->telp->setFormValue($objForm->GetValue("x_telp"));
		}
		if (!$this->telp_area->FldIsDetailKey) {
			$this->telp_area->setFormValue($objForm->GetValue("x_telp_area"));
		}
		if (!$this->hp->FldIsDetailKey) {
			$this->hp->setFormValue($objForm->GetValue("x_hp"));
		}
		if (!$this->alamat_dom->FldIsDetailKey) {
			$this->alamat_dom->setFormValue($objForm->GetValue("x_alamat_dom"));
		}
		if (!$this->kota_dom->FldIsDetailKey) {
			$this->kota_dom->setFormValue($objForm->GetValue("x_kota_dom"));
		}
		if (!$this->kd_pos_dom->FldIsDetailKey) {
			$this->kd_pos_dom->setFormValue($objForm->GetValue("x_kd_pos_dom"));
		}
		if (!$this->kd_propinsi_dom->FldIsDetailKey) {
			$this->kd_propinsi_dom->setFormValue($objForm->GetValue("x_kd_propinsi_dom"));
		}
		if (!$this->telp_dom->FldIsDetailKey) {
			$this->telp_dom->setFormValue($objForm->GetValue("x_telp_dom"));
		}
		if (!$this->telp_dom_area->FldIsDetailKey) {
			$this->telp_dom_area->setFormValue($objForm->GetValue("x_telp_dom_area"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->kd_st_emp->FldIsDetailKey) {
			$this->kd_st_emp->setFormValue($objForm->GetValue("x_kd_st_emp"));
		}
		if (!$this->skala->FldIsDetailKey) {
			$this->skala->setFormValue($objForm->GetValue("x_skala"));
		}
		if (!$this->gp->FldIsDetailKey) {
			$this->gp->setFormValue($objForm->GetValue("x_gp"));
		}
		if (!$this->upah_tetap->FldIsDetailKey) {
			$this->upah_tetap->setFormValue($objForm->GetValue("x_upah_tetap"));
		}
		if (!$this->tgl_honor->FldIsDetailKey) {
			$this->tgl_honor->setFormValue($objForm->GetValue("x_tgl_honor"));
			$this->tgl_honor->CurrentValue = ew_UnFormatDateTime($this->tgl_honor->CurrentValue, 0);
		}
		if (!$this->honor->FldIsDetailKey) {
			$this->honor->setFormValue($objForm->GetValue("x_honor"));
		}
		if (!$this->premi_honor->FldIsDetailKey) {
			$this->premi_honor->setFormValue($objForm->GetValue("x_premi_honor"));
		}
		if (!$this->tgl_gp->FldIsDetailKey) {
			$this->tgl_gp->setFormValue($objForm->GetValue("x_tgl_gp"));
			$this->tgl_gp->CurrentValue = ew_UnFormatDateTime($this->tgl_gp->CurrentValue, 0);
		}
		if (!$this->skala_95->FldIsDetailKey) {
			$this->skala_95->setFormValue($objForm->GetValue("x_skala_95"));
		}
		if (!$this->gp_95->FldIsDetailKey) {
			$this->gp_95->setFormValue($objForm->GetValue("x_gp_95"));
		}
		if (!$this->tgl_gp_95->FldIsDetailKey) {
			$this->tgl_gp_95->setFormValue($objForm->GetValue("x_tgl_gp_95"));
			$this->tgl_gp_95->CurrentValue = ew_UnFormatDateTime($this->tgl_gp_95->CurrentValue, 0);
		}
		if (!$this->kd_indx->FldIsDetailKey) {
			$this->kd_indx->setFormValue($objForm->GetValue("x_kd_indx"));
		}
		if (!$this->indx_lok->FldIsDetailKey) {
			$this->indx_lok->setFormValue($objForm->GetValue("x_indx_lok"));
		}
		if (!$this->gol_darah->FldIsDetailKey) {
			$this->gol_darah->setFormValue($objForm->GetValue("x_gol_darah"));
		}
		if (!$this->kd_jbt->FldIsDetailKey) {
			$this->kd_jbt->setFormValue($objForm->GetValue("x_kd_jbt"));
		}
		if (!$this->tgl_kd_jbt->FldIsDetailKey) {
			$this->tgl_kd_jbt->setFormValue($objForm->GetValue("x_tgl_kd_jbt"));
			$this->tgl_kd_jbt->CurrentValue = ew_UnFormatDateTime($this->tgl_kd_jbt->CurrentValue, 0);
		}
		if (!$this->kd_jbt_pgs->FldIsDetailKey) {
			$this->kd_jbt_pgs->setFormValue($objForm->GetValue("x_kd_jbt_pgs"));
		}
		if (!$this->tgl_kd_jbt_pgs->FldIsDetailKey) {
			$this->tgl_kd_jbt_pgs->setFormValue($objForm->GetValue("x_tgl_kd_jbt_pgs"));
			$this->tgl_kd_jbt_pgs->CurrentValue = ew_UnFormatDateTime($this->tgl_kd_jbt_pgs->CurrentValue, 0);
		}
		if (!$this->kd_jbt_pjs->FldIsDetailKey) {
			$this->kd_jbt_pjs->setFormValue($objForm->GetValue("x_kd_jbt_pjs"));
		}
		if (!$this->tgl_kd_jbt_pjs->FldIsDetailKey) {
			$this->tgl_kd_jbt_pjs->setFormValue($objForm->GetValue("x_tgl_kd_jbt_pjs"));
			$this->tgl_kd_jbt_pjs->CurrentValue = ew_UnFormatDateTime($this->tgl_kd_jbt_pjs->CurrentValue, 0);
		}
		if (!$this->kd_jbt_ps->FldIsDetailKey) {
			$this->kd_jbt_ps->setFormValue($objForm->GetValue("x_kd_jbt_ps"));
		}
		if (!$this->tgl_kd_jbt_ps->FldIsDetailKey) {
			$this->tgl_kd_jbt_ps->setFormValue($objForm->GetValue("x_tgl_kd_jbt_ps"));
			$this->tgl_kd_jbt_ps->CurrentValue = ew_UnFormatDateTime($this->tgl_kd_jbt_ps->CurrentValue, 0);
		}
		if (!$this->kd_pat->FldIsDetailKey) {
			$this->kd_pat->setFormValue($objForm->GetValue("x_kd_pat"));
		}
		if (!$this->kd_gas->FldIsDetailKey) {
			$this->kd_gas->setFormValue($objForm->GetValue("x_kd_gas"));
		}
		if (!$this->pimp_empid->FldIsDetailKey) {
			$this->pimp_empid->setFormValue($objForm->GetValue("x_pimp_empid"));
		}
		if (!$this->stshift->FldIsDetailKey) {
			$this->stshift->setFormValue($objForm->GetValue("x_stshift"));
		}
		if (!$this->no_rek->FldIsDetailKey) {
			$this->no_rek->setFormValue($objForm->GetValue("x_no_rek"));
		}
		if (!$this->kd_bank->FldIsDetailKey) {
			$this->kd_bank->setFormValue($objForm->GetValue("x_kd_bank"));
		}
		if (!$this->kd_jamsostek->FldIsDetailKey) {
			$this->kd_jamsostek->setFormValue($objForm->GetValue("x_kd_jamsostek"));
		}
		if (!$this->acc_astek->FldIsDetailKey) {
			$this->acc_astek->setFormValue($objForm->GetValue("x_acc_astek"));
		}
		if (!$this->acc_dapens->FldIsDetailKey) {
			$this->acc_dapens->setFormValue($objForm->GetValue("x_acc_dapens"));
		}
		if (!$this->acc_kes->FldIsDetailKey) {
			$this->acc_kes->setFormValue($objForm->GetValue("x_acc_kes"));
		}
		if (!$this->st->FldIsDetailKey) {
			$this->st->setFormValue($objForm->GetValue("x_st"));
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
		if (!$this->fgr_print_id->FldIsDetailKey) {
			$this->fgr_print_id->setFormValue($objForm->GetValue("x_fgr_print_id"));
		}
		if (!$this->kd_jbt_eselon->FldIsDetailKey) {
			$this->kd_jbt_eselon->setFormValue($objForm->GetValue("x_kd_jbt_eselon"));
		}
		if (!$this->npwp->FldIsDetailKey) {
			$this->npwp->setFormValue($objForm->GetValue("x_npwp"));
		}
		if (!$this->tgl_keluar->FldIsDetailKey) {
			$this->tgl_keluar->setFormValue($objForm->GetValue("x_tgl_keluar"));
			$this->tgl_keluar->CurrentValue = ew_UnFormatDateTime($this->tgl_keluar->CurrentValue, 0);
		}
		if (!$this->nama_nasabah->FldIsDetailKey) {
			$this->nama_nasabah->setFormValue($objForm->GetValue("x_nama_nasabah"));
		}
		if (!$this->no_ktp->FldIsDetailKey) {
			$this->no_ktp->setFormValue($objForm->GetValue("x_no_ktp"));
		}
		if (!$this->no_kokar->FldIsDetailKey) {
			$this->no_kokar->setFormValue($objForm->GetValue("x_no_kokar"));
		}
		if (!$this->no_bmw->FldIsDetailKey) {
			$this->no_bmw->setFormValue($objForm->GetValue("x_no_bmw"));
		}
		if (!$this->no_bpjs_ketenagakerjaan->FldIsDetailKey) {
			$this->no_bpjs_ketenagakerjaan->setFormValue($objForm->GetValue("x_no_bpjs_ketenagakerjaan"));
		}
		if (!$this->no_bpjs_kesehatan->FldIsDetailKey) {
			$this->no_bpjs_kesehatan->setFormValue($objForm->GetValue("x_no_bpjs_kesehatan"));
		}
		if (!$this->eselon->FldIsDetailKey) {
			$this->eselon->setFormValue($objForm->GetValue("x_eselon"));
		}
		if (!$this->kd_jenjang->FldIsDetailKey) {
			$this->kd_jenjang->setFormValue($objForm->GetValue("x_kd_jenjang"));
		}
		if (!$this->kd_jbt_esl->FldIsDetailKey) {
			$this->kd_jbt_esl->setFormValue($objForm->GetValue("x_kd_jbt_esl"));
		}
		if (!$this->tgl_jbt_esl->FldIsDetailKey) {
			$this->tgl_jbt_esl->setFormValue($objForm->GetValue("x_tgl_jbt_esl"));
			$this->tgl_jbt_esl->CurrentValue = ew_UnFormatDateTime($this->tgl_jbt_esl->CurrentValue, 0);
		}
		if (!$this->org_id->FldIsDetailKey) {
			$this->org_id->setFormValue($objForm->GetValue("x_org_id"));
		}
		if (!$this->kd_payroll->FldIsDetailKey) {
			$this->kd_payroll->setFormValue($objForm->GetValue("x_kd_payroll"));
		}
		if (!$this->id_wn->FldIsDetailKey) {
			$this->id_wn->setFormValue($objForm->GetValue("x_id_wn"));
		}
		if (!$this->no_anggota_kkms->FldIsDetailKey) {
			$this->no_anggota_kkms->setFormValue($objForm->GetValue("x_no_anggota_kkms"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->employee_id->CurrentValue = $this->employee_id->FormValue;
		$this->first_name->CurrentValue = $this->first_name->FormValue;
		$this->last_name->CurrentValue = $this->last_name->FormValue;
		$this->first_title->CurrentValue = $this->first_title->FormValue;
		$this->last_title->CurrentValue = $this->last_title->FormValue;
		$this->init->CurrentValue = $this->init->FormValue;
		$this->tpt_lahir->CurrentValue = $this->tpt_lahir->FormValue;
		$this->tgl_lahir->CurrentValue = $this->tgl_lahir->FormValue;
		$this->tgl_lahir->CurrentValue = ew_UnFormatDateTime($this->tgl_lahir->CurrentValue, 0);
		$this->jk->CurrentValue = $this->jk->FormValue;
		$this->kd_agama->CurrentValue = $this->kd_agama->FormValue;
		$this->tgl_masuk->CurrentValue = $this->tgl_masuk->FormValue;
		$this->tgl_masuk->CurrentValue = ew_UnFormatDateTime($this->tgl_masuk->CurrentValue, 0);
		$this->tpt_masuk->CurrentValue = $this->tpt_masuk->FormValue;
		$this->stkel->CurrentValue = $this->stkel->FormValue;
		$this->alamat->CurrentValue = $this->alamat->FormValue;
		$this->kota->CurrentValue = $this->kota->FormValue;
		$this->kd_pos->CurrentValue = $this->kd_pos->FormValue;
		$this->kd_propinsi->CurrentValue = $this->kd_propinsi->FormValue;
		$this->telp->CurrentValue = $this->telp->FormValue;
		$this->telp_area->CurrentValue = $this->telp_area->FormValue;
		$this->hp->CurrentValue = $this->hp->FormValue;
		$this->alamat_dom->CurrentValue = $this->alamat_dom->FormValue;
		$this->kota_dom->CurrentValue = $this->kota_dom->FormValue;
		$this->kd_pos_dom->CurrentValue = $this->kd_pos_dom->FormValue;
		$this->kd_propinsi_dom->CurrentValue = $this->kd_propinsi_dom->FormValue;
		$this->telp_dom->CurrentValue = $this->telp_dom->FormValue;
		$this->telp_dom_area->CurrentValue = $this->telp_dom_area->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->kd_st_emp->CurrentValue = $this->kd_st_emp->FormValue;
		$this->skala->CurrentValue = $this->skala->FormValue;
		$this->gp->CurrentValue = $this->gp->FormValue;
		$this->upah_tetap->CurrentValue = $this->upah_tetap->FormValue;
		$this->tgl_honor->CurrentValue = $this->tgl_honor->FormValue;
		$this->tgl_honor->CurrentValue = ew_UnFormatDateTime($this->tgl_honor->CurrentValue, 0);
		$this->honor->CurrentValue = $this->honor->FormValue;
		$this->premi_honor->CurrentValue = $this->premi_honor->FormValue;
		$this->tgl_gp->CurrentValue = $this->tgl_gp->FormValue;
		$this->tgl_gp->CurrentValue = ew_UnFormatDateTime($this->tgl_gp->CurrentValue, 0);
		$this->skala_95->CurrentValue = $this->skala_95->FormValue;
		$this->gp_95->CurrentValue = $this->gp_95->FormValue;
		$this->tgl_gp_95->CurrentValue = $this->tgl_gp_95->FormValue;
		$this->tgl_gp_95->CurrentValue = ew_UnFormatDateTime($this->tgl_gp_95->CurrentValue, 0);
		$this->kd_indx->CurrentValue = $this->kd_indx->FormValue;
		$this->indx_lok->CurrentValue = $this->indx_lok->FormValue;
		$this->gol_darah->CurrentValue = $this->gol_darah->FormValue;
		$this->kd_jbt->CurrentValue = $this->kd_jbt->FormValue;
		$this->tgl_kd_jbt->CurrentValue = $this->tgl_kd_jbt->FormValue;
		$this->tgl_kd_jbt->CurrentValue = ew_UnFormatDateTime($this->tgl_kd_jbt->CurrentValue, 0);
		$this->kd_jbt_pgs->CurrentValue = $this->kd_jbt_pgs->FormValue;
		$this->tgl_kd_jbt_pgs->CurrentValue = $this->tgl_kd_jbt_pgs->FormValue;
		$this->tgl_kd_jbt_pgs->CurrentValue = ew_UnFormatDateTime($this->tgl_kd_jbt_pgs->CurrentValue, 0);
		$this->kd_jbt_pjs->CurrentValue = $this->kd_jbt_pjs->FormValue;
		$this->tgl_kd_jbt_pjs->CurrentValue = $this->tgl_kd_jbt_pjs->FormValue;
		$this->tgl_kd_jbt_pjs->CurrentValue = ew_UnFormatDateTime($this->tgl_kd_jbt_pjs->CurrentValue, 0);
		$this->kd_jbt_ps->CurrentValue = $this->kd_jbt_ps->FormValue;
		$this->tgl_kd_jbt_ps->CurrentValue = $this->tgl_kd_jbt_ps->FormValue;
		$this->tgl_kd_jbt_ps->CurrentValue = ew_UnFormatDateTime($this->tgl_kd_jbt_ps->CurrentValue, 0);
		$this->kd_pat->CurrentValue = $this->kd_pat->FormValue;
		$this->kd_gas->CurrentValue = $this->kd_gas->FormValue;
		$this->pimp_empid->CurrentValue = $this->pimp_empid->FormValue;
		$this->stshift->CurrentValue = $this->stshift->FormValue;
		$this->no_rek->CurrentValue = $this->no_rek->FormValue;
		$this->kd_bank->CurrentValue = $this->kd_bank->FormValue;
		$this->kd_jamsostek->CurrentValue = $this->kd_jamsostek->FormValue;
		$this->acc_astek->CurrentValue = $this->acc_astek->FormValue;
		$this->acc_dapens->CurrentValue = $this->acc_dapens->FormValue;
		$this->acc_kes->CurrentValue = $this->acc_kes->FormValue;
		$this->st->CurrentValue = $this->st->FormValue;
		$this->created_by->CurrentValue = $this->created_by->FormValue;
		$this->created_date->CurrentValue = $this->created_date->FormValue;
		$this->created_date->CurrentValue = ew_UnFormatDateTime($this->created_date->CurrentValue, 0);
		$this->last_update_by->CurrentValue = $this->last_update_by->FormValue;
		$this->last_update_date->CurrentValue = $this->last_update_date->FormValue;
		$this->last_update_date->CurrentValue = ew_UnFormatDateTime($this->last_update_date->CurrentValue, 0);
		$this->fgr_print_id->CurrentValue = $this->fgr_print_id->FormValue;
		$this->kd_jbt_eselon->CurrentValue = $this->kd_jbt_eselon->FormValue;
		$this->npwp->CurrentValue = $this->npwp->FormValue;
		$this->tgl_keluar->CurrentValue = $this->tgl_keluar->FormValue;
		$this->tgl_keluar->CurrentValue = ew_UnFormatDateTime($this->tgl_keluar->CurrentValue, 0);
		$this->nama_nasabah->CurrentValue = $this->nama_nasabah->FormValue;
		$this->no_ktp->CurrentValue = $this->no_ktp->FormValue;
		$this->no_kokar->CurrentValue = $this->no_kokar->FormValue;
		$this->no_bmw->CurrentValue = $this->no_bmw->FormValue;
		$this->no_bpjs_ketenagakerjaan->CurrentValue = $this->no_bpjs_ketenagakerjaan->FormValue;
		$this->no_bpjs_kesehatan->CurrentValue = $this->no_bpjs_kesehatan->FormValue;
		$this->eselon->CurrentValue = $this->eselon->FormValue;
		$this->kd_jenjang->CurrentValue = $this->kd_jenjang->FormValue;
		$this->kd_jbt_esl->CurrentValue = $this->kd_jbt_esl->FormValue;
		$this->tgl_jbt_esl->CurrentValue = $this->tgl_jbt_esl->FormValue;
		$this->tgl_jbt_esl->CurrentValue = ew_UnFormatDateTime($this->tgl_jbt_esl->CurrentValue, 0);
		$this->org_id->CurrentValue = $this->org_id->FormValue;
		$this->kd_payroll->CurrentValue = $this->kd_payroll->FormValue;
		$this->id_wn->CurrentValue = $this->id_wn->FormValue;
		$this->no_anggota_kkms->CurrentValue = $this->no_anggota_kkms->FormValue;
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
		$this->employee_id->setDbValue($row['employee_id']);
		$this->first_name->setDbValue($row['first_name']);
		$this->last_name->setDbValue($row['last_name']);
		$this->first_title->setDbValue($row['first_title']);
		$this->last_title->setDbValue($row['last_title']);
		$this->init->setDbValue($row['init']);
		$this->tpt_lahir->setDbValue($row['tpt_lahir']);
		$this->tgl_lahir->setDbValue($row['tgl_lahir']);
		$this->jk->setDbValue($row['jk']);
		$this->kd_agama->setDbValue($row['kd_agama']);
		$this->tgl_masuk->setDbValue($row['tgl_masuk']);
		$this->tpt_masuk->setDbValue($row['tpt_masuk']);
		$this->stkel->setDbValue($row['stkel']);
		$this->alamat->setDbValue($row['alamat']);
		$this->kota->setDbValue($row['kota']);
		$this->kd_pos->setDbValue($row['kd_pos']);
		$this->kd_propinsi->setDbValue($row['kd_propinsi']);
		$this->telp->setDbValue($row['telp']);
		$this->telp_area->setDbValue($row['telp_area']);
		$this->hp->setDbValue($row['hp']);
		$this->alamat_dom->setDbValue($row['alamat_dom']);
		$this->kota_dom->setDbValue($row['kota_dom']);
		$this->kd_pos_dom->setDbValue($row['kd_pos_dom']);
		$this->kd_propinsi_dom->setDbValue($row['kd_propinsi_dom']);
		$this->telp_dom->setDbValue($row['telp_dom']);
		$this->telp_dom_area->setDbValue($row['telp_dom_area']);
		$this->_email->setDbValue($row['email']);
		$this->kd_st_emp->setDbValue($row['kd_st_emp']);
		$this->skala->setDbValue($row['skala']);
		$this->gp->setDbValue($row['gp']);
		$this->upah_tetap->setDbValue($row['upah_tetap']);
		$this->tgl_honor->setDbValue($row['tgl_honor']);
		$this->honor->setDbValue($row['honor']);
		$this->premi_honor->setDbValue($row['premi_honor']);
		$this->tgl_gp->setDbValue($row['tgl_gp']);
		$this->skala_95->setDbValue($row['skala_95']);
		$this->gp_95->setDbValue($row['gp_95']);
		$this->tgl_gp_95->setDbValue($row['tgl_gp_95']);
		$this->kd_indx->setDbValue($row['kd_indx']);
		$this->indx_lok->setDbValue($row['indx_lok']);
		$this->gol_darah->setDbValue($row['gol_darah']);
		$this->kd_jbt->setDbValue($row['kd_jbt']);
		$this->tgl_kd_jbt->setDbValue($row['tgl_kd_jbt']);
		$this->kd_jbt_pgs->setDbValue($row['kd_jbt_pgs']);
		$this->tgl_kd_jbt_pgs->setDbValue($row['tgl_kd_jbt_pgs']);
		$this->kd_jbt_pjs->setDbValue($row['kd_jbt_pjs']);
		$this->tgl_kd_jbt_pjs->setDbValue($row['tgl_kd_jbt_pjs']);
		$this->kd_jbt_ps->setDbValue($row['kd_jbt_ps']);
		$this->tgl_kd_jbt_ps->setDbValue($row['tgl_kd_jbt_ps']);
		$this->kd_pat->setDbValue($row['kd_pat']);
		$this->kd_gas->setDbValue($row['kd_gas']);
		$this->pimp_empid->setDbValue($row['pimp_empid']);
		$this->stshift->setDbValue($row['stshift']);
		$this->no_rek->setDbValue($row['no_rek']);
		$this->kd_bank->setDbValue($row['kd_bank']);
		$this->kd_jamsostek->setDbValue($row['kd_jamsostek']);
		$this->acc_astek->setDbValue($row['acc_astek']);
		$this->acc_dapens->setDbValue($row['acc_dapens']);
		$this->acc_kes->setDbValue($row['acc_kes']);
		$this->st->setDbValue($row['st']);
		$this->signature->Upload->DbValue = $row['signature'];
		if (is_array($this->signature->Upload->DbValue) || is_object($this->signature->Upload->DbValue)) // Byte array
			$this->signature->Upload->DbValue = ew_BytesToStr($this->signature->Upload->DbValue);
		$this->created_by->setDbValue($row['created_by']);
		$this->created_date->setDbValue($row['created_date']);
		$this->last_update_by->setDbValue($row['last_update_by']);
		$this->last_update_date->setDbValue($row['last_update_date']);
		$this->fgr_print_id->setDbValue($row['fgr_print_id']);
		$this->kd_jbt_eselon->setDbValue($row['kd_jbt_eselon']);
		$this->npwp->setDbValue($row['npwp']);
		$this->paraf->Upload->DbValue = $row['paraf'];
		if (is_array($this->paraf->Upload->DbValue) || is_object($this->paraf->Upload->DbValue)) // Byte array
			$this->paraf->Upload->DbValue = ew_BytesToStr($this->paraf->Upload->DbValue);
		$this->tgl_keluar->setDbValue($row['tgl_keluar']);
		$this->nama_nasabah->setDbValue($row['nama_nasabah']);
		$this->no_ktp->setDbValue($row['no_ktp']);
		$this->no_kokar->setDbValue($row['no_kokar']);
		$this->no_bmw->setDbValue($row['no_bmw']);
		$this->no_bpjs_ketenagakerjaan->setDbValue($row['no_bpjs_ketenagakerjaan']);
		$this->no_bpjs_kesehatan->setDbValue($row['no_bpjs_kesehatan']);
		$this->eselon->setDbValue($row['eselon']);
		$this->kd_jenjang->setDbValue($row['kd_jenjang']);
		$this->kd_jbt_esl->setDbValue($row['kd_jbt_esl']);
		$this->tgl_jbt_esl->setDbValue($row['tgl_jbt_esl']);
		$this->org_id->setDbValue($row['org_id']);
		$this->picture->Upload->DbValue = $row['picture'];
		if (is_array($this->picture->Upload->DbValue) || is_object($this->picture->Upload->DbValue)) // Byte array
			$this->picture->Upload->DbValue = ew_BytesToStr($this->picture->Upload->DbValue);
		$this->kd_payroll->setDbValue($row['kd_payroll']);
		$this->id_wn->setDbValue($row['id_wn']);
		$this->no_anggota_kkms->setDbValue($row['no_anggota_kkms']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['employee_id'] = NULL;
		$row['first_name'] = NULL;
		$row['last_name'] = NULL;
		$row['first_title'] = NULL;
		$row['last_title'] = NULL;
		$row['init'] = NULL;
		$row['tpt_lahir'] = NULL;
		$row['tgl_lahir'] = NULL;
		$row['jk'] = NULL;
		$row['kd_agama'] = NULL;
		$row['tgl_masuk'] = NULL;
		$row['tpt_masuk'] = NULL;
		$row['stkel'] = NULL;
		$row['alamat'] = NULL;
		$row['kota'] = NULL;
		$row['kd_pos'] = NULL;
		$row['kd_propinsi'] = NULL;
		$row['telp'] = NULL;
		$row['telp_area'] = NULL;
		$row['hp'] = NULL;
		$row['alamat_dom'] = NULL;
		$row['kota_dom'] = NULL;
		$row['kd_pos_dom'] = NULL;
		$row['kd_propinsi_dom'] = NULL;
		$row['telp_dom'] = NULL;
		$row['telp_dom_area'] = NULL;
		$row['email'] = NULL;
		$row['kd_st_emp'] = NULL;
		$row['skala'] = NULL;
		$row['gp'] = NULL;
		$row['upah_tetap'] = NULL;
		$row['tgl_honor'] = NULL;
		$row['honor'] = NULL;
		$row['premi_honor'] = NULL;
		$row['tgl_gp'] = NULL;
		$row['skala_95'] = NULL;
		$row['gp_95'] = NULL;
		$row['tgl_gp_95'] = NULL;
		$row['kd_indx'] = NULL;
		$row['indx_lok'] = NULL;
		$row['gol_darah'] = NULL;
		$row['kd_jbt'] = NULL;
		$row['tgl_kd_jbt'] = NULL;
		$row['kd_jbt_pgs'] = NULL;
		$row['tgl_kd_jbt_pgs'] = NULL;
		$row['kd_jbt_pjs'] = NULL;
		$row['tgl_kd_jbt_pjs'] = NULL;
		$row['kd_jbt_ps'] = NULL;
		$row['tgl_kd_jbt_ps'] = NULL;
		$row['kd_pat'] = NULL;
		$row['kd_gas'] = NULL;
		$row['pimp_empid'] = NULL;
		$row['stshift'] = NULL;
		$row['no_rek'] = NULL;
		$row['kd_bank'] = NULL;
		$row['kd_jamsostek'] = NULL;
		$row['acc_astek'] = NULL;
		$row['acc_dapens'] = NULL;
		$row['acc_kes'] = NULL;
		$row['st'] = NULL;
		$row['signature'] = NULL;
		$row['created_by'] = NULL;
		$row['created_date'] = NULL;
		$row['last_update_by'] = NULL;
		$row['last_update_date'] = NULL;
		$row['fgr_print_id'] = NULL;
		$row['kd_jbt_eselon'] = NULL;
		$row['npwp'] = NULL;
		$row['paraf'] = NULL;
		$row['tgl_keluar'] = NULL;
		$row['nama_nasabah'] = NULL;
		$row['no_ktp'] = NULL;
		$row['no_kokar'] = NULL;
		$row['no_bmw'] = NULL;
		$row['no_bpjs_ketenagakerjaan'] = NULL;
		$row['no_bpjs_kesehatan'] = NULL;
		$row['eselon'] = NULL;
		$row['kd_jenjang'] = NULL;
		$row['kd_jbt_esl'] = NULL;
		$row['tgl_jbt_esl'] = NULL;
		$row['org_id'] = NULL;
		$row['picture'] = NULL;
		$row['kd_payroll'] = NULL;
		$row['id_wn'] = NULL;
		$row['no_anggota_kkms'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->employee_id->DbValue = $row['employee_id'];
		$this->first_name->DbValue = $row['first_name'];
		$this->last_name->DbValue = $row['last_name'];
		$this->first_title->DbValue = $row['first_title'];
		$this->last_title->DbValue = $row['last_title'];
		$this->init->DbValue = $row['init'];
		$this->tpt_lahir->DbValue = $row['tpt_lahir'];
		$this->tgl_lahir->DbValue = $row['tgl_lahir'];
		$this->jk->DbValue = $row['jk'];
		$this->kd_agama->DbValue = $row['kd_agama'];
		$this->tgl_masuk->DbValue = $row['tgl_masuk'];
		$this->tpt_masuk->DbValue = $row['tpt_masuk'];
		$this->stkel->DbValue = $row['stkel'];
		$this->alamat->DbValue = $row['alamat'];
		$this->kota->DbValue = $row['kota'];
		$this->kd_pos->DbValue = $row['kd_pos'];
		$this->kd_propinsi->DbValue = $row['kd_propinsi'];
		$this->telp->DbValue = $row['telp'];
		$this->telp_area->DbValue = $row['telp_area'];
		$this->hp->DbValue = $row['hp'];
		$this->alamat_dom->DbValue = $row['alamat_dom'];
		$this->kota_dom->DbValue = $row['kota_dom'];
		$this->kd_pos_dom->DbValue = $row['kd_pos_dom'];
		$this->kd_propinsi_dom->DbValue = $row['kd_propinsi_dom'];
		$this->telp_dom->DbValue = $row['telp_dom'];
		$this->telp_dom_area->DbValue = $row['telp_dom_area'];
		$this->_email->DbValue = $row['email'];
		$this->kd_st_emp->DbValue = $row['kd_st_emp'];
		$this->skala->DbValue = $row['skala'];
		$this->gp->DbValue = $row['gp'];
		$this->upah_tetap->DbValue = $row['upah_tetap'];
		$this->tgl_honor->DbValue = $row['tgl_honor'];
		$this->honor->DbValue = $row['honor'];
		$this->premi_honor->DbValue = $row['premi_honor'];
		$this->tgl_gp->DbValue = $row['tgl_gp'];
		$this->skala_95->DbValue = $row['skala_95'];
		$this->gp_95->DbValue = $row['gp_95'];
		$this->tgl_gp_95->DbValue = $row['tgl_gp_95'];
		$this->kd_indx->DbValue = $row['kd_indx'];
		$this->indx_lok->DbValue = $row['indx_lok'];
		$this->gol_darah->DbValue = $row['gol_darah'];
		$this->kd_jbt->DbValue = $row['kd_jbt'];
		$this->tgl_kd_jbt->DbValue = $row['tgl_kd_jbt'];
		$this->kd_jbt_pgs->DbValue = $row['kd_jbt_pgs'];
		$this->tgl_kd_jbt_pgs->DbValue = $row['tgl_kd_jbt_pgs'];
		$this->kd_jbt_pjs->DbValue = $row['kd_jbt_pjs'];
		$this->tgl_kd_jbt_pjs->DbValue = $row['tgl_kd_jbt_pjs'];
		$this->kd_jbt_ps->DbValue = $row['kd_jbt_ps'];
		$this->tgl_kd_jbt_ps->DbValue = $row['tgl_kd_jbt_ps'];
		$this->kd_pat->DbValue = $row['kd_pat'];
		$this->kd_gas->DbValue = $row['kd_gas'];
		$this->pimp_empid->DbValue = $row['pimp_empid'];
		$this->stshift->DbValue = $row['stshift'];
		$this->no_rek->DbValue = $row['no_rek'];
		$this->kd_bank->DbValue = $row['kd_bank'];
		$this->kd_jamsostek->DbValue = $row['kd_jamsostek'];
		$this->acc_astek->DbValue = $row['acc_astek'];
		$this->acc_dapens->DbValue = $row['acc_dapens'];
		$this->acc_kes->DbValue = $row['acc_kes'];
		$this->st->DbValue = $row['st'];
		$this->signature->Upload->DbValue = $row['signature'];
		$this->created_by->DbValue = $row['created_by'];
		$this->created_date->DbValue = $row['created_date'];
		$this->last_update_by->DbValue = $row['last_update_by'];
		$this->last_update_date->DbValue = $row['last_update_date'];
		$this->fgr_print_id->DbValue = $row['fgr_print_id'];
		$this->kd_jbt_eselon->DbValue = $row['kd_jbt_eselon'];
		$this->npwp->DbValue = $row['npwp'];
		$this->paraf->Upload->DbValue = $row['paraf'];
		$this->tgl_keluar->DbValue = $row['tgl_keluar'];
		$this->nama_nasabah->DbValue = $row['nama_nasabah'];
		$this->no_ktp->DbValue = $row['no_ktp'];
		$this->no_kokar->DbValue = $row['no_kokar'];
		$this->no_bmw->DbValue = $row['no_bmw'];
		$this->no_bpjs_ketenagakerjaan->DbValue = $row['no_bpjs_ketenagakerjaan'];
		$this->no_bpjs_kesehatan->DbValue = $row['no_bpjs_kesehatan'];
		$this->eselon->DbValue = $row['eselon'];
		$this->kd_jenjang->DbValue = $row['kd_jenjang'];
		$this->kd_jbt_esl->DbValue = $row['kd_jbt_esl'];
		$this->tgl_jbt_esl->DbValue = $row['tgl_jbt_esl'];
		$this->org_id->DbValue = $row['org_id'];
		$this->picture->Upload->DbValue = $row['picture'];
		$this->kd_payroll->DbValue = $row['kd_payroll'];
		$this->id_wn->DbValue = $row['id_wn'];
		$this->no_anggota_kkms->DbValue = $row['no_anggota_kkms'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
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
		// Convert decimal values if posted back

		if ($this->gp->FormValue == $this->gp->CurrentValue && is_numeric(ew_StrToFloat($this->gp->CurrentValue)))
			$this->gp->CurrentValue = ew_StrToFloat($this->gp->CurrentValue);

		// Convert decimal values if posted back
		if ($this->upah_tetap->FormValue == $this->upah_tetap->CurrentValue && is_numeric(ew_StrToFloat($this->upah_tetap->CurrentValue)))
			$this->upah_tetap->CurrentValue = ew_StrToFloat($this->upah_tetap->CurrentValue);

		// Convert decimal values if posted back
		if ($this->honor->FormValue == $this->honor->CurrentValue && is_numeric(ew_StrToFloat($this->honor->CurrentValue)))
			$this->honor->CurrentValue = ew_StrToFloat($this->honor->CurrentValue);

		// Convert decimal values if posted back
		if ($this->premi_honor->FormValue == $this->premi_honor->CurrentValue && is_numeric(ew_StrToFloat($this->premi_honor->CurrentValue)))
			$this->premi_honor->CurrentValue = ew_StrToFloat($this->premi_honor->CurrentValue);

		// Convert decimal values if posted back
		if ($this->gp_95->FormValue == $this->gp_95->CurrentValue && is_numeric(ew_StrToFloat($this->gp_95->CurrentValue)))
			$this->gp_95->CurrentValue = ew_StrToFloat($this->gp_95->CurrentValue);

		// Convert decimal values if posted back
		if ($this->indx_lok->FormValue == $this->indx_lok->CurrentValue && is_numeric(ew_StrToFloat($this->indx_lok->CurrentValue)))
			$this->indx_lok->CurrentValue = ew_StrToFloat($this->indx_lok->CurrentValue);

		// Convert decimal values if posted back
		if ($this->fgr_print_id->FormValue == $this->fgr_print_id->CurrentValue && is_numeric(ew_StrToFloat($this->fgr_print_id->CurrentValue)))
			$this->fgr_print_id->CurrentValue = ew_StrToFloat($this->fgr_print_id->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// employee_id
			$this->employee_id->EditAttrs["class"] = "form-control";
			$this->employee_id->EditCustomAttributes = "";
			$this->employee_id->EditValue = $this->employee_id->CurrentValue;
			$this->employee_id->ViewCustomAttributes = "";

			// first_name
			$this->first_name->EditAttrs["class"] = "form-control";
			$this->first_name->EditCustomAttributes = "";
			$this->first_name->EditValue = ew_HtmlEncode($this->first_name->CurrentValue);
			$this->first_name->PlaceHolder = ew_RemoveHtml($this->first_name->FldCaption());

			// last_name
			$this->last_name->EditAttrs["class"] = "form-control";
			$this->last_name->EditCustomAttributes = "";
			$this->last_name->EditValue = ew_HtmlEncode($this->last_name->CurrentValue);
			$this->last_name->PlaceHolder = ew_RemoveHtml($this->last_name->FldCaption());

			// first_title
			$this->first_title->EditAttrs["class"] = "form-control";
			$this->first_title->EditCustomAttributes = "";
			$this->first_title->EditValue = ew_HtmlEncode($this->first_title->CurrentValue);
			$this->first_title->PlaceHolder = ew_RemoveHtml($this->first_title->FldCaption());

			// last_title
			$this->last_title->EditAttrs["class"] = "form-control";
			$this->last_title->EditCustomAttributes = "";
			$this->last_title->EditValue = ew_HtmlEncode($this->last_title->CurrentValue);
			$this->last_title->PlaceHolder = ew_RemoveHtml($this->last_title->FldCaption());

			// init
			$this->init->EditAttrs["class"] = "form-control";
			$this->init->EditCustomAttributes = "";
			$this->init->EditValue = ew_HtmlEncode($this->init->CurrentValue);
			$this->init->PlaceHolder = ew_RemoveHtml($this->init->FldCaption());

			// tpt_lahir
			$this->tpt_lahir->EditAttrs["class"] = "form-control";
			$this->tpt_lahir->EditCustomAttributes = "";
			$this->tpt_lahir->EditValue = ew_HtmlEncode($this->tpt_lahir->CurrentValue);
			$this->tpt_lahir->PlaceHolder = ew_RemoveHtml($this->tpt_lahir->FldCaption());

			// tgl_lahir
			$this->tgl_lahir->EditAttrs["class"] = "form-control";
			$this->tgl_lahir->EditCustomAttributes = "";
			$this->tgl_lahir->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_lahir->CurrentValue, 8));
			$this->tgl_lahir->PlaceHolder = ew_RemoveHtml($this->tgl_lahir->FldCaption());

			// jk
			$this->jk->EditAttrs["class"] = "form-control";
			$this->jk->EditCustomAttributes = "";
			$this->jk->EditValue = ew_HtmlEncode($this->jk->CurrentValue);
			$this->jk->PlaceHolder = ew_RemoveHtml($this->jk->FldCaption());

			// kd_agama
			$this->kd_agama->EditAttrs["class"] = "form-control";
			$this->kd_agama->EditCustomAttributes = "";
			$this->kd_agama->EditValue = ew_HtmlEncode($this->kd_agama->CurrentValue);
			$this->kd_agama->PlaceHolder = ew_RemoveHtml($this->kd_agama->FldCaption());

			// tgl_masuk
			$this->tgl_masuk->EditAttrs["class"] = "form-control";
			$this->tgl_masuk->EditCustomAttributes = "";
			$this->tgl_masuk->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_masuk->CurrentValue, 8));
			$this->tgl_masuk->PlaceHolder = ew_RemoveHtml($this->tgl_masuk->FldCaption());

			// tpt_masuk
			$this->tpt_masuk->EditAttrs["class"] = "form-control";
			$this->tpt_masuk->EditCustomAttributes = "";
			$this->tpt_masuk->EditValue = ew_HtmlEncode($this->tpt_masuk->CurrentValue);
			$this->tpt_masuk->PlaceHolder = ew_RemoveHtml($this->tpt_masuk->FldCaption());

			// stkel
			$this->stkel->EditAttrs["class"] = "form-control";
			$this->stkel->EditCustomAttributes = "";
			$this->stkel->EditValue = ew_HtmlEncode($this->stkel->CurrentValue);
			$this->stkel->PlaceHolder = ew_RemoveHtml($this->stkel->FldCaption());

			// alamat
			$this->alamat->EditAttrs["class"] = "form-control";
			$this->alamat->EditCustomAttributes = "";
			$this->alamat->EditValue = ew_HtmlEncode($this->alamat->CurrentValue);
			$this->alamat->PlaceHolder = ew_RemoveHtml($this->alamat->FldCaption());

			// kota
			$this->kota->EditAttrs["class"] = "form-control";
			$this->kota->EditCustomAttributes = "";
			$this->kota->EditValue = ew_HtmlEncode($this->kota->CurrentValue);
			$this->kota->PlaceHolder = ew_RemoveHtml($this->kota->FldCaption());

			// kd_pos
			$this->kd_pos->EditAttrs["class"] = "form-control";
			$this->kd_pos->EditCustomAttributes = "";
			$this->kd_pos->EditValue = ew_HtmlEncode($this->kd_pos->CurrentValue);
			$this->kd_pos->PlaceHolder = ew_RemoveHtml($this->kd_pos->FldCaption());

			// kd_propinsi
			$this->kd_propinsi->EditAttrs["class"] = "form-control";
			$this->kd_propinsi->EditCustomAttributes = "";
			$this->kd_propinsi->EditValue = ew_HtmlEncode($this->kd_propinsi->CurrentValue);
			$this->kd_propinsi->PlaceHolder = ew_RemoveHtml($this->kd_propinsi->FldCaption());

			// telp
			$this->telp->EditAttrs["class"] = "form-control";
			$this->telp->EditCustomAttributes = "";
			$this->telp->EditValue = ew_HtmlEncode($this->telp->CurrentValue);
			$this->telp->PlaceHolder = ew_RemoveHtml($this->telp->FldCaption());

			// telp_area
			$this->telp_area->EditAttrs["class"] = "form-control";
			$this->telp_area->EditCustomAttributes = "";
			$this->telp_area->EditValue = ew_HtmlEncode($this->telp_area->CurrentValue);
			$this->telp_area->PlaceHolder = ew_RemoveHtml($this->telp_area->FldCaption());

			// hp
			$this->hp->EditAttrs["class"] = "form-control";
			$this->hp->EditCustomAttributes = "";
			$this->hp->EditValue = ew_HtmlEncode($this->hp->CurrentValue);
			$this->hp->PlaceHolder = ew_RemoveHtml($this->hp->FldCaption());

			// alamat_dom
			$this->alamat_dom->EditAttrs["class"] = "form-control";
			$this->alamat_dom->EditCustomAttributes = "";
			$this->alamat_dom->EditValue = ew_HtmlEncode($this->alamat_dom->CurrentValue);
			$this->alamat_dom->PlaceHolder = ew_RemoveHtml($this->alamat_dom->FldCaption());

			// kota_dom
			$this->kota_dom->EditAttrs["class"] = "form-control";
			$this->kota_dom->EditCustomAttributes = "";
			$this->kota_dom->EditValue = ew_HtmlEncode($this->kota_dom->CurrentValue);
			$this->kota_dom->PlaceHolder = ew_RemoveHtml($this->kota_dom->FldCaption());

			// kd_pos_dom
			$this->kd_pos_dom->EditAttrs["class"] = "form-control";
			$this->kd_pos_dom->EditCustomAttributes = "";
			$this->kd_pos_dom->EditValue = ew_HtmlEncode($this->kd_pos_dom->CurrentValue);
			$this->kd_pos_dom->PlaceHolder = ew_RemoveHtml($this->kd_pos_dom->FldCaption());

			// kd_propinsi_dom
			$this->kd_propinsi_dom->EditAttrs["class"] = "form-control";
			$this->kd_propinsi_dom->EditCustomAttributes = "";
			$this->kd_propinsi_dom->EditValue = ew_HtmlEncode($this->kd_propinsi_dom->CurrentValue);
			$this->kd_propinsi_dom->PlaceHolder = ew_RemoveHtml($this->kd_propinsi_dom->FldCaption());

			// telp_dom
			$this->telp_dom->EditAttrs["class"] = "form-control";
			$this->telp_dom->EditCustomAttributes = "";
			$this->telp_dom->EditValue = ew_HtmlEncode($this->telp_dom->CurrentValue);
			$this->telp_dom->PlaceHolder = ew_RemoveHtml($this->telp_dom->FldCaption());

			// telp_dom_area
			$this->telp_dom_area->EditAttrs["class"] = "form-control";
			$this->telp_dom_area->EditCustomAttributes = "";
			$this->telp_dom_area->EditValue = ew_HtmlEncode($this->telp_dom_area->CurrentValue);
			$this->telp_dom_area->PlaceHolder = ew_RemoveHtml($this->telp_dom_area->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// kd_st_emp
			$this->kd_st_emp->EditAttrs["class"] = "form-control";
			$this->kd_st_emp->EditCustomAttributes = "";
			$this->kd_st_emp->EditValue = ew_HtmlEncode($this->kd_st_emp->CurrentValue);
			$this->kd_st_emp->PlaceHolder = ew_RemoveHtml($this->kd_st_emp->FldCaption());

			// skala
			$this->skala->EditAttrs["class"] = "form-control";
			$this->skala->EditCustomAttributes = "";
			$this->skala->EditValue = ew_HtmlEncode($this->skala->CurrentValue);
			$this->skala->PlaceHolder = ew_RemoveHtml($this->skala->FldCaption());

			// gp
			$this->gp->EditAttrs["class"] = "form-control";
			$this->gp->EditCustomAttributes = "";
			$this->gp->EditValue = ew_HtmlEncode($this->gp->CurrentValue);
			$this->gp->PlaceHolder = ew_RemoveHtml($this->gp->FldCaption());
			if (strval($this->gp->EditValue) <> "" && is_numeric($this->gp->EditValue)) $this->gp->EditValue = ew_FormatNumber($this->gp->EditValue, -2, -1, -2, 0);

			// upah_tetap
			$this->upah_tetap->EditAttrs["class"] = "form-control";
			$this->upah_tetap->EditCustomAttributes = "";
			$this->upah_tetap->EditValue = ew_HtmlEncode($this->upah_tetap->CurrentValue);
			$this->upah_tetap->PlaceHolder = ew_RemoveHtml($this->upah_tetap->FldCaption());
			if (strval($this->upah_tetap->EditValue) <> "" && is_numeric($this->upah_tetap->EditValue)) $this->upah_tetap->EditValue = ew_FormatNumber($this->upah_tetap->EditValue, -2, -1, -2, 0);

			// tgl_honor
			$this->tgl_honor->EditAttrs["class"] = "form-control";
			$this->tgl_honor->EditCustomAttributes = "";
			$this->tgl_honor->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_honor->CurrentValue, 8));
			$this->tgl_honor->PlaceHolder = ew_RemoveHtml($this->tgl_honor->FldCaption());

			// honor
			$this->honor->EditAttrs["class"] = "form-control";
			$this->honor->EditCustomAttributes = "";
			$this->honor->EditValue = ew_HtmlEncode($this->honor->CurrentValue);
			$this->honor->PlaceHolder = ew_RemoveHtml($this->honor->FldCaption());
			if (strval($this->honor->EditValue) <> "" && is_numeric($this->honor->EditValue)) $this->honor->EditValue = ew_FormatNumber($this->honor->EditValue, -2, -1, -2, 0);

			// premi_honor
			$this->premi_honor->EditAttrs["class"] = "form-control";
			$this->premi_honor->EditCustomAttributes = "";
			$this->premi_honor->EditValue = ew_HtmlEncode($this->premi_honor->CurrentValue);
			$this->premi_honor->PlaceHolder = ew_RemoveHtml($this->premi_honor->FldCaption());
			if (strval($this->premi_honor->EditValue) <> "" && is_numeric($this->premi_honor->EditValue)) $this->premi_honor->EditValue = ew_FormatNumber($this->premi_honor->EditValue, -2, -1, -2, 0);

			// tgl_gp
			$this->tgl_gp->EditAttrs["class"] = "form-control";
			$this->tgl_gp->EditCustomAttributes = "";
			$this->tgl_gp->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_gp->CurrentValue, 8));
			$this->tgl_gp->PlaceHolder = ew_RemoveHtml($this->tgl_gp->FldCaption());

			// skala_95
			$this->skala_95->EditAttrs["class"] = "form-control";
			$this->skala_95->EditCustomAttributes = "";
			$this->skala_95->EditValue = ew_HtmlEncode($this->skala_95->CurrentValue);
			$this->skala_95->PlaceHolder = ew_RemoveHtml($this->skala_95->FldCaption());

			// gp_95
			$this->gp_95->EditAttrs["class"] = "form-control";
			$this->gp_95->EditCustomAttributes = "";
			$this->gp_95->EditValue = ew_HtmlEncode($this->gp_95->CurrentValue);
			$this->gp_95->PlaceHolder = ew_RemoveHtml($this->gp_95->FldCaption());
			if (strval($this->gp_95->EditValue) <> "" && is_numeric($this->gp_95->EditValue)) $this->gp_95->EditValue = ew_FormatNumber($this->gp_95->EditValue, -2, -1, -2, 0);

			// tgl_gp_95
			$this->tgl_gp_95->EditAttrs["class"] = "form-control";
			$this->tgl_gp_95->EditCustomAttributes = "";
			$this->tgl_gp_95->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_gp_95->CurrentValue, 8));
			$this->tgl_gp_95->PlaceHolder = ew_RemoveHtml($this->tgl_gp_95->FldCaption());

			// kd_indx
			$this->kd_indx->EditAttrs["class"] = "form-control";
			$this->kd_indx->EditCustomAttributes = "";
			$this->kd_indx->EditValue = ew_HtmlEncode($this->kd_indx->CurrentValue);
			$this->kd_indx->PlaceHolder = ew_RemoveHtml($this->kd_indx->FldCaption());

			// indx_lok
			$this->indx_lok->EditAttrs["class"] = "form-control";
			$this->indx_lok->EditCustomAttributes = "";
			$this->indx_lok->EditValue = ew_HtmlEncode($this->indx_lok->CurrentValue);
			$this->indx_lok->PlaceHolder = ew_RemoveHtml($this->indx_lok->FldCaption());
			if (strval($this->indx_lok->EditValue) <> "" && is_numeric($this->indx_lok->EditValue)) $this->indx_lok->EditValue = ew_FormatNumber($this->indx_lok->EditValue, -2, -1, -2, 0);

			// gol_darah
			$this->gol_darah->EditAttrs["class"] = "form-control";
			$this->gol_darah->EditCustomAttributes = "";
			$this->gol_darah->EditValue = ew_HtmlEncode($this->gol_darah->CurrentValue);
			$this->gol_darah->PlaceHolder = ew_RemoveHtml($this->gol_darah->FldCaption());

			// kd_jbt
			$this->kd_jbt->EditAttrs["class"] = "form-control";
			$this->kd_jbt->EditCustomAttributes = "";
			$this->kd_jbt->EditValue = ew_HtmlEncode($this->kd_jbt->CurrentValue);
			$this->kd_jbt->PlaceHolder = ew_RemoveHtml($this->kd_jbt->FldCaption());

			// tgl_kd_jbt
			$this->tgl_kd_jbt->EditAttrs["class"] = "form-control";
			$this->tgl_kd_jbt->EditCustomAttributes = "";
			$this->tgl_kd_jbt->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_kd_jbt->CurrentValue, 8));
			$this->tgl_kd_jbt->PlaceHolder = ew_RemoveHtml($this->tgl_kd_jbt->FldCaption());

			// kd_jbt_pgs
			$this->kd_jbt_pgs->EditAttrs["class"] = "form-control";
			$this->kd_jbt_pgs->EditCustomAttributes = "";
			$this->kd_jbt_pgs->EditValue = ew_HtmlEncode($this->kd_jbt_pgs->CurrentValue);
			$this->kd_jbt_pgs->PlaceHolder = ew_RemoveHtml($this->kd_jbt_pgs->FldCaption());

			// tgl_kd_jbt_pgs
			$this->tgl_kd_jbt_pgs->EditAttrs["class"] = "form-control";
			$this->tgl_kd_jbt_pgs->EditCustomAttributes = "";
			$this->tgl_kd_jbt_pgs->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_kd_jbt_pgs->CurrentValue, 8));
			$this->tgl_kd_jbt_pgs->PlaceHolder = ew_RemoveHtml($this->tgl_kd_jbt_pgs->FldCaption());

			// kd_jbt_pjs
			$this->kd_jbt_pjs->EditAttrs["class"] = "form-control";
			$this->kd_jbt_pjs->EditCustomAttributes = "";
			$this->kd_jbt_pjs->EditValue = ew_HtmlEncode($this->kd_jbt_pjs->CurrentValue);
			$this->kd_jbt_pjs->PlaceHolder = ew_RemoveHtml($this->kd_jbt_pjs->FldCaption());

			// tgl_kd_jbt_pjs
			$this->tgl_kd_jbt_pjs->EditAttrs["class"] = "form-control";
			$this->tgl_kd_jbt_pjs->EditCustomAttributes = "";
			$this->tgl_kd_jbt_pjs->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_kd_jbt_pjs->CurrentValue, 8));
			$this->tgl_kd_jbt_pjs->PlaceHolder = ew_RemoveHtml($this->tgl_kd_jbt_pjs->FldCaption());

			// kd_jbt_ps
			$this->kd_jbt_ps->EditAttrs["class"] = "form-control";
			$this->kd_jbt_ps->EditCustomAttributes = "";
			$this->kd_jbt_ps->EditValue = ew_HtmlEncode($this->kd_jbt_ps->CurrentValue);
			$this->kd_jbt_ps->PlaceHolder = ew_RemoveHtml($this->kd_jbt_ps->FldCaption());

			// tgl_kd_jbt_ps
			$this->tgl_kd_jbt_ps->EditAttrs["class"] = "form-control";
			$this->tgl_kd_jbt_ps->EditCustomAttributes = "";
			$this->tgl_kd_jbt_ps->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_kd_jbt_ps->CurrentValue, 8));
			$this->tgl_kd_jbt_ps->PlaceHolder = ew_RemoveHtml($this->tgl_kd_jbt_ps->FldCaption());

			// kd_pat
			$this->kd_pat->EditAttrs["class"] = "form-control";
			$this->kd_pat->EditCustomAttributes = "";
			$this->kd_pat->EditValue = ew_HtmlEncode($this->kd_pat->CurrentValue);
			$this->kd_pat->PlaceHolder = ew_RemoveHtml($this->kd_pat->FldCaption());

			// kd_gas
			$this->kd_gas->EditAttrs["class"] = "form-control";
			$this->kd_gas->EditCustomAttributes = "";
			$this->kd_gas->EditValue = ew_HtmlEncode($this->kd_gas->CurrentValue);
			$this->kd_gas->PlaceHolder = ew_RemoveHtml($this->kd_gas->FldCaption());

			// pimp_empid
			$this->pimp_empid->EditAttrs["class"] = "form-control";
			$this->pimp_empid->EditCustomAttributes = "";
			$this->pimp_empid->EditValue = ew_HtmlEncode($this->pimp_empid->CurrentValue);
			$this->pimp_empid->PlaceHolder = ew_RemoveHtml($this->pimp_empid->FldCaption());

			// stshift
			$this->stshift->EditAttrs["class"] = "form-control";
			$this->stshift->EditCustomAttributes = "";
			$this->stshift->EditValue = ew_HtmlEncode($this->stshift->CurrentValue);
			$this->stshift->PlaceHolder = ew_RemoveHtml($this->stshift->FldCaption());

			// no_rek
			$this->no_rek->EditAttrs["class"] = "form-control";
			$this->no_rek->EditCustomAttributes = "";
			$this->no_rek->EditValue = ew_HtmlEncode($this->no_rek->CurrentValue);
			$this->no_rek->PlaceHolder = ew_RemoveHtml($this->no_rek->FldCaption());

			// kd_bank
			$this->kd_bank->EditAttrs["class"] = "form-control";
			$this->kd_bank->EditCustomAttributes = "";
			$this->kd_bank->EditValue = ew_HtmlEncode($this->kd_bank->CurrentValue);
			$this->kd_bank->PlaceHolder = ew_RemoveHtml($this->kd_bank->FldCaption());

			// kd_jamsostek
			$this->kd_jamsostek->EditAttrs["class"] = "form-control";
			$this->kd_jamsostek->EditCustomAttributes = "";
			$this->kd_jamsostek->EditValue = ew_HtmlEncode($this->kd_jamsostek->CurrentValue);
			$this->kd_jamsostek->PlaceHolder = ew_RemoveHtml($this->kd_jamsostek->FldCaption());

			// acc_astek
			$this->acc_astek->EditAttrs["class"] = "form-control";
			$this->acc_astek->EditCustomAttributes = "";
			$this->acc_astek->EditValue = ew_HtmlEncode($this->acc_astek->CurrentValue);
			$this->acc_astek->PlaceHolder = ew_RemoveHtml($this->acc_astek->FldCaption());

			// acc_dapens
			$this->acc_dapens->EditAttrs["class"] = "form-control";
			$this->acc_dapens->EditCustomAttributes = "";
			$this->acc_dapens->EditValue = ew_HtmlEncode($this->acc_dapens->CurrentValue);
			$this->acc_dapens->PlaceHolder = ew_RemoveHtml($this->acc_dapens->FldCaption());

			// acc_kes
			$this->acc_kes->EditAttrs["class"] = "form-control";
			$this->acc_kes->EditCustomAttributes = "";
			$this->acc_kes->EditValue = ew_HtmlEncode($this->acc_kes->CurrentValue);
			$this->acc_kes->PlaceHolder = ew_RemoveHtml($this->acc_kes->FldCaption());

			// st
			$this->st->EditAttrs["class"] = "form-control";
			$this->st->EditCustomAttributes = "";
			$this->st->EditValue = ew_HtmlEncode($this->st->CurrentValue);
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
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->signature);

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

			// fgr_print_id
			$this->fgr_print_id->EditAttrs["class"] = "form-control";
			$this->fgr_print_id->EditCustomAttributes = "";
			$this->fgr_print_id->EditValue = ew_HtmlEncode($this->fgr_print_id->CurrentValue);
			$this->fgr_print_id->PlaceHolder = ew_RemoveHtml($this->fgr_print_id->FldCaption());
			if (strval($this->fgr_print_id->EditValue) <> "" && is_numeric($this->fgr_print_id->EditValue)) $this->fgr_print_id->EditValue = ew_FormatNumber($this->fgr_print_id->EditValue, -2, -1, -2, 0);

			// kd_jbt_eselon
			$this->kd_jbt_eselon->EditAttrs["class"] = "form-control";
			$this->kd_jbt_eselon->EditCustomAttributes = "";
			$this->kd_jbt_eselon->EditValue = ew_HtmlEncode($this->kd_jbt_eselon->CurrentValue);
			$this->kd_jbt_eselon->PlaceHolder = ew_RemoveHtml($this->kd_jbt_eselon->FldCaption());

			// npwp
			$this->npwp->EditAttrs["class"] = "form-control";
			$this->npwp->EditCustomAttributes = "";
			$this->npwp->EditValue = ew_HtmlEncode($this->npwp->CurrentValue);
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
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->paraf);

			// tgl_keluar
			$this->tgl_keluar->EditAttrs["class"] = "form-control";
			$this->tgl_keluar->EditCustomAttributes = "";
			$this->tgl_keluar->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_keluar->CurrentValue, 8));
			$this->tgl_keluar->PlaceHolder = ew_RemoveHtml($this->tgl_keluar->FldCaption());

			// nama_nasabah
			$this->nama_nasabah->EditAttrs["class"] = "form-control";
			$this->nama_nasabah->EditCustomAttributes = "";
			$this->nama_nasabah->EditValue = ew_HtmlEncode($this->nama_nasabah->CurrentValue);
			$this->nama_nasabah->PlaceHolder = ew_RemoveHtml($this->nama_nasabah->FldCaption());

			// no_ktp
			$this->no_ktp->EditAttrs["class"] = "form-control";
			$this->no_ktp->EditCustomAttributes = "";
			$this->no_ktp->EditValue = ew_HtmlEncode($this->no_ktp->CurrentValue);
			$this->no_ktp->PlaceHolder = ew_RemoveHtml($this->no_ktp->FldCaption());

			// no_kokar
			$this->no_kokar->EditAttrs["class"] = "form-control";
			$this->no_kokar->EditCustomAttributes = "";
			$this->no_kokar->EditValue = ew_HtmlEncode($this->no_kokar->CurrentValue);
			$this->no_kokar->PlaceHolder = ew_RemoveHtml($this->no_kokar->FldCaption());

			// no_bmw
			$this->no_bmw->EditAttrs["class"] = "form-control";
			$this->no_bmw->EditCustomAttributes = "";
			$this->no_bmw->EditValue = ew_HtmlEncode($this->no_bmw->CurrentValue);
			$this->no_bmw->PlaceHolder = ew_RemoveHtml($this->no_bmw->FldCaption());

			// no_bpjs_ketenagakerjaan
			$this->no_bpjs_ketenagakerjaan->EditAttrs["class"] = "form-control";
			$this->no_bpjs_ketenagakerjaan->EditCustomAttributes = "";
			$this->no_bpjs_ketenagakerjaan->EditValue = ew_HtmlEncode($this->no_bpjs_ketenagakerjaan->CurrentValue);
			$this->no_bpjs_ketenagakerjaan->PlaceHolder = ew_RemoveHtml($this->no_bpjs_ketenagakerjaan->FldCaption());

			// no_bpjs_kesehatan
			$this->no_bpjs_kesehatan->EditAttrs["class"] = "form-control";
			$this->no_bpjs_kesehatan->EditCustomAttributes = "";
			$this->no_bpjs_kesehatan->EditValue = ew_HtmlEncode($this->no_bpjs_kesehatan->CurrentValue);
			$this->no_bpjs_kesehatan->PlaceHolder = ew_RemoveHtml($this->no_bpjs_kesehatan->FldCaption());

			// eselon
			$this->eselon->EditAttrs["class"] = "form-control";
			$this->eselon->EditCustomAttributes = "";
			$this->eselon->EditValue = ew_HtmlEncode($this->eselon->CurrentValue);
			$this->eselon->PlaceHolder = ew_RemoveHtml($this->eselon->FldCaption());

			// kd_jenjang
			$this->kd_jenjang->EditAttrs["class"] = "form-control";
			$this->kd_jenjang->EditCustomAttributes = "";
			$this->kd_jenjang->EditValue = ew_HtmlEncode($this->kd_jenjang->CurrentValue);
			$this->kd_jenjang->PlaceHolder = ew_RemoveHtml($this->kd_jenjang->FldCaption());

			// kd_jbt_esl
			$this->kd_jbt_esl->EditAttrs["class"] = "form-control";
			$this->kd_jbt_esl->EditCustomAttributes = "";
			$this->kd_jbt_esl->EditValue = ew_HtmlEncode($this->kd_jbt_esl->CurrentValue);
			$this->kd_jbt_esl->PlaceHolder = ew_RemoveHtml($this->kd_jbt_esl->FldCaption());

			// tgl_jbt_esl
			$this->tgl_jbt_esl->EditAttrs["class"] = "form-control";
			$this->tgl_jbt_esl->EditCustomAttributes = "";
			$this->tgl_jbt_esl->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_jbt_esl->CurrentValue, 8));
			$this->tgl_jbt_esl->PlaceHolder = ew_RemoveHtml($this->tgl_jbt_esl->FldCaption());

			// org_id
			$this->org_id->EditAttrs["class"] = "form-control";
			$this->org_id->EditCustomAttributes = "";
			$this->org_id->EditValue = ew_HtmlEncode($this->org_id->CurrentValue);
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
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->picture);

			// kd_payroll
			$this->kd_payroll->EditAttrs["class"] = "form-control";
			$this->kd_payroll->EditCustomAttributes = "";
			$this->kd_payroll->EditValue = ew_HtmlEncode($this->kd_payroll->CurrentValue);
			$this->kd_payroll->PlaceHolder = ew_RemoveHtml($this->kd_payroll->FldCaption());

			// id_wn
			$this->id_wn->EditAttrs["class"] = "form-control";
			$this->id_wn->EditCustomAttributes = "";
			$this->id_wn->EditValue = ew_HtmlEncode($this->id_wn->CurrentValue);
			$this->id_wn->PlaceHolder = ew_RemoveHtml($this->id_wn->FldCaption());

			// no_anggota_kkms
			$this->no_anggota_kkms->EditAttrs["class"] = "form-control";
			$this->no_anggota_kkms->EditCustomAttributes = "";
			$this->no_anggota_kkms->EditValue = ew_HtmlEncode($this->no_anggota_kkms->CurrentValue);
			$this->no_anggota_kkms->PlaceHolder = ew_RemoveHtml($this->no_anggota_kkms->FldCaption());

			// Edit refer script
			// employee_id

			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";

			// first_name
			$this->first_name->LinkCustomAttributes = "";
			$this->first_name->HrefValue = "";

			// last_name
			$this->last_name->LinkCustomAttributes = "";
			$this->last_name->HrefValue = "";

			// first_title
			$this->first_title->LinkCustomAttributes = "";
			$this->first_title->HrefValue = "";

			// last_title
			$this->last_title->LinkCustomAttributes = "";
			$this->last_title->HrefValue = "";

			// init
			$this->init->LinkCustomAttributes = "";
			$this->init->HrefValue = "";

			// tpt_lahir
			$this->tpt_lahir->LinkCustomAttributes = "";
			$this->tpt_lahir->HrefValue = "";

			// tgl_lahir
			$this->tgl_lahir->LinkCustomAttributes = "";
			$this->tgl_lahir->HrefValue = "";

			// jk
			$this->jk->LinkCustomAttributes = "";
			$this->jk->HrefValue = "";

			// kd_agama
			$this->kd_agama->LinkCustomAttributes = "";
			$this->kd_agama->HrefValue = "";

			// tgl_masuk
			$this->tgl_masuk->LinkCustomAttributes = "";
			$this->tgl_masuk->HrefValue = "";

			// tpt_masuk
			$this->tpt_masuk->LinkCustomAttributes = "";
			$this->tpt_masuk->HrefValue = "";

			// stkel
			$this->stkel->LinkCustomAttributes = "";
			$this->stkel->HrefValue = "";

			// alamat
			$this->alamat->LinkCustomAttributes = "";
			$this->alamat->HrefValue = "";

			// kota
			$this->kota->LinkCustomAttributes = "";
			$this->kota->HrefValue = "";

			// kd_pos
			$this->kd_pos->LinkCustomAttributes = "";
			$this->kd_pos->HrefValue = "";

			// kd_propinsi
			$this->kd_propinsi->LinkCustomAttributes = "";
			$this->kd_propinsi->HrefValue = "";

			// telp
			$this->telp->LinkCustomAttributes = "";
			$this->telp->HrefValue = "";

			// telp_area
			$this->telp_area->LinkCustomAttributes = "";
			$this->telp_area->HrefValue = "";

			// hp
			$this->hp->LinkCustomAttributes = "";
			$this->hp->HrefValue = "";

			// alamat_dom
			$this->alamat_dom->LinkCustomAttributes = "";
			$this->alamat_dom->HrefValue = "";

			// kota_dom
			$this->kota_dom->LinkCustomAttributes = "";
			$this->kota_dom->HrefValue = "";

			// kd_pos_dom
			$this->kd_pos_dom->LinkCustomAttributes = "";
			$this->kd_pos_dom->HrefValue = "";

			// kd_propinsi_dom
			$this->kd_propinsi_dom->LinkCustomAttributes = "";
			$this->kd_propinsi_dom->HrefValue = "";

			// telp_dom
			$this->telp_dom->LinkCustomAttributes = "";
			$this->telp_dom->HrefValue = "";

			// telp_dom_area
			$this->telp_dom_area->LinkCustomAttributes = "";
			$this->telp_dom_area->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

			// kd_st_emp
			$this->kd_st_emp->LinkCustomAttributes = "";
			$this->kd_st_emp->HrefValue = "";

			// skala
			$this->skala->LinkCustomAttributes = "";
			$this->skala->HrefValue = "";

			// gp
			$this->gp->LinkCustomAttributes = "";
			$this->gp->HrefValue = "";

			// upah_tetap
			$this->upah_tetap->LinkCustomAttributes = "";
			$this->upah_tetap->HrefValue = "";

			// tgl_honor
			$this->tgl_honor->LinkCustomAttributes = "";
			$this->tgl_honor->HrefValue = "";

			// honor
			$this->honor->LinkCustomAttributes = "";
			$this->honor->HrefValue = "";

			// premi_honor
			$this->premi_honor->LinkCustomAttributes = "";
			$this->premi_honor->HrefValue = "";

			// tgl_gp
			$this->tgl_gp->LinkCustomAttributes = "";
			$this->tgl_gp->HrefValue = "";

			// skala_95
			$this->skala_95->LinkCustomAttributes = "";
			$this->skala_95->HrefValue = "";

			// gp_95
			$this->gp_95->LinkCustomAttributes = "";
			$this->gp_95->HrefValue = "";

			// tgl_gp_95
			$this->tgl_gp_95->LinkCustomAttributes = "";
			$this->tgl_gp_95->HrefValue = "";

			// kd_indx
			$this->kd_indx->LinkCustomAttributes = "";
			$this->kd_indx->HrefValue = "";

			// indx_lok
			$this->indx_lok->LinkCustomAttributes = "";
			$this->indx_lok->HrefValue = "";

			// gol_darah
			$this->gol_darah->LinkCustomAttributes = "";
			$this->gol_darah->HrefValue = "";

			// kd_jbt
			$this->kd_jbt->LinkCustomAttributes = "";
			$this->kd_jbt->HrefValue = "";

			// tgl_kd_jbt
			$this->tgl_kd_jbt->LinkCustomAttributes = "";
			$this->tgl_kd_jbt->HrefValue = "";

			// kd_jbt_pgs
			$this->kd_jbt_pgs->LinkCustomAttributes = "";
			$this->kd_jbt_pgs->HrefValue = "";

			// tgl_kd_jbt_pgs
			$this->tgl_kd_jbt_pgs->LinkCustomAttributes = "";
			$this->tgl_kd_jbt_pgs->HrefValue = "";

			// kd_jbt_pjs
			$this->kd_jbt_pjs->LinkCustomAttributes = "";
			$this->kd_jbt_pjs->HrefValue = "";

			// tgl_kd_jbt_pjs
			$this->tgl_kd_jbt_pjs->LinkCustomAttributes = "";
			$this->tgl_kd_jbt_pjs->HrefValue = "";

			// kd_jbt_ps
			$this->kd_jbt_ps->LinkCustomAttributes = "";
			$this->kd_jbt_ps->HrefValue = "";

			// tgl_kd_jbt_ps
			$this->tgl_kd_jbt_ps->LinkCustomAttributes = "";
			$this->tgl_kd_jbt_ps->HrefValue = "";

			// kd_pat
			$this->kd_pat->LinkCustomAttributes = "";
			$this->kd_pat->HrefValue = "";

			// kd_gas
			$this->kd_gas->LinkCustomAttributes = "";
			$this->kd_gas->HrefValue = "";

			// pimp_empid
			$this->pimp_empid->LinkCustomAttributes = "";
			$this->pimp_empid->HrefValue = "";

			// stshift
			$this->stshift->LinkCustomAttributes = "";
			$this->stshift->HrefValue = "";

			// no_rek
			$this->no_rek->LinkCustomAttributes = "";
			$this->no_rek->HrefValue = "";

			// kd_bank
			$this->kd_bank->LinkCustomAttributes = "";
			$this->kd_bank->HrefValue = "";

			// kd_jamsostek
			$this->kd_jamsostek->LinkCustomAttributes = "";
			$this->kd_jamsostek->HrefValue = "";

			// acc_astek
			$this->acc_astek->LinkCustomAttributes = "";
			$this->acc_astek->HrefValue = "";

			// acc_dapens
			$this->acc_dapens->LinkCustomAttributes = "";
			$this->acc_dapens->HrefValue = "";

			// acc_kes
			$this->acc_kes->LinkCustomAttributes = "";
			$this->acc_kes->HrefValue = "";

			// st
			$this->st->LinkCustomAttributes = "";
			$this->st->HrefValue = "";

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

			// fgr_print_id
			$this->fgr_print_id->LinkCustomAttributes = "";
			$this->fgr_print_id->HrefValue = "";

			// kd_jbt_eselon
			$this->kd_jbt_eselon->LinkCustomAttributes = "";
			$this->kd_jbt_eselon->HrefValue = "";

			// npwp
			$this->npwp->LinkCustomAttributes = "";
			$this->npwp->HrefValue = "";

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

			// tgl_keluar
			$this->tgl_keluar->LinkCustomAttributes = "";
			$this->tgl_keluar->HrefValue = "";

			// nama_nasabah
			$this->nama_nasabah->LinkCustomAttributes = "";
			$this->nama_nasabah->HrefValue = "";

			// no_ktp
			$this->no_ktp->LinkCustomAttributes = "";
			$this->no_ktp->HrefValue = "";

			// no_kokar
			$this->no_kokar->LinkCustomAttributes = "";
			$this->no_kokar->HrefValue = "";

			// no_bmw
			$this->no_bmw->LinkCustomAttributes = "";
			$this->no_bmw->HrefValue = "";

			// no_bpjs_ketenagakerjaan
			$this->no_bpjs_ketenagakerjaan->LinkCustomAttributes = "";
			$this->no_bpjs_ketenagakerjaan->HrefValue = "";

			// no_bpjs_kesehatan
			$this->no_bpjs_kesehatan->LinkCustomAttributes = "";
			$this->no_bpjs_kesehatan->HrefValue = "";

			// eselon
			$this->eselon->LinkCustomAttributes = "";
			$this->eselon->HrefValue = "";

			// kd_jenjang
			$this->kd_jenjang->LinkCustomAttributes = "";
			$this->kd_jenjang->HrefValue = "";

			// kd_jbt_esl
			$this->kd_jbt_esl->LinkCustomAttributes = "";
			$this->kd_jbt_esl->HrefValue = "";

			// tgl_jbt_esl
			$this->tgl_jbt_esl->LinkCustomAttributes = "";
			$this->tgl_jbt_esl->HrefValue = "";

			// org_id
			$this->org_id->LinkCustomAttributes = "";
			$this->org_id->HrefValue = "";

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

			// kd_payroll
			$this->kd_payroll->LinkCustomAttributes = "";
			$this->kd_payroll->HrefValue = "";

			// id_wn
			$this->id_wn->LinkCustomAttributes = "";
			$this->id_wn->HrefValue = "";

			// no_anggota_kkms
			$this->no_anggota_kkms->LinkCustomAttributes = "";
			$this->no_anggota_kkms->HrefValue = "";
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
		if (!ew_CheckDateDef($this->tgl_lahir->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_lahir->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_masuk->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_masuk->FldErrMsg());
		}
		if (!ew_CheckNumber($this->gp->FormValue)) {
			ew_AddMessage($gsFormError, $this->gp->FldErrMsg());
		}
		if (!ew_CheckNumber($this->upah_tetap->FormValue)) {
			ew_AddMessage($gsFormError, $this->upah_tetap->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_honor->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_honor->FldErrMsg());
		}
		if (!ew_CheckNumber($this->honor->FormValue)) {
			ew_AddMessage($gsFormError, $this->honor->FldErrMsg());
		}
		if (!ew_CheckNumber($this->premi_honor->FormValue)) {
			ew_AddMessage($gsFormError, $this->premi_honor->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_gp->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_gp->FldErrMsg());
		}
		if (!ew_CheckNumber($this->gp_95->FormValue)) {
			ew_AddMessage($gsFormError, $this->gp_95->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_gp_95->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_gp_95->FldErrMsg());
		}
		if (!ew_CheckNumber($this->indx_lok->FormValue)) {
			ew_AddMessage($gsFormError, $this->indx_lok->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_kd_jbt->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_kd_jbt->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_kd_jbt_pgs->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_kd_jbt_pgs->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_kd_jbt_pjs->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_kd_jbt_pjs->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_kd_jbt_ps->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_kd_jbt_ps->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->created_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->created_date->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->last_update_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->last_update_date->FldErrMsg());
		}
		if (!ew_CheckNumber($this->fgr_print_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->fgr_print_id->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_keluar->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_keluar->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_jbt_esl->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_jbt_esl->FldErrMsg());
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
			// first_name

			$this->first_name->SetDbValueDef($rsnew, $this->first_name->CurrentValue, NULL, $this->first_name->ReadOnly);

			// last_name
			$this->last_name->SetDbValueDef($rsnew, $this->last_name->CurrentValue, NULL, $this->last_name->ReadOnly);

			// first_title
			$this->first_title->SetDbValueDef($rsnew, $this->first_title->CurrentValue, NULL, $this->first_title->ReadOnly);

			// last_title
			$this->last_title->SetDbValueDef($rsnew, $this->last_title->CurrentValue, NULL, $this->last_title->ReadOnly);

			// init
			$this->init->SetDbValueDef($rsnew, $this->init->CurrentValue, NULL, $this->init->ReadOnly);

			// tpt_lahir
			$this->tpt_lahir->SetDbValueDef($rsnew, $this->tpt_lahir->CurrentValue, NULL, $this->tpt_lahir->ReadOnly);

			// tgl_lahir
			$this->tgl_lahir->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_lahir->CurrentValue, 0), NULL, $this->tgl_lahir->ReadOnly);

			// jk
			$this->jk->SetDbValueDef($rsnew, $this->jk->CurrentValue, NULL, $this->jk->ReadOnly);

			// kd_agama
			$this->kd_agama->SetDbValueDef($rsnew, $this->kd_agama->CurrentValue, NULL, $this->kd_agama->ReadOnly);

			// tgl_masuk
			$this->tgl_masuk->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_masuk->CurrentValue, 0), NULL, $this->tgl_masuk->ReadOnly);

			// tpt_masuk
			$this->tpt_masuk->SetDbValueDef($rsnew, $this->tpt_masuk->CurrentValue, NULL, $this->tpt_masuk->ReadOnly);

			// stkel
			$this->stkel->SetDbValueDef($rsnew, $this->stkel->CurrentValue, NULL, $this->stkel->ReadOnly);

			// alamat
			$this->alamat->SetDbValueDef($rsnew, $this->alamat->CurrentValue, NULL, $this->alamat->ReadOnly);

			// kota
			$this->kota->SetDbValueDef($rsnew, $this->kota->CurrentValue, NULL, $this->kota->ReadOnly);

			// kd_pos
			$this->kd_pos->SetDbValueDef($rsnew, $this->kd_pos->CurrentValue, NULL, $this->kd_pos->ReadOnly);

			// kd_propinsi
			$this->kd_propinsi->SetDbValueDef($rsnew, $this->kd_propinsi->CurrentValue, NULL, $this->kd_propinsi->ReadOnly);

			// telp
			$this->telp->SetDbValueDef($rsnew, $this->telp->CurrentValue, NULL, $this->telp->ReadOnly);

			// telp_area
			$this->telp_area->SetDbValueDef($rsnew, $this->telp_area->CurrentValue, NULL, $this->telp_area->ReadOnly);

			// hp
			$this->hp->SetDbValueDef($rsnew, $this->hp->CurrentValue, NULL, $this->hp->ReadOnly);

			// alamat_dom
			$this->alamat_dom->SetDbValueDef($rsnew, $this->alamat_dom->CurrentValue, NULL, $this->alamat_dom->ReadOnly);

			// kota_dom
			$this->kota_dom->SetDbValueDef($rsnew, $this->kota_dom->CurrentValue, NULL, $this->kota_dom->ReadOnly);

			// kd_pos_dom
			$this->kd_pos_dom->SetDbValueDef($rsnew, $this->kd_pos_dom->CurrentValue, NULL, $this->kd_pos_dom->ReadOnly);

			// kd_propinsi_dom
			$this->kd_propinsi_dom->SetDbValueDef($rsnew, $this->kd_propinsi_dom->CurrentValue, NULL, $this->kd_propinsi_dom->ReadOnly);

			// telp_dom
			$this->telp_dom->SetDbValueDef($rsnew, $this->telp_dom->CurrentValue, NULL, $this->telp_dom->ReadOnly);

			// telp_dom_area
			$this->telp_dom_area->SetDbValueDef($rsnew, $this->telp_dom_area->CurrentValue, NULL, $this->telp_dom_area->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, $this->_email->ReadOnly);

			// kd_st_emp
			$this->kd_st_emp->SetDbValueDef($rsnew, $this->kd_st_emp->CurrentValue, NULL, $this->kd_st_emp->ReadOnly);

			// skala
			$this->skala->SetDbValueDef($rsnew, $this->skala->CurrentValue, NULL, $this->skala->ReadOnly);

			// gp
			$this->gp->SetDbValueDef($rsnew, $this->gp->CurrentValue, NULL, $this->gp->ReadOnly);

			// upah_tetap
			$this->upah_tetap->SetDbValueDef($rsnew, $this->upah_tetap->CurrentValue, NULL, $this->upah_tetap->ReadOnly);

			// tgl_honor
			$this->tgl_honor->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_honor->CurrentValue, 0), NULL, $this->tgl_honor->ReadOnly);

			// honor
			$this->honor->SetDbValueDef($rsnew, $this->honor->CurrentValue, NULL, $this->honor->ReadOnly);

			// premi_honor
			$this->premi_honor->SetDbValueDef($rsnew, $this->premi_honor->CurrentValue, NULL, $this->premi_honor->ReadOnly);

			// tgl_gp
			$this->tgl_gp->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_gp->CurrentValue, 0), NULL, $this->tgl_gp->ReadOnly);

			// skala_95
			$this->skala_95->SetDbValueDef($rsnew, $this->skala_95->CurrentValue, NULL, $this->skala_95->ReadOnly);

			// gp_95
			$this->gp_95->SetDbValueDef($rsnew, $this->gp_95->CurrentValue, NULL, $this->gp_95->ReadOnly);

			// tgl_gp_95
			$this->tgl_gp_95->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_gp_95->CurrentValue, 0), NULL, $this->tgl_gp_95->ReadOnly);

			// kd_indx
			$this->kd_indx->SetDbValueDef($rsnew, $this->kd_indx->CurrentValue, NULL, $this->kd_indx->ReadOnly);

			// indx_lok
			$this->indx_lok->SetDbValueDef($rsnew, $this->indx_lok->CurrentValue, NULL, $this->indx_lok->ReadOnly);

			// gol_darah
			$this->gol_darah->SetDbValueDef($rsnew, $this->gol_darah->CurrentValue, NULL, $this->gol_darah->ReadOnly);

			// kd_jbt
			$this->kd_jbt->SetDbValueDef($rsnew, $this->kd_jbt->CurrentValue, NULL, $this->kd_jbt->ReadOnly);

			// tgl_kd_jbt
			$this->tgl_kd_jbt->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_kd_jbt->CurrentValue, 0), NULL, $this->tgl_kd_jbt->ReadOnly);

			// kd_jbt_pgs
			$this->kd_jbt_pgs->SetDbValueDef($rsnew, $this->kd_jbt_pgs->CurrentValue, NULL, $this->kd_jbt_pgs->ReadOnly);

			// tgl_kd_jbt_pgs
			$this->tgl_kd_jbt_pgs->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_kd_jbt_pgs->CurrentValue, 0), NULL, $this->tgl_kd_jbt_pgs->ReadOnly);

			// kd_jbt_pjs
			$this->kd_jbt_pjs->SetDbValueDef($rsnew, $this->kd_jbt_pjs->CurrentValue, NULL, $this->kd_jbt_pjs->ReadOnly);

			// tgl_kd_jbt_pjs
			$this->tgl_kd_jbt_pjs->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_kd_jbt_pjs->CurrentValue, 0), NULL, $this->tgl_kd_jbt_pjs->ReadOnly);

			// kd_jbt_ps
			$this->kd_jbt_ps->SetDbValueDef($rsnew, $this->kd_jbt_ps->CurrentValue, NULL, $this->kd_jbt_ps->ReadOnly);

			// tgl_kd_jbt_ps
			$this->tgl_kd_jbt_ps->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_kd_jbt_ps->CurrentValue, 0), NULL, $this->tgl_kd_jbt_ps->ReadOnly);

			// kd_pat
			$this->kd_pat->SetDbValueDef($rsnew, $this->kd_pat->CurrentValue, NULL, $this->kd_pat->ReadOnly);

			// kd_gas
			$this->kd_gas->SetDbValueDef($rsnew, $this->kd_gas->CurrentValue, NULL, $this->kd_gas->ReadOnly);

			// pimp_empid
			$this->pimp_empid->SetDbValueDef($rsnew, $this->pimp_empid->CurrentValue, NULL, $this->pimp_empid->ReadOnly);

			// stshift
			$this->stshift->SetDbValueDef($rsnew, $this->stshift->CurrentValue, NULL, $this->stshift->ReadOnly);

			// no_rek
			$this->no_rek->SetDbValueDef($rsnew, $this->no_rek->CurrentValue, NULL, $this->no_rek->ReadOnly);

			// kd_bank
			$this->kd_bank->SetDbValueDef($rsnew, $this->kd_bank->CurrentValue, NULL, $this->kd_bank->ReadOnly);

			// kd_jamsostek
			$this->kd_jamsostek->SetDbValueDef($rsnew, $this->kd_jamsostek->CurrentValue, NULL, $this->kd_jamsostek->ReadOnly);

			// acc_astek
			$this->acc_astek->SetDbValueDef($rsnew, $this->acc_astek->CurrentValue, NULL, $this->acc_astek->ReadOnly);

			// acc_dapens
			$this->acc_dapens->SetDbValueDef($rsnew, $this->acc_dapens->CurrentValue, NULL, $this->acc_dapens->ReadOnly);

			// acc_kes
			$this->acc_kes->SetDbValueDef($rsnew, $this->acc_kes->CurrentValue, NULL, $this->acc_kes->ReadOnly);

			// st
			$this->st->SetDbValueDef($rsnew, $this->st->CurrentValue, NULL, $this->st->ReadOnly);

			// signature
			if ($this->signature->Visible && !$this->signature->ReadOnly && !$this->signature->Upload->KeepFile) {
				if (is_null($this->signature->Upload->Value)) {
					$rsnew['signature'] = NULL;
				} else {
					$rsnew['signature'] = $this->signature->Upload->Value;
				}
			}

			// created_by
			$this->created_by->SetDbValueDef($rsnew, $this->created_by->CurrentValue, NULL, $this->created_by->ReadOnly);

			// created_date
			$this->created_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->created_date->CurrentValue, 0), NULL, $this->created_date->ReadOnly);

			// last_update_by
			$this->last_update_by->SetDbValueDef($rsnew, $this->last_update_by->CurrentValue, NULL, $this->last_update_by->ReadOnly);

			// last_update_date
			$this->last_update_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->last_update_date->CurrentValue, 0), NULL, $this->last_update_date->ReadOnly);

			// fgr_print_id
			$this->fgr_print_id->SetDbValueDef($rsnew, $this->fgr_print_id->CurrentValue, NULL, $this->fgr_print_id->ReadOnly);

			// kd_jbt_eselon
			$this->kd_jbt_eselon->SetDbValueDef($rsnew, $this->kd_jbt_eselon->CurrentValue, NULL, $this->kd_jbt_eselon->ReadOnly);

			// npwp
			$this->npwp->SetDbValueDef($rsnew, $this->npwp->CurrentValue, NULL, $this->npwp->ReadOnly);

			// paraf
			if ($this->paraf->Visible && !$this->paraf->ReadOnly && !$this->paraf->Upload->KeepFile) {
				if (is_null($this->paraf->Upload->Value)) {
					$rsnew['paraf'] = NULL;
				} else {
					$rsnew['paraf'] = $this->paraf->Upload->Value;
				}
			}

			// tgl_keluar
			$this->tgl_keluar->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_keluar->CurrentValue, 0), NULL, $this->tgl_keluar->ReadOnly);

			// nama_nasabah
			$this->nama_nasabah->SetDbValueDef($rsnew, $this->nama_nasabah->CurrentValue, NULL, $this->nama_nasabah->ReadOnly);

			// no_ktp
			$this->no_ktp->SetDbValueDef($rsnew, $this->no_ktp->CurrentValue, NULL, $this->no_ktp->ReadOnly);

			// no_kokar
			$this->no_kokar->SetDbValueDef($rsnew, $this->no_kokar->CurrentValue, NULL, $this->no_kokar->ReadOnly);

			// no_bmw
			$this->no_bmw->SetDbValueDef($rsnew, $this->no_bmw->CurrentValue, NULL, $this->no_bmw->ReadOnly);

			// no_bpjs_ketenagakerjaan
			$this->no_bpjs_ketenagakerjaan->SetDbValueDef($rsnew, $this->no_bpjs_ketenagakerjaan->CurrentValue, NULL, $this->no_bpjs_ketenagakerjaan->ReadOnly);

			// no_bpjs_kesehatan
			$this->no_bpjs_kesehatan->SetDbValueDef($rsnew, $this->no_bpjs_kesehatan->CurrentValue, NULL, $this->no_bpjs_kesehatan->ReadOnly);

			// eselon
			$this->eselon->SetDbValueDef($rsnew, $this->eselon->CurrentValue, NULL, $this->eselon->ReadOnly);

			// kd_jenjang
			$this->kd_jenjang->SetDbValueDef($rsnew, $this->kd_jenjang->CurrentValue, NULL, $this->kd_jenjang->ReadOnly);

			// kd_jbt_esl
			$this->kd_jbt_esl->SetDbValueDef($rsnew, $this->kd_jbt_esl->CurrentValue, NULL, $this->kd_jbt_esl->ReadOnly);

			// tgl_jbt_esl
			$this->tgl_jbt_esl->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_jbt_esl->CurrentValue, 0), NULL, $this->tgl_jbt_esl->ReadOnly);

			// org_id
			$this->org_id->SetDbValueDef($rsnew, $this->org_id->CurrentValue, NULL, $this->org_id->ReadOnly);

			// picture
			if ($this->picture->Visible && !$this->picture->ReadOnly && !$this->picture->Upload->KeepFile) {
				if (is_null($this->picture->Upload->Value)) {
					$rsnew['picture'] = NULL;
				} else {
					$rsnew['picture'] = $this->picture->Upload->Value;
				}
			}

			// kd_payroll
			$this->kd_payroll->SetDbValueDef($rsnew, $this->kd_payroll->CurrentValue, NULL, $this->kd_payroll->ReadOnly);

			// id_wn
			$this->id_wn->SetDbValueDef($rsnew, $this->id_wn->CurrentValue, NULL, $this->id_wn->ReadOnly);

			// no_anggota_kkms
			$this->no_anggota_kkms->SetDbValueDef($rsnew, $this->no_anggota_kkms->CurrentValue, NULL, $this->no_anggota_kkms->ReadOnly);

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

		// signature
		ew_CleanUploadTempPath($this->signature, $this->signature->Upload->Index);

		// paraf
		ew_CleanUploadTempPath($this->paraf, $this->paraf->Upload->Index);

		// picture
		ew_CleanUploadTempPath($this->picture, $this->picture->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("personallist.php"), "", $this->TableVar, TRUE);
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
if (!isset($personal_edit)) $personal_edit = new cpersonal_edit();

// Page init
$personal_edit->Page_Init();

// Page main
$personal_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$personal_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fpersonaledit = new ew_Form("fpersonaledit", "edit");

// Validate form
fpersonaledit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $personal->employee_id->FldCaption(), $personal->employee_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tgl_lahir");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->tgl_lahir->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_masuk");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->tgl_masuk->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_gp");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->gp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_upah_tetap");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->upah_tetap->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_honor");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->tgl_honor->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_honor");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->honor->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_premi_honor");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->premi_honor->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_gp");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->tgl_gp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_gp_95");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->gp_95->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_gp_95");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->tgl_gp_95->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_indx_lok");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->indx_lok->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_kd_jbt");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->tgl_kd_jbt->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_kd_jbt_pgs");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->tgl_kd_jbt_pgs->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_kd_jbt_pjs");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->tgl_kd_jbt_pjs->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_kd_jbt_ps");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->tgl_kd_jbt_ps->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_created_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->created_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_update_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->last_update_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fgr_print_id");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->fgr_print_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_keluar");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->tgl_keluar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_jbt_esl");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($personal->tgl_jbt_esl->FldErrMsg()) ?>");

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
fpersonaledit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fpersonaledit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $personal_edit->ShowPageHeader(); ?>
<?php
$personal_edit->ShowMessage();
?>
<form name="fpersonaledit" id="fpersonaledit" class="<?php echo $personal_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($personal_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $personal_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="personal">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($personal_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($personal->employee_id->Visible) { // employee_id ?>
	<div id="r_employee_id" class="form-group">
		<label id="elh_personal_employee_id" for="x_employee_id" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->employee_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->employee_id->CellAttributes() ?>>
<span id="el_personal_employee_id">
<span<?php echo $personal->employee_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $personal->employee_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="personal" data-field="x_employee_id" name="x_employee_id" id="x_employee_id" value="<?php echo ew_HtmlEncode($personal->employee_id->CurrentValue) ?>">
<?php echo $personal->employee_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->first_name->Visible) { // first_name ?>
	<div id="r_first_name" class="form-group">
		<label id="elh_personal_first_name" for="x_first_name" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->first_name->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->first_name->CellAttributes() ?>>
<span id="el_personal_first_name">
<input type="text" data-table="personal" data-field="x_first_name" name="x_first_name" id="x_first_name" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($personal->first_name->getPlaceHolder()) ?>" value="<?php echo $personal->first_name->EditValue ?>"<?php echo $personal->first_name->EditAttributes() ?>>
</span>
<?php echo $personal->first_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->last_name->Visible) { // last_name ?>
	<div id="r_last_name" class="form-group">
		<label id="elh_personal_last_name" for="x_last_name" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->last_name->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->last_name->CellAttributes() ?>>
<span id="el_personal_last_name">
<input type="text" data-table="personal" data-field="x_last_name" name="x_last_name" id="x_last_name" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($personal->last_name->getPlaceHolder()) ?>" value="<?php echo $personal->last_name->EditValue ?>"<?php echo $personal->last_name->EditAttributes() ?>>
</span>
<?php echo $personal->last_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->first_title->Visible) { // first_title ?>
	<div id="r_first_title" class="form-group">
		<label id="elh_personal_first_title" for="x_first_title" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->first_title->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->first_title->CellAttributes() ?>>
<span id="el_personal_first_title">
<input type="text" data-table="personal" data-field="x_first_title" name="x_first_title" id="x_first_title" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($personal->first_title->getPlaceHolder()) ?>" value="<?php echo $personal->first_title->EditValue ?>"<?php echo $personal->first_title->EditAttributes() ?>>
</span>
<?php echo $personal->first_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->last_title->Visible) { // last_title ?>
	<div id="r_last_title" class="form-group">
		<label id="elh_personal_last_title" for="x_last_title" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->last_title->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->last_title->CellAttributes() ?>>
<span id="el_personal_last_title">
<input type="text" data-table="personal" data-field="x_last_title" name="x_last_title" id="x_last_title" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($personal->last_title->getPlaceHolder()) ?>" value="<?php echo $personal->last_title->EditValue ?>"<?php echo $personal->last_title->EditAttributes() ?>>
</span>
<?php echo $personal->last_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->init->Visible) { // init ?>
	<div id="r_init" class="form-group">
		<label id="elh_personal_init" for="x_init" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->init->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->init->CellAttributes() ?>>
<span id="el_personal_init">
<input type="text" data-table="personal" data-field="x_init" name="x_init" id="x_init" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($personal->init->getPlaceHolder()) ?>" value="<?php echo $personal->init->EditValue ?>"<?php echo $personal->init->EditAttributes() ?>>
</span>
<?php echo $personal->init->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->tpt_lahir->Visible) { // tpt_lahir ?>
	<div id="r_tpt_lahir" class="form-group">
		<label id="elh_personal_tpt_lahir" for="x_tpt_lahir" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->tpt_lahir->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->tpt_lahir->CellAttributes() ?>>
<span id="el_personal_tpt_lahir">
<input type="text" data-table="personal" data-field="x_tpt_lahir" name="x_tpt_lahir" id="x_tpt_lahir" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($personal->tpt_lahir->getPlaceHolder()) ?>" value="<?php echo $personal->tpt_lahir->EditValue ?>"<?php echo $personal->tpt_lahir->EditAttributes() ?>>
</span>
<?php echo $personal->tpt_lahir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->tgl_lahir->Visible) { // tgl_lahir ?>
	<div id="r_tgl_lahir" class="form-group">
		<label id="elh_personal_tgl_lahir" for="x_tgl_lahir" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->tgl_lahir->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->tgl_lahir->CellAttributes() ?>>
<span id="el_personal_tgl_lahir">
<input type="text" data-table="personal" data-field="x_tgl_lahir" name="x_tgl_lahir" id="x_tgl_lahir" placeholder="<?php echo ew_HtmlEncode($personal->tgl_lahir->getPlaceHolder()) ?>" value="<?php echo $personal->tgl_lahir->EditValue ?>"<?php echo $personal->tgl_lahir->EditAttributes() ?>>
</span>
<?php echo $personal->tgl_lahir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->jk->Visible) { // jk ?>
	<div id="r_jk" class="form-group">
		<label id="elh_personal_jk" for="x_jk" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->jk->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->jk->CellAttributes() ?>>
<span id="el_personal_jk">
<input type="text" data-table="personal" data-field="x_jk" name="x_jk" id="x_jk" size="30" maxlength="1" placeholder="<?php echo ew_HtmlEncode($personal->jk->getPlaceHolder()) ?>" value="<?php echo $personal->jk->EditValue ?>"<?php echo $personal->jk->EditAttributes() ?>>
</span>
<?php echo $personal->jk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_agama->Visible) { // kd_agama ?>
	<div id="r_kd_agama" class="form-group">
		<label id="elh_personal_kd_agama" for="x_kd_agama" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_agama->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_agama->CellAttributes() ?>>
<span id="el_personal_kd_agama">
<input type="text" data-table="personal" data-field="x_kd_agama" name="x_kd_agama" id="x_kd_agama" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($personal->kd_agama->getPlaceHolder()) ?>" value="<?php echo $personal->kd_agama->EditValue ?>"<?php echo $personal->kd_agama->EditAttributes() ?>>
</span>
<?php echo $personal->kd_agama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->tgl_masuk->Visible) { // tgl_masuk ?>
	<div id="r_tgl_masuk" class="form-group">
		<label id="elh_personal_tgl_masuk" for="x_tgl_masuk" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->tgl_masuk->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->tgl_masuk->CellAttributes() ?>>
<span id="el_personal_tgl_masuk">
<input type="text" data-table="personal" data-field="x_tgl_masuk" name="x_tgl_masuk" id="x_tgl_masuk" placeholder="<?php echo ew_HtmlEncode($personal->tgl_masuk->getPlaceHolder()) ?>" value="<?php echo $personal->tgl_masuk->EditValue ?>"<?php echo $personal->tgl_masuk->EditAttributes() ?>>
</span>
<?php echo $personal->tgl_masuk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->tpt_masuk->Visible) { // tpt_masuk ?>
	<div id="r_tpt_masuk" class="form-group">
		<label id="elh_personal_tpt_masuk" for="x_tpt_masuk" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->tpt_masuk->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->tpt_masuk->CellAttributes() ?>>
<span id="el_personal_tpt_masuk">
<input type="text" data-table="personal" data-field="x_tpt_masuk" name="x_tpt_masuk" id="x_tpt_masuk" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($personal->tpt_masuk->getPlaceHolder()) ?>" value="<?php echo $personal->tpt_masuk->EditValue ?>"<?php echo $personal->tpt_masuk->EditAttributes() ?>>
</span>
<?php echo $personal->tpt_masuk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->stkel->Visible) { // stkel ?>
	<div id="r_stkel" class="form-group">
		<label id="elh_personal_stkel" for="x_stkel" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->stkel->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->stkel->CellAttributes() ?>>
<span id="el_personal_stkel">
<input type="text" data-table="personal" data-field="x_stkel" name="x_stkel" id="x_stkel" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($personal->stkel->getPlaceHolder()) ?>" value="<?php echo $personal->stkel->EditValue ?>"<?php echo $personal->stkel->EditAttributes() ?>>
</span>
<?php echo $personal->stkel->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->alamat->Visible) { // alamat ?>
	<div id="r_alamat" class="form-group">
		<label id="elh_personal_alamat" for="x_alamat" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->alamat->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->alamat->CellAttributes() ?>>
<span id="el_personal_alamat">
<input type="text" data-table="personal" data-field="x_alamat" name="x_alamat" id="x_alamat" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($personal->alamat->getPlaceHolder()) ?>" value="<?php echo $personal->alamat->EditValue ?>"<?php echo $personal->alamat->EditAttributes() ?>>
</span>
<?php echo $personal->alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kota->Visible) { // kota ?>
	<div id="r_kota" class="form-group">
		<label id="elh_personal_kota" for="x_kota" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kota->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kota->CellAttributes() ?>>
<span id="el_personal_kota">
<input type="text" data-table="personal" data-field="x_kota" name="x_kota" id="x_kota" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($personal->kota->getPlaceHolder()) ?>" value="<?php echo $personal->kota->EditValue ?>"<?php echo $personal->kota->EditAttributes() ?>>
</span>
<?php echo $personal->kota->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_pos->Visible) { // kd_pos ?>
	<div id="r_kd_pos" class="form-group">
		<label id="elh_personal_kd_pos" for="x_kd_pos" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_pos->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_pos->CellAttributes() ?>>
<span id="el_personal_kd_pos">
<input type="text" data-table="personal" data-field="x_kd_pos" name="x_kd_pos" id="x_kd_pos" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($personal->kd_pos->getPlaceHolder()) ?>" value="<?php echo $personal->kd_pos->EditValue ?>"<?php echo $personal->kd_pos->EditAttributes() ?>>
</span>
<?php echo $personal->kd_pos->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_propinsi->Visible) { // kd_propinsi ?>
	<div id="r_kd_propinsi" class="form-group">
		<label id="elh_personal_kd_propinsi" for="x_kd_propinsi" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_propinsi->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_propinsi->CellAttributes() ?>>
<span id="el_personal_kd_propinsi">
<input type="text" data-table="personal" data-field="x_kd_propinsi" name="x_kd_propinsi" id="x_kd_propinsi" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($personal->kd_propinsi->getPlaceHolder()) ?>" value="<?php echo $personal->kd_propinsi->EditValue ?>"<?php echo $personal->kd_propinsi->EditAttributes() ?>>
</span>
<?php echo $personal->kd_propinsi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->telp->Visible) { // telp ?>
	<div id="r_telp" class="form-group">
		<label id="elh_personal_telp" for="x_telp" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->telp->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->telp->CellAttributes() ?>>
<span id="el_personal_telp">
<input type="text" data-table="personal" data-field="x_telp" name="x_telp" id="x_telp" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($personal->telp->getPlaceHolder()) ?>" value="<?php echo $personal->telp->EditValue ?>"<?php echo $personal->telp->EditAttributes() ?>>
</span>
<?php echo $personal->telp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->telp_area->Visible) { // telp_area ?>
	<div id="r_telp_area" class="form-group">
		<label id="elh_personal_telp_area" for="x_telp_area" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->telp_area->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->telp_area->CellAttributes() ?>>
<span id="el_personal_telp_area">
<input type="text" data-table="personal" data-field="x_telp_area" name="x_telp_area" id="x_telp_area" size="30" maxlength="4" placeholder="<?php echo ew_HtmlEncode($personal->telp_area->getPlaceHolder()) ?>" value="<?php echo $personal->telp_area->EditValue ?>"<?php echo $personal->telp_area->EditAttributes() ?>>
</span>
<?php echo $personal->telp_area->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->hp->Visible) { // hp ?>
	<div id="r_hp" class="form-group">
		<label id="elh_personal_hp" for="x_hp" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->hp->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->hp->CellAttributes() ?>>
<span id="el_personal_hp">
<input type="text" data-table="personal" data-field="x_hp" name="x_hp" id="x_hp" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($personal->hp->getPlaceHolder()) ?>" value="<?php echo $personal->hp->EditValue ?>"<?php echo $personal->hp->EditAttributes() ?>>
</span>
<?php echo $personal->hp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->alamat_dom->Visible) { // alamat_dom ?>
	<div id="r_alamat_dom" class="form-group">
		<label id="elh_personal_alamat_dom" for="x_alamat_dom" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->alamat_dom->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->alamat_dom->CellAttributes() ?>>
<span id="el_personal_alamat_dom">
<input type="text" data-table="personal" data-field="x_alamat_dom" name="x_alamat_dom" id="x_alamat_dom" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($personal->alamat_dom->getPlaceHolder()) ?>" value="<?php echo $personal->alamat_dom->EditValue ?>"<?php echo $personal->alamat_dom->EditAttributes() ?>>
</span>
<?php echo $personal->alamat_dom->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kota_dom->Visible) { // kota_dom ?>
	<div id="r_kota_dom" class="form-group">
		<label id="elh_personal_kota_dom" for="x_kota_dom" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kota_dom->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kota_dom->CellAttributes() ?>>
<span id="el_personal_kota_dom">
<input type="text" data-table="personal" data-field="x_kota_dom" name="x_kota_dom" id="x_kota_dom" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($personal->kota_dom->getPlaceHolder()) ?>" value="<?php echo $personal->kota_dom->EditValue ?>"<?php echo $personal->kota_dom->EditAttributes() ?>>
</span>
<?php echo $personal->kota_dom->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_pos_dom->Visible) { // kd_pos_dom ?>
	<div id="r_kd_pos_dom" class="form-group">
		<label id="elh_personal_kd_pos_dom" for="x_kd_pos_dom" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_pos_dom->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_pos_dom->CellAttributes() ?>>
<span id="el_personal_kd_pos_dom">
<input type="text" data-table="personal" data-field="x_kd_pos_dom" name="x_kd_pos_dom" id="x_kd_pos_dom" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($personal->kd_pos_dom->getPlaceHolder()) ?>" value="<?php echo $personal->kd_pos_dom->EditValue ?>"<?php echo $personal->kd_pos_dom->EditAttributes() ?>>
</span>
<?php echo $personal->kd_pos_dom->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_propinsi_dom->Visible) { // kd_propinsi_dom ?>
	<div id="r_kd_propinsi_dom" class="form-group">
		<label id="elh_personal_kd_propinsi_dom" for="x_kd_propinsi_dom" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_propinsi_dom->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_propinsi_dom->CellAttributes() ?>>
<span id="el_personal_kd_propinsi_dom">
<input type="text" data-table="personal" data-field="x_kd_propinsi_dom" name="x_kd_propinsi_dom" id="x_kd_propinsi_dom" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($personal->kd_propinsi_dom->getPlaceHolder()) ?>" value="<?php echo $personal->kd_propinsi_dom->EditValue ?>"<?php echo $personal->kd_propinsi_dom->EditAttributes() ?>>
</span>
<?php echo $personal->kd_propinsi_dom->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->telp_dom->Visible) { // telp_dom ?>
	<div id="r_telp_dom" class="form-group">
		<label id="elh_personal_telp_dom" for="x_telp_dom" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->telp_dom->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->telp_dom->CellAttributes() ?>>
<span id="el_personal_telp_dom">
<input type="text" data-table="personal" data-field="x_telp_dom" name="x_telp_dom" id="x_telp_dom" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($personal->telp_dom->getPlaceHolder()) ?>" value="<?php echo $personal->telp_dom->EditValue ?>"<?php echo $personal->telp_dom->EditAttributes() ?>>
</span>
<?php echo $personal->telp_dom->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->telp_dom_area->Visible) { // telp_dom_area ?>
	<div id="r_telp_dom_area" class="form-group">
		<label id="elh_personal_telp_dom_area" for="x_telp_dom_area" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->telp_dom_area->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->telp_dom_area->CellAttributes() ?>>
<span id="el_personal_telp_dom_area">
<input type="text" data-table="personal" data-field="x_telp_dom_area" name="x_telp_dom_area" id="x_telp_dom_area" size="30" maxlength="4" placeholder="<?php echo ew_HtmlEncode($personal->telp_dom_area->getPlaceHolder()) ?>" value="<?php echo $personal->telp_dom_area->EditValue ?>"<?php echo $personal->telp_dom_area->EditAttributes() ?>>
</span>
<?php echo $personal->telp_dom_area->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_personal__email" for="x__email" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->_email->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->_email->CellAttributes() ?>>
<span id="el_personal__email">
<input type="text" data-table="personal" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($personal->_email->getPlaceHolder()) ?>" value="<?php echo $personal->_email->EditValue ?>"<?php echo $personal->_email->EditAttributes() ?>>
</span>
<?php echo $personal->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_st_emp->Visible) { // kd_st_emp ?>
	<div id="r_kd_st_emp" class="form-group">
		<label id="elh_personal_kd_st_emp" for="x_kd_st_emp" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_st_emp->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_st_emp->CellAttributes() ?>>
<span id="el_personal_kd_st_emp">
<input type="text" data-table="personal" data-field="x_kd_st_emp" name="x_kd_st_emp" id="x_kd_st_emp" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($personal->kd_st_emp->getPlaceHolder()) ?>" value="<?php echo $personal->kd_st_emp->EditValue ?>"<?php echo $personal->kd_st_emp->EditAttributes() ?>>
</span>
<?php echo $personal->kd_st_emp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->skala->Visible) { // skala ?>
	<div id="r_skala" class="form-group">
		<label id="elh_personal_skala" for="x_skala" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->skala->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->skala->CellAttributes() ?>>
<span id="el_personal_skala">
<input type="text" data-table="personal" data-field="x_skala" name="x_skala" id="x_skala" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($personal->skala->getPlaceHolder()) ?>" value="<?php echo $personal->skala->EditValue ?>"<?php echo $personal->skala->EditAttributes() ?>>
</span>
<?php echo $personal->skala->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->gp->Visible) { // gp ?>
	<div id="r_gp" class="form-group">
		<label id="elh_personal_gp" for="x_gp" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->gp->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->gp->CellAttributes() ?>>
<span id="el_personal_gp">
<input type="text" data-table="personal" data-field="x_gp" name="x_gp" id="x_gp" size="30" placeholder="<?php echo ew_HtmlEncode($personal->gp->getPlaceHolder()) ?>" value="<?php echo $personal->gp->EditValue ?>"<?php echo $personal->gp->EditAttributes() ?>>
</span>
<?php echo $personal->gp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->upah_tetap->Visible) { // upah_tetap ?>
	<div id="r_upah_tetap" class="form-group">
		<label id="elh_personal_upah_tetap" for="x_upah_tetap" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->upah_tetap->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->upah_tetap->CellAttributes() ?>>
<span id="el_personal_upah_tetap">
<input type="text" data-table="personal" data-field="x_upah_tetap" name="x_upah_tetap" id="x_upah_tetap" size="30" placeholder="<?php echo ew_HtmlEncode($personal->upah_tetap->getPlaceHolder()) ?>" value="<?php echo $personal->upah_tetap->EditValue ?>"<?php echo $personal->upah_tetap->EditAttributes() ?>>
</span>
<?php echo $personal->upah_tetap->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->tgl_honor->Visible) { // tgl_honor ?>
	<div id="r_tgl_honor" class="form-group">
		<label id="elh_personal_tgl_honor" for="x_tgl_honor" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->tgl_honor->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->tgl_honor->CellAttributes() ?>>
<span id="el_personal_tgl_honor">
<input type="text" data-table="personal" data-field="x_tgl_honor" name="x_tgl_honor" id="x_tgl_honor" placeholder="<?php echo ew_HtmlEncode($personal->tgl_honor->getPlaceHolder()) ?>" value="<?php echo $personal->tgl_honor->EditValue ?>"<?php echo $personal->tgl_honor->EditAttributes() ?>>
</span>
<?php echo $personal->tgl_honor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->honor->Visible) { // honor ?>
	<div id="r_honor" class="form-group">
		<label id="elh_personal_honor" for="x_honor" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->honor->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->honor->CellAttributes() ?>>
<span id="el_personal_honor">
<input type="text" data-table="personal" data-field="x_honor" name="x_honor" id="x_honor" size="30" placeholder="<?php echo ew_HtmlEncode($personal->honor->getPlaceHolder()) ?>" value="<?php echo $personal->honor->EditValue ?>"<?php echo $personal->honor->EditAttributes() ?>>
</span>
<?php echo $personal->honor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->premi_honor->Visible) { // premi_honor ?>
	<div id="r_premi_honor" class="form-group">
		<label id="elh_personal_premi_honor" for="x_premi_honor" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->premi_honor->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->premi_honor->CellAttributes() ?>>
<span id="el_personal_premi_honor">
<input type="text" data-table="personal" data-field="x_premi_honor" name="x_premi_honor" id="x_premi_honor" size="30" placeholder="<?php echo ew_HtmlEncode($personal->premi_honor->getPlaceHolder()) ?>" value="<?php echo $personal->premi_honor->EditValue ?>"<?php echo $personal->premi_honor->EditAttributes() ?>>
</span>
<?php echo $personal->premi_honor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->tgl_gp->Visible) { // tgl_gp ?>
	<div id="r_tgl_gp" class="form-group">
		<label id="elh_personal_tgl_gp" for="x_tgl_gp" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->tgl_gp->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->tgl_gp->CellAttributes() ?>>
<span id="el_personal_tgl_gp">
<input type="text" data-table="personal" data-field="x_tgl_gp" name="x_tgl_gp" id="x_tgl_gp" placeholder="<?php echo ew_HtmlEncode($personal->tgl_gp->getPlaceHolder()) ?>" value="<?php echo $personal->tgl_gp->EditValue ?>"<?php echo $personal->tgl_gp->EditAttributes() ?>>
</span>
<?php echo $personal->tgl_gp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->skala_95->Visible) { // skala_95 ?>
	<div id="r_skala_95" class="form-group">
		<label id="elh_personal_skala_95" for="x_skala_95" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->skala_95->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->skala_95->CellAttributes() ?>>
<span id="el_personal_skala_95">
<input type="text" data-table="personal" data-field="x_skala_95" name="x_skala_95" id="x_skala_95" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($personal->skala_95->getPlaceHolder()) ?>" value="<?php echo $personal->skala_95->EditValue ?>"<?php echo $personal->skala_95->EditAttributes() ?>>
</span>
<?php echo $personal->skala_95->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->gp_95->Visible) { // gp_95 ?>
	<div id="r_gp_95" class="form-group">
		<label id="elh_personal_gp_95" for="x_gp_95" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->gp_95->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->gp_95->CellAttributes() ?>>
<span id="el_personal_gp_95">
<input type="text" data-table="personal" data-field="x_gp_95" name="x_gp_95" id="x_gp_95" size="30" placeholder="<?php echo ew_HtmlEncode($personal->gp_95->getPlaceHolder()) ?>" value="<?php echo $personal->gp_95->EditValue ?>"<?php echo $personal->gp_95->EditAttributes() ?>>
</span>
<?php echo $personal->gp_95->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->tgl_gp_95->Visible) { // tgl_gp_95 ?>
	<div id="r_tgl_gp_95" class="form-group">
		<label id="elh_personal_tgl_gp_95" for="x_tgl_gp_95" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->tgl_gp_95->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->tgl_gp_95->CellAttributes() ?>>
<span id="el_personal_tgl_gp_95">
<input type="text" data-table="personal" data-field="x_tgl_gp_95" name="x_tgl_gp_95" id="x_tgl_gp_95" placeholder="<?php echo ew_HtmlEncode($personal->tgl_gp_95->getPlaceHolder()) ?>" value="<?php echo $personal->tgl_gp_95->EditValue ?>"<?php echo $personal->tgl_gp_95->EditAttributes() ?>>
</span>
<?php echo $personal->tgl_gp_95->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_indx->Visible) { // kd_indx ?>
	<div id="r_kd_indx" class="form-group">
		<label id="elh_personal_kd_indx" for="x_kd_indx" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_indx->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_indx->CellAttributes() ?>>
<span id="el_personal_kd_indx">
<input type="text" data-table="personal" data-field="x_kd_indx" name="x_kd_indx" id="x_kd_indx" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($personal->kd_indx->getPlaceHolder()) ?>" value="<?php echo $personal->kd_indx->EditValue ?>"<?php echo $personal->kd_indx->EditAttributes() ?>>
</span>
<?php echo $personal->kd_indx->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->indx_lok->Visible) { // indx_lok ?>
	<div id="r_indx_lok" class="form-group">
		<label id="elh_personal_indx_lok" for="x_indx_lok" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->indx_lok->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->indx_lok->CellAttributes() ?>>
<span id="el_personal_indx_lok">
<input type="text" data-table="personal" data-field="x_indx_lok" name="x_indx_lok" id="x_indx_lok" size="30" placeholder="<?php echo ew_HtmlEncode($personal->indx_lok->getPlaceHolder()) ?>" value="<?php echo $personal->indx_lok->EditValue ?>"<?php echo $personal->indx_lok->EditAttributes() ?>>
</span>
<?php echo $personal->indx_lok->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->gol_darah->Visible) { // gol_darah ?>
	<div id="r_gol_darah" class="form-group">
		<label id="elh_personal_gol_darah" for="x_gol_darah" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->gol_darah->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->gol_darah->CellAttributes() ?>>
<span id="el_personal_gol_darah">
<input type="text" data-table="personal" data-field="x_gol_darah" name="x_gol_darah" id="x_gol_darah" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($personal->gol_darah->getPlaceHolder()) ?>" value="<?php echo $personal->gol_darah->EditValue ?>"<?php echo $personal->gol_darah->EditAttributes() ?>>
</span>
<?php echo $personal->gol_darah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_jbt->Visible) { // kd_jbt ?>
	<div id="r_kd_jbt" class="form-group">
		<label id="elh_personal_kd_jbt" for="x_kd_jbt" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_jbt->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_jbt->CellAttributes() ?>>
<span id="el_personal_kd_jbt">
<input type="text" data-table="personal" data-field="x_kd_jbt" name="x_kd_jbt" id="x_kd_jbt" size="30" maxlength="7" placeholder="<?php echo ew_HtmlEncode($personal->kd_jbt->getPlaceHolder()) ?>" value="<?php echo $personal->kd_jbt->EditValue ?>"<?php echo $personal->kd_jbt->EditAttributes() ?>>
</span>
<?php echo $personal->kd_jbt->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->tgl_kd_jbt->Visible) { // tgl_kd_jbt ?>
	<div id="r_tgl_kd_jbt" class="form-group">
		<label id="elh_personal_tgl_kd_jbt" for="x_tgl_kd_jbt" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->tgl_kd_jbt->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->tgl_kd_jbt->CellAttributes() ?>>
<span id="el_personal_tgl_kd_jbt">
<input type="text" data-table="personal" data-field="x_tgl_kd_jbt" name="x_tgl_kd_jbt" id="x_tgl_kd_jbt" placeholder="<?php echo ew_HtmlEncode($personal->tgl_kd_jbt->getPlaceHolder()) ?>" value="<?php echo $personal->tgl_kd_jbt->EditValue ?>"<?php echo $personal->tgl_kd_jbt->EditAttributes() ?>>
</span>
<?php echo $personal->tgl_kd_jbt->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_jbt_pgs->Visible) { // kd_jbt_pgs ?>
	<div id="r_kd_jbt_pgs" class="form-group">
		<label id="elh_personal_kd_jbt_pgs" for="x_kd_jbt_pgs" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_jbt_pgs->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_jbt_pgs->CellAttributes() ?>>
<span id="el_personal_kd_jbt_pgs">
<input type="text" data-table="personal" data-field="x_kd_jbt_pgs" name="x_kd_jbt_pgs" id="x_kd_jbt_pgs" size="30" maxlength="7" placeholder="<?php echo ew_HtmlEncode($personal->kd_jbt_pgs->getPlaceHolder()) ?>" value="<?php echo $personal->kd_jbt_pgs->EditValue ?>"<?php echo $personal->kd_jbt_pgs->EditAttributes() ?>>
</span>
<?php echo $personal->kd_jbt_pgs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->tgl_kd_jbt_pgs->Visible) { // tgl_kd_jbt_pgs ?>
	<div id="r_tgl_kd_jbt_pgs" class="form-group">
		<label id="elh_personal_tgl_kd_jbt_pgs" for="x_tgl_kd_jbt_pgs" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->tgl_kd_jbt_pgs->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->tgl_kd_jbt_pgs->CellAttributes() ?>>
<span id="el_personal_tgl_kd_jbt_pgs">
<input type="text" data-table="personal" data-field="x_tgl_kd_jbt_pgs" name="x_tgl_kd_jbt_pgs" id="x_tgl_kd_jbt_pgs" placeholder="<?php echo ew_HtmlEncode($personal->tgl_kd_jbt_pgs->getPlaceHolder()) ?>" value="<?php echo $personal->tgl_kd_jbt_pgs->EditValue ?>"<?php echo $personal->tgl_kd_jbt_pgs->EditAttributes() ?>>
</span>
<?php echo $personal->tgl_kd_jbt_pgs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_jbt_pjs->Visible) { // kd_jbt_pjs ?>
	<div id="r_kd_jbt_pjs" class="form-group">
		<label id="elh_personal_kd_jbt_pjs" for="x_kd_jbt_pjs" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_jbt_pjs->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_jbt_pjs->CellAttributes() ?>>
<span id="el_personal_kd_jbt_pjs">
<input type="text" data-table="personal" data-field="x_kd_jbt_pjs" name="x_kd_jbt_pjs" id="x_kd_jbt_pjs" size="30" maxlength="7" placeholder="<?php echo ew_HtmlEncode($personal->kd_jbt_pjs->getPlaceHolder()) ?>" value="<?php echo $personal->kd_jbt_pjs->EditValue ?>"<?php echo $personal->kd_jbt_pjs->EditAttributes() ?>>
</span>
<?php echo $personal->kd_jbt_pjs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->tgl_kd_jbt_pjs->Visible) { // tgl_kd_jbt_pjs ?>
	<div id="r_tgl_kd_jbt_pjs" class="form-group">
		<label id="elh_personal_tgl_kd_jbt_pjs" for="x_tgl_kd_jbt_pjs" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->tgl_kd_jbt_pjs->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->tgl_kd_jbt_pjs->CellAttributes() ?>>
<span id="el_personal_tgl_kd_jbt_pjs">
<input type="text" data-table="personal" data-field="x_tgl_kd_jbt_pjs" name="x_tgl_kd_jbt_pjs" id="x_tgl_kd_jbt_pjs" placeholder="<?php echo ew_HtmlEncode($personal->tgl_kd_jbt_pjs->getPlaceHolder()) ?>" value="<?php echo $personal->tgl_kd_jbt_pjs->EditValue ?>"<?php echo $personal->tgl_kd_jbt_pjs->EditAttributes() ?>>
</span>
<?php echo $personal->tgl_kd_jbt_pjs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_jbt_ps->Visible) { // kd_jbt_ps ?>
	<div id="r_kd_jbt_ps" class="form-group">
		<label id="elh_personal_kd_jbt_ps" for="x_kd_jbt_ps" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_jbt_ps->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_jbt_ps->CellAttributes() ?>>
<span id="el_personal_kd_jbt_ps">
<input type="text" data-table="personal" data-field="x_kd_jbt_ps" name="x_kd_jbt_ps" id="x_kd_jbt_ps" size="30" maxlength="7" placeholder="<?php echo ew_HtmlEncode($personal->kd_jbt_ps->getPlaceHolder()) ?>" value="<?php echo $personal->kd_jbt_ps->EditValue ?>"<?php echo $personal->kd_jbt_ps->EditAttributes() ?>>
</span>
<?php echo $personal->kd_jbt_ps->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->tgl_kd_jbt_ps->Visible) { // tgl_kd_jbt_ps ?>
	<div id="r_tgl_kd_jbt_ps" class="form-group">
		<label id="elh_personal_tgl_kd_jbt_ps" for="x_tgl_kd_jbt_ps" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->tgl_kd_jbt_ps->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->tgl_kd_jbt_ps->CellAttributes() ?>>
<span id="el_personal_tgl_kd_jbt_ps">
<input type="text" data-table="personal" data-field="x_tgl_kd_jbt_ps" name="x_tgl_kd_jbt_ps" id="x_tgl_kd_jbt_ps" placeholder="<?php echo ew_HtmlEncode($personal->tgl_kd_jbt_ps->getPlaceHolder()) ?>" value="<?php echo $personal->tgl_kd_jbt_ps->EditValue ?>"<?php echo $personal->tgl_kd_jbt_ps->EditAttributes() ?>>
</span>
<?php echo $personal->tgl_kd_jbt_ps->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_pat->Visible) { // kd_pat ?>
	<div id="r_kd_pat" class="form-group">
		<label id="elh_personal_kd_pat" for="x_kd_pat" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_pat->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_pat->CellAttributes() ?>>
<span id="el_personal_kd_pat">
<input type="text" data-table="personal" data-field="x_kd_pat" name="x_kd_pat" id="x_kd_pat" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($personal->kd_pat->getPlaceHolder()) ?>" value="<?php echo $personal->kd_pat->EditValue ?>"<?php echo $personal->kd_pat->EditAttributes() ?>>
</span>
<?php echo $personal->kd_pat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_gas->Visible) { // kd_gas ?>
	<div id="r_kd_gas" class="form-group">
		<label id="elh_personal_kd_gas" for="x_kd_gas" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_gas->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_gas->CellAttributes() ?>>
<span id="el_personal_kd_gas">
<input type="text" data-table="personal" data-field="x_kd_gas" name="x_kd_gas" id="x_kd_gas" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($personal->kd_gas->getPlaceHolder()) ?>" value="<?php echo $personal->kd_gas->EditValue ?>"<?php echo $personal->kd_gas->EditAttributes() ?>>
</span>
<?php echo $personal->kd_gas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->pimp_empid->Visible) { // pimp_empid ?>
	<div id="r_pimp_empid" class="form-group">
		<label id="elh_personal_pimp_empid" for="x_pimp_empid" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->pimp_empid->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->pimp_empid->CellAttributes() ?>>
<span id="el_personal_pimp_empid">
<input type="text" data-table="personal" data-field="x_pimp_empid" name="x_pimp_empid" id="x_pimp_empid" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($personal->pimp_empid->getPlaceHolder()) ?>" value="<?php echo $personal->pimp_empid->EditValue ?>"<?php echo $personal->pimp_empid->EditAttributes() ?>>
</span>
<?php echo $personal->pimp_empid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->stshift->Visible) { // stshift ?>
	<div id="r_stshift" class="form-group">
		<label id="elh_personal_stshift" for="x_stshift" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->stshift->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->stshift->CellAttributes() ?>>
<span id="el_personal_stshift">
<input type="text" data-table="personal" data-field="x_stshift" name="x_stshift" id="x_stshift" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($personal->stshift->getPlaceHolder()) ?>" value="<?php echo $personal->stshift->EditValue ?>"<?php echo $personal->stshift->EditAttributes() ?>>
</span>
<?php echo $personal->stshift->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->no_rek->Visible) { // no_rek ?>
	<div id="r_no_rek" class="form-group">
		<label id="elh_personal_no_rek" for="x_no_rek" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->no_rek->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->no_rek->CellAttributes() ?>>
<span id="el_personal_no_rek">
<input type="text" data-table="personal" data-field="x_no_rek" name="x_no_rek" id="x_no_rek" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($personal->no_rek->getPlaceHolder()) ?>" value="<?php echo $personal->no_rek->EditValue ?>"<?php echo $personal->no_rek->EditAttributes() ?>>
</span>
<?php echo $personal->no_rek->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_bank->Visible) { // kd_bank ?>
	<div id="r_kd_bank" class="form-group">
		<label id="elh_personal_kd_bank" for="x_kd_bank" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_bank->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_bank->CellAttributes() ?>>
<span id="el_personal_kd_bank">
<input type="text" data-table="personal" data-field="x_kd_bank" name="x_kd_bank" id="x_kd_bank" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($personal->kd_bank->getPlaceHolder()) ?>" value="<?php echo $personal->kd_bank->EditValue ?>"<?php echo $personal->kd_bank->EditAttributes() ?>>
</span>
<?php echo $personal->kd_bank->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_jamsostek->Visible) { // kd_jamsostek ?>
	<div id="r_kd_jamsostek" class="form-group">
		<label id="elh_personal_kd_jamsostek" for="x_kd_jamsostek" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_jamsostek->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_jamsostek->CellAttributes() ?>>
<span id="el_personal_kd_jamsostek">
<input type="text" data-table="personal" data-field="x_kd_jamsostek" name="x_kd_jamsostek" id="x_kd_jamsostek" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($personal->kd_jamsostek->getPlaceHolder()) ?>" value="<?php echo $personal->kd_jamsostek->EditValue ?>"<?php echo $personal->kd_jamsostek->EditAttributes() ?>>
</span>
<?php echo $personal->kd_jamsostek->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->acc_astek->Visible) { // acc_astek ?>
	<div id="r_acc_astek" class="form-group">
		<label id="elh_personal_acc_astek" for="x_acc_astek" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->acc_astek->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->acc_astek->CellAttributes() ?>>
<span id="el_personal_acc_astek">
<input type="text" data-table="personal" data-field="x_acc_astek" name="x_acc_astek" id="x_acc_astek" size="30" maxlength="11" placeholder="<?php echo ew_HtmlEncode($personal->acc_astek->getPlaceHolder()) ?>" value="<?php echo $personal->acc_astek->EditValue ?>"<?php echo $personal->acc_astek->EditAttributes() ?>>
</span>
<?php echo $personal->acc_astek->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->acc_dapens->Visible) { // acc_dapens ?>
	<div id="r_acc_dapens" class="form-group">
		<label id="elh_personal_acc_dapens" for="x_acc_dapens" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->acc_dapens->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->acc_dapens->CellAttributes() ?>>
<span id="el_personal_acc_dapens">
<input type="text" data-table="personal" data-field="x_acc_dapens" name="x_acc_dapens" id="x_acc_dapens" size="30" maxlength="13" placeholder="<?php echo ew_HtmlEncode($personal->acc_dapens->getPlaceHolder()) ?>" value="<?php echo $personal->acc_dapens->EditValue ?>"<?php echo $personal->acc_dapens->EditAttributes() ?>>
</span>
<?php echo $personal->acc_dapens->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->acc_kes->Visible) { // acc_kes ?>
	<div id="r_acc_kes" class="form-group">
		<label id="elh_personal_acc_kes" for="x_acc_kes" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->acc_kes->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->acc_kes->CellAttributes() ?>>
<span id="el_personal_acc_kes">
<input type="text" data-table="personal" data-field="x_acc_kes" name="x_acc_kes" id="x_acc_kes" size="30" maxlength="13" placeholder="<?php echo ew_HtmlEncode($personal->acc_kes->getPlaceHolder()) ?>" value="<?php echo $personal->acc_kes->EditValue ?>"<?php echo $personal->acc_kes->EditAttributes() ?>>
</span>
<?php echo $personal->acc_kes->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->st->Visible) { // st ?>
	<div id="r_st" class="form-group">
		<label id="elh_personal_st" for="x_st" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->st->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->st->CellAttributes() ?>>
<span id="el_personal_st">
<input type="text" data-table="personal" data-field="x_st" name="x_st" id="x_st" size="30" maxlength="1" placeholder="<?php echo ew_HtmlEncode($personal->st->getPlaceHolder()) ?>" value="<?php echo $personal->st->EditValue ?>"<?php echo $personal->st->EditAttributes() ?>>
</span>
<?php echo $personal->st->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->signature->Visible) { // signature ?>
	<div id="r_signature" class="form-group">
		<label id="elh_personal_signature" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->signature->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->signature->CellAttributes() ?>>
<span id="el_personal_signature">
<div id="fd_x_signature">
<span title="<?php echo $personal->signature->FldTitle() ? $personal->signature->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($personal->signature->ReadOnly || $personal->signature->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="personal" data-field="x_signature" name="x_signature" id="x_signature"<?php echo $personal->signature->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_signature" id= "fn_x_signature" value="<?php echo $personal->signature->Upload->FileName ?>">
<?php if (@$_POST["fa_x_signature"] == "0") { ?>
<input type="hidden" name="fa_x_signature" id= "fa_x_signature" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_signature" id= "fa_x_signature" value="1">
<?php } ?>
<input type="hidden" name="fs_x_signature" id= "fs_x_signature" value="0">
<input type="hidden" name="fx_x_signature" id= "fx_x_signature" value="<?php echo $personal->signature->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_signature" id= "fm_x_signature" value="<?php echo $personal->signature->UploadMaxFileSize ?>">
</div>
<table id="ft_x_signature" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $personal->signature->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->created_by->Visible) { // created_by ?>
	<div id="r_created_by" class="form-group">
		<label id="elh_personal_created_by" for="x_created_by" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->created_by->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->created_by->CellAttributes() ?>>
<span id="el_personal_created_by">
<input type="text" data-table="personal" data-field="x_created_by" name="x_created_by" id="x_created_by" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($personal->created_by->getPlaceHolder()) ?>" value="<?php echo $personal->created_by->EditValue ?>"<?php echo $personal->created_by->EditAttributes() ?>>
</span>
<?php echo $personal->created_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->created_date->Visible) { // created_date ?>
	<div id="r_created_date" class="form-group">
		<label id="elh_personal_created_date" for="x_created_date" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->created_date->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->created_date->CellAttributes() ?>>
<span id="el_personal_created_date">
<input type="text" data-table="personal" data-field="x_created_date" name="x_created_date" id="x_created_date" placeholder="<?php echo ew_HtmlEncode($personal->created_date->getPlaceHolder()) ?>" value="<?php echo $personal->created_date->EditValue ?>"<?php echo $personal->created_date->EditAttributes() ?>>
</span>
<?php echo $personal->created_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->last_update_by->Visible) { // last_update_by ?>
	<div id="r_last_update_by" class="form-group">
		<label id="elh_personal_last_update_by" for="x_last_update_by" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->last_update_by->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->last_update_by->CellAttributes() ?>>
<span id="el_personal_last_update_by">
<input type="text" data-table="personal" data-field="x_last_update_by" name="x_last_update_by" id="x_last_update_by" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($personal->last_update_by->getPlaceHolder()) ?>" value="<?php echo $personal->last_update_by->EditValue ?>"<?php echo $personal->last_update_by->EditAttributes() ?>>
</span>
<?php echo $personal->last_update_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->last_update_date->Visible) { // last_update_date ?>
	<div id="r_last_update_date" class="form-group">
		<label id="elh_personal_last_update_date" for="x_last_update_date" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->last_update_date->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->last_update_date->CellAttributes() ?>>
<span id="el_personal_last_update_date">
<input type="text" data-table="personal" data-field="x_last_update_date" name="x_last_update_date" id="x_last_update_date" placeholder="<?php echo ew_HtmlEncode($personal->last_update_date->getPlaceHolder()) ?>" value="<?php echo $personal->last_update_date->EditValue ?>"<?php echo $personal->last_update_date->EditAttributes() ?>>
</span>
<?php echo $personal->last_update_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->fgr_print_id->Visible) { // fgr_print_id ?>
	<div id="r_fgr_print_id" class="form-group">
		<label id="elh_personal_fgr_print_id" for="x_fgr_print_id" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->fgr_print_id->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->fgr_print_id->CellAttributes() ?>>
<span id="el_personal_fgr_print_id">
<input type="text" data-table="personal" data-field="x_fgr_print_id" name="x_fgr_print_id" id="x_fgr_print_id" size="30" placeholder="<?php echo ew_HtmlEncode($personal->fgr_print_id->getPlaceHolder()) ?>" value="<?php echo $personal->fgr_print_id->EditValue ?>"<?php echo $personal->fgr_print_id->EditAttributes() ?>>
</span>
<?php echo $personal->fgr_print_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_jbt_eselon->Visible) { // kd_jbt_eselon ?>
	<div id="r_kd_jbt_eselon" class="form-group">
		<label id="elh_personal_kd_jbt_eselon" for="x_kd_jbt_eselon" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_jbt_eselon->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_jbt_eselon->CellAttributes() ?>>
<span id="el_personal_kd_jbt_eselon">
<input type="text" data-table="personal" data-field="x_kd_jbt_eselon" name="x_kd_jbt_eselon" id="x_kd_jbt_eselon" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($personal->kd_jbt_eselon->getPlaceHolder()) ?>" value="<?php echo $personal->kd_jbt_eselon->EditValue ?>"<?php echo $personal->kd_jbt_eselon->EditAttributes() ?>>
</span>
<?php echo $personal->kd_jbt_eselon->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->npwp->Visible) { // npwp ?>
	<div id="r_npwp" class="form-group">
		<label id="elh_personal_npwp" for="x_npwp" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->npwp->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->npwp->CellAttributes() ?>>
<span id="el_personal_npwp">
<input type="text" data-table="personal" data-field="x_npwp" name="x_npwp" id="x_npwp" size="30" maxlength="23" placeholder="<?php echo ew_HtmlEncode($personal->npwp->getPlaceHolder()) ?>" value="<?php echo $personal->npwp->EditValue ?>"<?php echo $personal->npwp->EditAttributes() ?>>
</span>
<?php echo $personal->npwp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->paraf->Visible) { // paraf ?>
	<div id="r_paraf" class="form-group">
		<label id="elh_personal_paraf" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->paraf->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->paraf->CellAttributes() ?>>
<span id="el_personal_paraf">
<div id="fd_x_paraf">
<span title="<?php echo $personal->paraf->FldTitle() ? $personal->paraf->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($personal->paraf->ReadOnly || $personal->paraf->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="personal" data-field="x_paraf" name="x_paraf" id="x_paraf"<?php echo $personal->paraf->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_paraf" id= "fn_x_paraf" value="<?php echo $personal->paraf->Upload->FileName ?>">
<?php if (@$_POST["fa_x_paraf"] == "0") { ?>
<input type="hidden" name="fa_x_paraf" id= "fa_x_paraf" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_paraf" id= "fa_x_paraf" value="1">
<?php } ?>
<input type="hidden" name="fs_x_paraf" id= "fs_x_paraf" value="0">
<input type="hidden" name="fx_x_paraf" id= "fx_x_paraf" value="<?php echo $personal->paraf->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_paraf" id= "fm_x_paraf" value="<?php echo $personal->paraf->UploadMaxFileSize ?>">
</div>
<table id="ft_x_paraf" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $personal->paraf->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->tgl_keluar->Visible) { // tgl_keluar ?>
	<div id="r_tgl_keluar" class="form-group">
		<label id="elh_personal_tgl_keluar" for="x_tgl_keluar" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->tgl_keluar->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->tgl_keluar->CellAttributes() ?>>
<span id="el_personal_tgl_keluar">
<input type="text" data-table="personal" data-field="x_tgl_keluar" name="x_tgl_keluar" id="x_tgl_keluar" placeholder="<?php echo ew_HtmlEncode($personal->tgl_keluar->getPlaceHolder()) ?>" value="<?php echo $personal->tgl_keluar->EditValue ?>"<?php echo $personal->tgl_keluar->EditAttributes() ?>>
</span>
<?php echo $personal->tgl_keluar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->nama_nasabah->Visible) { // nama_nasabah ?>
	<div id="r_nama_nasabah" class="form-group">
		<label id="elh_personal_nama_nasabah" for="x_nama_nasabah" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->nama_nasabah->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->nama_nasabah->CellAttributes() ?>>
<span id="el_personal_nama_nasabah">
<input type="text" data-table="personal" data-field="x_nama_nasabah" name="x_nama_nasabah" id="x_nama_nasabah" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($personal->nama_nasabah->getPlaceHolder()) ?>" value="<?php echo $personal->nama_nasabah->EditValue ?>"<?php echo $personal->nama_nasabah->EditAttributes() ?>>
</span>
<?php echo $personal->nama_nasabah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->no_ktp->Visible) { // no_ktp ?>
	<div id="r_no_ktp" class="form-group">
		<label id="elh_personal_no_ktp" for="x_no_ktp" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->no_ktp->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->no_ktp->CellAttributes() ?>>
<span id="el_personal_no_ktp">
<input type="text" data-table="personal" data-field="x_no_ktp" name="x_no_ktp" id="x_no_ktp" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($personal->no_ktp->getPlaceHolder()) ?>" value="<?php echo $personal->no_ktp->EditValue ?>"<?php echo $personal->no_ktp->EditAttributes() ?>>
</span>
<?php echo $personal->no_ktp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->no_kokar->Visible) { // no_kokar ?>
	<div id="r_no_kokar" class="form-group">
		<label id="elh_personal_no_kokar" for="x_no_kokar" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->no_kokar->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->no_kokar->CellAttributes() ?>>
<span id="el_personal_no_kokar">
<input type="text" data-table="personal" data-field="x_no_kokar" name="x_no_kokar" id="x_no_kokar" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($personal->no_kokar->getPlaceHolder()) ?>" value="<?php echo $personal->no_kokar->EditValue ?>"<?php echo $personal->no_kokar->EditAttributes() ?>>
</span>
<?php echo $personal->no_kokar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->no_bmw->Visible) { // no_bmw ?>
	<div id="r_no_bmw" class="form-group">
		<label id="elh_personal_no_bmw" for="x_no_bmw" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->no_bmw->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->no_bmw->CellAttributes() ?>>
<span id="el_personal_no_bmw">
<input type="text" data-table="personal" data-field="x_no_bmw" name="x_no_bmw" id="x_no_bmw" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($personal->no_bmw->getPlaceHolder()) ?>" value="<?php echo $personal->no_bmw->EditValue ?>"<?php echo $personal->no_bmw->EditAttributes() ?>>
</span>
<?php echo $personal->no_bmw->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->no_bpjs_ketenagakerjaan->Visible) { // no_bpjs_ketenagakerjaan ?>
	<div id="r_no_bpjs_ketenagakerjaan" class="form-group">
		<label id="elh_personal_no_bpjs_ketenagakerjaan" for="x_no_bpjs_ketenagakerjaan" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->no_bpjs_ketenagakerjaan->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->no_bpjs_ketenagakerjaan->CellAttributes() ?>>
<span id="el_personal_no_bpjs_ketenagakerjaan">
<input type="text" data-table="personal" data-field="x_no_bpjs_ketenagakerjaan" name="x_no_bpjs_ketenagakerjaan" id="x_no_bpjs_ketenagakerjaan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($personal->no_bpjs_ketenagakerjaan->getPlaceHolder()) ?>" value="<?php echo $personal->no_bpjs_ketenagakerjaan->EditValue ?>"<?php echo $personal->no_bpjs_ketenagakerjaan->EditAttributes() ?>>
</span>
<?php echo $personal->no_bpjs_ketenagakerjaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->no_bpjs_kesehatan->Visible) { // no_bpjs_kesehatan ?>
	<div id="r_no_bpjs_kesehatan" class="form-group">
		<label id="elh_personal_no_bpjs_kesehatan" for="x_no_bpjs_kesehatan" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->no_bpjs_kesehatan->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->no_bpjs_kesehatan->CellAttributes() ?>>
<span id="el_personal_no_bpjs_kesehatan">
<input type="text" data-table="personal" data-field="x_no_bpjs_kesehatan" name="x_no_bpjs_kesehatan" id="x_no_bpjs_kesehatan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($personal->no_bpjs_kesehatan->getPlaceHolder()) ?>" value="<?php echo $personal->no_bpjs_kesehatan->EditValue ?>"<?php echo $personal->no_bpjs_kesehatan->EditAttributes() ?>>
</span>
<?php echo $personal->no_bpjs_kesehatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->eselon->Visible) { // eselon ?>
	<div id="r_eselon" class="form-group">
		<label id="elh_personal_eselon" for="x_eselon" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->eselon->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->eselon->CellAttributes() ?>>
<span id="el_personal_eselon">
<input type="text" data-table="personal" data-field="x_eselon" name="x_eselon" id="x_eselon" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($personal->eselon->getPlaceHolder()) ?>" value="<?php echo $personal->eselon->EditValue ?>"<?php echo $personal->eselon->EditAttributes() ?>>
</span>
<?php echo $personal->eselon->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_jenjang->Visible) { // kd_jenjang ?>
	<div id="r_kd_jenjang" class="form-group">
		<label id="elh_personal_kd_jenjang" for="x_kd_jenjang" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_jenjang->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_jenjang->CellAttributes() ?>>
<span id="el_personal_kd_jenjang">
<input type="text" data-table="personal" data-field="x_kd_jenjang" name="x_kd_jenjang" id="x_kd_jenjang" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($personal->kd_jenjang->getPlaceHolder()) ?>" value="<?php echo $personal->kd_jenjang->EditValue ?>"<?php echo $personal->kd_jenjang->EditAttributes() ?>>
</span>
<?php echo $personal->kd_jenjang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_jbt_esl->Visible) { // kd_jbt_esl ?>
	<div id="r_kd_jbt_esl" class="form-group">
		<label id="elh_personal_kd_jbt_esl" for="x_kd_jbt_esl" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_jbt_esl->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_jbt_esl->CellAttributes() ?>>
<span id="el_personal_kd_jbt_esl">
<input type="text" data-table="personal" data-field="x_kd_jbt_esl" name="x_kd_jbt_esl" id="x_kd_jbt_esl" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($personal->kd_jbt_esl->getPlaceHolder()) ?>" value="<?php echo $personal->kd_jbt_esl->EditValue ?>"<?php echo $personal->kd_jbt_esl->EditAttributes() ?>>
</span>
<?php echo $personal->kd_jbt_esl->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->tgl_jbt_esl->Visible) { // tgl_jbt_esl ?>
	<div id="r_tgl_jbt_esl" class="form-group">
		<label id="elh_personal_tgl_jbt_esl" for="x_tgl_jbt_esl" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->tgl_jbt_esl->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->tgl_jbt_esl->CellAttributes() ?>>
<span id="el_personal_tgl_jbt_esl">
<input type="text" data-table="personal" data-field="x_tgl_jbt_esl" name="x_tgl_jbt_esl" id="x_tgl_jbt_esl" placeholder="<?php echo ew_HtmlEncode($personal->tgl_jbt_esl->getPlaceHolder()) ?>" value="<?php echo $personal->tgl_jbt_esl->EditValue ?>"<?php echo $personal->tgl_jbt_esl->EditAttributes() ?>>
</span>
<?php echo $personal->tgl_jbt_esl->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->org_id->Visible) { // org_id ?>
	<div id="r_org_id" class="form-group">
		<label id="elh_personal_org_id" for="x_org_id" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->org_id->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->org_id->CellAttributes() ?>>
<span id="el_personal_org_id">
<input type="text" data-table="personal" data-field="x_org_id" name="x_org_id" id="x_org_id" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($personal->org_id->getPlaceHolder()) ?>" value="<?php echo $personal->org_id->EditValue ?>"<?php echo $personal->org_id->EditAttributes() ?>>
</span>
<?php echo $personal->org_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->picture->Visible) { // picture ?>
	<div id="r_picture" class="form-group">
		<label id="elh_personal_picture" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->picture->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->picture->CellAttributes() ?>>
<span id="el_personal_picture">
<div id="fd_x_picture">
<span title="<?php echo $personal->picture->FldTitle() ? $personal->picture->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($personal->picture->ReadOnly || $personal->picture->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="personal" data-field="x_picture" name="x_picture" id="x_picture"<?php echo $personal->picture->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_picture" id= "fn_x_picture" value="<?php echo $personal->picture->Upload->FileName ?>">
<?php if (@$_POST["fa_x_picture"] == "0") { ?>
<input type="hidden" name="fa_x_picture" id= "fa_x_picture" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_picture" id= "fa_x_picture" value="1">
<?php } ?>
<input type="hidden" name="fs_x_picture" id= "fs_x_picture" value="0">
<input type="hidden" name="fx_x_picture" id= "fx_x_picture" value="<?php echo $personal->picture->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_picture" id= "fm_x_picture" value="<?php echo $personal->picture->UploadMaxFileSize ?>">
</div>
<table id="ft_x_picture" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $personal->picture->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->kd_payroll->Visible) { // kd_payroll ?>
	<div id="r_kd_payroll" class="form-group">
		<label id="elh_personal_kd_payroll" for="x_kd_payroll" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->kd_payroll->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->kd_payroll->CellAttributes() ?>>
<span id="el_personal_kd_payroll">
<input type="text" data-table="personal" data-field="x_kd_payroll" name="x_kd_payroll" id="x_kd_payroll" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($personal->kd_payroll->getPlaceHolder()) ?>" value="<?php echo $personal->kd_payroll->EditValue ?>"<?php echo $personal->kd_payroll->EditAttributes() ?>>
</span>
<?php echo $personal->kd_payroll->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->id_wn->Visible) { // id_wn ?>
	<div id="r_id_wn" class="form-group">
		<label id="elh_personal_id_wn" for="x_id_wn" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->id_wn->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->id_wn->CellAttributes() ?>>
<span id="el_personal_id_wn">
<input type="text" data-table="personal" data-field="x_id_wn" name="x_id_wn" id="x_id_wn" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($personal->id_wn->getPlaceHolder()) ?>" value="<?php echo $personal->id_wn->EditValue ?>"<?php echo $personal->id_wn->EditAttributes() ?>>
</span>
<?php echo $personal->id_wn->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($personal->no_anggota_kkms->Visible) { // no_anggota_kkms ?>
	<div id="r_no_anggota_kkms" class="form-group">
		<label id="elh_personal_no_anggota_kkms" for="x_no_anggota_kkms" class="<?php echo $personal_edit->LeftColumnClass ?>"><?php echo $personal->no_anggota_kkms->FldCaption() ?></label>
		<div class="<?php echo $personal_edit->RightColumnClass ?>"><div<?php echo $personal->no_anggota_kkms->CellAttributes() ?>>
<span id="el_personal_no_anggota_kkms">
<input type="text" data-table="personal" data-field="x_no_anggota_kkms" name="x_no_anggota_kkms" id="x_no_anggota_kkms" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($personal->no_anggota_kkms->getPlaceHolder()) ?>" value="<?php echo $personal->no_anggota_kkms->EditValue ?>"<?php echo $personal->no_anggota_kkms->EditAttributes() ?>>
</span>
<?php echo $personal->no_anggota_kkms->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$personal_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $personal_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $personal_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fpersonaledit.Init();
</script>
<?php
$personal_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$personal_edit->Page_Terminate();
?>
