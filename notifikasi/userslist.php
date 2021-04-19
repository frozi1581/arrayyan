<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$users_list = NULL; // Initialize page object first

class cusers_list extends cusers {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_list';

	// Grid form hidden field names
	var $FormName = 'fuserslist';
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

		// Table object (users)
		if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == "cusers") {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "usersadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "usersdelete.php";
		$this->MultiUpdateUrl = "usersupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'users', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fuserslistsrch";

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
		$this->nama_pegawai->SetVisibility();
		$this->username->SetVisibility();
		$this->kode_unit_organisasi->SetVisibility();
		$this->kode_unit_kerja->SetVisibility();
		$this->jabatan->SetVisibility();
		$this->user_group->SetVisibility();
		$this->status->SetVisibility();
		$this->nomor_anggota->SetVisibility();
		$this->nip->SetVisibility();
		$this->nip_lama->SetVisibility();
		$this->gelar_depan->SetVisibility();
		$this->gelar_belakang->SetVisibility();
		$this->pendidikan_terakhir->SetVisibility();
		$this->nama_lembaga->SetVisibility();
		$this->warga_negara->SetVisibility();
		$this->tempat_lahir->SetVisibility();
		$this->tanggal_lahir->SetVisibility();
		$this->jenis_kelamin->SetVisibility();
		$this->status_perkawinan->SetVisibility();
		$this->agama->SetVisibility();
		$this->nama_bank->SetVisibility();
		$this->no_rekening->SetVisibility();
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
		global $EW_EXPORT, $users;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($users);
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fuserslistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJson(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->nama_pegawai->AdvancedSearch->ToJson(), ","); // Field nama_pegawai
		$sFilterList = ew_Concat($sFilterList, $this->username->AdvancedSearch->ToJson(), ","); // Field username
		$sFilterList = ew_Concat($sFilterList, $this->kode_unit_organisasi->AdvancedSearch->ToJson(), ","); // Field kode_unit_organisasi
		$sFilterList = ew_Concat($sFilterList, $this->kode_unit_kerja->AdvancedSearch->ToJson(), ","); // Field kode_unit_kerja
		$sFilterList = ew_Concat($sFilterList, $this->jabatan->AdvancedSearch->ToJson(), ","); // Field jabatan
		$sFilterList = ew_Concat($sFilterList, $this->password->AdvancedSearch->ToJson(), ","); // Field password
		$sFilterList = ew_Concat($sFilterList, $this->user_group->AdvancedSearch->ToJson(), ","); // Field user_group
		$sFilterList = ew_Concat($sFilterList, $this->status->AdvancedSearch->ToJson(), ","); // Field status
		$sFilterList = ew_Concat($sFilterList, $this->photo->AdvancedSearch->ToJson(), ","); // Field photo
		$sFilterList = ew_Concat($sFilterList, $this->nomor_anggota->AdvancedSearch->ToJson(), ","); // Field nomor_anggota
		$sFilterList = ew_Concat($sFilterList, $this->nip->AdvancedSearch->ToJson(), ","); // Field nip
		$sFilterList = ew_Concat($sFilterList, $this->nip_lama->AdvancedSearch->ToJson(), ","); // Field nip_lama
		$sFilterList = ew_Concat($sFilterList, $this->gelar_depan->AdvancedSearch->ToJson(), ","); // Field gelar_depan
		$sFilterList = ew_Concat($sFilterList, $this->gelar_belakang->AdvancedSearch->ToJson(), ","); // Field gelar_belakang
		$sFilterList = ew_Concat($sFilterList, $this->pendidikan_terakhir->AdvancedSearch->ToJson(), ","); // Field pendidikan_terakhir
		$sFilterList = ew_Concat($sFilterList, $this->nama_lembaga->AdvancedSearch->ToJson(), ","); // Field nama_lembaga
		$sFilterList = ew_Concat($sFilterList, $this->warga_negara->AdvancedSearch->ToJson(), ","); // Field warga_negara
		$sFilterList = ew_Concat($sFilterList, $this->tempat_lahir->AdvancedSearch->ToJson(), ","); // Field tempat_lahir
		$sFilterList = ew_Concat($sFilterList, $this->tanggal_lahir->AdvancedSearch->ToJson(), ","); // Field tanggal_lahir
		$sFilterList = ew_Concat($sFilterList, $this->jenis_kelamin->AdvancedSearch->ToJson(), ","); // Field jenis_kelamin
		$sFilterList = ew_Concat($sFilterList, $this->status_perkawinan->AdvancedSearch->ToJson(), ","); // Field status_perkawinan
		$sFilterList = ew_Concat($sFilterList, $this->agama->AdvancedSearch->ToJson(), ","); // Field agama
		$sFilterList = ew_Concat($sFilterList, $this->nama_bank->AdvancedSearch->ToJson(), ","); // Field nama_bank
		$sFilterList = ew_Concat($sFilterList, $this->no_rekening->AdvancedSearch->ToJson(), ","); // Field no_rekening
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fuserslistsrch", $filters);

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

		// Field nama_pegawai
		$this->nama_pegawai->AdvancedSearch->SearchValue = @$filter["x_nama_pegawai"];
		$this->nama_pegawai->AdvancedSearch->SearchOperator = @$filter["z_nama_pegawai"];
		$this->nama_pegawai->AdvancedSearch->SearchCondition = @$filter["v_nama_pegawai"];
		$this->nama_pegawai->AdvancedSearch->SearchValue2 = @$filter["y_nama_pegawai"];
		$this->nama_pegawai->AdvancedSearch->SearchOperator2 = @$filter["w_nama_pegawai"];
		$this->nama_pegawai->AdvancedSearch->Save();

		// Field username
		$this->username->AdvancedSearch->SearchValue = @$filter["x_username"];
		$this->username->AdvancedSearch->SearchOperator = @$filter["z_username"];
		$this->username->AdvancedSearch->SearchCondition = @$filter["v_username"];
		$this->username->AdvancedSearch->SearchValue2 = @$filter["y_username"];
		$this->username->AdvancedSearch->SearchOperator2 = @$filter["w_username"];
		$this->username->AdvancedSearch->Save();

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

		// Field jabatan
		$this->jabatan->AdvancedSearch->SearchValue = @$filter["x_jabatan"];
		$this->jabatan->AdvancedSearch->SearchOperator = @$filter["z_jabatan"];
		$this->jabatan->AdvancedSearch->SearchCondition = @$filter["v_jabatan"];
		$this->jabatan->AdvancedSearch->SearchValue2 = @$filter["y_jabatan"];
		$this->jabatan->AdvancedSearch->SearchOperator2 = @$filter["w_jabatan"];
		$this->jabatan->AdvancedSearch->Save();

		// Field password
		$this->password->AdvancedSearch->SearchValue = @$filter["x_password"];
		$this->password->AdvancedSearch->SearchOperator = @$filter["z_password"];
		$this->password->AdvancedSearch->SearchCondition = @$filter["v_password"];
		$this->password->AdvancedSearch->SearchValue2 = @$filter["y_password"];
		$this->password->AdvancedSearch->SearchOperator2 = @$filter["w_password"];
		$this->password->AdvancedSearch->Save();

		// Field user_group
		$this->user_group->AdvancedSearch->SearchValue = @$filter["x_user_group"];
		$this->user_group->AdvancedSearch->SearchOperator = @$filter["z_user_group"];
		$this->user_group->AdvancedSearch->SearchCondition = @$filter["v_user_group"];
		$this->user_group->AdvancedSearch->SearchValue2 = @$filter["y_user_group"];
		$this->user_group->AdvancedSearch->SearchOperator2 = @$filter["w_user_group"];
		$this->user_group->AdvancedSearch->Save();

		// Field status
		$this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
		$this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
		$this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
		$this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
		$this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
		$this->status->AdvancedSearch->Save();

		// Field photo
		$this->photo->AdvancedSearch->SearchValue = @$filter["x_photo"];
		$this->photo->AdvancedSearch->SearchOperator = @$filter["z_photo"];
		$this->photo->AdvancedSearch->SearchCondition = @$filter["v_photo"];
		$this->photo->AdvancedSearch->SearchValue2 = @$filter["y_photo"];
		$this->photo->AdvancedSearch->SearchOperator2 = @$filter["w_photo"];
		$this->photo->AdvancedSearch->Save();

		// Field nomor_anggota
		$this->nomor_anggota->AdvancedSearch->SearchValue = @$filter["x_nomor_anggota"];
		$this->nomor_anggota->AdvancedSearch->SearchOperator = @$filter["z_nomor_anggota"];
		$this->nomor_anggota->AdvancedSearch->SearchCondition = @$filter["v_nomor_anggota"];
		$this->nomor_anggota->AdvancedSearch->SearchValue2 = @$filter["y_nomor_anggota"];
		$this->nomor_anggota->AdvancedSearch->SearchOperator2 = @$filter["w_nomor_anggota"];
		$this->nomor_anggota->AdvancedSearch->Save();

		// Field nip
		$this->nip->AdvancedSearch->SearchValue = @$filter["x_nip"];
		$this->nip->AdvancedSearch->SearchOperator = @$filter["z_nip"];
		$this->nip->AdvancedSearch->SearchCondition = @$filter["v_nip"];
		$this->nip->AdvancedSearch->SearchValue2 = @$filter["y_nip"];
		$this->nip->AdvancedSearch->SearchOperator2 = @$filter["w_nip"];
		$this->nip->AdvancedSearch->Save();

		// Field nip_lama
		$this->nip_lama->AdvancedSearch->SearchValue = @$filter["x_nip_lama"];
		$this->nip_lama->AdvancedSearch->SearchOperator = @$filter["z_nip_lama"];
		$this->nip_lama->AdvancedSearch->SearchCondition = @$filter["v_nip_lama"];
		$this->nip_lama->AdvancedSearch->SearchValue2 = @$filter["y_nip_lama"];
		$this->nip_lama->AdvancedSearch->SearchOperator2 = @$filter["w_nip_lama"];
		$this->nip_lama->AdvancedSearch->Save();

		// Field gelar_depan
		$this->gelar_depan->AdvancedSearch->SearchValue = @$filter["x_gelar_depan"];
		$this->gelar_depan->AdvancedSearch->SearchOperator = @$filter["z_gelar_depan"];
		$this->gelar_depan->AdvancedSearch->SearchCondition = @$filter["v_gelar_depan"];
		$this->gelar_depan->AdvancedSearch->SearchValue2 = @$filter["y_gelar_depan"];
		$this->gelar_depan->AdvancedSearch->SearchOperator2 = @$filter["w_gelar_depan"];
		$this->gelar_depan->AdvancedSearch->Save();

		// Field gelar_belakang
		$this->gelar_belakang->AdvancedSearch->SearchValue = @$filter["x_gelar_belakang"];
		$this->gelar_belakang->AdvancedSearch->SearchOperator = @$filter["z_gelar_belakang"];
		$this->gelar_belakang->AdvancedSearch->SearchCondition = @$filter["v_gelar_belakang"];
		$this->gelar_belakang->AdvancedSearch->SearchValue2 = @$filter["y_gelar_belakang"];
		$this->gelar_belakang->AdvancedSearch->SearchOperator2 = @$filter["w_gelar_belakang"];
		$this->gelar_belakang->AdvancedSearch->Save();

		// Field pendidikan_terakhir
		$this->pendidikan_terakhir->AdvancedSearch->SearchValue = @$filter["x_pendidikan_terakhir"];
		$this->pendidikan_terakhir->AdvancedSearch->SearchOperator = @$filter["z_pendidikan_terakhir"];
		$this->pendidikan_terakhir->AdvancedSearch->SearchCondition = @$filter["v_pendidikan_terakhir"];
		$this->pendidikan_terakhir->AdvancedSearch->SearchValue2 = @$filter["y_pendidikan_terakhir"];
		$this->pendidikan_terakhir->AdvancedSearch->SearchOperator2 = @$filter["w_pendidikan_terakhir"];
		$this->pendidikan_terakhir->AdvancedSearch->Save();

		// Field nama_lembaga
		$this->nama_lembaga->AdvancedSearch->SearchValue = @$filter["x_nama_lembaga"];
		$this->nama_lembaga->AdvancedSearch->SearchOperator = @$filter["z_nama_lembaga"];
		$this->nama_lembaga->AdvancedSearch->SearchCondition = @$filter["v_nama_lembaga"];
		$this->nama_lembaga->AdvancedSearch->SearchValue2 = @$filter["y_nama_lembaga"];
		$this->nama_lembaga->AdvancedSearch->SearchOperator2 = @$filter["w_nama_lembaga"];
		$this->nama_lembaga->AdvancedSearch->Save();

		// Field warga_negara
		$this->warga_negara->AdvancedSearch->SearchValue = @$filter["x_warga_negara"];
		$this->warga_negara->AdvancedSearch->SearchOperator = @$filter["z_warga_negara"];
		$this->warga_negara->AdvancedSearch->SearchCondition = @$filter["v_warga_negara"];
		$this->warga_negara->AdvancedSearch->SearchValue2 = @$filter["y_warga_negara"];
		$this->warga_negara->AdvancedSearch->SearchOperator2 = @$filter["w_warga_negara"];
		$this->warga_negara->AdvancedSearch->Save();

		// Field tempat_lahir
		$this->tempat_lahir->AdvancedSearch->SearchValue = @$filter["x_tempat_lahir"];
		$this->tempat_lahir->AdvancedSearch->SearchOperator = @$filter["z_tempat_lahir"];
		$this->tempat_lahir->AdvancedSearch->SearchCondition = @$filter["v_tempat_lahir"];
		$this->tempat_lahir->AdvancedSearch->SearchValue2 = @$filter["y_tempat_lahir"];
		$this->tempat_lahir->AdvancedSearch->SearchOperator2 = @$filter["w_tempat_lahir"];
		$this->tempat_lahir->AdvancedSearch->Save();

		// Field tanggal_lahir
		$this->tanggal_lahir->AdvancedSearch->SearchValue = @$filter["x_tanggal_lahir"];
		$this->tanggal_lahir->AdvancedSearch->SearchOperator = @$filter["z_tanggal_lahir"];
		$this->tanggal_lahir->AdvancedSearch->SearchCondition = @$filter["v_tanggal_lahir"];
		$this->tanggal_lahir->AdvancedSearch->SearchValue2 = @$filter["y_tanggal_lahir"];
		$this->tanggal_lahir->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal_lahir"];
		$this->tanggal_lahir->AdvancedSearch->Save();

		// Field jenis_kelamin
		$this->jenis_kelamin->AdvancedSearch->SearchValue = @$filter["x_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->SearchOperator = @$filter["z_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->SearchCondition = @$filter["v_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->SearchValue2 = @$filter["y_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->SearchOperator2 = @$filter["w_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->Save();

		// Field status_perkawinan
		$this->status_perkawinan->AdvancedSearch->SearchValue = @$filter["x_status_perkawinan"];
		$this->status_perkawinan->AdvancedSearch->SearchOperator = @$filter["z_status_perkawinan"];
		$this->status_perkawinan->AdvancedSearch->SearchCondition = @$filter["v_status_perkawinan"];
		$this->status_perkawinan->AdvancedSearch->SearchValue2 = @$filter["y_status_perkawinan"];
		$this->status_perkawinan->AdvancedSearch->SearchOperator2 = @$filter["w_status_perkawinan"];
		$this->status_perkawinan->AdvancedSearch->Save();

		// Field agama
		$this->agama->AdvancedSearch->SearchValue = @$filter["x_agama"];
		$this->agama->AdvancedSearch->SearchOperator = @$filter["z_agama"];
		$this->agama->AdvancedSearch->SearchCondition = @$filter["v_agama"];
		$this->agama->AdvancedSearch->SearchValue2 = @$filter["y_agama"];
		$this->agama->AdvancedSearch->SearchOperator2 = @$filter["w_agama"];
		$this->agama->AdvancedSearch->Save();

		// Field nama_bank
		$this->nama_bank->AdvancedSearch->SearchValue = @$filter["x_nama_bank"];
		$this->nama_bank->AdvancedSearch->SearchOperator = @$filter["z_nama_bank"];
		$this->nama_bank->AdvancedSearch->SearchCondition = @$filter["v_nama_bank"];
		$this->nama_bank->AdvancedSearch->SearchValue2 = @$filter["y_nama_bank"];
		$this->nama_bank->AdvancedSearch->SearchOperator2 = @$filter["w_nama_bank"];
		$this->nama_bank->AdvancedSearch->Save();

		// Field no_rekening
		$this->no_rekening->AdvancedSearch->SearchValue = @$filter["x_no_rekening"];
		$this->no_rekening->AdvancedSearch->SearchOperator = @$filter["z_no_rekening"];
		$this->no_rekening->AdvancedSearch->SearchCondition = @$filter["v_no_rekening"];
		$this->no_rekening->AdvancedSearch->SearchValue2 = @$filter["y_no_rekening"];
		$this->no_rekening->AdvancedSearch->SearchOperator2 = @$filter["w_no_rekening"];
		$this->no_rekening->AdvancedSearch->Save();

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
		$this->BuildBasicSearchSQL($sWhere, $this->nama_pegawai, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->username, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kode_unit_organisasi, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kode_unit_kerja, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jabatan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->password, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->photo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nomor_anggota, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nip, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nip_lama, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->gelar_depan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->gelar_belakang, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pendidikan_terakhir, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_lembaga, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->warga_negara, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->tempat_lahir, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jenis_kelamin, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->status_perkawinan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->agama, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_bank, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->no_rekening, $arKeywords, $type);
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
			$this->UpdateSort($this->nama_pegawai); // nama_pegawai
			$this->UpdateSort($this->username); // username
			$this->UpdateSort($this->kode_unit_organisasi); // kode_unit_organisasi
			$this->UpdateSort($this->kode_unit_kerja); // kode_unit_kerja
			$this->UpdateSort($this->jabatan); // jabatan
			$this->UpdateSort($this->user_group); // user_group
			$this->UpdateSort($this->status); // status
			$this->UpdateSort($this->nomor_anggota); // nomor_anggota
			$this->UpdateSort($this->nip); // nip
			$this->UpdateSort($this->nip_lama); // nip_lama
			$this->UpdateSort($this->gelar_depan); // gelar_depan
			$this->UpdateSort($this->gelar_belakang); // gelar_belakang
			$this->UpdateSort($this->pendidikan_terakhir); // pendidikan_terakhir
			$this->UpdateSort($this->nama_lembaga); // nama_lembaga
			$this->UpdateSort($this->warga_negara); // warga_negara
			$this->UpdateSort($this->tempat_lahir); // tempat_lahir
			$this->UpdateSort($this->tanggal_lahir); // tanggal_lahir
			$this->UpdateSort($this->jenis_kelamin); // jenis_kelamin
			$this->UpdateSort($this->status_perkawinan); // status_perkawinan
			$this->UpdateSort($this->agama); // agama
			$this->UpdateSort($this->nama_bank); // nama_bank
			$this->UpdateSort($this->no_rekening); // no_rekening
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
				$this->nama_pegawai->setSort("");
				$this->username->setSort("");
				$this->kode_unit_organisasi->setSort("");
				$this->kode_unit_kerja->setSort("");
				$this->jabatan->setSort("");
				$this->user_group->setSort("");
				$this->status->setSort("");
				$this->nomor_anggota->setSort("");
				$this->nip->setSort("");
				$this->nip_lama->setSort("");
				$this->gelar_depan->setSort("");
				$this->gelar_belakang->setSort("");
				$this->pendidikan_terakhir->setSort("");
				$this->nama_lembaga->setSort("");
				$this->warga_negara->setSort("");
				$this->tempat_lahir->setSort("");
				$this->tanggal_lahir->setSort("");
				$this->jenis_kelamin->setSort("");
				$this->status_perkawinan->setSort("");
				$this->agama->setSort("");
				$this->nama_bank->setSort("");
				$this->no_rekening->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fuserslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fuserslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fuserslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fuserslistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$this->nama_pegawai->setDbValue($row['nama_pegawai']);
		$this->username->setDbValue($row['username']);
		$this->kode_unit_organisasi->setDbValue($row['kode_unit_organisasi']);
		$this->kode_unit_kerja->setDbValue($row['kode_unit_kerja']);
		$this->jabatan->setDbValue($row['jabatan']);
		$this->password->setDbValue($row['password']);
		$this->user_group->setDbValue($row['user_group']);
		$this->status->setDbValue($row['status']);
		$this->photo->setDbValue($row['photo']);
		$this->nomor_anggota->setDbValue($row['nomor_anggota']);
		$this->nip->setDbValue($row['nip']);
		$this->nip_lama->setDbValue($row['nip_lama']);
		$this->gelar_depan->setDbValue($row['gelar_depan']);
		$this->gelar_belakang->setDbValue($row['gelar_belakang']);
		$this->pendidikan_terakhir->setDbValue($row['pendidikan_terakhir']);
		$this->nama_lembaga->setDbValue($row['nama_lembaga']);
		$this->warga_negara->setDbValue($row['warga_negara']);
		$this->tempat_lahir->setDbValue($row['tempat_lahir']);
		$this->tanggal_lahir->setDbValue($row['tanggal_lahir']);
		$this->jenis_kelamin->setDbValue($row['jenis_kelamin']);
		$this->status_perkawinan->setDbValue($row['status_perkawinan']);
		$this->agama->setDbValue($row['agama']);
		$this->nama_bank->setDbValue($row['nama_bank']);
		$this->no_rekening->setDbValue($row['no_rekening']);
		$this->change_date->setDbValue($row['change_date']);
		$this->change_by->setDbValue($row['change_by']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['nama_pegawai'] = NULL;
		$row['username'] = NULL;
		$row['kode_unit_organisasi'] = NULL;
		$row['kode_unit_kerja'] = NULL;
		$row['jabatan'] = NULL;
		$row['password'] = NULL;
		$row['user_group'] = NULL;
		$row['status'] = NULL;
		$row['photo'] = NULL;
		$row['nomor_anggota'] = NULL;
		$row['nip'] = NULL;
		$row['nip_lama'] = NULL;
		$row['gelar_depan'] = NULL;
		$row['gelar_belakang'] = NULL;
		$row['pendidikan_terakhir'] = NULL;
		$row['nama_lembaga'] = NULL;
		$row['warga_negara'] = NULL;
		$row['tempat_lahir'] = NULL;
		$row['tanggal_lahir'] = NULL;
		$row['jenis_kelamin'] = NULL;
		$row['status_perkawinan'] = NULL;
		$row['agama'] = NULL;
		$row['nama_bank'] = NULL;
		$row['no_rekening'] = NULL;
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
		$this->nama_pegawai->DbValue = $row['nama_pegawai'];
		$this->username->DbValue = $row['username'];
		$this->kode_unit_organisasi->DbValue = $row['kode_unit_organisasi'];
		$this->kode_unit_kerja->DbValue = $row['kode_unit_kerja'];
		$this->jabatan->DbValue = $row['jabatan'];
		$this->password->DbValue = $row['password'];
		$this->user_group->DbValue = $row['user_group'];
		$this->status->DbValue = $row['status'];
		$this->photo->DbValue = $row['photo'];
		$this->nomor_anggota->DbValue = $row['nomor_anggota'];
		$this->nip->DbValue = $row['nip'];
		$this->nip_lama->DbValue = $row['nip_lama'];
		$this->gelar_depan->DbValue = $row['gelar_depan'];
		$this->gelar_belakang->DbValue = $row['gelar_belakang'];
		$this->pendidikan_terakhir->DbValue = $row['pendidikan_terakhir'];
		$this->nama_lembaga->DbValue = $row['nama_lembaga'];
		$this->warga_negara->DbValue = $row['warga_negara'];
		$this->tempat_lahir->DbValue = $row['tempat_lahir'];
		$this->tanggal_lahir->DbValue = $row['tanggal_lahir'];
		$this->jenis_kelamin->DbValue = $row['jenis_kelamin'];
		$this->status_perkawinan->DbValue = $row['status_perkawinan'];
		$this->agama->DbValue = $row['agama'];
		$this->nama_bank->DbValue = $row['nama_bank'];
		$this->no_rekening->DbValue = $row['no_rekening'];
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
		// nama_pegawai
		// username
		// kode_unit_organisasi
		// kode_unit_kerja
		// jabatan
		// password
		// user_group
		// status
		// photo
		// nomor_anggota
		// nip
		// nip_lama
		// gelar_depan
		// gelar_belakang
		// pendidikan_terakhir
		// nama_lembaga
		// warga_negara
		// tempat_lahir
		// tanggal_lahir
		// jenis_kelamin
		// status_perkawinan
		// agama
		// nama_bank
		// no_rekening
		// change_date
		// change_by

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nama_pegawai
		$this->nama_pegawai->ViewValue = $this->nama_pegawai->CurrentValue;
		$this->nama_pegawai->ViewCustomAttributes = "";

		// username
		$this->username->ViewValue = $this->username->CurrentValue;
		$this->username->ViewCustomAttributes = "";

		// kode_unit_organisasi
		$this->kode_unit_organisasi->ViewValue = $this->kode_unit_organisasi->CurrentValue;
		$this->kode_unit_organisasi->ViewCustomAttributes = "";

		// kode_unit_kerja
		$this->kode_unit_kerja->ViewValue = $this->kode_unit_kerja->CurrentValue;
		$this->kode_unit_kerja->ViewCustomAttributes = "";

		// jabatan
		$this->jabatan->ViewValue = $this->jabatan->CurrentValue;
		$this->jabatan->ViewCustomAttributes = "";

		// user_group
		$this->user_group->ViewValue = $this->user_group->CurrentValue;
		$this->user_group->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

		// nomor_anggota
		$this->nomor_anggota->ViewValue = $this->nomor_anggota->CurrentValue;
		$this->nomor_anggota->ViewCustomAttributes = "";

		// nip
		$this->nip->ViewValue = $this->nip->CurrentValue;
		$this->nip->ViewCustomAttributes = "";

		// nip_lama
		$this->nip_lama->ViewValue = $this->nip_lama->CurrentValue;
		$this->nip_lama->ViewCustomAttributes = "";

		// gelar_depan
		$this->gelar_depan->ViewValue = $this->gelar_depan->CurrentValue;
		$this->gelar_depan->ViewCustomAttributes = "";

		// gelar_belakang
		$this->gelar_belakang->ViewValue = $this->gelar_belakang->CurrentValue;
		$this->gelar_belakang->ViewCustomAttributes = "";

		// pendidikan_terakhir
		$this->pendidikan_terakhir->ViewValue = $this->pendidikan_terakhir->CurrentValue;
		$this->pendidikan_terakhir->ViewCustomAttributes = "";

		// nama_lembaga
		$this->nama_lembaga->ViewValue = $this->nama_lembaga->CurrentValue;
		$this->nama_lembaga->ViewCustomAttributes = "";

		// warga_negara
		$this->warga_negara->ViewValue = $this->warga_negara->CurrentValue;
		$this->warga_negara->ViewCustomAttributes = "";

		// tempat_lahir
		$this->tempat_lahir->ViewValue = $this->tempat_lahir->CurrentValue;
		$this->tempat_lahir->ViewCustomAttributes = "";

		// tanggal_lahir
		$this->tanggal_lahir->ViewValue = $this->tanggal_lahir->CurrentValue;
		$this->tanggal_lahir->ViewValue = ew_FormatDateTime($this->tanggal_lahir->ViewValue, 0);
		$this->tanggal_lahir->ViewCustomAttributes = "";

		// jenis_kelamin
		$this->jenis_kelamin->ViewValue = $this->jenis_kelamin->CurrentValue;
		$this->jenis_kelamin->ViewCustomAttributes = "";

		// status_perkawinan
		$this->status_perkawinan->ViewValue = $this->status_perkawinan->CurrentValue;
		$this->status_perkawinan->ViewCustomAttributes = "";

		// agama
		$this->agama->ViewValue = $this->agama->CurrentValue;
		$this->agama->ViewCustomAttributes = "";

		// nama_bank
		$this->nama_bank->ViewValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->ViewCustomAttributes = "";

		// no_rekening
		$this->no_rekening->ViewValue = $this->no_rekening->CurrentValue;
		$this->no_rekening->ViewCustomAttributes = "";

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

			// nama_pegawai
			$this->nama_pegawai->LinkCustomAttributes = "";
			$this->nama_pegawai->HrefValue = "";
			$this->nama_pegawai->TooltipValue = "";

			// username
			$this->username->LinkCustomAttributes = "";
			$this->username->HrefValue = "";
			$this->username->TooltipValue = "";

			// kode_unit_organisasi
			$this->kode_unit_organisasi->LinkCustomAttributes = "";
			$this->kode_unit_organisasi->HrefValue = "";
			$this->kode_unit_organisasi->TooltipValue = "";

			// kode_unit_kerja
			$this->kode_unit_kerja->LinkCustomAttributes = "";
			$this->kode_unit_kerja->HrefValue = "";
			$this->kode_unit_kerja->TooltipValue = "";

			// jabatan
			$this->jabatan->LinkCustomAttributes = "";
			$this->jabatan->HrefValue = "";
			$this->jabatan->TooltipValue = "";

			// user_group
			$this->user_group->LinkCustomAttributes = "";
			$this->user_group->HrefValue = "";
			$this->user_group->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// nomor_anggota
			$this->nomor_anggota->LinkCustomAttributes = "";
			$this->nomor_anggota->HrefValue = "";
			$this->nomor_anggota->TooltipValue = "";

			// nip
			$this->nip->LinkCustomAttributes = "";
			$this->nip->HrefValue = "";
			$this->nip->TooltipValue = "";

			// nip_lama
			$this->nip_lama->LinkCustomAttributes = "";
			$this->nip_lama->HrefValue = "";
			$this->nip_lama->TooltipValue = "";

			// gelar_depan
			$this->gelar_depan->LinkCustomAttributes = "";
			$this->gelar_depan->HrefValue = "";
			$this->gelar_depan->TooltipValue = "";

			// gelar_belakang
			$this->gelar_belakang->LinkCustomAttributes = "";
			$this->gelar_belakang->HrefValue = "";
			$this->gelar_belakang->TooltipValue = "";

			// pendidikan_terakhir
			$this->pendidikan_terakhir->LinkCustomAttributes = "";
			$this->pendidikan_terakhir->HrefValue = "";
			$this->pendidikan_terakhir->TooltipValue = "";

			// nama_lembaga
			$this->nama_lembaga->LinkCustomAttributes = "";
			$this->nama_lembaga->HrefValue = "";
			$this->nama_lembaga->TooltipValue = "";

			// warga_negara
			$this->warga_negara->LinkCustomAttributes = "";
			$this->warga_negara->HrefValue = "";
			$this->warga_negara->TooltipValue = "";

			// tempat_lahir
			$this->tempat_lahir->LinkCustomAttributes = "";
			$this->tempat_lahir->HrefValue = "";
			$this->tempat_lahir->TooltipValue = "";

			// tanggal_lahir
			$this->tanggal_lahir->LinkCustomAttributes = "";
			$this->tanggal_lahir->HrefValue = "";
			$this->tanggal_lahir->TooltipValue = "";

			// jenis_kelamin
			$this->jenis_kelamin->LinkCustomAttributes = "";
			$this->jenis_kelamin->HrefValue = "";
			$this->jenis_kelamin->TooltipValue = "";

			// status_perkawinan
			$this->status_perkawinan->LinkCustomAttributes = "";
			$this->status_perkawinan->HrefValue = "";
			$this->status_perkawinan->TooltipValue = "";

			// agama
			$this->agama->LinkCustomAttributes = "";
			$this->agama->HrefValue = "";
			$this->agama->TooltipValue = "";

			// nama_bank
			$this->nama_bank->LinkCustomAttributes = "";
			$this->nama_bank->HrefValue = "";
			$this->nama_bank->TooltipValue = "";

			// no_rekening
			$this->no_rekening->LinkCustomAttributes = "";
			$this->no_rekening->HrefValue = "";
			$this->no_rekening->TooltipValue = "";

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
if (!isset($users_list)) $users_list = new cusers_list();

// Page init
$users_list->Page_Init();

// Page main
$users_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fuserslist = new ew_Form("fuserslist", "list");
fuserslist.FormKeyCountName = '<?php echo $users_list->FormKeyCountName ?>';

// Form_CustomValidate event
fuserslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fuserslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fuserslistsrch = new ew_Form("fuserslistsrch");
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
<?php if ($users_list->TotalRecs > 0 && $users_list->ExportOptions->Visible()) { ?>
<?php $users_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($users_list->SearchOptions->Visible()) { ?>
<?php $users_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($users_list->FilterOptions->Visible()) { ?>
<?php $users_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $users_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($users_list->TotalRecs <= 0)
			$users_list->TotalRecs = $users->ListRecordCount();
	} else {
		if (!$users_list->Recordset && ($users_list->Recordset = $users_list->LoadRecordset()))
			$users_list->TotalRecs = $users_list->Recordset->RecordCount();
	}
	$users_list->StartRec = 1;
	if ($users_list->DisplayRecs <= 0 || ($users->Export <> "" && $users->ExportAll)) // Display all records
		$users_list->DisplayRecs = $users_list->TotalRecs;
	if (!($users->Export <> "" && $users->ExportAll))
		$users_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$users_list->Recordset = $users_list->LoadRecordset($users_list->StartRec-1, $users_list->DisplayRecs);

	// Set no record found message
	if ($users->CurrentAction == "" && $users_list->TotalRecs == 0) {
		if ($users_list->SearchWhere == "0=101")
			$users_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$users_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$users_list->RenderOtherOptions();
?>
<?php if ($users->Export == "" && $users->CurrentAction == "") { ?>
<form name="fuserslistsrch" id="fuserslistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($users_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fuserslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="users">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($users_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($users_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $users_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($users_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($users_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($users_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($users_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $users_list->ShowPageHeader(); ?>
<?php
$users_list->ShowMessage();
?>
<?php if ($users_list->TotalRecs > 0 || $users->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($users_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> users">
<form name="fuserslist" id="fuserslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($users_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $users_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<div id="gmp_users" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($users_list->TotalRecs > 0 || $users->CurrentAction == "gridedit") { ?>
<table id="tbl_userslist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$users_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$users_list->RenderListOptions();

// Render list options (header, left)
$users_list->ListOptions->Render("header", "left");
?>
<?php if ($users->id->Visible) { // id ?>
	<?php if ($users->SortUrl($users->id) == "") { ?>
		<th data-name="id" class="<?php echo $users->id->HeaderCellClass() ?>"><div id="elh_users_id" class="users_id"><div class="ewTableHeaderCaption"><?php echo $users->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $users->id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->id) ?>',1);"><div id="elh_users_id" class="users_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->nama_pegawai->Visible) { // nama_pegawai ?>
	<?php if ($users->SortUrl($users->nama_pegawai) == "") { ?>
		<th data-name="nama_pegawai" class="<?php echo $users->nama_pegawai->HeaderCellClass() ?>"><div id="elh_users_nama_pegawai" class="users_nama_pegawai"><div class="ewTableHeaderCaption"><?php echo $users->nama_pegawai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_pegawai" class="<?php echo $users->nama_pegawai->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->nama_pegawai) ?>',1);"><div id="elh_users_nama_pegawai" class="users_nama_pegawai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->nama_pegawai->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->nama_pegawai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->nama_pegawai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->username->Visible) { // username ?>
	<?php if ($users->SortUrl($users->username) == "") { ?>
		<th data-name="username" class="<?php echo $users->username->HeaderCellClass() ?>"><div id="elh_users_username" class="users_username"><div class="ewTableHeaderCaption"><?php echo $users->username->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="username" class="<?php echo $users->username->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->username) ?>',1);"><div id="elh_users_username" class="users_username">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->username->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->username->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->username->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->kode_unit_organisasi->Visible) { // kode_unit_organisasi ?>
	<?php if ($users->SortUrl($users->kode_unit_organisasi) == "") { ?>
		<th data-name="kode_unit_organisasi" class="<?php echo $users->kode_unit_organisasi->HeaderCellClass() ?>"><div id="elh_users_kode_unit_organisasi" class="users_kode_unit_organisasi"><div class="ewTableHeaderCaption"><?php echo $users->kode_unit_organisasi->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_unit_organisasi" class="<?php echo $users->kode_unit_organisasi->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->kode_unit_organisasi) ?>',1);"><div id="elh_users_kode_unit_organisasi" class="users_kode_unit_organisasi">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->kode_unit_organisasi->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->kode_unit_organisasi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->kode_unit_organisasi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->kode_unit_kerja->Visible) { // kode_unit_kerja ?>
	<?php if ($users->SortUrl($users->kode_unit_kerja) == "") { ?>
		<th data-name="kode_unit_kerja" class="<?php echo $users->kode_unit_kerja->HeaderCellClass() ?>"><div id="elh_users_kode_unit_kerja" class="users_kode_unit_kerja"><div class="ewTableHeaderCaption"><?php echo $users->kode_unit_kerja->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_unit_kerja" class="<?php echo $users->kode_unit_kerja->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->kode_unit_kerja) ?>',1);"><div id="elh_users_kode_unit_kerja" class="users_kode_unit_kerja">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->kode_unit_kerja->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->kode_unit_kerja->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->kode_unit_kerja->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->jabatan->Visible) { // jabatan ?>
	<?php if ($users->SortUrl($users->jabatan) == "") { ?>
		<th data-name="jabatan" class="<?php echo $users->jabatan->HeaderCellClass() ?>"><div id="elh_users_jabatan" class="users_jabatan"><div class="ewTableHeaderCaption"><?php echo $users->jabatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jabatan" class="<?php echo $users->jabatan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->jabatan) ?>',1);"><div id="elh_users_jabatan" class="users_jabatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->jabatan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->jabatan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->jabatan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->user_group->Visible) { // user_group ?>
	<?php if ($users->SortUrl($users->user_group) == "") { ?>
		<th data-name="user_group" class="<?php echo $users->user_group->HeaderCellClass() ?>"><div id="elh_users_user_group" class="users_user_group"><div class="ewTableHeaderCaption"><?php echo $users->user_group->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="user_group" class="<?php echo $users->user_group->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->user_group) ?>',1);"><div id="elh_users_user_group" class="users_user_group">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->user_group->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->user_group->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->user_group->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->status->Visible) { // status ?>
	<?php if ($users->SortUrl($users->status) == "") { ?>
		<th data-name="status" class="<?php echo $users->status->HeaderCellClass() ?>"><div id="elh_users_status" class="users_status"><div class="ewTableHeaderCaption"><?php echo $users->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $users->status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->status) ?>',1);"><div id="elh_users_status" class="users_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->nomor_anggota->Visible) { // nomor_anggota ?>
	<?php if ($users->SortUrl($users->nomor_anggota) == "") { ?>
		<th data-name="nomor_anggota" class="<?php echo $users->nomor_anggota->HeaderCellClass() ?>"><div id="elh_users_nomor_anggota" class="users_nomor_anggota"><div class="ewTableHeaderCaption"><?php echo $users->nomor_anggota->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomor_anggota" class="<?php echo $users->nomor_anggota->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->nomor_anggota) ?>',1);"><div id="elh_users_nomor_anggota" class="users_nomor_anggota">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->nomor_anggota->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->nomor_anggota->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->nomor_anggota->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->nip->Visible) { // nip ?>
	<?php if ($users->SortUrl($users->nip) == "") { ?>
		<th data-name="nip" class="<?php echo $users->nip->HeaderCellClass() ?>"><div id="elh_users_nip" class="users_nip"><div class="ewTableHeaderCaption"><?php echo $users->nip->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nip" class="<?php echo $users->nip->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->nip) ?>',1);"><div id="elh_users_nip" class="users_nip">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->nip->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->nip->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->nip->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->nip_lama->Visible) { // nip_lama ?>
	<?php if ($users->SortUrl($users->nip_lama) == "") { ?>
		<th data-name="nip_lama" class="<?php echo $users->nip_lama->HeaderCellClass() ?>"><div id="elh_users_nip_lama" class="users_nip_lama"><div class="ewTableHeaderCaption"><?php echo $users->nip_lama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nip_lama" class="<?php echo $users->nip_lama->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->nip_lama) ?>',1);"><div id="elh_users_nip_lama" class="users_nip_lama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->nip_lama->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->nip_lama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->nip_lama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->gelar_depan->Visible) { // gelar_depan ?>
	<?php if ($users->SortUrl($users->gelar_depan) == "") { ?>
		<th data-name="gelar_depan" class="<?php echo $users->gelar_depan->HeaderCellClass() ?>"><div id="elh_users_gelar_depan" class="users_gelar_depan"><div class="ewTableHeaderCaption"><?php echo $users->gelar_depan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="gelar_depan" class="<?php echo $users->gelar_depan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->gelar_depan) ?>',1);"><div id="elh_users_gelar_depan" class="users_gelar_depan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->gelar_depan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->gelar_depan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->gelar_depan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->gelar_belakang->Visible) { // gelar_belakang ?>
	<?php if ($users->SortUrl($users->gelar_belakang) == "") { ?>
		<th data-name="gelar_belakang" class="<?php echo $users->gelar_belakang->HeaderCellClass() ?>"><div id="elh_users_gelar_belakang" class="users_gelar_belakang"><div class="ewTableHeaderCaption"><?php echo $users->gelar_belakang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="gelar_belakang" class="<?php echo $users->gelar_belakang->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->gelar_belakang) ?>',1);"><div id="elh_users_gelar_belakang" class="users_gelar_belakang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->gelar_belakang->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->gelar_belakang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->gelar_belakang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->pendidikan_terakhir->Visible) { // pendidikan_terakhir ?>
	<?php if ($users->SortUrl($users->pendidikan_terakhir) == "") { ?>
		<th data-name="pendidikan_terakhir" class="<?php echo $users->pendidikan_terakhir->HeaderCellClass() ?>"><div id="elh_users_pendidikan_terakhir" class="users_pendidikan_terakhir"><div class="ewTableHeaderCaption"><?php echo $users->pendidikan_terakhir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pendidikan_terakhir" class="<?php echo $users->pendidikan_terakhir->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->pendidikan_terakhir) ?>',1);"><div id="elh_users_pendidikan_terakhir" class="users_pendidikan_terakhir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->pendidikan_terakhir->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->pendidikan_terakhir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->pendidikan_terakhir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->nama_lembaga->Visible) { // nama_lembaga ?>
	<?php if ($users->SortUrl($users->nama_lembaga) == "") { ?>
		<th data-name="nama_lembaga" class="<?php echo $users->nama_lembaga->HeaderCellClass() ?>"><div id="elh_users_nama_lembaga" class="users_nama_lembaga"><div class="ewTableHeaderCaption"><?php echo $users->nama_lembaga->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_lembaga" class="<?php echo $users->nama_lembaga->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->nama_lembaga) ?>',1);"><div id="elh_users_nama_lembaga" class="users_nama_lembaga">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->nama_lembaga->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->nama_lembaga->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->nama_lembaga->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->warga_negara->Visible) { // warga_negara ?>
	<?php if ($users->SortUrl($users->warga_negara) == "") { ?>
		<th data-name="warga_negara" class="<?php echo $users->warga_negara->HeaderCellClass() ?>"><div id="elh_users_warga_negara" class="users_warga_negara"><div class="ewTableHeaderCaption"><?php echo $users->warga_negara->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="warga_negara" class="<?php echo $users->warga_negara->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->warga_negara) ?>',1);"><div id="elh_users_warga_negara" class="users_warga_negara">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->warga_negara->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->warga_negara->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->warga_negara->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->tempat_lahir->Visible) { // tempat_lahir ?>
	<?php if ($users->SortUrl($users->tempat_lahir) == "") { ?>
		<th data-name="tempat_lahir" class="<?php echo $users->tempat_lahir->HeaderCellClass() ?>"><div id="elh_users_tempat_lahir" class="users_tempat_lahir"><div class="ewTableHeaderCaption"><?php echo $users->tempat_lahir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tempat_lahir" class="<?php echo $users->tempat_lahir->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->tempat_lahir) ?>',1);"><div id="elh_users_tempat_lahir" class="users_tempat_lahir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->tempat_lahir->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->tempat_lahir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->tempat_lahir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->tanggal_lahir->Visible) { // tanggal_lahir ?>
	<?php if ($users->SortUrl($users->tanggal_lahir) == "") { ?>
		<th data-name="tanggal_lahir" class="<?php echo $users->tanggal_lahir->HeaderCellClass() ?>"><div id="elh_users_tanggal_lahir" class="users_tanggal_lahir"><div class="ewTableHeaderCaption"><?php echo $users->tanggal_lahir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tanggal_lahir" class="<?php echo $users->tanggal_lahir->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->tanggal_lahir) ?>',1);"><div id="elh_users_tanggal_lahir" class="users_tanggal_lahir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->tanggal_lahir->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->tanggal_lahir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->tanggal_lahir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->jenis_kelamin->Visible) { // jenis_kelamin ?>
	<?php if ($users->SortUrl($users->jenis_kelamin) == "") { ?>
		<th data-name="jenis_kelamin" class="<?php echo $users->jenis_kelamin->HeaderCellClass() ?>"><div id="elh_users_jenis_kelamin" class="users_jenis_kelamin"><div class="ewTableHeaderCaption"><?php echo $users->jenis_kelamin->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jenis_kelamin" class="<?php echo $users->jenis_kelamin->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->jenis_kelamin) ?>',1);"><div id="elh_users_jenis_kelamin" class="users_jenis_kelamin">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->jenis_kelamin->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->jenis_kelamin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->jenis_kelamin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->status_perkawinan->Visible) { // status_perkawinan ?>
	<?php if ($users->SortUrl($users->status_perkawinan) == "") { ?>
		<th data-name="status_perkawinan" class="<?php echo $users->status_perkawinan->HeaderCellClass() ?>"><div id="elh_users_status_perkawinan" class="users_status_perkawinan"><div class="ewTableHeaderCaption"><?php echo $users->status_perkawinan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status_perkawinan" class="<?php echo $users->status_perkawinan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->status_perkawinan) ?>',1);"><div id="elh_users_status_perkawinan" class="users_status_perkawinan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->status_perkawinan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->status_perkawinan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->status_perkawinan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->agama->Visible) { // agama ?>
	<?php if ($users->SortUrl($users->agama) == "") { ?>
		<th data-name="agama" class="<?php echo $users->agama->HeaderCellClass() ?>"><div id="elh_users_agama" class="users_agama"><div class="ewTableHeaderCaption"><?php echo $users->agama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="agama" class="<?php echo $users->agama->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->agama) ?>',1);"><div id="elh_users_agama" class="users_agama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->agama->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->agama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->agama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->nama_bank->Visible) { // nama_bank ?>
	<?php if ($users->SortUrl($users->nama_bank) == "") { ?>
		<th data-name="nama_bank" class="<?php echo $users->nama_bank->HeaderCellClass() ?>"><div id="elh_users_nama_bank" class="users_nama_bank"><div class="ewTableHeaderCaption"><?php echo $users->nama_bank->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_bank" class="<?php echo $users->nama_bank->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->nama_bank) ?>',1);"><div id="elh_users_nama_bank" class="users_nama_bank">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->nama_bank->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->nama_bank->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->nama_bank->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->no_rekening->Visible) { // no_rekening ?>
	<?php if ($users->SortUrl($users->no_rekening) == "") { ?>
		<th data-name="no_rekening" class="<?php echo $users->no_rekening->HeaderCellClass() ?>"><div id="elh_users_no_rekening" class="users_no_rekening"><div class="ewTableHeaderCaption"><?php echo $users->no_rekening->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_rekening" class="<?php echo $users->no_rekening->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->no_rekening) ?>',1);"><div id="elh_users_no_rekening" class="users_no_rekening">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->no_rekening->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->no_rekening->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->no_rekening->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->change_date->Visible) { // change_date ?>
	<?php if ($users->SortUrl($users->change_date) == "") { ?>
		<th data-name="change_date" class="<?php echo $users->change_date->HeaderCellClass() ?>"><div id="elh_users_change_date" class="users_change_date"><div class="ewTableHeaderCaption"><?php echo $users->change_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="change_date" class="<?php echo $users->change_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->change_date) ?>',1);"><div id="elh_users_change_date" class="users_change_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->change_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->change_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->change_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->change_by->Visible) { // change_by ?>
	<?php if ($users->SortUrl($users->change_by) == "") { ?>
		<th data-name="change_by" class="<?php echo $users->change_by->HeaderCellClass() ?>"><div id="elh_users_change_by" class="users_change_by"><div class="ewTableHeaderCaption"><?php echo $users->change_by->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="change_by" class="<?php echo $users->change_by->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->change_by) ?>',1);"><div id="elh_users_change_by" class="users_change_by">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->change_by->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->change_by->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->change_by->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$users_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($users->ExportAll && $users->Export <> "") {
	$users_list->StopRec = $users_list->TotalRecs;
} else {

	// Set the last record to display
	if ($users_list->TotalRecs > $users_list->StartRec + $users_list->DisplayRecs - 1)
		$users_list->StopRec = $users_list->StartRec + $users_list->DisplayRecs - 1;
	else
		$users_list->StopRec = $users_list->TotalRecs;
}
$users_list->RecCnt = $users_list->StartRec - 1;
if ($users_list->Recordset && !$users_list->Recordset->EOF) {
	$users_list->Recordset->MoveFirst();
	$bSelectLimit = $users_list->UseSelectLimit;
	if (!$bSelectLimit && $users_list->StartRec > 1)
		$users_list->Recordset->Move($users_list->StartRec - 1);
} elseif (!$users->AllowAddDeleteRow && $users_list->StopRec == 0) {
	$users_list->StopRec = $users->GridAddRowCount;
}

// Initialize aggregate
$users->RowType = EW_ROWTYPE_AGGREGATEINIT;
$users->ResetAttrs();
$users_list->RenderRow();
while ($users_list->RecCnt < $users_list->StopRec) {
	$users_list->RecCnt++;
	if (intval($users_list->RecCnt) >= intval($users_list->StartRec)) {
		$users_list->RowCnt++;

		// Set up key count
		$users_list->KeyCount = $users_list->RowIndex;

		// Init row class and style
		$users->ResetAttrs();
		$users->CssClass = "";
		if ($users->CurrentAction == "gridadd") {
		} else {
			$users_list->LoadRowValues($users_list->Recordset); // Load row values
		}
		$users->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$users->RowAttrs = array_merge($users->RowAttrs, array('data-rowindex'=>$users_list->RowCnt, 'id'=>'r' . $users_list->RowCnt . '_users', 'data-rowtype'=>$users->RowType));

		// Render row
		$users_list->RenderRow();

		// Render list options
		$users_list->RenderListOptions();
?>
	<tr<?php echo $users->RowAttributes() ?>>
<?php

// Render list options (body, left)
$users_list->ListOptions->Render("body", "left", $users_list->RowCnt);
?>
	<?php if ($users->id->Visible) { // id ?>
		<td data-name="id"<?php echo $users->id->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_id" class="users_id">
<span<?php echo $users->id->ViewAttributes() ?>>
<?php echo $users->id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->nama_pegawai->Visible) { // nama_pegawai ?>
		<td data-name="nama_pegawai"<?php echo $users->nama_pegawai->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_nama_pegawai" class="users_nama_pegawai">
<span<?php echo $users->nama_pegawai->ViewAttributes() ?>>
<?php echo $users->nama_pegawai->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->username->Visible) { // username ?>
		<td data-name="username"<?php echo $users->username->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_username" class="users_username">
<span<?php echo $users->username->ViewAttributes() ?>>
<?php echo $users->username->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->kode_unit_organisasi->Visible) { // kode_unit_organisasi ?>
		<td data-name="kode_unit_organisasi"<?php echo $users->kode_unit_organisasi->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_kode_unit_organisasi" class="users_kode_unit_organisasi">
<span<?php echo $users->kode_unit_organisasi->ViewAttributes() ?>>
<?php echo $users->kode_unit_organisasi->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->kode_unit_kerja->Visible) { // kode_unit_kerja ?>
		<td data-name="kode_unit_kerja"<?php echo $users->kode_unit_kerja->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_kode_unit_kerja" class="users_kode_unit_kerja">
<span<?php echo $users->kode_unit_kerja->ViewAttributes() ?>>
<?php echo $users->kode_unit_kerja->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->jabatan->Visible) { // jabatan ?>
		<td data-name="jabatan"<?php echo $users->jabatan->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_jabatan" class="users_jabatan">
<span<?php echo $users->jabatan->ViewAttributes() ?>>
<?php echo $users->jabatan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->user_group->Visible) { // user_group ?>
		<td data-name="user_group"<?php echo $users->user_group->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_user_group" class="users_user_group">
<span<?php echo $users->user_group->ViewAttributes() ?>>
<?php echo $users->user_group->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->status->Visible) { // status ?>
		<td data-name="status"<?php echo $users->status->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_status" class="users_status">
<span<?php echo $users->status->ViewAttributes() ?>>
<?php echo $users->status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->nomor_anggota->Visible) { // nomor_anggota ?>
		<td data-name="nomor_anggota"<?php echo $users->nomor_anggota->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_nomor_anggota" class="users_nomor_anggota">
<span<?php echo $users->nomor_anggota->ViewAttributes() ?>>
<?php echo $users->nomor_anggota->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->nip->Visible) { // nip ?>
		<td data-name="nip"<?php echo $users->nip->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_nip" class="users_nip">
<span<?php echo $users->nip->ViewAttributes() ?>>
<?php echo $users->nip->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->nip_lama->Visible) { // nip_lama ?>
		<td data-name="nip_lama"<?php echo $users->nip_lama->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_nip_lama" class="users_nip_lama">
<span<?php echo $users->nip_lama->ViewAttributes() ?>>
<?php echo $users->nip_lama->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->gelar_depan->Visible) { // gelar_depan ?>
		<td data-name="gelar_depan"<?php echo $users->gelar_depan->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_gelar_depan" class="users_gelar_depan">
<span<?php echo $users->gelar_depan->ViewAttributes() ?>>
<?php echo $users->gelar_depan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->gelar_belakang->Visible) { // gelar_belakang ?>
		<td data-name="gelar_belakang"<?php echo $users->gelar_belakang->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_gelar_belakang" class="users_gelar_belakang">
<span<?php echo $users->gelar_belakang->ViewAttributes() ?>>
<?php echo $users->gelar_belakang->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->pendidikan_terakhir->Visible) { // pendidikan_terakhir ?>
		<td data-name="pendidikan_terakhir"<?php echo $users->pendidikan_terakhir->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_pendidikan_terakhir" class="users_pendidikan_terakhir">
<span<?php echo $users->pendidikan_terakhir->ViewAttributes() ?>>
<?php echo $users->pendidikan_terakhir->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->nama_lembaga->Visible) { // nama_lembaga ?>
		<td data-name="nama_lembaga"<?php echo $users->nama_lembaga->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_nama_lembaga" class="users_nama_lembaga">
<span<?php echo $users->nama_lembaga->ViewAttributes() ?>>
<?php echo $users->nama_lembaga->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->warga_negara->Visible) { // warga_negara ?>
		<td data-name="warga_negara"<?php echo $users->warga_negara->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_warga_negara" class="users_warga_negara">
<span<?php echo $users->warga_negara->ViewAttributes() ?>>
<?php echo $users->warga_negara->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->tempat_lahir->Visible) { // tempat_lahir ?>
		<td data-name="tempat_lahir"<?php echo $users->tempat_lahir->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_tempat_lahir" class="users_tempat_lahir">
<span<?php echo $users->tempat_lahir->ViewAttributes() ?>>
<?php echo $users->tempat_lahir->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->tanggal_lahir->Visible) { // tanggal_lahir ?>
		<td data-name="tanggal_lahir"<?php echo $users->tanggal_lahir->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_tanggal_lahir" class="users_tanggal_lahir">
<span<?php echo $users->tanggal_lahir->ViewAttributes() ?>>
<?php echo $users->tanggal_lahir->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->jenis_kelamin->Visible) { // jenis_kelamin ?>
		<td data-name="jenis_kelamin"<?php echo $users->jenis_kelamin->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_jenis_kelamin" class="users_jenis_kelamin">
<span<?php echo $users->jenis_kelamin->ViewAttributes() ?>>
<?php echo $users->jenis_kelamin->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->status_perkawinan->Visible) { // status_perkawinan ?>
		<td data-name="status_perkawinan"<?php echo $users->status_perkawinan->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_status_perkawinan" class="users_status_perkawinan">
<span<?php echo $users->status_perkawinan->ViewAttributes() ?>>
<?php echo $users->status_perkawinan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->agama->Visible) { // agama ?>
		<td data-name="agama"<?php echo $users->agama->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_agama" class="users_agama">
<span<?php echo $users->agama->ViewAttributes() ?>>
<?php echo $users->agama->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->nama_bank->Visible) { // nama_bank ?>
		<td data-name="nama_bank"<?php echo $users->nama_bank->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_nama_bank" class="users_nama_bank">
<span<?php echo $users->nama_bank->ViewAttributes() ?>>
<?php echo $users->nama_bank->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->no_rekening->Visible) { // no_rekening ?>
		<td data-name="no_rekening"<?php echo $users->no_rekening->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_no_rekening" class="users_no_rekening">
<span<?php echo $users->no_rekening->ViewAttributes() ?>>
<?php echo $users->no_rekening->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->change_date->Visible) { // change_date ?>
		<td data-name="change_date"<?php echo $users->change_date->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_change_date" class="users_change_date">
<span<?php echo $users->change_date->ViewAttributes() ?>>
<?php echo $users->change_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->change_by->Visible) { // change_by ?>
		<td data-name="change_by"<?php echo $users->change_by->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_change_by" class="users_change_by">
<span<?php echo $users->change_by->ViewAttributes() ?>>
<?php echo $users->change_by->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$users_list->ListOptions->Render("body", "right", $users_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($users->CurrentAction <> "gridadd")
		$users_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($users->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($users_list->Recordset)
	$users_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($users->CurrentAction <> "gridadd" && $users->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($users_list->Pager)) $users_list->Pager = new cPrevNextPager($users_list->StartRec, $users_list->DisplayRecs, $users_list->TotalRecs, $users_list->AutoHidePager) ?>
<?php if ($users_list->Pager->RecordCount > 0 && $users_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($users_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($users_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $users_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($users_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($users_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $users_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($users_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $users_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $users_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $users_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($users_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($users_list->TotalRecs == 0 && $users->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($users_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fuserslistsrch.FilterList = <?php echo $users_list->GetFilterList() ?>;
fuserslistsrch.Init();
fuserslist.Init();
</script>
<?php
$users_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$users_list->Page_Terminate();
?>
