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

$pendidikan_view = NULL; // Initialize page object first

class cpendidikan_view extends cpendidikan {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'pendidikan';

	// Page object name
	var $PageObjName = 'pendidikan_view';

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

		// Table object (pendidikan)
		if (!isset($GLOBALS["pendidikan"]) || get_class($GLOBALS["pendidikan"]) == "cpendidikan") {
			$GLOBALS["pendidikan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pendidikan"];
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
			define("EW_TABLE_NAME", 'pendidikan', TRUE);

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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "pendidikanview.php")
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
				$sReturnUrl = "pendidikanlist.php"; // Return to list
			}
			if (@$_GET["employee_id"] <> "") {
				$this->employee_id->setQueryStringValue($_GET["employee_id"]);
				$this->RecKey["employee_id"] = $this->employee_id->QueryStringValue;
			} elseif (@$_POST["employee_id"] <> "") {
				$this->employee_id->setFormValue($_POST["employee_id"]);
				$this->RecKey["employee_id"] = $this->employee_id->FormValue;
			} else {
				$sReturnUrl = "pendidikanlist.php"; // Return to list
			}
			if (@$_GET["kd_jenjang"] <> "") {
				$this->kd_jenjang->setQueryStringValue($_GET["kd_jenjang"]);
				$this->RecKey["kd_jenjang"] = $this->kd_jenjang->QueryStringValue;
			} elseif (@$_POST["kd_jenjang"] <> "") {
				$this->kd_jenjang->setFormValue($_POST["kd_jenjang"]);
				$this->RecKey["kd_jenjang"] = $this->kd_jenjang->FormValue;
			} else {
				$sReturnUrl = "pendidikanlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "pendidikanlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "pendidikanlist.php"; // Not page request, return to list
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pendidikanlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($pendidikan_view)) $pendidikan_view = new cpendidikan_view();

// Page init
$pendidikan_view->Page_Init();

// Page main
$pendidikan_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pendidikan_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fpendidikanview = new ew_Form("fpendidikanview", "view");

