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

$tb_pat_view = NULL; // Initialize page object first

class ctb_pat_view extends ctb_pat {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'tb_pat';

	// Page object name
	var $PageObjName = 'tb_pat_view';

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

		// Table object (tb_pat)
		if (!isset($GLOBALS["tb_pat"]) || get_class($GLOBALS["tb_pat"]) == "ctb_pat") {
			$GLOBALS["tb_pat"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_pat"];
		}
		$KeyUrl = "";
		if (@$_GET["KD_PAT"] <> "") {
			$this->RecKey["KD_PAT"] = $_GET["KD_PAT"];
			$KeyUrl .= "&amp;KD_PAT=" . urlencode($this->RecKey["KD_PAT"]);
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
			define("EW_TABLE_NAME", 'tb_pat', TRUE);

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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "tb_patview.php")
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
			if (@$_GET["KD_PAT"] <> "") {
				$this->KD_PAT->setQueryStringValue($_GET["KD_PAT"]);
				$this->RecKey["KD_PAT"] = $this->KD_PAT->QueryStringValue;
			} elseif (@$_POST["KD_PAT"] <> "") {
				$this->KD_PAT->setFormValue($_POST["KD_PAT"]);
				$this->RecKey["KD_PAT"] = $this->KD_PAT->FormValue;
			} else {
				$sReturnUrl = "tb_patlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "tb_patlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "tb_patlist.php"; // Not page request, return to list
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_patlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($tb_pat_view)) $tb_pat_view = new ctb_pat_view();

// Page init
$tb_pat_view->Page_Init();

// Page main
$tb_pat_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_pat_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = ftb_patview = new ew_Form("ftb_patview", "view");

// Form_CustomValidate event
ftb_patview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftb_patview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $tb_pat_view->ExportOptions->Render("body") ?>
<?php
	foreach ($tb_pat_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $tb_pat_view->ShowPageHeader(); ?>
<?php
$tb_pat_view->ShowMessage();
?>
<form name="ftb_patview" id="ftb_patview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_pat_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_pat_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_pat">
<input type="hidden" name="modal" value="<?php echo intval($tb_pat_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($tb_pat->KD_PAT->Visible) { // KD_PAT ?>
	<tr id="r_KD_PAT">
		<td class="col-sm-2"><span id="elh_tb_pat_KD_PAT"><?php echo $tb_pat->KD_PAT->FldCaption() ?></span></td>
		<td data-name="KD_PAT"<?php echo $tb_pat->KD_PAT->CellAttributes() ?>>
<span id="el_tb_pat_KD_PAT">
<span<?php echo $tb_pat->KD_PAT->ViewAttributes() ?>>
<?php echo $tb_pat->KD_PAT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_pat->KET->Visible) { // KET ?>
	<tr id="r_KET">
		<td class="col-sm-2"><span id="elh_tb_pat_KET"><?php echo $tb_pat->KET->FldCaption() ?></span></td>
		<td data-name="KET"<?php echo $tb_pat->KET->CellAttributes() ?>>
<span id="el_tb_pat_KET">
<span<?php echo $tb_pat->KET->ViewAttributes() ?>>
<?php echo $tb_pat->KET->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_pat->ALAMAT->Visible) { // ALAMAT ?>
	<tr id="r_ALAMAT">
		<td class="col-sm-2"><span id="elh_tb_pat_ALAMAT"><?php echo $tb_pat->ALAMAT->FldCaption() ?></span></td>
		<td data-name="ALAMAT"<?php echo $tb_pat->ALAMAT->CellAttributes() ?>>
<span id="el_tb_pat_ALAMAT">
<span<?php echo $tb_pat->ALAMAT->ViewAttributes() ?>>
<?php echo $tb_pat->ALAMAT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_pat->KOTA->Visible) { // KOTA ?>
	<tr id="r_KOTA">
		<td class="col-sm-2"><span id="elh_tb_pat_KOTA"><?php echo $tb_pat->KOTA->FldCaption() ?></span></td>
		<td data-name="KOTA"<?php echo $tb_pat->KOTA->CellAttributes() ?>>
<span id="el_tb_pat_KOTA">
<span<?php echo $tb_pat->KOTA->ViewAttributes() ?>>
<?php echo $tb_pat->KOTA->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_pat->SINGKATAN->Visible) { // SINGKATAN ?>
	<tr id="r_SINGKATAN">
		<td class="col-sm-2"><span id="elh_tb_pat_SINGKATAN"><?php echo $tb_pat->SINGKATAN->FldCaption() ?></span></td>
		<td data-name="SINGKATAN"<?php echo $tb_pat->SINGKATAN->CellAttributes() ?>>
<span id="el_tb_pat_SINGKATAN">
<span<?php echo $tb_pat->SINGKATAN->ViewAttributes() ?>>
<?php echo $tb_pat->SINGKATAN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_pat->CREATED_BY->Visible) { // CREATED_BY ?>
	<tr id="r_CREATED_BY">
		<td class="col-sm-2"><span id="elh_tb_pat_CREATED_BY"><?php echo $tb_pat->CREATED_BY->FldCaption() ?></span></td>
		<td data-name="CREATED_BY"<?php echo $tb_pat->CREATED_BY->CellAttributes() ?>>
<span id="el_tb_pat_CREATED_BY">
<span<?php echo $tb_pat->CREATED_BY->ViewAttributes() ?>>
<?php echo $tb_pat->CREATED_BY->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_pat->CREATED_DATE->Visible) { // CREATED_DATE ?>
	<tr id="r_CREATED_DATE">
		<td class="col-sm-2"><span id="elh_tb_pat_CREATED_DATE"><?php echo $tb_pat->CREATED_DATE->FldCaption() ?></span></td>
		<td data-name="CREATED_DATE"<?php echo $tb_pat->CREATED_DATE->CellAttributes() ?>>
<span id="el_tb_pat_CREATED_DATE">
<span<?php echo $tb_pat->CREATED_DATE->ViewAttributes() ?>>
<?php echo $tb_pat->CREATED_DATE->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_pat->LAST_UPDATE_BY->Visible) { // LAST_UPDATE_BY ?>
	<tr id="r_LAST_UPDATE_BY">
		<td class="col-sm-2"><span id="elh_tb_pat_LAST_UPDATE_BY"><?php echo $tb_pat->LAST_UPDATE_BY->FldCaption() ?></span></td>
		<td data-name="LAST_UPDATE_BY"<?php echo $tb_pat->LAST_UPDATE_BY->CellAttributes() ?>>
<span id="el_tb_pat_LAST_UPDATE_BY">
<span<?php echo $tb_pat->LAST_UPDATE_BY->ViewAttributes() ?>>
<?php echo $tb_pat->LAST_UPDATE_BY->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_pat->LAST_UPDATE_DATE->Visible) { // LAST_UPDATE_DATE ?>
	<tr id="r_LAST_UPDATE_DATE">
		<td class="col-sm-2"><span id="elh_tb_pat_LAST_UPDATE_DATE"><?php echo $tb_pat->LAST_UPDATE_DATE->FldCaption() ?></span></td>
		<td data-name="LAST_UPDATE_DATE"<?php echo $tb_pat->LAST_UPDATE_DATE->CellAttributes() ?>>
<span id="el_tb_pat_LAST_UPDATE_DATE">
<span<?php echo $tb_pat->LAST_UPDATE_DATE->ViewAttributes() ?>>
<?php echo $tb_pat->LAST_UPDATE_DATE->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
ftb_patview.Init();
</script>
<?php
$tb_pat_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_pat_view->Page_Terminate();
?>
