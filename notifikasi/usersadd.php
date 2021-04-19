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

$users_add = NULL; // Initialize page object first

class cusers_add extends cusers {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_add';

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

		// Table object (users)
		if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == "cusers") {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("userslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "userslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "usersview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
		$this->nama_pegawai->CurrentValue = NULL;
		$this->nama_pegawai->OldValue = $this->nama_pegawai->CurrentValue;
		$this->username->CurrentValue = NULL;
		$this->username->OldValue = $this->username->CurrentValue;
		$this->kode_unit_organisasi->CurrentValue = NULL;
		$this->kode_unit_organisasi->OldValue = $this->kode_unit_organisasi->CurrentValue;
		$this->kode_unit_kerja->CurrentValue = NULL;
		$this->kode_unit_kerja->OldValue = $this->kode_unit_kerja->CurrentValue;
		$this->jabatan->CurrentValue = NULL;
		$this->jabatan->OldValue = $this->jabatan->CurrentValue;
		$this->password->CurrentValue = NULL;
		$this->password->OldValue = $this->password->CurrentValue;
		$this->user_group->CurrentValue = NULL;
		$this->user_group->OldValue = $this->user_group->CurrentValue;
		$this->status->CurrentValue = NULL;
		$this->status->OldValue = $this->status->CurrentValue;
		$this->photo->CurrentValue = NULL;
		$this->photo->OldValue = $this->photo->CurrentValue;
		$this->nomor_anggota->CurrentValue = NULL;
		$this->nomor_anggota->OldValue = $this->nomor_anggota->CurrentValue;
		$this->nip->CurrentValue = NULL;
		$this->nip->OldValue = $this->nip->CurrentValue;
		$this->nip_lama->CurrentValue = NULL;
		$this->nip_lama->OldValue = $this->nip_lama->CurrentValue;
		$this->gelar_depan->CurrentValue = NULL;
		$this->gelar_depan->OldValue = $this->gelar_depan->CurrentValue;
		$this->gelar_belakang->CurrentValue = NULL;
		$this->gelar_belakang->OldValue = $this->gelar_belakang->CurrentValue;
		$this->pendidikan_terakhir->CurrentValue = NULL;
		$this->pendidikan_terakhir->OldValue = $this->pendidikan_terakhir->CurrentValue;
		$this->nama_lembaga->CurrentValue = NULL;
		$this->nama_lembaga->OldValue = $this->nama_lembaga->CurrentValue;
		$this->warga_negara->CurrentValue = NULL;
		$this->warga_negara->OldValue = $this->warga_negara->CurrentValue;
		$this->tempat_lahir->CurrentValue = NULL;
		$this->tempat_lahir->OldValue = $this->tempat_lahir->CurrentValue;
		$this->tanggal_lahir->CurrentValue = "0000-00-00";
		$this->jenis_kelamin->CurrentValue = NULL;
		$this->jenis_kelamin->OldValue = $this->jenis_kelamin->CurrentValue;
		$this->status_perkawinan->CurrentValue = NULL;
		$this->status_perkawinan->OldValue = $this->status_perkawinan->CurrentValue;
		$this->agama->CurrentValue = NULL;
		$this->agama->OldValue = $this->agama->CurrentValue;
		$this->nama_bank->CurrentValue = NULL;
		$this->nama_bank->OldValue = $this->nama_bank->CurrentValue;
		$this->no_rekening->CurrentValue = NULL;
		$this->no_rekening->OldValue = $this->no_rekening->CurrentValue;
		$this->change_date->CurrentValue = NULL;
		$this->change_date->OldValue = $this->change_date->CurrentValue;
		$this->change_by->CurrentValue = NULL;
		$this->change_by->OldValue = $this->change_by->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nama_pegawai->FldIsDetailKey) {
			$this->nama_pegawai->setFormValue($objForm->GetValue("x_nama_pegawai"));
		}
		if (!$this->username->FldIsDetailKey) {
			$this->username->setFormValue($objForm->GetValue("x_username"));
		}
		if (!$this->kode_unit_organisasi->FldIsDetailKey) {
			$this->kode_unit_organisasi->setFormValue($objForm->GetValue("x_kode_unit_organisasi"));
		}
		if (!$this->kode_unit_kerja->FldIsDetailKey) {
			$this->kode_unit_kerja->setFormValue($objForm->GetValue("x_kode_unit_kerja"));
		}
		if (!$this->jabatan->FldIsDetailKey) {
			$this->jabatan->setFormValue($objForm->GetValue("x_jabatan"));
		}
		if (!$this->password->FldIsDetailKey) {
			$this->password->setFormValue($objForm->GetValue("x_password"));
		}
		if (!$this->user_group->FldIsDetailKey) {
			$this->user_group->setFormValue($objForm->GetValue("x_user_group"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->photo->FldIsDetailKey) {
			$this->photo->setFormValue($objForm->GetValue("x_photo"));
		}
		if (!$this->nomor_anggota->FldIsDetailKey) {
			$this->nomor_anggota->setFormValue($objForm->GetValue("x_nomor_anggota"));
		}
		if (!$this->nip->FldIsDetailKey) {
			$this->nip->setFormValue($objForm->GetValue("x_nip"));
		}
		if (!$this->nip_lama->FldIsDetailKey) {
			$this->nip_lama->setFormValue($objForm->GetValue("x_nip_lama"));
		}
		if (!$this->gelar_depan->FldIsDetailKey) {
			$this->gelar_depan->setFormValue($objForm->GetValue("x_gelar_depan"));
		}
		if (!$this->gelar_belakang->FldIsDetailKey) {
			$this->gelar_belakang->setFormValue($objForm->GetValue("x_gelar_belakang"));
		}
		if (!$this->pendidikan_terakhir->FldIsDetailKey) {
			$this->pendidikan_terakhir->setFormValue($objForm->GetValue("x_pendidikan_terakhir"));
		}
		if (!$this->nama_lembaga->FldIsDetailKey) {
			$this->nama_lembaga->setFormValue($objForm->GetValue("x_nama_lembaga"));
		}
		if (!$this->warga_negara->FldIsDetailKey) {
			$this->warga_negara->setFormValue($objForm->GetValue("x_warga_negara"));
		}
		if (!$this->tempat_lahir->FldIsDetailKey) {
			$this->tempat_lahir->setFormValue($objForm->GetValue("x_tempat_lahir"));
		}
		if (!$this->tanggal_lahir->FldIsDetailKey) {
			$this->tanggal_lahir->setFormValue($objForm->GetValue("x_tanggal_lahir"));
			$this->tanggal_lahir->CurrentValue = ew_UnFormatDateTime($this->tanggal_lahir->CurrentValue, 0);
		}
		if (!$this->jenis_kelamin->FldIsDetailKey) {
			$this->jenis_kelamin->setFormValue($objForm->GetValue("x_jenis_kelamin"));
		}
		if (!$this->status_perkawinan->FldIsDetailKey) {
			$this->status_perkawinan->setFormValue($objForm->GetValue("x_status_perkawinan"));
		}
		if (!$this->agama->FldIsDetailKey) {
			$this->agama->setFormValue($objForm->GetValue("x_agama"));
		}
		if (!$this->nama_bank->FldIsDetailKey) {
			$this->nama_bank->setFormValue($objForm->GetValue("x_nama_bank"));
		}
		if (!$this->no_rekening->FldIsDetailKey) {
			$this->no_rekening->setFormValue($objForm->GetValue("x_no_rekening"));
		}
		if (!$this->change_date->FldIsDetailKey) {
			$this->change_date->setFormValue($objForm->GetValue("x_change_date"));
			$this->change_date->CurrentValue = ew_UnFormatDateTime($this->change_date->CurrentValue, 0);
		}
		if (!$this->change_by->FldIsDetailKey) {
			$this->change_by->setFormValue($objForm->GetValue("x_change_by"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->nama_pegawai->CurrentValue = $this->nama_pegawai->FormValue;
		$this->username->CurrentValue = $this->username->FormValue;
		$this->kode_unit_organisasi->CurrentValue = $this->kode_unit_organisasi->FormValue;
		$this->kode_unit_kerja->CurrentValue = $this->kode_unit_kerja->FormValue;
		$this->jabatan->CurrentValue = $this->jabatan->FormValue;
		$this->password->CurrentValue = $this->password->FormValue;
		$this->user_group->CurrentValue = $this->user_group->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->photo->CurrentValue = $this->photo->FormValue;
		$this->nomor_anggota->CurrentValue = $this->nomor_anggota->FormValue;
		$this->nip->CurrentValue = $this->nip->FormValue;
		$this->nip_lama->CurrentValue = $this->nip_lama->FormValue;
		$this->gelar_depan->CurrentValue = $this->gelar_depan->FormValue;
		$this->gelar_belakang->CurrentValue = $this->gelar_belakang->FormValue;
		$this->pendidikan_terakhir->CurrentValue = $this->pendidikan_terakhir->FormValue;
		$this->nama_lembaga->CurrentValue = $this->nama_lembaga->FormValue;
		$this->warga_negara->CurrentValue = $this->warga_negara->FormValue;
		$this->tempat_lahir->CurrentValue = $this->tempat_lahir->FormValue;
		$this->tanggal_lahir->CurrentValue = $this->tanggal_lahir->FormValue;
		$this->tanggal_lahir->CurrentValue = ew_UnFormatDateTime($this->tanggal_lahir->CurrentValue, 0);
		$this->jenis_kelamin->CurrentValue = $this->jenis_kelamin->FormValue;
		$this->status_perkawinan->CurrentValue = $this->status_perkawinan->FormValue;
		$this->agama->CurrentValue = $this->agama->FormValue;
		$this->nama_bank->CurrentValue = $this->nama_bank->FormValue;
		$this->no_rekening->CurrentValue = $this->no_rekening->FormValue;
		$this->change_date->CurrentValue = $this->change_date->FormValue;
		$this->change_date->CurrentValue = ew_UnFormatDateTime($this->change_date->CurrentValue, 0);
		$this->change_by->CurrentValue = $this->change_by->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['nama_pegawai'] = $this->nama_pegawai->CurrentValue;
		$row['username'] = $this->username->CurrentValue;
		$row['kode_unit_organisasi'] = $this->kode_unit_organisasi->CurrentValue;
		$row['kode_unit_kerja'] = $this->kode_unit_kerja->CurrentValue;
		$row['jabatan'] = $this->jabatan->CurrentValue;
		$row['password'] = $this->password->CurrentValue;
		$row['user_group'] = $this->user_group->CurrentValue;
		$row['status'] = $this->status->CurrentValue;
		$row['photo'] = $this->photo->CurrentValue;
		$row['nomor_anggota'] = $this->nomor_anggota->CurrentValue;
		$row['nip'] = $this->nip->CurrentValue;
		$row['nip_lama'] = $this->nip_lama->CurrentValue;
		$row['gelar_depan'] = $this->gelar_depan->CurrentValue;
		$row['gelar_belakang'] = $this->gelar_belakang->CurrentValue;
		$row['pendidikan_terakhir'] = $this->pendidikan_terakhir->CurrentValue;
		$row['nama_lembaga'] = $this->nama_lembaga->CurrentValue;
		$row['warga_negara'] = $this->warga_negara->CurrentValue;
		$row['tempat_lahir'] = $this->tempat_lahir->CurrentValue;
		$row['tanggal_lahir'] = $this->tanggal_lahir->CurrentValue;
		$row['jenis_kelamin'] = $this->jenis_kelamin->CurrentValue;
		$row['status_perkawinan'] = $this->status_perkawinan->CurrentValue;
		$row['agama'] = $this->agama->CurrentValue;
		$row['nama_bank'] = $this->nama_bank->CurrentValue;
		$row['no_rekening'] = $this->no_rekening->CurrentValue;
		$row['change_date'] = $this->change_date->CurrentValue;
		$row['change_by'] = $this->change_by->CurrentValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nama_pegawai
			$this->nama_pegawai->EditAttrs["class"] = "form-control";
			$this->nama_pegawai->EditCustomAttributes = "";
			$this->nama_pegawai->EditValue = ew_HtmlEncode($this->nama_pegawai->CurrentValue);
			$this->nama_pegawai->PlaceHolder = ew_RemoveHtml($this->nama_pegawai->FldCaption());

			// username
			$this->username->EditAttrs["class"] = "form-control";
			$this->username->EditCustomAttributes = "";
			$this->username->EditValue = ew_HtmlEncode($this->username->CurrentValue);
			$this->username->PlaceHolder = ew_RemoveHtml($this->username->FldCaption());

			// kode_unit_organisasi
			$this->kode_unit_organisasi->EditAttrs["class"] = "form-control";
			$this->kode_unit_organisasi->EditCustomAttributes = "";
			$this->kode_unit_organisasi->EditValue = ew_HtmlEncode($this->kode_unit_organisasi->CurrentValue);
			$this->kode_unit_organisasi->PlaceHolder = ew_RemoveHtml($this->kode_unit_organisasi->FldCaption());

			// kode_unit_kerja
			$this->kode_unit_kerja->EditAttrs["class"] = "form-control";
			$this->kode_unit_kerja->EditCustomAttributes = "";
			$this->kode_unit_kerja->EditValue = ew_HtmlEncode($this->kode_unit_kerja->CurrentValue);
			$this->kode_unit_kerja->PlaceHolder = ew_RemoveHtml($this->kode_unit_kerja->FldCaption());

			// jabatan
			$this->jabatan->EditAttrs["class"] = "form-control";
			$this->jabatan->EditCustomAttributes = "";
			$this->jabatan->EditValue = ew_HtmlEncode($this->jabatan->CurrentValue);
			$this->jabatan->PlaceHolder = ew_RemoveHtml($this->jabatan->FldCaption());

			// password
			$this->password->EditAttrs["class"] = "form-control";
			$this->password->EditCustomAttributes = "";
			$this->password->EditValue = ew_HtmlEncode($this->password->CurrentValue);
			$this->password->PlaceHolder = ew_RemoveHtml($this->password->FldCaption());

			// user_group
			$this->user_group->EditAttrs["class"] = "form-control";
			$this->user_group->EditCustomAttributes = "";
			$this->user_group->EditValue = ew_HtmlEncode($this->user_group->CurrentValue);
			$this->user_group->PlaceHolder = ew_RemoveHtml($this->user_group->FldCaption());

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = ew_HtmlEncode($this->status->CurrentValue);
			$this->status->PlaceHolder = ew_RemoveHtml($this->status->FldCaption());

			// photo
			$this->photo->EditAttrs["class"] = "form-control";
			$this->photo->EditCustomAttributes = "";
			$this->photo->EditValue = ew_HtmlEncode($this->photo->CurrentValue);
			$this->photo->PlaceHolder = ew_RemoveHtml($this->photo->FldCaption());

			// nomor_anggota
			$this->nomor_anggota->EditAttrs["class"] = "form-control";
			$this->nomor_anggota->EditCustomAttributes = "";
			$this->nomor_anggota->EditValue = ew_HtmlEncode($this->nomor_anggota->CurrentValue);
			$this->nomor_anggota->PlaceHolder = ew_RemoveHtml($this->nomor_anggota->FldCaption());

			// nip
			$this->nip->EditAttrs["class"] = "form-control";
			$this->nip->EditCustomAttributes = "";
			$this->nip->EditValue = ew_HtmlEncode($this->nip->CurrentValue);
			$this->nip->PlaceHolder = ew_RemoveHtml($this->nip->FldCaption());

			// nip_lama
			$this->nip_lama->EditAttrs["class"] = "form-control";
			$this->nip_lama->EditCustomAttributes = "";
			$this->nip_lama->EditValue = ew_HtmlEncode($this->nip_lama->CurrentValue);
			$this->nip_lama->PlaceHolder = ew_RemoveHtml($this->nip_lama->FldCaption());

			// gelar_depan
			$this->gelar_depan->EditAttrs["class"] = "form-control";
			$this->gelar_depan->EditCustomAttributes = "";
			$this->gelar_depan->EditValue = ew_HtmlEncode($this->gelar_depan->CurrentValue);
			$this->gelar_depan->PlaceHolder = ew_RemoveHtml($this->gelar_depan->FldCaption());

			// gelar_belakang
			$this->gelar_belakang->EditAttrs["class"] = "form-control";
			$this->gelar_belakang->EditCustomAttributes = "";
			$this->gelar_belakang->EditValue = ew_HtmlEncode($this->gelar_belakang->CurrentValue);
			$this->gelar_belakang->PlaceHolder = ew_RemoveHtml($this->gelar_belakang->FldCaption());

			// pendidikan_terakhir
			$this->pendidikan_terakhir->EditAttrs["class"] = "form-control";
			$this->pendidikan_terakhir->EditCustomAttributes = "";
			$this->pendidikan_terakhir->EditValue = ew_HtmlEncode($this->pendidikan_terakhir->CurrentValue);
			$this->pendidikan_terakhir->PlaceHolder = ew_RemoveHtml($this->pendidikan_terakhir->FldCaption());

			// nama_lembaga
			$this->nama_lembaga->EditAttrs["class"] = "form-control";
			$this->nama_lembaga->EditCustomAttributes = "";
			$this->nama_lembaga->EditValue = ew_HtmlEncode($this->nama_lembaga->CurrentValue);
			$this->nama_lembaga->PlaceHolder = ew_RemoveHtml($this->nama_lembaga->FldCaption());

			// warga_negara
			$this->warga_negara->EditAttrs["class"] = "form-control";
			$this->warga_negara->EditCustomAttributes = "";
			$this->warga_negara->EditValue = ew_HtmlEncode($this->warga_negara->CurrentValue);
			$this->warga_negara->PlaceHolder = ew_RemoveHtml($this->warga_negara->FldCaption());

			// tempat_lahir
			$this->tempat_lahir->EditAttrs["class"] = "form-control";
			$this->tempat_lahir->EditCustomAttributes = "";
			$this->tempat_lahir->EditValue = ew_HtmlEncode($this->tempat_lahir->CurrentValue);
			$this->tempat_lahir->PlaceHolder = ew_RemoveHtml($this->tempat_lahir->FldCaption());

			// tanggal_lahir
			$this->tanggal_lahir->EditAttrs["class"] = "form-control";
			$this->tanggal_lahir->EditCustomAttributes = "";
			$this->tanggal_lahir->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tanggal_lahir->CurrentValue, 8));
			$this->tanggal_lahir->PlaceHolder = ew_RemoveHtml($this->tanggal_lahir->FldCaption());

			// jenis_kelamin
			$this->jenis_kelamin->EditAttrs["class"] = "form-control";
			$this->jenis_kelamin->EditCustomAttributes = "";
			$this->jenis_kelamin->EditValue = ew_HtmlEncode($this->jenis_kelamin->CurrentValue);
			$this->jenis_kelamin->PlaceHolder = ew_RemoveHtml($this->jenis_kelamin->FldCaption());

			// status_perkawinan
			$this->status_perkawinan->EditAttrs["class"] = "form-control";
			$this->status_perkawinan->EditCustomAttributes = "";
			$this->status_perkawinan->EditValue = ew_HtmlEncode($this->status_perkawinan->CurrentValue);
			$this->status_perkawinan->PlaceHolder = ew_RemoveHtml($this->status_perkawinan->FldCaption());

			// agama
			$this->agama->EditAttrs["class"] = "form-control";
			$this->agama->EditCustomAttributes = "";
			$this->agama->EditValue = ew_HtmlEncode($this->agama->CurrentValue);
			$this->agama->PlaceHolder = ew_RemoveHtml($this->agama->FldCaption());

			// nama_bank
			$this->nama_bank->EditAttrs["class"] = "form-control";
			$this->nama_bank->EditCustomAttributes = "";
			$this->nama_bank->EditValue = ew_HtmlEncode($this->nama_bank->CurrentValue);
			$this->nama_bank->PlaceHolder = ew_RemoveHtml($this->nama_bank->FldCaption());

			// no_rekening
			$this->no_rekening->EditAttrs["class"] = "form-control";
			$this->no_rekening->EditCustomAttributes = "";
			$this->no_rekening->EditValue = ew_HtmlEncode($this->no_rekening->CurrentValue);
			$this->no_rekening->PlaceHolder = ew_RemoveHtml($this->no_rekening->FldCaption());

			// change_date
			$this->change_date->EditAttrs["class"] = "form-control";
			$this->change_date->EditCustomAttributes = "";
			$this->change_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->change_date->CurrentValue, 8));
			$this->change_date->PlaceHolder = ew_RemoveHtml($this->change_date->FldCaption());

			// change_by
			$this->change_by->EditAttrs["class"] = "form-control";
			$this->change_by->EditCustomAttributes = "";
			$this->change_by->EditValue = ew_HtmlEncode($this->change_by->CurrentValue);
			$this->change_by->PlaceHolder = ew_RemoveHtml($this->change_by->FldCaption());

			// Add refer script
			// nama_pegawai

			$this->nama_pegawai->LinkCustomAttributes = "";
			$this->nama_pegawai->HrefValue = "";

			// username
			$this->username->LinkCustomAttributes = "";
			$this->username->HrefValue = "";

			// kode_unit_organisasi
			$this->kode_unit_organisasi->LinkCustomAttributes = "";
			$this->kode_unit_organisasi->HrefValue = "";

			// kode_unit_kerja
			$this->kode_unit_kerja->LinkCustomAttributes = "";
			$this->kode_unit_kerja->HrefValue = "";

			// jabatan
			$this->jabatan->LinkCustomAttributes = "";
			$this->jabatan->HrefValue = "";

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";

			// user_group
			$this->user_group->LinkCustomAttributes = "";
			$this->user_group->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";

			// photo
			$this->photo->LinkCustomAttributes = "";
			$this->photo->HrefValue = "";

			// nomor_anggota
			$this->nomor_anggota->LinkCustomAttributes = "";
			$this->nomor_anggota->HrefValue = "";

			// nip
			$this->nip->LinkCustomAttributes = "";
			$this->nip->HrefValue = "";

			// nip_lama
			$this->nip_lama->LinkCustomAttributes = "";
			$this->nip_lama->HrefValue = "";

			// gelar_depan
			$this->gelar_depan->LinkCustomAttributes = "";
			$this->gelar_depan->HrefValue = "";

			// gelar_belakang
			$this->gelar_belakang->LinkCustomAttributes = "";
			$this->gelar_belakang->HrefValue = "";

			// pendidikan_terakhir
			$this->pendidikan_terakhir->LinkCustomAttributes = "";
			$this->pendidikan_terakhir->HrefValue = "";

			// nama_lembaga
			$this->nama_lembaga->LinkCustomAttributes = "";
			$this->nama_lembaga->HrefValue = "";

			// warga_negara
			$this->warga_negara->LinkCustomAttributes = "";
			$this->warga_negara->HrefValue = "";

			// tempat_lahir
			$this->tempat_lahir->LinkCustomAttributes = "";
			$this->tempat_lahir->HrefValue = "";

			// tanggal_lahir
			$this->tanggal_lahir->LinkCustomAttributes = "";
			$this->tanggal_lahir->HrefValue = "";

			// jenis_kelamin
			$this->jenis_kelamin->LinkCustomAttributes = "";
			$this->jenis_kelamin->HrefValue = "";

			// status_perkawinan
			$this->status_perkawinan->LinkCustomAttributes = "";
			$this->status_perkawinan->HrefValue = "";

			// agama
			$this->agama->LinkCustomAttributes = "";
			$this->agama->HrefValue = "";

			// nama_bank
			$this->nama_bank->LinkCustomAttributes = "";
			$this->nama_bank->HrefValue = "";

			// no_rekening
			$this->no_rekening->LinkCustomAttributes = "";
			$this->no_rekening->HrefValue = "";

			// change_date
			$this->change_date->LinkCustomAttributes = "";
			$this->change_date->HrefValue = "";

			// change_by
			$this->change_by->LinkCustomAttributes = "";
			$this->change_by->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->username->FldIsDetailKey && !is_null($this->username->FormValue) && $this->username->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->username->FldCaption(), $this->username->ReqErrMsg));
		}
		if (!$this->password->FldIsDetailKey && !is_null($this->password->FormValue) && $this->password->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->password->FldCaption(), $this->password->ReqErrMsg));
		}
		if (!$this->user_group->FldIsDetailKey && !is_null($this->user_group->FormValue) && $this->user_group->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->user_group->FldCaption(), $this->user_group->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->user_group->FormValue)) {
			ew_AddMessage($gsFormError, $this->user_group->FldErrMsg());
		}
		if (!$this->status->FldIsDetailKey && !is_null($this->status->FormValue) && $this->status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status->FldCaption(), $this->status->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->status->FormValue)) {
			ew_AddMessage($gsFormError, $this->status->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tanggal_lahir->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal_lahir->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->change_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->change_date->FldErrMsg());
		}
		if (!$this->change_by->FldIsDetailKey && !is_null($this->change_by->FormValue) && $this->change_by->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->change_by->FldCaption(), $this->change_by->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		if ($this->nip->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(nip = '" . ew_AdjustSql($this->nip->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->nip->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->nip->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// nama_pegawai
		$this->nama_pegawai->SetDbValueDef($rsnew, $this->nama_pegawai->CurrentValue, NULL, FALSE);

		// username
		$this->username->SetDbValueDef($rsnew, $this->username->CurrentValue, "", FALSE);

		// kode_unit_organisasi
		$this->kode_unit_organisasi->SetDbValueDef($rsnew, $this->kode_unit_organisasi->CurrentValue, NULL, FALSE);

		// kode_unit_kerja
		$this->kode_unit_kerja->SetDbValueDef($rsnew, $this->kode_unit_kerja->CurrentValue, NULL, FALSE);

		// jabatan
		$this->jabatan->SetDbValueDef($rsnew, $this->jabatan->CurrentValue, NULL, FALSE);

		// password
		$this->password->SetDbValueDef($rsnew, $this->password->CurrentValue, "", FALSE);

		// user_group
		$this->user_group->SetDbValueDef($rsnew, $this->user_group->CurrentValue, 0, FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, 0, FALSE);

		// photo
		$this->photo->SetDbValueDef($rsnew, $this->photo->CurrentValue, NULL, FALSE);

		// nomor_anggota
		$this->nomor_anggota->SetDbValueDef($rsnew, $this->nomor_anggota->CurrentValue, NULL, FALSE);

		// nip
		$this->nip->SetDbValueDef($rsnew, $this->nip->CurrentValue, NULL, FALSE);

		// nip_lama
		$this->nip_lama->SetDbValueDef($rsnew, $this->nip_lama->CurrentValue, NULL, FALSE);

		// gelar_depan
		$this->gelar_depan->SetDbValueDef($rsnew, $this->gelar_depan->CurrentValue, NULL, FALSE);

		// gelar_belakang
		$this->gelar_belakang->SetDbValueDef($rsnew, $this->gelar_belakang->CurrentValue, NULL, FALSE);

		// pendidikan_terakhir
		$this->pendidikan_terakhir->SetDbValueDef($rsnew, $this->pendidikan_terakhir->CurrentValue, NULL, FALSE);

		// nama_lembaga
		$this->nama_lembaga->SetDbValueDef($rsnew, $this->nama_lembaga->CurrentValue, NULL, FALSE);

		// warga_negara
		$this->warga_negara->SetDbValueDef($rsnew, $this->warga_negara->CurrentValue, NULL, FALSE);

		// tempat_lahir
		$this->tempat_lahir->SetDbValueDef($rsnew, $this->tempat_lahir->CurrentValue, NULL, FALSE);

		// tanggal_lahir
		$this->tanggal_lahir->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal_lahir->CurrentValue, 0), NULL, strval($this->tanggal_lahir->CurrentValue) == "");

		// jenis_kelamin
		$this->jenis_kelamin->SetDbValueDef($rsnew, $this->jenis_kelamin->CurrentValue, NULL, FALSE);

		// status_perkawinan
		$this->status_perkawinan->SetDbValueDef($rsnew, $this->status_perkawinan->CurrentValue, NULL, FALSE);

		// agama
		$this->agama->SetDbValueDef($rsnew, $this->agama->CurrentValue, NULL, FALSE);

		// nama_bank
		$this->nama_bank->SetDbValueDef($rsnew, $this->nama_bank->CurrentValue, NULL, FALSE);

		// no_rekening
		$this->no_rekening->SetDbValueDef($rsnew, $this->no_rekening->CurrentValue, NULL, FALSE);

		// change_date
		$this->change_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->change_date->CurrentValue, 0), NULL, FALSE);

		// change_by
		$this->change_by->SetDbValueDef($rsnew, $this->change_by->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("userslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($users_add)) $users_add = new cusers_add();

// Page init
$users_add->Page_Init();

// Page main
$users_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fusersadd = new ew_Form("fusersadd", "add");

// Validate form
fusersadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_username");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->username->FldCaption(), $users->username->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_password");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->password->FldCaption(), $users->password->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_user_group");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->user_group->FldCaption(), $users->user_group->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_user_group");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->user_group->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->status->FldCaption(), $users->status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->status->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tanggal_lahir");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->tanggal_lahir->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_change_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->change_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_change_by");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->change_by->FldCaption(), $users->change_by->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fusersadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fusersadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $users_add->ShowPageHeader(); ?>
<?php
$users_add->ShowMessage();
?>
<form name="fusersadd" id="fusersadd" class="<?php echo $users_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($users_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $users_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($users_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($users->nama_pegawai->Visible) { // nama_pegawai ?>
	<div id="r_nama_pegawai" class="form-group">
		<label id="elh_users_nama_pegawai" for="x_nama_pegawai" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->nama_pegawai->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->nama_pegawai->CellAttributes() ?>>