// Form_CustomValidate event
fpendidikanview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fpendidikanview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $pendidikan_view->ExportOptions->Render("body") ?>
<?php
	foreach ($pendidikan_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $pendidikan_view->ShowPageHeader(); ?>
<?php
$pendidikan_view->ShowMessage();
?>
<form name="fpendidikanview" id="fpendidikanview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pendidikan_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pendidikan_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pendidikan">
<input type="hidden" name="modal" value="<?php echo intval($pendidikan_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($pendidikan->id->Visible) { // id ?>
	<tr id="r_id">
		<td class="col-sm-2"><span id="elh_pendidikan_id"><?php echo $pendidikan->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $pendidikan->id->CellAttributes() ?>>
<span id="el_pendidikan_id">
<span<?php echo $pendidikan->id->ViewAttributes() ?>>
<?php echo $pendidikan->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->employee_id->Visible) { // employee_id ?>
	<tr id="r_employee_id">
		<td class="col-sm-2"><span id="elh_pendidikan_employee_id"><?php echo $pendidikan->employee_id->FldCaption() ?></span></td>
		<td data-name="employee_id"<?php echo $pendidikan->employee_id->CellAttributes() ?>>
<span id="el_pendidikan_employee_id">
<span<?php echo $pendidikan->employee_id->ViewAttributes() ?>>
<?php echo $pendidikan->employee_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->kd_jenjang->Visible) { // kd_jenjang ?>
	<tr id="r_kd_jenjang">
		<td class="col-sm-2"><span id="elh_pendidikan_kd_jenjang"><?php echo $pendidikan->kd_jenjang->FldCaption() ?></span></td>
		<td data-name="kd_jenjang"<?php echo $pendidikan->kd_jenjang->CellAttributes() ?>>
<span id="el_pendidikan_kd_jenjang">
<span<?php echo $pendidikan->kd_jenjang->ViewAttributes() ?>>
<?php echo $pendidikan->kd_jenjang->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->kd_jurusan->Visible) { // kd_jurusan ?>
	<tr id="r_kd_jurusan">
		<td class="col-sm-2"><span id="elh_pendidikan_kd_jurusan"><?php echo $pendidikan->kd_jurusan->FldCaption() ?></span></td>
		<td data-name="kd_jurusan"<?php echo $pendidikan->kd_jurusan->CellAttributes() ?>>
<span id="el_pendidikan_kd_jurusan">
<span<?php echo $pendidikan->kd_jurusan->ViewAttributes() ?>>
<?php echo $pendidikan->kd_jurusan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->kd_lmbg->Visible) { // kd_lmbg ?>
	<tr id="r_kd_lmbg">
		<td class="col-sm-2"><span id="elh_pendidikan_kd_lmbg"><?php echo $pendidikan->kd_lmbg->FldCaption() ?></span></td>
		<td data-name="kd_lmbg"<?php echo $pendidikan->kd_lmbg->CellAttributes() ?>>
<span id="el_pendidikan_kd_lmbg">
<span<?php echo $pendidikan->kd_lmbg->ViewAttributes() ?>>
<?php echo $pendidikan->kd_lmbg->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->ipk->Visible) { // ipk ?>
	<tr id="r_ipk">
		<td class="col-sm-2"><span id="elh_pendidikan_ipk"><?php echo $pendidikan->ipk->FldCaption() ?></span></td>
		<td data-name="ipk"<?php echo $pendidikan->ipk->CellAttributes() ?>>
<span id="el_pendidikan_ipk">
<span<?php echo $pendidikan->ipk->ViewAttributes() ?>>
<?php echo $pendidikan->ipk->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->ket->Visible) { // ket ?>
	<tr id="r_ket">
		<td class="col-sm-2"><span id="elh_pendidikan_ket"><?php echo $pendidikan->ket->FldCaption() ?></span></td>
		<td data-name="ket"<?php echo $pendidikan->ket->CellAttributes() ?>>
<span id="el_pendidikan_ket">
<span<?php echo $pendidikan->ket->ViewAttributes() ?>>
<?php echo $pendidikan->ket->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->th_mulai->Visible) { // th_mulai ?>
	<tr id="r_th_mulai">
		<td class="col-sm-2"><span id="elh_pendidikan_th_mulai"><?php echo $pendidikan->th_mulai->FldCaption() ?></span></td>
		<td data-name="th_mulai"<?php echo $pendidikan->th_mulai->CellAttributes() ?>>
<span id="el_pendidikan_th_mulai">
<span<?php echo $pendidikan->th_mulai->ViewAttributes() ?>>
<?php echo $pendidikan->th_mulai->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->th_akhir->Visible) { // th_akhir ?>
	<tr id="r_th_akhir">
		<td class="col-sm-2"><span id="elh_pendidikan_th_akhir"><?php echo $pendidikan->th_akhir->FldCaption() ?></span></td>
		<td data-name="th_akhir"<?php echo $pendidikan->th_akhir->CellAttributes() ?>>
<span id="el_pendidikan_th_akhir">
<span<?php echo $pendidikan->th_akhir->ViewAttributes() ?>>
<?php echo $pendidikan->th_akhir->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->no_ijazah->Visible) { // no_ijazah ?>
	<tr id="r_no_ijazah">
		<td class="col-sm-2"><span id="elh_pendidikan_no_ijazah"><?php echo $pendidikan->no_ijazah->FldCaption() ?></span></td>
		<td data-name="no_ijazah"<?php echo $pendidikan->no_ijazah->CellAttributes() ?>>
<span id="el_pendidikan_no_ijazah">
<span<?php echo $pendidikan->no_ijazah->ViewAttributes() ?>>
<?php echo $pendidikan->no_ijazah->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->tanggal_ijazah->Visible) { // tanggal_ijazah ?>
	<tr id="r_tanggal_ijazah">
		<td class="col-sm-2"><span id="elh_pendidikan_tanggal_ijazah"><?php echo $pendidikan->tanggal_ijazah->FldCaption() ?></span></td>
		<td data-name="tanggal_ijazah"<?php echo $pendidikan->tanggal_ijazah->CellAttributes() ?>>
<span id="el_pendidikan_tanggal_ijazah">
<span<?php echo $pendidikan->tanggal_ijazah->ViewAttributes() ?>>
<?php echo $pendidikan->tanggal_ijazah->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->upload_ijazah->Visible) { // upload_ijazah ?>
	<tr id="r_upload_ijazah">
		<td class="col-sm-2"><span id="elh_pendidikan_upload_ijazah"><?php echo $pendidikan->upload_ijazah->FldCaption() ?></span></td>
		<td data-name="upload_ijazah"<?php echo $pendidikan->upload_ijazah->CellAttributes() ?>>
<span id="el_pendidikan_upload_ijazah">
<span<?php echo $pendidikan->upload_ijazah->ViewAttributes() ?>>
<?php echo $pendidikan->upload_ijazah->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->lokasi_pendidikan->Visible) { // lokasi_pendidikan ?>
	<tr id="r_lokasi_pendidikan">
		<td class="col-sm-2"><span id="elh_pendidikan_lokasi_pendidikan"><?php echo $pendidikan->lokasi_pendidikan->FldCaption() ?></span></td>
		<td data-name="lokasi_pendidikan"<?php echo $pendidikan->lokasi_pendidikan->CellAttributes() ?>>
<span id="el_pendidikan_lokasi_pendidikan">
<span<?php echo $pendidikan->lokasi_pendidikan->ViewAttributes() ?>>
<?php echo $pendidikan->lokasi_pendidikan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->app->Visible) { // app ?>
	<tr id="r_app">
		<td class="col-sm-2"><span id="elh_pendidikan_app"><?php echo $pendidikan->app->FldCaption() ?></span></td>
		<td data-name="app"<?php echo $pendidikan->app->CellAttributes() ?>>
<span id="el_pendidikan_app">
<span<?php echo $pendidikan->app->ViewAttributes() ?>>
<?php echo $pendidikan->app->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->app_empid->Visible) { // app_empid ?>
	<tr id="r_app_empid">
		<td class="col-sm-2"><span id="elh_pendidikan_app_empid"><?php echo $pendidikan->app_empid->FldCaption() ?></span></td>
		<td data-name="app_empid"<?php echo $pendidikan->app_empid->CellAttributes() ?>>
<span id="el_pendidikan_app_empid">
<span<?php echo $pendidikan->app_empid->ViewAttributes() ?>>
<?php echo $pendidikan->app_empid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->app_jbt->Visible) { // app_jbt ?>
	<tr id="r_app_jbt">
		<td class="col-sm-2"><span id="elh_pendidikan_app_jbt"><?php echo $pendidikan->app_jbt->FldCaption() ?></span></td>
		<td data-name="app_jbt"<?php echo $pendidikan->app_jbt->CellAttributes() ?>>
<span id="el_pendidikan_app_jbt">
<span<?php echo $pendidikan->app_jbt->ViewAttributes() ?>>
<?php echo $pendidikan->app_jbt->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->app_date->Visible) { // app_date ?>
	<tr id="r_app_date">
		<td class="col-sm-2"><span id="elh_pendidikan_app_date"><?php echo $pendidikan->app_date->FldCaption() ?></span></td>
		<td data-name="app_date"<?php echo $pendidikan->app_date->CellAttributes() ?>>
<span id="el_pendidikan_app_date">
<span<?php echo $pendidikan->app_date->ViewAttributes() ?>>
<?php echo $pendidikan->app_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->created_by->Visible) { // created_by ?>
	<tr id="r_created_by">
		<td class="col-sm-2"><span id="elh_pendidikan_created_by"><?php echo $pendidikan->created_by->FldCaption() ?></span></td>
		<td data-name="created_by"<?php echo $pendidikan->created_by->CellAttributes() ?>>
<span id="el_pendidikan_created_by">
<span<?php echo $pendidikan->created_by->ViewAttributes() ?>>
<?php echo $pendidikan->created_by->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->created_date->Visible) { // created_date ?>
	<tr id="r_created_date">
		<td class="col-sm-2"><span id="elh_pendidikan_created_date"><?php echo $pendidikan->created_date->FldCaption() ?></span></td>
		<td data-name="created_date"<?php echo $pendidikan->created_date->CellAttributes() ?>>
<span id="el_pendidikan_created_date">
<span<?php echo $pendidikan->created_date->ViewAttributes() ?>>
<?php echo $pendidikan->created_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->last_update_by->Visible) { // last_update_by ?>
	<tr id="r_last_update_by">
		<td class="col-sm-2"><span id="elh_pendidikan_last_update_by"><?php echo $pendidikan->last_update_by->FldCaption() ?></span></td>
		<td data-name="last_update_by"<?php echo $pendidikan->last_update_by->CellAttributes() ?>>
<span id="el_pendidikan_last_update_by">
<span<?php echo $pendidikan->last_update_by->ViewAttributes() ?>>
<?php echo $pendidikan->last_update_by->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pendidikan->last_update_date->Visible) { // last_update_date ?>
	<tr id="r_last_update_date">
		<td class="col-sm-2"><span id="elh_pendidikan_last_update_date"><?php echo $pendidikan->last_update_date->FldCaption() ?></span></td>
		<td data-name="last_update_date"<?php echo $pendidikan->last_update_date->CellAttributes() ?>>
<span id="el_pendidikan_last_update_date">
<span<?php echo $pendidikan->last_update_date->ViewAttributes() ?>>
<?php echo $pendidikan->last_update_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fpendidikanview.Init();
</script>
<?php
$pendidikan_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pendidikan_view->Page_Terminate();
?>
