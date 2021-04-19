<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tb_notifikasi_dinfo.php" ?>
<?php include_once "tb_notifikasiinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tb_notifikasi_d_add = NULL; // Initialize page object first

class ctb_notifikasi_d_add extends ctb_notifikasi_d {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'tb_notifikasi_d';

	// Page object name
	var $PageObjName = 'tb_notifikasi_d_add';

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

		// Table object (tb_notifikasi_d)
		if (!isset($GLOBALS["tb_notifikasi_d"]) || get_class($GLOBALS["tb_notifikasi_d"]) == "ctb_notifikasi_d") {
			$GLOBALS["tb_notifikasi_d"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_notifikasi_d"];
		}

		// Table object (tb_notifikasi)
		if (!isset($GLOBALS['tb_notifikasi'])) $GLOBALS['tb_notifikasi'] = new ctb_notifikasi();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_notifikasi_d', TRUE);

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
		$this->bagian->SetVisibility();
		$this->lokasi_kerja->SetVisibility();

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
		global $EW_EXPORT, $tb_notifikasi_d;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_notifikasi_d);
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
					if ($pageName == "tb_notifikasi_dview.php")
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

		// Set up master/detail parameters
		$this->SetupMasterParms();

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
			if (@$_GET["employee_id"] != "") {
				$this->employee_id->setQueryStringValue($_GET["employee_id"]);
				$this->setKey("employee_id", $this->employee_id->CurrentValue); // Set up key
			} else {
				$this->setKey("employee_id", ""); // Clear key
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
					$this->Page_Terminate("tb_notifikasi_dlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tb_notifikasi_dlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "tb_notifikasi_dview.php")
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
		$this->employee_id->CurrentValue = NULL;
		$this->employee_id->OldValue = $this->employee_id->CurrentValue;
		$this->bagian->CurrentValue = NULL;
		$this->bagian->OldValue = $this->bagian->CurrentValue;
		$this->lokasi_kerja->CurrentValue = NULL;
		$this->lokasi_kerja->OldValue = $this->lokasi_kerja->CurrentValue;
		$this->notif_active->CurrentValue = NULL;
		$this->notif_active->OldValue = $this->notif_active->CurrentValue;
		$this->status_notif->CurrentValue = NULL;
		$this->status_notif->OldValue = $this->status_notif->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->employee_id->FldIsDetailKey) {
			$this->employee_id->setFormValue($objForm->GetValue("x_employee_id"));
		}
		if (!$this->bagian->FldIsDetailKey) {
			$this->bagian->setFormValue($objForm->GetValue("x_bagian"));
		}
		if (!$this->lokasi_kerja->FldIsDetailKey) {
			$this->lokasi_kerja->setFormValue($objForm->GetValue("x_lokasi_kerja"));
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->employee_id->CurrentValue = $this->employee_id->FormValue;
		$this->bagian->CurrentValue = $this->bagian->FormValue;
		$this->lokasi_kerja->CurrentValue = $this->lokasi_kerja->FormValue;
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
		$this->bagian->setDbValue($row['bagian']);
		$this->lokasi_kerja->setDbValue($row['lokasi_kerja']);
		$this->notif_active->setDbValue($row['notif_active']);
		$this->status_notif->setDbValue($row['status_notif']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['employee_id'] = $this->employee_id->CurrentValue;
		$row['bagian'] = $this->bagian->CurrentValue;
		$row['lokasi_kerja'] = $this->lokasi_kerja->CurrentValue;
		$row['notif_active'] = $this->notif_active->CurrentValue;
		$row['status_notif'] = $this->status_notif->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->employee_id->DbValue = $row['employee_id'];
		$this->bagian->DbValue = $row['bagian'];
		$this->lokasi_kerja->DbValue = $row['lokasi_kerja'];
		$this->notif_active->DbValue = $row['notif_active'];
		$this->status_notif->DbValue = $row['status_notif'];
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
		// bagian
		// lokasi_kerja
		// notif_active
		// status_notif

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// employee_id
		$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
		if (strval($this->employee_id->CurrentValue) <> "") {
			$sFilterWrk = "a.employee_id" . ew_SearchString("=", $this->employee_id->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `employee_id`, `name` AS `DispFld`, `lok_kerja` AS `Disp2Fld`, `bagian` AS `Disp3Fld`, '' AS `Disp4Fld` FROM ( SELECT a.employee_id, CASE WHEN a.first_name <> '' AND a.last_name <> '' THEN Concat(a.first_name, ' ', a.last_name) WHEN a.first_name IS NULL AND a.last_name IS NULL THEN a.first_title WHEN a.first_name <> '' THEN a.first_name ELSE a.last_name END AS name, b.KET lok_kerja, c.ket bagian FROM personal a LEFT JOIN tb_pat b ON a.kd_pat = b.KD_PAT LEFT JOIN tb_gas c ON a.kd_gas = c.kd_gas ORDER BY a.kd_pat )a";
		$sWhereWrk = "";
		$this->employee_id->LookupFilters = array("dx1" => 'a.name', "dx2" => 'a.lok_kerja', "dx3" => 'a.bagian');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->employee_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->employee_id->ViewValue = $this->employee_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
			}
		} else {
			$this->employee_id->ViewValue = NULL;
		}
		$this->employee_id->ViewCustomAttributes = "";

		// bagian
		$this->bagian->ViewValue = $this->bagian->CurrentValue;
		$this->bagian->ViewCustomAttributes = "";

		// lokasi_kerja
		$this->lokasi_kerja->ViewValue = $this->lokasi_kerja->CurrentValue;
		$this->lokasi_kerja->ViewCustomAttributes = "";

		// notif_active
		if (strval($this->notif_active->CurrentValue) <> "") {
			$this->notif_active->ViewValue = $this->notif_active->OptionCaption($this->notif_active->CurrentValue);
		} else {
			$this->notif_active->ViewValue = NULL;
		}
		$this->notif_active->ViewCustomAttributes = "";

		// status_notif
		$this->status_notif->ViewValue = $this->status_notif->CurrentValue;
		$this->status_notif->ViewCustomAttributes = "";

			// employee_id
			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";
			$this->employee_id->TooltipValue = "";

			// bagian
			$this->bagian->LinkCustomAttributes = "";
			$this->bagian->HrefValue = "";
			$this->bagian->TooltipValue = "";

			// lokasi_kerja
			$this->lokasi_kerja->LinkCustomAttributes = "";
			$this->lokasi_kerja->HrefValue = "";
			$this->lokasi_kerja->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// employee_id
			$this->employee_id->EditAttrs["class"] = "form-control";
			$this->employee_id->EditCustomAttributes = "";
			$this->employee_id->EditValue = ew_HtmlEncode($this->employee_id->CurrentValue);
			if (strval($this->employee_id->CurrentValue) <> "") {
				$sFilterWrk = "a.employee_id" . ew_SearchString("=", $this->employee_id->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `employee_id`, `name` AS `DispFld`, `lok_kerja` AS `Disp2Fld`, `bagian` AS `Disp3Fld`, '' AS `Disp4Fld` FROM ( SELECT a.employee_id, CASE WHEN a.first_name <> '' AND a.last_name <> '' THEN Concat(a.first_name, ' ', a.last_name) WHEN a.first_name IS NULL AND a.last_name IS NULL THEN a.first_title WHEN a.first_name <> '' THEN a.first_name ELSE a.last_name END AS name, b.KET lok_kerja, c.ket bagian FROM personal a LEFT JOIN tb_pat b ON a.kd_pat = b.KD_PAT LEFT JOIN tb_gas c ON a.kd_gas = c.kd_gas ORDER BY a.kd_pat )a";
			$sWhereWrk = "";
			$this->employee_id->LookupFilters = array("dx1" => 'a.name', "dx2" => 'a.lok_kerja', "dx3" => 'a.bagian');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->employee_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$arwrk[3] = ew_HtmlEncode($rswrk->fields('Disp3Fld'));
					$this->employee_id->EditValue = $this->employee_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->employee_id->EditValue = ew_HtmlEncode($this->employee_id->CurrentValue);
				}
			} else {
				$this->employee_id->EditValue = NULL;
			}
			$this->employee_id->PlaceHolder = ew_RemoveHtml($this->employee_id->FldCaption());

			// bagian
			$this->bagian->EditAttrs["class"] = "form-control";
			$this->bagian->EditCustomAttributes = "";
			$this->bagian->EditValue = ew_HtmlEncode($this->bagian->CurrentValue);
			$this->bagian->PlaceHolder = ew_RemoveHtml($this->bagian->FldCaption());

			// lokasi_kerja
			$this->lokasi_kerja->EditAttrs["class"] = "form-control";
			$this->lokasi_kerja->EditCustomAttributes = "";
			$this->lokasi_kerja->EditValue = ew_HtmlEncode($this->lokasi_kerja->CurrentValue);
			$this->lokasi_kerja->PlaceHolder = ew_RemoveHtml($this->lokasi_kerja->FldCaption());

			// Add refer script
			// employee_id

			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";

			// bagian
			$this->bagian->LinkCustomAttributes = "";
			$this->bagian->HrefValue = "";

			// lokasi_kerja
			$this->lokasi_kerja->LinkCustomAttributes = "";
			$this->lokasi_kerja->HrefValue = "";
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

		// Check referential integrity for master table 'tb_notifikasi'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_tb_notifikasi();
		if ($this->id->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@id@", ew_AdjustSql($this->id->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			if (!isset($GLOBALS["tb_notifikasi"])) $GLOBALS["tb_notifikasi"] = new ctb_notifikasi();
			$rsmaster = $GLOBALS["tb_notifikasi"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "tb_notifikasi", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// employee_id
		$this->employee_id->SetDbValueDef($rsnew, $this->employee_id->CurrentValue, "", FALSE);

		// bagian
		$this->bagian->SetDbValueDef($rsnew, $this->bagian->CurrentValue, NULL, FALSE);

		// lokasi_kerja
		$this->lokasi_kerja->SetDbValueDef($rsnew, $this->lokasi_kerja->CurrentValue, NULL, FALSE);

		// id
		if ($this->id->getSessionValue() <> "") {
			$rsnew['id'] = $this->id->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['employee_id']) == "") {
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

	// Set up master/detail based on QueryString
	function SetupMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "tb_notifikasi") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["tb_notifikasi"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->id->setQueryStringValue($GLOBALS["tb_notifikasi"]->id->QueryStringValue);
					$this->id->setSessionValue($this->id->QueryStringValue);
					if (!is_numeric($GLOBALS["tb_notifikasi"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "tb_notifikasi") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["tb_notifikasi"]->id->setFormValue($_POST["fk_id"]);
					$this->id->setFormValue($GLOBALS["tb_notifikasi"]->id->FormValue);
					$this->id->setSessionValue($this->id->FormValue);
					if (!is_numeric($GLOBALS["tb_notifikasi"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			if (!$this->IsAddOrEdit()) {
				$this->StartRec = 1;
				$this->setStartRecordNumber($this->StartRec);
			}

			// Clear previous master key from Session
			if ($sMasterTblVar <> "tb_notifikasi") {
				if ($this->id->CurrentValue == "") $this->id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_notifikasi_dlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_employee_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `employee_id` AS `LinkFld`, `name` AS `DispFld`, `lok_kerja` AS `Disp2Fld`, `bagian` AS `Disp3Fld`, '' AS `Disp4Fld` FROM ( SELECT a.employee_id, CASE WHEN a.first_name <> '' AND a.last_name <> '' THEN Concat(a.first_name, ' ', a.last_name) WHEN a.first_name IS NULL AND a.last_name IS NULL THEN a.first_title WHEN a.first_name <> '' THEN a.first_name ELSE a.last_name END AS name, b.KET lok_kerja, c.ket bagian FROM personal a LEFT JOIN tb_pat b ON a.kd_pat = b.KD_PAT LEFT JOIN tb_gas c ON a.kd_gas = c.kd_gas ORDER BY a.kd_pat )a";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => 'a.name', "dx2" => 'a.lok_kerja', "dx3" => 'a.bagian');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => 'a.employee_id IN ({filter_value})', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->employee_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_employee_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `employee_id`, `name` AS `DispFld`, `lok_kerja` AS `Disp2Fld`, `bagian` AS `Disp3Fld` FROM ( SELECT a.employee_id, CASE WHEN a.first_name <> '' AND a.last_name <> '' THEN Concat(a.first_name, ' ', a.last_name) WHEN a.first_name IS NULL AND a.last_name IS NULL THEN a.first_title WHEN a.first_name <> '' THEN a.first_name ELSE a.last_name END AS name, b.KET lok_kerja, c.ket bagian FROM personal a LEFT JOIN tb_pat b ON a.kd_pat = b.KD_PAT LEFT JOIN tb_gas c ON a.kd_gas = c.kd_gas ORDER BY a.kd_pat )a";
			$sWhereWrk = "`name` LIKE '{query_value}%' OR CONCAT(`name`,'" . ew_ValueSeparator(1, $this->employee_id) . "',`lok_kerja`,'" . ew_ValueSeparator(2, $this->employee_id) . "',`bagian`) LIKE '{query_value}%'";
			$fld->LookupFilters = array("dx1" => 'a.name', "dx2" => 'a.lok_kerja', "dx3" => 'a.bagian');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->employee_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($tb_notifikasi_d_add)) $tb_notifikasi_d_add = new ctb_notifikasi_d_add();

// Page init
$tb_notifikasi_d_add->Page_Init();

// Page main
$tb_notifikasi_d_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_notifikasi_d_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftb_notifikasi_dadd = new ew_Form("ftb_notifikasi_dadd", "add");

// Validate form
ftb_notifikasi_dadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_notifikasi_d->employee_id->FldCaption(), $tb_notifikasi_d->employee_id->ReqErrMsg)) ?>");

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
ftb_notifikasi_dadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftb_notifikasi_dadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftb_notifikasi_dadd.Lists["x_employee_id"] = {"LinkField":"x_employee_id","Ajax":true,"AutoFill":true,"DisplayFields":["x_name","x_lok_kerja","x_bagian",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_personal"};
ftb_notifikasi_dadd.Lists["x_employee_id"].Data = "<?php echo $tb_notifikasi_d_add->employee_id->LookupFilterQuery(FALSE, "add") ?>";
ftb_notifikasi_dadd.AutoSuggests["x_employee_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $tb_notifikasi_d_add->employee_id->LookupFilterQuery(TRUE, "add"))) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tb_notifikasi_d_add->ShowPageHeader(); ?>
<?php
$tb_notifikasi_d_add->ShowMessage();
?>
<form name="ftb_notifikasi_dadd" id="ftb_notifikasi_dadd" class="<?php echo $tb_notifikasi_d_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_notifikasi_d_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_notifikasi_d_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_notifikasi_d">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($tb_notifikasi_d_add->IsModal) ?>">
<?php if ($tb_notifikasi_d->getCurrentMasterTable() == "tb_notifikasi") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="tb_notifikasi">
<input type="hidden" name="fk_id" value="<?php echo $tb_notifikasi_d->id->getSessionValue() ?>">
<?php } ?>
<div class="ewAddDiv"><!-- page* -->
<?php if ($tb_notifikasi_d->employee_id->Visible) { // employee_id ?>
	<div id="r_employee_id" class="form-group">
		<label id="elh_tb_notifikasi_d_employee_id" class="<?php echo $tb_notifikasi_d_add->LeftColumnClass ?>"><?php echo $tb_notifikasi_d->employee_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $tb_notifikasi_d_add->RightColumnClass ?>"><div<?php echo $tb_notifikasi_d->employee_id->CellAttributes() ?>>
<span id="el_tb_notifikasi_d_employee_id">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$tb_notifikasi_d->employee_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_notifikasi_d->employee_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_employee_id" style="white-space: nowrap; z-index: 8980">
	<input type="text" name="sv_x_employee_id" id="sv_x_employee_id" value="<?php echo $tb_notifikasi_d->employee_id->EditValue ?>" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->getPlaceHolder()) ?>"<?php echo $tb_notifikasi_d->employee_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_employee_id" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_notifikasi_d->employee_id->DisplayValueSeparatorAttribute() ?>" name="x_employee_id" id="x_employee_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ftb_notifikasi_dadd.CreateAutoSuggest({"id":"x_employee_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_notifikasi_d->employee_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_employee_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($tb_notifikasi_d->employee_id->ReadOnly || $tb_notifikasi_d->employee_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="ln_x_employee_id" id="ln_x_employee_id" value="x_bagian,x_lokasi_kerja">
</span>
<?php echo $tb_notifikasi_d->employee_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_notifikasi_d->bagian->Visible) { // bagian ?>
	<div id="r_bagian" class="form-group">
		<label id="elh_tb_notifikasi_d_bagian" for="x_bagian" class="<?php echo $tb_notifikasi_d_add->LeftColumnClass ?>"><?php echo $tb_notifikasi_d->bagian->FldCaption() ?></label>
		<div class="<?php echo $tb_notifikasi_d_add->RightColumnClass ?>"><div<?php echo $tb_notifikasi_d->bagian->CellAttributes() ?>>
<span id="el_tb_notifikasi_d_bagian">
<input type="text" data-table="tb_notifikasi_d" data-field="x_bagian" data-page="1" name="x_bagian" id="x_bagian" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($tb_notifikasi_d->bagian->getPlaceHolder()) ?>" value="<?php echo $tb_notifikasi_d->bagian->EditValue ?>"<?php echo $tb_notifikasi_d->bagian->EditAttributes() ?>>
</span>
<?php echo $tb_notifikasi_d->bagian->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_notifikasi_d->lokasi_kerja->Visible) { // lokasi_kerja ?>
	<div id="r_lokasi_kerja" class="form-group">
		<label id="elh_tb_notifikasi_d_lokasi_kerja" for="x_lokasi_kerja" class="<?php echo $tb_notifikasi_d_add->LeftColumnClass ?>"><?php echo $tb_notifikasi_d->lokasi_kerja->FldCaption() ?></label>
		<div class="<?php echo $tb_notifikasi_d_add->RightColumnClass ?>"><div<?php echo $tb_notifikasi_d->lokasi_kerja->CellAttributes() ?>>
<span id="el_tb_notifikasi_d_lokasi_kerja">
<input type="text" data-table="tb_notifikasi_d" data-field="x_lokasi_kerja" data-page="1" name="x_lokasi_kerja" id="x_lokasi_kerja" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($tb_notifikasi_d->lokasi_kerja->getPlaceHolder()) ?>" value="<?php echo $tb_notifikasi_d->lokasi_kerja->EditValue ?>"<?php echo $tb_notifikasi_d->lokasi_kerja->EditAttributes() ?>>
</span>
<?php echo $tb_notifikasi_d->lokasi_kerja->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (strval($tb_notifikasi_d->id->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode(strval($tb_notifikasi_d->id->getSessionValue())) ?>">
<?php } ?>
<?php if (!$tb_notifikasi_d_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $tb_notifikasi_d_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_notifikasi_d_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ftb_notifikasi_dadd.Init();
</script>
<?php
$tb_notifikasi_d_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_notifikasi_d_add->Page_Terminate();
?>
