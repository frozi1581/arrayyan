<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ciri_ciri_jasmaniinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$ciri_ciri_jasmani_delete = NULL; // Initialize page object first

class cciri_ciri_jasmani_delete extends cciri_ciri_jasmani {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'ciri_ciri_jasmani';

	// Page object name
	var $PageObjName = 'ciri_ciri_jasmani_delete';

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

		// Table object (ciri_ciri_jasmani)
		if (!isset($GLOBALS["ciri_ciri_jasmani"]) || get_class($GLOBALS["ciri_ciri_jasmani"]) == "cciri_ciri_jasmani") {
			$GLOBALS["ciri_ciri_jasmani"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ciri_ciri_jasmani"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ciri_ciri_jasmani', TRUE);

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
		$this->tinggi_badan->SetVisibility();
		$this->berat->SetVisibility();
		$this->bentuk_hidung->SetVisibility();
		$this->bentuk_muka->SetVisibility();
		$this->warna_kulit->SetVisibility();
		$this->warna_rambut->SetVisibility();
		$this->hobi->SetVisibility();
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
		global $EW_EXPORT, $ciri_ciri_jasmani;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ciri_ciri_jasmani);
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
			$this->Page_Terminate("ciri_ciri_jasmanilist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in ciri_ciri_jasmani class, ciri_ciri_jasmaniinfo.php

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
				$this->Page_Terminate("ciri_ciri_jasmanilist.php"); // Return to list
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
		$this->tinggi_badan->setDbValue($row['tinggi_badan']);
		$this->berat->setDbValue($row['berat']);
		$this->bentuk_hidung->setDbValue($row['bentuk_hidung']);
		$this->bentuk_muka->setDbValue($row['bentuk_muka']);
		$this->warna_kulit->setDbValue($row['warna_kulit']);
		$this->warna_rambut->setDbValue($row['warna_rambut']);
		$this->hobi->setDbValue($row['hobi']);
		$this->stat_validasi->setDbValue($row['stat_validasi']);
		$this->change_date->setDbValue($row['change_date']);
		$this->change_by->setDbValue($row['change_by']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['nip'] = NULL;
		$row['tinggi_badan'] = NULL;
		$row['berat'] = NULL;
		$row['bentuk_hidung'] = NULL;
		$row['bentuk_muka'] = NULL;
		$row['warna_kulit'] = NULL;
		$row['warna_rambut'] = NULL;
		$row['hobi'] = NULL;
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
		$this->tinggi_badan->DbValue = $row['tinggi_badan'];
		$this->berat->DbValue = $row['berat'];
		$this->bentuk_hidung->DbValue = $row['bentuk_hidung'];
		$this->bentuk_muka->DbValue = $row['bentuk_muka'];
		$this->warna_kulit->DbValue = $row['warna_kulit'];
		$this->warna_rambut->DbValue = $row['warna_rambut'];
		$this->hobi->DbValue = $row['hobi'];
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
		// tinggi_badan
		// berat
		// bentuk_hidung
		// bentuk_muka
		// warna_kulit
		// warna_rambut
		// hobi
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

		// tinggi_badan
		$this->tinggi_badan->ViewValue = $this->tinggi_badan->CurrentValue;
		$this->tinggi_badan->ViewCustomAttributes = "";

		// berat
		$this->berat->ViewValue = $this->berat->CurrentValue;
		$this->berat->ViewCustomAttributes = "";

		// bentuk_hidung
		$this->bentuk_hidung->ViewValue = $this->bentuk_hidung->CurrentValue;
		$this->bentuk_hidung->ViewCustomAttributes = "";

		// bentuk_muka
		$this->bentuk_muka->ViewValue = $this->bentuk_muka->CurrentValue;
		$this->bentuk_muka->ViewCustomAttributes = "";

		// warna_kulit
		$this->warna_kulit->ViewValue = $this->warna_kulit->CurrentValue;
		$this->warna_kulit->ViewCustomAttributes = "";

		// warna_rambut
		$this->warna_rambut->ViewValue = $this->warna_rambut->CurrentValue;
		$this->warna_rambut->ViewCustomAttributes = "";

		// hobi
		$this->hobi->ViewValue = $this->hobi->CurrentValue;
		$this->hobi->ViewCustomAttributes = "";

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

			// tinggi_badan
			$this->tinggi_badan->LinkCustomAttributes = "";
			$this->tinggi_badan->HrefValue = "";
			$this->tinggi_badan->TooltipValue = "";

			// berat
			$this->berat->LinkCustomAttributes = "";
			$this->berat->HrefValue = "";
			$this->berat->TooltipValue = "";

			// bentuk_hidung
			$this->bentuk_hidung->LinkCustomAttributes = "";
			$this->bentuk_hidung->HrefValue = "";
			$this->bentuk_hidung->TooltipValue = "";

			// bentuk_muka
			$this->bentuk_muka->LinkCustomAttributes = "";
			$this->bentuk_muka->HrefValue = "";
			$this->bentuk_muka->TooltipValue = "";

			// warna_kulit
			$this->warna_kulit->LinkCustomAttributes = "";
			$this->warna_kulit->HrefValue = "";
			$this->warna_kulit->TooltipValue = "";

			// warna_rambut
			$this->warna_rambut->LinkCustomAttributes = "";
			$this->warna_rambut->HrefValue = "";
			$this->warna_rambut->TooltipValue = "";

			// hobi
			$this->hobi->LinkCustomAttributes = "";
			$this->hobi->HrefValue = "";
			$this->hobi->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ciri_ciri_jasmanilist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ciri_ciri_jasmani_delete)) $ciri_ciri_jasmani_delete = new cciri_ciri_jasmani_delete();

// Page init
$ciri_ciri_jasmani_delete->Page_Init();

// Page main
$ciri_ciri_jasmani_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ciri_ciri_jasmani_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fciri_ciri_jasmanidelete = new ew_Form("fciri_ciri_jasmanidelete", "delete");

// Form_CustomValidate event
fciri_ciri_jasmanidelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fciri_ciri_jasmanidelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $ciri_ciri_jasmani_delete->ShowPageHeader(); ?>
<?php
$ciri_ciri_jasmani_delete->ShowMessage();
?>
<form name="fciri_ciri_jasmanidelete" id="fciri_ciri_jasmanidelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ciri_ciri_jasmani_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ciri_ciri_jasmani_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ciri_ciri_jasmani">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($ciri_ciri_jasmani_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($ciri_ciri_jasmani->id->Visible) { // id ?>
		<th class="<?php echo $ciri_ciri_jasmani->id->HeaderCellClass() ?>"><span id="elh_ciri_ciri_jasmani_id" class="ciri_ciri_jasmani_id"><?php echo $ciri_ciri_jasmani->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ciri_ciri_jasmani->nip->Visible) { // nip ?>
		<th class="<?php echo $ciri_ciri_jasmani->nip->HeaderCellClass() ?>"><span id="elh_ciri_ciri_jasmani_nip" class="ciri_ciri_jasmani_nip"><?php echo $ciri_ciri_jasmani->nip->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ciri_ciri_jasmani->tinggi_badan->Visible) { // tinggi_badan ?>
		<th class="<?php echo $ciri_ciri_jasmani->tinggi_badan->HeaderCellClass() ?>"><span id="elh_ciri_ciri_jasmani_tinggi_badan" class="ciri_ciri_jasmani_tinggi_badan"><?php echo $ciri_ciri_jasmani->tinggi_badan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ciri_ciri_jasmani->berat->Visible) { // berat ?>
		<th class="<?php echo $ciri_ciri_jasmani->berat->HeaderCellClass() ?>"><span id="elh_ciri_ciri_jasmani_berat" class="ciri_ciri_jasmani_berat"><?php echo $ciri_ciri_jasmani->berat->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ciri_ciri_jasmani->bentuk_hidung->Visible) { // bentuk_hidung ?>
		<th class="<?php echo $ciri_ciri_jasmani->bentuk_hidung->HeaderCellClass() ?>"><span id="elh_ciri_ciri_jasmani_bentuk_hidung" class="ciri_ciri_jasmani_bentuk_hidung"><?php echo $ciri_ciri_jasmani->bentuk_hidung->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ciri_ciri_jasmani->bentuk_muka->Visible) { // bentuk_muka ?>
		<th class="<?php echo $ciri_ciri_jasmani->bentuk_muka->HeaderCellClass() ?>"><span id="elh_ciri_ciri_jasmani_bentuk_muka" class="ciri_ciri_jasmani_bentuk_muka"><?php echo $ciri_ciri_jasmani->bentuk_muka->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ciri_ciri_jasmani->warna_kulit->Visible) { // warna_kulit ?>
		<th class="<?php echo $ciri_ciri_jasmani->warna_kulit->HeaderCellClass() ?>"><span id="elh_ciri_ciri_jasmani_warna_kulit" class="ciri_ciri_jasmani_warna_kulit"><?php echo $ciri_ciri_jasmani->warna_kulit->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ciri_ciri_jasmani->warna_rambut->Visible) { // warna_rambut ?>
		<th class="<?php echo $ciri_ciri_jasmani->warna_rambut->HeaderCellClass() ?>"><span id="elh_ciri_ciri_jasmani_warna_rambut" class="ciri_ciri_jasmani_warna_rambut"><?php echo $ciri_ciri_jasmani->warna_rambut->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ciri_ciri_jasmani->hobi->Visible) { // hobi ?>
		<th class="<?php echo $ciri_ciri_jasmani->hobi->HeaderCellClass() ?>"><span id="elh_ciri_ciri_jasmani_hobi" class="ciri_ciri_jasmani_hobi"><?php echo $ciri_ciri_jasmani->hobi->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ciri_ciri_jasmani->stat_validasi->Visible) { // stat_validasi ?>
		<th class="<?php echo $ciri_ciri_jasmani->stat_validasi->HeaderCellClass() ?>"><span id="elh_ciri_ciri_jasmani_stat_validasi" class="ciri_ciri_jasmani_stat_validasi"><?php echo $ciri_ciri_jasmani->stat_validasi->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ciri_ciri_jasmani->change_date->Visible) { // change_date ?>
		<th class="<?php echo $ciri_ciri_jasmani->change_date->HeaderCellClass() ?>"><span id="elh_ciri_ciri_jasmani_change_date" class="ciri_ciri_jasmani_change_date"><?php echo $ciri_ciri_jasmani->change_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ciri_ciri_jasmani->change_by->Visible) { // change_by ?>
		<th class="<?php echo $ciri_ciri_jasmani->change_by->HeaderCellClass() ?>"><span id="elh_ciri_ciri_jasmani_change_by" class="ciri_ciri_jasmani_change_by"><?php echo $ciri_ciri_jasmani->change_by->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$ciri_ciri_jasmani_delete->RecCnt = 0;
$i = 0;
while (!$ciri_ciri_jasmani_delete->Recordset->EOF) {
	$ciri_ciri_jasmani_delete->RecCnt++;
	$ciri_ciri_jasmani_delete->RowCnt++;

	// Set row properties
	$ciri_ciri_jasmani->ResetAttrs();
	$ciri_ciri_jasmani->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$ciri_ciri_jasmani_delete->LoadRowValues($ciri_ciri_jasmani_delete->Recordset);

	// Render row
	$ciri_ciri_jasmani_delete->RenderRow();
?>
	<tr<?php echo $ciri_ciri_jasmani->RowAttributes() ?>>
<?php if ($ciri_ciri_jasmani->id->Visible) { // id ?>
		<td<?php echo $ciri_ciri_jasmani->id->CellAttributes() ?>>
<span id="el<?php echo $ciri_ciri_jasmani_delete->RowCnt ?>_ciri_ciri_jasmani_id" class="ciri_ciri_jasmani_id">
<span<?php echo $ciri_ciri_jasmani->id->ViewAttributes() ?>>
<?php echo $ciri_ciri_jasmani->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ciri_ciri_jasmani->nip->Visible) { // nip ?>
		<td<?php echo $ciri_ciri_jasmani->nip->CellAttributes() ?>>
<span id="el<?php echo $ciri_ciri_jasmani_delete->RowCnt ?>_ciri_ciri_jasmani_nip" class="ciri_ciri_jasmani_nip">
<span<?php echo $ciri_ciri_jasmani->nip->ViewAttributes() ?>>
<?php echo $ciri_ciri_jasmani->nip->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ciri_ciri_jasmani->tinggi_badan->Visible) { // tinggi_badan ?>
		<td<?php echo $ciri_ciri_jasmani->tinggi_badan->CellAttributes() ?>>
<span id="el<?php echo $ciri_ciri_jasmani_delete->RowCnt ?>_ciri_ciri_jasmani_tinggi_badan" class="ciri_ciri_jasmani_tinggi_badan">
<span<?php echo $ciri_ciri_jasmani->tinggi_badan->ViewAttributes() ?>>
<?php echo $ciri_ciri_jasmani->tinggi_badan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ciri_ciri_jasmani->berat->Visible) { // berat ?>
		<td<?php echo $ciri_ciri_jasmani->berat->CellAttributes() ?>>
<span id="el<?php echo $ciri_ciri_jasmani_delete->RowCnt ?>_ciri_ciri_jasmani_berat" class="ciri_ciri_jasmani_berat">
<span<?php echo $ciri_ciri_jasmani->berat->ViewAttributes() ?>>
<?php echo $ciri_ciri_jasmani->berat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ciri_ciri_jasmani->bentuk_hidung->Visible) { // bentuk_hidung ?>
		<td<?php echo $ciri_ciri_jasmani->bentuk_hidung->CellAttributes() ?>>
<span id="el<?php echo $ciri_ciri_jasmani_delete->RowCnt ?>_ciri_ciri_jasmani_bentuk_hidung" class="ciri_ciri_jasmani_bentuk_hidung">
<span<?php echo $ciri_ciri_jasmani->bentuk_hidung->ViewAttributes() ?>>
<?php echo $ciri_ciri_jasmani->bentuk_hidung->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ciri_ciri_jasmani->bentuk_muka->Visible) { // bentuk_muka ?>
		<td<?php echo $ciri_ciri_jasmani->bentuk_muka->CellAttributes() ?>>
<span id="el<?php echo $ciri_ciri_jasmani_delete->RowCnt ?>_ciri_ciri_jasmani_bentuk_muka" class="ciri_ciri_jasmani_bentuk_muka">
<span<?php echo $ciri_ciri_jasmani->bentuk_muka->ViewAttributes() ?>>
<?php echo $ciri_ciri_jasmani->bentuk_muka->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ciri_ciri_jasmani->warna_kulit->Visible) { // warna_kulit ?>
		<td<?php echo $ciri_ciri_jasmani->warna_kulit->CellAttributes() ?>>
<span id="el<?php echo $ciri_ciri_jasmani_delete->RowCnt ?>_ciri_ciri_jasmani_warna_kulit" class="ciri_ciri_jasmani_warna_kulit">
<span<?php echo $ciri_ciri_jasmani->warna_kulit->ViewAttributes() ?>>
<?php echo $ciri_ciri_jasmani->warna_kulit->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ciri_ciri_jasmani->warna_rambut->Visible) { // warna_rambut ?>
		<td<?php echo $ciri_ciri_jasmani->warna_rambut->CellAttributes() ?>>
<span id="el<?php echo $ciri_ciri_jasmani_delete->RowCnt ?>_ciri_ciri_jasmani_warna_rambut" class="ciri_ciri_jasmani_warna_rambut">
<span<?php echo $ciri_ciri_jasmani->warna_rambut->ViewAttributes() ?>>
<?php echo $ciri_ciri_jasmani->warna_rambut->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ciri_ciri_jasmani->hobi->Visible) { // hobi ?>
		<td<?php echo $ciri_ciri_jasmani->hobi->CellAttributes() ?>>
<span id="el<?php echo $ciri_ciri_jasmani_delete->RowCnt ?>_ciri_ciri_jasmani_hobi" class="ciri_ciri_jasmani_hobi">
<span<?php echo $ciri_ciri_jasmani->hobi->ViewAttributes() ?>>
<?php echo $ciri_ciri_jasmani->hobi->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ciri_ciri_jasmani->stat_validasi->Visible) { // stat_validasi ?>
		<td<?php echo $ciri_ciri_jasmani->stat_validasi->CellAttributes() ?>>
<span id="el<?php echo $ciri_ciri_jasmani_delete->RowCnt ?>_ciri_ciri_jasmani_stat_validasi" class="ciri_ciri_jasmani_stat_validasi">
<span<?php echo $ciri_ciri_jasmani->stat_validasi->ViewAttributes() ?>>
<?php echo $ciri_ciri_jasmani->stat_validasi->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ciri_ciri_jasmani->change_date->Visible) { // change_date ?>
		<td<?php echo $ciri_ciri_jasmani->change_date->CellAttributes() ?>>
<span id="el<?php echo $ciri_ciri_jasmani_delete->RowCnt ?>_ciri_ciri_jasmani_change_date" class="ciri_ciri_jasmani_change_date">
<span<?php echo $ciri_ciri_jasmani->change_date->ViewAttributes() ?>>
<?php echo $ciri_ciri_jasmani->change_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ciri_ciri_jasmani->change_by->Visible) { // change_by ?>
		<td<?php echo $ciri_ciri_jasmani->change_by->CellAttributes() ?>>
<span id="el<?php echo $ciri_ciri_jasmani_delete->RowCnt ?>_ciri_ciri_jasmani_change_by" class="ciri_ciri_jasmani_change_by">
<span<?php echo $ciri_ciri_jasmani->change_by->ViewAttributes() ?>>
<?php echo $ciri_ciri_jasmani->change_by->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$ciri_ciri_jasmani_delete->Recordset->MoveNext();
}
$ciri_ciri_jasmani_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ciri_ciri_jasmani_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fciri_ciri_jasmanidelete.Init();
</script>
<?php
$ciri_ciri_jasmani_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ciri_ciri_jasmani_delete->Page_Terminate();
?>
