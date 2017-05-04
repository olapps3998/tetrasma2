<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_coal3info.php" ?>
<?php include_once "t_coal2info.php" ?>
<?php include_once "t_userinfo.php" ?>
<?php include_once "t_coal4gridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_coal3_edit = NULL; // Initialize page object first

class ct_coal3_edit extends ct_coal3 {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{BD598998-6524-4166-9FBE-52F174C8EABD}";

	// Table name
	var $TableName = 't_coal3';

	// Page object name
	var $PageObjName = 't_coal3_edit';

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

		// Table object (t_coal3)
		if (!isset($GLOBALS["t_coal3"]) || get_class($GLOBALS["t_coal3"]) == "ct_coal3") {
			$GLOBALS["t_coal3"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_coal3"];
		}

		// Table object (t_coal2)
		if (!isset($GLOBALS['t_coal2'])) $GLOBALS['t_coal2'] = new ct_coal2();

		// Table object (t_user)
		if (!isset($GLOBALS['t_user'])) $GLOBALS['t_user'] = new ct_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_coal3', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (t_user)
		if (!isset($UserTable)) {
			$UserTable = new ct_user();
			$UserTableConn = Conn($UserTable->DBID);
		}
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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("t_coal3list.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->coal1_id->SetVisibility();
		$this->coal2_id->SetVisibility();
		$this->coal3_no->SetVisibility();
		$this->coal3_nm->SetVisibility();

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

			// Process auto fill for detail table 't_coal4'
			if (@$_POST["grid"] == "ft_coal4grid") {
				if (!isset($GLOBALS["t_coal4_grid"])) $GLOBALS["t_coal4_grid"] = new ct_coal4_grid;
				$GLOBALS["t_coal4_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $t_coal3;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_coal3);
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
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Load key from QueryString
		if (@$_GET["coal3_id"] <> "") {
			$this->coal3_id->setQueryStringValue($_GET["coal3_id"]);
			$this->RecKey["coal3_id"] = $this->coal3_id->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("t_coal3list.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->coal3_id->CurrentValue) == strval($this->Recordset->fields('coal3_id'))) {
					$this->setStartRecordNumber($this->StartRec); // Save record position
					$bMatchRecord = TRUE;
					break;
				} else {
					$this->StartRec++;
					$this->Recordset->MoveNext();
				}
			}
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$bMatchRecord) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("t_coal3list.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t_coal3list.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed

					// Set up detail parameters
					$this->SetUpDetailParms();
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->coal1_id->FldIsDetailKey) {
			$this->coal1_id->setFormValue($objForm->GetValue("x_coal1_id"));
		}
		if (!$this->coal2_id->FldIsDetailKey) {
			$this->coal2_id->setFormValue($objForm->GetValue("x_coal2_id"));
		}
		if (!$this->coal3_no->FldIsDetailKey) {
			$this->coal3_no->setFormValue($objForm->GetValue("x_coal3_no"));
		}
		if (!$this->coal3_nm->FldIsDetailKey) {
			$this->coal3_nm->setFormValue($objForm->GetValue("x_coal3_nm"));
		}
		if (!$this->coal3_id->FldIsDetailKey)
			$this->coal3_id->setFormValue($objForm->GetValue("x_coal3_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->coal3_id->CurrentValue = $this->coal3_id->FormValue;
		$this->coal1_id->CurrentValue = $this->coal1_id->FormValue;
		$this->coal2_id->CurrentValue = $this->coal2_id->FormValue;
		$this->coal3_no->CurrentValue = $this->coal3_no->FormValue;
		$this->coal3_nm->CurrentValue = $this->coal3_nm->FormValue;
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
		$this->coal3_id->setDbValue($rs->fields('coal3_id'));
		$this->coal1_id->setDbValue($rs->fields('coal1_id'));
		if (array_key_exists('EV__coal1_id', $rs->fields)) {
			$this->coal1_id->VirtualValue = $rs->fields('EV__coal1_id'); // Set up virtual field value
		} else {
			$this->coal1_id->VirtualValue = ""; // Clear value
		}
		$this->coal2_id->setDbValue($rs->fields('coal2_id'));
		if (array_key_exists('EV__coal2_id', $rs->fields)) {
			$this->coal2_id->VirtualValue = $rs->fields('EV__coal2_id'); // Set up virtual field value
		} else {
			$this->coal2_id->VirtualValue = ""; // Clear value
		}
		$this->coal3_no->setDbValue($rs->fields('coal3_no'));
		$this->coal3_nm->setDbValue($rs->fields('coal3_nm'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->coal3_id->DbValue = $row['coal3_id'];
		$this->coal1_id->DbValue = $row['coal1_id'];
		$this->coal2_id->DbValue = $row['coal2_id'];
		$this->coal3_no->DbValue = $row['coal3_no'];
		$this->coal3_nm->DbValue = $row['coal3_nm'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// coal3_id
		// coal1_id
		// coal2_id
		// coal3_no
		// coal3_nm

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// coal3_id
		$this->coal3_id->ViewValue = $this->coal3_id->CurrentValue;
		$this->coal3_id->ViewCustomAttributes = "";

		// coal1_id
		if ($this->coal1_id->VirtualValue <> "") {
			$this->coal1_id->ViewValue = $this->coal1_id->VirtualValue;
		} else {
		if (strval($this->coal1_id->CurrentValue) <> "") {
			$sFilterWrk = "`coal1_id`" . ew_SearchString("=", $this->coal1_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `coal1_id`, `coal1_no` AS `DispFld`, `coal1_nm` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_coal1`";
		$sWhereWrk = "";
		$this->coal1_id->LookupFilters = array("dx1" => '`coal1_no`', "dx2" => '`coal1_nm`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->coal1_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->coal1_id->ViewValue = $this->coal1_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->coal1_id->ViewValue = $this->coal1_id->CurrentValue;
			}
		} else {
			$this->coal1_id->ViewValue = NULL;
		}
		}
		$this->coal1_id->ViewCustomAttributes = "";

		// coal2_id
		if ($this->coal2_id->VirtualValue <> "") {
			$this->coal2_id->ViewValue = $this->coal2_id->VirtualValue;
		} else {
		if (strval($this->coal2_id->CurrentValue) <> "") {
			$sFilterWrk = "`coal2_id`" . ew_SearchString("=", $this->coal2_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `coal2_id`, `coal2_no` AS `DispFld`, `coal2_nm` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_coal2`";
		$sWhereWrk = "";
		$this->coal2_id->LookupFilters = array("dx1" => '`coal2_no`', "dx2" => '`coal2_nm`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->coal2_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->coal2_id->ViewValue = $this->coal2_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->coal2_id->ViewValue = $this->coal2_id->CurrentValue;
			}
		} else {
			$this->coal2_id->ViewValue = NULL;
		}
		}
		$this->coal2_id->ViewCustomAttributes = "";

		// coal3_no
		$this->coal3_no->ViewValue = $this->coal3_no->CurrentValue;
		$this->coal3_no->ViewCustomAttributes = "";

		// coal3_nm
		$this->coal3_nm->ViewValue = $this->coal3_nm->CurrentValue;
		$this->coal3_nm->ViewCustomAttributes = "";

			// coal1_id
			$this->coal1_id->LinkCustomAttributes = "";
			$this->coal1_id->HrefValue = "";
			$this->coal1_id->TooltipValue = "";

			// coal2_id
			$this->coal2_id->LinkCustomAttributes = "";
			$this->coal2_id->HrefValue = "";
			$this->coal2_id->TooltipValue = "";

			// coal3_no
			$this->coal3_no->LinkCustomAttributes = "";
			$this->coal3_no->HrefValue = "";
			$this->coal3_no->TooltipValue = "";

			// coal3_nm
			$this->coal3_nm->LinkCustomAttributes = "";
			$this->coal3_nm->HrefValue = "";
			$this->coal3_nm->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// coal1_id
			$this->coal1_id->EditCustomAttributes = "";
			if ($this->coal1_id->getSessionValue() <> "") {
				$this->coal1_id->CurrentValue = $this->coal1_id->getSessionValue();
			if ($this->coal1_id->VirtualValue <> "") {
				$this->coal1_id->ViewValue = $this->coal1_id->VirtualValue;
			} else {
			if (strval($this->coal1_id->CurrentValue) <> "") {
				$sFilterWrk = "`coal1_id`" . ew_SearchString("=", $this->coal1_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `coal1_id`, `coal1_no` AS `DispFld`, `coal1_nm` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_coal1`";
			$sWhereWrk = "";
			$this->coal1_id->LookupFilters = array("dx1" => '`coal1_no`', "dx2" => '`coal1_nm`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->coal1_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$arwrk[2] = $rswrk->fields('Disp2Fld');
					$this->coal1_id->ViewValue = $this->coal1_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->coal1_id->ViewValue = $this->coal1_id->CurrentValue;
				}
			} else {
				$this->coal1_id->ViewValue = NULL;
			}
			}
			$this->coal1_id->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->coal1_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`coal1_id`" . ew_SearchString("=", $this->coal1_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `coal1_id`, `coal1_no` AS `DispFld`, `coal1_nm` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t_coal1`";
			$sWhereWrk = "";
			$this->coal1_id->LookupFilters = array("dx1" => '`coal1_no`', "dx2" => '`coal1_nm`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->coal1_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->coal1_id->ViewValue = $this->coal1_id->DisplayValue($arwrk);
			} else {
				$this->coal1_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->coal1_id->EditValue = $arwrk;
			}

			// coal2_id
			$this->coal2_id->EditCustomAttributes = "";
			if ($this->coal2_id->getSessionValue() <> "") {
				$this->coal2_id->CurrentValue = $this->coal2_id->getSessionValue();
			if ($this->coal2_id->VirtualValue <> "") {
				$this->coal2_id->ViewValue = $this->coal2_id->VirtualValue;
			} else {
			if (strval($this->coal2_id->CurrentValue) <> "") {
				$sFilterWrk = "`coal2_id`" . ew_SearchString("=", $this->coal2_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `coal2_id`, `coal2_no` AS `DispFld`, `coal2_nm` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_coal2`";
			$sWhereWrk = "";
			$this->coal2_id->LookupFilters = array("dx1" => '`coal2_no`', "dx2" => '`coal2_nm`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->coal2_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$arwrk[2] = $rswrk->fields('Disp2Fld');
					$this->coal2_id->ViewValue = $this->coal2_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->coal2_id->ViewValue = $this->coal2_id->CurrentValue;
				}
			} else {
				$this->coal2_id->ViewValue = NULL;
			}
			}
			$this->coal2_id->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->coal2_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`coal2_id`" . ew_SearchString("=", $this->coal2_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `coal2_id`, `coal2_no` AS `DispFld`, `coal2_nm` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `coal1_id` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t_coal2`";
			$sWhereWrk = "";
			$this->coal2_id->LookupFilters = array("dx1" => '`coal2_no`', "dx2" => '`coal2_nm`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->coal2_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->coal2_id->ViewValue = $this->coal2_id->DisplayValue($arwrk);
			} else {
				$this->coal2_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->coal2_id->EditValue = $arwrk;
			}

			// coal3_no
			$this->coal3_no->EditAttrs["class"] = "form-control";
			$this->coal3_no->EditCustomAttributes = "";
			$this->coal3_no->EditValue = ew_HtmlEncode($this->coal3_no->CurrentValue);
			$this->coal3_no->PlaceHolder = ew_RemoveHtml($this->coal3_no->FldCaption());

			// coal3_nm
			$this->coal3_nm->EditAttrs["class"] = "form-control";
			$this->coal3_nm->EditCustomAttributes = "";
			$this->coal3_nm->EditValue = ew_HtmlEncode($this->coal3_nm->CurrentValue);
			$this->coal3_nm->PlaceHolder = ew_RemoveHtml($this->coal3_nm->FldCaption());

			// Edit refer script
			// coal1_id

			$this->coal1_id->LinkCustomAttributes = "";
			$this->coal1_id->HrefValue = "";

			// coal2_id
			$this->coal2_id->LinkCustomAttributes = "";
			$this->coal2_id->HrefValue = "";

			// coal3_no
			$this->coal3_no->LinkCustomAttributes = "";
			$this->coal3_no->HrefValue = "";

			// coal3_nm
			$this->coal3_nm->LinkCustomAttributes = "";
			$this->coal3_nm->HrefValue = "";
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
		if (!$this->coal1_id->FldIsDetailKey && !is_null($this->coal1_id->FormValue) && $this->coal1_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->coal1_id->FldCaption(), $this->coal1_id->ReqErrMsg));
		}
		if (!$this->coal2_id->FldIsDetailKey && !is_null($this->coal2_id->FormValue) && $this->coal2_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->coal2_id->FldCaption(), $this->coal2_id->ReqErrMsg));
		}
		if (!$this->coal3_no->FldIsDetailKey && !is_null($this->coal3_no->FormValue) && $this->coal3_no->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->coal3_no->FldCaption(), $this->coal3_no->ReqErrMsg));
		}
		if (!$this->coal3_nm->FldIsDetailKey && !is_null($this->coal3_nm->FormValue) && $this->coal3_nm->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->coal3_nm->FldCaption(), $this->coal3_nm->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("t_coal4", $DetailTblVar) && $GLOBALS["t_coal4"]->DetailEdit) {
			if (!isset($GLOBALS["t_coal4_grid"])) $GLOBALS["t_coal4_grid"] = new ct_coal4_grid(); // get detail page object
			$GLOBALS["t_coal4_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// coal1_id
			$this->coal1_id->SetDbValueDef($rsnew, $this->coal1_id->CurrentValue, NULL, $this->coal1_id->ReadOnly);

			// coal2_id
			$this->coal2_id->SetDbValueDef($rsnew, $this->coal2_id->CurrentValue, 0, $this->coal2_id->ReadOnly);

			// coal3_no
			$this->coal3_no->SetDbValueDef($rsnew, $this->coal3_no->CurrentValue, "", $this->coal3_no->ReadOnly);

			// coal3_nm
			$this->coal3_nm->SetDbValueDef($rsnew, $this->coal3_nm->CurrentValue, "", $this->coal3_nm->ReadOnly);

			// Check referential integrity for master table 't_coal2'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_t_coal2();
			$KeyValue = isset($rsnew['coal2_id']) ? $rsnew['coal2_id'] : $rsold['coal2_id'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@coal2_id@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			$KeyValue = isset($rsnew['coal1_id']) ? $rsnew['coal1_id'] : $rsold['coal1_id'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@coal1_id@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				if (!isset($GLOBALS["t_coal2"])) $GLOBALS["t_coal2"] = new ct_coal2();
				$rsmaster = $GLOBALS["t_coal2"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "t_coal2", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
			}

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

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("t_coal4", $DetailTblVar) && $GLOBALS["t_coal4"]->DetailEdit) {
						if (!isset($GLOBALS["t_coal4_grid"])) $GLOBALS["t_coal4_grid"] = new ct_coal4_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "t_coal4"); // Load user level of detail table
						$EditRow = $GLOBALS["t_coal4_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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
			if ($sMasterTblVar == "t_coal2") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_coal2_id"] <> "") {
					$GLOBALS["t_coal2"]->coal2_id->setQueryStringValue($_GET["fk_coal2_id"]);
					$this->coal2_id->setQueryStringValue($GLOBALS["t_coal2"]->coal2_id->QueryStringValue);
					$this->coal2_id->setSessionValue($this->coal2_id->QueryStringValue);
					if (!is_numeric($GLOBALS["t_coal2"]->coal2_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_coal1_id"] <> "") {
					$GLOBALS["t_coal2"]->coal1_id->setQueryStringValue($_GET["fk_coal1_id"]);
					$this->coal1_id->setQueryStringValue($GLOBALS["t_coal2"]->coal1_id->QueryStringValue);
					$this->coal1_id->setSessionValue($this->coal1_id->QueryStringValue);
					if (!is_numeric($GLOBALS["t_coal2"]->coal1_id->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "t_coal2") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_coal2_id"] <> "") {
					$GLOBALS["t_coal2"]->coal2_id->setFormValue($_POST["fk_coal2_id"]);
					$this->coal2_id->setFormValue($GLOBALS["t_coal2"]->coal2_id->FormValue);
					$this->coal2_id->setSessionValue($this->coal2_id->FormValue);
					if (!is_numeric($GLOBALS["t_coal2"]->coal2_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_coal1_id"] <> "") {
					$GLOBALS["t_coal2"]->coal1_id->setFormValue($_POST["fk_coal1_id"]);
					$this->coal1_id->setFormValue($GLOBALS["t_coal2"]->coal1_id->FormValue);
					$this->coal1_id->setSessionValue($this->coal1_id->FormValue);
					if (!is_numeric($GLOBALS["t_coal2"]->coal1_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t_coal2") {
				if ($this->coal2_id->CurrentValue == "") $this->coal2_id->setSessionValue("");
				if ($this->coal1_id->CurrentValue == "") $this->coal1_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("t_coal4", $DetailTblVar)) {
				if (!isset($GLOBALS["t_coal4_grid"]))
					$GLOBALS["t_coal4_grid"] = new ct_coal4_grid;
				if ($GLOBALS["t_coal4_grid"]->DetailEdit) {
					$GLOBALS["t_coal4_grid"]->CurrentMode = "edit";
					$GLOBALS["t_coal4_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["t_coal4_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["t_coal4_grid"]->setStartRecordNumber(1);
					$GLOBALS["t_coal4_grid"]->coal1_id->FldIsDetailKey = TRUE;
					$GLOBALS["t_coal4_grid"]->coal1_id->CurrentValue = $this->coal1_id->CurrentValue;
					$GLOBALS["t_coal4_grid"]->coal1_id->setSessionValue($GLOBALS["t_coal4_grid"]->coal1_id->CurrentValue);
					$GLOBALS["t_coal4_grid"]->coal2_id->FldIsDetailKey = TRUE;
					$GLOBALS["t_coal4_grid"]->coal2_id->CurrentValue = $this->coal2_id->CurrentValue;
					$GLOBALS["t_coal4_grid"]->coal2_id->setSessionValue($GLOBALS["t_coal4_grid"]->coal2_id->CurrentValue);
					$GLOBALS["t_coal4_grid"]->coal3_id->FldIsDetailKey = TRUE;
					$GLOBALS["t_coal4_grid"]->coal3_id->CurrentValue = $this->coal3_id->CurrentValue;
					$GLOBALS["t_coal4_grid"]->coal3_id->setSessionValue($GLOBALS["t_coal4_grid"]->coal3_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_coal3list.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_coal1_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `coal1_id` AS `LinkFld`, `coal1_no` AS `DispFld`, `coal1_nm` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_coal1`";
			$sWhereWrk = "{filter}";
			$this->coal1_id->LookupFilters = array("dx1" => '`coal1_no`', "dx2" => '`coal1_nm`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`coal1_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->coal1_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_coal2_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `coal2_id` AS `LinkFld`, `coal2_no` AS `DispFld`, `coal2_nm` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_coal2`";
			$sWhereWrk = "{filter}";
			$this->coal2_id->LookupFilters = array("dx1" => '`coal2_no`', "dx2" => '`coal2_nm`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`coal2_id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`coal1_id` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->coal2_id, $sWhereWrk); // Call Lookup selecting
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t_coal3_edit)) $t_coal3_edit = new ct_coal3_edit();

// Page init
$t_coal3_edit->Page_Init();

// Page main
$t_coal3_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_coal3_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft_coal3edit = new ew_Form("ft_coal3edit", "edit");

// Validate form
ft_coal3edit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_coal1_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_coal3->coal1_id->FldCaption(), $t_coal3->coal1_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_coal2_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_coal3->coal2_id->FldCaption(), $t_coal3->coal2_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_coal3_no");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_coal3->coal3_no->FldCaption(), $t_coal3->coal3_no->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_coal3_nm");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_coal3->coal3_nm->FldCaption(), $t_coal3->coal3_nm->ReqErrMsg)) ?>");

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
ft_coal3edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_coal3edit.ValidateRequired = true;
<?php } else { ?>
ft_coal3edit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_coal3edit.Lists["x_coal1_id"] = {"LinkField":"x_coal1_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_coal1_no","x_coal1_nm","",""],"ParentFields":[],"ChildFields":["x_coal2_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_coal1"};
ft_coal3edit.Lists["x_coal2_id"] = {"LinkField":"x_coal2_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_coal2_no","x_coal2_nm","",""],"ParentFields":["x_coal1_id"],"ChildFields":[],"FilterFields":["x_coal1_id"],"Options":[],"Template":"","LinkTable":"t_coal2"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_coal3_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t_coal3_edit->ShowPageHeader(); ?>
<?php
$t_coal3_edit->ShowMessage();
?>
<?php if (!$t_coal3_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t_coal3_edit->Pager)) $t_coal3_edit->Pager = new cPrevNextPager($t_coal3_edit->StartRec, $t_coal3_edit->DisplayRecs, $t_coal3_edit->TotalRecs) ?>
<?php if ($t_coal3_edit->Pager->RecordCount > 0 && $t_coal3_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t_coal3_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t_coal3_edit->PageUrl() ?>start=<?php echo $t_coal3_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t_coal3_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t_coal3_edit->PageUrl() ?>start=<?php echo $t_coal3_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t_coal3_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t_coal3_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t_coal3_edit->PageUrl() ?>start=<?php echo $t_coal3_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t_coal3_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t_coal3_edit->PageUrl() ?>start=<?php echo $t_coal3_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t_coal3_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="ft_coal3edit" id="ft_coal3edit" class="<?php echo $t_coal3_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_coal3_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_coal3_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_coal3">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($t_coal3_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($t_coal3->getCurrentMasterTable() == "t_coal2") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t_coal2">
<input type="hidden" name="fk_coal2_id" value="<?php echo $t_coal3->coal2_id->getSessionValue() ?>">
<input type="hidden" name="fk_coal1_id" value="<?php echo $t_coal3->coal1_id->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($t_coal3->coal1_id->Visible) { // coal1_id ?>
	<div id="r_coal1_id" class="form-group">
		<label id="elh_t_coal3_coal1_id" for="x_coal1_id" class="col-sm-2 control-label ewLabel"><?php echo $t_coal3->coal1_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_coal3->coal1_id->CellAttributes() ?>>
<?php if ($t_coal3->coal1_id->getSessionValue() <> "") { ?>
<span id="el_t_coal3_coal1_id">
<span<?php echo $t_coal3->coal1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal3->coal1_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_coal1_id" name="x_coal1_id" value="<?php echo ew_HtmlEncode($t_coal3->coal1_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_t_coal3_coal1_id">
<?php $t_coal3->coal1_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_coal3->coal1_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_coal1_id"><?php echo (strval($t_coal3->coal1_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal3->coal1_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal3->coal1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_coal1_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal3" data-field="x_coal1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal3->coal1_id->DisplayValueSeparatorAttribute() ?>" name="x_coal1_id" id="x_coal1_id" value="<?php echo $t_coal3->coal1_id->CurrentValue ?>"<?php echo $t_coal3->coal1_id->EditAttributes() ?>>
<input type="hidden" name="s_x_coal1_id" id="s_x_coal1_id" value="<?php echo $t_coal3->coal1_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $t_coal3->coal1_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_coal3->coal2_id->Visible) { // coal2_id ?>
	<div id="r_coal2_id" class="form-group">
		<label id="elh_t_coal3_coal2_id" for="x_coal2_id" class="col-sm-2 control-label ewLabel"><?php echo $t_coal3->coal2_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_coal3->coal2_id->CellAttributes() ?>>
<?php if ($t_coal3->coal2_id->getSessionValue() <> "") { ?>
<span id="el_t_coal3_coal2_id">
<span<?php echo $t_coal3->coal2_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal3->coal2_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_coal2_id" name="x_coal2_id" value="<?php echo ew_HtmlEncode($t_coal3->coal2_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_t_coal3_coal2_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_coal2_id"><?php echo (strval($t_coal3->coal2_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal3->coal2_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal3->coal2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_coal2_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal3" data-field="x_coal2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal3->coal2_id->DisplayValueSeparatorAttribute() ?>" name="x_coal2_id" id="x_coal2_id" value="<?php echo $t_coal3->coal2_id->CurrentValue ?>"<?php echo $t_coal3->coal2_id->EditAttributes() ?>>
<input type="hidden" name="s_x_coal2_id" id="s_x_coal2_id" value="<?php echo $t_coal3->coal2_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $t_coal3->coal2_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_coal3->coal3_no->Visible) { // coal3_no ?>
	<div id="r_coal3_no" class="form-group">
		<label id="elh_t_coal3_coal3_no" for="x_coal3_no" class="col-sm-2 control-label ewLabel"><?php echo $t_coal3->coal3_no->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_coal3->coal3_no->CellAttributes() ?>>
<span id="el_t_coal3_coal3_no">
<input type="text" data-table="t_coal3" data-field="x_coal3_no" name="x_coal3_no" id="x_coal3_no" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($t_coal3->coal3_no->getPlaceHolder()) ?>" value="<?php echo $t_coal3->coal3_no->EditValue ?>"<?php echo $t_coal3->coal3_no->EditAttributes() ?>>
</span>
<?php echo $t_coal3->coal3_no->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_coal3->coal3_nm->Visible) { // coal3_nm ?>
	<div id="r_coal3_nm" class="form-group">
		<label id="elh_t_coal3_coal3_nm" for="x_coal3_nm" class="col-sm-2 control-label ewLabel"><?php echo $t_coal3->coal3_nm->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_coal3->coal3_nm->CellAttributes() ?>>
<span id="el_t_coal3_coal3_nm">
<input type="text" data-table="t_coal3" data-field="x_coal3_nm" name="x_coal3_nm" id="x_coal3_nm" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_coal3->coal3_nm->getPlaceHolder()) ?>" value="<?php echo $t_coal3->coal3_nm->EditValue ?>"<?php echo $t_coal3->coal3_nm->EditAttributes() ?>>
</span>
<?php echo $t_coal3->coal3_nm->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="t_coal3" data-field="x_coal3_id" name="x_coal3_id" id="x_coal3_id" value="<?php echo ew_HtmlEncode($t_coal3->coal3_id->CurrentValue) ?>">
<?php
	if (in_array("t_coal4", explode(",", $t_coal3->getCurrentDetailTable())) && $t_coal4->DetailEdit) {
?>
<?php if ($t_coal3->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("t_coal4", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "t_coal4grid.php" ?>
<?php } ?>
<?php if (!$t_coal3_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_coal3_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php if (!isset($t_coal3_edit->Pager)) $t_coal3_edit->Pager = new cPrevNextPager($t_coal3_edit->StartRec, $t_coal3_edit->DisplayRecs, $t_coal3_edit->TotalRecs) ?>
<?php if ($t_coal3_edit->Pager->RecordCount > 0 && $t_coal3_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t_coal3_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t_coal3_edit->PageUrl() ?>start=<?php echo $t_coal3_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t_coal3_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t_coal3_edit->PageUrl() ?>start=<?php echo $t_coal3_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t_coal3_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t_coal3_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t_coal3_edit->PageUrl() ?>start=<?php echo $t_coal3_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t_coal3_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t_coal3_edit->PageUrl() ?>start=<?php echo $t_coal3_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t_coal3_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
ft_coal3edit.Init();
</script>
<?php
$t_coal3_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_coal3_edit->Page_Terminate();
?>
