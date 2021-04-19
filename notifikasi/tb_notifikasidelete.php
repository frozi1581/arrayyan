<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tb_notifikasiinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tb_notifikasi_delete = NULL; // Initialize page object first

class ctb_notifikasi_delete extends ctb_notifikasi {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'tb_notifikasi';

	// Page object name
	var $PageObjName = 'tb_notifikasi_delete';

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

		// Table object (tb_notifikasi)
		if (!isset($GLOBALS["tb_notifikasi"]) || get_class($GLOBALS["tb_notifikasi"]) == "ctb_notifikasi") {
			$GLOBALS["tb_notifikasi"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_notifikasi"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
			$this->Page_Terminate("tb_notifikasilist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tb_notifikasi class, tb_notifikasiinfo.php

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
				$this->Page_Terminate("tb_notifikasilist.php"); // Return to list
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_notifikasilist.php"), "", $this->TableVar, TRUE);
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
if (!isset($tb_notifikasi_delete)) $tb_notifikasi_delete = new ctb_notifikasi_delete();

// Page init
$tb_notifikasi_delete->Page_Init();

// Page main
$tb_notifikasi_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_notifikasi_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ftb_notifikasidelete = new ew_Form("ftb_notifikasidelete", "delete");

// Form_CustomValidate event
ftb_notifikasidelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftb_notifikasidelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftb_notifikasidelete.Lists["x_topic"] = {"LinkField":"x_nama_referensi","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_referensi","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_referensi"};
ftb_notifikasidelete.Lists["x_topic"].Data = "<?php echo $tb_notifikasi_delete->topic->LookupFilterQuery(FALSE, "delete") ?>";
ftb_notifikasidelete.Lists["x_priority"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftb_notifikasidelete.Lists["x_priority"].Options = <?php echo json_encode($tb_notifikasi_delete->priority->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tb_notifikasi_delete->ShowPageHeader(); ?>
<?php
$tb_notifikasi_delete->ShowMessage();
?>
<form name="ftb_notifikasidelete" id="ftb_notifikasidelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_notifikasi_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_notifikasi_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_notifikasi">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tb_notifikasi_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($tb_notifikasi->id->Visible) { // id ?>
		<th class="<?php echo $tb_notifikasi->id->HeaderCellClass() ?>"><span id="elh_tb_notifikasi_id" class="tb_notifikasi_id"><?php echo $tb_notifikasi->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_notifikasi->topic->Visible) { // topic ?>
		<th class="<?php echo $tb_notifikasi->topic->HeaderCellClass() ?>"><span id="elh_tb_notifikasi_topic" class="tb_notifikasi_topic"><?php echo $tb_notifikasi->topic->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_notifikasi->priority->Visible) { // priority ?>
		<th class="<?php echo $tb_notifikasi->priority->HeaderCellClass() ?>"><span id="elh_tb_notifikasi_priority" class="tb_notifikasi_priority"><?php echo $tb_notifikasi->priority->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_notifikasi->isi_notif->Visible) { // isi_notif ?>
		<th class="<?php echo $tb_notifikasi->isi_notif->HeaderCellClass() ?>"><span id="elh_tb_notifikasi_isi_notif" class="tb_notifikasi_isi_notif"><?php echo $tb_notifikasi->isi_notif->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_notifikasi->action->Visible) { // action ?>
		<th class="<?php echo $tb_notifikasi->action->HeaderCellClass() ?>"><span id="elh_tb_notifikasi_action" class="tb_notifikasi_action"><?php echo $tb_notifikasi->action->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_notifikasi->tgl_cr->Visible) { // tgl_cr ?>
		<th class="<?php echo $tb_notifikasi->tgl_cr->HeaderCellClass() ?>"><span id="elh_tb_notifikasi_tgl_cr" class="tb_notifikasi_tgl_cr"><?php echo $tb_notifikasi->tgl_cr->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_notifikasi->tgl_upd->Visible) { // tgl_upd ?>
		<th class="<?php echo $tb_notifikasi->tgl_upd->HeaderCellClass() ?>"><span id="elh_tb_notifikasi_tgl_upd" class="tb_notifikasi_tgl_upd"><?php echo $tb_notifikasi->tgl_upd->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tb_notifikasi_delete->RecCnt = 0;
$i = 0;
while (!$tb_notifikasi_delete->Recordset->EOF) {
	$tb_notifikasi_delete->RecCnt++;
	$tb_notifikasi_delete->RowCnt++;

	// Set row properties
	$tb_notifikasi->ResetAttrs();
	$tb_notifikasi->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tb_notifikasi_delete->LoadRowValues($tb_notifikasi_delete->Recordset);

	// Render row
	$tb_notifikasi_delete->RenderRow();
?>
	<tr<?php echo $tb_notifikasi->RowAttributes() ?>>
<?php if ($tb_notifikasi->id->Visible) { // id ?>
		<td<?php echo $tb_notifikasi->id->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_delete->RowCnt ?>_tb_notifikasi_id" class="tb_notifikasi_id">
<span<?php echo $tb_notifikasi->id->ViewAttributes() ?>>
<?php echo $tb_notifikasi->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_notifikasi->topic->Visible) { // topic ?>
		<td<?php echo $tb_notifikasi->topic->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_delete->RowCnt ?>_tb_notifikasi_topic" class="tb_notifikasi_topic">
<span<?php echo $tb_notifikasi->topic->ViewAttributes() ?>>
<?php echo $tb_notifikasi->topic->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_notifikasi->priority->Visible) { // priority ?>
		<td<?php echo $tb_notifikasi->priority->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_delete->RowCnt ?>_tb_notifikasi_priority" class="tb_notifikasi_priority">
<span<?php echo $tb_notifikasi->priority->ViewAttributes() ?>>
<?php echo $tb_notifikasi->priority->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_notifikasi->isi_notif->Visible) { // isi_notif ?>
		<td<?php echo $tb_notifikasi->isi_notif->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_delete->RowCnt ?>_tb_notifikasi_isi_notif" class="tb_notifikasi_isi_notif">
<span<?php echo $tb_notifikasi->isi_notif->ViewAttributes() ?>>
<?php echo $tb_notifikasi->isi_notif->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_notifikasi->action->Visible) { // action ?>
		<td<?php echo $tb_notifikasi->action->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_delete->RowCnt ?>_tb_notifikasi_action" class="tb_notifikasi_action">
<span<?php echo $tb_notifikasi->action->ViewAttributes() ?>>
<?php echo $tb_notifikasi->action->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_notifikasi->tgl_cr->Visible) { // tgl_cr ?>
		<td<?php echo $tb_notifikasi->tgl_cr->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_delete->RowCnt ?>_tb_notifikasi_tgl_cr" class="tb_notifikasi_tgl_cr">
<span<?php echo $tb_notifikasi->tgl_cr->ViewAttributes() ?>>
<?php echo $tb_notifikasi->tgl_cr->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_notifikasi->tgl_upd->Visible) { // tgl_upd ?>
		<td<?php echo $tb_notifikasi->tgl_upd->CellAttributes() ?>>
<span id="el<?php echo $tb_notifikasi_delete->RowCnt ?>_tb_notifikasi_tgl_upd" class="tb_notifikasi_tgl_upd">
<span<?php echo $tb_notifikasi->tgl_upd->ViewAttributes() ?>>
<?php echo $tb_notifikasi->tgl_upd->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tb_notifikasi_delete->Recordset->MoveNext();
}
$tb_notifikasi_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_notifikasi_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ftb_notifikasidelete.Init();
</script>
<?php
$tb_notifikasi_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_notifikasi_delete->Page_Terminate();
?>
