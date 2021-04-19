<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "pendidikaninfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$pendidikan_delete = NULL; // Initialize page object first

class cpendidikan_delete extends cpendidikan {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'pendidikan';

	// Page object name
	var $PageObjName = 'pendidikan_delete';

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

		// Table object (pendidikan)
		if (!isset($GLOBALS["pendidikan"]) || get_class($GLOBALS["pendidikan"]) == "cpendidikan") {
			$GLOBALS["pendidikan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pendidikan"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pendidikan', TRUE);

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
		$this->kd_jenjang->SetVisibility();
		$this->kd_jurusan->SetVisibility();
		$this->kd_lmbg->SetVisibility();
		$this->ipk->SetVisibility();
		$this->ket->SetVisibility();
		$this->th_mulai->SetVisibility();
		$this->th_akhir->SetVisibility();
		$this->no_ijazah->SetVisibility();
		$this->tanggal_ijazah->SetVisibility();
		$this->upload_ijazah->SetVisibility();
		$this->lokasi_pendidikan->SetVisibility();
		$this->app->SetVisibility();
		$this->app_empid->SetVisibility();
		$this->app_jbt->SetVisibility();
		$this->app_date->SetVisibility();
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();

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
		global $EW_EXPORT, $pendidikan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pendidikan);
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
			$this->Page_Terminate("pendidikanlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in pendidikan class, pendidikaninfo.php

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
				$this->Page_Terminate("pendidikanlist.php"); // Return to list
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
		$this->kd_jenjang->setDbValue($row['kd_jenjang']);
		$this->kd_jurusan->setDbValue($row['kd_jurusan']);
		$this->kd_lmbg->setDbValue($row['kd_lmbg']);
		$this->ipk->setDbValue($row['ipk']);
		$this->ket->setDbValue($row['ket']);
		$this->th_mulai->setDbValue($row['th_mulai']);
		$this->th_akhir->setDbValue($row['th_akhir']);
		$this->no_ijazah->setDbValue($row['no_ijazah']);
		$this->tanggal_ijazah->setDbValue($row['tanggal_ijazah']);
		$this->upload_ijazah->setDbValue($row['upload_ijazah']);
		$this->lokasi_pendidikan->setDbValue($row['lokasi_pendidikan']);
		$this->app->setDbValue($row['app']);
		$this->app_empid->setDbValue($row['app_empid']);
		$this->app_jbt->setDbValue($row['app_jbt']);
		$this->app_date->setDbValue($row['app_date']);
		$this->created_by->setDbValue($row['created_by']);
		$this->created_date->setDbValue($row['created_date']);
		$this->last_update_by->setDbValue($row['last_update_by']);
		$this->last_update_date->setDbValue($row['last_update_date']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['employee_id'] = NULL;
		$row['kd_jenjang'] = NULL;
		$row['kd_jurusan'] = NULL;
		$row['kd_lmbg'] = NULL;
		$row['ipk'] = NULL;
		$row['ket'] = NULL;
		$row['th_mulai'] = NULL;
		$row['th_akhir'] = NULL;
		$row['no_ijazah'] = NULL;
		$row['tanggal_ijazah'] = NULL;
		$row['upload_ijazah'] = NULL;
		$row['lokasi_pendidikan'] = NULL;
		$row['app'] = NULL;
		$row['app_empid'] = NULL;
		$row['app_jbt'] = NULL;
		$row['app_date'] = NULL;
		$row['created_by'] = NULL;
		$row['created_date'] = NULL;
		$row['last_update_by'] = NULL;
		$row['last_update_date'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->employee_id->DbValue = $row['employee_id'];
		$this->kd_jenjang->DbValue = $row['kd_jenjang'];
		$this->kd_jurusan->DbValue = $row['kd_jurusan'];
		$this->kd_lmbg->DbValue = $row['kd_lmbg'];
		$this->ipk->DbValue = $row['ipk'];
		$this->ket->DbValue = $row['ket'];
		$this->th_mulai->DbValue = $row['th_mulai'];
		$this->th_akhir->DbValue = $row['th_akhir'];
		$this->no_ijazah->DbValue = $row['no_ijazah'];
		$this->tanggal_ijazah->DbValue = $row['tanggal_ijazah'];
		$this->upload_ijazah->DbValue = $row['upload_ijazah'];
		$this->lokasi_pendidikan->DbValue = $row['lokasi_pendidikan'];
		$this->app->DbValue = $row['app'];
		$this->app_empid->DbValue = $row['app_empid'];
		$this->app_jbt->DbValue = $row['app_jbt'];
		$this->app_date->DbValue = $row['app_date'];
		$this->created_by->DbValue = $row['created_by'];
		$this->created_date->DbValue = $row['created_date'];
		$this->last_update_by->DbValue = $row['last_update_by'];
		$this->last_update_date->DbValue = $row['last_update_date'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->ipk->FormValue == $this->ipk->CurrentValue && is_numeric(ew_StrToFloat($this->ipk->CurrentValue)))
			$this->ipk->CurrentValue = ew_StrToFloat($this->ipk->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// employee_id
		// kd_jenjang
		// kd_jurusan
		// kd_lmbg
		// ipk
		// ket
		// th_mulai
		// th_akhir
		// no_ijazah
		// tanggal_ijazah
		// upload_ijazah
		// lokasi_pendidikan
		// app
		// app_empid
		// app_jbt
		// app_date
		// created_by
		// created_date
		// last_update_by
		// last_update_date

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// employee_id
		$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
		$this->employee_id->ViewCustomAttributes = "";

		// kd_jenjang
		$this->kd_jenjang->ViewValue = $this->kd_jenjang->CurrentValue;
		$this->kd_jenjang->ViewCustomAttributes = "";

		// kd_jurusan
		$this->kd_jurusan->ViewValue = $this->kd_jurusan->CurrentValue;
		$this->kd_jurusan->ViewCustomAttributes = "";

		// kd_lmbg
		$this->kd_lmbg->ViewValue = $this->kd_lmbg->CurrentValue;
		$this->kd_lmbg->ViewCustomAttributes = "";

		// ipk
		$this->ipk->ViewValue = $this->ipk->CurrentValue;
		$this->ipk->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

		// th_mulai
		$this->th_mulai->ViewValue = $this->th_mulai->CurrentValue;
		$this->th_mulai->ViewCustomAttributes = "";

		// th_akhir
		$this->th_akhir->ViewValue = $this->th_akhir->CurrentValue;
		$this->th_akhir->ViewCustomAttributes = "";

		// no_ijazah
		$this->no_ijazah->ViewValue = $this->no_ijazah->CurrentValue;
		$this->no_ijazah->ViewCustomAttributes = "";

		// tanggal_ijazah
		$this->tanggal_ijazah->ViewValue = $this->tanggal_ijazah->CurrentValue;
		$this->tanggal_ijazah->ViewValue = ew_FormatDateTime($this->tanggal_ijazah->ViewValue, 0);
		$this->tanggal_ijazah->ViewCustomAttributes = "";

		// upload_ijazah
		$this->upload_ijazah->ViewValue = $this->upload_ijazah->CurrentValue;
		$this->upload_ijazah->ViewCustomAttributes = "";

		// lokasi_pendidikan
		$this->lokasi_pendidikan->ViewValue = $this->lokasi_pendidikan->CurrentValue;
		$this->lokasi_pendidikan->ViewCustomAttributes = "";

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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// employee_id
			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";
			$this->employee_id->TooltipValue = "";

			// kd_jenjang
			$this->kd_jenjang->LinkCustomAttributes = "";
			$this->kd_jenjang->HrefValue = "";
			$this->kd_jenjang->TooltipValue = "";

			// kd_jurusan
			$this->kd_jurusan->LinkCustomAttributes = "";
			$this->kd_jurusan->HrefValue = "";
			$this->kd_jurusan->TooltipValue = "";

			// kd_lmbg
			$this->kd_lmbg->LinkCustomAttributes = "";
			$this->kd_lmbg->HrefValue = "";
			$this->kd_lmbg->TooltipValue = "";

			// ipk
			$this->ipk->LinkCustomAttributes = "";
			$this->ipk->HrefValue = "";
			$this->ipk->TooltipValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";
			$this->ket->TooltipValue = "";

			// th_mulai
			$this->th_mulai->LinkCustomAttributes = "";
			$this->th_mulai->HrefValue = "";
			$this->th_mulai->TooltipValue = "";

			// th_akhir
			$this->th_akhir->LinkCustomAttributes = "";
			$this->th_akhir->HrefValue = "";
			$this->th_akhir->TooltipValue = "";

			// no_ijazah
			$this->no_ijazah->LinkCustomAttributes = "";
			$this->no_ijazah->HrefValue = "";
			$this->no_ijazah->TooltipValue = "";

			// tanggal_ijazah
			$this->tanggal_ijazah->LinkCustomAttributes = "";
			$this->tanggal_ijazah->HrefValue = "";
			$this->tanggal_ijazah->TooltipValue = "";

			// upload_ijazah
			$this->upload_ijazah->LinkCustomAttributes = "";
			$this->upload_ijazah->HrefValue = "";
			$this->upload_ijazah->TooltipValue = "";

			// lokasi_pendidikan
			$this->lokasi_pendidikan->LinkCustomAttributes = "";
			$this->lokasi_pendidikan->HrefValue = "";
			$this->lokasi_pendidikan->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pendidikanlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($pendidikan_delete)) $pendidikan_delete = new cpendidikan_delete();

// Page init
$pendidikan_delete->Page_Init();

// Page main
$pendidikan_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pendidikan_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fpendidikandelete = new ew_Form("fpendidikandelete", "delete");

// Form_CustomValidate event
fpendidikandelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fpendidikandelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $pendidikan_delete->ShowPageHeader(); ?>
<?php
$pendidikan_delete->ShowMessage();
?>
<form name="fpendidikandelete" id="fpendidikandelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pendidikan_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pendidikan_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pendidikan">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($pendidikan_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($pendidikan->id->Visible) { // id ?>
		<th class="<?php echo $pendidikan->id->HeaderCellClass() ?>"><span id="elh_pendidikan_id" class="pendidikan_id"><?php echo $pendidikan->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->employee_id->Visible) { // employee_id ?>
		<th class="<?php echo $pendidikan->employee_id->HeaderCellClass() ?>"><span id="elh_pendidikan_employee_id" class="pendidikan_employee_id"><?php echo $pendidikan->employee_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->kd_jenjang->Visible) { // kd_jenjang ?>
		<th class="<?php echo $pendidikan->kd_jenjang->HeaderCellClass() ?>"><span id="elh_pendidikan_kd_jenjang" class="pendidikan_kd_jenjang"><?php echo $pendidikan->kd_jenjang->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->kd_jurusan->Visible) { // kd_jurusan ?>
		<th class="<?php echo $pendidikan->kd_jurusan->HeaderCellClass() ?>"><span id="elh_pendidikan_kd_jurusan" class="pendidikan_kd_jurusan"><?php echo $pendidikan->kd_jurusan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->kd_lmbg->Visible) { // kd_lmbg ?>
		<th class="<?php echo $pendidikan->kd_lmbg->HeaderCellClass() ?>"><span id="elh_pendidikan_kd_lmbg" class="pendidikan_kd_lmbg"><?php echo $pendidikan->kd_lmbg->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->ipk->Visible) { // ipk ?>
		<th class="<?php echo $pendidikan->ipk->HeaderCellClass() ?>"><span id="elh_pendidikan_ipk" class="pendidikan_ipk"><?php echo $pendidikan->ipk->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->ket->Visible) { // ket ?>
		<th class="<?php echo $pendidikan->ket->HeaderCellClass() ?>"><span id="elh_pendidikan_ket" class="pendidikan_ket"><?php echo $pendidikan->ket->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->th_mulai->Visible) { // th_mulai ?>
		<th class="<?php echo $pendidikan->th_mulai->HeaderCellClass() ?>"><span id="elh_pendidikan_th_mulai" class="pendidikan_th_mulai"><?php echo $pendidikan->th_mulai->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->th_akhir->Visible) { // th_akhir ?>
		<th class="<?php echo $pendidikan->th_akhir->HeaderCellClass() ?>"><span id="elh_pendidikan_th_akhir" class="pendidikan_th_akhir"><?php echo $pendidikan->th_akhir->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->no_ijazah->Visible) { // no_ijazah ?>
		<th class="<?php echo $pendidikan->no_ijazah->HeaderCellClass() ?>"><span id="elh_pendidikan_no_ijazah" class="pendidikan_no_ijazah"><?php echo $pendidikan->no_ijazah->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->tanggal_ijazah->Visible) { // tanggal_ijazah ?>
		<th class="<?php echo $pendidikan->tanggal_ijazah->HeaderCellClass() ?>"><span id="elh_pendidikan_tanggal_ijazah" class="pendidikan_tanggal_ijazah"><?php echo $pendidikan->tanggal_ijazah->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->upload_ijazah->Visible) { // upload_ijazah ?>
		<th class="<?php echo $pendidikan->upload_ijazah->HeaderCellClass() ?>"><span id="elh_pendidikan_upload_ijazah" class="pendidikan_upload_ijazah"><?php echo $pendidikan->upload_ijazah->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->lokasi_pendidikan->Visible) { // lokasi_pendidikan ?>
		<th class="<?php echo $pendidikan->lokasi_pendidikan->HeaderCellClass() ?>"><span id="elh_pendidikan_lokasi_pendidikan" class="pendidikan_lokasi_pendidikan"><?php echo $pendidikan->lokasi_pendidikan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->app->Visible) { // app ?>
		<th class="<?php echo $pendidikan->app->HeaderCellClass() ?>"><span id="elh_pendidikan_app" class="pendidikan_app"><?php echo $pendidikan->app->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->app_empid->Visible) { // app_empid ?>
		<th class="<?php echo $pendidikan->app_empid->HeaderCellClass() ?>"><span id="elh_pendidikan_app_empid" class="pendidikan_app_empid"><?php echo $pendidikan->app_empid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->app_jbt->Visible) { // app_jbt ?>
		<th class="<?php echo $pendidikan->app_jbt->HeaderCellClass() ?>"><span id="elh_pendidikan_app_jbt" class="pendidikan_app_jbt"><?php echo $pendidikan->app_jbt->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->app_date->Visible) { // app_date ?>
		<th class="<?php echo $pendidikan->app_date->HeaderCellClass() ?>"><span id="elh_pendidikan_app_date" class="pendidikan_app_date"><?php echo $pendidikan->app_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->created_by->Visible) { // created_by ?>
		<th class="<?php echo $pendidikan->created_by->HeaderCellClass() ?>"><span id="elh_pendidikan_created_by" class="pendidikan_created_by"><?php echo $pendidikan->created_by->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->created_date->Visible) { // created_date ?>
		<th class="<?php echo $pendidikan->created_date->HeaderCellClass() ?>"><span id="elh_pendidikan_created_date" class="pendidikan_created_date"><?php echo $pendidikan->created_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->last_update_by->Visible) { // last_update_by ?>
		<th class="<?php echo $pendidikan->last_update_by->HeaderCellClass() ?>"><span id="elh_pendidikan_last_update_by" class="pendidikan_last_update_by"><?php echo $pendidikan->last_update_by->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pendidikan->last_update_date->Visible) { // last_update_date ?>
		<th class="<?php echo $pendidikan->last_update_date->HeaderCellClass() ?>"><span id="elh_pendidikan_last_update_date" class="pendidikan_last_update_date"><?php echo $pendidikan->last_update_date->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$pendidikan_delete->RecCnt = 0;
$i = 0;
while (!$pendidikan_delete->Recordset->EOF) {
	$pendidikan_delete->RecCnt++;
	$pendidikan_delete->RowCnt++;

	// Set row properties
	$pendidikan->ResetAttrs();
	$pendidikan->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$pendidikan_delete->LoadRowValues($pendidikan_delete->Recordset);

	// Render row
	$pendidikan_delete->RenderRow();
?>
	<tr<?php echo $pendidikan->RowAttributes() ?>>
<?php if ($pendidikan->id->Visible) { // id ?>
		<td<?php echo $pendidikan->id->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_id" class="pendidikan_id">
<span<?php echo $pendidikan->id->ViewAttributes() ?>>
<?php echo $pendidikan->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->employee_id->Visible) { // employee_id ?>
		<td<?php echo $pendidikan->employee_id->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_employee_id" class="pendidikan_employee_id">
<span<?php echo $pendidikan->employee_id->ViewAttributes() ?>>
<?php echo $pendidikan->employee_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->kd_jenjang->Visible) { // kd_jenjang ?>
		<td<?php echo $pendidikan->kd_jenjang->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_kd_jenjang" class="pendidikan_kd_jenjang">
<span<?php echo $pendidikan->kd_jenjang->ViewAttributes() ?>>
<?php echo $pendidikan->kd_jenjang->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->kd_jurusan->Visible) { // kd_jurusan ?>
		<td<?php echo $pendidikan->kd_jurusan->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_kd_jurusan" class="pendidikan_kd_jurusan">
<span<?php echo $pendidikan->kd_jurusan->ViewAttributes() ?>>
<?php echo $pendidikan->kd_jurusan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->kd_lmbg->Visible) { // kd_lmbg ?>
		<td<?php echo $pendidikan->kd_lmbg->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_kd_lmbg" class="pendidikan_kd_lmbg">
<span<?php echo $pendidikan->kd_lmbg->ViewAttributes() ?>>
<?php echo $pendidikan->kd_lmbg->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->ipk->Visible) { // ipk ?>
		<td<?php echo $pendidikan->ipk->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_ipk" class="pendidikan_ipk">
<span<?php echo $pendidikan->ipk->ViewAttributes() ?>>
<?php echo $pendidikan->ipk->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->ket->Visible) { // ket ?>
		<td<?php echo $pendidikan->ket->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_ket" class="pendidikan_ket">
<span<?php echo $pendidikan->ket->ViewAttributes() ?>>
<?php echo $pendidikan->ket->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->th_mulai->Visible) { // th_mulai ?>
		<td<?php echo $pendidikan->th_mulai->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_th_mulai" class="pendidikan_th_mulai">
<span<?php echo $pendidikan->th_mulai->ViewAttributes() ?>>
<?php echo $pendidikan->th_mulai->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->th_akhir->Visible) { // th_akhir ?>
		<td<?php echo $pendidikan->th_akhir->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_th_akhir" class="pendidikan_th_akhir">
<span<?php echo $pendidikan->th_akhir->ViewAttributes() ?>>
<?php echo $pendidikan->th_akhir->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->no_ijazah->Visible) { // no_ijazah ?>
		<td<?php echo $pendidikan->no_ijazah->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_no_ijazah" class="pendidikan_no_ijazah">
<span<?php echo $pendidikan->no_ijazah->ViewAttributes() ?>>
<?php echo $pendidikan->no_ijazah->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->tanggal_ijazah->Visible) { // tanggal_ijazah ?>
		<td<?php echo $pendidikan->tanggal_ijazah->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_tanggal_ijazah" class="pendidikan_tanggal_ijazah">
<span<?php echo $pendidikan->tanggal_ijazah->ViewAttributes() ?>>
<?php echo $pendidikan->tanggal_ijazah->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->upload_ijazah->Visible) { // upload_ijazah ?>
		<td<?php echo $pendidikan->upload_ijazah->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_upload_ijazah" class="pendidikan_upload_ijazah">
<span<?php echo $pendidikan->upload_ijazah->ViewAttributes() ?>>
<?php echo $pendidikan->upload_ijazah->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->lokasi_pendidikan->Visible) { // lokasi_pendidikan ?>
		<td<?php echo $pendidikan->lokasi_pendidikan->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_lokasi_pendidikan" class="pendidikan_lokasi_pendidikan">
<span<?php echo $pendidikan->lokasi_pendidikan->ViewAttributes() ?>>
<?php echo $pendidikan->lokasi_pendidikan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->app->Visible) { // app ?>
		<td<?php echo $pendidikan->app->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_app" class="pendidikan_app">
<span<?php echo $pendidikan->app->ViewAttributes() ?>>
<?php echo $pendidikan->app->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->app_empid->Visible) { // app_empid ?>
		<td<?php echo $pendidikan->app_empid->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_app_empid" class="pendidikan_app_empid">
<span<?php echo $pendidikan->app_empid->ViewAttributes() ?>>
<?php echo $pendidikan->app_empid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->app_jbt->Visible) { // app_jbt ?>
		<td<?php echo $pendidikan->app_jbt->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_app_jbt" class="pendidikan_app_jbt">
<span<?php echo $pendidikan->app_jbt->ViewAttributes() ?>>
<?php echo $pendidikan->app_jbt->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->app_date->Visible) { // app_date ?>
		<td<?php echo $pendidikan->app_date->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_app_date" class="pendidikan_app_date">
<span<?php echo $pendidikan->app_date->ViewAttributes() ?>>
<?php echo $pendidikan->app_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->created_by->Visible) { // created_by ?>
		<td<?php echo $pendidikan->created_by->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_created_by" class="pendidikan_created_by">
<span<?php echo $pendidikan->created_by->ViewAttributes() ?>>
<?php echo $pendidikan->created_by->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->created_date->Visible) { // created_date ?>
		<td<?php echo $pendidikan->created_date->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_created_date" class="pendidikan_created_date">
<span<?php echo $pendidikan->created_date->ViewAttributes() ?>>
<?php echo $pendidikan->created_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->last_update_by->Visible) { // last_update_by ?>
		<td<?php echo $pendidikan->last_update_by->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_last_update_by" class="pendidikan_last_update_by">
<span<?php echo $pendidikan->last_update_by->ViewAttributes() ?>>
<?php echo $pendidikan->last_update_by->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pendidikan->last_update_date->Visible) { // last_update_date ?>
		<td<?php echo $pendidikan->last_update_date->CellAttributes() ?>>
<span id="el<?php echo $pendidikan_delete->RowCnt ?>_pendidikan_last_update_date" class="pendidikan_last_update_date">
<span<?php echo $pendidikan->last_update_date->ViewAttributes() ?>>
<?php echo $pendidikan->last_update_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$pendidikan_delete->Recordset->MoveNext();
}
$pendidikan_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pendidikan_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fpendidikandelete.Init();
</script>
<?php
$pendidikan_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pendidikan_delete->Page_Terminate();
?>
