<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tb_jbtinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tb_jbt_delete = NULL; // Initialize page object first

class ctb_jbt_delete extends ctb_jbt {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'tb_jbt';

	// Page object name
	var $PageObjName = 'tb_jbt_delete';

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

		// Table object (tb_jbt)
		if (!isset($GLOBALS["tb_jbt"]) || get_class($GLOBALS["tb_jbt"]) == "ctb_jbt") {
			$GLOBALS["tb_jbt"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_jbt"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_jbt', TRUE);

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
		$this->kd_jbt->SetVisibility();
		$this->ket->SetVisibility();
		$this->tjb->SetVisibility();
		$this->koef->SetVisibility();
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();
		$this->kd_jbt_old->SetVisibility();
		$this->ket_old->SetVisibility();
		$this->jbt_type->SetVisibility();
		$this->org_id->SetVisibility();
		$this->parent_kd_jbt->SetVisibility();
		$this->eselon_num->SetVisibility();
		$this->jns_jbt->SetVisibility();
		$this->status->SetVisibility();

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
		global $EW_EXPORT, $tb_jbt;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_jbt);
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
			$this->Page_Terminate("tb_jbtlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tb_jbt class, tb_jbtinfo.php

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
				$this->Page_Terminate("tb_jbtlist.php"); // Return to list
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
		$this->kd_jbt->setDbValue($row['kd_jbt']);
		$this->ket->setDbValue($row['ket']);
		$this->tjb->setDbValue($row['tjb']);
		$this->koef->setDbValue($row['koef']);
		$this->created_by->setDbValue($row['created_by']);
		$this->created_date->setDbValue($row['created_date']);
		$this->last_update_by->setDbValue($row['last_update_by']);
		$this->last_update_date->setDbValue($row['last_update_date']);
		$this->kd_jbt_old->setDbValue($row['kd_jbt_old']);
		$this->ket_old->setDbValue($row['ket_old']);
		$this->jbt_type->setDbValue($row['jbt_type']);
		$this->org_id->setDbValue($row['org_id']);
		$this->parent_kd_jbt->setDbValue($row['parent_kd_jbt']);
		$this->eselon_num->setDbValue($row['eselon_num']);
		$this->jns_jbt->setDbValue($row['jns_jbt']);
		$this->status->setDbValue($row['status']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['kd_jbt'] = NULL;
		$row['ket'] = NULL;
		$row['tjb'] = NULL;
		$row['koef'] = NULL;
		$row['created_by'] = NULL;
		$row['created_date'] = NULL;
		$row['last_update_by'] = NULL;
		$row['last_update_date'] = NULL;
		$row['kd_jbt_old'] = NULL;
		$row['ket_old'] = NULL;
		$row['jbt_type'] = NULL;
		$row['org_id'] = NULL;
		$row['parent_kd_jbt'] = NULL;
		$row['eselon_num'] = NULL;
		$row['jns_jbt'] = NULL;
		$row['status'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->kd_jbt->DbValue = $row['kd_jbt'];
		$this->ket->DbValue = $row['ket'];
		$this->tjb->DbValue = $row['tjb'];
		$this->koef->DbValue = $row['koef'];
		$this->created_by->DbValue = $row['created_by'];
		$this->created_date->DbValue = $row['created_date'];
		$this->last_update_by->DbValue = $row['last_update_by'];
		$this->last_update_date->DbValue = $row['last_update_date'];
		$this->kd_jbt_old->DbValue = $row['kd_jbt_old'];
		$this->ket_old->DbValue = $row['ket_old'];
		$this->jbt_type->DbValue = $row['jbt_type'];
		$this->org_id->DbValue = $row['org_id'];
		$this->parent_kd_jbt->DbValue = $row['parent_kd_jbt'];
		$this->eselon_num->DbValue = $row['eselon_num'];
		$this->jns_jbt->DbValue = $row['jns_jbt'];
		$this->status->DbValue = $row['status'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->koef->FormValue == $this->koef->CurrentValue && is_numeric(ew_StrToFloat($this->koef->CurrentValue)))
			$this->koef->CurrentValue = ew_StrToFloat($this->koef->CurrentValue);

		// Convert decimal values if posted back
		if ($this->eselon_num->FormValue == $this->eselon_num->CurrentValue && is_numeric(ew_StrToFloat($this->eselon_num->CurrentValue)))
			$this->eselon_num->CurrentValue = ew_StrToFloat($this->eselon_num->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// kd_jbt
		// ket
		// tjb
		// koef
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// kd_jbt_old
		// ket_old
		// jbt_type
		// org_id
		// parent_kd_jbt
		// eselon_num
		// jns_jbt
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// kd_jbt
		$this->kd_jbt->ViewValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

		// tjb
		$this->tjb->ViewValue = $this->tjb->CurrentValue;
		$this->tjb->ViewCustomAttributes = "";

		// koef
		$this->koef->ViewValue = $this->koef->CurrentValue;
		$this->koef->ViewCustomAttributes = "";

		// created_by
		$this->created_by->ViewValue = $this->created_by->CurrentValue;
		$this->created_by->ViewCustomAttributes = "";

		// created_date
		$this->created_date->ViewValue = $this->created_date->CurrentValue;
		$this->created_date->ViewValue = ew_FormatDateTime($this->created_date->ViewValue, 0);
		$this->created_date->ViewCustomAttributes = "";

		// last_update_by
		$this->last_update_by->ViewValue = $this->last_update_by->CurrentValue;
		$this->last_update_by->ViewCustomAttributes = "";

		// last_update_date
		$this->last_update_date->ViewValue = $this->last_update_date->CurrentValue;
		$this->last_update_date->ViewValue = ew_FormatDateTime($this->last_update_date->ViewValue, 0);
		$this->last_update_date->ViewCustomAttributes = "";

		// kd_jbt_old
		$this->kd_jbt_old->ViewValue = $this->kd_jbt_old->CurrentValue;
		$this->kd_jbt_old->ViewCustomAttributes = "";

		// ket_old
		$this->ket_old->ViewValue = $this->ket_old->CurrentValue;
		$this->ket_old->ViewCustomAttributes = "";

		// jbt_type
		$this->jbt_type->ViewValue = $this->jbt_type->CurrentValue;
		$this->jbt_type->ViewCustomAttributes = "";

		// org_id
		$this->org_id->ViewValue = $this->org_id->CurrentValue;
		$this->org_id->ViewCustomAttributes = "";

		// parent_kd_jbt
		$this->parent_kd_jbt->ViewValue = $this->parent_kd_jbt->CurrentValue;
		$this->parent_kd_jbt->ViewCustomAttributes = "";

		// eselon_num
		$this->eselon_num->ViewValue = $this->eselon_num->CurrentValue;
		$this->eselon_num->ViewCustomAttributes = "";

		// jns_jbt
		$this->jns_jbt->ViewValue = $this->jns_jbt->CurrentValue;
		$this->jns_jbt->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

			// kd_jbt
			$this->kd_jbt->LinkCustomAttributes = "";
			$this->kd_jbt->HrefValue = "";
			$this->kd_jbt->TooltipValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";
			$this->ket->TooltipValue = "";

			// tjb
			$this->tjb->LinkCustomAttributes = "";
			$this->tjb->HrefValue = "";
			$this->tjb->TooltipValue = "";

			// koef
			$this->koef->LinkCustomAttributes = "";
			$this->koef->HrefValue = "";
			$this->koef->TooltipValue = "";

			// created_by
			$this->created_by->LinkCustomAttributes = "";
			$this->created_by->HrefValue = "";
			$this->created_by->TooltipValue = "";

			// created_date
			$this->created_date->LinkCustomAttributes = "";
			$this->created_date->HrefValue = "";
			$this->created_date->TooltipValue = "";

			// last_update_by
			$this->last_update_by->LinkCustomAttributes = "";
			$this->last_update_by->HrefValue = "";
			$this->last_update_by->TooltipValue = "";

			// last_update_date
			$this->last_update_date->LinkCustomAttributes = "";
			$this->last_update_date->HrefValue = "";
			$this->last_update_date->TooltipValue = "";

			// kd_jbt_old
			$this->kd_jbt_old->LinkCustomAttributes = "";
			$this->kd_jbt_old->HrefValue = "";
			$this->kd_jbt_old->TooltipValue = "";

			// ket_old
			$this->ket_old->LinkCustomAttributes = "";
			$this->ket_old->HrefValue = "";
			$this->ket_old->TooltipValue = "";

			// jbt_type
			$this->jbt_type->LinkCustomAttributes = "";
			$this->jbt_type->HrefValue = "";
			$this->jbt_type->TooltipValue = "";

			// org_id
			$this->org_id->LinkCustomAttributes = "";
			$this->org_id->HrefValue = "";
			$this->org_id->TooltipValue = "";

			// parent_kd_jbt
			$this->parent_kd_jbt->LinkCustomAttributes = "";
			$this->parent_kd_jbt->HrefValue = "";
			$this->parent_kd_jbt->TooltipValue = "";

			// eselon_num
			$this->eselon_num->LinkCustomAttributes = "";
			$this->eselon_num->HrefValue = "";
			$this->eselon_num->TooltipValue = "";

			// jns_jbt
			$this->jns_jbt->LinkCustomAttributes = "";
			$this->jns_jbt->HrefValue = "";
			$this->jns_jbt->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
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
				$sThisKey .= $row['kd_jbt'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_jbtlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($tb_jbt_delete)) $tb_jbt_delete = new ctb_jbt_delete();

// Page init
$tb_jbt_delete->Page_Init();

// Page main
$tb_jbt_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_jbt_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ftb_jbtdelete = new ew_Form("ftb_jbtdelete", "delete");

// Form_CustomValidate event
ftb_jbtdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftb_jbtdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tb_jbt_delete->ShowPageHeader(); ?>
<?php
$tb_jbt_delete->ShowMessage();
?>
<form name="ftb_jbtdelete" id="ftb_jbtdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_jbt_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_jbt_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_jbt">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tb_jbt_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($tb_jbt->kd_jbt->Visible) { // kd_jbt ?>
		<th class="<?php echo $tb_jbt->kd_jbt->HeaderCellClass() ?>"><span id="elh_tb_jbt_kd_jbt" class="tb_jbt_kd_jbt"><?php echo $tb_jbt->kd_jbt->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->ket->Visible) { // ket ?>
		<th class="<?php echo $tb_jbt->ket->HeaderCellClass() ?>"><span id="elh_tb_jbt_ket" class="tb_jbt_ket"><?php echo $tb_jbt->ket->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->tjb->Visible) { // tjb ?>
		<th class="<?php echo $tb_jbt->tjb->HeaderCellClass() ?>"><span id="elh_tb_jbt_tjb" class="tb_jbt_tjb"><?php echo $tb_jbt->tjb->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->koef->Visible) { // koef ?>
		<th class="<?php echo $tb_jbt->koef->HeaderCellClass() ?>"><span id="elh_tb_jbt_koef" class="tb_jbt_koef"><?php echo $tb_jbt->koef->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->created_by->Visible) { // created_by ?>
		<th class="<?php echo $tb_jbt->created_by->HeaderCellClass() ?>"><span id="elh_tb_jbt_created_by" class="tb_jbt_created_by"><?php echo $tb_jbt->created_by->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->created_date->Visible) { // created_date ?>
		<th class="<?php echo $tb_jbt->created_date->HeaderCellClass() ?>"><span id="elh_tb_jbt_created_date" class="tb_jbt_created_date"><?php echo $tb_jbt->created_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->last_update_by->Visible) { // last_update_by ?>
		<th class="<?php echo $tb_jbt->last_update_by->HeaderCellClass() ?>"><span id="elh_tb_jbt_last_update_by" class="tb_jbt_last_update_by"><?php echo $tb_jbt->last_update_by->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->last_update_date->Visible) { // last_update_date ?>
		<th class="<?php echo $tb_jbt->last_update_date->HeaderCellClass() ?>"><span id="elh_tb_jbt_last_update_date" class="tb_jbt_last_update_date"><?php echo $tb_jbt->last_update_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->kd_jbt_old->Visible) { // kd_jbt_old ?>
		<th class="<?php echo $tb_jbt->kd_jbt_old->HeaderCellClass() ?>"><span id="elh_tb_jbt_kd_jbt_old" class="tb_jbt_kd_jbt_old"><?php echo $tb_jbt->kd_jbt_old->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->ket_old->Visible) { // ket_old ?>
		<th class="<?php echo $tb_jbt->ket_old->HeaderCellClass() ?>"><span id="elh_tb_jbt_ket_old" class="tb_jbt_ket_old"><?php echo $tb_jbt->ket_old->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->jbt_type->Visible) { // jbt_type ?>
		<th class="<?php echo $tb_jbt->jbt_type->HeaderCellClass() ?>"><span id="elh_tb_jbt_jbt_type" class="tb_jbt_jbt_type"><?php echo $tb_jbt->jbt_type->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->org_id->Visible) { // org_id ?>
		<th class="<?php echo $tb_jbt->org_id->HeaderCellClass() ?>"><span id="elh_tb_jbt_org_id" class="tb_jbt_org_id"><?php echo $tb_jbt->org_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->parent_kd_jbt->Visible) { // parent_kd_jbt ?>
		<th class="<?php echo $tb_jbt->parent_kd_jbt->HeaderCellClass() ?>"><span id="elh_tb_jbt_parent_kd_jbt" class="tb_jbt_parent_kd_jbt"><?php echo $tb_jbt->parent_kd_jbt->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->eselon_num->Visible) { // eselon_num ?>
		<th class="<?php echo $tb_jbt->eselon_num->HeaderCellClass() ?>"><span id="elh_tb_jbt_eselon_num" class="tb_jbt_eselon_num"><?php echo $tb_jbt->eselon_num->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->jns_jbt->Visible) { // jns_jbt ?>
		<th class="<?php echo $tb_jbt->jns_jbt->HeaderCellClass() ?>"><span id="elh_tb_jbt_jns_jbt" class="tb_jbt_jns_jbt"><?php echo $tb_jbt->jns_jbt->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_jbt->status->Visible) { // status ?>
		<th class="<?php echo $tb_jbt->status->HeaderCellClass() ?>"><span id="elh_tb_jbt_status" class="tb_jbt_status"><?php echo $tb_jbt->status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tb_jbt_delete->RecCnt = 0;
$i = 0;
while (!$tb_jbt_delete->Recordset->EOF) {
	$tb_jbt_delete->RecCnt++;
	$tb_jbt_delete->RowCnt++;

	// Set row properties
	$tb_jbt->ResetAttrs();
	$tb_jbt->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tb_jbt_delete->LoadRowValues($tb_jbt_delete->Recordset);

	// Render row
	$tb_jbt_delete->RenderRow();
?>
	<tr<?php echo $tb_jbt->RowAttributes() ?>>
<?php if ($tb_jbt->kd_jbt->Visible) { // kd_jbt ?>
		<td<?php echo $tb_jbt->kd_jbt->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_kd_jbt" class="tb_jbt_kd_jbt">
<span<?php echo $tb_jbt->kd_jbt->ViewAttributes() ?>>
<?php echo $tb_jbt->kd_jbt->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->ket->Visible) { // ket ?>
		<td<?php echo $tb_jbt->ket->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_ket" class="tb_jbt_ket">
<span<?php echo $tb_jbt->ket->ViewAttributes() ?>>
<?php echo $tb_jbt->ket->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->tjb->Visible) { // tjb ?>
		<td<?php echo $tb_jbt->tjb->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_tjb" class="tb_jbt_tjb">
<span<?php echo $tb_jbt->tjb->ViewAttributes() ?>>
<?php echo $tb_jbt->tjb->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->koef->Visible) { // koef ?>
		<td<?php echo $tb_jbt->koef->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_koef" class="tb_jbt_koef">
<span<?php echo $tb_jbt->koef->ViewAttributes() ?>>
<?php echo $tb_jbt->koef->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->created_by->Visible) { // created_by ?>
		<td<?php echo $tb_jbt->created_by->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_created_by" class="tb_jbt_created_by">
<span<?php echo $tb_jbt->created_by->ViewAttributes() ?>>
<?php echo $tb_jbt->created_by->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->created_date->Visible) { // created_date ?>
		<td<?php echo $tb_jbt->created_date->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_created_date" class="tb_jbt_created_date">
<span<?php echo $tb_jbt->created_date->ViewAttributes() ?>>
<?php echo $tb_jbt->created_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->last_update_by->Visible) { // last_update_by ?>
		<td<?php echo $tb_jbt->last_update_by->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_last_update_by" class="tb_jbt_last_update_by">
<span<?php echo $tb_jbt->last_update_by->ViewAttributes() ?>>
<?php echo $tb_jbt->last_update_by->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->last_update_date->Visible) { // last_update_date ?>
		<td<?php echo $tb_jbt->last_update_date->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_last_update_date" class="tb_jbt_last_update_date">
<span<?php echo $tb_jbt->last_update_date->ViewAttributes() ?>>
<?php echo $tb_jbt->last_update_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->kd_jbt_old->Visible) { // kd_jbt_old ?>
		<td<?php echo $tb_jbt->kd_jbt_old->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_kd_jbt_old" class="tb_jbt_kd_jbt_old">
<span<?php echo $tb_jbt->kd_jbt_old->ViewAttributes() ?>>
<?php echo $tb_jbt->kd_jbt_old->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->ket_old->Visible) { // ket_old ?>
		<td<?php echo $tb_jbt->ket_old->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_ket_old" class="tb_jbt_ket_old">
<span<?php echo $tb_jbt->ket_old->ViewAttributes() ?>>
<?php echo $tb_jbt->ket_old->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->jbt_type->Visible) { // jbt_type ?>
		<td<?php echo $tb_jbt->jbt_type->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_jbt_type" class="tb_jbt_jbt_type">
<span<?php echo $tb_jbt->jbt_type->ViewAttributes() ?>>
<?php echo $tb_jbt->jbt_type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->org_id->Visible) { // org_id ?>
		<td<?php echo $tb_jbt->org_id->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_org_id" class="tb_jbt_org_id">
<span<?php echo $tb_jbt->org_id->ViewAttributes() ?>>
<?php echo $tb_jbt->org_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->parent_kd_jbt->Visible) { // parent_kd_jbt ?>
		<td<?php echo $tb_jbt->parent_kd_jbt->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_parent_kd_jbt" class="tb_jbt_parent_kd_jbt">
<span<?php echo $tb_jbt->parent_kd_jbt->ViewAttributes() ?>>
<?php echo $tb_jbt->parent_kd_jbt->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->eselon_num->Visible) { // eselon_num ?>
		<td<?php echo $tb_jbt->eselon_num->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_eselon_num" class="tb_jbt_eselon_num">
<span<?php echo $tb_jbt->eselon_num->ViewAttributes() ?>>
<?php echo $tb_jbt->eselon_num->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->jns_jbt->Visible) { // jns_jbt ?>
		<td<?php echo $tb_jbt->jns_jbt->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_jns_jbt" class="tb_jbt_jns_jbt">
<span<?php echo $tb_jbt->jns_jbt->ViewAttributes() ?>>
<?php echo $tb_jbt->jns_jbt->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_jbt->status->Visible) { // status ?>
		<td<?php echo $tb_jbt->status->CellAttributes() ?>>
<span id="el<?php echo $tb_jbt_delete->RowCnt ?>_tb_jbt_status" class="tb_jbt_status">
<span<?php echo $tb_jbt->status->ViewAttributes() ?>>
<?php echo $tb_jbt->status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tb_jbt_delete->Recordset->MoveNext();
}
$tb_jbt_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_jbt_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ftb_jbtdelete.Init();
</script>
<?php
$tb_jbt_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_jbt_delete->Page_Terminate();
?>
