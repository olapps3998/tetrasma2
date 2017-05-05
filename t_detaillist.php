<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_detailinfo.php" ?>
<?php include_once "t_userinfo.php" ?>
<?php include_once "t_jurnalinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_detail_list = NULL; // Initialize page object first

class ct_detail_list extends ct_detail {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{BD598998-6524-4166-9FBE-52F174C8EABD}";

	// Table name
	var $TableName = 't_detail';

	// Page object name
	var $PageObjName = 't_detail_list';

	// Grid form hidden field names
	var $FormName = 'ft_detaillist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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
		if (!$this->CheckToken || !ew_IsHttpPost())
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
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t_detail)
		if (!isset($GLOBALS["t_detail"]) || get_class($GLOBALS["t_detail"]) == "ct_detail") {
			$GLOBALS["t_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_detail"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t_detailadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t_detaildelete.php";
		$this->MultiUpdateUrl = "t_detailupdate.php";

		// Table object (t_user)
		if (!isset($GLOBALS['t_user'])) $GLOBALS['t_user'] = new ct_user();

		// Table object (t_jurnal)
		if (!isset($GLOBALS['t_jurnal'])) $GLOBALS['t_jurnal'] = new ct_jurnal();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_detail', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (t_user)
		if (!isset($UserTable)) {
			$UserTable = new ct_user();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption ft_detaillistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Create form object
		$objForm = new cFormObj();

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->jurnal_id->SetVisibility();
		$this->coa_id->SetVisibility();
		$this->debet->SetVisibility();
		$this->kredit->SetVisibility();
		$this->anggota_id->SetVisibility();

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

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
		global $EW_EXPORT, $t_detail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_detail);
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
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "t_jurnal") {
			global $t_jurnal;
			$rsmaster = $t_jurnal->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("t_jurnallist.php"); // Return to master page
			} else {
				$t_jurnal->LoadListRowValues($rsmaster);
				$t_jurnal->RowType = EW_ROWTYPE_MASTER; // Master row
				$t_jurnal->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 20; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	//  Exit inline mode
	function ClearInlineMode() {
		$this->setKey("detail_id", ""); // Clear inline edit key
		$this->debet->FormValue = ""; // Clear form value
		$this->kredit->FormValue = ""; // Clear form value
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (@$_GET["detail_id"] <> "") {
			$this->detail_id->setQueryStringValue($_GET["detail_id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("detail_id", $this->detail_id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("detail_id")) <> strval($this->detail_id->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		if ($this->CurrentAction == "copy") {
			if (@$_GET["detail_id"] <> "") {
				$this->detail_id->setQueryStringValue($_GET["detail_id"]);
				$this->setKey("detail_id", $this->detail_id->CurrentValue); // Set up key
			} else {
				$this->setKey("detail_id", ""); // Clear key
				$this->CurrentAction = "add";
			}
		}
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old recordset
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->detail_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->detail_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertBegin")); // Batch insert begin
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->detail_id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertSuccess")); // Batch insert success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertRollback")); // Batch insert rollback
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_jurnal_id") && $objForm->HasValue("o_jurnal_id") && $this->jurnal_id->CurrentValue <> $this->jurnal_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_coa_id") && $objForm->HasValue("o_coa_id") && $this->coa_id->CurrentValue <> $this->coa_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_debet") && $objForm->HasValue("o_debet") && $this->debet->CurrentValue <> $this->debet->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_kredit") && $objForm->HasValue("o_kredit") && $this->kredit->CurrentValue <> $this->kredit->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_anggota_id") && $objForm->HasValue("o_anggota_id") && $this->anggota_id->CurrentValue <> $this->anggota_id->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->jurnal_id, $bCtrl); // jurnal_id
			$this->UpdateSort($this->coa_id, $bCtrl); // coa_id
			$this->UpdateSort($this->debet, $bCtrl); // debet
			$this->UpdateSort($this->kredit, $bCtrl); // kredit
			$this->UpdateSort($this->anggota_id, $bCtrl); // anggota_id
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->jurnal_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->setSessionOrderByList($sOrderBy);
				$this->jurnal_id->setSort("");
				$this->coa_id->setSort("");
				$this->debet->setSort("");
				$this->kredit->setSort("");
				$this->anggota_id->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// "sequence"
		$item = &$this->ListOptions->Add("sequence");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE; // Always on left
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->detail_id->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineCopyUrl) . "\">" . $Language->Phrase("InlineCopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->detail_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->detail_id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->CanAdd());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.ft_detaillist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft_detaillistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft_detaillistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = FALSE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft_detaillist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
		}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
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

	// Load default values
	function LoadDefaultValues() {
		$this->jurnal_id->CurrentValue = NULL;
		$this->jurnal_id->OldValue = $this->jurnal_id->CurrentValue;
		$this->coa_id->CurrentValue = NULL;
		$this->coa_id->OldValue = $this->coa_id->CurrentValue;
		$this->debet->CurrentValue = NULL;
		$this->debet->OldValue = $this->debet->CurrentValue;
		$this->kredit->CurrentValue = NULL;
		$this->kredit->OldValue = $this->kredit->CurrentValue;
		$this->anggota_id->CurrentValue = NULL;
		$this->anggota_id->OldValue = $this->anggota_id->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->jurnal_id->FldIsDetailKey) {
			$this->jurnal_id->setFormValue($objForm->GetValue("x_jurnal_id"));
		}
		$this->jurnal_id->setOldValue($objForm->GetValue("o_jurnal_id"));
		if (!$this->coa_id->FldIsDetailKey) {
			$this->coa_id->setFormValue($objForm->GetValue("x_coa_id"));
		}
		$this->coa_id->setOldValue($objForm->GetValue("o_coa_id"));
		if (!$this->debet->FldIsDetailKey) {
			$this->debet->setFormValue($objForm->GetValue("x_debet"));
		}
		$this->debet->setOldValue($objForm->GetValue("o_debet"));
		if (!$this->kredit->FldIsDetailKey) {
			$this->kredit->setFormValue($objForm->GetValue("x_kredit"));
		}
		$this->kredit->setOldValue($objForm->GetValue("o_kredit"));
		if (!$this->anggota_id->FldIsDetailKey) {
			$this->anggota_id->setFormValue($objForm->GetValue("x_anggota_id"));
		}
		$this->anggota_id->setOldValue($objForm->GetValue("o_anggota_id"));
		if (!$this->detail_id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->detail_id->setFormValue($objForm->GetValue("x_detail_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->detail_id->CurrentValue = $this->detail_id->FormValue;
		$this->jurnal_id->CurrentValue = $this->jurnal_id->FormValue;
		$this->coa_id->CurrentValue = $this->coa_id->FormValue;
		$this->debet->CurrentValue = $this->debet->FormValue;
		$this->kredit->CurrentValue = $this->kredit->FormValue;
		$this->anggota_id->CurrentValue = $this->anggota_id->FormValue;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderByList())));
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
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->detail_id->setDbValue($rs->fields('detail_id'));
		$this->jurnal_id->setDbValue($rs->fields('jurnal_id'));
		$this->coa_id->setDbValue($rs->fields('coa_id'));
		if (array_key_exists('EV__coa_id', $rs->fields)) {
			$this->coa_id->VirtualValue = $rs->fields('EV__coa_id'); // Set up virtual field value
		} else {
			$this->coa_id->VirtualValue = ""; // Clear value
		}
		$this->debet->setDbValue($rs->fields('debet'));
		$this->kredit->setDbValue($rs->fields('kredit'));
		$this->anggota_id->setDbValue($rs->fields('anggota_id'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->detail_id->DbValue = $row['detail_id'];
		$this->jurnal_id->DbValue = $row['jurnal_id'];
		$this->coa_id->DbValue = $row['coa_id'];
		$this->debet->DbValue = $row['debet'];
		$this->kredit->DbValue = $row['kredit'];
		$this->anggota_id->DbValue = $row['anggota_id'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("detail_id")) <> "")
			$this->detail_id->CurrentValue = $this->getKey("detail_id"); // detail_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Convert decimal values if posted back
		if ($this->debet->FormValue == $this->debet->CurrentValue && is_numeric(ew_StrToFloat($this->debet->CurrentValue)))
			$this->debet->CurrentValue = ew_StrToFloat($this->debet->CurrentValue);

		// Convert decimal values if posted back
		if ($this->kredit->FormValue == $this->kredit->CurrentValue && is_numeric(ew_StrToFloat($this->kredit->CurrentValue)))
			$this->kredit->CurrentValue = ew_StrToFloat($this->kredit->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// detail_id
		// jurnal_id
		// coa_id
		// debet
		// kredit
		// anggota_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// detail_id
		$this->detail_id->ViewValue = $this->detail_id->CurrentValue;
		$this->detail_id->ViewCustomAttributes = "";

		// jurnal_id
		$this->jurnal_id->ViewValue = $this->jurnal_id->CurrentValue;
		$this->jurnal_id->ViewCustomAttributes = "";

		// coa_id
		if ($this->coa_id->VirtualValue <> "") {
			$this->coa_id->ViewValue = $this->coa_id->VirtualValue;
		} else {
		if (strval($this->coa_id->CurrentValue) <> "") {
			$sFilterWrk = "`coal4_id`" . ew_SearchString("=", $this->coa_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `coal4_id`, `coal4_no` AS `DispFld`, `coal4_nm` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_coal4`";
		$sWhereWrk = "";
		$this->coa_id->LookupFilters = array("dx1" => '`coal4_no`', "dx2" => '`coal4_nm`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->coa_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->coa_id->ViewValue = $this->coa_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->coa_id->ViewValue = $this->coa_id->CurrentValue;
			}
		} else {
			$this->coa_id->ViewValue = NULL;
		}
		}
		$this->coa_id->ViewCustomAttributes = "";

		// debet
		$this->debet->ViewValue = $this->debet->CurrentValue;
		$this->debet->ViewCustomAttributes = "";

		// kredit
		$this->kredit->ViewValue = $this->kredit->CurrentValue;
		$this->kredit->ViewCustomAttributes = "";

		// anggota_id
		$this->anggota_id->ViewValue = $this->anggota_id->CurrentValue;
		$this->anggota_id->ViewCustomAttributes = "";

			// jurnal_id
			$this->jurnal_id->LinkCustomAttributes = "";
			$this->jurnal_id->HrefValue = "";
			$this->jurnal_id->TooltipValue = "";

			// coa_id
			$this->coa_id->LinkCustomAttributes = "";
			$this->coa_id->HrefValue = "";
			$this->coa_id->TooltipValue = "";

			// debet
			$this->debet->LinkCustomAttributes = "";
			$this->debet->HrefValue = "";
			$this->debet->TooltipValue = "";

			// kredit
			$this->kredit->LinkCustomAttributes = "";
			$this->kredit->HrefValue = "";
			$this->kredit->TooltipValue = "";

			// anggota_id
			$this->anggota_id->LinkCustomAttributes = "";
			$this->anggota_id->HrefValue = "";
			$this->anggota_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// jurnal_id
			$this->jurnal_id->EditAttrs["class"] = "form-control";
			$this->jurnal_id->EditCustomAttributes = "";
			if ($this->jurnal_id->getSessionValue() <> "") {
				$this->jurnal_id->CurrentValue = $this->jurnal_id->getSessionValue();
				$this->jurnal_id->OldValue = $this->jurnal_id->CurrentValue;
			$this->jurnal_id->ViewValue = $this->jurnal_id->CurrentValue;
			$this->jurnal_id->ViewCustomAttributes = "";
			} else {
			$this->jurnal_id->EditValue = ew_HtmlEncode($this->jurnal_id->CurrentValue);
			$this->jurnal_id->PlaceHolder = ew_RemoveHtml($this->jurnal_id->FldCaption());
			}

			// coa_id
			$this->coa_id->EditCustomAttributes = "";
			if (trim(strval($this->coa_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`coal4_id`" . ew_SearchString("=", $this->coa_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `coal4_id`, `coal4_no` AS `DispFld`, `coal4_nm` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t_coal4`";
			$sWhereWrk = "";
			$this->coa_id->LookupFilters = array("dx1" => '`coal4_no`', "dx2" => '`coal4_nm`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->coa_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->coa_id->ViewValue = $this->coa_id->DisplayValue($arwrk);
			} else {
				$this->coa_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->coa_id->EditValue = $arwrk;

			// debet
			$this->debet->EditAttrs["class"] = "form-control";
			$this->debet->EditCustomAttributes = "";
			$this->debet->EditValue = ew_HtmlEncode($this->debet->CurrentValue);
			$this->debet->PlaceHolder = ew_RemoveHtml($this->debet->FldCaption());
			if (strval($this->debet->EditValue) <> "" && is_numeric($this->debet->EditValue)) {
			$this->debet->EditValue = ew_FormatNumber($this->debet->EditValue, -2, -1, -2, 0);
			$this->debet->OldValue = $this->debet->EditValue;
			}

			// kredit
			$this->kredit->EditAttrs["class"] = "form-control";
			$this->kredit->EditCustomAttributes = "";
			$this->kredit->EditValue = ew_HtmlEncode($this->kredit->CurrentValue);
			$this->kredit->PlaceHolder = ew_RemoveHtml($this->kredit->FldCaption());
			if (strval($this->kredit->EditValue) <> "" && is_numeric($this->kredit->EditValue)) {
			$this->kredit->EditValue = ew_FormatNumber($this->kredit->EditValue, -2, -1, -2, 0);
			$this->kredit->OldValue = $this->kredit->EditValue;
			}

			// anggota_id
			$this->anggota_id->EditAttrs["class"] = "form-control";
			$this->anggota_id->EditCustomAttributes = "";
			$this->anggota_id->EditValue = ew_HtmlEncode($this->anggota_id->CurrentValue);
			$this->anggota_id->PlaceHolder = ew_RemoveHtml($this->anggota_id->FldCaption());

			// Add refer script
			// jurnal_id

			$this->jurnal_id->LinkCustomAttributes = "";
			$this->jurnal_id->HrefValue = "";

			// coa_id
			$this->coa_id->LinkCustomAttributes = "";
			$this->coa_id->HrefValue = "";

			// debet
			$this->debet->LinkCustomAttributes = "";
			$this->debet->HrefValue = "";

			// kredit
			$this->kredit->LinkCustomAttributes = "";
			$this->kredit->HrefValue = "";

			// anggota_id
			$this->anggota_id->LinkCustomAttributes = "";
			$this->anggota_id->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// jurnal_id
			$this->jurnal_id->EditAttrs["class"] = "form-control";
			$this->jurnal_id->EditCustomAttributes = "";
			if ($this->jurnal_id->getSessionValue() <> "") {
				$this->jurnal_id->CurrentValue = $this->jurnal_id->getSessionValue();
				$this->jurnal_id->OldValue = $this->jurnal_id->CurrentValue;
			$this->jurnal_id->ViewValue = $this->jurnal_id->CurrentValue;
			$this->jurnal_id->ViewCustomAttributes = "";
			} else {
			$this->jurnal_id->EditValue = ew_HtmlEncode($this->jurnal_id->CurrentValue);
			$this->jurnal_id->PlaceHolder = ew_RemoveHtml($this->jurnal_id->FldCaption());
			}

			// coa_id
			$this->coa_id->EditCustomAttributes = "";
			if (trim(strval($this->coa_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`coal4_id`" . ew_SearchString("=", $this->coa_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `coal4_id`, `coal4_no` AS `DispFld`, `coal4_nm` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t_coal4`";
			$sWhereWrk = "";
			$this->coa_id->LookupFilters = array("dx1" => '`coal4_no`', "dx2" => '`coal4_nm`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->coa_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->coa_id->ViewValue = $this->coa_id->DisplayValue($arwrk);
			} else {
				$this->coa_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->coa_id->EditValue = $arwrk;

			// debet
			$this->debet->EditAttrs["class"] = "form-control";
			$this->debet->EditCustomAttributes = "";
			$this->debet->EditValue = ew_HtmlEncode($this->debet->CurrentValue);
			$this->debet->PlaceHolder = ew_RemoveHtml($this->debet->FldCaption());
			if (strval($this->debet->EditValue) <> "" && is_numeric($this->debet->EditValue)) {
			$this->debet->EditValue = ew_FormatNumber($this->debet->EditValue, -2, -1, -2, 0);
			$this->debet->OldValue = $this->debet->EditValue;
			}

			// kredit
			$this->kredit->EditAttrs["class"] = "form-control";
			$this->kredit->EditCustomAttributes = "";
			$this->kredit->EditValue = ew_HtmlEncode($this->kredit->CurrentValue);
			$this->kredit->PlaceHolder = ew_RemoveHtml($this->kredit->FldCaption());
			if (strval($this->kredit->EditValue) <> "" && is_numeric($this->kredit->EditValue)) {
			$this->kredit->EditValue = ew_FormatNumber($this->kredit->EditValue, -2, -1, -2, 0);
			$this->kredit->OldValue = $this->kredit->EditValue;
			}

			// anggota_id
			$this->anggota_id->EditAttrs["class"] = "form-control";
			$this->anggota_id->EditCustomAttributes = "";
			$this->anggota_id->EditValue = ew_HtmlEncode($this->anggota_id->CurrentValue);
			$this->anggota_id->PlaceHolder = ew_RemoveHtml($this->anggota_id->FldCaption());

			// Edit refer script
			// jurnal_id

			$this->jurnal_id->LinkCustomAttributes = "";
			$this->jurnal_id->HrefValue = "";

			// coa_id
			$this->coa_id->LinkCustomAttributes = "";
			$this->coa_id->HrefValue = "";

			// debet
			$this->debet->LinkCustomAttributes = "";
			$this->debet->HrefValue = "";

			// kredit
			$this->kredit->LinkCustomAttributes = "";
			$this->kredit->HrefValue = "";

			// anggota_id
			$this->anggota_id->LinkCustomAttributes = "";
			$this->anggota_id->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

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
		if (!$this->jurnal_id->FldIsDetailKey && !is_null($this->jurnal_id->FormValue) && $this->jurnal_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->jurnal_id->FldCaption(), $this->jurnal_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->jurnal_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->jurnal_id->FldErrMsg());
		}
		if (!$this->coa_id->FldIsDetailKey && !is_null($this->coa_id->FormValue) && $this->coa_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->coa_id->FldCaption(), $this->coa_id->ReqErrMsg));
		}
		if (!$this->debet->FldIsDetailKey && !is_null($this->debet->FormValue) && $this->debet->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->debet->FldCaption(), $this->debet->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->debet->FormValue)) {
			ew_AddMessage($gsFormError, $this->debet->FldErrMsg());
		}
		if (!$this->kredit->FldIsDetailKey && !is_null($this->kredit->FormValue) && $this->kredit->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kredit->FldCaption(), $this->kredit->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->kredit->FormValue)) {
			ew_AddMessage($gsFormError, $this->kredit->FldErrMsg());
		}
		if (!ew_CheckInteger($this->anggota_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->anggota_id->FldErrMsg());
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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
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

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

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
				$sThisKey .= $row['detail_id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

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
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// jurnal_id
			$this->jurnal_id->SetDbValueDef($rsnew, $this->jurnal_id->CurrentValue, 0, $this->jurnal_id->ReadOnly);

			// coa_id
			$this->coa_id->SetDbValueDef($rsnew, $this->coa_id->CurrentValue, 0, $this->coa_id->ReadOnly);

			// debet
			$this->debet->SetDbValueDef($rsnew, $this->debet->CurrentValue, 0, $this->debet->ReadOnly);

			// kredit
			$this->kredit->SetDbValueDef($rsnew, $this->kredit->CurrentValue, 0, $this->kredit->ReadOnly);

			// anggota_id
			$this->anggota_id->SetDbValueDef($rsnew, $this->anggota_id->CurrentValue, NULL, $this->anggota_id->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// jurnal_id
		$this->jurnal_id->SetDbValueDef($rsnew, $this->jurnal_id->CurrentValue, 0, FALSE);

		// coa_id
		$this->coa_id->SetDbValueDef($rsnew, $this->coa_id->CurrentValue, 0, FALSE);

		// debet
		$this->debet->SetDbValueDef($rsnew, $this->debet->CurrentValue, 0, FALSE);

		// kredit
		$this->kredit->SetDbValueDef($rsnew, $this->kredit->CurrentValue, 0, FALSE);

		// anggota_id
		$this->anggota_id->SetDbValueDef($rsnew, $this->anggota_id->CurrentValue, NULL, FALSE);

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

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_t_detail\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_t_detail',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ft_detaillist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "t_jurnal") {
			global $t_jurnal;
			if (!isset($t_jurnal)) $t_jurnal = new ct_jurnal;
			$rsmaster = $t_jurnal->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$t_jurnal;
					$t_jurnal->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
					$Doc->Table = &$this;
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		if ($this->Export == "email") {
			echo $this->ExportEmail($Doc->Text);
		} else {
			$Doc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_POST["sender"];
		$sRecipient = @$_POST["recipient"];
		$sCc = @$_POST["cc"];
		$sBcc = @$_POST["bcc"];
		$sContentType = @$_POST["contenttype"];

		// Subject
		$sSubject = ew_StripSlashes(@$_POST["subject"]);
		$sEmailSubject = $sSubject;

		// Message
		$sContent = ew_StripSlashes(@$_POST["message"]);
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterSenderEmail") . "</p>";
		}
		if (!ew_CheckEmail($sSender)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperSenderEmail") . "</p>";
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperRecipientEmail") . "</p>";
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperCcEmail") . "</p>";
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperBccEmail") . "</p>";
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			return "<p class=\"text-danger\">" . $Language->Phrase("ExceedMaxEmailExport") . "</p>";
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		if ($sEmailMessage <> "") {
			$sEmailMessage = ew_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		if ($sContentType == "url") {
			$sUrl = ew_ConvertFullUrl(ew_CurrentPage() . "?" . $this->ExportQueryString());
			$sEmailMessage .= $sUrl; // Send URL only
		} else {
			foreach ($gTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
			$sEmailMessage .= ew_CleanEmailContent($EmailContent); // Send HTML
		}
		$Email->Content = $sEmailMessage; // Content
		$EventArgs = array();
		if ($this->Recordset) {
			$this->RecCnt = $this->StartRec - 1;
			$this->Recordset->MoveFirst();
			if ($this->StartRec > 1)
				$this->Recordset->Move($this->StartRec - 1);
			$EventArgs["rs"] = &$this->Recordset;
		}
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			return "<p class=\"text-success\">" . $Language->Phrase("SendEmailSuccess") . "</p>"; // Set up success message
		} else {

			// Sent email failure
			return "<p class=\"text-danger\">" . $Email->SendErrDescription . "</p>";
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";

		// Build QueryString for search
		// Build QueryString for pager

		$sQry .= "&" . EW_TABLE_REC_PER_PAGE . "=" . urlencode($this->getRecordsPerPage()) . "&" . EW_TABLE_START_REC . "=" . urlencode($this->getStartRecordNumber());
		return $sQry;
	}

	// Add search QueryString
	function AddSearchQueryString(&$Qry, &$Fld) {
		$FldSearchValue = $Fld->AdvancedSearch->getValue("x");
		$FldParm = substr($Fld->FldVar,2);
		if (strval($FldSearchValue) <> "") {
			$Qry .= "&x_" . $FldParm . "=" . urlencode($FldSearchValue) .
				"&z_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("z"));
		}
		$FldSearchValue2 = $Fld->AdvancedSearch->getValue("y");
		if (strval($FldSearchValue2) <> "") {
			$Qry .= "&v_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("v")) .
				"&y_" . $FldParm . "=" . urlencode($FldSearchValue2) .
				"&w_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("w"));
		}
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t_jurnal") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_jurnal_id"] <> "") {
					$GLOBALS["t_jurnal"]->jurnal_id->setQueryStringValue($_GET["fk_jurnal_id"]);
					$this->jurnal_id->setQueryStringValue($GLOBALS["t_jurnal"]->jurnal_id->QueryStringValue);
					$this->jurnal_id->setSessionValue($this->jurnal_id->QueryStringValue);
					if (!is_numeric($GLOBALS["t_jurnal"]->jurnal_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t_jurnal") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_jurnal_id"] <> "") {
					$GLOBALS["t_jurnal"]->jurnal_id->setFormValue($_POST["fk_jurnal_id"]);
					$this->jurnal_id->setFormValue($GLOBALS["t_jurnal"]->jurnal_id->FormValue);
					$this->jurnal_id->setSessionValue($this->jurnal_id->FormValue);
					if (!is_numeric($GLOBALS["t_jurnal"]->jurnal_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t_jurnal") {
				if ($this->jurnal_id->CurrentValue == "") $this->jurnal_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_coa_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `coal4_id` AS `LinkFld`, `coal4_no` AS `DispFld`, `coal4_nm` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_coal4`";
			$sWhereWrk = "{filter}";
			$this->coa_id->LookupFilters = array("dx1" => '`coal4_no`', "dx2" => '`coal4_nm`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`coal4_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->coa_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($t_detail_list)) $t_detail_list = new ct_detail_list();

// Page init
$t_detail_list->Page_Init();

// Page main
$t_detail_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_detail_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($t_detail->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft_detaillist = new ew_Form("ft_detaillist", "list");
ft_detaillist.FormKeyCountName = '<?php echo $t_detail_list->FormKeyCountName ?>';

// Validate form
ft_detaillist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_jurnal_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_detail->jurnal_id->FldCaption(), $t_detail->jurnal_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jurnal_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_detail->jurnal_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_coa_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_detail->coa_id->FldCaption(), $t_detail->coa_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_debet");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_detail->debet->FldCaption(), $t_detail->debet->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_debet");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_detail->debet->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kredit");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_detail->kredit->FldCaption(), $t_detail->kredit->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kredit");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_detail->kredit->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_anggota_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_detail->anggota_id->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
ft_detaillist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "jurnal_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "coa_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "debet", false)) return false;
	if (ew_ValueChanged(fobj, infix, "kredit", false)) return false;
	if (ew_ValueChanged(fobj, infix, "anggota_id", false)) return false;
	return true;
}

// Form_CustomValidate event
ft_detaillist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_detaillist.ValidateRequired = true;
<?php } else { ?>
ft_detaillist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_detaillist.Lists["x_coa_id"] = {"LinkField":"x_coal4_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_coal4_no","x_coal4_nm","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_coal4"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($t_detail->Export == "") { ?>
<div class="ewToolbar">
<?php if ($t_detail->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($t_detail_list->TotalRecs > 0 && $t_detail_list->ExportOptions->Visible()) { ?>
<?php $t_detail_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t_detail->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($t_detail->Export == "") || (EW_EXPORT_MASTER_RECORD && $t_detail->Export == "print")) { ?>
<?php
if ($t_detail_list->DbMasterFilter <> "" && $t_detail->getCurrentMasterTable() == "t_jurnal") {
	if ($t_detail_list->MasterRecordExists) {
?>
<?php include_once "t_jurnalmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($t_detail->CurrentAction == "gridadd") {
	$t_detail->CurrentFilter = "0=1";
	$t_detail_list->StartRec = 1;
	$t_detail_list->DisplayRecs = $t_detail->GridAddRowCount;
	$t_detail_list->TotalRecs = $t_detail_list->DisplayRecs;
	$t_detail_list->StopRec = $t_detail_list->DisplayRecs;
} else {
	$bSelectLimit = $t_detail_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t_detail_list->TotalRecs <= 0)
			$t_detail_list->TotalRecs = $t_detail->SelectRecordCount();
	} else {
		if (!$t_detail_list->Recordset && ($t_detail_list->Recordset = $t_detail_list->LoadRecordset()))
			$t_detail_list->TotalRecs = $t_detail_list->Recordset->RecordCount();
	}
	$t_detail_list->StartRec = 1;
	if ($t_detail_list->DisplayRecs <= 0 || ($t_detail->Export <> "" && $t_detail->ExportAll)) // Display all records
		$t_detail_list->DisplayRecs = $t_detail_list->TotalRecs;
	if (!($t_detail->Export <> "" && $t_detail->ExportAll))
		$t_detail_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t_detail_list->Recordset = $t_detail_list->LoadRecordset($t_detail_list->StartRec-1, $t_detail_list->DisplayRecs);

	// Set no record found message
	if ($t_detail->CurrentAction == "" && $t_detail_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t_detail_list->setWarningMessage(ew_DeniedMsg());
		if ($t_detail_list->SearchWhere == "0=101")
			$t_detail_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t_detail_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t_detail_list->RenderOtherOptions();
?>
<?php $t_detail_list->ShowPageHeader(); ?>
<?php
$t_detail_list->ShowMessage();
?>
<?php if ($t_detail_list->TotalRecs > 0 || $t_detail->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t_detail">
<?php if ($t_detail->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($t_detail->CurrentAction <> "gridadd" && $t_detail->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t_detail_list->Pager)) $t_detail_list->Pager = new cPrevNextPager($t_detail_list->StartRec, $t_detail_list->DisplayRecs, $t_detail_list->TotalRecs) ?>
<?php if ($t_detail_list->Pager->RecordCount > 0 && $t_detail_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t_detail_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t_detail_list->PageUrl() ?>start=<?php echo $t_detail_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t_detail_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t_detail_list->PageUrl() ?>start=<?php echo $t_detail_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t_detail_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t_detail_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t_detail_list->PageUrl() ?>start=<?php echo $t_detail_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t_detail_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t_detail_list->PageUrl() ?>start=<?php echo $t_detail_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t_detail_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t_detail_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t_detail_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $t_detail_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t_detail">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t_detail_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t_detail_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t_detail_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t_detail_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="200"<?php if ($t_detail_list->DisplayRecs == 200) { ?> selected<?php } ?>>200</option>
<option value="ALL"<?php if ($t_detail->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_detail_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ft_detaillist" id="ft_detaillist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_detail_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_detail_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_detail">
<?php if ($t_detail->getCurrentMasterTable() == "t_jurnal" && $t_detail->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t_jurnal">
<input type="hidden" name="fk_jurnal_id" value="<?php echo $t_detail->jurnal_id->getSessionValue() ?>">
<?php } ?>
<div id="gmp_t_detail" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($t_detail_list->TotalRecs > 0 || $t_detail->CurrentAction == "add" || $t_detail->CurrentAction == "copy" || $t_detail->CurrentAction == "gridedit") { ?>
<table id="tbl_t_detaillist" class="table ewTable">
<?php echo $t_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t_detail_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t_detail_list->RenderListOptions();

// Render list options (header, left)
$t_detail_list->ListOptions->Render("header", "left");
?>
<?php if ($t_detail->jurnal_id->Visible) { // jurnal_id ?>
	<?php if ($t_detail->SortUrl($t_detail->jurnal_id) == "") { ?>
		<th data-name="jurnal_id"><div id="elh_t_detail_jurnal_id" class="t_detail_jurnal_id"><div class="ewTableHeaderCaption"><?php echo $t_detail->jurnal_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jurnal_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_detail->SortUrl($t_detail->jurnal_id) ?>',2);"><div id="elh_t_detail_jurnal_id" class="t_detail_jurnal_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_detail->jurnal_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_detail->jurnal_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_detail->jurnal_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_detail->coa_id->Visible) { // coa_id ?>
	<?php if ($t_detail->SortUrl($t_detail->coa_id) == "") { ?>
		<th data-name="coa_id"><div id="elh_t_detail_coa_id" class="t_detail_coa_id"><div class="ewTableHeaderCaption"><?php echo $t_detail->coa_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="coa_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_detail->SortUrl($t_detail->coa_id) ?>',2);"><div id="elh_t_detail_coa_id" class="t_detail_coa_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_detail->coa_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_detail->coa_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_detail->coa_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_detail->debet->Visible) { // debet ?>
	<?php if ($t_detail->SortUrl($t_detail->debet) == "") { ?>
		<th data-name="debet"><div id="elh_t_detail_debet" class="t_detail_debet"><div class="ewTableHeaderCaption"><?php echo $t_detail->debet->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="debet"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_detail->SortUrl($t_detail->debet) ?>',2);"><div id="elh_t_detail_debet" class="t_detail_debet">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_detail->debet->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_detail->debet->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_detail->debet->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_detail->kredit->Visible) { // kredit ?>
	<?php if ($t_detail->SortUrl($t_detail->kredit) == "") { ?>
		<th data-name="kredit"><div id="elh_t_detail_kredit" class="t_detail_kredit"><div class="ewTableHeaderCaption"><?php echo $t_detail->kredit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kredit"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_detail->SortUrl($t_detail->kredit) ?>',2);"><div id="elh_t_detail_kredit" class="t_detail_kredit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_detail->kredit->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_detail->kredit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_detail->kredit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_detail->anggota_id->Visible) { // anggota_id ?>
	<?php if ($t_detail->SortUrl($t_detail->anggota_id) == "") { ?>
		<th data-name="anggota_id"><div id="elh_t_detail_anggota_id" class="t_detail_anggota_id"><div class="ewTableHeaderCaption"><?php echo $t_detail->anggota_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="anggota_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_detail->SortUrl($t_detail->anggota_id) ?>',2);"><div id="elh_t_detail_anggota_id" class="t_detail_anggota_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_detail->anggota_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_detail->anggota_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_detail->anggota_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t_detail_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($t_detail->CurrentAction == "add" || $t_detail->CurrentAction == "copy") {
		$t_detail_list->RowIndex = 0;
		$t_detail_list->KeyCount = $t_detail_list->RowIndex;
		if ($t_detail->CurrentAction == "copy" && !$t_detail_list->LoadRow())
				$t_detail->CurrentAction = "add";
		if ($t_detail->CurrentAction == "add")
			$t_detail_list->LoadDefaultValues();
		if ($t_detail->EventCancelled) // Insert failed
			$t_detail_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$t_detail->ResetAttrs();
		$t_detail->RowAttrs = array_merge($t_detail->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_t_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$t_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t_detail_list->RenderRow();

		// Render list options
		$t_detail_list->RenderListOptions();
		$t_detail_list->StartRowCnt = 0;
?>
	<tr<?php echo $t_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_detail_list->ListOptions->Render("body", "left", $t_detail_list->RowCnt);
?>
	<?php if ($t_detail->jurnal_id->Visible) { // jurnal_id ?>
		<td data-name="jurnal_id">
<?php if ($t_detail->jurnal_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_jurnal_id" class="form-group t_detail_jurnal_id">
<span<?php echo $t_detail->jurnal_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_detail->jurnal_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" name="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($t_detail->jurnal_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_jurnal_id" class="form-group t_detail_jurnal_id">
<input type="text" data-table="t_detail" data-field="x_jurnal_id" name="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" id="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->jurnal_id->getPlaceHolder()) ?>" value="<?php echo $t_detail->jurnal_id->EditValue ?>"<?php echo $t_detail->jurnal_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t_detail" data-field="x_jurnal_id" name="o<?php echo $t_detail_list->RowIndex ?>_jurnal_id" id="o<?php echo $t_detail_list->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($t_detail->jurnal_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_detail->coa_id->Visible) { // coa_id ?>
		<td data-name="coa_id">
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_coa_id" class="form-group t_detail_coa_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_detail_list->RowIndex ?>_coa_id"><?php echo (strval($t_detail->coa_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_detail->coa_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detail->coa_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_detail_list->RowIndex ?>_coa_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_detail" data-field="x_coa_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detail->coa_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_detail_list->RowIndex ?>_coa_id" id="x<?php echo $t_detail_list->RowIndex ?>_coa_id" value="<?php echo $t_detail->coa_id->CurrentValue ?>"<?php echo $t_detail->coa_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_detail_list->RowIndex ?>_coa_id" id="s_x<?php echo $t_detail_list->RowIndex ?>_coa_id" value="<?php echo $t_detail->coa_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t_detail" data-field="x_coa_id" name="o<?php echo $t_detail_list->RowIndex ?>_coa_id" id="o<?php echo $t_detail_list->RowIndex ?>_coa_id" value="<?php echo ew_HtmlEncode($t_detail->coa_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_detail->debet->Visible) { // debet ?>
		<td data-name="debet">
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_debet" class="form-group t_detail_debet">
<input type="text" data-table="t_detail" data-field="x_debet" name="x<?php echo $t_detail_list->RowIndex ?>_debet" id="x<?php echo $t_detail_list->RowIndex ?>_debet" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->debet->getPlaceHolder()) ?>" value="<?php echo $t_detail->debet->EditValue ?>"<?php echo $t_detail->debet->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_debet" name="o<?php echo $t_detail_list->RowIndex ?>_debet" id="o<?php echo $t_detail_list->RowIndex ?>_debet" value="<?php echo ew_HtmlEncode($t_detail->debet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_detail->kredit->Visible) { // kredit ?>
		<td data-name="kredit">
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_kredit" class="form-group t_detail_kredit">
<input type="text" data-table="t_detail" data-field="x_kredit" name="x<?php echo $t_detail_list->RowIndex ?>_kredit" id="x<?php echo $t_detail_list->RowIndex ?>_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->kredit->getPlaceHolder()) ?>" value="<?php echo $t_detail->kredit->EditValue ?>"<?php echo $t_detail->kredit->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_kredit" name="o<?php echo $t_detail_list->RowIndex ?>_kredit" id="o<?php echo $t_detail_list->RowIndex ?>_kredit" value="<?php echo ew_HtmlEncode($t_detail->kredit->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_detail->anggota_id->Visible) { // anggota_id ?>
		<td data-name="anggota_id">
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_anggota_id" class="form-group t_detail_anggota_id">
<input type="text" data-table="t_detail" data-field="x_anggota_id" name="x<?php echo $t_detail_list->RowIndex ?>_anggota_id" id="x<?php echo $t_detail_list->RowIndex ?>_anggota_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->anggota_id->getPlaceHolder()) ?>" value="<?php echo $t_detail->anggota_id->EditValue ?>"<?php echo $t_detail->anggota_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_anggota_id" name="o<?php echo $t_detail_list->RowIndex ?>_anggota_id" id="o<?php echo $t_detail_list->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($t_detail->anggota_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_detail_list->ListOptions->Render("body", "right", $t_detail_list->RowCnt);
?>
<script type="text/javascript">
ft_detaillist.UpdateOpts(<?php echo $t_detail_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($t_detail->ExportAll && $t_detail->Export <> "") {
	$t_detail_list->StopRec = $t_detail_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t_detail_list->TotalRecs > $t_detail_list->StartRec + $t_detail_list->DisplayRecs - 1)
		$t_detail_list->StopRec = $t_detail_list->StartRec + $t_detail_list->DisplayRecs - 1;
	else
		$t_detail_list->StopRec = $t_detail_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t_detail_list->FormKeyCountName) && ($t_detail->CurrentAction == "gridadd" || $t_detail->CurrentAction == "gridedit" || $t_detail->CurrentAction == "F")) {
		$t_detail_list->KeyCount = $objForm->GetValue($t_detail_list->FormKeyCountName);
		$t_detail_list->StopRec = $t_detail_list->StartRec + $t_detail_list->KeyCount - 1;
	}
}
$t_detail_list->RecCnt = $t_detail_list->StartRec - 1;
if ($t_detail_list->Recordset && !$t_detail_list->Recordset->EOF) {
	$t_detail_list->Recordset->MoveFirst();
	$bSelectLimit = $t_detail_list->UseSelectLimit;
	if (!$bSelectLimit && $t_detail_list->StartRec > 1)
		$t_detail_list->Recordset->Move($t_detail_list->StartRec - 1);
} elseif (!$t_detail->AllowAddDeleteRow && $t_detail_list->StopRec == 0) {
	$t_detail_list->StopRec = $t_detail->GridAddRowCount;
}

// Initialize aggregate
$t_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t_detail->ResetAttrs();
$t_detail_list->RenderRow();
$t_detail_list->EditRowCnt = 0;
if ($t_detail->CurrentAction == "edit")
	$t_detail_list->RowIndex = 1;
if ($t_detail->CurrentAction == "gridadd")
	$t_detail_list->RowIndex = 0;
if ($t_detail->CurrentAction == "gridedit")
	$t_detail_list->RowIndex = 0;
while ($t_detail_list->RecCnt < $t_detail_list->StopRec) {
	$t_detail_list->RecCnt++;
	if (intval($t_detail_list->RecCnt) >= intval($t_detail_list->StartRec)) {
		$t_detail_list->RowCnt++;
		if ($t_detail->CurrentAction == "gridadd" || $t_detail->CurrentAction == "gridedit" || $t_detail->CurrentAction == "F") {
			$t_detail_list->RowIndex++;
			$objForm->Index = $t_detail_list->RowIndex;
			if ($objForm->HasValue($t_detail_list->FormActionName))
				$t_detail_list->RowAction = strval($objForm->GetValue($t_detail_list->FormActionName));
			elseif ($t_detail->CurrentAction == "gridadd")
				$t_detail_list->RowAction = "insert";
			else
				$t_detail_list->RowAction = "";
		}

		// Set up key count
		$t_detail_list->KeyCount = $t_detail_list->RowIndex;

		// Init row class and style
		$t_detail->ResetAttrs();
		$t_detail->CssClass = "";
		if ($t_detail->CurrentAction == "gridadd") {
			$t_detail_list->LoadDefaultValues(); // Load default values
		} else {
			$t_detail_list->LoadRowValues($t_detail_list->Recordset); // Load row values
		}
		$t_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t_detail->CurrentAction == "gridadd") // Grid add
			$t_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t_detail->CurrentAction == "gridadd" && $t_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t_detail_list->RestoreCurrentRowFormValues($t_detail_list->RowIndex); // Restore form values
		if ($t_detail->CurrentAction == "edit") {
			if ($t_detail_list->CheckInlineEditKey() && $t_detail_list->EditRowCnt == 0) { // Inline edit
				$t_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($t_detail->CurrentAction == "gridedit") { // Grid edit
			if ($t_detail->EventCancelled) {
				$t_detail_list->RestoreCurrentRowFormValues($t_detail_list->RowIndex); // Restore form values
			}
			if ($t_detail_list->RowAction == "insert")
				$t_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t_detail->CurrentAction == "edit" && $t_detail->RowType == EW_ROWTYPE_EDIT && $t_detail->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$t_detail_list->RestoreFormValues(); // Restore form values
		}
		if ($t_detail->CurrentAction == "gridedit" && ($t_detail->RowType == EW_ROWTYPE_EDIT || $t_detail->RowType == EW_ROWTYPE_ADD) && $t_detail->EventCancelled) // Update failed
			$t_detail_list->RestoreCurrentRowFormValues($t_detail_list->RowIndex); // Restore form values
		if ($t_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t_detail_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$t_detail->RowAttrs = array_merge($t_detail->RowAttrs, array('data-rowindex'=>$t_detail_list->RowCnt, 'id'=>'r' . $t_detail_list->RowCnt . '_t_detail', 'data-rowtype'=>$t_detail->RowType));

		// Render row
		$t_detail_list->RenderRow();

		// Render list options
		$t_detail_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t_detail_list->RowAction <> "delete" && $t_detail_list->RowAction <> "insertdelete" && !($t_detail_list->RowAction == "insert" && $t_detail->CurrentAction == "F" && $t_detail_list->EmptyRow())) {
?>
	<tr<?php echo $t_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_detail_list->ListOptions->Render("body", "left", $t_detail_list->RowCnt);
?>
	<?php if ($t_detail->jurnal_id->Visible) { // jurnal_id ?>
		<td data-name="jurnal_id"<?php echo $t_detail->jurnal_id->CellAttributes() ?>>
<?php if ($t_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t_detail->jurnal_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_jurnal_id" class="form-group t_detail_jurnal_id">
<span<?php echo $t_detail->jurnal_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_detail->jurnal_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" name="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($t_detail->jurnal_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_jurnal_id" class="form-group t_detail_jurnal_id">
<input type="text" data-table="t_detail" data-field="x_jurnal_id" name="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" id="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->jurnal_id->getPlaceHolder()) ?>" value="<?php echo $t_detail->jurnal_id->EditValue ?>"<?php echo $t_detail->jurnal_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t_detail" data-field="x_jurnal_id" name="o<?php echo $t_detail_list->RowIndex ?>_jurnal_id" id="o<?php echo $t_detail_list->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($t_detail->jurnal_id->OldValue) ?>">
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t_detail->jurnal_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_jurnal_id" class="form-group t_detail_jurnal_id">
<span<?php echo $t_detail->jurnal_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_detail->jurnal_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" name="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($t_detail->jurnal_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_jurnal_id" class="form-group t_detail_jurnal_id">
<input type="text" data-table="t_detail" data-field="x_jurnal_id" name="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" id="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->jurnal_id->getPlaceHolder()) ?>" value="<?php echo $t_detail->jurnal_id->EditValue ?>"<?php echo $t_detail->jurnal_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_jurnal_id" class="t_detail_jurnal_id">
<span<?php echo $t_detail->jurnal_id->ViewAttributes() ?>>
<?php echo $t_detail->jurnal_id->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $t_detail_list->PageObjName . "_row_" . $t_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t_detail" data-field="x_detail_id" name="x<?php echo $t_detail_list->RowIndex ?>_detail_id" id="x<?php echo $t_detail_list->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($t_detail->detail_id->CurrentValue) ?>">
<input type="hidden" data-table="t_detail" data-field="x_detail_id" name="o<?php echo $t_detail_list->RowIndex ?>_detail_id" id="o<?php echo $t_detail_list->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($t_detail->detail_id->OldValue) ?>">
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_EDIT || $t_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t_detail" data-field="x_detail_id" name="x<?php echo $t_detail_list->RowIndex ?>_detail_id" id="x<?php echo $t_detail_list->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($t_detail->detail_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t_detail->coa_id->Visible) { // coa_id ?>
		<td data-name="coa_id"<?php echo $t_detail->coa_id->CellAttributes() ?>>
<?php if ($t_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_coa_id" class="form-group t_detail_coa_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_detail_list->RowIndex ?>_coa_id"><?php echo (strval($t_detail->coa_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_detail->coa_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detail->coa_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_detail_list->RowIndex ?>_coa_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_detail" data-field="x_coa_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detail->coa_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_detail_list->RowIndex ?>_coa_id" id="x<?php echo $t_detail_list->RowIndex ?>_coa_id" value="<?php echo $t_detail->coa_id->CurrentValue ?>"<?php echo $t_detail->coa_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_detail_list->RowIndex ?>_coa_id" id="s_x<?php echo $t_detail_list->RowIndex ?>_coa_id" value="<?php echo $t_detail->coa_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t_detail" data-field="x_coa_id" name="o<?php echo $t_detail_list->RowIndex ?>_coa_id" id="o<?php echo $t_detail_list->RowIndex ?>_coa_id" value="<?php echo ew_HtmlEncode($t_detail->coa_id->OldValue) ?>">
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_coa_id" class="form-group t_detail_coa_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_detail_list->RowIndex ?>_coa_id"><?php echo (strval($t_detail->coa_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_detail->coa_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detail->coa_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_detail_list->RowIndex ?>_coa_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_detail" data-field="x_coa_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detail->coa_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_detail_list->RowIndex ?>_coa_id" id="x<?php echo $t_detail_list->RowIndex ?>_coa_id" value="<?php echo $t_detail->coa_id->CurrentValue ?>"<?php echo $t_detail->coa_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_detail_list->RowIndex ?>_coa_id" id="s_x<?php echo $t_detail_list->RowIndex ?>_coa_id" value="<?php echo $t_detail->coa_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_coa_id" class="t_detail_coa_id">
<span<?php echo $t_detail->coa_id->ViewAttributes() ?>>
<?php echo $t_detail->coa_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_detail->debet->Visible) { // debet ?>
		<td data-name="debet"<?php echo $t_detail->debet->CellAttributes() ?>>
<?php if ($t_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_debet" class="form-group t_detail_debet">
<input type="text" data-table="t_detail" data-field="x_debet" name="x<?php echo $t_detail_list->RowIndex ?>_debet" id="x<?php echo $t_detail_list->RowIndex ?>_debet" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->debet->getPlaceHolder()) ?>" value="<?php echo $t_detail->debet->EditValue ?>"<?php echo $t_detail->debet->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_debet" name="o<?php echo $t_detail_list->RowIndex ?>_debet" id="o<?php echo $t_detail_list->RowIndex ?>_debet" value="<?php echo ew_HtmlEncode($t_detail->debet->OldValue) ?>">
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_debet" class="form-group t_detail_debet">
<input type="text" data-table="t_detail" data-field="x_debet" name="x<?php echo $t_detail_list->RowIndex ?>_debet" id="x<?php echo $t_detail_list->RowIndex ?>_debet" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->debet->getPlaceHolder()) ?>" value="<?php echo $t_detail->debet->EditValue ?>"<?php echo $t_detail->debet->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_debet" class="t_detail_debet">
<span<?php echo $t_detail->debet->ViewAttributes() ?>>
<?php echo $t_detail->debet->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_detail->kredit->Visible) { // kredit ?>
		<td data-name="kredit"<?php echo $t_detail->kredit->CellAttributes() ?>>
<?php if ($t_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_kredit" class="form-group t_detail_kredit">
<input type="text" data-table="t_detail" data-field="x_kredit" name="x<?php echo $t_detail_list->RowIndex ?>_kredit" id="x<?php echo $t_detail_list->RowIndex ?>_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->kredit->getPlaceHolder()) ?>" value="<?php echo $t_detail->kredit->EditValue ?>"<?php echo $t_detail->kredit->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_kredit" name="o<?php echo $t_detail_list->RowIndex ?>_kredit" id="o<?php echo $t_detail_list->RowIndex ?>_kredit" value="<?php echo ew_HtmlEncode($t_detail->kredit->OldValue) ?>">
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_kredit" class="form-group t_detail_kredit">
<input type="text" data-table="t_detail" data-field="x_kredit" name="x<?php echo $t_detail_list->RowIndex ?>_kredit" id="x<?php echo $t_detail_list->RowIndex ?>_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->kredit->getPlaceHolder()) ?>" value="<?php echo $t_detail->kredit->EditValue ?>"<?php echo $t_detail->kredit->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_kredit" class="t_detail_kredit">
<span<?php echo $t_detail->kredit->ViewAttributes() ?>>
<?php echo $t_detail->kredit->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_detail->anggota_id->Visible) { // anggota_id ?>
		<td data-name="anggota_id"<?php echo $t_detail->anggota_id->CellAttributes() ?>>
<?php if ($t_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_anggota_id" class="form-group t_detail_anggota_id">
<input type="text" data-table="t_detail" data-field="x_anggota_id" name="x<?php echo $t_detail_list->RowIndex ?>_anggota_id" id="x<?php echo $t_detail_list->RowIndex ?>_anggota_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->anggota_id->getPlaceHolder()) ?>" value="<?php echo $t_detail->anggota_id->EditValue ?>"<?php echo $t_detail->anggota_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_anggota_id" name="o<?php echo $t_detail_list->RowIndex ?>_anggota_id" id="o<?php echo $t_detail_list->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($t_detail->anggota_id->OldValue) ?>">
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_anggota_id" class="form-group t_detail_anggota_id">
<input type="text" data-table="t_detail" data-field="x_anggota_id" name="x<?php echo $t_detail_list->RowIndex ?>_anggota_id" id="x<?php echo $t_detail_list->RowIndex ?>_anggota_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->anggota_id->getPlaceHolder()) ?>" value="<?php echo $t_detail->anggota_id->EditValue ?>"<?php echo $t_detail->anggota_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_detail_list->RowCnt ?>_t_detail_anggota_id" class="t_detail_anggota_id">
<span<?php echo $t_detail->anggota_id->ViewAttributes() ?>>
<?php echo $t_detail->anggota_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_detail_list->ListOptions->Render("body", "right", $t_detail_list->RowCnt);
?>
	</tr>
<?php if ($t_detail->RowType == EW_ROWTYPE_ADD || $t_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft_detaillist.UpdateOpts(<?php echo $t_detail_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t_detail->CurrentAction <> "gridadd")
		if (!$t_detail_list->Recordset->EOF) $t_detail_list->Recordset->MoveNext();
}
?>
<?php
	if ($t_detail->CurrentAction == "gridadd" || $t_detail->CurrentAction == "gridedit") {
		$t_detail_list->RowIndex = '$rowindex$';
		$t_detail_list->LoadDefaultValues();

		// Set row properties
		$t_detail->ResetAttrs();
		$t_detail->RowAttrs = array_merge($t_detail->RowAttrs, array('data-rowindex'=>$t_detail_list->RowIndex, 'id'=>'r0_t_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t_detail->RowAttrs["class"], "ewTemplate");
		$t_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t_detail_list->RenderRow();

		// Render list options
		$t_detail_list->RenderListOptions();
		$t_detail_list->StartRowCnt = 0;
?>
	<tr<?php echo $t_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_detail_list->ListOptions->Render("body", "left", $t_detail_list->RowIndex);
?>
	<?php if ($t_detail->jurnal_id->Visible) { // jurnal_id ?>
		<td data-name="jurnal_id">
<?php if ($t_detail->jurnal_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t_detail_jurnal_id" class="form-group t_detail_jurnal_id">
<span<?php echo $t_detail->jurnal_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_detail->jurnal_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" name="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($t_detail->jurnal_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t_detail_jurnal_id" class="form-group t_detail_jurnal_id">
<input type="text" data-table="t_detail" data-field="x_jurnal_id" name="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" id="x<?php echo $t_detail_list->RowIndex ?>_jurnal_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->jurnal_id->getPlaceHolder()) ?>" value="<?php echo $t_detail->jurnal_id->EditValue ?>"<?php echo $t_detail->jurnal_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t_detail" data-field="x_jurnal_id" name="o<?php echo $t_detail_list->RowIndex ?>_jurnal_id" id="o<?php echo $t_detail_list->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($t_detail->jurnal_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_detail->coa_id->Visible) { // coa_id ?>
		<td data-name="coa_id">
<span id="el$rowindex$_t_detail_coa_id" class="form-group t_detail_coa_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_detail_list->RowIndex ?>_coa_id"><?php echo (strval($t_detail->coa_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_detail->coa_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detail->coa_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_detail_list->RowIndex ?>_coa_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_detail" data-field="x_coa_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detail->coa_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_detail_list->RowIndex ?>_coa_id" id="x<?php echo $t_detail_list->RowIndex ?>_coa_id" value="<?php echo $t_detail->coa_id->CurrentValue ?>"<?php echo $t_detail->coa_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_detail_list->RowIndex ?>_coa_id" id="s_x<?php echo $t_detail_list->RowIndex ?>_coa_id" value="<?php echo $t_detail->coa_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t_detail" data-field="x_coa_id" name="o<?php echo $t_detail_list->RowIndex ?>_coa_id" id="o<?php echo $t_detail_list->RowIndex ?>_coa_id" value="<?php echo ew_HtmlEncode($t_detail->coa_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_detail->debet->Visible) { // debet ?>
		<td data-name="debet">
<span id="el$rowindex$_t_detail_debet" class="form-group t_detail_debet">
<input type="text" data-table="t_detail" data-field="x_debet" name="x<?php echo $t_detail_list->RowIndex ?>_debet" id="x<?php echo $t_detail_list->RowIndex ?>_debet" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->debet->getPlaceHolder()) ?>" value="<?php echo $t_detail->debet->EditValue ?>"<?php echo $t_detail->debet->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_debet" name="o<?php echo $t_detail_list->RowIndex ?>_debet" id="o<?php echo $t_detail_list->RowIndex ?>_debet" value="<?php echo ew_HtmlEncode($t_detail->debet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_detail->kredit->Visible) { // kredit ?>
		<td data-name="kredit">
<span id="el$rowindex$_t_detail_kredit" class="form-group t_detail_kredit">
<input type="text" data-table="t_detail" data-field="x_kredit" name="x<?php echo $t_detail_list->RowIndex ?>_kredit" id="x<?php echo $t_detail_list->RowIndex ?>_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->kredit->getPlaceHolder()) ?>" value="<?php echo $t_detail->kredit->EditValue ?>"<?php echo $t_detail->kredit->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_kredit" name="o<?php echo $t_detail_list->RowIndex ?>_kredit" id="o<?php echo $t_detail_list->RowIndex ?>_kredit" value="<?php echo ew_HtmlEncode($t_detail->kredit->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_detail->anggota_id->Visible) { // anggota_id ?>
		<td data-name="anggota_id">
<span id="el$rowindex$_t_detail_anggota_id" class="form-group t_detail_anggota_id">
<input type="text" data-table="t_detail" data-field="x_anggota_id" name="x<?php echo $t_detail_list->RowIndex ?>_anggota_id" id="x<?php echo $t_detail_list->RowIndex ?>_anggota_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->anggota_id->getPlaceHolder()) ?>" value="<?php echo $t_detail->anggota_id->EditValue ?>"<?php echo $t_detail->anggota_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_detail" data-field="x_anggota_id" name="o<?php echo $t_detail_list->RowIndex ?>_anggota_id" id="o<?php echo $t_detail_list->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($t_detail->anggota_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_detail_list->ListOptions->Render("body", "right", $t_detail_list->RowCnt);
?>
<script type="text/javascript">
ft_detaillist.UpdateOpts(<?php echo $t_detail_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t_detail->CurrentAction == "add" || $t_detail->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $t_detail_list->FormKeyCountName ?>" id="<?php echo $t_detail_list->FormKeyCountName ?>" value="<?php echo $t_detail_list->KeyCount ?>">
<?php } ?>
<?php if ($t_detail->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t_detail_list->FormKeyCountName ?>" id="<?php echo $t_detail_list->FormKeyCountName ?>" value="<?php echo $t_detail_list->KeyCount ?>">
<?php echo $t_detail_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t_detail->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $t_detail_list->FormKeyCountName ?>" id="<?php echo $t_detail_list->FormKeyCountName ?>" value="<?php echo $t_detail_list->KeyCount ?>">
<?php } ?>
<?php if ($t_detail->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t_detail_list->FormKeyCountName ?>" id="<?php echo $t_detail_list->FormKeyCountName ?>" value="<?php echo $t_detail_list->KeyCount ?>">
<?php echo $t_detail_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t_detail->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t_detail_list->Recordset)
	$t_detail_list->Recordset->Close();
?>
<?php if ($t_detail->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($t_detail->CurrentAction <> "gridadd" && $t_detail->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t_detail_list->Pager)) $t_detail_list->Pager = new cPrevNextPager($t_detail_list->StartRec, $t_detail_list->DisplayRecs, $t_detail_list->TotalRecs) ?>
<?php if ($t_detail_list->Pager->RecordCount > 0 && $t_detail_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t_detail_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t_detail_list->PageUrl() ?>start=<?php echo $t_detail_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t_detail_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t_detail_list->PageUrl() ?>start=<?php echo $t_detail_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t_detail_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t_detail_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t_detail_list->PageUrl() ?>start=<?php echo $t_detail_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t_detail_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t_detail_list->PageUrl() ?>start=<?php echo $t_detail_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t_detail_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t_detail_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t_detail_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $t_detail_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t_detail">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t_detail_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t_detail_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t_detail_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t_detail_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="200"<?php if ($t_detail_list->DisplayRecs == 200) { ?> selected<?php } ?>>200</option>
<option value="ALL"<?php if ($t_detail->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_detail_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($t_detail_list->TotalRecs == 0 && $t_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_detail_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t_detail->Export == "") { ?>
<script type="text/javascript">
ft_detaillist.Init();
</script>
<?php } ?>
<?php
$t_detail_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($t_detail->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$t_detail_list->Page_Terminate();
?>
