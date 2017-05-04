<?php

// Global variable for table object
$t_coal4 = NULL;

//
// Table class for t_coal4
//
class ct_coal4 extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $coal4_id;
	var $coal1_id;
	var $coal2_id;
	var $coal3_id;
	var $coal4_no;
	var $coal4_nm;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't_coal4';
		$this->TableName = 't_coal4';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t_coal4`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// coal4_id
		$this->coal4_id = new cField('t_coal4', 't_coal4', 'x_coal4_id', 'coal4_id', '`coal4_id`', '`coal4_id`', 3, -1, FALSE, '`coal4_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->coal4_id->Sortable = TRUE; // Allow sort
		$this->coal4_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['coal4_id'] = &$this->coal4_id;

		// coal1_id
		$this->coal1_id = new cField('t_coal4', 't_coal4', 'x_coal1_id', 'coal1_id', '(select coal1_id from t_coal2 where t_coal2.coal2_id = (select coal2_id from t_coal3 where t_coal4.coal3_id = t_coal3.coal3_id))', '(select coal1_id from t_coal2 where t_coal2.coal2_id = (select coal2_id from t_coal3 where t_coal4.coal3_id = t_coal3.coal3_id))', 3, -1, FALSE, '`EV__coal1_id`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'SELECT');
		$this->coal1_id->FldIsCustom = TRUE; // Custom field
		$this->coal1_id->Sortable = TRUE; // Allow sort
		$this->coal1_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->coal1_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->coal1_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['coal1_id'] = &$this->coal1_id;

		// coal2_id
		$this->coal2_id = new cField('t_coal4', 't_coal4', 'x_coal2_id', 'coal2_id', '(select coal2_id from t_coal3 where t_coal4.coal3_id = t_coal3.coal3_id)', '(select coal2_id from t_coal3 where t_coal4.coal3_id = t_coal3.coal3_id)', 3, -1, FALSE, '`EV__coal2_id`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'SELECT');
		$this->coal2_id->FldIsCustom = TRUE; // Custom field
		$this->coal2_id->Sortable = TRUE; // Allow sort
		$this->coal2_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->coal2_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->coal2_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['coal2_id'] = &$this->coal2_id;

		// coal3_id
		$this->coal3_id = new cField('t_coal4', 't_coal4', 'x_coal3_id', 'coal3_id', '`coal3_id`', '`coal3_id`', 3, -1, FALSE, '`EV__coal3_id`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'SELECT');
		$this->coal3_id->Sortable = TRUE; // Allow sort
		$this->coal3_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->coal3_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->coal3_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['coal3_id'] = &$this->coal3_id;

		// coal4_no
		$this->coal4_no = new cField('t_coal4', 't_coal4', 'x_coal4_no', 'coal4_no', '`coal4_no`', '`coal4_no`', 200, -1, FALSE, '`coal4_no`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->coal4_no->Sortable = TRUE; // Allow sort
		$this->fields['coal4_no'] = &$this->coal4_no;

		// coal4_nm
		$this->coal4_nm = new cField('t_coal4', 't_coal4', 'x_coal4_nm', 'coal4_nm', '`coal4_nm`', '`coal4_nm`', 200, -1, FALSE, '`coal4_nm`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->coal4_nm->Sortable = TRUE; // Allow sort
		$this->fields['coal4_nm'] = &$this->coal4_nm;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
			$sSortFieldList = ($ofld->FldVirtualExpression <> "") ? $ofld->FldVirtualExpression : $sSortField;
			if ($ctrl) {
				$sOrderByList = $this->getSessionOrderByList();
				if (strpos($sOrderByList, $sSortFieldList . " " . $sLastSort) !== FALSE) {
					$sOrderByList = str_replace($sSortFieldList . " " . $sLastSort, $sSortFieldList . " " . $sThisSort, $sOrderByList);
				} else {
					if ($sOrderByList <> "") $sOrderByList .= ", ";
					$sOrderByList .= $sSortFieldList . " " . $sThisSort;
				}
				$this->setSessionOrderByList($sOrderByList); // Save to Session
			} else {
				$this->setSessionOrderByList($sSortFieldList . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Session ORDER BY for List page
	function getSessionOrderByList() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST];
	}

	function setSessionOrderByList($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST] = $v;
	}

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "t_coal3") {
			if ($this->coal1_id->getSessionValue() <> "")
				$sMasterFilter .= "(select coal1_id from t_coal2 where t_coal3.coal2_id = t_coal2.coal2_id)=" . ew_QuotedValue($this->coal1_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->coal2_id->getSessionValue() <> "")
				$sMasterFilter .= " AND `coal2_id`=" . ew_QuotedValue($this->coal2_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->coal3_id->getSessionValue() <> "")
				$sMasterFilter .= " AND `coal3_id`=" . ew_QuotedValue($this->coal3_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "t_coal3") {
			if ($this->coal1_id->getSessionValue() <> "")
				$sDetailFilter .= "(select coal1_id from t_coal2 where t_coal2.coal2_id = (select coal2_id from t_coal3 where t_coal4.coal3_id = t_coal3.coal3_id))=" . ew_QuotedValue($this->coal1_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->coal2_id->getSessionValue() <> "")
				$sDetailFilter .= " AND (select coal2_id from t_coal3 where t_coal4.coal3_id = t_coal3.coal3_id)=" . ew_QuotedValue($this->coal2_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->coal3_id->getSessionValue() <> "")
				$sDetailFilter .= " AND `coal3_id`=" . ew_QuotedValue($this->coal3_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_t_coal3() {
		return "(select coal1_id from t_coal2 where t_coal3.coal2_id = t_coal2.coal2_id)=@coal1_id@ AND `coal2_id`=@coal2_id@ AND `coal3_id`=@coal3_id@";
	}

	// Detail filter
	function SqlDetailFilter_t_coal3() {
		return "(select coal1_id from t_coal2 where t_coal2.coal2_id = (select coal2_id from t_coal3 where t_coal4.coal3_id = t_coal3.coal3_id))=@coal1_id@ AND (select coal2_id from t_coal3 where t_coal4.coal3_id = t_coal3.coal3_id)=@coal2_id@ AND `coal3_id`=@coal3_id@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t_coal4`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT *, (select coal1_id from t_coal2 where t_coal2.coal2_id = (select coal2_id from t_coal3 where t_coal4.coal3_id = t_coal3.coal3_id)) AS `coal1_id`, (select coal2_id from t_coal3 where t_coal4.coal3_id = t_coal3.coal3_id) AS `coal2_id` FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlSelectList = "";

	function getSqlSelectList() { // Select for List page
		$select = "";
		$select = "SELECT * FROM (" .
			"SELECT *, (select coal1_id from t_coal2 where t_coal2.coal2_id = (select coal2_id from t_coal3 where t_coal4.coal3_id = t_coal3.coal3_id)) AS `coal1_id`, (select coal2_id from t_coal3 where t_coal4.coal3_id = t_coal3.coal3_id) AS `coal2_id`, (SELECT CONCAT(`coal1_no`,'" . ew_ValueSeparator(1, $this->coal1_id) . "',`coal1_nm`) FROM `t_coal1` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`coal1_id` = `t_coal4`.`coal1_id` LIMIT 1) AS `EV__coal1_id`, (SELECT CONCAT(`coal2_no`,'" . ew_ValueSeparator(1, $this->coal2_id) . "',`coal2_nm`) FROM `t_coal2` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`coal2_id` = `t_coal4`.`coal2_id` LIMIT 1) AS `EV__coal2_id`, (SELECT CONCAT(`coal3_no`,'" . ew_ValueSeparator(1, $this->coal3_id) . "',`coal3_nm`) FROM `t_coal3` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`coal3_id` = `t_coal4`.`coal3_id` LIMIT 1) AS `EV__coal3_id` FROM `t_coal4`" .
			") `EW_TMP_TABLE`";
		return ($this->_SqlSelectList <> "") ? $this->_SqlSelectList : $select;
	}

	function SqlSelectList() { // For backward compatibility
		return $this->getSqlSelectList();
	}

	function setSqlSelectList($v) {
		$this->_SqlSelectList = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		if ($this->UseVirtualFields()) {
			$sSort = $this->getSessionOrderByList();
			return ew_BuildSelectSql($this->getSqlSelectList(), $this->getSqlWhere(), $this->getSqlGroupBy(),
				$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
		} else {
			$sSort = $this->getSessionOrderBy();
			return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
				$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
		}
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = ($this->UseVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Check if virtual fields is used in SQL
	function UseVirtualFields() {
		$sWhere = $this->getSessionWhere();
		$sOrderBy = $this->getSessionOrderByList();
		if ($sWhere <> "")
			$sWhere = " " . str_replace(array("(",")"), array("",""), $sWhere) . " ";
		if ($sOrderBy <> "")
			$sOrderBy = " " . str_replace(array("(",")"), array("",""), $sOrderBy) . " ";
		if ($this->coal1_id->AdvancedSearch->SearchValue <> "" ||
			$this->coal1_id->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->coal1_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->coal1_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if ($this->coal2_id->AdvancedSearch->SearchValue <> "" ||
			$this->coal2_id->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->coal2_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->coal2_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if ($this->coal3_id->AdvancedSearch->SearchValue <> "" ||
			$this->coal3_id->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->coal3_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->coal3_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		return FALSE;
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->coal4_id->setDbValue($conn->Insert_ID());
			$rs['coal4_id'] = $this->coal4_id->DbValue;
			if ($this->AuditTrailOnAdd)
				$this->WriteAuditTrailOnAdd($rs);
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		if ($bUpdate && $this->AuditTrailOnEdit) {
			$rsaudit = $rs;
			$fldname = 'coal4_id';
			if (!array_key_exists($fldname, $rsaudit)) $rsaudit[$fldname] = $rsold[$fldname];
			$this->WriteAuditTrailOnEdit($rsaudit, $rsold);
		}
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('coal4_id', $rs))
				ew_AddFilter($where, ew_QuotedName('coal4_id', $this->DBID) . '=' . ew_QuotedValue($rs['coal4_id'], $this->coal4_id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		if ($bDelete && $this->AuditTrailOnDelete)
			$this->WriteAuditTrailOnDelete($rs);
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`coal4_id` = @coal4_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->coal4_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@coal4_id@", ew_AdjustSql($this->coal4_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "t_coal4list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t_coal4list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t_coal4view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_coal4view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t_coal4add.php?" . $this->UrlParm($parm);
		else
			$url = "t_coal4add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t_coal4edit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t_coal4add.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t_coal4delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "t_coal3" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_coal1_id=" . urlencode($this->coal1_id->CurrentValue);
			$url .= "&fk_coal2_id=" . urlencode($this->coal2_id->CurrentValue);
			$url .= "&fk_coal3_id=" . urlencode($this->coal3_id->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "coal4_id:" . ew_VarToJson($this->coal4_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->coal4_id->CurrentValue)) {
			$sUrl .= "coal4_id=" . urlencode($this->coal4_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["coal4_id"]))
				$arKeys[] = ew_StripSlashes($_POST["coal4_id"]);
			elseif (isset($_GET["coal4_id"]))
				$arKeys[] = ew_StripSlashes($_GET["coal4_id"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->coal4_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->coal4_id->setDbValue($rs->fields('coal4_id'));
		$this->coal1_id->setDbValue($rs->fields('coal1_id'));
		$this->coal2_id->setDbValue($rs->fields('coal2_id'));
		$this->coal3_id->setDbValue($rs->fields('coal3_id'));
		$this->coal4_no->setDbValue($rs->fields('coal4_no'));
		$this->coal4_nm->setDbValue($rs->fields('coal4_nm'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// coal4_id
		// coal1_id
		// coal2_id
		// coal3_id
		// coal4_no
		// coal4_nm
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

		// coal4_id
		$this->coal4_id->LinkCustomAttributes = "";
		$this->coal4_id->HrefValue = "";
		$this->coal4_id->TooltipValue = "";

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

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// coal4_id
		$this->coal4_id->EditAttrs["class"] = "form-control";
		$this->coal4_id->EditCustomAttributes = "";
		$this->coal4_id->EditValue = $this->coal4_id->CurrentValue;
		$this->coal4_id->ViewCustomAttributes = "";

		// coal1_id
		$this->coal1_id->EditAttrs["class"] = "form-control";
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
		}

		// coal2_id
		$this->coal2_id->EditAttrs["class"] = "form-control";
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
		}

		// coal3_id
		$this->coal3_id->EditAttrs["class"] = "form-control";
		$this->coal3_id->EditCustomAttributes = "";
		if ($this->coal3_id->getSessionValue() <> "") {
			$this->coal3_id->CurrentValue = $this->coal3_id->getSessionValue();
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
		} else {
		}

		// coal4_no
		$this->coal4_no->EditAttrs["class"] = "form-control";
		$this->coal4_no->EditCustomAttributes = "";
		$this->coal4_no->EditValue = $this->coal4_no->CurrentValue;
		$this->coal4_no->PlaceHolder = ew_RemoveHtml($this->coal4_no->FldCaption());

		// coal4_nm
		$this->coal4_nm->EditAttrs["class"] = "form-control";
		$this->coal4_nm->EditCustomAttributes = "";
		$this->coal4_nm->EditValue = $this->coal4_nm->CurrentValue;
		$this->coal4_nm->PlaceHolder = ew_RemoveHtml($this->coal4_nm->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->coal1_id->Exportable) $Doc->ExportCaption($this->coal1_id);
					if ($this->coal2_id->Exportable) $Doc->ExportCaption($this->coal2_id);
					if ($this->coal3_id->Exportable) $Doc->ExportCaption($this->coal3_id);
					if ($this->coal4_no->Exportable) $Doc->ExportCaption($this->coal4_no);
					if ($this->coal4_nm->Exportable) $Doc->ExportCaption($this->coal4_nm);
				} else {
					if ($this->coal4_id->Exportable) $Doc->ExportCaption($this->coal4_id);
					if ($this->coal1_id->Exportable) $Doc->ExportCaption($this->coal1_id);
					if ($this->coal2_id->Exportable) $Doc->ExportCaption($this->coal2_id);
					if ($this->coal3_id->Exportable) $Doc->ExportCaption($this->coal3_id);
					if ($this->coal4_no->Exportable) $Doc->ExportCaption($this->coal4_no);
					if ($this->coal4_nm->Exportable) $Doc->ExportCaption($this->coal4_nm);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->coal1_id->Exportable) $Doc->ExportField($this->coal1_id);
						if ($this->coal2_id->Exportable) $Doc->ExportField($this->coal2_id);
						if ($this->coal3_id->Exportable) $Doc->ExportField($this->coal3_id);
						if ($this->coal4_no->Exportable) $Doc->ExportField($this->coal4_no);
						if ($this->coal4_nm->Exportable) $Doc->ExportField($this->coal4_nm);
					} else {
						if ($this->coal4_id->Exportable) $Doc->ExportField($this->coal4_id);
						if ($this->coal1_id->Exportable) $Doc->ExportField($this->coal1_id);
						if ($this->coal2_id->Exportable) $Doc->ExportField($this->coal2_id);
						if ($this->coal3_id->Exportable) $Doc->ExportField($this->coal3_id);
						if ($this->coal4_no->Exportable) $Doc->ExportField($this->coal4_no);
						if ($this->coal4_nm->Exportable) $Doc->ExportField($this->coal4_nm);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 't_coal4';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 't_coal4';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['coal4_id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 't_coal4';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['coal4_id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rsnew) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && array_key_exists($fldname, $rsold) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 't_coal4';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['coal4_id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$oldvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
			}
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
