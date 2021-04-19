<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "v_notif_dinfo.php" ?>
<?php include_once "tb_notifikasiinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$v_notif_d_preview = NULL; // Initialize page object first

class cv_notif_d_preview extends cv_notif_d {

	// Page ID
	var $PageID = 'preview';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'v_notif_d';

	// Page object name
	var $PageObjName = 'v_notif_d_preview';

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

		// Table object (v_notif_d)
		if (!isset($GLOBALS["v_notif_d"]) || get_class($GLOBALS["v_notif_d"]) == "cv_notif_d") {
			$GLOBALS["v_notif_d"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["v_notif_d"];
		}

		// Table object (tb_notifikasi)
		if (!isset($GLOBALS['tb_notifikasi'])) $GLOBALS['tb_notifikasi'] = new ctb_notifikasi();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'preview', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'v_notif_d', TRUE);

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

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Set up list options
		$this->SetupListOptions();
		$this->id->SetVisibility();
		$this->employee_id->SetVisibility();
		$this->bagian->SetVisibility();
		$this->lokasi_kerja->SetVisibility();
		$this->status->SetVisibility();
		if ($this->IsAddOrEdit())
			$this->status->Visible = FALSE;

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

		// Create Token
		$this->CreateToken();

		// Setup other options
		$this->SetupOtherOptions();
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
		global $EW_EXPORT, $v_notif_d;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($v_notif_d);
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
	var $Recordset;
	var $TotalRecs;
	var $RowCnt;
	var $RecCount;
	var $ListOptions; // List options
	var $OtherOptions; // Other options
	var $Pager;
	var $StartRec = 1;
	var $DisplayRecs = 0;
	var $SortField = "";
	var $SortOrder = "";

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load filter
		$filter = @$_GET["f"];
		$filter = ew_Decrypt($filter);
		if ($filter == "") $filter = "0=1";
		$this->StartRec = intval(@$_GET["start"]) ?: 1;
		$this->SortField = @$_GET["sort"];
		$this->SortOrder = @$_GET["sortorder"];

		// Set up foreign keys from filter
		$this->SetupForeignKeysFromFilter($filter);

		// Call Recordset Selecting event
		$this->Recordset_Selecting($filter);

