<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "rwy_persediaan_saham_pegawaiinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$rwy_persediaan_saham_pegawai_delete = NULL; // Initialize page object first

class crwy_persediaan_saham_pegawai_delete extends crwy_persediaan_saham_pegawai {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'rwy_persediaan_saham_pegawai';

	// Page object name
	var $PageObjName = 'rwy_persediaan_saham_pegawai_delete';

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

		// Table object (rwy_persediaan_saham_pegawai)
		if (!isset($GLOBALS["rwy_persediaan_saham_pegawai"]) || get_class($GLOBALS["rwy_persediaan_saham_pegawai"]) == "crwy_persediaan_saham_pegawai") {
			$GLOBALS["rwy_persediaan_saham_pegawai"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["rwy_persediaan_saham_pegawai"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rwy_persediaan_saham_pegawai', TRUE);

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
		$this->kode_unit_organisasi->SetVisibility();
		$this->kode_unit_kerja->SetVisibility();
		$this->periode_bulan->SetVisibility();
		$this->periode_tahun->SetVisibility();
		$this->industri_kontruksi_abim_ups_anak->SetVisibility();
		$this->realty_ups_anak->SetVisibility();
		$this->pst_ups_anak->SetVisibility();
		$this->wton_anak_ups_anak->SetVisibility();
		$this->industri_kontruksi_abim_ups_dianak->SetVisibility();
		$this->realty_ups_dianak->SetVisibility();
		$this->esa_dianak->SetVisibility();
		$this->esop_dianak->SetVisibility();
		$this->change_by->SetVisibility();
		$this->change_date->SetVisibility();

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
		global $EW_EXPORT, $rwy_persediaan_saham_pegawai;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($rwy_persediaan_saham_pegawai);
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
			$this->Page_Terminate("rwy_persediaan_saham_pegawailist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in rwy_persediaan_saham_pegawai class, rwy_persediaan_saham_pegawaiinfo.php

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
				$this->Page_Terminate("rwy_persediaan_saham_pegawailist.php"); // Return to list
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
		$this->kode_unit_organisasi->setDbValue($row['kode_unit_organisasi']);
		$this->kode_unit_kerja->setDbValue($row['kode_unit_kerja']);
		$this->periode_bulan->setDbValue($row['periode_bulan']);
		$this->periode_tahun->setDbValue($row['periode_tahun']);
		$this->industri_kontruksi_abim_ups_anak->setDbValue($row['industri_kontruksi_abim_ups_anak']);
		$this->realty_ups_anak->setDbValue($row['realty_ups_anak']);
		$this->pst_ups_anak->setDbValue($row['pst_ups_anak']);
		$this->wton_anak_ups_anak->setDbValue($row['wton_anak_ups_anak']);
		$this->industri_kontruksi_abim_ups_dianak->setDbValue($row['industri_kontruksi_abim_ups_dianak']);
		$this->realty_ups_dianak->setDbValue($row['realty_ups_dianak']);
		$this->esa_dianak->setDbValue($row['esa_dianak']);
		$this->esop_dianak->setDbValue($row['esop_dianak']);
		$this->change_by->setDbValue($row['change_by']);
		$this->change_date->setDbValue($row['change_date']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['nip'] = NULL;
		$row['kode_unit_organisasi'] = NULL;
		$row['kode_unit_kerja'] = NULL;
		$row['periode_bulan'] = NULL;
		$row['periode_tahun'] = NULL;
		$row['industri_kontruksi_abim_ups_anak'] = NULL;
		$row['realty_ups_anak'] = NULL;
		$row['pst_ups_anak'] = NULL;
		$row['wton_anak_ups_anak'] = NULL;
		$row['industri_kontruksi_abim_ups_dianak'] = NULL;
		$row['realty_ups_dianak'] = NULL;
		$row['esa_dianak'] = NULL;
		$row['esop_dianak'] = NULL;
		$row['change_by'] = NULL;
		$row['change_date'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->nip->DbValue = $row['nip'];
		$this->kode_unit_organisasi->DbValue = $row['kode_unit_organisasi'];
		$this->kode_unit_kerja->DbValue = $row['kode_unit_kerja'];
		$this->periode_bulan->DbValue = $row['periode_bulan'];
		$this->periode_tahun->DbValue = $row['periode_tahun'];
		$this->industri_kontruksi_abim_ups_anak->DbValue = $row['industri_kontruksi_abim_ups_anak'];
		$this->realty_ups_anak->DbValue = $row['realty_ups_anak'];
		$this->pst_ups_anak->DbValue = $row['pst_ups_anak'];
		$this->wton_anak_ups_anak->DbValue = $row['wton_anak_ups_anak'];
		$this->industri_kontruksi_abim_ups_dianak->DbValue = $row['industri_kontruksi_abim_ups_dianak'];
		$this->realty_ups_dianak->DbValue = $row['realty_ups_dianak'];
		$this->esa_dianak->DbValue = $row['esa_dianak'];
		$this->esop_dianak->DbValue = $row['esop_dianak'];
		$this->change_by->DbValue = $row['change_by'];
		$this->change_date->DbValue = $row['change_date'];
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
		// kode_unit_organisasi
		// kode_unit_kerja
		// periode_bulan
		// periode_tahun
		// industri_kontruksi_abim_ups_anak
		// realty_ups_anak
		// pst_ups_anak
		// wton_anak_ups_anak
		// industri_kontruksi_abim_ups_dianak
		// realty_ups_dianak
		// esa_dianak
		// esop_dianak
		// change_by
		// change_date

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nip
		$this->nip->ViewValue = $this->nip->CurrentValue;
		$this->nip->ViewCustomAttributes = "";

		// kode_unit_organisasi
		$this->kode_unit_organisasi->ViewValue = $this->kode_unit_organisasi->CurrentValue;
		$this->kode_unit_organisasi->ViewCustomAttributes = "";

		// kode_unit_kerja
		$this->kode_unit_kerja->ViewValue = $this->kode_unit_kerja->CurrentValue;
		$this->kode_unit_kerja->ViewCustomAttributes = "";

		// periode_bulan
		$this->periode_bulan->ViewValue = $this->periode_bulan->CurrentValue;
		$this->periode_bulan->ViewCustomAttributes = "";

		// periode_tahun
		$this->periode_tahun->ViewValue = $this->periode_tahun->CurrentValue;
		$this->periode_tahun->ViewCustomAttributes = "";

		// industri_kontruksi_abim_ups_anak
		$this->industri_kontruksi_abim_ups_anak->ViewValue = $this->industri_kontruksi_abim_ups_anak->CurrentValue;
		$this->industri_kontruksi_abim_ups_anak->ViewCustomAttributes = "";

		// realty_ups_anak
		$this->realty_ups_anak->ViewValue = $this->realty_ups_anak->CurrentValue;
		$this->realty_ups_anak->ViewCustomAttributes = "";

		// pst_ups_anak
		$this->pst_ups_anak->ViewValue = $this->pst_ups_anak->CurrentValue;
		$this->pst_ups_anak->ViewCustomAttributes = "";

		// wton_anak_ups_anak
		$this->wton_anak_ups_anak->ViewValue = $this->wton_anak_ups_anak->CurrentValue;
		$this->wton_anak_ups_anak->ViewCustomAttributes = "";

		// industri_kontruksi_abim_ups_dianak
		$this->industri_kontruksi_abim_ups_dianak->ViewValue = $this->industri_kontruksi_abim_ups_dianak->CurrentValue;
		$this->industri_kontruksi_abim_ups_dianak->ViewCustomAttributes = "";

		// realty_ups_dianak
		$this->realty_ups_dianak->ViewValue = $this->realty_ups_dianak->CurrentValue;
		$this->realty_ups_dianak->ViewCustomAttributes = "";

		// esa_dianak
		$this->esa_dianak->ViewValue = $this->esa_dianak->CurrentValue;
		$this->esa_dianak->ViewCustomAttributes = "";

		// esop_dianak
		$this->esop_dianak->ViewValue = $this->esop_dianak->CurrentValue;
		$this->esop_dianak->ViewCustomAttributes = "";

		// change_by
		$this->change_by->ViewValue = $this->change_by->CurrentValue;
		$this->change_by->ViewCustomAttributes = "";

		// change_date
		$this->change_date->ViewValue = $this->change_date->CurrentValue;
		$this->change_date->ViewValue = ew_FormatDateTime($this->change_date->ViewValue, 0);
		$this->change_date->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// nip
			$this->nip->LinkCustomAttributes = "";
			$this->nip->HrefValue = "";
			$this->nip->TooltipValue = "";

			// kode_unit_organisasi
			$this->kode_unit_organisasi->LinkCustomAttributes = "";
			$this->kode_unit_organisasi->HrefValue = "";
			$this->kode_unit_organisasi->TooltipValue = "";

			// kode_unit_kerja
			$this->kode_unit_kerja->LinkCustomAttributes = "";
			$this->kode_unit_kerja->HrefValue = "";
			$this->kode_unit_kerja->TooltipValue = "";

			// periode_bulan
			$this->periode_bulan->LinkCustomAttributes = "";
			$this->periode_bulan->HrefValue = "";
			$this->periode_bulan->TooltipValue = "";

			// periode_tahun
			$this->periode_tahun->LinkCustomAttributes = "";
			$this->periode_tahun->HrefValue = "";
			$this->periode_tahun->TooltipValue = "";

			// industri_kontruksi_abim_ups_anak
			$this->industri_kontruksi_abim_ups_anak->LinkCustomAttributes = "";
			$this->industri_kontruksi_abim_ups_anak->HrefValue = "";
			$this->industri_kontruksi_abim_ups_anak->TooltipValue = "";

			// realty_ups_anak
			$this->realty_ups_anak->LinkCustomAttributes = "";
			$this->realty_ups_anak->HrefValue = "";
			$this->realty_ups_anak->TooltipValue = "";

			// pst_ups_anak
			$this->pst_ups_anak->LinkCustomAttributes = "";
			$this->pst_ups_anak->HrefValue = "";
			$this->pst_ups_anak->TooltipValue = "";

			// wton_anak_ups_anak
			$this->wton_anak_ups_anak->LinkCustomAttributes = "";
			$this->wton_anak_ups_anak->HrefValue = "";
			$this->wton_anak_ups_anak->TooltipValue = "";

			// industri_kontruksi_abim_ups_dianak
			$this->industri_kontruksi_abim_ups_dianak->LinkCustomAttributes = "";
			$this->industri_kontruksi_abim_ups_dianak->HrefValue = "";
			$this->industri_kontruksi_abim_ups_dianak->TooltipValue = "";

			// realty_ups_dianak
			$this->realty_ups_dianak->LinkCustomAttributes = "";
			$this->realty_ups_dianak->HrefValue = "";
			$this->realty_ups_dianak->TooltipValue = "";

			// esa_dianak
			$this->esa_dianak->LinkCustomAttributes = "";
			$this->esa_dianak->HrefValue = "";
			$this->esa_dianak->TooltipValue = "";

			// esop_dianak
			$this->esop_dianak->LinkCustomAttributes = "";
			$this->esop_dianak->HrefValue = "";
			$this->esop_dianak->TooltipValue = "";

			// change_by
			$this->change_by->LinkCustomAttributes = "";
			$this->change_by->HrefValue = "";
			$this->change_by->TooltipValue = "";

			// change_date
			$this->change_date->LinkCustomAttributes = "";
			$this->change_date->HrefValue = "";
			$this->change_date->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("rwy_persediaan_saham_pegawailist.php"), "", $this->TableVar, TRUE);
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
if (!isset($rwy_persediaan_saham_pegawai_delete)) $rwy_persediaan_saham_pegawai_delete = new crwy_persediaan_saham_pegawai_delete();

// Page init
$rwy_persediaan_saham_pegawai_delete->Page_Init();

// Page main
$rwy_persediaan_saham_pegawai_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$rwy_persediaan_saham_pegawai_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = frwy_persediaan_saham_pegawaidelete = new ew_Form("frwy_persediaan_saham_pegawaidelete", "delete");

// Form_CustomValidate event
frwy_persediaan_saham_pegawaidelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
frwy_persediaan_saham_pegawaidelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $rwy_persediaan_saham_pegawai_delete->ShowPageHeader(); ?>
<?php
$rwy_persediaan_saham_pegawai_delete->ShowMessage();
?>
<form name="frwy_persediaan_saham_pegawaidelete" id="frwy_persediaan_saham_pegawaidelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($rwy_persediaan_saham_pegawai_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $rwy_persediaan_saham_pegawai_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="rwy_persediaan_saham_pegawai">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($rwy_persediaan_saham_pegawai_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($rwy_persediaan_saham_pegawai->id->Visible) { // id ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->id->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_id" class="rwy_persediaan_saham_pegawai_id"><?php echo $rwy_persediaan_saham_pegawai->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->nip->Visible) { // nip ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->nip->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_nip" class="rwy_persediaan_saham_pegawai_nip"><?php echo $rwy_persediaan_saham_pegawai->nip->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->kode_unit_organisasi->Visible) { // kode_unit_organisasi ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_kode_unit_organisasi" class="rwy_persediaan_saham_pegawai_kode_unit_organisasi"><?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->kode_unit_kerja->Visible) { // kode_unit_kerja ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_kode_unit_kerja" class="rwy_persediaan_saham_pegawai_kode_unit_kerja"><?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->periode_bulan->Visible) { // periode_bulan ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->periode_bulan->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_periode_bulan" class="rwy_persediaan_saham_pegawai_periode_bulan"><?php echo $rwy_persediaan_saham_pegawai->periode_bulan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->periode_tahun->Visible) { // periode_tahun ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->periode_tahun->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_periode_tahun" class="rwy_persediaan_saham_pegawai_periode_tahun"><?php echo $rwy_persediaan_saham_pegawai->periode_tahun->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->Visible) { // industri_kontruksi_abim_ups_anak ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_anak" class="rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_anak"><?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->realty_ups_anak->Visible) { // realty_ups_anak ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_realty_ups_anak" class="rwy_persediaan_saham_pegawai_realty_ups_anak"><?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->pst_ups_anak->Visible) { // pst_ups_anak ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_pst_ups_anak" class="rwy_persediaan_saham_pegawai_pst_ups_anak"><?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->wton_anak_ups_anak->Visible) { // wton_anak_ups_anak ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_wton_anak_ups_anak" class="rwy_persediaan_saham_pegawai_wton_anak_ups_anak"><?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->Visible) { // industri_kontruksi_abim_ups_dianak ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_dianak" class="rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_dianak"><?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->realty_ups_dianak->Visible) { // realty_ups_dianak ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_realty_ups_dianak" class="rwy_persediaan_saham_pegawai_realty_ups_dianak"><?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->esa_dianak->Visible) { // esa_dianak ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->esa_dianak->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_esa_dianak" class="rwy_persediaan_saham_pegawai_esa_dianak"><?php echo $rwy_persediaan_saham_pegawai->esa_dianak->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->esop_dianak->Visible) { // esop_dianak ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->esop_dianak->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_esop_dianak" class="rwy_persediaan_saham_pegawai_esop_dianak"><?php echo $rwy_persediaan_saham_pegawai->esop_dianak->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->change_by->Visible) { // change_by ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->change_by->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_change_by" class="rwy_persediaan_saham_pegawai_change_by"><?php echo $rwy_persediaan_saham_pegawai->change_by->FldCaption() ?></span></th>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->change_date->Visible) { // change_date ?>
		<th class="<?php echo $rwy_persediaan_saham_pegawai->change_date->HeaderCellClass() ?>"><span id="elh_rwy_persediaan_saham_pegawai_change_date" class="rwy_persediaan_saham_pegawai_change_date"><?php echo $rwy_persediaan_saham_pegawai->change_date->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$rwy_persediaan_saham_pegawai_delete->RecCnt = 0;
$i = 0;
while (!$rwy_persediaan_saham_pegawai_delete->Recordset->EOF) {
	$rwy_persediaan_saham_pegawai_delete->RecCnt++;
	$rwy_persediaan_saham_pegawai_delete->RowCnt++;

	// Set row properties
	$rwy_persediaan_saham_pegawai->ResetAttrs();
	$rwy_persediaan_saham_pegawai->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$rwy_persediaan_saham_pegawai_delete->LoadRowValues($rwy_persediaan_saham_pegawai_delete->Recordset);

	// Render row
	$rwy_persediaan_saham_pegawai_delete->RenderRow();
?>
	<tr<?php echo $rwy_persediaan_saham_pegawai->RowAttributes() ?>>
<?php if ($rwy_persediaan_saham_pegawai->id->Visible) { // id ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->id->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_id" class="rwy_persediaan_saham_pegawai_id">
<span<?php echo $rwy_persediaan_saham_pegawai->id->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->nip->Visible) { // nip ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->nip->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_nip" class="rwy_persediaan_saham_pegawai_nip">
<span<?php echo $rwy_persediaan_saham_pegawai->nip->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->nip->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->kode_unit_organisasi->Visible) { // kode_unit_organisasi ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_kode_unit_organisasi" class="rwy_persediaan_saham_pegawai_kode_unit_organisasi">
<span<?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->kode_unit_organisasi->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->kode_unit_kerja->Visible) { // kode_unit_kerja ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_kode_unit_kerja" class="rwy_persediaan_saham_pegawai_kode_unit_kerja">
<span<?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->kode_unit_kerja->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->periode_bulan->Visible) { // periode_bulan ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->periode_bulan->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_periode_bulan" class="rwy_persediaan_saham_pegawai_periode_bulan">
<span<?php echo $rwy_persediaan_saham_pegawai->periode_bulan->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->periode_bulan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->periode_tahun->Visible) { // periode_tahun ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->periode_tahun->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_periode_tahun" class="rwy_persediaan_saham_pegawai_periode_tahun">
<span<?php echo $rwy_persediaan_saham_pegawai->periode_tahun->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->periode_tahun->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->Visible) { // industri_kontruksi_abim_ups_anak ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_anak" class="rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_anak">
<span<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_anak->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->realty_ups_anak->Visible) { // realty_ups_anak ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_realty_ups_anak" class="rwy_persediaan_saham_pegawai_realty_ups_anak">
<span<?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->realty_ups_anak->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->pst_ups_anak->Visible) { // pst_ups_anak ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_pst_ups_anak" class="rwy_persediaan_saham_pegawai_pst_ups_anak">
<span<?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->pst_ups_anak->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->wton_anak_ups_anak->Visible) { // wton_anak_ups_anak ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_wton_anak_ups_anak" class="rwy_persediaan_saham_pegawai_wton_anak_ups_anak">
<span<?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->wton_anak_ups_anak->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->Visible) { // industri_kontruksi_abim_ups_dianak ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_dianak" class="rwy_persediaan_saham_pegawai_industri_kontruksi_abim_ups_dianak">
<span<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->industri_kontruksi_abim_ups_dianak->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->realty_ups_dianak->Visible) { // realty_ups_dianak ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_realty_ups_dianak" class="rwy_persediaan_saham_pegawai_realty_ups_dianak">
<span<?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->realty_ups_dianak->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->esa_dianak->Visible) { // esa_dianak ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->esa_dianak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_esa_dianak" class="rwy_persediaan_saham_pegawai_esa_dianak">
<span<?php echo $rwy_persediaan_saham_pegawai->esa_dianak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->esa_dianak->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->esop_dianak->Visible) { // esop_dianak ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->esop_dianak->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_esop_dianak" class="rwy_persediaan_saham_pegawai_esop_dianak">
<span<?php echo $rwy_persediaan_saham_pegawai->esop_dianak->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->esop_dianak->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->change_by->Visible) { // change_by ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->change_by->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_change_by" class="rwy_persediaan_saham_pegawai_change_by">
<span<?php echo $rwy_persediaan_saham_pegawai->change_by->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->change_by->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($rwy_persediaan_saham_pegawai->change_date->Visible) { // change_date ?>
		<td<?php echo $rwy_persediaan_saham_pegawai->change_date->CellAttributes() ?>>
<span id="el<?php echo $rwy_persediaan_saham_pegawai_delete->RowCnt ?>_rwy_persediaan_saham_pegawai_change_date" class="rwy_persediaan_saham_pegawai_change_date">
<span<?php echo $rwy_persediaan_saham_pegawai->change_date->ViewAttributes() ?>>
<?php echo $rwy_persediaan_saham_pegawai->change_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$rwy_persediaan_saham_pegawai_delete->Recordset->MoveNext();
}
$rwy_persediaan_saham_pegawai_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $rwy_persediaan_saham_pegawai_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
frwy_persediaan_saham_pegawaidelete.Init();
</script>
<?php
$rwy_persediaan_saham_pegawai_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$rwy_persediaan_saham_pegawai_delete->Page_Terminate();
?>
