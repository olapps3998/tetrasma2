<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_coal4info.php" ?>
<?php include_once "t_userinfo.php" ?>
<?php include_once "t_coal3info.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_coal4_delete = NULL; // Initialize page object first

class ct_coal4_delete extends ct_coal4 {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{BD598998-6524-4166-9FBE-52F174C8EABD}";

	// Table name
	var $TableName = 't_coal4';

	// Page object name
	var $PageObjName = 't_coal4_delete';

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

		// Table object (t_coal4)
		if (!isset($GLOBALS["t_coal4"]) || get_class($GLOBALS["t_coal4"]) == "ct_coal4") {
			$GLOBALS["t_coal4"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_coal4"];
		}

		// Table object (t_user)
		if (!isset($GLOBALS['t_user'])) $GLOBALS['t_user'] = new ct_user();

		// Table object (t_coal3)
		if (!isset($GLOBALS['t_coal3'])) $GLOBALS['t_coal3'] = new ct_coal3();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_coal4', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("t_coal4list.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->coal1_id->SetVisibility();
		$this->coal2_id->SetVisibility();
		$this->coal3_id->SetVisibility();
		$this->coal4_no->SetVisibility();
		$this->coal4_nm->SetVisibility();

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
		global $EW_EXPORT, $t_coal4;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_coal4);
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t_coal4list.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t_coal4 class, t_coal4info.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("t_coal4list.php"); // Return to list
			}
		}
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
		$this->coal4_id->setDbValue($rs->fields('coal4_id'));
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
		$this->coal3_id->setDbValue($rs->fields('coal3_id'));
		if (array_key_exists('EV__coal3_id', $rs->fields)) {
			$this->coal3_id->VirtualValue = $rs->fields('EV__coal3_id'); // Set up virtual field value
		} else {
			$this->coal3_id->VirtualValue = ""; // Clear value
		}
		$this->coal4_no->setDbValue($rs->fields('coal4_no'));
		$this->coal4_nm->setDbValue($rs->fields('coal4_nm'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->coal4_id->DbValue = $row['coal4_id'];
		$this->coal1_id->DbValue = $row['coal1_id'];
		$this->coal2_id->DbValue = $row['coal2_id'];
		$this->coal3_id->DbValue = $row['coal3_id'];
		$this->coal4_no->DbValue = $row['coal4_no'];
		$this->coal4_nm->DbValue = $row['coal4_nm'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// coal4_id
		// coal1_id
		// coal2_id
		// coal3_id
		// coal4_no
		// coal4_nm

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// coal4_id
		$this->coal4_id->ViewValue = $this->coal4_id->CurrentValue;
		$this->coal4_id->ViewCustomAttributes = "";

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

		// coal3_id
		if ($this->coal3_id->VirtualValue <> "") {
			$this->coal3_id->ViewValue = $this->coal3_id->VirtualValue;
		} else {
		if (strval($this->coal3_id->CurrentValue) <> "") {
			$sFilterWrk = "`coal3_id`" . ew_SearchString("=", $this->coal3_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `coal3_id`, `coal3_no` AS `DispFld`, `coal3_nm` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_coal3`";
		$sWhereWrk = "";
		$this->coal3_id->LookupFilters = array("dx1" => '`coal3_no`', "dx2" => '`coal3_nm`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->coal3_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->coal3_id->ViewValue = $this->coal3_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->coal3_id->ViewValue = $this->coal3_id->CurrentValue;
			}
		} else {
			$this->coal3_id->ViewValue = NULL;
		}
		}
		$this->coal3_id->ViewCustomAttributes = "";

		// coal4_no
		$this->coal4_no->ViewValue = $this->coal4_no->CurrentValue;
		$this->coal4_no->ViewCustomAttributes = "";

		// coal4_nm
		$this->coal4_nm->ViewValue = $this->coal4_nm->CurrentValue;
		$this->coal4_nm->ViewCustomAttributes = "";

			// coal1_id
			$this->coal1_id->LinkCustomAttributes = "";
			$this->coal1_id->HrefValue = "";
			$this->coal1_id->TooltipValue = "";

			// coal2_id
			$this->coal2_id->LinkCustomAttributes = "";
			$this->coal2_id->HrefValue = "";
			$this->coal2_id->TooltipValue = "";

			// coal3_id
			$this->coal3_id->LinkCustomAttributes = "";
			$this->coal3_id->HrefValue = "";
			$this->coal3_id->TooltipValue = "";

			// coal4_no
			$this->coal4_no->LinkCustomAttributes = "";
			$this->coal4_no->HrefValue = "";
			$this->coal4_no->TooltipValue = "";

			// coal4_nm
			$this->coal4_nm->LinkCustomAttributes = "";
			$this->coal4_nm->HrefValue = "";
			$this->coal4_nm->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
		$conn->BeginTrans();
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
				$sThisKey .= $row['coal4_id'];
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
			$conn->CommitTrans(); // Commit the changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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
			if ($sMasterTblVar == "t_coal3") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_coal1_id"] <> "") {
					$GLOBALS["t_coal3"]->coal1_id->setQueryStringValue($_GET["fk_coal1_id"]);
					$this->coal1_id->setQueryStringValue($GLOBALS["t_coal3"]->coal1_id->QueryStringValue);
					$this->coal1_id->setSessionValue($this->coal1_id->QueryStringValue);
					if (!is_numeric($GLOBALS["t_coal3"]->coal1_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_coal2_id"] <> "") {
					$GLOBALS["t_coal3"]->coal2_id->setQueryStringValue($_GET["fk_coal2_id"]);
					$this->coal2_id->setQueryStringValue($GLOBALS["t_coal3"]->coal2_id->QueryStringValue);
					$this->coal2_id->setSessionValue($this->coal2_id->QueryStringValue);
					if (!is_numeric($GLOBALS["t_coal3"]->coal2_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_coal3_id"] <> "") {
					$GLOBALS["t_coal3"]->coal3_id->setQueryStringValue($_GET["fk_coal3_id"]);
					$this->coal3_id->setQueryStringValue($GLOBALS["t_coal3"]->coal3_id->QueryStringValue);
					$this->coal3_id->setSessionValue($this->coal3_id->QueryStringValue);
					if (!is_numeric($GLOBALS["t_coal3"]->coal3_id->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "t_coal3") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_coal1_id"] <> "") {
					$GLOBALS["t_coal3"]->coal1_id->setFormValue($_POST["fk_coal1_id"]);
					$this->coal1_id->setFormValue($GLOBALS["t_coal3"]->coal1_id->FormValue);
					$this->coal1_id->setSessionValue($this->coal1_id->FormValue);
					if (!is_numeric($GLOBALS["t_coal3"]->coal1_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_coal2_id"] <> "") {
					$GLOBALS["t_coal3"]->coal2_id->setFormValue($_POST["fk_coal2_id"]);
					$this->coal2_id->setFormValue($GLOBALS["t_coal3"]->coal2_id->FormValue);
					$this->coal2_id->setSessionValue($this->coal2_id->FormValue);
					if (!is_numeric($GLOBALS["t_coal3"]->coal2_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_coal3_id"] <> "") {
					$GLOBALS["t_coal3"]->coal3_id->setFormValue($_POST["fk_coal3_id"]);
					$this->coal3_id->setFormValue($GLOBALS["t_coal3"]->coal3_id->FormValue);
					$this->coal3_id->setSessionValue($this->coal3_id->FormValue);
					if (!is_numeric($GLOBALS["t_coal3"]->coal3_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t_coal3") {
				if ($this->coal1_id->CurrentValue == "") $this->coal1_id->setSessionValue("");
				if ($this->coal2_id->CurrentValue == "") $this->coal2_id->setSessionValue("");
				if ($this->coal3_id->CurrentValue == "") $this->coal3_id->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_coal4list.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t_coal4_delete)) $t_coal4_delete = new ct_coal4_delete();

// Page init
$t_coal4_delete->Page_Init();

// Page main
$t_coal4_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_coal4_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft_coal4delete = new ew_Form("ft_coal4delete", "delete");

// Form_CustomValidate event
ft_coal4delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_coal4delete.ValidateRequired = true;
<?php } else { ?>
ft_coal4delete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_coal4delete.Lists["x_coal1_id"] = {"LinkField":"x_coal1_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_coal1_no","x_coal1_nm","",""],"ParentFields":[],"ChildFields":["x_coal2_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_coal1"};
ft_coal4delete.Lists["x_coal2_id"] = {"LinkField":"x_coal2_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_coal2_no","x_coal2_nm","",""],"ParentFields":[],"ChildFields":["x_coal3_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_coal2"};
ft_coal4delete.Lists["x_coal3_id"] = {"LinkField":"x_coal3_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_coal3_no","x_coal3_nm","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_coal3"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $t_coal4_delete->ShowPageHeader(); ?>
<?php
$t_coal4_delete->ShowMessage();
?>
<form name="ft_coal4delete" id="ft_coal4delete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_coal4_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_coal4_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_coal4">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t_coal4_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $t_coal4->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t_coal4->coal1_id->Visible) { // coal1_id ?>
		<th><span id="elh_t_coal4_coal1_id" class="t_coal4_coal1_id"><?php echo $t_coal4->coal1_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_coal4->coal2_id->Visible) { // coal2_id ?>
		<th><span id="elh_t_coal4_coal2_id" class="t_coal4_coal2_id"><?php echo $t_coal4->coal2_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_coal4->coal3_id->Visible) { // coal3_id ?>
		<th><span id="elh_t_coal4_coal3_id" class="t_coal4_coal3_id"><?php echo $t_coal4->coal3_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_coal4->coal4_no->Visible) { // coal4_no ?>
		<th><span id="elh_t_coal4_coal4_no" class="t_coal4_coal4_no"><?php echo $t_coal4->coal4_no->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_coal4->coal4_nm->Visible) { // coal4_nm ?>
		<th><span id="elh_t_coal4_coal4_nm" class="t_coal4_coal4_nm"><?php echo $t_coal4->coal4_nm->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t_coal4_delete->RecCnt = 0;
$i = 0;
while (!$t_coal4_delete->Recordset->EOF) {
	$t_coal4_delete->RecCnt++;
	$t_coal4_delete->RowCnt++;

	// Set row properties
	$t_coal4->ResetAttrs();
	$t_coal4->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t_coal4_delete->LoadRowValues($t_coal4_delete->Recordset);

	// Render row
	$t_coal4_delete->RenderRow();
?>
	<tr<?php echo $t_coal4->RowAttributes() ?>>
<?php if ($t_coal4->coal1_id->Visible) { // coal1_id ?>
		<td<?php echo $t_coal4->coal1_id->CellAttributes() ?>>
<span id="el<?php echo $t_coal4_delete->RowCnt ?>_t_coal4_coal1_id" class="t_coal4_coal1_id">
<span<?php echo $t_coal4->coal1_id->ViewAttributes() ?>>
<?php echo $t_coal4->coal1_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_coal4->coal2_id->Visible) { // coal2_id ?>
		<td<?php echo $t_coal4->coal2_id->CellAttributes() ?>>
<span id="el<?php echo $t_coal4_delete->RowCnt ?>_t_coal4_coal2_id" class="t_coal4_coal2_id">
<span<?php echo $t_coal4->coal2_id->ViewAttributes() ?>>
<?php echo $t_coal4->coal2_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_coal4->coal3_id->Visible) { // coal3_id ?>
		<td<?php echo $t_coal4->coal3_id->CellAttributes() ?>>
<span id="el<?php echo $t_coal4_delete->RowCnt ?>_t_coal4_coal3_id" class="t_coal4_coal3_id">
<span<?php echo $t_coal4->coal3_id->ViewAttributes() ?>>
<?php echo $t_coal4->coal3_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_coal4->coal4_no->Visible) { // coal4_no ?>
		<td<?php echo $t_coal4->coal4_no->CellAttributes() ?>>
<span id="el<?php echo $t_coal4_delete->RowCnt ?>_t_coal4_coal4_no" class="t_coal4_coal4_no">
<span<?php echo $t_coal4->coal4_no->ViewAttributes() ?>>
<?php echo $t_coal4->coal4_no->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_coal4->coal4_nm->Visible) { // coal4_nm ?>
		<td<?php echo $t_coal4->coal4_nm->CellAttributes() ?>>
<span id="el<?php echo $t_coal4_delete->RowCnt ?>_t_coal4_coal4_nm" class="t_coal4_coal4_nm">
<span<?php echo $t_coal4->coal4_nm->ViewAttributes() ?>>
<?php echo $t_coal4->coal4_nm->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t_coal4_delete->Recordset->MoveNext();
}
$t_coal4_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_coal4_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft_coal4delete.Init();
</script>
<?php
$t_coal4_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_coal4_delete->Page_Terminate();
?>
