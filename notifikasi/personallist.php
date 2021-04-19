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

$personal_list = NULL; // Initialize page object first

class cpersonal_list extends cpersonal {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'personal';

	// Page object name
	var $PageObjName = 'personal_list';

	// Grid form hidden field names
	var $FormName = 'fpersonallist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "personaladd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "personaldelete.php";
		$this->MultiUpdateUrl = "personalupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fpersonallistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();
		$this->fgr_print_id->SetVisibility();
		$this->kd_jbt_eselon->SetVisibility();
		$this->npwp->SetVisibility();
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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->employee_id->setFormValue($arrKeyFlds[0]);
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Initialize
		$sFilterList = "";
		$sSavedFilterList = "";

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server" && isset($UserProfile))
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fpersonallistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->employee_id->AdvancedSearch->ToJson(), ","); // Field employee_id
		$sFilterList = ew_Concat($sFilterList, $this->first_name->AdvancedSearch->ToJson(), ","); // Field first_name
		$sFilterList = ew_Concat($sFilterList, $this->last_name->AdvancedSearch->ToJson(), ","); // Field last_name
		$sFilterList = ew_Concat($sFilterList, $this->first_title->AdvancedSearch->ToJson(), ","); // Field first_title
		$sFilterList = ew_Concat($sFilterList, $this->last_title->AdvancedSearch->ToJson(), ","); // Field last_title
		$sFilterList = ew_Concat($sFilterList, $this->init->AdvancedSearch->ToJson(), ","); // Field init
		$sFilterList = ew_Concat($sFilterList, $this->tpt_lahir->AdvancedSearch->ToJson(), ","); // Field tpt_lahir
		$sFilterList = ew_Concat($sFilterList, $this->tgl_lahir->AdvancedSearch->ToJson(), ","); // Field tgl_lahir
		$sFilterList = ew_Concat($sFilterList, $this->jk->AdvancedSearch->ToJson(), ","); // Field jk
		$sFilterList = ew_Concat($sFilterList, $this->kd_agama->AdvancedSearch->ToJson(), ","); // Field kd_agama
		$sFilterList = ew_Concat($sFilterList, $this->tgl_masuk->AdvancedSearch->ToJson(), ","); // Field tgl_masuk
		$sFilterList = ew_Concat($sFilterList, $this->tpt_masuk->AdvancedSearch->ToJson(), ","); // Field tpt_masuk
		$sFilterList = ew_Concat($sFilterList, $this->stkel->AdvancedSearch->ToJson(), ","); // Field stkel
		$sFilterList = ew_Concat($sFilterList, $this->alamat->AdvancedSearch->ToJson(), ","); // Field alamat
		$sFilterList = ew_Concat($sFilterList, $this->kota->AdvancedSearch->ToJson(), ","); // Field kota
		$sFilterList = ew_Concat($sFilterList, $this->kd_pos->AdvancedSearch->ToJson(), ","); // Field kd_pos
		$sFilterList = ew_Concat($sFilterList, $this->kd_propinsi->AdvancedSearch->ToJson(), ","); // Field kd_propinsi
		$sFilterList = ew_Concat($sFilterList, $this->telp->AdvancedSearch->ToJson(), ","); // Field telp
		$sFilterList = ew_Concat($sFilterList, $this->telp_area->AdvancedSearch->ToJson(), ","); // Field telp_area
		$sFilterList = ew_Concat($sFilterList, $this->hp->AdvancedSearch->ToJson(), ","); // Field hp
		$sFilterList = ew_Concat($sFilterList, $this->alamat_dom->AdvancedSearch->ToJson(), ","); // Field alamat_dom
		$sFilterList = ew_Concat($sFilterList, $this->kota_dom->AdvancedSearch->ToJson(), ","); // Field kota_dom
		$sFilterList = ew_Concat($sFilterList, $this->kd_pos_dom->AdvancedSearch->ToJson(), ","); // Field kd_pos_dom
		$sFilterList = ew_Concat($sFilterList, $this->kd_propinsi_dom->AdvancedSearch->ToJson(), ","); // Field kd_propinsi_dom
		$sFilterList = ew_Concat($sFilterList, $this->telp_dom->AdvancedSearch->ToJson(), ","); // Field telp_dom
		$sFilterList = ew_Concat($sFilterList, $this->telp_dom_area->AdvancedSearch->ToJson(), ","); // Field telp_dom_area
		$sFilterList = ew_Concat($sFilterList, $this->_email->AdvancedSearch->ToJson(), ","); // Field email
		$sFilterList = ew_Concat($sFilterList, $this->kd_st_emp->AdvancedSearch->ToJson(), ","); // Field kd_st_emp
		$sFilterList = ew_Concat($sFilterList, $this->skala->AdvancedSearch->ToJson(), ","); // Field skala
		$sFilterList = ew_Concat($sFilterList, $this->gp->AdvancedSearch->ToJson(), ","); // Field gp
		$sFilterList = ew_Concat($sFilterList, $this->upah_tetap->AdvancedSearch->ToJson(), ","); // Field upah_tetap
		$sFilterList = ew_Concat($sFilterList, $this->tgl_honor->AdvancedSearch->ToJson(), ","); // Field tgl_honor
		$sFilterList = ew_Concat($sFilterList, $this->honor->AdvancedSearch->ToJson(), ","); // Field honor
		$sFilterList = ew_Concat($sFilterList, $this->premi_honor->AdvancedSearch->ToJson(), ","); // Field premi_honor
		$sFilterList = ew_Concat($sFilterList, $this->tgl_gp->AdvancedSearch->ToJson(), ","); // Field tgl_gp
		$sFilterList = ew_Concat($sFilterList, $this->skala_95->AdvancedSearch->ToJson(), ","); // Field skala_95
		$sFilterList = ew_Concat($sFilterList, $this->gp_95->AdvancedSearch->ToJson(), ","); // Field gp_95
		$sFilterList = ew_Concat($sFilterList, $this->tgl_gp_95->AdvancedSearch->ToJson(), ","); // Field tgl_gp_95
		$sFilterList = ew_Concat($sFilterList, $this->kd_indx->AdvancedSearch->ToJson(), ","); // Field kd_indx
		$sFilterList = ew_Concat($sFilterList, $this->indx_lok->AdvancedSearch->ToJson(), ","); // Field indx_lok
		$sFilterList = ew_Concat($sFilterList, $this->gol_darah->AdvancedSearch->ToJson(), ","); // Field gol_darah
		$sFilterList = ew_Concat($sFilterList, $this->kd_jbt->AdvancedSearch->ToJson(), ","); // Field kd_jbt
		$sFilterList = ew_Concat($sFilterList, $this->tgl_kd_jbt->AdvancedSearch->ToJson(), ","); // Field tgl_kd_jbt
		$sFilterList = ew_Concat($sFilterList, $this->kd_jbt_pgs->AdvancedSearch->ToJson(), ","); // Field kd_jbt_pgs
		$sFilterList = ew_Concat($sFilterList, $this->tgl_kd_jbt_pgs->AdvancedSearch->ToJson(), ","); // Field tgl_kd_jbt_pgs
		$sFilterList = ew_Concat($sFilterList, $this->kd_jbt_pjs->AdvancedSearch->ToJson(), ","); // Field kd_jbt_pjs
		$sFilterList = ew_Concat($sFilterList, $this->tgl_kd_jbt_pjs->AdvancedSearch->ToJson(), ","); // Field tgl_kd_jbt_pjs
		$sFilterList = ew_Concat($sFilterList, $this->kd_jbt_ps->AdvancedSearch->ToJson(), ","); // Field kd_jbt_ps
		$sFilterList = ew_Concat($sFilterList, $this->tgl_kd_jbt_ps->AdvancedSearch->ToJson(), ","); // Field tgl_kd_jbt_ps
		$sFilterList = ew_Concat($sFilterList, $this->kd_pat->AdvancedSearch->ToJson(), ","); // Field kd_pat
		$sFilterList = ew_Concat($sFilterList, $this->kd_gas->AdvancedSearch->ToJson(), ","); // Field kd_gas
		$sFilterList = ew_Concat($sFilterList, $this->pimp_empid->AdvancedSearch->ToJson(), ","); // Field pimp_empid
		$sFilterList = ew_Concat($sFilterList, $this->stshift->AdvancedSearch->ToJson(), ","); // Field stshift
		$sFilterList = ew_Concat($sFilterList, $this->no_rek->AdvancedSearch->ToJson(), ","); // Field no_rek
		$sFilterList = ew_Concat($sFilterList, $this->kd_bank->AdvancedSearch->ToJson(), ","); // Field kd_bank
		$sFilterList = ew_Concat($sFilterList, $this->kd_jamsostek->AdvancedSearch->ToJson(), ","); // Field kd_jamsostek
		$sFilterList = ew_Concat($sFilterList, $this->acc_astek->AdvancedSearch->ToJson(), ","); // Field acc_astek
		$sFilterList = ew_Concat($sFilterList, $this->acc_dapens->AdvancedSearch->ToJson(), ","); // Field acc_dapens
		$sFilterList = ew_Concat($sFilterList, $this->acc_kes->AdvancedSearch->ToJson(), ","); // Field acc_kes
		$sFilterList = ew_Concat($sFilterList, $this->st->AdvancedSearch->ToJson(), ","); // Field st
		$sFilterList = ew_Concat($sFilterList, $this->created_by->AdvancedSearch->ToJson(), ","); // Field created_by
		$sFilterList = ew_Concat($sFilterList, $this->created_date->AdvancedSearch->ToJson(), ","); // Field created_date
		$sFilterList = ew_Concat($sFilterList, $this->last_update_by->AdvancedSearch->ToJson(), ","); // Field last_update_by
		$sFilterList = ew_Concat($sFilterList, $this->last_update_date->AdvancedSearch->ToJson(), ","); // Field last_update_date
		$sFilterList = ew_Concat($sFilterList, $this->fgr_print_id->AdvancedSearch->ToJson(), ","); // Field fgr_print_id
		$sFilterList = ew_Concat($sFilterList, $this->kd_jbt_eselon->AdvancedSearch->ToJson(), ","); // Field kd_jbt_eselon
		$sFilterList = ew_Concat($sFilterList, $this->npwp->AdvancedSearch->ToJson(), ","); // Field npwp
		$sFilterList = ew_Concat($sFilterList, $this->tgl_keluar->AdvancedSearch->ToJson(), ","); // Field tgl_keluar
		$sFilterList = ew_Concat($sFilterList, $this->nama_nasabah->AdvancedSearch->ToJson(), ","); // Field nama_nasabah
		$sFilterList = ew_Concat($sFilterList, $this->no_ktp->AdvancedSearch->ToJson(), ","); // Field no_ktp
		$sFilterList = ew_Concat($sFilterList, $this->no_kokar->AdvancedSearch->ToJson(), ","); // Field no_kokar
		$sFilterList = ew_Concat($sFilterList, $this->no_bmw->AdvancedSearch->ToJson(), ","); // Field no_bmw
		$sFilterList = ew_Concat($sFilterList, $this->no_bpjs_ketenagakerjaan->AdvancedSearch->ToJson(), ","); // Field no_bpjs_ketenagakerjaan
		$sFilterList = ew_Concat($sFilterList, $this->no_bpjs_kesehatan->AdvancedSearch->ToJson(), ","); // Field no_bpjs_kesehatan
		$sFilterList = ew_Concat($sFilterList, $this->eselon->AdvancedSearch->ToJson(), ","); // Field eselon
		$sFilterList = ew_Concat($sFilterList, $this->kd_jenjang->AdvancedSearch->ToJson(), ","); // Field kd_jenjang
		$sFilterList = ew_Concat($sFilterList, $this->kd_jbt_esl->AdvancedSearch->ToJson(), ","); // Field kd_jbt_esl
		$sFilterList = ew_Concat($sFilterList, $this->tgl_jbt_esl->AdvancedSearch->ToJson(), ","); // Field tgl_jbt_esl
		$sFilterList = ew_Concat($sFilterList, $this->org_id->AdvancedSearch->ToJson(), ","); // Field org_id
		$sFilterList = ew_Concat($sFilterList, $this->kd_payroll->AdvancedSearch->ToJson(), ","); // Field kd_payroll
		$sFilterList = ew_Concat($sFilterList, $this->id_wn->AdvancedSearch->ToJson(), ","); // Field id_wn
		$sFilterList = ew_Concat($sFilterList, $this->no_anggota_kkms->AdvancedSearch->ToJson(), ","); // Field no_anggota_kkms
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "fpersonallistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field employee_id
		$this->employee_id->AdvancedSearch->SearchValue = @$filter["x_employee_id"];
		$this->employee_id->AdvancedSearch->SearchOperator = @$filter["z_employee_id"];
		$this->employee_id->AdvancedSearch->SearchCondition = @$filter["v_employee_id"];
		$this->employee_id->AdvancedSearch->SearchValue2 = @$filter["y_employee_id"];
		$this->employee_id->AdvancedSearch->SearchOperator2 = @$filter["w_employee_id"];
		$this->employee_id->AdvancedSearch->Save();

		// Field first_name
		$this->first_name->AdvancedSearch->SearchValue = @$filter["x_first_name"];
		$this->first_name->AdvancedSearch->SearchOperator = @$filter["z_first_name"];
		$this->first_name->AdvancedSearch->SearchCondition = @$filter["v_first_name"];
		$this->first_name->AdvancedSearch->SearchValue2 = @$filter["y_first_name"];
		$this->first_name->AdvancedSearch->SearchOperator2 = @$filter["w_first_name"];
		$this->first_name->AdvancedSearch->Save();

		// Field last_name
		$this->last_name->AdvancedSearch->SearchValue = @$filter["x_last_name"];
		$this->last_name->AdvancedSearch->SearchOperator = @$filter["z_last_name"];
		$this->last_name->AdvancedSearch->SearchCondition = @$filter["v_last_name"];
		$this->last_name->AdvancedSearch->SearchValue2 = @$filter["y_last_name"];
		$this->last_name->AdvancedSearch->SearchOperator2 = @$filter["w_last_name"];
		$this->last_name->AdvancedSearch->Save();

		// Field first_title
		$this->first_title->AdvancedSearch->SearchValue = @$filter["x_first_title"];
		$this->first_title->AdvancedSearch->SearchOperator = @$filter["z_first_title"];
		$this->first_title->AdvancedSearch->SearchCondition = @$filter["v_first_title"];
		$this->first_title->AdvancedSearch->SearchValue2 = @$filter["y_first_title"];
		$this->first_title->AdvancedSearch->SearchOperator2 = @$filter["w_first_title"];
		$this->first_title->AdvancedSearch->Save();

		// Field last_title
		$this->last_title->AdvancedSearch->SearchValue = @$filter["x_last_title"];
		$this->last_title->AdvancedSearch->SearchOperator = @$filter["z_last_title"];
		$this->last_title->AdvancedSearch->SearchCondition = @$filter["v_last_title"];
		$this->last_title->AdvancedSearch->SearchValue2 = @$filter["y_last_title"];
		$this->last_title->AdvancedSearch->SearchOperator2 = @$filter["w_last_title"];
		$this->last_title->AdvancedSearch->Save();

		// Field init
		$this->init->AdvancedSearch->SearchValue = @$filter["x_init"];
		$this->init->AdvancedSearch->SearchOperator = @$filter["z_init"];
		$this->init->AdvancedSearch->SearchCondition = @$filter["v_init"];
		$this->init->AdvancedSearch->SearchValue2 = @$filter["y_init"];
		$this->init->AdvancedSearch->SearchOperator2 = @$filter["w_init"];
		$this->init->AdvancedSearch->Save();

		// Field tpt_lahir
		$this->tpt_lahir->AdvancedSearch->SearchValue = @$filter["x_tpt_lahir"];
		$this->tpt_lahir->AdvancedSearch->SearchOperator = @$filter["z_tpt_lahir"];
		$this->tpt_lahir->AdvancedSearch->SearchCondition = @$filter["v_tpt_lahir"];
		$this->tpt_lahir->AdvancedSearch->SearchValue2 = @$filter["y_tpt_lahir"];
		$this->tpt_lahir->AdvancedSearch->SearchOperator2 = @$filter["w_tpt_lahir"];
		$this->tpt_lahir->AdvancedSearch->Save();

		// Field tgl_lahir
		$this->tgl_lahir->AdvancedSearch->SearchValue = @$filter["x_tgl_lahir"];
		$this->tgl_lahir->AdvancedSearch->SearchOperator = @$filter["z_tgl_lahir"];
		$this->tgl_lahir->AdvancedSearch->SearchCondition = @$filter["v_tgl_lahir"];
		$this->tgl_lahir->AdvancedSearch->SearchValue2 = @$filter["y_tgl_lahir"];
		$this->tgl_lahir->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_lahir"];
		$this->tgl_lahir->AdvancedSearch->Save();

		// Field jk
		$this->jk->AdvancedSearch->SearchValue = @$filter["x_jk"];
		$this->jk->AdvancedSearch->SearchOperator = @$filter["z_jk"];
		$this->jk->AdvancedSearch->SearchCondition = @$filter["v_jk"];
		$this->jk->AdvancedSearch->SearchValue2 = @$filter["y_jk"];
		$this->jk->AdvancedSearch->SearchOperator2 = @$filter["w_jk"];
		$this->jk->AdvancedSearch->Save();

		// Field kd_agama
		$this->kd_agama->AdvancedSearch->SearchValue = @$filter["x_kd_agama"];
		$this->kd_agama->AdvancedSearch->SearchOperator = @$filter["z_kd_agama"];
		$this->kd_agama->AdvancedSearch->SearchCondition = @$filter["v_kd_agama"];
		$this->kd_agama->AdvancedSearch->SearchValue2 = @$filter["y_kd_agama"];
		$this->kd_agama->AdvancedSearch->SearchOperator2 = @$filter["w_kd_agama"];
		$this->kd_agama->AdvancedSearch->Save();

		// Field tgl_masuk
		$this->tgl_masuk->AdvancedSearch->SearchValue = @$filter["x_tgl_masuk"];
		$this->tgl_masuk->AdvancedSearch->SearchOperator = @$filter["z_tgl_masuk"];
		$this->tgl_masuk->AdvancedSearch->SearchCondition = @$filter["v_tgl_masuk"];
		$this->tgl_masuk->AdvancedSearch->SearchValue2 = @$filter["y_tgl_masuk"];
		$this->tgl_masuk->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_masuk"];
		$this->tgl_masuk->AdvancedSearch->Save();

		// Field tpt_masuk
		$this->tpt_masuk->AdvancedSearch->SearchValue = @$filter["x_tpt_masuk"];
		$this->tpt_masuk->AdvancedSearch->SearchOperator = @$filter["z_tpt_masuk"];
		$this->tpt_masuk->AdvancedSearch->SearchCondition = @$filter["v_tpt_masuk"];
		$this->tpt_masuk->AdvancedSearch->SearchValue2 = @$filter["y_tpt_masuk"];
		$this->tpt_masuk->AdvancedSearch->SearchOperator2 = @$filter["w_tpt_masuk"];
		$this->tpt_masuk->AdvancedSearch->Save();

		// Field stkel
		$this->stkel->AdvancedSearch->SearchValue = @$filter["x_stkel"];
		$this->stkel->AdvancedSearch->SearchOperator = @$filter["z_stkel"];
		$this->stkel->AdvancedSearch->SearchCondition = @$filter["v_stkel"];
		$this->stkel->AdvancedSearch->SearchValue2 = @$filter["y_stkel"];
		$this->stkel->AdvancedSearch->SearchOperator2 = @$filter["w_stkel"];
		$this->stkel->AdvancedSearch->Save();

		// Field alamat
		$this->alamat->AdvancedSearch->SearchValue = @$filter["x_alamat"];
		$this->alamat->AdvancedSearch->SearchOperator = @$filter["z_alamat"];
		$this->alamat->AdvancedSearch->SearchCondition = @$filter["v_alamat"];
		$this->alamat->AdvancedSearch->SearchValue2 = @$filter["y_alamat"];
		$this->alamat->AdvancedSearch->SearchOperator2 = @$filter["w_alamat"];
		$this->alamat->AdvancedSearch->Save();

		// Field kota
		$this->kota->AdvancedSearch->SearchValue = @$filter["x_kota"];
		$this->kota->AdvancedSearch->SearchOperator = @$filter["z_kota"];
		$this->kota->AdvancedSearch->SearchCondition = @$filter["v_kota"];
		$this->kota->AdvancedSearch->SearchValue2 = @$filter["y_kota"];
		$this->kota->AdvancedSearch->SearchOperator2 = @$filter["w_kota"];
		$this->kota->AdvancedSearch->Save();

		// Field kd_pos
		$this->kd_pos->AdvancedSearch->SearchValue = @$filter["x_kd_pos"];
		$this->kd_pos->AdvancedSearch->SearchOperator = @$filter["z_kd_pos"];
		$this->kd_pos->AdvancedSearch->SearchCondition = @$filter["v_kd_pos"];
		$this->kd_pos->AdvancedSearch->SearchValue2 = @$filter["y_kd_pos"];
		$this->kd_pos->AdvancedSearch->SearchOperator2 = @$filter["w_kd_pos"];
		$this->kd_pos->AdvancedSearch->Save();

		// Field kd_propinsi
		$this->kd_propinsi->AdvancedSearch->SearchValue = @$filter["x_kd_propinsi"];
		$this->kd_propinsi->AdvancedSearch->SearchOperator = @$filter["z_kd_propinsi"];
		$this->kd_propinsi->AdvancedSearch->SearchCondition = @$filter["v_kd_propinsi"];
		$this->kd_propinsi->AdvancedSearch->SearchValue2 = @$filter["y_kd_propinsi"];
		$this->kd_propinsi->AdvancedSearch->SearchOperator2 = @$filter["w_kd_propinsi"];
		$this->kd_propinsi->AdvancedSearch->Save();

		// Field telp
		$this->telp->AdvancedSearch->SearchValue = @$filter["x_telp"];
		$this->telp->AdvancedSearch->SearchOperator = @$filter["z_telp"];
		$this->telp->AdvancedSearch->SearchCondition = @$filter["v_telp"];
		$this->telp->AdvancedSearch->SearchValue2 = @$filter["y_telp"];
		$this->telp->AdvancedSearch->SearchOperator2 = @$filter["w_telp"];
		$this->telp->AdvancedSearch->Save();

		// Field telp_area
		$this->telp_area->AdvancedSearch->SearchValue = @$filter["x_telp_area"];
		$this->telp_area->AdvancedSearch->SearchOperator = @$filter["z_telp_area"];
		$this->telp_area->AdvancedSearch->SearchCondition = @$filter["v_telp_area"];
		$this->telp_area->AdvancedSearch->SearchValue2 = @$filter["y_telp_area"];
		$this->telp_area->AdvancedSearch->SearchOperator2 = @$filter["w_telp_area"];
		$this->telp_area->AdvancedSearch->Save();

		// Field hp
		$this->hp->AdvancedSearch->SearchValue = @$filter["x_hp"];
		$this->hp->AdvancedSearch->SearchOperator = @$filter["z_hp"];
		$this->hp->AdvancedSearch->SearchCondition = @$filter["v_hp"];
		$this->hp->AdvancedSearch->SearchValue2 = @$filter["y_hp"];
		$this->hp->AdvancedSearch->SearchOperator2 = @$filter["w_hp"];
		$this->hp->AdvancedSearch->Save();

		// Field alamat_dom
		$this->alamat_dom->AdvancedSearch->SearchValue = @$filter["x_alamat_dom"];
		$this->alamat_dom->AdvancedSearch->SearchOperator = @$filter["z_alamat_dom"];
		$this->alamat_dom->AdvancedSearch->SearchCondition = @$filter["v_alamat_dom"];
		$this->alamat_dom->AdvancedSearch->SearchValue2 = @$filter["y_alamat_dom"];
		$this->alamat_dom->AdvancedSearch->SearchOperator2 = @$filter["w_alamat_dom"];
		$this->alamat_dom->AdvancedSearch->Save();

		// Field kota_dom
		$this->kota_dom->AdvancedSearch->SearchValue = @$filter["x_kota_dom"];
		$this->kota_dom->AdvancedSearch->SearchOperator = @$filter["z_kota_dom"];
		$this->kota_dom->AdvancedSearch->SearchCondition = @$filter["v_kota_dom"];
		$this->kota_dom->AdvancedSearch->SearchValue2 = @$filter["y_kota_dom"];
		$this->kota_dom->AdvancedSearch->SearchOperator2 = @$filter["w_kota_dom"];
		$this->kota_dom->AdvancedSearch->Save();

		// Field kd_pos_dom
		$this->kd_pos_dom->AdvancedSearch->SearchValue = @$filter["x_kd_pos_dom"];
		$this->kd_pos_dom->AdvancedSearch->SearchOperator = @$filter["z_kd_pos_dom"];
		$this->kd_pos_dom->AdvancedSearch->SearchCondition = @$filter["v_kd_pos_dom"];
		$this->kd_pos_dom->AdvancedSearch->SearchValue2 = @$filter["y_kd_pos_dom"];
		$this->kd_pos_dom->AdvancedSearch->SearchOperator2 = @$filter["w_kd_pos_dom"];
		$this->kd_pos_dom->AdvancedSearch->Save();

		// Field kd_propinsi_dom
		$this->kd_propinsi_dom->AdvancedSearch->SearchValue = @$filter["x_kd_propinsi_dom"];
		$this->kd_propinsi_dom->AdvancedSearch->SearchOperator = @$filter["z_kd_propinsi_dom"];
		$this->kd_propinsi_dom->AdvancedSearch->SearchCondition = @$filter["v_kd_propinsi_dom"];
		$this->kd_propinsi_dom->AdvancedSearch->SearchValue2 = @$filter["y_kd_propinsi_dom"];
		$this->kd_propinsi_dom->AdvancedSearch->SearchOperator2 = @$filter["w_kd_propinsi_dom"];
		$this->kd_propinsi_dom->AdvancedSearch->Save();

		// Field telp_dom
		$this->telp_dom->AdvancedSearch->SearchValue = @$filter["x_telp_dom"];
		$this->telp_dom->AdvancedSearch->SearchOperator = @$filter["z_telp_dom"];
		$this->telp_dom->AdvancedSearch->SearchCondition = @$filter["v_telp_dom"];
		$this->telp_dom->AdvancedSearch->SearchValue2 = @$filter["y_telp_dom"];
		$this->telp_dom->AdvancedSearch->SearchOperator2 = @$filter["w_telp_dom"];
		$this->telp_dom->AdvancedSearch->Save();

		// Field telp_dom_area
		$this->telp_dom_area->AdvancedSearch->SearchValue = @$filter["x_telp_dom_area"];
		$this->telp_dom_area->AdvancedSearch->SearchOperator = @$filter["z_telp_dom_area"];
		$this->telp_dom_area->AdvancedSearch->SearchCondition = @$filter["v_telp_dom_area"];
		$this->telp_dom_area->AdvancedSearch->SearchValue2 = @$filter["y_telp_dom_area"];
		$this->telp_dom_area->AdvancedSearch->SearchOperator2 = @$filter["w_telp_dom_area"];
		$this->telp_dom_area->AdvancedSearch->Save();

		// Field email
		$this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
		$this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
		$this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
		$this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
		$this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
		$this->_email->AdvancedSearch->Save();

		// Field kd_st_emp
		$this->kd_st_emp->AdvancedSearch->SearchValue = @$filter["x_kd_st_emp"];
		$this->kd_st_emp->AdvancedSearch->SearchOperator = @$filter["z_kd_st_emp"];
		$this->kd_st_emp->AdvancedSearch->SearchCondition = @$filter["v_kd_st_emp"];
		$this->kd_st_emp->AdvancedSearch->SearchValue2 = @$filter["y_kd_st_emp"];
		$this->kd_st_emp->AdvancedSearch->SearchOperator2 = @$filter["w_kd_st_emp"];
		$this->kd_st_emp->AdvancedSearch->Save();

		// Field skala
		$this->skala->AdvancedSearch->SearchValue = @$filter["x_skala"];
		$this->skala->AdvancedSearch->SearchOperator = @$filter["z_skala"];
		$this->skala->AdvancedSearch->SearchCondition = @$filter["v_skala"];
		$this->skala->AdvancedSearch->SearchValue2 = @$filter["y_skala"];
		$this->skala->AdvancedSearch->SearchOperator2 = @$filter["w_skala"];
		$this->skala->AdvancedSearch->Save();

		// Field gp
		$this->gp->AdvancedSearch->SearchValue = @$filter["x_gp"];
		$this->gp->AdvancedSearch->SearchOperator = @$filter["z_gp"];
		$this->gp->AdvancedSearch->SearchCondition = @$filter["v_gp"];
		$this->gp->AdvancedSearch->SearchValue2 = @$filter["y_gp"];
		$this->gp->AdvancedSearch->SearchOperator2 = @$filter["w_gp"];
		$this->gp->AdvancedSearch->Save();

		// Field upah_tetap
		$this->upah_tetap->AdvancedSearch->SearchValue = @$filter["x_upah_tetap"];
		$this->upah_tetap->AdvancedSearch->SearchOperator = @$filter["z_upah_tetap"];
		$this->upah_tetap->AdvancedSearch->SearchCondition = @$filter["v_upah_tetap"];
		$this->upah_tetap->AdvancedSearch->SearchValue2 = @$filter["y_upah_tetap"];
		$this->upah_tetap->AdvancedSearch->SearchOperator2 = @$filter["w_upah_tetap"];
		$this->upah_tetap->AdvancedSearch->Save();

		// Field tgl_honor
		$this->tgl_honor->AdvancedSearch->SearchValue = @$filter["x_tgl_honor"];
		$this->tgl_honor->AdvancedSearch->SearchOperator = @$filter["z_tgl_honor"];
		$this->tgl_honor->AdvancedSearch->SearchCondition = @$filter["v_tgl_honor"];
		$this->tgl_honor->AdvancedSearch->SearchValue2 = @$filter["y_tgl_honor"];
		$this->tgl_honor->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_honor"];
		$this->tgl_honor->AdvancedSearch->Save();

		// Field honor
		$this->honor->AdvancedSearch->SearchValue = @$filter["x_honor"];
		$this->honor->AdvancedSearch->SearchOperator = @$filter["z_honor"];
		$this->honor->AdvancedSearch->SearchCondition = @$filter["v_honor"];
		$this->honor->AdvancedSearch->SearchValue2 = @$filter["y_honor"];
		$this->honor->AdvancedSearch->SearchOperator2 = @$filter["w_honor"];
		$this->honor->AdvancedSearch->Save();

		// Field premi_honor
		$this->premi_honor->AdvancedSearch->SearchValue = @$filter["x_premi_honor"];
		$this->premi_honor->AdvancedSearch->SearchOperator = @$filter["z_premi_honor"];
		$this->premi_honor->AdvancedSearch->SearchCondition = @$filter["v_premi_honor"];
		$this->premi_honor->AdvancedSearch->SearchValue2 = @$filter["y_premi_honor"];
		$this->premi_honor->AdvancedSearch->SearchOperator2 = @$filter["w_premi_honor"];
		$this->premi_honor->AdvancedSearch->Save();

		// Field tgl_gp
		$this->tgl_gp->AdvancedSearch->SearchValue = @$filter["x_tgl_gp"];
		$this->tgl_gp->AdvancedSearch->SearchOperator = @$filter["z_tgl_gp"];
		$this->tgl_gp->AdvancedSearch->SearchCondition = @$filter["v_tgl_gp"];
		$this->tgl_gp->AdvancedSearch->SearchValue2 = @$filter["y_tgl_gp"];
		$this->tgl_gp->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_gp"];
		$this->tgl_gp->AdvancedSearch->Save();

		// Field skala_95
		$this->skala_95->AdvancedSearch->SearchValue = @$filter["x_skala_95"];
		$this->skala_95->AdvancedSearch->SearchOperator = @$filter["z_skala_95"];
		$this->skala_95->AdvancedSearch->SearchCondition = @$filter["v_skala_95"];
		$this->skala_95->AdvancedSearch->SearchValue2 = @$filter["y_skala_95"];
		$this->skala_95->AdvancedSearch->SearchOperator2 = @$filter["w_skala_95"];
		$this->skala_95->AdvancedSearch->Save();

		// Field gp_95
		$this->gp_95->AdvancedSearch->SearchValue = @$filter["x_gp_95"];
		$this->gp_95->AdvancedSearch->SearchOperator = @$filter["z_gp_95"];
		$this->gp_95->AdvancedSearch->SearchCondition = @$filter["v_gp_95"];
		$this->gp_95->AdvancedSearch->SearchValue2 = @$filter["y_gp_95"];
		$this->gp_95->AdvancedSearch->SearchOperator2 = @$filter["w_gp_95"];
		$this->gp_95->AdvancedSearch->Save();

		// Field tgl_gp_95
		$this->tgl_gp_95->AdvancedSearch->SearchValue = @$filter["x_tgl_gp_95"];
		$this->tgl_gp_95->AdvancedSearch->SearchOperator = @$filter["z_tgl_gp_95"];
		$this->tgl_gp_95->AdvancedSearch->SearchCondition = @$filter["v_tgl_gp_95"];
		$this->tgl_gp_95->AdvancedSearch->SearchValue2 = @$filter["y_tgl_gp_95"];
		$this->tgl_gp_95->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_gp_95"];
		$this->tgl_gp_95->AdvancedSearch->Save();

		// Field kd_indx
		$this->kd_indx->AdvancedSearch->SearchValue = @$filter["x_kd_indx"];
		$this->kd_indx->AdvancedSearch->SearchOperator = @$filter["z_kd_indx"];
		$this->kd_indx->AdvancedSearch->SearchCondition = @$filter["v_kd_indx"];
		$this->kd_indx->AdvancedSearch->SearchValue2 = @$filter["y_kd_indx"];
		$this->kd_indx->AdvancedSearch->SearchOperator2 = @$filter["w_kd_indx"];
		$this->kd_indx->AdvancedSearch->Save();

		// Field indx_lok
		$this->indx_lok->AdvancedSearch->SearchValue = @$filter["x_indx_lok"];
		$this->indx_lok->AdvancedSearch->SearchOperator = @$filter["z_indx_lok"];
		$this->indx_lok->AdvancedSearch->SearchCondition = @$filter["v_indx_lok"];
		$this->indx_lok->AdvancedSearch->SearchValue2 = @$filter["y_indx_lok"];
		$this->indx_lok->AdvancedSearch->SearchOperator2 = @$filter["w_indx_lok"];
		$this->indx_lok->AdvancedSearch->Save();

		// Field gol_darah
		$this->gol_darah->AdvancedSearch->SearchValue = @$filter["x_gol_darah"];
		$this->gol_darah->AdvancedSearch->SearchOperator = @$filter["z_gol_darah"];
		$this->gol_darah->AdvancedSearch->SearchCondition = @$filter["v_gol_darah"];
		$this->gol_darah->AdvancedSearch->SearchValue2 = @$filter["y_gol_darah"];
		$this->gol_darah->AdvancedSearch->SearchOperator2 = @$filter["w_gol_darah"];
		$this->gol_darah->AdvancedSearch->Save();

		// Field kd_jbt
		$this->kd_jbt->AdvancedSearch->SearchValue = @$filter["x_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->SearchOperator = @$filter["z_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->SearchCondition = @$filter["v_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->SearchValue2 = @$filter["y_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->SearchOperator2 = @$filter["w_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->Save();

		// Field tgl_kd_jbt
		$this->tgl_kd_jbt->AdvancedSearch->SearchValue = @$filter["x_tgl_kd_jbt"];
		$this->tgl_kd_jbt->AdvancedSearch->SearchOperator = @$filter["z_tgl_kd_jbt"];
		$this->tgl_kd_jbt->AdvancedSearch->SearchCondition = @$filter["v_tgl_kd_jbt"];
		$this->tgl_kd_jbt->AdvancedSearch->SearchValue2 = @$filter["y_tgl_kd_jbt"];
		$this->tgl_kd_jbt->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_kd_jbt"];
		$this->tgl_kd_jbt->AdvancedSearch->Save();

		// Field kd_jbt_pgs
		$this->kd_jbt_pgs->AdvancedSearch->SearchValue = @$filter["x_kd_jbt_pgs"];
		$this->kd_jbt_pgs->AdvancedSearch->SearchOperator = @$filter["z_kd_jbt_pgs"];
		$this->kd_jbt_pgs->AdvancedSearch->SearchCondition = @$filter["v_kd_jbt_pgs"];
		$this->kd_jbt_pgs->AdvancedSearch->SearchValue2 = @$filter["y_kd_jbt_pgs"];
		$this->kd_jbt_pgs->AdvancedSearch->SearchOperator2 = @$filter["w_kd_jbt_pgs"];
		$this->kd_jbt_pgs->AdvancedSearch->Save();

		// Field tgl_kd_jbt_pgs
		$this->tgl_kd_jbt_pgs->AdvancedSearch->SearchValue = @$filter["x_tgl_kd_jbt_pgs"];
		$this->tgl_kd_jbt_pgs->AdvancedSearch->SearchOperator = @$filter["z_tgl_kd_jbt_pgs"];
		$this->tgl_kd_jbt_pgs->AdvancedSearch->SearchCondition = @$filter["v_tgl_kd_jbt_pgs"];
		$this->tgl_kd_jbt_pgs->AdvancedSearch->SearchValue2 = @$filter["y_tgl_kd_jbt_pgs"];
		$this->tgl_kd_jbt_pgs->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_kd_jbt_pgs"];
		$this->tgl_kd_jbt_pgs->AdvancedSearch->Save();

		// Field kd_jbt_pjs
		$this->kd_jbt_pjs->AdvancedSearch->SearchValue = @$filter["x_kd_jbt_pjs"];
		$this->kd_jbt_pjs->AdvancedSearch->SearchOperator = @$filter["z_kd_jbt_pjs"];
		$this->kd_jbt_pjs->AdvancedSearch->SearchCondition = @$filter["v_kd_jbt_pjs"];
		$this->kd_jbt_pjs->AdvancedSearch->SearchValue2 = @$filter["y_kd_jbt_pjs"];
		$this->kd_jbt_pjs->AdvancedSearch->SearchOperator2 = @$filter["w_kd_jbt_pjs"];
		$this->kd_jbt_pjs->AdvancedSearch->Save();

		// Field tgl_kd_jbt_pjs
		$this->tgl_kd_jbt_pjs->AdvancedSearch->SearchValue = @$filter["x_tgl_kd_jbt_pjs"];
		$this->tgl_kd_jbt_pjs->AdvancedSearch->SearchOperator = @$filter["z_tgl_kd_jbt_pjs"];
		$this->tgl_kd_jbt_pjs->AdvancedSearch->SearchCondition = @$filter["v_tgl_kd_jbt_pjs"];
		$this->tgl_kd_jbt_pjs->AdvancedSearch->SearchValue2 = @$filter["y_tgl_kd_jbt_pjs"];
		$this->tgl_kd_jbt_pjs->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_kd_jbt_pjs"];
		$this->tgl_kd_jbt_pjs->AdvancedSearch->Save();

		// Field kd_jbt_ps
		$this->kd_jbt_ps->AdvancedSearch->SearchValue = @$filter["x_kd_jbt_ps"];
		$this->kd_jbt_ps->AdvancedSearch->SearchOperator = @$filter["z_kd_jbt_ps"];
		$this->kd_jbt_ps->AdvancedSearch->SearchCondition = @$filter["v_kd_jbt_ps"];
		$this->kd_jbt_ps->AdvancedSearch->SearchValue2 = @$filter["y_kd_jbt_ps"];
		$this->kd_jbt_ps->AdvancedSearch->SearchOperator2 = @$filter["w_kd_jbt_ps"];
		$this->kd_jbt_ps->AdvancedSearch->Save();

		// Field tgl_kd_jbt_ps
		$this->tgl_kd_jbt_ps->AdvancedSearch->SearchValue = @$filter["x_tgl_kd_jbt_ps"];
		$this->tgl_kd_jbt_ps->AdvancedSearch->SearchOperator = @$filter["z_tgl_kd_jbt_ps"];
		$this->tgl_kd_jbt_ps->AdvancedSearch->SearchCondition = @$filter["v_tgl_kd_jbt_ps"];
		$this->tgl_kd_jbt_ps->AdvancedSearch->SearchValue2 = @$filter["y_tgl_kd_jbt_ps"];
		$this->tgl_kd_jbt_ps->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_kd_jbt_ps"];
		$this->tgl_kd_jbt_ps->AdvancedSearch->Save();

		// Field kd_pat
		$this->kd_pat->AdvancedSearch->SearchValue = @$filter["x_kd_pat"];
		$this->kd_pat->AdvancedSearch->SearchOperator = @$filter["z_kd_pat"];
		$this->kd_pat->AdvancedSearch->SearchCondition = @$filter["v_kd_pat"];
		$this->kd_pat->AdvancedSearch->SearchValue2 = @$filter["y_kd_pat"];
		$this->kd_pat->AdvancedSearch->SearchOperator2 = @$filter["w_kd_pat"];
		$this->kd_pat->AdvancedSearch->Save();

		// Field kd_gas
		$this->kd_gas->AdvancedSearch->SearchValue = @$filter["x_kd_gas"];
		$this->kd_gas->AdvancedSearch->SearchOperator = @$filter["z_kd_gas"];
		$this->kd_gas->AdvancedSearch->SearchCondition = @$filter["v_kd_gas"];
		$this->kd_gas->AdvancedSearch->SearchValue2 = @$filter["y_kd_gas"];
		$this->kd_gas->AdvancedSearch->SearchOperator2 = @$filter["w_kd_gas"];
		$this->kd_gas->AdvancedSearch->Save();

		// Field pimp_empid
		$this->pimp_empid->AdvancedSearch->SearchValue = @$filter["x_pimp_empid"];
		$this->pimp_empid->AdvancedSearch->SearchOperator = @$filter["z_pimp_empid"];
		$this->pimp_empid->AdvancedSearch->SearchCondition = @$filter["v_pimp_empid"];
		$this->pimp_empid->AdvancedSearch->SearchValue2 = @$filter["y_pimp_empid"];
		$this->pimp_empid->AdvancedSearch->SearchOperator2 = @$filter["w_pimp_empid"];
		$this->pimp_empid->AdvancedSearch->Save();

		// Field stshift
		$this->stshift->AdvancedSearch->SearchValue = @$filter["x_stshift"];
		$this->stshift->AdvancedSearch->SearchOperator = @$filter["z_stshift"];
		$this->stshift->AdvancedSearch->SearchCondition = @$filter["v_stshift"];
		$this->stshift->AdvancedSearch->SearchValue2 = @$filter["y_stshift"];
		$this->stshift->AdvancedSearch->SearchOperator2 = @$filter["w_stshift"];
		$this->stshift->AdvancedSearch->Save();

		// Field no_rek
		$this->no_rek->AdvancedSearch->SearchValue = @$filter["x_no_rek"];
		$this->no_rek->AdvancedSearch->SearchOperator = @$filter["z_no_rek"];
		$this->no_rek->AdvancedSearch->SearchCondition = @$filter["v_no_rek"];
		$this->no_rek->AdvancedSearch->SearchValue2 = @$filter["y_no_rek"];
		$this->no_rek->AdvancedSearch->SearchOperator2 = @$filter["w_no_rek"];
		$this->no_rek->AdvancedSearch->Save();

		// Field kd_bank
		$this->kd_bank->AdvancedSearch->SearchValue = @$filter["x_kd_bank"];
		$this->kd_bank->AdvancedSearch->SearchOperator = @$filter["z_kd_bank"];
		$this->kd_bank->AdvancedSearch->SearchCondition = @$filter["v_kd_bank"];
		$this->kd_bank->AdvancedSearch->SearchValue2 = @$filter["y_kd_bank"];
		$this->kd_bank->AdvancedSearch->SearchOperator2 = @$filter["w_kd_bank"];
		$this->kd_bank->AdvancedSearch->Save();

		// Field kd_jamsostek
		$this->kd_jamsostek->AdvancedSearch->SearchValue = @$filter["x_kd_jamsostek"];
		$this->kd_jamsostek->AdvancedSearch->SearchOperator = @$filter["z_kd_jamsostek"];
		$this->kd_jamsostek->AdvancedSearch->SearchCondition = @$filter["v_kd_jamsostek"];
		$this->kd_jamsostek->AdvancedSearch->SearchValue2 = @$filter["y_kd_jamsostek"];
		$this->kd_jamsostek->AdvancedSearch->SearchOperator2 = @$filter["w_kd_jamsostek"];
		$this->kd_jamsostek->AdvancedSearch->Save();

		// Field acc_astek
		$this->acc_astek->AdvancedSearch->SearchValue = @$filter["x_acc_astek"];
		$this->acc_astek->AdvancedSearch->SearchOperator = @$filter["z_acc_astek"];
		$this->acc_astek->AdvancedSearch->SearchCondition = @$filter["v_acc_astek"];
		$this->acc_astek->AdvancedSearch->SearchValue2 = @$filter["y_acc_astek"];
		$this->acc_astek->AdvancedSearch->SearchOperator2 = @$filter["w_acc_astek"];
		$this->acc_astek->AdvancedSearch->Save();

		// Field acc_dapens
		$this->acc_dapens->AdvancedSearch->SearchValue = @$filter["x_acc_dapens"];
		$this->acc_dapens->AdvancedSearch->SearchOperator = @$filter["z_acc_dapens"];
		$this->acc_dapens->AdvancedSearch->SearchCondition = @$filter["v_acc_dapens"];
		$this->acc_dapens->AdvancedSearch->SearchValue2 = @$filter["y_acc_dapens"];
		$this->acc_dapens->AdvancedSearch->SearchOperator2 = @$filter["w_acc_dapens"];
		$this->acc_dapens->AdvancedSearch->Save();

		// Field acc_kes
		$this->acc_kes->AdvancedSearch->SearchValue = @$filter["x_acc_kes"];
		$this->acc_kes->AdvancedSearch->SearchOperator = @$filter["z_acc_kes"];
		$this->acc_kes->AdvancedSearch->SearchCondition = @$filter["v_acc_kes"];
		$this->acc_kes->AdvancedSearch->SearchValue2 = @$filter["y_acc_kes"];
		$this->acc_kes->AdvancedSearch->SearchOperator2 = @$filter["w_acc_kes"];
		$this->acc_kes->AdvancedSearch->Save();

		// Field st
		$this->st->AdvancedSearch->SearchValue = @$filter["x_st"];
		$this->st->AdvancedSearch->SearchOperator = @$filter["z_st"];
		$this->st->AdvancedSearch->SearchCondition = @$filter["v_st"];
		$this->st->AdvancedSearch->SearchValue2 = @$filter["y_st"];
		$this->st->AdvancedSearch->SearchOperator2 = @$filter["w_st"];
		$this->st->AdvancedSearch->Save();

		// Field created_by
		$this->created_by->AdvancedSearch->SearchValue = @$filter["x_created_by"];
		$this->created_by->AdvancedSearch->SearchOperator = @$filter["z_created_by"];
		$this->created_by->AdvancedSearch->SearchCondition = @$filter["v_created_by"];
		$this->created_by->AdvancedSearch->SearchValue2 = @$filter["y_created_by"];
		$this->created_by->AdvancedSearch->SearchOperator2 = @$filter["w_created_by"];
		$this->created_by->AdvancedSearch->Save();

		// Field created_date
		$this->created_date->AdvancedSearch->SearchValue = @$filter["x_created_date"];
		$this->created_date->AdvancedSearch->SearchOperator = @$filter["z_created_date"];
		$this->created_date->AdvancedSearch->SearchCondition = @$filter["v_created_date"];
		$this->created_date->AdvancedSearch->SearchValue2 = @$filter["y_created_date"];
		$this->created_date->AdvancedSearch->SearchOperator2 = @$filter["w_created_date"];
		$this->created_date->AdvancedSearch->Save();

		// Field last_update_by
		$this->last_update_by->AdvancedSearch->SearchValue = @$filter["x_last_update_by"];
		$this->last_update_by->AdvancedSearch->SearchOperator = @$filter["z_last_update_by"];
		$this->last_update_by->AdvancedSearch->SearchCondition = @$filter["v_last_update_by"];
		$this->last_update_by->AdvancedSearch->SearchValue2 = @$filter["y_last_update_by"];
		$this->last_update_by->AdvancedSearch->SearchOperator2 = @$filter["w_last_update_by"];
		$this->last_update_by->AdvancedSearch->Save();

		// Field last_update_date
		$this->last_update_date->AdvancedSearch->SearchValue = @$filter["x_last_update_date"];
		$this->last_update_date->AdvancedSearch->SearchOperator = @$filter["z_last_update_date"];
		$this->last_update_date->AdvancedSearch->SearchCondition = @$filter["v_last_update_date"];
		$this->last_update_date->AdvancedSearch->SearchValue2 = @$filter["y_last_update_date"];
		$this->last_update_date->AdvancedSearch->SearchOperator2 = @$filter["w_last_update_date"];
		$this->last_update_date->AdvancedSearch->Save();

		// Field fgr_print_id
		$this->fgr_print_id->AdvancedSearch->SearchValue = @$filter["x_fgr_print_id"];
		$this->fgr_print_id->AdvancedSearch->SearchOperator = @$filter["z_fgr_print_id"];
		$this->fgr_print_id->AdvancedSearch->SearchCondition = @$filter["v_fgr_print_id"];
		$this->fgr_print_id->AdvancedSearch->SearchValue2 = @$filter["y_fgr_print_id"];
		$this->fgr_print_id->AdvancedSearch->SearchOperator2 = @$filter["w_fgr_print_id"];
		$this->fgr_print_id->AdvancedSearch->Save();

		// Field kd_jbt_eselon
		$this->kd_jbt_eselon->AdvancedSearch->SearchValue = @$filter["x_kd_jbt_eselon"];
		$this->kd_jbt_eselon->AdvancedSearch->SearchOperator = @$filter["z_kd_jbt_eselon"];
		$this->kd_jbt_eselon->AdvancedSearch->SearchCondition = @$filter["v_kd_jbt_eselon"];
		$this->kd_jbt_eselon->AdvancedSearch->SearchValue2 = @$filter["y_kd_jbt_eselon"];
		$this->kd_jbt_eselon->AdvancedSearch->SearchOperator2 = @$filter["w_kd_jbt_eselon"];
		$this->kd_jbt_eselon->AdvancedSearch->Save();

		// Field npwp
		$this->npwp->AdvancedSearch->SearchValue = @$filter["x_npwp"];
		$this->npwp->AdvancedSearch->SearchOperator = @$filter["z_npwp"];
		$this->npwp->AdvancedSearch->SearchCondition = @$filter["v_npwp"];
		$this->npwp->AdvancedSearch->SearchValue2 = @$filter["y_npwp"];
		$this->npwp->AdvancedSearch->SearchOperator2 = @$filter["w_npwp"];
		$this->npwp->AdvancedSearch->Save();

		// Field tgl_keluar
		$this->tgl_keluar->AdvancedSearch->SearchValue = @$filter["x_tgl_keluar"];
		$this->tgl_keluar->AdvancedSearch->SearchOperator = @$filter["z_tgl_keluar"];
		$this->tgl_keluar->AdvancedSearch->SearchCondition = @$filter["v_tgl_keluar"];
		$this->tgl_keluar->AdvancedSearch->SearchValue2 = @$filter["y_tgl_keluar"];
		$this->tgl_keluar->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_keluar"];
		$this->tgl_keluar->AdvancedSearch->Save();

		// Field nama_nasabah
		$this->nama_nasabah->AdvancedSearch->SearchValue = @$filter["x_nama_nasabah"];
		$this->nama_nasabah->AdvancedSearch->SearchOperator = @$filter["z_nama_nasabah"];
		$this->nama_nasabah->AdvancedSearch->SearchCondition = @$filter["v_nama_nasabah"];
		$this->nama_nasabah->AdvancedSearch->SearchValue2 = @$filter["y_nama_nasabah"];
		$this->nama_nasabah->AdvancedSearch->SearchOperator2 = @$filter["w_nama_nasabah"];
		$this->nama_nasabah->AdvancedSearch->Save();

		// Field no_ktp
		$this->no_ktp->AdvancedSearch->SearchValue = @$filter["x_no_ktp"];
		$this->no_ktp->AdvancedSearch->SearchOperator = @$filter["z_no_ktp"];
		$this->no_ktp->AdvancedSearch->SearchCondition = @$filter["v_no_ktp"];
		$this->no_ktp->AdvancedSearch->SearchValue2 = @$filter["y_no_ktp"];
		$this->no_ktp->AdvancedSearch->SearchOperator2 = @$filter["w_no_ktp"];
		$this->no_ktp->AdvancedSearch->Save();

		// Field no_kokar
		$this->no_kokar->AdvancedSearch->SearchValue = @$filter["x_no_kokar"];
		$this->no_kokar->AdvancedSearch->SearchOperator = @$filter["z_no_kokar"];
		$this->no_kokar->AdvancedSearch->SearchCondition = @$filter["v_no_kokar"];
		$this->no_kokar->AdvancedSearch->SearchValue2 = @$filter["y_no_kokar"];
		$this->no_kokar->AdvancedSearch->SearchOperator2 = @$filter["w_no_kokar"];
		$this->no_kokar->AdvancedSearch->Save();

		// Field no_bmw
		$this->no_bmw->AdvancedSearch->SearchValue = @$filter["x_no_bmw"];
		$this->no_bmw->AdvancedSearch->SearchOperator = @$filter["z_no_bmw"];
		$this->no_bmw->AdvancedSearch->SearchCondition = @$filter["v_no_bmw"];
		$this->no_bmw->AdvancedSearch->SearchValue2 = @$filter["y_no_bmw"];
		$this->no_bmw->AdvancedSearch->SearchOperator2 = @$filter["w_no_bmw"];
		$this->no_bmw->AdvancedSearch->Save();

		// Field no_bpjs_ketenagakerjaan
		$this->no_bpjs_ketenagakerjaan->AdvancedSearch->SearchValue = @$filter["x_no_bpjs_ketenagakerjaan"];
		$this->no_bpjs_ketenagakerjaan->AdvancedSearch->SearchOperator = @$filter["z_no_bpjs_ketenagakerjaan"];
		$this->no_bpjs_ketenagakerjaan->AdvancedSearch->SearchCondition = @$filter["v_no_bpjs_ketenagakerjaan"];
		$this->no_bpjs_ketenagakerjaan->AdvancedSearch->SearchValue2 = @$filter["y_no_bpjs_ketenagakerjaan"];
		$this->no_bpjs_ketenagakerjaan->AdvancedSearch->SearchOperator2 = @$filter["w_no_bpjs_ketenagakerjaan"];
		$this->no_bpjs_ketenagakerjaan->AdvancedSearch->Save();

		// Field no_bpjs_kesehatan
		$this->no_bpjs_kesehatan->AdvancedSearch->SearchValue = @$filter["x_no_bpjs_kesehatan"];
		$this->no_bpjs_kesehatan->AdvancedSearch->SearchOperator = @$filter["z_no_bpjs_kesehatan"];
		$this->no_bpjs_kesehatan->AdvancedSearch->SearchCondition = @$filter["v_no_bpjs_kesehatan"];
		$this->no_bpjs_kesehatan->AdvancedSearch->SearchValue2 = @$filter["y_no_bpjs_kesehatan"];
		$this->no_bpjs_kesehatan->AdvancedSearch->SearchOperator2 = @$filter["w_no_bpjs_kesehatan"];
		$this->no_bpjs_kesehatan->AdvancedSearch->Save();

		// Field eselon
		$this->eselon->AdvancedSearch->SearchValue = @$filter["x_eselon"];
		$this->eselon->AdvancedSearch->SearchOperator = @$filter["z_eselon"];
		$this->eselon->AdvancedSearch->SearchCondition = @$filter["v_eselon"];
		$this->eselon->AdvancedSearch->SearchValue2 = @$filter["y_eselon"];
		$this->eselon->AdvancedSearch->SearchOperator2 = @$filter["w_eselon"];
		$this->eselon->AdvancedSearch->Save();

		// Field kd_jenjang
		$this->kd_jenjang->AdvancedSearch->SearchValue = @$filter["x_kd_jenjang"];
		$this->kd_jenjang->AdvancedSearch->SearchOperator = @$filter["z_kd_jenjang"];
		$this->kd_jenjang->AdvancedSearch->SearchCondition = @$filter["v_kd_jenjang"];
		$this->kd_jenjang->AdvancedSearch->SearchValue2 = @$filter["y_kd_jenjang"];
		$this->kd_jenjang->AdvancedSearch->SearchOperator2 = @$filter["w_kd_jenjang"];
		$this->kd_jenjang->AdvancedSearch->Save();

		// Field kd_jbt_esl
		$this->kd_jbt_esl->AdvancedSearch->SearchValue = @$filter["x_kd_jbt_esl"];
		$this->kd_jbt_esl->AdvancedSearch->SearchOperator = @$filter["z_kd_jbt_esl"];
		$this->kd_jbt_esl->AdvancedSearch->SearchCondition = @$filter["v_kd_jbt_esl"];
		$this->kd_jbt_esl->AdvancedSearch->SearchValue2 = @$filter["y_kd_jbt_esl"];
		$this->kd_jbt_esl->AdvancedSearch->SearchOperator2 = @$filter["w_kd_jbt_esl"];
		$this->kd_jbt_esl->AdvancedSearch->Save();

		// Field tgl_jbt_esl
		$this->tgl_jbt_esl->AdvancedSearch->SearchValue = @$filter["x_tgl_jbt_esl"];
		$this->tgl_jbt_esl->AdvancedSearch->SearchOperator = @$filter["z_tgl_jbt_esl"];
		$this->tgl_jbt_esl->AdvancedSearch->SearchCondition = @$filter["v_tgl_jbt_esl"];
		$this->tgl_jbt_esl->AdvancedSearch->SearchValue2 = @$filter["y_tgl_jbt_esl"];
		$this->tgl_jbt_esl->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_jbt_esl"];
		$this->tgl_jbt_esl->AdvancedSearch->Save();

		// Field org_id
		$this->org_id->AdvancedSearch->SearchValue = @$filter["x_org_id"];
		$this->org_id->AdvancedSearch->SearchOperator = @$filter["z_org_id"];
		$this->org_id->AdvancedSearch->SearchCondition = @$filter["v_org_id"];
		$this->org_id->AdvancedSearch->SearchValue2 = @$filter["y_org_id"];
		$this->org_id->AdvancedSearch->SearchOperator2 = @$filter["w_org_id"];
		$this->org_id->AdvancedSearch->Save();

		// Field kd_payroll
		$this->kd_payroll->AdvancedSearch->SearchValue = @$filter["x_kd_payroll"];
		$this->kd_payroll->AdvancedSearch->SearchOperator = @$filter["z_kd_payroll"];
		$this->kd_payroll->AdvancedSearch->SearchCondition = @$filter["v_kd_payroll"];
		$this->kd_payroll->AdvancedSearch->SearchValue2 = @$filter["y_kd_payroll"];
		$this->kd_payroll->AdvancedSearch->SearchOperator2 = @$filter["w_kd_payroll"];
		$this->kd_payroll->AdvancedSearch->Save();

		// Field id_wn
		$this->id_wn->AdvancedSearch->SearchValue = @$filter["x_id_wn"];
		$this->id_wn->AdvancedSearch->SearchOperator = @$filter["z_id_wn"];
		$this->id_wn->AdvancedSearch->SearchCondition = @$filter["v_id_wn"];
		$this->id_wn->AdvancedSearch->SearchValue2 = @$filter["y_id_wn"];
		$this->id_wn->AdvancedSearch->SearchOperator2 = @$filter["w_id_wn"];
		$this->id_wn->AdvancedSearch->Save();

		// Field no_anggota_kkms
		$this->no_anggota_kkms->AdvancedSearch->SearchValue = @$filter["x_no_anggota_kkms"];
		$this->no_anggota_kkms->AdvancedSearch->SearchOperator = @$filter["z_no_anggota_kkms"];
		$this->no_anggota_kkms->AdvancedSearch->SearchCondition = @$filter["v_no_anggota_kkms"];
		$this->no_anggota_kkms->AdvancedSearch->SearchValue2 = @$filter["y_no_anggota_kkms"];
		$this->no_anggota_kkms->AdvancedSearch->SearchOperator2 = @$filter["w_no_anggota_kkms"];
		$this->no_anggota_kkms->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->employee_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->first_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->last_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->first_title, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->last_title, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->init, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->tpt_lahir, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jk, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_agama, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->tpt_masuk, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->stkel, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->alamat, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kota, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_pos, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_propinsi, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->telp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->telp_area, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->hp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->alamat_dom, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kota_dom, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_pos_dom, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_propinsi_dom, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->telp_dom, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->telp_dom_area, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->_email, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_st_emp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->skala, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->skala_95, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_indx, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->gol_darah, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_jbt, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_jbt_pgs, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_jbt_pjs, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_jbt_ps, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_pat, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_gas, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pimp_empid, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->stshift, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->no_rek, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_bank, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_jamsostek, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->acc_astek, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->acc_dapens, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->acc_kes, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->st, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->created_by, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->last_update_by, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_jbt_eselon, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->npwp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_nasabah, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->no_ktp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->no_kokar, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->no_bmw, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->no_bpjs_ketenagakerjaan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->no_bpjs_kesehatan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eselon, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_jenjang, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_jbt_esl, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->org_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_payroll, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->id_wn, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->no_anggota_kkms, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->employee_id); // employee_id
			$this->UpdateSort($this->first_name); // first_name
			$this->UpdateSort($this->last_name); // last_name
			$this->UpdateSort($this->first_title); // first_title
			$this->UpdateSort($this->last_title); // last_title
			$this->UpdateSort($this->init); // init
			$this->UpdateSort($this->tpt_lahir); // tpt_lahir
			$this->UpdateSort($this->tgl_lahir); // tgl_lahir
			$this->UpdateSort($this->jk); // jk
			$this->UpdateSort($this->kd_agama); // kd_agama
			$this->UpdateSort($this->tgl_masuk); // tgl_masuk
			$this->UpdateSort($this->tpt_masuk); // tpt_masuk
			$this->UpdateSort($this->stkel); // stkel
			$this->UpdateSort($this->alamat); // alamat
			$this->UpdateSort($this->kota); // kota
			$this->UpdateSort($this->kd_pos); // kd_pos
			$this->UpdateSort($this->kd_propinsi); // kd_propinsi
			$this->UpdateSort($this->telp); // telp
			$this->UpdateSort($this->telp_area); // telp_area
			$this->UpdateSort($this->hp); // hp
			$this->UpdateSort($this->alamat_dom); // alamat_dom
			$this->UpdateSort($this->kota_dom); // kota_dom
			$this->UpdateSort($this->kd_pos_dom); // kd_pos_dom
			$this->UpdateSort($this->kd_propinsi_dom); // kd_propinsi_dom
			$this->UpdateSort($this->telp_dom); // telp_dom
			$this->UpdateSort($this->telp_dom_area); // telp_dom_area
			$this->UpdateSort($this->_email); // email
			$this->UpdateSort($this->kd_st_emp); // kd_st_emp
			$this->UpdateSort($this->skala); // skala
			$this->UpdateSort($this->gp); // gp
			$this->UpdateSort($this->upah_tetap); // upah_tetap
			$this->UpdateSort($this->tgl_honor); // tgl_honor
			$this->UpdateSort($this->honor); // honor
			$this->UpdateSort($this->premi_honor); // premi_honor
			$this->UpdateSort($this->tgl_gp); // tgl_gp
			$this->UpdateSort($this->skala_95); // skala_95
			$this->UpdateSort($this->gp_95); // gp_95
			$this->UpdateSort($this->tgl_gp_95); // tgl_gp_95
			$this->UpdateSort($this->kd_indx); // kd_indx
			$this->UpdateSort($this->indx_lok); // indx_lok
			$this->UpdateSort($this->gol_darah); // gol_darah
			$this->UpdateSort($this->kd_jbt); // kd_jbt
			$this->UpdateSort($this->tgl_kd_jbt); // tgl_kd_jbt
			$this->UpdateSort($this->kd_jbt_pgs); // kd_jbt_pgs
			$this->UpdateSort($this->tgl_kd_jbt_pgs); // tgl_kd_jbt_pgs
			$this->UpdateSort($this->kd_jbt_pjs); // kd_jbt_pjs
			$this->UpdateSort($this->tgl_kd_jbt_pjs); // tgl_kd_jbt_pjs
			$this->UpdateSort($this->kd_jbt_ps); // kd_jbt_ps
			$this->UpdateSort($this->tgl_kd_jbt_ps); // tgl_kd_jbt_ps
			$this->UpdateSort($this->kd_pat); // kd_pat
			$this->UpdateSort($this->kd_gas); // kd_gas
			$this->UpdateSort($this->pimp_empid); // pimp_empid
			$this->UpdateSort($this->stshift); // stshift
			$this->UpdateSort($this->no_rek); // no_rek
			$this->UpdateSort($this->kd_bank); // kd_bank
			$this->UpdateSort($this->kd_jamsostek); // kd_jamsostek
			$this->UpdateSort($this->acc_astek); // acc_astek
			$this->UpdateSort($this->acc_dapens); // acc_dapens
			$this->UpdateSort($this->acc_kes); // acc_kes
			$this->UpdateSort($this->st); // st
			$this->UpdateSort($this->created_by); // created_by
			$this->UpdateSort($this->created_date); // created_date
			$this->UpdateSort($this->last_update_by); // last_update_by
			$this->UpdateSort($this->last_update_date); // last_update_date
			$this->UpdateSort($this->fgr_print_id); // fgr_print_id
			$this->UpdateSort($this->kd_jbt_eselon); // kd_jbt_eselon
			$this->UpdateSort($this->npwp); // npwp
			$this->UpdateSort($this->tgl_keluar); // tgl_keluar
			$this->UpdateSort($this->nama_nasabah); // nama_nasabah
			$this->UpdateSort($this->no_ktp); // no_ktp
			$this->UpdateSort($this->no_kokar); // no_kokar
			$this->UpdateSort($this->no_bmw); // no_bmw
			$this->UpdateSort($this->no_bpjs_ketenagakerjaan); // no_bpjs_ketenagakerjaan
			$this->UpdateSort($this->no_bpjs_kesehatan); // no_bpjs_kesehatan
			$this->UpdateSort($this->eselon); // eselon
			$this->UpdateSort($this->kd_jenjang); // kd_jenjang
			$this->UpdateSort($this->kd_jbt_esl); // kd_jbt_esl
			$this->UpdateSort($this->tgl_jbt_esl); // tgl_jbt_esl
			$this->UpdateSort($this->org_id); // org_id
			$this->UpdateSort($this->kd_payroll); // kd_payroll
			$this->UpdateSort($this->id_wn); // id_wn
			$this->UpdateSort($this->no_anggota_kkms); // no_anggota_kkms
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->employee_id->setSort("");
				$this->first_name->setSort("");
				$this->last_name->setSort("");
				$this->first_title->setSort("");
				$this->last_title->setSort("");
				$this->init->setSort("");
				$this->tpt_lahir->setSort("");
				$this->tgl_lahir->setSort("");
				$this->jk->setSort("");
				$this->kd_agama->setSort("");
				$this->tgl_masuk->setSort("");
				$this->tpt_masuk->setSort("");
				$this->stkel->setSort("");
				$this->alamat->setSort("");
				$this->kota->setSort("");
				$this->kd_pos->setSort("");
				$this->kd_propinsi->setSort("");
				$this->telp->setSort("");
				$this->telp_area->setSort("");
				$this->hp->setSort("");
				$this->alamat_dom->setSort("");
				$this->kota_dom->setSort("");
				$this->kd_pos_dom->setSort("");
				$this->kd_propinsi_dom->setSort("");
				$this->telp_dom->setSort("");
				$this->telp_dom_area->setSort("");
				$this->_email->setSort("");
				$this->kd_st_emp->setSort("");
				$this->skala->setSort("");
				$this->gp->setSort("");
				$this->upah_tetap->setSort("");
				$this->tgl_honor->setSort("");
				$this->honor->setSort("");
				$this->premi_honor->setSort("");
				$this->tgl_gp->setSort("");
				$this->skala_95->setSort("");
				$this->gp_95->setSort("");
				$this->tgl_gp_95->setSort("");
				$this->kd_indx->setSort("");
				$this->indx_lok->setSort("");
				$this->gol_darah->setSort("");
				$this->kd_jbt->setSort("");
				$this->tgl_kd_jbt->setSort("");
				$this->kd_jbt_pgs->setSort("");
				$this->tgl_kd_jbt_pgs->setSort("");
				$this->kd_jbt_pjs->setSort("");
				$this->tgl_kd_jbt_pjs->setSort("");
				$this->kd_jbt_ps->setSort("");
				$this->tgl_kd_jbt_ps->setSort("");
				$this->kd_pat->setSort("");
				$this->kd_gas->setSort("");
				$this->pimp_empid->setSort("");
				$this->stshift->setSort("");
				$this->no_rek->setSort("");
				$this->kd_bank->setSort("");
				$this->kd_jamsostek->setSort("");
				$this->acc_astek->setSort("");
				$this->acc_dapens->setSort("");
				$this->acc_kes->setSort("");
				$this->st->setSort("");
				$this->created_by->setSort("");
				$this->created_date->setSort("");
				$this->last_update_by->setSort("");
				$this->last_update_date->setSort("");
				$this->fgr_print_id->setSort("");
				$this->kd_jbt_eselon->setSort("");
				$this->npwp->setSort("");
				$this->tgl_keluar->setSort("");
				$this->nama_nasabah->setSort("");
				$this->no_ktp->setSort("");
				$this->no_kokar->setSort("");
				$this->no_bmw->setSort("");
				$this->no_bpjs_ketenagakerjaan->setSort("");
				$this->no_bpjs_kesehatan->setSort("");
				$this->eselon->setSort("");
				$this->kd_jenjang->setSort("");
				$this->kd_jbt_esl->setSort("");
				$this->tgl_jbt_esl->setSort("");
				$this->org_id->setSort("");
				$this->kd_payroll->setSort("");
				$this->id_wn->setSort("");
				$this->no_anggota_kkms->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if (TRUE)
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->employee_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "");
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fpersonallistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fpersonallistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fpersonallist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fpersonallistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
	}

	function SetupListOptionsExt() {
		global $Security, $Language;

		// Hide detail items for dropdown if necessary
		$this->ListOptions->HideDetailItemsForDropDown();
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($personal_list)) $personal_list = new cpersonal_list();

