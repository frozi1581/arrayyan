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

$personal_signature_blobview = NULL; // Initialize page object first

class cpersonal_signature_blobview extends cpersonal {

	// Page ID
	var $PageID = 'blobview';

	// Project ID
	var $ProjectID = '{8F16C616-6AD2-4381-B7F6-A784BA58350F}';

	// Page object name
	var $PageObjName = 'personal_signature_blobview';

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
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		return $PageUrl;
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

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'blobview', TRUE);

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
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();
		ob_clean(); // Clear output

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

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
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
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {

		// Get key
		if (@$_GET["employee_id"] <> "") {
			$this->employee_id->setQueryStringValue($_GET["employee_id"]);
		} else {
			$this->Page_Terminate(); // Exit
			exit();
		}
		$fld = $this->fields["signature"];
		$objBinary = new cUpload($fld);

		// Show thumbnail
		$bShowThumbnail = (@$_GET["showthumbnail"] == "1");
		if (@$_GET["thumbnailwidth"] == "" && @$_GET["thumbnailheight"] == "") {
			$iThumbnailWidth = EW_THUMBNAIL_DEFAULT_WIDTH; // Set default width
			$iThumbnailHeight = EW_THUMBNAIL_DEFAULT_HEIGHT; // Set default height
		} else {
			if (@$_GET["thumbnailwidth"] <> "") {
				$iThumbnailWidth = $_GET["thumbnailwidth"];
				if (!is_numeric($iThumbnailWidth) || $iThumbnailWidth < 0) $iThumbnailWidth = 0;
			}
			if (@$_GET["thumbnailheight"] <> "") {
				$iThumbnailHeight = $_GET["thumbnailheight"];
				if (!is_numeric($iThumbnailHeight) || $iThumbnailHeight < 0) $iThumbnailHeight = 0;
			}
		}
		$sFilter = $this->KeyFilter();

		// Set up filter (SQL WHERE clause) and get return SQL
		// SQL constructor in personal class, personalinfo.php

		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($this->Recordset = $conn->Execute($sSql)) {
			if (!$this->Recordset->EOF) {
				if (ob_get_length())
					ob_end_clean();
				$objBinary->Value = $this->Recordset->fields('signature');
				$objBinary->Value = $objBinary->Value;
				if ($bShowThumbnail)
					ew_ResizeBinary($objBinary->Value, $iThumbnailWidth, $iThumbnailHeight);
				$data = $objBinary->Value;
				if (!ew_ContainsStr(ew_ServerVar("HTTP_USER_AGENT"), "MSIE"))
					header("Content-type: " . ew_ContentType(substr($data, 0, 11)));
				if (ew_StartsStr("PK", $data) && ew_ContainsStr($data, "[Content_Types].xml") &&
					ew_ContainsStr($data, "_rels") && ew_ContainsStr($data, "docProps")) { // Fix Office 2007 documents
					if (!ew_EndsStr("\0\0\0\0", $data))
						$data .= "\0\0\0\0";
				}
				echo $data;
			}
			$this->Recordset->Close();
		}
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($personal_signature_blobview)) $personal_signature_blobview = new cpersonal_signature_blobview();

// Page init
$personal_signature_blobview->Page_Init();

// Page main
$personal_signature_blobview->Page_Main();
?>
<?php
$personal_signature_blobview->Page_Terminate();
?>
