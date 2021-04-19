<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "pendidikaninfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$pendidikan_add = NULL; // Initialize page object first

class cpendidikan_add extends cpendidikan {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'pendidikan';

	// Page object name
	var $PageObjName = 'pendidikan_add';

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

		// Table object (pendidikan)
		if (!isset($GLOBALS["pendidikan"]) || get_class($GLOBALS["pendidikan"]) == "cpendidikan") {
			$GLOBALS["pendidikan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pendidikan"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pendidikan', TRUE);

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
		$this->kd_jenjang->SetVisibility();
		$this->kd_jurusan->SetVisibility();
		$this->kd_lmbg->SetVisibility();
		$this->ipk->SetVisibility();
		$this->ket->SetVisibility();
		$this->th_mulai->SetVisibility();
		$this->th_akhir->SetVisibility();
		$this->no_ijazah->SetVisibility();
		$this->tanggal_ijazah->SetVisibility();
		$this->upload_ijazah->SetVisibility();
		$this->lokasi_pendidikan->SetVisibility();
		$this->app->SetVisibility();
		$this->app_empid->SetVisibility();
		$this->app_jbt->SetVisibility();
		$this->app_date->SetVisibility();
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();

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
		global $EW_EXPORT, $pendidikan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pendidikan);
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
					if ($pageName == "pendidikanview.php")
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
			if (@$_GET["employee_id"] != "") {
				$this->employee_id->setQueryStringValue($_GET["employee_id"]);
				$this->setKey("employee_id", $this->employee_id->CurrentValue); // Set up key
			} else {
				$this->setKey("employee_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["kd_jenjang"] != "") {
				$this->kd_jenjang->setQueryStringValue($_GET["kd_jenjang"]);
				$this->setKey("kd_jenjang", $this->kd_jenjang->CurrentValue); // Set up key
			} else {
				$this->setKey("kd_jenjang", ""); // Clear key
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
					$this->Page_Terminate("pendidikanlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "pendidikanlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "pendidikanview.php")
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
		$this->kd_jenjang->CurrentValue = NULL;
		$this->kd_jenjang->OldValue = $this->kd_jenjang->CurrentValue;
		$this->kd_jurusan->CurrentValue = NULL;
		$this->kd_jurusan->OldValue = $this->kd_jurusan->CurrentValue;
		$this->kd_lmbg->CurrentValue = NULL;
		$this->kd_lmbg->OldValue = $this->kd_lmbg->CurrentValue;
		$this->ipk->CurrentValue = NULL;
		$this->ipk->OldValue = $this->ipk->CurrentValue;
		$this->ket->CurrentValue = NULL;
		$this->ket->OldValue = $this->ket->CurrentValue;
		$this->th_mulai->CurrentValue = NULL;
		$this->th_mulai->OldValue = $this->th_mulai->CurrentValue;
		$this->th_akhir->CurrentValue = NULL;
		$this->th_akhir->OldValue = $this->th_akhir->CurrentValue;
		$this->no_ijazah->CurrentValue = NULL;
		$this->no_ijazah->OldValue = $this->no_ijazah->CurrentValue;
		$this->tanggal_ijazah->CurrentValue = NULL;
		$this->tanggal_ijazah->OldValue = $this->tanggal_ijazah->CurrentValue;
		$this->upload_ijazah->CurrentValue = NULL;
		$this->upload_ijazah->OldValue = $this->upload_ijazah->CurrentValue;
		$this->lokasi_pendidikan->CurrentValue = NULL;
		$this->lokasi_pendidikan->OldValue = $this->lokasi_pendidikan->CurrentValue;
		$this->app->CurrentValue = "0";
		$this->app_empid->CurrentValue = NULL;
		$this->app_empid->OldValue = $this->app_empid->CurrentValue;
		$this->app_jbt->CurrentValue = NULL;
		$this->app_jbt->OldValue = $this->app_jbt->CurrentValue;
		$this->app_date->CurrentValue = NULL;
		$this->app_date->OldValue = $this->app_date->CurrentValue;
		$this->created_by->CurrentValue = NULL;
		$this->created_by->OldValue = $this->created_by->CurrentValue;
		$this->created_date->CurrentValue = NULL;
		$this->created_date->OldValue = $this->created_date->CurrentValue;
		$this->last_update_by->CurrentValue = NULL;
		$this->last_update_by->OldValue = $this->last_update_by->CurrentValue;
		$this->last_update_date->CurrentValue = NULL;
		$this->last_update_date->OldValue = $this->last_update_date->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->employee_id->FldIsDetailKey) {
			$this->employee_id->setFormValue($objForm->GetValue("x_employee_id"));
		}
		if (!$this->kd_jenjang->FldIsDetailKey) {
			$this->kd_jenjang->setFormValue($objForm->GetValue("x_kd_jenjang"));
		}
		if (!$this->kd_jurusan->FldIsDetailKey) {
			$this->kd_jurusan->setFormValue($objForm->GetValue("x_kd_jurusan"));
		}
		if (!$this->kd_lmbg->FldIsDetailKey) {
			$this->kd_lmbg->setFormValue($objForm->GetValue("x_kd_lmbg"));
		}
		if (!$this->ipk->FldIsDetailKey) {
			$this->ipk->setFormValue($objForm->GetValue("x_ipk"));
		}
		if (!$this->ket->FldIsDetailKey) {
			$this->ket->setFormValue($objForm->GetValue("x_ket"));
		}
		if (!$this->th_mulai->FldIsDetailKey) {
			$this->th_mulai->setFormValue($objForm->GetValue("x_th_mulai"));
		}
		if (!$this->th_akhir->FldIsDetailKey) {
			$this->th_akhir->setFormValue($objForm->GetValue("x_th_akhir"));
		}
		if (!$this->no_ijazah->FldIsDetailKey) {
			$this->no_ijazah->setFormValue($objForm->GetValue("x_no_ijazah"));
		}
		if (!$this->tanggal_ijazah->FldIsDetailKey) {
			$this->tanggal_ijazah->setFormValue($objForm->GetValue("x_tanggal_ijazah"));
			$this->tanggal_ijazah->CurrentValue = ew_UnFormatDateTime($this->tanggal_ijazah->CurrentValue, 0);
		}
		if (!$this->upload_ijazah->FldIsDetailKey) {
			$this->upload_ijazah->setFormValue($objForm->GetValue("x_upload_ijazah"));
		}
		if (!$this->lokasi_pendidikan->FldIsDetailKey) {
			$this->lokasi_pendidikan->setFormValue($objForm->GetValue("x_lokasi_pendidikan"));
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->employee_id->CurrentValue = $this->employee_id->FormValue;
		$this->kd_jenjang->CurrentValue = $this->kd_jenjang->FormValue;
		$this->kd_jurusan->CurrentValue = $this->kd_jurusan->FormValue;
		$this->kd_lmbg->CurrentValue = $this->kd_lmbg->FormValue;
		$this->ipk->CurrentValue = $this->ipk->FormValue;
		$this->ket->CurrentValue = $this->ket->FormValue;
		$this->th_mulai->CurrentValue = $this->th_mulai->FormValue;
		$this->th_akhir->CurrentValue = $this->th_akhir->FormValue;
		$this->no_ijazah->CurrentValue = $this->no_ijazah->FormValue;
		$this->tanggal_ijazah->CurrentValue = $this->tanggal_ijazah->FormValue;
		$this->tanggal_ijazah->CurrentValue = ew_UnFormatDateTime($this->tanggal_ijazah->CurrentValue, 0);
		$this->upload_ijazah->CurrentValue = $this->upload_ijazah->FormValue;
		$this->lokasi_pendidikan->CurrentValue = $this->lokasi_pendidikan->FormValue;
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
		$this->kd_jenjang->setDbValue($row['kd_jenjang']);
		$this->kd_jurusan->setDbValue($row['kd_jurusan']);
		$this->kd_lmbg->setDbValue($row['kd_lmbg']);
		$this->ipk->setDbValue($row['ipk']);
		$this->ket->setDbValue($row['ket']);
		$this->th_mulai->setDbValue($row['th_mulai']);
		$this->th_akhir->setDbValue($row['th_akhir']);
		$this->no_ijazah->setDbValue($row['no_ijazah']);
		$this->tanggal_ijazah->setDbValue($row['tanggal_ijazah']);
		$this->upload_ijazah->setDbValue($row['upload_ijazah']);
		$this->lokasi_pendidikan->setDbValue($row['lokasi_pendidikan']);
		$this->app->setDbValue($row['app']);
		$this->app_empid->setDbValue($row['app_empid']);
		$this->app_jbt->setDbValue($row['app_jbt']);
		$this->app_date->setDbValue($row['app_date']);
		$this->created_by->setDbValue($row['created_by']);
		$this->created_date->setDbValue($row['created_date']);
		$this->last_update_by->setDbValue($row['last_update_by']);
		$this->last_update_date->setDbValue($row['last_update_date']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['employee_id'] = $this->employee_id->CurrentValue;
		$row['kd_jenjang'] = $this->kd_jenjang->CurrentValue;
		$row['kd_jurusan'] = $this->kd_jurusan->CurrentValue;
		$row['kd_lmbg'] = $this->kd_lmbg->CurrentValue;
		$row['ipk'] = $this->ipk->CurrentValue;
		$row['ket'] = $this->ket->CurrentValue;
		$row['th_mulai'] = $this->th_mulai->CurrentValue;
		$row['th_akhir'] = $this->th_akhir->CurrentValue;
		$row['no_ijazah'] = $this->no_ijazah->CurrentValue;
		$row['tanggal_ijazah'] = $this->tanggal_ijazah->CurrentValue;
		$row['upload_ijazah'] = $this->upload_ijazah->CurrentValue;
		$row['lokasi_pendidikan'] = $this->lokasi_pendidikan->CurrentValue;
		$row['app'] = $this->app->CurrentValue;
		$row['app_empid'] = $this->app_empid->CurrentValue;
		$row['app_jbt'] = $this->app_jbt->CurrentValue;
		$row['app_date'] = $this->app_date->CurrentValue;
		$row['created_by'] = $this->created_by->CurrentValue;
		$row['created_date'] = $this->created_date->CurrentValue;
		$row['last_update_by'] = $this->last_update_by->CurrentValue;
		$row['last_update_date'] = $this->last_update_date->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->employee_id->DbValue = $row['employee_id'];
		$this->kd_jenjang->DbValue = $row['kd_jenjang'];
		$this->kd_jurusan->DbValue = $row['kd_jurusan'];
		$this->kd_lmbg->DbValue = $row['kd_lmbg'];
		$this->ipk->DbValue = $row['ipk'];
		$this->ket->DbValue = $row['ket'];
		$this->th_mulai->DbValue = $row['th_mulai'];
		$this->th_akhir->DbValue = $row['th_akhir'];
		$this->no_ijazah->DbValue = $row['no_ijazah'];
		$this->tanggal_ijazah->DbValue = $row['tanggal_ijazah'];
		$this->upload_ijazah->DbValue = $row['upload_ijazah'];
		$this->lokasi_pendidikan->DbValue = $row['lokasi_pendidikan'];
		$this->app->DbValue = $row['app'];
		$this->app_empid->DbValue = $row['app_empid'];
		$this->app_jbt->DbValue = $row['app_jbt'];
		$this->app_date->DbValue = $row['app_date'];
		$this->created_by->DbValue = $row['created_by'];
		$this->created_date->DbValue = $row['created_date'];
		$this->last_update_by->DbValue = $row['last_update_by'];
		$this->last_update_date->DbValue = $row['last_update_date'];
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
		// Convert decimal values if posted back

		if ($this->ipk->FormValue == $this->ipk->CurrentValue && is_numeric(ew_StrToFloat($this->ipk->CurrentValue)))
			$this->ipk->CurrentValue = ew_StrToFloat($this->ipk->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// employee_id
		// kd_jenjang
		// kd_jurusan
		// kd_lmbg
		// ipk
		// ket
		// th_mulai
		// th_akhir
		// no_ijazah
		// tanggal_ijazah
		// upload_ijazah
		// lokasi_pendidikan
		// app
		// app_empid
		// app_jbt
		// app_date
		// created_by
		// created_date
		// last_update_by
		// last_update_date

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// employee_id
		$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
		$this->employee_id->ViewCustomAttributes = "";

		// kd_jenjang
		$this->kd_jenjang->ViewValue = $this->kd_jenjang->CurrentValue;
		$this->kd_jenjang->ViewCustomAttributes = "";

		// kd_jurusan
		$this->kd_jurusan->ViewValue = $this->kd_jurusan->CurrentValue;
		$this->kd_jurusan->ViewCustomAttributes = "";

		// kd_lmbg
		$this->kd_lmbg->ViewValue = $this->kd_lmbg->CurrentValue;
		$this->kd_lmbg->ViewCustomAttributes = "";

		// ipk
		$this->ipk->ViewValue = $this->ipk->CurrentValue;
		$this->ipk->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

		// th_mulai
		$this->th_mulai->ViewValue = $this->th_mulai->CurrentValue;
		$this->th_mulai->ViewCustomAttributes = "";

		// th_akhir
		$this->th_akhir->ViewValue = $this->th_akhir->CurrentValue;
		$this->th_akhir->ViewCustomAttributes = "";

		// no_ijazah
		$this->no_ijazah->ViewValue = $this->no_ijazah->CurrentValue;
		$this->no_ijazah->ViewCustomAttributes = "";

		// tanggal_ijazah
		$this->tanggal_ijazah->ViewValue = $this->tanggal_ijazah->CurrentValue;
		$this->tanggal_ijazah->ViewValue = ew_FormatDateTime($this->tanggal_ijazah->ViewValue, 0);
		$this->tanggal_ijazah->ViewCustomAttributes = "";

		// upload_ijazah
		$this->upload_ijazah->ViewValue = $this->upload_ijazah->CurrentValue;
		$this->upload_ijazah->ViewCustomAttributes = "";

		// lokasi_pendidikan
		$this->lokasi_pendidikan->ViewValue = $this->lokasi_pendidikan->CurrentValue;
		$this->lokasi_pendidikan->ViewCustomAttributes = "";

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

			// employee_id
			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";
			$this->employee_id->TooltipValue = "";

			// kd_jenjang
			$this->kd_jenjang->LinkCustomAttributes = "";
			$this->kd_jenjang->HrefValue = "";
			$this->kd_jenjang->TooltipValue = "";

			// kd_jurusan
			$this->kd_jurusan->LinkCustomAttributes = "";
			$this->kd_jurusan->HrefValue = "";
			$this->kd_jurusan->TooltipValue = "";

			// kd_lmbg
			$this->kd_lmbg->LinkCustomAttributes = "";
			$this->kd_lmbg->HrefValue = "";
			$this->kd_lmbg->TooltipValue = "";

			// ipk
			$this->ipk->LinkCustomAttributes = "";
			$this->ipk->HrefValue = "";
			$this->ipk->TooltipValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";
			$this->ket->TooltipValue = "";

			// th_mulai
			$this->th_mulai->LinkCustomAttributes = "";
			$this->th_mulai->HrefValue = "";
			$this->th_mulai->TooltipValue = "";

			// th_akhir
			$this->th_akhir->LinkCustomAttributes = "";
			$this->th_akhir->HrefValue = "";
			$this->th_akhir->TooltipValue = "";

			// no_ijazah
			$this->no_ijazah->LinkCustomAttributes = "";
			$this->no_ijazah->HrefValue = "";
			$this->no_ijazah->TooltipValue = "";

			// tanggal_ijazah
			$this->tanggal_ijazah->LinkCustomAttributes = "";
			$this->tanggal_ijazah->HrefValue = "";
			$this->tanggal_ijazah->TooltipValue = "";

			// upload_ijazah
			$this->upload_ijazah->LinkCustomAttributes = "";
			$this->upload_ijazah->HrefValue = "";
			$this->upload_ijazah->TooltipValue = "";

			// lokasi_pendidikan
			$this->lokasi_pendidikan->LinkCustomAttributes = "";
			$this->lokasi_pendidikan->HrefValue = "";
			$this->lokasi_pendidikan->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// employee_id
			$this->employee_id->EditAttrs["class"] = "form-control";
			$this->employee_id->EditCustomAttributes = "";
			$this->employee_id->EditValue = ew_HtmlEncode($this->employee_id->CurrentValue);
			$this->employee_id->PlaceHolder = ew_RemoveHtml($this->employee_id->FldCaption());

			// kd_jenjang
			$this->kd_jenjang->EditAttrs["class"] = "form-control";
			$this->kd_jenjang->EditCustomAttributes = "";
			$this->kd_jenjang->EditValue = ew_HtmlEncode($this->kd_jenjang->CurrentValue);
			$this->kd_jenjang->PlaceHolder = ew_RemoveHtml($this->kd_jenjang->FldCaption());

			// kd_jurusan
			$this->kd_jurusan->EditAttrs["class"] = "form-control";
			$this->kd_jurusan->EditCustomAttributes = "";
			$this->kd_jurusan->EditValue = ew_HtmlEncode($this->kd_jurusan->CurrentValue);
			$this->kd_jurusan->PlaceHolder = ew_RemoveHtml($this->kd_jurusan->FldCaption());

			// kd_lmbg
			$this->kd_lmbg->EditAttrs["class"] = "form-control";
			$this->kd_lmbg->EditCustomAttributes = "";
			$this->kd_lmbg->EditValue = ew_HtmlEncode($this->kd_lmbg->CurrentValue);
			$this->kd_lmbg->PlaceHolder = ew_RemoveHtml($this->kd_lmbg->FldCaption());

			// ipk
			$this->ipk->EditAttrs["class"] = "form-control";
			$this->ipk->EditCustomAttributes = "";
			$this->ipk->EditValue = ew_HtmlEncode($this->ipk->CurrentValue);
			$this->ipk->PlaceHolder = ew_RemoveHtml($this->ipk->FldCaption());
			if (strval($this->ipk->EditValue) <> "" && is_numeric($this->ipk->EditValue)) $this->ipk->EditValue = ew_FormatNumber($this->ipk->EditValue, -2, -1, -2, 0);

			// ket
			$this->ket->EditAttrs["class"] = "form-control";
			$this->ket->EditCustomAttributes = "";
			$this->ket->EditValue = ew_HtmlEncode($this->ket->CurrentValue);
			$this->ket->PlaceHolder = ew_RemoveHtml($this->ket->FldCaption());

			// th_mulai
			$this->th_mulai->EditAttrs["class"] = "form-control";
			$this->th_mulai->EditCustomAttributes = "";
			$this->th_mulai->EditValue = ew_HtmlEncode($this->th_mulai->CurrentValue);
			$this->th_mulai->PlaceHolder = ew_RemoveHtml($this->th_mulai->FldCaption());

			// th_akhir
			$this->th_akhir->EditAttrs["class"] = "form-control";
			$this->th_akhir->EditCustomAttributes = "";
			$this->th_akhir->EditValue = ew_HtmlEncode($this->th_akhir->CurrentValue);
			$this->th_akhir->PlaceHolder = ew_RemoveHtml($this->th_akhir->FldCaption());

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

			// upload_ijazah
			$this->upload_ijazah->EditAttrs["class"] = "form-control";
			$this->upload_ijazah->EditCustomAttributes = "";
			$this->upload_ijazah->EditValue = ew_HtmlEncode($this->upload_ijazah->CurrentValue);
			$this->upload_ijazah->PlaceHolder = ew_RemoveHtml($this->upload_ijazah->FldCaption());

			// lokasi_pendidikan
			$this->lokasi_pendidikan->EditAttrs["class"] = "form-control";
			$this->lokasi_pendidikan->EditCustomAttributes = "";
			$this->lokasi_pendidikan->EditValue = ew_HtmlEncode($this->lokasi_pendidikan->CurrentValue);
			$this->lokasi_pendidikan->PlaceHolder = ew_RemoveHtml($this->lokasi_pendidikan->FldCaption());

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

			// Add refer script
			// employee_id

			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";

			// kd_jenjang
			$this->kd_jenjang->LinkCustomAttributes = "";
			$this->kd_jenjang->HrefValue = "";

			// kd_jurusan
			$this->kd_jurusan->LinkCustomAttributes = "";
			$this->kd_jurusan->HrefValue = "";

			// kd_lmbg
			$this->kd_lmbg->LinkCustomAttributes = "";
			$this->kd_lmbg->HrefValue = "";

			// ipk
			$this->ipk->LinkCustomAttributes = "";
			$this->ipk->HrefValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";

			// th_mulai
			$this->th_mulai->LinkCustomAttributes = "";
			$this->th_mulai->HrefValue = "";

			// th_akhir
			$this->th_akhir->LinkCustomAttributes = "";
			$this->th_akhir->HrefValue = "";

			// no_ijazah
			$this->no_ijazah->LinkCustomAttributes = "";
			$this->no_ijazah->HrefValue = "";

			// tanggal_ijazah
			$this->tanggal_ijazah->LinkCustomAttributes = "";
			$this->tanggal_ijazah->HrefValue = "";

			// upload_ijazah
			$this->upload_ijazah->LinkCustomAttributes = "";
			$this->upload_ijazah->HrefValue = "";

			// lokasi_pendidikan
			$this->lokasi_pendidikan->LinkCustomAttributes = "";
			$this->lokasi_pendidikan->HrefValue = "";

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
		if (!$this->kd_jenjang->FldIsDetailKey && !is_null($this->kd_jenjang->FormValue) && $this->kd_jenjang->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kd_jenjang->FldCaption(), $this->kd_jenjang->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->ipk->FormValue)) {
			ew_AddMessage($gsFormError, $this->ipk->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tanggal_ijazah->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal_ijazah->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// employee_id
		$this->employee_id->SetDbValueDef($rsnew, $this->employee_id->CurrentValue, "", FALSE);

		// kd_jenjang
		$this->kd_jenjang->SetDbValueDef($rsnew, $this->kd_jenjang->CurrentValue, "", FALSE);

		// kd_jurusan
		$this->kd_jurusan->SetDbValueDef($rsnew, $this->kd_jurusan->CurrentValue, NULL, FALSE);

		// kd_lmbg
		$this->kd_lmbg->SetDbValueDef($rsnew, $this->kd_lmbg->CurrentValue, NULL, FALSE);

		// ipk
		$this->ipk->SetDbValueDef($rsnew, $this->ipk->CurrentValue, NULL, FALSE);

		// ket
		$this->ket->SetDbValueDef($rsnew, $this->ket->CurrentValue, NULL, FALSE);

		// th_mulai
		$this->th_mulai->SetDbValueDef($rsnew, $this->th_mulai->CurrentValue, NULL, FALSE);

		// th_akhir
		$this->th_akhir->SetDbValueDef($rsnew, $this->th_akhir->CurrentValue, NULL, FALSE);

		// no_ijazah
		$this->no_ijazah->SetDbValueDef($rsnew, $this->no_ijazah->CurrentValue, NULL, FALSE);

		// tanggal_ijazah
		$this->tanggal_ijazah->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal_ijazah->CurrentValue, 0), NULL, FALSE);

		// upload_ijazah
		$this->upload_ijazah->SetDbValueDef($rsnew, $this->upload_ijazah->CurrentValue, NULL, FALSE);

		// lokasi_pendidikan
		$this->lokasi_pendidikan->SetDbValueDef($rsnew, $this->lokasi_pendidikan->CurrentValue, NULL, FALSE);

		// app
		$this->app->SetDbValueDef($rsnew, $this->app->CurrentValue, NULL, strval($this->app->CurrentValue) == "");

		// app_empid
		$this->app_empid->SetDbValueDef($rsnew, $this->app_empid->CurrentValue, NULL, FALSE);

		// app_jbt
		$this->app_jbt->SetDbValueDef($rsnew, $this->app_jbt->CurrentValue, NULL, FALSE);

		// app_date
		$this->app_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->app_date->CurrentValue, 0), NULL, FALSE);

		// created_by
		$this->created_by->SetDbValueDef($rsnew, $this->created_by->CurrentValue, NULL, FALSE);

		// created_date
		$this->created_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->created_date->CurrentValue, 0), NULL, FALSE);

