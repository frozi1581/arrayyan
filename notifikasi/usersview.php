<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$users_view = NULL; // Initialize page object first

class cusers_view extends cusers {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_view';

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

		// Table object (users)
		if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == "cusers") {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
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
			define("EW_TABLE_NAME", 'users', TRUE);

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
		$this->nama_pegawai->SetVisibility();
		$this->username->SetVisibility();
		$this->kode_unit_organisasi->SetVisibility();
		$this->kode_unit_kerja->SetVisibility();
		$this->jabatan->SetVisibility();
		$this->password->SetVisibility();
		$this->user_group->SetVisibility();
		$this->status->SetVisibility();
		$this->photo->SetVisibility();
		$this->nomor_anggota->SetVisibility();
		$this->nip->SetVisibility();
		$this->nip_lama->SetVisibility();
		$this->gelar_depan->SetVisibility();
		$this->gelar_belakang->SetVisibility();
		$this->pendidikan_terakhir->SetVisibility();
		$this->nama_lembaga->SetVisibility();
		$this->warga_negara->SetVisibility();
		$this->tempat_lahir->SetVisibility();
		$this->tanggal_lahir->SetVisibility();
		$this->jenis_kelamin->SetVisibility();
		$this->status_perkawinan->SetVisibility();
		$this->agama->SetVisibility();
		$this->nama_bank->SetVisibility();
		$this->no_rekening->SetVisibility();
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
		global $EW_EXPORT, $users;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($users);
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
					if ($pageName == "usersview.php")
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
				$sReturnUrl = "userslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "userslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "userslist.php"; // Not page request, return to list
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
		$this->nama_pegawai->setDbValue($row['nama_pegawai']);
		$this->username->setDbValue($row['username']);
		$this->kode_unit_organisasi->setDbValue($row['kode_unit_organisasi']);
		$this->kode_unit_kerja->setDbValue($row['kode_unit_kerja']);
		$this->jabatan->setDbValue($row['jabatan']);
		$this->password->setDbValue($row['password']);
		$this->user_group->setDbValue($row['user_group']);
		$this->status->setDbValue($row['status']);
		$this->photo->setDbValue($row['photo']);
		$this->nomor_anggota->setDbValue($row['nomor_anggota']);
		$this->nip->setDbValue($row['nip']);
		$this->nip_lama->setDbValue($row['nip_lama']);
		$this->gelar_depan->setDbValue($row['gelar_depan']);
		$this->gelar_belakang->setDbValue($row['gelar_belakang']);
		$this->pendidikan_terakhir->setDbValue($row['pendidikan_terakhir']);
		$this->nama_lembaga->setDbValue($row['nama_lembaga']);
		$this->warga_negara->setDbValue($row['warga_negara']);
		$this->tempat_lahir->setDbValue($row['tempat_lahir']);
		$this->tanggal_lahir->setDbValue($row['tanggal_lahir']);
		$this->jenis_kelamin->setDbValue($row['jenis_kelamin']);
		$this->status_perkawinan->setDbValue($row['status_perkawinan']);
		$this->agama->setDbValue($row['agama']);
		$this->nama_bank->setDbValue($row['nama_bank']);
		$this->no_rekening->setDbValue($row['no_rekening']);
		$this->change_date->setDbValue($row['change_date']);
		$this->change_by->setDbValue($row['change_by']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['nama_pegawai'] = NULL;
		$row['username'] = NULL;
		$row['kode_unit_organisasi'] = NULL;
		$row['kode_unit_kerja'] = NULL;
		$row['jabatan'] = NULL;
		$row['password'] = NULL;
		$row['user_group'] = NULL;
		$row['status'] = NULL;
		$row['photo'] = NULL;
		$row['nomor_anggota'] = NULL;
		$row['nip'] = NULL;
		$row['nip_lama'] = NULL;
		$row['gelar_depan'] = NULL;
		$row['gelar_belakang'] = NULL;
		$row['pendidikan_terakhir'] = NULL;
		$row['nama_lembaga'] = NULL;
		$row['warga_negara'] = NULL;
		$row['tempat_lahir'] = NULL;
		$row['tanggal_lahir'] = NULL;
		$row['jenis_kelamin'] = NULL;
		$row['status_perkawinan'] = NULL;
		$row['agama'] = NULL;
		$row['nama_bank'] = NULL;
		$row['no_rekening'] = NULL;
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
		$this->nama_pegawai->DbValue = $row['nama_pegawai'];
		$this->username->DbValue = $row['username'];
		$this->kode_unit_organisasi->DbValue = $row['kode_unit_organisasi'];
		$this->kode_unit_kerja->DbValue = $row['kode_unit_kerja'];
		$this->jabatan->DbValue = $row['jabatan'];
		$this->password->DbValue = $row['password'];
		$this->user_group->DbValue = $row['user_group'];
		$this->status->DbValue = $row['status'];
		$this->photo->DbValue = $row['photo'];
		$this->nomor_anggota->DbValue = $row['nomor_anggota'];
		$this->nip->DbValue = $row['nip'];
		$this->nip_lama->DbValue = $row['nip_lama'];
		$this->gelar_depan->DbValue = $row['gelar_depan'];
		$this->gelar_belakang->DbValue = $row['gelar_belakang'];
		$this->pendidikan_terakhir->DbValue = $row['pendidikan_terakhir'];
		$this->nama_lembaga->DbValue = $row['nama_lembaga'];
		$this->warga_negara->DbValue = $row['warga_negara'];
		$this->tempat_lahir->DbValue = $row['tempat_lahir'];
		$this->tanggal_lahir->DbValue = $row['tanggal_lahir'];
		$this->jenis_kelamin->DbValue = $row['jenis_kelamin'];
		$this->status_perkawinan->DbValue = $row['status_perkawinan'];
		$this->agama->DbValue = $row['agama'];
		$this->nama_bank->DbValue = $row['nama_bank'];
		$this->no_rekening->DbValue = $row['no_rekening'];
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
		// nama_pegawai
		// username
		// kode_unit_organisasi
		// kode_unit_kerja
		// jabatan
		// password
		// user_group
		// status
		// photo
		// nomor_anggota
		// nip
		// nip_lama
		// gelar_depan
		// gelar_belakang
		// pendidikan_terakhir
		// nama_lembaga
		// warga_negara
		// tempat_lahir
		// tanggal_lahir
		// jenis_kelamin
		// status_perkawinan
		// agama
		// nama_bank
		// no_rekening
		// change_date
		// change_by

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nama_pegawai
		$this->nama_pegawai->ViewValue = $this->nama_pegawai->CurrentValue;
		$this->nama_pegawai->ViewCustomAttributes = "";

		// username
		$this->username->ViewValue = $this->username->CurrentValue;
		$this->username->ViewCustomAttributes = "";

		// kode_unit_organisasi
		$this->kode_unit_organisasi->ViewValue = $this->kode_unit_organisasi->CurrentValue;
		$this->kode_unit_organisasi->ViewCustomAttributes = "";

		// kode_unit_kerja
		$this->kode_unit_kerja->ViewValue = $this->kode_unit_kerja->CurrentValue;
		$this->kode_unit_kerja->ViewCustomAttributes = "";

		// jabatan
		$this->jabatan->ViewValue = $this->jabatan->CurrentValue;
		$this->jabatan->ViewCustomAttributes = "";

		// password
		$this->password->ViewValue = $this->password->CurrentValue;
		$this->password->ViewCustomAttributes = "";

		// user_group
		$this->user_group->ViewValue = $this->user_group->CurrentValue;
		$this->user_group->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

		// photo
		$this->photo->ViewValue = $this->photo->CurrentValue;
		$this->photo->ViewCustomAttributes = "";

		// nomor_anggota
		$this->nomor_anggota->ViewValue = $this->nomor_anggota->CurrentValue;
		$this->nomor_anggota->ViewCustomAttributes = "";

		// nip
		$this->nip->ViewValue = $this->nip->CurrentValue;
		$this->nip->ViewCustomAttributes = "";

		// nip_lama
		$this->nip_lama->ViewValue = $this->nip_lama->CurrentValue;
		$this->nip_lama->ViewCustomAttributes = "";

		// gelar_depan
		$this->gelar_depan->ViewValue = $this->gelar_depan->CurrentValue;
		$this->gelar_depan->ViewCustomAttributes = "";

		// gelar_belakang
		$this->gelar_belakang->ViewValue = $this->gelar_belakang->CurrentValue;
		$this->gelar_belakang->ViewCustomAttributes = "";

		// pendidikan_terakhir
		$this->pendidikan_terakhir->ViewValue = $this->pendidikan_terakhir->CurrentValue;
		$this->pendidikan_terakhir->ViewCustomAttributes = "";

		// nama_lembaga
		$this->nama_lembaga->ViewValue = $this->nama_lembaga->CurrentValue;
		$this->nama_lembaga->ViewCustomAttributes = "";

		// warga_negara
		$this->warga_negara->ViewValue = $this->warga_negara->CurrentValue;
		$this->warga_negara->ViewCustomAttributes = "";

		// tempat_lahir
		$this->tempat_lahir->ViewValue = $this->tempat_lahir->CurrentValue;
		$this->tempat_lahir->ViewCustomAttributes = "";

		// tanggal_lahir
		$this->tanggal_lahir->ViewValue = $this->tanggal_lahir->CurrentValue;
		$this->tanggal_lahir->ViewValue = ew_FormatDateTime($this->tanggal_lahir->ViewValue, 0);
		$this->tanggal_lahir->ViewCustomAttributes = "";

		// jenis_kelamin
		$this->jenis_kelamin->ViewValue = $this->jenis_kelamin->CurrentValue;
		$this->jenis_kelamin->ViewCustomAttributes = "";

		// status_perkawinan
		$this->status_perkawinan->ViewValue = $this->status_perkawinan->CurrentValue;
		$this->status_perkawinan->ViewCustomAttributes = "";

		// agama
		$this->agama->ViewValue = $this->agama->CurrentValue;
		$this->agama->ViewCustomAttributes = "";

		// nama_bank
		$this->nama_bank->ViewValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->ViewCustomAttributes = "";

		// no_rekening
		$this->no_rekening->ViewValue = $this->no_rekening->CurrentValue;
		$this->no_rekening->ViewCustomAttributes = "";

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

			// nama_pegawai
			$this->nama_pegawai->LinkCustomAttributes = "";
			$this->nama_pegawai->HrefValue = "";
			$this->nama_pegawai->TooltipValue = "";

			// username
			$this->username->LinkCustomAttributes = "";
			$this->username->HrefValue = "";
			$this->username->TooltipValue = "";

			// kode_unit_organisasi
			$this->kode_unit_organisasi->LinkCustomAttributes = "";
			$this->kode_unit_organisasi->HrefValue = "";
			$this->kode_unit_organisasi->TooltipValue = "";

			// kode_unit_kerja
			$this->kode_unit_kerja->LinkCustomAttributes = "";
			$this->kode_unit_kerja->HrefValue = "";
			$this->kode_unit_kerja->TooltipValue = "";

			// jabatan
			$this->jabatan->LinkCustomAttributes = "";
			$this->jabatan->HrefValue = "";
			$this->jabatan->TooltipValue = "";

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";
			$this->password->TooltipValue = "";

			// user_group
			$this->user_group->LinkCustomAttributes = "";
			$this->user_group->HrefValue = "";
			$this->user_group->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// photo
			$this->photo->LinkCustomAttributes = "";
			$this->photo->HrefValue = "";
			$this->photo->TooltipValue = "";

			// nomor_anggota
			$this->nomor_anggota->LinkCustomAttributes = "";
			$this->nomor_anggota->HrefValue = "";
			$this->nomor_anggota->TooltipValue = "";

			// nip
			$this->nip->LinkCustomAttributes = "";
			$this->nip->HrefValue = "";
			$this->nip->TooltipValue = "";

			// nip_lama
			$this->nip_lama->LinkCustomAttributes = "";
			$this->nip_lama->HrefValue = "";
			$this->nip_lama->TooltipValue = "";

			// gelar_depan
			$this->gelar_depan->LinkCustomAttributes = "";
			$this->gelar_depan->HrefValue = "";
			$this->gelar_depan->TooltipValue = "";

			// gelar_belakang
			$this->gelar_belakang->LinkCustomAttributes = "";
			$this->gelar_belakang->HrefValue = "";
			$this->gelar_belakang->TooltipValue = "";

			// pendidikan_terakhir
			$this->pendidikan_terakhir->LinkCustomAttributes = "";
			$this->pendidikan_terakhir->HrefValue = "";
			$this->pendidikan_terakhir->TooltipValue = "";

			// nama_lembaga
			$this->nama_lembaga->LinkCustomAttributes = "";
			$this->nama_lembaga->HrefValue = "";
			$this->nama_lembaga->TooltipValue = "";

			// warga_negara
			$this->warga_negara->LinkCustomAttributes = "";
			$this->warga_negara->HrefValue = "";
			$this->warga_negara->TooltipValue = "";

			// tempat_lahir
			$this->tempat_lahir->LinkCustomAttributes = "";
			$this->tempat_lahir->HrefValue = "";
			$this->tempat_lahir->TooltipValue = "";

			// tanggal_lahir
			$this->tanggal_lahir->LinkCustomAttributes = "";
			$this->tanggal_lahir->HrefValue = "";
			$this->tanggal_lahir->TooltipValue = "";

			// jenis_kelamin
			$this->jenis_kelamin->LinkCustomAttributes = "";
			$this->jenis_kelamin->HrefValue = "";
			$this->jenis_kelamin->TooltipValue = "";

			// status_perkawinan
			$this->status_perkawinan->LinkCustomAttributes = "";
			$this->status_perkawinan->HrefValue = "";
			$this->status_perkawinan->TooltipValue = "";

			// agama
			$this->agama->LinkCustomAttributes = "";
			$this->agama->HrefValue = "";
			$this->agama->TooltipValue = "";

			// nama_bank
			$this->nama_bank->LinkCustomAttributes = "";
			$this->nama_bank->HrefValue = "";
			$this->nama_bank->TooltipValue = "";

			// no_rekening
			$this->no_rekening->LinkCustomAttributes = "";
			$this->no_rekening->HrefValue = "";
			$this->no_rekening->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("userslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($users_view)) $users_view = new cusers_view();

// Page init
$users_view->Page_Init();

// Page main
$users_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fusersview = new ew_Form("fusersview", "view");

// Form_CustomValidate event
fusersview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fusersview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $users_view->ExportOptions->Render("body") ?>
<?php
	foreach ($users_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $users_view->ShowPageHeader(); ?>
<?php
$users_view->ShowMessage();
?>
<form name="fusersview" id="fusersview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($users_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $users_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="modal" value="<?php echo intval($users_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($users->id->Visible) { // id ?>
	<tr id="r_id">
		<td class="col-sm-2"><span id="elh_users_id"><?php echo $users->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $users->id->CellAttributes() ?>>
<span id="el_users_id">
<span<?php echo $users->id->ViewAttributes() ?>>
<?php echo $users->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->nama_pegawai->Visible) { // nama_pegawai ?>
	<tr id="r_nama_pegawai">
		<td class="col-sm-2"><span id="elh_users_nama_pegawai"><?php echo $users->nama_pegawai->FldCaption() ?></span></td>
		<td data-name="nama_pegawai"<?php echo $users->nama_pegawai->CellAttributes() ?>>
<span id="el_users_nama_pegawai">
<span<?php echo $users->nama_pegawai->ViewAttributes() ?>>
<?php echo $users->nama_pegawai->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->username->Visible) { // username ?>
	<tr id="r_username">
		<td class="col-sm-2"><span id="elh_users_username"><?php echo $users->username->FldCaption() ?></span></td>
		<td data-name="username"<?php echo $users->username->CellAttributes() ?>>
<span id="el_users_username">
<span<?php echo $users->username->ViewAttributes() ?>>
<?php echo $users->username->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->kode_unit_organisasi->Visible) { // kode_unit_organisasi ?>
	<tr id="r_kode_unit_organisasi">
		<td class="col-sm-2"><span id="elh_users_kode_unit_organisasi"><?php echo $users->kode_unit_organisasi->FldCaption() ?></span></td>
		<td data-name="kode_unit_organisasi"<?php echo $users->kode_unit_organisasi->CellAttributes() ?>>
<span id="el_users_kode_unit_organisasi">
<span<?php echo $users->kode_unit_organisasi->ViewAttributes() ?>>
<?php echo $users->kode_unit_organisasi->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->kode_unit_kerja->Visible) { // kode_unit_kerja ?>
	<tr id="r_kode_unit_kerja">
		<td class="col-sm-2"><span id="elh_users_kode_unit_kerja"><?php echo $users->kode_unit_kerja->FldCaption() ?></span></td>
		<td data-name="kode_unit_kerja"<?php echo $users->kode_unit_kerja->CellAttributes() ?>>
<span id="el_users_kode_unit_kerja">
<span<?php echo $users->kode_unit_kerja->ViewAttributes() ?>>
<?php echo $users->kode_unit_kerja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->jabatan->Visible) { // jabatan ?>
	<tr id="r_jabatan">
		<td class="col-sm-2"><span id="elh_users_jabatan"><?php echo $users->jabatan->FldCaption() ?></span></td>
		<td data-name="jabatan"<?php echo $users->jabatan->CellAttributes() ?>>
<span id="el_users_jabatan">
<span<?php echo $users->jabatan->ViewAttributes() ?>>
<?php echo $users->jabatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->password->Visible) { // password ?>
	<tr id="r_password">
		<td class="col-sm-2"><span id="elh_users_password"><?php echo $users->password->FldCaption() ?></span></td>
		<td data-name="password"<?php echo $users->password->CellAttributes() ?>>
<span id="el_users_password">
<span<?php echo $users->password->ViewAttributes() ?>>
<?php echo $users->password->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->user_group->Visible) { // user_group ?>
	<tr id="r_user_group">
		<td class="col-sm-2"><span id="elh_users_user_group"><?php echo $users->user_group->FldCaption() ?></span></td>
		<td data-name="user_group"<?php echo $users->user_group->CellAttributes() ?>>
<span id="el_users_user_group">
<span<?php echo $users->user_group->ViewAttributes() ?>>
<?php echo $users->user_group->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->status->Visible) { // status ?>
	<tr id="r_status">
		<td class="col-sm-2"><span id="elh_users_status"><?php echo $users->status->FldCaption() ?></span></td>
		<td data-name="status"<?php echo $users->status->CellAttributes() ?>>
<span id="el_users_status">
<span<?php echo $users->status->ViewAttributes() ?>>
<?php echo $users->status->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->photo->Visible) { // photo ?>
	<tr id="r_photo">
		<td class="col-sm-2"><span id="elh_users_photo"><?php echo $users->photo->FldCaption() ?></span></td>
		<td data-name="photo"<?php echo $users->photo->CellAttributes() ?>>
<span id="el_users_photo">
<span<?php echo $users->photo->ViewAttributes() ?>>
<?php echo $users->photo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->nomor_anggota->Visible) { // nomor_anggota ?>
	<tr id="r_nomor_anggota">
		<td class="col-sm-2"><span id="elh_users_nomor_anggota"><?php echo $users->nomor_anggota->FldCaption() ?></span></td>
		<td data-name="nomor_anggota"<?php echo $users->nomor_anggota->CellAttributes() ?>>
<span id="el_users_nomor_anggota">
<span<?php echo $users->nomor_anggota->ViewAttributes() ?>>
<?php echo $users->nomor_anggota->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->nip->Visible) { // nip ?>
	<tr id="r_nip">
		<td class="col-sm-2"><span id="elh_users_nip"><?php echo $users->nip->FldCaption() ?></span></td>
		<td data-name="nip"<?php echo $users->nip->CellAttributes() ?>>
<span id="el_users_nip">
<span<?php echo $users->nip->ViewAttributes() ?>>
<?php echo $users->nip->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->nip_lama->Visible) { // nip_lama ?>
	<tr id="r_nip_lama">
		<td class="col-sm-2"><span id="elh_users_nip_lama"><?php echo $users->nip_lama->FldCaption() ?></span></td>
		<td data-name="nip_lama"<?php echo $users->nip_lama->CellAttributes() ?>>
<span id="el_users_nip_lama">
<span<?php echo $users->nip_lama->ViewAttributes() ?>>
<?php echo $users->nip_lama->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->gelar_depan->Visible) { // gelar_depan ?>
	<tr id="r_gelar_depan">
		<td class="col-sm-2"><span id="elh_users_gelar_depan"><?php echo $users->gelar_depan->FldCaption() ?></span></td>
		<td data-name="gelar_depan"<?php echo $users->gelar_depan->CellAttributes() ?>>
<span id="el_users_gelar_depan">
<span<?php echo $users->gelar_depan->ViewAttributes() ?>>
<?php echo $users->gelar_depan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->gelar_belakang->Visible) { // gelar_belakang ?>
	<tr id="r_gelar_belakang">
		<td class="col-sm-2"><span id="elh_users_gelar_belakang"><?php echo $users->gelar_belakang->FldCaption() ?></span></td>
		<td data-name="gelar_belakang"<?php echo $users->gelar_belakang->CellAttributes() ?>>
<span id="el_users_gelar_belakang">
<span<?php echo $users->gelar_belakang->ViewAttributes() ?>>
<?php echo $users->gelar_belakang->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->pendidikan_terakhir->Visible) { // pendidikan_terakhir ?>
	<tr id="r_pendidikan_terakhir">
		<td class="col-sm-2"><span id="elh_users_pendidikan_terakhir"><?php echo $users->pendidikan_terakhir->FldCaption() ?></span></td>
		<td data-name="pendidikan_terakhir"<?php echo $users->pendidikan_terakhir->CellAttributes() ?>>
<span id="el_users_pendidikan_terakhir">
<span<?php echo $users->pendidikan_terakhir->ViewAttributes() ?>>
<?php echo $users->pendidikan_terakhir->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->nama_lembaga->Visible) { // nama_lembaga ?>
	<tr id="r_nama_lembaga">
		<td class="col-sm-2"><span id="elh_users_nama_lembaga"><?php echo $users->nama_lembaga->FldCaption() ?></span></td>
		<td data-name="nama_lembaga"<?php echo $users->nama_lembaga->CellAttributes() ?>>
<span id="el_users_nama_lembaga">
<span<?php echo $users->nama_lembaga->ViewAttributes() ?>>
<?php echo $users->nama_lembaga->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->warga_negara->Visible) { // warga_negara ?>
	<tr id="r_warga_negara">
		<td class="col-sm-2"><span id="elh_users_warga_negara"><?php echo $users->warga_negara->FldCaption() ?></span></td>
		<td data-name="warga_negara"<?php echo $users->warga_negara->CellAttributes() ?>>
<span id="el_users_warga_negara">
<span<?php echo $users->warga_negara->ViewAttributes() ?>>
<?php echo $users->warga_negara->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->tempat_lahir->Visible) { // tempat_lahir ?>
	<tr id="r_tempat_lahir">
		<td class="col-sm-2"><span id="elh_users_tempat_lahir"><?php echo $users->tempat_lahir->FldCaption() ?></span></td>
		<td data-name="tempat_lahir"<?php echo $users->tempat_lahir->CellAttributes() ?>>
<span id="el_users_tempat_lahir">
<span<?php echo $users->tempat_lahir->ViewAttributes() ?>>
<?php echo $users->tempat_lahir->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->tanggal_lahir->Visible) { // tanggal_lahir ?>
	<tr id="r_tanggal_lahir">
		<td class="col-sm-2"><span id="elh_users_tanggal_lahir"><?php echo $users->tanggal_lahir->FldCaption() ?></span></td>
		<td data-name="tanggal_lahir"<?php echo $users->tanggal_lahir->CellAttributes() ?>>
<span id="el_users_tanggal_lahir">
<span<?php echo $users->tanggal_lahir->ViewAttributes() ?>>
<?php echo $users->tanggal_lahir->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->jenis_kelamin->Visible) { // jenis_kelamin ?>
	<tr id="r_jenis_kelamin">
		<td class="col-sm-2"><span id="elh_users_jenis_kelamin"><?php echo $users->jenis_kelamin->FldCaption() ?></span></td>
		<td data-name="jenis_kelamin"<?php echo $users->jenis_kelamin->CellAttributes() ?>>
<span id="el_users_jenis_kelamin">
<span<?php echo $users->jenis_kelamin->ViewAttributes() ?>>
<?php echo $users->jenis_kelamin->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->status_perkawinan->Visible) { // status_perkawinan ?>
	<tr id="r_status_perkawinan">
		<td class="col-sm-2"><span id="elh_users_status_perkawinan"><?php echo $users->status_perkawinan->FldCaption() ?></span></td>
		<td data-name="status_perkawinan"<?php echo $users->status_perkawinan->CellAttributes() ?>>
<span id="el_users_status_perkawinan">
<span<?php echo $users->status_perkawinan->ViewAttributes() ?>>
<?php echo $users->status_perkawinan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->agama->Visible) { // agama ?>
	<tr id="r_agama">
		<td class="col-sm-2"><span id="elh_users_agama"><?php echo $users->agama->FldCaption() ?></span></td>
		<td data-name="agama"<?php echo $users->agama->CellAttributes() ?>>
<span id="el_users_agama">
<span<?php echo $users->agama->ViewAttributes() ?>>
<?php echo $users->agama->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->nama_bank->Visible) { // nama_bank ?>
	<tr id="r_nama_bank">
		<td class="col-sm-2"><span id="elh_users_nama_bank"><?php echo $users->nama_bank->FldCaption() ?></span></td>
		<td data-name="nama_bank"<?php echo $users->nama_bank->CellAttributes() ?>>
<span id="el_users_nama_bank">
<span<?php echo $users->nama_bank->ViewAttributes() ?>>
<?php echo $users->nama_bank->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->no_rekening->Visible) { // no_rekening ?>
	<tr id="r_no_rekening">
		<td class="col-sm-2"><span id="elh_users_no_rekening"><?php echo $users->no_rekening->FldCaption() ?></span></td>
		<td data-name="no_rekening"<?php echo $users->no_rekening->CellAttributes() ?>>
<span id="el_users_no_rekening">
<span<?php echo $users->no_rekening->ViewAttributes() ?>>
<?php echo $users->no_rekening->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->change_date->Visible) { // change_date ?>
	<tr id="r_change_date">
		<td class="col-sm-2"><span id="elh_users_change_date"><?php echo $users->change_date->FldCaption() ?></span></td>
		<td data-name="change_date"<?php echo $users->change_date->CellAttributes() ?>>
<span id="el_users_change_date">
<span<?php echo $users->change_date->ViewAttributes() ?>>
<?php echo $users->change_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->change_by->Visible) { // change_by ?>
	<tr id="r_change_by">
		<td class="col-sm-2"><span id="elh_users_change_by"><?php echo $users->change_by->FldCaption() ?></span></td>
		<td data-name="change_by"<?php echo $users->change_by->CellAttributes() ?>>
<span id="el_users_change_by">
<span<?php echo $users->change_by->ViewAttributes() ?>>
<?php echo $users->change_by->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fusersview.Init();
</script>
<?php
$users_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$users_view->Page_Terminate();
?>
