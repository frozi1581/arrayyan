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

$hst_kerja_view = NULL; // Initialize page object first

class chst_kerja_view extends chst_kerja {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'hst_kerja';

	// Page object name
	var $PageObjName = 'hst_kerja_view';

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

		// Table object (hst_kerja)
		if (!isset($GLOBALS["hst_kerja"]) || get_class($GLOBALS["hst_kerja"]) == "chst_kerja") {
			$GLOBALS["hst_kerja"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hst_kerja"];
		}
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&amp;id=" . urlencode($this->RecKey["id"]);
		}
		if (@$_GET["employee_id"] <> "") {
			$this->RecKey["employee_id"] = $_GET["employee_id"];
			$KeyUrl .= "&amp;employee_id=" . urlencode($this->RecKey["employee_id"]);
		}
		if (@$_GET["kd_jbt"] <> "") {
			$this->RecKey["kd_jbt"] = $_GET["kd_jbt"];
			$KeyUrl .= "&amp;kd_jbt=" . urlencode($this->RecKey["kd_jbt"]);
		}
		if (@$_GET["kd_pat"] <> "") {
			$this->RecKey["kd_pat"] = $_GET["kd_pat"];
			$KeyUrl .= "&amp;kd_pat=" . urlencode($this->RecKey["kd_pat"]);
		}
		if (@$_GET["kd_jenjang"] <> "") {
			$this->RecKey["kd_jenjang"] = $_GET["kd_jenjang"];
			$KeyUrl .= "&amp;kd_jenjang=" . urlencode($this->RecKey["kd_jenjang"]);
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
			define("EW_TABLE_NAME", 'hst_kerja', TRUE);

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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "hst_kerjaview.php")
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
				$sReturnUrl = "hst_kerjalist.php"; // Return to list
			}
			if (@$_GET["employee_id"] <> "") {
				$this->employee_id->setQueryStringValue($_GET["employee_id"]);
				$this->RecKey["employee_id"] = $this->employee_id->QueryStringValue;
			} elseif (@$_POST["employee_id"] <> "") {
				$this->employee_id->setFormValue($_POST["employee_id"]);
				$this->RecKey["employee_id"] = $this->employee_id->FormValue;
			} else {
				$sReturnUrl = "hst_kerjalist.php"; // Return to list
			}
			if (@$_GET["kd_jbt"] <> "") {
				$this->kd_jbt->setQueryStringValue($_GET["kd_jbt"]);
				$this->RecKey["kd_jbt"] = $this->kd_jbt->QueryStringValue;
			} elseif (@$_POST["kd_jbt"] <> "") {
				$this->kd_jbt->setFormValue($_POST["kd_jbt"]);
				$this->RecKey["kd_jbt"] = $this->kd_jbt->FormValue;
			} else {
				$sReturnUrl = "hst_kerjalist.php"; // Return to list
			}
			if (@$_GET["kd_pat"] <> "") {
				$this->kd_pat->setQueryStringValue($_GET["kd_pat"]);
				$this->RecKey["kd_pat"] = $this->kd_pat->QueryStringValue;
			} elseif (@$_POST["kd_pat"] <> "") {
				$this->kd_pat->setFormValue($_POST["kd_pat"]);
				$this->RecKey["kd_pat"] = $this->kd_pat->FormValue;
			} else {
				$sReturnUrl = "hst_kerjalist.php"; // Return to list
			}
			if (@$_GET["kd_jenjang"] <> "") {
				$this->kd_jenjang->setQueryStringValue($_GET["kd_jenjang"]);
				$this->RecKey["kd_jenjang"] = $this->kd_jenjang->QueryStringValue;
			} elseif (@$_POST["kd_jenjang"] <> "") {
				$this->kd_jenjang->setFormValue($_POST["kd_jenjang"]);
				$this->RecKey["kd_jenjang"] = $this->kd_jenjang->FormValue;
			} else {
				$sReturnUrl = "hst_kerjalist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "hst_kerjalist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "hst_kerjalist.php"; // Not page request, return to list
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hst_kerjalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hst_kerja_view)) $hst_kerja_view = new chst_kerja_view();

// Page init
$hst_kerja_view->Page_Init();

// Page main
$hst_kerja_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hst_kerja_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fhst_kerjaview = new ew_Form("fhst_kerjaview", "view");

