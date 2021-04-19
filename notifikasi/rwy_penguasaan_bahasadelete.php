<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "rwy_penguasaan_bahasainfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$rwy_penguasaan_bahasa_delete = NULL; // Initialize page object first

class crwy_penguasaan_bahasa_delete extends crwy_penguasaan_bahasa {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'rwy_penguasaan_bahasa';

	// Page object name
	var $PageObjName = 'rwy_penguasaan_bahasa_delete';

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

		// Table object (rwy_penguasaan_bahasa)
		if (!isset($GLOBALS["rwy_penguasaan_bahasa"]) || get_class($GLOBALS["rwy_penguasaan_bahasa"]) == "crwy_penguasaan_bahasa") {
			$GLOBALS["rwy_penguasaan_bahasa"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["rwy_penguasaan_bahasa"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rwy_penguasaan_bahasa', TRUE);

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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->nip->SetVisibility();
		$this->nama_bahasa->SetVisibility();
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
		global $EW_EXPORT, $rwy_penguasaan_bahasa;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($rwy_penguasaan_bahasa);
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("rwy_penguasaan_bahasalist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in rwy_penguasaan_bahasa class, rwy_penguasaan_bahasainfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("rwy_penguasaan_bahasalist.php"); // Return to list
			}
		}
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
		$this->nama_bahasa->setDbValue($row['nama_bahasa']);
		$this->stat_validasi->setDbValue($row['stat_validasi']);
		$this->change_date->setDbValue($row['change_date']);
		$this->change_by->setDbValue($row['change_by']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['nip'] = NULL;
		$row['nama_bahasa'] = NULL;
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
		$this->nama_bahasa->DbValue = $row['nama_bahasa'];
		$this->stat_validasi->DbValue = $row['stat_validasi'];
		$this->change_date->DbValue = $row['change_date'];
		$this->change_by->DbValue = $row['change_by'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// nip
		// nama_bahasa
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

		// nama_bahasa
		$this->nama_bahasa->ViewValue = $this->nama_bahasa->CurrentValue;
		$this->nama_bahasa->ViewCustomAttributes = "";

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

			// nama_bahasa
			$this->nama_bahasa->LinkCustomAttributes = "";
			$this->nama_bahasa->HrefValue = "";
			$this->nama_bahasa->TooltipValue = "";

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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("rwy_penguasaan_bahasalist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($rwy_penguasaan_bahasa_delete)) $rwy_penguasaan_bahasa_delete = new crwy_penguasaan_bahasa_delete();

// Page init
$rwy_penguasaan_bahasa_delete->Page_Init();

// Page main
$rwy_penguasaan_bahasa_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$rwy_penguasaan_bahasa_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = frwy_penguasaan_bahasadelete = new ew_Form("frwy_penguasaan_bahasadelete", "delete");

// Form_CustomValidate event
frwy_penguasaan_bahasadelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
frwy_penguasaan_bahasadelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $rwy_penguasaan_bahasa_delete->ShowPageHeader(); ?>
<?php
$rwy_penguasaan_bahasa_delete->ShowMessage();
?>
<form name="frwy_penguasaan_bahasadelete" id="frwy_penguasaan_bahasadelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($rwy_penguasaan_bahasa_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $rwy_penguasaan_bahasa_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="rwy_penguasaan_bahasa">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($rwy_penguasaan_bahasa_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($rwy_penguasaan_bahasa->id->Visible) { // id ?>
		<th class="<?php echo $rwy_penguasaan_bahasa->id->HeaderCellClass() ?>"><span id="elh_rwy_penguasaan_bahasa_id" class="rwy_penguasaan_bahasa_id"><?php echo $rwy_penguasaan_bahasa->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_penguasaan_bahasa->nip->Visible) { // nip ?>
		<th class="<?php echo $rwy_penguasaan_bahasa->nip->HeaderCellClass() ?>"><span id="elh_rwy_penguasaan_bahasa_nip" class="rwy_penguasaan_bahasa_nip"><?php echo $rwy_penguasaan_bahasa->nip->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_penguasaan_bahasa->nama_bahasa->Visible) { // nama_bahasa ?>
		<th class="<?php echo $rwy_penguasaan_bahasa->nama_bahasa->HeaderCellClass() ?>"><span id="elh_rwy_penguasaan_bahasa_nama_bahasa" class="rwy_penguasaan_bahasa_nama_bahasa"><?php echo $rwy_penguasaan_bahasa->nama_bahasa->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_penguasaan_bahasa->stat_validasi->Visible) { // stat_validasi ?>
		<th class="<?php echo $rwy_penguasaan_bahasa->stat_validasi->HeaderCellClass() ?>"><span id="elh_rwy_penguasaan_bahasa_stat_validasi" class="rwy_penguasaan_bahasa_stat_validasi"><?php echo $rwy_penguasaan_bahasa->stat_validasi->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_penguasaan_bahasa->change_date->Visible) { // change_date ?>
		<th class="<?php echo $rwy_penguasaan_bahasa->change_date->HeaderCellClass() ?>"><span id="elh_rwy_penguasaan_bahasa_change_date" class="rwy_penguasaan_bahasa_change_date"><?php echo $rwy_penguasaan_bahasa->change_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_penguasaan_bahasa->change_by->Visible) { // change_by ?>
		<th class="<?php echo $rwy_penguasaan_bahasa->change_by->HeaderCellClass() ?>"><span id="elh_rwy_penguasaan_bahasa_change_by" class="rwy_penguasaan_bahasa_change_by"><?php echo $rwy_penguasaan_bahasa->change_by->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$rwy_penguasaan_bahasa_delete->RecCnt = 0;
$i = 0;
while (!$rwy_penguasaan_bahasa_delete->Recordset->EOF) {
	$rwy_penguasaan_bahasa_delete->RecCnt++;
	$rwy_penguasaan_bahasa_delete->RowCnt++;

	// Set row properties
	$rwy_penguasaan_bahasa->ResetAttrs();
	$rwy_penguasaan_bahasa->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$rwy_penguasaan_bahasa_delete->LoadRowValues($rwy_penguasaan_bahasa_delete->Recordset);

	// Render row
	$rwy_penguasaan_bahasa_delete->RenderRow();
?>
	<tr<?php echo $rwy_penguasaan_bahasa->RowAttributes() ?>>
<?php if ($rwy_penguasaan_bahasa->id->Visible) { // id ?>
		<td<?php echo $rwy_penguasaan_bahasa->id->CellAttributes() ?>>
<span id="el<?php echo $rwy_penguasaan_bahasa_delete->RowCnt ?>_rwy_penguasaan_bahasa_id" class="rwy_penguasaan_bahasa_id">
<span<?php echo $rwy_penguasaan_bahasa->id->ViewAttributes() ?>>
<?php echo $rwy_penguasaan_bahasa->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_penguasaan_bahasa->nip->Visible) { // nip ?>
		<td<?php echo $rwy_penguasaan_bahasa->nip->CellAttributes() ?>>
<span id="el<?php echo $rwy_penguasaan_bahasa_delete->RowCnt ?>_rwy_penguasaan_bahasa_nip" class="rwy_penguasaan_bahasa_nip">
<span<?php echo $rwy_penguasaan_bahasa->nip->ViewAttributes() ?>>
<?php echo $rwy_penguasaan_bahasa->nip->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_penguasaan_bahasa->nama_bahasa->Visible) { // nama_bahasa ?>
		<td<?php echo $rwy_penguasaan_bahasa->nama_bahasa->CellAttributes() ?>>
<span id="el<?php echo $rwy_penguasaan_bahasa_delete->RowCnt ?>_rwy_penguasaan_bahasa_nama_bahasa" class="rwy_penguasaan_bahasa_nama_bahasa">
<span<?php echo $rwy_penguasaan_bahasa->nama_bahasa->ViewAttributes() ?>>
<?php echo $rwy_penguasaan_bahasa->nama_bahasa->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_penguasaan_bahasa->stat_validasi->Visible) { // stat_validasi ?>
		<td<?php echo $rwy_penguasaan_bahasa->stat_validasi->CellAttributes() ?>>
<span id="el<?php echo $rwy_penguasaan_bahasa_delete->RowCnt ?>_rwy_penguasaan_bahasa_stat_validasi" class="rwy_penguasaan_bahasa_stat_validasi">
<span<?php echo $rwy_penguasaan_bahasa->stat_validasi->ViewAttributes() ?>>
<?php echo $rwy_penguasaan_bahasa->stat_validasi->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_penguasaan_bahasa->change_date->Visible) { // change_date ?>
		<td<?php echo $rwy_penguasaan_bahasa->change_date->CellAttributes() ?>>
<span id="el<?php echo $rwy_penguasaan_bahasa_delete->RowCnt ?>_rwy_penguasaan_bahasa_change_date" class="rwy_penguasaan_bahasa_change_date">
<span<?php echo $rwy_penguasaan_bahasa->change_date->ViewAttributes() ?>>
<?php echo $rwy_penguasaan_bahasa->change_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_penguasaan_bahasa->change_by->Visible) { // change_by ?>
		<td<?php echo $rwy_penguasaan_bahasa->change_by->CellAttributes() ?>>
<span id="el<?php echo $rwy_penguasaan_bahasa_delete->RowCnt ?>_rwy_penguasaan_bahasa_change_by" class="rwy_penguasaan_bahasa_change_by">
<span<?php echo $rwy_penguasaan_bahasa->change_by->ViewAttributes() ?>>
<?php echo $rwy_penguasaan_bahasa->change_by->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$rwy_penguasaan_bahasa_delete->Recordset->MoveNext();
}
$rwy_penguasaan_bahasa_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $rwy_penguasaan_bahasa_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
frwy_penguasaan_bahasadelete.Init();
</script>
<?php
$rwy_penguasaan_bahasa_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$rwy_penguasaan_bahasa_delete->Page_Terminate();
?>
