<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tb_jbtinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tb_jbt_list = NULL; // Initialize page object first

class ctb_jbt_list extends ctb_jbt {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'tb_jbt';

	// Page object name
	var $PageObjName = 'tb_jbt_list';

	// Grid form hidden field names
	var $FormName = 'ftb_jbtlist';
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

		// Table object (tb_jbt)
		if (!isset($GLOBALS["tb_jbt"]) || get_class($GLOBALS["tb_jbt"]) == "ctb_jbt") {
			$GLOBALS["tb_jbt"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_jbt"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "tb_jbtadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "tb_jbtdelete.php";
		$this->MultiUpdateUrl = "tb_jbtupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_jbt', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ftb_jbtlistsrch";

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
		$this->kd_jbt->SetVisibility();
		$this->ket->SetVisibility();
		$this->tjb->SetVisibility();
		$this->koef->SetVisibility();
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();
		$this->kd_jbt_old->SetVisibility();
		$this->ket_old->SetVisibility();
		$this->jbt_type->SetVisibility();
		$this->org_id->SetVisibility();
		$this->parent_kd_jbt->SetVisibility();
		$this->eselon_num->SetVisibility();
		$this->jns_jbt->SetVisibility();
		$this->status->SetVisibility();

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
		global $EW_EXPORT, $tb_jbt;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_jbt);
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
			$this->kd_jbt->setFormValue($arrKeyFlds[0]);
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "ftb_jbtlistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->kd_jbt->AdvancedSearch->ToJson(), ","); // Field kd_jbt
		$sFilterList = ew_Concat($sFilterList, $this->ket->AdvancedSearch->ToJson(), ","); // Field ket
		$sFilterList = ew_Concat($sFilterList, $this->tjb->AdvancedSearch->ToJson(), ","); // Field tjb
		$sFilterList = ew_Concat($sFilterList, $this->koef->AdvancedSearch->ToJson(), ","); // Field koef
		$sFilterList = ew_Concat($sFilterList, $this->created_by->AdvancedSearch->ToJson(), ","); // Field created_by
		$sFilterList = ew_Concat($sFilterList, $this->created_date->AdvancedSearch->ToJson(), ","); // Field created_date
		$sFilterList = ew_Concat($sFilterList, $this->last_update_by->AdvancedSearch->ToJson(), ","); // Field last_update_by
		$sFilterList = ew_Concat($sFilterList, $this->last_update_date->AdvancedSearch->ToJson(), ","); // Field last_update_date
		$sFilterList = ew_Concat($sFilterList, $this->kd_jbt_old->AdvancedSearch->ToJson(), ","); // Field kd_jbt_old
		$sFilterList = ew_Concat($sFilterList, $this->ket_old->AdvancedSearch->ToJson(), ","); // Field ket_old
		$sFilterList = ew_Concat($sFilterList, $this->jbt_type->AdvancedSearch->ToJson(), ","); // Field jbt_type
		$sFilterList = ew_Concat($sFilterList, $this->org_id->AdvancedSearch->ToJson(), ","); // Field org_id
		$sFilterList = ew_Concat($sFilterList, $this->parent_kd_jbt->AdvancedSearch->ToJson(), ","); // Field parent_kd_jbt
		$sFilterList = ew_Concat($sFilterList, $this->eselon_num->AdvancedSearch->ToJson(), ","); // Field eselon_num
		$sFilterList = ew_Concat($sFilterList, $this->jns_jbt->AdvancedSearch->ToJson(), ","); // Field jns_jbt
		$sFilterList = ew_Concat($sFilterList, $this->status->AdvancedSearch->ToJson(), ","); // Field status
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ftb_jbtlistsrch", $filters);

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

		// Field kd_jbt
		$this->kd_jbt->AdvancedSearch->SearchValue = @$filter["x_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->SearchOperator = @$filter["z_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->SearchCondition = @$filter["v_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->SearchValue2 = @$filter["y_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->SearchOperator2 = @$filter["w_kd_jbt"];
		$this->kd_jbt->AdvancedSearch->Save();

		// Field ket
		$this->ket->AdvancedSearch->SearchValue = @$filter["x_ket"];
		$this->ket->AdvancedSearch->SearchOperator = @$filter["z_ket"];
		$this->ket->AdvancedSearch->SearchCondition = @$filter["v_ket"];
		$this->ket->AdvancedSearch->SearchValue2 = @$filter["y_ket"];
		$this->ket->AdvancedSearch->SearchOperator2 = @$filter["w_ket"];
		$this->ket->AdvancedSearch->Save();

		// Field tjb
		$this->tjb->AdvancedSearch->SearchValue = @$filter["x_tjb"];
		$this->tjb->AdvancedSearch->SearchOperator = @$filter["z_tjb"];
		$this->tjb->AdvancedSearch->SearchCondition = @$filter["v_tjb"];
		$this->tjb->AdvancedSearch->SearchValue2 = @$filter["y_tjb"];
		$this->tjb->AdvancedSearch->SearchOperator2 = @$filter["w_tjb"];
		$this->tjb->AdvancedSearch->Save();

		// Field koef
		$this->koef->AdvancedSearch->SearchValue = @$filter["x_koef"];
		$this->koef->AdvancedSearch->SearchOperator = @$filter["z_koef"];
		$this->koef->AdvancedSearch->SearchCondition = @$filter["v_koef"];
		$this->koef->AdvancedSearch->SearchValue2 = @$filter["y_koef"];
		$this->koef->AdvancedSearch->SearchOperator2 = @$filter["w_koef"];
		$this->koef->AdvancedSearch->Save();

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

		// Field kd_jbt_old
		$this->kd_jbt_old->AdvancedSearch->SearchValue = @$filter["x_kd_jbt_old"];
		$this->kd_jbt_old->AdvancedSearch->SearchOperator = @$filter["z_kd_jbt_old"];
		$this->kd_jbt_old->AdvancedSearch->SearchCondition = @$filter["v_kd_jbt_old"];
		$this->kd_jbt_old->AdvancedSearch->SearchValue2 = @$filter["y_kd_jbt_old"];
		$this->kd_jbt_old->AdvancedSearch->SearchOperator2 = @$filter["w_kd_jbt_old"];
		$this->kd_jbt_old->AdvancedSearch->Save();

		// Field ket_old
		$this->ket_old->AdvancedSearch->SearchValue = @$filter["x_ket_old"];
		$this->ket_old->AdvancedSearch->SearchOperator = @$filter["z_ket_old"];
		$this->ket_old->AdvancedSearch->SearchCondition = @$filter["v_ket_old"];
		$this->ket_old->AdvancedSearch->SearchValue2 = @$filter["y_ket_old"];
		$this->ket_old->AdvancedSearch->SearchOperator2 = @$filter["w_ket_old"];
		$this->ket_old->AdvancedSearch->Save();

		// Field jbt_type
		$this->jbt_type->AdvancedSearch->SearchValue = @$filter["x_jbt_type"];
		$this->jbt_type->AdvancedSearch->SearchOperator = @$filter["z_jbt_type"];
		$this->jbt_type->AdvancedSearch->SearchCondition = @$filter["v_jbt_type"];
		$this->jbt_type->AdvancedSearch->SearchValue2 = @$filter["y_jbt_type"];
		$this->jbt_type->AdvancedSearch->SearchOperator2 = @$filter["w_jbt_type"];
		$this->jbt_type->AdvancedSearch->Save();

		// Field org_id
		$this->org_id->AdvancedSearch->SearchValue = @$filter["x_org_id"];
		$this->org_id->AdvancedSearch->SearchOperator = @$filter["z_org_id"];
		$this->org_id->AdvancedSearch->SearchCondition = @$filter["v_org_id"];
		$this->org_id->AdvancedSearch->SearchValue2 = @$filter["y_org_id"];
		$this->org_id->AdvancedSearch->SearchOperator2 = @$filter["w_org_id"];
		$this->org_id->AdvancedSearch->Save();

		// Field parent_kd_jbt
		$this->parent_kd_jbt->AdvancedSearch->SearchValue = @$filter["x_parent_kd_jbt"];
		$this->parent_kd_jbt->AdvancedSearch->SearchOperator = @$filter["z_parent_kd_jbt"];
		$this->parent_kd_jbt->AdvancedSearch->SearchCondition = @$filter["v_parent_kd_jbt"];
		$this->parent_kd_jbt->AdvancedSearch->SearchValue2 = @$filter["y_parent_kd_jbt"];
		$this->parent_kd_jbt->AdvancedSearch->SearchOperator2 = @$filter["w_parent_kd_jbt"];
		$this->parent_kd_jbt->AdvancedSearch->Save();

		// Field eselon_num
		$this->eselon_num->AdvancedSearch->SearchValue = @$filter["x_eselon_num"];
		$this->eselon_num->AdvancedSearch->SearchOperator = @$filter["z_eselon_num"];
		$this->eselon_num->AdvancedSearch->SearchCondition = @$filter["v_eselon_num"];
		$this->eselon_num->AdvancedSearch->SearchValue2 = @$filter["y_eselon_num"];
		$this->eselon_num->AdvancedSearch->SearchOperator2 = @$filter["w_eselon_num"];
		$this->eselon_num->AdvancedSearch->Save();

		// Field jns_jbt
		$this->jns_jbt->AdvancedSearch->SearchValue = @$filter["x_jns_jbt"];
		$this->jns_jbt->AdvancedSearch->SearchOperator = @$filter["z_jns_jbt"];
		$this->jns_jbt->AdvancedSearch->SearchCondition = @$filter["v_jns_jbt"];
		$this->jns_jbt->AdvancedSearch->SearchValue2 = @$filter["y_jns_jbt"];
		$this->jns_jbt->AdvancedSearch->SearchOperator2 = @$filter["w_jns_jbt"];
		$this->jns_jbt->AdvancedSearch->Save();

		// Field status
		$this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
		$this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
		$this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
		$this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
		$this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
		$this->status->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->kd_jbt, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ket, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->tjb, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->created_by, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->last_update_by, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_jbt_old, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ket_old, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jbt_type, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->org_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->parent_kd_jbt, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jns_jbt, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->status, $arKeywords, $type);
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
			$this->UpdateSort($this->kd_jbt); // kd_jbt
			$this->UpdateSort($this->ket); // ket
			$this->UpdateSort($this->tjb); // tjb
			$this->UpdateSort($this->koef); // koef
			$this->UpdateSort($this->created_by); // created_by
			$this->UpdateSort($this->created_date); // created_date
			$this->UpdateSort($this->last_update_by); // last_update_by
			$this->UpdateSort($this->last_update_date); // last_update_date
			$this->UpdateSort($this->kd_jbt_old); // kd_jbt_old
			$this->UpdateSort($this->ket_old); // ket_old
			$this->UpdateSort($this->jbt_type); // jbt_type
			$this->UpdateSort($this->org_id); // org_id
			$this->UpdateSort($this->parent_kd_jbt); // parent_kd_jbt
			$this->UpdateSort($this->eselon_num); // eselon_num
			$this->UpdateSort($this->jns_jbt); // jns_jbt
			$this->UpdateSort($this->status); // status
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
				$this->kd_jbt->setSort("");
				$this->ket->setSort("");
				$this->tjb->setSort("");
				$this->koef->setSort("");
				$this->created_by->setSort("");
				$this->created_date->setSort("");
				$this->last_update_by->setSort("");
				$this->last_update_date->setSort("");
				$this->kd_jbt_old->setSort("");
				$this->ket_old->setSort("");
				$this->jbt_type->setSort("");
				$this->org_id->setSort("");
				$this->parent_kd_jbt->setSort("");
				$this->eselon_num->setSort("");
				$this->jns_jbt->setSort("");
				$this->status->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->kd_jbt->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ftb_jbtlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ftb_jbtlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ftb_jbtlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ftb_jbtlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$this->kd_jbt->setDbValue($row['kd_jbt']);
		$this->ket->setDbValue($row['ket']);
		$this->tjb->setDbValue($row['tjb']);
		$this->koef->setDbValue($row['koef']);
		$this->created_by->setDbValue($row['created_by']);
		$this->created_date->setDbValue($row['created_date']);
		$this->last_update_by->setDbValue($row['last_update_by']);
		$this->last_update_date->setDbValue($row['last_update_date']);
		$this->kd_jbt_old->setDbValue($row['kd_jbt_old']);
		$this->ket_old->setDbValue($row['ket_old']);
		$this->jbt_type->setDbValue($row['jbt_type']);
		$this->org_id->setDbValue($row['org_id']);
		$this->parent_kd_jbt->setDbValue($row['parent_kd_jbt']);
		$this->eselon_num->setDbValue($row['eselon_num']);
		$this->jns_jbt->setDbValue($row['jns_jbt']);
		$this->status->setDbValue($row['status']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['kd_jbt'] = NULL;
		$row['ket'] = NULL;
		$row['tjb'] = NULL;
		$row['koef'] = NULL;
		$row['created_by'] = NULL;
		$row['created_date'] = NULL;
		$row['last_update_by'] = NULL;
		$row['last_update_date'] = NULL;
		$row['kd_jbt_old'] = NULL;
		$row['ket_old'] = NULL;
		$row['jbt_type'] = NULL;
		$row['org_id'] = NULL;
		$row['parent_kd_jbt'] = NULL;
		$row['eselon_num'] = NULL;
		$row['jns_jbt'] = NULL;
		$row['status'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->kd_jbt->DbValue = $row['kd_jbt'];
		$this->ket->DbValue = $row['ket'];
		$this->tjb->DbValue = $row['tjb'];
		$this->koef->DbValue = $row['koef'];
		$this->created_by->DbValue = $row['created_by'];
		$this->created_date->DbValue = $row['created_date'];
		$this->last_update_by->DbValue = $row['last_update_by'];
		$this->last_update_date->DbValue = $row['last_update_date'];
		$this->kd_jbt_old->DbValue = $row['kd_jbt_old'];
		$this->ket_old->DbValue = $row['ket_old'];
		$this->jbt_type->DbValue = $row['jbt_type'];
		$this->org_id->DbValue = $row['org_id'];
		$this->parent_kd_jbt->DbValue = $row['parent_kd_jbt'];
		$this->eselon_num->DbValue = $row['eselon_num'];
		$this->jns_jbt->DbValue = $row['jns_jbt'];
		$this->status->DbValue = $row['status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("kd_jbt")) <> "")
			$this->kd_jbt->CurrentValue = $this->getKey("kd_jbt"); // kd_jbt
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
		if ($this->koef->FormValue == $this->koef->CurrentValue && is_numeric(ew_StrToFloat($this->koef->CurrentValue)))
			$this->koef->CurrentValue = ew_StrToFloat($this->koef->CurrentValue);

		// Convert decimal values if posted back
		if ($this->eselon_num->FormValue == $this->eselon_num->CurrentValue && is_numeric(ew_StrToFloat($this->eselon_num->CurrentValue)))
			$this->eselon_num->CurrentValue = ew_StrToFloat($this->eselon_num->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// kd_jbt
		// ket
		// tjb
		// koef
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// kd_jbt_old
		// ket_old
		// jbt_type
		// org_id
		// parent_kd_jbt
		// eselon_num
		// jns_jbt
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// kd_jbt
		$this->kd_jbt->ViewValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

		// tjb
		$this->tjb->ViewValue = $this->tjb->CurrentValue;
		$this->tjb->ViewCustomAttributes = "";

		// koef
		$this->koef->ViewValue = $this->koef->CurrentValue;
		$this->koef->ViewCustomAttributes = "";

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

		// kd_jbt_old
		$this->kd_jbt_old->ViewValue = $this->kd_jbt_old->CurrentValue;
		$this->kd_jbt_old->ViewCustomAttributes = "";

		// ket_old
		$this->ket_old->ViewValue = $this->ket_old->CurrentValue;
		$this->ket_old->ViewCustomAttributes = "";

		// jbt_type
		$this->jbt_type->ViewValue = $this->jbt_type->CurrentValue;
		$this->jbt_type->ViewCustomAttributes = "";

		// org_id
		$this->org_id->ViewValue = $this->org_id->CurrentValue;
		$this->org_id->ViewCustomAttributes = "";

		// parent_kd_jbt
		$this->parent_kd_jbt->ViewValue = $this->parent_kd_jbt->CurrentValue;
		$this->parent_kd_jbt->ViewCustomAttributes = "";

		// eselon_num
		$this->eselon_num->ViewValue = $this->eselon_num->CurrentValue;
		$this->eselon_num->ViewCustomAttributes = "";

		// jns_jbt
		$this->jns_jbt->ViewValue = $this->jns_jbt->CurrentValue;
		$this->jns_jbt->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

			// kd_jbt
			$this->kd_jbt->LinkCustomAttributes = "";
			$this->kd_jbt->HrefValue = "";
			$this->kd_jbt->TooltipValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";
			$this->ket->TooltipValue = "";

			// tjb
			$this->tjb->LinkCustomAttributes = "";
			$this->tjb->HrefValue = "";
			$this->tjb->TooltipValue = "";

			// koef
			$this->koef->LinkCustomAttributes = "";
			$this->koef->HrefValue = "";
			$this->koef->TooltipValue = "";

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

			// kd_jbt_old
			$this->kd_jbt_old->LinkCustomAttributes = "";
			$this->kd_jbt_old->HrefValue = "";
			$this->kd_jbt_old->TooltipValue = "";

			// ket_old
			$this->ket_old->LinkCustomAttributes = "";
			$this->ket_old->HrefValue = "";
			$this->ket_old->TooltipValue = "";

			// jbt_type
			$this->jbt_type->LinkCustomAttributes = "";
			$this->jbt_type->HrefValue = "";
			$this->jbt_type->TooltipValue = "";

			// org_id
			$this->org_id->LinkCustomAttributes = "";
			$this->org_id->HrefValue = "";
			$this->org_id->TooltipValue = "";

			// parent_kd_jbt
			$this->parent_kd_jbt->LinkCustomAttributes = "";
			$this->parent_kd_jbt->HrefValue = "";
			$this->parent_kd_jbt->TooltipValue = "";

			// eselon_num
			$this->eselon_num->LinkCustomAttributes = "";
			$this->eselon_num->HrefValue = "";
			$this->eselon_num->TooltipValue = "";

			// jns_jbt
			$this->jns_jbt->LinkCustomAttributes = "";
			$this->jns_jbt->HrefValue = "";
			$this->jns_jbt->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
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
if (!isset($tb_jbt_list)) $tb_jbt_list = new ctb_jbt_list();

// Page init
$tb_jbt_list->Page_Init();

// Page main
$tb_jbt_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_jbt_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ftb_jbtlist = new ew_Form("ftb_jbtlist", "list");
ftb_jbtlist.FormKeyCountName = '<?php echo $tb_jbt_list->FormKeyCountName ?>';

// Form_CustomValidate event
ftb_jbtlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftb_jbtlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = ftb_jbtlistsrch = new ew_Form("ftb_jbtlistsrch");
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
<?php if ($tb_jbt_list->TotalRecs > 0 && $tb_jbt_list->ExportOptions->Visible()) { ?>
<?php $tb_jbt_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($tb_jbt_list->SearchOptions->Visible()) { ?>
<?php $tb_jbt_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($tb_jbt_list->FilterOptions->Visible()) { ?>
<?php $tb_jbt_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $tb_jbt_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($tb_jbt_list->TotalRecs <= 0)
			$tb_jbt_list->TotalRecs = $tb_jbt->ListRecordCount();
	} else {
		if (!$tb_jbt_list->Recordset && ($tb_jbt_list->Recordset = $tb_jbt_list->LoadRecordset()))
			$tb_jbt_list->TotalRecs = $tb_jbt_list->Recordset->RecordCount();
	}
	$tb_jbt_list->StartRec = 1;
	if ($tb_jbt_list->DisplayRecs <= 0 || ($tb_jbt->Export <> "" && $tb_jbt->ExportAll)) // Display all records
		$tb_jbt_list->DisplayRecs = $tb_jbt_list->TotalRecs;
	if (!($tb_jbt->Export <> "" && $tb_jbt->ExportAll))
		$tb_jbt_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$tb_jbt_list->Recordset = $tb_jbt_list->LoadRecordset($tb_jbt_list->StartRec-1, $tb_jbt_list->DisplayRecs);

	// Set no record found message
	if ($tb_jbt->CurrentAction == "" && $tb_jbt_list->TotalRecs == 0) {
		if ($tb_jbt_list->SearchWhere == "0=101")
			$tb_jbt_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$tb_jbt_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$tb_jbt_list->RenderOtherOptions();
?>
<?php if ($tb_jbt->Export == "" && $tb_jbt->CurrentAction == "") { ?>
<form name="ftb_jbtlistsrch" id="ftb_jbtlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($tb_jbt_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ftb_jbtlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tb_jbt">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($tb_jbt_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($tb_jbt_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $tb_jbt_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($tb_jbt_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($tb_jbt_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($tb_jbt_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($tb_jbt_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $tb_jbt_list->ShowPageHeader(); ?>
<?php
$tb_jbt_list->ShowMessage();
?>
<?php if ($tb_jbt_list->TotalRecs > 0 || $tb_jbt->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($tb_jbt_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> tb_jbt">
<form name="ftb_jbtlist" id="ftb_jbtlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_jbt_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_jbt_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_jbt">
<div id="gmp_tb_jbt" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($tb_jbt_list->TotalRecs > 0 || $tb_jbt->CurrentAction == "gridedit") { ?>
<table id="tbl_tb_jbtlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$tb_jbt_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$tb_jbt_list->RenderListOptions();

// Render list options (header, left)
$tb_jbt_list->ListOptions->Render("header", "left");
?>
<?php if ($tb_jbt->kd_jbt->Visible) { // kd_jbt ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->kd_jbt) == "") { ?>
		<th data-name="kd_jbt" class="<?php echo $tb_jbt->kd_jbt->HeaderCellClass() ?>"><div id="elh_tb_jbt_kd_jbt" class="tb_jbt_kd_jbt"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->kd_jbt->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_jbt" class="<?php echo $tb_jbt->kd_jbt->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->kd_jbt) ?>',1);"><div id="elh_tb_jbt_kd_jbt" class="tb_jbt_kd_jbt">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->kd_jbt->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->kd_jbt->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->kd_jbt->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->ket->Visible) { // ket ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->ket) == "") { ?>
		<th data-name="ket" class="<?php echo $tb_jbt->ket->HeaderCellClass() ?>"><div id="elh_tb_jbt_ket" class="tb_jbt_ket"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->ket->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ket" class="<?php echo $tb_jbt->ket->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->ket) ?>',1);"><div id="elh_tb_jbt_ket" class="tb_jbt_ket">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->ket->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->ket->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->ket->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->tjb->Visible) { // tjb ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->tjb) == "") { ?>
		<th data-name="tjb" class="<?php echo $tb_jbt->tjb->HeaderCellClass() ?>"><div id="elh_tb_jbt_tjb" class="tb_jbt_tjb"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->tjb->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tjb" class="<?php echo $tb_jbt->tjb->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->tjb) ?>',1);"><div id="elh_tb_jbt_tjb" class="tb_jbt_tjb">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->tjb->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->tjb->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->tjb->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->koef->Visible) { // koef ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->koef) == "") { ?>
		<th data-name="koef" class="<?php echo $tb_jbt->koef->HeaderCellClass() ?>"><div id="elh_tb_jbt_koef" class="tb_jbt_koef"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->koef->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="koef" class="<?php echo $tb_jbt->koef->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->koef) ?>',1);"><div id="elh_tb_jbt_koef" class="tb_jbt_koef">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->koef->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->koef->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->koef->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->created_by->Visible) { // created_by ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->created_by) == "") { ?>
		<th data-name="created_by" class="<?php echo $tb_jbt->created_by->HeaderCellClass() ?>"><div id="elh_tb_jbt_created_by" class="tb_jbt_created_by"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->created_by->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="created_by" class="<?php echo $tb_jbt->created_by->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->created_by) ?>',1);"><div id="elh_tb_jbt_created_by" class="tb_jbt_created_by">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->created_by->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->created_by->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->created_by->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->created_date->Visible) { // created_date ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->created_date) == "") { ?>
		<th data-name="created_date" class="<?php echo $tb_jbt->created_date->HeaderCellClass() ?>"><div id="elh_tb_jbt_created_date" class="tb_jbt_created_date"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->created_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="created_date" class="<?php echo $tb_jbt->created_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->created_date) ?>',1);"><div id="elh_tb_jbt_created_date" class="tb_jbt_created_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->created_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->created_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->created_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->last_update_by->Visible) { // last_update_by ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->last_update_by) == "") { ?>
		<th data-name="last_update_by" class="<?php echo $tb_jbt->last_update_by->HeaderCellClass() ?>"><div id="elh_tb_jbt_last_update_by" class="tb_jbt_last_update_by"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->last_update_by->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="last_update_by" class="<?php echo $tb_jbt->last_update_by->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->last_update_by) ?>',1);"><div id="elh_tb_jbt_last_update_by" class="tb_jbt_last_update_by">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->last_update_by->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->last_update_by->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->last_update_by->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->last_update_date->Visible) { // last_update_date ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->last_update_date) == "") { ?>
		<th data-name="last_update_date" class="<?php echo $tb_jbt->last_update_date->HeaderCellClass() ?>"><div id="elh_tb_jbt_last_update_date" class="tb_jbt_last_update_date"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->last_update_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="last_update_date" class="<?php echo $tb_jbt->last_update_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->last_update_date) ?>',1);"><div id="elh_tb_jbt_last_update_date" class="tb_jbt_last_update_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->last_update_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->last_update_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->last_update_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->kd_jbt_old->Visible) { // kd_jbt_old ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->kd_jbt_old) == "") { ?>
		<th data-name="kd_jbt_old" class="<?php echo $tb_jbt->kd_jbt_old->HeaderCellClass() ?>"><div id="elh_tb_jbt_kd_jbt_old" class="tb_jbt_kd_jbt_old"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->kd_jbt_old->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_jbt_old" class="<?php echo $tb_jbt->kd_jbt_old->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->kd_jbt_old) ?>',1);"><div id="elh_tb_jbt_kd_jbt_old" class="tb_jbt_kd_jbt_old">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->kd_jbt_old->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->kd_jbt_old->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->kd_jbt_old->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->ket_old->Visible) { // ket_old ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->ket_old) == "") { ?>
		<th data-name="ket_old" class="<?php echo $tb_jbt->ket_old->HeaderCellClass() ?>"><div id="elh_tb_jbt_ket_old" class="tb_jbt_ket_old"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->ket_old->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ket_old" class="<?php echo $tb_jbt->ket_old->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->ket_old) ?>',1);"><div id="elh_tb_jbt_ket_old" class="tb_jbt_ket_old">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->ket_old->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->ket_old->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->ket_old->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->jbt_type->Visible) { // jbt_type ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->jbt_type) == "") { ?>
		<th data-name="jbt_type" class="<?php echo $tb_jbt->jbt_type->HeaderCellClass() ?>"><div id="elh_tb_jbt_jbt_type" class="tb_jbt_jbt_type"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->jbt_type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jbt_type" class="<?php echo $tb_jbt->jbt_type->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->jbt_type) ?>',1);"><div id="elh_tb_jbt_jbt_type" class="tb_jbt_jbt_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->jbt_type->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->jbt_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->jbt_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->org_id->Visible) { // org_id ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->org_id) == "") { ?>
		<th data-name="org_id" class="<?php echo $tb_jbt->org_id->HeaderCellClass() ?>"><div id="elh_tb_jbt_org_id" class="tb_jbt_org_id"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->org_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="org_id" class="<?php echo $tb_jbt->org_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->org_id) ?>',1);"><div id="elh_tb_jbt_org_id" class="tb_jbt_org_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->org_id->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->org_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->org_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->parent_kd_jbt->Visible) { // parent_kd_jbt ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->parent_kd_jbt) == "") { ?>
		<th data-name="parent_kd_jbt" class="<?php echo $tb_jbt->parent_kd_jbt->HeaderCellClass() ?>"><div id="elh_tb_jbt_parent_kd_jbt" class="tb_jbt_parent_kd_jbt"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->parent_kd_jbt->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="parent_kd_jbt" class="<?php echo $tb_jbt->parent_kd_jbt->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->parent_kd_jbt) ?>',1);"><div id="elh_tb_jbt_parent_kd_jbt" class="tb_jbt_parent_kd_jbt">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->parent_kd_jbt->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->parent_kd_jbt->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->parent_kd_jbt->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->eselon_num->Visible) { // eselon_num ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->eselon_num) == "") { ?>
		<th data-name="eselon_num" class="<?php echo $tb_jbt->eselon_num->HeaderCellClass() ?>"><div id="elh_tb_jbt_eselon_num" class="tb_jbt_eselon_num"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->eselon_num->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="eselon_num" class="<?php echo $tb_jbt->eselon_num->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->eselon_num) ?>',1);"><div id="elh_tb_jbt_eselon_num" class="tb_jbt_eselon_num">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->eselon_num->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->eselon_num->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->eselon_num->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->jns_jbt->Visible) { // jns_jbt ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->jns_jbt) == "") { ?>
		<th data-name="jns_jbt" class="<?php echo $tb_jbt->jns_jbt->HeaderCellClass() ?>"><div id="elh_tb_jbt_jns_jbt" class="tb_jbt_jns_jbt"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->jns_jbt->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jns_jbt" class="<?php echo $tb_jbt->jns_jbt->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->jns_jbt) ?>',1);"><div id="elh_tb_jbt_jns_jbt" class="tb_jbt_jns_jbt">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->jns_jbt->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->jns_jbt->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->jns_jbt->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_jbt->status->Visible) { // status ?>
	<?php if ($tb_jbt->SortUrl($tb_jbt->status) == "") { ?>
		<th data-name="status" class="<?php echo $tb_jbt->status->HeaderCellClass() ?>"><div id="elh_tb_jbt_status" class="tb_jbt_status"><div class="ewTableHeaderCaption"><?php echo $tb_jbt->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $tb_jbt->status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_jbt->SortUrl($tb_jbt->status) ?>',1);"><div id="elh_tb_jbt_status" class="tb_jbt_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_jbt->status->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tb_jbt->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_jbt->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$tb_jbt_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($tb_jbt->ExportAll && $tb_jbt->Export <> "") {
	$tb_jbt_list->StopRec = $tb_jbt_list->TotalRecs;
} else {

	// Set the last record to display
	if ($tb_jbt_list->TotalRecs > $tb_jbt_list->StartRec + $tb_jbt_list->DisplayRecs - 1)
		$tb_jbt_list->StopRec = $tb_jbt_list->StartRec + $tb_jbt_list->DisplayRecs - 1;
	else
		$tb_jbt_list->StopRec = $tb_jbt_list->TotalRecs;
}
$tb_jbt_list->RecCnt = $tb_jbt_list->StartRec - 1;
if ($tb_jbt_list->Recordset && !$tb_jbt_list->Recordset->EOF) {
	$tb_jbt_list->Recordset->MoveFirst();
	$bSelectLimit = $tb_jbt_list->UseSelectLimit;
	if (!$bSelectLimit && $tb_jbt_list->StartRec > 1)
		$tb_jbt_list->Recordset->Move($tb_jbt_list->StartRec - 1);
} elseif (!$tb_jbt->AllowAddDeleteRow && $tb_jbt_list->StopRec == 0) {
	$tb_jbt_list->StopRec = $tb_jbt->GridAddRowCount;
}

// Initialize aggregate
$tb_jbt->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tb_jbt->ResetAttrs();
$tb_jbt_list->RenderRow();
while ($tb_jbt_list->RecCnt < $tb_jbt_list->StopRec) {
	$tb_jbt_list->RecCnt++;
	if (intval($tb_jbt_list->RecCnt) >= intval($tb_jbt_list->StartRec)) {
		$tb_jbt_list->RowCnt++;

		// Set up key count
		$tb_jbt_list->KeyCount = $tb_jbt_list->RowIndex;

		// Init row class and style
		$tb_jbt->ResetAttrs();
		$tb_jbt->CssClass = "";
		if ($tb_jbt->CurrentAction == "gridadd") {
		} else {
			$tb_jbt_list->LoadRowValues($tb_jbt_list->Recordset); // Load row values
		}
		$tb_jbt->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$tb_jbt->RowAttrs = array_merge($tb_jbt->RowAttrs, array('data-rowindex'=>$tb_jbt_list->RowCnt, 'id'=>'r' . $tb_jbt_list->RowCnt . '_tb_jbt', 'data-rowtype'=>$tb_jbt->RowType));

		// Render row
		$tb_jbt_list->RenderRow();

		// Render list options
		$tb_jbt_list->RenderListOptions();
?>
	<tr<?php echo $tb_jbt->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tb_jbt_list->ListOptions->Render("body", "left", $tb_jbt_list->RowCnt);
?>
	<?php if ($tb_jbt->kd_jbt->Visible) { // kd_jbt ?>
		<td data-name="kd_jbt"<?php echo $tb_jbt->kd_jbt->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_kd_jbt" class="tb_jbt_kd_jbt">
<span<?php echo $tb_jbt->kd_jbt->ViewAttributes() ?>>
<?php echo $tb_jbt->kd_jbt->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->ket->Visible) { // ket ?>
		<td data-name="ket"<?php echo $tb_jbt->ket->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_ket" class="tb_jbt_ket">
<span<?php echo $tb_jbt->ket->ViewAttributes() ?>>
<?php echo $tb_jbt->ket->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->tjb->Visible) { // tjb ?>
		<td data-name="tjb"<?php echo $tb_jbt->tjb->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_tjb" class="tb_jbt_tjb">
<span<?php echo $tb_jbt->tjb->ViewAttributes() ?>>
<?php echo $tb_jbt->tjb->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->koef->Visible) { // koef ?>
		<td data-name="koef"<?php echo $tb_jbt->koef->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_koef" class="tb_jbt_koef">
<span<?php echo $tb_jbt->koef->ViewAttributes() ?>>
<?php echo $tb_jbt->koef->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->created_by->Visible) { // created_by ?>
		<td data-name="created_by"<?php echo $tb_jbt->created_by->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_created_by" class="tb_jbt_created_by">
<span<?php echo $tb_jbt->created_by->ViewAttributes() ?>>
<?php echo $tb_jbt->created_by->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->created_date->Visible) { // created_date ?>
		<td data-name="created_date"<?php echo $tb_jbt->created_date->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_created_date" class="tb_jbt_created_date">
<span<?php echo $tb_jbt->created_date->ViewAttributes() ?>>
<?php echo $tb_jbt->created_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->last_update_by->Visible) { // last_update_by ?>
		<td data-name="last_update_by"<?php echo $tb_jbt->last_update_by->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_last_update_by" class="tb_jbt_last_update_by">
<span<?php echo $tb_jbt->last_update_by->ViewAttributes() ?>>
<?php echo $tb_jbt->last_update_by->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->last_update_date->Visible) { // last_update_date ?>
		<td data-name="last_update_date"<?php echo $tb_jbt->last_update_date->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_last_update_date" class="tb_jbt_last_update_date">
<span<?php echo $tb_jbt->last_update_date->ViewAttributes() ?>>
<?php echo $tb_jbt->last_update_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->kd_jbt_old->Visible) { // kd_jbt_old ?>
		<td data-name="kd_jbt_old"<?php echo $tb_jbt->kd_jbt_old->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_kd_jbt_old" class="tb_jbt_kd_jbt_old">
<span<?php echo $tb_jbt->kd_jbt_old->ViewAttributes() ?>>
<?php echo $tb_jbt->kd_jbt_old->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->ket_old->Visible) { // ket_old ?>
		<td data-name="ket_old"<?php echo $tb_jbt->ket_old->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_ket_old" class="tb_jbt_ket_old">
<span<?php echo $tb_jbt->ket_old->ViewAttributes() ?>>
<?php echo $tb_jbt->ket_old->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->jbt_type->Visible) { // jbt_type ?>
		<td data-name="jbt_type"<?php echo $tb_jbt->jbt_type->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_jbt_type" class="tb_jbt_jbt_type">
<span<?php echo $tb_jbt->jbt_type->ViewAttributes() ?>>
<?php echo $tb_jbt->jbt_type->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->org_id->Visible) { // org_id ?>
		<td data-name="org_id"<?php echo $tb_jbt->org_id->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_org_id" class="tb_jbt_org_id">
<span<?php echo $tb_jbt->org_id->ViewAttributes() ?>>
<?php echo $tb_jbt->org_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->parent_kd_jbt->Visible) { // parent_kd_jbt ?>
		<td data-name="parent_kd_jbt"<?php echo $tb_jbt->parent_kd_jbt->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_parent_kd_jbt" class="tb_jbt_parent_kd_jbt">
<span<?php echo $tb_jbt->parent_kd_jbt->ViewAttributes() ?>>
<?php echo $tb_jbt->parent_kd_jbt->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->eselon_num->Visible) { // eselon_num ?>
		<td data-name="eselon_num"<?php echo $tb_jbt->eselon_num->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_eselon_num" class="tb_jbt_eselon_num">
<span<?php echo $tb_jbt->eselon_num->ViewAttributes() ?>>
<?php echo $tb_jbt->eselon_num->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->jns_jbt->Visible) { // jns_jbt ?>
		<td data-name="jns_jbt"<?php echo $tb_jbt->jns_jbt->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_jns_jbt" class="tb_jbt_jns_jbt">
<span<?php echo $tb_jbt->jns_jbt->ViewAttributes() ?>>
<?php echo $tb_jbt->jns_jbt->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_jbt->status->Visible) { // status ?>
		<td data-name="status"<?php echo $tb_jbt->status->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_list->RowCnt ?>_tb_jbt_status" class="tb_jbt_status">
<span<?php echo $tb_jbt->status->ViewAttributes() ?>>
<?php echo $tb_jbt->status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tb_jbt_list->ListOptions->Render("body", "right", $tb_jbt_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($tb_jbt->CurrentAction <> "gridadd")
		$tb_jbt_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($tb_jbt->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($tb_jbt_list->Recordset)
	$tb_jbt_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($tb_jbt->CurrentAction <> "gridadd" && $tb_jbt->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($tb_jbt_list->Pager)) $tb_jbt_list->Pager = new cPrevNextPager($tb_jbt_list->StartRec, $tb_jbt_list->DisplayRecs, $tb_jbt_list->TotalRecs, $tb_jbt_list->AutoHidePager) ?>
<?php if ($tb_jbt_list->Pager->RecordCount > 0 && $tb_jbt_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($tb_jbt_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $tb_jbt_list->PageUrl() ?>start=<?php echo $tb_jbt_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($tb_jbt_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $tb_jbt_list->PageUrl() ?>start=<?php echo $tb_jbt_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tb_jbt_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($tb_jbt_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $tb_jbt_list->PageUrl() ?>start=<?php echo $tb_jbt_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($tb_jbt_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $tb_jbt_list->PageUrl() ?>start=<?php echo $tb_jbt_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tb_jbt_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($tb_jbt_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tb_jbt_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tb_jbt_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tb_jbt_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tb_jbt_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($tb_jbt_list->TotalRecs == 0 && $tb_jbt->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tb_jbt_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ftb_jbtlistsrch.FilterList = <?php echo $tb_jbt_list->GetFilterList() ?>;
ftb_jbtlistsrch.Init();
ftb_jbtlist.Init();
</script>
<?php
$tb_jbt_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_jbt_list->Page_Terminate();
?>