// Form_CustomValidate event
fhst_kerjaview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fhst_kerjaview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $hst_kerja_view->ExportOptions->Render("body") ?>
<?php
	foreach ($hst_kerja_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $hst_kerja_view->ShowPageHeader(); ?>
<?php
$hst_kerja_view->ShowMessage();
?>
<form name="fhst_kerjaview" id="fhst_kerjaview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hst_kerja_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hst_kerja_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hst_kerja">
<input type="hidden" name="modal" value="<?php echo intval($hst_kerja_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($hst_kerja->id->Visible) { // id ?>
	<tr id="r_id">
		<td class="col-sm-2"><span id="elh_hst_kerja_id"><?php echo $hst_kerja->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $hst_kerja->id->CellAttributes() ?>>
<span id="el_hst_kerja_id">
<span<?php echo $hst_kerja->id->ViewAttributes() ?>>
<?php echo $hst_kerja->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->employee_id->Visible) { // employee_id ?>
	<tr id="r_employee_id">
		<td class="col-sm-2"><span id="elh_hst_kerja_employee_id"><?php echo $hst_kerja->employee_id->FldCaption() ?></span></td>
		<td data-name="employee_id"<?php echo $hst_kerja->employee_id->CellAttributes() ?>>
<span id="el_hst_kerja_employee_id">
<span<?php echo $hst_kerja->employee_id->ViewAttributes() ?>>
<?php echo $hst_kerja->employee_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->kd_jbt->Visible) { // kd_jbt ?>
	<tr id="r_kd_jbt">
		<td class="col-sm-2"><span id="elh_hst_kerja_kd_jbt"><?php echo $hst_kerja->kd_jbt->FldCaption() ?></span></td>
		<td data-name="kd_jbt"<?php echo $hst_kerja->kd_jbt->CellAttributes() ?>>
<span id="el_hst_kerja_kd_jbt">
<span<?php echo $hst_kerja->kd_jbt->ViewAttributes() ?>>
<?php echo $hst_kerja->kd_jbt->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->kd_pat->Visible) { // kd_pat ?>
	<tr id="r_kd_pat">
		<td class="col-sm-2"><span id="elh_hst_kerja_kd_pat"><?php echo $hst_kerja->kd_pat->FldCaption() ?></span></td>
		<td data-name="kd_pat"<?php echo $hst_kerja->kd_pat->CellAttributes() ?>>
<span id="el_hst_kerja_kd_pat">
<span<?php echo $hst_kerja->kd_pat->ViewAttributes() ?>>
<?php echo $hst_kerja->kd_pat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->kd_jenjang->Visible) { // kd_jenjang ?>
	<tr id="r_kd_jenjang">
		<td class="col-sm-2"><span id="elh_hst_kerja_kd_jenjang"><?php echo $hst_kerja->kd_jenjang->FldCaption() ?></span></td>
		<td data-name="kd_jenjang"<?php echo $hst_kerja->kd_jenjang->CellAttributes() ?>>
<span id="el_hst_kerja_kd_jenjang">
<span<?php echo $hst_kerja->kd_jenjang->ViewAttributes() ?>>
<?php echo $hst_kerja->kd_jenjang->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->tgl_mulai->Visible) { // tgl_mulai ?>
	<tr id="r_tgl_mulai">
		<td class="col-sm-2"><span id="elh_hst_kerja_tgl_mulai"><?php echo $hst_kerja->tgl_mulai->FldCaption() ?></span></td>
		<td data-name="tgl_mulai"<?php echo $hst_kerja->tgl_mulai->CellAttributes() ?>>
<span id="el_hst_kerja_tgl_mulai">
<span<?php echo $hst_kerja->tgl_mulai->ViewAttributes() ?>>
<?php echo $hst_kerja->tgl_mulai->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->tgl_akhir->Visible) { // tgl_akhir ?>
	<tr id="r_tgl_akhir">
		<td class="col-sm-2"><span id="elh_hst_kerja_tgl_akhir"><?php echo $hst_kerja->tgl_akhir->FldCaption() ?></span></td>
		<td data-name="tgl_akhir"<?php echo $hst_kerja->tgl_akhir->CellAttributes() ?>>
<span id="el_hst_kerja_tgl_akhir">
<span<?php echo $hst_kerja->tgl_akhir->ViewAttributes() ?>>
<?php echo $hst_kerja->tgl_akhir->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->no_sk->Visible) { // no_sk ?>
	<tr id="r_no_sk">
		<td class="col-sm-2"><span id="elh_hst_kerja_no_sk"><?php echo $hst_kerja->no_sk->FldCaption() ?></span></td>
		<td data-name="no_sk"<?php echo $hst_kerja->no_sk->CellAttributes() ?>>
<span id="el_hst_kerja_no_sk">
<span<?php echo $hst_kerja->no_sk->ViewAttributes() ?>>
<?php echo $hst_kerja->no_sk->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->ket->Visible) { // ket ?>
	<tr id="r_ket">
		<td class="col-sm-2"><span id="elh_hst_kerja_ket"><?php echo $hst_kerja->ket->FldCaption() ?></span></td>
		<td data-name="ket"<?php echo $hst_kerja->ket->CellAttributes() ?>>
<span id="el_hst_kerja_ket">
<span<?php echo $hst_kerja->ket->ViewAttributes() ?>>
<?php echo $hst_kerja->ket->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->company->Visible) { // company ?>
	<tr id="r_company">
		<td class="col-sm-2"><span id="elh_hst_kerja_company"><?php echo $hst_kerja->company->FldCaption() ?></span></td>
		<td data-name="company"<?php echo $hst_kerja->company->CellAttributes() ?>>
<span id="el_hst_kerja_company">
<span<?php echo $hst_kerja->company->ViewAttributes() ?>>
<?php echo $hst_kerja->company->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->created_by->Visible) { // created_by ?>
	<tr id="r_created_by">
		<td class="col-sm-2"><span id="elh_hst_kerja_created_by"><?php echo $hst_kerja->created_by->FldCaption() ?></span></td>
		<td data-name="created_by"<?php echo $hst_kerja->created_by->CellAttributes() ?>>
<span id="el_hst_kerja_created_by">
<span<?php echo $hst_kerja->created_by->ViewAttributes() ?>>
<?php echo $hst_kerja->created_by->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->created_date->Visible) { // created_date ?>
	<tr id="r_created_date">
		<td class="col-sm-2"><span id="elh_hst_kerja_created_date"><?php echo $hst_kerja->created_date->FldCaption() ?></span></td>
		<td data-name="created_date"<?php echo $hst_kerja->created_date->CellAttributes() ?>>
<span id="el_hst_kerja_created_date">
<span<?php echo $hst_kerja->created_date->ViewAttributes() ?>>
<?php echo $hst_kerja->created_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->last_update_by->Visible) { // last_update_by ?>
	<tr id="r_last_update_by">
		<td class="col-sm-2"><span id="elh_hst_kerja_last_update_by"><?php echo $hst_kerja->last_update_by->FldCaption() ?></span></td>
		<td data-name="last_update_by"<?php echo $hst_kerja->last_update_by->CellAttributes() ?>>
<span id="el_hst_kerja_last_update_by">
<span<?php echo $hst_kerja->last_update_by->ViewAttributes() ?>>
<?php echo $hst_kerja->last_update_by->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->last_update_date->Visible) { // last_update_date ?>
	<tr id="r_last_update_date">
		<td class="col-sm-2"><span id="elh_hst_kerja_last_update_date"><?php echo $hst_kerja->last_update_date->FldCaption() ?></span></td>
		<td data-name="last_update_date"<?php echo $hst_kerja->last_update_date->CellAttributes() ?>>
<span id="el_hst_kerja_last_update_date">
<span<?php echo $hst_kerja->last_update_date->ViewAttributes() ?>>
<?php echo $hst_kerja->last_update_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->st->Visible) { // st ?>
	<tr id="r_st">
		<td class="col-sm-2"><span id="elh_hst_kerja_st"><?php echo $hst_kerja->st->FldCaption() ?></span></td>
		<td data-name="st"<?php echo $hst_kerja->st->CellAttributes() ?>>
<span id="el_hst_kerja_st">
<span<?php echo $hst_kerja->st->ViewAttributes() ?>>
<?php echo $hst_kerja->st->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hst_kerja->kd_jbt_eselon->Visible) { // kd_jbt_eselon ?>
	<tr id="r_kd_jbt_eselon">
		<td class="col-sm-2"><span id="elh_hst_kerja_kd_jbt_eselon"><?php echo $hst_kerja->kd_jbt_eselon->FldCaption() ?></span></td>
		<td data-name="kd_jbt_eselon"<?php echo $hst_kerja->kd_jbt_eselon->CellAttributes() ?>>
<span id="el_hst_kerja_kd_jbt_eselon">
<span<?php echo $hst_kerja->kd_jbt_eselon->ViewAttributes() ?>>
<?php echo $hst_kerja->kd_jbt_eselon->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fhst_kerjaview.Init();
</script>
<?php
$hst_kerja_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hst_kerja_view->Page_Terminate();
?>
