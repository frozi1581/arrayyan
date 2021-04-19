<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "rwy_pendidikaninfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$rwy_pendidikan_list = NULL; // Initialize page object first

class crwy_pendidikan_list extends crwy_pendidikan {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'rwy_pendidikan';

	// Page object name
	var $PageObjName = 'rwy_pendidikan_list';

	// Grid form hidden field names
	var $FormName = 'frwy_pendidikanlist';
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

		// Table object (rwy_pendidikan)
		if (!isset($GLOBALS["rwy_pendidikan"]) || get_class($GLOBALS["rwy_pendidikan"]) == "crwy_pendidikan") {
			$GLOBALS["rwy_pendidikan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["rwy_pendidikan"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "rwy_pendidikanadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "rwy_pendidikandelete.php";
		$this->MultiUpdateUrl = "rwy_pendidikanupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rwy_pendidikan', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption frwy_pendidikanlistsrch";

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
		$this->nip->SetVisibility();
		$this->pendidikan_terakhir->SetVisibility();
		$this->jurusan->SetVisibility();
		$this->nama_lembaga->SetVisibility();
		$this->no_ijazah->SetVisibility();
		$this->tanggal_ijazah->SetVisibility();
		$this->lokasi_pendidikan->SetVisibility();
		$this->stat_validasi->SetVisibility();
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
		global $EW_EXPORT, $rwy_pendidikan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($rwy_pendidikan);
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
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "frwy_pendidikanlistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJson(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->nip->AdvancedSearch->ToJson(), ","); // Field nip
		$sFilterList = ew_Concat($sFilterList, $this->pendidikan_terakhir->AdvancedSearch->ToJson(), ","); // Field pendidikan_terakhir
		$sFilterList = ew_Concat($sFilterList, $this->jurusan->AdvancedSearch->ToJson(), ","); // Field jurusan
		$sFilterList = ew_Concat($sFilterList, $this->nama_lembaga->AdvancedSearch->ToJson(), ","); // Field nama_lembaga
		$sFilterList = ew_Concat($sFilterList, $this->no_ijazah->AdvancedSearch->ToJson(), ","); // Field no_ijazah
		$sFilterList = ew_Concat($sFilterList, $this->tanggal_ijazah->AdvancedSearch->ToJson(), ","); // Field tanggal_ijazah
		$sFilterList = ew_Concat($sFilterList, $this->lokasi_pendidikan->AdvancedSearch->ToJson(), ","); // Field lokasi_pendidikan
		$sFilterList = ew_Concat($sFilterList, $this->stat_validasi->AdvancedSearch->ToJson(), ","); // Field stat_validasi
		$sFilterList = ew_Concat($sFilterList, $this->change_date->AdvancedSearch->ToJson(), ","); // Field change_date
		$sFilterList = ew_Concat($sFilterList, $this->change_by->AdvancedSearch->ToJson(), ","); // Field change_by
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "frwy_pendidikanlistsrch", $filters);

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

		// Field nip
		$this->nip->AdvancedSearch->SearchValue = @$filter["x_nip"];
		$this->nip->AdvancedSearch->SearchOperator = @$filter["z_nip"];
		$this->nip->AdvancedSearch->SearchCondition = @$filter["v_nip"];
		$this->nip->AdvancedSearch->SearchValue2 = @$filter["y_nip"];
		$this->nip->AdvancedSearch->SearchOperator2 = @$filter["w_nip"];
		$this->nip->AdvancedSearch->Save();

		// Field pendidikan_terakhir
		$this->pendidikan_terakhir->AdvancedSearch->SearchValue = @$filter["x_pendidikan_terakhir"];
		$this->pendidikan_terakhir->AdvancedSearch->SearchOperator = @$filter["z_pendidikan_terakhir"];
		$this->pendidikan_terakhir->AdvancedSearch->SearchCondition = @$filter["v_pendidikan_terakhir"];
		$this->pendidikan_terakhir->AdvancedSearch->SearchValue2 = @$filter["y_pendidikan_terakhir"];
		$this->pendidikan_terakhir->AdvancedSearch->SearchOperator2 = @$filter["w_pendidikan_terakhir"];
		$this->pendidikan_terakhir->AdvancedSearch->Save();

		// Field jurusan
		$this->jurusan->AdvancedSearch->SearchValue = @$filter["x_jurusan"];
		$this->jurusan->AdvancedSearch->SearchOperator = @$filter["z_jurusan"];
		$this->jurusan->AdvancedSearch->SearchCondition = @$filter["v_jurusan"];
		$this->jurusan->AdvancedSearch->SearchValue2 = @$filter["y_jurusan"];
		$this->jurusan->AdvancedSearch->SearchOperator2 = @$filter["w_jurusan"];
		$this->jurusan->AdvancedSearch->Save();

		// Field nama_lembaga
		$this->nama_lembaga->AdvancedSearch->SearchValue = @$filter["x_nama_lembaga"];
		$this->nama_lembaga->AdvancedSearch->SearchOperator = @$filter["z_nama_lembaga"];
		$this->nama_lembaga->AdvancedSearch->SearchCondition = @$filter["v_nama_lembaga"];
		$this->nama_lembaga->AdvancedSearch->SearchValue2 = @$filter["y_nama_lembaga"];
		$this->nama_lembaga->AdvancedSearch->SearchOperator2 = @$filter["w_nama_lembaga"];
		$this->nama_lembaga->AdvancedSearch->Save();

		// Field no_ijazah
		$this->no_ijazah->AdvancedSearch->SearchValue = @$filter["x_no_ijazah"];
		$this->no_ijazah->AdvancedSearch->SearchOperator = @$filter["z_no_ijazah"];
		$this->no_ijazah->AdvancedSearch->SearchCondition = @$filter["v_no_ijazah"];
		$this->no_ijazah->AdvancedSearch->SearchValue2 = @$filter["y_no_ijazah"];
		$this->no_ijazah->AdvancedSearch->SearchOperator2 = @$filter["w_no_ijazah"];
		$this->no_ijazah->AdvancedSearch->Save();

		// Field tanggal_ijazah
		$this->tanggal_ijazah->AdvancedSearch->SearchValue = @$filter["x_tanggal_ijazah"];
		$this->tanggal_ijazah->AdvancedSearch->SearchOperator = @$filter["z_tanggal_ijazah"];
		$this->tanggal_ijazah->AdvancedSearch->SearchCondition = @$filter["v_tanggal_ijazah"];
		$this->tanggal_ijazah->AdvancedSearch->SearchValue2 = @$filter["y_tanggal_ijazah"];
		$this->tanggal_ijazah->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal_ijazah"];
		$this->tanggal_ijazah->AdvancedSearch->Save();

		// Field lokasi_pendidikan
		$this->lokasi_pendidikan->AdvancedSearch->SearchValue = @$filter["x_lokasi_pendidikan"];
		$this->lokasi_pendidikan->AdvancedSearch->SearchOperator = @$filter["z_lokasi_pendidikan"];
		$this->lokasi_pendidikan->AdvancedSearch->SearchCondition = @$filter["v_lokasi_pendidikan"];
		$this->lokasi_pendidikan->AdvancedSearch->SearchValue2 = @$filter["y_lokasi_pendidikan"];
		$this->lokasi_pendidikan->AdvancedSearch->SearchOperator2 = @$filter["w_lokasi_pendidikan"];
		$this->lokasi_pendidikan->AdvancedSearch->Save();

		// Field stat_validasi
		$this->stat_validasi->AdvancedSearch->SearchValue = @$filter["x_stat_validasi"];
		$this->stat_validasi->AdvancedSearch->SearchOperator = @$filter["z_stat_validasi"];
		$this->stat_validasi->AdvancedSearch->SearchCondition = @$filter["v_stat_validasi"];
		$this->stat_validasi->AdvancedSearch->SearchValue2 = @$filter["y_stat_validasi"];
		$this->stat_validasi->AdvancedSearch->SearchOperator2 = @$filter["w_stat_validasi"];
		$this->stat_validasi->AdvancedSearch->Save();

		// Field change_date
		$this->change_date->AdvancedSearch->SearchValue = @$filter["x_change_date"];
		$this->change_date->AdvancedSearch->SearchOperator = @$filter["z_change_date"];
		$this->change_date->AdvancedSearch->SearchCondition = @$filter["v_change_date"];
		$this->change_date->AdvancedSearch->SearchValue2 = @$filter["y_change_date"];
		$this->change_date->AdvancedSearch->SearchOperator2 = @$filter["w_change_date"];
		$this->change_date->AdvancedSearch->Save();

		// Field change_by
		$this->change_by->AdvancedSearch->SearchValue = @$filter["x_change_by"];
		$this->change_by->AdvancedSearch->SearchOperator = @$filter["z_change_by"];
		$this->change_by->AdvancedSearch->SearchCondition = @$filter["v_change_by"];
		$this->change_by->AdvancedSearch->SearchValue2 = @$filter["y_change_by"];
		$this->change_by->AdvancedSearch->SearchOperator2 = @$filter["w_change_by"];
		$this->change_by->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->nip, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pendidikan_terakhir, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jurusan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_lembaga, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->no_ijazah, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->lokasi_pendidikan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->change_by, $arKeywords, $type);
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
			$this->UpdateSort($this->nip); // nip
			$this->UpdateSort($this->pendidikan_terakhir); // pendidikan_terakhir
			$this->UpdateSort($this->jurusan); // jurusan
			$this->UpdateSort($this->nama_lembaga); // nama_lembaga
			$this->UpdateSort($this->no_ijazah); // no_ijazah
			$this->UpdateSort($this->tanggal_ijazah); // tanggal_ijazah
			$this->UpdateSort($this->lokasi_pendidikan); // lokasi_pendidikan
			$this->UpdateSort($this->stat_validasi); // stat_validasi
			$this->UpdateSort($this->change_date); // change_date
			$this->UpdateSort($this->change_by); // change_by
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
				$this->nip->setSort("");
				$this->pendidikan_terakhir->setSort("");
				$this->jurusan->setSort("");
				$this->nama_lembaga->setSort("");
				$this->no_ijazah->setSort("");
				$this->tanggal_ijazah->setSort("");
				$this->lokasi_pendidikan->setSort("");
				$this->stat_validasi->setSort("");
				$this->change_date->setSort("");
				$this->change_by->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"frwy_pendidikanlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"frwy_pendidikanlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.frwy_pendidikanlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"frwy_pendidikanlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$this->nip->setDbValue($row['nip']);
		$this->pendidikan_terakhir->setDbValue($row['pendidikan_terakhir']);
		$this->jurusan->setDbValue($row['jurusan']);
		$this->nama_lembaga->setDbValue($row['nama_lembaga']);
		$this->no_ijazah->setDbValue($row['no_ijazah']);
		$this->tanggal_ijazah->setDbValue($row['tanggal_ijazah']);
		$this->lokasi_pendidikan->setDbValue($row['lokasi_pendidikan']);
		$this->stat_validasi->setDbValue($row['stat_validasi']);
		$this->change_date->setDbValue($row['change_date']);
		$this->change_by->setDbValue($row['change_by']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['nip'] = NULL;
		$row['pendidikan_terakhir'] = NULL;
		$row['jurusan'] = NULL;
		$row['nama_lembaga'] = NULL;
		$row['no_ijazah'] = NULL;
		$row['tanggal_ijazah'] = NULL;
		$row['lokasi_pendidikan'] = NULL;
		$row['stat_validasi'] = NULL;
		$row['change_date'] = NULL;
		$row['change_by'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->nip->DbValue = $row['nip'];
		$this->pendidikan_terakhir->DbValue = $row['pendidikan_terakhir'];
		$this->jurusan->DbValue = $row['jurusan'];
		$this->nama_lembaga->DbValue = $row['nama_lembaga'];
		$this->no_ijazah->DbValue = $row['no_ijazah'];
		$this->tanggal_ijazah->DbValue = $row['tanggal_ijazah'];
		$this->lokasi_pendidikan->DbValue = $row['lokasi_pendidikan'];
		$this->stat_validasi->DbValue = $row['stat_validasi'];
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
		// nip
		// pendidikan_terakhir
		// jurusan
		// nama_lembaga
		// no_ijazah
		// tanggal_ijazah
		// lokasi_pendidikan
		// stat_validasi
		// change_date
		// change_by

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nip
		$this->nip->ViewValue = $this->nip->CurrentValue;
		$this->nip->ViewCustomAttributes = "";

		// pendidikan_terakhir
		$this->pendidikan_terakhir->ViewValue = $this->pendidikan_terakhir->CurrentValue;
		$this->pendidikan_terakhir->ViewCustomAttributes = "";

		// jurusan
		$this->jurusan->ViewValue = $this->jurusan->CurrentValue;
		$this->jurusan->ViewCustomAttributes = "";

		// nama_lembaga
		$this->nama_lembaga->ViewValue = $this->nama_lembaga->CurrentValue;
		$this->nama_lembaga->ViewCustomAttributes = "";

		// no_ijazah
		$this->no_ijazah->ViewValue = $this->no_ijazah->CurrentValue;
		$this->no_ijazah->ViewCustomAttributes = "";

		// tanggal_ijazah
		$this->tanggal_ijazah->ViewValue = $this->tanggal_ijazah->CurrentValue;
		$this->tanggal_ijazah->ViewValue = ew_FormatDateTime($this->tanggal_ijazah->ViewValue, 0);
		$this->tanggal_ijazah->ViewCustomAttributes = "";

		// lokasi_pendidikan
		$this->lokasi_pendidikan->ViewValue = $this->lokasi_pendidikan->CurrentValue;
		$this->lokasi_pendidikan->ViewCustomAttributes = "";

		// stat_validasi
		$this->stat_validasi->ViewValue = $this->stat_validasi->CurrentValue;
		$this->stat_validasi->ViewCustomAttributes = "";

		// change_date
		$this->change_date->ViewValue = $this->change_date->CurrentValue;
		$this->change_date->ViewValue = ew_FormatDateTime($this->change_date->ViewValue, 0);
		$this->change_date->ViewCustomAttributes = "";

		// change_by
		$this->change_by->ViewValue = $this->change_by->CurrentValue;
		$this->change_by->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// nip
			$this->nip->LinkCustomAttributes = "";
			$this->nip->HrefValue = "";
			$this->nip->TooltipValue = "";

			// pendidikan_terakhir
			$this->pendidikan_terakhir->LinkCustomAttributes = "";
			$this->pendidikan_terakhir->HrefValue = "";
			$this->pendidikan_terakhir->TooltipValue = "";

			// jurusan
			$this->jurusan->LinkCustomAttributes = "";
			$this->jurusan->HrefValue = "";
			$this->jurusan->TooltipValue = "";

			// nama_lembaga
			$this->nama_lembaga->LinkCustomAttributes = "";
			$this->nama_lembaga->HrefValue = "";
			$this->nama_lembaga->TooltipValue = "";

			// no_ijazah
			$this->no_ijazah->LinkCustomAttributes = "";
			$this->no_ijazah->HrefValue = "";
			$this->no_ijazah->TooltipValue = "";

			// tanggal_ijazah
			$this->tanggal_ijazah->LinkCustomAttributes = "";
			$this->tanggal_ijazah->HrefValue = "";
			$this->tanggal_ijazah->TooltipValue = "";

			// lokasi_pendidikan
			$this->lokasi_pendidikan->LinkCustomAttributes = "";
			$this->lokasi_pendidikan->HrefValue = "";
			$this->lokasi_pendidikan->TooltipValue = "";

			// stat_validasi
			$this->stat_validasi->LinkCustomAttributes = "";
			$this->stat_validasi->HrefValue = "";
			$this->stat_validasi->TooltipValue = "";

			// change_date
			$this->change_date->LinkCustomAttributes = "";
			$this->change_date->HrefValue = "";
			$this->change_date->TooltipValue = "";

			// change_by
			$this->change_by->LinkCustomAttributes = "";
			$this->change_by->HrefValue = "";
			$this->change_by->TooltipValue = "";
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
if (!isset($rwy_pendidikan_list)) $rwy_pendidikan_list = new crwy_pendidikan_list();

// Page init
$rwy_pendidikan_list->Page_Init();

// Page main
$rwy_pendidikan_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$rwy_pendidikan_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = frwy_pendidikanlist = new ew_Form("frwy_pendidikanlist", "list");
frwy_pendidikanlist.FormKeyCountName = '<?php echo $rwy_pendidikan_list->FormKeyCountName ?>';

// Form_CustomValidate event
frwy_pendidikanlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
frwy_pendidikanlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = frwy_pendidikanlistsrch = new ew_Form("frwy_pendidikanlistsrch");
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
<?php if ($rwy_pendidikan_list->TotalRecs > 0 && $rwy_pendidikan_list->ExportOptions->Visible()) { ?>
<?php $rwy_pendidikan_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($rwy_pendidikan_list->SearchOptions->Visible()) { ?>
<?php $rwy_pendidikan_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($rwy_pendidikan_list->FilterOptions->Visible()) { ?>
<?php $rwy_pendidikan_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $rwy_pendidikan_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($rwy_pendidikan_list->TotalRecs <= 0)
			$rwy_pendidikan_list->TotalRecs = $rwy_pendidikan->ListRecordCount();
	} else {
		if (!$rwy_pendidikan_list->Recordset && ($rwy_pendidikan_list->Recordset = $rwy_pendidikan_list->LoadRecordset()))
			$rwy_pendidikan_list->TotalRecs = $rwy_pendidikan_list->Recordset->RecordCount();
	}
	$rwy_pendidikan_list->StartRec = 1;
	if ($rwy_pendidikan_list->DisplayRecs <= 0 || ($rwy_pendidikan->Export <> "" && $rwy_pendidikan->ExportAll)) // Display all records
		$rwy_pendidikan_list->DisplayRecs = $rwy_pendidikan_list->TotalRecs;
	if (!($rwy_pendidikan->Export <> "" && $rwy_pendidikan->ExportAll))
		$rwy_pendidikan_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rwy_pendidikan_list->Recordset = $rwy_pendidikan_list->LoadRecordset($rwy_pendidikan_list->StartRec-1, $rwy_pendidikan_list->DisplayRecs);

	// Set no record found message
	if ($rwy_pendidikan->CurrentAction == "" && $rwy_pendidikan_list->TotalRecs == 0) {
		if ($rwy_pendidikan_list->SearchWhere == "0=101")
			$rwy_pendidikan_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$rwy_pendidikan_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$rwy_pendidikan_list->RenderOtherOptions();
?>
<?php if ($rwy_pendidikan->Export == "" && $rwy_pendidikan->CurrentAction == "") { ?>
<form name="frwy_pendidikanlistsrch" id="frwy_pendidikanlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($rwy_pendidikan_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="frwy_pendidikanlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="rwy_pendidikan">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($rwy_pendidikan_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($rwy_pendidikan_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $rwy_pendidikan_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($rwy_pendidikan_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($rwy_pendidikan_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($rwy_pendidikan_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($rwy_pendidikan_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $rwy_pendidikan_list->ShowPageHeader(); ?>
<?php
$rwy_pendidikan_list->ShowMessage();
?>
<?php if ($rwy_pendidikan_list->TotalRecs > 0 || $rwy_pendidikan->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($rwy_pendidikan_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> rwy_pendidikan">
<form name="frwy_pendidikanlist" id="frwy_pendidikanlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($rwy_pendidikan_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $rwy_pendidikan_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="rwy_pendidikan">
<div id="gmp_rwy_pendidikan" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($rwy_pendidikan_list->TotalRecs > 0 || $rwy_pendidikan->CurrentAction == "gridedit") { ?>
<table id="tbl_rwy_pendidikanlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$rwy_pendidikan_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$rwy_pendidikan_list->RenderListOptions();

// Render list options (header, left)
$rwy_pendidikan_list->ListOptions->Render("header", "left");
?>
<?php if ($rwy_pendidikan->id->Visible) { // id ?>
	<?php if ($rwy_pendidikan->SortUrl($rwy_pendidikan->id) == "") { ?>
		<th data-name="id" class="<?php echo $rwy_pendidikan->id->HeaderCellClass() ?>"><div id="elh_rwy_pendidikan_id" class="rwy_pendidikan_id"><div class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $rwy_pendidikan->id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_pendidikan->SortUrl($rwy_pendidikan->id) ?>',1);"><div id="elh_rwy_pendidikan_id" class="rwy_pendidikan_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_pendidikan->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_pendidikan->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_pendidikan->nip->Visible) { // nip ?>
	<?php if ($rwy_pendidikan->SortUrl($rwy_pendidikan->nip) == "") { ?>
		<th data-name="nip" class="<?php echo $rwy_pendidikan->nip->HeaderCellClass() ?>"><div id="elh_rwy_pendidikan_nip" class="rwy_pendidikan_nip"><div class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->nip->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nip" class="<?php echo $rwy_pendidikan->nip->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_pendidikan->SortUrl($rwy_pendidikan->nip) ?>',1);"><div id="elh_rwy_pendidikan_nip" class="rwy_pendidikan_nip">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->nip->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($rwy_pendidikan->nip->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_pendidikan->nip->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_pendidikan->pendidikan_terakhir->Visible) { // pendidikan_terakhir ?>
	<?php if ($rwy_pendidikan->SortUrl($rwy_pendidikan->pendidikan_terakhir) == "") { ?>
		<th data-name="pendidikan_terakhir" class="<?php echo $rwy_pendidikan->pendidikan_terakhir->HeaderCellClass() ?>"><div id="elh_rwy_pendidikan_pendidikan_terakhir" class="rwy_pendidikan_pendidikan_terakhir"><div class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->pendidikan_terakhir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pendidikan_terakhir" class="<?php echo $rwy_pendidikan->pendidikan_terakhir->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_pendidikan->SortUrl($rwy_pendidikan->pendidikan_terakhir) ?>',1);"><div id="elh_rwy_pendidikan_pendidikan_terakhir" class="rwy_pendidikan_pendidikan_terakhir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->pendidikan_terakhir->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($rwy_pendidikan->pendidikan_terakhir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_pendidikan->pendidikan_terakhir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_pendidikan->jurusan->Visible) { // jurusan ?>
	<?php if ($rwy_pendidikan->SortUrl($rwy_pendidikan->jurusan) == "") { ?>
		<th data-name="jurusan" class="<?php echo $rwy_pendidikan->jurusan->HeaderCellClass() ?>"><div id="elh_rwy_pendidikan_jurusan" class="rwy_pendidikan_jurusan"><div class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->jurusan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jurusan" class="<?php echo $rwy_pendidikan->jurusan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_pendidikan->SortUrl($rwy_pendidikan->jurusan) ?>',1);"><div id="elh_rwy_pendidikan_jurusan" class="rwy_pendidikan_jurusan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->jurusan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($rwy_pendidikan->jurusan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_pendidikan->jurusan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_pendidikan->nama_lembaga->Visible) { // nama_lembaga ?>
	<?php if ($rwy_pendidikan->SortUrl($rwy_pendidikan->nama_lembaga) == "") { ?>
		<th data-name="nama_lembaga" class="<?php echo $rwy_pendidikan->nama_lembaga->HeaderCellClass() ?>"><div id="elh_rwy_pendidikan_nama_lembaga" class="rwy_pendidikan_nama_lembaga"><div class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->nama_lembaga->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_lembaga" class="<?php echo $rwy_pendidikan->nama_lembaga->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_pendidikan->SortUrl($rwy_pendidikan->nama_lembaga) ?>',1);"><div id="elh_rwy_pendidikan_nama_lembaga" class="rwy_pendidikan_nama_lembaga">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->nama_lembaga->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($rwy_pendidikan->nama_lembaga->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_pendidikan->nama_lembaga->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_pendidikan->no_ijazah->Visible) { // no_ijazah ?>
	<?php if ($rwy_pendidikan->SortUrl($rwy_pendidikan->no_ijazah) == "") { ?>
		<th data-name="no_ijazah" class="<?php echo $rwy_pendidikan->no_ijazah->HeaderCellClass() ?>"><div id="elh_rwy_pendidikan_no_ijazah" class="rwy_pendidikan_no_ijazah"><div class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->no_ijazah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_ijazah" class="<?php echo $rwy_pendidikan->no_ijazah->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_pendidikan->SortUrl($rwy_pendidikan->no_ijazah) ?>',1);"><div id="elh_rwy_pendidikan_no_ijazah" class="rwy_pendidikan_no_ijazah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->no_ijazah->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($rwy_pendidikan->no_ijazah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_pendidikan->no_ijazah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_pendidikan->tanggal_ijazah->Visible) { // tanggal_ijazah ?>
	<?php if ($rwy_pendidikan->SortUrl($rwy_pendidikan->tanggal_ijazah) == "") { ?>
		<th data-name="tanggal_ijazah" class="<?php echo $rwy_pendidikan->tanggal_ijazah->HeaderCellClass() ?>"><div id="elh_rwy_pendidikan_tanggal_ijazah" class="rwy_pendidikan_tanggal_ijazah"><div class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->tanggal_ijazah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tanggal_ijazah" class="<?php echo $rwy_pendidikan->tanggal_ijazah->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_pendidikan->SortUrl($rwy_pendidikan->tanggal_ijazah) ?>',1);"><div id="elh_rwy_pendidikan_tanggal_ijazah" class="rwy_pendidikan_tanggal_ijazah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->tanggal_ijazah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_pendidikan->tanggal_ijazah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_pendidikan->tanggal_ijazah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_pendidikan->lokasi_pendidikan->Visible) { // lokasi_pendidikan ?>
	<?php if ($rwy_pendidikan->SortUrl($rwy_pendidikan->lokasi_pendidikan) == "") { ?>
		<th data-name="lokasi_pendidikan" class="<?php echo $rwy_pendidikan->lokasi_pendidikan->HeaderCellClass() ?>"><div id="elh_rwy_pendidikan_lokasi_pendidikan" class="rwy_pendidikan_lokasi_pendidikan"><div class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->lokasi_pendidikan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lokasi_pendidikan" class="<?php echo $rwy_pendidikan->lokasi_pendidikan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_pendidikan->SortUrl($rwy_pendidikan->lokasi_pendidikan) ?>',1);"><div id="elh_rwy_pendidikan_lokasi_pendidikan" class="rwy_pendidikan_lokasi_pendidikan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->lokasi_pendidikan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($rwy_pendidikan->lokasi_pendidikan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_pendidikan->lokasi_pendidikan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_pendidikan->stat_validasi->Visible) { // stat_validasi ?>
	<?php if ($rwy_pendidikan->SortUrl($rwy_pendidikan->stat_validasi) == "") { ?>
		<th data-name="stat_validasi" class="<?php echo $rwy_pendidikan->stat_validasi->HeaderCellClass() ?>"><div id="elh_rwy_pendidikan_stat_validasi" class="rwy_pendidikan_stat_validasi"><div class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->stat_validasi->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="stat_validasi" class="<?php echo $rwy_pendidikan->stat_validasi->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_pendidikan->SortUrl($rwy_pendidikan->stat_validasi) ?>',1);"><div id="elh_rwy_pendidikan_stat_validasi" class="rwy_pendidikan_stat_validasi">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->stat_validasi->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_pendidikan->stat_validasi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_pendidikan->stat_validasi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_pendidikan->change_date->Visible) { // change_date ?>
	<?php if ($rwy_pendidikan->SortUrl($rwy_pendidikan->change_date) == "") { ?>
		<th data-name="change_date" class="<?php echo $rwy_pendidikan->change_date->HeaderCellClass() ?>"><div id="elh_rwy_pendidikan_change_date" class="rwy_pendidikan_change_date"><div class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->change_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="change_date" class="<?php echo $rwy_pendidikan->change_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_pendidikan->SortUrl($rwy_pendidikan->change_date) ?>',1);"><div id="elh_rwy_pendidikan_change_date" class="rwy_pendidikan_change_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->change_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_pendidikan->change_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_pendidikan->change_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_pendidikan->change_by->Visible) { // change_by ?>
	<?php if ($rwy_pendidikan->SortUrl($rwy_pendidikan->change_by) == "") { ?>
		<th data-name="change_by" class="<?php echo $rwy_pendidikan->change_by->HeaderCellClass() ?>"><div id="elh_rwy_pendidikan_change_by" class="rwy_pendidikan_change_by"><div class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->change_by->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="change_by" class="<?php echo $rwy_pendidikan->change_by->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_pendidikan->SortUrl($rwy_pendidikan->change_by) ?>',1);"><div id="elh_rwy_pendidikan_change_by" class="rwy_pendidikan_change_by">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_pendidikan->change_by->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($rwy_pendidikan->change_by->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_pendidikan->change_by->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$rwy_pendidikan_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($rwy_pendidikan->ExportAll && $rwy_pendidikan->Export <> "") {
	$rwy_pendidikan_list->StopRec = $rwy_pendidikan_list->TotalRecs;
} else {

	// Set the last record to display
	if ($rwy_pendidikan_list->TotalRecs > $rwy_pendidikan_list->StartRec + $rwy_pendidikan_list->DisplayRecs - 1)
		$rwy_pendidikan_list->StopRec = $rwy_pendidikan_list->StartRec + $rwy_pendidikan_list->DisplayRecs - 1;
	else
		$rwy_pendidikan_list->StopRec = $rwy_pendidikan_list->TotalRecs;
}
$rwy_pendidikan_list->RecCnt = $rwy_pendidikan_list->StartRec - 1;
if ($rwy_pendidikan_list->Recordset && !$rwy_pendidikan_list->Recordset->EOF) {
	$rwy_pendidikan_list->Recordset->MoveFirst();
	$bSelectLimit = $rwy_pendidikan_list->UseSelectLimit;
	if (!$bSelectLimit && $rwy_pendidikan_list->StartRec > 1)
		$rwy_pendidikan_list->Recordset->Move($rwy_pendidikan_list->StartRec - 1);
} elseif (!$rwy_pendidikan->AllowAddDeleteRow && $rwy_pendidikan_list->StopRec == 0) {
	$rwy_pendidikan_list->StopRec = $rwy_pendidikan->GridAddRowCount;
}

// Initialize aggregate
$rwy_pendidikan->RowType = EW_ROWTYPE_AGGREGATEINIT;
$rwy_pendidikan->ResetAttrs();
$rwy_pendidikan_list->RenderRow();
while ($rwy_pendidikan_list->RecCnt < $rwy_pendidikan_list->StopRec) {
	$rwy_pendidikan_list->RecCnt++;
	if (intval($rwy_pendidikan_list->RecCnt) >= intval($rwy_pendidikan_list->StartRec)) {
		$rwy_pendidikan_list->RowCnt++;

		// Set up key count
		$rwy_pendidikan_list->KeyCount = $rwy_pendidikan_list->RowIndex;

		// Init row class and style
		$rwy_pendidikan->ResetAttrs();
		$rwy_pendidikan->CssClass = "";
		if ($rwy_pendidikan->CurrentAction == "gridadd") {
		} else {
			$rwy_pendidikan_list->LoadRowValues($rwy_pendidikan_list->Recordset); // Load row values
		}
		$rwy_pendidikan->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$rwy_pendidikan->RowAttrs = array_merge($rwy_pendidikan->RowAttrs, array('data-rowindex'=>$rwy_pendidikan_list->RowCnt, 'id'=>'r' . $rwy_pendidikan_list->RowCnt . '_rwy_pendidikan', 'data-rowtype'=>$rwy_pendidikan->RowType));

		// Render row
		$rwy_pendidikan_list->RenderRow();

		// Render list options
		$rwy_pendidikan_list->RenderListOptions();
?>
	<tr<?php echo $rwy_pendidikan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$rwy_pendidikan_list->ListOptions->Render("body", "left", $rwy_pendidikan_list->RowCnt);
?>
	<?php if ($rwy_pendidikan->id->Visible) { // id ?>
		<td data-name="id"<?php echo $rwy_pendidikan->id->CellAttributes() ?>>
<span id="el<?php echo $rwy_pendidikan_list->RowCnt ?>_rwy_pendidikan_id" class="rwy_pendidikan_id">
<span<?php echo $rwy_pendidikan->id->ViewAttributes() ?>>
<?php echo $rwy_pendidikan->id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_pendidikan->nip->Visible) { // nip ?>
		<td data-name="nip"<?php echo $rwy_pendidikan->nip->CellAttributes() ?>>
<span id="el<?php echo $rwy_pendidikan_list->RowCnt ?>_rwy_pendidikan_nip" class="rwy_pendidikan_nip">
<span<?php echo $rwy_pendidikan->nip->ViewAttributes() ?>>
<?php echo $rwy_pendidikan->nip->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_pendidikan->pendidikan_terakhir->Visible) { // pendidikan_terakhir ?>
		<td data-name="pendidikan_terakhir"<?php echo $rwy_pendidikan->pendidikan_terakhir->CellAttributes() ?>>
<span id="el<?php echo $rwy_pendidikan_list->RowCnt ?>_rwy_pendidikan_pendidikan_terakhir" class="rwy_pendidikan_pendidikan_terakhir">
<span<?php echo $rwy_pendidikan->pendidikan_terakhir->ViewAttributes() ?>>
<?php echo $rwy_pendidikan->pendidikan_terakhir->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_pendidikan->jurusan->Visible) { // jurusan ?>
		<td data-name="jurusan"<?php echo $rwy_pendidikan->jurusan->CellAttributes() ?>>
<span id="el<?php echo $rwy_pendidikan_list->RowCnt ?>_rwy_pendidikan_jurusan" class="rwy_pendidikan_jurusan">
<span<?php echo $rwy_pendidikan->jurusan->ViewAttributes() ?>>
<?php echo $rwy_pendidikan->jurusan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_pendidikan->nama_lembaga->Visible) { // nama_lembaga ?>
		<td data-name="nama_lembaga"<?php echo $rwy_pendidikan->nama_lembaga->CellAttributes() ?>>
<span id="el<?php echo $rwy_pendidikan_list->RowCnt ?>_rwy_pendidikan_nama_lembaga" class="rwy_pendidikan_nama_lembaga">
<span<?php echo $rwy_pendidikan->nama_lembaga->ViewAttributes() ?>>
<?php echo $rwy_pendidikan->nama_lembaga->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_pendidikan->no_ijazah->Visible) { // no_ijazah ?>
		<td data-name="no_ijazah"<?php echo $rwy_pendidikan->no_ijazah->CellAttributes() ?>>
<span id="el<?php echo $rwy_pendidikan_list->RowCnt ?>_rwy_pendidikan_no_ijazah" class="rwy_pendidikan_no_ijazah">
<span<?php echo $rwy_pendidikan->no_ijazah->ViewAttributes() ?>>
<?php echo $rwy_pendidikan->no_ijazah->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_pendidikan->tanggal_ijazah->Visible) { // tanggal_ijazah ?>
		<td data-name="tanggal_ijazah"<?php echo $rwy_pendidikan->tanggal_ijazah->CellAttributes() ?>>
<span id="el<?php echo $rwy_pendidikan_list->RowCnt ?>_rwy_pendidikan_tanggal_ijazah" class="rwy_pendidikan_tanggal_ijazah">
<span<?php echo $rwy_pendidikan->tanggal_ijazah->ViewAttributes() ?>>
<?php echo $rwy_pendidikan->tanggal_ijazah->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_pendidikan->lokasi_pendidikan->Visible) { // lokasi_pendidikan ?>
		<td data-name="lokasi_pendidikan"<?php echo $rwy_pendidikan->lokasi_pendidikan->CellAttributes() ?>>
<span id="el<?php echo $rwy_pendidikan_list->RowCnt ?>_rwy_pendidikan_lokasi_pendidikan" class="rwy_pendidikan_lokasi_pendidikan">
<span<?php echo $rwy_pendidikan->lokasi_pendidikan->ViewAttributes() ?>>
<?php echo $rwy_pendidikan->lokasi_pendidikan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_pendidikan->stat_validasi->Visible) { // stat_validasi ?>
		<td data-name="stat_validasi"<?php echo $rwy_pendidikan->stat_validasi->CellAttributes() ?>>
<span id="el<?php echo $rwy_pendidikan_list->RowCnt ?>_rwy_pendidikan_stat_validasi" class="rwy_pendidikan_stat_validasi">
<span<?php echo $rwy_pendidikan->stat_validasi->ViewAttributes() ?>>
<?php echo $rwy_pendidikan->stat_validasi->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_pendidikan->change_date->Visible) { // change_date ?>
		<td data-name="change_date"<?php echo $rwy_pendidikan->change_date->CellAttributes() ?>>
<span id="el<?php echo $rwy_pendidikan_list->RowCnt ?>_rwy_pendidikan_change_date" class="rwy_pendidikan_change_date">
<span<?php echo $rwy_pendidikan->change_date->ViewAttributes() ?>>
<?php echo $rwy_pendidikan->change_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_pendidikan->change_by->Visible) { // change_by ?>
		<td data-name="change_by"<?php echo $rwy_pendidikan->change_by->CellAttributes() ?>>
<span id="el<?php echo $rwy_pendidikan_list->RowCnt ?>_rwy_pendidikan_change_by" class="rwy_pendidikan_change_by">
<span<?php echo $rwy_pendidikan->change_by->ViewAttributes() ?>>
<?php echo $rwy_pendidikan->change_by->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$rwy_pendidikan_list->ListOptions->Render("body", "right", $rwy_pendidikan_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($rwy_pendidikan->CurrentAction <> "gridadd")
		$rwy_pendidikan_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($rwy_pendidikan->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($rwy_pendidikan_list->Recordset)
	$rwy_pendidikan_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($rwy_pendidikan->CurrentAction <> "gridadd" && $rwy_pendidikan->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($rwy_pendidikan_list->Pager)) $rwy_pendidikan_list->Pager = new cPrevNextPager($rwy_pendidikan_list->StartRec, $rwy_pendidikan_list->DisplayRecs, $rwy_pendidikan_list->TotalRecs, $rwy_pendidikan_list->AutoHidePager) ?>
<?php if ($rwy_pendidikan_list->Pager->RecordCount > 0 && $rwy_pendidikan_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($rwy_pendidikan_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $rwy_pendidikan_list->PageUrl() ?>start=<?php echo $rwy_pendidikan_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($rwy_pendidikan_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $rwy_pendidikan_list->PageUrl() ?>start=<?php echo $rwy_pendidikan_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $rwy_pendidikan_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($rwy_pendidikan_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $rwy_pendidikan_list->PageUrl() ?>start=<?php echo $rwy_pendidikan_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($rwy_pendidikan_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $rwy_pendidikan_list->PageUrl() ?>start=<?php echo $rwy_pendidikan_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $rwy_pendidikan_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($rwy_pendidikan_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $rwy_pendidikan_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $rwy_pendidikan_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $rwy_pendidikan_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($rwy_pendidikan_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($rwy_pendidikan_list->TotalRecs == 0 && $rwy_pendidikan->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($rwy_pendidikan_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
frwy_pendidikanlistsrch.FilterList = <?php echo $rwy_pendidikan_list->GetFilterList() ?>;
frwy_pendidikanlistsrch.Init();
frwy_pendidikanlist.Init();
</script>
<?php
$rwy_pendidikan_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$rwy_pendidikan_list->Page_Terminate();
?>