// Page init
$personal_list->Page_Init();

// Page main
$personal_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$personal_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fpersonallist = new ew_Form("fpersonallist", "list");
fpersonallist.FormKeyCountName = '<?php echo $personal_list->FormKeyCountName ?>';

// Form_CustomValidate event
fpersonallist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fpersonallist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fpersonallistsrch = new ew_Form("fpersonallistsrch");
</script>
<style type="text/css">
.ewTablePreviewRow { /* main table preview row color */
	background-color: #FFFFFF; /* preview row color */
}
.ewTablePreviewRow .ewGrid {
	display: table;
}
</style>
<div id="ewPreview" class="hide"><!-- preview -->
	<div class="nav-tabs-custom"><!-- .nav-tabs-custom -->
		<ul class="nav nav-tabs"></ul>
		<div class="tab-content"><!-- .tab-content -->
			<div class="tab-pane fade"></div>
		</div><!-- /.tab-content -->
	</div><!-- /.nav-tabs-custom -->
</div><!-- /preview -->
<script type="text/javascript" src="phpjs/ewpreview.js"></script>
<script type="text/javascript">
var EW_PREVIEW_PLACEMENT = EW_CSS_FLIP ? "right" : "left";
var EW_PREVIEW_SINGLE_ROW = false;
var EW_PREVIEW_OVERLAY = false;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($personal_list->TotalRecs > 0 && $personal_list->ExportOptions->Visible()) { ?>
<?php $personal_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($personal_list->SearchOptions->Visible()) { ?>
<?php $personal_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($personal_list->FilterOptions->Visible()) { ?>
<?php $personal_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $personal_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($personal_list->TotalRecs <= 0)
			$personal_list->TotalRecs = $personal->ListRecordCount();
	} else {
		if (!$personal_list->Recordset && ($personal_list->Recordset = $personal_list->LoadRecordset()))
			$personal_list->TotalRecs = $personal_list->Recordset->RecordCount();
	}
	$personal_list->StartRec = 1;
	if ($personal_list->DisplayRecs <= 0 || ($personal->Export <> "" && $personal->ExportAll)) // Display all records
		$personal_list->DisplayRecs = $personal_list->TotalRecs;
	if (!($personal->Export <> "" && $personal->ExportAll))
		$personal_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$personal_list->Recordset = $personal_list->LoadRecordset($personal_list->StartRec-1, $personal_list->DisplayRecs);

	// Set no record found message
	if ($personal->CurrentAction == "" && $personal_list->TotalRecs == 0) {
		if ($personal_list->SearchWhere == "0=101")
			$personal_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$personal_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$personal_list->RenderOtherOptions();
?>
<?php if ($personal->Export == "" && $personal->CurrentAction == "") { ?>
<form name="fpersonallistsrch" id="fpersonallistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($personal_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fpersonallistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="personal">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($personal_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($personal_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $personal_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($personal_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($personal_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($personal_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($personal_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $personal_list->ShowPageHeader(); ?>
<?php
$personal_list->ShowMessage();
?>
<?php if ($personal_list->TotalRecs > 0 || $personal->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($personal_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> personal">
<form name="fpersonallist" id="fpersonallist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($personal_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $personal_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="personal">
<div id="gmp_personal" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($personal_list->TotalRecs > 0 || $personal->CurrentAction == "gridedit") { ?>
<table id="tbl_personallist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$personal_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$personal_list->RenderListOptions();

// Render list options (header, left)
$personal_list->ListOptions->Render("header", "left");
?>
<?php if ($personal->employee_id->Visible) { // employee_id ?>
	<?php if ($personal->SortUrl($personal->employee_id) == "") { ?>
		<th data-name="employee_id" class="<?php echo $personal->employee_id->HeaderCellClass() ?>"><div id="elh_personal_employee_id" class="personal_employee_id"><div class="ewTableHeaderCaption"><?php echo $personal->employee_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="employee_id" class="<?php echo $personal->employee_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->employee_id) ?>',1);"><div id="elh_personal_employee_id" class="personal_employee_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->employee_id->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->employee_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->employee_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->first_name->Visible) { // first_name ?>
	<?php if ($personal->SortUrl($personal->first_name) == "") { ?>
		<th data-name="first_name" class="<?php echo $personal->first_name->HeaderCellClass() ?>"><div id="elh_personal_first_name" class="personal_first_name"><div class="ewTableHeaderCaption"><?php echo $personal->first_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="first_name" class="<?php echo $personal->first_name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->first_name) ?>',1);"><div id="elh_personal_first_name" class="personal_first_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->first_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->first_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->first_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->last_name->Visible) { // last_name ?>
	<?php if ($personal->SortUrl($personal->last_name) == "") { ?>
		<th data-name="last_name" class="<?php echo $personal->last_name->HeaderCellClass() ?>"><div id="elh_personal_last_name" class="personal_last_name"><div class="ewTableHeaderCaption"><?php echo $personal->last_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="last_name" class="<?php echo $personal->last_name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->last_name) ?>',1);"><div id="elh_personal_last_name" class="personal_last_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->last_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->last_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->last_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->first_title->Visible) { // first_title ?>
	<?php if ($personal->SortUrl($personal->first_title) == "") { ?>
		<th data-name="first_title" class="<?php echo $personal->first_title->HeaderCellClass() ?>"><div id="elh_personal_first_title" class="personal_first_title"><div class="ewTableHeaderCaption"><?php echo $personal->first_title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="first_title" class="<?php echo $personal->first_title->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->first_title) ?>',1);"><div id="elh_personal_first_title" class="personal_first_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->first_title->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->first_title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->first_title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->last_title->Visible) { // last_title ?>
	<?php if ($personal->SortUrl($personal->last_title) == "") { ?>
		<th data-name="last_title" class="<?php echo $personal->last_title->HeaderCellClass() ?>"><div id="elh_personal_last_title" class="personal_last_title"><div class="ewTableHeaderCaption"><?php echo $personal->last_title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="last_title" class="<?php echo $personal->last_title->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->last_title) ?>',1);"><div id="elh_personal_last_title" class="personal_last_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->last_title->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->last_title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->last_title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->init->Visible) { // init ?>
	<?php if ($personal->SortUrl($personal->init) == "") { ?>
		<th data-name="init" class="<?php echo $personal->init->HeaderCellClass() ?>"><div id="elh_personal_init" class="personal_init"><div class="ewTableHeaderCaption"><?php echo $personal->init->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="init" class="<?php echo $personal->init->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->init) ?>',1);"><div id="elh_personal_init" class="personal_init">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->init->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->init->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->init->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->tpt_lahir->Visible) { // tpt_lahir ?>
	<?php if ($personal->SortUrl($personal->tpt_lahir) == "") { ?>
		<th data-name="tpt_lahir" class="<?php echo $personal->tpt_lahir->HeaderCellClass() ?>"><div id="elh_personal_tpt_lahir" class="personal_tpt_lahir"><div class="ewTableHeaderCaption"><?php echo $personal->tpt_lahir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tpt_lahir" class="<?php echo $personal->tpt_lahir->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->tpt_lahir) ?>',1);"><div id="elh_personal_tpt_lahir" class="personal_tpt_lahir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->tpt_lahir->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->tpt_lahir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->tpt_lahir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->tgl_lahir->Visible) { // tgl_lahir ?>
	<?php if ($personal->SortUrl($personal->tgl_lahir) == "") { ?>
		<th data-name="tgl_lahir" class="<?php echo $personal->tgl_lahir->HeaderCellClass() ?>"><div id="elh_personal_tgl_lahir" class="personal_tgl_lahir"><div class="ewTableHeaderCaption"><?php echo $personal->tgl_lahir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_lahir" class="<?php echo $personal->tgl_lahir->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->tgl_lahir) ?>',1);"><div id="elh_personal_tgl_lahir" class="personal_tgl_lahir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->tgl_lahir->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->tgl_lahir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->tgl_lahir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->jk->Visible) { // jk ?>
	<?php if ($personal->SortUrl($personal->jk) == "") { ?>
		<th data-name="jk" class="<?php echo $personal->jk->HeaderCellClass() ?>"><div id="elh_personal_jk" class="personal_jk"><div class="ewTableHeaderCaption"><?php echo $personal->jk->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jk" class="<?php echo $personal->jk->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->jk) ?>',1);"><div id="elh_personal_jk" class="personal_jk">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->jk->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->jk->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->jk->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_agama->Visible) { // kd_agama ?>
	<?php if ($personal->SortUrl($personal->kd_agama) == "") { ?>
		<th data-name="kd_agama" class="<?php echo $personal->kd_agama->HeaderCellClass() ?>"><div id="elh_personal_kd_agama" class="personal_kd_agama"><div class="ewTableHeaderCaption"><?php echo $personal->kd_agama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_agama" class="<?php echo $personal->kd_agama->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_agama) ?>',1);"><div id="elh_personal_kd_agama" class="personal_kd_agama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_agama->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_agama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_agama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->tgl_masuk->Visible) { // tgl_masuk ?>
	<?php if ($personal->SortUrl($personal->tgl_masuk) == "") { ?>
		<th data-name="tgl_masuk" class="<?php echo $personal->tgl_masuk->HeaderCellClass() ?>"><div id="elh_personal_tgl_masuk" class="personal_tgl_masuk"><div class="ewTableHeaderCaption"><?php echo $personal->tgl_masuk->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_masuk" class="<?php echo $personal->tgl_masuk->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->tgl_masuk) ?>',1);"><div id="elh_personal_tgl_masuk" class="personal_tgl_masuk">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->tgl_masuk->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->tgl_masuk->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->tgl_masuk->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->tpt_masuk->Visible) { // tpt_masuk ?>
	<?php if ($personal->SortUrl($personal->tpt_masuk) == "") { ?>
		<th data-name="tpt_masuk" class="<?php echo $personal->tpt_masuk->HeaderCellClass() ?>"><div id="elh_personal_tpt_masuk" class="personal_tpt_masuk"><div class="ewTableHeaderCaption"><?php echo $personal->tpt_masuk->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tpt_masuk" class="<?php echo $personal->tpt_masuk->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->tpt_masuk) ?>',1);"><div id="elh_personal_tpt_masuk" class="personal_tpt_masuk">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->tpt_masuk->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->tpt_masuk->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->tpt_masuk->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->stkel->Visible) { // stkel ?>
	<?php if ($personal->SortUrl($personal->stkel) == "") { ?>
		<th data-name="stkel" class="<?php echo $personal->stkel->HeaderCellClass() ?>"><div id="elh_personal_stkel" class="personal_stkel"><div class="ewTableHeaderCaption"><?php echo $personal->stkel->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="stkel" class="<?php echo $personal->stkel->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->stkel) ?>',1);"><div id="elh_personal_stkel" class="personal_stkel">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->stkel->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->stkel->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->stkel->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->alamat->Visible) { // alamat ?>
	<?php if ($personal->SortUrl($personal->alamat) == "") { ?>
		<th data-name="alamat" class="<?php echo $personal->alamat->HeaderCellClass() ?>"><div id="elh_personal_alamat" class="personal_alamat"><div class="ewTableHeaderCaption"><?php echo $personal->alamat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="alamat" class="<?php echo $personal->alamat->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->alamat) ?>',1);"><div id="elh_personal_alamat" class="personal_alamat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->alamat->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->alamat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->alamat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kota->Visible) { // kota ?>
	<?php if ($personal->SortUrl($personal->kota) == "") { ?>
		<th data-name="kota" class="<?php echo $personal->kota->HeaderCellClass() ?>"><div id="elh_personal_kota" class="personal_kota"><div class="ewTableHeaderCaption"><?php echo $personal->kota->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kota" class="<?php echo $personal->kota->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kota) ?>',1);"><div id="elh_personal_kota" class="personal_kota">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kota->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kota->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kota->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_pos->Visible) { // kd_pos ?>
	<?php if ($personal->SortUrl($personal->kd_pos) == "") { ?>
		<th data-name="kd_pos" class="<?php echo $personal->kd_pos->HeaderCellClass() ?>"><div id="elh_personal_kd_pos" class="personal_kd_pos"><div class="ewTableHeaderCaption"><?php echo $personal->kd_pos->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_pos" class="<?php echo $personal->kd_pos->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_pos) ?>',1);"><div id="elh_personal_kd_pos" class="personal_kd_pos">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_pos->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_pos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_pos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_propinsi->Visible) { // kd_propinsi ?>
	<?php if ($personal->SortUrl($personal->kd_propinsi) == "") { ?>
		<th data-name="kd_propinsi" class="<?php echo $personal->kd_propinsi->HeaderCellClass() ?>"><div id="elh_personal_kd_propinsi" class="personal_kd_propinsi"><div class="ewTableHeaderCaption"><?php echo $personal->kd_propinsi->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_propinsi" class="<?php echo $personal->kd_propinsi->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_propinsi) ?>',1);"><div id="elh_personal_kd_propinsi" class="personal_kd_propinsi">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_propinsi->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_propinsi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_propinsi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->telp->Visible) { // telp ?>
	<?php if ($personal->SortUrl($personal->telp) == "") { ?>
		<th data-name="telp" class="<?php echo $personal->telp->HeaderCellClass() ?>"><div id="elh_personal_telp" class="personal_telp"><div class="ewTableHeaderCaption"><?php echo $personal->telp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="telp" class="<?php echo $personal->telp->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->telp) ?>',1);"><div id="elh_personal_telp" class="personal_telp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->telp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->telp->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->telp->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->telp_area->Visible) { // telp_area ?>
	<?php if ($personal->SortUrl($personal->telp_area) == "") { ?>
		<th data-name="telp_area" class="<?php echo $personal->telp_area->HeaderCellClass() ?>"><div id="elh_personal_telp_area" class="personal_telp_area"><div class="ewTableHeaderCaption"><?php echo $personal->telp_area->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="telp_area" class="<?php echo $personal->telp_area->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->telp_area) ?>',1);"><div id="elh_personal_telp_area" class="personal_telp_area">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->telp_area->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->telp_area->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->telp_area->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->hp->Visible) { // hp ?>
	<?php if ($personal->SortUrl($personal->hp) == "") { ?>
		<th data-name="hp" class="<?php echo $personal->hp->HeaderCellClass() ?>"><div id="elh_personal_hp" class="personal_hp"><div class="ewTableHeaderCaption"><?php echo $personal->hp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hp" class="<?php echo $personal->hp->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->hp) ?>',1);"><div id="elh_personal_hp" class="personal_hp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->hp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->hp->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->hp->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->alamat_dom->Visible) { // alamat_dom ?>
	<?php if ($personal->SortUrl($personal->alamat_dom) == "") { ?>
		<th data-name="alamat_dom" class="<?php echo $personal->alamat_dom->HeaderCellClass() ?>"><div id="elh_personal_alamat_dom" class="personal_alamat_dom"><div class="ewTableHeaderCaption"><?php echo $personal->alamat_dom->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="alamat_dom" class="<?php echo $personal->alamat_dom->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->alamat_dom) ?>',1);"><div id="elh_personal_alamat_dom" class="personal_alamat_dom">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->alamat_dom->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->alamat_dom->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->alamat_dom->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kota_dom->Visible) { // kota_dom ?>
	<?php if ($personal->SortUrl($personal->kota_dom) == "") { ?>
		<th data-name="kota_dom" class="<?php echo $personal->kota_dom->HeaderCellClass() ?>"><div id="elh_personal_kota_dom" class="personal_kota_dom"><div class="ewTableHeaderCaption"><?php echo $personal->kota_dom->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kota_dom" class="<?php echo $personal->kota_dom->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kota_dom) ?>',1);"><div id="elh_personal_kota_dom" class="personal_kota_dom">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kota_dom->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kota_dom->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kota_dom->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_pos_dom->Visible) { // kd_pos_dom ?>
	<?php if ($personal->SortUrl($personal->kd_pos_dom) == "") { ?>
		<th data-name="kd_pos_dom" class="<?php echo $personal->kd_pos_dom->HeaderCellClass() ?>"><div id="elh_personal_kd_pos_dom" class="personal_kd_pos_dom"><div class="ewTableHeaderCaption"><?php echo $personal->kd_pos_dom->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_pos_dom" class="<?php echo $personal->kd_pos_dom->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_pos_dom) ?>',1);"><div id="elh_personal_kd_pos_dom" class="personal_kd_pos_dom">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_pos_dom->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_pos_dom->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_pos_dom->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_propinsi_dom->Visible) { // kd_propinsi_dom ?>
	<?php if ($personal->SortUrl($personal->kd_propinsi_dom) == "") { ?>
		<th data-name="kd_propinsi_dom" class="<?php echo $personal->kd_propinsi_dom->HeaderCellClass() ?>"><div id="elh_personal_kd_propinsi_dom" class="personal_kd_propinsi_dom"><div class="ewTableHeaderCaption"><?php echo $personal->kd_propinsi_dom->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_propinsi_dom" class="<?php echo $personal->kd_propinsi_dom->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_propinsi_dom) ?>',1);"><div id="elh_personal_kd_propinsi_dom" class="personal_kd_propinsi_dom">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_propinsi_dom->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_propinsi_dom->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_propinsi_dom->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->telp_dom->Visible) { // telp_dom ?>
	<?php if ($personal->SortUrl($personal->telp_dom) == "") { ?>
		<th data-name="telp_dom" class="<?php echo $personal->telp_dom->HeaderCellClass() ?>"><div id="elh_personal_telp_dom" class="personal_telp_dom"><div class="ewTableHeaderCaption"><?php echo $personal->telp_dom->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="telp_dom" class="<?php echo $personal->telp_dom->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->telp_dom) ?>',1);"><div id="elh_personal_telp_dom" class="personal_telp_dom">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->telp_dom->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->telp_dom->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->telp_dom->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->telp_dom_area->Visible) { // telp_dom_area ?>
	<?php if ($personal->SortUrl($personal->telp_dom_area) == "") { ?>
		<th data-name="telp_dom_area" class="<?php echo $personal->telp_dom_area->HeaderCellClass() ?>"><div id="elh_personal_telp_dom_area" class="personal_telp_dom_area"><div class="ewTableHeaderCaption"><?php echo $personal->telp_dom_area->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="telp_dom_area" class="<?php echo $personal->telp_dom_area->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->telp_dom_area) ?>',1);"><div id="elh_personal_telp_dom_area" class="personal_telp_dom_area">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->telp_dom_area->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->telp_dom_area->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->telp_dom_area->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->_email->Visible) { // email ?>
	<?php if ($personal->SortUrl($personal->_email) == "") { ?>
		<th data-name="_email" class="<?php echo $personal->_email->HeaderCellClass() ?>"><div id="elh_personal__email" class="personal__email"><div class="ewTableHeaderCaption"><?php echo $personal->_email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_email" class="<?php echo $personal->_email->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->_email) ?>',1);"><div id="elh_personal__email" class="personal__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->_email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_st_emp->Visible) { // kd_st_emp ?>
	<?php if ($personal->SortUrl($personal->kd_st_emp) == "") { ?>
		<th data-name="kd_st_emp" class="<?php echo $personal->kd_st_emp->HeaderCellClass() ?>"><div id="elh_personal_kd_st_emp" class="personal_kd_st_emp"><div class="ewTableHeaderCaption"><?php echo $personal->kd_st_emp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_st_emp" class="<?php echo $personal->kd_st_emp->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_st_emp) ?>',1);"><div id="elh_personal_kd_st_emp" class="personal_kd_st_emp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_st_emp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_st_emp->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_st_emp->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->skala->Visible) { // skala ?>
	<?php if ($personal->SortUrl($personal->skala) == "") { ?>
		<th data-name="skala" class="<?php echo $personal->skala->HeaderCellClass() ?>"><div id="elh_personal_skala" class="personal_skala"><div class="ewTableHeaderCaption"><?php echo $personal->skala->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="skala" class="<?php echo $personal->skala->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->skala) ?>',1);"><div id="elh_personal_skala" class="personal_skala">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->skala->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->skala->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->skala->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->gp->Visible) { // gp ?>
	<?php if ($personal->SortUrl($personal->gp) == "") { ?>
		<th data-name="gp" class="<?php echo $personal->gp->HeaderCellClass() ?>"><div id="elh_personal_gp" class="personal_gp"><div class="ewTableHeaderCaption"><?php echo $personal->gp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="gp" class="<?php echo $personal->gp->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->gp) ?>',1);"><div id="elh_personal_gp" class="personal_gp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->gp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->gp->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->gp->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->upah_tetap->Visible) { // upah_tetap ?>
	<?php if ($personal->SortUrl($personal->upah_tetap) == "") { ?>
		<th data-name="upah_tetap" class="<?php echo $personal->upah_tetap->HeaderCellClass() ?>"><div id="elh_personal_upah_tetap" class="personal_upah_tetap"><div class="ewTableHeaderCaption"><?php echo $personal->upah_tetap->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="upah_tetap" class="<?php echo $personal->upah_tetap->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->upah_tetap) ?>',1);"><div id="elh_personal_upah_tetap" class="personal_upah_tetap">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->upah_tetap->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->upah_tetap->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->upah_tetap->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->tgl_honor->Visible) { // tgl_honor ?>
	<?php if ($personal->SortUrl($personal->tgl_honor) == "") { ?>
		<th data-name="tgl_honor" class="<?php echo $personal->tgl_honor->HeaderCellClass() ?>"><div id="elh_personal_tgl_honor" class="personal_tgl_honor"><div class="ewTableHeaderCaption"><?php echo $personal->tgl_honor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_honor" class="<?php echo $personal->tgl_honor->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->tgl_honor) ?>',1);"><div id="elh_personal_tgl_honor" class="personal_tgl_honor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->tgl_honor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->tgl_honor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->tgl_honor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->honor->Visible) { // honor ?>
	<?php if ($personal->SortUrl($personal->honor) == "") { ?>
		<th data-name="honor" class="<?php echo $personal->honor->HeaderCellClass() ?>"><div id="elh_personal_honor" class="personal_honor"><div class="ewTableHeaderCaption"><?php echo $personal->honor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="honor" class="<?php echo $personal->honor->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->honor) ?>',1);"><div id="elh_personal_honor" class="personal_honor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->honor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->honor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->honor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->premi_honor->Visible) { // premi_honor ?>
	<?php if ($personal->SortUrl($personal->premi_honor) == "") { ?>
		<th data-name="premi_honor" class="<?php echo $personal->premi_honor->HeaderCellClass() ?>"><div id="elh_personal_premi_honor" class="personal_premi_honor"><div class="ewTableHeaderCaption"><?php echo $personal->premi_honor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="premi_honor" class="<?php echo $personal->premi_honor->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->premi_honor) ?>',1);"><div id="elh_personal_premi_honor" class="personal_premi_honor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->premi_honor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->premi_honor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->premi_honor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->tgl_gp->Visible) { // tgl_gp ?>
	<?php if ($personal->SortUrl($personal->tgl_gp) == "") { ?>
		<th data-name="tgl_gp" class="<?php echo $personal->tgl_gp->HeaderCellClass() ?>"><div id="elh_personal_tgl_gp" class="personal_tgl_gp"><div class="ewTableHeaderCaption"><?php echo $personal->tgl_gp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_gp" class="<?php echo $personal->tgl_gp->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->tgl_gp) ?>',1);"><div id="elh_personal_tgl_gp" class="personal_tgl_gp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->tgl_gp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->tgl_gp->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->tgl_gp->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->skala_95->Visible) { // skala_95 ?>
	<?php if ($personal->SortUrl($personal->skala_95) == "") { ?>
		<th data-name="skala_95" class="<?php echo $personal->skala_95->HeaderCellClass() ?>"><div id="elh_personal_skala_95" class="personal_skala_95"><div class="ewTableHeaderCaption"><?php echo $personal->skala_95->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="skala_95" class="<?php echo $personal->skala_95->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->skala_95) ?>',1);"><div id="elh_personal_skala_95" class="personal_skala_95">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->skala_95->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->skala_95->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->skala_95->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->gp_95->Visible) { // gp_95 ?>
	<?php if ($personal->SortUrl($personal->gp_95) == "") { ?>
		<th data-name="gp_95" class="<?php echo $personal->gp_95->HeaderCellClass() ?>"><div id="elh_personal_gp_95" class="personal_gp_95"><div class="ewTableHeaderCaption"><?php echo $personal->gp_95->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="gp_95" class="<?php echo $personal->gp_95->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->gp_95) ?>',1);"><div id="elh_personal_gp_95" class="personal_gp_95">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->gp_95->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->gp_95->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->gp_95->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->tgl_gp_95->Visible) { // tgl_gp_95 ?>
	<?php if ($personal->SortUrl($personal->tgl_gp_95) == "") { ?>
		<th data-name="tgl_gp_95" class="<?php echo $personal->tgl_gp_95->HeaderCellClass() ?>"><div id="elh_personal_tgl_gp_95" class="personal_tgl_gp_95"><div class="ewTableHeaderCaption"><?php echo $personal->tgl_gp_95->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_gp_95" class="<?php echo $personal->tgl_gp_95->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->tgl_gp_95) ?>',1);"><div id="elh_personal_tgl_gp_95" class="personal_tgl_gp_95">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->tgl_gp_95->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->tgl_gp_95->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->tgl_gp_95->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_indx->Visible) { // kd_indx ?>
	<?php if ($personal->SortUrl($personal->kd_indx) == "") { ?>
		<th data-name="kd_indx" class="<?php echo $personal->kd_indx->HeaderCellClass() ?>"><div id="elh_personal_kd_indx" class="personal_kd_indx"><div class="ewTableHeaderCaption"><?php echo $personal->kd_indx->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_indx" class="<?php echo $personal->kd_indx->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_indx) ?>',1);"><div id="elh_personal_kd_indx" class="personal_kd_indx">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_indx->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_indx->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_indx->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->indx_lok->Visible) { // indx_lok ?>
	<?php if ($personal->SortUrl($personal->indx_lok) == "") { ?>
		<th data-name="indx_lok" class="<?php echo $personal->indx_lok->HeaderCellClass() ?>"><div id="elh_personal_indx_lok" class="personal_indx_lok"><div class="ewTableHeaderCaption"><?php echo $personal->indx_lok->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="indx_lok" class="<?php echo $personal->indx_lok->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->indx_lok) ?>',1);"><div id="elh_personal_indx_lok" class="personal_indx_lok">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->indx_lok->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->indx_lok->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->indx_lok->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->gol_darah->Visible) { // gol_darah ?>
	<?php if ($personal->SortUrl($personal->gol_darah) == "") { ?>
		<th data-name="gol_darah" class="<?php echo $personal->gol_darah->HeaderCellClass() ?>"><div id="elh_personal_gol_darah" class="personal_gol_darah"><div class="ewTableHeaderCaption"><?php echo $personal->gol_darah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="gol_darah" class="<?php echo $personal->gol_darah->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->gol_darah) ?>',1);"><div id="elh_personal_gol_darah" class="personal_gol_darah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->gol_darah->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->gol_darah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->gol_darah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_jbt->Visible) { // kd_jbt ?>
	<?php if ($personal->SortUrl($personal->kd_jbt) == "") { ?>
		<th data-name="kd_jbt" class="<?php echo $personal->kd_jbt->HeaderCellClass() ?>"><div id="elh_personal_kd_jbt" class="personal_kd_jbt"><div class="ewTableHeaderCaption"><?php echo $personal->kd_jbt->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_jbt" class="<?php echo $personal->kd_jbt->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_jbt) ?>',1);"><div id="elh_personal_kd_jbt" class="personal_kd_jbt">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_jbt->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_jbt->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_jbt->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->tgl_kd_jbt->Visible) { // tgl_kd_jbt ?>
	<?php if ($personal->SortUrl($personal->tgl_kd_jbt) == "") { ?>
		<th data-name="tgl_kd_jbt" class="<?php echo $personal->tgl_kd_jbt->HeaderCellClass() ?>"><div id="elh_personal_tgl_kd_jbt" class="personal_tgl_kd_jbt"><div class="ewTableHeaderCaption"><?php echo $personal->tgl_kd_jbt->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_kd_jbt" class="<?php echo $personal->tgl_kd_jbt->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->tgl_kd_jbt) ?>',1);"><div id="elh_personal_tgl_kd_jbt" class="personal_tgl_kd_jbt">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->tgl_kd_jbt->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->tgl_kd_jbt->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->tgl_kd_jbt->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_jbt_pgs->Visible) { // kd_jbt_pgs ?>
	<?php if ($personal->SortUrl($personal->kd_jbt_pgs) == "") { ?>
		<th data-name="kd_jbt_pgs" class="<?php echo $personal->kd_jbt_pgs->HeaderCellClass() ?>"><div id="elh_personal_kd_jbt_pgs" class="personal_kd_jbt_pgs"><div class="ewTableHeaderCaption"><?php echo $personal->kd_jbt_pgs->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_jbt_pgs" class="<?php echo $personal->kd_jbt_pgs->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_jbt_pgs) ?>',1);"><div id="elh_personal_kd_jbt_pgs" class="personal_kd_jbt_pgs">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_jbt_pgs->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_jbt_pgs->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_jbt_pgs->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->tgl_kd_jbt_pgs->Visible) { // tgl_kd_jbt_pgs ?>
	<?php if ($personal->SortUrl($personal->tgl_kd_jbt_pgs) == "") { ?>
		<th data-name="tgl_kd_jbt_pgs" class="<?php echo $personal->tgl_kd_jbt_pgs->HeaderCellClass() ?>"><div id="elh_personal_tgl_kd_jbt_pgs" class="personal_tgl_kd_jbt_pgs"><div class="ewTableHeaderCaption"><?php echo $personal->tgl_kd_jbt_pgs->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_kd_jbt_pgs" class="<?php echo $personal->tgl_kd_jbt_pgs->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->tgl_kd_jbt_pgs) ?>',1);"><div id="elh_personal_tgl_kd_jbt_pgs" class="personal_tgl_kd_jbt_pgs">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->tgl_kd_jbt_pgs->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->tgl_kd_jbt_pgs->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->tgl_kd_jbt_pgs->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_jbt_pjs->Visible) { // kd_jbt_pjs ?>
	<?php if ($personal->SortUrl($personal->kd_jbt_pjs) == "") { ?>
		<th data-name="kd_jbt_pjs" class="<?php echo $personal->kd_jbt_pjs->HeaderCellClass() ?>"><div id="elh_personal_kd_jbt_pjs" class="personal_kd_jbt_pjs"><div class="ewTableHeaderCaption"><?php echo $personal->kd_jbt_pjs->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_jbt_pjs" class="<?php echo $personal->kd_jbt_pjs->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_jbt_pjs) ?>',1);"><div id="elh_personal_kd_jbt_pjs" class="personal_kd_jbt_pjs">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_jbt_pjs->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_jbt_pjs->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_jbt_pjs->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->tgl_kd_jbt_pjs->Visible) { // tgl_kd_jbt_pjs ?>
	<?php if ($personal->SortUrl($personal->tgl_kd_jbt_pjs) == "") { ?>
		<th data-name="tgl_kd_jbt_pjs" class="<?php echo $personal->tgl_kd_jbt_pjs->HeaderCellClass() ?>"><div id="elh_personal_tgl_kd_jbt_pjs" class="personal_tgl_kd_jbt_pjs"><div class="ewTableHeaderCaption"><?php echo $personal->tgl_kd_jbt_pjs->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_kd_jbt_pjs" class="<?php echo $personal->tgl_kd_jbt_pjs->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->tgl_kd_jbt_pjs) ?>',1);"><div id="elh_personal_tgl_kd_jbt_pjs" class="personal_tgl_kd_jbt_pjs">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->tgl_kd_jbt_pjs->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->tgl_kd_jbt_pjs->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->tgl_kd_jbt_pjs->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_jbt_ps->Visible) { // kd_jbt_ps ?>
	<?php if ($personal->SortUrl($personal->kd_jbt_ps) == "") { ?>
		<th data-name="kd_jbt_ps" class="<?php echo $personal->kd_jbt_ps->HeaderCellClass() ?>"><div id="elh_personal_kd_jbt_ps" class="personal_kd_jbt_ps"><div class="ewTableHeaderCaption"><?php echo $personal->kd_jbt_ps->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_jbt_ps" class="<?php echo $personal->kd_jbt_ps->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_jbt_ps) ?>',1);"><div id="elh_personal_kd_jbt_ps" class="personal_kd_jbt_ps">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_jbt_ps->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_jbt_ps->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_jbt_ps->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->tgl_kd_jbt_ps->Visible) { // tgl_kd_jbt_ps ?>
	<?php if ($personal->SortUrl($personal->tgl_kd_jbt_ps) == "") { ?>
		<th data-name="tgl_kd_jbt_ps" class="<?php echo $personal->tgl_kd_jbt_ps->HeaderCellClass() ?>"><div id="elh_personal_tgl_kd_jbt_ps" class="personal_tgl_kd_jbt_ps"><div class="ewTableHeaderCaption"><?php echo $personal->tgl_kd_jbt_ps->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_kd_jbt_ps" class="<?php echo $personal->tgl_kd_jbt_ps->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->tgl_kd_jbt_ps) ?>',1);"><div id="elh_personal_tgl_kd_jbt_ps" class="personal_tgl_kd_jbt_ps">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->tgl_kd_jbt_ps->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->tgl_kd_jbt_ps->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->tgl_kd_jbt_ps->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_pat->Visible) { // kd_pat ?>
	<?php if ($personal->SortUrl($personal->kd_pat) == "") { ?>
		<th data-name="kd_pat" class="<?php echo $personal->kd_pat->HeaderCellClass() ?>"><div id="elh_personal_kd_pat" class="personal_kd_pat"><div class="ewTableHeaderCaption"><?php echo $personal->kd_pat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_pat" class="<?php echo $personal->kd_pat->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_pat) ?>',1);"><div id="elh_personal_kd_pat" class="personal_kd_pat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_pat->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_pat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_pat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_gas->Visible) { // kd_gas ?>
	<?php if ($personal->SortUrl($personal->kd_gas) == "") { ?>
		<th data-name="kd_gas" class="<?php echo $personal->kd_gas->HeaderCellClass() ?>"><div id="elh_personal_kd_gas" class="personal_kd_gas"><div class="ewTableHeaderCaption"><?php echo $personal->kd_gas->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_gas" class="<?php echo $personal->kd_gas->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_gas) ?>',1);"><div id="elh_personal_kd_gas" class="personal_kd_gas">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_gas->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_gas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_gas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->pimp_empid->Visible) { // pimp_empid ?>
	<?php if ($personal->SortUrl($personal->pimp_empid) == "") { ?>
		<th data-name="pimp_empid" class="<?php echo $personal->pimp_empid->HeaderCellClass() ?>"><div id="elh_personal_pimp_empid" class="personal_pimp_empid"><div class="ewTableHeaderCaption"><?php echo $personal->pimp_empid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pimp_empid" class="<?php echo $personal->pimp_empid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->pimp_empid) ?>',1);"><div id="elh_personal_pimp_empid" class="personal_pimp_empid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->pimp_empid->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->pimp_empid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->pimp_empid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->stshift->Visible) { // stshift ?>
	<?php if ($personal->SortUrl($personal->stshift) == "") { ?>
		<th data-name="stshift" class="<?php echo $personal->stshift->HeaderCellClass() ?>"><div id="elh_personal_stshift" class="personal_stshift"><div class="ewTableHeaderCaption"><?php echo $personal->stshift->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="stshift" class="<?php echo $personal->stshift->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->stshift) ?>',1);"><div id="elh_personal_stshift" class="personal_stshift">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->stshift->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->stshift->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->stshift->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->no_rek->Visible) { // no_rek ?>
	<?php if ($personal->SortUrl($personal->no_rek) == "") { ?>
		<th data-name="no_rek" class="<?php echo $personal->no_rek->HeaderCellClass() ?>"><div id="elh_personal_no_rek" class="personal_no_rek"><div class="ewTableHeaderCaption"><?php echo $personal->no_rek->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_rek" class="<?php echo $personal->no_rek->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->no_rek) ?>',1);"><div id="elh_personal_no_rek" class="personal_no_rek">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->no_rek->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->no_rek->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->no_rek->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_bank->Visible) { // kd_bank ?>
	<?php if ($personal->SortUrl($personal->kd_bank) == "") { ?>
		<th data-name="kd_bank" class="<?php echo $personal->kd_bank->HeaderCellClass() ?>"><div id="elh_personal_kd_bank" class="personal_kd_bank"><div class="ewTableHeaderCaption"><?php echo $personal->kd_bank->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_bank" class="<?php echo $personal->kd_bank->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_bank) ?>',1);"><div id="elh_personal_kd_bank" class="personal_kd_bank">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_bank->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_bank->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_bank->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_jamsostek->Visible) { // kd_jamsostek ?>
	<?php if ($personal->SortUrl($personal->kd_jamsostek) == "") { ?>
		<th data-name="kd_jamsostek" class="<?php echo $personal->kd_jamsostek->HeaderCellClass() ?>"><div id="elh_personal_kd_jamsostek" class="personal_kd_jamsostek"><div class="ewTableHeaderCaption"><?php echo $personal->kd_jamsostek->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_jamsostek" class="<?php echo $personal->kd_jamsostek->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_jamsostek) ?>',1);"><div id="elh_personal_kd_jamsostek" class="personal_kd_jamsostek">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_jamsostek->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_jamsostek->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_jamsostek->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->acc_astek->Visible) { // acc_astek ?>
	<?php if ($personal->SortUrl($personal->acc_astek) == "") { ?>
		<th data-name="acc_astek" class="<?php echo $personal->acc_astek->HeaderCellClass() ?>"><div id="elh_personal_acc_astek" class="personal_acc_astek"><div class="ewTableHeaderCaption"><?php echo $personal->acc_astek->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="acc_astek" class="<?php echo $personal->acc_astek->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->acc_astek) ?>',1);"><div id="elh_personal_acc_astek" class="personal_acc_astek">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->acc_astek->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->acc_astek->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->acc_astek->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->acc_dapens->Visible) { // acc_dapens ?>
	<?php if ($personal->SortUrl($personal->acc_dapens) == "") { ?>
		<th data-name="acc_dapens" class="<?php echo $personal->acc_dapens->HeaderCellClass() ?>"><div id="elh_personal_acc_dapens" class="personal_acc_dapens"><div class="ewTableHeaderCaption"><?php echo $personal->acc_dapens->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="acc_dapens" class="<?php echo $personal->acc_dapens->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->acc_dapens) ?>',1);"><div id="elh_personal_acc_dapens" class="personal_acc_dapens">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->acc_dapens->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->acc_dapens->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->acc_dapens->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->acc_kes->Visible) { // acc_kes ?>
	<?php if ($personal->SortUrl($personal->acc_kes) == "") { ?>
		<th data-name="acc_kes" class="<?php echo $personal->acc_kes->HeaderCellClass() ?>"><div id="elh_personal_acc_kes" class="personal_acc_kes"><div class="ewTableHeaderCaption"><?php echo $personal->acc_kes->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="acc_kes" class="<?php echo $personal->acc_kes->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->acc_kes) ?>',1);"><div id="elh_personal_acc_kes" class="personal_acc_kes">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->acc_kes->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->acc_kes->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->acc_kes->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->st->Visible) { // st ?>
	<?php if ($personal->SortUrl($personal->st) == "") { ?>
		<th data-name="st" class="<?php echo $personal->st->HeaderCellClass() ?>"><div id="elh_personal_st" class="personal_st"><div class="ewTableHeaderCaption"><?php echo $personal->st->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="st" class="<?php echo $personal->st->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->st) ?>',1);"><div id="elh_personal_st" class="personal_st">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->st->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->st->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->st->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->created_by->Visible) { // created_by ?>
	<?php if ($personal->SortUrl($personal->created_by) == "") { ?>
		<th data-name="created_by" class="<?php echo $personal->created_by->HeaderCellClass() ?>"><div id="elh_personal_created_by" class="personal_created_by"><div class="ewTableHeaderCaption"><?php echo $personal->created_by->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="created_by" class="<?php echo $personal->created_by->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->created_by) ?>',1);"><div id="elh_personal_created_by" class="personal_created_by">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->created_by->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->created_by->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->created_by->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->created_date->Visible) { // created_date ?>
	<?php if ($personal->SortUrl($personal->created_date) == "") { ?>
		<th data-name="created_date" class="<?php echo $personal->created_date->HeaderCellClass() ?>"><div id="elh_personal_created_date" class="personal_created_date"><div class="ewTableHeaderCaption"><?php echo $personal->created_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="created_date" class="<?php echo $personal->created_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->created_date) ?>',1);"><div id="elh_personal_created_date" class="personal_created_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->created_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->created_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->created_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->last_update_by->Visible) { // last_update_by ?>
	<?php if ($personal->SortUrl($personal->last_update_by) == "") { ?>
		<th data-name="last_update_by" class="<?php echo $personal->last_update_by->HeaderCellClass() ?>"><div id="elh_personal_last_update_by" class="personal_last_update_by"><div class="ewTableHeaderCaption"><?php echo $personal->last_update_by->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="last_update_by" class="<?php echo $personal->last_update_by->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->last_update_by) ?>',1);"><div id="elh_personal_last_update_by" class="personal_last_update_by">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->last_update_by->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->last_update_by->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->last_update_by->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->last_update_date->Visible) { // last_update_date ?>
	<?php if ($personal->SortUrl($personal->last_update_date) == "") { ?>
		<th data-name="last_update_date" class="<?php echo $personal->last_update_date->HeaderCellClass() ?>"><div id="elh_personal_last_update_date" class="personal_last_update_date"><div class="ewTableHeaderCaption"><?php echo $personal->last_update_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="last_update_date" class="<?php echo $personal->last_update_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->last_update_date) ?>',1);"><div id="elh_personal_last_update_date" class="personal_last_update_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->last_update_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->last_update_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->last_update_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->fgr_print_id->Visible) { // fgr_print_id ?>
	<?php if ($personal->SortUrl($personal->fgr_print_id) == "") { ?>
		<th data-name="fgr_print_id" class="<?php echo $personal->fgr_print_id->HeaderCellClass() ?>"><div id="elh_personal_fgr_print_id" class="personal_fgr_print_id"><div class="ewTableHeaderCaption"><?php echo $personal->fgr_print_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fgr_print_id" class="<?php echo $personal->fgr_print_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->fgr_print_id) ?>',1);"><div id="elh_personal_fgr_print_id" class="personal_fgr_print_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->fgr_print_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->fgr_print_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->fgr_print_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_jbt_eselon->Visible) { // kd_jbt_eselon ?>
	<?php if ($personal->SortUrl($personal->kd_jbt_eselon) == "") { ?>
		<th data-name="kd_jbt_eselon" class="<?php echo $personal->kd_jbt_eselon->HeaderCellClass() ?>"><div id="elh_personal_kd_jbt_eselon" class="personal_kd_jbt_eselon"><div class="ewTableHeaderCaption"><?php echo $personal->kd_jbt_eselon->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_jbt_eselon" class="<?php echo $personal->kd_jbt_eselon->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_jbt_eselon) ?>',1);"><div id="elh_personal_kd_jbt_eselon" class="personal_kd_jbt_eselon">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_jbt_eselon->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_jbt_eselon->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_jbt_eselon->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->npwp->Visible) { // npwp ?>
	<?php if ($personal->SortUrl($personal->npwp) == "") { ?>
		<th data-name="npwp" class="<?php echo $personal->npwp->HeaderCellClass() ?>"><div id="elh_personal_npwp" class="personal_npwp"><div class="ewTableHeaderCaption"><?php echo $personal->npwp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="npwp" class="<?php echo $personal->npwp->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->npwp) ?>',1);"><div id="elh_personal_npwp" class="personal_npwp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->npwp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->npwp->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->npwp->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->tgl_keluar->Visible) { // tgl_keluar ?>
	<?php if ($personal->SortUrl($personal->tgl_keluar) == "") { ?>
		<th data-name="tgl_keluar" class="<?php echo $personal->tgl_keluar->HeaderCellClass() ?>"><div id="elh_personal_tgl_keluar" class="personal_tgl_keluar"><div class="ewTableHeaderCaption"><?php echo $personal->tgl_keluar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_keluar" class="<?php echo $personal->tgl_keluar->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->tgl_keluar) ?>',1);"><div id="elh_personal_tgl_keluar" class="personal_tgl_keluar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->tgl_keluar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->tgl_keluar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->tgl_keluar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->nama_nasabah->Visible) { // nama_nasabah ?>
	<?php if ($personal->SortUrl($personal->nama_nasabah) == "") { ?>
		<th data-name="nama_nasabah" class="<?php echo $personal->nama_nasabah->HeaderCellClass() ?>"><div id="elh_personal_nama_nasabah" class="personal_nama_nasabah"><div class="ewTableHeaderCaption"><?php echo $personal->nama_nasabah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_nasabah" class="<?php echo $personal->nama_nasabah->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->nama_nasabah) ?>',1);"><div id="elh_personal_nama_nasabah" class="personal_nama_nasabah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->nama_nasabah->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->nama_nasabah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->nama_nasabah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->no_ktp->Visible) { // no_ktp ?>
	<?php if ($personal->SortUrl($personal->no_ktp) == "") { ?>
		<th data-name="no_ktp" class="<?php echo $personal->no_ktp->HeaderCellClass() ?>"><div id="elh_personal_no_ktp" class="personal_no_ktp"><div class="ewTableHeaderCaption"><?php echo $personal->no_ktp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_ktp" class="<?php echo $personal->no_ktp->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->no_ktp) ?>',1);"><div id="elh_personal_no_ktp" class="personal_no_ktp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->no_ktp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->no_ktp->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->no_ktp->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->no_kokar->Visible) { // no_kokar ?>
	<?php if ($personal->SortUrl($personal->no_kokar) == "") { ?>
		<th data-name="no_kokar" class="<?php echo $personal->no_kokar->HeaderCellClass() ?>"><div id="elh_personal_no_kokar" class="personal_no_kokar"><div class="ewTableHeaderCaption"><?php echo $personal->no_kokar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_kokar" class="<?php echo $personal->no_kokar->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->no_kokar) ?>',1);"><div id="elh_personal_no_kokar" class="personal_no_kokar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->no_kokar->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->no_kokar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->no_kokar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->no_bmw->Visible) { // no_bmw ?>
	<?php if ($personal->SortUrl($personal->no_bmw) == "") { ?>
		<th data-name="no_bmw" class="<?php echo $personal->no_bmw->HeaderCellClass() ?>"><div id="elh_personal_no_bmw" class="personal_no_bmw"><div class="ewTableHeaderCaption"><?php echo $personal->no_bmw->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_bmw" class="<?php echo $personal->no_bmw->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->no_bmw) ?>',1);"><div id="elh_personal_no_bmw" class="personal_no_bmw">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->no_bmw->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->no_bmw->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->no_bmw->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->no_bpjs_ketenagakerjaan->Visible) { // no_bpjs_ketenagakerjaan ?>
	<?php if ($personal->SortUrl($personal->no_bpjs_ketenagakerjaan) == "") { ?>
		<th data-name="no_bpjs_ketenagakerjaan" class="<?php echo $personal->no_bpjs_ketenagakerjaan->HeaderCellClass() ?>"><div id="elh_personal_no_bpjs_ketenagakerjaan" class="personal_no_bpjs_ketenagakerjaan"><div class="ewTableHeaderCaption"><?php echo $personal->no_bpjs_ketenagakerjaan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_bpjs_ketenagakerjaan" class="<?php echo $personal->no_bpjs_ketenagakerjaan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->no_bpjs_ketenagakerjaan) ?>',1);"><div id="elh_personal_no_bpjs_ketenagakerjaan" class="personal_no_bpjs_ketenagakerjaan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->no_bpjs_ketenagakerjaan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->no_bpjs_ketenagakerjaan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->no_bpjs_ketenagakerjaan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->no_bpjs_kesehatan->Visible) { // no_bpjs_kesehatan ?>
	<?php if ($personal->SortUrl($personal->no_bpjs_kesehatan) == "") { ?>
		<th data-name="no_bpjs_kesehatan" class="<?php echo $personal->no_bpjs_kesehatan->HeaderCellClass() ?>"><div id="elh_personal_no_bpjs_kesehatan" class="personal_no_bpjs_kesehatan"><div class="ewTableHeaderCaption"><?php echo $personal->no_bpjs_kesehatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_bpjs_kesehatan" class="<?php echo $personal->no_bpjs_kesehatan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->no_bpjs_kesehatan) ?>',1);"><div id="elh_personal_no_bpjs_kesehatan" class="personal_no_bpjs_kesehatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->no_bpjs_kesehatan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->no_bpjs_kesehatan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->no_bpjs_kesehatan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->eselon->Visible) { // eselon ?>
	<?php if ($personal->SortUrl($personal->eselon) == "") { ?>
		<th data-name="eselon" class="<?php echo $personal->eselon->HeaderCellClass() ?>"><div id="elh_personal_eselon" class="personal_eselon"><div class="ewTableHeaderCaption"><?php echo $personal->eselon->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="eselon" class="<?php echo $personal->eselon->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->eselon) ?>',1);"><div id="elh_personal_eselon" class="personal_eselon">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->eselon->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->eselon->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->eselon->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_jenjang->Visible) { // kd_jenjang ?>
	<?php if ($personal->SortUrl($personal->kd_jenjang) == "") { ?>
		<th data-name="kd_jenjang" class="<?php echo $personal->kd_jenjang->HeaderCellClass() ?>"><div id="elh_personal_kd_jenjang" class="personal_kd_jenjang"><div class="ewTableHeaderCaption"><?php echo $personal->kd_jenjang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_jenjang" class="<?php echo $personal->kd_jenjang->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_jenjang) ?>',1);"><div id="elh_personal_kd_jenjang" class="personal_kd_jenjang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_jenjang->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_jenjang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_jenjang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_jbt_esl->Visible) { // kd_jbt_esl ?>
	<?php if ($personal->SortUrl($personal->kd_jbt_esl) == "") { ?>
		<th data-name="kd_jbt_esl" class="<?php echo $personal->kd_jbt_esl->HeaderCellClass() ?>"><div id="elh_personal_kd_jbt_esl" class="personal_kd_jbt_esl"><div class="ewTableHeaderCaption"><?php echo $personal->kd_jbt_esl->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_jbt_esl" class="<?php echo $personal->kd_jbt_esl->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_jbt_esl) ?>',1);"><div id="elh_personal_kd_jbt_esl" class="personal_kd_jbt_esl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_jbt_esl->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_jbt_esl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_jbt_esl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->tgl_jbt_esl->Visible) { // tgl_jbt_esl ?>
	<?php if ($personal->SortUrl($personal->tgl_jbt_esl) == "") { ?>
		<th data-name="tgl_jbt_esl" class="<?php echo $personal->tgl_jbt_esl->HeaderCellClass() ?>"><div id="elh_personal_tgl_jbt_esl" class="personal_tgl_jbt_esl"><div class="ewTableHeaderCaption"><?php echo $personal->tgl_jbt_esl->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_jbt_esl" class="<?php echo $personal->tgl_jbt_esl->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->tgl_jbt_esl) ?>',1);"><div id="elh_personal_tgl_jbt_esl" class="personal_tgl_jbt_esl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->tgl_jbt_esl->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal->tgl_jbt_esl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->tgl_jbt_esl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->org_id->Visible) { // org_id ?>
	<?php if ($personal->SortUrl($personal->org_id) == "") { ?>
		<th data-name="org_id" class="<?php echo $personal->org_id->HeaderCellClass() ?>"><div id="elh_personal_org_id" class="personal_org_id"><div class="ewTableHeaderCaption"><?php echo $personal->org_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="org_id" class="<?php echo $personal->org_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->org_id) ?>',1);"><div id="elh_personal_org_id" class="personal_org_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->org_id->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->org_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->org_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->kd_payroll->Visible) { // kd_payroll ?>
	<?php if ($personal->SortUrl($personal->kd_payroll) == "") { ?>
		<th data-name="kd_payroll" class="<?php echo $personal->kd_payroll->HeaderCellClass() ?>"><div id="elh_personal_kd_payroll" class="personal_kd_payroll"><div class="ewTableHeaderCaption"><?php echo $personal->kd_payroll->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_payroll" class="<?php echo $personal->kd_payroll->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->kd_payroll) ?>',1);"><div id="elh_personal_kd_payroll" class="personal_kd_payroll">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->kd_payroll->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->kd_payroll->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->kd_payroll->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->id_wn->Visible) { // id_wn ?>
	<?php if ($personal->SortUrl($personal->id_wn) == "") { ?>
		<th data-name="id_wn" class="<?php echo $personal->id_wn->HeaderCellClass() ?>"><div id="elh_personal_id_wn" class="personal_id_wn"><div class="ewTableHeaderCaption"><?php echo $personal->id_wn->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_wn" class="<?php echo $personal->id_wn->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->id_wn) ?>',1);"><div id="elh_personal_id_wn" class="personal_id_wn">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->id_wn->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->id_wn->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->id_wn->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($personal->no_anggota_kkms->Visible) { // no_anggota_kkms ?>
	<?php if ($personal->SortUrl($personal->no_anggota_kkms) == "") { ?>
		<th data-name="no_anggota_kkms" class="<?php echo $personal->no_anggota_kkms->HeaderCellClass() ?>"><div id="elh_personal_no_anggota_kkms" class="personal_no_anggota_kkms"><div class="ewTableHeaderCaption"><?php echo $personal->no_anggota_kkms->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_anggota_kkms" class="<?php echo $personal->no_anggota_kkms->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $personal->SortUrl($personal->no_anggota_kkms) ?>',1);"><div id="elh_personal_no_anggota_kkms" class="personal_no_anggota_kkms">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal->no_anggota_kkms->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($personal->no_anggota_kkms->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal->no_anggota_kkms->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$personal_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($personal->ExportAll && $personal->Export <> "") {
	$personal_list->StopRec = $personal_list->TotalRecs;
} else {

	// Set the last record to display
	if ($personal_list->TotalRecs > $personal_list->StartRec + $personal_list->DisplayRecs - 1)
		$personal_list->StopRec = $personal_list->StartRec + $personal_list->DisplayRecs - 1;
	else
		$personal_list->StopRec = $personal_list->TotalRecs;
}
$personal_list->RecCnt = $personal_list->StartRec - 1;
if ($personal_list->Recordset && !$personal_list->Recordset->EOF) {
	$personal_list->Recordset->MoveFirst();
	$bSelectLimit = $personal_list->UseSelectLimit;
	if (!$bSelectLimit && $personal_list->StartRec > 1)
		$personal_list->Recordset->Move($personal_list->StartRec - 1);
} elseif (!$personal->AllowAddDeleteRow && $personal_list->StopRec == 0) {
	$personal_list->StopRec = $personal->GridAddRowCount;
}

// Initialize aggregate
$personal->RowType = EW_ROWTYPE_AGGREGATEINIT;
$personal->ResetAttrs();
$personal_list->RenderRow();
while ($personal_list->RecCnt < $personal_list->StopRec) {
	$personal_list->RecCnt++;
	if (intval($personal_list->RecCnt) >= intval($personal_list->StartRec)) {
		$personal_list->RowCnt++;

		// Set up key count
		$personal_list->KeyCount = $personal_list->RowIndex;

		// Init row class and style
		$personal->ResetAttrs();
		$personal->CssClass = "";
		if ($personal->CurrentAction == "gridadd") {
		} else {
			$personal_list->LoadRowValues($personal_list->Recordset); // Load row values
		}
		$personal->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$personal->RowAttrs = array_merge($personal->RowAttrs, array('data-rowindex'=>$personal_list->RowCnt, 'id'=>'r' . $personal_list->RowCnt . '_personal', 'data-rowtype'=>$personal->RowType));

		// Render row
		$personal_list->RenderRow();

		// Render list options
		$personal_list->RenderListOptions();
?>
	<tr<?php echo $personal->RowAttributes() ?>>
<?php

// Render list options (body, left)
$personal_list->ListOptions->Render("body", "left", $personal_list->RowCnt);
?>
	<?php if ($personal->employee_id->Visible) { // employee_id ?>
		<td data-name="employee_id"<?php echo $personal->employee_id->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_employee_id" class="personal_employee_id">
<span<?php echo $personal->employee_id->ViewAttributes() ?>>
<?php echo $personal->employee_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->first_name->Visible) { // first_name ?>
		<td data-name="first_name"<?php echo $personal->first_name->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_first_name" class="personal_first_name">
<span<?php echo $personal->first_name->ViewAttributes() ?>>
<?php echo $personal->first_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->last_name->Visible) { // last_name ?>
		<td data-name="last_name"<?php echo $personal->last_name->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_last_name" class="personal_last_name">
<span<?php echo $personal->last_name->ViewAttributes() ?>>
<?php echo $personal->last_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->first_title->Visible) { // first_title ?>
		<td data-name="first_title"<?php echo $personal->first_title->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_first_title" class="personal_first_title">
<span<?php echo $personal->first_title->ViewAttributes() ?>>
<?php echo $personal->first_title->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->last_title->Visible) { // last_title ?>
		<td data-name="last_title"<?php echo $personal->last_title->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_last_title" class="personal_last_title">
<span<?php echo $personal->last_title->ViewAttributes() ?>>
<?php echo $personal->last_title->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->init->Visible) { // init ?>
		<td data-name="init"<?php echo $personal->init->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_init" class="personal_init">
<span<?php echo $personal->init->ViewAttributes() ?>>
<?php echo $personal->init->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->tpt_lahir->Visible) { // tpt_lahir ?>
		<td data-name="tpt_lahir"<?php echo $personal->tpt_lahir->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_tpt_lahir" class="personal_tpt_lahir">
<span<?php echo $personal->tpt_lahir->ViewAttributes() ?>>
<?php echo $personal->tpt_lahir->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->tgl_lahir->Visible) { // tgl_lahir ?>
		<td data-name="tgl_lahir"<?php echo $personal->tgl_lahir->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_tgl_lahir" class="personal_tgl_lahir">
<span<?php echo $personal->tgl_lahir->ViewAttributes() ?>>
<?php echo $personal->tgl_lahir->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->jk->Visible) { // jk ?>
		<td data-name="jk"<?php echo $personal->jk->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_jk" class="personal_jk">
<span<?php echo $personal->jk->ViewAttributes() ?>>
<?php echo $personal->jk->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_agama->Visible) { // kd_agama ?>
		<td data-name="kd_agama"<?php echo $personal->kd_agama->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_agama" class="personal_kd_agama">
<span<?php echo $personal->kd_agama->ViewAttributes() ?>>
<?php echo $personal->kd_agama->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->tgl_masuk->Visible) { // tgl_masuk ?>
		<td data-name="tgl_masuk"<?php echo $personal->tgl_masuk->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_tgl_masuk" class="personal_tgl_masuk">
<span<?php echo $personal->tgl_masuk->ViewAttributes() ?>>
<?php echo $personal->tgl_masuk->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->tpt_masuk->Visible) { // tpt_masuk ?>
		<td data-name="tpt_masuk"<?php echo $personal->tpt_masuk->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_tpt_masuk" class="personal_tpt_masuk">
<span<?php echo $personal->tpt_masuk->ViewAttributes() ?>>
<?php echo $personal->tpt_masuk->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->stkel->Visible) { // stkel ?>
		<td data-name="stkel"<?php echo $personal->stkel->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_stkel" class="personal_stkel">
<span<?php echo $personal->stkel->ViewAttributes() ?>>
<?php echo $personal->stkel->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->alamat->Visible) { // alamat ?>
		<td data-name="alamat"<?php echo $personal->alamat->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_alamat" class="personal_alamat">
<span<?php echo $personal->alamat->ViewAttributes() ?>>
<?php echo $personal->alamat->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kota->Visible) { // kota ?>
		<td data-name="kota"<?php echo $personal->kota->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kota" class="personal_kota">
<span<?php echo $personal->kota->ViewAttributes() ?>>
<?php echo $personal->kota->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_pos->Visible) { // kd_pos ?>
		<td data-name="kd_pos"<?php echo $personal->kd_pos->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_pos" class="personal_kd_pos">
<span<?php echo $personal->kd_pos->ViewAttributes() ?>>
<?php echo $personal->kd_pos->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_propinsi->Visible) { // kd_propinsi ?>
		<td data-name="kd_propinsi"<?php echo $personal->kd_propinsi->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_propinsi" class="personal_kd_propinsi">
<span<?php echo $personal->kd_propinsi->ViewAttributes() ?>>
<?php echo $personal->kd_propinsi->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->telp->Visible) { // telp ?>
		<td data-name="telp"<?php echo $personal->telp->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_telp" class="personal_telp">
<span<?php echo $personal->telp->ViewAttributes() ?>>
<?php echo $personal->telp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->telp_area->Visible) { // telp_area ?>
		<td data-name="telp_area"<?php echo $personal->telp_area->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_telp_area" class="personal_telp_area">
<span<?php echo $personal->telp_area->ViewAttributes() ?>>
<?php echo $personal->telp_area->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->hp->Visible) { // hp ?>
		<td data-name="hp"<?php echo $personal->hp->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_hp" class="personal_hp">
<span<?php echo $personal->hp->ViewAttributes() ?>>
<?php echo $personal->hp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->alamat_dom->Visible) { // alamat_dom ?>
		<td data-name="alamat_dom"<?php echo $personal->alamat_dom->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_alamat_dom" class="personal_alamat_dom">
<span<?php echo $personal->alamat_dom->ViewAttributes() ?>>
<?php echo $personal->alamat_dom->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kota_dom->Visible) { // kota_dom ?>
		<td data-name="kota_dom"<?php echo $personal->kota_dom->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kota_dom" class="personal_kota_dom">
<span<?php echo $personal->kota_dom->ViewAttributes() ?>>
<?php echo $personal->kota_dom->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_pos_dom->Visible) { // kd_pos_dom ?>
		<td data-name="kd_pos_dom"<?php echo $personal->kd_pos_dom->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_pos_dom" class="personal_kd_pos_dom">
<span<?php echo $personal->kd_pos_dom->ViewAttributes() ?>>
<?php echo $personal->kd_pos_dom->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_propinsi_dom->Visible) { // kd_propinsi_dom ?>
		<td data-name="kd_propinsi_dom"<?php echo $personal->kd_propinsi_dom->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_propinsi_dom" class="personal_kd_propinsi_dom">
<span<?php echo $personal->kd_propinsi_dom->ViewAttributes() ?>>
<?php echo $personal->kd_propinsi_dom->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->telp_dom->Visible) { // telp_dom ?>
		<td data-name="telp_dom"<?php echo $personal->telp_dom->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_telp_dom" class="personal_telp_dom">
<span<?php echo $personal->telp_dom->ViewAttributes() ?>>
<?php echo $personal->telp_dom->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->telp_dom_area->Visible) { // telp_dom_area ?>
		<td data-name="telp_dom_area"<?php echo $personal->telp_dom_area->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_telp_dom_area" class="personal_telp_dom_area">
<span<?php echo $personal->telp_dom_area->ViewAttributes() ?>>
<?php echo $personal->telp_dom_area->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->_email->Visible) { // email ?>
		<td data-name="_email"<?php echo $personal->_email->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal__email" class="personal__email">
<span<?php echo $personal->_email->ViewAttributes() ?>>
<?php echo $personal->_email->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_st_emp->Visible) { // kd_st_emp ?>
		<td data-name="kd_st_emp"<?php echo $personal->kd_st_emp->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_st_emp" class="personal_kd_st_emp">
<span<?php echo $personal->kd_st_emp->ViewAttributes() ?>>
<?php echo $personal->kd_st_emp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->skala->Visible) { // skala ?>
		<td data-name="skala"<?php echo $personal->skala->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_skala" class="personal_skala">
<span<?php echo $personal->skala->ViewAttributes() ?>>
<?php echo $personal->skala->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->gp->Visible) { // gp ?>
		<td data-name="gp"<?php echo $personal->gp->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_gp" class="personal_gp">
<span<?php echo $personal->gp->ViewAttributes() ?>>
<?php echo $personal->gp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->upah_tetap->Visible) { // upah_tetap ?>
		<td data-name="upah_tetap"<?php echo $personal->upah_tetap->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_upah_tetap" class="personal_upah_tetap">
<span<?php echo $personal->upah_tetap->ViewAttributes() ?>>
<?php echo $personal->upah_tetap->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->tgl_honor->Visible) { // tgl_honor ?>
		<td data-name="tgl_honor"<?php echo $personal->tgl_honor->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_tgl_honor" class="personal_tgl_honor">
<span<?php echo $personal->tgl_honor->ViewAttributes() ?>>
<?php echo $personal->tgl_honor->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->honor->Visible) { // honor ?>
		<td data-name="honor"<?php echo $personal->honor->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_honor" class="personal_honor">
<span<?php echo $personal->honor->ViewAttributes() ?>>
<?php echo $personal->honor->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->premi_honor->Visible) { // premi_honor ?>
		<td data-name="premi_honor"<?php echo $personal->premi_honor->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_premi_honor" class="personal_premi_honor">
<span<?php echo $personal->premi_honor->ViewAttributes() ?>>
<?php echo $personal->premi_honor->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->tgl_gp->Visible) { // tgl_gp ?>
		<td data-name="tgl_gp"<?php echo $personal->tgl_gp->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_tgl_gp" class="personal_tgl_gp">
<span<?php echo $personal->tgl_gp->ViewAttributes() ?>>
<?php echo $personal->tgl_gp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->skala_95->Visible) { // skala_95 ?>
		<td data-name="skala_95"<?php echo $personal->skala_95->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_skala_95" class="personal_skala_95">
<span<?php echo $personal->skala_95->ViewAttributes() ?>>
<?php echo $personal->skala_95->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->gp_95->Visible) { // gp_95 ?>
		<td data-name="gp_95"<?php echo $personal->gp_95->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_gp_95" class="personal_gp_95">
<span<?php echo $personal->gp_95->ViewAttributes() ?>>
<?php echo $personal->gp_95->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->tgl_gp_95->Visible) { // tgl_gp_95 ?>
		<td data-name="tgl_gp_95"<?php echo $personal->tgl_gp_95->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_tgl_gp_95" class="personal_tgl_gp_95">
<span<?php echo $personal->tgl_gp_95->ViewAttributes() ?>>
<?php echo $personal->tgl_gp_95->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_indx->Visible) { // kd_indx ?>
		<td data-name="kd_indx"<?php echo $personal->kd_indx->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_indx" class="personal_kd_indx">
<span<?php echo $personal->kd_indx->ViewAttributes() ?>>
<?php echo $personal->kd_indx->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->indx_lok->Visible) { // indx_lok ?>
		<td data-name="indx_lok"<?php echo $personal->indx_lok->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_indx_lok" class="personal_indx_lok">
<span<?php echo $personal->indx_lok->ViewAttributes() ?>>
<?php echo $personal->indx_lok->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->gol_darah->Visible) { // gol_darah ?>
		<td data-name="gol_darah"<?php echo $personal->gol_darah->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_gol_darah" class="personal_gol_darah">
<span<?php echo $personal->gol_darah->ViewAttributes() ?>>
<?php echo $personal->gol_darah->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_jbt->Visible) { // kd_jbt ?>
		<td data-name="kd_jbt"<?php echo $personal->kd_jbt->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_jbt" class="personal_kd_jbt">
<span<?php echo $personal->kd_jbt->ViewAttributes() ?>>
<?php echo $personal->kd_jbt->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->tgl_kd_jbt->Visible) { // tgl_kd_jbt ?>
		<td data-name="tgl_kd_jbt"<?php echo $personal->tgl_kd_jbt->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_tgl_kd_jbt" class="personal_tgl_kd_jbt">
<span<?php echo $personal->tgl_kd_jbt->ViewAttributes() ?>>
<?php echo $personal->tgl_kd_jbt->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_jbt_pgs->Visible) { // kd_jbt_pgs ?>
		<td data-name="kd_jbt_pgs"<?php echo $personal->kd_jbt_pgs->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_jbt_pgs" class="personal_kd_jbt_pgs">
<span<?php echo $personal->kd_jbt_pgs->ViewAttributes() ?>>
<?php echo $personal->kd_jbt_pgs->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->tgl_kd_jbt_pgs->Visible) { // tgl_kd_jbt_pgs ?>
		<td data-name="tgl_kd_jbt_pgs"<?php echo $personal->tgl_kd_jbt_pgs->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_tgl_kd_jbt_pgs" class="personal_tgl_kd_jbt_pgs">
<span<?php echo $personal->tgl_kd_jbt_pgs->ViewAttributes() ?>>
<?php echo $personal->tgl_kd_jbt_pgs->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_jbt_pjs->Visible) { // kd_jbt_pjs ?>
		<td data-name="kd_jbt_pjs"<?php echo $personal->kd_jbt_pjs->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_jbt_pjs" class="personal_kd_jbt_pjs">
<span<?php echo $personal->kd_jbt_pjs->ViewAttributes() ?>>
<?php echo $personal->kd_jbt_pjs->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->tgl_kd_jbt_pjs->Visible) { // tgl_kd_jbt_pjs ?>
		<td data-name="tgl_kd_jbt_pjs"<?php echo $personal->tgl_kd_jbt_pjs->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_tgl_kd_jbt_pjs" class="personal_tgl_kd_jbt_pjs">
<span<?php echo $personal->tgl_kd_jbt_pjs->ViewAttributes() ?>>
<?php echo $personal->tgl_kd_jbt_pjs->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_jbt_ps->Visible) { // kd_jbt_ps ?>
		<td data-name="kd_jbt_ps"<?php echo $personal->kd_jbt_ps->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_jbt_ps" class="personal_kd_jbt_ps">
<span<?php echo $personal->kd_jbt_ps->ViewAttributes() ?>>
<?php echo $personal->kd_jbt_ps->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->tgl_kd_jbt_ps->Visible) { // tgl_kd_jbt_ps ?>
		<td data-name="tgl_kd_jbt_ps"<?php echo $personal->tgl_kd_jbt_ps->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_tgl_kd_jbt_ps" class="personal_tgl_kd_jbt_ps">
<span<?php echo $personal->tgl_kd_jbt_ps->ViewAttributes() ?>>
<?php echo $personal->tgl_kd_jbt_ps->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_pat->Visible) { // kd_pat ?>
		<td data-name="kd_pat"<?php echo $personal->kd_pat->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_pat" class="personal_kd_pat">
<span<?php echo $personal->kd_pat->ViewAttributes() ?>>
<?php echo $personal->kd_pat->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_gas->Visible) { // kd_gas ?>
		<td data-name="kd_gas"<?php echo $personal->kd_gas->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_gas" class="personal_kd_gas">
<span<?php echo $personal->kd_gas->ViewAttributes() ?>>
<?php echo $personal->kd_gas->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->pimp_empid->Visible) { // pimp_empid ?>
		<td data-name="pimp_empid"<?php echo $personal->pimp_empid->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_pimp_empid" class="personal_pimp_empid">
<span<?php echo $personal->pimp_empid->ViewAttributes() ?>>
<?php echo $personal->pimp_empid->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->stshift->Visible) { // stshift ?>
		<td data-name="stshift"<?php echo $personal->stshift->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_stshift" class="personal_stshift">
<span<?php echo $personal->stshift->ViewAttributes() ?>>
<?php echo $personal->stshift->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->no_rek->Visible) { // no_rek ?>
		<td data-name="no_rek"<?php echo $personal->no_rek->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_no_rek" class="personal_no_rek">
<span<?php echo $personal->no_rek->ViewAttributes() ?>>
<?php echo $personal->no_rek->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_bank->Visible) { // kd_bank ?>
		<td data-name="kd_bank"<?php echo $personal->kd_bank->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_bank" class="personal_kd_bank">
<span<?php echo $personal->kd_bank->ViewAttributes() ?>>
<?php echo $personal->kd_bank->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_jamsostek->Visible) { // kd_jamsostek ?>
		<td data-name="kd_jamsostek"<?php echo $personal->kd_jamsostek->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_jamsostek" class="personal_kd_jamsostek">
<span<?php echo $personal->kd_jamsostek->ViewAttributes() ?>>
<?php echo $personal->kd_jamsostek->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->acc_astek->Visible) { // acc_astek ?>
		<td data-name="acc_astek"<?php echo $personal->acc_astek->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_acc_astek" class="personal_acc_astek">
<span<?php echo $personal->acc_astek->ViewAttributes() ?>>
<?php echo $personal->acc_astek->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->acc_dapens->Visible) { // acc_dapens ?>
		<td data-name="acc_dapens"<?php echo $personal->acc_dapens->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_acc_dapens" class="personal_acc_dapens">
<span<?php echo $personal->acc_dapens->ViewAttributes() ?>>
<?php echo $personal->acc_dapens->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->acc_kes->Visible) { // acc_kes ?>
		<td data-name="acc_kes"<?php echo $personal->acc_kes->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_acc_kes" class="personal_acc_kes">
<span<?php echo $personal->acc_kes->ViewAttributes() ?>>
<?php echo $personal->acc_kes->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->st->Visible) { // st ?>
		<td data-name="st"<?php echo $personal->st->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_st" class="personal_st">
<span<?php echo $personal->st->ViewAttributes() ?>>
<?php echo $personal->st->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->created_by->Visible) { // created_by ?>
		<td data-name="created_by"<?php echo $personal->created_by->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_created_by" class="personal_created_by">
<span<?php echo $personal->created_by->ViewAttributes() ?>>
<?php echo $personal->created_by->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->created_date->Visible) { // created_date ?>
		<td data-name="created_date"<?php echo $personal->created_date->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_created_date" class="personal_created_date">
<span<?php echo $personal->created_date->ViewAttributes() ?>>
<?php echo $personal->created_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->last_update_by->Visible) { // last_update_by ?>
		<td data-name="last_update_by"<?php echo $personal->last_update_by->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_last_update_by" class="personal_last_update_by">
<span<?php echo $personal->last_update_by->ViewAttributes() ?>>
<?php echo $personal->last_update_by->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->last_update_date->Visible) { // last_update_date ?>
		<td data-name="last_update_date"<?php echo $personal->last_update_date->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_last_update_date" class="personal_last_update_date">
<span<?php echo $personal->last_update_date->ViewAttributes() ?>>
<?php echo $personal->last_update_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->fgr_print_id->Visible) { // fgr_print_id ?>
		<td data-name="fgr_print_id"<?php echo $personal->fgr_print_id->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_fgr_print_id" class="personal_fgr_print_id">
<span<?php echo $personal->fgr_print_id->ViewAttributes() ?>>
<?php echo $personal->fgr_print_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_jbt_eselon->Visible) { // kd_jbt_eselon ?>
		<td data-name="kd_jbt_eselon"<?php echo $personal->kd_jbt_eselon->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_jbt_eselon" class="personal_kd_jbt_eselon">
<span<?php echo $personal->kd_jbt_eselon->ViewAttributes() ?>>
<?php echo $personal->kd_jbt_eselon->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->npwp->Visible) { // npwp ?>
		<td data-name="npwp"<?php echo $personal->npwp->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_npwp" class="personal_npwp">
<span<?php echo $personal->npwp->ViewAttributes() ?>>
<?php echo $personal->npwp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->tgl_keluar->Visible) { // tgl_keluar ?>
		<td data-name="tgl_keluar"<?php echo $personal->tgl_keluar->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_tgl_keluar" class="personal_tgl_keluar">
<span<?php echo $personal->tgl_keluar->ViewAttributes() ?>>
<?php echo $personal->tgl_keluar->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->nama_nasabah->Visible) { // nama_nasabah ?>
		<td data-name="nama_nasabah"<?php echo $personal->nama_nasabah->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_nama_nasabah" class="personal_nama_nasabah">
<span<?php echo $personal->nama_nasabah->ViewAttributes() ?>>
<?php echo $personal->nama_nasabah->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->no_ktp->Visible) { // no_ktp ?>
		<td data-name="no_ktp"<?php echo $personal->no_ktp->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_no_ktp" class="personal_no_ktp">
<span<?php echo $personal->no_ktp->ViewAttributes() ?>>
<?php echo $personal->no_ktp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->no_kokar->Visible) { // no_kokar ?>
		<td data-name="no_kokar"<?php echo $personal->no_kokar->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_no_kokar" class="personal_no_kokar">
<span<?php echo $personal->no_kokar->ViewAttributes() ?>>
<?php echo $personal->no_kokar->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->no_bmw->Visible) { // no_bmw ?>
		<td data-name="no_bmw"<?php echo $personal->no_bmw->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_no_bmw" class="personal_no_bmw">
<span<?php echo $personal->no_bmw->ViewAttributes() ?>>
<?php echo $personal->no_bmw->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->no_bpjs_ketenagakerjaan->Visible) { // no_bpjs_ketenagakerjaan ?>
		<td data-name="no_bpjs_ketenagakerjaan"<?php echo $personal->no_bpjs_ketenagakerjaan->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_no_bpjs_ketenagakerjaan" class="personal_no_bpjs_ketenagakerjaan">
<span<?php echo $personal->no_bpjs_ketenagakerjaan->ViewAttributes() ?>>
<?php echo $personal->no_bpjs_ketenagakerjaan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->no_bpjs_kesehatan->Visible) { // no_bpjs_kesehatan ?>
		<td data-name="no_bpjs_kesehatan"<?php echo $personal->no_bpjs_kesehatan->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_no_bpjs_kesehatan" class="personal_no_bpjs_kesehatan">
<span<?php echo $personal->no_bpjs_kesehatan->ViewAttributes() ?>>
<?php echo $personal->no_bpjs_kesehatan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->eselon->Visible) { // eselon ?>
		<td data-name="eselon"<?php echo $personal->eselon->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_eselon" class="personal_eselon">
<span<?php echo $personal->eselon->ViewAttributes() ?>>
<?php echo $personal->eselon->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_jenjang->Visible) { // kd_jenjang ?>
		<td data-name="kd_jenjang"<?php echo $personal->kd_jenjang->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_jenjang" class="personal_kd_jenjang">
<span<?php echo $personal->kd_jenjang->ViewAttributes() ?>>
<?php echo $personal->kd_jenjang->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_jbt_esl->Visible) { // kd_jbt_esl ?>
		<td data-name="kd_jbt_esl"<?php echo $personal->kd_jbt_esl->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_jbt_esl" class="personal_kd_jbt_esl">
<span<?php echo $personal->kd_jbt_esl->ViewAttributes() ?>>
<?php echo $personal->kd_jbt_esl->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->tgl_jbt_esl->Visible) { // tgl_jbt_esl ?>
		<td data-name="tgl_jbt_esl"<?php echo $personal->tgl_jbt_esl->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_tgl_jbt_esl" class="personal_tgl_jbt_esl">
<span<?php echo $personal->tgl_jbt_esl->ViewAttributes() ?>>
<?php echo $personal->tgl_jbt_esl->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->org_id->Visible) { // org_id ?>
		<td data-name="org_id"<?php echo $personal->org_id->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_org_id" class="personal_org_id">
<span<?php echo $personal->org_id->ViewAttributes() ?>>
<?php echo $personal->org_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->kd_payroll->Visible) { // kd_payroll ?>
		<td data-name="kd_payroll"<?php echo $personal->kd_payroll->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_kd_payroll" class="personal_kd_payroll">
<span<?php echo $personal->kd_payroll->ViewAttributes() ?>>
<?php echo $personal->kd_payroll->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->id_wn->Visible) { // id_wn ?>
		<td data-name="id_wn"<?php echo $personal->id_wn->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_id_wn" class="personal_id_wn">
<span<?php echo $personal->id_wn->ViewAttributes() ?>>
<?php echo $personal->id_wn->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($personal->no_anggota_kkms->Visible) { // no_anggota_kkms ?>
		<td data-name="no_anggota_kkms"<?php echo $personal->no_anggota_kkms->CellAttributes() ?>>
<span id="el<?php echo $personal_list->RowCnt ?>_personal_no_anggota_kkms" class="personal_no_anggota_kkms">
<span<?php echo $personal->no_anggota_kkms->ViewAttributes() ?>>
<?php echo $personal->no_anggota_kkms->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$personal_list->ListOptions->Render("body", "right", $personal_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($personal->CurrentAction <> "gridadd")
		$personal_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($personal->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($personal_list->Recordset)
	$personal_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($personal->CurrentAction <> "gridadd" && $personal->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($personal_list->Pager)) $personal_list->Pager = new cPrevNextPager($personal_list->StartRec, $personal_list->DisplayRecs, $personal_list->TotalRecs, $personal_list->AutoHidePager) ?>
<?php if ($personal_list->Pager->RecordCount > 0 && $personal_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($personal_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $personal_list->PageUrl() ?>start=<?php echo $personal_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($personal_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $personal_list->PageUrl() ?>start=<?php echo $personal_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $personal_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($personal_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $personal_list->PageUrl() ?>start=<?php echo $personal_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($personal_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $personal_list->PageUrl() ?>start=<?php echo $personal_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $personal_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($personal_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $personal_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $personal_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $personal_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($personal_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($personal_list->TotalRecs == 0 && $personal->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($personal_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fpersonallistsrch.FilterList = <?php echo $personal_list->GetFilterList() ?>;
fpersonallistsrch.Init();
fpersonallist.Init();
</script>
<?php
$personal_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$personal_list->Page_Terminate();
?>
