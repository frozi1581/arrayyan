<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tb_notifikasiinfo.php" ?>
<?php include_once "tb_notifikasi_dgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tb_notifikasi_add = NULL; // Initialize page object first

class ctb_notifikasi_add extends ctb_notifikasi {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'tb_notifikasi';

	// Page object name
	var $PageObjName = 'tb_notifikasi_add';

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

		// Table object (tb_notifikasi)
		if (!isset($GLOBALS["tb_notifikasi"]) || get_class($GLOBALS["tb_notifikasi"]) == "ctb_notifikasi") {
			$GLOBALS["tb_notifikasi"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_notifikasi"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_notifikasi', TRUE);

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
		$this->topic->SetVisibility();
		$this->priority->SetVisibility();
		$this->isi_notif->SetVisibility();
		$this->action->SetVisibility();
		$this->filter_penerima->SetVisibility();

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

			// Get the keys for master table
			$sDetailTblVar = $this->getCurrentDetailTable();
			if ($sDetailTblVar <> "") {
				$DetailTblVar = explode(",", $sDetailTblVar);
				if (in_array("tb_notifikasi_d", $DetailTblVar)) {

					// Process auto fill for detail table 'tb_notifikasi_d'
					if (preg_match('/^ftb_notifikasi_d(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["tb_notifikasi_d_grid"])) $GLOBALS["tb_notifikasi_d_grid"] = new ctb_notifikasi_d_grid;
						$GLOBALS["tb_notifikasi_d_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
			}
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
		global $EW_EXPORT, $tb_notifikasi;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_notifikasi);
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
					if ($pageName == "tb_notifikasiview.php")
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

		// Set up detail parameters
		$this->SetupDetailParms();

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
					$this->Page_Terminate("tb_notifikasilist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tb_notifikasilist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "tb_notifikasiview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetupDetailParms();
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
		$this->topic->CurrentValue = NULL;
		$this->topic->OldValue = $this->topic->CurrentValue;
		$this->priority->CurrentValue = NULL;
		$this->priority->OldValue = $this->priority->CurrentValue;
		$this->isi_notif->CurrentValue = NULL;
		$this->isi_notif->OldValue = $this->isi_notif->CurrentValue;
		$this->action->CurrentValue = NULL;
		$this->action->OldValue = $this->action->CurrentValue;
		$this->tgl_cr->CurrentValue = NULL;
		$this->tgl_cr->OldValue = $this->tgl_cr->CurrentValue;
		$this->cr_by->CurrentValue = NULL;
		$this->cr_by->OldValue = $this->cr_by->CurrentValue;
		$this->filter_penerima->CurrentValue = NULL;
		$this->filter_penerima->OldValue = $this->filter_penerima->CurrentValue;
		$this->tgl_upd->CurrentValue = NULL;
		$this->tgl_upd->OldValue = $this->tgl_upd->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->topic->FldIsDetailKey) {
			$this->topic->setFormValue($objForm->GetValue("x_topic"));
		}
		if (!$this->priority->FldIsDetailKey) {
			$this->priority->setFormValue($objForm->GetValue("x_priority"));
		}
		if (!$this->isi_notif->FldIsDetailKey) {
			$this->isi_notif->setFormValue($objForm->GetValue("x_isi_notif"));
		}
		if (!$this->action->FldIsDetailKey) {
			$this->action->setFormValue($objForm->GetValue("x_action"));
		}
		if (!$this->filter_penerima->FldIsDetailKey) {
			$this->filter_penerima->setFormValue($objForm->GetValue("x_filter_penerima"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->topic->CurrentValue = $this->topic->FormValue;
		$this->priority->CurrentValue = $this->priority->FormValue;
		$this->isi_notif->CurrentValue = $this->isi_notif->FormValue;
		$this->action->CurrentValue = $this->action->FormValue;
		$this->filter_penerima->CurrentValue = $this->filter_penerima->FormValue;
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
		$this->topic->setDbValue($row['topic']);
		$this->priority->setDbValue($row['priority']);
		$this->isi_notif->setDbValue($row['isi_notif']);
		$this->action->setDbValue($row['action']);
		$this->tgl_cr->setDbValue($row['tgl_cr']);
		$this->cr_by->setDbValue($row['cr_by']);
		$this->filter_penerima->setDbValue($row['filter_penerima']);
		$this->tgl_upd->setDbValue($row['tgl_upd']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['topic'] = $this->topic->CurrentValue;
		$row['priority'] = $this->priority->CurrentValue;
		$row['isi_notif'] = $this->isi_notif->CurrentValue;
		$row['action'] = $this->action->CurrentValue;
		$row['tgl_cr'] = $this->tgl_cr->CurrentValue;
		$row['cr_by'] = $this->cr_by->CurrentValue;
		$row['filter_penerima'] = $this->filter_penerima->CurrentValue;
		$row['tgl_upd'] = $this->tgl_upd->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->topic->DbValue = $row['topic'];
		$this->priority->DbValue = $row['priority'];
		$this->isi_notif->DbValue = $row['isi_notif'];
		$this->action->DbValue = $row['action'];
		$this->tgl_cr->DbValue = $row['tgl_cr'];
		$this->cr_by->DbValue = $row['cr_by'];
		$this->filter_penerima->DbValue = $row['filter_penerima'];
		$this->tgl_upd->DbValue = $row['tgl_upd'];
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
		// topic
		// priority
		// isi_notif
		// action
		// tgl_cr
		// cr_by
		// filter_penerima
		// tgl_upd

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

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

		// priority
		if (strval($this->priority->CurrentValue) <> "") {
			$this->priority->ViewValue = $this->priority->OptionCaption($this->priority->CurrentValue);
		} else {
			$this->priority->ViewValue = NULL;
		}
		$this->priority->ViewCustomAttributes = "";

		// isi_notif
		$this->isi_notif->ViewValue = $this->isi_notif->CurrentValue;
		$this->isi_notif->ViewCustomAttributes = "";

		// action
		$this->action->ViewValue = $this->action->CurrentValue;
		$this->action->ViewCustomAttributes = "";

		// tgl_cr
		$this->tgl_cr->ViewValue = $this->tgl_cr->CurrentValue;
		$this->tgl_cr->ViewValue = ew_FormatDateTime($this->tgl_cr->ViewValue, 2);
		$this->tgl_cr->ViewCustomAttributes = "";

		// cr_by
		$this->cr_by->ViewValue = $this->cr_by->CurrentValue;
		$this->cr_by->ViewCustomAttributes = "";

		// filter_penerima
		$this->filter_penerima->ViewValue = $this->filter_penerima->CurrentValue;
		if (strval($this->filter_penerima->CurrentValue) <> "") {
			$sFilterWrk = "tb_pat.KD_PAT" . ew_SearchString("=", $this->filter_penerima->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `KD_PAT`, `KET` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM tb_pat";
		$sWhereWrk = "";
		$this->filter_penerima->LookupFilters = array("dx1" => 'tb_pat.KET');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->filter_penerima, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->filter_penerima->ViewValue = $this->filter_penerima->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->filter_penerima->ViewValue = $this->filter_penerima->CurrentValue;
			}
		} else {
			$this->filter_penerima->ViewValue = NULL;
		}
		$this->filter_penerima->ViewCustomAttributes = "";

		// tgl_upd
		$this->tgl_upd->ViewValue = $this->tgl_upd->CurrentValue;
		$this->tgl_upd->ViewValue = ew_FormatDateTime($this->tgl_upd->ViewValue, 0);
		$this->tgl_upd->ViewCustomAttributes = "";

			// topic
			$this->topic->LinkCustomAttributes = "";
			$this->topic->HrefValue = "";
			$this->topic->TooltipValue = "";

			// priority
			$this->priority->LinkCustomAttributes = "";
			$this->priority->HrefValue = "";
			$this->priority->TooltipValue = "";

			// isi_notif
			$this->isi_notif->LinkCustomAttributes = "";
			$this->isi_notif->HrefValue = "";
			$this->isi_notif->TooltipValue = "";

			// action
			$this->action->LinkCustomAttributes = "";
			$this->action->HrefValue = "";
			$this->action->TooltipValue = "";

			// filter_penerima
			$this->filter_penerima->LinkCustomAttributes = "";
			$this->filter_penerima->HrefValue = "";
			$this->filter_penerima->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// priority
			$this->priority->EditAttrs["class"] = "form-control";
			$this->priority->EditCustomAttributes = "";
			$this->priority->EditValue = $this->priority->Options(TRUE);

			// isi_notif
			$this->isi_notif->EditAttrs["class"] = "form-control";
			$this->isi_notif->EditCustomAttributes = "";
			$this->isi_notif->EditValue = ew_HtmlEncode($this->isi_notif->CurrentValue);
			$this->isi_notif->PlaceHolder = ew_RemoveHtml($this->isi_notif->FldCaption());

			// action
			$this->action->EditAttrs["class"] = "form-control";
			$this->action->EditCustomAttributes = "";
			$this->action->EditValue = ew_HtmlEncode($this->action->CurrentValue);
			$this->action->PlaceHolder = ew_RemoveHtml($this->action->FldCaption());

			// filter_penerima
			$this->filter_penerima->EditAttrs["class"] = "form-control";
			$this->filter_penerima->EditCustomAttributes = "";
			$this->filter_penerima->EditValue = ew_HtmlEncode($this->filter_penerima->CurrentValue);
			if (strval($this->filter_penerima->CurrentValue) <> "") {
				$sFilterWrk = "tb_pat.KD_PAT" . ew_SearchString("=", $this->filter_penerima->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `KD_PAT`, `KET` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM tb_pat";
			$sWhereWrk = "";
			$this->filter_penerima->LookupFilters = array("dx1" => 'tb_pat.KET');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->filter_penerima, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->filter_penerima->EditValue = $this->filter_penerima->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->filter_penerima->EditValue = ew_HtmlEncode($this->filter_penerima->CurrentValue);
				}
			} else {
				$this->filter_penerima->EditValue = NULL;
			}
			$this->filter_penerima->PlaceHolder = ew_RemoveHtml($this->filter_penerima->FldCaption());

			// Add refer script
			// topic

			$this->topic->LinkCustomAttributes = "";
			$this->topic->HrefValue = "";

			// priority
			$this->priority->LinkCustomAttributes = "";
			$this->priority->HrefValue = "";

			// isi_notif
			$this->isi_notif->LinkCustomAttributes = "";
			$this->isi_notif->HrefValue = "";

			// action
			$this->action->LinkCustomAttributes = "";
			$this->action->HrefValue = "";

			// filter_penerima
			$this->filter_penerima->LinkCustomAttributes = "";
			$this->filter_penerima->HrefValue = "";
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

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("tb_notifikasi_d", $DetailTblVar) && $GLOBALS["tb_notifikasi_d"]->DetailAdd) {
			if (!isset($GLOBALS["tb_notifikasi_d_grid"])) $GLOBALS["tb_notifikasi_d_grid"] = new ctb_notifikasi_d_grid(); // get detail page object
			$GLOBALS["tb_notifikasi_d_grid"]->ValidateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// topic
		$this->topic->SetDbValueDef($rsnew, $this->topic->CurrentValue, NULL, FALSE);

		// priority
		$this->priority->SetDbValueDef($rsnew, $this->priority->CurrentValue, NULL, FALSE);

		// isi_notif
		$this->isi_notif->SetDbValueDef($rsnew, $this->isi_notif->CurrentValue, NULL, FALSE);

		// action
		$this->action->SetDbValueDef($rsnew, $this->action->CurrentValue, NULL, FALSE);

		// filter_penerima
		$this->filter_penerima->SetDbValueDef($rsnew, $this->filter_penerima->CurrentValue, "", FALSE);

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("tb_notifikasi_d", $DetailTblVar) && $GLOBALS["tb_notifikasi_d"]->DetailAdd) {
				$GLOBALS["tb_notifikasi_d"]->id->setSessionValue($this->id->CurrentValue); // Set master key
				if (!isset($GLOBALS["tb_notifikasi_d_grid"])) $GLOBALS["tb_notifikasi_d_grid"] = new ctb_notifikasi_d_grid(); // Get detail page object
				$AddRow = $GLOBALS["tb_notifikasi_d_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["tb_notifikasi_d"]->id->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetupDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("tb_notifikasi_d", $DetailTblVar)) {
				if (!isset($GLOBALS["tb_notifikasi_d_grid"]))
					$GLOBALS["tb_notifikasi_d_grid"] = new ctb_notifikasi_d_grid;
				if ($GLOBALS["tb_notifikasi_d_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["tb_notifikasi_d_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["tb_notifikasi_d_grid"]->CurrentMode = "add";
					$GLOBALS["tb_notifikasi_d_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["tb_notifikasi_d_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["tb_notifikasi_d_grid"]->setStartRecordNumber(1);
					$GLOBALS["tb_notifikasi_d_grid"]->id->FldIsDetailKey = TRUE;
					$GLOBALS["tb_notifikasi_d_grid"]->id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["tb_notifikasi_d_grid"]->id->setSessionValue($GLOBALS["tb_notifikasi_d_grid"]->id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_notifikasilist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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
		case "x_filter_penerima":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KD_PAT` AS `LinkFld`, `KET` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM tb_pat";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => 'tb_pat.KET');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => 'tb_pat.KD_PAT IN ({filter_value})', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->filter_penerima, $sWhereWrk); // Call Lookup Selecting
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
		case "x_filter_penerima":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KD_PAT`, `KET` AS `DispFld` FROM tb_pat";
			$sWhereWrk = "`KET` LIKE '{query_value}%'";
			$fld->LookupFilters = array("dx1" => 'tb_pat.KET');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->filter_penerima, $sWhereWrk); // Call Lookup Selecting
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

		  if($_SESSION["redirect"]!='')
			$url =$_SESSION["redirect"]; 
			$_SESSION["redirect"]='';
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

		$header = "Form Notifikasi";
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
if (!isset($tb_notifikasi_add)) $tb_notifikasi_add = new ctb_notifikasi_add();

// Page init
$tb_notifikasi_add->Page_Init();

// Page main
$tb_notifikasi_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_notifikasi_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftb_notifikasiadd = new ew_Form("ftb_notifikasiadd", "add");

// Validate form
ftb_notifikasiadd.Validate = function() {
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
ftb_notifikasiadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftb_notifikasiadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftb_notifikasiadd.Lists["x_topic"] = {"LinkField":"x_nama_referensi","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_referensi","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_referensi"};
ftb_notifikasiadd.Lists["x_topic"].Data = "<?php echo $tb_notifikasi_add->topic->LookupFilterQuery(FALSE, "add") ?>";
ftb_notifikasiadd.Lists["x_priority"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftb_notifikasiadd.Lists["x_priority"].Options = <?php echo json_encode($tb_notifikasi_add->priority->Options()) ?>;
ftb_notifikasiadd.Lists["x_filter_penerima"] = {"LinkField":"x_KD_PAT","Ajax":true,"AutoFill":false,"DisplayFields":["x_KET","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_tb_pat"};
ftb_notifikasiadd.Lists["x_filter_penerima"].Data = "<?php echo $tb_notifikasi_add->filter_penerima->LookupFilterQuery(FALSE, "add") ?>";
ftb_notifikasiadd.AutoSuggests["x_filter_penerima"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $tb_notifikasi_add->filter_penerima->LookupFilterQuery(TRUE, "add"))) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
$(document).ready(function(){
	$('.content-header').hide();
	$('.tbl_tb_notifikasi_dgrid').hide();
});
</script>
<?php $tb_notifikasi_add->ShowPageHeader(); ?>
<?php
$tb_notifikasi_add->ShowMessage();
?>
<form name="ftb_notifikasiadd" id="ftb_notifikasiadd" class="<?php echo $tb_notifikasi_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_notifikasi_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_notifikasi_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_notifikasi">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($tb_notifikasi_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($tb_notifikasi->topic->Visible) { // topic ?>
	<div id="r_topic" class="form-group">
		<label id="elh_tb_notifikasi_topic" for="x_topic" class="<?php echo $tb_notifikasi_add->LeftColumnClass ?>"><?php echo $tb_notifikasi->topic->FldCaption() ?></label>
		<div class="<?php echo $tb_notifikasi_add->RightColumnClass ?>"><div<?php echo $tb_notifikasi->topic->CellAttributes() ?>>
<span id="el_tb_notifikasi_topic">
<select data-table="tb_notifikasi" data-field="x_topic" data-page="1" data-value-separator="<?php echo $tb_notifikasi->topic->DisplayValueSeparatorAttribute() ?>" id="x_topic" name="x_topic"<?php echo $tb_notifikasi->topic->EditAttributes() ?>>
<?php echo $tb_notifikasi->topic->SelectOptionListHtml("x_topic") ?>
</select>
</span>
<?php echo $tb_notifikasi->topic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_notifikasi->priority->Visible) { // priority ?>
	<div id="r_priority" class="form-group">
		<label id="elh_tb_notifikasi_priority" for="x_priority" class="<?php echo $tb_notifikasi_add->LeftColumnClass ?>"><?php echo $tb_notifikasi->priority->FldCaption() ?></label>
		<div class="<?php echo $tb_notifikasi_add->RightColumnClass ?>"><div<?php echo $tb_notifikasi->priority->CellAttributes() ?>>
<span id="el_tb_notifikasi_priority">
<select data-table="tb_notifikasi" data-field="x_priority" data-page="1" data-value-separator="<?php echo $tb_notifikasi->priority->DisplayValueSeparatorAttribute() ?>" id="x_priority" name="x_priority"<?php echo $tb_notifikasi->priority->EditAttributes() ?>>
<?php echo $tb_notifikasi->priority->SelectOptionListHtml("x_priority") ?>
</select>
</span>
<?php echo $tb_notifikasi->priority->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_notifikasi->isi_notif->Visible) { // isi_notif ?>
	<div id="r_isi_notif" class="form-group">
		<label id="elh_tb_notifikasi_isi_notif" for="x_isi_notif" class="<?php echo $tb_notifikasi_add->LeftColumnClass ?>"><?php echo $tb_notifikasi->isi_notif->FldCaption() ?></label>
		<div class="<?php echo $tb_notifikasi_add->RightColumnClass ?>"><div<?php echo $tb_notifikasi->isi_notif->CellAttributes() ?>>
<span id="el_tb_notifikasi_isi_notif">
<textarea data-table="tb_notifikasi" data-field="x_isi_notif" data-page="1" name="x_isi_notif" id="x_isi_notif" cols="100" rows="4" placeholder="<?php echo ew_HtmlEncode($tb_notifikasi->isi_notif->getPlaceHolder()) ?>"<?php echo $tb_notifikasi->isi_notif->EditAttributes() ?>><?php echo $tb_notifikasi->isi_notif->EditValue ?></textarea>
</span>
<?php echo $tb_notifikasi->isi_notif->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_notifikasi->action->Visible) { // action ?>
	<div id="r_action" class="form-group">
		<label id="elh_tb_notifikasi_action" for="x_action" class="<?php echo $tb_notifikasi_add->LeftColumnClass ?>"><?php echo $tb_notifikasi->action->FldCaption() ?></label>
		<div class="<?php echo $tb_notifikasi_add->RightColumnClass ?>"><div<?php echo $tb_notifikasi->action->CellAttributes() ?>>
<span id="el_tb_notifikasi_action">
<textarea data-table="tb_notifikasi" data-field="x_action" data-page="1" name="x_action" id="x_action" cols="50" rows="5" placeholder="<?php echo ew_HtmlEncode($tb_notifikasi->action->getPlaceHolder()) ?>"<?php echo $tb_notifikasi->action->EditAttributes() ?>><?php echo $tb_notifikasi->action->EditValue ?></textarea>
</span>
<?php echo $tb_notifikasi->action->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_notifikasi->filter_penerima->Visible) { // filter_penerima ?>
	<div id="r_filter_penerima" class="form-group">
		<label id="elh_tb_notifikasi_filter_penerima" class="<?php echo $tb_notifikasi_add->LeftColumnClass ?>"><?php echo $tb_notifikasi->filter_penerima->FldCaption() ?></label>
		<div class="<?php echo $tb_notifikasi_add->RightColumnClass ?>"><div<?php echo $tb_notifikasi->filter_penerima->CellAttributes() ?>>
<span id="el_tb_notifikasi_filter_penerima">
<?php
$wrkonchange = trim(" " . @$tb_notifikasi->filter_penerima->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_notifikasi->filter_penerima->EditAttrs["onchange"] = "";
?>
<span id="as_x_filter_penerima" style="white-space: nowrap; z-index: 8920">
	<input type="text" name="sv_x_filter_penerima" id="sv_x_filter_penerima" value="<?php echo $tb_notifikasi->filter_penerima->EditValue ?>" placeholder="<?php echo ew_HtmlEncode($tb_notifikasi->filter_penerima->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_notifikasi->filter_penerima->getPlaceHolder()) ?>"<?php echo $tb_notifikasi->filter_penerima->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_notifikasi" data-field="x_filter_penerima" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_notifikasi->filter_penerima->DisplayValueSeparatorAttribute() ?>" name="x_filter_penerima" id="x_filter_penerima" value="<?php echo ew_HtmlEncode($tb_notifikasi->filter_penerima->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ftb_notifikasiadd.CreateAutoSuggest({"id":"x_filter_penerima","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_notifikasi->filter_penerima->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_filter_penerima',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($tb_notifikasi->filter_penerima->ReadOnly || $tb_notifikasi->filter_penerima->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php echo $tb_notifikasi->filter_penerima->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("tb_notifikasi_d", explode(",", $tb_notifikasi->getCurrentDetailTable())) && $tb_notifikasi_d->DetailAdd) {
?>
<?php if ($tb_notifikasi->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("tb_notifikasi_d", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "tb_notifikasi_dgrid.php" ?>
<?php } ?>
<?php if (!$tb_notifikasi_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $tb_notifikasi_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_notifikasi_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ftb_notifikasiadd.Init();
</script>
<?php
$tb_notifikasi_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

$(document).ready(function(){
	$('.content-header').hide();
	$('.tbl_tb_notifikasi_dgrid').hide();
});
</script>
<?php include_once "footer.php" ?>
<?php
$tb_notifikasi_add->Page_Terminate();
?>
