<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tb_patinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tb_pat_edit = NULL; // Initialize page object first

class ctb_pat_edit extends ctb_pat {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'tb_pat';

	// Page object name
	var $PageObjName = 'tb_pat_edit';

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

		// Table object (tb_pat)
		if (!isset($GLOBALS["tb_pat"]) || get_class($GLOBALS["tb_pat"]) == "ctb_pat") {
			$GLOBALS["tb_pat"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_pat"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_pat', TRUE);

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
		$this->KD_PAT->SetVisibility();
		$this->KET->SetVisibility();
		$this->ALAMAT->SetVisibility();
		$this->KOTA->SetVisibility();
		$this->SINGKATAN->SetVisibility();
		$this->CREATED_BY->SetVisibility();
		$this->CREATED_DATE->SetVisibility();
		$this->LAST_UPDATE_BY->SetVisibility();
		$this->LAST_UPDATE_DATE->SetVisibility();

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
		global $EW_EXPORT, $tb_pat;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_pat);
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
					if ($pageName == "tb_patview.php")
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
			if ($objForm->HasValue("x_KD_PAT")) {
				$this->KD_PAT->setFormValue($objForm->GetValue("x_KD_PAT"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["KD_PAT"])) {
				$this->KD_PAT->setQueryStringValue($_GET["KD_PAT"]);
				$loadByQuery = TRUE;
			} else {
				$this->KD_PAT->CurrentValue = NULL;
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
					$this->Page_Terminate("tb_patlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "tb_patlist.php")
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
		if (!$this->KD_PAT->FldIsDetailKey) {
			$this->KD_PAT->setFormValue($objForm->GetValue("x_KD_PAT"));
		}
		if (!$this->KET->FldIsDetailKey) {
			$this->KET->setFormValue($objForm->GetValue("x_KET"));
		}
		if (!$this->ALAMAT->FldIsDetailKey) {
			$this->ALAMAT->setFormValue($objForm->GetValue("x_ALAMAT"));
		}
		if (!$this->KOTA->FldIsDetailKey) {
			$this->KOTA->setFormValue($objForm->GetValue("x_KOTA"));
		}
		if (!$this->SINGKATAN->FldIsDetailKey) {
			$this->SINGKATAN->setFormValue($objForm->GetValue("x_SINGKATAN"));
		}
		if (!$this->CREATED_BY->FldIsDetailKey) {
			$this->CREATED_BY->setFormValue($objForm->GetValue("x_CREATED_BY"));
		}
		if (!$this->CREATED_DATE->FldIsDetailKey) {
			$this->CREATED_DATE->setFormValue($objForm->GetValue("x_CREATED_DATE"));
			$this->CREATED_DATE->CurrentValue = ew_UnFormatDateTime($this->CREATED_DATE->CurrentValue, 0);
		}
		if (!$this->LAST_UPDATE_BY->FldIsDetailKey) {
			$this->LAST_UPDATE_BY->setFormValue($objForm->GetValue("x_LAST_UPDATE_BY"));
		}
		if (!$this->LAST_UPDATE_DATE->FldIsDetailKey) {
			$this->LAST_UPDATE_DATE->setFormValue($objForm->GetValue("x_LAST_UPDATE_DATE"));
			$this->LAST_UPDATE_DATE->CurrentValue = ew_UnFormatDateTime($this->LAST_UPDATE_DATE->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->KD_PAT->CurrentValue = $this->KD_PAT->FormValue;
		$this->KET->CurrentValue = $this->KET->FormValue;
		$this->ALAMAT->CurrentValue = $this->ALAMAT->FormValue;
		$this->KOTA->CurrentValue = $this->KOTA->FormValue;
		$this->SINGKATAN->CurrentValue = $this->SINGKATAN->FormValue;
		$this->CREATED_BY->CurrentValue = $this->CREATED_BY->FormValue;
		$this->CREATED_DATE->CurrentValue = $this->CREATED_DATE->FormValue;
		$this->CREATED_DATE->CurrentValue = ew_UnFormatDateTime($this->CREATED_DATE->CurrentValue, 0);
		$this->LAST_UPDATE_BY->CurrentValue = $this->LAST_UPDATE_BY->FormValue;
		$this->LAST_UPDATE_DATE->CurrentValue = $this->LAST_UPDATE_DATE->FormValue;
		$this->LAST_UPDATE_DATE->CurrentValue = ew_UnFormatDateTime($this->LAST_UPDATE_DATE->CurrentValue, 0);
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
		$this->KD_PAT->setDbValue($row['KD_PAT']);
		$this->KET->setDbValue($row['KET']);
		$this->ALAMAT->setDbValue($row['ALAMAT']);
		$this->KOTA->setDbValue($row['KOTA']);
		$this->SINGKATAN->setDbValue($row['SINGKATAN']);
		$this->CREATED_BY->setDbValue($row['CREATED_BY']);
		$this->CREATED_DATE->setDbValue($row['CREATED_DATE']);
		$this->LAST_UPDATE_BY->setDbValue($row['LAST_UPDATE_BY']);
		$this->LAST_UPDATE_DATE->setDbValue($row['LAST_UPDATE_DATE']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['KD_PAT'] = NULL;
		$row['KET'] = NULL;
		$row['ALAMAT'] = NULL;
		$row['KOTA'] = NULL;
		$row['SINGKATAN'] = NULL;
		$row['CREATED_BY'] = NULL;
		$row['CREATED_DATE'] = NULL;
		$row['LAST_UPDATE_BY'] = NULL;
		$row['LAST_UPDATE_DATE'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->KD_PAT->DbValue = $row['KD_PAT'];
		$this->KET->DbValue = $row['KET'];
		$this->ALAMAT->DbValue = $row['ALAMAT'];
		$this->KOTA->DbValue = $row['KOTA'];
		$this->SINGKATAN->DbValue = $row['SINGKATAN'];
		$this->CREATED_BY->DbValue = $row['CREATED_BY'];
		$this->CREATED_DATE->DbValue = $row['CREATED_DATE'];
		$this->LAST_UPDATE_BY->DbValue = $row['LAST_UPDATE_BY'];
		$this->LAST_UPDATE_DATE->DbValue = $row['LAST_UPDATE_DATE'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("KD_PAT")) <> "")
			$this->KD_PAT->CurrentValue = $this->getKey("KD_PAT"); // KD_PAT
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
		// KD_PAT
		// KET
		// ALAMAT
		// KOTA
		// SINGKATAN
		// CREATED_BY
		// CREATED_DATE
		// LAST_UPDATE_BY
		// LAST_UPDATE_DATE

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// KD_PAT
		$this->KD_PAT->ViewValue = $this->KD_PAT->CurrentValue;
		$this->KD_PAT->ViewCustomAttributes = "";

		// KET
		$this->KET->ViewValue = $this->KET->CurrentValue;
		$this->KET->ViewCustomAttributes = "";

		// ALAMAT
		$this->ALAMAT->ViewValue = $this->ALAMAT->CurrentValue;
		$this->ALAMAT->ViewCustomAttributes = "";

		// KOTA
		$this->KOTA->ViewValue = $this->KOTA->CurrentValue;
		$this->KOTA->ViewCustomAttributes = "";

		// SINGKATAN
		$this->SINGKATAN->ViewValue = $this->SINGKATAN->CurrentValue;
		$this->SINGKATAN->ViewCustomAttributes = "";

		// CREATED_BY
		$this->CREATED_BY->ViewValue = $this->CREATED_BY->CurrentValue;
		$this->CREATED_BY->ViewCustomAttributes = "";

		// CREATED_DATE
		$this->CREATED_DATE->ViewValue = $this->CREATED_DATE->CurrentValue;
		$this->CREATED_DATE->ViewValue = ew_FormatDateTime($this->CREATED_DATE->ViewValue, 0);
		$this->CREATED_DATE->ViewCustomAttributes = "";

		// LAST_UPDATE_BY
		$this->LAST_UPDATE_BY->ViewValue = $this->LAST_UPDATE_BY->CurrentValue;
		$this->LAST_UPDATE_BY->ViewCustomAttributes = "";

		// LAST_UPDATE_DATE
		$this->LAST_UPDATE_DATE->ViewValue = $this->LAST_UPDATE_DATE->CurrentValue;
		$this->LAST_UPDATE_DATE->ViewValue = ew_FormatDateTime($this->LAST_UPDATE_DATE->ViewValue, 0);
		$this->LAST_UPDATE_DATE->ViewCustomAttributes = "";

			// KD_PAT
			$this->KD_PAT->LinkCustomAttributes = "";
			$this->KD_PAT->HrefValue = "";
			$this->KD_PAT->TooltipValue = "";

			// KET
			$this->KET->LinkCustomAttributes = "";
			$this->KET->HrefValue = "";
			$this->KET->TooltipValue = "";

			// ALAMAT
			$this->ALAMAT->LinkCustomAttributes = "";
			$this->ALAMAT->HrefValue = "";
			$this->ALAMAT->TooltipValue = "";

			// KOTA
			$this->KOTA->LinkCustomAttributes = "";
			$this->KOTA->HrefValue = "";
			$this->KOTA->TooltipValue = "";

			// SINGKATAN
			$this->SINGKATAN->LinkCustomAttributes = "";
			$this->SINGKATAN->HrefValue = "";
			$this->SINGKATAN->TooltipValue = "";

			// CREATED_BY
			$this->CREATED_BY->LinkCustomAttributes = "";
			$this->CREATED_BY->HrefValue = "";
			$this->CREATED_BY->TooltipValue = "";

			// CREATED_DATE
			$this->CREATED_DATE->LinkCustomAttributes = "";
			$this->CREATED_DATE->HrefValue = "";
			$this->CREATED_DATE->TooltipValue = "";

			// LAST_UPDATE_BY
			$this->LAST_UPDATE_BY->LinkCustomAttributes = "";
			$this->LAST_UPDATE_BY->HrefValue = "";
			$this->LAST_UPDATE_BY->TooltipValue = "";

			// LAST_UPDATE_DATE
			$this->LAST_UPDATE_DATE->LinkCustomAttributes = "";
			$this->LAST_UPDATE_DATE->HrefValue = "";
			$this->LAST_UPDATE_DATE->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// KD_PAT
			$this->KD_PAT->EditAttrs["class"] = "form-control";
			$this->KD_PAT->EditCustomAttributes = "";
			$this->KD_PAT->EditValue = $this->KD_PAT->CurrentValue;
			$this->KD_PAT->ViewCustomAttributes = "";

			// KET
			$this->KET->EditAttrs["class"] = "form-control";
			$this->KET->EditCustomAttributes = "";
			$this->KET->EditValue = ew_HtmlEncode($this->KET->CurrentValue);
			$this->KET->PlaceHolder = ew_RemoveHtml($this->KET->FldCaption());

			// ALAMAT
			$this->ALAMAT->EditAttrs["class"] = "form-control";
			$this->ALAMAT->EditCustomAttributes = "";
			$this->ALAMAT->EditValue = ew_HtmlEncode($this->ALAMAT->CurrentValue);
			$this->ALAMAT->PlaceHolder = ew_RemoveHtml($this->ALAMAT->FldCaption());

			// KOTA
			$this->KOTA->EditAttrs["class"] = "form-control";
			$this->KOTA->EditCustomAttributes = "";
			$this->KOTA->EditValue = ew_HtmlEncode($this->KOTA->CurrentValue);
			$this->KOTA->PlaceHolder = ew_RemoveHtml($this->KOTA->FldCaption());

			// SINGKATAN
			$this->SINGKATAN->EditAttrs["class"] = "form-control";
			$this->SINGKATAN->EditCustomAttributes = "";
			$this->SINGKATAN->EditValue = ew_HtmlEncode($this->SINGKATAN->CurrentValue);
			$this->SINGKATAN->PlaceHolder = ew_RemoveHtml($this->SINGKATAN->FldCaption());

			// CREATED_BY
			$this->CREATED_BY->EditAttrs["class"] = "form-control";
			$this->CREATED_BY->EditCustomAttributes = "";
			$this->CREATED_BY->EditValue = ew_HtmlEncode($this->CREATED_BY->CurrentValue);
			$this->CREATED_BY->PlaceHolder = ew_RemoveHtml($this->CREATED_BY->FldCaption());

			// CREATED_DATE
			$this->CREATED_DATE->EditAttrs["class"] = "form-control";
			$this->CREATED_DATE->EditCustomAttributes = "";
			$this->CREATED_DATE->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->CREATED_DATE->CurrentValue, 8));
			$this->CREATED_DATE->PlaceHolder = ew_RemoveHtml($this->CREATED_DATE->FldCaption());

			// LAST_UPDATE_BY
			$this->LAST_UPDATE_BY->EditAttrs["class"] = "form-control";
			$this->LAST_UPDATE_BY->EditCustomAttributes = "";
			$this->LAST_UPDATE_BY->EditValue = ew_HtmlEncode($this->LAST_UPDATE_BY->CurrentValue);
			$this->LAST_UPDATE_BY->PlaceHolder = ew_RemoveHtml($this->LAST_UPDATE_BY->FldCaption());

			// LAST_UPDATE_DATE
			$this->LAST_UPDATE_DATE->EditAttrs["class"] = "form-control";
			$this->LAST_UPDATE_DATE->EditCustomAttributes = "";
			$this->LAST_UPDATE_DATE->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->LAST_UPDATE_DATE->CurrentValue, 8));
			$this->LAST_UPDATE_DATE->PlaceHolder = ew_RemoveHtml($this->LAST_UPDATE_DATE->FldCaption());

			// Edit refer script
			// KD_PAT

			$this->KD_PAT->LinkCustomAttributes = "";
			$this->KD_PAT->HrefValue = "";

			// KET
			$this->KET->LinkCustomAttributes = "";
			$this->KET->HrefValue = "";

			// ALAMAT
			$this->ALAMAT->LinkCustomAttributes = "";
			$this->ALAMAT->HrefValue = "";

			// KOTA
			$this->KOTA->LinkCustomAttributes = "";
			$this->KOTA->HrefValue = "";

			// SINGKATAN
			$this->SINGKATAN->LinkCustomAttributes = "";
			$this->SINGKATAN->HrefValue = "";

			// CREATED_BY
			$this->CREATED_BY->LinkCustomAttributes = "";
			$this->CREATED_BY->HrefValue = "";

			// CREATED_DATE
			$this->CREATED_DATE->LinkCustomAttributes = "";
			$this->CREATED_DATE->HrefValue = "";

			// LAST_UPDATE_BY
			$this->LAST_UPDATE_BY->LinkCustomAttributes = "";
			$this->LAST_UPDATE_BY->HrefValue = "";

			// LAST_UPDATE_DATE
			$this->LAST_UPDATE_DATE->LinkCustomAttributes = "";
			$this->LAST_UPDATE_DATE->HrefValue = "";
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
		if (!$this->KD_PAT->FldIsDetailKey && !is_null($this->KD_PAT->FormValue) && $this->KD_PAT->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KD_PAT->FldCaption(), $this->KD_PAT->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->CREATED_DATE->FormValue)) {
			ew_AddMessage($gsFormError, $this->CREATED_DATE->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->LAST_UPDATE_DATE->FormValue)) {
			ew_AddMessage($gsFormError, $this->LAST_UPDATE_DATE->FldErrMsg());
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

			// KD_PAT
			// KET

			$this->KET->SetDbValueDef($rsnew, $this->KET->CurrentValue, NULL, $this->KET->ReadOnly);

			// ALAMAT
			$this->ALAMAT->SetDbValueDef($rsnew, $this->ALAMAT->CurrentValue, NULL, $this->ALAMAT->ReadOnly);

			// KOTA
			$this->KOTA->SetDbValueDef($rsnew, $this->KOTA->CurrentValue, NULL, $this->KOTA->ReadOnly);

			// SINGKATAN
			$this->SINGKATAN->SetDbValueDef($rsnew, $this->SINGKATAN->CurrentValue, NULL, $this->SINGKATAN->ReadOnly);

			// CREATED_BY
			$this->CREATED_BY->SetDbValueDef($rsnew, $this->CREATED_BY->CurrentValue, NULL, $this->CREATED_BY->ReadOnly);

			// CREATED_DATE
			$this->CREATED_DATE->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->CREATED_DATE->CurrentValue, 0), NULL, $this->CREATED_DATE->ReadOnly);

			// LAST_UPDATE_BY
			$this->LAST_UPDATE_BY->SetDbValueDef($rsnew, $this->LAST_UPDATE_BY->CurrentValue, NULL, $this->LAST_UPDATE_BY->ReadOnly);

			// LAST_UPDATE_DATE
			$this->LAST_UPDATE_DATE->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->LAST_UPDATE_DATE->CurrentValue, 0), NULL, $this->LAST_UPDATE_DATE->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_patlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($tb_pat_edit)) $tb_pat_edit = new ctb_pat_edit();

