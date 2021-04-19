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

$rwy_pendidikan_edit = NULL; // Initialize page object first

class crwy_pendidikan_edit extends crwy_pendidikan {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'rwy_pendidikan';

	// Page object name
	var $PageObjName = 'rwy_pendidikan_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
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
					$this->Page_Terminate("rwy_pendidikanlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "rwy_pendidikanlist.php")
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
		$this->id->CurrentValue = $this->id->FormValue;
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
		$row = array();
		$row['id'] = NULL;
		$row['nip'] = NULL;
		$row['pendidikan_terakhir'] = NULL;
		$row['jurusan'] = NULL;
		$row['nama_lembaga'] = NULL;
		$row['no_ijazah'] = NULL;
		$row['tanggal_ijazah'] = NULL;
		$row['lokasi_pendidikan'] = NULL;
		$row['stat_validasi'] = NULL;
		$row['change_date'] = NULL;
		$row['change_by'] = NULL;
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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

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

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

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

			// pendidikan_terakhir
			$this->pendidikan_terakhir->SetDbValueDef($rsnew, $this->pendidikan_terakhir->CurrentValue, NULL, $this->pendidikan_terakhir->ReadOnly);

			// jurusan
			$this->jurusan->SetDbValueDef($rsnew, $this->jurusan->CurrentValue, NULL, $this->jurusan->ReadOnly);

			// nama_lembaga
			$this->nama_lembaga->SetDbValueDef($rsnew, $this->nama_lembaga->CurrentValue, NULL, $this->nama_lembaga->ReadOnly);

			// no_ijazah
			$this->no_ijazah->SetDbValueDef($rsnew, $this->no_ijazah->CurrentValue, NULL, $this->no_ijazah->ReadOnly);

			// tanggal_ijazah
			$this->tanggal_ijazah->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal_ijazah->CurrentValue, 0), NULL, $this->tanggal_ijazah->ReadOnly);

			// lokasi_pendidikan
			$this->lokasi_pendidikan->SetDbValueDef($rsnew, $this->lokasi_pendidikan->CurrentValue, NULL, $this->lokasi_pendidikan->ReadOnly);

			// stat_validasi
			$this->stat_validasi->SetDbValueDef($rsnew, $this->stat_validasi->CurrentValue, NULL, $this->stat_validasi->ReadOnly);

			// change_date
			$this->change_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->change_date->CurrentValue, 0), NULL, $this->change_date->ReadOnly);

			// change_by
			$this->change_by->SetDbValueDef($rsnew, $this->change_by->CurrentValue, NULL, $this->change_by->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("rwy_pendidikanlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($rwy_pendidikan_edit)) $rwy_pendidikan_edit = new crwy_pendidikan_edit();

// Page init
$rwy_pendidikan_edit->Page_Init();

// Page main
$rwy_pendidikan_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$rwy_pendidikan_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = frwy_pendidikanedit = new ew_Form("frwy_pendidikanedit", "edit");

// Validate form
frwy_pendidikanedit.Validate = function() {
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
frwy_pendidikanedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
frwy_pendidikanedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $rwy_pendidikan_edit->ShowPageHeader(); ?>
<?php
$rwy_pendidikan_edit->ShowMessage();
?>
<form name="frwy_pendidikanedit" id="frwy_pendidikanedit" class="<?php echo $rwy_pendidikan_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($rwy_pendidikan_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $rwy_pendidikan_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="rwy_pendidikan">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($rwy_pendidikan_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($rwy_pendidikan->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_rwy_pendidikan_id" class="<?php echo $rwy_pendidikan_edit->LeftColumnClass ?>"><?php echo $rwy_pendidikan->id->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_edit->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->id->CellAttributes() ?>>
<span id="el_rwy_pendidikan_id">
<span<?php echo $rwy_pendidikan->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $rwy_pendidikan->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="rwy_pendidikan" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($rwy_pendidikan->id->CurrentValue) ?>">
<?php echo $rwy_pendidikan->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->nip->Visible) { // nip ?>
	<div id="r_nip" class="form-group">
		<label id="elh_rwy_pendidikan_nip" for="x_nip" class="<?php echo $rwy_pendidikan_edit->LeftColumnClass ?>"><?php echo $rwy_pendidikan->nip->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_edit->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->nip->CellAttributes() ?>>
<span id="el_rwy_pendidikan_nip">
<input type="text" data-table="rwy_pendidikan" data-field="x_nip" name="x_nip" id="x_nip" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->nip->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->nip->EditValue ?>"<?php echo $rwy_pendidikan->nip->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->nip->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->pendidikan_terakhir->Visible) { // pendidikan_terakhir ?>
	<div id="r_pendidikan_terakhir" class="form-group">
		<label id="elh_rwy_pendidikan_pendidikan_terakhir" for="x_pendidikan_terakhir" class="<?php echo $rwy_pendidikan_edit->LeftColumnClass ?>"><?php echo $rwy_pendidikan->pendidikan_terakhir->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_edit->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->pendidikan_terakhir->CellAttributes() ?>>
<span id="el_rwy_pendidikan_pendidikan_terakhir">
<input type="text" data-table="rwy_pendidikan" data-field="x_pendidikan_terakhir" name="x_pendidikan_terakhir" id="x_pendidikan_terakhir" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->pendidikan_terakhir->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->pendidikan_terakhir->EditValue ?>"<?php echo $rwy_pendidikan->pendidikan_terakhir->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->pendidikan_terakhir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->jurusan->Visible) { // jurusan ?>
	<div id="r_jurusan" class="form-group">
		<label id="elh_rwy_pendidikan_jurusan" for="x_jurusan" class="<?php echo $rwy_pendidikan_edit->LeftColumnClass ?>"><?php echo $rwy_pendidikan->jurusan->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_edit->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->jurusan->CellAttributes() ?>>
<span id="el_rwy_pendidikan_jurusan">
<input type="text" data-table="rwy_pendidikan" data-field="x_jurusan" name="x_jurusan" id="x_jurusan" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->jurusan->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->jurusan->EditValue ?>"<?php echo $rwy_pendidikan->jurusan->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->jurusan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->nama_lembaga->Visible) { // nama_lembaga ?>
	<div id="r_nama_lembaga" class="form-group">
		<label id="elh_rwy_pendidikan_nama_lembaga" for="x_nama_lembaga" class="<?php echo $rwy_pendidikan_edit->LeftColumnClass ?>"><?php echo $rwy_pendidikan->nama_lembaga->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_edit->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->nama_lembaga->CellAttributes() ?>>
<span id="el_rwy_pendidikan_nama_lembaga">
<input type="text" data-table="rwy_pendidikan" data-field="x_nama_lembaga" name="x_nama_lembaga" id="x_nama_lembaga" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->nama_lembaga->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->nama_lembaga->EditValue ?>"<?php echo $rwy_pendidikan->nama_lembaga->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->nama_lembaga->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->no_ijazah->Visible) { // no_ijazah ?>
	<div id="r_no_ijazah" class="form-group">
		<label id="elh_rwy_pendidikan_no_ijazah" for="x_no_ijazah" class="<?php echo $rwy_pendidikan_edit->LeftColumnClass ?>"><?php echo $rwy_pendidikan->no_ijazah->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_edit->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->no_ijazah->CellAttributes() ?>>
<span id="el_rwy_pendidikan_no_ijazah">
<input type="text" data-table="rwy_pendidikan" data-field="x_no_ijazah" name="x_no_ijazah" id="x_no_ijazah" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->no_ijazah->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->no_ijazah->EditValue ?>"<?php echo $rwy_pendidikan->no_ijazah->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->no_ijazah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->tanggal_ijazah->Visible) { // tanggal_ijazah ?>
	<div id="r_tanggal_ijazah" class="form-group">
		<label id="elh_rwy_pendidikan_tanggal_ijazah" for="x_tanggal_ijazah" class="<?php echo $rwy_pendidikan_edit->LeftColumnClass ?>"><?php echo $rwy_pendidikan->tanggal_ijazah->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_edit->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->tanggal_ijazah->CellAttributes() ?>>
<span id="el_rwy_pendidikan_tanggal_ijazah">
<input type="text" data-table="rwy_pendidikan" data-field="x_tanggal_ijazah" name="x_tanggal_ijazah" id="x_tanggal_ijazah" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->tanggal_ijazah->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->tanggal_ijazah->EditValue ?>"<?php echo $rwy_pendidikan->tanggal_ijazah->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->tanggal_ijazah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->lokasi_pendidikan->Visible) { // lokasi_pendidikan ?>
	<div id="r_lokasi_pendidikan" class="form-group">
		<label id="elh_rwy_pendidikan_lokasi_pendidikan" for="x_lokasi_pendidikan" class="<?php echo $rwy_pendidikan_edit->LeftColumnClass ?>"><?php echo $rwy_pendidikan->lokasi_pendidikan->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_edit->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->lokasi_pendidikan->CellAttributes() ?>>
<span id="el_rwy_pendidikan_lokasi_pendidikan">
<input type="text" data-table="rwy_pendidikan" data-field="x_lokasi_pendidikan" name="x_lokasi_pendidikan" id="x_lokasi_pendidikan" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->lokasi_pendidikan->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->lokasi_pendidikan->EditValue ?>"<?php echo $rwy_pendidikan->lokasi_pendidikan->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->lokasi_pendidikan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->stat_validasi->Visible) { // stat_validasi ?>
	<div id="r_stat_validasi" class="form-group">
		<label id="elh_rwy_pendidikan_stat_validasi" for="x_stat_validasi" class="<?php echo $rwy_pendidikan_edit->LeftColumnClass ?>"><?php echo $rwy_pendidikan->stat_validasi->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_edit->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->stat_validasi->CellAttributes() ?>>
<span id="el_rwy_pendidikan_stat_validasi">
<input type="text" data-table="rwy_pendidikan" data-field="x_stat_validasi" name="x_stat_validasi" id="x_stat_validasi" size="30" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->stat_validasi->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->stat_validasi->EditValue ?>"<?php echo $rwy_pendidikan->stat_validasi->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->stat_validasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->change_date->Visible) { // change_date ?>
	<div id="r_change_date" class="form-group">
		<label id="elh_rwy_pendidikan_change_date" for="x_change_date" class="<?php echo $rwy_pendidikan_edit->LeftColumnClass ?>"><?php echo $rwy_pendidikan->change_date->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_edit->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->change_date->CellAttributes() ?>>
<span id="el_rwy_pendidikan_change_date">
<input type="text" data-table="rwy_pendidikan" data-field="x_change_date" name="x_change_date" id="x_change_date" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->change_date->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->change_date->EditValue ?>"<?php echo $rwy_pendidikan->change_date->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->change_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($rwy_pendidikan->change_by->Visible) { // change_by ?>
	<div id="r_change_by" class="form-group">
		<label id="elh_rwy_pendidikan_change_by" for="x_change_by" class="<?php echo $rwy_pendidikan_edit->LeftColumnClass ?>"><?php echo $rwy_pendidikan->change_by->FldCaption() ?></label>
		<div class="<?php echo $rwy_pendidikan_edit->RightColumnClass ?>"><div<?php echo $rwy_pendidikan->change_by->CellAttributes() ?>>
<span id="el_rwy_pendidikan_change_by">
<input type="text" data-table="rwy_pendidikan" data-field="x_change_by" name="x_change_by" id="x_change_by" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($rwy_pendidikan->change_by->getPlaceHolder()) ?>" value="<?php echo $rwy_pendidikan->change_by->EditValue ?>"<?php echo $rwy_pendidikan->change_by->EditAttributes() ?>>
</span>
<?php echo $rwy_pendidikan->change_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$rwy_pendidikan_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $rwy_pendidikan_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $rwy_pendidikan_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
frwy_pendidikanedit.Init();
</script>
<?php
$rwy_pendidikan_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$rwy_pendidikan_edit->Page_Terminate();
?>
