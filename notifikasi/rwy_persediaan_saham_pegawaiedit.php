<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "rwy_persediaan_saham_pegawaiinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$rwy_persediaan_saham_pegawai_edit = NULL; // Initialize page object first

class crwy_persediaan_saham_pegawai_edit extends crwy_persediaan_saham_pegawai {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'rwy_persediaan_saham_pegawai';

	// Page object name
	var $PageObjName = 'rwy_persediaan_saham_pegawai_edit';

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

		// Table object (rwy_persediaan_saham_pegawai)
		if (!isset($GLOBALS["rwy_persediaan_saham_pegawai"]) || get_class($GLOBALS["rwy_persediaan_saham_pegawai"]) == "crwy_persediaan_saham_pegawai") {
			$GLOBALS["rwy_persediaan_saham_pegawai"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["rwy_persediaan_saham_pegawai"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rwy_persediaan_saham_pegawai', TRUE);

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
		$this->nip->SetVisibility();
		$this->kode_unit_organisasi->SetVisibility();
		$this->kode_unit_kerja->SetVisibility();
		$this->periode_bulan->SetVisibility();
		$this->periode_tahun->SetVisibility();
		$this->industri_kontruksi_abim_ups_anak->SetVisibility();
		$this->realty_ups_anak->SetVisibility();
		$this->pst_ups_anak->SetVisibility();
		$this->wton_anak_ups_anak->SetVisibility();
		$this->industri_kontruksi_abim_ups_dianak->SetVisibility();
		$this->realty_ups_dianak->SetVisibility();
		$this->esa_dianak->SetVisibility();
		$this->esop_dianak->SetVisibility();
		$this->change_by->SetVisibility();
		$this->change_date->SetVisibility();

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
		global $EW_EXPORT, $rwy_persediaan_saham_pegawai;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($rwy_persediaan_saham_pegawai);
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
					if ($pageName == "rwy_persediaan_saham_pegawaiview.php")
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
					$this->Page_Terminate("rwy_persediaan_saham_pegawailist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "rwy_persediaan_saham_pegawailist.php")
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
		if (!$this->nip->FldIsDetailKey) {
			$this->nip->setFormValue($objForm->GetValue("x_nip"));
		}
		if (!$this->kode_unit_organisasi->FldIsDetailKey) {
			$this->kode_unit_organisasi->setFormValue($objForm->GetValue("x_kode_unit_organisasi"));
		}
		if (!$this->kode_unit_kerja->FldIsDetailKey) {
			$this->kode_unit_kerja->setFormValue($objForm->GetValue("x_kode_unit_kerja"));
		}
		if (!$this->periode_bulan->FldIsDetailKey) {
			$this->periode_bulan->setFormValue($objForm->GetValue("x_periode_bulan"));
		}
		if (!$this->periode_tahun->FldIsDetailKey) {
			$this->periode_tahun->setFormValue($objForm->GetValue("x_periode_tahun"));
		}
		if (!$this->industri_kontruksi_abim_ups_anak->FldIsDetailKey) {
			$this->industri_kontruksi_abim_ups_anak->setFormValue($objForm->GetValue("x_industri_kontruksi_abim_ups_anak"));
		}
		if (!$this->realty_ups_anak->FldIsDetailKey) {
			$this->realty_ups_anak->setFormValue($objForm->GetValue("x_realty_ups_anak"));
		}
		if (!$this->pst_ups_anak->FldIsDetailKey) {
			$this->pst_ups_anak->setFormValue($objForm->GetValue("x_pst_ups_anak"));
		}
		if (!$this->wton_anak_ups_anak->FldIsDetailKey) {
			$this->wton_anak_ups_anak->setFormValue($objForm->GetValue("x_wton_anak_ups_anak"));
		}
		if (!$this->industri_kontruksi_abim_ups_dianak->FldIsDetailKey) {
			$this->industri_kontruksi_abim_ups_dianak->setFormValue($objForm->GetValue("x_industri_kontruksi_abim_ups_dianak"));
		}
		if (!$this->realty_ups_dianak->FldIsDetailKey) {
			$this->realty_ups_dianak->setFormValue($objForm->GetValue("x_realty_ups_dianak"));
		}
		if (!$this->esa_dianak->FldIsDetailKey) {
			$this->esa_dianak->setFormValue($objForm->GetValue("x_esa_dianak"));
		}
		if (!$this->esop_dianak->FldIsDetailKey) {
			$this->esop_dianak->setFormValue($objForm->GetValue("x_esop_dianak"));
		}
		if (!$this->change_by->FldIsDetailKey) {
			$this->change_by->setFormValue($objForm->GetValue("x_change_by"));
		}
		if (!$this->change_date->FldIsDetailKey) {
			$this->change_date->setFormValue($objForm->GetValue("x_change_date"));
			$this->change_date->CurrentValue = ew_UnFormatDateTime($this->change_date->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->nip->CurrentValue = $this->nip->FormValue;
		$this->kode_unit_organisasi->CurrentValue = $this->kode_unit_organisasi->FormValue;
		$this->kode_unit_kerja->CurrentValue = $this->kode_unit_kerja->FormValue;
		$this->periode_bulan->CurrentValue = $this->periode_bulan->FormValue;
		$this->periode_tahun->CurrentValue = $this->periode_tahun->FormValue;
		$this->industri_kontruksi_abim_ups_anak->CurrentValue = $this->industri_kontruksi_abim_ups_anak->FormValue;
		$this->realty_ups_anak->CurrentValue = $this->realty_ups_anak->FormValue;
		$this->pst_ups_anak->CurrentValue = $this->pst_ups_anak->FormValue;
		$this->wton_anak_ups_anak->CurrentValue = $this->wton_anak_ups_anak->FormValue;
		$this->industri_kontruksi_abim_ups_dianak->CurrentValue = $this->industri_kontruksi_abim_ups_dianak->FormValue;
		$this->realty_ups_dianak->CurrentValue = $this->realty_ups_dianak->FormValue;
		$this->esa_dianak->CurrentValue = $this->esa_dianak->FormValue;
		$this->esop_dianak->CurrentValue = $this->esop_dianak->FormValue;
		$this->change_by->CurrentValue = $this->change_by->FormValue;
		$this->change_date->CurrentValue = $this->change_date->FormValue;
		$this->change_date->CurrentValue = ew_UnFormatDateTime($this->change_date->CurrentValue, 0);
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
		$this->kode_unit_organisasi->setDbValue($row['kode_unit_organisasi']);
		$this->kode_unit_kerja->setDbValue($row['kode_unit_kerja']);
		$this->periode_bulan->setDbValue($row['periode_bulan']);
		$this->periode_tahun->setDbValue($row['periode_tahun']);
		$this->industri_kontruksi_abim_ups_anak->setDbValue($row['industri_kontruksi_abim_ups_anak']);
		$this->realty_ups_anak->setDbValue($row['realty_ups_anak']);
		$this->pst_ups_anak->setDbValue($row['pst_ups_anak']);
		$this->wton_anak_ups_anak->setDbValue($row['wton_anak_ups_anak']);
		$this->industri_kontruksi_abim_ups_dianak->setDbValue($row['industri_kontruksi_abim_ups_dianak']);
		$this->realty_ups_dianak->setDbValue($row['realty_ups_dianak']);
		$this->esa_dianak->setDbValue($row['esa_dianak']);
		$this->esop_dianak->setDbValue($row['esop_dianak']);
		$this->change_by->setDbValue($row['change_by']);
		$this->change_date->setDbValue($row['change_date']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['nip'] = NULL;
		$row['kode_unit_organisasi'] = NULL;
		$row['kode_unit_kerja'] = NULL;
		$row['periode_bulan'] = NULL;
		$row['periode_tahun'] = NULL;
		$row['industri_kontruksi_abim_ups_anak'] = NULL;
		$row['realty_ups_anak'] = NULL;
		$row['pst_ups_anak'] = NULL;
		$row['wton_anak_ups_anak'] = NULL;
		$row['industri_kontruksi_abim_ups_dianak'] = NULL;
		$row['realty_ups_dianak'] = NULL;
		$row['esa_dianak'] = NULL;
		$row['esop_dianak'] = NULL;
		$row['change_by'] = NULL;
		$row['change_date'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->nip->DbValue = $row['nip'];
		$this->kode_unit_organisasi->DbValue = $row['kode_unit_organisasi'];
		$this->kode_unit_kerja->DbValue = $row['kode_unit_kerja'];
		$this->periode_bulan->DbValue = $row['periode_bulan'];
		$this->periode_tahun->DbValue = $row['periode_tahun'];
		$this->industri_kontruksi_abim_ups_anak->DbValue = $row['industri_kontruksi_abim_ups_anak'];
		$this->realty_ups_anak->DbValue = $row['realty_ups_anak'];
		$this->pst_ups_anak->DbValue = $row['pst_ups_anak'];
		$this->wton_anak_ups_anak->DbValue = $row['wton_anak_ups_anak'];
		$this->industri_kontruksi_abim_ups_dianak->DbValue = $row['industri_kontruksi_abim_ups_dianak'];
		$this->realty_ups_dianak->DbValue = $row['realty_ups_dianak'];
		$this->esa_dianak->DbValue = $row['esa_dianak'];
		$this->esop_dianak->DbValue = $row['esop_dianak'];
		$this->change_by->DbValue = $row['change_by'];
		$this->change_date->DbValue = $row['change_date'];
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
		// kode_unit_organisasi
		// kode_unit_kerja
		// periode_bulan
		// periode_tahun
		// industri_kontruksi_abim_ups_anak
		// realty_ups_anak
		// pst_ups_anak
		// wton_anak_ups_anak
		// industri_kontruksi_abim_ups_dianak
		// realty_ups_dianak
		// esa_dianak
		// esop_dianak
		// change_by
		// change_date

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nip
		$this->nip->ViewValue = $this->nip->CurrentValue;
		$this->nip->ViewCustomAttributes = "";

		// kode_unit_organisasi
		$this->kode_unit_organisasi->ViewValue = $this->kode_unit_organisasi->CurrentValue;
		$this->kode_unit_organisasi->ViewCustomAttributes = "";

		// kode_unit_kerja
		$this->kode_unit_kerja->ViewValue = $this->kode_unit_kerja->CurrentValue;
		$this->kode_unit_kerja->ViewCustomAttributes = "";

		// periode_bulan
		$this->periode_bulan->ViewValue = $this->periode_bulan->CurrentValue;
		$this->periode_bulan->ViewCustomAttributes = "";

		// periode_tahun
		$this->periode_tahun->ViewValue = $this->periode_tahun->CurrentValue;
		$this->periode_tahun->ViewCustomAttributes = "";

		// industri_kontruksi_abim_ups_anak
		$this->industri_kontruksi_abim_ups_anak->ViewValue = $this->industri_kontruksi_abim_ups_anak->CurrentValue;
		$this->industri_kontruksi_abim_ups_anak->ViewCustomAttributes = "";

		// realty_ups_anak
		$this->realty_ups_anak->ViewValue = $this->realty_ups_anak->CurrentValue;
		$this->realty_ups_anak->ViewCustomAttributes = "";

		// pst_ups_anak
		$this->pst_ups_anak->ViewValue = $this->pst_ups_anak->CurrentValue;
		$this->pst_ups_anak->ViewCustomAttributes = "";

		// wton_anak_ups_anak
		$this->wton_anak_ups_anak->ViewValue = $this->wton_anak_ups_anak->CurrentValue;
		$this->wton_anak_ups_anak->ViewCustomAttributes = "";

		// industri_kontruksi_abim_ups_dianak
		$this->industri_kontruksi_abim_ups_dianak->ViewValue = $this->industri_kontruksi_abim_ups_dianak->CurrentValue;
		$this->industri_kontruksi_abim_ups_dianak->ViewCustomAttributes = "";

		// realty_ups_dianak
		$this->realty_ups_dianak->ViewValue = $this->realty_ups_dianak->CurrentValue;
		$this->realty_ups_dianak->ViewCustomAttributes = "";

		// esa_dianak
		$this->esa_dianak->ViewValue = $this->esa_dianak->CurrentValue;
		$this->esa_dianak->ViewCustomAttributes = "";

		// esop_dianak
		$this->esop_dianak->ViewValue = $this->esop_dianak->CurrentValue;
		$this->esop_dianak->ViewCustomAttributes = "";

		// change_by
		$this->change_by->ViewValue = $this->change_by->CurrentValue;
		$this->change_by->ViewCustomAttributes = "";

		// change_date
		$this->change_date->ViewValue = $this->change_date->CurrentValue;
		$this->change_date->ViewValue = ew_FormatDateTime($this->change_date->ViewValue, 0);
		$this->change_date->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// nip
			$this->nip->LinkCustomAttributes = "";
			$this->nip->HrefValue = "";
			$this->nip->TooltipValue = "";

			// kode_unit_organisasi
			$this->kode_unit_organisasi->LinkCustomAttributes = "";
			$this->kode_unit_organisasi->HrefValue = "";
			$this->kode_unit_organisasi->TooltipValue = "";

			// kode_unit_kerja
			$this->kode_unit_kerja->LinkCustomAttributes = "";
			$this->kode_unit_kerja->HrefValue = "";
			$this->kode_unit_kerja->TooltipValue = "";

			// periode_bulan
			$this->periode_bulan->LinkCustomAttributes = "";
			$this->periode_bulan->HrefValue = "";
			$this->periode_bulan->TooltipValue = "";

			// periode_tahun
			$this->periode_tahun->LinkCustomAttributes = "";
			$this->periode_tahun->HrefValue = "";
			$this->periode_tahun->TooltipValue = "";

			// industri_kontruksi_abim_ups_anak
			$this->industri_kontruksi_abim_ups_anak->LinkCustomAttributes = "";
			$this->industri_kontruksi_abim_ups_anak->HrefValue = "";
			$this->industri_kontruksi_abim_ups_anak->TooltipValue = "";

			// realty_ups_anak
			$this->realty_ups_anak->LinkCustomAttributes = "";
			$this->realty_ups_anak->HrefValue = "";
			$this->realty_ups_anak->TooltipValue = "";

			// pst_ups_anak
			$this->pst_ups_anak->LinkCustomAttributes = "";
			$this->pst_ups_anak->HrefValue = "";
			$this->pst_ups_anak->TooltipValue = "";

			// wton_anak_ups_anak
			$this->wton_anak_ups_anak->LinkCustomAttributes = "";
			$this->wton_anak_ups_anak->HrefValue = "";
			$this->wton_anak_ups_anak->TooltipValue = "";

			// industri_kontruksi_abim_ups_dianak
			$this->industri_kontruksi_abim_ups_dianak->LinkCustomAttributes = "";
			$this->industri_kontruksi_abim_ups_dianak->HrefValue = "";
			$this->industri_kontruksi_abim_ups_dianak->TooltipValue = "";

			// realty_ups_dianak
			$this->realty_ups_dianak->LinkCustomAttributes = "";
			$this->realty_ups_dianak->HrefValue = "";
			$this->realty_ups_dianak->TooltipValue = "";

			// esa_dianak
			$this->esa_dianak->LinkCustomAttributes = "";
			$this->esa_dianak->HrefValue = "";
			$this->esa_dianak->TooltipValue = "";

			// esop_dianak
			$this->esop_dianak->LinkCustomAttributes = "";
			$this->esop_dianak->HrefValue = "";
			$this->esop_dianak->TooltipValue = "";

			// change_by
			$this->change_by->LinkCustomAttributes = "";
			$this->change_by->HrefValue = "";
			$this->change_by->TooltipValue = "";

			// change_date
			$this->change_date->LinkCustomAttributes = "";
			$this->change_date->HrefValue = "";
			$this->change_date->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// nip
			$this->nip->EditAttrs["class"] = "form-control";
			$this->nip->EditCustomAttributes = "";
			$this->nip->EditValue = ew_HtmlEncode($this->nip->CurrentValue);
			$this->nip->PlaceHolder = ew_RemoveHtml($this->nip->FldCaption());

			// kode_unit_organisasi
			$this->kode_unit_organisasi->EditAttrs["class"] = "form-control";
			$this->kode_unit_organisasi->EditCustomAttributes = "";
			$this->kode_unit_organisasi->EditValue = ew_HtmlEncode($this->kode_unit_organisasi->CurrentValue);
			$this->kode_unit_organisasi->PlaceHolder = ew_RemoveHtml($this->kode_unit_organisasi->FldCaption());

			// kode_unit_kerja
			$this->kode_unit_kerja->EditAttrs["class"] = "form-control";
			$this->kode_unit_kerja->EditCustomAttributes = "";
			$this->kode_unit_kerja->EditValue = ew_HtmlEncode($this->kode_unit_kerja->CurrentValue);
			$this->kode_unit_kerja->PlaceHolder = ew_RemoveHtml($this->kode_unit_kerja->FldCaption());

			// periode_bulan
			$this->periode_bulan->EditAttrs["class"] = "form-control";
			$this->periode_bulan->EditCustomAttributes = "";
			$this->periode_bulan->EditValue = ew_HtmlEncode($this->periode_bulan->CurrentValue);
			$this->periode_bulan->PlaceHolder = ew_RemoveHtml($this->periode_bulan->FldCaption());

			// periode_tahun
			$this->periode_tahun->EditAttrs["class"] = "form-control";
			$this->periode_tahun->EditCustomAttributes = "";
			$this->periode_tahun->EditValue = ew_HtmlEncode($this->periode_tahun->CurrentValue);
			$this->periode_tahun->PlaceHolder = ew_RemoveHtml($this->periode_tahun->FldCaption());

			// industri_kontruksi_abim_ups_anak
			$this->industri_kontruksi_abim_ups_anak->EditAttrs["class"] = "form-control";
			$this->industri_kontruksi_abim_ups_anak->EditCustomAttributes = "";
			$this->industri_kontruksi_abim_ups_anak->EditValue = ew_HtmlEncode($this->industri_kontruksi_abim_ups_anak->CurrentValue);
			$this->industri_kontruksi_abim_ups_anak->PlaceHolder = ew_RemoveHtml($this->industri_kontruksi_abim_ups_anak->FldCaption());

			// realty_ups_anak
			$this->realty_ups_anak->EditAttrs["class"] = "form-control";
			$this->realty_ups_anak->EditCustomAttributes = "";
			$this->realty_ups_anak->EditValue = ew_HtmlEncode($this->realty_ups_anak->CurrentValue);
			$this->realty_ups_anak->PlaceHolder = ew_RemoveHtml($this->realty_ups_anak->FldCaption());

			// pst_ups_anak
			$this->pst_ups_anak->EditAttrs["class"] = "form-control";
			$this->pst_ups_anak->EditCustomAttributes = "";
			$this->pst_ups_anak->EditValue = ew_HtmlEncode($this->pst_ups_anak->CurrentValue);
			$this->pst_ups_anak->PlaceHolder = ew_RemoveHtml($this->pst_ups_anak->FldCaption());

			// wton_anak_ups_anak
			$this->wton_anak_ups_anak->EditAttrs["class"] = "form-control";
			$this->wton_anak_ups_anak->EditCustomAttributes = "";
			$this->wton_anak_ups_anak->EditValue = ew_HtmlEncode($this->wton_anak_ups_anak->CurrentValue);
			$this->wton_anak_ups_anak->PlaceHolder = ew_RemoveHtml($this->wton_anak_ups_anak->FldCaption());

			// industri_kontruksi_abim_ups_dianak
			$this->industri_kontruksi_abim_ups_dianak->EditAttrs["class"] = "form-control";
			$this->industri_kontruksi_abim_ups_dianak->EditCustomAttributes = "";
			$this->industri_kontruksi_abim_ups_dianak->EditValue = ew_HtmlEncode($this->industri_kontruksi_abim_ups_dianak->CurrentValue);
			$this->industri_kontruksi_abim_ups_dianak->PlaceHolder = ew_RemoveHtml($this->industri_kontruksi_abim_ups_dianak->FldCaption());

			// realty_ups_dianak
			$this->realty_ups_dianak->EditAttrs["class"] = "form-control";
			$this->realty_ups_dianak->EditCustomAttributes = "";
			$this->realty_ups_dianak->EditValue = ew_HtmlEncode($this->realty_ups_dianak->CurrentValue);
			$this->realty_ups_dianak->PlaceHolder = ew_RemoveHtml($this->realty_ups_dianak->FldCaption());

			// esa_dianak
			$this->esa_dianak->EditAttrs["class"] = "form-control";
			$this->esa_dianak->EditCustomAttributes = "";
			$this->esa_dianak->EditValue = ew_HtmlEncode($this->esa_dianak->CurrentValue);
			$this->esa_dianak->PlaceHolder = ew_RemoveHtml($this->esa_dianak->FldCaption());

			// esop_dianak
			$this->esop_dianak->EditAttrs["class"] = "form-control";
			$this->esop_dianak->EditCustomAttributes = "";
			$this->esop_dianak->EditValue = ew_HtmlEncode($this->esop_dianak->CurrentValue);
			$this->esop_dianak->PlaceHolder = ew_RemoveHtml($this->esop_dianak->FldCaption());

			// change_by
			$this->change_by->EditAttrs["class"] = "form-control";
			$this->change_by->EditCustomAttributes = "";
			$this->change_by->EditValue = ew_HtmlEncode($this->change_by->CurrentValue);
			$this->change_by->PlaceHolder = ew_RemoveHtml($this->change_by->FldCaption());

			// change_date
			$this->change_date->EditAttrs["class"] = "form-control";
			$this->change_date->EditCustomAttributes = "";
			$this->change_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->change_date->CurrentValue, 8));
			$this->change_date->PlaceHolder = ew_RemoveHtml($this->change_date->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// nip
			$this->nip->LinkCustomAttributes = "";
			$this->nip->HrefValue = "";

			// kode_unit_organisasi
			$this->kode_unit_organisasi->LinkCustomAttributes = "";
			$this->kode_unit_organisasi->HrefValue = "";

			// kode_unit_kerja
			$this->kode_unit_kerja->LinkCustomAttributes = "";
			$this->kode_unit_kerja->HrefValue = "";

			// periode_bulan
			$this->periode_bulan->LinkCustomAttributes = "";
			$this->periode_bulan->HrefValue = "";

			// periode_tahun
			$this->periode_tahun->LinkCustomAttributes = "";
			$this->periode_tahun->HrefValue = "";

			// industri_kontruksi_abim_ups_anak
			$this->industri_kontruksi_abim_ups_anak->LinkCustomAttributes = "";
			$this->industri_kontruksi_abim_ups_anak->HrefValue = "";

			// realty_ups_anak
			$this->realty_ups_anak->LinkCustomAttributes = "";
			$this->realty_ups_anak->HrefValue = "";

			// pst_ups_anak
			$this->pst_ups_anak->LinkCustomAttributes = "";
			$this->pst_ups_anak->HrefValue = "";

			// wton_anak_ups_anak
			$this->wton_anak_ups_anak->LinkCustomAttributes = "";
			$this->wton_anak_ups_anak->HrefValue = "";

			// industri_kontruksi_abim_ups_dianak
			$this->industri_kontruksi_abim_ups_dianak->LinkCustomAttributes = "";
			$this->industri_kontruksi_abim_ups_dianak->HrefValue = "";

			// realty_ups_dianak
			$this->realty_ups_dianak->LinkCustomAttributes = "";
			$this->realty_ups_dianak->HrefValue = "";

			// esa_dianak
			$this->esa_dianak->LinkCustomAttributes = "";
			$this->esa_dianak->HrefValue = "";

			// esop_dianak
			$this->esop_dianak->LinkCustomAttributes = "";
			$this->esop_dianak->HrefValue = "";

			// change_by
			$this->change_by->LinkCustomAttributes = "";
			$this->change_by->HrefValue = "";

			// change_date
			$this->change_date->LinkCustomAttributes = "";
			$this->change_date->HrefValue = "";
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
		if (!ew_CheckInteger($this->periode_bulan->FormValue)) {
			ew_AddMessage($gsFormError, $this->periode_bulan->FldErrMsg());
		}
		if (!ew_CheckInteger($this->periode_tahun->FormValue)) {
			ew_AddMessage($gsFormError, $this->periode_tahun->FldErrMsg());
		}
		if (!ew_CheckInteger($this->industri_kontruksi_abim_ups_anak->FormValue)) {
			ew_AddMessage($gsFormError, $this->industri_kontruksi_abim_ups_anak->FldErrMsg());
		}
		if (!ew_CheckInteger($this->realty_ups_anak->FormValue)) {
			ew_AddMessage($gsFormError, $this->realty_ups_anak->FldErrMsg());
		}
		if (!ew_CheckInteger($this->pst_ups_anak->FormValue)) {
			ew_AddMessage($gsFormError, $this->pst_ups_anak->FldErrMsg());
		}
		if (!ew_CheckInteger($this->wton_anak_ups_anak->FormValue)) {
			ew_AddMessage($gsFormError, $this->wton_anak_ups_anak->FldErrMsg());
		}
		if (!ew_CheckInteger($this->industri_kontruksi_abim_ups_dianak->FormValue)) {
			ew_AddMessage($gsFormError, $this->industri_kontruksi_abim_ups_dianak->FldErrMsg());
		}
		if (!ew_CheckInteger($this->realty_ups_dianak->FormValue)) {
			ew_AddMessage($gsFormError, $this->realty_ups_dianak->FldErrMsg());
		}
		if (!ew_CheckInteger($this->esa_dianak->FormValue)) {
			ew_AddMessage($gsFormError, $this->esa_dianak->FldErrMsg());
		}
		if (!ew_CheckInteger($this->esop_dianak->FormValue)) {
			ew_AddMessage($gsFormError, $this->esop_dianak->FldErrMsg());
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

			// nip
			$this->nip->SetDbValueDef($rsnew, $this->nip->CurrentValue, NULL, $this->nip->ReadOnly);

			// kode_unit_organisasi
			$this->kode_unit_organisasi->SetDbValueDef($rsnew, $this->kode_unit_organisasi->CurrentValue, NULL, $this->kode_unit_organisasi->ReadOnly);

			// kode_unit_kerja
			$this->kode_unit_kerja->SetDbValueDef($rsnew, $this->kode_unit_kerja->CurrentValue, NULL, $this->kode_unit_kerja->ReadOnly);

			// periode_bulan
			$this->periode_bulan->SetDbValueDef($rsnew, $this->periode_bulan->CurrentValue, NULL, $this->periode_bulan->ReadOnly);

			// periode_tahun
			$this->periode_tahun->SetDbValueDef($rsnew, $this->periode_tahun->CurrentValue, NULL, $this->periode_tahun->ReadOnly);

			// industri_kontruksi_abim_ups_anak
			$this->industri_kontruksi_abim_ups_anak->SetDbValueDef($rsnew, $this->industri_kontruksi_abim_ups_anak->CurrentValue, NULL, $this->industri_kontruksi_abim_ups_anak->ReadOnly);

			// realty_ups_anak
			$this->realty_ups_anak->SetDbValueDef($rsnew, $this->realty_ups_anak->CurrentValue, NULL, $this->realty_ups_anak->ReadOnly);

			// pst_ups_anak
			$this->pst_ups_anak->SetDbValueDef($rsnew, $this->pst_ups_anak->CurrentValue, NULL, $this->pst_ups_anak->ReadOnly);

			// wton_anak_ups_anak
			$this->wton_anak_ups_anak->SetDbValueDef($rsnew, $this->wton_anak_ups_anak->CurrentValue, NULL, $this->wton_anak_ups_anak->ReadOnly);

			// industri_kontruksi_abim_ups_dianak
			$this->industri_kontruksi_abim_ups_dianak->SetDbValueDef($rsnew, $this->industri_kontruksi_abim_ups_dianak->CurrentValue, NULL, $this->industri_kontruksi_abim_ups_dianak->ReadOnly);

			// realty_ups_dianak
			$this->realty_ups_dianak->SetDbValueDef($rsnew, $this->realty_ups_dianak->CurrentValue, NULL, $this->realty_ups_dianak->ReadOnly);

			// esa_dianak
			$this->esa_dianak->SetDbValueDef($rsnew, $this->esa_dianak->CurrentValue, NULL, $this->esa_dianak->ReadOnly);

			// esop_dianak
			$this->esop_dianak->SetDbValueDef($rsnew, $this->esop_dianak->CurrentValue, NULL, $this->esop_dianak->ReadOnly);

			// change_by
			$this->change_by->SetDbValueDef($rsnew, $this->change_by->CurrentValue, NULL, $this->change_by->ReadOnly);

			// change_date
			$this->change_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->change_date->CurrentValue, 0), NULL, $this->change_date->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("rwy_persediaan_saham_pegawailist.php"), "", $this->TableVar, TRUE);
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
if (!isset($rwy_persediaan_saham_pegawai_edit)) $rwy_persediaan_saham_pegawai_edit = new crwy_persediaan_saham_pegawai_edit();

// Page init
$rwy_persediaan_saham_pegawai_edit->Page_Init();

// Page main
$rwy_persediaan_saham_pegawai_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$rwy_persediaan_saham_pegawai_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = frwy_persediaan_saham_pegawaiedit = new ew_Form("frwy_persediaan_saham_pegawaiedit", "edit");

// Validate form
frwy_persediaan_saham_pegawaiedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_periode_bulan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_persediaan_saham_pegawai->periode_bulan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_periode_tahun");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_persediaan_saham_pegawai->periode_tahun->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_industri_kontruksi_abim_ups_anak");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_realty_ups_anak");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_persediaan_saham_pegawai->realty_ups_anak->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pst_ups_anak");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_persediaan_saham_pegawai->pst_ups_anak->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_wton_anak_ups_anak");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_persediaan_saham_pegawai->wton_anak_ups_anak->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_industri_kontruksi_abim_ups_dianak");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_realty_ups_dianak");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_persediaan_saham_pegawai->realty_ups_dianak->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_esa_dianak");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_persediaan_saham_pegawai->esa_dianak->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_esop_dianak");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_persediaan_saham_pegawai->esop_dianak->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_change_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_persediaan_saham_pegawai->change_date->FldErrMsg()) ?>");

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
frwy_persediaan_saham_pegawaiedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
frwy_persediaan_saham_pegawaiedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $rwy_persediaan_saham_pegawai_edit->ShowPageHeader(); ?>
<?php
$rwy_persediaan_saham_pegawai_edit->ShowMessage();
?>
<form name="frwy_persediaan_saham_pegawaiedit" id="frwy_persediaan_saham_pegawaiedit" class="<?php echo $rwy_persediaan_saham_pegawai_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($rwy_persediaan_saham_pegawai_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $rwy_persediaan_saham_pegawai_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="rwy_persediaan_saham_pegawai">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($rwy_persediaan_saham_pegawai_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($rwy_persediaan_saham_pegawai->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_id" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->id->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->id->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_id">
<span<?php echo $rwy_persediaan_saham_pegawai->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $rwy_persediaan_saham_pegawai->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="rwy_persediaan_saham_pegawai" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->id->CurrentValue) ?>">
<?php echo $rwy_persediaan_saham_pegawai->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->nip->Visible) { // nip ?>
	<div id="r_nip" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_nip" for="x_nip" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->nip->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->nip->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_nip">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_nip" name="x_nip" id="x_nip" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->nip->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->nip->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->nip->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->nip->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->kode_unit_organisasi->Visible) { // kode_unit_organisasi ?>
	<div id="r_kode_unit_organisasi" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_kode_unit_organisasi" for="x_kode_unit_organisasi" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_kode_unit_organisasi">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_kode_unit_organisasi" name="x_kode_unit_organisasi" id="x_kode_unit_organisasi" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->kode_unit_organisasi->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->kode_unit_kerja->Visible) { // kode_unit_kerja ?>
	<div id="r_kode_unit_kerja" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_kode_unit_kerja" for="x_kode_unit_kerja" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_kode_unit_kerja">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_kode_unit_kerja" name="x_kode_unit_kerja" id="x_kode_unit_kerja" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->kode_unit_kerja->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->periode_bulan->Visible) { // periode_bulan ?>
	<div id="r_periode_bulan" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_periode_bulan" for="x_periode_bulan" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->periode_bulan->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->periode_bulan->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_periode_bulan">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_periode_bulan" name="x_periode_bulan" id="x_periode_bulan" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->periode_bulan->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->periode_bulan->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->periode_bulan->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->periode_bulan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->periode_tahun->Visible) { // periode_tahun ?>
	<div id="r_periode_tahun" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_periode_tahun" for="x_periode_tahun" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->periode_tahun->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->periode_tahun->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_periode_tahun">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_periode_tahun" name="x_periode_tahun" id="x_periode_tahun" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->periode_tahun->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->periode_tahun->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->periode_tahun->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->periode_tahun->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->Visible) { // industri_kontruksi_abim_ups_anak ?>
	<div id="r_industri_kontruksi_abim_ups_anak" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_anak" for="x_industri_kontruksi_abim_ups_anak" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_anak">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_industri_kontruksi_abim_ups_anak" name="x_industri_kontruksi_abim_ups_anak" id="x_industri_kontruksi_abim_ups_anak" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->realty_ups_anak->Visible) { // realty_ups_anak ?>
	<div id="r_realty_ups_anak" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_realty_ups_anak" for="x_realty_ups_anak" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_realty_ups_anak">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_realty_ups_anak" name="x_realty_ups_anak" id="x_realty_ups_anak" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->realty_ups_anak->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->pst_ups_anak->Visible) { // pst_ups_anak ?>
	<div id="r_pst_ups_anak" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_pst_ups_anak" for="x_pst_ups_anak" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_pst_ups_anak">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_pst_ups_anak" name="x_pst_ups_anak" id="x_pst_ups_anak" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->pst_ups_anak->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->wton_anak_ups_anak->Visible) { // wton_anak_ups_anak ?>
	<div id="r_wton_anak_ups_anak" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_wton_anak_ups_anak" for="x_wton_anak_ups_anak" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_wton_anak_ups_anak">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_wton_anak_ups_anak" name="x_wton_anak_ups_anak" id="x_wton_anak_ups_anak" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->wton_anak_ups_anak->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->Visible) { // industri_kontruksi_abim_ups_dianak ?>
	<div id="r_industri_kontruksi_abim_ups_dianak" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_dianak" for="x_industri_kontruksi_abim_ups_dianak" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_dianak">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_industri_kontruksi_abim_ups_dianak" name="x_industri_kontruksi_abim_ups_dianak" id="x_industri_kontruksi_abim_ups_dianak" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->realty_ups_dianak->Visible) { // realty_ups_dianak ?>
	<div id="r_realty_ups_dianak" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_realty_ups_dianak" for="x_realty_ups_dianak" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_realty_ups_dianak">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_realty_ups_dianak" name="x_realty_ups_dianak" id="x_realty_ups_dianak" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->realty_ups_dianak->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->esa_dianak->Visible) { // esa_dianak ?>
	<div id="r_esa_dianak" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_esa_dianak" for="x_esa_dianak" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->esa_dianak->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->esa_dianak->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_esa_dianak">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_esa_dianak" name="x_esa_dianak" id="x_esa_dianak" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->esa_dianak->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->esa_dianak->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->esa_dianak->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->esa_dianak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->esop_dianak->Visible) { // esop_dianak ?>
	<div id="r_esop_dianak" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_esop_dianak" for="x_esop_dianak" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->esop_dianak->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->esop_dianak->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_esop_dianak">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_esop_dianak" name="x_esop_dianak" id="x_esop_dianak" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->esop_dianak->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->esop_dianak->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->esop_dianak->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->esop_dianak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->change_by->Visible) { // change_by ?>
	<div id="r_change_by" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_change_by" for="x_change_by" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->change_by->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->change_by->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_change_by">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_change_by" name="x_change_by" id="x_change_by" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->change_by->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->change_by->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->change_by->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->change_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->change_date->Visible) { // change_date ?>
	<div id="r_change_date" class="form-group">
		<label id="elh_rwy_persediaan_saham_pegawai_change_date" for="x_change_date" class="<?php echo $rwy_persediaan_saham_pegawai_edit->LeftColumnClass ?>"><?php echo $rwy_persediaan_saham_pegawai->change_date->FldCaption() ?></label>
		<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->RightColumnClass ?>"><div<?php echo $rwy_persediaan_saham_pegawai->change_date->CellAttributes() ?>>
<span id="el_rwy_persediaan_saham_pegawai_change_date">
<input type="text" data-table="rwy_persediaan_saham_pegawai" data-field="x_change_date" name="x_change_date" id="x_change_date" placeholder="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai->change_date->getPlaceHolder()) ?>" value="<?php echo $rwy_persediaan_saham_pegawai->change_date->EditValue ?>"<?php echo $rwy_persediaan_saham_pegawai->change_date->EditAttributes() ?>>
</span>
<?php echo $rwy_persediaan_saham_pegawai->change_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$rwy_persediaan_saham_pegawai_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $rwy_persediaan_saham_pegawai_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $rwy_persediaan_saham_pegawai_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
frwy_persediaan_saham_pegawaiedit.Init();
</script>
<?php
$rwy_persediaan_saham_pegawai_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$rwy_persediaan_saham_pegawai_edit->Page_Terminate();
?>
