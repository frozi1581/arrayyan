<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "referensiinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$referensi_add = NULL; // Initialize page object first

class creferensi_add extends creferensi {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'referensi';

	// Page object name
	var $PageObjName = 'referensi_add';

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

		// Table object (referensi)
		if (!isset($GLOBALS["referensi"]) || get_class($GLOBALS["referensi"]) == "creferensi") {
			$GLOBALS["referensi"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["referensi"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'referensi', TRUE);

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
		$this->id_ref->SetVisibility();
		$this->jenis_ref->SetVisibility();
		$this->index_ref->SetVisibility();
		$this->nama_referensi->SetVisibility();
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
		global $EW_EXPORT, $referensi;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($referensi);
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
					if ($pageName == "referensiview.php")
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
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
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
					$this->Page_Terminate("referensilist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "referensilist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "referensiview.php")
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
		$this->id_ref->CurrentValue = NULL;
		$this->id_ref->OldValue = $this->id_ref->CurrentValue;
		$this->jenis_ref->CurrentValue = NULL;
		$this->jenis_ref->OldValue = $this->jenis_ref->CurrentValue;
		$this->index_ref->CurrentValue = NULL;
		$this->index_ref->OldValue = $this->index_ref->CurrentValue;
		$this->nama_referensi->CurrentValue = NULL;
		$this->nama_referensi->OldValue = $this->nama_referensi->CurrentValue;
		$this->change_date->CurrentValue = NULL;
		$this->change_date->OldValue = $this->change_date->CurrentValue;
		$this->change_by->CurrentValue = NULL;
		$this->change_by->OldValue = $this->change_by->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id_ref->FldIsDetailKey) {
			$this->id_ref->setFormValue($objForm->GetValue("x_id_ref"));
		}
		if (!$this->jenis_ref->FldIsDetailKey) {
			$this->jenis_ref->setFormValue($objForm->GetValue("x_jenis_ref"));
		}
		if (!$this->index_ref->FldIsDetailKey) {
			$this->index_ref->setFormValue($objForm->GetValue("x_index_ref"));
		}
		if (!$this->nama_referensi->FldIsDetailKey) {
			$this->nama_referensi->setFormValue($objForm->GetValue("x_nama_referensi"));
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
		$this->id_ref->CurrentValue = $this->id_ref->FormValue;
		$this->jenis_ref->CurrentValue = $this->jenis_ref->FormValue;
		$this->index_ref->CurrentValue = $this->index_ref->FormValue;
		$this->nama_referensi->CurrentValue = $this->nama_referensi->FormValue;
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
		$this->id_ref->setDbValue($row['id_ref']);
		$this->jenis_ref->setDbValue($row['jenis_ref']);
		$this->index_ref->setDbValue($row['index_ref']);
		$this->nama_referensi->setDbValue($row['nama_referensi']);
		$this->change_date->setDbValue($row['change_date']);
		$this->change_by->setDbValue($row['change_by']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['id_ref'] = $this->id_ref->CurrentValue;
		$row['jenis_ref'] = $this->jenis_ref->CurrentValue;
		$row['index_ref'] = $this->index_ref->CurrentValue;
		$row['nama_referensi'] = $this->nama_referensi->CurrentValue;
		$row['change_date'] = $this->change_date->CurrentValue;
		$row['change_by'] = $this->change_by->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_ref->DbValue = $row['id_ref'];
		$this->jenis_ref->DbValue = $row['jenis_ref'];
		$this->index_ref->DbValue = $row['index_ref'];
		$this->nama_referensi->DbValue = $row['nama_referensi'];
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
		// id_ref
		// jenis_ref
		// index_ref
		// nama_referensi
		// change_date
		// change_by

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_ref
		$this->id_ref->ViewValue = $this->id_ref->CurrentValue;
		$this->id_ref->ViewCustomAttributes = "";

		// jenis_ref
		$this->jenis_ref->ViewValue = $this->jenis_ref->CurrentValue;
		$this->jenis_ref->ViewCustomAttributes = "";

		// index_ref
		$this->index_ref->ViewValue = $this->index_ref->CurrentValue;
		$this->index_ref->ViewCustomAttributes = "";

		// nama_referensi
		$this->nama_referensi->ViewValue = $this->nama_referensi->CurrentValue;
		$this->nama_referensi->ViewCustomAttributes = "";

		// change_date
		$this->change_date->ViewValue = $this->change_date->CurrentValue;
		$this->change_date->ViewValue = ew_FormatDateTime($this->change_date->ViewValue, 0);
		$this->change_date->ViewCustomAttributes = "";

		// change_by
		$this->change_by->ViewValue = $this->change_by->CurrentValue;
		$this->change_by->ViewCustomAttributes = "";

			// id_ref
			$this->id_ref->LinkCustomAttributes = "";
			$this->id_ref->HrefValue = "";
			$this->id_ref->TooltipValue = "";

			// jenis_ref
			$this->jenis_ref->LinkCustomAttributes = "";
			$this->jenis_ref->HrefValue = "";
			$this->jenis_ref->TooltipValue = "";

			// index_ref
			$this->index_ref->LinkCustomAttributes = "";
			$this->index_ref->HrefValue = "";
			$this->index_ref->TooltipValue = "";

			// nama_referensi
			$this->nama_referensi->LinkCustomAttributes = "";
			$this->nama_referensi->HrefValue = "";
			$this->nama_referensi->TooltipValue = "";

			// change_date
			$this->change_date->LinkCustomAttributes = "";
			$this->change_date->HrefValue = "";
			$this->change_date->TooltipValue = "";

			// change_by
			$this->change_by->LinkCustomAttributes = "";
			$this->change_by->HrefValue = "";
			$this->change_by->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// id_ref
			$this->id_ref->EditAttrs["class"] = "form-control";
			$this->id_ref->EditCustomAttributes = "";
			$this->id_ref->EditValue = ew_HtmlEncode($this->id_ref->CurrentValue);
			$this->id_ref->PlaceHolder = ew_RemoveHtml($this->id_ref->FldCaption());

			// jenis_ref
			$this->jenis_ref->EditAttrs["class"] = "form-control";
			$this->jenis_ref->EditCustomAttributes = "";
			$this->jenis_ref->EditValue = ew_HtmlEncode($this->jenis_ref->CurrentValue);
			$this->jenis_ref->PlaceHolder = ew_RemoveHtml($this->jenis_ref->FldCaption());

			// index_ref
			$this->index_ref->EditAttrs["class"] = "form-control";
			$this->index_ref->EditCustomAttributes = "";
			$this->index_ref->EditValue = ew_HtmlEncode($this->index_ref->CurrentValue);
			$this->index_ref->PlaceHolder = ew_RemoveHtml($this->index_ref->FldCaption());

			// nama_referensi
			$this->nama_referensi->EditAttrs["class"] = "form-control";
			$this->nama_referensi->EditCustomAttributes = "";
			$this->nama_referensi->EditValue = ew_HtmlEncode($this->nama_referensi->CurrentValue);
			$this->nama_referensi->PlaceHolder = ew_RemoveHtml($this->nama_referensi->FldCaption());

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

			// Add refer script
			// id_ref

			$this->id_ref->LinkCustomAttributes = "";
			$this->id_ref->HrefValue = "";

			// jenis_ref
			$this->jenis_ref->LinkCustomAttributes = "";
			$this->jenis_ref->HrefValue = "";

			// index_ref
			$this->index_ref->LinkCustomAttributes = "";
			$this->index_ref->HrefValue = "";

			// nama_referensi
			$this->nama_referensi->LinkCustomAttributes = "";
			$this->nama_referensi->HrefValue = "";

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
		if (!ew_CheckInteger($this->id_ref->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_ref->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// id_ref
		$this->id_ref->SetDbValueDef($rsnew, $this->id_ref->CurrentValue, NULL, FALSE);

		// jenis_ref
		$this->jenis_ref->SetDbValueDef($rsnew, $this->jenis_ref->CurrentValue, NULL, FALSE);

		// index_ref
		$this->index_ref->SetDbValueDef($rsnew, $this->index_ref->CurrentValue, NULL, FALSE);

		// nama_referensi
		$this->nama_referensi->SetDbValueDef($rsnew, $this->nama_referensi->CurrentValue, NULL, FALSE);

		// change_date
		$this->change_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->change_date->CurrentValue, 0), NULL, FALSE);

		// change_by
		$this->change_by->SetDbValueDef($rsnew, $this->change_by->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("referensilist.php"), "", $this->TableVar, TRUE);
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
if (!isset($referensi_add)) $referensi_add = new creferensi_add();

// Page init
$referensi_add->Page_Init();

// Page main
$referensi_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$referensi_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = freferensiadd = new ew_Form("freferensiadd", "add");

// Validate form
freferensiadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_id_ref");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referensi->id_ref->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_change_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($referensi->change_date->FldErrMsg()) ?>");

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
freferensiadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
freferensiadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $referensi_add->ShowPageHeader(); ?>
<?php
$referensi_add->ShowMessage();
?>
<form name="freferensiadd" id="freferensiadd" class="<?php echo $referensi_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($referensi_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $referensi_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="referensi">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($referensi_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($referensi->id_ref->Visible) { // id_ref ?>
	<div id="r_id_ref" class="form-group">
		<label id="elh_referensi_id_ref" for="x_id_ref" class="<?php echo $referensi_add->LeftColumnClass ?>"><?php echo $referensi->id_ref->FldCaption() ?></label>
		<div class="<?php echo $referensi_add->RightColumnClass ?>"><div<?php echo $referensi->id_ref->CellAttributes() ?>>
<span id="el_referensi_id_ref">
<input type="text" data-table="referensi" data-field="x_id_ref" name="x_id_ref" id="x_id_ref" size="30" placeholder="<?php echo ew_HtmlEncode($referensi->id_ref->getPlaceHolder()) ?>" value="<?php echo $referensi->id_ref->EditValue ?>"<?php echo $referensi->id_ref->EditAttributes() ?>>
</span>
<?php echo $referensi->id_ref->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referensi->jenis_ref->Visible) { // jenis_ref ?>
	<div id="r_jenis_ref" class="form-group">
		<label id="elh_referensi_jenis_ref" for="x_jenis_ref" class="<?php echo $referensi_add->LeftColumnClass ?>"><?php echo $referensi->jenis_ref->FldCaption() ?></label>
		<div class="<?php echo $referensi_add->RightColumnClass ?>"><div<?php echo $referensi->jenis_ref->CellAttributes() ?>>
<span id="el_referensi_jenis_ref">
<input type="text" data-table="referensi" data-field="x_jenis_ref" name="x_jenis_ref" id="x_jenis_ref" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($referensi->jenis_ref->getPlaceHolder()) ?>" value="<?php echo $referensi->jenis_ref->EditValue ?>"<?php echo $referensi->jenis_ref->EditAttributes() ?>>
</span>
<?php echo $referensi->jenis_ref->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referensi->index_ref->Visible) { // index_ref ?>
	<div id="r_index_ref" class="form-group">
		<label id="elh_referensi_index_ref" for="x_index_ref" class="<?php echo $referensi_add->LeftColumnClass ?>"><?php echo $referensi->index_ref->FldCaption() ?></label>
		<div class="<?php echo $referensi_add->RightColumnClass ?>"><div<?php echo $referensi->index_ref->CellAttributes() ?>>
<span id="el_referensi_index_ref">
<input type="text" data-table="referensi" data-field="x_index_ref" name="x_index_ref" id="x_index_ref" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($referensi->index_ref->getPlaceHolder()) ?>" value="<?php echo $referensi->index_ref->EditValue ?>"<?php echo $referensi->index_ref->EditAttributes() ?>>
</span>
<?php echo $referensi->index_ref->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referensi->nama_referensi->Visible) { // nama_referensi ?>
	<div id="r_nama_referensi" class="form-group">
		<label id="elh_referensi_nama_referensi" for="x_nama_referensi" class="<?php echo $referensi_add->LeftColumnClass ?>"><?php echo $referensi->nama_referensi->FldCaption() ?></label>
		<div class="<?php echo $referensi_add->RightColumnClass ?>"><div<?php echo $referensi->nama_referensi->CellAttributes() ?>>
<span id="el_referensi_nama_referensi">
<input type="text" data-table="referensi" data-field="x_nama_referensi" name="x_nama_referensi" id="x_nama_referensi" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($referensi->nama_referensi->getPlaceHolder()) ?>" value="<?php echo $referensi->nama_referensi->EditValue ?>"<?php echo $referensi->nama_referensi->EditAttributes() ?>>
</span>
<?php echo $referensi->nama_referensi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referensi->change_date->Visible) { // change_date ?>
	<div id="r_change_date" class="form-group">
		<label id="elh_referensi_change_date" for="x_change_date" class="<?php echo $referensi_add->LeftColumnClass ?>"><?php echo $referensi->change_date->FldCaption() ?></label>
		<div class="<?php echo $referensi_add->RightColumnClass ?>"><div<?php echo $referensi->change_date->CellAttributes() ?>>
<span id="el_referensi_change_date">
<input type="text" data-table="referensi" data-field="x_change_date" name="x_change_date" id="x_change_date" placeholder="<?php echo ew_HtmlEncode($referensi->change_date->getPlaceHolder()) ?>" value="<?php echo $referensi->change_date->EditValue ?>"<?php echo $referensi->change_date->EditAttributes() ?>>
</span>
<?php echo $referensi->change_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($referensi->change_by->Visible) { // change_by ?>
	<div id="r_change_by" class="form-group">
		<label id="elh_referensi_change_by" for="x_change_by" class="<?php echo $referensi_add->LeftColumnClass ?>"><?php echo $referensi->change_by->FldCaption() ?></label>
		<div class="<?php echo $referensi_add->RightColumnClass ?>"><div<?php echo $referensi->change_by->CellAttributes() ?>>
<span id="el_referensi_change_by">
<input type="text" data-table="referensi" data-field="x_change_by" name="x_change_by" id="x_change_by" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($referensi->change_by->getPlaceHolder()) ?>" value="<?php echo $referensi->change_by->EditValue ?>"<?php echo $referensi->change_by->EditAttributes() ?>>
</span>
<?php echo $referensi->change_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$referensi_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $referensi_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $referensi_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
freferensiadd.Init();
</script>
<?php
$referensi_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$referensi_add->Page_Terminate();
?>
