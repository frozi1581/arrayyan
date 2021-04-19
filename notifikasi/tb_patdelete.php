<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tb_patinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tb_pat_delete = NULL; // Initialize page object first

class ctb_pat_delete extends ctb_pat {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'tb_pat';

	// Page object name
	var $PageObjName = 'tb_pat_delete';

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

		// Table object (tb_pat)
		if (!isset($GLOBALS["tb_pat"]) || get_class($GLOBALS["tb_pat"]) == "ctb_pat") {
			$GLOBALS["tb_pat"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_pat"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_pat', TRUE);

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
		$this->KD_PAT->SetVisibility();
		$this->KET->SetVisibility();
		$this->ALAMAT->SetVisibility();
		$this->KOTA->SetVisibility();
		$this->SINGKATAN->SetVisibility();
		$this->CREATED_BY->SetVisibility();
		$this->CREATED_DATE->SetVisibility();
		$this->LAST_UPDATE_BY->SetVisibility();
		$this->LAST_UPDATE_DATE->SetVisibility();

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
		global $EW_EXPORT, $tb_pat;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_pat);
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
			$this->Page_Terminate("tb_patlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tb_pat class, tb_patinfo.php

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
				$this->Page_Terminate("tb_patlist.php"); // Return to list
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
		$this->KD_PAT->setDbValue($row['KD_PAT']);
		$this->KET->setDbValue($row['KET']);
		$this->ALAMAT->setDbValue($row['ALAMAT']);
		$this->KOTA->setDbValue($row['KOTA']);
		$this->SINGKATAN->setDbValue($row['SINGKATAN']);
		$this->CREATED_BY->setDbValue($row['CREATED_BY']);
		$this->CREATED_DATE->setDbValue($row['CREATED_DATE']);
		$this->LAST_UPDATE_BY->setDbValue($row['LAST_UPDATE_BY']);
		$this->LAST_UPDATE_DATE->setDbValue($row['LAST_UPDATE_DATE']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['KD_PAT'] = NULL;
		$row['KET'] = NULL;
		$row['ALAMAT'] = NULL;
		$row['KOTA'] = NULL;
		$row['SINGKATAN'] = NULL;
		$row['CREATED_BY'] = NULL;
		$row['CREATED_DATE'] = NULL;
		$row['LAST_UPDATE_BY'] = NULL;
		$row['LAST_UPDATE_DATE'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->KD_PAT->DbValue = $row['KD_PAT'];
		$this->KET->DbValue = $row['KET'];
		$this->ALAMAT->DbValue = $row['ALAMAT'];
		$this->KOTA->DbValue = $row['KOTA'];
		$this->SINGKATAN->DbValue = $row['SINGKATAN'];
		$this->CREATED_BY->DbValue = $row['CREATED_BY'];
		$this->CREATED_DATE->DbValue = $row['CREATED_DATE'];
		$this->LAST_UPDATE_BY->DbValue = $row['LAST_UPDATE_BY'];
		$this->LAST_UPDATE_DATE->DbValue = $row['LAST_UPDATE_DATE'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// KD_PAT
		// KET
		// ALAMAT
		// KOTA
		// SINGKATAN
		// CREATED_BY
		// CREATED_DATE
		// LAST_UPDATE_BY
		// LAST_UPDATE_DATE

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// KD_PAT
		$this->KD_PAT->ViewValue = $this->KD_PAT->CurrentValue;
		$this->KD_PAT->ViewCustomAttributes = "";

		// KET
		$this->KET->ViewValue = $this->KET->CurrentValue;
		$this->KET->ViewCustomAttributes = "";

		// ALAMAT
		$this->ALAMAT->ViewValue = $this->ALAMAT->CurrentValue;
		$this->ALAMAT->ViewCustomAttributes = "";

		// KOTA
		$this->KOTA->ViewValue = $this->KOTA->CurrentValue;
		$this->KOTA->ViewCustomAttributes = "";

		// SINGKATAN
		$this->SINGKATAN->ViewValue = $this->SINGKATAN->CurrentValue;
		$this->SINGKATAN->ViewCustomAttributes = "";

		// CREATED_BY
		$this->CREATED_BY->ViewValue = $this->CREATED_BY->CurrentValue;
		$this->CREATED_BY->ViewCustomAttributes = "";

		// CREATED_DATE
		$this->CREATED_DATE->ViewValue = $this->CREATED_DATE->CurrentValue;
		$this->CREATED_DATE->ViewValue = ew_FormatDateTime($this->CREATED_DATE->ViewValue, 0);
		$this->CREATED_DATE->ViewCustomAttributes = "";

		// LAST_UPDATE_BY
		$this->LAST_UPDATE_BY->ViewValue = $this->LAST_UPDATE_BY->CurrentValue;
		$this->LAST_UPDATE_BY->ViewCustomAttributes = "";

		// LAST_UPDATE_DATE
		$this->LAST_UPDATE_DATE->ViewValue = $this->LAST_UPDATE_DATE->CurrentValue;
		$this->LAST_UPDATE_DATE->ViewValue = ew_FormatDateTime($this->LAST_UPDATE_DATE->ViewValue, 0);
		$this->LAST_UPDATE_DATE->ViewCustomAttributes = "";

			// KD_PAT
			$this->KD_PAT->LinkCustomAttributes = "";
			$this->KD_PAT->HrefValue = "";
			$this->KD_PAT->TooltipValue = "";

			// KET
			$this->KET->LinkCustomAttributes = "";
			$this->KET->HrefValue = "";
			$this->KET->TooltipValue = "";

			// ALAMAT
			$this->ALAMAT->LinkCustomAttributes = "";
			$this->ALAMAT->HrefValue = "";
			$this->ALAMAT->TooltipValue = "";

			// KOTA
			$this->KOTA->LinkCustomAttributes = "";
			$this->KOTA->HrefValue = "";
			$this->KOTA->TooltipValue = "";

			// SINGKATAN
			$this->SINGKATAN->LinkCustomAttributes = "";
			$this->SINGKATAN->HrefValue = "";
			$this->SINGKATAN->TooltipValue = "";

			// CREATED_BY
			$this->CREATED_BY->LinkCustomAttributes = "";
			$this->CREATED_BY->HrefValue = "";
			$this->CREATED_BY->TooltipValue = "";

			// CREATED_DATE
			$this->CREATED_DATE->LinkCustomAttributes = "";
			$this->CREATED_DATE->HrefValue = "";
			$this->CREATED_DATE->TooltipValue = "";

			// LAST_UPDATE_BY
			$this->LAST_UPDATE_BY->LinkCustomAttributes = "";
			$this->LAST_UPDATE_BY->HrefValue = "";
			$this->LAST_UPDATE_BY->TooltipValue = "";

			// LAST_UPDATE_DATE
			$this->LAST_UPDATE_DATE->LinkCustomAttributes = "";
			$this->LAST_UPDATE_DATE->HrefValue = "";
			$this->LAST_UPDATE_DATE->TooltipValue = "";
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
				$sThisKey .= $row['KD_PAT'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_patlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($tb_pat_delete)) $tb_pat_delete = new ctb_pat_delete();

// Page init
$tb_pat_delete->Page_Init();

// Page main
$tb_pat_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_pat_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ftb_patdelete = new ew_Form("ftb_patdelete", "delete");

// Form_CustomValidate event
ftb_patdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftb_patdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tb_pat_delete->ShowPageHeader(); ?>
<?php
$tb_pat_delete->ShowMessage();
?>
<form name="ftb_patdelete" id="ftb_patdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_pat_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_pat_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_pat">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tb_pat_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($tb_pat->KD_PAT->Visible) { // KD_PAT ?>
		<th class="<?php echo $tb_pat->KD_PAT->HeaderCellClass() ?>"><span id="elh_tb_pat_KD_PAT" class="tb_pat_KD_PAT"><?php echo $tb_pat->KD_PAT->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_pat->KET->Visible) { // KET ?>
		<th class="<?php echo $tb_pat->KET->HeaderCellClass() ?>"><span id="elh_tb_pat_KET" class="tb_pat_KET"><?php echo $tb_pat->KET->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_pat->ALAMAT->Visible) { // ALAMAT ?>
		<th class="<?php echo $tb_pat->ALAMAT->HeaderCellClass() ?>"><span id="elh_tb_pat_ALAMAT" class="tb_pat_ALAMAT"><?php echo $tb_pat->ALAMAT->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_pat->KOTA->Visible) { // KOTA ?>
		<th class="<?php echo $tb_pat->KOTA->HeaderCellClass() ?>"><span id="elh_tb_pat_KOTA" class="tb_pat_KOTA"><?php echo $tb_pat->KOTA->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_pat->SINGKATAN->Visible) { // SINGKATAN ?>
		<th class="<?php echo $tb_pat->SINGKATAN->HeaderCellClass() ?>"><span id="elh_tb_pat_SINGKATAN" class="tb_pat_SINGKATAN"><?php echo $tb_pat->SINGKATAN->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_pat->CREATED_BY->Visible) { // CREATED_BY ?>
		<th class="<?php echo $tb_pat->CREATED_BY->HeaderCellClass() ?>"><span id="elh_tb_pat_CREATED_BY" class="tb_pat_CREATED_BY"><?php echo $tb_pat->CREATED_BY->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_pat->CREATED_DATE->Visible) { // CREATED_DATE ?>
		<th class="<?php echo $tb_pat->CREATED_DATE->HeaderCellClass() ?>"><span id="elh_tb_pat_CREATED_DATE" class="tb_pat_CREATED_DATE"><?php echo $tb_pat->CREATED_DATE->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_pat->LAST_UPDATE_BY->Visible) { // LAST_UPDATE_BY ?>
		<th class="<?php echo $tb_pat->LAST_UPDATE_BY->HeaderCellClass() ?>"><span id="elh_tb_pat_LAST_UPDATE_BY" class="tb_pat_LAST_UPDATE_BY"><?php echo $tb_pat->LAST_UPDATE_BY->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_pat->LAST_UPDATE_DATE->Visible) { // LAST_UPDATE_DATE ?>
		<th class="<?php echo $tb_pat->LAST_UPDATE_DATE->HeaderCellClass() ?>"><span id="elh_tb_pat_LAST_UPDATE_DATE" class="tb_pat_LAST_UPDATE_DATE"><?php echo $tb_pat->LAST_UPDATE_DATE->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tb_pat_delete->RecCnt = 0;
$i = 0;
while (!$tb_pat_delete->Recordset->EOF) {
	$tb_pat_delete->RecCnt++;
	$tb_pat_delete->RowCnt++;

	// Set row properties
	$tb_pat->ResetAttrs();
	$tb_pat->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tb_pat_delete->LoadRowValues($tb_pat_delete->Recordset);

	// Render row
	$tb_pat_delete->RenderRow();
?>
	<tr<?php echo $tb_pat->RowAttributes() ?>>
<?php if ($tb_pat->KD_PAT->Visible) { // KD_PAT ?>
		<td<?php echo $tb_pat->KD_PAT->CellAttributes() ?>>
<span id="el<?php echo $tb_pat_delete->RowCnt ?>_tb_pat_KD_PAT" class="tb_pat_KD_PAT">
<span<?php echo $tb_pat->KD_PAT->ViewAttributes() ?>>
<?php echo $tb_pat->KD_PAT->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_pat->KET->Visible) { // KET ?>
		<td<?php echo $tb_pat->KET->CellAttributes() ?>>
<span id="el<?php echo $tb_pat_delete->RowCnt ?>_tb_pat_KET" class="tb_pat_KET">
<span<?php echo $tb_pat->KET->ViewAttributes() ?>>
<?php echo $tb_pat->KET->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_pat->ALAMAT->Visible) { // ALAMAT ?>
		<td<?php echo $tb_pat->ALAMAT->CellAttributes() ?>>
<span id="el<?php echo $tb_pat_delete->RowCnt ?>_tb_pat_ALAMAT" class="tb_pat_ALAMAT">
<span<?php echo $tb_pat->ALAMAT->ViewAttributes() ?>>
<?php echo $tb_pat->ALAMAT->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_pat->KOTA->Visible) { // KOTA ?>
		<td<?php echo $tb_pat->KOTA->CellAttributes() ?>>
<span id="el<?php echo $tb_pat_delete->RowCnt ?>_tb_pat_KOTA" class="tb_pat_KOTA">
<span<?php echo $tb_pat->KOTA->ViewAttributes() ?>>
<?php echo $tb_pat->KOTA->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_pat->SINGKATAN->Visible) { // SINGKATAN ?>
		<td<?php echo $tb_pat->SINGKATAN->CellAttributes() ?>>
<span id="el<?php echo $tb_pat_delete->RowCnt ?>_tb_pat_SINGKATAN" class="tb_pat_SINGKATAN">
<span<?php echo $tb_pat->SINGKATAN->ViewAttributes() ?>>
<?php echo $tb_pat->SINGKATAN->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_pat->CREATED_BY->Visible) { // CREATED_BY ?>
		<td<?php echo $tb_pat->CREATED_BY->CellAttributes() ?>>
<span id="el<?php echo $tb_pat_delete->RowCnt ?>_tb_pat_CREATED_BY" class="tb_pat_CREATED_BY">
<span<?php echo $tb_pat->CREATED_BY->ViewAttributes() ?>>
<?php echo $tb_pat->CREATED_BY->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_pat->CREATED_DATE->Visible) { // CREATED_DATE ?>
		<td<?php echo $tb_pat->CREATED_DATE->CellAttributes() ?>>
<span id="el<?php echo $tb_pat_delete->RowCnt ?>_tb_pat_CREATED_DATE" class="tb_pat_CREATED_DATE">
<span<?php echo $tb_pat->CREATED_DATE->ViewAttributes() ?>>
<?php echo $tb_pat->CREATED_DATE->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_pat->LAST_UPDATE_BY->Visible) { // LAST_UPDATE_BY ?>
		<td<?php echo $tb_pat->LAST_UPDATE_BY->CellAttributes() ?>>
<span id="el<?php echo $tb_pat_delete->RowCnt ?>_tb_pat_LAST_UPDATE_BY" class="tb_pat_LAST_UPDATE_BY">
<span<?php echo $tb_pat->LAST_UPDATE_BY->ViewAttributes() ?>>
<?php echo $tb_pat->LAST_UPDATE_BY->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_pat->LAST_UPDATE_DATE->Visible) { // LAST_UPDATE_DATE ?>
		<td<?php echo $tb_pat->LAST_UPDATE_DATE->CellAttributes() ?>>
<span id="el<?php echo $tb_pat_delete->RowCnt ?>_tb_pat_LAST_UPDATE_DATE" class="tb_pat_LAST_UPDATE_DATE">
<span<?php echo $tb_pat->LAST_UPDATE_DATE->ViewAttributes() ?>>
<?php echo $tb_pat->LAST_UPDATE_DATE->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tb_pat_delete->Recordset->MoveNext();
}
$tb_pat_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_pat_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ftb_patdelete.Init();
</script>
<?php
$tb_pat_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_pat_delete->Page_Terminate();
?>
