<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "st_latihinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$st_latih_list = NULL; // Initialize page object first

class cst_latih_list extends cst_latih {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'st_latih';

	// Page object name
	var $PageObjName = 'st_latih_list';

	// Grid form hidden field names
	var $FormName = 'fst_latihlist';
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

		// Table object (st_latih)
		if (!isset($GLOBALS["st_latih"]) || get_class($GLOBALS["st_latih"]) == "cst_latih") {
			$GLOBALS["st_latih"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["st_latih"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "st_latihadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "st_latihdelete.php";
		$this->MultiUpdateUrl = "st_latihupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'st_latih', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fst_latihlistsrch";

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
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->no_st->SetVisibility();
		$this->tgl_st->SetVisibility();
		$this->employee_id->SetVisibility();
		$this->kd_latih->SetVisibility();
		$this->tgl_mulai->SetVisibility();
		$this->tgl_akhir->SetVisibility();
		$this->kd_lmbg->SetVisibility();
		$this->kd_jbt->SetVisibility();
		$this->jam->SetVisibility();
		$this->tempat->SetVisibility();
		$this->app->SetVisibility();
		$this->app_empid->SetVisibility();
		$this->app_jbt->SetVisibility();
		$this->app_date->SetVisibility();
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();
		$this->sertifikat->SetVisibility();

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
		global $EW_EXPORT, $st_latih;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($st_latih);
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
		if (count($arrKeyFlds) >= 3) {
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
			$this->no_st->setFormValue($arrKeyFlds[1]);
			$this->employee_id->setFormValue($arrKeyFlds[2]);
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fst_latihlistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJson(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->no_st->AdvancedSearch->ToJson(), ","); // Field no_st
		$sFilterList = ew_Concat($sFilterList, $this->tgl_st->AdvancedSearch->ToJson(), ","); // Field tgl_st
		$sFilterList = ew_Concat($sFilterList, $this->employee_id->AdvancedSearch->ToJson(), ","); // Field employee_id
		$sFilterList = ew_Concat($sFilterList, $this->kd_latih->AdvancedSearch->ToJson(), ","); // Field kd_latih
		$sFilterList = ew_Concat($sFilterList, $this->tgl_mulai->AdvancedSearch->ToJson(), ","); // Field tgl_mulai
		$sFilterList = ew_Concat($sFilterList, $this->tgl_akhir->AdvancedSearch->ToJson(), ","); // Field tgl_akhir
		$sFilterList = ew_Concat($sFilterList, $this->kd_lmbg->AdvancedSearch->ToJson(), ","); // Field kd_lmbg
		$sFilterList = ew_Concat($sFilterList, $this->kd_jbt->AdvancedSearch->ToJson(), ","); // Field kd_jbt
		$sFilterList = ew_Concat($sFilterList, $this->jam->AdvancedSearch->ToJson(), ","); // Field jam
		$sFilterList = ew_Concat($sFilterList, $this->tempat->AdvancedSearch->ToJson(), ","); // Field tempat
		$sFilterList = ew_Concat($sFilterList, $this->app->AdvancedSearch->ToJson(), ","); // Field app
		$sFilterList = ew_Concat($sFilterList, $this->app_empid->AdvancedSearch->ToJson(), ","); // Field app_empid
		$sFilterList = ew_Concat($sFilterList, $this->app_jbt->AdvancedSearch->ToJson(), ","); // Field app_jbt
		$sFilterList = ew_Concat($sFilterList, $this->app_date->AdvancedSearch->ToJson(), ","); // Field app_date
		$sFilterList = ew_Concat($sFilterList, $this->created_by->AdvancedSearch->ToJson(), ","); // Field created_by
		$sFilterList = ew_Concat($sFilterList, $this->created_date->AdvancedSearch->ToJson(), ","); // Field created_date
		$sFilterList = ew_Concat($sFilterList, $this->last_update_by->AdvancedSearch->ToJson(), ","); // Field last_update_by
		$sFilterList = ew_Concat($sFilterList, $this->last_update_date->AdvancedSearch->ToJson(), ","); // Field last_update_date
		$sFilterList = ew_Concat($sFilterList, $this->sertifikat->AdvancedSearch->ToJson(), ","); // Field sertifikat
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fst_latihlistsrch", $filters);

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

		// Field id
		$this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
		$this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
		$this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
		$this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
		$this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
		$this->id->AdvancedSearch->Save();

		// Field no_st
		$this->no_st->AdvancedSearch->SearchValue = @$filter["x_no_st"];
		$this->no_st->AdvancedSearch->SearchOperator = @$filter["z_no_st"];
		$this->no_st->AdvancedSearch->SearchCondition = @$filter["v_no_st"];
		$this->no_st->AdvancedSearch->SearchValue2 = @$filter["y_no_st"];
		$this->no_st->AdvancedSearch->SearchOperator2 = @$filter["w_no_st"];
		$this->no_st->AdvancedSearch->Save();

		// Field tgl_st
		$this->tgl_st->AdvancedSearch->SearchValue = @$filter["x_tgl_st"];
		$this->tgl_st->AdvancedSearch->SearchOperator = @$filter["z_tgl_st"];
		$this->tgl_st->AdvancedSearch->SearchCondition = @$filter["v_tgl_st"];
		$this->tgl_st->AdvancedSearch->SearchValue2 = @$filter["y_tgl_st"];
		$this->tgl_st->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_st"];
		$this->tgl_st->AdvancedSearch->Save();

		// Field employee_id
		$this->employee_id->AdvancedSearch->SearchValue = @$filter["x_employee_id"];
		$this->employee_id->AdvancedSearch->SearchOperator = @$filter["z_employee_id"];
		$this->employee_id->AdvancedSearch->SearchCondition = @$filter["v_employee_id"];
		$this->employee_id->AdvancedSearch->SearchValue2 = @$filter["y_employee_id"];
		$this->employee_id->AdvancedSearch->SearchOperator2 = @$filter["w_employee_id"];
		$this->employee_id->AdvancedSearch->Save();

		// Field kd_latih
		$this->kd_latih->AdvancedSearch->SearchValue = @$filter["x_kd_latih"];
		$this->kd_latih->AdvancedSearch->SearchOperator = @$filter["z_kd_latih"];
		$this->kd_latih->AdvancedSearch->SearchCondition = @$filter["v_kd_latih"];
		$this->kd_latih->AdvancedSearch->SearchValue2 = @$filter["y_kd_latih"];
		$this->kd_latih->AdvancedSearch->SearchOperator2 = @$filter["w_kd_latih"];
		$this->kd_latih->AdvancedSearch->Save();

		// Field tgl_mulai
		$this->tgl_mulai->AdvancedSearch->SearchValue = @$filter["x_tgl_mulai"];
		$this->tgl_mulai->AdvancedSearch->SearchOperator = @$filter["z_tgl_mulai"];
		$this->tgl_mulai->AdvancedSearch->SearchCondition = @$filter["v_tgl_mulai"];
		$this->tgl_mulai->AdvancedSearch->SearchValue2 = @$filter["y_tgl_mulai"];
		$this->tgl_mulai->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_mulai"];
		$this->tgl_mulai->AdvancedSearch->Save();

		// Field tgl_akhir
		$this->tgl_akhir->AdvancedSearch->SearchValue = @$filter["x_tgl_akhir"];
		$this->tgl_akhir->AdvancedSearch->SearchOperator = @$filter["z_tgl_akhir"];
		$this->tgl_akhir->AdvancedSearch->SearchCondition = @$filter["v_tgl_akhir"];
		$this->tgl_akhir->AdvancedSearch->SearchValue2 = @$filter["y_tgl_akhir"];
		$this->tgl_akhir->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_akhir"];
		$this->tgl_akhir->AdvancedSearch->Save();

		// Field kd_lmbg
		$this->kd_lmbg->AdvancedSearch->SearchValue = @$filter["x_kd_lmbg"];
		$this->kd_lmbg->AdvancedSearch->SearchOperator = @$filter["z_kd_lmbg"];
		$this->kd_lmbg->AdvancedSearch->SearchCondition = @$filter["v_kd_lmbg"];
		$this->kd_lmbg->AdvancedSearch->SearchValue2 = @$filter["y_kd_lmbg"];
		$this->kd_lmbg->AdvancedSearch->SearchOperator2 = @$filter["w_kd_lmbg"];
		$this->kd_lmbg->AdvancedSearch->Save();

		// Field kd_jbt
		$this->kd_jbt->AdvancedSearch->SearchValue = @$filter["x_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->SearchOperator = @$filter["z_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->SearchCondition = @$filter["v_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->SearchValue2 = @$filter["y_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->SearchOperator2 = @$filter["w_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->Save();

		// Field jam
		$this->jam->AdvancedSearch->SearchValue = @$filter["x_jam"];
		$this->jam->AdvancedSearch->SearchOperator = @$filter["z_jam"];
		$this->jam->AdvancedSearch->SearchCondition = @$filter["v_jam"];
		$this->jam->AdvancedSearch->SearchValue2 = @$filter["y_jam"];
		$this->jam->AdvancedSearch->SearchOperator2 = @$filter["w_jam"];
		$this->jam->AdvancedSearch->Save();

		// Field tempat
		$this->tempat->AdvancedSearch->SearchValue = @$filter["x_tempat"];
		$this->tempat->AdvancedSearch->SearchOperator = @$filter["z_tempat"];
		$this->tempat->AdvancedSearch->SearchCondition = @$filter["v_tempat"];
		$this->tempat->AdvancedSearch->SearchValue2 = @$filter["y_tempat"];
		$this->tempat->AdvancedSearch->SearchOperator2 = @$filter["w_tempat"];
		$this->tempat->AdvancedSearch->Save();

		// Field app
		$this->app->AdvancedSearch->SearchValue = @$filter["x_app"];
		$this->app->AdvancedSearch->SearchOperator = @$filter["z_app"];
		$this->app->AdvancedSearch->SearchCondition = @$filter["v_app"];
		$this->app->AdvancedSearch->SearchValue2 = @$filter["y_app"];
		$this->app->AdvancedSearch->SearchOperator2 = @$filter["w_app"];
		$this->app->AdvancedSearch->Save();

		// Field app_empid
		$this->app_empid->AdvancedSearch->SearchValue = @$filter["x_app_empid"];
		$this->app_empid->AdvancedSearch->SearchOperator = @$filter["z_app_empid"];
		$this->app_empid->AdvancedSearch->SearchCondition = @$filter["v_app_empid"];
		$this->app_empid->AdvancedSearch->SearchValue2 = @$filter["y_app_empid"];
		$this->app_empid->AdvancedSearch->SearchOperator2 = @$filter["w_app_empid"];
		$this->app_empid->AdvancedSearch->Save();

		// Field app_jbt
		$this->app_jbt->AdvancedSearch->SearchValue = @$filter["x_app_jbt"];
		$this->app_jbt->AdvancedSearch->SearchOperator = @$filter["z_app_jbt"];
		$this->app_jbt->AdvancedSearch->SearchCondition = @$filter["v_app_jbt"];
		$this->app_jbt->AdvancedSearch->SearchValue2 = @$filter["y_app_jbt"];
		$this->app_jbt->AdvancedSearch->SearchOperator2 = @$filter["w_app_jbt"];
		$this->app_jbt->AdvancedSearch->Save();

		// Field app_date
		$this->app_date->AdvancedSearch->SearchValue = @$filter["x_app_date"];
		$this->app_date->AdvancedSearch->SearchOperator = @$filter["z_app_date"];
		$this->app_date->AdvancedSearch->SearchCondition = @$filter["v_app_date"];
		$this->app_date->AdvancedSearch->SearchValue2 = @$filter["y_app_date"];
		$this->app_date->AdvancedSearch->SearchOperator2 = @$filter["w_app_date"];
		$this->app_date->AdvancedSearch->Save();

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

		// Field sertifikat
		$this->sertifikat->AdvancedSearch->SearchValue = @$filter["x_sertifikat"];
		$this->sertifikat->AdvancedSearch->SearchOperator = @$filter["z_sertifikat"];
		$this->sertifikat->AdvancedSearch->SearchCondition = @$filter["v_sertifikat"];
		$this->sertifikat->AdvancedSearch->SearchValue2 = @$filter["y_sertifikat"];
		$this->sertifikat->AdvancedSearch->SearchOperator2 = @$filter["w_sertifikat"];
		$this->sertifikat->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->no_st, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->employee_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_latih, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_lmbg, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_jbt, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jam, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->tempat, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->app, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->app_empid, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->app_jbt, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->created_by, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->last_update_by, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->sertifikat, $arKeywords, $type);
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
			$this->UpdateSort($this->id); // id
			$this->UpdateSort($this->no_st); // no_st
			$this->UpdateSort($this->tgl_st); // tgl_st
			$this->UpdateSort($this->employee_id); // employee_id
			$this->UpdateSort($this->kd_latih); // kd_latih
			$this->UpdateSort($this->tgl_mulai); // tgl_mulai
			$this->UpdateSort($this->tgl_akhir); // tgl_akhir
			$this->UpdateSort($this->kd_lmbg); // kd_lmbg
			$this->UpdateSort($this->kd_jbt); // kd_jbt
			$this->UpdateSort($this->jam); // jam
			$this->UpdateSort($this->tempat); // tempat
			$this->UpdateSort($this->app); // app
			$this->UpdateSort($this->app_empid); // app_empid
			$this->UpdateSort($this->app_jbt); // app_jbt
			$this->UpdateSort($this->app_date); // app_date
			$this->UpdateSort($this->created_by); // created_by
			$this->UpdateSort($this->created_date); // created_date
			$this->UpdateSort($this->last_update_by); // last_update_by
			$this->UpdateSort($this->last_update_date); // last_update_date
			$this->UpdateSort($this->sertifikat); // sertifikat
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
				$this->id->setSort("");
				$this->no_st->setSort("");
				$this->tgl_st->setSort("");
				$this->employee_id->setSort("");
				$this->kd_latih->setSort("");
				$this->tgl_mulai->setSort("");
				$this->tgl_akhir->setSort("");
				$this->kd_lmbg->setSort("");
				$this->kd_jbt->setSort("");
				$this->jam->setSort("");
				$this->tempat->setSort("");
				$this->app->setSort("");
				$this->app_empid->setSort("");
				$this->app_jbt->setSort("");
				$this->app_date->setSort("");
				$this->created_by->setSort("");
				$this->created_date->setSort("");
				$this->last_update_by->setSort("");
				$this->last_update_date->setSort("");
				$this->sertifikat->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->no_st->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->employee_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fst_latihlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fst_latihlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fst_latihlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fst_latihlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$this->id->setDbValue($row['id']);
		$this->no_st->setDbValue($row['no_st']);
		$this->tgl_st->setDbValue($row['tgl_st']);
		$this->employee_id->setDbValue($row['employee_id']);
		$this->kd_latih->setDbValue($row['kd_latih']);
		$this->tgl_mulai->setDbValue($row['tgl_mulai']);
		$this->tgl_akhir->setDbValue($row['tgl_akhir']);
		$this->kd_lmbg->setDbValue($row['kd_lmbg']);
		$this->kd_jbt->setDbValue($row['kd_jbt']);
		$this->jam->setDbValue($row['jam']);
		$this->tempat->setDbValue($row['tempat']);
		$this->app->setDbValue($row['app']);
		$this->app_empid->setDbValue($row['app_empid']);
		$this->app_jbt->setDbValue($row['app_jbt']);
		$this->app_date->setDbValue($row['app_date']);
		$this->created_by->setDbValue($row['created_by']);
		$this->created_date->setDbValue($row['created_date']);
		$this->last_update_by->setDbValue($row['last_update_by']);
		$this->last_update_date->setDbValue($row['last_update_date']);
		$this->sertifikat->setDbValue($row['sertifikat']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['no_st'] = NULL;
		$row['tgl_st'] = NULL;
		$row['employee_id'] = NULL;
		$row['kd_latih'] = NULL;
		$row['tgl_mulai'] = NULL;
		$row['tgl_akhir'] = NULL;
		$row['kd_lmbg'] = NULL;
		$row['kd_jbt'] = NULL;
		$row['jam'] = NULL;
		$row['tempat'] = NULL;
		$row['app'] = NULL;
		$row['app_empid'] = NULL;
		$row['app_jbt'] = NULL;
		$row['app_date'] = NULL;
		$row['created_by'] = NULL;
		$row['created_date'] = NULL;
		$row['last_update_by'] = NULL;
		$row['last_update_date'] = NULL;
		$row['sertifikat'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->no_st->DbValue = $row['no_st'];
		$this->tgl_st->DbValue = $row['tgl_st'];
		$this->employee_id->DbValue = $row['employee_id'];
		$this->kd_latih->DbValue = $row['kd_latih'];
		$this->tgl_mulai->DbValue = $row['tgl_mulai'];
		$this->tgl_akhir->DbValue = $row['tgl_akhir'];
		$this->kd_lmbg->DbValue = $row['kd_lmbg'];
		$this->kd_jbt->DbValue = $row['kd_jbt'];
		$this->jam->DbValue = $row['jam'];
		$this->tempat->DbValue = $row['tempat'];
		$this->app->DbValue = $row['app'];
		$this->app_empid->DbValue = $row['app_empid'];
		$this->app_jbt->DbValue = $row['app_jbt'];
		$this->app_date->DbValue = $row['app_date'];
		$this->created_by->DbValue = $row['created_by'];
		$this->created_date->DbValue = $row['created_date'];
		$this->last_update_by->DbValue = $row['last_update_by'];
		$this->last_update_date->DbValue = $row['last_update_date'];
		$this->sertifikat->DbValue = $row['sertifikat'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("no_st")) <> "")
			$this->no_st->CurrentValue = $this->getKey("no_st"); // no_st
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// no_st
		// tgl_st
		// employee_id
		// kd_latih
		// tgl_mulai
		// tgl_akhir
		// kd_lmbg
		// kd_jbt
		// jam
		// tempat
		// app
		// app_empid
		// app_jbt
		// app_date
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// sertifikat

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// no_st
		$this->no_st->ViewValue = $this->no_st->CurrentValue;
		$this->no_st->ViewCustomAttributes = "";

		// tgl_st
		$this->tgl_st->ViewValue = $this->tgl_st->CurrentValue;
		$this->tgl_st->ViewValue = ew_FormatDateTime($this->tgl_st->ViewValue, 0);
		$this->tgl_st->ViewCustomAttributes = "";

		// employee_id
		$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
		$this->employee_id->ViewCustomAttributes = "";

		// kd_latih
		$this->kd_latih->ViewValue = $this->kd_latih->CurrentValue;
		$this->kd_latih->ViewCustomAttributes = "";

		// tgl_mulai
		$this->tgl_mulai->ViewValue = $this->tgl_mulai->CurrentValue;
		$this->tgl_mulai->ViewValue = ew_FormatDateTime($this->tgl_mulai->ViewValue, 0);
		$this->tgl_mulai->ViewCustomAttributes = "";

		// tgl_akhir
		$this->tgl_akhir->ViewValue = $this->tgl_akhir->CurrentValue;
		$this->tgl_akhir->ViewValue = ew_FormatDateTime($this->tgl_akhir->ViewValue, 0);
		$this->tgl_akhir->ViewCustomAttributes = "";

		// kd_lmbg
		$this->kd_lmbg->ViewValue = $this->kd_lmbg->CurrentValue;
		$this->kd_lmbg->ViewCustomAttributes = "";

		// kd_jbt
		$this->kd_jbt->ViewValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// jam
		$this->jam->ViewValue = $this->jam->CurrentValue;
		$this->jam->ViewCustomAttributes = "";

		// tempat
		$this->tempat->ViewValue = $this->tempat->CurrentValue;
		$this->tempat->ViewCustomAttributes = "";

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

		// sertifikat
		$this->sertifikat->ViewValue = $this->sertifikat->CurrentValue;
		$this->sertifikat->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// no_st
			$this->no_st->LinkCustomAttributes = "";
			$this->no_st->HrefValue = "";
			$this->no_st->TooltipValue = "";

			// tgl_st
			$this->tgl_st->LinkCustomAttributes = "";
			$this->tgl_st->HrefValue = "";
			$this->tgl_st->TooltipValue = "";

			// employee_id
			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";
			$this->employee_id->TooltipValue = "";

			// kd_latih
			$this->kd_latih->LinkCustomAttributes = "";
			$this->kd_latih->HrefValue = "";
			$this->kd_latih->TooltipValue = "";

			// tgl_mulai
			$this->tgl_mulai->LinkCustomAttributes = "";
			$this->tgl_mulai->HrefValue = "";
			$this->tgl_mulai->TooltipValue = "";

			// tgl_akhir
			$this->tgl_akhir->LinkCustomAttributes = "";
			$this->tgl_akhir->HrefValue = "";
			$this->tgl_akhir->TooltipValue = "";

			// kd_lmbg
			$this->kd_lmbg->LinkCustomAttributes = "";
			$this->kd_lmbg->HrefValue = "";
			$this->kd_lmbg->TooltipValue = "";

			// kd_jbt
			$this->kd_jbt->LinkCustomAttributes = "";
			$this->kd_jbt->HrefValue = "";
			$this->kd_jbt->TooltipValue = "";

			// jam
			$this->jam->LinkCustomAttributes = "";
			$this->jam->HrefValue = "";
			$this->jam->TooltipValue = "";

			// tempat
			$this->tempat->LinkCustomAttributes = "";
			$this->tempat->HrefValue = "";
			$this->tempat->TooltipValue = "";

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

			// sertifikat
			$this->sertifikat->LinkCustomAttributes = "";
			$this->sertifikat->HrefValue = "";
			$this->sertifikat->TooltipValue = "";
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
if (!isset($st_latih_list)) $st_latih_list = new cst_latih_list();

// Page init
$st_latih_list->Page_Init();

// Page main
$st_latih_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$st_latih_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fst_latihlist = new ew_Form("fst_latihlist", "list");
fst_latihlist.FormKeyCountName = '<?php echo $st_latih_list->FormKeyCountName ?>';

// Form_CustomValidate event
fst_latihlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fst_latihlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fst_latihlistsrch = new ew_Form("fst_latihlistsrch");
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
<?php if ($st_latih_list->TotalRecs > 0 && $st_latih_list->ExportOptions->Visible()) { ?>
<?php $st_latih_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($st_latih_list->SearchOptions->Visible()) { ?>
<?php $st_latih_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($st_latih_list->FilterOptions->Visible()) { ?>
<?php $st_latih_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $st_latih_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($st_latih_list->TotalRecs <= 0)
			$st_latih_list->TotalRecs = $st_latih->ListRecordCount();
	} else {
		if (!$st_latih_list->Recordset && ($st_latih_list->Recordset = $st_latih_list->LoadRecordset()))
			$st_latih_list->TotalRecs = $st_latih_list->Recordset->RecordCount();
	}
	$st_latih_list->StartRec = 1;
	if ($st_latih_list->DisplayRecs <= 0 || ($st_latih->Export <> "" && $st_latih->ExportAll)) // Display all records
		$st_latih_list->DisplayRecs = $st_latih_list->TotalRecs;
	if (!($st_latih->Export <> "" && $st_latih->ExportAll))
		$st_latih_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$st_latih_list->Recordset = $st_latih_list->LoadRecordset($st_latih_list->StartRec-1, $st_latih_list->DisplayRecs);

	// Set no record found message
	if ($st_latih->CurrentAction == "" && $st_latih_list->TotalRecs == 0) {
		if ($st_latih_list->SearchWhere == "0=101")
			$st_latih_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$st_latih_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$st_latih_list->RenderOtherOptions();
?>
<?php if ($st_latih->Export == "" && $st_latih->CurrentAction == "") { ?>
<form name="fst_latihlistsrch" id="fst_latihlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($st_latih_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fst_latihlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="st_latih">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($st_latih_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($st_latih_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $st_latih_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($st_latih_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($st_latih_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($st_latih_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($st_latih_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $st_latih_list->ShowPageHeader(); ?>
<?php
$st_latih_list->ShowMessage();
?>
<?php if ($st_latih_list->TotalRecs > 0 || $st_latih->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($st_latih_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> st_latih">
<form name="fst_latihlist" id="fst_latihlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($st_latih_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $st_latih_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="st_latih">
<div id="gmp_st_latih" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($st_latih_list->TotalRecs > 0 || $st_latih->CurrentAction == "gridedit") { ?>
<table id="tbl_st_latihlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$st_latih_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$st_latih_list->RenderListOptions();

// Render list options (header, left)
$st_latih_list->ListOptions->Render("header", "left");
?>
<?php if ($st_latih->id->Visible) { // id ?>
	<?php if ($st_latih->SortUrl($st_latih->id) == "") { ?>
		<th data-name="id" class="<?php echo $st_latih->id->HeaderCellClass() ?>"><div id="elh_st_latih_id" class="st_latih_id"><div class="ewTableHeaderCaption"><?php echo $st_latih->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $st_latih->id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->id) ?>',1);"><div id="elh_st_latih_id" class="st_latih_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->no_st->Visible) { // no_st ?>
	<?php if ($st_latih->SortUrl($st_latih->no_st) == "") { ?>
		<th data-name="no_st" class="<?php echo $st_latih->no_st->HeaderCellClass() ?>"><div id="elh_st_latih_no_st" class="st_latih_no_st"><div class="ewTableHeaderCaption"><?php echo $st_latih->no_st->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_st" class="<?php echo $st_latih->no_st->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->no_st) ?>',1);"><div id="elh_st_latih_no_st" class="st_latih_no_st">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->no_st->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->no_st->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->no_st->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->tgl_st->Visible) { // tgl_st ?>
	<?php if ($st_latih->SortUrl($st_latih->tgl_st) == "") { ?>
		<th data-name="tgl_st" class="<?php echo $st_latih->tgl_st->HeaderCellClass() ?>"><div id="elh_st_latih_tgl_st" class="st_latih_tgl_st"><div class="ewTableHeaderCaption"><?php echo $st_latih->tgl_st->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_st" class="<?php echo $st_latih->tgl_st->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->tgl_st) ?>',1);"><div id="elh_st_latih_tgl_st" class="st_latih_tgl_st">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->tgl_st->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->tgl_st->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->tgl_st->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->employee_id->Visible) { // employee_id ?>
	<?php if ($st_latih->SortUrl($st_latih->employee_id) == "") { ?>
		<th data-name="employee_id" class="<?php echo $st_latih->employee_id->HeaderCellClass() ?>"><div id="elh_st_latih_employee_id" class="st_latih_employee_id"><div class="ewTableHeaderCaption"><?php echo $st_latih->employee_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="employee_id" class="<?php echo $st_latih->employee_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->employee_id) ?>',1);"><div id="elh_st_latih_employee_id" class="st_latih_employee_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->employee_id->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->employee_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->employee_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->kd_latih->Visible) { // kd_latih ?>
	<?php if ($st_latih->SortUrl($st_latih->kd_latih) == "") { ?>
		<th data-name="kd_latih" class="<?php echo $st_latih->kd_latih->HeaderCellClass() ?>"><div id="elh_st_latih_kd_latih" class="st_latih_kd_latih"><div class="ewTableHeaderCaption"><?php echo $st_latih->kd_latih->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_latih" class="<?php echo $st_latih->kd_latih->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->kd_latih) ?>',1);"><div id="elh_st_latih_kd_latih" class="st_latih_kd_latih">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->kd_latih->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->kd_latih->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->kd_latih->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->tgl_mulai->Visible) { // tgl_mulai ?>
	<?php if ($st_latih->SortUrl($st_latih->tgl_mulai) == "") { ?>
		<th data-name="tgl_mulai" class="<?php echo $st_latih->tgl_mulai->HeaderCellClass() ?>"><div id="elh_st_latih_tgl_mulai" class="st_latih_tgl_mulai"><div class="ewTableHeaderCaption"><?php echo $st_latih->tgl_mulai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_mulai" class="<?php echo $st_latih->tgl_mulai->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->tgl_mulai) ?>',1);"><div id="elh_st_latih_tgl_mulai" class="st_latih_tgl_mulai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->tgl_mulai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->tgl_mulai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->tgl_mulai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->tgl_akhir->Visible) { // tgl_akhir ?>
	<?php if ($st_latih->SortUrl($st_latih->tgl_akhir) == "") { ?>
		<th data-name="tgl_akhir" class="<?php echo $st_latih->tgl_akhir->HeaderCellClass() ?>"><div id="elh_st_latih_tgl_akhir" class="st_latih_tgl_akhir"><div class="ewTableHeaderCaption"><?php echo $st_latih->tgl_akhir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_akhir" class="<?php echo $st_latih->tgl_akhir->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->tgl_akhir) ?>',1);"><div id="elh_st_latih_tgl_akhir" class="st_latih_tgl_akhir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->tgl_akhir->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->tgl_akhir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->tgl_akhir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->kd_lmbg->Visible) { // kd_lmbg ?>
	<?php if ($st_latih->SortUrl($st_latih->kd_lmbg) == "") { ?>
		<th data-name="kd_lmbg" class="<?php echo $st_latih->kd_lmbg->HeaderCellClass() ?>"><div id="elh_st_latih_kd_lmbg" class="st_latih_kd_lmbg"><div class="ewTableHeaderCaption"><?php echo $st_latih->kd_lmbg->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_lmbg" class="<?php echo $st_latih->kd_lmbg->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->kd_lmbg) ?>',1);"><div id="elh_st_latih_kd_lmbg" class="st_latih_kd_lmbg">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->kd_lmbg->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->kd_lmbg->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->kd_lmbg->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->kd_jbt->Visible) { // kd_jbt ?>
	<?php if ($st_latih->SortUrl($st_latih->kd_jbt) == "") { ?>
		<th data-name="kd_jbt" class="<?php echo $st_latih->kd_jbt->HeaderCellClass() ?>"><div id="elh_st_latih_kd_jbt" class="st_latih_kd_jbt"><div class="ewTableHeaderCaption"><?php echo $st_latih->kd_jbt->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_jbt" class="<?php echo $st_latih->kd_jbt->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->kd_jbt) ?>',1);"><div id="elh_st_latih_kd_jbt" class="st_latih_kd_jbt">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->kd_jbt->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->kd_jbt->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->kd_jbt->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->jam->Visible) { // jam ?>
	<?php if ($st_latih->SortUrl($st_latih->jam) == "") { ?>
		<th data-name="jam" class="<?php echo $st_latih->jam->HeaderCellClass() ?>"><div id="elh_st_latih_jam" class="st_latih_jam"><div class="ewTableHeaderCaption"><?php echo $st_latih->jam->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jam" class="<?php echo $st_latih->jam->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->jam) ?>',1);"><div id="elh_st_latih_jam" class="st_latih_jam">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->jam->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->jam->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->jam->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->tempat->Visible) { // tempat ?>
	<?php if ($st_latih->SortUrl($st_latih->tempat) == "") { ?>
		<th data-name="tempat" class="<?php echo $st_latih->tempat->HeaderCellClass() ?>"><div id="elh_st_latih_tempat" class="st_latih_tempat"><div class="ewTableHeaderCaption"><?php echo $st_latih->tempat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tempat" class="<?php echo $st_latih->tempat->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->tempat) ?>',1);"><div id="elh_st_latih_tempat" class="st_latih_tempat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->tempat->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->tempat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->tempat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->app->Visible) { // app ?>
	<?php if ($st_latih->SortUrl($st_latih->app) == "") { ?>
		<th data-name="app" class="<?php echo $st_latih->app->HeaderCellClass() ?>"><div id="elh_st_latih_app" class="st_latih_app"><div class="ewTableHeaderCaption"><?php echo $st_latih->app->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="app" class="<?php echo $st_latih->app->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->app) ?>',1);"><div id="elh_st_latih_app" class="st_latih_app">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->app->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->app->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->app->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->app_empid->Visible) { // app_empid ?>
	<?php if ($st_latih->SortUrl($st_latih->app_empid) == "") { ?>
		<th data-name="app_empid" class="<?php echo $st_latih->app_empid->HeaderCellClass() ?>"><div id="elh_st_latih_app_empid" class="st_latih_app_empid"><div class="ewTableHeaderCaption"><?php echo $st_latih->app_empid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="app_empid" class="<?php echo $st_latih->app_empid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->app_empid) ?>',1);"><div id="elh_st_latih_app_empid" class="st_latih_app_empid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->app_empid->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->app_empid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->app_empid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->app_jbt->Visible) { // app_jbt ?>
	<?php if ($st_latih->SortUrl($st_latih->app_jbt) == "") { ?>
		<th data-name="app_jbt" class="<?php echo $st_latih->app_jbt->HeaderCellClass() ?>"><div id="elh_st_latih_app_jbt" class="st_latih_app_jbt"><div class="ewTableHeaderCaption"><?php echo $st_latih->app_jbt->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="app_jbt" class="<?php echo $st_latih->app_jbt->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->app_jbt) ?>',1);"><div id="elh_st_latih_app_jbt" class="st_latih_app_jbt">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->app_jbt->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->app_jbt->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->app_jbt->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->app_date->Visible) { // app_date ?>
	<?php if ($st_latih->SortUrl($st_latih->app_date) == "") { ?>
		<th data-name="app_date" class="<?php echo $st_latih->app_date->HeaderCellClass() ?>"><div id="elh_st_latih_app_date" class="st_latih_app_date"><div class="ewTableHeaderCaption"><?php echo $st_latih->app_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="app_date" class="<?php echo $st_latih->app_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->app_date) ?>',1);"><div id="elh_st_latih_app_date" class="st_latih_app_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->app_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->app_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->app_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->created_by->Visible) { // created_by ?>
	<?php if ($st_latih->SortUrl($st_latih->created_by) == "") { ?>
		<th data-name="created_by" class="<?php echo $st_latih->created_by->HeaderCellClass() ?>"><div id="elh_st_latih_created_by" class="st_latih_created_by"><div class="ewTableHeaderCaption"><?php echo $st_latih->created_by->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="created_by" class="<?php echo $st_latih->created_by->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->created_by) ?>',1);"><div id="elh_st_latih_created_by" class="st_latih_created_by">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->created_by->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->created_by->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->created_by->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->created_date->Visible) { // created_date ?>
	<?php if ($st_latih->SortUrl($st_latih->created_date) == "") { ?>
		<th data-name="created_date" class="<?php echo $st_latih->created_date->HeaderCellClass() ?>"><div id="elh_st_latih_created_date" class="st_latih_created_date"><div class="ewTableHeaderCaption"><?php echo $st_latih->created_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="created_date" class="<?php echo $st_latih->created_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->created_date) ?>',1);"><div id="elh_st_latih_created_date" class="st_latih_created_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->created_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->created_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->created_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->last_update_by->Visible) { // last_update_by ?>
	<?php if ($st_latih->SortUrl($st_latih->last_update_by) == "") { ?>
		<th data-name="last_update_by" class="<?php echo $st_latih->last_update_by->HeaderCellClass() ?>"><div id="elh_st_latih_last_update_by" class="st_latih_last_update_by"><div class="ewTableHeaderCaption"><?php echo $st_latih->last_update_by->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="last_update_by" class="<?php echo $st_latih->last_update_by->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->last_update_by) ?>',1);"><div id="elh_st_latih_last_update_by" class="st_latih_last_update_by">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->last_update_by->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->last_update_by->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->last_update_by->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->last_update_date->Visible) { // last_update_date ?>
	<?php if ($st_latih->SortUrl($st_latih->last_update_date) == "") { ?>
		<th data-name="last_update_date" class="<?php echo $st_latih->last_update_date->HeaderCellClass() ?>"><div id="elh_st_latih_last_update_date" class="st_latih_last_update_date"><div class="ewTableHeaderCaption"><?php echo $st_latih->last_update_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="last_update_date" class="<?php echo $st_latih->last_update_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->last_update_date) ?>',1);"><div id="elh_st_latih_last_update_date" class="st_latih_last_update_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->last_update_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->last_update_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->last_update_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($st_latih->sertifikat->Visible) { // sertifikat ?>
	<?php if ($st_latih->SortUrl($st_latih->sertifikat) == "") { ?>
		<th data-name="sertifikat" class="<?php echo $st_latih->sertifikat->HeaderCellClass() ?>"><div id="elh_st_latih_sertifikat" class="st_latih_sertifikat"><div class="ewTableHeaderCaption"><?php echo $st_latih->sertifikat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sertifikat" class="<?php echo $st_latih->sertifikat->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $st_latih->SortUrl($st_latih->sertifikat) ?>',1);"><div id="elh_st_latih_sertifikat" class="st_latih_sertifikat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $st_latih->sertifikat->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($st_latih->sertifikat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($st_latih->sertifikat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$st_latih_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($st_latih->ExportAll && $st_latih->Export <> "") {
	$st_latih_list->StopRec = $st_latih_list->TotalRecs;
} else {

	// Set the last record to display
	if ($st_latih_list->TotalRecs > $st_latih_list->StartRec + $st_latih_list->DisplayRecs - 1)
		$st_latih_list->StopRec = $st_latih_list->StartRec + $st_latih_list->DisplayRecs - 1;
	else
		$st_latih_list->StopRec = $st_latih_list->TotalRecs;
}
$st_latih_list->RecCnt = $st_latih_list->StartRec - 1;
if ($st_latih_list->Recordset && !$st_latih_list->Recordset->EOF) {
	$st_latih_list->Recordset->MoveFirst();
	$bSelectLimit = $st_latih_list->UseSelectLimit;
	if (!$bSelectLimit && $st_latih_list->StartRec > 1)
		$st_latih_list->Recordset->Move($st_latih_list->StartRec - 1);
} elseif (!$st_latih->AllowAddDeleteRow && $st_latih_list->StopRec == 0) {
	$st_latih_list->StopRec = $st_latih->GridAddRowCount;
}

// Initialize aggregate
$st_latih->RowType = EW_ROWTYPE_AGGREGATEINIT;
$st_latih->ResetAttrs();
$st_latih_list->RenderRow();
while ($st_latih_list->RecCnt < $st_latih_list->StopRec) {
	$st_latih_list->RecCnt++;
	if (intval($st_latih_list->RecCnt) >= intval($st_latih_list->StartRec)) {
		$st_latih_list->RowCnt++;

		// Set up key count
		$st_latih_list->KeyCount = $st_latih_list->RowIndex;

		// Init row class and style
		$st_latih->ResetAttrs();
		$st_latih->CssClass = "";
		if ($st_latih->CurrentAction == "gridadd") {
		} else {
			$st_latih_list->LoadRowValues($st_latih_list->Recordset); // Load row values
		}
		$st_latih->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$st_latih->RowAttrs = array_merge($st_latih->RowAttrs, array('data-rowindex'=>$st_latih_list->RowCnt, 'id'=>'r' . $st_latih_list->RowCnt . '_st_latih', 'data-rowtype'=>$st_latih->RowType));

		// Render row
		$st_latih_list->RenderRow();

		// Render list options
		$st_latih_list->RenderListOptions();
?>
	<tr<?php echo $st_latih->RowAttributes() ?>>
<?php

// Render list options (body, left)
$st_latih_list->ListOptions->Render("body", "left", $st_latih_list->RowCnt);
?>
	<?php if ($st_latih->id->Visible) { // id ?>
		<td data-name="id"<?php echo $st_latih->id->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_id" class="st_latih_id">
<span<?php echo $st_latih->id->ViewAttributes() ?>>
<?php echo $st_latih->id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->no_st->Visible) { // no_st ?>
		<td data-name="no_st"<?php echo $st_latih->no_st->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_no_st" class="st_latih_no_st">
<span<?php echo $st_latih->no_st->ViewAttributes() ?>>
<?php echo $st_latih->no_st->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->tgl_st->Visible) { // tgl_st ?>
		<td data-name="tgl_st"<?php echo $st_latih->tgl_st->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_tgl_st" class="st_latih_tgl_st">
<span<?php echo $st_latih->tgl_st->ViewAttributes() ?>>
<?php echo $st_latih->tgl_st->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->employee_id->Visible) { // employee_id ?>
		<td data-name="employee_id"<?php echo $st_latih->employee_id->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_employee_id" class="st_latih_employee_id">
<span<?php echo $st_latih->employee_id->ViewAttributes() ?>>
<?php echo $st_latih->employee_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->kd_latih->Visible) { // kd_latih ?>
		<td data-name="kd_latih"<?php echo $st_latih->kd_latih->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_kd_latih" class="st_latih_kd_latih">
<span<?php echo $st_latih->kd_latih->ViewAttributes() ?>>
<?php echo $st_latih->kd_latih->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->tgl_mulai->Visible) { // tgl_mulai ?>
		<td data-name="tgl_mulai"<?php echo $st_latih->tgl_mulai->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_tgl_mulai" class="st_latih_tgl_mulai">
<span<?php echo $st_latih->tgl_mulai->ViewAttributes() ?>>
<?php echo $st_latih->tgl_mulai->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->tgl_akhir->Visible) { // tgl_akhir ?>
		<td data-name="tgl_akhir"<?php echo $st_latih->tgl_akhir->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_tgl_akhir" class="st_latih_tgl_akhir">
<span<?php echo $st_latih->tgl_akhir->ViewAttributes() ?>>
<?php echo $st_latih->tgl_akhir->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->kd_lmbg->Visible) { // kd_lmbg ?>
		<td data-name="kd_lmbg"<?php echo $st_latih->kd_lmbg->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_kd_lmbg" class="st_latih_kd_lmbg">
<span<?php echo $st_latih->kd_lmbg->ViewAttributes() ?>>
<?php echo $st_latih->kd_lmbg->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->kd_jbt->Visible) { // kd_jbt ?>
		<td data-name="kd_jbt"<?php echo $st_latih->kd_jbt->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_kd_jbt" class="st_latih_kd_jbt">
<span<?php echo $st_latih->kd_jbt->ViewAttributes() ?>>
<?php echo $st_latih->kd_jbt->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->jam->Visible) { // jam ?>
		<td data-name="jam"<?php echo $st_latih->jam->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_jam" class="st_latih_jam">
<span<?php echo $st_latih->jam->ViewAttributes() ?>>
<?php echo $st_latih->jam->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->tempat->Visible) { // tempat ?>
		<td data-name="tempat"<?php echo $st_latih->tempat->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_tempat" class="st_latih_tempat">
<span<?php echo $st_latih->tempat->ViewAttributes() ?>>
<?php echo $st_latih->tempat->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->app->Visible) { // app ?>
		<td data-name="app"<?php echo $st_latih->app->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_app" class="st_latih_app">
<span<?php echo $st_latih->app->ViewAttributes() ?>>
<?php echo $st_latih->app->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->app_empid->Visible) { // app_empid ?>
		<td data-name="app_empid"<?php echo $st_latih->app_empid->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_app_empid" class="st_latih_app_empid">
<span<?php echo $st_latih->app_empid->ViewAttributes() ?>>
<?php echo $st_latih->app_empid->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->app_jbt->Visible) { // app_jbt ?>
		<td data-name="app_jbt"<?php echo $st_latih->app_jbt->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_app_jbt" class="st_latih_app_jbt">
<span<?php echo $st_latih->app_jbt->ViewAttributes() ?>>
<?php echo $st_latih->app_jbt->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->app_date->Visible) { // app_date ?>
		<td data-name="app_date"<?php echo $st_latih->app_date->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_app_date" class="st_latih_app_date">
<span<?php echo $st_latih->app_date->ViewAttributes() ?>>
<?php echo $st_latih->app_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->created_by->Visible) { // created_by ?>
		<td data-name="created_by"<?php echo $st_latih->created_by->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_created_by" class="st_latih_created_by">
<span<?php echo $st_latih->created_by->ViewAttributes() ?>>
<?php echo $st_latih->created_by->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->created_date->Visible) { // created_date ?>
		<td data-name="created_date"<?php echo $st_latih->created_date->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_created_date" class="st_latih_created_date">
<span<?php echo $st_latih->created_date->ViewAttributes() ?>>
<?php echo $st_latih->created_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->last_update_by->Visible) { // last_update_by ?>
		<td data-name="last_update_by"<?php echo $st_latih->last_update_by->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_last_update_by" class="st_latih_last_update_by">
<span<?php echo $st_latih->last_update_by->ViewAttributes() ?>>
<?php echo $st_latih->last_update_by->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->last_update_date->Visible) { // last_update_date ?>
		<td data-name="last_update_date"<?php echo $st_latih->last_update_date->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_last_update_date" class="st_latih_last_update_date">
<span<?php echo $st_latih->last_update_date->ViewAttributes() ?>>
<?php echo $st_latih->last_update_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($st_latih->sertifikat->Visible) { // sertifikat ?>
		<td data-name="sertifikat"<?php echo $st_latih->sertifikat->CellAttributes() ?>>
<span id="el<?php echo $st_latih_list->RowCnt ?>_st_latih_sertifikat" class="st_latih_sertifikat">
<span<?php echo $st_latih->sertifikat->ViewAttributes() ?>>
<?php echo $st_latih->sertifikat->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$st_latih_list->ListOptions->Render("body", "right", $st_latih_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($st_latih->CurrentAction <> "gridadd")
		$st_latih_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($st_latih->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($st_latih_list->Recordset)
	$st_latih_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($st_latih->CurrentAction <> "gridadd" && $st_latih->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($st_latih_list->Pager)) $st_latih_list->Pager = new cPrevNextPager($st_latih_list->StartRec, $st_latih_list->DisplayRecs, $st_latih_list->TotalRecs, $st_latih_list->AutoHidePager) ?>
<?php if ($st_latih_list->Pager->RecordCount > 0 && $st_latih_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($st_latih_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $st_latih_list->PageUrl() ?>start=<?php echo $st_latih_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($st_latih_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $st_latih_list->PageUrl() ?>start=<?php echo $st_latih_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $st_latih_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($st_latih_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $st_latih_list->PageUrl() ?>start=<?php echo $st_latih_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($st_latih_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $st_latih_list->PageUrl() ?>start=<?php echo $st_latih_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $st_latih_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($st_latih_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $st_latih_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $st_latih_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $st_latih_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($st_latih_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($st_latih_list->TotalRecs == 0 && $st_latih->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($st_latih_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fst_latihlistsrch.FilterList = <?php echo $st_latih_list->GetFilterList() ?>;
fst_latihlistsrch.Init();
fst_latihlist.Init();
</script>
<?php
$st_latih_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$st_latih_list->Page_Terminate();
?>
