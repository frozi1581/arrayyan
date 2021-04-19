<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tb_notifikasiinfo.php" ?>
<?php include_once "tb_notifikasi_dgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tb_notifikasi_view = NULL; // Initialize page object first

class ctb_notifikasi_view extends ctb_notifikasi {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'tb_notifikasi';

	// Page object name
	var $PageObjName = 'tb_notifikasi_view';

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

		// Table object (tb_notifikasi)
		if (!isset($GLOBALS["tb_notifikasi"]) || get_class($GLOBALS["tb_notifikasi"]) == "ctb_notifikasi") {
			$GLOBALS["tb_notifikasi"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_notifikasi"];
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
			define("EW_TABLE_NAME", 'tb_notifikasi', TRUE);

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
		$this->topic->SetVisibility();
		$this->priority->SetVisibility();
		$this->isi_notif->SetVisibility();
		$this->action->SetVisibility();
		$this->tgl_cr->SetVisibility();
		$this->cr_by->SetVisibility();
		$this->filter_penerima->SetVisibility();
		$this->tgl_upd->SetVisibility();

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
		global $EW_EXPORT, $tb_notifikasi;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_notifikasi);
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
					if ($pageName == "tb_notifikasiview.php")
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
				$sReturnUrl = "tb_notifikasilist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "tb_notifikasilist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "tb_notifikasilist.php"; // Not page request, return to list
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

		// Set up detail parameters
		$this->SetupDetailParms();
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

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddQuery($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "");
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_tb_notifikasi_d"
		$item = &$option->Add("detail_tb_notifikasi_d");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("tb_notifikasi_d", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("tb_notifikasi_dlist.php?" . EW_TABLE_SHOW_MASTER . "=tb_notifikasi&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["tb_notifikasi_d_grid"] && $GLOBALS["tb_notifikasi_d_grid"]->DetailView) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=tb_notifikasi_d")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "tb_notifikasi_d";
		}
		if ($GLOBALS["tb_notifikasi_d_grid"] && $GLOBALS["tb_notifikasi_d_grid"]->DetailEdit) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=tb_notifikasi_d")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "tb_notifikasi_d";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = TRUE;
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "tb_notifikasi_d";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$option->Add("details");
			$oListOpt->Body = $body;
		}

