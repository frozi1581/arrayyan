<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "rwy_jabataninfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$rwy_jabatan_edit = NULL; // Initialize page object first

class crwy_jabatan_edit extends crwy_jabatan {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'rwy_jabatan';

	// Page object name
	var $PageObjName = 'rwy_jabatan_edit';

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

		// Table object (rwy_jabatan)
		if (!isset($GLOBALS["rwy_jabatan"]) || get_class($GLOBALS["rwy_jabatan"]) == "crwy_jabatan") {
			$GLOBALS["rwy_jabatan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["rwy_jabatan"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rwy_jabatan', TRUE);

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
		$this->jabatan->SetVisibility();
		$this->fungsi_bidang->SetVisibility();
		$this->berlaku_sejak->SetVisibility();
		$this->tanggal_berakhir->SetVisibility();
		$this->no_sk->SetVisibility();
		$this->tanggal_sk->SetVisibility();
		$this->status_jabatan->SetVisibility();
		$this->status_rwy_jabatan->SetVisibility();
		$this->stat_validasi->SetVisibility();
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
		global $EW_EXPORT, $rwy_jabatan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($rwy_jabatan);
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
					if ($pageName == "rwy_jabatanview.php")
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
					$this->Page_Terminate("rwy_jabatanlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "rwy_jabatanlist.php")
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
		if (!$this->jabatan->FldIsDetailKey) {
			$this->jabatan->setFormValue($objForm->GetValue("x_jabatan"));
		}
		if (!$this->fungsi_bidang->FldIsDetailKey) {
			$this->fungsi_bidang->setFormValue($objForm->GetValue("x_fungsi_bidang"));
		}
		if (!$this->berlaku_sejak->FldIsDetailKey) {
			$this->berlaku_sejak->setFormValue($objForm->GetValue("x_berlaku_sejak"));
			$this->berlaku_sejak->CurrentValue = ew_UnFormatDateTime($this->berlaku_sejak->CurrentValue, 0);
		}
		if (!$this->tanggal_berakhir->FldIsDetailKey) {
			$this->tanggal_berakhir->setFormValue($objForm->GetValue("x_tanggal_berakhir"));
			$this->tanggal_berakhir->CurrentValue = ew_UnFormatDateTime($this->tanggal_berakhir->CurrentValue, 0);
		}
		if (!$this->no_sk->FldIsDetailKey) {
			$this->no_sk->setFormValue($objForm->GetValue("x_no_sk"));
		}
		if (!$this->tanggal_sk->FldIsDetailKey) {
			$this->tanggal_sk->setFormValue($objForm->GetValue("x_tanggal_sk"));
			$this->tanggal_sk->CurrentValue = ew_UnFormatDateTime($this->tanggal_sk->CurrentValue, 0);
		}
		if (!$this->status_jabatan->FldIsDetailKey) {
			$this->status_jabatan->setFormValue($objForm->GetValue("x_status_jabatan"));
		}
		if (!$this->status_rwy_jabatan->FldIsDetailKey) {
			$this->status_rwy_jabatan->setFormValue($objForm->GetValue("x_status_rwy_jabatan"));
		}
		if (!$this->stat_validasi->FldIsDetailKey) {
			$this->stat_validasi->setFormValue($objForm->GetValue("x_stat_validasi"));
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
		$this->jabatan->CurrentValue = $this->jabatan->FormValue;
		$this->fungsi_bidang->CurrentValue = $this->fungsi_bidang->FormValue;
		$this->berlaku_sejak->CurrentValue = $this->berlaku_sejak->FormValue;
		$this->berlaku_sejak->CurrentValue = ew_UnFormatDateTime($this->berlaku_sejak->CurrentValue, 0);
		$this->tanggal_berakhir->CurrentValue = $this->tanggal_berakhir->FormValue;
		$this->tanggal_berakhir->CurrentValue = ew_UnFormatDateTime($this->tanggal_berakhir->CurrentValue, 0);
		$this->no_sk->CurrentValue = $this->no_sk->FormValue;
		$this->tanggal_sk->CurrentValue = $this->tanggal_sk->FormValue;
		$this->tanggal_sk->CurrentValue = ew_UnFormatDateTime($this->tanggal_sk->CurrentValue, 0);
		$this->status_jabatan->CurrentValue = $this->status_jabatan->FormValue;
		$this->status_rwy_jabatan->CurrentValue = $this->status_rwy_jabatan->FormValue;
		$this->stat_validasi->CurrentValue = $this->stat_validasi->FormValue;
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
		$this->jabatan->setDbValue($row['jabatan']);
		$this->fungsi_bidang->setDbValue($row['fungsi_bidang']);
		$this->berlaku_sejak->setDbValue($row['berlaku_sejak']);
		$this->tanggal_berakhir->setDbValue($row['tanggal_berakhir']);
		$this->no_sk->setDbValue($row['no_sk']);
		$this->tanggal_sk->setDbValue($row['tanggal_sk']);
		$this->status_jabatan->setDbValue($row['status_jabatan']);
		$this->status_rwy_jabatan->setDbValue($row['status_rwy_jabatan']);
		$this->stat_validasi->setDbValue($row['stat_validasi']);
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
		$row['jabatan'] = NULL;
		$row['fungsi_bidang'] = NULL;
		$row['berlaku_sejak'] = NULL;
		$row['tanggal_berakhir'] = NULL;
		$row['no_sk'] = NULL;
		$row['tanggal_sk'] = NULL;
		$row['status_jabatan'] = NULL;
		$row['status_rwy_jabatan'] = NULL;
		$row['stat_validasi'] = NULL;
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
		$this->jabatan->DbValue = $row['jabatan'];
		$this->fungsi_bidang->DbValue = $row['fungsi_bidang'];
		$this->berlaku_sejak->DbValue = $row['berlaku_sejak'];
		$this->tanggal_berakhir->DbValue = $row['tanggal_berakhir'];
		$this->no_sk->DbValue = $row['no_sk'];
		$this->tanggal_sk->DbValue = $row['tanggal_sk'];
		$this->status_jabatan->DbValue = $row['status_jabatan'];
		$this->status_rwy_jabatan->DbValue = $row['status_rwy_jabatan'];
		$this->stat_validasi->DbValue = $row['stat_validasi'];
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
		// jabatan
		// fungsi_bidang
		// berlaku_sejak
		// tanggal_berakhir
		// no_sk
		// tanggal_sk
		// status_jabatan
		// status_rwy_jabatan
		// stat_validasi
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

		// jabatan
		$this->jabatan->ViewValue = $this->jabatan->CurrentValue;
		$this->jabatan->ViewCustomAttributes = "";

		// fungsi_bidang
		$this->fungsi_bidang->ViewValue = $this->fungsi_bidang->CurrentValue;
		$this->fungsi_bidang->ViewCustomAttributes = "";

		// berlaku_sejak
		$this->berlaku_sejak->ViewValue = $this->berlaku_sejak->CurrentValue;
		$this->berlaku_sejak->ViewValue = ew_FormatDateTime($this->berlaku_sejak->ViewValue, 0);
		$this->berlaku_sejak->ViewCustomAttributes = "";

		// tanggal_berakhir
		$this->tanggal_berakhir->ViewValue = $this->tanggal_berakhir->CurrentValue;
		$this->tanggal_berakhir->ViewValue = ew_FormatDateTime($this->tanggal_berakhir->ViewValue, 0);
		$this->tanggal_berakhir->ViewCustomAttributes = "";

		// no_sk
		$this->no_sk->ViewValue = $this->no_sk->CurrentValue;
		$this->no_sk->ViewCustomAttributes = "";

		// tanggal_sk
		$this->tanggal_sk->ViewValue = $this->tanggal_sk->CurrentValue;
		$this->tanggal_sk->ViewValue = ew_FormatDateTime($this->tanggal_sk->ViewValue, 0);
		$this->tanggal_sk->ViewCustomAttributes = "";

		// status_jabatan
		$this->status_jabatan->ViewValue = $this->status_jabatan->CurrentValue;
		$this->status_jabatan->ViewCustomAttributes = "";

		// status_rwy_jabatan
		$this->status_rwy_jabatan->ViewValue = $this->status_rwy_jabatan->CurrentValue;
		$this->status_rwy_jabatan->ViewCustomAttributes = "";

		// stat_validasi
		$this->stat_validasi->ViewValue = $this->stat_validasi->CurrentValue;
		$this->stat_validasi->ViewCustomAttributes = "";

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

			// jabatan
			$this->jabatan->LinkCustomAttributes = "";
			$this->jabatan->HrefValue = "";
			$this->jabatan->TooltipValue = "";

			// fungsi_bidang
			$this->fungsi_bidang->LinkCustomAttributes = "";
			$this->fungsi_bidang->HrefValue = "";
			$this->fungsi_bidang->TooltipValue = "";

			// berlaku_sejak
			$this->berlaku_sejak->LinkCustomAttributes = "";
			$this->berlaku_sejak->HrefValue = "";
			$this->berlaku_sejak->TooltipValue = "";

			// tanggal_berakhir
			$this->tanggal_berakhir->LinkCustomAttributes = "";
			$this->tanggal_berakhir->HrefValue = "";
			$this->tanggal_berakhir->TooltipValue = "";

			// no_sk
			$this->no_sk->LinkCustomAttributes = "";
			$this->no_sk->HrefValue = "";
			$this->no_sk->TooltipValue = "";

			// tanggal_sk
			$this->tanggal_sk->LinkCustomAttributes = "";
			$this->tanggal_sk->HrefValue = "";
			$this->tanggal_sk->TooltipValue = "";

			// status_jabatan
			$this->status_jabatan->LinkCustomAttributes = "";
			$this->status_jabatan->HrefValue = "";
			$this->status_jabatan->TooltipValue = "";

			// status_rwy_jabatan
			$this->status_rwy_jabatan->LinkCustomAttributes = "";
			$this->status_rwy_jabatan->HrefValue = "";
			$this->status_rwy_jabatan->TooltipValue = "";

			// stat_validasi
			$this->stat_validasi->LinkCustomAttributes = "";
			$this->stat_validasi->HrefValue = "";
			$this->stat_validasi->TooltipValue = "";

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

			// jabatan
			$this->jabatan->EditAttrs["class"] = "form-control";
			$this->jabatan->EditCustomAttributes = "";
			$this->jabatan->EditValue = ew_HtmlEncode($this->jabatan->CurrentValue);
			$this->jabatan->PlaceHolder = ew_RemoveHtml($this->jabatan->FldCaption());

			// fungsi_bidang
			$this->fungsi_bidang->EditAttrs["class"] = "form-control";
			$this->fungsi_bidang->EditCustomAttributes = "";
			$this->fungsi_bidang->EditValue = ew_HtmlEncode($this->fungsi_bidang->CurrentValue);
			$this->fungsi_bidang->PlaceHolder = ew_RemoveHtml($this->fungsi_bidang->FldCaption());

			// berlaku_sejak
			$this->berlaku_sejak->EditAttrs["class"] = "form-control";
			$this->berlaku_sejak->EditCustomAttributes = "";
			$this->berlaku_sejak->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->berlaku_sejak->CurrentValue, 8));
			$this->berlaku_sejak->PlaceHolder = ew_RemoveHtml($this->berlaku_sejak->FldCaption());

			// tanggal_berakhir
			$this->tanggal_berakhir->EditAttrs["class"] = "form-control";
			$this->tanggal_berakhir->EditCustomAttributes = "";
			$this->tanggal_berakhir->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tanggal_berakhir->CurrentValue, 8));
			$this->tanggal_berakhir->PlaceHolder = ew_RemoveHtml($this->tanggal_berakhir->FldCaption());

