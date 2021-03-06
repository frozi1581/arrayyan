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

$tb_notifikasi_list = NULL; // Initialize page object first

class ctb_notifikasi_list extends ctb_notifikasi {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'tb_notifikasi';

	// Page object name
	var $PageObjName = 'tb_notifikasi_list';

	// Grid form hidden field names
	var $FormName = 'ftb_notifikasilist';
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

		// Table object (tb_notifikasi)
		if (!isset($GLOBALS["tb_notifikasi"]) || get_class($GLOBALS["tb_notifikasi"]) == "ctb_notifikasi") {
			$GLOBALS["tb_notifikasi"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_notifikasi"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "tb_notifikasiadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "tb_notifikasidelete.php";
		$this->MultiUpdateUrl = "tb_notifikasiupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ftb_notifikasilistsrch";

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
		$this->topic->SetVisibility();
		$this->priority->SetVisibility();
		$this->isi_notif->SetVisibility();
		$this->action->SetVisibility();
		$this->tgl_cr->SetVisibility();
		$this->tgl_upd->SetVisibility();

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
	var $DisplayRecs = 10;
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
			$this->DisplayRecs = 10; // Load default
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "ftb_notifikasilistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJson(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->topic->AdvancedSearch->ToJson(), ","); // Field topic
		$sFilterList = ew_Concat($sFilterList, $this->priority->AdvancedSearch->ToJson(), ","); // Field priority
		$sFilterList = ew_Concat($sFilterList, $this->isi_notif->AdvancedSearch->ToJson(), ","); // Field isi_notif
		$sFilterList = ew_Concat($sFilterList, $this->action->AdvancedSearch->ToJson(), ","); // Field action
		$sFilterList = ew_Concat($sFilterList, $this->tgl_cr->AdvancedSearch->ToJson(), ","); // Field tgl_cr
		$sFilterList = ew_Concat($sFilterList, $this->cr_by->AdvancedSearch->ToJson(), ","); // Field cr_by
		$sFilterList = ew_Concat($sFilterList, $this->filter_penerima->AdvancedSearch->ToJson(), ","); // Field filter_penerima
		$sFilterList = ew_Concat($sFilterList, $this->tgl_upd->AdvancedSearch->ToJson(), ","); // Field tgl_upd
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ftb_notifikasilistsrch", $filters);

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

		// Field topic
		$this->topic->AdvancedSearch->SearchValue = @$filter["x_topic"];
		$this->topic->AdvancedSearch->SearchOperator = @$filter["z_topic"];
		$this->topic->AdvancedSearch->SearchCondition = @$filter["v_topic"];
		$this->topic->AdvancedSearch->SearchValue2 = @$filter["y_topic"];
		$this->topic->AdvancedSearch->SearchOperator2 = @$filter["w_topic"];
		$this->topic->AdvancedSearch->Save();

		// Field priority
		$this->priority->AdvancedSearch->SearchValue = @$filter["x_priority"];
		$this->priority->AdvancedSearch->SearchOperator = @$filter["z_priority"];
		$this->priority->AdvancedSearch->SearchCondition = @$filter["v_priority"];
		$this->priority->AdvancedSearch->SearchValue2 = @$filter["y_priority"];
		$this->priority->AdvancedSearch->SearchOperator2 = @$filter["w_priority"];
		$this->priority->AdvancedSearch->Save();

		// Field isi_notif
		$this->isi_notif->AdvancedSearch->SearchValue = @$filter["x_isi_notif"];
		$this->isi_notif->AdvancedSearch->SearchOperator = @$filter["z_isi_notif"];
		$this->isi_notif->AdvancedSearch->SearchCondition = @$filter["v_isi_notif"];
		$this->isi_notif->AdvancedSearch->SearchValue2 = @$filter["y_isi_notif"];
		$this->isi_notif->AdvancedSearch->SearchOperator2 = @$filter["w_isi_notif"];
		$this->isi_notif->AdvancedSearch->Save();

		// Field action
		$this->action->AdvancedSearch->SearchValue = @$filter["x_action"];
		$this->action->AdvancedSearch->SearchOperator = @$filter["z_action"];
		$this->action->AdvancedSearch->SearchCondition = @$filter["v_action"];
		$this->action->AdvancedSearch->SearchValue2 = @$filter["y_action"];
		$this->action->AdvancedSearch->SearchOperator2 = @$filter["w_action"];
		$this->action->AdvancedSearch->Save();

		// Field tgl_cr
		$this->tgl_cr->AdvancedSearch->SearchValue = @$filter["x_tgl_cr"];
		$this->tgl_cr->AdvancedSearch->SearchOperator = @$filter["z_tgl_cr"];
		$this->tgl_cr->AdvancedSearch->SearchCondition = @$filter["v_tgl_cr"];
		$this->tgl_cr->AdvancedSearch->SearchValue2 = @$filter["y_tgl_cr"];
		$this->tgl_cr->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_cr"];
		$this->tgl_cr->AdvancedSearch->Save();

		// Field cr_by
		$this->cr_by->AdvancedSearch->SearchValue = @$filter["x_cr_by"];
		$this->cr_by->AdvancedSearch->SearchOperator = @$filter["z_cr_by"];
		$this->cr_by->AdvancedSearch->SearchCondition = @$filter["v_cr_by"];
		$this->cr_by->AdvancedSearch->SearchValue2 = @$filter["y_cr_by"];
		$this->cr_by->AdvancedSearch->SearchOperator2 = @$filter["w_cr_by"];
		$this->cr_by->AdvancedSearch->Save();

		// Field filter_penerima
		$this->filter_penerima->AdvancedSearch->SearchValue = @$filter["x_filter_penerima"];
		$this->filter_penerima->AdvancedSearch->SearchOperator = @$filter["z_filter_penerima"];
		$this->filter_penerima->AdvancedSearch->SearchCondition = @$filter["v_filter_penerima"];
		$this->filter_penerima->AdvancedSearch->SearchValue2 = @$filter["y_filter_penerima"];
		$this->filter_penerima->AdvancedSearch->SearchOperator2 = @$filter["w_filter_penerima"];
		$this->filter_penerima->AdvancedSearch->Save();

		// Field tgl_upd
		$this->tgl_upd->AdvancedSearch->SearchValue = @$filter["x_tgl_upd"];
		$this->tgl_upd->AdvancedSearch->SearchOperator = @$filter["z_tgl_upd"];
		$this->tgl_upd->AdvancedSearch->SearchCondition = @$filter["v_tgl_upd"];
		$this->tgl_upd->AdvancedSearch->SearchValue2 = @$filter["y_tgl_upd"];
		$this->tgl_upd->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_upd"];
		$this->tgl_upd->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->topic, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->priority, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->action, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->cr_by, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->filter_penerima, $arKeywords, $type);
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
			$this->UpdateSort($this->topic); // topic
			$this->UpdateSort($this->priority); // priority
			$this->UpdateSort($this->isi_notif); // isi_notif
			$this->UpdateSort($this->action); // action
			$this->UpdateSort($this->tgl_cr); // tgl_cr
			$this->UpdateSort($this->tgl_upd); // tgl_upd
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
				$this->topic->setSort("");
				$this->priority->setSort("");
				$this->isi_notif->setSort("");
				$this->action->setSort("");
				$this->tgl_cr->setSort("");
				$this->tgl_upd->setSort("");
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
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "detail_tb_notifikasi_d"
		$item = &$this->ListOptions->Add("detail_tb_notifikasi_d");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["tb_notifikasi_d_grid"])) $GLOBALS["tb_notifikasi_d_grid"] = new ctb_notifikasi_d_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssClass = "text-nowrap";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = TRUE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("tb_notifikasi_d");
		$this->DetailPages = $pages;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
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
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_tb_notifikasi_d"
		$oListOpt = &$this->ListOptions->Items["detail_tb_notifikasi_d"];
		if (TRUE) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("tb_notifikasi_d", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("tb_notifikasi_dlist.php?" . EW_TABLE_SHOW_MASTER . "=tb_notifikasi&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["tb_notifikasi_d_grid"]->DetailView) {
				$caption = $Language->Phrase("MasterDetailViewLink");
				$url = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=tb_notifikasi_d");
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "tb_notifikasi_d";
			}
			if ($GLOBALS["tb_notifikasi_d_grid"]->DetailEdit) {
				$caption = $Language->Phrase("MasterDetailEditLink");
				$url = $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=tb_notifikasi_d");
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "tb_notifikasi_d";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
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
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_tb_notifikasi_d");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=tb_notifikasi_d");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["tb_notifikasi_d"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["tb_notifikasi_d"]->DetailAdd);
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "tb_notifikasi_d";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink);
			$caption = $Language->Phrase("AddMasterDetailLink");
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
			$item->Visible = ($DetailTableLink <> "");

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detailadd_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = TRUE;
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ftb_notifikasilistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ftb_notifikasilistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ftb_notifikasilist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ftb_notifikasilistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$links = "";
		$btngrps = "";
		$sSqlWrk = "`id`=" . ew_AdjustSql($this->id->CurrentValue, $this->DBID) . "";

		// Column "detail_tb_notifikasi_d"
		if ($this->DetailPages->Items["tb_notifikasi_d"]->Visible) {
			$link = "";
			$option = &$this->ListOptions->Items["detail_tb_notifikasi_d"];
			$url = "tb_notifikasi_dpreview.php?t=tb_notifikasi&f=" . ew_Encrypt($sSqlWrk);
			$btngrp = "<div data-table=\"tb_notifikasi_d\" data-url=\"" . $url . "\">";
			if (TRUE) {
				$label = $Language->TablePhrase("tb_notifikasi_d", "TblCaption");
				$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"tb_notifikasi_d\" data-url=\"" . $url . "\">" . $label . "</a></li>";
				$links .= $link;
				$detaillnk = ew_JsEncode3("tb_notifikasi_dlist.php?" . EW_TABLE_SHOW_MASTER . "=tb_notifikasi&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "");
				$btngrp .= "<a href=\"javascript:void(0);\" class=\"ewLinkSeparator\" title=\"" . $Language->TablePhrase("tb_notifikasi_d", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->Phrase("MasterDetailListLink") . "</a>";
			}
			if ($GLOBALS["tb_notifikasi_d_grid"]->DetailView) {
				$caption = $Language->Phrase("MasterDetailViewLink");
				$url = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=tb_notifikasi_d");
				$btngrp .= "<a href=\"javascript:void(0);\" class=\"ewLinkSeparator\" title=\"" . ew_HtmlTitle($caption) . "\" onclick=\"window.location='" . ew_HtmlEncode($url) . "'\">" . $caption . "</a>";
			}
			if ($GLOBALS["tb_notifikasi_d_grid"]->DetailEdit) {
				$caption = $Language->Phrase("MasterDetailEditLink");
				$url = $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=tb_notifikasi_d");
				$btngrp .= "<a href=\"javascript:void(0);\" class=\"ewLinkSeparator\" title=\"" . ew_HtmlTitle($caption) . "\" onclick=\"window.location='" . ew_HtmlEncode($url) . "'\">" . $caption . "</a>";
			}
			$btngrp .= "</div>";
			if ($link <> "") {
				$btngrps .= $btngrp;
				$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
			}
		}

		// Hide detail items if necessary
		$this->ListOptions->HideDetailItemsForDropDown();

		// Column "preview"
		$option = &$this->ListOptions->GetItem("preview");
		if (!$option) { // Add preview column
			$option = &$this->ListOptions->Add("preview");
			$option->OnLeft = TRUE;
			if ($option->OnLeft) {
				$option->MoveTo($this->ListOptions->ItemPos("checkbox") + 1);
			} else {
				$option->MoveTo($this->ListOptions->ItemPos("checkbox"));
			}
			$option->Visible = !($this->Export <> "" || $this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit");
			$option->ShowInDropDown = FALSE;
			$option->ShowInButtonGroup = FALSE;
		}
		if ($option) {
			$option->Body = "<span class=\"ewPreviewRowBtn ewIcon icon-expand\"></span>";
			$option->Body .= "<div class=\"hide ewPreview\">" . $links . $btngrps . "</div>";
			if ($option->Visible) $option->Visible = $links <> "";
		}

		// Column "details" (Multiple details)
		$option = &$this->ListOptions->GetItem("details");
		if ($option) {
			$option->Body .= "<div class=\"hide ewPreview\">" . $links . $btngrps . "</div>";
			if ($option->Visible) $option->Visible = $links <> "";
		}
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
		$row = array();
		$row['id'] = NULL;
		$row['topic'] = NULL;
		$row['priority'] = NULL;
		$row['isi_notif'] = NULL;
		$row['action'] = NULL;
		$row['tgl_cr'] = NULL;
		$row['cr_by'] = NULL;
		$row['filter_penerima'] = NULL;
		$row['tgl_upd'] = NULL;
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

		// tgl_upd
		$this->tgl_upd->ViewValue = $this->tgl_upd->CurrentValue;
		$this->tgl_upd->ViewValue = ew_FormatDateTime($this->tgl_upd->ViewValue, 0);
		$this->tgl_upd->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

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

			// tgl_cr
			$this->tgl_cr->LinkCustomAttributes = "";
			$this->tgl_cr->HrefValue = "";
			$this->tgl_cr->TooltipValue = "";

			// tgl_upd
			$this->tgl_upd->LinkCustomAttributes = "";
			$this->tgl_upd->HrefValue = "";
			$this->tgl_upd->TooltipValue = "";
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
if (!isset($tb_notifikasi_list)) $tb_notifikasi_list = new ctb_notifikasi_list();

// Page init
$tb_notifikasi_list->Page_Init();

// Page main
$tb_notifikasi_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_notifikasi_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ftb_notifikasilist = new ew_Form("ftb_notifikasilist", "list");
ftb_notifikasilist.FormKeyCountName = '<?php echo $tb_notifikasi_list->FormKeyCountName ?>';

// Form_CustomValidate event
ftb_notifikasilist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftb_notifikasilist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftb_notifikasilist.Lists["x_topic"] = {"LinkField":"x_nama_referensi","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_referensi","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_referensi"};
ftb_notifikasilist.Lists["x_topic"].Data = "<?php echo $tb_notifikasi_list->topic->LookupFilterQuery(FALSE, "list") ?>";
ftb_notifikasilist.Lists["x_priority"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftb_notifikasilist.Lists["x_priority"].Options = <?php echo json_encode($tb_notifikasi_list->priority->Options()) ?>;

// Form object for search
var CurrentSearchForm = ftb_notifikasilistsrch = new ew_Form("ftb_notifikasilistsrch");
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
var EW_PREVIEW_PLACEMENT = EW_CSS_FLIP ? "left" : "right";
var EW_PREVIEW_SINGLE_ROW = false;
var EW_PREVIEW_OVERLAY = false;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
/*
$('.ewAdd').hide();	
$('.ewDetailAdd').text('Add Notifikasi');
$('.ewAdd').after('<button class="btn btn-default ewButton" name="btnHome" id="btnHome" type="Button" href="<?php echo $_SESSION['home']; ?>">HOME</button>');
*/
</script>
<div class="ewToolbar">
<?php if ($tb_notifikasi_list->TotalRecs > 0 && $tb_notifikasi_list->ExportOptions->Visible()) { ?>
<?php $tb_notifikasi_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($tb_notifikasi_list->SearchOptions->Visible()) { ?>
<?php $tb_notifikasi_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($tb_notifikasi_list->FilterOptions->Visible()) { ?>
<?php $tb_notifikasi_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $tb_notifikasi_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($tb_notifikasi_list->TotalRecs <= 0)
			$tb_notifikasi_list->TotalRecs = $tb_notifikasi->ListRecordCount();
	} else {
		if (!$tb_notifikasi_list->Recordset && ($tb_notifikasi_list->Recordset = $tb_notifikasi_list->LoadRecordset()))
			$tb_notifikasi_list->TotalRecs = $tb_notifikasi_list->Recordset->RecordCount();
	}
	$tb_notifikasi_list->StartRec = 1;
	if ($tb_notifikasi_list->DisplayRecs <= 0 || ($tb_notifikasi->Export <> "" && $tb_notifikasi->ExportAll)) // Display all records
		$tb_notifikasi_list->DisplayRecs = $tb_notifikasi_list->TotalRecs;
	if (!($tb_notifikasi->Export <> "" && $tb_notifikasi->ExportAll))
		$tb_notifikasi_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$tb_notifikasi_list->Recordset = $tb_notifikasi_list->LoadRecordset($tb_notifikasi_list->StartRec-1, $tb_notifikasi_list->DisplayRecs);

	// Set no record found message
	if ($tb_notifikasi->CurrentAction == "" && $tb_notifikasi_list->TotalRecs == 0) {
		if ($tb_notifikasi_list->SearchWhere == "0=101")
			$tb_notifikasi_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$tb_notifikasi_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$tb_notifikasi_list->RenderOtherOptions();
?>
<?php if ($tb_notifikasi->Export == "" && $tb_notifikasi->CurrentAction == "") { ?>
<form name="ftb_notifikasilistsrch" id="ftb_notifikasilistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($tb_notifikasi_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ftb_notifikasilistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tb_notifikasi">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($tb_notifikasi_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($tb_notifikasi_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $tb_notifikasi_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($tb_notifikasi_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($tb_notifikasi_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($tb_notifikasi_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($tb_notifikasi_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $tb_notifikasi_list->ShowPageHeader(); ?>
<?php
$tb_notifikasi_list->ShowMessage();
?>
<?php if ($tb_notifikasi_list->TotalRecs > 0 || $tb_notifikasi->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($tb_notifikasi_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> tb_notifikasi">
<div class="box-header ewGridUpperPanel">
<?php if ($tb_notifikasi->CurrentAction <> "gridadd" && $tb_notifikasi->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($tb_notifikasi_list->Pager)) $tb_notifikasi_list->Pager = new cPrevNextPager($tb_notifikasi_list->StartRec, $tb_notifikasi_list->DisplayRecs, $tb_notifikasi_list->TotalRecs, $tb_notifikasi_list->AutoHidePager) ?>
<?php if ($tb_notifikasi_list->Pager->RecordCount > 0 && $tb_notifikasi_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($tb_notifikasi_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $tb_notifikasi_list->PageUrl() ?>start=<?php echo $tb_notifikasi_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($tb_notifikasi_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $tb_notifikasi_list->PageUrl() ?>start=<?php echo $tb_notifikasi_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tb_notifikasi_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($tb_notifikasi_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $tb_notifikasi_list->PageUrl() ?>start=<?php echo $tb_notifikasi_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($tb_notifikasi_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $tb_notifikasi_list->PageUrl() ?>start=<?php echo $tb_notifikasi_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tb_notifikasi_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($tb_notifikasi_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tb_notifikasi_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tb_notifikasi_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tb_notifikasi_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tb_notifikasi_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="ftb_notifikasilist" id="ftb_notifikasilist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_notifikasi_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_notifikasi_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_notifikasi">
<div id="gmp_tb_notifikasi" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($tb_notifikasi_list->TotalRecs > 0 || $tb_notifikasi->CurrentAction == "gridedit") { ?>
<table id="tbl_tb_notifikasilist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$tb_notifikasi_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$tb_notifikasi_list->RenderListOptions();

// Render list options (header, left)
$tb_notifikasi_list->ListOptions->Render("header", "left");
?>
<?php if ($tb_notifikasi->id->Visible) { // id ?>
	<?php if ($tb_notifikasi->SortUrl($tb_notifikasi->id) == "") { ?>
		<th data-name="id" class="<?php echo $tb_notifikasi->id->HeaderCellClass() ?>"><div id="elh_tb_notifikasi_id" class="tb_notifikasi_id"><div class="ewTableHeaderCaption"><?php echo $tb_notifikasi->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $tb_notifikasi->id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_notifikasi->SortUrl($tb_notifikasi->id) ?>',1);"><div id="elh_tb_notifikasi_id" class="tb_notifikasi_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_notifikasi->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_notifikasi->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_notifikasi->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_notifikasi->topic->Visible) { // topic ?>
	<?php if ($tb_notifikasi->SortUrl($tb_notifikasi->topic) == "") { ?>
		<th data-name="topic" class="<?php echo $tb_notifikasi->topic->HeaderCellClass() ?>"><div id="elh_tb_notifikasi_topic" class="tb_notifikasi_topic"><div class="ewTableHeaderCaption"><?php echo $tb_notifikasi->topic->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="topic" class="<?php echo $tb_notifikasi->topic->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_notifikasi->SortUrl($tb_notifikasi->topic) ?>',1);"><div id="elh_tb_notifikasi_topic" class="tb_notifikasi_topic">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_notifikasi->topic->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_notifikasi->topic->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_notifikasi->topic->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_notifikasi->priority->Visible) { // priority ?>
	<?php if ($tb_notifikasi->SortUrl($tb_notifikasi->priority) == "") { ?>
		<th data-name="priority" class="<?php echo $tb_notifikasi->priority->HeaderCellClass() ?>"><div id="elh_tb_notifikasi_priority" class="tb_notifikasi_priority"><div class="ewTableHeaderCaption"><?php echo $tb_notifikasi->priority->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="priority" class="<?php echo $tb_notifikasi->priority->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_notifikasi->SortUrl($tb_notifikasi->priority) ?>',1);"><div id="elh_tb_notifikasi_priority" class="tb_notifikasi_priority">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_notifikasi->priority->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_notifikasi->priority->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_notifikasi->priority->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_notifikasi->isi_notif->Visible) { // isi_notif ?>
	<?php if ($tb_notifikasi->SortUrl($tb_notifikasi->isi_notif) == "") { ?>
		<th data-name="isi_notif" class="<?php echo $tb_notifikasi->isi_notif->HeaderCellClass() ?>"><div id="elh_tb_notifikasi_isi_notif" class="tb_notifikasi_isi_notif"><div class="ewTableHeaderCaption"><?php echo $tb_notifikasi->isi_notif->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="isi_notif" class="<?php echo $tb_notifikasi->isi_notif->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_notifikasi->SortUrl($tb_notifikasi->isi_notif) ?>',1);"><div id="elh_tb_notifikasi_isi_notif" class="tb_notifikasi_isi_notif">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_notifikasi->isi_notif->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_notifikasi->isi_notif->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_notifikasi->isi_notif->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_notifikasi->action->Visible) { // action ?>
	<?php if ($tb_notifikasi->SortUrl($tb_notifikasi->action) == "") { ?>
		<th data-name="action" class="<?php echo $tb_notifikasi->action->HeaderCellClass() ?>"><div id="elh_tb_notifikasi_action" class="tb_notifikasi_action"><div class="ewTableHeaderCaption"><?php echo $tb_notifikasi->action->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="action" class="<?php echo $tb_notifikasi->action->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_notifikasi->SortUrl($tb_notifikasi->action) ?>',1);"><div id="elh_tb_notifikasi_action" class="tb_notifikasi_action">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_notifikasi->action->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tb_notifikasi->action->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_notifikasi->action->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_notifikasi->tgl_cr->Visible) { // tgl_cr ?>
	<?php if ($tb_notifikasi->SortUrl($tb_notifikasi->tgl_cr) == "") { ?>
		<th data-name="tgl_cr" class="<?php echo $tb_notifikasi->tgl_cr->HeaderCellClass() ?>"><div id="elh_tb_notifikasi_tgl_cr" class="tb_notifikasi_tgl_cr"><div class="ewTableHeaderCaption"><?php echo $tb_notifikasi->tgl_cr->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_cr" class="<?php echo $tb_notifikasi->tgl_cr->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_notifikasi->SortUrl($tb_notifikasi->tgl_cr) ?>',1);"><div id="elh_tb_notifikasi_tgl_cr" class="tb_notifikasi_tgl_cr">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_notifikasi->tgl_cr->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_notifikasi->tgl_cr->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_notifikasi->tgl_cr->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_notifikasi->tgl_upd->Visible) { // tgl_upd ?>
	<?php if ($tb_notifikasi->SortUrl($tb_notifikasi->tgl_upd) == "") { ?>
		<th data-name="tgl_upd" class="<?php echo $tb_notifikasi->tgl_upd->HeaderCellClass() ?>"><div id="elh_tb_notifikasi_tgl_upd" class="tb_notifikasi_tgl_upd"><div class="ewTableHeaderCaption"><?php echo $tb_notifikasi->tgl_upd->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_upd" class="<?php echo $tb_notifikasi->tgl_upd->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tb_notifikasi->SortUrl($tb_notifikasi->tgl_upd) ?>',1);"><div id="elh_tb_notifikasi_tgl_upd" class="tb_notifikasi_tgl_upd">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_notifikasi->tgl_upd->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_notifikasi->tgl_upd->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_notifikasi->tgl_upd->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$tb_notifikasi_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($tb_notifikasi->ExportAll && $tb_notifikasi->Export <> "") {
	$tb_notifikasi_list->StopRec = $tb_notifikasi_list->TotalRecs;
} else {

	// Set the last record to display
	if ($tb_notifikasi_list->TotalRecs > $tb_notifikasi_list->StartRec + $tb_notifikasi_list->DisplayRecs - 1)
		$tb_notifikasi_list->StopRec = $tb_notifikasi_list->StartRec + $tb_notifikasi_list->DisplayRecs - 1;
	else
		$tb_notifikasi_list->StopRec = $tb_notifikasi_list->TotalRecs;
}
$tb_notifikasi_list->RecCnt = $tb_notifikasi_list->StartRec - 1;
if ($tb_notifikasi_list->Recordset && !$tb_notifikasi_list->Recordset->EOF) {
	$tb_notifikasi_list->Recordset->MoveFirst();
	$bSelectLimit = $tb_notifikasi_list->UseSelectLimit;
	if (!$bSelectLimit && $tb_notifikasi_list->StartRec > 1)
		$tb_notifikasi_list->Recordset->Move($tb_notifikasi_list->StartRec - 1);
} elseif (!$tb_notifikasi->AllowAddDeleteRow && $tb_notifikasi_list->StopRec == 0) {
	$tb_notifikasi_list->StopRec = $tb_notifikasi->GridAddRowCount;
}

// Initialize aggregate
$tb_notifikasi->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tb_notifikasi->ResetAttrs();
$tb_notifikasi_list->RenderRow();
while ($tb_notifikasi_list->RecCnt < $tb_notifikasi_list->StopRec) {
	$tb_notifikasi_list->RecCnt++;
	if (intval($tb_notifikasi_list->RecCnt) >= intval($tb_notifikasi_list->StartRec)) {
		$tb_notifikasi_list->RowCnt++;

		// Set up key count
		$tb_notifikasi_list->KeyCount = $tb_notifikasi_list->RowIndex;

		// Init row class and style
		$tb_notifikasi->ResetAttrs();
		$tb_notifikasi->CssClass = "";
		if ($tb_notifikasi->CurrentAction == "gridadd") {
		} else {
			$tb_notifikasi_list->LoadRowValues($tb_notifikasi_list->Recordset); // Load row values
		}
		$tb_notifikasi->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$tb_notifikasi->RowAttrs = array_merge($tb_notifikasi->RowAttrs, array('data-rowindex'=>$tb_notifikasi_list->RowCnt, 'id'=>'r' . $tb_notifikasi_list->RowCnt . '_tb_notifikasi', 'data-rowtype'=>$tb_notifikasi->RowType));

		// Render row
		$tb_notifikasi_list->RenderRow();

		// Render list options
		$tb_notifikasi_list->RenderListOptions();
?>
	<tr<?php echo $tb_notifikasi->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tb_notifikasi_list->ListOptions->Render("body", "left", $tb_notifikasi_list->RowCnt);
?>
	<?php if ($tb_notifikasi->id->Visible) { // id ?>
		<td data-name="id"<?php echo $tb_notifikasi->id->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_list->RowCnt ?>_tb_notifikasi_id" class="tb_notifikasi_id">
<span<?php echo $tb_notifikasi->id->ViewAttributes() ?>>
<?php echo $tb_notifikasi->id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_notifikasi->topic->Visible) { // topic ?>
		<td data-name="topic"<?php echo $tb_notifikasi->topic->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_list->RowCnt ?>_tb_notifikasi_topic" class="tb_notifikasi_topic">
<span<?php echo $tb_notifikasi->topic->ViewAttributes() ?>>
<?php echo $tb_notifikasi->topic->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_notifikasi->priority->Visible) { // priority ?>
		<td data-name="priority"<?php echo $tb_notifikasi->priority->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_list->RowCnt ?>_tb_notifikasi_priority" class="tb_notifikasi_priority">
<span<?php echo $tb_notifikasi->priority->ViewAttributes() ?>>
<?php echo $tb_notifikasi->priority->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_notifikasi->isi_notif->Visible) { // isi_notif ?>
		<td data-name="isi_notif"<?php echo $tb_notifikasi->isi_notif->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_list->RowCnt ?>_tb_notifikasi_isi_notif" class="tb_notifikasi_isi_notif">
<span<?php echo $tb_notifikasi->isi_notif->ViewAttributes() ?>>
<?php echo $tb_notifikasi->isi_notif->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_notifikasi->action->Visible) { // action ?>
		<td data-name="action"<?php echo $tb_notifikasi->action->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_list->RowCnt ?>_tb_notifikasi_action" class="tb_notifikasi_action">
<span<?php echo $tb_notifikasi->action->ViewAttributes() ?>>
<?php echo $tb_notifikasi->action->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_notifikasi->tgl_cr->Visible) { // tgl_cr ?>
		<td data-name="tgl_cr"<?php echo $tb_notifikasi->tgl_cr->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_list->RowCnt ?>_tb_notifikasi_tgl_cr" class="tb_notifikasi_tgl_cr">
<span<?php echo $tb_notifikasi->tgl_cr->ViewAttributes() ?>>
<?php echo $tb_notifikasi->tgl_cr->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tb_notifikasi->tgl_upd->Visible) { // tgl_upd ?>
		<td data-name="tgl_upd"<?php echo $tb_notifikasi->tgl_upd->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_list->RowCnt ?>_tb_notifikasi_tgl_upd" class="tb_notifikasi_tgl_upd">
<span<?php echo $tb_notifikasi->tgl_upd->ViewAttributes() ?>>
<?php echo $tb_notifikasi->tgl_upd->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tb_notifikasi_list->ListOptions->Render("body", "right", $tb_notifikasi_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($tb_notifikasi->CurrentAction <> "gridadd")
		$tb_notifikasi_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($tb_notifikasi->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($tb_notifikasi_list->Recordset)
	$tb_notifikasi_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($tb_notifikasi->CurrentAction <> "gridadd" && $tb_notifikasi->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($tb_notifikasi_list->Pager)) $tb_notifikasi_list->Pager = new cPrevNextPager($tb_notifikasi_list->StartRec, $tb_notifikasi_list->DisplayRecs, $tb_notifikasi_list->TotalRecs, $tb_notifikasi_list->AutoHidePager) ?>
<?php if ($tb_notifikasi_list->Pager->RecordCount > 0 && $tb_notifikasi_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($tb_notifikasi_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $tb_notifikasi_list->PageUrl() ?>start=<?php echo $tb_notifikasi_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($tb_notifikasi_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $tb_notifikasi_list->PageUrl() ?>start=<?php echo $tb_notifikasi_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tb_notifikasi_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($tb_notifikasi_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $tb_notifikasi_list->PageUrl() ?>start=<?php echo $tb_notifikasi_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($tb_notifikasi_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $tb_notifikasi_list->PageUrl() ?>start=<?php echo $tb_notifikasi_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tb_notifikasi_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($tb_notifikasi_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tb_notifikasi_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tb_notifikasi_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tb_notifikasi_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tb_notifikasi_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($tb_notifikasi_list->TotalRecs == 0 && $tb_notifikasi->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tb_notifikasi_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ftb_notifikasilistsrch.FilterList = <?php echo $tb_notifikasi_list->GetFilterList() ?>;
ftb_notifikasilistsrch.Init();
ftb_notifikasilist.Init();
</script>
<?php
$tb_notifikasi_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");
//alert("<?php echo $_SESSION['u_id']; ?>");

$('.ewAdd').hide();	
$('.ewDetailAdd').text('Add Notifikasi');
$('.ewAdd').after('<a href="<?php echo $_SESSION['home']; ?>">   <button class="btn btn-default ewButton" name="btnHome" id="btnHome" type="Button" >Home</button></a>');
</script>
<?php include_once "footer.php" ?>
<?php
$tb_notifikasi_list->Page_Terminate();
?>