		// Set up detail default
		$option = &$options["detail"];
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$option->UseImageAndText = TRUE;
		$ar = explode(",", $DetailTableLink);
		$cnt = count($ar);
		$option->UseDropDownButton = ($cnt > 1);
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

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
		$this->topic->setDbValue($row['topic']);
		$this->priority->setDbValue($row['priority']);
		$this->isi_notif->setDbValue($row['isi_notif']);
		$this->action->setDbValue($row['action']);
		$this->tgl_cr->setDbValue($row['tgl_cr']);
		$this->cr_by->setDbValue($row['cr_by']);
		$this->filter_penerima->setDbValue($row['filter_penerima']);
		$this->tgl_upd->setDbValue($row['tgl_upd']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['topic'] = NULL;
		$row['priority'] = NULL;
		$row['isi_notif'] = NULL;
		$row['action'] = NULL;
		$row['tgl_cr'] = NULL;
		$row['cr_by'] = NULL;
		$row['filter_penerima'] = NULL;
		$row['tgl_upd'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->topic->DbValue = $row['topic'];
		$this->priority->DbValue = $row['priority'];
		$this->isi_notif->DbValue = $row['isi_notif'];
		$this->action->DbValue = $row['action'];
		$this->tgl_cr->DbValue = $row['tgl_cr'];
		$this->cr_by->DbValue = $row['cr_by'];
		$this->filter_penerima->DbValue = $row['filter_penerima'];
		$this->tgl_upd->DbValue = $row['tgl_upd'];
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
		// topic
		// priority
		// isi_notif
		// action
		// tgl_cr
		// cr_by
		// filter_penerima
		// tgl_upd

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// topic
		if (strval($this->topic->CurrentValue) <> "") {
			$sFilterWrk = "`nama_referensi`" . ew_SearchString("=", $this->topic->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama_referensi`, `nama_referensi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM referensi";
		$sWhereWrk = "(id_ref=12)";
		$this->topic->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->topic, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->topic->ViewValue = $this->topic->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->topic->ViewValue = $this->topic->CurrentValue;
			}
		} else {
			$this->topic->ViewValue = NULL;
		}
		$this->topic->ViewCustomAttributes = "";

		// priority
		if (strval($this->priority->CurrentValue) <> "") {
			$this->priority->ViewValue = $this->priority->OptionCaption($this->priority->CurrentValue);
		} else {
			$this->priority->ViewValue = NULL;
		}
		$this->priority->ViewCustomAttributes = "";

		// isi_notif
		$this->isi_notif->ViewValue = $this->isi_notif->CurrentValue;
		$this->isi_notif->ViewCustomAttributes = "";

		// action
		$this->action->ViewValue = $this->action->CurrentValue;
		$this->action->ViewCustomAttributes = "";

		// tgl_cr
		$this->tgl_cr->ViewValue = $this->tgl_cr->CurrentValue;
		$this->tgl_cr->ViewValue = ew_FormatDateTime($this->tgl_cr->ViewValue, 2);
		$this->tgl_cr->ViewCustomAttributes = "";

		// cr_by
		$this->cr_by->ViewValue = $this->cr_by->CurrentValue;
		$this->cr_by->ViewCustomAttributes = "";

		// filter_penerima
		$this->filter_penerima->ViewValue = $this->filter_penerima->CurrentValue;
		if (strval($this->filter_penerima->CurrentValue) <> "") {
			$sFilterWrk = "tb_pat.KD_PAT" . ew_SearchString("=", $this->filter_penerima->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `KD_PAT`, `KET` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM tb_pat";
		$sWhereWrk = "";
		$this->filter_penerima->LookupFilters = array("dx1" => 'tb_pat.KET');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->filter_penerima, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->filter_penerima->ViewValue = $this->filter_penerima->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->filter_penerima->ViewValue = $this->filter_penerima->CurrentValue;
			}
		} else {
			$this->filter_penerima->ViewValue = NULL;
		}
		$this->filter_penerima->ViewCustomAttributes = "";

		// tgl_upd
		$this->tgl_upd->ViewValue = $this->tgl_upd->CurrentValue;
		$this->tgl_upd->ViewValue = ew_FormatDateTime($this->tgl_upd->ViewValue, 0);
		$this->tgl_upd->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// topic
			$this->topic->LinkCustomAttributes = "";
			$this->topic->HrefValue = "";
			$this->topic->TooltipValue = "";

			// priority
			$this->priority->LinkCustomAttributes = "";
			$this->priority->HrefValue = "";
			$this->priority->TooltipValue = "";

			// isi_notif
			$this->isi_notif->LinkCustomAttributes = "";
			$this->isi_notif->HrefValue = "";
			$this->isi_notif->TooltipValue = "";

			// action
			$this->action->LinkCustomAttributes = "";
			$this->action->HrefValue = "";
			$this->action->TooltipValue = "";

			// tgl_cr
			$this->tgl_cr->LinkCustomAttributes = "";
			$this->tgl_cr->HrefValue = "";
			$this->tgl_cr->TooltipValue = "";

			// cr_by
			$this->cr_by->LinkCustomAttributes = "";
			$this->cr_by->HrefValue = "";
			$this->cr_by->TooltipValue = "";

			// filter_penerima
			$this->filter_penerima->LinkCustomAttributes = "";
			$this->filter_penerima->HrefValue = "";
			$this->filter_penerima->TooltipValue = "";

			// tgl_upd
			$this->tgl_upd->LinkCustomAttributes = "";
			$this->tgl_upd->HrefValue = "";
			$this->tgl_upd->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up detail parms based on QueryString
	function SetupDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("tb_notifikasi_d", $DetailTblVar)) {
				if (!isset($GLOBALS["tb_notifikasi_d_grid"]))
					$GLOBALS["tb_notifikasi_d_grid"] = new ctb_notifikasi_d_grid;
				if ($GLOBALS["tb_notifikasi_d_grid"]->DetailView) {
					$GLOBALS["tb_notifikasi_d_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["tb_notifikasi_d_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["tb_notifikasi_d_grid"]->setStartRecordNumber(1);
					$GLOBALS["tb_notifikasi_d_grid"]->id->FldIsDetailKey = TRUE;
					$GLOBALS["tb_notifikasi_d_grid"]->id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["tb_notifikasi_d_grid"]->id->setSessionValue($GLOBALS["tb_notifikasi_d_grid"]->id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_notifikasilist.php"), "", $this->TableVar, TRUE);
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
if (!isset($tb_notifikasi_view)) $tb_notifikasi_view = new ctb_notifikasi_view();

// Page init
$tb_notifikasi_view->Page_Init();

// Page main
$tb_notifikasi_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_notifikasi_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = ftb_notifikasiview = new ew_Form("ftb_notifikasiview", "view");

// Form_CustomValidate event
ftb_notifikasiview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftb_notifikasiview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftb_notifikasiview.Lists["x_topic"] = {"LinkField":"x_nama_referensi","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_referensi","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_referensi"};
ftb_notifikasiview.Lists["x_topic"].Data = "<?php echo $tb_notifikasi_view->topic->LookupFilterQuery(FALSE, "view") ?>";
ftb_notifikasiview.Lists["x_priority"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftb_notifikasiview.Lists["x_priority"].Options = <?php echo json_encode($tb_notifikasi_view->priority->Options()) ?>;
ftb_notifikasiview.Lists["x_filter_penerima"] = {"LinkField":"x_KD_PAT","Ajax":true,"AutoFill":false,"DisplayFields":["x_KET","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_tb_pat"};
ftb_notifikasiview.Lists["x_filter_penerima"].Data = "<?php echo $tb_notifikasi_view->filter_penerima->LookupFilterQuery(FALSE, "view") ?>";
ftb_notifikasiview.AutoSuggests["x_filter_penerima"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $tb_notifikasi_view->filter_penerima->LookupFilterQuery(TRUE, "view"))) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $tb_notifikasi_view->ExportOptions->Render("body") ?>
<?php
	foreach ($tb_notifikasi_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $tb_notifikasi_view->ShowPageHeader(); ?>
<?php
$tb_notifikasi_view->ShowMessage();
?>
<form name="ftb_notifikasiview" id="ftb_notifikasiview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_notifikasi_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_notifikasi_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_notifikasi">
<input type="hidden" name="modal" value="<?php echo intval($tb_notifikasi_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($tb_notifikasi->id->Visible) { // id ?>
	<tr id="r_id">
		<td class="col-sm-2"><span id="elh_tb_notifikasi_id"><?php echo $tb_notifikasi->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $tb_notifikasi->id->CellAttributes() ?>>
<span id="el_tb_notifikasi_id" data-page="1">
<span<?php echo $tb_notifikasi->id->ViewAttributes() ?>>
<?php echo $tb_notifikasi->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_notifikasi->topic->Visible) { // topic ?>
	<tr id="r_topic">
		<td class="col-sm-2"><span id="elh_tb_notifikasi_topic"><?php echo $tb_notifikasi->topic->FldCaption() ?></span></td>
		<td data-name="topic"<?php echo $tb_notifikasi->topic->CellAttributes() ?>>
<span id="el_tb_notifikasi_topic" data-page="1">
<span<?php echo $tb_notifikasi->topic->ViewAttributes() ?>>
<?php echo $tb_notifikasi->topic->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_notifikasi->priority->Visible) { // priority ?>
	<tr id="r_priority">
		<td class="col-sm-2"><span id="elh_tb_notifikasi_priority"><?php echo $tb_notifikasi->priority->FldCaption() ?></span></td>
		<td data-name="priority"<?php echo $tb_notifikasi->priority->CellAttributes() ?>>
<span id="el_tb_notifikasi_priority" data-page="1">
<span<?php echo $tb_notifikasi->priority->ViewAttributes() ?>>
<?php echo $tb_notifikasi->priority->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_notifikasi->isi_notif->Visible) { // isi_notif ?>
	<tr id="r_isi_notif">
		<td class="col-sm-2"><span id="elh_tb_notifikasi_isi_notif"><?php echo $tb_notifikasi->isi_notif->FldCaption() ?></span></td>
		<td data-name="isi_notif"<?php echo $tb_notifikasi->isi_notif->CellAttributes() ?>>
<span id="el_tb_notifikasi_isi_notif" data-page="1">
<span<?php echo $tb_notifikasi->isi_notif->ViewAttributes() ?>>
<?php echo $tb_notifikasi->isi_notif->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_notifikasi->action->Visible) { // action ?>
	<tr id="r_action">
		<td class="col-sm-2"><span id="elh_tb_notifikasi_action"><?php echo $tb_notifikasi->action->FldCaption() ?></span></td>
		<td data-name="action"<?php echo $tb_notifikasi->action->CellAttributes() ?>>
<span id="el_tb_notifikasi_action" data-page="1">
<span<?php echo $tb_notifikasi->action->ViewAttributes() ?>>
<?php echo $tb_notifikasi->action->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_notifikasi->tgl_cr->Visible) { // tgl_cr ?>
	<tr id="r_tgl_cr">
		<td class="col-sm-2"><span id="elh_tb_notifikasi_tgl_cr"><?php echo $tb_notifikasi->tgl_cr->FldCaption() ?></span></td>
		<td data-name="tgl_cr"<?php echo $tb_notifikasi->tgl_cr->CellAttributes() ?>>
<span id="el_tb_notifikasi_tgl_cr" data-page="1">
<span<?php echo $tb_notifikasi->tgl_cr->ViewAttributes() ?>>
<?php echo $tb_notifikasi->tgl_cr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_notifikasi->cr_by->Visible) { // cr_by ?>
	<tr id="r_cr_by">
		<td class="col-sm-2"><span id="elh_tb_notifikasi_cr_by"><?php echo $tb_notifikasi->cr_by->FldCaption() ?></span></td>
		<td data-name="cr_by"<?php echo $tb_notifikasi->cr_by->CellAttributes() ?>>
<span id="el_tb_notifikasi_cr_by" data-page="1">
<span<?php echo $tb_notifikasi->cr_by->ViewAttributes() ?>>
<?php echo $tb_notifikasi->cr_by->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_notifikasi->filter_penerima->Visible) { // filter_penerima ?>
	<tr id="r_filter_penerima">
		<td class="col-sm-2"><span id="elh_tb_notifikasi_filter_penerima"><?php echo $tb_notifikasi->filter_penerima->FldCaption() ?></span></td>
		<td data-name="filter_penerima"<?php echo $tb_notifikasi->filter_penerima->CellAttributes() ?>>
<span id="el_tb_notifikasi_filter_penerima" data-page="1">
<span<?php echo $tb_notifikasi->filter_penerima->ViewAttributes() ?>>
<?php echo $tb_notifikasi->filter_penerima->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tb_notifikasi->tgl_upd->Visible) { // tgl_upd ?>
	<tr id="r_tgl_upd">
		<td class="col-sm-2"><span id="elh_tb_notifikasi_tgl_upd"><?php echo $tb_notifikasi->tgl_upd->FldCaption() ?></span></td>
		<td data-name="tgl_upd"<?php echo $tb_notifikasi->tgl_upd->CellAttributes() ?>>
<span id="el_tb_notifikasi_tgl_upd" data-page="1">
<span<?php echo $tb_notifikasi->tgl_upd->ViewAttributes() ?>>
<?php echo $tb_notifikasi->tgl_upd->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("tb_notifikasi_d", explode(",", $tb_notifikasi->getCurrentDetailTable())) && $tb_notifikasi_d->DetailView) {
?>
<?php if ($tb_notifikasi->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("tb_notifikasi_d", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "tb_notifikasi_dgrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
ftb_notifikasiview.Init();
</script>
<?php
$tb_notifikasi_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_notifikasi_view->Page_Terminate();
?>
