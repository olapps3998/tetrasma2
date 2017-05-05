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

$t_detail_add = NULL; // Initialize page object first

class ct_detail_add extends ct_detail {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{BD598998-6524-4166-9FBE-52F174C8EABD}";

	// Table name
	var $TableName = 't_detail';

	// Page object name
	var $PageObjName = 't_detail_add';

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

		// Table object (t_detail)
		if (!isset($GLOBALS["t_detail"]) || get_class($GLOBALS["t_detail"]) == "ct_detail") {
			$GLOBALS["t_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_detail"];
		}

		// Table object (t_user)
		if (!isset($GLOBALS['t_user'])) $GLOBALS['t_user'] = new ct_user();

		// Table object (t_jurnal)
		if (!isset($GLOBALS['t_jurnal'])) $GLOBALS['t_jurnal'] = new ct_jurnal();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("t_detaillist.php"));
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
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
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["detail_id"] != "") {
				$this->detail_id->setQueryStringValue($_GET["detail_id"]);
				$this->setKey("detail_id", $this->detail_id->CurrentValue); // Set up key
			} else {
				$this->setKey("detail_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("t_detaillist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t_detaillist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t_detailview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

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
		if (!$this->coa_id->FldIsDetailKey) {
			$this->coa_id->setFormValue($objForm->GetValue("x_coa_id"));
		}
		if (!$this->debet->FldIsDetailKey) {
			$this->debet->setFormValue($objForm->GetValue("x_debet"));
		}
		if (!$this->kredit->FldIsDetailKey) {
			$this->kredit->setFormValue($objForm->GetValue("x_kredit"));
		}
		if (!$this->anggota_id->FldIsDetailKey) {
			$this->anggota_id->setFormValue($objForm->GetValue("x_anggota_id"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->jurnal_id->CurrentValue = $this->jurnal_id->FormValue;
		$this->coa_id->CurrentValue = $this->coa_id->FormValue;
		$this->debet->CurrentValue = $this->debet->FormValue;
		$this->kredit->CurrentValue = $this->kredit->FormValue;
		$this->anggota_id->CurrentValue = $this->anggota_id->FormValue;
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
			if (strval($this->debet->EditValue) <> "" && is_numeric($this->debet->EditValue)) $this->debet->EditValue = ew_FormatNumber($this->debet->EditValue, -2, -1, -2, 0);

			// kredit
			$this->kredit->EditAttrs["class"] = "form-control";
			$this->kredit->EditCustomAttributes = "";
			$this->kredit->EditValue = ew_HtmlEncode($this->kredit->CurrentValue);
			$this->kredit->PlaceHolder = ew_RemoveHtml($this->kredit->FldCaption());
			if (strval($this->kredit->EditValue) <> "" && is_numeric($this->kredit->EditValue)) $this->kredit->EditValue = ew_FormatNumber($this->kredit->EditValue, -2, -1, -2, 0);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_detaillist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t_detail_add)) $t_detail_add = new ct_detail_add();

// Page init
$t_detail_add->Page_Init();

// Page main
$t_detail_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_detail_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft_detailadd = new ew_Form("ft_detailadd", "add");

// Validate form
ft_detailadd.Validate = function() {
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
ft_detailadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_detailadd.ValidateRequired = true;
<?php } else { ?>
ft_detailadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_detailadd.Lists["x_coa_id"] = {"LinkField":"x_coal4_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_coal4_no","x_coal4_nm","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_coal4"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_detail_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t_detail_add->ShowPageHeader(); ?>
<?php
$t_detail_add->ShowMessage();
?>
<form name="ft_detailadd" id="ft_detailadd" class="<?php echo $t_detail_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_detail_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_detail_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_detail">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t_detail_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($t_detail->getCurrentMasterTable() == "t_jurnal") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t_jurnal">
<input type="hidden" name="fk_jurnal_id" value="<?php echo $t_detail->jurnal_id->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($t_detail->jurnal_id->Visible) { // jurnal_id ?>
	<div id="r_jurnal_id" class="form-group">
		<label id="elh_t_detail_jurnal_id" for="x_jurnal_id" class="col-sm-2 control-label ewLabel"><?php echo $t_detail->jurnal_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_detail->jurnal_id->CellAttributes() ?>>
<?php if ($t_detail->jurnal_id->getSessionValue() <> "") { ?>
<span id="el_t_detail_jurnal_id">
<span<?php echo $t_detail->jurnal_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_detail->jurnal_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_jurnal_id" name="x_jurnal_id" value="<?php echo ew_HtmlEncode($t_detail->jurnal_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_t_detail_jurnal_id">
<input type="text" data-table="t_detail" data-field="x_jurnal_id" name="x_jurnal_id" id="x_jurnal_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->jurnal_id->getPlaceHolder()) ?>" value="<?php echo $t_detail->jurnal_id->EditValue ?>"<?php echo $t_detail->jurnal_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $t_detail->jurnal_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_detail->coa_id->Visible) { // coa_id ?>
	<div id="r_coa_id" class="form-group">
		<label id="elh_t_detail_coa_id" for="x_coa_id" class="col-sm-2 control-label ewLabel"><?php echo $t_detail->coa_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_detail->coa_id->CellAttributes() ?>>
<span id="el_t_detail_coa_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_coa_id"><?php echo (strval($t_detail->coa_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_detail->coa_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_detail->coa_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_coa_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_detail" data-field="x_coa_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_detail->coa_id->DisplayValueSeparatorAttribute() ?>" name="x_coa_id" id="x_coa_id" value="<?php echo $t_detail->coa_id->CurrentValue ?>"<?php echo $t_detail->coa_id->EditAttributes() ?>>
<input type="hidden" name="s_x_coa_id" id="s_x_coa_id" value="<?php echo $t_detail->coa_id->LookupFilterQuery() ?>">
</span>
<?php echo $t_detail->coa_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_detail->debet->Visible) { // debet ?>
	<div id="r_debet" class="form-group">
		<label id="elh_t_detail_debet" for="x_debet" class="col-sm-2 control-label ewLabel"><?php echo $t_detail->debet->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_detail->debet->CellAttributes() ?>>
<span id="el_t_detail_debet">
<input type="text" data-table="t_detail" data-field="x_debet" name="x_debet" id="x_debet" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->debet->getPlaceHolder()) ?>" value="<?php echo $t_detail->debet->EditValue ?>"<?php echo $t_detail->debet->EditAttributes() ?>>
</span>
<?php echo $t_detail->debet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_detail->kredit->Visible) { // kredit ?>
	<div id="r_kredit" class="form-group">
		<label id="elh_t_detail_kredit" for="x_kredit" class="col-sm-2 control-label ewLabel"><?php echo $t_detail->kredit->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_detail->kredit->CellAttributes() ?>>
<span id="el_t_detail_kredit">
<input type="text" data-table="t_detail" data-field="x_kredit" name="x_kredit" id="x_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->kredit->getPlaceHolder()) ?>" value="<?php echo $t_detail->kredit->EditValue ?>"<?php echo $t_detail->kredit->EditAttributes() ?>>
</span>
<?php echo $t_detail->kredit->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_detail->anggota_id->Visible) { // anggota_id ?>
	<div id="r_anggota_id" class="form-group">
		<label id="elh_t_detail_anggota_id" for="x_anggota_id" class="col-sm-2 control-label ewLabel"><?php echo $t_detail->anggota_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_detail->anggota_id->CellAttributes() ?>>
<span id="el_t_detail_anggota_id">
<input type="text" data-table="t_detail" data-field="x_anggota_id" name="x_anggota_id" id="x_anggota_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_detail->anggota_id->getPlaceHolder()) ?>" value="<?php echo $t_detail->anggota_id->EditValue ?>"<?php echo $t_detail->anggota_id->EditAttributes() ?>>
</span>
<?php echo $t_detail->anggota_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t_detail_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_detail_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_detailadd.Init();
</script>
<?php
$t_detail_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_detail_add->Page_Terminate();
?>
