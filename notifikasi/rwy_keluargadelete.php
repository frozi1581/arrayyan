<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "rwy_keluargainfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$rwy_keluarga_delete = NULL; // Initialize page object first

class crwy_keluarga_delete extends crwy_keluarga {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'rwy_keluarga';

	// Page object name
	var $PageObjName = 'rwy_keluarga_delete';

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

		// Table object (rwy_keluarga)
		if (!isset($GLOBALS["rwy_keluarga"]) || get_class($GLOBALS["rwy_keluarga"]) == "crwy_keluarga") {
			$GLOBALS["rwy_keluarga"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["rwy_keluarga"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rwy_keluarga', TRUE);

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
		$this->hubungan_keluarga->SetVisibility();
		$this->tanggal_lahir->SetVisibility();
		$this->tempat_lahir->SetVisibility();
		$this->pendidikan_terakhir->SetVisibility();
		$this->jurusan->SetVisibility();
		$this->jenis_kelamin->SetVisibility();
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
		global $EW_EXPORT, $rwy_keluarga;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($rwy_keluarga);
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
			$this->Page_Terminate("rwy_keluargalist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in rwy_keluarga class, rwy_keluargainfo.php

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
				$this->Page_Terminate("rwy_keluargalist.php"); // Return to list
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
		$this->hubungan_keluarga->setDbValue($row['hubungan_keluarga']);
		$this->nama_lengkap->setDbValue($row['nama_lengkap']);
		$this->tanggal_lahir->setDbValue($row['tanggal_lahir']);
		$this->tempat_lahir->setDbValue($row['tempat_lahir']);
		$this->pendidikan_terakhir->setDbValue($row['pendidikan_terakhir']);
		$this->jurusan->setDbValue($row['jurusan']);
		$this->jenis_kelamin->setDbValue($row['jenis_kelamin']);
		$this->stat_validasi->setDbValue($row['stat_validasi']);
		$this->change_date->setDbValue($row['change_date']);
		$this->change_by->setDbValue($row['change_by']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['nip'] = NULL;
		$row['hubungan_keluarga'] = NULL;
		$row['nama_lengkap'] = NULL;
		$row['tanggal_lahir'] = NULL;
		$row['tempat_lahir'] = NULL;
		$row['pendidikan_terakhir'] = NULL;
		$row['jurusan'] = NULL;
		$row['jenis_kelamin'] = NULL;
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
		$this->hubungan_keluarga->DbValue = $row['hubungan_keluarga'];
		$this->nama_lengkap->DbValue = $row['nama_lengkap'];
		$this->tanggal_lahir->DbValue = $row['tanggal_lahir'];
		$this->tempat_lahir->DbValue = $row['tempat_lahir'];
		$this->pendidikan_terakhir->DbValue = $row['pendidikan_terakhir'];
		$this->jurusan->DbValue = $row['jurusan'];
		$this->jenis_kelamin->DbValue = $row['jenis_kelamin'];
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
		// hubungan_keluarga
		// nama_lengkap
		// tanggal_lahir
		// tempat_lahir
		// pendidikan_terakhir
		// jurusan
		// jenis_kelamin
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

		// hubungan_keluarga
		$this->hubungan_keluarga->ViewValue = $this->hubungan_keluarga->CurrentValue;
		$this->hubungan_keluarga->ViewCustomAttributes = "";

		// tanggal_lahir
		$this->tanggal_lahir->ViewValue = $this->tanggal_lahir->CurrentValue;
		$this->tanggal_lahir->ViewValue = ew_FormatDateTime($this->tanggal_lahir->ViewValue, 0);
		$this->tanggal_lahir->ViewCustomAttributes = "";

		// tempat_lahir
		$this->tempat_lahir->ViewValue = $this->tempat_lahir->CurrentValue;
		$this->tempat_lahir->ViewCustomAttributes = "";

		// pendidikan_terakhir
		$this->pendidikan_terakhir->ViewValue = $this->pendidikan_terakhir->CurrentValue;
		$this->pendidikan_terakhir->ViewCustomAttributes = "";

		// jurusan
		$this->jurusan->ViewValue = $this->jurusan->CurrentValue;
		$this->jurusan->ViewCustomAttributes = "";

		// jenis_kelamin
		$this->jenis_kelamin->ViewValue = $this->jenis_kelamin->CurrentValue;
		$this->jenis_kelamin->ViewCustomAttributes = "";

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

			// hubungan_keluarga
			$this->hubungan_keluarga->LinkCustomAttributes = "";
			$this->hubungan_keluarga->HrefValue = "";
			$this->hubungan_keluarga->TooltipValue = "";

			// tanggal_lahir
			$this->tanggal_lahir->LinkCustomAttributes = "";
			$this->tanggal_lahir->HrefValue = "";
			$this->tanggal_lahir->TooltipValue = "";

			// tempat_lahir
			$this->tempat_lahir->LinkCustomAttributes = "";
			$this->tempat_lahir->HrefValue = "";
			$this->tempat_lahir->TooltipValue = "";

			// pendidikan_terakhir
			$this->pendidikan_terakhir->LinkCustomAttributes = "";
			$this->pendidikan_terakhir->HrefValue = "";
			$this->pendidikan_terakhir->TooltipValue = "";

			// jurusan
			$this->jurusan->LinkCustomAttributes = "";
			$this->jurusan->HrefValue = "";
			$this->jurusan->TooltipValue = "";

			// jenis_kelamin
			$this->jenis_kelamin->LinkCustomAttributes = "";
			$this->jenis_kelamin->HrefValue = "";
			$this->jenis_kelamin->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("rwy_keluargalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($rwy_keluarga_delete)) $rwy_keluarga_delete = new crwy_keluarga_delete();

// Page init
$rwy_keluarga_delete->Page_Init();

// Page main
$rwy_keluarga_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$rwy_keluarga_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = frwy_keluargadelete = new ew_Form("frwy_keluargadelete", "delete");

// Form_CustomValidate event
frwy_keluargadelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
frwy_keluargadelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $rwy_keluarga_delete->ShowPageHeader(); ?>
<?php
$rwy_keluarga_delete->ShowMessage();
?>
<form name="frwy_keluargadelete" id="frwy_keluargadelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($rwy_keluarga_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $rwy_keluarga_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="rwy_keluarga">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($rwy_keluarga_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($rwy_keluarga->id->Visible) { // id ?>
		<th class="<?php echo $rwy_keluarga->id->HeaderCellClass() ?>"><span id="elh_rwy_keluarga_id" class="rwy_keluarga_id"><?php echo $rwy_keluarga->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_keluarga->nip->Visible) { // nip ?>
		<th class="<?php echo $rwy_keluarga->nip->HeaderCellClass() ?>"><span id="elh_rwy_keluarga_nip" class="rwy_keluarga_nip"><?php echo $rwy_keluarga->nip->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_keluarga->hubungan_keluarga->Visible) { // hubungan_keluarga ?>
		<th class="<?php echo $rwy_keluarga->hubungan_keluarga->HeaderCellClass() ?>"><span id="elh_rwy_keluarga_hubungan_keluarga" class="rwy_keluarga_hubungan_keluarga"><?php echo $rwy_keluarga->hubungan_keluarga->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_keluarga->tanggal_lahir->Visible) { // tanggal_lahir ?>
		<th class="<?php echo $rwy_keluarga->tanggal_lahir->HeaderCellClass() ?>"><span id="elh_rwy_keluarga_tanggal_lahir" class="rwy_keluarga_tanggal_lahir"><?php echo $rwy_keluarga->tanggal_lahir->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_keluarga->tempat_lahir->Visible) { // tempat_lahir ?>
		<th class="<?php echo $rwy_keluarga->tempat_lahir->HeaderCellClass() ?>"><span id="elh_rwy_keluarga_tempat_lahir" class="rwy_keluarga_tempat_lahir"><?php echo $rwy_keluarga->tempat_lahir->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_keluarga->pendidikan_terakhir->Visible) { // pendidikan_terakhir ?>
		<th class="<?php echo $rwy_keluarga->pendidikan_terakhir->HeaderCellClass() ?>"><span id="elh_rwy_keluarga_pendidikan_terakhir" class="rwy_keluarga_pendidikan_terakhir"><?php echo $rwy_keluarga->pendidikan_terakhir->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_keluarga->jurusan->Visible) { // jurusan ?>
		<th class="<?php echo $rwy_keluarga->jurusan->HeaderCellClass() ?>"><span id="elh_rwy_keluarga_jurusan" class="rwy_keluarga_jurusan"><?php echo $rwy_keluarga->jurusan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_keluarga->jenis_kelamin->Visible) { // jenis_kelamin ?>
		<th class="<?php echo $rwy_keluarga->jenis_kelamin->HeaderCellClass() ?>"><span id="elh_rwy_keluarga_jenis_kelamin" class="rwy_keluarga_jenis_kelamin"><?php echo $rwy_keluarga->jenis_kelamin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_keluarga->stat_validasi->Visible) { // stat_validasi ?>
		<th class="<?php echo $rwy_keluarga->stat_validasi->HeaderCellClass() ?>"><span id="elh_rwy_keluarga_stat_validasi" class="rwy_keluarga_stat_validasi"><?php echo $rwy_keluarga->stat_validasi->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_keluarga->change_date->Visible) { // change_date ?>
		<th class="<?php echo $rwy_keluarga->change_date->HeaderCellClass() ?>"><span id="elh_rwy_keluarga_change_date" class="rwy_keluarga_change_date"><?php echo $rwy_keluarga->change_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_keluarga->change_by->Visible) { // change_by ?>
		<th class="<?php echo $rwy_keluarga->change_by->HeaderCellClass() ?>"><span id="elh_rwy_keluarga_change_by" class="rwy_keluarga_change_by"><?php echo $rwy_keluarga->change_by->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$rwy_keluarga_delete->RecCnt = 0;
$i = 0;
while (!$rwy_keluarga_delete->Recordset->EOF) {
	$rwy_keluarga_delete->RecCnt++;
	$rwy_keluarga_delete->RowCnt++;

	// Set row properties
	$rwy_keluarga->ResetAttrs();
	$rwy_keluarga->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$rwy_keluarga_delete->LoadRowValues($rwy_keluarga_delete->Recordset);

	// Render row
	$rwy_keluarga_delete->RenderRow();
?>
	<tr<?php echo $rwy_keluarga->RowAttributes() ?>>
<?php if ($rwy_keluarga->id->Visible) { // id ?>
		<td<?php echo $rwy_keluarga->id->CellAttributes() ?>>
<span id="el<?php echo $rwy_keluarga_delete->RowCnt ?>_rwy_keluarga_id" class="rwy_keluarga_id">
<span<?php echo $rwy_keluarga->id->ViewAttributes() ?>>
<?php echo $rwy_keluarga->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_keluarga->nip->Visible) { // nip ?>
		<td<?php echo $rwy_keluarga->nip->CellAttributes() ?>>
<span id="el<?php echo $rwy_keluarga_delete->RowCnt ?>_rwy_keluarga_nip" class="rwy_keluarga_nip">
<span<?php echo $rwy_keluarga->nip->ViewAttributes() ?>>
<?php echo $rwy_keluarga->nip->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_keluarga->hubungan_keluarga->Visible) { // hubungan_keluarga ?>
		<td<?php echo $rwy_keluarga->hubungan_keluarga->CellAttributes() ?>>
<span id="el<?php echo $rwy_keluarga_delete->RowCnt ?>_rwy_keluarga_hubungan_keluarga" class="rwy_keluarga_hubungan_keluarga">
<span<?php echo $rwy_keluarga->hubungan_keluarga->ViewAttributes() ?>>
<?php echo $rwy_keluarga->hubungan_keluarga->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_keluarga->tanggal_lahir->Visible) { // tanggal_lahir ?>
		<td<?php echo $rwy_keluarga->tanggal_lahir->CellAttributes() ?>>
<span id="el<?php echo $rwy_keluarga_delete->RowCnt ?>_rwy_keluarga_tanggal_lahir" class="rwy_keluarga_tanggal_lahir">
<span<?php echo $rwy_keluarga->tanggal_lahir->ViewAttributes() ?>>
<?php echo $rwy_keluarga->tanggal_lahir->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_keluarga->tempat_lahir->Visible) { // tempat_lahir ?>
		<td<?php echo $rwy_keluarga->tempat_lahir->CellAttributes() ?>>
<span id="el<?php echo $rwy_keluarga_delete->RowCnt ?>_rwy_keluarga_tempat_lahir" class="rwy_keluarga_tempat_lahir">
<span<?php echo $rwy_keluarga->tempat_lahir->ViewAttributes() ?>>
<?php echo $rwy_keluarga->tempat_lahir->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_keluarga->pendidikan_terakhir->Visible) { // pendidikan_terakhir ?>
		<td<?php echo $rwy_keluarga->pendidikan_terakhir->CellAttributes() ?>>
<span id="el<?php echo $rwy_keluarga_delete->RowCnt ?>_rwy_keluarga_pendidikan_terakhir" class="rwy_keluarga_pendidikan_terakhir">
<span<?php echo $rwy_keluarga->pendidikan_terakhir->ViewAttributes() ?>>
<?php echo $rwy_keluarga->pendidikan_terakhir->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_keluarga->jurusan->Visible) { // jurusan ?>
		<td<?php echo $rwy_keluarga->jurusan->CellAttributes() ?>>
<span id="el<?php echo $rwy_keluarga_delete->RowCnt ?>_rwy_keluarga_jurusan" class="rwy_keluarga_jurusan">
<span<?php echo $rwy_keluarga->jurusan->ViewAttributes() ?>>
<?php echo $rwy_keluarga->jurusan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_keluarga->jenis_kelamin->Visible) { // jenis_kelamin ?>
		<td<?php echo $rwy_keluarga->jenis_kelamin->CellAttributes() ?>>
<span id="el<?php echo $rwy_keluarga_delete->RowCnt ?>_rwy_keluarga_jenis_kelamin" class="rwy_keluarga_jenis_kelamin">
<span<?php echo $rwy_keluarga->jenis_kelamin->ViewAttributes() ?>>
<?php echo $rwy_keluarga->jenis_kelamin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_keluarga->stat_validasi->Visible) { // stat_validasi ?>
		<td<?php echo $rwy_keluarga->stat_validasi->CellAttributes() ?>>
<span id="el<?php echo $rwy_keluarga_delete->RowCnt ?>_rwy_keluarga_stat_validasi" class="rwy_keluarga_stat_validasi">
<span<?php echo $rwy_keluarga->stat_validasi->ViewAttributes() ?>>
<?php echo $rwy_keluarga->stat_validasi->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_keluarga->change_date->Visible) { // change_date ?>
		<td<?php echo $rwy_keluarga->change_date->CellAttributes() ?>>
<span id="el<?php echo $rwy_keluarga_delete->RowCnt ?>_rwy_keluarga_change_date" class="rwy_keluarga_change_date">
<span<?php echo $rwy_keluarga->change_date->ViewAttributes() ?>>
<?php echo $rwy_keluarga->change_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_keluarga->change_by->Visible) { // change_by ?>
		<td<?php echo $rwy_keluarga->change_by->CellAttributes() ?>>
<span id="el<?php echo $rwy_keluarga_delete->RowCnt ?>_rwy_keluarga_change_by" class="rwy_keluarga_change_by">
<span<?php echo $rwy_keluarga->change_by->ViewAttributes() ?>>
<?php echo $rwy_keluarga->change_by->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$rwy_keluarga_delete->Recordset->MoveNext();
}
$rwy_keluarga_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $rwy_keluarga_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
frwy_keluargadelete.Init();
</script>
<?php
$rwy_keluarga_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$rwy_keluarga_delete->Page_Terminate();
?>
