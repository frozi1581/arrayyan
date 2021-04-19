<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "rwy_persediaan_saham_pegawaiinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$rwy_persediaan_saham_pegawai_list = NULL; // Initialize page object first

class crwy_persediaan_saham_pegawai_list extends crwy_persediaan_saham_pegawai {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'rwy_persediaan_saham_pegawai';

	// Page object name
	var $PageObjName = 'rwy_persediaan_saham_pegawai_list';

	// Grid form hidden field names
	var $FormName = 'frwy_persediaan_saham_pegawailist';
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

		// Table object (rwy_persediaan_saham_pegawai)
		if (!isset($GLOBALS["rwy_persediaan_saham_pegawai"]) || get_class($GLOBALS["rwy_persediaan_saham_pegawai"]) == "crwy_persediaan_saham_pegawai") {
			$GLOBALS["rwy_persediaan_saham_pegawai"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["rwy_persediaan_saham_pegawai"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "rwy_persediaan_saham_pegawaiadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "rwy_persediaan_saham_pegawaidelete.php";
		$this->MultiUpdateUrl = "rwy_persediaan_saham_pegawaiupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rwy_persediaan_saham_pegawai', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption frwy_persediaan_saham_pegawailistsrch";

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
		$this->kode_unit_organisasi->SetVisibility();
		$this->kode_unit_kerja->SetVisibility();
		$this->periode_bulan->SetVisibility();
		$this->periode_tahun->SetVisibility();
		$this->industri_kontruksi_abim_ups_anak->SetVisibility();
		$this->realty_ups_anak->SetVisibility();
		$this->pst_ups_anak->SetVisibility();
		$this->wton_anak_ups_anak->SetVisibility();
		$this->industri_kontruksi_abim_ups_dianak->SetVisibility();
		$this->realty_ups_dianak->SetVisibility();
		$this->esa_dianak->SetVisibility();
		$this->esop_dianak->SetVisibility();
		$this->change_by->SetVisibility();
		$this->change_date->SetVisibility();

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
		global $EW_EXPORT, $rwy_persediaan_saham_pegawai;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($rwy_persediaan_saham_pegawai);
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "frwy_persediaan_saham_pegawailistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJson(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->nip->AdvancedSearch->ToJson(), ","); // Field nip
		$sFilterList = ew_Concat($sFilterList, $this->kode_unit_organisasi->AdvancedSearch->ToJson(), ","); // Field kode_unit_organisasi
		$sFilterList = ew_Concat($sFilterList, $this->kode_unit_kerja->AdvancedSearch->ToJson(), ","); // Field kode_unit_kerja
		$sFilterList = ew_Concat($sFilterList, $this->periode_bulan->AdvancedSearch->ToJson(), ","); // Field periode_bulan
		$sFilterList = ew_Concat($sFilterList, $this->periode_tahun->AdvancedSearch->ToJson(), ","); // Field periode_tahun
		$sFilterList = ew_Concat($sFilterList, $this->industri_kontruksi_abim_ups_anak->AdvancedSearch->ToJson(), ","); // Field industri_kontruksi_abim_ups_anak
		$sFilterList = ew_Concat($sFilterList, $this->realty_ups_anak->AdvancedSearch->ToJson(), ","); // Field realty_ups_anak
		$sFilterList = ew_Concat($sFilterList, $this->pst_ups_anak->AdvancedSearch->ToJson(), ","); // Field pst_ups_anak
		$sFilterList = ew_Concat($sFilterList, $this->wton_anak_ups_anak->AdvancedSearch->ToJson(), ","); // Field wton_anak_ups_anak
		$sFilterList = ew_Concat($sFilterList, $this->industri_kontruksi_abim_ups_dianak->AdvancedSearch->ToJson(), ","); // Field industri_kontruksi_abim_ups_dianak
		$sFilterList = ew_Concat($sFilterList, $this->realty_ups_dianak->AdvancedSearch->ToJson(), ","); // Field realty_ups_dianak
		$sFilterList = ew_Concat($sFilterList, $this->esa_dianak->AdvancedSearch->ToJson(), ","); // Field esa_dianak
		$sFilterList = ew_Concat($sFilterList, $this->esop_dianak->AdvancedSearch->ToJson(), ","); // Field esop_dianak
		$sFilterList = ew_Concat($sFilterList, $this->change_by->AdvancedSearch->ToJson(), ","); // Field change_by
		$sFilterList = ew_Concat($sFilterList, $this->change_date->AdvancedSearch->ToJson(), ","); // Field change_date
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "frwy_persediaan_saham_pegawailistsrch", $filters);

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

		// Field kode_unit_organisasi
		$this->kode_unit_organisasi->AdvancedSearch->SearchValue = @$filter["x_kode_unit_organisasi"];
		$this->kode_unit_organisasi->AdvancedSearch->SearchOperator = @$filter["z_kode_unit_organisasi"];
		$this->kode_unit_organisasi->AdvancedSearch->SearchCondition = @$filter["v_kode_unit_organisasi"];
		$this->kode_unit_organisasi->AdvancedSearch->SearchValue2 = @$filter["y_kode_unit_organisasi"];
		$this->kode_unit_organisasi->AdvancedSearch->SearchOperator2 = @$filter["w_kode_unit_organisasi"];
		$this->kode_unit_organisasi->AdvancedSearch->Save();

		// Field kode_unit_kerja
		$this->kode_unit_kerja->AdvancedSearch->SearchValue = @$filter["x_kode_unit_kerja"];
		$this->kode_unit_kerja->AdvancedSearch->SearchOperator = @$filter["z_kode_unit_kerja"];
		$this->kode_unit_kerja->AdvancedSearch->SearchCondition = @$filter["v_kode_unit_kerja"];
		$this->kode_unit_kerja->AdvancedSearch->SearchValue2 = @$filter["y_kode_unit_kerja"];
		$this->kode_unit_kerja->AdvancedSearch->SearchOperator2 = @$filter["w_kode_unit_kerja"];
		$this->kode_unit_kerja->AdvancedSearch->Save();

		// Field periode_bulan
		$this->periode_bulan->AdvancedSearch->SearchValue = @$filter["x_periode_bulan"];
		$this->periode_bulan->AdvancedSearch->SearchOperator = @$filter["z_periode_bulan"];
		$this->periode_bulan->AdvancedSearch->SearchCondition = @$filter["v_periode_bulan"];
		$this->periode_bulan->AdvancedSearch->SearchValue2 = @$filter["y_periode_bulan"];
		$this->periode_bulan->AdvancedSearch->SearchOperator2 = @$filter["w_periode_bulan"];
		$this->periode_bulan->AdvancedSearch->Save();

		// Field periode_tahun
		$this->periode_tahun->AdvancedSearch->SearchValue = @$filter["x_periode_tahun"];
		$this->periode_tahun->AdvancedSearch->SearchOperator = @$filter["z_periode_tahun"];
		$this->periode_tahun->AdvancedSearch->SearchCondition = @$filter["v_periode_tahun"];
		$this->periode_tahun->AdvancedSearch->SearchValue2 = @$filter["y_periode_tahun"];
		$this->periode_tahun->AdvancedSearch->SearchOperator2 = @$filter["w_periode_tahun"];
		$this->periode_tahun->AdvancedSearch->Save();

		// Field industri_kontruksi_abim_ups_anak
		$this->industri_kontruksi_abim_ups_anak->AdvancedSearch->SearchValue = @$filter["x_industri_kontruksi_abim_ups_anak"];
		$this->industri_kontruksi_abim_ups_anak->AdvancedSearch->SearchOperator = @$filter["z_industri_kontruksi_abim_ups_anak"];
		$this->industri_kontruksi_abim_ups_anak->AdvancedSearch->SearchCondition = @$filter["v_industri_kontruksi_abim_ups_anak"];
		$this->industri_kontruksi_abim_ups_anak->AdvancedSearch->SearchValue2 = @$filter["y_industri_kontruksi_abim_ups_anak"];
		$this->industri_kontruksi_abim_ups_anak->AdvancedSearch->SearchOperator2 = @$filter["w_industri_kontruksi_abim_ups_anak"];
		$this->industri_kontruksi_abim_ups_anak->AdvancedSearch->Save();

		// Field realty_ups_anak
		$this->realty_ups_anak->AdvancedSearch->SearchValue = @$filter["x_realty_ups_anak"];
		$this->realty_ups_anak->AdvancedSearch->SearchOperator = @$filter["z_realty_ups_anak"];
		$this->realty_ups_anak->AdvancedSearch->SearchCondition = @$filter["v_realty_ups_anak"];
		$this->realty_ups_anak->AdvancedSearch->SearchValue2 = @$filter["y_realty_ups_anak"];
		$this->realty_ups_anak->AdvancedSearch->SearchOperator2 = @$filter["w_realty_ups_anak"];
		$this->realty_ups_anak->AdvancedSearch->Save();

		// Field pst_ups_anak
		$this->pst_ups_anak->AdvancedSearch->SearchValue = @$filter["x_pst_ups_anak"];
		$this->pst_ups_anak->AdvancedSearch->SearchOperator = @$filter["z_pst_ups_anak"];
		$this->pst_ups_anak->AdvancedSearch->SearchCondition = @$filter["v_pst_ups_anak"];
		$this->pst_ups_anak->AdvancedSearch->SearchValue2 = @$filter["y_pst_ups_anak"];
		$this->pst_ups_anak->AdvancedSearch->SearchOperator2 = @$filter["w_pst_ups_anak"];
		$this->pst_ups_anak->AdvancedSearch->Save();

		// Field wton_anak_ups_anak
		$this->wton_anak_ups_anak->AdvancedSearch->SearchValue = @$filter["x_wton_anak_ups_anak"];
		$this->wton_anak_ups_anak->AdvancedSearch->SearchOperator = @$filter["z_wton_anak_ups_anak"];
		$this->wton_anak_ups_anak->AdvancedSearch->SearchCondition = @$filter["v_wton_anak_ups_anak"];
		$this->wton_anak_ups_anak->AdvancedSearch->SearchValue2 = @$filter["y_wton_anak_ups_anak"];
		$this->wton_anak_ups_anak->AdvancedSearch->SearchOperator2 = @$filter["w_wton_anak_ups_anak"];
		$this->wton_anak_ups_anak->AdvancedSearch->Save();

		// Field industri_kontruksi_abim_ups_dianak
		$this->industri_kontruksi_abim_ups_dianak->AdvancedSearch->SearchValue = @$filter["x_industri_kontruksi_abim_ups_dianak"];
		$this->industri_kontruksi_abim_ups_dianak->AdvancedSearch->SearchOperator = @$filter["z_industri_kontruksi_abim_ups_dianak"];
		$this->industri_kontruksi_abim_ups_dianak->AdvancedSearch->SearchCondition = @$filter["v_industri_kontruksi_abim_ups_dianak"];
		$this->industri_kontruksi_abim_ups_dianak->AdvancedSearch->SearchValue2 = @$filter["y_industri_kontruksi_abim_ups_dianak"];
		$this->industri_kontruksi_abim_ups_dianak->AdvancedSearch->SearchOperator2 = @$filter["w_industri_kontruksi_abim_ups_dianak"];
		$this->industri_kontruksi_abim_ups_dianak->AdvancedSearch->Save();

		// Field realty_ups_dianak
		$this->realty_ups_dianak->AdvancedSearch->SearchValue = @$filter["x_realty_ups_dianak"];
		$this->realty_ups_dianak->AdvancedSearch->SearchOperator = @$filter["z_realty_ups_dianak"];
		$this->realty_ups_dianak->AdvancedSearch->SearchCondition = @$filter["v_realty_ups_dianak"];
		$this->realty_ups_dianak->AdvancedSearch->SearchValue2 = @$filter["y_realty_ups_dianak"];
		$this->realty_ups_dianak->AdvancedSearch->SearchOperator2 = @$filter["w_realty_ups_dianak"];
		$this->realty_ups_dianak->AdvancedSearch->Save();

		// Field esa_dianak
		$this->esa_dianak->AdvancedSearch->SearchValue = @$filter["x_esa_dianak"];
		$this->esa_dianak->AdvancedSearch->SearchOperator = @$filter["z_esa_dianak"];
		$this->esa_dianak->AdvancedSearch->SearchCondition = @$filter["v_esa_dianak"];
		$this->esa_dianak->AdvancedSearch->SearchValue2 = @$filter["y_esa_dianak"];
		$this->esa_dianak->AdvancedSearch->SearchOperator2 = @$filter["w_esa_dianak"];
		$this->esa_dianak->AdvancedSearch->Save();

		// Field esop_dianak
		$this->esop_dianak->AdvancedSearch->SearchValue = @$filter["x_esop_dianak"];
		$this->esop_dianak->AdvancedSearch->SearchOperator = @$filter["z_esop_dianak"];
		$this->esop_dianak->AdvancedSearch->SearchCondition = @$filter["v_esop_dianak"];
		$this->esop_dianak->AdvancedSearch->SearchValue2 = @$filter["y_esop_dianak"];
		$this->esop_dianak->AdvancedSearch->SearchOperator2 = @$filter["w_esop_dianak"];
		$this->esop_dianak->AdvancedSearch->Save();

		// Field change_by
		$this->change_by->AdvancedSearch->SearchValue = @$filter["x_change_by"];
		$this->change_by->AdvancedSearch->SearchOperator = @$filter["z_change_by"];
		$this->change_by->AdvancedSearch->SearchCondition = @$filter["v_change_by"];
		$this->change_by->AdvancedSearch->SearchValue2 = @$filter["y_change_by"];
		$this->change_by->AdvancedSearch->SearchOperator2 = @$filter["w_change_by"];
		$this->change_by->AdvancedSearch->Save();

		// Field change_date
		$this->change_date->AdvancedSearch->SearchValue = @$filter["x_change_date"];
		$this->change_date->AdvancedSearch->SearchOperator = @$filter["z_change_date"];
		$this->change_date->AdvancedSearch->SearchCondition = @$filter["v_change_date"];
		$this->change_date->AdvancedSearch->SearchValue2 = @$filter["y_change_date"];
		$this->change_date->AdvancedSearch->SearchOperator2 = @$filter["w_change_date"];
		$this->change_date->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->nip, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kode_unit_organisasi, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kode_unit_kerja, $arKeywords, $type);
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
			$this->UpdateSort($this->kode_unit_organisasi); // kode_unit_organisasi
			$this->UpdateSort($this->kode_unit_kerja); // kode_unit_kerja
			$this->UpdateSort($this->periode_bulan); // periode_bulan
			$this->UpdateSort($this->periode_tahun); // periode_tahun
			$this->UpdateSort($this->industri_kontruksi_abim_ups_anak); // industri_kontruksi_abim_ups_anak
			$this->UpdateSort($this->realty_ups_anak); // realty_ups_anak
			$this->UpdateSort($this->pst_ups_anak); // pst_ups_anak
			$this->UpdateSort($this->wton_anak_ups_anak); // wton_anak_ups_anak
			$this->UpdateSort($this->industri_kontruksi_abim_ups_dianak); // industri_kontruksi_abim_ups_dianak
			$this->UpdateSort($this->realty_ups_dianak); // realty_ups_dianak
			$this->UpdateSort($this->esa_dianak); // esa_dianak
			$this->UpdateSort($this->esop_dianak); // esop_dianak
			$this->UpdateSort($this->change_by); // change_by
			$this->UpdateSort($this->change_date); // change_date
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
				$this->kode_unit_organisasi->setSort("");
				$this->kode_unit_kerja->setSort("");
				$this->periode_bulan->setSort("");
				$this->periode_tahun->setSort("");
				$this->industri_kontruksi_abim_ups_anak->setSort("");
				$this->realty_ups_anak->setSort("");
				$this->pst_ups_anak->setSort("");
				$this->wton_anak_ups_anak->setSort("");
				$this->industri_kontruksi_abim_ups_dianak->setSort("");
				$this->realty_ups_dianak->setSort("");
				$this->esa_dianak->setSort("");
				$this->esop_dianak->setSort("");
				$this->change_by->setSort("");
				$this->change_date->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"frwy_persediaan_saham_pegawailistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"frwy_persediaan_saham_pegawailistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.frwy_persediaan_saham_pegawailist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"frwy_persediaan_saham_pegawailistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$this->kode_unit_organisasi->setDbValue($row['kode_unit_organisasi']);
		$this->kode_unit_kerja->setDbValue($row['kode_unit_kerja']);
		$this->periode_bulan->setDbValue($row['periode_bulan']);
		$this->periode_tahun->setDbValue($row['periode_tahun']);
		$this->industri_kontruksi_abim_ups_anak->setDbValue($row['industri_kontruksi_abim_ups_anak']);
		$this->realty_ups_anak->setDbValue($row['realty_ups_anak']);
		$this->pst_ups_anak->setDbValue($row['pst_ups_anak']);
		$this->wton_anak_ups_anak->setDbValue($row['wton_anak_ups_anak']);
		$this->industri_kontruksi_abim_ups_dianak->setDbValue($row['industri_kontruksi_abim_ups_dianak']);
		$this->realty_ups_dianak->setDbValue($row['realty_ups_dianak']);
		$this->esa_dianak->setDbValue($row['esa_dianak']);
		$this->esop_dianak->setDbValue($row['esop_dianak']);
		$this->change_by->setDbValue($row['change_by']);
		$this->change_date->setDbValue($row['change_date']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['nip'] = NULL;
		$row['kode_unit_organisasi'] = NULL;
		$row['kode_unit_kerja'] = NULL;
		$row['periode_bulan'] = NULL;
		$row['periode_tahun'] = NULL;
		$row['industri_kontruksi_abim_ups_anak'] = NULL;
		$row['realty_ups_anak'] = NULL;
		$row['pst_ups_anak'] = NULL;
		$row['wton_anak_ups_anak'] = NULL;
		$row['industri_kontruksi_abim_ups_dianak'] = NULL;
		$row['realty_ups_dianak'] = NULL;
		$row['esa_dianak'] = NULL;
		$row['esop_dianak'] = NULL;
		$row['change_by'] = NULL;
		$row['change_date'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->nip->DbValue = $row['nip'];
		$this->kode_unit_organisasi->DbValue = $row['kode_unit_organisasi'];
		$this->kode_unit_kerja->DbValue = $row['kode_unit_kerja'];
		$this->periode_bulan->DbValue = $row['periode_bulan'];
		$this->periode_tahun->DbValue = $row['periode_tahun'];
		$this->industri_kontruksi_abim_ups_anak->DbValue = $row['industri_kontruksi_abim_ups_anak'];
		$this->realty_ups_anak->DbValue = $row['realty_ups_anak'];
		$this->pst_ups_anak->DbValue = $row['pst_ups_anak'];
		$this->wton_anak_ups_anak->DbValue = $row['wton_anak_ups_anak'];
		$this->industri_kontruksi_abim_ups_dianak->DbValue = $row['industri_kontruksi_abim_ups_dianak'];
		$this->realty_ups_dianak->DbValue = $row['realty_ups_dianak'];
		$this->esa_dianak->DbValue = $row['esa_dianak'];
		$this->esop_dianak->DbValue = $row['esop_dianak'];
		$this->change_by->DbValue = $row['change_by'];
		$this->change_date->DbValue = $row['change_date'];
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
		// kode_unit_organisasi
		// kode_unit_kerja
		// periode_bulan
		// periode_tahun
		// industri_kontruksi_abim_ups_anak
		// realty_ups_anak
		// pst_ups_anak
		// wton_anak_ups_anak
		// industri_kontruksi_abim_ups_dianak
		// realty_ups_dianak
		// esa_dianak
		// esop_dianak
		// change_by
		// change_date

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nip
		$this->nip->ViewValue = $this->nip->CurrentValue;
		$this->nip->ViewCustomAttributes = "";

		// kode_unit_organisasi
		$this->kode_unit_organisasi->ViewValue = $this->kode_unit_organisasi->CurrentValue;
		$this->kode_unit_organisasi->ViewCustomAttributes = "";

		// kode_unit_kerja
		$this->kode_unit_kerja->ViewValue = $this->kode_unit_kerja->CurrentValue;
		$this->kode_unit_kerja->ViewCustomAttributes = "";

		// periode_bulan
		$this->periode_bulan->ViewValue = $this->periode_bulan->CurrentValue;
		$this->periode_bulan->ViewCustomAttributes = "";

		// periode_tahun
		$this->periode_tahun->ViewValue = $this->periode_tahun->CurrentValue;
		$this->periode_tahun->ViewCustomAttributes = "";

		// industri_kontruksi_abim_ups_anak
		$this->industri_kontruksi_abim_ups_anak->ViewValue = $this->industri_kontruksi_abim_ups_anak->CurrentValue;
		$this->industri_kontruksi_abim_ups_anak->ViewCustomAttributes = "";

		// realty_ups_anak
		$this->realty_ups_anak->ViewValue = $this->realty_ups_anak->CurrentValue;
		$this->realty_ups_anak->ViewCustomAttributes = "";

		// pst_ups_anak
		$this->pst_ups_anak->ViewValue = $this->pst_ups_anak->CurrentValue;
		$this->pst_ups_anak->ViewCustomAttributes = "";

		// wton_anak_ups_anak
		$this->wton_anak_ups_anak->ViewValue = $this->wton_anak_ups_anak->CurrentValue;
		$this->wton_anak_ups_anak->ViewCustomAttributes = "";

		// industri_kontruksi_abim_ups_dianak
		$this->industri_kontruksi_abim_ups_dianak->ViewValue = $this->industri_kontruksi_abim_ups_dianak->CurrentValue;
		$this->industri_kontruksi_abim_ups_dianak->ViewCustomAttributes = "";

		// realty_ups_dianak
		$this->realty_ups_dianak->ViewValue = $this->realty_ups_dianak->CurrentValue;
		$this->realty_ups_dianak->ViewCustomAttributes = "";

		// esa_dianak
		$this->esa_dianak->ViewValue = $this->esa_dianak->CurrentValue;
		$this->esa_dianak->ViewCustomAttributes = "";

		// esop_dianak
		$this->esop_dianak->ViewValue = $this->esop_dianak->CurrentValue;
		$this->esop_dianak->ViewCustomAttributes = "";

		// change_by
		$this->change_by->ViewValue = $this->change_by->CurrentValue;
		$this->change_by->ViewCustomAttributes = "";

		// change_date
		$this->change_date->ViewValue = $this->change_date->CurrentValue;
		$this->change_date->ViewValue = ew_FormatDateTime($this->change_date->ViewValue, 0);
		$this->change_date->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// nip
			$this->nip->LinkCustomAttributes = "";
			$this->nip->HrefValue = "";
			$this->nip->TooltipValue = "";

			// kode_unit_organisasi
			$this->kode_unit_organisasi->LinkCustomAttributes = "";
			$this->kode_unit_organisasi->HrefValue = "";
			$this->kode_unit_organisasi->TooltipValue = "";

			// kode_unit_kerja
			$this->kode_unit_kerja->LinkCustomAttributes = "";
			$this->kode_unit_kerja->HrefValue = "";
			$this->kode_unit_kerja->TooltipValue = "";

			// periode_bulan
			$this->periode_bulan->LinkCustomAttributes = "";
			$this->periode_bulan->HrefValue = "";
			$this->periode_bulan->TooltipValue = "";

			// periode_tahun
			$this->periode_tahun->LinkCustomAttributes = "";
			$this->periode_tahun->HrefValue = "";
			$this->periode_tahun->TooltipValue = "";

			// industri_kontruksi_abim_ups_anak
			$this->industri_kontruksi_abim_ups_anak->LinkCustomAttributes = "";
			$this->industri_kontruksi_abim_ups_anak->HrefValue = "";
			$this->industri_kontruksi_abim_ups_anak->TooltipValue = "";

			// realty_ups_anak
			$this->realty_ups_anak->LinkCustomAttributes = "";
			$this->realty_ups_anak->HrefValue = "";
			$this->realty_ups_anak->TooltipValue = "";

			// pst_ups_anak
			$this->pst_ups_anak->LinkCustomAttributes = "";
			$this->pst_ups_anak->HrefValue = "";
			$this->pst_ups_anak->TooltipValue = "";

			// wton_anak_ups_anak
			$this->wton_anak_ups_anak->LinkCustomAttributes = "";
			$this->wton_anak_ups_anak->HrefValue = "";
			$this->wton_anak_ups_anak->TooltipValue = "";

			// industri_kontruksi_abim_ups_dianak
			$this->industri_kontruksi_abim_ups_dianak->LinkCustomAttributes = "";
			$this->industri_kontruksi_abim_ups_dianak->HrefValue = "";
			$this->industri_kontruksi_abim_ups_dianak->TooltipValue = "";

			// realty_ups_dianak
			$this->realty_ups_dianak->LinkCustomAttributes = "";
			$this->realty_ups_dianak->HrefValue = "";
			$this->realty_ups_dianak->TooltipValue = "";

			// esa_dianak
			$this->esa_dianak->LinkCustomAttributes = "";
			$this->esa_dianak->HrefValue = "";
			$this->esa_dianak->TooltipValue = "";

			// esop_dianak
			$this->esop_dianak->LinkCustomAttributes = "";
			$this->esop_dianak->HrefValue = "";
			$this->esop_dianak->TooltipValue = "";

			// change_by
			$this->change_by->LinkCustomAttributes = "";
			$this->change_by->HrefValue = "";
			$this->change_by->TooltipValue = "";

			// change_date
			$this->change_date->LinkCustomAttributes = "";
			$this->change_date->HrefValue = "";
			$this->change_date->TooltipValue = "";
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
if (!isset($rwy_persediaan_saham_pegawai_list)) $rwy_persediaan_saham_pegawai_list = new crwy_persediaan_saham_pegawai_list();

// Page init
$rwy_persediaan_saham_pegawai_list->Page_Init();

// Page main
$rwy_persediaan_saham_pegawai_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$rwy_persediaan_saham_pegawai_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = frwy_persediaan_saham_pegawailist = new ew_Form("frwy_persediaan_saham_pegawailist", "list");
frwy_persediaan_saham_pegawailist.FormKeyCountName = '<?php echo $rwy_persediaan_saham_pegawai_list->FormKeyCountName ?>';

// Form_CustomValidate event
frwy_persediaan_saham_pegawailist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
frwy_persediaan_saham_pegawailist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = frwy_persediaan_saham_pegawailistsrch = new ew_Form("frwy_persediaan_saham_pegawailistsrch");
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
<?php if ($rwy_persediaan_saham_pegawai_list->TotalRecs > 0 && $rwy_persediaan_saham_pegawai_list->ExportOptions->Visible()) { ?>
<?php $rwy_persediaan_saham_pegawai_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai_list->SearchOptions->Visible()) { ?>
<?php $rwy_persediaan_saham_pegawai_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai_list->FilterOptions->Visible()) { ?>
<?php $rwy_persediaan_saham_pegawai_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $rwy_persediaan_saham_pegawai_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($rwy_persediaan_saham_pegawai_list->TotalRecs <= 0)
			$rwy_persediaan_saham_pegawai_list->TotalRecs = $rwy_persediaan_saham_pegawai->ListRecordCount();
	} else {
		if (!$rwy_persediaan_saham_pegawai_list->Recordset && ($rwy_persediaan_saham_pegawai_list->Recordset = $rwy_persediaan_saham_pegawai_list->LoadRecordset()))
			$rwy_persediaan_saham_pegawai_list->TotalRecs = $rwy_persediaan_saham_pegawai_list->Recordset->RecordCount();
	}
	$rwy_persediaan_saham_pegawai_list->StartRec = 1;
	if ($rwy_persediaan_saham_pegawai_list->DisplayRecs <= 0 || ($rwy_persediaan_saham_pegawai->Export <> "" && $rwy_persediaan_saham_pegawai->ExportAll)) // Display all records
		$rwy_persediaan_saham_pegawai_list->DisplayRecs = $rwy_persediaan_saham_pegawai_list->TotalRecs;
	if (!($rwy_persediaan_saham_pegawai->Export <> "" && $rwy_persediaan_saham_pegawai->ExportAll))
		$rwy_persediaan_saham_pegawai_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rwy_persediaan_saham_pegawai_list->Recordset = $rwy_persediaan_saham_pegawai_list->LoadRecordset($rwy_persediaan_saham_pegawai_list->StartRec-1, $rwy_persediaan_saham_pegawai_list->DisplayRecs);

	// Set no record found message
	if ($rwy_persediaan_saham_pegawai->CurrentAction == "" && $rwy_persediaan_saham_pegawai_list->TotalRecs == 0) {
		if ($rwy_persediaan_saham_pegawai_list->SearchWhere == "0=101")
			$rwy_persediaan_saham_pegawai_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$rwy_persediaan_saham_pegawai_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$rwy_persediaan_saham_pegawai_list->RenderOtherOptions();
?>
<?php if ($rwy_persediaan_saham_pegawai->Export == "" && $rwy_persediaan_saham_pegawai->CurrentAction == "") { ?>
<form name="frwy_persediaan_saham_pegawailistsrch" id="frwy_persediaan_saham_pegawailistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($rwy_persediaan_saham_pegawai_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="frwy_persediaan_saham_pegawailistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="rwy_persediaan_saham_pegawai">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($rwy_persediaan_saham_pegawai_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $rwy_persediaan_saham_pegawai_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($rwy_persediaan_saham_pegawai_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($rwy_persediaan_saham_pegawai_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($rwy_persediaan_saham_pegawai_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($rwy_persediaan_saham_pegawai_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $rwy_persediaan_saham_pegawai_list->ShowPageHeader(); ?>
<?php
$rwy_persediaan_saham_pegawai_list->ShowMessage();
?>
<?php if ($rwy_persediaan_saham_pegawai_list->TotalRecs > 0 || $rwy_persediaan_saham_pegawai->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($rwy_persediaan_saham_pegawai_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> rwy_persediaan_saham_pegawai">
<form name="frwy_persediaan_saham_pegawailist" id="frwy_persediaan_saham_pegawailist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($rwy_persediaan_saham_pegawai_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $rwy_persediaan_saham_pegawai_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="rwy_persediaan_saham_pegawai">
<div id="gmp_rwy_persediaan_saham_pegawai" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($rwy_persediaan_saham_pegawai_list->TotalRecs > 0 || $rwy_persediaan_saham_pegawai->CurrentAction == "gridedit") { ?>
<table id="tbl_rwy_persediaan_saham_pegawailist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$rwy_persediaan_saham_pegawai_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$rwy_persediaan_saham_pegawai_list->RenderListOptions();

// Render list options (header, left)
$rwy_persediaan_saham_pegawai_list->ListOptions->Render("header", "left");
?>
<?php if ($rwy_persediaan_saham_pegawai->id->Visible) { // id ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->id) == "") { ?>
		<th data-name="id" class="<?php echo $rwy_persediaan_saham_pegawai->id->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_id" class="rwy_persediaan_saham_pegawai_id"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $rwy_persediaan_saham_pegawai->id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->id) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_id" class="rwy_persediaan_saham_pegawai_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->nip->Visible) { // nip ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->nip) == "") { ?>
		<th data-name="nip" class="<?php echo $rwy_persediaan_saham_pegawai->nip->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_nip" class="rwy_persediaan_saham_pegawai_nip"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->nip->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nip" class="<?php echo $rwy_persediaan_saham_pegawai->nip->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->nip) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_nip" class="rwy_persediaan_saham_pegawai_nip">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->nip->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->nip->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->nip->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->kode_unit_organisasi->Visible) { // kode_unit_organisasi ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->kode_unit_organisasi) == "") { ?>
		<th data-name="kode_unit_organisasi" class="<?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_kode_unit_organisasi" class="rwy_persediaan_saham_pegawai_kode_unit_organisasi"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_unit_organisasi" class="<?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->kode_unit_organisasi) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_kode_unit_organisasi" class="rwy_persediaan_saham_pegawai_kode_unit_organisasi">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->kode_unit_organisasi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->kode_unit_organisasi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->kode_unit_kerja->Visible) { // kode_unit_kerja ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->kode_unit_kerja) == "") { ?>
		<th data-name="kode_unit_kerja" class="<?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_kode_unit_kerja" class="rwy_persediaan_saham_pegawai_kode_unit_kerja"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_unit_kerja" class="<?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->kode_unit_kerja) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_kode_unit_kerja" class="rwy_persediaan_saham_pegawai_kode_unit_kerja">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->kode_unit_kerja->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->kode_unit_kerja->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->periode_bulan->Visible) { // periode_bulan ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->periode_bulan) == "") { ?>
		<th data-name="periode_bulan" class="<?php echo $rwy_persediaan_saham_pegawai->periode_bulan->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_periode_bulan" class="rwy_persediaan_saham_pegawai_periode_bulan"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->periode_bulan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="periode_bulan" class="<?php echo $rwy_persediaan_saham_pegawai->periode_bulan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->periode_bulan) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_periode_bulan" class="rwy_persediaan_saham_pegawai_periode_bulan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->periode_bulan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->periode_bulan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->periode_bulan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->periode_tahun->Visible) { // periode_tahun ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->periode_tahun) == "") { ?>
		<th data-name="periode_tahun" class="<?php echo $rwy_persediaan_saham_pegawai->periode_tahun->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_periode_tahun" class="rwy_persediaan_saham_pegawai_periode_tahun"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->periode_tahun->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="periode_tahun" class="<?php echo $rwy_persediaan_saham_pegawai->periode_tahun->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->periode_tahun) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_periode_tahun" class="rwy_persediaan_saham_pegawai_periode_tahun">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->periode_tahun->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->periode_tahun->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->periode_tahun->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->Visible) { // industri_kontruksi_abim_ups_anak ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak) == "") { ?>
		<th data-name="industri_kontruksi_abim_ups_anak" class="<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_anak" class="rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_anak"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="industri_kontruksi_abim_ups_anak" class="<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_anak" class="rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_anak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->realty_ups_anak->Visible) { // realty_ups_anak ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->realty_ups_anak) == "") { ?>
		<th data-name="realty_ups_anak" class="<?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_realty_ups_anak" class="rwy_persediaan_saham_pegawai_realty_ups_anak"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="realty_ups_anak" class="<?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->realty_ups_anak) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_realty_ups_anak" class="rwy_persediaan_saham_pegawai_realty_ups_anak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->realty_ups_anak->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->realty_ups_anak->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->pst_ups_anak->Visible) { // pst_ups_anak ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->pst_ups_anak) == "") { ?>
		<th data-name="pst_ups_anak" class="<?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_pst_ups_anak" class="rwy_persediaan_saham_pegawai_pst_ups_anak"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pst_ups_anak" class="<?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->pst_ups_anak) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_pst_ups_anak" class="rwy_persediaan_saham_pegawai_pst_ups_anak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->pst_ups_anak->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->pst_ups_anak->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->wton_anak_ups_anak->Visible) { // wton_anak_ups_anak ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->wton_anak_ups_anak) == "") { ?>
		<th data-name="wton_anak_ups_anak" class="<?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_wton_anak_ups_anak" class="rwy_persediaan_saham_pegawai_wton_anak_ups_anak"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="wton_anak_ups_anak" class="<?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->wton_anak_ups_anak) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_wton_anak_ups_anak" class="rwy_persediaan_saham_pegawai_wton_anak_ups_anak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->wton_anak_ups_anak->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->wton_anak_ups_anak->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->Visible) { // industri_kontruksi_abim_ups_dianak ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak) == "") { ?>
		<th data-name="industri_kontruksi_abim_ups_dianak" class="<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_dianak" class="rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_dianak"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="industri_kontruksi_abim_ups_dianak" class="<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_dianak" class="rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_dianak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->realty_ups_dianak->Visible) { // realty_ups_dianak ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->realty_ups_dianak) == "") { ?>
		<th data-name="realty_ups_dianak" class="<?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_realty_ups_dianak" class="rwy_persediaan_saham_pegawai_realty_ups_dianak"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="realty_ups_dianak" class="<?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->realty_ups_dianak) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_realty_ups_dianak" class="rwy_persediaan_saham_pegawai_realty_ups_dianak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->realty_ups_dianak->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->realty_ups_dianak->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->esa_dianak->Visible) { // esa_dianak ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->esa_dianak) == "") { ?>
		<th data-name="esa_dianak" class="<?php echo $rwy_persediaan_saham_pegawai->esa_dianak->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_esa_dianak" class="rwy_persediaan_saham_pegawai_esa_dianak"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->esa_dianak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="esa_dianak" class="<?php echo $rwy_persediaan_saham_pegawai->esa_dianak->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->esa_dianak) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_esa_dianak" class="rwy_persediaan_saham_pegawai_esa_dianak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->esa_dianak->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->esa_dianak->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->esa_dianak->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->esop_dianak->Visible) { // esop_dianak ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->esop_dianak) == "") { ?>
		<th data-name="esop_dianak" class="<?php echo $rwy_persediaan_saham_pegawai->esop_dianak->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_esop_dianak" class="rwy_persediaan_saham_pegawai_esop_dianak"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->esop_dianak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="esop_dianak" class="<?php echo $rwy_persediaan_saham_pegawai->esop_dianak->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->esop_dianak) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_esop_dianak" class="rwy_persediaan_saham_pegawai_esop_dianak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->esop_dianak->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->esop_dianak->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->esop_dianak->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->change_by->Visible) { // change_by ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->change_by) == "") { ?>
		<th data-name="change_by" class="<?php echo $rwy_persediaan_saham_pegawai->change_by->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_change_by" class="rwy_persediaan_saham_pegawai_change_by"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->change_by->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="change_by" class="<?php echo $rwy_persediaan_saham_pegawai->change_by->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->change_by) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_change_by" class="rwy_persediaan_saham_pegawai_change_by">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->change_by->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->change_by->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->change_by->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->change_date->Visible) { // change_date ?>
	<?php if ($rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->change_date) == "") { ?>
		<th data-name="change_date" class="<?php echo $rwy_persediaan_saham_pegawai->change_date->HeaderCellClass() ?>"><div id="elh_rwy_persediaan_saham_pegawai_change_date" class="rwy_persediaan_saham_pegawai_change_date"><div class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->change_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="change_date" class="<?php echo $rwy_persediaan_saham_pegawai->change_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $rwy_persediaan_saham_pegawai->SortUrl($rwy_persediaan_saham_pegawai->change_date) ?>',1);"><div id="elh_rwy_persediaan_saham_pegawai_change_date" class="rwy_persediaan_saham_pegawai_change_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $rwy_persediaan_saham_pegawai->change_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($rwy_persediaan_saham_pegawai->change_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($rwy_persediaan_saham_pegawai->change_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$rwy_persediaan_saham_pegawai_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($rwy_persediaan_saham_pegawai->ExportAll && $rwy_persediaan_saham_pegawai->Export <> "") {
	$rwy_persediaan_saham_pegawai_list->StopRec = $rwy_persediaan_saham_pegawai_list->TotalRecs;
} else {

	// Set the last record to display
	if ($rwy_persediaan_saham_pegawai_list->TotalRecs > $rwy_persediaan_saham_pegawai_list->StartRec + $rwy_persediaan_saham_pegawai_list->DisplayRecs - 1)
		$rwy_persediaan_saham_pegawai_list->StopRec = $rwy_persediaan_saham_pegawai_list->StartRec + $rwy_persediaan_saham_pegawai_list->DisplayRecs - 1;
	else
		$rwy_persediaan_saham_pegawai_list->StopRec = $rwy_persediaan_saham_pegawai_list->TotalRecs;
}
$rwy_persediaan_saham_pegawai_list->RecCnt = $rwy_persediaan_saham_pegawai_list->StartRec - 1;
if ($rwy_persediaan_saham_pegawai_list->Recordset && !$rwy_persediaan_saham_pegawai_list->Recordset->EOF) {
	$rwy_persediaan_saham_pegawai_list->Recordset->MoveFirst();
	$bSelectLimit = $rwy_persediaan_saham_pegawai_list->UseSelectLimit;
	if (!$bSelectLimit && $rwy_persediaan_saham_pegawai_list->StartRec > 1)
		$rwy_persediaan_saham_pegawai_list->Recordset->Move($rwy_persediaan_saham_pegawai_list->StartRec - 1);
} elseif (!$rwy_persediaan_saham_pegawai->AllowAddDeleteRow && $rwy_persediaan_saham_pegawai_list->StopRec == 0) {
	$rwy_persediaan_saham_pegawai_list->StopRec = $rwy_persediaan_saham_pegawai->GridAddRowCount;
}

// Initialize aggregate
$rwy_persediaan_saham_pegawai->RowType = EW_ROWTYPE_AGGREGATEINIT;
$rwy_persediaan_saham_pegawai->ResetAttrs();
$rwy_persediaan_saham_pegawai_list->RenderRow();
while ($rwy_persediaan_saham_pegawai_list->RecCnt < $rwy_persediaan_saham_pegawai_list->StopRec) {
	$rwy_persediaan_saham_pegawai_list->RecCnt++;
	if (intval($rwy_persediaan_saham_pegawai_list->RecCnt) >= intval($rwy_persediaan_saham_pegawai_list->StartRec)) {
		$rwy_persediaan_saham_pegawai_list->RowCnt++;

		// Set up key count
		$rwy_persediaan_saham_pegawai_list->KeyCount = $rwy_persediaan_saham_pegawai_list->RowIndex;

		// Init row class and style
		$rwy_persediaan_saham_pegawai->ResetAttrs();
		$rwy_persediaan_saham_pegawai->CssClass = "";
		if ($rwy_persediaan_saham_pegawai->CurrentAction == "gridadd") {
		} else {
			$rwy_persediaan_saham_pegawai_list->LoadRowValues($rwy_persediaan_saham_pegawai_list->Recordset); // Load row values
		}
		$rwy_persediaan_saham_pegawai->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$rwy_persediaan_saham_pegawai->RowAttrs = array_merge($rwy_persediaan_saham_pegawai->RowAttrs, array('data-rowindex'=>$rwy_persediaan_saham_pegawai_list->RowCnt, 'id'=>'r' . $rwy_persediaan_saham_pegawai_list->RowCnt . '_rwy_persediaan_saham_pegawai', 'data-rowtype'=>$rwy_persediaan_saham_pegawai->RowType));

		// Render row
		$rwy_persediaan_saham_pegawai_list->RenderRow();

		// Render list options
		$rwy_persediaan_saham_pegawai_list->RenderListOptions();
?>
	<tr<?php echo $rwy_persediaan_saham_pegawai->RowAttributes() ?>>
<?php

// Render list options (body, left)
$rwy_persediaan_saham_pegawai_list->ListOptions->Render("body", "left", $rwy_persediaan_saham_pegawai_list->RowCnt);
?>
	<?php if ($rwy_persediaan_saham_pegawai->id->Visible) { // id ?>
		<td data-name="id"<?php echo $rwy_persediaan_saham_pegawai->id->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_id" class="rwy_persediaan_saham_pegawai_id">
<span<?php echo $rwy_persediaan_saham_pegawai->id->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->nip->Visible) { // nip ?>
		<td data-name="nip"<?php echo $rwy_persediaan_saham_pegawai->nip->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_nip" class="rwy_persediaan_saham_pegawai_nip">
<span<?php echo $rwy_persediaan_saham_pegawai->nip->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->nip->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->kode_unit_organisasi->Visible) { // kode_unit_organisasi ?>
		<td data-name="kode_unit_organisasi"<?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_kode_unit_organisasi" class="rwy_persediaan_saham_pegawai_kode_unit_organisasi">
<span<?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->kode_unit_kerja->Visible) { // kode_unit_kerja ?>
		<td data-name="kode_unit_kerja"<?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_kode_unit_kerja" class="rwy_persediaan_saham_pegawai_kode_unit_kerja">
<span<?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->periode_bulan->Visible) { // periode_bulan ?>
		<td data-name="periode_bulan"<?php echo $rwy_persediaan_saham_pegawai->periode_bulan->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_periode_bulan" class="rwy_persediaan_saham_pegawai_periode_bulan">
<span<?php echo $rwy_persediaan_saham_pegawai->periode_bulan->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->periode_bulan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->periode_tahun->Visible) { // periode_tahun ?>
		<td data-name="periode_tahun"<?php echo $rwy_persediaan_saham_pegawai->periode_tahun->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_periode_tahun" class="rwy_persediaan_saham_pegawai_periode_tahun">
<span<?php echo $rwy_persediaan_saham_pegawai->periode_tahun->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->periode_tahun->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->Visible) { // industri_kontruksi_abim_ups_anak ?>
		<td data-name="industri_kontruksi_abim_ups_anak"<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_anak" class="rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_anak">
<span<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->realty_ups_anak->Visible) { // realty_ups_anak ?>
		<td data-name="realty_ups_anak"<?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_realty_ups_anak" class="rwy_persediaan_saham_pegawai_realty_ups_anak">
<span<?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->pst_ups_anak->Visible) { // pst_ups_anak ?>
		<td data-name="pst_ups_anak"<?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_pst_ups_anak" class="rwy_persediaan_saham_pegawai_pst_ups_anak">
<span<?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->wton_anak_ups_anak->Visible) { // wton_anak_ups_anak ?>
		<td data-name="wton_anak_ups_anak"<?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_wton_anak_ups_anak" class="rwy_persediaan_saham_pegawai_wton_anak_ups_anak">
<span<?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->Visible) { // industri_kontruksi_abim_ups_dianak ?>
		<td data-name="industri_kontruksi_abim_ups_dianak"<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_dianak" class="rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_dianak">
<span<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->realty_ups_dianak->Visible) { // realty_ups_dianak ?>
		<td data-name="realty_ups_dianak"<?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_realty_ups_dianak" class="rwy_persediaan_saham_pegawai_realty_ups_dianak">
<span<?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->esa_dianak->Visible) { // esa_dianak ?>
		<td data-name="esa_dianak"<?php echo $rwy_persediaan_saham_pegawai->esa_dianak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_esa_dianak" class="rwy_persediaan_saham_pegawai_esa_dianak">
<span<?php echo $rwy_persediaan_saham_pegawai->esa_dianak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->esa_dianak->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->esop_dianak->Visible) { // esop_dianak ?>
		<td data-name="esop_dianak"<?php echo $rwy_persediaan_saham_pegawai->esop_dianak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_esop_dianak" class="rwy_persediaan_saham_pegawai_esop_dianak">
<span<?php echo $rwy_persediaan_saham_pegawai->esop_dianak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->esop_dianak->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->change_by->Visible) { // change_by ?>
		<td data-name="change_by"<?php echo $rwy_persediaan_saham_pegawai->change_by->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_change_by" class="rwy_persediaan_saham_pegawai_change_by">
<span<?php echo $rwy_persediaan_saham_pegawai->change_by->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->change_by->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($rwy_persediaan_saham_pegawai->change_date->Visible) { // change_date ?>
		<td data-name="change_date"<?php echo $rwy_persediaan_saham_pegawai->change_date->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_list->RowCnt ?>_rwy_persediaan_saham_pegawai_change_date" class="rwy_persediaan_saham_pegawai_change_date">
<span<?php echo $rwy_persediaan_saham_pegawai->change_date->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->change_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$rwy_persediaan_saham_pegawai_list->ListOptions->Render("body", "right", $rwy_persediaan_saham_pegawai_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($rwy_persediaan_saham_pegawai->CurrentAction <> "gridadd")
		$rwy_persediaan_saham_pegawai_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($rwy_persediaan_saham_pegawai_list->Recordset)
	$rwy_persediaan_saham_pegawai_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($rwy_persediaan_saham_pegawai->CurrentAction <> "gridadd" && $rwy_persediaan_saham_pegawai->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($rwy_persediaan_saham_pegawai_list->Pager)) $rwy_persediaan_saham_pegawai_list->Pager = new cPrevNextPager($rwy_persediaan_saham_pegawai_list->StartRec, $rwy_persediaan_saham_pegawai_list->DisplayRecs, $rwy_persediaan_saham_pegawai_list->TotalRecs, $rwy_persediaan_saham_pegawai_list->AutoHidePager) ?>
<?php if ($rwy_persediaan_saham_pegawai_list->Pager->RecordCount > 0 && $rwy_persediaan_saham_pegawai_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($rwy_persediaan_saham_pegawai_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $rwy_persediaan_saham_pegawai_list->PageUrl() ?>start=<?php echo $rwy_persediaan_saham_pegawai_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($rwy_persediaan_saham_pegawai_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $rwy_persediaan_saham_pegawai_list->PageUrl() ?>start=<?php echo $rwy_persediaan_saham_pegawai_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $rwy_persediaan_saham_pegawai_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($rwy_persediaan_saham_pegawai_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $rwy_persediaan_saham_pegawai_list->PageUrl() ?>start=<?php echo $rwy_persediaan_saham_pegawai_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($rwy_persediaan_saham_pegawai_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $rwy_persediaan_saham_pegawai_list->PageUrl() ?>start=<?php echo $rwy_persediaan_saham_pegawai_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $rwy_persediaan_saham_pegawai_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $rwy_persediaan_saham_pegawai_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $rwy_persediaan_saham_pegawai_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $rwy_persediaan_saham_pegawai_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($rwy_persediaan_saham_pegawai_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai_list->TotalRecs == 0 && $rwy_persediaan_saham_pegawai->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($rwy_persediaan_saham_pegawai_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
frwy_persediaan_saham_pegawailistsrch.FilterList = <?php echo $rwy_persediaan_saham_pegawai_list->GetFilterList() ?>;
frwy_persediaan_saham_pegawailistsrch.Init();
frwy_persediaan_saham_pegawailist.Init();
</script>
<?php
$rwy_persediaan_saham_pegawai_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$rwy_persediaan_saham_pegawai_list->Page_Terminate();
?>
