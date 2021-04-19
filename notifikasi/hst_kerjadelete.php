<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "hst_kerjainfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$hst_kerja_delete = NULL; // Initialize page object first

class chst_kerja_delete extends chst_kerja {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'hst_kerja';

	// Page object name
	var $PageObjName = 'hst_kerja_delete';

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

		// Table object (hst_kerja)
		if (!isset($GLOBALS["hst_kerja"]) || get_class($GLOBALS["hst_kerja"]) == "chst_kerja") {
			$GLOBALS["hst_kerja"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hst_kerja"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hst_kerja', TRUE);

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
		$this->employee_id->SetVisibility();
		$this->kd_jbt->SetVisibility();
		$this->kd_pat->SetVisibility();
		$this->kd_jenjang->SetVisibility();
		$this->tgl_mulai->SetVisibility();
		$this->tgl_akhir->SetVisibility();
		$this->no_sk->SetVisibility();
		$this->ket->SetVisibility();
		$this->company->SetVisibility();
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();
		$this->st->SetVisibility();
		$this->kd_jbt_eselon->SetVisibility();

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
		global $EW_EXPORT, $hst_kerja;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($hst_kerja);
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
			$this->Page_Terminate("hst_kerjalist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in hst_kerja class, hst_kerjainfo.php

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
				$this->Page_Terminate("hst_kerjalist.php"); // Return to list
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
		$this->employee_id->setDbValue($row['employee_id']);
		$this->kd_jbt->setDbValue($row['kd_jbt']);
		$this->kd_pat->setDbValue($row['kd_pat']);
		$this->kd_jenjang->setDbValue($row['kd_jenjang']);
		$this->tgl_mulai->setDbValue($row['tgl_mulai']);
		$this->tgl_akhir->setDbValue($row['tgl_akhir']);
		$this->no_sk->setDbValue($row['no_sk']);
		$this->ket->setDbValue($row['ket']);
		$this->company->setDbValue($row['company']);
		$this->created_by->setDbValue($row['created_by']);
		$this->created_date->setDbValue($row['created_date']);
		$this->last_update_by->setDbValue($row['last_update_by']);
		$this->last_update_date->setDbValue($row['last_update_date']);
		$this->st->setDbValue($row['st']);
		$this->kd_jbt_eselon->setDbValue($row['kd_jbt_eselon']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['employee_id'] = NULL;
		$row['kd_jbt'] = NULL;
		$row['kd_pat'] = NULL;
		$row['kd_jenjang'] = NULL;
		$row['tgl_mulai'] = NULL;
		$row['tgl_akhir'] = NULL;
		$row['no_sk'] = NULL;
		$row['ket'] = NULL;
		$row['company'] = NULL;
		$row['created_by'] = NULL;
		$row['created_date'] = NULL;
		$row['last_update_by'] = NULL;
		$row['last_update_date'] = NULL;
		$row['st'] = NULL;
		$row['kd_jbt_eselon'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->employee_id->DbValue = $row['employee_id'];
		$this->kd_jbt->DbValue = $row['kd_jbt'];
		$this->kd_pat->DbValue = $row['kd_pat'];
		$this->kd_jenjang->DbValue = $row['kd_jenjang'];
		$this->tgl_mulai->DbValue = $row['tgl_mulai'];
		$this->tgl_akhir->DbValue = $row['tgl_akhir'];
		$this->no_sk->DbValue = $row['no_sk'];
		$this->ket->DbValue = $row['ket'];
		$this->company->DbValue = $row['company'];
		$this->created_by->DbValue = $row['created_by'];
		$this->created_date->DbValue = $row['created_date'];
		$this->last_update_by->DbValue = $row['last_update_by'];
		$this->last_update_date->DbValue = $row['last_update_date'];
		$this->st->DbValue = $row['st'];
		$this->kd_jbt_eselon->DbValue = $row['kd_jbt_eselon'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// employee_id
		// kd_jbt
		// kd_pat
		// kd_jenjang
		// tgl_mulai
		// tgl_akhir
		// no_sk
		// ket
		// company
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// st
		// kd_jbt_eselon

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// employee_id
		$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
		$this->employee_id->ViewCustomAttributes = "";

		// kd_jbt
		$this->kd_jbt->ViewValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// kd_pat
		$this->kd_pat->ViewValue = $this->kd_pat->CurrentValue;
		$this->kd_pat->ViewCustomAttributes = "";

		// kd_jenjang
		$this->kd_jenjang->ViewValue = $this->kd_jenjang->CurrentValue;
		$this->kd_jenjang->ViewCustomAttributes = "";

		// tgl_mulai
		$this->tgl_mulai->ViewValue = $this->tgl_mulai->CurrentValue;
		$this->tgl_mulai->ViewValue = ew_FormatDateTime($this->tgl_mulai->ViewValue, 0);
		$this->tgl_mulai->ViewCustomAttributes = "";

		// tgl_akhir
		$this->tgl_akhir->ViewValue = $this->tgl_akhir->CurrentValue;
		$this->tgl_akhir->ViewValue = ew_FormatDateTime($this->tgl_akhir->ViewValue, 0);
		$this->tgl_akhir->ViewCustomAttributes = "";

		// no_sk
		$this->no_sk->ViewValue = $this->no_sk->CurrentValue;
		$this->no_sk->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

		// company
		$this->company->ViewValue = $this->company->CurrentValue;
		$this->company->ViewCustomAttributes = "";

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

		// st
		$this->st->ViewValue = $this->st->CurrentValue;
		$this->st->ViewCustomAttributes = "";

		// kd_jbt_eselon
		$this->kd_jbt_eselon->ViewValue = $this->kd_jbt_eselon->CurrentValue;
		$this->kd_jbt_eselon->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// employee_id
			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";
			$this->employee_id->TooltipValue = "";

			// kd_jbt
			$this->kd_jbt->LinkCustomAttributes = "";
			$this->kd_jbt->HrefValue = "";
			$this->kd_jbt->TooltipValue = "";

			// kd_pat
			$this->kd_pat->LinkCustomAttributes = "";
			$this->kd_pat->HrefValue = "";
			$this->kd_pat->TooltipValue = "";

			// kd_jenjang
			$this->kd_jenjang->LinkCustomAttributes = "";
			$this->kd_jenjang->HrefValue = "";
			$this->kd_jenjang->TooltipValue = "";

			// tgl_mulai
			$this->tgl_mulai->LinkCustomAttributes = "";
			$this->tgl_mulai->HrefValue = "";
			$this->tgl_mulai->TooltipValue = "";

			// tgl_akhir
			$this->tgl_akhir->LinkCustomAttributes = "";
			$this->tgl_akhir->HrefValue = "";
			$this->tgl_akhir->TooltipValue = "";

			// no_sk
			$this->no_sk->LinkCustomAttributes = "";
			$this->no_sk->HrefValue = "";
			$this->no_sk->TooltipValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";
			$this->ket->TooltipValue = "";

			// company
			$this->company->LinkCustomAttributes = "";
			$this->company->HrefValue = "";
			$this->company->TooltipValue = "";

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

			// st
			$this->st->LinkCustomAttributes = "";
			$this->st->HrefValue = "";
			$this->st->TooltipValue = "";

			// kd_jbt_eselon
			$this->kd_jbt_eselon->LinkCustomAttributes = "";
			$this->kd_jbt_eselon->HrefValue = "";
			$this->kd_jbt_eselon->TooltipValue = "";
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
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['employee_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['kd_jbt'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['kd_pat'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['kd_jenjang'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hst_kerjalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hst_kerja_delete)) $hst_kerja_delete = new chst_kerja_delete();

// Page init
$hst_kerja_delete->Page_Init();

// Page main
$hst_kerja_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hst_kerja_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fhst_kerjadelete = new ew_Form("fhst_kerjadelete", "delete");

// Form_CustomValidate event
fhst_kerjadelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fhst_kerjadelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $hst_kerja_delete->ShowPageHeader(); ?>
<?php
$hst_kerja_delete->ShowMessage();
?>
<form name="fhst_kerjadelete" id="fhst_kerjadelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hst_kerja_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hst_kerja_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hst_kerja">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($hst_kerja_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($hst_kerja->id->Visible) { // id ?>
		<th class="<?php echo $hst_kerja->id->HeaderCellClass() ?>"><span id="elh_hst_kerja_id" class="hst_kerja_id"><?php echo $hst_kerja->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->employee_id->Visible) { // employee_id ?>
		<th class="<?php echo $hst_kerja->employee_id->HeaderCellClass() ?>"><span id="elh_hst_kerja_employee_id" class="hst_kerja_employee_id"><?php echo $hst_kerja->employee_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->kd_jbt->Visible) { // kd_jbt ?>
		<th class="<?php echo $hst_kerja->kd_jbt->HeaderCellClass() ?>"><span id="elh_hst_kerja_kd_jbt" class="hst_kerja_kd_jbt"><?php echo $hst_kerja->kd_jbt->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->kd_pat->Visible) { // kd_pat ?>
		<th class="<?php echo $hst_kerja->kd_pat->HeaderCellClass() ?>"><span id="elh_hst_kerja_kd_pat" class="hst_kerja_kd_pat"><?php echo $hst_kerja->kd_pat->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->kd_jenjang->Visible) { // kd_jenjang ?>
		<th class="<?php echo $hst_kerja->kd_jenjang->HeaderCellClass() ?>"><span id="elh_hst_kerja_kd_jenjang" class="hst_kerja_kd_jenjang"><?php echo $hst_kerja->kd_jenjang->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->tgl_mulai->Visible) { // tgl_mulai ?>
		<th class="<?php echo $hst_kerja->tgl_mulai->HeaderCellClass() ?>"><span id="elh_hst_kerja_tgl_mulai" class="hst_kerja_tgl_mulai"><?php echo $hst_kerja->tgl_mulai->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->tgl_akhir->Visible) { // tgl_akhir ?>
		<th class="<?php echo $hst_kerja->tgl_akhir->HeaderCellClass() ?>"><span id="elh_hst_kerja_tgl_akhir" class="hst_kerja_tgl_akhir"><?php echo $hst_kerja->tgl_akhir->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->no_sk->Visible) { // no_sk ?>
		<th class="<?php echo $hst_kerja->no_sk->HeaderCellClass() ?>"><span id="elh_hst_kerja_no_sk" class="hst_kerja_no_sk"><?php echo $hst_kerja->no_sk->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->ket->Visible) { // ket ?>
		<th class="<?php echo $hst_kerja->ket->HeaderCellClass() ?>"><span id="elh_hst_kerja_ket" class="hst_kerja_ket"><?php echo $hst_kerja->ket->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->company->Visible) { // company ?>
		<th class="<?php echo $hst_kerja->company->HeaderCellClass() ?>"><span id="elh_hst_kerja_company" class="hst_kerja_company"><?php echo $hst_kerja->company->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->created_by->Visible) { // created_by ?>
		<th class="<?php echo $hst_kerja->created_by->HeaderCellClass() ?>"><span id="elh_hst_kerja_created_by" class="hst_kerja_created_by"><?php echo $hst_kerja->created_by->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->created_date->Visible) { // created_date ?>
		<th class="<?php echo $hst_kerja->created_date->HeaderCellClass() ?>"><span id="elh_hst_kerja_created_date" class="hst_kerja_created_date"><?php echo $hst_kerja->created_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->last_update_by->Visible) { // last_update_by ?>
		<th class="<?php echo $hst_kerja->last_update_by->HeaderCellClass() ?>"><span id="elh_hst_kerja_last_update_by" class="hst_kerja_last_update_by"><?php echo $hst_kerja->last_update_by->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->last_update_date->Visible) { // last_update_date ?>
		<th class="<?php echo $hst_kerja->last_update_date->HeaderCellClass() ?>"><span id="elh_hst_kerja_last_update_date" class="hst_kerja_last_update_date"><?php echo $hst_kerja->last_update_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->st->Visible) { // st ?>
		<th class="<?php echo $hst_kerja->st->HeaderCellClass() ?>"><span id="elh_hst_kerja_st" class="hst_kerja_st"><?php echo $hst_kerja->st->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hst_kerja->kd_jbt_eselon->Visible) { // kd_jbt_eselon ?>
		<th class="<?php echo $hst_kerja->kd_jbt_eselon->HeaderCellClass() ?>"><span id="elh_hst_kerja_kd_jbt_eselon" class="hst_kerja_kd_jbt_eselon"><?php echo $hst_kerja->kd_jbt_eselon->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$hst_kerja_delete->RecCnt = 0;
$i = 0;
while (!$hst_kerja_delete->Recordset->EOF) {
	$hst_kerja_delete->RecCnt++;
	$hst_kerja_delete->RowCnt++;

	// Set row properties
	$hst_kerja->ResetAttrs();
	$hst_kerja->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$hst_kerja_delete->LoadRowValues($hst_kerja_delete->Recordset);

	// Render row
	$hst_kerja_delete->RenderRow();
?>
	<tr<?php echo $hst_kerja->RowAttributes() ?>>
<?php if ($hst_kerja->id->Visible) { // id ?>
		<td<?php echo $hst_kerja->id->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_id" class="hst_kerja_id">
<span<?php echo $hst_kerja->id->ViewAttributes() ?>>
<?php echo $hst_kerja->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->employee_id->Visible) { // employee_id ?>
		<td<?php echo $hst_kerja->employee_id->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_employee_id" class="hst_kerja_employee_id">
<span<?php echo $hst_kerja->employee_id->ViewAttributes() ?>>
<?php echo $hst_kerja->employee_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->kd_jbt->Visible) { // kd_jbt ?>
		<td<?php echo $hst_kerja->kd_jbt->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_kd_jbt" class="hst_kerja_kd_jbt">
<span<?php echo $hst_kerja->kd_jbt->ViewAttributes() ?>>
<?php echo $hst_kerja->kd_jbt->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->kd_pat->Visible) { // kd_pat ?>
		<td<?php echo $hst_kerja->kd_pat->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_kd_pat" class="hst_kerja_kd_pat">
<span<?php echo $hst_kerja->kd_pat->ViewAttributes() ?>>
<?php echo $hst_kerja->kd_pat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->kd_jenjang->Visible) { // kd_jenjang ?>
		<td<?php echo $hst_kerja->kd_jenjang->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_kd_jenjang" class="hst_kerja_kd_jenjang">
<span<?php echo $hst_kerja->kd_jenjang->ViewAttributes() ?>>
<?php echo $hst_kerja->kd_jenjang->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->tgl_mulai->Visible) { // tgl_mulai ?>
		<td<?php echo $hst_kerja->tgl_mulai->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_tgl_mulai" class="hst_kerja_tgl_mulai">
<span<?php echo $hst_kerja->tgl_mulai->ViewAttributes() ?>>
<?php echo $hst_kerja->tgl_mulai->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->tgl_akhir->Visible) { // tgl_akhir ?>
		<td<?php echo $hst_kerja->tgl_akhir->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_tgl_akhir" class="hst_kerja_tgl_akhir">
<span<?php echo $hst_kerja->tgl_akhir->ViewAttributes() ?>>
<?php echo $hst_kerja->tgl_akhir->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->no_sk->Visible) { // no_sk ?>
		<td<?php echo $hst_kerja->no_sk->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_no_sk" class="hst_kerja_no_sk">
<span<?php echo $hst_kerja->no_sk->ViewAttributes() ?>>
<?php echo $hst_kerja->no_sk->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->ket->Visible) { // ket ?>
		<td<?php echo $hst_kerja->ket->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_ket" class="hst_kerja_ket">
<span<?php echo $hst_kerja->ket->ViewAttributes() ?>>
<?php echo $hst_kerja->ket->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->company->Visible) { // company ?>
		<td<?php echo $hst_kerja->company->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_company" class="hst_kerja_company">
<span<?php echo $hst_kerja->company->ViewAttributes() ?>>
<?php echo $hst_kerja->company->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->created_by->Visible) { // created_by ?>
		<td<?php echo $hst_kerja->created_by->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_created_by" class="hst_kerja_created_by">
<span<?php echo $hst_kerja->created_by->ViewAttributes() ?>>
<?php echo $hst_kerja->created_by->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->created_date->Visible) { // created_date ?>
		<td<?php echo $hst_kerja->created_date->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_created_date" class="hst_kerja_created_date">
<span<?php echo $hst_kerja->created_date->ViewAttributes() ?>>
<?php echo $hst_kerja->created_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->last_update_by->Visible) { // last_update_by ?>
		<td<?php echo $hst_kerja->last_update_by->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_last_update_by" class="hst_kerja_last_update_by">
<span<?php echo $hst_kerja->last_update_by->ViewAttributes() ?>>
<?php echo $hst_kerja->last_update_by->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->last_update_date->Visible) { // last_update_date ?>
		<td<?php echo $hst_kerja->last_update_date->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_last_update_date" class="hst_kerja_last_update_date">
<span<?php echo $hst_kerja->last_update_date->ViewAttributes() ?>>
<?php echo $hst_kerja->last_update_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->st->Visible) { // st ?>
		<td<?php echo $hst_kerja->st->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_st" class="hst_kerja_st">
<span<?php echo $hst_kerja->st->ViewAttributes() ?>>
<?php echo $hst_kerja->st->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hst_kerja->kd_jbt_eselon->Visible) { // kd_jbt_eselon ?>
		<td<?php echo $hst_kerja->kd_jbt_eselon->CellAttributes() ?>>
<span id="el<?php echo $hst_kerja_delete->RowCnt ?>_hst_kerja_kd_jbt_eselon" class="hst_kerja_kd_jbt_eselon">
<span<?php echo $hst_kerja->kd_jbt_eselon->ViewAttributes() ?>>
<?php echo $hst_kerja->kd_jbt_eselon->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$hst_kerja_delete->Recordset->MoveNext();
}
$hst_kerja_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hst_kerja_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fhst_kerjadelete.Init();
</script>
<?php
$hst_kerja_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hst_kerja_delete->Page_Terminate();
?>