			// no_sk
			$this->no_sk->EditAttrs["class"] = "form-control";
			$this->no_sk->EditCustomAttributes = "";
			$this->no_sk->EditValue = ew_HtmlEncode($this->no_sk->CurrentValue);
			$this->no_sk->PlaceHolder = ew_RemoveHtml($this->no_sk->FldCaption());

			// tanggal_sk
			$this->tanggal_sk->EditAttrs["class"] = "form-control";
			$this->tanggal_sk->EditCustomAttributes = "";
			$this->tanggal_sk->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tanggal_sk->CurrentValue, 8));
			$this->tanggal_sk->PlaceHolder = ew_RemoveHtml($this->tanggal_sk->FldCaption());

			// status_jabatan
			$this->status_jabatan->EditAttrs["class"] = "form-control";
			$this->status_jabatan->EditCustomAttributes = "";
			$this->status_jabatan->EditValue = ew_HtmlEncode($this->status_jabatan->CurrentValue);
			$this->status_jabatan->PlaceHolder = ew_RemoveHtml($this->status_jabatan->FldCaption());

			// status_rwy_jabatan
			$this->status_rwy_jabatan->EditAttrs["class"] = "form-control";
			$this->status_rwy_jabatan->EditCustomAttributes = "";
			$this->status_rwy_jabatan->EditValue = ew_HtmlEncode($this->status_rwy_jabatan->CurrentValue);
			$this->status_rwy_jabatan->PlaceHolder = ew_RemoveHtml($this->status_rwy_jabatan->FldCaption());

			// stat_validasi
			$this->stat_validasi->EditAttrs["class"] = "form-control";
			$this->stat_validasi->EditCustomAttributes = "";
			$this->stat_validasi->EditValue = ew_HtmlEncode($this->stat_validasi->CurrentValue);
			$this->stat_validasi->PlaceHolder = ew_RemoveHtml($this->stat_validasi->FldCaption());

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

			// jabatan
			$this->jabatan->LinkCustomAttributes = "";
			$this->jabatan->HrefValue = "";

			// fungsi_bidang
			$this->fungsi_bidang->LinkCustomAttributes = "";
			$this->fungsi_bidang->HrefValue = "";

			// berlaku_sejak
			$this->berlaku_sejak->LinkCustomAttributes = "";
			$this->berlaku_sejak->HrefValue = "";

			// tanggal_berakhir
			$this->tanggal_berakhir->LinkCustomAttributes = "";
			$this->tanggal_berakhir->HrefValue = "";

			// no_sk
			$this->no_sk->LinkCustomAttributes = "";
			$this->no_sk->HrefValue = "";

			// tanggal_sk
			$this->tanggal_sk->LinkCustomAttributes = "";
			$this->tanggal_sk->HrefValue = "";

			// status_jabatan
			$this->status_jabatan->LinkCustomAttributes = "";
			$this->status_jabatan->HrefValue = "";

			// status_rwy_jabatan
			$this->status_rwy_jabatan->LinkCustomAttributes = "";
			$this->status_rwy_jabatan->HrefValue = "";

			// stat_validasi
			$this->stat_validasi->LinkCustomAttributes = "";
			$this->stat_validasi->HrefValue = "";

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
		if (!ew_CheckDateDef($this->berlaku_sejak->FormValue)) {
			ew_AddMessage($gsFormError, $this->berlaku_sejak->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tanggal_berakhir->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal_berakhir->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tanggal_sk->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal_sk->FldErrMsg());
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

			// jabatan
			$this->jabatan->SetDbValueDef($rsnew, $this->jabatan->CurrentValue, NULL, $this->jabatan->ReadOnly);

			// fungsi_bidang
			$this->fungsi_bidang->SetDbValueDef($rsnew, $this->fungsi_bidang->CurrentValue, NULL, $this->fungsi_bidang->ReadOnly);

			// berlaku_sejak
			$this->berlaku_sejak->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->berlaku_sejak->CurrentValue, 0), NULL, $this->berlaku_sejak->ReadOnly);

			// tanggal_berakhir
			$this->tanggal_berakhir->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal_berakhir->CurrentValue, 0), NULL, $this->tanggal_berakhir->ReadOnly);

			// no_sk
			$this->no_sk->SetDbValueDef($rsnew, $this->no_sk->CurrentValue, NULL, $this->no_sk->ReadOnly);

			// tanggal_sk
			$this->tanggal_sk->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal_sk->CurrentValue, 0), NULL, $this->tanggal_sk->ReadOnly);

			// status_jabatan
			$this->status_jabatan->SetDbValueDef($rsnew, $this->status_jabatan->CurrentValue, NULL, $this->status_jabatan->ReadOnly);

			// status_rwy_jabatan
			$this->status_rwy_jabatan->SetDbValueDef($rsnew, $this->status_rwy_jabatan->CurrentValue, NULL, $this->status_rwy_jabatan->ReadOnly);

			// stat_validasi
			$this->stat_validasi->SetDbValueDef($rsnew, $this->stat_validasi->CurrentValue, NULL, $this->stat_validasi->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("rwy_jabatanlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($rwy_jabatan_edit)) $rwy_jabatan_edit = new crwy_jabatan_edit();

// Page init
$rwy_jabatan_edit->Page_Init();

// Page main
$rwy_jabatan_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$rwy_jabatan_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = frwy_jabatanedit = new ew_Form("frwy_jabatanedit", "edit");

// Validate form
frwy_jabatanedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_berlaku_sejak");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_jabatan->berlaku_sejak->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tanggal_berakhir");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_jabatan->tanggal_berakhir->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tanggal_sk");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_jabatan->tanggal_sk->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_stat_validasi");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_jabatan->stat_validasi->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_change_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($rwy_jabatan->change_date->FldErrMsg()) ?>");

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
frwy_jabatanedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
frwy_jabatanedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $rwy_jabatan_edit->ShowPageHeader(); ?>
<?php
$rwy_jabatan_edit->ShowMessage();
?>
<form name="frwy_jabatanedit" id="frwy_jabatanedit" class="<?php echo $rwy_jabatan_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($rwy_jabatan_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $rwy_jabatan_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="rwy_jabatan">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($rwy_jabatan_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($rwy_jabatan->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_rwy_jabatan_id" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->id->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->id->CellAttributes() ?>>
<span id="el_rwy_jabatan_id">
<span<?php echo $rwy_jabatan->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $rwy_jabatan->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="rwy_jabatan" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($rwy_jabatan->id->CurrentValue) ?>">
<?php echo $rwy_jabatan->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->nip->Visible) { // nip ?>
	<div id="r_nip" class="form-group">
		<label id="elh_rwy_jabatan_nip" for="x_nip" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->nip->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->nip->CellAttributes() ?>>
<span id="el_rwy_jabatan_nip">
<input type="text" data-table="rwy_jabatan" data-field="x_nip" name="x_nip" id="x_nip" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->nip->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->nip->EditValue ?>"<?php echo $rwy_jabatan->nip->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->nip->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->kode_unit_organisasi->Visible) { // kode_unit_organisasi ?>
	<div id="r_kode_unit_organisasi" class="form-group">
		<label id="elh_rwy_jabatan_kode_unit_organisasi" for="x_kode_unit_organisasi" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->kode_unit_organisasi->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->kode_unit_organisasi->CellAttributes() ?>>
<span id="el_rwy_jabatan_kode_unit_organisasi">
<input type="text" data-table="rwy_jabatan" data-field="x_kode_unit_organisasi" name="x_kode_unit_organisasi" id="x_kode_unit_organisasi" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->kode_unit_organisasi->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->kode_unit_organisasi->EditValue ?>"<?php echo $rwy_jabatan->kode_unit_organisasi->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->kode_unit_organisasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->kode_unit_kerja->Visible) { // kode_unit_kerja ?>
	<div id="r_kode_unit_kerja" class="form-group">
		<label id="elh_rwy_jabatan_kode_unit_kerja" for="x_kode_unit_kerja" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->kode_unit_kerja->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->kode_unit_kerja->CellAttributes() ?>>
<span id="el_rwy_jabatan_kode_unit_kerja">
<input type="text" data-table="rwy_jabatan" data-field="x_kode_unit_kerja" name="x_kode_unit_kerja" id="x_kode_unit_kerja" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->kode_unit_kerja->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->kode_unit_kerja->EditValue ?>"<?php echo $rwy_jabatan->kode_unit_kerja->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->kode_unit_kerja->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->jabatan->Visible) { // jabatan ?>
	<div id="r_jabatan" class="form-group">
		<label id="elh_rwy_jabatan_jabatan" for="x_jabatan" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->jabatan->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->jabatan->CellAttributes() ?>>
<span id="el_rwy_jabatan_jabatan">
<input type="text" data-table="rwy_jabatan" data-field="x_jabatan" name="x_jabatan" id="x_jabatan" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->jabatan->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->jabatan->EditValue ?>"<?php echo $rwy_jabatan->jabatan->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->jabatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->fungsi_bidang->Visible) { // fungsi_bidang ?>
	<div id="r_fungsi_bidang" class="form-group">
		<label id="elh_rwy_jabatan_fungsi_bidang" for="x_fungsi_bidang" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->fungsi_bidang->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->fungsi_bidang->CellAttributes() ?>>
<span id="el_rwy_jabatan_fungsi_bidang">
<input type="text" data-table="rwy_jabatan" data-field="x_fungsi_bidang" name="x_fungsi_bidang" id="x_fungsi_bidang" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->fungsi_bidang->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->fungsi_bidang->EditValue ?>"<?php echo $rwy_jabatan->fungsi_bidang->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->fungsi_bidang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->berlaku_sejak->Visible) { // berlaku_sejak ?>
	<div id="r_berlaku_sejak" class="form-group">
		<label id="elh_rwy_jabatan_berlaku_sejak" for="x_berlaku_sejak" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->berlaku_sejak->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->berlaku_sejak->CellAttributes() ?>>
<span id="el_rwy_jabatan_berlaku_sejak">
<input type="text" data-table="rwy_jabatan" data-field="x_berlaku_sejak" name="x_berlaku_sejak" id="x_berlaku_sejak" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->berlaku_sejak->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->berlaku_sejak->EditValue ?>"<?php echo $rwy_jabatan->berlaku_sejak->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->berlaku_sejak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->tanggal_berakhir->Visible) { // tanggal_berakhir ?>
	<div id="r_tanggal_berakhir" class="form-group">
		<label id="elh_rwy_jabatan_tanggal_berakhir" for="x_tanggal_berakhir" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->tanggal_berakhir->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->tanggal_berakhir->CellAttributes() ?>>
<span id="el_rwy_jabatan_tanggal_berakhir">
<input type="text" data-table="rwy_jabatan" data-field="x_tanggal_berakhir" name="x_tanggal_berakhir" id="x_tanggal_berakhir" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->tanggal_berakhir->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->tanggal_berakhir->EditValue ?>"<?php echo $rwy_jabatan->tanggal_berakhir->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->tanggal_berakhir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->no_sk->Visible) { // no_sk ?>
	<div id="r_no_sk" class="form-group">
		<label id="elh_rwy_jabatan_no_sk" for="x_no_sk" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->no_sk->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->no_sk->CellAttributes() ?>>
<span id="el_rwy_jabatan_no_sk">
<input type="text" data-table="rwy_jabatan" data-field="x_no_sk" name="x_no_sk" id="x_no_sk" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->no_sk->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->no_sk->EditValue ?>"<?php echo $rwy_jabatan->no_sk->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->no_sk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->tanggal_sk->Visible) { // tanggal_sk ?>
	<div id="r_tanggal_sk" class="form-group">
		<label id="elh_rwy_jabatan_tanggal_sk" for="x_tanggal_sk" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->tanggal_sk->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->tanggal_sk->CellAttributes() ?>>
<span id="el_rwy_jabatan_tanggal_sk">
<input type="text" data-table="rwy_jabatan" data-field="x_tanggal_sk" name="x_tanggal_sk" id="x_tanggal_sk" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->tanggal_sk->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->tanggal_sk->EditValue ?>"<?php echo $rwy_jabatan->tanggal_sk->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->tanggal_sk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->status_jabatan->Visible) { // status_jabatan ?>
	<div id="r_status_jabatan" class="form-group">
		<label id="elh_rwy_jabatan_status_jabatan" for="x_status_jabatan" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->status_jabatan->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->status_jabatan->CellAttributes() ?>>
<span id="el_rwy_jabatan_status_jabatan">
<input type="text" data-table="rwy_jabatan" data-field="x_status_jabatan" name="x_status_jabatan" id="x_status_jabatan" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->status_jabatan->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->status_jabatan->EditValue ?>"<?php echo $rwy_jabatan->status_jabatan->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->status_jabatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->status_rwy_jabatan->Visible) { // status_rwy_jabatan ?>
	<div id="r_status_rwy_jabatan" class="form-group">
		<label id="elh_rwy_jabatan_status_rwy_jabatan" for="x_status_rwy_jabatan" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->status_rwy_jabatan->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->status_rwy_jabatan->CellAttributes() ?>>
<span id="el_rwy_jabatan_status_rwy_jabatan">
<input type="text" data-table="rwy_jabatan" data-field="x_status_rwy_jabatan" name="x_status_rwy_jabatan" id="x_status_rwy_jabatan" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->status_rwy_jabatan->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->status_rwy_jabatan->EditValue ?>"<?php echo $rwy_jabatan->status_rwy_jabatan->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->status_rwy_jabatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->stat_validasi->Visible) { // stat_validasi ?>
	<div id="r_stat_validasi" class="form-group">
		<label id="elh_rwy_jabatan_stat_validasi" for="x_stat_validasi" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->stat_validasi->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->stat_validasi->CellAttributes() ?>>
<span id="el_rwy_jabatan_stat_validasi">
<input type="text" data-table="rwy_jabatan" data-field="x_stat_validasi" name="x_stat_validasi" id="x_stat_validasi" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->stat_validasi->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->stat_validasi->EditValue ?>"<?php echo $rwy_jabatan->stat_validasi->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->stat_validasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->change_by->Visible) { // change_by ?>
	<div id="r_change_by" class="form-group">
		<label id="elh_rwy_jabatan_change_by" for="x_change_by" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->change_by->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->change_by->CellAttributes() ?>>
<span id="el_rwy_jabatan_change_by">
<input type="text" data-table="rwy_jabatan" data-field="x_change_by" name="x_change_by" id="x_change_by" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->change_by->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->change_by->EditValue ?>"<?php echo $rwy_jabatan->change_by->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->change_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_jabatan->change_date->Visible) { // change_date ?>
	<div id="r_change_date" class="form-group">
		<label id="elh_rwy_jabatan_change_date" for="x_change_date" class="<?php echo $rwy_jabatan_edit->LeftColumnClass ?>"><?php echo $rwy_jabatan->change_date->FldCaption() ?></label>
		<div class="<?php echo $rwy_jabatan_edit->RightColumnClass ?>"><div<?php echo $rwy_jabatan->change_date->CellAttributes() ?>>
<span id="el_rwy_jabatan_change_date">
<input type="text" data-table="rwy_jabatan" data-field="x_change_date" name="x_change_date" id="x_change_date" placeholder="<?php echo ew_HtmlEncode($rwy_jabatan->change_date->getPlaceHolder()) ?>" value="<?php echo $rwy_jabatan->change_date->EditValue ?>"<?php echo $rwy_jabatan->change_date->EditAttributes() ?>>
</span>
<?php echo $rwy_jabatan->change_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$rwy_jabatan_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $rwy_jabatan_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $rwy_jabatan_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
frwy_jabatanedit.Init();
</script>
<?php
$rwy_jabatan_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$rwy_jabatan_edit->Page_Terminate();
?>
