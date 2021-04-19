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

$rwy_keluarga_view = NULL; // Initialize page object first

class crwy_keluarga_view extends crwy_keluarga {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'rwy_keluarga';

	// Page object name
	var $PageObjName = 'rwy_keluarga_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&amp;id=" . urlencode($this->RecKey["id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->nip->SetVisibility();
		$this->hubungan_keluarga->SetVisibility();
		$this->nama_lengkap->SetVisibility();
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "rwy_keluargaview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $gbSkipHeaderFooter, $EW_EXPORT;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$sReturnUrl = "rwy_keluargalist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "rwy_keluargalist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "rwy_keluargalist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "");

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "");

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->CopyUrl) . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "");

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddQuery($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "");

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

		// nama_lengkap
		$this->nama_lengkap->ViewValue = $this->nama_lengkap->CurrentValue;
		$this->nama_lengkap->ViewCustomAttributes = "";

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

			// nama_lengkap
			$this->nama_lengkap->LinkCustomAttributes = "";
			$this->nama_lengkap->HrefValue = "";
			$this->nama_lengkap->TooltipValue = "";

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("rwy_keluargalist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($rwy_keluarga_view)) $rwy_keluarga_view = new crwy_keluarga_view();

// Page init
$rwy_keluarga_view->Page_Init();

// Page main
$rwy_keluarga_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$rwy_keluarga_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = frwy_keluargaview = new ew_Form("frwy_keluargaview", "view");

// Form_CustomValidate event
frwy_keluargaview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
frwy_keluargaview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $rwy_keluarga_view->ExportOptions->Render("body") ?>
<?php
	foreach ($rwy_keluarga_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $rwy_keluarga_view->ShowPageHeader(); ?>
<?php
$rwy_keluarga_view->ShowMessage();
?>
<form name="frwy_keluargaview" id="frwy_keluargaview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($rwy_keluarga_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $rwy_keluarga_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="rwy_keluarga">
<input type="hidden" name="modal" value="<?php echo intval($rwy_keluarga_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($rwy_keluarga->id->Visible) { // id ?>
	<tr id="r_id">
		<td class="col-sm-2"><span id="elh_rwy_keluarga_id"><?php echo $rwy_keluarga->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $rwy_keluarga->id->CellAttributes() ?>>
<span id="el_rwy_keluarga_id">
<span<?php echo $rwy_keluarga->id->ViewAttributes() ?>>
<?php echo $rwy_keluarga->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($rwy_keluarga->nip->Visible) { // nip ?>
	<tr id="r_nip">
		<td class="col-sm-2"><span id="elh_rwy_keluarga_nip"><?php echo $rwy_keluarga->nip->FldCaption() ?></span></td>
		<td data-name="nip"<?php echo $rwy_keluarga->nip->CellAttributes() ?>>
<span id="el_rwy_keluarga_nip">
<span<?php echo $rwy_keluarga->nip->ViewAttributes() ?>>
<?php echo $rwy_keluarga->nip->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($rwy_keluarga->hubungan_keluarga->Visible) { // hubungan_keluarga ?>
	<tr id="r_hubungan_keluarga">
		<td class="col-sm-2"><span id="elh_rwy_keluarga_hubungan_keluarga"><?php echo $rwy_keluarga->hubungan_keluarga->FldCaption() ?></span></td>
		<td data-name="hubungan_keluarga"<?php echo $rwy_keluarga->hubungan_keluarga->CellAttributes() ?>>
<span id="el_rwy_keluarga_hubungan_keluarga">
<span<?php echo $rwy_keluarga->hubungan_keluarga->ViewAttributes() ?>>
<?php echo $rwy_keluarga->hubungan_keluarga->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($rwy_keluarga->nama_lengkap->Visible) { // nama_lengkap ?>
	<tr id="r_nama_lengkap">
		<td class="col-sm-2"><span id="elh_rwy_keluarga_nama_lengkap"><?php echo $rwy_keluarga->nama_lengkap->FldCaption() ?></span></td>
		<td data-name="nama_lengkap"<?php echo $rwy_keluarga->nama_lengkap->CellAttributes() ?>>
<span id="el_rwy_keluarga_nama_lengkap">
<span<?php echo $rwy_keluarga->nama_lengkap->ViewAttributes() ?>>
<?php echo $rwy_keluarga->nama_lengkap->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($rwy_keluarga->tanggal_lahir->Visible) { // tanggal_lahir ?>
	<tr id="r_tanggal_lahir">
		<td class="col-sm-2"><span id="elh_rwy_keluarga_tanggal_lahir"><?php echo $rwy_keluarga->tanggal_lahir->FldCaption() ?></span></td>
		<td data-name="tanggal_lahir"<?php echo $rwy_keluarga->tanggal_lahir->CellAttributes() ?>>
<span id="el_rwy_keluarga_tanggal_lahir">
<span<?php echo $rwy_keluarga->tanggal_lahir->ViewAttributes() ?>>
<?php echo $rwy_keluarga->tanggal_lahir->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($rwy_keluarga->tempat_lahir->Visible) { // tempat_lahir ?>
	<tr id="r_tempat_lahir">
		<td class="col-sm-2"><span id="elh_rwy_keluarga_tempat_lahir"><?php echo $rwy_keluarga->tempat_lahir->FldCaption() ?></span></td>
		<td data-name="tempat_lahir"<?php echo $rwy_keluarga->tempat_lahir->CellAttributes() ?>>
<span id="el_rwy_keluarga_tempat_lahir">
<span<?php echo $rwy_keluarga->tempat_lahir->ViewAttributes() ?>>
<?php echo $rwy_keluarga->tempat_lahir->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($rwy_keluarga->pendidikan_terakhir->Visible) { // pendidikan_terakhir ?>
	<tr id="r_pendidikan_terakhir">
		<td class="col-sm-2"><span id="elh_rwy_keluarga_pendidikan_terakhir"><?php echo $rwy_keluarga->pendidikan_terakhir->FldCaption() ?></span></td>
		<td data-name="pendidikan_terakhir"<?php echo $rwy_keluarga->pendidikan_terakhir->CellAttributes() ?>>
<span id="el_rwy_keluarga_pendidikan_terakhir">
<span<?php echo $rwy_keluarga->pendidikan_terakhir->ViewAttributes() ?>>
<?php echo $rwy_keluarga->pendidikan_terakhir->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($rwy_keluarga->jurusan->Visible) { // jurusan ?>
	<tr id="r_jurusan">
		<td class="col-sm-2"><span id="elh_rwy_keluarga_jurusan"><?php echo $rwy_keluarga->jurusan->FldCaption() ?></span></td>
		<td data-name="jurusan"<?php echo $rwy_keluarga->jurusan->CellAttributes() ?>>
<span id="el_rwy_keluarga_jurusan">
<span<?php echo $rwy_keluarga->jurusan->ViewAttributes() ?>>
<?php echo $rwy_keluarga->jurusan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($rwy_keluarga->jenis_kelamin->Visible) { // jenis_kelamin ?>
	<tr id="r_jenis_kelamin">
		<td class="col-sm-2"><span id="elh_rwy_keluarga_jenis_kelamin"><?php echo $rwy_keluarga->jenis_kelamin->FldCaption() ?></span></td>
		<td data-name="jenis_kelamin"<?php echo $rwy_keluarga->jenis_kelamin->CellAttributes() ?>>
<span id="el_rwy_keluarga_jenis_kelamin">
<span<?php echo $rwy_keluarga->jenis_kelamin->ViewAttributes() ?>>
<?php echo $rwy_keluarga->jenis_kelamin->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($rwy_keluarga->stat_validasi->Visible) { // stat_validasi ?>
	<tr id="r_stat_validasi">
		<td class="col-sm-2"><span id="elh_rwy_keluarga_stat_validasi"><?php echo $rwy_keluarga->stat_validasi->FldCaption() ?></span></td>
		<td data-name="stat_validasi"<?php echo $rwy_keluarga->stat_validasi->CellAttributes() ?>>
<span id="el_rwy_keluarga_stat_validasi">
<span<?php echo $rwy_keluarga->stat_validasi->ViewAttributes() ?>>
<?php echo $rwy_keluarga->stat_validasi->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($rwy_keluarga->change_date->Visible) { // change_date ?>
	<tr id="r_change_date">
		<td class="col-sm-2"><span id="elh_rwy_keluarga_change_date"><?php echo $rwy_keluarga->change_date->FldCaption() ?></span></td>
		<td data-name="change_date"<?php echo $rwy_keluarga->change_date->CellAttributes() ?>>
<span id="el_rwy_keluarga_change_date">
<span<?php echo $rwy_keluarga->change_date->ViewAttributes() ?>>
<?php echo $rwy_keluarga->change_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($rwy_keluarga->change_by->Visible) { // change_by ?>
	<tr id="r_change_by">
		<td class="col-sm-2"><span id="elh_rwy_keluarga_change_by"><?php echo $rwy_keluarga->change_by->FldCaption() ?></span></td>
		<td data-name="change_by"<?php echo $rwy_keluarga->change_by->CellAttributes() ?>>
<span id="el_rwy_keluarga_change_by">
<span<?php echo $rwy_keluarga->change_by->ViewAttributes() ?>>
<?php echo $rwy_keluarga->change_by->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
frwy_keluargaview.Init();
</script>
<?php
$rwy_keluarga_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$rwy_keluarga_view->Page_Terminate();
?>
