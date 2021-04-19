<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "v_inbox_notifinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$v_inbox_notif_add = NULL; // Initialize page object first

class cv_inbox_notif_add extends cv_inbox_notif {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'v_inbox_notif';

	// Page object name
	var $PageObjName = 'v_inbox_notif_add';

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

		// Table object (v_inbox_notif)
		if (!isset($GLOBALS["v_inbox_notif"]) || get_class($GLOBALS["v_inbox_notif"]) == "cv_inbox_notif") {
			$GLOBALS["v_inbox_notif"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["v_inbox_notif"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'v_inbox_notif', TRUE);

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
		$this->priority->SetVisibility();
		if ($this->IsAddOrEdit())
			$this->priority->Visible = FALSE;
		$this->topic->SetVisibility();
		if ($this->IsAddOrEdit())
			$this->topic->Visible = FALSE;
		$this->isi_notif->SetVisibility();
		if ($this->IsAddOrEdit())
			$this->isi_notif->Visible = FALSE;
		$this->USER_NAME->SetVisibility();
		if ($this->IsAddOrEdit())
			$this->USER_NAME->Visible = FALSE;
		$this->cr_by->SetVisibility();
		if ($this->IsAddOrEdit())
			$this->cr_by->Visible = FALSE;

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
		global $EW_EXPORT, $v_inbox_notif;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($v_inbox_notif);
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
					if ($pageName == "v_inbox_notifview.php")
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
			$this->CopyRecord = FALSE;
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
					$this->Page_Terminate("v_inbox_notiflist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "v_inbox_notiflist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "v_inbox_notifview.php")
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
		$this->priority->CurrentValue = NULL;
		$this->priority->OldValue = $this->priority->CurrentValue;
		$this->topic->CurrentValue = NULL;
		$this->topic->OldValue = $this->topic->CurrentValue;
		$this->isi_notif->CurrentValue = NULL;
		$this->isi_notif->OldValue = $this->isi_notif->CurrentValue;
		$this->tgl_cr->CurrentValue = NULL;
		$this->tgl_cr->OldValue = $this->tgl_cr->CurrentValue;
		$this->USER_NAME->CurrentValue = NULL;
		$this->USER_NAME->OldValue = $this->USER_NAME->CurrentValue;
		$this->cr_by->CurrentValue = NULL;
		$this->cr_by->OldValue = $this->cr_by->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->employee_id->FldIsDetailKey) {
			$this->employee_id->setFormValue($objForm->GetValue("x_employee_id"));
		}
		if (!$this->priority->FldIsDetailKey) {
			$this->priority->setFormValue($objForm->GetValue("x_priority"));
		}
		if (!$this->topic->FldIsDetailKey) {
			$this->topic->setFormValue($objForm->GetValue("x_topic"));
		}
		if (!$this->isi_notif->FldIsDetailKey) {
			$this->isi_notif->setFormValue($objForm->GetValue("x_isi_notif"));
		}
		if (!$this->USER_NAME->FldIsDetailKey) {
			$this->USER_NAME->setFormValue($objForm->GetValue("x_USER_NAME"));
		}
		if (!$this->cr_by->FldIsDetailKey) {
			$this->cr_by->setFormValue($objForm->GetValue("x_cr_by"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->employee_id->CurrentValue = $this->employee_id->FormValue;
		$this->priority->CurrentValue = $this->priority->FormValue;
		$this->topic->CurrentValue = $this->topic->FormValue;
		$this->isi_notif->CurrentValue = $this->isi_notif->FormValue;
		$this->USER_NAME->CurrentValue = $this->USER_NAME->FormValue;
		$this->cr_by->CurrentValue = $this->cr_by->FormValue;
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
		$this->priority->setDbValue($row['priority']);
		$this->topic->setDbValue($row['topic']);
		$this->isi_notif->setDbValue($row['isi_notif']);
		$this->tgl_cr->setDbValue($row['tgl_cr']);
		$this->USER_NAME->setDbValue($row['USER_NAME']);
		$this->cr_by->setDbValue($row['cr_by']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['employee_id'] = $this->employee_id->CurrentValue;
		$row['priority'] = $this->priority->CurrentValue;
		$row['topic'] = $this->topic->CurrentValue;
		$row['isi_notif'] = $this->isi_notif->CurrentValue;
		$row['tgl_cr'] = $this->tgl_cr->CurrentValue;
		$row['USER_NAME'] = $this->USER_NAME->CurrentValue;
		$row['cr_by'] = $this->cr_by->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->employee_id->DbValue = $row['employee_id'];
		$this->priority->DbValue = $row['priority'];
		$this->topic->DbValue = $row['topic'];
		$this->isi_notif->DbValue = $row['isi_notif'];
		$this->tgl_cr->DbValue = $row['tgl_cr'];
		$this->USER_NAME->DbValue = $row['USER_NAME'];
		$this->cr_by->DbValue = $row['cr_by'];
	}

	// Load old record
	function LoadOldRecord() {
		return FALSE;
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
		// priority
		// topic
		// isi_notif
		// tgl_cr
		// USER_NAME
		// cr_by

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

		// priority
		if (strval($this->priority->CurrentValue) <> "") {
			$this->priority->ViewValue = $this->priority->OptionCaption($this->priority->CurrentValue);
		} else {
			$this->priority->ViewValue = NULL;
		}
		$this->priority->ViewCustomAttributes = "";

		// topic
		if (strval($this->topic->CurrentValue) <> "") {
			$sFilterWrk = "`nama_referensi`" . ew_SearchString("=", $this->topic->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama_referensi`, `nama_referensi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM referensi";
		$sWhereWrk = "(id_ref=12)";
		$this->topic->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->topic, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->topic->ViewValue = $this->topic->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->topic->ViewValue = $this->topic->CurrentValue;
			}
		} else {
			$this->topic->ViewValue = NULL;
		}
		$this->topic->ViewCustomAttributes = "";

		// isi_notif
		$this->isi_notif->ViewValue = $this->isi_notif->CurrentValue;
		$this->isi_notif->ViewCustomAttributes = "";

		// tgl_cr
		$this->tgl_cr->ViewValue = $this->tgl_cr->CurrentValue;
		$this->tgl_cr->ViewValue = ew_FormatDateTime($this->tgl_cr->ViewValue, 2);
		$this->tgl_cr->ViewCustomAttributes = "";

		// USER_NAME
		$this->USER_NAME->ViewValue = $this->USER_NAME->CurrentValue;
		$this->USER_NAME->ViewCustomAttributes = "";

		// cr_by
		$this->cr_by->ViewValue = $this->cr_by->CurrentValue;
		$this->cr_by->ViewCustomAttributes = "";

			// employee_id
			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";
			$this->employee_id->TooltipValue = "";

			// priority
			$this->priority->LinkCustomAttributes = "";
			$this->priority->HrefValue = "";
			$this->priority->TooltipValue = "";

			// topic
			$this->topic->LinkCustomAttributes = "";
			$this->topic->HrefValue = "";
			$this->topic->TooltipValue = "";

			// isi_notif
			$this->isi_notif->LinkCustomAttributes = "";
			$this->isi_notif->HrefValue = "";
			$this->isi_notif->TooltipValue = "";

			// USER_NAME
			$this->USER_NAME->LinkCustomAttributes = "";
			$this->USER_NAME->HrefValue = "";
			$this->USER_NAME->TooltipValue = "";

			// cr_by
			$this->cr_by->LinkCustomAttributes = "";
			$this->cr_by->HrefValue = "";
			$this->cr_by->TooltipValue = "";
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

			// priority
			$this->priority->EditAttrs["class"] = "form-control";
			$this->priority->EditCustomAttributes = "";
			$this->priority->EditValue = $this->priority->Options(TRUE);

			// topic
			$this->topic->EditAttrs["class"] = "form-control";
			$this->topic->EditCustomAttributes = "";
			if (trim(strval($this->topic->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`nama_referensi`" . ew_SearchString("=", $this->topic->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `nama_referensi`, `nama_referensi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM referensi";
			$sWhereWrk = "(id_ref=12)";
			$this->topic->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->topic, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->topic->EditValue = $arwrk;

			// isi_notif
			$this->isi_notif->EditAttrs["class"] = "form-control";
			$this->isi_notif->EditCustomAttributes = "";
			$this->isi_notif->EditValue = ew_HtmlEncode($this->isi_notif->CurrentValue);
			$this->isi_notif->PlaceHolder = ew_RemoveHtml($this->isi_notif->FldCaption());

			// USER_NAME
			$this->USER_NAME->EditAttrs["class"] = "form-control";
			$this->USER_NAME->EditCustomAttributes = "";
			$this->USER_NAME->EditValue = ew_HtmlEncode($this->USER_NAME->CurrentValue);
			$this->USER_NAME->PlaceHolder = ew_RemoveHtml($this->USER_NAME->FldCaption());

			// cr_by
			$this->cr_by->EditAttrs["class"] = "form-control";
			$this->cr_by->EditCustomAttributes = "";
			$this->cr_by->EditValue = ew_HtmlEncode($this->cr_by->CurrentValue);
			$this->cr_by->PlaceHolder = ew_RemoveHtml($this->cr_by->FldCaption());

			// Add refer script
			// employee_id

			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";

			// priority
			$this->priority->LinkCustomAttributes = "";
			$this->priority->HrefValue = "";

			// topic
			$this->topic->LinkCustomAttributes = "";
			$this->topic->HrefValue = "";

			// isi_notif
			$this->isi_notif->LinkCustomAttributes = "";
			$this->isi_notif->HrefValue = "";

			// USER_NAME
			$this->USER_NAME->LinkCustomAttributes = "";
			$this->USER_NAME->HrefValue = "";

			// cr_by
			$this->cr_by->LinkCustomAttributes = "";
			$this->cr_by->HrefValue = "";
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
		if (!$this->USER_NAME->FldIsDetailKey && !is_null($this->USER_NAME->FormValue) && $this->USER_NAME->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->USER_NAME->FldCaption(), $this->USER_NAME->ReqErrMsg));
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
		if ($this->employee_id->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(employee_id = '" . ew_AdjustSql($this->employee_id->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->employee_id->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->employee_id->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// employee_id
		$this->employee_id->SetDbValueDef($rsnew, $this->employee_id->CurrentValue, "", FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("v_inbox_notiflist.php"), "", $this->TableVar, TRUE);
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
		case "x_topic":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `nama_referensi` AS `LinkFld`, `nama_referensi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM referensi";
			$sWhereWrk = "(id_ref=12)";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`nama_referensi` IN ({filter_value})', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->topic, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($v_inbox_notif_add)) $v_inbox_notif_add = new cv_inbox_notif_add();

// Page init
$v_inbox_notif_add->Page_Init();

// Page main
$v_inbox_notif_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_inbox_notif_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fv_inbox_notifadd = new ew_Form("fv_inbox_notifadd", "add");

// Validate form
fv_inbox_notifadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $v_inbox_notif->employee_id->FldCaption(), $v_inbox_notif->employee_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_USER_NAME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $v_inbox_notif->USER_NAME->FldCaption(), $v_inbox_notif->USER_NAME->ReqErrMsg)) ?>");

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
fv_inbox_notifadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_inbox_notifadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fv_inbox_notifadd.Lists["x_employee_id"] = {"LinkField":"x_employee_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","x_lok_kerja","x_bagian",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_personal"};
fv_inbox_notifadd.Lists["x_employee_id"].Data = "<?php echo $v_inbox_notif_add->employee_id->LookupFilterQuery(FALSE, "add") ?>";
fv_inbox_notifadd.AutoSuggests["x_employee_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $v_inbox_notif_add->employee_id->LookupFilterQuery(TRUE, "add"))) ?>;
fv_inbox_notifadd.Lists["x_priority"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fv_inbox_notifadd.Lists["x_priority"].Options = <?php echo json_encode($v_inbox_notif_add->priority->Options()) ?>;
fv_inbox_notifadd.Lists["x_topic"] = {"LinkField":"x_nama_referensi","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_referensi","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_referensi"};
fv_inbox_notifadd.Lists["x_topic"].Data = "<?php echo $v_inbox_notif_add->topic->LookupFilterQuery(FALSE, "add") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $v_inbox_notif_add->ShowPageHeader(); ?>
<?php
$v_inbox_notif_add->ShowMessage();
?>
<form name="fv_inbox_notifadd" id="fv_inbox_notifadd" class="<?php echo $v_inbox_notif_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($v_inbox_notif_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $v_inbox_notif_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="v_inbox_notif">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($v_inbox_notif_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($v_inbox_notif->employee_id->Visible) { // employee_id ?>
	<div id="r_employee_id" class="form-group">
		<label id="elh_v_inbox_notif_employee_id" class="<?php echo $v_inbox_notif_add->LeftColumnClass ?>"><?php echo $v_inbox_notif->employee_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $v_inbox_notif_add->RightColumnClass ?>"><div<?php echo $v_inbox_notif->employee_id->CellAttributes() ?>>
<span id="el_v_inbox_notif_employee_id">
<?php
$wrkonchange = trim(" " . @$v_inbox_notif->employee_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$v_inbox_notif->employee_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_employee_id" style="white-space: nowrap; z-index: 8980">
	<input type="text" name="sv_x_employee_id" id="sv_x_employee_id" value="<?php echo $v_inbox_notif->employee_id->EditValue ?>" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($v_inbox_notif->employee_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($v_inbox_notif->employee_id->getPlaceHolder()) ?>"<?php echo $v_inbox_notif->employee_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_inbox_notif" data-field="x_employee_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $v_inbox_notif->employee_id->DisplayValueSeparatorAttribute() ?>" name="x_employee_id" id="x_employee_id" value="<?php echo ew_HtmlEncode($v_inbox_notif->employee_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
fv_inbox_notifadd.CreateAutoSuggest({"id":"x_employee_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($v_inbox_notif->employee_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_employee_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($v_inbox_notif->employee_id->ReadOnly || $v_inbox_notif->employee_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php echo $v_inbox_notif->employee_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($v_inbox_notif->priority->Visible) { // priority ?>
	<div id="r_priority" class="form-group">
		<label id="elh_v_inbox_notif_priority" for="x_priority" class="<?php echo $v_inbox_notif_add->LeftColumnClass ?>"><?php echo $v_inbox_notif->priority->FldCaption() ?></label>
		<div class="<?php echo $v_inbox_notif_add->RightColumnClass ?>"><div<?php echo $v_inbox_notif->priority->CellAttributes() ?>>
<span id="el_v_inbox_notif_priority">
<select data-table="v_inbox_notif" data-field="x_priority" data-value-separator="<?php echo $v_inbox_notif->priority->DisplayValueSeparatorAttribute() ?>" id="x_priority" name="x_priority"<?php echo $v_inbox_notif->priority->EditAttributes() ?>>
<?php echo $v_inbox_notif->priority->SelectOptionListHtml("x_priority") ?>
</select>
</span>
<?php echo $v_inbox_notif->priority->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($v_inbox_notif->topic->Visible) { // topic ?>
	<div id="r_topic" class="form-group">
		<label id="elh_v_inbox_notif_topic" for="x_topic" class="<?php echo $v_inbox_notif_add->LeftColumnClass ?>"><?php echo $v_inbox_notif->topic->FldCaption() ?></label>
		<div class="<?php echo $v_inbox_notif_add->RightColumnClass ?>"><div<?php echo $v_inbox_notif->topic->CellAttributes() ?>>
<span id="el_v_inbox_notif_topic">
<select data-table="v_inbox_notif" data-field="x_topic" data-value-separator="<?php echo $v_inbox_notif->topic->DisplayValueSeparatorAttribute() ?>" id="x_topic" name="x_topic"<?php echo $v_inbox_notif->topic->EditAttributes() ?>>
<?php echo $v_inbox_notif->topic->SelectOptionListHtml("x_topic") ?>
</select>
</span>
<?php echo $v_inbox_notif->topic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($v_inbox_notif->isi_notif->Visible) { // isi_notif ?>
	<div id="r_isi_notif" class="form-group">
		<label id="elh_v_inbox_notif_isi_notif" for="x_isi_notif" class="<?php echo $v_inbox_notif_add->LeftColumnClass ?>"><?php echo $v_inbox_notif->isi_notif->FldCaption() ?></label>
		<div class="<?php echo $v_inbox_notif_add->RightColumnClass ?>"><div<?php echo $v_inbox_notif->isi_notif->CellAttributes() ?>>
<span id="el_v_inbox_notif_isi_notif">
<textarea data-table="v_inbox_notif" data-field="x_isi_notif" name="x_isi_notif" id="x_isi_notif" cols="100" rows="4" placeholder="<?php echo ew_HtmlEncode($v_inbox_notif->isi_notif->getPlaceHolder()) ?>"<?php echo $v_inbox_notif->isi_notif->EditAttributes() ?>><?php echo $v_inbox_notif->isi_notif->EditValue ?></textarea>
</span>
<?php echo $v_inbox_notif->isi_notif->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($v_inbox_notif->USER_NAME->Visible) { // USER_NAME ?>
	<div id="r_USER_NAME" class="form-group">
		<label id="elh_v_inbox_notif_USER_NAME" for="x_USER_NAME" class="<?php echo $v_inbox_notif_add->LeftColumnClass ?>"><?php echo $v_inbox_notif->USER_NAME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $v_inbox_notif_add->RightColumnClass ?>"><div<?php echo $v_inbox_notif->USER_NAME->CellAttributes() ?>>
<span id="el_v_inbox_notif_USER_NAME">
<input type="text" data-table="v_inbox_notif" data-field="x_USER_NAME" name="x_USER_NAME" id="x_USER_NAME" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_inbox_notif->USER_NAME->getPlaceHolder()) ?>" value="<?php echo $v_inbox_notif->USER_NAME->EditValue ?>"<?php echo $v_inbox_notif->USER_NAME->EditAttributes() ?>>
</span>
<?php echo $v_inbox_notif->USER_NAME->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($v_inbox_notif->cr_by->Visible) { // cr_by ?>
	<div id="r_cr_by" class="form-group">
		<label id="elh_v_inbox_notif_cr_by" for="x_cr_by" class="<?php echo $v_inbox_notif_add->LeftColumnClass ?>"><?php echo $v_inbox_notif->cr_by->FldCaption() ?></label>
		<div class="<?php echo $v_inbox_notif_add->RightColumnClass ?>"><div<?php echo $v_inbox_notif->cr_by->CellAttributes() ?>>
<span id="el_v_inbox_notif_cr_by">
<input type="text" data-table="v_inbox_notif" data-field="x_cr_by" name="x_cr_by" id="x_cr_by" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($v_inbox_notif->cr_by->getPlaceHolder()) ?>" value="<?php echo $v_inbox_notif->cr_by->EditValue ?>"<?php echo $v_inbox_notif->cr_by->EditAttributes() ?>>
</span>
<?php echo $v_inbox_notif->cr_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$v_inbox_notif_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $v_inbox_notif_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $v_inbox_notif_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fv_inbox_notifadd.Init();
</script>
<?php
$v_inbox_notif_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$v_inbox_notif_add->Page_Terminate();
?>