<span id="el_users_nama_pegawai">
<input type="text" data-table="users" data-field="x_nama_pegawai" name="x_nama_pegawai" id="x_nama_pegawai" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($users->nama_pegawai->getPlaceHolder()) ?>" value="<?php echo $users->nama_pegawai->EditValue ?>"<?php echo $users->nama_pegawai->EditAttributes() ?>>
</span>
<?php echo $users->nama_pegawai->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->username->Visible) { // username ?>
	<div id="r_username" class="form-group">
		<label id="elh_users_username" for="x_username" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->username->CellAttributes() ?>>
<span id="el_users_username">
<input type="text" data-table="users" data-field="x_username" name="x_username" id="x_username" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($users->username->getPlaceHolder()) ?>" value="<?php echo $users->username->EditValue ?>"<?php echo $users->username->EditAttributes() ?>>
</span>
<?php echo $users->username->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->kode_unit_organisasi->Visible) { // kode_unit_organisasi ?>
	<div id="r_kode_unit_organisasi" class="form-group">
		<label id="elh_users_kode_unit_organisasi" for="x_kode_unit_organisasi" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->kode_unit_organisasi->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->kode_unit_organisasi->CellAttributes() ?>>
<span id="el_users_kode_unit_organisasi">
<input type="text" data-table="users" data-field="x_kode_unit_organisasi" name="x_kode_unit_organisasi" id="x_kode_unit_organisasi" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($users->kode_unit_organisasi->getPlaceHolder()) ?>" value="<?php echo $users->kode_unit_organisasi->EditValue ?>"<?php echo $users->kode_unit_organisasi->EditAttributes() ?>>
</span>
<?php echo $users->kode_unit_organisasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->kode_unit_kerja->Visible) { // kode_unit_kerja ?>
	<div id="r_kode_unit_kerja" class="form-group">
		<label id="elh_users_kode_unit_kerja" for="x_kode_unit_kerja" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->kode_unit_kerja->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->kode_unit_kerja->CellAttributes() ?>>
<span id="el_users_kode_unit_kerja">
<input type="text" data-table="users" data-field="x_kode_unit_kerja" name="x_kode_unit_kerja" id="x_kode_unit_kerja" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($users->kode_unit_kerja->getPlaceHolder()) ?>" value="<?php echo $users->kode_unit_kerja->EditValue ?>"<?php echo $users->kode_unit_kerja->EditAttributes() ?>>
</span>
<?php echo $users->kode_unit_kerja->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->jabatan->Visible) { // jabatan ?>
	<div id="r_jabatan" class="form-group">
		<label id="elh_users_jabatan" for="x_jabatan" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->jabatan->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->jabatan->CellAttributes() ?>>
<span id="el_users_jabatan">
<input type="text" data-table="users" data-field="x_jabatan" name="x_jabatan" id="x_jabatan" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($users->jabatan->getPlaceHolder()) ?>" value="<?php echo $users->jabatan->EditValue ?>"<?php echo $users->jabatan->EditAttributes() ?>>
</span>
<?php echo $users->jabatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->password->Visible) { // password ?>
	<div id="r_password" class="form-group">
		<label id="elh_users_password" for="x_password" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->password->CellAttributes() ?>>
<span id="el_users_password">
<textarea data-table="users" data-field="x_password" name="x_password" id="x_password" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($users->password->getPlaceHolder()) ?>"<?php echo $users->password->EditAttributes() ?>><?php echo $users->password->EditValue ?></textarea>
</span>
<?php echo $users->password->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->user_group->Visible) { // user_group ?>
	<div id="r_user_group" class="form-group">
		<label id="elh_users_user_group" for="x_user_group" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->user_group->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->user_group->CellAttributes() ?>>
<span id="el_users_user_group">
<input type="text" data-table="users" data-field="x_user_group" name="x_user_group" id="x_user_group" size="30" placeholder="<?php echo ew_HtmlEncode($users->user_group->getPlaceHolder()) ?>" value="<?php echo $users->user_group->EditValue ?>"<?php echo $users->user_group->EditAttributes() ?>>
</span>
<?php echo $users->user_group->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_users_status" for="x_status" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->status->CellAttributes() ?>>
<span id="el_users_status">
<input type="text" data-table="users" data-field="x_status" name="x_status" id="x_status" size="30" placeholder="<?php echo ew_HtmlEncode($users->status->getPlaceHolder()) ?>" value="<?php echo $users->status->EditValue ?>"<?php echo $users->status->EditAttributes() ?>>
</span>
<?php echo $users->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->photo->Visible) { // photo ?>
	<div id="r_photo" class="form-group">
		<label id="elh_users_photo" for="x_photo" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->photo->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->photo->CellAttributes() ?>>
<span id="el_users_photo">
<textarea data-table="users" data-field="x_photo" name="x_photo" id="x_photo" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($users->photo->getPlaceHolder()) ?>"<?php echo $users->photo->EditAttributes() ?>><?php echo $users->photo->EditValue ?></textarea>
</span>
<?php echo $users->photo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->nomor_anggota->Visible) { // nomor_anggota ?>
	<div id="r_nomor_anggota" class="form-group">
		<label id="elh_users_nomor_anggota" for="x_nomor_anggota" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->nomor_anggota->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->nomor_anggota->CellAttributes() ?>>
<span id="el_users_nomor_anggota">
<input type="text" data-table="users" data-field="x_nomor_anggota" name="x_nomor_anggota" id="x_nomor_anggota" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->nomor_anggota->getPlaceHolder()) ?>" value="<?php echo $users->nomor_anggota->EditValue ?>"<?php echo $users->nomor_anggota->EditAttributes() ?>>
</span>
<?php echo $users->nomor_anggota->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->nip->Visible) { // nip ?>
	<div id="r_nip" class="form-group">
		<label id="elh_users_nip" for="x_nip" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->nip->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->nip->CellAttributes() ?>>
<span id="el_users_nip">
<input type="text" data-table="users" data-field="x_nip" name="x_nip" id="x_nip" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->nip->getPlaceHolder()) ?>" value="<?php echo $users->nip->EditValue ?>"<?php echo $users->nip->EditAttributes() ?>>
</span>
<?php echo $users->nip->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->nip_lama->Visible) { // nip_lama ?>
	<div id="r_nip_lama" class="form-group">
		<label id="elh_users_nip_lama" for="x_nip_lama" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->nip_lama->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->nip_lama->CellAttributes() ?>>
<span id="el_users_nip_lama">
<input type="text" data-table="users" data-field="x_nip_lama" name="x_nip_lama" id="x_nip_lama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->nip_lama->getPlaceHolder()) ?>" value="<?php echo $users->nip_lama->EditValue ?>"<?php echo $users->nip_lama->EditAttributes() ?>>
</span>
<?php echo $users->nip_lama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->gelar_depan->Visible) { // gelar_depan ?>
	<div id="r_gelar_depan" class="form-group">
		<label id="elh_users_gelar_depan" for="x_gelar_depan" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->gelar_depan->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->gelar_depan->CellAttributes() ?>>
<span id="el_users_gelar_depan">
<input type="text" data-table="users" data-field="x_gelar_depan" name="x_gelar_depan" id="x_gelar_depan" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($users->gelar_depan->getPlaceHolder()) ?>" value="<?php echo $users->gelar_depan->EditValue ?>"<?php echo $users->gelar_depan->EditAttributes() ?>>
</span>
<?php echo $users->gelar_depan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->gelar_belakang->Visible) { // gelar_belakang ?>
	<div id="r_gelar_belakang" class="form-group">
		<label id="elh_users_gelar_belakang" for="x_gelar_belakang" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->gelar_belakang->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->gelar_belakang->CellAttributes() ?>>
<span id="el_users_gelar_belakang">
<input type="text" data-table="users" data-field="x_gelar_belakang" name="x_gelar_belakang" id="x_gelar_belakang" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($users->gelar_belakang->getPlaceHolder()) ?>" value="<?php echo $users->gelar_belakang->EditValue ?>"<?php echo $users->gelar_belakang->EditAttributes() ?>>
</span>
<?php echo $users->gelar_belakang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->pendidikan_terakhir->Visible) { // pendidikan_terakhir ?>
	<div id="r_pendidikan_terakhir" class="form-group">
		<label id="elh_users_pendidikan_terakhir" for="x_pendidikan_terakhir" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->pendidikan_terakhir->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->pendidikan_terakhir->CellAttributes() ?>>
<span id="el_users_pendidikan_terakhir">
<input type="text" data-table="users" data-field="x_pendidikan_terakhir" name="x_pendidikan_terakhir" id="x_pendidikan_terakhir" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($users->pendidikan_terakhir->getPlaceHolder()) ?>" value="<?php echo $users->pendidikan_terakhir->EditValue ?>"<?php echo $users->pendidikan_terakhir->EditAttributes() ?>>
</span>
<?php echo $users->pendidikan_terakhir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->nama_lembaga->Visible) { // nama_lembaga ?>
	<div id="r_nama_lembaga" class="form-group">
		<label id="elh_users_nama_lembaga" for="x_nama_lembaga" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->nama_lembaga->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->nama_lembaga->CellAttributes() ?>>
<span id="el_users_nama_lembaga">
<input type="text" data-table="users" data-field="x_nama_lembaga" name="x_nama_lembaga" id="x_nama_lembaga" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($users->nama_lembaga->getPlaceHolder()) ?>" value="<?php echo $users->nama_lembaga->EditValue ?>"<?php echo $users->nama_lembaga->EditAttributes() ?>>
</span>
<?php echo $users->nama_lembaga->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->warga_negara->Visible) { // warga_negara ?>
	<div id="r_warga_negara" class="form-group">
		<label id="elh_users_warga_negara" for="x_warga_negara" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->warga_negara->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->warga_negara->CellAttributes() ?>>
<span id="el_users_warga_negara">
<input type="text" data-table="users" data-field="x_warga_negara" name="x_warga_negara" id="x_warga_negara" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->warga_negara->getPlaceHolder()) ?>" value="<?php echo $users->warga_negara->EditValue ?>"<?php echo $users->warga_negara->EditAttributes() ?>>
</span>
<?php echo $users->warga_negara->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->tempat_lahir->Visible) { // tempat_lahir ?>
	<div id="r_tempat_lahir" class="form-group">
		<label id="elh_users_tempat_lahir" for="x_tempat_lahir" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->tempat_lahir->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->tempat_lahir->CellAttributes() ?>>
<span id="el_users_tempat_lahir">
<input type="text" data-table="users" data-field="x_tempat_lahir" name="x_tempat_lahir" id="x_tempat_lahir" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->tempat_lahir->getPlaceHolder()) ?>" value="<?php echo $users->tempat_lahir->EditValue ?>"<?php echo $users->tempat_lahir->EditAttributes() ?>>
</span>
<?php echo $users->tempat_lahir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->tanggal_lahir->Visible) { // tanggal_lahir ?>
	<div id="r_tanggal_lahir" class="form-group">
		<label id="elh_users_tanggal_lahir" for="x_tanggal_lahir" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->tanggal_lahir->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->tanggal_lahir->CellAttributes() ?>>
<span id="el_users_tanggal_lahir">
<input type="text" data-table="users" data-field="x_tanggal_lahir" name="x_tanggal_lahir" id="x_tanggal_lahir" placeholder="<?php echo ew_HtmlEncode($users->tanggal_lahir->getPlaceHolder()) ?>" value="<?php echo $users->tanggal_lahir->EditValue ?>"<?php echo $users->tanggal_lahir->EditAttributes() ?>>
</span>
<?php echo $users->tanggal_lahir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->jenis_kelamin->Visible) { // jenis_kelamin ?>
	<div id="r_jenis_kelamin" class="form-group">
		<label id="elh_users_jenis_kelamin" for="x_jenis_kelamin" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->jenis_kelamin->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->jenis_kelamin->CellAttributes() ?>>
<span id="el_users_jenis_kelamin">
<input type="text" data-table="users" data-field="x_jenis_kelamin" name="x_jenis_kelamin" id="x_jenis_kelamin" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($users->jenis_kelamin->getPlaceHolder()) ?>" value="<?php echo $users->jenis_kelamin->EditValue ?>"<?php echo $users->jenis_kelamin->EditAttributes() ?>>
</span>
<?php echo $users->jenis_kelamin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->status_perkawinan->Visible) { // status_perkawinan ?>
	<div id="r_status_perkawinan" class="form-group">
		<label id="elh_users_status_perkawinan" for="x_status_perkawinan" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->status_perkawinan->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->status_perkawinan->CellAttributes() ?>>
<span id="el_users_status_perkawinan">
<input type="text" data-table="users" data-field="x_status_perkawinan" name="x_status_perkawinan" id="x_status_perkawinan" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($users->status_perkawinan->getPlaceHolder()) ?>" value="<?php echo $users->status_perkawinan->EditValue ?>"<?php echo $users->status_perkawinan->EditAttributes() ?>>
</span>
<?php echo $users->status_perkawinan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->agama->Visible) { // agama ?>
	<div id="r_agama" class="form-group">
		<label id="elh_users_agama" for="x_agama" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->agama->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->agama->CellAttributes() ?>>
<span id="el_users_agama">
<input type="text" data-table="users" data-field="x_agama" name="x_agama" id="x_agama" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($users->agama->getPlaceHolder()) ?>" value="<?php echo $users->agama->EditValue ?>"<?php echo $users->agama->EditAttributes() ?>>
</span>
<?php echo $users->agama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->nama_bank->Visible) { // nama_bank ?>
	<div id="r_nama_bank" class="form-group">
		<label id="elh_users_nama_bank" for="x_nama_bank" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->nama_bank->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->nama_bank->CellAttributes() ?>>
<span id="el_users_nama_bank">
<input type="text" data-table="users" data-field="x_nama_bank" name="x_nama_bank" id="x_nama_bank" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($users->nama_bank->getPlaceHolder()) ?>" value="<?php echo $users->nama_bank->EditValue ?>"<?php echo $users->nama_bank->EditAttributes() ?>>
</span>
<?php echo $users->nama_bank->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->no_rekening->Visible) { // no_rekening ?>
	<div id="r_no_rekening" class="form-group">
		<label id="elh_users_no_rekening" for="x_no_rekening" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->no_rekening->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->no_rekening->CellAttributes() ?>>
<span id="el_users_no_rekening">
<input type="text" data-table="users" data-field="x_no_rekening" name="x_no_rekening" id="x_no_rekening" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($users->no_rekening->getPlaceHolder()) ?>" value="<?php echo $users->no_rekening->EditValue ?>"<?php echo $users->no_rekening->EditAttributes() ?>>
</span>
<?php echo $users->no_rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->change_date->Visible) { // change_date ?>
	<div id="r_change_date" class="form-group">
		<label id="elh_users_change_date" for="x_change_date" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->change_date->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->change_date->CellAttributes() ?>>
<span id="el_users_change_date">
<input type="text" data-table="users" data-field="x_change_date" name="x_change_date" id="x_change_date" placeholder="<?php echo ew_HtmlEncode($users->change_date->getPlaceHolder()) ?>" value="<?php echo $users->change_date->EditValue ?>"<?php echo $users->change_date->EditAttributes() ?>>
</span>
<?php echo $users->change_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->change_by->Visible) { // change_by ?>
	<div id="r_change_by" class="form-group">
		<label id="elh_users_change_by" for="x_change_by" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->change_by->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->change_by->CellAttributes() ?>>
<span id="el_users_change_by">
<input type="text" data-table="users" data-field="x_change_by" name="x_change_by" id="x_change_by" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($users->change_by->getPlaceHolder()) ?>" value="<?php echo $users->change_by->EditValue ?>"<?php echo $users->change_by->EditAttributes() ?>>
</span>
<?php echo $users->change_by->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$users_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $users_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $users_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fusersadd.Init();
</script>
<?php
$users_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$users_add->Page_Terminate();
?>