		// last_update_by
		$this->last_update_by->SetDbValueDef($rsnew, $this->last_update_by->CurrentValue, NULL, FALSE);

		// last_update_date
		$this->last_update_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->last_update_date->CurrentValue, 0), NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['employee_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['kd_jenjang']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pendidikanlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($pendidikan_add)) $pendidikan_add = new cpendidikan_add();

// Page init
$pendidikan_add->Page_Init();

// Page main
$pendidikan_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pendidikan_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fpendidikanadd = new ew_Form("fpendidikanadd", "add");

// Validate form
fpendidikanadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendidikan->employee_id->FldCaption(), $pendidikan->employee_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kd_jenjang");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendidikan->kd_jenjang->FldCaption(), $pendidikan->kd_jenjang->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ipk");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pendidikan->ipk->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tanggal_ijazah");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pendidikan->tanggal_ijazah->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_app_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pendidikan->app_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_created_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pendidikan->created_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_update_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pendidikan->last_update_date->FldErrMsg()) ?>");

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
fpendidikanadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fpendidikanadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $pendidikan_add->ShowPageHeader(); ?>
<?php
$pendidikan_add->ShowMessage();
?>
<form name="fpendidikanadd" id="fpendidikanadd" class="<?php echo $pendidikan_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pendidikan_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pendidikan_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pendidikan">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($pendidikan_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($pendidikan->employee_id->Visible) { // employee_id ?>
	<div id="r_employee_id" class="form-group">
		<label id="elh_pendidikan_employee_id" for="x_employee_id" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->employee_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->employee_id->CellAttributes() ?>>
<span id="el_pendidikan_employee_id">
<input type="text" data-table="pendidikan" data-field="x_employee_id" name="x_employee_id" id="x_employee_id" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($pendidikan->employee_id->getPlaceHolder()) ?>" value="<?php echo $pendidikan->employee_id->EditValue ?>"<?php echo $pendidikan->employee_id->EditAttributes() ?>>
</span>
<?php echo $pendidikan->employee_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->kd_jenjang->Visible) { // kd_jenjang ?>
	<div id="r_kd_jenjang" class="form-group">
		<label id="elh_pendidikan_kd_jenjang" for="x_kd_jenjang" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->kd_jenjang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->kd_jenjang->CellAttributes() ?>>
<span id="el_pendidikan_kd_jenjang">
<input type="text" data-table="pendidikan" data-field="x_kd_jenjang" name="x_kd_jenjang" id="x_kd_jenjang" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($pendidikan->kd_jenjang->getPlaceHolder()) ?>" value="<?php echo $pendidikan->kd_jenjang->EditValue ?>"<?php echo $pendidikan->kd_jenjang->EditAttributes() ?>>
</span>
<?php echo $pendidikan->kd_jenjang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->kd_jurusan->Visible) { // kd_jurusan ?>
	<div id="r_kd_jurusan" class="form-group">
		<label id="elh_pendidikan_kd_jurusan" for="x_kd_jurusan" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->kd_jurusan->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->kd_jurusan->CellAttributes() ?>>
<span id="el_pendidikan_kd_jurusan">
<input type="text" data-table="pendidikan" data-field="x_kd_jurusan" name="x_kd_jurusan" id="x_kd_jurusan" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($pendidikan->kd_jurusan->getPlaceHolder()) ?>" value="<?php echo $pendidikan->kd_jurusan->EditValue ?>"<?php echo $pendidikan->kd_jurusan->EditAttributes() ?>>
</span>
<?php echo $pendidikan->kd_jurusan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->kd_lmbg->Visible) { // kd_lmbg ?>
	<div id="r_kd_lmbg" class="form-group">
		<label id="elh_pendidikan_kd_lmbg" for="x_kd_lmbg" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->kd_lmbg->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->kd_lmbg->CellAttributes() ?>>
<span id="el_pendidikan_kd_lmbg">
<input type="text" data-table="pendidikan" data-field="x_kd_lmbg" name="x_kd_lmbg" id="x_kd_lmbg" size="30" maxlength="4" placeholder="<?php echo ew_HtmlEncode($pendidikan->kd_lmbg->getPlaceHolder()) ?>" value="<?php echo $pendidikan->kd_lmbg->EditValue ?>"<?php echo $pendidikan->kd_lmbg->EditAttributes() ?>>
</span>
<?php echo $pendidikan->kd_lmbg->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->ipk->Visible) { // ipk ?>
	<div id="r_ipk" class="form-group">
		<label id="elh_pendidikan_ipk" for="x_ipk" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->ipk->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->ipk->CellAttributes() ?>>
<span id="el_pendidikan_ipk">
<input type="text" data-table="pendidikan" data-field="x_ipk" name="x_ipk" id="x_ipk" size="30" placeholder="<?php echo ew_HtmlEncode($pendidikan->ipk->getPlaceHolder()) ?>" value="<?php echo $pendidikan->ipk->EditValue ?>"<?php echo $pendidikan->ipk->EditAttributes() ?>>
</span>
<?php echo $pendidikan->ipk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->ket->Visible) { // ket ?>
	<div id="r_ket" class="form-group">
		<label id="elh_pendidikan_ket" for="x_ket" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->ket->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->ket->CellAttributes() ?>>
<span id="el_pendidikan_ket">
<input type="text" data-table="pendidikan" data-field="x_ket" name="x_ket" id="x_ket" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendidikan->ket->getPlaceHolder()) ?>" value="<?php echo $pendidikan->ket->EditValue ?>"<?php echo $pendidikan->ket->EditAttributes() ?>>
</span>
<?php echo $pendidikan->ket->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->th_mulai->Visible) { // th_mulai ?>
	<div id="r_th_mulai" class="form-group">
		<label id="elh_pendidikan_th_mulai" for="x_th_mulai" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->th_mulai->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->th_mulai->CellAttributes() ?>>
<span id="el_pendidikan_th_mulai">
<input type="text" data-table="pendidikan" data-field="x_th_mulai" name="x_th_mulai" id="x_th_mulai" size="30" maxlength="4" placeholder="<?php echo ew_HtmlEncode($pendidikan->th_mulai->getPlaceHolder()) ?>" value="<?php echo $pendidikan->th_mulai->EditValue ?>"<?php echo $pendidikan->th_mulai->EditAttributes() ?>>
</span>
<?php echo $pendidikan->th_mulai->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->th_akhir->Visible) { // th_akhir ?>
	<div id="r_th_akhir" class="form-group">
		<label id="elh_pendidikan_th_akhir" for="x_th_akhir" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->th_akhir->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->th_akhir->CellAttributes() ?>>
<span id="el_pendidikan_th_akhir">
<input type="text" data-table="pendidikan" data-field="x_th_akhir" name="x_th_akhir" id="x_th_akhir" size="30" maxlength="4" placeholder="<?php echo ew_HtmlEncode($pendidikan->th_akhir->getPlaceHolder()) ?>" value="<?php echo $pendidikan->th_akhir->EditValue ?>"<?php echo $pendidikan->th_akhir->EditAttributes() ?>>
</span>
<?php echo $pendidikan->th_akhir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->no_ijazah->Visible) { // no_ijazah ?>
	<div id="r_no_ijazah" class="form-group">
		<label id="elh_pendidikan_no_ijazah" for="x_no_ijazah" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->no_ijazah->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->no_ijazah->CellAttributes() ?>>
<span id="el_pendidikan_no_ijazah">
<input type="text" data-table="pendidikan" data-field="x_no_ijazah" name="x_no_ijazah" id="x_no_ijazah" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($pendidikan->no_ijazah->getPlaceHolder()) ?>" value="<?php echo $pendidikan->no_ijazah->EditValue ?>"<?php echo $pendidikan->no_ijazah->EditAttributes() ?>>
</span>
<?php echo $pendidikan->no_ijazah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->tanggal_ijazah->Visible) { // tanggal_ijazah ?>
	<div id="r_tanggal_ijazah" class="form-group">
		<label id="elh_pendidikan_tanggal_ijazah" for="x_tanggal_ijazah" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->tanggal_ijazah->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->tanggal_ijazah->CellAttributes() ?>>
<span id="el_pendidikan_tanggal_ijazah">
<input type="text" data-table="pendidikan" data-field="x_tanggal_ijazah" name="x_tanggal_ijazah" id="x_tanggal_ijazah" placeholder="<?php echo ew_HtmlEncode($pendidikan->tanggal_ijazah->getPlaceHolder()) ?>" value="<?php echo $pendidikan->tanggal_ijazah->EditValue ?>"<?php echo $pendidikan->tanggal_ijazah->EditAttributes() ?>>
</span>
<?php echo $pendidikan->tanggal_ijazah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->upload_ijazah->Visible) { // upload_ijazah ?>
	<div id="r_upload_ijazah" class="form-group">
		<label id="elh_pendidikan_upload_ijazah" for="x_upload_ijazah" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->upload_ijazah->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->upload_ijazah->CellAttributes() ?>>
<span id="el_pendidikan_upload_ijazah">
<input type="text" data-table="pendidikan" data-field="x_upload_ijazah" name="x_upload_ijazah" id="x_upload_ijazah" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($pendidikan->upload_ijazah->getPlaceHolder()) ?>" value="<?php echo $pendidikan->upload_ijazah->EditValue ?>"<?php echo $pendidikan->upload_ijazah->EditAttributes() ?>>
</span>
<?php echo $pendidikan->upload_ijazah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->lokasi_pendidikan->Visible) { // lokasi_pendidikan ?>
	<div id="r_lokasi_pendidikan" class="form-group">
		<label id="elh_pendidikan_lokasi_pendidikan" for="x_lokasi_pendidikan" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->lokasi_pendidikan->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->lokasi_pendidikan->CellAttributes() ?>>
<span id="el_pendidikan_lokasi_pendidikan">
<input type="text" data-table="pendidikan" data-field="x_lokasi_pendidikan" name="x_lokasi_pendidikan" id="x_lokasi_pendidikan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($pendidikan->lokasi_pendidikan->getPlaceHolder()) ?>" value="<?php echo $pendidikan->lokasi_pendidikan->EditValue ?>"<?php echo $pendidikan->lokasi_pendidikan->EditAttributes() ?>>
</span>
<?php echo $pendidikan->lokasi_pendidikan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->app->Visible) { // app ?>
	<div id="r_app" class="form-group">
		<label id="elh_pendidikan_app" for="x_app" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->app->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->app->CellAttributes() ?>>
<span id="el_pendidikan_app">
<input type="text" data-table="pendidikan" data-field="x_app" name="x_app" id="x_app" size="30" maxlength="1" placeholder="<?php echo ew_HtmlEncode($pendidikan->app->getPlaceHolder()) ?>" value="<?php echo $pendidikan->app->EditValue ?>"<?php echo $pendidikan->app->EditAttributes() ?>>
</span>
<?php echo $pendidikan->app->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->app_empid->Visible) { // app_empid ?>
	<div id="r_app_empid" class="form-group">
		<label id="elh_pendidikan_app_empid" for="x_app_empid" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->app_empid->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->app_empid->CellAttributes() ?>>
<span id="el_pendidikan_app_empid">
<input type="text" data-table="pendidikan" data-field="x_app_empid" name="x_app_empid" id="x_app_empid" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($pendidikan->app_empid->getPlaceHolder()) ?>" value="<?php echo $pendidikan->app_empid->EditValue ?>"<?php echo $pendidikan->app_empid->EditAttributes() ?>>
</span>
<?php echo $pendidikan->app_empid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->app_jbt->Visible) { // app_jbt ?>
	<div id="r_app_jbt" class="form-group">
		<label id="elh_pendidikan_app_jbt" for="x_app_jbt" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->app_jbt->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->app_jbt->CellAttributes() ?>>
<span id="el_pendidikan_app_jbt">
<input type="text" data-table="pendidikan" data-field="x_app_jbt" name="x_app_jbt" id="x_app_jbt" size="30" maxlength="7" placeholder="<?php echo ew_HtmlEncode($pendidikan->app_jbt->getPlaceHolder()) ?>" value="<?php echo $pendidikan->app_jbt->EditValue ?>"<?php echo $pendidikan->app_jbt->EditAttributes() ?>>
</span>
<?php echo $pendidikan->app_jbt->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->app_date->Visible) { // app_date ?>
	<div id="r_app_date" class="form-group">
		<label id="elh_pendidikan_app_date" for="x_app_date" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->app_date->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->app_date->CellAttributes() ?>>
<span id="el_pendidikan_app_date">
<input type="text" data-table="pendidikan" data-field="x_app_date" name="x_app_date" id="x_app_date" placeholder="<?php echo ew_HtmlEncode($pendidikan->app_date->getPlaceHolder()) ?>" value="<?php echo $pendidikan->app_date->EditValue ?>"<?php echo $pendidikan->app_date->EditAttributes() ?>>
</span>
<?php echo $pendidikan->app_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->created_by->Visible) { // created_by ?>
	<div id="r_created_by" class="form-group">
		<label id="elh_pendidikan_created_by" for="x_created_by" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->created_by->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->created_by->CellAttributes() ?>>
<span id="el_pendidikan_created_by">
<input type="text" data-table="pendidikan" data-field="x_created_by" name="x_created_by" id="x_created_by" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($pendidikan->created_by->getPlaceHolder()) ?>" value="<?php echo $pendidikan->created_by->EditValue ?>"<?php echo $pendidikan->created_by->EditAttributes() ?>>
</span>
<?php echo $pendidikan->created_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->created_date->Visible) { // created_date ?>
	<div id="r_created_date" class="form-group">
		<label id="elh_pendidikan_created_date" for="x_created_date" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->created_date->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->created_date->CellAttributes() ?>>
<span id="el_pendidikan_created_date">
<input type="text" data-table="pendidikan" data-field="x_created_date" name="x_created_date" id="x_created_date" placeholder="<?php echo ew_HtmlEncode($pendidikan->created_date->getPlaceHolder()) ?>" value="<?php echo $pendidikan->created_date->EditValue ?>"<?php echo $pendidikan->created_date->EditAttributes() ?>>
</span>
<?php echo $pendidikan->created_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->last_update_by->Visible) { // last_update_by ?>
	<div id="r_last_update_by" class="form-group">
		<label id="elh_pendidikan_last_update_by" for="x_last_update_by" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->last_update_by->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->last_update_by->CellAttributes() ?>>
<span id="el_pendidikan_last_update_by">
<input type="text" data-table="pendidikan" data-field="x_last_update_by" name="x_last_update_by" id="x_last_update_by" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($pendidikan->last_update_by->getPlaceHolder()) ?>" value="<?php echo $pendidikan->last_update_by->EditValue ?>"<?php echo $pendidikan->last_update_by->EditAttributes() ?>>
</span>
<?php echo $pendidikan->last_update_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendidikan->last_update_date->Visible) { // last_update_date ?>
	<div id="r_last_update_date" class="form-group">
		<label id="elh_pendidikan_last_update_date" for="x_last_update_date" class="<?php echo $pendidikan_add->LeftColumnClass ?>"><?php echo $pendidikan->last_update_date->FldCaption() ?></label>
		<div class="<?php echo $pendidikan_add->RightColumnClass ?>"><div<?php echo $pendidikan->last_update_date->CellAttributes() ?>>
<span id="el_pendidikan_last_update_date">
<input type="text" data-table="pendidikan" data-field="x_last_update_date" name="x_last_update_date" id="x_last_update_date" placeholder="<?php echo ew_HtmlEncode($pendidikan->last_update_date->getPlaceHolder()) ?>" value="<?php echo $pendidikan->last_update_date->EditValue ?>"<?php echo $pendidikan->last_update_date->EditAttributes() ?>>
</span>
<?php echo $pendidikan->last_update_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$pendidikan_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $pendidikan_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pendidikan_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fpendidikanadd.Init();
</script>
<?php
$pendidikan_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pendidikan_add->Page_Terminate();
?>