		// Load recordset
		$filter = $this->ApplyUserIDFilters($filter);
		$this->TotalRecs = $this->LoadRecordCount($filter);
		$sSql = $this->PreviewSQL($filter);
		if ($this->DisplayRecs > 0)
			$this->Recordset = $this->Connection()->SelectLimit($sSql, $this->DisplayRecs, $this->StartRec - 1);
		if (!$this->Recordset)
			$this->Recordset = $this->Connection()->Execute($sSql);
		if ($this->Recordset && !$this->Recordset->EOF) {

			// Call Recordset Selected event
			$this->Recordset_Selected($this->Recordset);
			$this->LoadListRowValues($this->Recordset);
		}
		$this->RenderOtherOptions();
	}

	// Get preview SQL
	function PreviewSQL($filter) {
		$sortField = $this->SortField;
		$sortOrder = $this->SortOrder;
		$sort = "";
		if (array_key_exists($sortField, $this->fields)) {
			$fld = $this->fields[$sortField];
			$sort = $fld->FldExpression;
			if ($sortOrder == "ASC" || $sortOrder == "DESC")
				$sort .= " " . $sortOrder;
		}
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $filter, $sort);
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();
		$masterkeyurl = $this->MasterKeyUrl();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
	}

	// Get master foreign key url
	function MasterKeyUrl() {
		$mastertblvar = @$_GET["t"];
		$url = "";
		if ($mastertblvar == "tb_notifikasi") {
			$url = "" . EW_TABLE_SHOW_MASTER . "=tb_notifikasi&fk_id=" . urlencode(strval($this->id->QueryStringValue)) . "";
		}
		return $url;
	}

	// Set up foreign keys from filter
	function SetupForeignKeysFromFilter($f) {
		$mastertblvar = @$_GET["t"];
		if ($mastertblvar == "tb_notifikasi") {
			$find = "`id`=";
			$x = strpos($f, $find);
			if ($x !== FALSE) {
				$x += strlen($find);
				$val = substr($f, $x);
				$val = $this->UnquoteValue($val, "DB");
 				$this->id->setQueryStringValue($val);
			}
		}
	}

	// Unquote value
	function UnquoteValue($val, $dbid) {
		if (substr($val,0,1) == "'" && substr($val,strlen($val)-1) == "'") {
			if (ew_GetConnectionType($dbid) == "MYSQL")
				return stripslashes(substr($val, 1, strlen($val)-2));
			else
				return str_replace("''", "'", substr($val, 1, strlen($val)-2));
		} else {
			return $val;
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
}
?>
<?php ew_Header(FALSE, "utf-8") ?>
<?php

// Create page object
if (!isset($v_notif_d_preview)) $v_notif_d_preview = new cv_notif_d_preview();

// Page init
$v_notif_d_preview->Page_Init();

// Page main
$v_notif_d_preview->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_notif_d_preview->Page_Render();
?>
<?php $v_notif_d_preview->ShowPageHeader(); ?>
<div class="box ewGrid v_notif_d"><!-- .box -->
<?php if ($v_notif_d_preview->TotalRecs > 0) { ?>
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel"><!-- .table-responsive -->
<table class="table ewTable ewPreviewTable"><!-- .table -->
	<thead><!-- Table header -->
		<tr class="ewTableHeader">
<?php

// Render list options
$v_notif_d_preview->RenderListOptions();

// Render list options (header, left)
$v_notif_d_preview->ListOptions->Render("header", "left");
?>
<?php if ($v_notif_d->id->Visible) { // id ?>
	<?php if ($v_notif_d->SortUrl($v_notif_d->id) == "") { ?>
		<th class="<?php echo $v_notif_d->id->HeaderCellClass() ?>"><?php echo $v_notif_d->id->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $v_notif_d->id->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $v_notif_d->id->FldName ?>" data-sort-order="<?php echo $v_notif_d_preview->SortField == $v_notif_d->id->FldName && $v_notif_d_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $v_notif_d->id->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($v_notif_d_preview->SortField == $v_notif_d->id->FldName) { ?><?php if ($v_notif_d_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_notif_d_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_notif_d->employee_id->Visible) { // employee_id ?>
	<?php if ($v_notif_d->SortUrl($v_notif_d->employee_id) == "") { ?>
		<th class="<?php echo $v_notif_d->employee_id->HeaderCellClass() ?>"><?php echo $v_notif_d->employee_id->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $v_notif_d->employee_id->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $v_notif_d->employee_id->FldName ?>" data-sort-order="<?php echo $v_notif_d_preview->SortField == $v_notif_d->employee_id->FldName && $v_notif_d_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $v_notif_d->employee_id->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($v_notif_d_preview->SortField == $v_notif_d->employee_id->FldName) { ?><?php if ($v_notif_d_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_notif_d_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_notif_d->bagian->Visible) { // bagian ?>
	<?php if ($v_notif_d->SortUrl($v_notif_d->bagian) == "") { ?>
		<th class="<?php echo $v_notif_d->bagian->HeaderCellClass() ?>"><?php echo $v_notif_d->bagian->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $v_notif_d->bagian->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $v_notif_d->bagian->FldName ?>" data-sort-order="<?php echo $v_notif_d_preview->SortField == $v_notif_d->bagian->FldName && $v_notif_d_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $v_notif_d->bagian->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($v_notif_d_preview->SortField == $v_notif_d->bagian->FldName) { ?><?php if ($v_notif_d_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_notif_d_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_notif_d->lokasi_kerja->Visible) { // lokasi_kerja ?>
	<?php if ($v_notif_d->SortUrl($v_notif_d->lokasi_kerja) == "") { ?>
		<th class="<?php echo $v_notif_d->lokasi_kerja->HeaderCellClass() ?>"><?php echo $v_notif_d->lokasi_kerja->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $v_notif_d->lokasi_kerja->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $v_notif_d->lokasi_kerja->FldName ?>" data-sort-order="<?php echo $v_notif_d_preview->SortField == $v_notif_d->lokasi_kerja->FldName && $v_notif_d_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $v_notif_d->lokasi_kerja->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($v_notif_d_preview->SortField == $v_notif_d->lokasi_kerja->FldName) { ?><?php if ($v_notif_d_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_notif_d_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_notif_d->status->Visible) { // status ?>
	<?php if ($v_notif_d->SortUrl($v_notif_d->status) == "") { ?>
		<th class="<?php echo $v_notif_d->status->HeaderCellClass() ?>"><?php echo $v_notif_d->status->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $v_notif_d->status->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $v_notif_d->status->FldName ?>" data-sort-order="<?php echo $v_notif_d_preview->SortField == $v_notif_d->status->FldName && $v_notif_d_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $v_notif_d->status->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($v_notif_d_preview->SortField == $v_notif_d->status->FldName) { ?><?php if ($v_notif_d_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_notif_d_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$v_notif_d_preview->ListOptions->Render("header", "right");
?>
		</tr>
	</thead>
	<tbody><!-- Table body -->
<?php
$v_notif_d_preview->RecCount = 0;
$v_notif_d_preview->RowCnt = 0;
while ($v_notif_d_preview->Recordset && !$v_notif_d_preview->Recordset->EOF) {

	// Init row class and style
	$v_notif_d_preview->RecCount++;
	$v_notif_d_preview->RowCnt++;
	$v_notif_d_preview->CssStyle = "";
	$v_notif_d_preview->LoadListRowValues($v_notif_d_preview->Recordset);

	// Render row
	$v_notif_d_preview->RowType = EW_ROWTYPE_PREVIEW; // Preview record
	$v_notif_d_preview->ResetAttrs();
	$v_notif_d_preview->RenderListRow();

	// Render list options
	$v_notif_d_preview->RenderListOptions();
?>
	<tr<?php echo $v_notif_d_preview->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_notif_d_preview->ListOptions->Render("body", "left", $v_notif_d_preview->RowCnt);
?>
<?php if ($v_notif_d->id->Visible) { // id ?>
		<!-- id -->
		<td<?php echo $v_notif_d->id->CellAttributes() ?>>
<span<?php echo $v_notif_d->id->ViewAttributes() ?>>
<?php echo $v_notif_d->id->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($v_notif_d->employee_id->Visible) { // employee_id ?>
		<!-- employee_id -->
		<td<?php echo $v_notif_d->employee_id->CellAttributes() ?>>
<span<?php echo $v_notif_d->employee_id->ViewAttributes() ?>>
<?php echo $v_notif_d->employee_id->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($v_notif_d->bagian->Visible) { // bagian ?>
		<!-- bagian -->
		<td<?php echo $v_notif_d->bagian->CellAttributes() ?>>
<span<?php echo $v_notif_d->bagian->ViewAttributes() ?>>
<?php echo $v_notif_d->bagian->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($v_notif_d->lokasi_kerja->Visible) { // lokasi_kerja ?>
		<!-- lokasi_kerja -->
		<td<?php echo $v_notif_d->lokasi_kerja->CellAttributes() ?>>
<span<?php echo $v_notif_d->lokasi_kerja->ViewAttributes() ?>>
<?php echo $v_notif_d->lokasi_kerja->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($v_notif_d->status->Visible) { // status ?>
		<!-- status -->
		<td<?php echo $v_notif_d->status->CellAttributes() ?>>
<span<?php echo $v_notif_d->status->ViewAttributes() ?>>
<?php echo $v_notif_d->status->ListViewValue() ?></span>
</td>
<?php } ?>
<?php

// Render list options (body, right)
$v_notif_d_preview->ListOptions->Render("body", "right", $v_notif_d_preview->RowCnt);
?>
	</tr>
<?php
	$v_notif_d_preview->Recordset->MoveNext();
}
?>
	</tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<?php } ?>
<div class="box-footer ewGridLowerPanel ewPreviewLowerPanel"><!-- .box-footer -->
<?php if ($v_notif_d_preview->TotalRecs > 0) { ?>
<?php if (!isset($v_notif_d_preview->Pager)) $v_notif_d_preview->Pager = new cPrevNextPager($v_notif_d_preview->StartRec, $v_notif_d_preview->DisplayRecs, $v_notif_d_preview->TotalRecs) ?>
<?php if ($v_notif_d_preview->Pager->RecordCount > 0 && $v_notif_d_preview->Pager->Visible) { ?>
<div class="ewPager"><div class="ewPrevNext"><div class="btn-group">
<!--first page button-->
	<?php if ($v_notif_d_preview->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" data-start="<?php echo $v_notif_d_preview->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($v_notif_d_preview->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" data-start="<?php echo $v_notif_d_preview->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
<!--next page button-->
	<?php if ($v_notif_d_preview->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" data-start="<?php echo $v_notif_d_preview->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($v_notif_d_preview->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" data-start="<?php echo $v_notif_d_preview->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div></div></div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $v_notif_d_preview->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $v_notif_d_preview->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $v_notif_d_preview->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php } else { ?>
<div class="ewDetailCount"><?php echo $Language->Phrase("NoRecord") ?></div>
<?php } ?>
<div class="ewPreviewOtherOptions">
<?php
	foreach ($v_notif_d_preview->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div><!-- /.box-footer -->
</div><!-- /.box -->
<?php
$v_notif_d_preview->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
if ($v_notif_d_preview->Recordset)
	$v_notif_d_preview->Recordset->Close();

// Output
$content = ob_get_contents();
ob_end_clean();
echo ew_ConvertToUtf8($content);
?>
<?php
$v_notif_d_preview->Page_Terminate();
?>
