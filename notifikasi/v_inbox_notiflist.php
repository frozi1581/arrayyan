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

$v_inbox_notif_list = NULL; // Initialize page object first

class cv_inbox_notif_list extends cv_inbox_notif {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'v_inbox_notif';

	// Page object name
	var $PageObjName = 'v_inbox_notif_list';

	// Grid form hidden field names
	var $FormName = 'fv_inbox_notiflist';
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

		// Table object (v_inbox_notif)
		if (!isset($GLOBALS["v_inbox_notif"]) || get_class($GLOBALS["v_inbox_notif"]) == "cv_inbox_notif") {
			$GLOBALS["v_inbox_notif"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["v_inbox_notif"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "v_inbox_notifadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "v_inbox_notifdelete.php";
		$this->MultiUpdateUrl = "v_inbox_notifupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fv_inbox_notiflistsrch";

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
		$this->priority->SetVisibility();
		if ($this->IsAddOrEdit())
			$this->priority->Visible = FALSE;
		$this->topic->SetVisibility();
		if ($this->IsAddOrEdit())
			$this->topic->Visible = FALSE;
		$this->isi_notif->SetVisibility();
		if ($this->IsAddOrEdit())
			$this->isi_notif->Visible = FALSE;
		$this->tgl_cr->SetVisibility();
		if ($this->IsAddOrEdit())
			$this->tgl_cr->Visible = FALSE;
		$this->USER_NAME->SetVisibility();
		if ($this->IsAddOrEdit())
			$this->USER_NAME->Visible = FALSE;

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
		if (count($arrKeyFlds) >= 0) {
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fv_inbox_notiflistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJson(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->employee_id->AdvancedSearch->ToJson(), ","); // Field employee_id
		$sFilterList = ew_Concat($sFilterList, $this->priority->AdvancedSearch->ToJson(), ","); // Field priority
		$sFilterList = ew_Concat($sFilterList, $this->topic->AdvancedSearch->ToJson(), ","); // Field topic
		$sFilterList = ew_Concat($sFilterList, $this->isi_notif->AdvancedSearch->ToJson(), ","); // Field isi_notif
		$sFilterList = ew_Concat($sFilterList, $this->tgl_cr->AdvancedSearch->ToJson(), ","); // Field tgl_cr
		$sFilterList = ew_Concat($sFilterList, $this->USER_NAME->AdvancedSearch->ToJson(), ","); // Field USER_NAME
		$sFilterList = ew_Concat($sFilterList, $this->cr_by->AdvancedSearch->ToJson(), ","); // Field cr_by
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fv_inbox_notiflistsrch", $filters);

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

		// Field employee_id
		$this->employee_id->AdvancedSearch->SearchValue = @$filter["x_employee_id"];
		$this->employee_id->AdvancedSearch->SearchOperator = @$filter["z_employee_id"];
		$this->employee_id->AdvancedSearch->SearchCondition = @$filter["v_employee_id"];
		$this->employee_id->AdvancedSearch->SearchValue2 = @$filter["y_employee_id"];
		$this->employee_id->AdvancedSearch->SearchOperator2 = @$filter["w_employee_id"];
		$this->employee_id->AdvancedSearch->Save();

		// Field priority
		$this->priority->AdvancedSearch->SearchValue = @$filter["x_priority"];
		$this->priority->AdvancedSearch->SearchOperator = @$filter["z_priority"];
		$this->priority->AdvancedSearch->SearchCondition = @$filter["v_priority"];
		$this->priority->AdvancedSearch->SearchValue2 = @$filter["y_priority"];
		$this->priority->AdvancedSearch->SearchOperator2 = @$filter["w_priority"];
		$this->priority->AdvancedSearch->Save();

		// Field topic
		$this->topic->AdvancedSearch->SearchValue = @$filter["x_topic"];
		$this->topic->AdvancedSearch->SearchOperator = @$filter["z_topic"];
		$this->topic->AdvancedSearch->SearchCondition = @$filter["v_topic"];
		$this->topic->AdvancedSearch->SearchValue2 = @$filter["y_topic"];
		$this->topic->AdvancedSearch->SearchOperator2 = @$filter["w_topic"];
		$this->topic->AdvancedSearch->Save();

		// Field isi_notif
		$this->isi_notif->AdvancedSearch->SearchValue = @$filter["x_isi_notif"];
		$this->isi_notif->AdvancedSearch->SearchOperator = @$filter["z_isi_notif"];
		$this->isi_notif->AdvancedSearch->SearchCondition = @$filter["v_isi_notif"];
		$this->isi_notif->AdvancedSearch->SearchValue2 = @$filter["y_isi_notif"];
		$this->isi_notif->AdvancedSearch->SearchOperator2 = @$filter["w_isi_notif"];
		$this->isi_notif->AdvancedSearch->Save();

		// Field tgl_cr
		$this->tgl_cr->AdvancedSearch->SearchValue = @$filter["x_tgl_cr"];
		$this->tgl_cr->AdvancedSearch->SearchOperator = @$filter["z_tgl_cr"];
		$this->tgl_cr->AdvancedSearch->SearchCondition = @$filter["v_tgl_cr"];
		$this->tgl_cr->AdvancedSearch->SearchValue2 = @$filter["y_tgl_cr"];
		$this->tgl_cr->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_cr"];
		$this->tgl_cr->AdvancedSearch->Save();

		// Field USER_NAME
		$this->USER_NAME->AdvancedSearch->SearchValue = @$filter["x_USER_NAME"];
		$this->USER_NAME->AdvancedSearch->SearchOperator = @$filter["z_USER_NAME"];
		$this->USER_NAME->AdvancedSearch->SearchCondition = @$filter["v_USER_NAME"];
		$this->USER_NAME->AdvancedSearch->SearchValue2 = @$filter["y_USER_NAME"];
		$this->USER_NAME->AdvancedSearch->SearchOperator2 = @$filter["w_USER_NAME"];
		$this->USER_NAME->AdvancedSearch->Save();

		// Field cr_by
		$this->cr_by->AdvancedSearch->SearchValue = @$filter["x_cr_by"];
		$this->cr_by->AdvancedSearch->SearchOperator = @$filter["z_cr_by"];
		$this->cr_by->AdvancedSearch->SearchCondition = @$filter["v_cr_by"];
		$this->cr_by->AdvancedSearch->SearchValue2 = @$filter["y_cr_by"];
		$this->cr_by->AdvancedSearch->SearchOperator2 = @$filter["w_cr_by"];
		$this->cr_by->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->employee_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->priority, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->topic, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->USER_NAME, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->cr_by, $arKeywords, $type);
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
			$this->UpdateSort($this->priority); // priority
			$this->UpdateSort($this->topic); // topic
			$this->UpdateSort($this->isi_notif); // isi_notif
			$this->UpdateSort($this->tgl_cr); // tgl_cr
			$this->UpdateSort($this->USER_NAME); // USER_NAME
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
				$this->priority->setSort("");
				$this->topic->setSort("");
				$this->isi_notif->setSort("");
				$this->tgl_cr->setSort("");
				$this->USER_NAME->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fv_inbox_notiflistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fv_inbox_notiflistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fv_inbox_notiflist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fv_inbox_notiflistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$row = array();
		$row['id'] = NULL;
		$row['employee_id'] = NULL;
		$row['priority'] = NULL;
		$row['topic'] = NULL;
		$row['isi_notif'] = NULL;
		$row['tgl_cr'] = NULL;
		$row['USER_NAME'] = NULL;
		$row['cr_by'] = NULL;
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
		// employee_id

		$this->employee_id->CellCssStyle = "white-space: nowrap;";

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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

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

			// tgl_cr
			$this->tgl_cr->LinkCustomAttributes = "";
			$this->tgl_cr->HrefValue = "";
			$this->tgl_cr->TooltipValue = "";

			// USER_NAME
			$this->USER_NAME->LinkCustomAttributes = "";
			$this->USER_NAME->HrefValue = "";
			$this->USER_NAME->TooltipValue = "";
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
if (!isset($v_inbox_notif_list)) $v_inbox_notif_list = new cv_inbox_notif_list();

// Page init
$v_inbox_notif_list->Page_Init();

// Page main
$v_inbox_notif_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_inbox_notif_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fv_inbox_notiflist = new ew_Form("fv_inbox_notiflist", "list");
fv_inbox_notiflist.FormKeyCountName = '<?php echo $v_inbox_notif_list->FormKeyCountName ?>';

// Form_CustomValidate event
fv_inbox_notiflist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_inbox_notiflist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fv_inbox_notiflist.Lists["x_priority"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fv_inbox_notiflist.Lists["x_priority"].Options = <?php echo json_encode($v_inbox_notif_list->priority->Options()) ?>;
fv_inbox_notiflist.Lists["x_topic"] = {"LinkField":"x_nama_referensi","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_referensi","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_referensi"};
fv_inbox_notiflist.Lists["x_topic"].Data = "<?php echo $v_inbox_notif_list->topic->LookupFilterQuery(FALSE, "list") ?>";

// Form object for search
var CurrentSearchForm = fv_inbox_notiflistsrch = new ew_Form("fv_inbox_notiflistsrch");
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
<?php if ($v_inbox_notif_list->TotalRecs > 0 && $v_inbox_notif_list->ExportOptions->Visible()) { ?>
<?php $v_inbox_notif_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($v_inbox_notif_list->SearchOptions->Visible()) { ?>
<?php $v_inbox_notif_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($v_inbox_notif_list->FilterOptions->Visible()) { ?>
<?php $v_inbox_notif_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $v_inbox_notif_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($v_inbox_notif_list->TotalRecs <= 0)
			$v_inbox_notif_list->TotalRecs = $v_inbox_notif->ListRecordCount();
	} else {
		if (!$v_inbox_notif_list->Recordset && ($v_inbox_notif_list->Recordset = $v_inbox_notif_list->LoadRecordset()))
			$v_inbox_notif_list->TotalRecs = $v_inbox_notif_list->Recordset->RecordCount();
	}
	$v_inbox_notif_list->StartRec = 1;
	if ($v_inbox_notif_list->DisplayRecs <= 0 || ($v_inbox_notif->Export <> "" && $v_inbox_notif->ExportAll)) // Display all records
		$v_inbox_notif_list->DisplayRecs = $v_inbox_notif_list->TotalRecs;
	if (!($v_inbox_notif->Export <> "" && $v_inbox_notif->ExportAll))
		$v_inbox_notif_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$v_inbox_notif_list->Recordset = $v_inbox_notif_list->LoadRecordset($v_inbox_notif_list->StartRec-1, $v_inbox_notif_list->DisplayRecs);

	// Set no record found message
	if ($v_inbox_notif->CurrentAction == "" && $v_inbox_notif_list->TotalRecs == 0) {
		if ($v_inbox_notif_list->SearchWhere == "0=101")
			$v_inbox_notif_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$v_inbox_notif_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$v_inbox_notif_list->RenderOtherOptions();
?>
<?php if ($v_inbox_notif->Export == "" && $v_inbox_notif->CurrentAction == "") { ?>
<form name="fv_inbox_notiflistsrch" id="fv_inbox_notiflistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($v_inbox_notif_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fv_inbox_notiflistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="v_inbox_notif">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($v_inbox_notif_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($v_inbox_notif_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $v_inbox_notif_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($v_inbox_notif_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($v_inbox_notif_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($v_inbox_notif_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($v_inbox_notif_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $v_inbox_notif_list->ShowPageHeader(); ?>
<?php
$v_inbox_notif_list->ShowMessage();
?>
<?php if ($v_inbox_notif_list->TotalRecs > 0 || $v_inbox_notif->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($v_inbox_notif_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> v_inbox_notif">
<form name="fv_inbox_notiflist" id="fv_inbox_notiflist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($v_inbox_notif_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $v_inbox_notif_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="v_inbox_notif">
<div id="gmp_v_inbox_notif" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($v_inbox_notif_list->TotalRecs > 0 || $v_inbox_notif->CurrentAction == "gridedit") { ?>
<table id="tbl_v_inbox_notiflist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$v_inbox_notif_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$v_inbox_notif_list->RenderListOptions();

// Render list options (header, left)
$v_inbox_notif_list->ListOptions->Render("header", "left");
?>
<?php if ($v_inbox_notif->id->Visible) { // id ?>
	<?php if ($v_inbox_notif->SortUrl($v_inbox_notif->id) == "") { ?>
		<th data-name="id" class="<?php echo $v_inbox_notif->id->HeaderCellClass() ?>"><div id="elh_v_inbox_notif_id" class="v_inbox_notif_id"><div class="ewTableHeaderCaption"><?php echo $v_inbox_notif->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $v_inbox_notif->id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_inbox_notif->SortUrl($v_inbox_notif->id) ?>',1);"><div id="elh_v_inbox_notif_id" class="v_inbox_notif_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_inbox_notif->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_inbox_notif->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_inbox_notif->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_inbox_notif->priority->Visible) { // priority ?>
	<?php if ($v_inbox_notif->SortUrl($v_inbox_notif->priority) == "") { ?>
		<th data-name="priority" class="<?php echo $v_inbox_notif->priority->HeaderCellClass() ?>"><div id="elh_v_inbox_notif_priority" class="v_inbox_notif_priority"><div class="ewTableHeaderCaption"><?php echo $v_inbox_notif->priority->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="priority" class="<?php echo $v_inbox_notif->priority->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_inbox_notif->SortUrl($v_inbox_notif->priority) ?>',1);"><div id="elh_v_inbox_notif_priority" class="v_inbox_notif_priority">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_inbox_notif->priority->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_inbox_notif->priority->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_inbox_notif->priority->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_inbox_notif->topic->Visible) { // topic ?>
	<?php if ($v_inbox_notif->SortUrl($v_inbox_notif->topic) == "") { ?>
		<th data-name="topic" class="<?php echo $v_inbox_notif->topic->HeaderCellClass() ?>"><div id="elh_v_inbox_notif_topic" class="v_inbox_notif_topic"><div class="ewTableHeaderCaption"><?php echo $v_inbox_notif->topic->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="topic" class="<?php echo $v_inbox_notif->topic->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_inbox_notif->SortUrl($v_inbox_notif->topic) ?>',1);"><div id="elh_v_inbox_notif_topic" class="v_inbox_notif_topic">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_inbox_notif->topic->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_inbox_notif->topic->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_inbox_notif->topic->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_inbox_notif->isi_notif->Visible) { // isi_notif ?>
	<?php if ($v_inbox_notif->SortUrl($v_inbox_notif->isi_notif) == "") { ?>
		<th data-name="isi_notif" class="<?php echo $v_inbox_notif->isi_notif->HeaderCellClass() ?>"><div id="elh_v_inbox_notif_isi_notif" class="v_inbox_notif_isi_notif"><div class="ewTableHeaderCaption"><?php echo $v_inbox_notif->isi_notif->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="isi_notif" class="<?php echo $v_inbox_notif->isi_notif->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_inbox_notif->SortUrl($v_inbox_notif->isi_notif) ?>',1);"><div id="elh_v_inbox_notif_isi_notif" class="v_inbox_notif_isi_notif">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_inbox_notif->isi_notif->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_inbox_notif->isi_notif->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_inbox_notif->isi_notif->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_inbox_notif->tgl_cr->Visible) { // tgl_cr ?>
	<?php if ($v_inbox_notif->SortUrl($v_inbox_notif->tgl_cr) == "") { ?>
		<th data-name="tgl_cr" class="<?php echo $v_inbox_notif->tgl_cr->HeaderCellClass() ?>"><div id="elh_v_inbox_notif_tgl_cr" class="v_inbox_notif_tgl_cr"><div class="ewTableHeaderCaption"><?php echo $v_inbox_notif->tgl_cr->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_cr" class="<?php echo $v_inbox_notif->tgl_cr->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_inbox_notif->SortUrl($v_inbox_notif->tgl_cr) ?>',1);"><div id="elh_v_inbox_notif_tgl_cr" class="v_inbox_notif_tgl_cr">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_inbox_notif->tgl_cr->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_inbox_notif->tgl_cr->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_inbox_notif->tgl_cr->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_inbox_notif->USER_NAME->Visible) { // USER_NAME ?>
	<?php if ($v_inbox_notif->SortUrl($v_inbox_notif->USER_NAME) == "") { ?>
		<th data-name="USER_NAME" class="<?php echo $v_inbox_notif->USER_NAME->HeaderCellClass() ?>"><div id="elh_v_inbox_notif_USER_NAME" class="v_inbox_notif_USER_NAME"><div class="ewTableHeaderCaption"><?php echo $v_inbox_notif->USER_NAME->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="USER_NAME" class="<?php echo $v_inbox_notif->USER_NAME->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_inbox_notif->SortUrl($v_inbox_notif->USER_NAME) ?>',1);"><div id="elh_v_inbox_notif_USER_NAME" class="v_inbox_notif_USER_NAME">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_inbox_notif->USER_NAME->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_inbox_notif->USER_NAME->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_inbox_notif->USER_NAME->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$v_inbox_notif_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($v_inbox_notif->ExportAll && $v_inbox_notif->Export <> "") {
	$v_inbox_notif_list->StopRec = $v_inbox_notif_list->TotalRecs;
} else {

	// Set the last record to display
	if ($v_inbox_notif_list->TotalRecs > $v_inbox_notif_list->StartRec + $v_inbox_notif_list->DisplayRecs - 1)
		$v_inbox_notif_list->StopRec = $v_inbox_notif_list->StartRec + $v_inbox_notif_list->DisplayRecs - 1;
	else
		$v_inbox_notif_list->StopRec = $v_inbox_notif_list->TotalRecs;
}
$v_inbox_notif_list->RecCnt = $v_inbox_notif_list->StartRec - 1;
if ($v_inbox_notif_list->Recordset && !$v_inbox_notif_list->Recordset->EOF) {
	$v_inbox_notif_list->Recordset->MoveFirst();
	$bSelectLimit = $v_inbox_notif_list->UseSelectLimit;
	if (!$bSelectLimit && $v_inbox_notif_list->StartRec > 1)
		$v_inbox_notif_list->Recordset->Move($v_inbox_notif_list->StartRec - 1);
} elseif (!$v_inbox_notif->AllowAddDeleteRow && $v_inbox_notif_list->StopRec == 0) {
	$v_inbox_notif_list->StopRec = $v_inbox_notif->GridAddRowCount;
}

// Initialize aggregate
$v_inbox_notif->RowType = EW_ROWTYPE_AGGREGATEINIT;
$v_inbox_notif->ResetAttrs();
$v_inbox_notif_list->RenderRow();
while ($v_inbox_notif_list->RecCnt < $v_inbox_notif_list->StopRec) {
	$v_inbox_notif_list->RecCnt++;
	if (intval($v_inbox_notif_list->RecCnt) >= intval($v_inbox_notif_list->StartRec)) {
		$v_inbox_notif_list->RowCnt++;

		// Set up key count
		$v_inbox_notif_list->KeyCount = $v_inbox_notif_list->RowIndex;

		// Init row class and style
		$v_inbox_notif->ResetAttrs();
		$v_inbox_notif->CssClass = "";
		if ($v_inbox_notif->CurrentAction == "gridadd") {
		} else {
			$v_inbox_notif_list->LoadRowValues($v_inbox_notif_list->Recordset); // Load row values
		}
		$v_inbox_notif->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$v_inbox_notif->RowAttrs = array_merge($v_inbox_notif->RowAttrs, array('data-rowindex'=>$v_inbox_notif_list->RowCnt, 'id'=>'r' . $v_inbox_notif_list->RowCnt . '_v_inbox_notif', 'data-rowtype'=>$v_inbox_notif->RowType));

		// Render row
		$v_inbox_notif_list->RenderRow();

		// Render list options
		$v_inbox_notif_list->RenderListOptions();
?>
	<tr<?php echo $v_inbox_notif->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_inbox_notif_list->ListOptions->Render("body", "left", $v_inbox_notif_list->RowCnt);
?>
	<?php if ($v_inbox_notif->id->Visible) { // id ?>
		<td data-name="id"<?php echo $v_inbox_notif->id->CellAttributes() ?>>
<span id="el<?php echo $v_inbox_notif_list->RowCnt ?>_v_inbox_notif_id" class="v_inbox_notif_id">
<span<?php echo $v_inbox_notif->id->ViewAttributes() ?>>
<?php echo $v_inbox_notif->id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_inbox_notif->priority->Visible) { // priority ?>
		<td data-name="priority"<?php echo $v_inbox_notif->priority->CellAttributes() ?>>
<span id="el<?php echo $v_inbox_notif_list->RowCnt ?>_v_inbox_notif_priority" class="v_inbox_notif_priority">
<span<?php echo $v_inbox_notif->priority->ViewAttributes() ?>>
<?php echo $v_inbox_notif->priority->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_inbox_notif->topic->Visible) { // topic ?>
		<td data-name="topic"<?php echo $v_inbox_notif->topic->CellAttributes() ?>>
<span id="el<?php echo $v_inbox_notif_list->RowCnt ?>_v_inbox_notif_topic" class="v_inbox_notif_topic">
<span<?php echo $v_inbox_notif->topic->ViewAttributes() ?>>
<?php echo $v_inbox_notif->topic->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_inbox_notif->isi_notif->Visible) { // isi_notif ?>
		<td data-name="isi_notif"<?php echo $v_inbox_notif->isi_notif->CellAttributes() ?>>
<span id="el<?php echo $v_inbox_notif_list->RowCnt ?>_v_inbox_notif_isi_notif" class="v_inbox_notif_isi_notif">
<span<?php echo $v_inbox_notif->isi_notif->ViewAttributes() ?>>
<?php echo $v_inbox_notif->isi_notif->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_inbox_notif->tgl_cr->Visible) { // tgl_cr ?>
		<td data-name="tgl_cr"<?php echo $v_inbox_notif->tgl_cr->CellAttributes() ?>>
<span id="el<?php echo $v_inbox_notif_list->RowCnt ?>_v_inbox_notif_tgl_cr" class="v_inbox_notif_tgl_cr">
<span<?php echo $v_inbox_notif->tgl_cr->ViewAttributes() ?>>
<?php echo $v_inbox_notif->tgl_cr->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_inbox_notif->USER_NAME->Visible) { // USER_NAME ?>
		<td data-name="USER_NAME"<?php echo $v_inbox_notif->USER_NAME->CellAttributes() ?>>
<span id="el<?php echo $v_inbox_notif_list->RowCnt ?>_v_inbox_notif_USER_NAME" class="v_inbox_notif_USER_NAME">
<span<?php echo $v_inbox_notif->USER_NAME->ViewAttributes() ?>>
<?php echo $v_inbox_notif->USER_NAME->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_inbox_notif_list->ListOptions->Render("body", "right", $v_inbox_notif_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($v_inbox_notif->CurrentAction <> "gridadd")
		$v_inbox_notif_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($v_inbox_notif->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($v_inbox_notif_list->Recordset)
	$v_inbox_notif_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($v_inbox_notif->CurrentAction <> "gridadd" && $v_inbox_notif->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($v_inbox_notif_list->Pager)) $v_inbox_notif_list->Pager = new cPrevNextPager($v_inbox_notif_list->StartRec, $v_inbox_notif_list->DisplayRecs, $v_inbox_notif_list->TotalRecs, $v_inbox_notif_list->AutoHidePager) ?>
<?php if ($v_inbox_notif_list->Pager->RecordCount > 0 && $v_inbox_notif_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($v_inbox_notif_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $v_inbox_notif_list->PageUrl() ?>start=<?php echo $v_inbox_notif_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($v_inbox_notif_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $v_inbox_notif_list->PageUrl() ?>start=<?php echo $v_inbox_notif_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $v_inbox_notif_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($v_inbox_notif_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $v_inbox_notif_list->PageUrl() ?>start=<?php echo $v_inbox_notif_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($v_inbox_notif_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $v_inbox_notif_list->PageUrl() ?>start=<?php echo $v_inbox_notif_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $v_inbox_notif_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($v_inbox_notif_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $v_inbox_notif_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $v_inbox_notif_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $v_inbox_notif_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_inbox_notif_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($v_inbox_notif_list->TotalRecs == 0 && $v_inbox_notif->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_inbox_notif_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fv_inbox_notiflistsrch.FilterList = <?php echo $v_inbox_notif_list->GetFilterList() ?>;
fv_inbox_notiflistsrch.Init();
fv_inbox_notiflist.Init();
</script>
<?php
$v_inbox_notif_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

$('.ewAdd').hide();	
$('.ewAdd').after('<a href="<?php echo $_SESSION['home']; ?>">   <button class="btn btn-default ewButton" name="btnHome" id="btnHome" type="Button" >Home</button></a>');
</script>
<?php include_once "footer.php" ?>
<?php
$v_inbox_notif_list->Page_Terminate();
?>
