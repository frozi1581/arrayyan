<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "personalinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$personal_view = NULL; // Initialize page object first

class cpersonal_view extends cpersonal {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'personal';

	// Page object name
	var $PageObjName = 'personal_view';

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

		// Table object (personal)
		if (!isset($GLOBALS["personal"]) || get_class($GLOBALS["personal"]) == "cpersonal") {
			$GLOBALS["personal"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["personal"];
		}
		$KeyUrl = "";
		if (@$_GET["employee_id"] <> "") {
			$this->RecKey["employee_id"] = $_GET["employee_id"];
			$KeyUrl .= "&amp;employee_id=" . urlencode($this->RecKey["employee_id"]);
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
			define("EW_TABLE_NAME", 'personal', TRUE);

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
		$this->employee_id->SetVisibility();
		$this->first_name->SetVisibility();
		$this->last_name->SetVisibility();
		$this->first_title->SetVisibility();
		$this->last_title->SetVisibility();
		$this->init->SetVisibility();
		$this->tpt_lahir->SetVisibility();
		$this->tgl_lahir->SetVisibility();
		$this->jk->SetVisibility();
		$this->kd_agama->SetVisibility();
		$this->tgl_masuk->SetVisibility();
		$this->tpt_masuk->SetVisibility();
		$this->stkel->SetVisibility();
		$this->alamat->SetVisibility();
		$this->kota->SetVisibility();
		$this->kd_pos->SetVisibility();
		$this->kd_propinsi->SetVisibility();
		$this->telp->SetVisibility();
		$this->telp_area->SetVisibility();
		$this->hp->SetVisibility();
		$this->alamat_dom->SetVisibility();
		$this->kota_dom->SetVisibility();
		$this->kd_pos_dom->SetVisibility();
		$this->kd_propinsi_dom->SetVisibility();
		$this->telp_dom->SetVisibility();
		$this->telp_dom_area->SetVisibility();
		$this->_email->SetVisibility();
		$this->kd_st_emp->SetVisibility();
		$this->skala->SetVisibility();
		$this->gp->SetVisibility();
		$this->upah_tetap->SetVisibility();
		$this->tgl_honor->SetVisibility();
		$this->honor->SetVisibility();
		$this->premi_honor->SetVisibility();
		$this->tgl_gp->SetVisibility();
		$this->skala_95->SetVisibility();
		$this->gp_95->SetVisibility();
		$this->tgl_gp_95->SetVisibility();
		$this->kd_indx->SetVisibility();
		$this->indx_lok->SetVisibility();
		$this->gol_darah->SetVisibility();
		$this->kd_jbt->SetVisibility();
		$this->tgl_kd_jbt->SetVisibility();
		$this->kd_jbt_pgs->SetVisibility();
		$this->tgl_kd_jbt_pgs->SetVisibility();
		$this->kd_jbt_pjs->SetVisibility();
		$this->tgl_kd_jbt_pjs->SetVisibility();
		$this->kd_jbt_ps->SetVisibility();
		$this->tgl_kd_jbt_ps->SetVisibility();
		$this->kd_pat->SetVisibility();
		$this->kd_gas->SetVisibility();
		$this->pimp_empid->SetVisibility();
		$this->stshift->SetVisibility();
		$this->no_rek->SetVisibility();
		$this->kd_bank->SetVisibility();
		$this->kd_jamsostek->SetVisibility();
		$this->acc_astek->SetVisibility();
		$this->acc_dapens->SetVisibility();
		$this->acc_kes->SetVisibility();
		$this->st->SetVisibility();
		$this->signature->SetVisibility();
		$this->created_by->SetVisibility();
		$this->created_date->SetVisibility();
		$this->last_update_by->SetVisibility();
		$this->last_update_date->SetVisibility();
		$this->fgr_print_id->SetVisibility();
		$this->kd_jbt_eselon->SetVisibility();
		$this->npwp->SetVisibility();
		$this->paraf->SetVisibility();
		$this->tgl_keluar->SetVisibility();
		$this->nama_nasabah->SetVisibility();
		$this->no_ktp->SetVisibility();
		$this->no_kokar->SetVisibility();
		$this->no_bmw->SetVisibility();
		$this->no_bpjs_ketenagakerjaan->SetVisibility();
		$this->no_bpjs_kesehatan->SetVisibility();
		$this->eselon->SetVisibility();
		$this->kd_jenjang->SetVisibility();
		$this->kd_jbt_esl->SetVisibility();
		$this->tgl_jbt_esl->SetVisibility();
		$this->org_id->SetVisibility();
		$this->picture->SetVisibility();
		$this->kd_payroll->SetVisibility();
		$this->id_wn->SetVisibility();
		$this->no_anggota_kkms->SetVisibility();

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
		global $EW_EXPORT, $personal;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($personal);
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
					if ($pageName == "personalview.php")
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
			if (@$_GET["employee_id"] <> "") {
				$this->employee_id->setQueryStringValue($_GET["employee_id"]);
				$this->RecKey["employee_id"] = $this->employee_id->QueryStringValue;
			} elseif (@$_POST["employee_id"] <> "") {
				$this->employee_id->setFormValue($_POST["employee_id"]);
				$this->RecKey["employee_id"] = $this->employee_id->FormValue;
			} else {
				$sReturnUrl = "personallist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "personallist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "personallist.php"; // Not page request, return to list
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
		$this->employee_id->setDbValue($row['employee_id']);
		$this->first_name->setDbValue($row['first_name']);
		$this->last_name->setDbValue($row['last_name']);
		$this->first_title->setDbValue($row['first_title']);
		$this->last_title->setDbValue($row['last_title']);
		$this->init->setDbValue($row['init']);
		$this->tpt_lahir->setDbValue($row['tpt_lahir']);
		$this->tgl_lahir->setDbValue($row['tgl_lahir']);
		$this->jk->setDbValue($row['jk']);
		$this->kd_agama->setDbValue($row['kd_agama']);
		$this->tgl_masuk->setDbValue($row['tgl_masuk']);
		$this->tpt_masuk->setDbValue($row['tpt_masuk']);
		$this->stkel->setDbValue($row['stkel']);
		$this->alamat->setDbValue($row['alamat']);
		$this->kota->setDbValue($row['kota']);
		$this->kd_pos->setDbValue($row['kd_pos']);
		$this->kd_propinsi->setDbValue($row['kd_propinsi']);
		$this->telp->setDbValue($row['telp']);
		$this->telp_area->setDbValue($row['telp_area']);
		$this->hp->setDbValue($row['hp']);
		$this->alamat_dom->setDbValue($row['alamat_dom']);
		$this->kota_dom->setDbValue($row['kota_dom']);
		$this->kd_pos_dom->setDbValue($row['kd_pos_dom']);
		$this->kd_propinsi_dom->setDbValue($row['kd_propinsi_dom']);
		$this->telp_dom->setDbValue($row['telp_dom']);
		$this->telp_dom_area->setDbValue($row['telp_dom_area']);
		$this->_email->setDbValue($row['email']);
		$this->kd_st_emp->setDbValue($row['kd_st_emp']);
		$this->skala->setDbValue($row['skala']);
		$this->gp->setDbValue($row['gp']);
		$this->upah_tetap->setDbValue($row['upah_tetap']);
		$this->tgl_honor->setDbValue($row['tgl_honor']);
		$this->honor->setDbValue($row['honor']);
		$this->premi_honor->setDbValue($row['premi_honor']);
		$this->tgl_gp->setDbValue($row['tgl_gp']);
		$this->skala_95->setDbValue($row['skala_95']);
		$this->gp_95->setDbValue($row['gp_95']);
		$this->tgl_gp_95->setDbValue($row['tgl_gp_95']);
		$this->kd_indx->setDbValue($row['kd_indx']);
		$this->indx_lok->setDbValue($row['indx_lok']);
		$this->gol_darah->setDbValue($row['gol_darah']);
		$this->kd_jbt->setDbValue($row['kd_jbt']);
		$this->tgl_kd_jbt->setDbValue($row['tgl_kd_jbt']);
		$this->kd_jbt_pgs->setDbValue($row['kd_jbt_pgs']);
		$this->tgl_kd_jbt_pgs->setDbValue($row['tgl_kd_jbt_pgs']);
		$this->kd_jbt_pjs->setDbValue($row['kd_jbt_pjs']);
		$this->tgl_kd_jbt_pjs->setDbValue($row['tgl_kd_jbt_pjs']);
		$this->kd_jbt_ps->setDbValue($row['kd_jbt_ps']);
		$this->tgl_kd_jbt_ps->setDbValue($row['tgl_kd_jbt_ps']);
		$this->kd_pat->setDbValue($row['kd_pat']);
		$this->kd_gas->setDbValue($row['kd_gas']);
		$this->pimp_empid->setDbValue($row['pimp_empid']);
		$this->stshift->setDbValue($row['stshift']);
		$this->no_rek->setDbValue($row['no_rek']);
		$this->kd_bank->setDbValue($row['kd_bank']);
		$this->kd_jamsostek->setDbValue($row['kd_jamsostek']);
		$this->acc_astek->setDbValue($row['acc_astek']);
		$this->acc_dapens->setDbValue($row['acc_dapens']);
		$this->acc_kes->setDbValue($row['acc_kes']);
		$this->st->setDbValue($row['st']);
		$this->signature->Upload->DbValue = $row['signature'];
		if (is_array($this->signature->Upload->DbValue) || is_object($this->signature->Upload->DbValue)) // Byte array
			$this->signature->Upload->DbValue = ew_BytesToStr($this->signature->Upload->DbValue);
		$this->created_by->setDbValue($row['created_by']);
		$this->created_date->setDbValue($row['created_date']);
		$this->last_update_by->setDbValue($row['last_update_by']);
		$this->last_update_date->setDbValue($row['last_update_date']);
		$this->fgr_print_id->setDbValue($row['fgr_print_id']);
		$this->kd_jbt_eselon->setDbValue($row['kd_jbt_eselon']);
		$this->npwp->setDbValue($row['npwp']);
		$this->paraf->Upload->DbValue = $row['paraf'];
		if (is_array($this->paraf->Upload->DbValue) || is_object($this->paraf->Upload->DbValue)) // Byte array
			$this->paraf->Upload->DbValue = ew_BytesToStr($this->paraf->Upload->DbValue);
		$this->tgl_keluar->setDbValue($row['tgl_keluar']);
		$this->nama_nasabah->setDbValue($row['nama_nasabah']);
		$this->no_ktp->setDbValue($row['no_ktp']);
		$this->no_kokar->setDbValue($row['no_kokar']);
		$this->no_bmw->setDbValue($row['no_bmw']);
		$this->no_bpjs_ketenagakerjaan->setDbValue($row['no_bpjs_ketenagakerjaan']);
		$this->no_bpjs_kesehatan->setDbValue($row['no_bpjs_kesehatan']);
		$this->eselon->setDbValue($row['eselon']);
		$this->kd_jenjang->setDbValue($row['kd_jenjang']);
		$this->kd_jbt_esl->setDbValue($row['kd_jbt_esl']);
		$this->tgl_jbt_esl->setDbValue($row['tgl_jbt_esl']);
		$this->org_id->setDbValue($row['org_id']);
		$this->picture->Upload->DbValue = $row['picture'];
		if (is_array($this->picture->Upload->DbValue) || is_object($this->picture->Upload->DbValue)) // Byte array
			$this->picture->Upload->DbValue = ew_BytesToStr($this->picture->Upload->DbValue);
		$this->kd_payroll->setDbValue($row['kd_payroll']);
		$this->id_wn->setDbValue($row['id_wn']);
		$this->no_anggota_kkms->setDbValue($row['no_anggota_kkms']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['employee_id'] = NULL;
		$row['first_name'] = NULL;
		$row['last_name'] = NULL;
		$row['first_title'] = NULL;
		$row['last_title'] = NULL;
		$row['init'] = NULL;
		$row['tpt_lahir'] = NULL;
		$row['tgl_lahir'] = NULL;
		$row['jk'] = NULL;
		$row['kd_agama'] = NULL;
		$row['tgl_masuk'] = NULL;
		$row['tpt_masuk'] = NULL;
		$row['stkel'] = NULL;
		$row['alamat'] = NULL;
		$row['kota'] = NULL;
		$row['kd_pos'] = NULL;
		$row['kd_propinsi'] = NULL;
		$row['telp'] = NULL;
		$row['telp_area'] = NULL;
		$row['hp'] = NULL;
		$row['alamat_dom'] = NULL;
		$row['kota_dom'] = NULL;
		$row['kd_pos_dom'] = NULL;
		$row['kd_propinsi_dom'] = NULL;
		$row['telp_dom'] = NULL;
		$row['telp_dom_area'] = NULL;
		$row['email'] = NULL;
		$row['kd_st_emp'] = NULL;
		$row['skala'] = NULL;
		$row['gp'] = NULL;
		$row['upah_tetap'] = NULL;
		$row['tgl_honor'] = NULL;
		$row['honor'] = NULL;
		$row['premi_honor'] = NULL;
		$row['tgl_gp'] = NULL;
		$row['skala_95'] = NULL;
		$row['gp_95'] = NULL;
		$row['tgl_gp_95'] = NULL;
		$row['kd_indx'] = NULL;
		$row['indx_lok'] = NULL;
		$row['gol_darah'] = NULL;
		$row['kd_jbt'] = NULL;
		$row['tgl_kd_jbt'] = NULL;
		$row['kd_jbt_pgs'] = NULL;
		$row['tgl_kd_jbt_pgs'] = NULL;
		$row['kd_jbt_pjs'] = NULL;
		$row['tgl_kd_jbt_pjs'] = NULL;
		$row['kd_jbt_ps'] = NULL;
		$row['tgl_kd_jbt_ps'] = NULL;
		$row['kd_pat'] = NULL;
		$row['kd_gas'] = NULL;
		$row['pimp_empid'] = NULL;
		$row['stshift'] = NULL;
		$row['no_rek'] = NULL;
		$row['kd_bank'] = NULL;
		$row['kd_jamsostek'] = NULL;
		$row['acc_astek'] = NULL;
		$row['acc_dapens'] = NULL;
		$row['acc_kes'] = NULL;
		$row['st'] = NULL;
		$row['signature'] = NULL;
		$row['created_by'] = NULL;
		$row['created_date'] = NULL;
		$row['last_update_by'] = NULL;
		$row['last_update_date'] = NULL;
		$row['fgr_print_id'] = NULL;
		$row['kd_jbt_eselon'] = NULL;
		$row['npwp'] = NULL;
		$row['paraf'] = NULL;
		$row['tgl_keluar'] = NULL;
		$row['nama_nasabah'] = NULL;
		$row['no_ktp'] = NULL;
		$row['no_kokar'] = NULL;
		$row['no_bmw'] = NULL;
		$row['no_bpjs_ketenagakerjaan'] = NULL;
		$row['no_bpjs_kesehatan'] = NULL;
		$row['eselon'] = NULL;
		$row['kd_jenjang'] = NULL;
		$row['kd_jbt_esl'] = NULL;
		$row['tgl_jbt_esl'] = NULL;
		$row['org_id'] = NULL;
		$row['picture'] = NULL;
		$row['kd_payroll'] = NULL;
		$row['id_wn'] = NULL;
		$row['no_anggota_kkms'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->employee_id->DbValue = $row['employee_id'];
		$this->first_name->DbValue = $row['first_name'];
		$this->last_name->DbValue = $row['last_name'];
		$this->first_title->DbValue = $row['first_title'];
		$this->last_title->DbValue = $row['last_title'];
		$this->init->DbValue = $row['init'];
		$this->tpt_lahir->DbValue = $row['tpt_lahir'];
		$this->tgl_lahir->DbValue = $row['tgl_lahir'];
		$this->jk->DbValue = $row['jk'];
		$this->kd_agama->DbValue = $row['kd_agama'];
		$this->tgl_masuk->DbValue = $row['tgl_masuk'];
		$this->tpt_masuk->DbValue = $row['tpt_masuk'];
		$this->stkel->DbValue = $row['stkel'];
		$this->alamat->DbValue = $row['alamat'];
		$this->kota->DbValue = $row['kota'];
		$this->kd_pos->DbValue = $row['kd_pos'];
		$this->kd_propinsi->DbValue = $row['kd_propinsi'];
		$this->telp->DbValue = $row['telp'];
		$this->telp_area->DbValue = $row['telp_area'];
		$this->hp->DbValue = $row['hp'];
		$this->alamat_dom->DbValue = $row['alamat_dom'];
		$this->kota_dom->DbValue = $row['kota_dom'];
		$this->kd_pos_dom->DbValue = $row['kd_pos_dom'];
		$this->kd_propinsi_dom->DbValue = $row['kd_propinsi_dom'];
		$this->telp_dom->DbValue = $row['telp_dom'];
		$this->telp_dom_area->DbValue = $row['telp_dom_area'];
		$this->_email->DbValue = $row['email'];
		$this->kd_st_emp->DbValue = $row['kd_st_emp'];
		$this->skala->DbValue = $row['skala'];
		$this->gp->DbValue = $row['gp'];
		$this->upah_tetap->DbValue = $row['upah_tetap'];
		$this->tgl_honor->DbValue = $row['tgl_honor'];
		$this->honor->DbValue = $row['honor'];
		$this->premi_honor->DbValue = $row['premi_honor'];
		$this->tgl_gp->DbValue = $row['tgl_gp'];
		$this->skala_95->DbValue = $row['skala_95'];
		$this->gp_95->DbValue = $row['gp_95'];
		$this->tgl_gp_95->DbValue = $row['tgl_gp_95'];
		$this->kd_indx->DbValue = $row['kd_indx'];
		$this->indx_lok->DbValue = $row['indx_lok'];
		$this->gol_darah->DbValue = $row['gol_darah'];
		$this->kd_jbt->DbValue = $row['kd_jbt'];
		$this->tgl_kd_jbt->DbValue = $row['tgl_kd_jbt'];
		$this->kd_jbt_pgs->DbValue = $row['kd_jbt_pgs'];
		$this->tgl_kd_jbt_pgs->DbValue = $row['tgl_kd_jbt_pgs'];
		$this->kd_jbt_pjs->DbValue = $row['kd_jbt_pjs'];
		$this->tgl_kd_jbt_pjs->DbValue = $row['tgl_kd_jbt_pjs'];
		$this->kd_jbt_ps->DbValue = $row['kd_jbt_ps'];
		$this->tgl_kd_jbt_ps->DbValue = $row['tgl_kd_jbt_ps'];
		$this->kd_pat->DbValue = $row['kd_pat'];
		$this->kd_gas->DbValue = $row['kd_gas'];
		$this->pimp_empid->DbValue = $row['pimp_empid'];
		$this->stshift->DbValue = $row['stshift'];
		$this->no_rek->DbValue = $row['no_rek'];
		$this->kd_bank->DbValue = $row['kd_bank'];
		$this->kd_jamsostek->DbValue = $row['kd_jamsostek'];
		$this->acc_astek->DbValue = $row['acc_astek'];
		$this->acc_dapens->DbValue = $row['acc_dapens'];
		$this->acc_kes->DbValue = $row['acc_kes'];
		$this->st->DbValue = $row['st'];
		$this->signature->Upload->DbValue = $row['signature'];
		$this->created_by->DbValue = $row['created_by'];
		$this->created_date->DbValue = $row['created_date'];
		$this->last_update_by->DbValue = $row['last_update_by'];
		$this->last_update_date->DbValue = $row['last_update_date'];
		$this->fgr_print_id->DbValue = $row['fgr_print_id'];
		$this->kd_jbt_eselon->DbValue = $row['kd_jbt_eselon'];
		$this->npwp->DbValue = $row['npwp'];
		$this->paraf->Upload->DbValue = $row['paraf'];
		$this->tgl_keluar->DbValue = $row['tgl_keluar'];
		$this->nama_nasabah->DbValue = $row['nama_nasabah'];
		$this->no_ktp->DbValue = $row['no_ktp'];
		$this->no_kokar->DbValue = $row['no_kokar'];
		$this->no_bmw->DbValue = $row['no_bmw'];
		$this->no_bpjs_ketenagakerjaan->DbValue = $row['no_bpjs_ketenagakerjaan'];
		$this->no_bpjs_kesehatan->DbValue = $row['no_bpjs_kesehatan'];
		$this->eselon->DbValue = $row['eselon'];
		$this->kd_jenjang->DbValue = $row['kd_jenjang'];
		$this->kd_jbt_esl->DbValue = $row['kd_jbt_esl'];
		$this->tgl_jbt_esl->DbValue = $row['tgl_jbt_esl'];
		$this->org_id->DbValue = $row['org_id'];
		$this->picture->Upload->DbValue = $row['picture'];
		$this->kd_payroll->DbValue = $row['kd_payroll'];
		$this->id_wn->DbValue = $row['id_wn'];
		$this->no_anggota_kkms->DbValue = $row['no_anggota_kkms'];
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

		// Convert decimal values if posted back
		if ($this->gp->FormValue == $this->gp->CurrentValue && is_numeric(ew_StrToFloat($this->gp->CurrentValue)))
			$this->gp->CurrentValue = ew_StrToFloat($this->gp->CurrentValue);

		// Convert decimal values if posted back
		if ($this->upah_tetap->FormValue == $this->upah_tetap->CurrentValue && is_numeric(ew_StrToFloat($this->upah_tetap->CurrentValue)))
			$this->upah_tetap->CurrentValue = ew_StrToFloat($this->upah_tetap->CurrentValue);

		// Convert decimal values if posted back
		if ($this->honor->FormValue == $this->honor->CurrentValue && is_numeric(ew_StrToFloat($this->honor->CurrentValue)))
			$this->honor->CurrentValue = ew_StrToFloat($this->honor->CurrentValue);

		// Convert decimal values if posted back
		if ($this->premi_honor->FormValue == $this->premi_honor->CurrentValue && is_numeric(ew_StrToFloat($this->premi_honor->CurrentValue)))
			$this->premi_honor->CurrentValue = ew_StrToFloat($this->premi_honor->CurrentValue);

		// Convert decimal values if posted back
		if ($this->gp_95->FormValue == $this->gp_95->CurrentValue && is_numeric(ew_StrToFloat($this->gp_95->CurrentValue)))
			$this->gp_95->CurrentValue = ew_StrToFloat($this->gp_95->CurrentValue);

		// Convert decimal values if posted back
		if ($this->indx_lok->FormValue == $this->indx_lok->CurrentValue && is_numeric(ew_StrToFloat($this->indx_lok->CurrentValue)))
			$this->indx_lok->CurrentValue = ew_StrToFloat($this->indx_lok->CurrentValue);

		// Convert decimal values if posted back
		if ($this->fgr_print_id->FormValue == $this->fgr_print_id->CurrentValue && is_numeric(ew_StrToFloat($this->fgr_print_id->CurrentValue)))
			$this->fgr_print_id->CurrentValue = ew_StrToFloat($this->fgr_print_id->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// employee_id
		// first_name
		// last_name
		// first_title
		// last_title
		// init
		// tpt_lahir
		// tgl_lahir
		// jk
		// kd_agama
		// tgl_masuk
		// tpt_masuk
		// stkel
		// alamat
		// kota
		// kd_pos
		// kd_propinsi
		// telp
		// telp_area
		// hp
		// alamat_dom
		// kota_dom
		// kd_pos_dom
		// kd_propinsi_dom
		// telp_dom
		// telp_dom_area
		// email
		// kd_st_emp
		// skala
		// gp
		// upah_tetap
		// tgl_honor
		// honor
		// premi_honor
		// tgl_gp
		// skala_95
		// gp_95
		// tgl_gp_95
		// kd_indx
		// indx_lok
		// gol_darah
		// kd_jbt
		// tgl_kd_jbt
		// kd_jbt_pgs
		// tgl_kd_jbt_pgs
		// kd_jbt_pjs
		// tgl_kd_jbt_pjs
		// kd_jbt_ps
		// tgl_kd_jbt_ps
		// kd_pat
		// kd_gas
		// pimp_empid
		// stshift
		// no_rek
		// kd_bank
		// kd_jamsostek
		// acc_astek
		// acc_dapens
		// acc_kes
		// st
		// signature
		// created_by
		// created_date
		// last_update_by
		// last_update_date
		// fgr_print_id
		// kd_jbt_eselon
		// npwp
		// paraf
		// tgl_keluar
		// nama_nasabah
		// no_ktp
		// no_kokar
		// no_bmw
		// no_bpjs_ketenagakerjaan
		// no_bpjs_kesehatan
		// eselon
		// kd_jenjang
		// kd_jbt_esl
		// tgl_jbt_esl
		// org_id
		// picture
		// kd_payroll
		// id_wn
		// no_anggota_kkms

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// employee_id
		$this->employee_id->ViewValue = $this->employee_id->CurrentValue;
		$this->employee_id->ViewCustomAttributes = "";

		// first_name
		$this->first_name->ViewValue = $this->first_name->CurrentValue;
		$this->first_name->ViewCustomAttributes = "";

		// last_name
		$this->last_name->ViewValue = $this->last_name->CurrentValue;
		$this->last_name->ViewCustomAttributes = "";

		// first_title
		$this->first_title->ViewValue = $this->first_title->CurrentValue;
		$this->first_title->ViewCustomAttributes = "";

		// last_title
		$this->last_title->ViewValue = $this->last_title->CurrentValue;
		$this->last_title->ViewCustomAttributes = "";

		// init
		$this->init->ViewValue = $this->init->CurrentValue;
		$this->init->ViewCustomAttributes = "";

		// tpt_lahir
		$this->tpt_lahir->ViewValue = $this->tpt_lahir->CurrentValue;
		$this->tpt_lahir->ViewCustomAttributes = "";

		// tgl_lahir
		$this->tgl_lahir->ViewValue = $this->tgl_lahir->CurrentValue;
		$this->tgl_lahir->ViewValue = ew_FormatDateTime($this->tgl_lahir->ViewValue, 0);
		$this->tgl_lahir->ViewCustomAttributes = "";

		// jk
		$this->jk->ViewValue = $this->jk->CurrentValue;
		$this->jk->ViewCustomAttributes = "";

		// kd_agama
		$this->kd_agama->ViewValue = $this->kd_agama->CurrentValue;
		$this->kd_agama->ViewCustomAttributes = "";

		// tgl_masuk
		$this->tgl_masuk->ViewValue = $this->tgl_masuk->CurrentValue;
		$this->tgl_masuk->ViewValue = ew_FormatDateTime($this->tgl_masuk->ViewValue, 0);
		$this->tgl_masuk->ViewCustomAttributes = "";

		// tpt_masuk
		$this->tpt_masuk->ViewValue = $this->tpt_masuk->CurrentValue;
		$this->tpt_masuk->ViewCustomAttributes = "";

		// stkel
		$this->stkel->ViewValue = $this->stkel->CurrentValue;
		$this->stkel->ViewCustomAttributes = "";

		// alamat
		$this->alamat->ViewValue = $this->alamat->CurrentValue;
		$this->alamat->ViewCustomAttributes = "";

		// kota
		$this->kota->ViewValue = $this->kota->CurrentValue;
		$this->kota->ViewCustomAttributes = "";

		// kd_pos
		$this->kd_pos->ViewValue = $this->kd_pos->CurrentValue;
		$this->kd_pos->ViewCustomAttributes = "";

		// kd_propinsi
		$this->kd_propinsi->ViewValue = $this->kd_propinsi->CurrentValue;
		$this->kd_propinsi->ViewCustomAttributes = "";

		// telp
		$this->telp->ViewValue = $this->telp->CurrentValue;
		$this->telp->ViewCustomAttributes = "";

		// telp_area
		$this->telp_area->ViewValue = $this->telp_area->CurrentValue;
		$this->telp_area->ViewCustomAttributes = "";

		// hp
		$this->hp->ViewValue = $this->hp->CurrentValue;
		$this->hp->ViewCustomAttributes = "";

		// alamat_dom
		$this->alamat_dom->ViewValue = $this->alamat_dom->CurrentValue;
		$this->alamat_dom->ViewCustomAttributes = "";

		// kota_dom
		$this->kota_dom->ViewValue = $this->kota_dom->CurrentValue;
		$this->kota_dom->ViewCustomAttributes = "";

		// kd_pos_dom
		$this->kd_pos_dom->ViewValue = $this->kd_pos_dom->CurrentValue;
		$this->kd_pos_dom->ViewCustomAttributes = "";

		// kd_propinsi_dom
		$this->kd_propinsi_dom->ViewValue = $this->kd_propinsi_dom->CurrentValue;
		$this->kd_propinsi_dom->ViewCustomAttributes = "";

		// telp_dom
		$this->telp_dom->ViewValue = $this->telp_dom->CurrentValue;
		$this->telp_dom->ViewCustomAttributes = "";

		// telp_dom_area
		$this->telp_dom_area->ViewValue = $this->telp_dom_area->CurrentValue;
		$this->telp_dom_area->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// kd_st_emp
		$this->kd_st_emp->ViewValue = $this->kd_st_emp->CurrentValue;
		$this->kd_st_emp->ViewCustomAttributes = "";

		// skala
		$this->skala->ViewValue = $this->skala->CurrentValue;
		$this->skala->ViewCustomAttributes = "";

		// gp
		$this->gp->ViewValue = $this->gp->CurrentValue;
		$this->gp->ViewCustomAttributes = "";

		// upah_tetap
		$this->upah_tetap->ViewValue = $this->upah_tetap->CurrentValue;
		$this->upah_tetap->ViewCustomAttributes = "";

		// tgl_honor
		$this->tgl_honor->ViewValue = $this->tgl_honor->CurrentValue;
		$this->tgl_honor->ViewValue = ew_FormatDateTime($this->tgl_honor->ViewValue, 0);
		$this->tgl_honor->ViewCustomAttributes = "";

		// honor
		$this->honor->ViewValue = $this->honor->CurrentValue;
		$this->honor->ViewCustomAttributes = "";

		// premi_honor
		$this->premi_honor->ViewValue = $this->premi_honor->CurrentValue;
		$this->premi_honor->ViewCustomAttributes = "";

		// tgl_gp
		$this->tgl_gp->ViewValue = $this->tgl_gp->CurrentValue;
		$this->tgl_gp->ViewValue = ew_FormatDateTime($this->tgl_gp->ViewValue, 0);
		$this->tgl_gp->ViewCustomAttributes = "";

		// skala_95
		$this->skala_95->ViewValue = $this->skala_95->CurrentValue;
		$this->skala_95->ViewCustomAttributes = "";

		// gp_95
		$this->gp_95->ViewValue = $this->gp_95->CurrentValue;
		$this->gp_95->ViewCustomAttributes = "";

		// tgl_gp_95
		$this->tgl_gp_95->ViewValue = $this->tgl_gp_95->CurrentValue;
		$this->tgl_gp_95->ViewValue = ew_FormatDateTime($this->tgl_gp_95->ViewValue, 0);
		$this->tgl_gp_95->ViewCustomAttributes = "";

		// kd_indx
		$this->kd_indx->ViewValue = $this->kd_indx->CurrentValue;
		$this->kd_indx->ViewCustomAttributes = "";

		// indx_lok
		$this->indx_lok->ViewValue = $this->indx_lok->CurrentValue;
		$this->indx_lok->ViewCustomAttributes = "";

		// gol_darah
		$this->gol_darah->ViewValue = $this->gol_darah->CurrentValue;
		$this->gol_darah->ViewCustomAttributes = "";

		// kd_jbt
		$this->kd_jbt->ViewValue = $this->kd_jbt->CurrentValue;
		$this->kd_jbt->ViewCustomAttributes = "";

		// tgl_kd_jbt
		$this->tgl_kd_jbt->ViewValue = $this->tgl_kd_jbt->CurrentValue;
		$this->tgl_kd_jbt->ViewValue = ew_FormatDateTime($this->tgl_kd_jbt->ViewValue, 0);
		$this->tgl_kd_jbt->ViewCustomAttributes = "";

		// kd_jbt_pgs
		$this->kd_jbt_pgs->ViewValue = $this->kd_jbt_pgs->CurrentValue;
		$this->kd_jbt_pgs->ViewCustomAttributes = "";

		// tgl_kd_jbt_pgs
		$this->tgl_kd_jbt_pgs->ViewValue = $this->tgl_kd_jbt_pgs->CurrentValue;
		$this->tgl_kd_jbt_pgs->ViewValue = ew_FormatDateTime($this->tgl_kd_jbt_pgs->ViewValue, 0);
		$this->tgl_kd_jbt_pgs->ViewCustomAttributes = "";

		// kd_jbt_pjs
		$this->kd_jbt_pjs->ViewValue = $this->kd_jbt_pjs->CurrentValue;
		$this->kd_jbt_pjs->ViewCustomAttributes = "";

		// tgl_kd_jbt_pjs
		$this->tgl_kd_jbt_pjs->ViewValue = $this->tgl_kd_jbt_pjs->CurrentValue;
		$this->tgl_kd_jbt_pjs->ViewValue = ew_FormatDateTime($this->tgl_kd_jbt_pjs->ViewValue, 0);
		$this->tgl_kd_jbt_pjs->ViewCustomAttributes = "";

		// kd_jbt_ps
		$this->kd_jbt_ps->ViewValue = $this->kd_jbt_ps->CurrentValue;
		$this->kd_jbt_ps->ViewCustomAttributes = "";

		// tgl_kd_jbt_ps
		$this->tgl_kd_jbt_ps->ViewValue = $this->tgl_kd_jbt_ps->CurrentValue;
		$this->tgl_kd_jbt_ps->ViewValue = ew_FormatDateTime($this->tgl_kd_jbt_ps->ViewValue, 0);
		$this->tgl_kd_jbt_ps->ViewCustomAttributes = "";

		// kd_pat
		$this->kd_pat->ViewValue = $this->kd_pat->CurrentValue;
		$this->kd_pat->ViewCustomAttributes = "";

		// kd_gas
		$this->kd_gas->ViewValue = $this->kd_gas->CurrentValue;
		$this->kd_gas->ViewCustomAttributes = "";

		// pimp_empid
		$this->pimp_empid->ViewValue = $this->pimp_empid->CurrentValue;
		$this->pimp_empid->ViewCustomAttributes = "";

		// stshift
		$this->stshift->ViewValue = $this->stshift->CurrentValue;
		$this->stshift->ViewCustomAttributes = "";

		// no_rek
		$this->no_rek->ViewValue = $this->no_rek->CurrentValue;
		$this->no_rek->ViewCustomAttributes = "";

		// kd_bank
		$this->kd_bank->ViewValue = $this->kd_bank->CurrentValue;
		$this->kd_bank->ViewCustomAttributes = "";

		// kd_jamsostek
		$this->kd_jamsostek->ViewValue = $this->kd_jamsostek->CurrentValue;
		$this->kd_jamsostek->ViewCustomAttributes = "";

		// acc_astek
		$this->acc_astek->ViewValue = $this->acc_astek->CurrentValue;
		$this->acc_astek->ViewCustomAttributes = "";

		// acc_dapens
		$this->acc_dapens->ViewValue = $this->acc_dapens->CurrentValue;
		$this->acc_dapens->ViewCustomAttributes = "";

		// acc_kes
		$this->acc_kes->ViewValue = $this->acc_kes->CurrentValue;
		$this->acc_kes->ViewCustomAttributes = "";

		// st
		$this->st->ViewValue = $this->st->CurrentValue;
		$this->st->ViewCustomAttributes = "";

		// signature
		if (!ew_Empty($this->signature->Upload->DbValue)) {
			$this->signature->ViewValue = "personal_signature_bv.php?" . "employee_id=" . $this->employee_id->CurrentValue;
			$this->signature->IsBlobImage = ew_IsImageFile(ew_ContentExt(substr($this->signature->Upload->DbValue, 0, 11)));
		} else {
			$this->signature->ViewValue = "";
		}
		$this->signature->ViewCustomAttributes = "";

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

		// fgr_print_id
		$this->fgr_print_id->ViewValue = $this->fgr_print_id->CurrentValue;
		$this->fgr_print_id->ViewCustomAttributes = "";

		// kd_jbt_eselon
		$this->kd_jbt_eselon->ViewValue = $this->kd_jbt_eselon->CurrentValue;
		$this->kd_jbt_eselon->ViewCustomAttributes = "";

		// npwp
		$this->npwp->ViewValue = $this->npwp->CurrentValue;
		$this->npwp->ViewCustomAttributes = "";

		// paraf
		if (!ew_Empty($this->paraf->Upload->DbValue)) {
			$this->paraf->ViewValue = "personal_paraf_bv.php?" . "employee_id=" . $this->employee_id->CurrentValue;
			$this->paraf->IsBlobImage = ew_IsImageFile(ew_ContentExt(substr($this->paraf->Upload->DbValue, 0, 11)));
		} else {
			$this->paraf->ViewValue = "";
		}
		$this->paraf->ViewCustomAttributes = "";

		// tgl_keluar
		$this->tgl_keluar->ViewValue = $this->tgl_keluar->CurrentValue;
		$this->tgl_keluar->ViewValue = ew_FormatDateTime($this->tgl_keluar->ViewValue, 0);
		$this->tgl_keluar->ViewCustomAttributes = "";

		// nama_nasabah
		$this->nama_nasabah->ViewValue = $this->nama_nasabah->CurrentValue;
		$this->nama_nasabah->ViewCustomAttributes = "";

		// no_ktp
		$this->no_ktp->ViewValue = $this->no_ktp->CurrentValue;
		$this->no_ktp->ViewCustomAttributes = "";

		// no_kokar
		$this->no_kokar->ViewValue = $this->no_kokar->CurrentValue;
		$this->no_kokar->ViewCustomAttributes = "";

		// no_bmw
		$this->no_bmw->ViewValue = $this->no_bmw->CurrentValue;
		$this->no_bmw->ViewCustomAttributes = "";

		// no_bpjs_ketenagakerjaan
		$this->no_bpjs_ketenagakerjaan->ViewValue = $this->no_bpjs_ketenagakerjaan->CurrentValue;
		$this->no_bpjs_ketenagakerjaan->ViewCustomAttributes = "";

		// no_bpjs_kesehatan
		$this->no_bpjs_kesehatan->ViewValue = $this->no_bpjs_kesehatan->CurrentValue;
		$this->no_bpjs_kesehatan->ViewCustomAttributes = "";

		// eselon
		$this->eselon->ViewValue = $this->eselon->CurrentValue;
		$this->eselon->ViewCustomAttributes = "";

		// kd_jenjang
		$this->kd_jenjang->ViewValue = $this->kd_jenjang->CurrentValue;
		$this->kd_jenjang->ViewCustomAttributes = "";

		// kd_jbt_esl
		$this->kd_jbt_esl->ViewValue = $this->kd_jbt_esl->CurrentValue;
		$this->kd_jbt_esl->ViewCustomAttributes = "";

		// tgl_jbt_esl
		$this->tgl_jbt_esl->ViewValue = $this->tgl_jbt_esl->CurrentValue;
		$this->tgl_jbt_esl->ViewValue = ew_FormatDateTime($this->tgl_jbt_esl->ViewValue, 0);
		$this->tgl_jbt_esl->ViewCustomAttributes = "";

		// org_id
		$this->org_id->ViewValue = $this->org_id->CurrentValue;
		$this->org_id->ViewCustomAttributes = "";

		// picture
		if (!ew_Empty($this->picture->Upload->DbValue)) {
			$this->picture->ViewValue = "personal_picture_bv.php?" . "employee_id=" . $this->employee_id->CurrentValue;
			$this->picture->IsBlobImage = ew_IsImageFile(ew_ContentExt(substr($this->picture->Upload->DbValue, 0, 11)));
		} else {
			$this->picture->ViewValue = "";
		}
		$this->picture->ViewCustomAttributes = "";

		// kd_payroll
		$this->kd_payroll->ViewValue = $this->kd_payroll->CurrentValue;
		$this->kd_payroll->ViewCustomAttributes = "";

		// id_wn
		$this->id_wn->ViewValue = $this->id_wn->CurrentValue;
		$this->id_wn->ViewCustomAttributes = "";

		// no_anggota_kkms
		$this->no_anggota_kkms->ViewValue = $this->no_anggota_kkms->CurrentValue;
		$this->no_anggota_kkms->ViewCustomAttributes = "";

			// employee_id
			$this->employee_id->LinkCustomAttributes = "";
			$this->employee_id->HrefValue = "";
			$this->employee_id->TooltipValue = "";

			// first_name
			$this->first_name->LinkCustomAttributes = "";
			$this->first_name->HrefValue = "";
			$this->first_name->TooltipValue = "";

			// last_name
			$this->last_name->LinkCustomAttributes = "";
			$this->last_name->HrefValue = "";
			$this->last_name->TooltipValue = "";

			// first_title
			$this->first_title->LinkCustomAttributes = "";
			$this->first_title->HrefValue = "";
			$this->first_title->TooltipValue = "";

			// last_title
			$this->last_title->LinkCustomAttributes = "";
			$this->last_title->HrefValue = "";
			$this->last_title->TooltipValue = "";

			// init
			$this->init->LinkCustomAttributes = "";
			$this->init->HrefValue = "";
			$this->init->TooltipValue = "";

			// tpt_lahir
			$this->tpt_lahir->LinkCustomAttributes = "";
			$this->tpt_lahir->HrefValue = "";
			$this->tpt_lahir->TooltipValue = "";

			// tgl_lahir
			$this->tgl_lahir->LinkCustomAttributes = "";
			$this->tgl_lahir->HrefValue = "";
			$this->tgl_lahir->TooltipValue = "";

			// jk
			$this->jk->LinkCustomAttributes = "";
			$this->jk->HrefValue = "";
			$this->jk->TooltipValue = "";

			// kd_agama
			$this->kd_agama->LinkCustomAttributes = "";
			$this->kd_agama->HrefValue = "";
			$this->kd_agama->TooltipValue = "";

			// tgl_masuk
			$this->tgl_masuk->LinkCustomAttributes = "";
			$this->tgl_masuk->HrefValue = "";
			$this->tgl_masuk->TooltipValue = "";

			// tpt_masuk
			$this->tpt_masuk->LinkCustomAttributes = "";
			$this->tpt_masuk->HrefValue = "";
			$this->tpt_masuk->TooltipValue = "";

			// stkel
			$this->stkel->LinkCustomAttributes = "";
			$this->stkel->HrefValue = "";
			$this->stkel->TooltipValue = "";

			// alamat
			$this->alamat->LinkCustomAttributes = "";
			$this->alamat->HrefValue = "";
			$this->alamat->TooltipValue = "";

			// kota
			$this->kota->LinkCustomAttributes = "";
			$this->kota->HrefValue = "";
			$this->kota->TooltipValue = "";

			// kd_pos
			$this->kd_pos->LinkCustomAttributes = "";
			$this->kd_pos->HrefValue = "";
			$this->kd_pos->TooltipValue = "";

			// kd_propinsi
			$this->kd_propinsi->LinkCustomAttributes = "";
			$this->kd_propinsi->HrefValue = "";
			$this->kd_propinsi->TooltipValue = "";

			// telp
			$this->telp->LinkCustomAttributes = "";
			$this->telp->HrefValue = "";
			$this->telp->TooltipValue = "";

			// telp_area
			$this->telp_area->LinkCustomAttributes = "";
			$this->telp_area->HrefValue = "";
			$this->telp_area->TooltipValue = "";

			// hp
			$this->hp->LinkCustomAttributes = "";
			$this->hp->HrefValue = "";
			$this->hp->TooltipValue = "";

			// alamat_dom
			$this->alamat_dom->LinkCustomAttributes = "";
			$this->alamat_dom->HrefValue = "";
			$this->alamat_dom->TooltipValue = "";

			// kota_dom
			$this->kota_dom->LinkCustomAttributes = "";
			$this->kota_dom->HrefValue = "";
			$this->kota_dom->TooltipValue = "";

			// kd_pos_dom
			$this->kd_pos_dom->LinkCustomAttributes = "";
			$this->kd_pos_dom->HrefValue = "";
			$this->kd_pos_dom->TooltipValue = "";

			// kd_propinsi_dom
			$this->kd_propinsi_dom->LinkCustomAttributes = "";
			$this->kd_propinsi_dom->HrefValue = "";
			$this->kd_propinsi_dom->TooltipValue = "";

			// telp_dom
			$this->telp_dom->LinkCustomAttributes = "";
			$this->telp_dom->HrefValue = "";
			$this->telp_dom->TooltipValue = "";

			// telp_dom_area
			$this->telp_dom_area->LinkCustomAttributes = "";
			$this->telp_dom_area->HrefValue = "";
			$this->telp_dom_area->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// kd_st_emp
			$this->kd_st_emp->LinkCustomAttributes = "";
			$this->kd_st_emp->HrefValue = "";
			$this->kd_st_emp->TooltipValue = "";

			// skala
			$this->skala->LinkCustomAttributes = "";
			$this->skala->HrefValue = "";
			$this->skala->TooltipValue = "";

			// gp
			$this->gp->LinkCustomAttributes = "";
			$this->gp->HrefValue = "";
			$this->gp->TooltipValue = "";

			// upah_tetap
			$this->upah_tetap->LinkCustomAttributes = "";
			$this->upah_tetap->HrefValue = "";
			$this->upah_tetap->TooltipValue = "";

			// tgl_honor
			$this->tgl_honor->LinkCustomAttributes = "";
			$this->tgl_honor->HrefValue = "";
			$this->tgl_honor->TooltipValue = "";

			// honor
			$this->honor->LinkCustomAttributes = "";
			$this->honor->HrefValue = "";
			$this->honor->TooltipValue = "";

			// premi_honor
			$this->premi_honor->LinkCustomAttributes = "";
			$this->premi_honor->HrefValue = "";
			$this->premi_honor->TooltipValue = "";

			// tgl_gp
			$this->tgl_gp->LinkCustomAttributes = "";
			$this->tgl_gp->HrefValue = "";
			$this->tgl_gp->TooltipValue = "";

			// skala_95
			$this->skala_95->LinkCustomAttributes = "";
			$this->skala_95->HrefValue = "";
			$this->skala_95->TooltipValue = "";

			// gp_95
			$this->gp_95->LinkCustomAttributes = "";
			$this->gp_95->HrefValue = "";
			$this->gp_95->TooltipValue = "";

			// tgl_gp_95
			$this->tgl_gp_95->LinkCustomAttributes = "";
			$this->tgl_gp_95->HrefValue = "";
			$this->tgl_gp_95->TooltipValue = "";

			// kd_indx
			$this->kd_indx->LinkCustomAttributes = "";
			$this->kd_indx->HrefValue = "";
			$this->kd_indx->TooltipValue = "";

			// indx_lok
			$this->indx_lok->LinkCustomAttributes = "";
			$this->indx_lok->HrefValue = "";
			$this->indx_lok->TooltipValue = "";

			// gol_darah
			$this->gol_darah->LinkCustomAttributes = "";
			$this->gol_darah->HrefValue = "";
			$this->gol_darah->TooltipValue = "";

			// kd_jbt
			$this->kd_jbt->LinkCustomAttributes = "";
			$this->kd_jbt->HrefValue = "";
			$this->kd_jbt->TooltipValue = "";

			// tgl_kd_jbt
			$this->tgl_kd_jbt->LinkCustomAttributes = "";
			$this->tgl_kd_jbt->HrefValue = "";
			$this->tgl_kd_jbt->TooltipValue = "";

			// kd_jbt_pgs
			$this->kd_jbt_pgs->LinkCustomAttributes = "";
			$this->kd_jbt_pgs->HrefValue = "";
			$this->kd_jbt_pgs->TooltipValue = "";

			// tgl_kd_jbt_pgs
			$this->tgl_kd_jbt_pgs->LinkCustomAttributes = "";
			$this->tgl_kd_jbt_pgs->HrefValue = "";
			$this->tgl_kd_jbt_pgs->TooltipValue = "";

			// kd_jbt_pjs
			$this->kd_jbt_pjs->LinkCustomAttributes = "";
			$this->kd_jbt_pjs->HrefValue = "";
			$this->kd_jbt_pjs->TooltipValue = "";

			// tgl_kd_jbt_pjs
			$this->tgl_kd_jbt_pjs->LinkCustomAttributes = "";
			$this->tgl_kd_jbt_pjs->HrefValue = "";
			$this->tgl_kd_jbt_pjs->TooltipValue = "";

			// kd_jbt_ps
			$this->kd_jbt_ps->LinkCustomAttributes = "";
			$this->kd_jbt_ps->HrefValue = "";
			$this->kd_jbt_ps->TooltipValue = "";

			// tgl_kd_jbt_ps
			$this->tgl_kd_jbt_ps->LinkCustomAttributes = "";
			$this->tgl_kd_jbt_ps->HrefValue = "";
			$this->tgl_kd_jbt_ps->TooltipValue = "";

			// kd_pat
			$this->kd_pat->LinkCustomAttributes = "";
			$this->kd_pat->HrefValue = "";
			$this->kd_pat->TooltipValue = "";

			// kd_gas
			$this->kd_gas->LinkCustomAttributes = "";
			$this->kd_gas->HrefValue = "";
			$this->kd_gas->TooltipValue = "";

			// pimp_empid
			$this->pimp_empid->LinkCustomAttributes = "";
			$this->pimp_empid->HrefValue = "";
			$this->pimp_empid->TooltipValue = "";

			// stshift
			$this->stshift->LinkCustomAttributes = "";
			$this->stshift->HrefValue = "";
			$this->stshift->TooltipValue = "";

			// no_rek
			$this->no_rek->LinkCustomAttributes = "";
			$this->no_rek->HrefValue = "";
			$this->no_rek->TooltipValue = "";

			// kd_bank
			$this->kd_bank->LinkCustomAttributes = "";
			$this->kd_bank->HrefValue = "";
			$this->kd_bank->TooltipValue = "";

			// kd_jamsostek
			$this->kd_jamsostek->LinkCustomAttributes = "";
			$this->kd_jamsostek->HrefValue = "";
			$this->kd_jamsostek->TooltipValue = "";

			// acc_astek
			$this->acc_astek->LinkCustomAttributes = "";
			$this->acc_astek->HrefValue = "";
			$this->acc_astek->TooltipValue = "";

			// acc_dapens
			$this->acc_dapens->LinkCustomAttributes = "";
			$this->acc_dapens->HrefValue = "";
			$this->acc_dapens->TooltipValue = "";

			// acc_kes
			$this->acc_kes->LinkCustomAttributes = "";
			$this->acc_kes->HrefValue = "";
			$this->acc_kes->TooltipValue = "";

			// st
			$this->st->LinkCustomAttributes = "";
			$this->st->HrefValue = "";
			$this->st->TooltipValue = "";

			// signature
			$this->signature->LinkCustomAttributes = "";
			if (!empty($this->signature->Upload->DbValue)) {
				$this->signature->HrefValue = "personal_signature_bv.php?employee_id=" . $this->employee_id->CurrentValue;
				$this->signature->LinkAttrs["target"] = "_blank";
				if ($this->Export <> "") $this->signature->HrefValue = ew_FullUrl($this->signature->HrefValue, "href");
			} else {
				$this->signature->HrefValue = "";
			}
			$this->signature->HrefValue2 = "personal_signature_bv.php?employee_id=" . $this->employee_id->CurrentValue;
			$this->signature->TooltipValue = "";

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

			// fgr_print_id
			$this->fgr_print_id->LinkCustomAttributes = "";
			$this->fgr_print_id->HrefValue = "";
			$this->fgr_print_id->TooltipValue = "";

			// kd_jbt_eselon
			$this->kd_jbt_eselon->LinkCustomAttributes = "";
			$this->kd_jbt_eselon->HrefValue = "";
			$this->kd_jbt_eselon->TooltipValue = "";

			// npwp
			$this->npwp->LinkCustomAttributes = "";
			$this->npwp->HrefValue = "";
			$this->npwp->TooltipValue = "";

			// paraf
			$this->paraf->LinkCustomAttributes = "";
			if (!empty($this->paraf->Upload->DbValue)) {
				$this->paraf->HrefValue = "personal_paraf_bv.php?employee_id=" . $this->employee_id->CurrentValue;
				$this->paraf->LinkAttrs["target"] = "_blank";
				if ($this->Export <> "") $this->paraf->HrefValue = ew_FullUrl($this->paraf->HrefValue, "href");
			} else {
				$this->paraf->HrefValue = "";
			}
			$this->paraf->HrefValue2 = "personal_paraf_bv.php?employee_id=" . $this->employee_id->CurrentValue;
			$this->paraf->TooltipValue = "";

			// tgl_keluar
			$this->tgl_keluar->LinkCustomAttributes = "";
			$this->tgl_keluar->HrefValue = "";
			$this->tgl_keluar->TooltipValue = "";

			// nama_nasabah
			$this->nama_nasabah->LinkCustomAttributes = "";
			$this->nama_nasabah->HrefValue = "";
			$this->nama_nasabah->TooltipValue = "";

			// no_ktp
			$this->no_ktp->LinkCustomAttributes = "";
			$this->no_ktp->HrefValue = "";
			$this->no_ktp->TooltipValue = "";

			// no_kokar
			$this->no_kokar->LinkCustomAttributes = "";
			$this->no_kokar->HrefValue = "";
			$this->no_kokar->TooltipValue = "";

			// no_bmw
			$this->no_bmw->LinkCustomAttributes = "";
			$this->no_bmw->HrefValue = "";
			$this->no_bmw->TooltipValue = "";

			// no_bpjs_ketenagakerjaan
			$this->no_bpjs_ketenagakerjaan->LinkCustomAttributes = "";
			$this->no_bpjs_ketenagakerjaan->HrefValue = "";
			$this->no_bpjs_ketenagakerjaan->TooltipValue = "";

			// no_bpjs_kesehatan
			$this->no_bpjs_kesehatan->LinkCustomAttributes = "";
			$this->no_bpjs_kesehatan->HrefValue = "";
			$this->no_bpjs_kesehatan->TooltipValue = "";

			// eselon
			$this->eselon->LinkCustomAttributes = "";
			$this->eselon->HrefValue = "";
			$this->eselon->TooltipValue = "";

			// kd_jenjang
			$this->kd_jenjang->LinkCustomAttributes = "";
			$this->kd_jenjang->HrefValue = "";
			$this->kd_jenjang->TooltipValue = "";

			// kd_jbt_esl
			$this->kd_jbt_esl->LinkCustomAttributes = "";
			$this->kd_jbt_esl->HrefValue = "";
			$this->kd_jbt_esl->TooltipValue = "";

			// tgl_jbt_esl
			$this->tgl_jbt_esl->LinkCustomAttributes = "";
			$this->tgl_jbt_esl->HrefValue = "";
			$this->tgl_jbt_esl->TooltipValue = "";

			// org_id
			$this->org_id->LinkCustomAttributes = "";
			$this->org_id->HrefValue = "";
			$this->org_id->TooltipValue = "";

			// picture
			$this->picture->LinkCustomAttributes = "";
			if (!empty($this->picture->Upload->DbValue)) {
				$this->picture->HrefValue = "personal_picture_bv.php?employee_id=" . $this->employee_id->CurrentValue;
				$this->picture->LinkAttrs["target"] = "_blank";
				if ($this->Export <> "") $this->picture->HrefValue = ew_FullUrl($this->picture->HrefValue, "href");
			} else {
				$this->picture->HrefValue = "";
			}
			$this->picture->HrefValue2 = "personal_picture_bv.php?employee_id=" . $this->employee_id->CurrentValue;
			$this->picture->TooltipValue = "";

			// kd_payroll
			$this->kd_payroll->LinkCustomAttributes = "";
			$this->kd_payroll->HrefValue = "";
			$this->kd_payroll->TooltipValue = "";

			// id_wn
			$this->id_wn->LinkCustomAttributes = "";
			$this->id_wn->HrefValue = "";
			$this->id_wn->TooltipValue = "";

			// no_anggota_kkms
			$this->no_anggota_kkms->LinkCustomAttributes = "";
			$this->no_anggota_kkms->HrefValue = "";
			$this->no_anggota_kkms->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("personallist.php"), "", $this->TableVar, TRUE);
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
if (!isset($personal_view)) $personal_view = new cpersonal_view();

// Page init
$personal_view->Page_Init();

// Page main
$personal_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$personal_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fpersonalview = new ew_Form("fpersonalview", "view");

// Form_CustomValidate event
fpersonalview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fpersonalview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $personal_view->ExportOptions->Render("body") ?>
<?php
	foreach ($personal_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $personal_view->ShowPageHeader(); ?>
<?php
$personal_view->ShowMessage();
?>
<form name="fpersonalview" id="fpersonalview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($personal_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $personal_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="personal">
<input type="hidden" name="modal" value="<?php echo intval($personal_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($personal->employee_id->Visible) { // employee_id ?>
	<tr id="r_employee_id">
		<td class="col-sm-2"><span id="elh_personal_employee_id"><?php echo $personal->employee_id->FldCaption() ?></span></td>
		<td data-name="employee_id"<?php echo $personal->employee_id->CellAttributes() ?>>
<span id="el_personal_employee_id">
<span<?php echo $personal->employee_id->ViewAttributes() ?>>
<?php echo $personal->employee_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->first_name->Visible) { // first_name ?>
	<tr id="r_first_name">
		<td class="col-sm-2"><span id="elh_personal_first_name"><?php echo $personal->first_name->FldCaption() ?></span></td>
		<td data-name="first_name"<?php echo $personal->first_name->CellAttributes() ?>>
<span id="el_personal_first_name">
<span<?php echo $personal->first_name->ViewAttributes() ?>>
<?php echo $personal->first_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->last_name->Visible) { // last_name ?>
	<tr id="r_last_name">
		<td class="col-sm-2"><span id="elh_personal_last_name"><?php echo $personal->last_name->FldCaption() ?></span></td>
		<td data-name="last_name"<?php echo $personal->last_name->CellAttributes() ?>>
<span id="el_personal_last_name">
<span<?php echo $personal->last_name->ViewAttributes() ?>>
<?php echo $personal->last_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->first_title->Visible) { // first_title ?>
	<tr id="r_first_title">
		<td class="col-sm-2"><span id="elh_personal_first_title"><?php echo $personal->first_title->FldCaption() ?></span></td>
		<td data-name="first_title"<?php echo $personal->first_title->CellAttributes() ?>>
<span id="el_personal_first_title">
<span<?php echo $personal->first_title->ViewAttributes() ?>>
<?php echo $personal->first_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->last_title->Visible) { // last_title ?>
	<tr id="r_last_title">
		<td class="col-sm-2"><span id="elh_personal_last_title"><?php echo $personal->last_title->FldCaption() ?></span></td>
		<td data-name="last_title"<?php echo $personal->last_title->CellAttributes() ?>>
<span id="el_personal_last_title">
<span<?php echo $personal->last_title->ViewAttributes() ?>>
<?php echo $personal->last_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->init->Visible) { // init ?>
	<tr id="r_init">
		<td class="col-sm-2"><span id="elh_personal_init"><?php echo $personal->init->FldCaption() ?></span></td>
		<td data-name="init"<?php echo $personal->init->CellAttributes() ?>>
<span id="el_personal_init">
<span<?php echo $personal->init->ViewAttributes() ?>>
<?php echo $personal->init->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->tpt_lahir->Visible) { // tpt_lahir ?>
	<tr id="r_tpt_lahir">
		<td class="col-sm-2"><span id="elh_personal_tpt_lahir"><?php echo $personal->tpt_lahir->FldCaption() ?></span></td>
		<td data-name="tpt_lahir"<?php echo $personal->tpt_lahir->CellAttributes() ?>>
<span id="el_personal_tpt_lahir">
<span<?php echo $personal->tpt_lahir->ViewAttributes() ?>>
<?php echo $personal->tpt_lahir->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->tgl_lahir->Visible) { // tgl_lahir ?>
	<tr id="r_tgl_lahir">
		<td class="col-sm-2"><span id="elh_personal_tgl_lahir"><?php echo $personal->tgl_lahir->FldCaption() ?></span></td>
		<td data-name="tgl_lahir"<?php echo $personal->tgl_lahir->CellAttributes() ?>>
<span id="el_personal_tgl_lahir">
<span<?php echo $personal->tgl_lahir->ViewAttributes() ?>>
<?php echo $personal->tgl_lahir->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->jk->Visible) { // jk ?>
	<tr id="r_jk">
		<td class="col-sm-2"><span id="elh_personal_jk"><?php echo $personal->jk->FldCaption() ?></span></td>
		<td data-name="jk"<?php echo $personal->jk->CellAttributes() ?>>
<span id="el_personal_jk">
<span<?php echo $personal->jk->ViewAttributes() ?>>
<?php echo $personal->jk->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_agama->Visible) { // kd_agama ?>
	<tr id="r_kd_agama">
		<td class="col-sm-2"><span id="elh_personal_kd_agama"><?php echo $personal->kd_agama->FldCaption() ?></span></td>
		<td data-name="kd_agama"<?php echo $personal->kd_agama->CellAttributes() ?>>
<span id="el_personal_kd_agama">
<span<?php echo $personal->kd_agama->ViewAttributes() ?>>
<?php echo $personal->kd_agama->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->tgl_masuk->Visible) { // tgl_masuk ?>
	<tr id="r_tgl_masuk">
		<td class="col-sm-2"><span id="elh_personal_tgl_masuk"><?php echo $personal->tgl_masuk->FldCaption() ?></span></td>
		<td data-name="tgl_masuk"<?php echo $personal->tgl_masuk->CellAttributes() ?>>
<span id="el_personal_tgl_masuk">
<span<?php echo $personal->tgl_masuk->ViewAttributes() ?>>
<?php echo $personal->tgl_masuk->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->tpt_masuk->Visible) { // tpt_masuk ?>
	<tr id="r_tpt_masuk">
		<td class="col-sm-2"><span id="elh_personal_tpt_masuk"><?php echo $personal->tpt_masuk->FldCaption() ?></span></td>
		<td data-name="tpt_masuk"<?php echo $personal->tpt_masuk->CellAttributes() ?>>
<span id="el_personal_tpt_masuk">
<span<?php echo $personal->tpt_masuk->ViewAttributes() ?>>
<?php echo $personal->tpt_masuk->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->stkel->Visible) { // stkel ?>
	<tr id="r_stkel">
		<td class="col-sm-2"><span id="elh_personal_stkel"><?php echo $personal->stkel->FldCaption() ?></span></td>
		<td data-name="stkel"<?php echo $personal->stkel->CellAttributes() ?>>
<span id="el_personal_stkel">
<span<?php echo $personal->stkel->ViewAttributes() ?>>
<?php echo $personal->stkel->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->alamat->Visible) { // alamat ?>
	<tr id="r_alamat">
		<td class="col-sm-2"><span id="elh_personal_alamat"><?php echo $personal->alamat->FldCaption() ?></span></td>
		<td data-name="alamat"<?php echo $personal->alamat->CellAttributes() ?>>
<span id="el_personal_alamat">
<span<?php echo $personal->alamat->ViewAttributes() ?>>
<?php echo $personal->alamat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kota->Visible) { // kota ?>
	<tr id="r_kota">
		<td class="col-sm-2"><span id="elh_personal_kota"><?php echo $personal->kota->FldCaption() ?></span></td>
		<td data-name="kota"<?php echo $personal->kota->CellAttributes() ?>>
<span id="el_personal_kota">
<span<?php echo $personal->kota->ViewAttributes() ?>>
<?php echo $personal->kota->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_pos->Visible) { // kd_pos ?>
	<tr id="r_kd_pos">
		<td class="col-sm-2"><span id="elh_personal_kd_pos"><?php echo $personal->kd_pos->FldCaption() ?></span></td>
		<td data-name="kd_pos"<?php echo $personal->kd_pos->CellAttributes() ?>>
<span id="el_personal_kd_pos">
<span<?php echo $personal->kd_pos->ViewAttributes() ?>>
<?php echo $personal->kd_pos->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_propinsi->Visible) { // kd_propinsi ?>
	<tr id="r_kd_propinsi">
		<td class="col-sm-2"><span id="elh_personal_kd_propinsi"><?php echo $personal->kd_propinsi->FldCaption() ?></span></td>
		<td data-name="kd_propinsi"<?php echo $personal->kd_propinsi->CellAttributes() ?>>
<span id="el_personal_kd_propinsi">
<span<?php echo $personal->kd_propinsi->ViewAttributes() ?>>
<?php echo $personal->kd_propinsi->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->telp->Visible) { // telp ?>
	<tr id="r_telp">
		<td class="col-sm-2"><span id="elh_personal_telp"><?php echo $personal->telp->FldCaption() ?></span></td>
		<td data-name="telp"<?php echo $personal->telp->CellAttributes() ?>>
<span id="el_personal_telp">
<span<?php echo $personal->telp->ViewAttributes() ?>>
<?php echo $personal->telp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->telp_area->Visible) { // telp_area ?>
	<tr id="r_telp_area">
		<td class="col-sm-2"><span id="elh_personal_telp_area"><?php echo $personal->telp_area->FldCaption() ?></span></td>
		<td data-name="telp_area"<?php echo $personal->telp_area->CellAttributes() ?>>
<span id="el_personal_telp_area">
<span<?php echo $personal->telp_area->ViewAttributes() ?>>
<?php echo $personal->telp_area->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->hp->Visible) { // hp ?>
	<tr id="r_hp">
		<td class="col-sm-2"><span id="elh_personal_hp"><?php echo $personal->hp->FldCaption() ?></span></td>
		<td data-name="hp"<?php echo $personal->hp->CellAttributes() ?>>
<span id="el_personal_hp">
<span<?php echo $personal->hp->ViewAttributes() ?>>
<?php echo $personal->hp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->alamat_dom->Visible) { // alamat_dom ?>
	<tr id="r_alamat_dom">
		<td class="col-sm-2"><span id="elh_personal_alamat_dom"><?php echo $personal->alamat_dom->FldCaption() ?></span></td>
		<td data-name="alamat_dom"<?php echo $personal->alamat_dom->CellAttributes() ?>>
<span id="el_personal_alamat_dom">
<span<?php echo $personal->alamat_dom->ViewAttributes() ?>>
<?php echo $personal->alamat_dom->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kota_dom->Visible) { // kota_dom ?>
	<tr id="r_kota_dom">
		<td class="col-sm-2"><span id="elh_personal_kota_dom"><?php echo $personal->kota_dom->FldCaption() ?></span></td>
		<td data-name="kota_dom"<?php echo $personal->kota_dom->CellAttributes() ?>>
<span id="el_personal_kota_dom">
<span<?php echo $personal->kota_dom->ViewAttributes() ?>>
<?php echo $personal->kota_dom->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_pos_dom->Visible) { // kd_pos_dom ?>
	<tr id="r_kd_pos_dom">
		<td class="col-sm-2"><span id="elh_personal_kd_pos_dom"><?php echo $personal->kd_pos_dom->FldCaption() ?></span></td>
		<td data-name="kd_pos_dom"<?php echo $personal->kd_pos_dom->CellAttributes() ?>>
<span id="el_personal_kd_pos_dom">
<span<?php echo $personal->kd_pos_dom->ViewAttributes() ?>>
<?php echo $personal->kd_pos_dom->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_propinsi_dom->Visible) { // kd_propinsi_dom ?>
	<tr id="r_kd_propinsi_dom">
		<td class="col-sm-2"><span id="elh_personal_kd_propinsi_dom"><?php echo $personal->kd_propinsi_dom->FldCaption() ?></span></td>
		<td data-name="kd_propinsi_dom"<?php echo $personal->kd_propinsi_dom->CellAttributes() ?>>
<span id="el_personal_kd_propinsi_dom">
<span<?php echo $personal->kd_propinsi_dom->ViewAttributes() ?>>
<?php echo $personal->kd_propinsi_dom->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->telp_dom->Visible) { // telp_dom ?>
	<tr id="r_telp_dom">
		<td class="col-sm-2"><span id="elh_personal_telp_dom"><?php echo $personal->telp_dom->FldCaption() ?></span></td>
		<td data-name="telp_dom"<?php echo $personal->telp_dom->CellAttributes() ?>>
<span id="el_personal_telp_dom">
<span<?php echo $personal->telp_dom->ViewAttributes() ?>>
<?php echo $personal->telp_dom->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->telp_dom_area->Visible) { // telp_dom_area ?>
	<tr id="r_telp_dom_area">
		<td class="col-sm-2"><span id="elh_personal_telp_dom_area"><?php echo $personal->telp_dom_area->FldCaption() ?></span></td>
		<td data-name="telp_dom_area"<?php echo $personal->telp_dom_area->CellAttributes() ?>>
<span id="el_personal_telp_dom_area">
<span<?php echo $personal->telp_dom_area->ViewAttributes() ?>>
<?php echo $personal->telp_dom_area->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->_email->Visible) { // email ?>
	<tr id="r__email">
		<td class="col-sm-2"><span id="elh_personal__email"><?php echo $personal->_email->FldCaption() ?></span></td>
		<td data-name="_email"<?php echo $personal->_email->CellAttributes() ?>>
<span id="el_personal__email">
<span<?php echo $personal->_email->ViewAttributes() ?>>
<?php echo $personal->_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_st_emp->Visible) { // kd_st_emp ?>
	<tr id="r_kd_st_emp">
		<td class="col-sm-2"><span id="elh_personal_kd_st_emp"><?php echo $personal->kd_st_emp->FldCaption() ?></span></td>
		<td data-name="kd_st_emp"<?php echo $personal->kd_st_emp->CellAttributes() ?>>
<span id="el_personal_kd_st_emp">
<span<?php echo $personal->kd_st_emp->ViewAttributes() ?>>
<?php echo $personal->kd_st_emp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->skala->Visible) { // skala ?>
	<tr id="r_skala">
		<td class="col-sm-2"><span id="elh_personal_skala"><?php echo $personal->skala->FldCaption() ?></span></td>
		<td data-name="skala"<?php echo $personal->skala->CellAttributes() ?>>
<span id="el_personal_skala">
<span<?php echo $personal->skala->ViewAttributes() ?>>
<?php echo $personal->skala->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->gp->Visible) { // gp ?>
	<tr id="r_gp">
		<td class="col-sm-2"><span id="elh_personal_gp"><?php echo $personal->gp->FldCaption() ?></span></td>
		<td data-name="gp"<?php echo $personal->gp->CellAttributes() ?>>
<span id="el_personal_gp">
<span<?php echo $personal->gp->ViewAttributes() ?>>
<?php echo $personal->gp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->upah_tetap->Visible) { // upah_tetap ?>
	<tr id="r_upah_tetap">
		<td class="col-sm-2"><span id="elh_personal_upah_tetap"><?php echo $personal->upah_tetap->FldCaption() ?></span></td>
		<td data-name="upah_tetap"<?php echo $personal->upah_tetap->CellAttributes() ?>>
<span id="el_personal_upah_tetap">
<span<?php echo $personal->upah_tetap->ViewAttributes() ?>>
<?php echo $personal->upah_tetap->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->tgl_honor->Visible) { // tgl_honor ?>
	<tr id="r_tgl_honor">
		<td class="col-sm-2"><span id="elh_personal_tgl_honor"><?php echo $personal->tgl_honor->FldCaption() ?></span></td>
		<td data-name="tgl_honor"<?php echo $personal->tgl_honor->CellAttributes() ?>>
<span id="el_personal_tgl_honor">
<span<?php echo $personal->tgl_honor->ViewAttributes() ?>>
<?php echo $personal->tgl_honor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->honor->Visible) { // honor ?>
	<tr id="r_honor">
		<td class="col-sm-2"><span id="elh_personal_honor"><?php echo $personal->honor->FldCaption() ?></span></td>
		<td data-name="honor"<?php echo $personal->honor->CellAttributes() ?>>
<span id="el_personal_honor">
<span<?php echo $personal->honor->ViewAttributes() ?>>
<?php echo $personal->honor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->premi_honor->Visible) { // premi_honor ?>
	<tr id="r_premi_honor">
		<td class="col-sm-2"><span id="elh_personal_premi_honor"><?php echo $personal->premi_honor->FldCaption() ?></span></td>
		<td data-name="premi_honor"<?php echo $personal->premi_honor->CellAttributes() ?>>
<span id="el_personal_premi_honor">
<span<?php echo $personal->premi_honor->ViewAttributes() ?>>
<?php echo $personal->premi_honor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->tgl_gp->Visible) { // tgl_gp ?>
	<tr id="r_tgl_gp">
		<td class="col-sm-2"><span id="elh_personal_tgl_gp"><?php echo $personal->tgl_gp->FldCaption() ?></span></td>
		<td data-name="tgl_gp"<?php echo $personal->tgl_gp->CellAttributes() ?>>
<span id="el_personal_tgl_gp">
<span<?php echo $personal->tgl_gp->ViewAttributes() ?>>
<?php echo $personal->tgl_gp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->skala_95->Visible) { // skala_95 ?>
	<tr id="r_skala_95">
		<td class="col-sm-2"><span id="elh_personal_skala_95"><?php echo $personal->skala_95->FldCaption() ?></span></td>
		<td data-name="skala_95"<?php echo $personal->skala_95->CellAttributes() ?>>
<span id="el_personal_skala_95">
<span<?php echo $personal->skala_95->ViewAttributes() ?>>
<?php echo $personal->skala_95->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->gp_95->Visible) { // gp_95 ?>
	<tr id="r_gp_95">
		<td class="col-sm-2"><span id="elh_personal_gp_95"><?php echo $personal->gp_95->FldCaption() ?></span></td>
		<td data-name="gp_95"<?php echo $personal->gp_95->CellAttributes() ?>>
<span id="el_personal_gp_95">
<span<?php echo $personal->gp_95->ViewAttributes() ?>>
<?php echo $personal->gp_95->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->tgl_gp_95->Visible) { // tgl_gp_95 ?>
	<tr id="r_tgl_gp_95">
		<td class="col-sm-2"><span id="elh_personal_tgl_gp_95"><?php echo $personal->tgl_gp_95->FldCaption() ?></span></td>
		<td data-name="tgl_gp_95"<?php echo $personal->tgl_gp_95->CellAttributes() ?>>
<span id="el_personal_tgl_gp_95">
<span<?php echo $personal->tgl_gp_95->ViewAttributes() ?>>
<?php echo $personal->tgl_gp_95->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_indx->Visible) { // kd_indx ?>
	<tr id="r_kd_indx">
		<td class="col-sm-2"><span id="elh_personal_kd_indx"><?php echo $personal->kd_indx->FldCaption() ?></span></td>
		<td data-name="kd_indx"<?php echo $personal->kd_indx->CellAttributes() ?>>
<span id="el_personal_kd_indx">
<span<?php echo $personal->kd_indx->ViewAttributes() ?>>
<?php echo $personal->kd_indx->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->indx_lok->Visible) { // indx_lok ?>
	<tr id="r_indx_lok">
		<td class="col-sm-2"><span id="elh_personal_indx_lok"><?php echo $personal->indx_lok->FldCaption() ?></span></td>
		<td data-name="indx_lok"<?php echo $personal->indx_lok->CellAttributes() ?>>
<span id="el_personal_indx_lok">
<span<?php echo $personal->indx_lok->ViewAttributes() ?>>
<?php echo $personal->indx_lok->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->gol_darah->Visible) { // gol_darah ?>
	<tr id="r_gol_darah">
		<td class="col-sm-2"><span id="elh_personal_gol_darah"><?php echo $personal->gol_darah->FldCaption() ?></span></td>
		<td data-name="gol_darah"<?php echo $personal->gol_darah->CellAttributes() ?>>
<span id="el_personal_gol_darah">
<span<?php echo $personal->gol_darah->ViewAttributes() ?>>
<?php echo $personal->gol_darah->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_jbt->Visible) { // kd_jbt ?>
	<tr id="r_kd_jbt">
		<td class="col-sm-2"><span id="elh_personal_kd_jbt"><?php echo $personal->kd_jbt->FldCaption() ?></span></td>
		<td data-name="kd_jbt"<?php echo $personal->kd_jbt->CellAttributes() ?>>
<span id="el_personal_kd_jbt">
<span<?php echo $personal->kd_jbt->ViewAttributes() ?>>
<?php echo $personal->kd_jbt->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->tgl_kd_jbt->Visible) { // tgl_kd_jbt ?>
	<tr id="r_tgl_kd_jbt">
		<td class="col-sm-2"><span id="elh_personal_tgl_kd_jbt"><?php echo $personal->tgl_kd_jbt->FldCaption() ?></span></td>
		<td data-name="tgl_kd_jbt"<?php echo $personal->tgl_kd_jbt->CellAttributes() ?>>
<span id="el_personal_tgl_kd_jbt">
<span<?php echo $personal->tgl_kd_jbt->ViewAttributes() ?>>
<?php echo $personal->tgl_kd_jbt->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_jbt_pgs->Visible) { // kd_jbt_pgs ?>
	<tr id="r_kd_jbt_pgs">
		<td class="col-sm-2"><span id="elh_personal_kd_jbt_pgs"><?php echo $personal->kd_jbt_pgs->FldCaption() ?></span></td>
		<td data-name="kd_jbt_pgs"<?php echo $personal->kd_jbt_pgs->CellAttributes() ?>>
<span id="el_personal_kd_jbt_pgs">
<span<?php echo $personal->kd_jbt_pgs->ViewAttributes() ?>>
<?php echo $personal->kd_jbt_pgs->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->tgl_kd_jbt_pgs->Visible) { // tgl_kd_jbt_pgs ?>
	<tr id="r_tgl_kd_jbt_pgs">
		<td class="col-sm-2"><span id="elh_personal_tgl_kd_jbt_pgs"><?php echo $personal->tgl_kd_jbt_pgs->FldCaption() ?></span></td>
		<td data-name="tgl_kd_jbt_pgs"<?php echo $personal->tgl_kd_jbt_pgs->CellAttributes() ?>>
<span id="el_personal_tgl_kd_jbt_pgs">
<span<?php echo $personal->tgl_kd_jbt_pgs->ViewAttributes() ?>>
<?php echo $personal->tgl_kd_jbt_pgs->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_jbt_pjs->Visible) { // kd_jbt_pjs ?>
	<tr id="r_kd_jbt_pjs">
		<td class="col-sm-2"><span id="elh_personal_kd_jbt_pjs"><?php echo $personal->kd_jbt_pjs->FldCaption() ?></span></td>
		<td data-name="kd_jbt_pjs"<?php echo $personal->kd_jbt_pjs->CellAttributes() ?>>
<span id="el_personal_kd_jbt_pjs">
<span<?php echo $personal->kd_jbt_pjs->ViewAttributes() ?>>
<?php echo $personal->kd_jbt_pjs->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->tgl_kd_jbt_pjs->Visible) { // tgl_kd_jbt_pjs ?>
	<tr id="r_tgl_kd_jbt_pjs">
		<td class="col-sm-2"><span id="elh_personal_tgl_kd_jbt_pjs"><?php echo $personal->tgl_kd_jbt_pjs->FldCaption() ?></span></td>
		<td data-name="tgl_kd_jbt_pjs"<?php echo $personal->tgl_kd_jbt_pjs->CellAttributes() ?>>
<span id="el_personal_tgl_kd_jbt_pjs">
<span<?php echo $personal->tgl_kd_jbt_pjs->ViewAttributes() ?>>
<?php echo $personal->tgl_kd_jbt_pjs->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_jbt_ps->Visible) { // kd_jbt_ps ?>
	<tr id="r_kd_jbt_ps">
		<td class="col-sm-2"><span id="elh_personal_kd_jbt_ps"><?php echo $personal->kd_jbt_ps->FldCaption() ?></span></td>
		<td data-name="kd_jbt_ps"<?php echo $personal->kd_jbt_ps->CellAttributes() ?>>
<span id="el_personal_kd_jbt_ps">
<span<?php echo $personal->kd_jbt_ps->ViewAttributes() ?>>
<?php echo $personal->kd_jbt_ps->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->tgl_kd_jbt_ps->Visible) { // tgl_kd_jbt_ps ?>
	<tr id="r_tgl_kd_jbt_ps">
		<td class="col-sm-2"><span id="elh_personal_tgl_kd_jbt_ps"><?php echo $personal->tgl_kd_jbt_ps->FldCaption() ?></span></td>
		<td data-name="tgl_kd_jbt_ps"<?php echo $personal->tgl_kd_jbt_ps->CellAttributes() ?>>
<span id="el_personal_tgl_kd_jbt_ps">
<span<?php echo $personal->tgl_kd_jbt_ps->ViewAttributes() ?>>
<?php echo $personal->tgl_kd_jbt_ps->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_pat->Visible) { // kd_pat ?>
	<tr id="r_kd_pat">
		<td class="col-sm-2"><span id="elh_personal_kd_pat"><?php echo $personal->kd_pat->FldCaption() ?></span></td>
		<td data-name="kd_pat"<?php echo $personal->kd_pat->CellAttributes() ?>>
<span id="el_personal_kd_pat">
<span<?php echo $personal->kd_pat->ViewAttributes() ?>>
<?php echo $personal->kd_pat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_gas->Visible) { // kd_gas ?>
	<tr id="r_kd_gas">
		<td class="col-sm-2"><span id="elh_personal_kd_gas"><?php echo $personal->kd_gas->FldCaption() ?></span></td>
		<td data-name="kd_gas"<?php echo $personal->kd_gas->CellAttributes() ?>>
<span id="el_personal_kd_gas">
<span<?php echo $personal->kd_gas->ViewAttributes() ?>>
<?php echo $personal->kd_gas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->pimp_empid->Visible) { // pimp_empid ?>
	<tr id="r_pimp_empid">
		<td class="col-sm-2"><span id="elh_personal_pimp_empid"><?php echo $personal->pimp_empid->FldCaption() ?></span></td>
		<td data-name="pimp_empid"<?php echo $personal->pimp_empid->CellAttributes() ?>>
<span id="el_personal_pimp_empid">
<span<?php echo $personal->pimp_empid->ViewAttributes() ?>>
<?php echo $personal->pimp_empid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->stshift->Visible) { // stshift ?>
	<tr id="r_stshift">
		<td class="col-sm-2"><span id="elh_personal_stshift"><?php echo $personal->stshift->FldCaption() ?></span></td>
		<td data-name="stshift"<?php echo $personal->stshift->CellAttributes() ?>>
<span id="el_personal_stshift">
<span<?php echo $personal->stshift->ViewAttributes() ?>>
<?php echo $personal->stshift->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->no_rek->Visible) { // no_rek ?>
	<tr id="r_no_rek">
		<td class="col-sm-2"><span id="elh_personal_no_rek"><?php echo $personal->no_rek->FldCaption() ?></span></td>
		<td data-name="no_rek"<?php echo $personal->no_rek->CellAttributes() ?>>
<span id="el_personal_no_rek">
<span<?php echo $personal->no_rek->ViewAttributes() ?>>
<?php echo $personal->no_rek->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_bank->Visible) { // kd_bank ?>
	<tr id="r_kd_bank">
		<td class="col-sm-2"><span id="elh_personal_kd_bank"><?php echo $personal->kd_bank->FldCaption() ?></span></td>
		<td data-name="kd_bank"<?php echo $personal->kd_bank->CellAttributes() ?>>
<span id="el_personal_kd_bank">
<span<?php echo $personal->kd_bank->ViewAttributes() ?>>
<?php echo $personal->kd_bank->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_jamsostek->Visible) { // kd_jamsostek ?>
	<tr id="r_kd_jamsostek">
		<td class="col-sm-2"><span id="elh_personal_kd_jamsostek"><?php echo $personal->kd_jamsostek->FldCaption() ?></span></td>
		<td data-name="kd_jamsostek"<?php echo $personal->kd_jamsostek->CellAttributes() ?>>
<span id="el_personal_kd_jamsostek">
<span<?php echo $personal->kd_jamsostek->ViewAttributes() ?>>
<?php echo $personal->kd_jamsostek->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->acc_astek->Visible) { // acc_astek ?>
	<tr id="r_acc_astek">
		<td class="col-sm-2"><span id="elh_personal_acc_astek"><?php echo $personal->acc_astek->FldCaption() ?></span></td>
		<td data-name="acc_astek"<?php echo $personal->acc_astek->CellAttributes() ?>>
<span id="el_personal_acc_astek">
<span<?php echo $personal->acc_astek->ViewAttributes() ?>>
<?php echo $personal->acc_astek->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->acc_dapens->Visible) { // acc_dapens ?>
	<tr id="r_acc_dapens">
		<td class="col-sm-2"><span id="elh_personal_acc_dapens"><?php echo $personal->acc_dapens->FldCaption() ?></span></td>
		<td data-name="acc_dapens"<?php echo $personal->acc_dapens->CellAttributes() ?>>
<span id="el_personal_acc_dapens">
<span<?php echo $personal->acc_dapens->ViewAttributes() ?>>
<?php echo $personal->acc_dapens->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->acc_kes->Visible) { // acc_kes ?>
	<tr id="r_acc_kes">
		<td class="col-sm-2"><span id="elh_personal_acc_kes"><?php echo $personal->acc_kes->FldCaption() ?></span></td>
		<td data-name="acc_kes"<?php echo $personal->acc_kes->CellAttributes() ?>>
<span id="el_personal_acc_kes">
<span<?php echo $personal->acc_kes->ViewAttributes() ?>>
<?php echo $personal->acc_kes->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->st->Visible) { // st ?>
	<tr id="r_st">
		<td class="col-sm-2"><span id="elh_personal_st"><?php echo $personal->st->FldCaption() ?></span></td>
		<td data-name="st"<?php echo $personal->st->CellAttributes() ?>>
<span id="el_personal_st">
<span<?php echo $personal->st->ViewAttributes() ?>>
<?php echo $personal->st->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->signature->Visible) { // signature ?>
	<tr id="r_signature">
		<td class="col-sm-2"><span id="elh_personal_signature"><?php echo $personal->signature->FldCaption() ?></span></td>
		<td data-name="signature"<?php echo $personal->signature->CellAttributes() ?>>
<span id="el_personal_signature">
<span<?php echo $personal->signature->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($personal->signature, $personal->signature->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->created_by->Visible) { // created_by ?>
	<tr id="r_created_by">
		<td class="col-sm-2"><span id="elh_personal_created_by"><?php echo $personal->created_by->FldCaption() ?></span></td>
		<td data-name="created_by"<?php echo $personal->created_by->CellAttributes() ?>>
<span id="el_personal_created_by">
<span<?php echo $personal->created_by->ViewAttributes() ?>>
<?php echo $personal->created_by->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->created_date->Visible) { // created_date ?>
	<tr id="r_created_date">
		<td class="col-sm-2"><span id="elh_personal_created_date"><?php echo $personal->created_date->FldCaption() ?></span></td>
		<td data-name="created_date"<?php echo $personal->created_date->CellAttributes() ?>>
<span id="el_personal_created_date">
<span<?php echo $personal->created_date->ViewAttributes() ?>>
<?php echo $personal->created_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->last_update_by->Visible) { // last_update_by ?>
	<tr id="r_last_update_by">
		<td class="col-sm-2"><span id="elh_personal_last_update_by"><?php echo $personal->last_update_by->FldCaption() ?></span></td>
		<td data-name="last_update_by"<?php echo $personal->last_update_by->CellAttributes() ?>>
<span id="el_personal_last_update_by">
<span<?php echo $personal->last_update_by->ViewAttributes() ?>>
<?php echo $personal->last_update_by->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->last_update_date->Visible) { // last_update_date ?>
	<tr id="r_last_update_date">
		<td class="col-sm-2"><span id="elh_personal_last_update_date"><?php echo $personal->last_update_date->FldCaption() ?></span></td>
		<td data-name="last_update_date"<?php echo $personal->last_update_date->CellAttributes() ?>>
<span id="el_personal_last_update_date">
<span<?php echo $personal->last_update_date->ViewAttributes() ?>>
<?php echo $personal->last_update_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->fgr_print_id->Visible) { // fgr_print_id ?>
	<tr id="r_fgr_print_id">
		<td class="col-sm-2"><span id="elh_personal_fgr_print_id"><?php echo $personal->fgr_print_id->FldCaption() ?></span></td>
		<td data-name="fgr_print_id"<?php echo $personal->fgr_print_id->CellAttributes() ?>>
<span id="el_personal_fgr_print_id">
<span<?php echo $personal->fgr_print_id->ViewAttributes() ?>>
<?php echo $personal->fgr_print_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_jbt_eselon->Visible) { // kd_jbt_eselon ?>
	<tr id="r_kd_jbt_eselon">
		<td class="col-sm-2"><span id="elh_personal_kd_jbt_eselon"><?php echo $personal->kd_jbt_eselon->FldCaption() ?></span></td>
		<td data-name="kd_jbt_eselon"<?php echo $personal->kd_jbt_eselon->CellAttributes() ?>>
<span id="el_personal_kd_jbt_eselon">
<span<?php echo $personal->kd_jbt_eselon->ViewAttributes() ?>>
<?php echo $personal->kd_jbt_eselon->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->npwp->Visible) { // npwp ?>
	<tr id="r_npwp">
		<td class="col-sm-2"><span id="elh_personal_npwp"><?php echo $personal->npwp->FldCaption() ?></span></td>
		<td data-name="npwp"<?php echo $personal->npwp->CellAttributes() ?>>
<span id="el_personal_npwp">
<span<?php echo $personal->npwp->ViewAttributes() ?>>
<?php echo $personal->npwp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->paraf->Visible) { // paraf ?>
	<tr id="r_paraf">
		<td class="col-sm-2"><span id="elh_personal_paraf"><?php echo $personal->paraf->FldCaption() ?></span></td>
		<td data-name="paraf"<?php echo $personal->paraf->CellAttributes() ?>>
<span id="el_personal_paraf">
<span<?php echo $personal->paraf->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($personal->paraf, $personal->paraf->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->tgl_keluar->Visible) { // tgl_keluar ?>
	<tr id="r_tgl_keluar">
		<td class="col-sm-2"><span id="elh_personal_tgl_keluar"><?php echo $personal->tgl_keluar->FldCaption() ?></span></td>
		<td data-name="tgl_keluar"<?php echo $personal->tgl_keluar->CellAttributes() ?>>
<span id="el_personal_tgl_keluar">
<span<?php echo $personal->tgl_keluar->ViewAttributes() ?>>
<?php echo $personal->tgl_keluar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->nama_nasabah->Visible) { // nama_nasabah ?>
	<tr id="r_nama_nasabah">
		<td class="col-sm-2"><span id="elh_personal_nama_nasabah"><?php echo $personal->nama_nasabah->FldCaption() ?></span></td>
		<td data-name="nama_nasabah"<?php echo $personal->nama_nasabah->CellAttributes() ?>>
<span id="el_personal_nama_nasabah">
<span<?php echo $personal->nama_nasabah->ViewAttributes() ?>>
<?php echo $personal->nama_nasabah->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->no_ktp->Visible) { // no_ktp ?>
	<tr id="r_no_ktp">
		<td class="col-sm-2"><span id="elh_personal_no_ktp"><?php echo $personal->no_ktp->FldCaption() ?></span></td>
		<td data-name="no_ktp"<?php echo $personal->no_ktp->CellAttributes() ?>>
<span id="el_personal_no_ktp">
<span<?php echo $personal->no_ktp->ViewAttributes() ?>>
<?php echo $personal->no_ktp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->no_kokar->Visible) { // no_kokar ?>
	<tr id="r_no_kokar">
		<td class="col-sm-2"><span id="elh_personal_no_kokar"><?php echo $personal->no_kokar->FldCaption() ?></span></td>
		<td data-name="no_kokar"<?php echo $personal->no_kokar->CellAttributes() ?>>
<span id="el_personal_no_kokar">
<span<?php echo $personal->no_kokar->ViewAttributes() ?>>
<?php echo $personal->no_kokar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->no_bmw->Visible) { // no_bmw ?>
	<tr id="r_no_bmw">
		<td class="col-sm-2"><span id="elh_personal_no_bmw"><?php echo $personal->no_bmw->FldCaption() ?></span></td>
		<td data-name="no_bmw"<?php echo $personal->no_bmw->CellAttributes() ?>>
<span id="el_personal_no_bmw">
<span<?php echo $personal->no_bmw->ViewAttributes() ?>>
<?php echo $personal->no_bmw->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->no_bpjs_ketenagakerjaan->Visible) { // no_bpjs_ketenagakerjaan ?>
	<tr id="r_no_bpjs_ketenagakerjaan">
		<td class="col-sm-2"><span id="elh_personal_no_bpjs_ketenagakerjaan"><?php echo $personal->no_bpjs_ketenagakerjaan->FldCaption() ?></span></td>
		<td data-name="no_bpjs_ketenagakerjaan"<?php echo $personal->no_bpjs_ketenagakerjaan->CellAttributes() ?>>
<span id="el_personal_no_bpjs_ketenagakerjaan">
<span<?php echo $personal->no_bpjs_ketenagakerjaan->ViewAttributes() ?>>
<?php echo $personal->no_bpjs_ketenagakerjaan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->no_bpjs_kesehatan->Visible) { // no_bpjs_kesehatan ?>
	<tr id="r_no_bpjs_kesehatan">
		<td class="col-sm-2"><span id="elh_personal_no_bpjs_kesehatan"><?php echo $personal->no_bpjs_kesehatan->FldCaption() ?></span></td>
		<td data-name="no_bpjs_kesehatan"<?php echo $personal->no_bpjs_kesehatan->CellAttributes() ?>>
<span id="el_personal_no_bpjs_kesehatan">
<span<?php echo $personal->no_bpjs_kesehatan->ViewAttributes() ?>>
<?php echo $personal->no_bpjs_kesehatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->eselon->Visible) { // eselon ?>
	<tr id="r_eselon">
		<td class="col-sm-2"><span id="elh_personal_eselon"><?php echo $personal->eselon->FldCaption() ?></span></td>
		<td data-name="eselon"<?php echo $personal->eselon->CellAttributes() ?>>
<span id="el_personal_eselon">
<span<?php echo $personal->eselon->ViewAttributes() ?>>
<?php echo $personal->eselon->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_jenjang->Visible) { // kd_jenjang ?>
	<tr id="r_kd_jenjang">
		<td class="col-sm-2"><span id="elh_personal_kd_jenjang"><?php echo $personal->kd_jenjang->FldCaption() ?></span></td>
		<td data-name="kd_jenjang"<?php echo $personal->kd_jenjang->CellAttributes() ?>>
<span id="el_personal_kd_jenjang">
<span<?php echo $personal->kd_jenjang->ViewAttributes() ?>>
<?php echo $personal->kd_jenjang->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_jbt_esl->Visible) { // kd_jbt_esl ?>
	<tr id="r_kd_jbt_esl">
		<td class="col-sm-2"><span id="elh_personal_kd_jbt_esl"><?php echo $personal->kd_jbt_esl->FldCaption() ?></span></td>
		<td data-name="kd_jbt_esl"<?php echo $personal->kd_jbt_esl->CellAttributes() ?>>
<span id="el_personal_kd_jbt_esl">
<span<?php echo $personal->kd_jbt_esl->ViewAttributes() ?>>
<?php echo $personal->kd_jbt_esl->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->tgl_jbt_esl->Visible) { // tgl_jbt_esl ?>
	<tr id="r_tgl_jbt_esl">
		<td class="col-sm-2"><span id="elh_personal_tgl_jbt_esl"><?php echo $personal->tgl_jbt_esl->FldCaption() ?></span></td>
		<td data-name="tgl_jbt_esl"<?php echo $personal->tgl_jbt_esl->CellAttributes() ?>>
<span id="el_personal_tgl_jbt_esl">
<span<?php echo $personal->tgl_jbt_esl->ViewAttributes() ?>>
<?php echo $personal->tgl_jbt_esl->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->org_id->Visible) { // org_id ?>
	<tr id="r_org_id">
		<td class="col-sm-2"><span id="elh_personal_org_id"><?php echo $personal->org_id->FldCaption() ?></span></td>
		<td data-name="org_id"<?php echo $personal->org_id->CellAttributes() ?>>
<span id="el_personal_org_id">
<span<?php echo $personal->org_id->ViewAttributes() ?>>
<?php echo $personal->org_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->picture->Visible) { // picture ?>
	<tr id="r_picture">
		<td class="col-sm-2"><span id="elh_personal_picture"><?php echo $personal->picture->FldCaption() ?></span></td>
		<td data-name="picture"<?php echo $personal->picture->CellAttributes() ?>>
<span id="el_personal_picture">
<span<?php echo $personal->picture->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($personal->picture, $personal->picture->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->kd_payroll->Visible) { // kd_payroll ?>
	<tr id="r_kd_payroll">
		<td class="col-sm-2"><span id="elh_personal_kd_payroll"><?php echo $personal->kd_payroll->FldCaption() ?></span></td>
		<td data-name="kd_payroll"<?php echo $personal->kd_payroll->CellAttributes() ?>>
<span id="el_personal_kd_payroll">
<span<?php echo $personal->kd_payroll->ViewAttributes() ?>>
<?php echo $personal->kd_payroll->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->id_wn->Visible) { // id_wn ?>
	<tr id="r_id_wn">
		<td class="col-sm-2"><span id="elh_personal_id_wn"><?php echo $personal->id_wn->FldCaption() ?></span></td>
		<td data-name="id_wn"<?php echo $personal->id_wn->CellAttributes() ?>>
<span id="el_personal_id_wn">
<span<?php echo $personal->id_wn->ViewAttributes() ?>>
<?php echo $personal->id_wn->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($personal->no_anggota_kkms->Visible) { // no_anggota_kkms ?>
	<tr id="r_no_anggota_kkms">
		<td class="col-sm-2"><span id="elh_personal_no_anggota_kkms"><?php echo $personal->no_anggota_kkms->FldCaption() ?></span></td>
		<td data-name="no_anggota_kkms"<?php echo $personal->no_anggota_kkms->CellAttributes() ?>>
<span id="el_personal_no_anggota_kkms">
<span<?php echo $personal->no_anggota_kkms->ViewAttributes() ?>>
<?php echo $personal->no_anggota_kkms->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fpersonalview.Init();
</script>
<?php
$personal_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$personal_view->Page_Terminate();
?>