// Page init
$tb_pat_edit->Page_Init();

// Page main
$tb_pat_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_pat_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ftb_patedit = new ew_Form("ftb_patedit", "edit");

// Validate form
ftb_patedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_KD_PAT");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_pat->KD_PAT->FldCaption(), $tb_pat->KD_PAT->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_CREATED_DATE");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_pat->CREATED_DATE->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_LAST_UPDATE_DATE");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_pat->LAST_UPDATE_DATE->FldErrMsg()) ?>");

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
ftb_patedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftb_patedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tb_pat_edit->ShowPageHeader(); ?>
<?php
$tb_pat_edit->ShowMessage();
?>
<form name="ftb_patedit" id="ftb_patedit" class="<?php echo $tb_pat_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_pat_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_pat_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_pat">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($tb_pat_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($tb_pat->KD_PAT->Visible) { // KD_PAT ?>
	<div id="r_KD_PAT" class="form-group">
		<label id="elh_tb_pat_KD_PAT" for="x_KD_PAT" class="<?php echo $tb_pat_edit->LeftColumnClass ?>"><?php echo $tb_pat->KD_PAT->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $tb_pat_edit->RightColumnClass ?>"><div<?php echo $tb_pat->KD_PAT->CellAttributes() ?>>
<span id="el_tb_pat_KD_PAT">
<span<?php echo $tb_pat->KD_PAT->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_pat->KD_PAT->EditValue ?></p></span>
</span>
<input type="hidden" data-table="tb_pat" data-field="x_KD_PAT" name="x_KD_PAT" id="x_KD_PAT" value="<?php echo ew_HtmlEncode($tb_pat->KD_PAT->CurrentValue) ?>">
<?php echo $tb_pat->KD_PAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_pat->KET->Visible) { // KET ?>
	<div id="r_KET" class="form-group">
		<label id="elh_tb_pat_KET" for="x_KET" class="<?php echo $tb_pat_edit->LeftColumnClass ?>"><?php echo $tb_pat->KET->FldCaption() ?></label>
		<div class="<?php echo $tb_pat_edit->RightColumnClass ?>"><div<?php echo $tb_pat->KET->CellAttributes() ?>>
<span id="el_tb_pat_KET">
<input type="text" data-table="tb_pat" data-field="x_KET" name="x_KET" id="x_KET" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($tb_pat->KET->getPlaceHolder()) ?>" value="<?php echo $tb_pat->KET->EditValue ?>"<?php echo $tb_pat->KET->EditAttributes() ?>>
</span>
<?php echo $tb_pat->KET->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_pat->ALAMAT->Visible) { // ALAMAT ?>
	<div id="r_ALAMAT" class="form-group">
		<label id="elh_tb_pat_ALAMAT" for="x_ALAMAT" class="<?php echo $tb_pat_edit->LeftColumnClass ?>"><?php echo $tb_pat->ALAMAT->FldCaption() ?></label>
		<div class="<?php echo $tb_pat_edit->RightColumnClass ?>"><div<?php echo $tb_pat->ALAMAT->CellAttributes() ?>>
<span id="el_tb_pat_ALAMAT">
<input type="text" data-table="tb_pat" data-field="x_ALAMAT" name="x_ALAMAT" id="x_ALAMAT" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tb_pat->ALAMAT->getPlaceHolder()) ?>" value="<?php echo $tb_pat->ALAMAT->EditValue ?>"<?php echo $tb_pat->ALAMAT->EditAttributes() ?>>
</span>
<?php echo $tb_pat->ALAMAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_pat->KOTA->Visible) { // KOTA ?>
	<div id="r_KOTA" class="form-group">
		<label id="elh_tb_pat_KOTA" for="x_KOTA" class="<?php echo $tb_pat_edit->LeftColumnClass ?>"><?php echo $tb_pat->KOTA->FldCaption() ?></label>
		<div class="<?php echo $tb_pat_edit->RightColumnClass ?>"><div<?php echo $tb_pat->KOTA->CellAttributes() ?>>
<span id="el_tb_pat_KOTA">
<input type="text" data-table="tb_pat" data-field="x_KOTA" name="x_KOTA" id="x_KOTA" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($tb_pat->KOTA->getPlaceHolder()) ?>" value="<?php echo $tb_pat->KOTA->EditValue ?>"<?php echo $tb_pat->KOTA->EditAttributes() ?>>
</span>
<?php echo $tb_pat->KOTA->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_pat->SINGKATAN->Visible) { // SINGKATAN ?>
	<div id="r_SINGKATAN" class="form-group">
		<label id="elh_tb_pat_SINGKATAN" for="x_SINGKATAN" class="<?php echo $tb_pat_edit->LeftColumnClass ?>"><?php echo $tb_pat->SINGKATAN->FldCaption() ?></label>
		<div class="<?php echo $tb_pat_edit->RightColumnClass ?>"><div<?php echo $tb_pat->SINGKATAN->CellAttributes() ?>>
<span id="el_tb_pat_SINGKATAN">
<input type="text" data-table="tb_pat" data-field="x_SINGKATAN" name="x_SINGKATAN" id="x_SINGKATAN" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tb_pat->SINGKATAN->getPlaceHolder()) ?>" value="<?php echo $tb_pat->SINGKATAN->EditValue ?>"<?php echo $tb_pat->SINGKATAN->EditAttributes() ?>>
</span>
<?php echo $tb_pat->SINGKATAN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_pat->CREATED_BY->Visible) { // CREATED_BY ?>
	<div id="r_CREATED_BY" class="form-group">
		<label id="elh_tb_pat_CREATED_BY" for="x_CREATED_BY" class="<?php echo $tb_pat_edit->LeftColumnClass ?>"><?php echo $tb_pat->CREATED_BY->FldCaption() ?></label>
		<div class="<?php echo $tb_pat_edit->RightColumnClass ?>"><div<?php echo $tb_pat->CREATED_BY->CellAttributes() ?>>
<span id="el_tb_pat_CREATED_BY">
<input type="text" data-table="tb_pat" data-field="x_CREATED_BY" name="x_CREATED_BY" id="x_CREATED_BY" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($tb_pat->CREATED_BY->getPlaceHolder()) ?>" value="<?php echo $tb_pat->CREATED_BY->EditValue ?>"<?php echo $tb_pat->CREATED_BY->EditAttributes() ?>>
</span>
<?php echo $tb_pat->CREATED_BY->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_pat->CREATED_DATE->Visible) { // CREATED_DATE ?>
	<div id="r_CREATED_DATE" class="form-group">
		<label id="elh_tb_pat_CREATED_DATE" for="x_CREATED_DATE" class="<?php echo $tb_pat_edit->LeftColumnClass ?>"><?php echo $tb_pat->CREATED_DATE->FldCaption() ?></label>
		<div class="<?php echo $tb_pat_edit->RightColumnClass ?>"><div<?php echo $tb_pat->CREATED_DATE->CellAttributes() ?>>
<span id="el_tb_pat_CREATED_DATE">
<input type="text" data-table="tb_pat" data-field="x_CREATED_DATE" name="x_CREATED_DATE" id="x_CREATED_DATE" placeholder="<?php echo ew_HtmlEncode($tb_pat->CREATED_DATE->getPlaceHolder()) ?>" value="<?php echo $tb_pat->CREATED_DATE->EditValue ?>"<?php echo $tb_pat->CREATED_DATE->EditAttributes() ?>>
</span>
<?php echo $tb_pat->CREATED_DATE->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_pat->LAST_UPDATE_BY->Visible) { // LAST_UPDATE_BY ?>
	<div id="r_LAST_UPDATE_BY" class="form-group">
		<label id="elh_tb_pat_LAST_UPDATE_BY" for="x_LAST_UPDATE_BY" class="<?php echo $tb_pat_edit->LeftColumnClass ?>"><?php echo $tb_pat->LAST_UPDATE_BY->FldCaption() ?></label>
		<div class="<?php echo $tb_pat_edit->RightColumnClass ?>"><div<?php echo $tb_pat->LAST_UPDATE_BY->CellAttributes() ?>>
<span id="el_tb_pat_LAST_UPDATE_BY">
<input type="text" data-table="tb_pat" data-field="x_LAST_UPDATE_BY" name="x_LAST_UPDATE_BY" id="x_LAST_UPDATE_BY" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($tb_pat->LAST_UPDATE_BY->getPlaceHolder()) ?>" value="<?php echo $tb_pat->LAST_UPDATE_BY->EditValue ?>"<?php echo $tb_pat->LAST_UPDATE_BY->EditAttributes() ?>>
</span>
<?php echo $tb_pat->LAST_UPDATE_BY->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_pat->LAST_UPDATE_DATE->Visible) { // LAST_UPDATE_DATE ?>
	<div id="r_LAST_UPDATE_DATE" class="form-group">
		<label id="elh_tb_pat_LAST_UPDATE_DATE" for="x_LAST_UPDATE_DATE" class="<?php echo $tb_pat_edit->LeftColumnClass ?>"><?php echo $tb_pat->LAST_UPDATE_DATE->FldCaption() ?></label>
		<div class="<?php echo $tb_pat_edit->RightColumnClass ?>"><div<?php echo $tb_pat->LAST_UPDATE_DATE->CellAttributes() ?>>
<span id="el_tb_pat_LAST_UPDATE_DATE">
<input type="text" data-table="tb_pat" data-field="x_LAST_UPDATE_DATE" name="x_LAST_UPDATE_DATE" id="x_LAST_UPDATE_DATE" placeholder="<?php echo ew_HtmlEncode($tb_pat->LAST_UPDATE_DATE->getPlaceHolder()) ?>" value="<?php echo $tb_pat->LAST_UPDATE_DATE->EditValue ?>"<?php echo $tb_pat->LAST_UPDATE_DATE->EditAttributes() ?>>
</span>
<?php echo $tb_pat->LAST_UPDATE_DATE->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$tb_pat_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $tb_pat_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_pat_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ftb_patedit.Init();
</script>
<?php
$tb_pat_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_pat_edit->Page_Terminate();
?>
