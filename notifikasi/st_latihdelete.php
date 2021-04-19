<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "st_latihinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$st_latih_delete = NULL; // Initialize page object first

class cst_latih_delete extends cst_latih {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'st_latih';

	// Page object name
	var $PageObjName = 'st_latih_delete';

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

		// Table object (st_latih)
		if (!isset($GLOBALS["st_latih"]) || get_class($GLOBALS["st_latih"]) == "cst_latih") {
			$GLOBALS["st_latih"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["st_latih"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'st_latih', TRUE);

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
		$this->no_st->SetVisibility();
		$this->tgl_st->SetVisibility();
		$this->employee_id->SetVisibility();
		$this->kd_latih->SetVisibility();
		$this->tgl_mulai->SetVisibility();
		$this->tgl_akhir->SetVisibility();
		$this->kd_lmbg->SetVisibility();
		$this->kd_jbt->SetVisibility();
		$this->jam->SetVisibility();
		$this->tempat->SetVisibility();
		$this->app->SetVisibility();
		$this->app_empid->SetVisibility();
		$this->app_jbt->SetVisibility();
		$this->app_date->SetVisibility();
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();
		$this->sertifikat->SetVisibility();

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
		global $EW_EXPORT, $st_latih;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($st_latih);
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
			$this->Page_Terminate("st_latihlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in st_latih class, st_latihinfo.php

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
				$this->Page_Terminate("st_latihlist.php"); // Return to list
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
		$this->no_st->setDbValue($row['no_st']);
		$this->tgl_st->setDbValue($row['tgl_st']);
		$this->employee_id->setDbValue($row['employee_id']);
		$this->kd_latih->setDbValue($row['kd_latih']);
		$this->tgl_mulai->setDbValue($row['tgl_mulai']);
		$this->tgl_akhir->setDbValue($row['tgl_akhir']);
		$this->kd_lmbg->setDbValue($row['kd_lmbg']);
		$this->kd_jbt->setDbValue($row['kd_jbt']);
		$this->jam->setDbValue($row['jam']);
		$this->tempat->setDbValue($row['tempat']);
		$this->app->setDbValue($row['app']);
		$this->app_empid->setDbValue($row['app_empid']);
		$this->app_jbt->setDbValue($row['app_jbt']);
		$this->app_date->setDbValue($row['app_date']);
		$this->created_by->setDbValue($row['created_by']);
		$this->created_date->setDbValue($row['created_date']);
		$this->last_update_by->setDbValue($row['last_update_by']);
		$this->last_update_date->setDbValue($row['last_update_date']);
		$this->sertifikat->setDbValue($row['sertifikat']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['no_st'] = NULL;
		$row['tgl_st'] = NULL;
		$row['employee_id'] = NULL;
		$row['kd_latih'] = NULL;
		$row['tgl_mulai'] = NULL;
		$row['tgl_akhir'] = NULL;
		$row['kd_lmbg'] = NULL;
		$row['kd_jbt'] = NULL;
		$row['jam'] = NULL;
		$row['tempat'] = NULL;
		$row['app'] = NULL;
		$row['app_empid'] = NULL;
		$row['app_jbt'] = NULL;
		$row['app_date'] = NULL;
		$row['created_by'] = NULL;
		$row['created_date'] = NULL;
		$row['last_update_by'] = NULL;
		$row['last_update_date'] = NULL;
		$row['sertifikat'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->no_st->DbValue = $row['no_st'];
		$this->tgl_st->DbValue = $row['tgl_st'];
		$this->employee_id->DbValue = $row['employee_id'];
		$this->kd_latih->DbValue = $row['kd_latih'];
		$this->tgl_mulai->DbValue = $row['tgl_mulai'];
		$this->tgl_akhir->DbValue = $row['tgl_akhir'];
		$this->kd_lmbg->DbValue = $row['kd_lmbg'];
		$this->kd_jbt->DbValue = $row['kd_jbt'];
		$this->jam->DbValue = $row['jam'];
		$this->tempat->DbValue = $row['tempat'];
		$this->app->DbValue = $row['app'];
		$this->app_empid->DbValue = $row['app_empid'];
		$this->app_jbt->DbValue = $row['app_jbt'];
		$this->app_date->DbValue = $row['app_date'];
		$this->created_by->DbValue = $row['created_by'];
		$this->created_date->DbValue = $row['created_date'];
		$this->last_update_by->DbValue = $row['last_update_by'];
		$this->last_update_date->DbValue = $row['last_update_date'];
		$this->sertifikat->DbValue = $row['sertifikat'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// no_st
		// tgl_st
		// employee_id
		// kd_latih
		// tgl_mulai
		// tgl_akhir
		// kd_lmbg
		// kd_jbt
		// jam
		// tempat
		// app
		// app_empid
		// app_jbt
		// app_date
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// sertifikat

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// no_st
		$this->no_st->ViewValue = $this->no_st->CurrentValue;
		$this->no_st->ViewCustomAttributes = "";

		// tgl_st
		$this->tgl_st->ViewValue = $this->tgl_st->CurrentValue;
		$this->tgl_st->ViewValue = ew_FormatDateTime($this->tgl_st->ViewValue, 0);
		$this->tgl_st->ViewCustomAttributes = "";

		// employee_id
		$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
		$this->employee_id->ViewCustomAttributes = "";

		// kd_latih
		$this->kd_latih->ViewValue = $this->kd_latih->CurrentValue;
		$this->kd_latih->ViewCustomAttributes = "";

		// tgl_mulai
		$this->tgl_mulai->ViewValue = $this->tgl_mulai->CurrentValue;
		$this->tgl_mulai->ViewValue = ew_FormatDateTime($this->tgl_mulai->ViewValue, 0);
		$this->tgl_mulai->ViewCustomAttributes = "";

		// tgl_akhir
		$this->tgl_akhir->ViewValue = $this->tgl_akhir->CurrentValue;
		$this->tgl_akhir->ViewValue = ew_FormatDateTime($this->tgl_akhir->ViewValue, 0);
		$this->tgl_akhir->ViewCustomAttributes = "";

		// kd_lmbg
		$this->kd_lmbg->ViewValue = $this->kd_lmbg->CurrentValue;
		$this->kd_lmbg->ViewCustomAttributes = "";

		// kd_jbt
		$this->kd_jbt->ViewValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// jam
		$this->jam->ViewValue = $this->jam->CurrentValue;
		$this->jam->ViewCustomAttributes = "";

		// tempat
		$this->tempat->ViewValue = $this->tempat->CurrentValue;
		$this->tempat->ViewCustomAttributes = "";

		// app
		$this->app->ViewValue = $this->app->CurrentValue;
		$this->app->ViewCustomAttributes = "";

		// app_empid
		$this->app_empid->ViewValue = $this->app_empid->CurrentValue;
		$this->app_empid->ViewCustomAttributes = "";

		// app_jbt
		$this->app_jbt->ViewValue = $this->app_jbt->CurrentValue;
		$this->app_jbt->ViewCustomAttributes = "";

		// app_date
		$this->app_date->ViewValue = $this->app_date->CurrentValue;
		$this->app_date->ViewValue = ew_FormatDateTime($this->app_date->ViewValue, 0);
		$this->app_date->ViewCustomAttributes = "";

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

		// sertifikat
		$this->sertifikat->ViewValue = $this->sertifikat->CurrentValue;
		$this->sertifikat->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// no_st
			$this->no_st->LinkCustomAttributes = "";
			$this->no_st->HrefValue = "";
			$this->no_st->TooltipValue = "";

			// tgl_st
			$this->tgl_st->LinkCustomAttributes = "";
			$this->tgl_st->HrefValue = "";
			$this->tgl_st->TooltipValue = "";

			// employee_id
			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";
			$this->employee_id->TooltipValue = "";

			// kd_latih
			$this->kd_latih->LinkCustomAttributes = "";
			$this->kd_latih->HrefValue = "";
			$this->kd_latih->TooltipValue = "";

			// tgl_mulai
			$this->tgl_mulai->LinkCustomAttributes = "";
			$this->tgl_mulai->HrefValue = "";
			$this->tgl_mulai->TooltipValue = "";

			// tgl_akhir
			$this->tgl_akhir->LinkCustomAttributes = "";
			$this->tgl_akhir->HrefValue = "";
			$this->tgl_akhir->TooltipValue = "";

			// kd_lmbg
			$this->kd_lmbg->LinkCustomAttributes = "";
			$this->kd_lmbg->HrefValue = "";
			$this->kd_lmbg->TooltipValue = "";

			// kd_jbt
			$this->kd_jbt->LinkCustomAttributes = "";
			$this->kd_jbt->HrefValue = "";
			$this->kd_jbt->TooltipValue = "";

			// jam
			$this->jam->LinkCustomAttributes = "";
			$this->jam->HrefValue = "";
			$this->jam->TooltipValue = "";

			// tempat
			$this->tempat->LinkCustomAttributes = "";
			$this->tempat->HrefValue = "";
			$this->tempat->TooltipValue = "";

			// app
			$this->app->LinkCustomAttributes = "";
			$this->app->HrefValue = "";
			$this->app->TooltipValue = "";

			// app_empid
			$this->app_empid->LinkCustomAttributes = "";
			$this->app_empid->HrefValue = "";
			$this->app_empid->TooltipValue = "";

			// app_jbt
			$this->app_jbt->LinkCustomAttributes = "";
			$this->app_jbt->HrefValue = "";
			$this->app_jbt->TooltipValue = "";

			// app_date
			$this->app_date->LinkCustomAttributes = "";
			$this->app_date->HrefValue = "";
			$this->app_date->TooltipValue = "";

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

			// sertifikat
			$this->sertifikat->LinkCustomAttributes = "";
			$this->sertifikat->HrefValue = "";
			$this->sertifikat->TooltipValue = "";
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
				$sThisKey .= $row['no_st'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['employee_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("st_latihlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($st_latih_delete)) $st_latih_delete = new cst_latih_delete();

// Page init
$st_latih_delete->Page_Init();

// Page main
$st_latih_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$st_latih_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fst_latihdelete = new ew_Form("fst_latihdelete", "delete");

// Form_CustomValidate event
fst_latihdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fst_latihdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $st_latih_delete->ShowPageHeader(); ?>
<?php
$st_latih_delete->ShowMessage();
?>
<form name="fst_latihdelete" id="fst_latihdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($st_latih_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $st_latih_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="st_latih">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($st_latih_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($st_latih->id->Visible) { // id ?>
		<th class="<?php echo $st_latih->id->HeaderCellClass() ?>"><span id="elh_st_latih_id" class="st_latih_id"><?php echo $st_latih->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->no_st->Visible) { // no_st ?>
		<th class="<?php echo $st_latih->no_st->HeaderCellClass() ?>"><span id="elh_st_latih_no_st" class="st_latih_no_st"><?php echo $st_latih->no_st->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->tgl_st->Visible) { // tgl_st ?>
		<th class="<?php echo $st_latih->tgl_st->HeaderCellClass() ?>"><span id="elh_st_latih_tgl_st" class="st_latih_tgl_st"><?php echo $st_latih->tgl_st->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->employee_id->Visible) { // employee_id ?>
		<th class="<?php echo $st_latih->employee_id->HeaderCellClass() ?>"><span id="elh_st_latih_employee_id" class="st_latih_employee_id"><?php echo $st_latih->employee_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->kd_latih->Visible) { // kd_latih ?>
		<th class="<?php echo $st_latih->kd_latih->HeaderCellClass() ?>"><span id="elh_st_latih_kd_latih" class="st_latih_kd_latih"><?php echo $st_latih->kd_latih->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->tgl_mulai->Visible) { // tgl_mulai ?>
		<th class="<?php echo $st_latih->tgl_mulai->HeaderCellClass() ?>"><span id="elh_st_latih_tgl_mulai" class="st_latih_tgl_mulai"><?php echo $st_latih->tgl_mulai->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->tgl_akhir->Visible) { // tgl_akhir ?>
		<th class="<?php echo $st_latih->tgl_akhir->HeaderCellClass() ?>"><span id="elh_st_latih_tgl_akhir" class="st_latih_tgl_akhir"><?php echo $st_latih->tgl_akhir->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->kd_lmbg->Visible) { // kd_lmbg ?>
		<th class="<?php echo $st_latih->kd_lmbg->HeaderCellClass() ?>"><span id="elh_st_latih_kd_lmbg" class="st_latih_kd_lmbg"><?php echo $st_latih->kd_lmbg->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->kd_jbt->Visible) { // kd_jbt ?>
		<th class="<?php echo $st_latih->kd_jbt->HeaderCellClass() ?>"><span id="elh_st_latih_kd_jbt" class="st_latih_kd_jbt"><?php echo $st_latih->kd_jbt->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->jam->Visible) { // jam ?>
		<th class="<?php echo $st_latih->jam->HeaderCellClass() ?>"><span id="elh_st_latih_jam" class="st_latih_jam"><?php echo $st_latih->jam->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->tempat->Visible) { // tempat ?>
		<th class="<?php echo $st_latih->tempat->HeaderCellClass() ?>"><span id="elh_st_latih_tempat" class="st_latih_tempat"><?php echo $st_latih->tempat->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->app->Visible) { // app ?>
		<th class="<?php echo $st_latih->app->HeaderCellClass() ?>"><span id="elh_st_latih_app" class="st_latih_app"><?php echo $st_latih->app->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->app_empid->Visible) { // app_empid ?>
		<th class="<?php echo $st_latih->app_empid->HeaderCellClass() ?>"><span id="elh_st_latih_app_empid" class="st_latih_app_empid"><?php echo $st_latih->app_empid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->app_jbt->Visible) { // app_jbt ?>
		<th class="<?php echo $st_latih->app_jbt->HeaderCellClass() ?>"><span id="elh_st_latih_app_jbt" class="st_latih_app_jbt"><?php echo $st_latih->app_jbt->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->app_date->Visible) { // app_date ?>
		<th class="<?php echo $st_latih->app_date->HeaderCellClass() ?>"><span id="elh_st_latih_app_date" class="st_latih_app_date"><?php echo $st_latih->app_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->created_by->Visible) { // created_by ?>
		<th class="<?php echo $st_latih->created_by->HeaderCellClass() ?>"><span id="elh_st_latih_created_by" class="st_latih_created_by"><?php echo $st_latih->created_by->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->created_date->Visible) { // created_date ?>
		<th class="<?php echo $st_latih->created_date->HeaderCellClass() ?>"><span id="elh_st_latih_created_date" class="st_latih_created_date"><?php echo $st_latih->created_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->last_update_by->Visible) { // last_update_by ?>
		<th class="<?php echo $st_latih->last_update_by->HeaderCellClass() ?>"><span id="elh_st_latih_last_update_by" class="st_latih_last_update_by"><?php echo $st_latih->last_update_by->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->last_update_date->Visible) { // last_update_date ?>
		<th class="<?php echo $st_latih->last_update_date->HeaderCellClass() ?>"><span id="elh_st_latih_last_update_date" class="st_latih_last_update_date"><?php echo $st_latih->last_update_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($st_latih->sertifikat->Visible) { // sertifikat ?>
		<th class="<?php echo $st_latih->sertifikat->HeaderCellClass() ?>"><span id="elh_st_latih_sertifikat" class="st_latih_sertifikat"><?php echo $st_latih->sertifikat->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$st_latih_delete->RecCnt = 0;
$i = 0;
while (!$st_latih_delete->Recordset->EOF) {
	$st_latih_delete->RecCnt++;
	$st_latih_delete->RowCnt++;

	// Set row properties
	$st_latih->ResetAttrs();
	$st_latih->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$st_latih_delete->LoadRowValues($st_latih_delete->Recordset);

	// Render row
	$st_latih_delete->RenderRow();
?>
	<tr<?php echo $st_latih->RowAttributes() ?>>
<?php if ($st_latih->id->Visible) { // id ?>
		<td<?php echo $st_latih->id->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_id" class="st_latih_id">
<span<?php echo $st_latih->id->ViewAttributes() ?>>
<?php echo $st_latih->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->no_st->Visible) { // no_st ?>
		<td<?php echo $st_latih->no_st->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_no_st" class="st_latih_no_st">
<span<?php echo $st_latih->no_st->ViewAttributes() ?>>
<?php echo $st_latih->no_st->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->tgl_st->Visible) { // tgl_st ?>
		<td<?php echo $st_latih->tgl_st->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_tgl_st" class="st_latih_tgl_st">
<span<?php echo $st_latih->tgl_st->ViewAttributes() ?>>
<?php echo $st_latih->tgl_st->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->employee_id->Visible) { // employee_id ?>
		<td<?php echo $st_latih->employee_id->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_employee_id" class="st_latih_employee_id">
<span<?php echo $st_latih->employee_id->ViewAttributes() ?>>
<?php echo $st_latih->employee_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->kd_latih->Visible) { // kd_latih ?>
		<td<?php echo $st_latih->kd_latih->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_kd_latih" class="st_latih_kd_latih">
<span<?php echo $st_latih->kd_latih->ViewAttributes() ?>>
<?php echo $st_latih->kd_latih->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->tgl_mulai->Visible) { // tgl_mulai ?>
		<td<?php echo $st_latih->tgl_mulai->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_tgl_mulai" class="st_latih_tgl_mulai">
<span<?php echo $st_latih->tgl_mulai->ViewAttributes() ?>>
<?php echo $st_latih->tgl_mulai->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->tgl_akhir->Visible) { // tgl_akhir ?>
		<td<?php echo $st_latih->tgl_akhir->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_tgl_akhir" class="st_latih_tgl_akhir">
<span<?php echo $st_latih->tgl_akhir->ViewAttributes() ?>>
<?php echo $st_latih->tgl_akhir->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->kd_lmbg->Visible) { // kd_lmbg ?>
		<td<?php echo $st_latih->kd_lmbg->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_kd_lmbg" class="st_latih_kd_lmbg">
<span<?php echo $st_latih->kd_lmbg->ViewAttributes() ?>>
<?php echo $st_latih->kd_lmbg->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->kd_jbt->Visible) { // kd_jbt ?>
		<td<?php echo $st_latih->kd_jbt->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_kd_jbt" class="st_latih_kd_jbt">
<span<?php echo $st_latih->kd_jbt->ViewAttributes() ?>>
<?php echo $st_latih->kd_jbt->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->jam->Visible) { // jam ?>
		<td<?php echo $st_latih->jam->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_jam" class="st_latih_jam">
<span<?php echo $st_latih->jam->ViewAttributes() ?>>
<?php echo $st_latih->jam->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->tempat->Visible) { // tempat ?>
		<td<?php echo $st_latih->tempat->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_tempat" class="st_latih_tempat">
<span<?php echo $st_latih->tempat->ViewAttributes() ?>>
<?php echo $st_latih->tempat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->app->Visible) { // app ?>
		<td<?php echo $st_latih->app->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_app" class="st_latih_app">
<span<?php echo $st_latih->app->ViewAttributes() ?>>
<?php echo $st_latih->app->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->app_empid->Visible) { // app_empid ?>
		<td<?php echo $st_latih->app_empid->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_app_empid" class="st_latih_app_empid">
<span<?php echo $st_latih->app_empid->ViewAttributes() ?>>
<?php echo $st_latih->app_empid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->app_jbt->Visible) { // app_jbt ?>
		<td<?php echo $st_latih->app_jbt->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_app_jbt" class="st_latih_app_jbt">
<span<?php echo $st_latih->app_jbt->ViewAttributes() ?>>
<?php echo $st_latih->app_jbt->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->app_date->Visible) { // app_date ?>
		<td<?php echo $st_latih->app_date->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_app_date" class="st_latih_app_date">
<span<?php echo $st_latih->app_date->ViewAttributes() ?>>
<?php echo $st_latih->app_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->created_by->Visible) { // created_by ?>
		<td<?php echo $st_latih->created_by->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_created_by" class="st_latih_created_by">
<span<?php echo $st_latih->created_by->ViewAttributes() ?>>
<?php echo $st_latih->created_by->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->created_date->Visible) { // created_date ?>
		<td<?php echo $st_latih->created_date->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_created_date" class="st_latih_created_date">
<span<?php echo $st_latih->created_date->ViewAttributes() ?>>
<?php echo $st_latih->created_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->last_update_by->Visible) { // last_update_by ?>
		<td<?php echo $st_latih->last_update_by->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_last_update_by" class="st_latih_last_update_by">
<span<?php echo $st_latih->last_update_by->ViewAttributes() ?>>
<?php echo $st_latih->last_update_by->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->last_update_date->Visible) { // last_update_date ?>
		<td<?php echo $st_latih->last_update_date->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_last_update_date" class="st_latih_last_update_date">
<span<?php echo $st_latih->last_update_date->ViewAttributes() ?>>
<?php echo $st_latih->last_update_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($st_latih->sertifikat->Visible) { // sertifikat ?>
		<td<?php echo $st_latih->sertifikat->CellAttributes() ?>>
<span id="el<?php echo $st_latih_delete->RowCnt ?>_st_latih_sertifikat" class="st_latih_sertifikat">
<span<?php echo $st_latih->sertifikat->ViewAttributes() ?>>
<?php echo $st_latih->sertifikat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$st_latih_delete->Recordset->MoveNext();
}
$st_latih_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $st_latih_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fst_latihdelete.Init();
</script>
<?php
$st_latih_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$st_latih_delete->Page_Terminate();
?>
