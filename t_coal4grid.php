<?php include_once "t_userinfo.php" ?>
<?php

// Create page object
if (!isset($t_coal4_grid)) $t_coal4_grid = new ct_coal4_grid();

// Page init
$t_coal4_grid->Page_Init();

// Page main
$t_coal4_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_coal4_grid->Page_Render();
?>
<?php if ($t_coal4->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft_coal4grid = new ew_Form("ft_coal4grid", "grid");
ft_coal4grid.FormKeyCountName = '<?php echo $t_coal4_grid->FormKeyCountName ?>';

// Validate form
ft_coal4grid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_coal1_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_coal4->coal1_id->FldCaption(), $t_coal4->coal1_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_coal2_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_coal4->coal2_id->FldCaption(), $t_coal4->coal2_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_coal3_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_coal4->coal3_id->FldCaption(), $t_coal4->coal3_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_coal4_no");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_coal4->coal4_no->FldCaption(), $t_coal4->coal4_no->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_coal4_nm");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_coal4->coal4_nm->FldCaption(), $t_coal4->coal4_nm->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft_coal4grid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "coal1_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "coal2_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "coal3_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "coal4_no", false)) return false;
	if (ew_ValueChanged(fobj, infix, "coal4_nm", false)) return false;
	return true;
}

// Form_CustomValidate event
ft_coal4grid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_coal4grid.ValidateRequired = true;
<?php } else { ?>
ft_coal4grid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_coal4grid.Lists["x_coal1_id"] = {"LinkField":"x_coal1_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_coal1_no","x_coal1_nm","",""],"ParentFields":[],"ChildFields":["x_coal2_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_coal1"};
ft_coal4grid.Lists["x_coal2_id"] = {"LinkField":"x_coal2_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_coal2_no","x_coal2_nm","",""],"ParentFields":["x_coal1_id"],"ChildFields":["x_coal3_id"],"FilterFields":["x_coal1_id"],"Options":[],"Template":"","LinkTable":"t_coal2"};
ft_coal4grid.Lists["x_coal3_id"] = {"LinkField":"x_coal3_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_coal3_no","x_coal3_nm","",""],"ParentFields":["x_coal2_id"],"ChildFields":[],"FilterFields":["x_coal2_id"],"Options":[],"Template":"","LinkTable":"t_coal3"};

// Form object for search
</script>
<?php } ?>
<?php
if ($t_coal4->CurrentAction == "gridadd") {
	if ($t_coal4->CurrentMode == "copy") {
		$bSelectLimit = $t_coal4_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t_coal4_grid->TotalRecs = $t_coal4->SelectRecordCount();
			$t_coal4_grid->Recordset = $t_coal4_grid->LoadRecordset($t_coal4_grid->StartRec-1, $t_coal4_grid->DisplayRecs);
		} else {
			if ($t_coal4_grid->Recordset = $t_coal4_grid->LoadRecordset())
				$t_coal4_grid->TotalRecs = $t_coal4_grid->Recordset->RecordCount();
		}
		$t_coal4_grid->StartRec = 1;
		$t_coal4_grid->DisplayRecs = $t_coal4_grid->TotalRecs;
	} else {
		$t_coal4->CurrentFilter = "0=1";
		$t_coal4_grid->StartRec = 1;
		$t_coal4_grid->DisplayRecs = $t_coal4->GridAddRowCount;
	}
	$t_coal4_grid->TotalRecs = $t_coal4_grid->DisplayRecs;
	$t_coal4_grid->StopRec = $t_coal4_grid->DisplayRecs;
} else {
	$bSelectLimit = $t_coal4_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t_coal4_grid->TotalRecs <= 0)
			$t_coal4_grid->TotalRecs = $t_coal4->SelectRecordCount();
	} else {
		if (!$t_coal4_grid->Recordset && ($t_coal4_grid->Recordset = $t_coal4_grid->LoadRecordset()))
			$t_coal4_grid->TotalRecs = $t_coal4_grid->Recordset->RecordCount();
	}
	$t_coal4_grid->StartRec = 1;
	$t_coal4_grid->DisplayRecs = $t_coal4_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t_coal4_grid->Recordset = $t_coal4_grid->LoadRecordset($t_coal4_grid->StartRec-1, $t_coal4_grid->DisplayRecs);

	// Set no record found message
	if ($t_coal4->CurrentAction == "" && $t_coal4_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t_coal4_grid->setWarningMessage(ew_DeniedMsg());
		if ($t_coal4_grid->SearchWhere == "0=101")
			$t_coal4_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t_coal4_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t_coal4_grid->RenderOtherOptions();
?>
<?php $t_coal4_grid->ShowPageHeader(); ?>
<?php
$t_coal4_grid->ShowMessage();
?>
<?php if ($t_coal4_grid->TotalRecs > 0 || $t_coal4->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t_coal4">
<div id="ft_coal4grid" class="ewForm form-inline">
<?php if ($t_coal4_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($t_coal4_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_t_coal4" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t_coal4grid" class="table ewTable">
<?php echo $t_coal4->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t_coal4_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t_coal4_grid->RenderListOptions();

// Render list options (header, left)
$t_coal4_grid->ListOptions->Render("header", "left");
?>
<?php if ($t_coal4->coal1_id->Visible) { // coal1_id ?>
	<?php if ($t_coal4->SortUrl($t_coal4->coal1_id) == "") { ?>
		<th data-name="coal1_id"><div id="elh_t_coal4_coal1_id" class="t_coal4_coal1_id"><div class="ewTableHeaderCaption"><?php echo $t_coal4->coal1_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="coal1_id"><div><div id="elh_t_coal4_coal1_id" class="t_coal4_coal1_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_coal4->coal1_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_coal4->coal1_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_coal4->coal1_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_coal4->coal2_id->Visible) { // coal2_id ?>
	<?php if ($t_coal4->SortUrl($t_coal4->coal2_id) == "") { ?>
		<th data-name="coal2_id"><div id="elh_t_coal4_coal2_id" class="t_coal4_coal2_id"><div class="ewTableHeaderCaption"><?php echo $t_coal4->coal2_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="coal2_id"><div><div id="elh_t_coal4_coal2_id" class="t_coal4_coal2_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_coal4->coal2_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_coal4->coal2_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_coal4->coal2_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_coal4->coal3_id->Visible) { // coal3_id ?>
	<?php if ($t_coal4->SortUrl($t_coal4->coal3_id) == "") { ?>
		<th data-name="coal3_id"><div id="elh_t_coal4_coal3_id" class="t_coal4_coal3_id"><div class="ewTableHeaderCaption"><?php echo $t_coal4->coal3_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="coal3_id"><div><div id="elh_t_coal4_coal3_id" class="t_coal4_coal3_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_coal4->coal3_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_coal4->coal3_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_coal4->coal3_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_coal4->coal4_no->Visible) { // coal4_no ?>
	<?php if ($t_coal4->SortUrl($t_coal4->coal4_no) == "") { ?>
		<th data-name="coal4_no"><div id="elh_t_coal4_coal4_no" class="t_coal4_coal4_no"><div class="ewTableHeaderCaption"><?php echo $t_coal4->coal4_no->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="coal4_no"><div><div id="elh_t_coal4_coal4_no" class="t_coal4_coal4_no">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_coal4->coal4_no->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_coal4->coal4_no->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_coal4->coal4_no->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_coal4->coal4_nm->Visible) { // coal4_nm ?>
	<?php if ($t_coal4->SortUrl($t_coal4->coal4_nm) == "") { ?>
		<th data-name="coal4_nm"><div id="elh_t_coal4_coal4_nm" class="t_coal4_coal4_nm"><div class="ewTableHeaderCaption"><?php echo $t_coal4->coal4_nm->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="coal4_nm"><div><div id="elh_t_coal4_coal4_nm" class="t_coal4_coal4_nm">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_coal4->coal4_nm->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_coal4->coal4_nm->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_coal4->coal4_nm->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t_coal4_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t_coal4_grid->StartRec = 1;
$t_coal4_grid->StopRec = $t_coal4_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t_coal4_grid->FormKeyCountName) && ($t_coal4->CurrentAction == "gridadd" || $t_coal4->CurrentAction == "gridedit" || $t_coal4->CurrentAction == "F")) {
		$t_coal4_grid->KeyCount = $objForm->GetValue($t_coal4_grid->FormKeyCountName);
		$t_coal4_grid->StopRec = $t_coal4_grid->StartRec + $t_coal4_grid->KeyCount - 1;
	}
}
$t_coal4_grid->RecCnt = $t_coal4_grid->StartRec - 1;
if ($t_coal4_grid->Recordset && !$t_coal4_grid->Recordset->EOF) {
	$t_coal4_grid->Recordset->MoveFirst();
	$bSelectLimit = $t_coal4_grid->UseSelectLimit;
	if (!$bSelectLimit && $t_coal4_grid->StartRec > 1)
		$t_coal4_grid->Recordset->Move($t_coal4_grid->StartRec - 1);
} elseif (!$t_coal4->AllowAddDeleteRow && $t_coal4_grid->StopRec == 0) {
	$t_coal4_grid->StopRec = $t_coal4->GridAddRowCount;
}

// Initialize aggregate
$t_coal4->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t_coal4->ResetAttrs();
$t_coal4_grid->RenderRow();
if ($t_coal4->CurrentAction == "gridadd")
	$t_coal4_grid->RowIndex = 0;
if ($t_coal4->CurrentAction == "gridedit")
	$t_coal4_grid->RowIndex = 0;
while ($t_coal4_grid->RecCnt < $t_coal4_grid->StopRec) {
	$t_coal4_grid->RecCnt++;
	if (intval($t_coal4_grid->RecCnt) >= intval($t_coal4_grid->StartRec)) {
		$t_coal4_grid->RowCnt++;
		if ($t_coal4->CurrentAction == "gridadd" || $t_coal4->CurrentAction == "gridedit" || $t_coal4->CurrentAction == "F") {
			$t_coal4_grid->RowIndex++;
			$objForm->Index = $t_coal4_grid->RowIndex;
			if ($objForm->HasValue($t_coal4_grid->FormActionName))
				$t_coal4_grid->RowAction = strval($objForm->GetValue($t_coal4_grid->FormActionName));
			elseif ($t_coal4->CurrentAction == "gridadd")
				$t_coal4_grid->RowAction = "insert";
			else
				$t_coal4_grid->RowAction = "";
		}

		// Set up key count
		$t_coal4_grid->KeyCount = $t_coal4_grid->RowIndex;

		// Init row class and style
		$t_coal4->ResetAttrs();
		$t_coal4->CssClass = "";
		if ($t_coal4->CurrentAction == "gridadd") {
			if ($t_coal4->CurrentMode == "copy") {
				$t_coal4_grid->LoadRowValues($t_coal4_grid->Recordset); // Load row values
				$t_coal4_grid->SetRecordKey($t_coal4_grid->RowOldKey, $t_coal4_grid->Recordset); // Set old record key
			} else {
				$t_coal4_grid->LoadDefaultValues(); // Load default values
				$t_coal4_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t_coal4_grid->LoadRowValues($t_coal4_grid->Recordset); // Load row values
		}
		$t_coal4->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t_coal4->CurrentAction == "gridadd") // Grid add
			$t_coal4->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t_coal4->CurrentAction == "gridadd" && $t_coal4->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t_coal4_grid->RestoreCurrentRowFormValues($t_coal4_grid->RowIndex); // Restore form values
		if ($t_coal4->CurrentAction == "gridedit") { // Grid edit
			if ($t_coal4->EventCancelled) {
				$t_coal4_grid->RestoreCurrentRowFormValues($t_coal4_grid->RowIndex); // Restore form values
			}
			if ($t_coal4_grid->RowAction == "insert")
				$t_coal4->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t_coal4->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t_coal4->CurrentAction == "gridedit" && ($t_coal4->RowType == EW_ROWTYPE_EDIT || $t_coal4->RowType == EW_ROWTYPE_ADD) && $t_coal4->EventCancelled) // Update failed
			$t_coal4_grid->RestoreCurrentRowFormValues($t_coal4_grid->RowIndex); // Restore form values
		if ($t_coal4->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t_coal4_grid->EditRowCnt++;
		if ($t_coal4->CurrentAction == "F") // Confirm row
			$t_coal4_grid->RestoreCurrentRowFormValues($t_coal4_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t_coal4->RowAttrs = array_merge($t_coal4->RowAttrs, array('data-rowindex'=>$t_coal4_grid->RowCnt, 'id'=>'r' . $t_coal4_grid->RowCnt . '_t_coal4', 'data-rowtype'=>$t_coal4->RowType));

		// Render row
		$t_coal4_grid->RenderRow();

		// Render list options
		$t_coal4_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t_coal4_grid->RowAction <> "delete" && $t_coal4_grid->RowAction <> "insertdelete" && !($t_coal4_grid->RowAction == "insert" && $t_coal4->CurrentAction == "F" && $t_coal4_grid->EmptyRow())) {
?>
	<tr<?php echo $t_coal4->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_coal4_grid->ListOptions->Render("body", "left", $t_coal4_grid->RowCnt);
?>
	<?php if ($t_coal4->coal1_id->Visible) { // coal1_id ?>
		<td data-name="coal1_id"<?php echo $t_coal4->coal1_id->CellAttributes() ?>>
<?php if ($t_coal4->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t_coal4->coal1_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal1_id" class="form-group t_coal4_coal1_id">
<span<?php echo $t_coal4->coal1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal1_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal4->coal1_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal1_id" class="form-group t_coal4_coal1_id">
<?php $t_coal4->coal1_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_coal4->coal1_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id"><?php echo (strval($t_coal4->coal1_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal4->coal1_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal4->coal1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal4" data-field="x_coal1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal4->coal1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo $t_coal4->coal1_id->CurrentValue ?>"<?php echo $t_coal4->coal1_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" id="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo $t_coal4->coal1_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal1_id" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal4->coal1_id->OldValue) ?>">
<?php } ?>
<?php if ($t_coal4->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t_coal4->coal1_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal1_id" class="form-group t_coal4_coal1_id">
<span<?php echo $t_coal4->coal1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal1_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal4->coal1_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal1_id" class="form-group t_coal4_coal1_id">
<?php $t_coal4->coal1_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_coal4->coal1_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id"><?php echo (strval($t_coal4->coal1_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal4->coal1_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal4->coal1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal4" data-field="x_coal1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal4->coal1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo $t_coal4->coal1_id->CurrentValue ?>"<?php echo $t_coal4->coal1_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" id="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo $t_coal4->coal1_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($t_coal4->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal1_id" class="t_coal4_coal1_id">
<span<?php echo $t_coal4->coal1_id->ViewAttributes() ?>>
<?php echo $t_coal4->coal1_id->ListViewValue() ?></span>
</span>
<?php if ($t_coal4->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal1_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal4->coal1_id->FormValue) ?>">
<input type="hidden" data-table="t_coal4" data-field="x_coal1_id" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal4->coal1_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal1_id" name="ft_coal4grid$x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" id="ft_coal4grid$x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal4->coal1_id->FormValue) ?>">
<input type="hidden" data-table="t_coal4" data-field="x_coal1_id" name="ft_coal4grid$o<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" id="ft_coal4grid$o<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal4->coal1_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t_coal4_grid->PageObjName . "_row_" . $t_coal4_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t_coal4->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal4_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_id" value="<?php echo ew_HtmlEncode($t_coal4->coal4_id->CurrentValue) ?>">
<input type="hidden" data-table="t_coal4" data-field="x_coal4_id" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_id" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_id" value="<?php echo ew_HtmlEncode($t_coal4->coal4_id->OldValue) ?>">
<?php } ?>
<?php if ($t_coal4->RowType == EW_ROWTYPE_EDIT || $t_coal4->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal4_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_id" value="<?php echo ew_HtmlEncode($t_coal4->coal4_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t_coal4->coal2_id->Visible) { // coal2_id ?>
		<td data-name="coal2_id"<?php echo $t_coal4->coal2_id->CellAttributes() ?>>
<?php if ($t_coal4->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t_coal4->coal2_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal2_id" class="form-group t_coal4_coal2_id">
<span<?php echo $t_coal4->coal2_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal2_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo ew_HtmlEncode($t_coal4->coal2_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal2_id" class="form-group t_coal4_coal2_id">
<?php $t_coal4->coal2_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_coal4->coal2_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id"><?php echo (strval($t_coal4->coal2_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal4->coal2_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal4->coal2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal4" data-field="x_coal2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal4->coal2_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo $t_coal4->coal2_id->CurrentValue ?>"<?php echo $t_coal4->coal2_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" id="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo $t_coal4->coal2_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal2_id" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo ew_HtmlEncode($t_coal4->coal2_id->OldValue) ?>">
<?php } ?>
<?php if ($t_coal4->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t_coal4->coal2_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal2_id" class="form-group t_coal4_coal2_id">
<span<?php echo $t_coal4->coal2_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal2_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo ew_HtmlEncode($t_coal4->coal2_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal2_id" class="form-group t_coal4_coal2_id">
<?php $t_coal4->coal2_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_coal4->coal2_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id"><?php echo (strval($t_coal4->coal2_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal4->coal2_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal4->coal2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal4" data-field="x_coal2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal4->coal2_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo $t_coal4->coal2_id->CurrentValue ?>"<?php echo $t_coal4->coal2_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" id="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo $t_coal4->coal2_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($t_coal4->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal2_id" class="t_coal4_coal2_id">
<span<?php echo $t_coal4->coal2_id->ViewAttributes() ?>>
<?php echo $t_coal4->coal2_id->ListViewValue() ?></span>
</span>
<?php if ($t_coal4->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal2_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo ew_HtmlEncode($t_coal4->coal2_id->FormValue) ?>">
<input type="hidden" data-table="t_coal4" data-field="x_coal2_id" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo ew_HtmlEncode($t_coal4->coal2_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal2_id" name="ft_coal4grid$x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" id="ft_coal4grid$x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo ew_HtmlEncode($t_coal4->coal2_id->FormValue) ?>">
<input type="hidden" data-table="t_coal4" data-field="x_coal2_id" name="ft_coal4grid$o<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" id="ft_coal4grid$o<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo ew_HtmlEncode($t_coal4->coal2_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_coal4->coal3_id->Visible) { // coal3_id ?>
		<td data-name="coal3_id"<?php echo $t_coal4->coal3_id->CellAttributes() ?>>
<?php if ($t_coal4->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t_coal4->coal3_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal3_id" class="form-group t_coal4_coal3_id">
<span<?php echo $t_coal4->coal3_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal3_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo ew_HtmlEncode($t_coal4->coal3_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal3_id" class="form-group t_coal4_coal3_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id"><?php echo (strval($t_coal4->coal3_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal4->coal3_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal4->coal3_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal4" data-field="x_coal3_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal4->coal3_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo $t_coal4->coal3_id->CurrentValue ?>"<?php echo $t_coal4->coal3_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" id="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo $t_coal4->coal3_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal3_id" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo ew_HtmlEncode($t_coal4->coal3_id->OldValue) ?>">
<?php } ?>
<?php if ($t_coal4->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t_coal4->coal3_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal3_id" class="form-group t_coal4_coal3_id">
<span<?php echo $t_coal4->coal3_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal3_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo ew_HtmlEncode($t_coal4->coal3_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal3_id" class="form-group t_coal4_coal3_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id"><?php echo (strval($t_coal4->coal3_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal4->coal3_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal4->coal3_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal4" data-field="x_coal3_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal4->coal3_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo $t_coal4->coal3_id->CurrentValue ?>"<?php echo $t_coal4->coal3_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" id="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo $t_coal4->coal3_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($t_coal4->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal3_id" class="t_coal4_coal3_id">
<span<?php echo $t_coal4->coal3_id->ViewAttributes() ?>>
<?php echo $t_coal4->coal3_id->ListViewValue() ?></span>
</span>
<?php if ($t_coal4->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal3_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo ew_HtmlEncode($t_coal4->coal3_id->FormValue) ?>">
<input type="hidden" data-table="t_coal4" data-field="x_coal3_id" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo ew_HtmlEncode($t_coal4->coal3_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal3_id" name="ft_coal4grid$x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" id="ft_coal4grid$x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo ew_HtmlEncode($t_coal4->coal3_id->FormValue) ?>">
<input type="hidden" data-table="t_coal4" data-field="x_coal3_id" name="ft_coal4grid$o<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" id="ft_coal4grid$o<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo ew_HtmlEncode($t_coal4->coal3_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_coal4->coal4_no->Visible) { // coal4_no ?>
		<td data-name="coal4_no"<?php echo $t_coal4->coal4_no->CellAttributes() ?>>
<?php if ($t_coal4->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal4_no" class="form-group t_coal4_coal4_no">
<input type="text" data-table="t_coal4" data-field="x_coal4_no" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($t_coal4->coal4_no->getPlaceHolder()) ?>" value="<?php echo $t_coal4->coal4_no->EditValue ?>"<?php echo $t_coal4->coal4_no->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_coal4" data-field="x_coal4_no" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" value="<?php echo ew_HtmlEncode($t_coal4->coal4_no->OldValue) ?>">
<?php } ?>
<?php if ($t_coal4->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal4_no" class="form-group t_coal4_coal4_no">
<input type="text" data-table="t_coal4" data-field="x_coal4_no" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($t_coal4->coal4_no->getPlaceHolder()) ?>" value="<?php echo $t_coal4->coal4_no->EditValue ?>"<?php echo $t_coal4->coal4_no->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_coal4->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal4_no" class="t_coal4_coal4_no">
<span<?php echo $t_coal4->coal4_no->ViewAttributes() ?>>
<?php echo $t_coal4->coal4_no->ListViewValue() ?></span>
</span>
<?php if ($t_coal4->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal4_no" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" value="<?php echo ew_HtmlEncode($t_coal4->coal4_no->FormValue) ?>">
<input type="hidden" data-table="t_coal4" data-field="x_coal4_no" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" value="<?php echo ew_HtmlEncode($t_coal4->coal4_no->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal4_no" name="ft_coal4grid$x<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" id="ft_coal4grid$x<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" value="<?php echo ew_HtmlEncode($t_coal4->coal4_no->FormValue) ?>">
<input type="hidden" data-table="t_coal4" data-field="x_coal4_no" name="ft_coal4grid$o<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" id="ft_coal4grid$o<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" value="<?php echo ew_HtmlEncode($t_coal4->coal4_no->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_coal4->coal4_nm->Visible) { // coal4_nm ?>
		<td data-name="coal4_nm"<?php echo $t_coal4->coal4_nm->CellAttributes() ?>>
<?php if ($t_coal4->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal4_nm" class="form-group t_coal4_coal4_nm">
<input type="text" data-table="t_coal4" data-field="x_coal4_nm" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_coal4->coal4_nm->getPlaceHolder()) ?>" value="<?php echo $t_coal4->coal4_nm->EditValue ?>"<?php echo $t_coal4->coal4_nm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_coal4" data-field="x_coal4_nm" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" value="<?php echo ew_HtmlEncode($t_coal4->coal4_nm->OldValue) ?>">
<?php } ?>
<?php if ($t_coal4->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal4_nm" class="form-group t_coal4_coal4_nm">
<input type="text" data-table="t_coal4" data-field="x_coal4_nm" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_coal4->coal4_nm->getPlaceHolder()) ?>" value="<?php echo $t_coal4->coal4_nm->EditValue ?>"<?php echo $t_coal4->coal4_nm->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_coal4->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_coal4_grid->RowCnt ?>_t_coal4_coal4_nm" class="t_coal4_coal4_nm">
<span<?php echo $t_coal4->coal4_nm->ViewAttributes() ?>>
<?php echo $t_coal4->coal4_nm->ListViewValue() ?></span>
</span>
<?php if ($t_coal4->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal4_nm" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" value="<?php echo ew_HtmlEncode($t_coal4->coal4_nm->FormValue) ?>">
<input type="hidden" data-table="t_coal4" data-field="x_coal4_nm" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" value="<?php echo ew_HtmlEncode($t_coal4->coal4_nm->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal4_nm" name="ft_coal4grid$x<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" id="ft_coal4grid$x<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" value="<?php echo ew_HtmlEncode($t_coal4->coal4_nm->FormValue) ?>">
<input type="hidden" data-table="t_coal4" data-field="x_coal4_nm" name="ft_coal4grid$o<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" id="ft_coal4grid$o<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" value="<?php echo ew_HtmlEncode($t_coal4->coal4_nm->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_coal4_grid->ListOptions->Render("body", "right", $t_coal4_grid->RowCnt);
?>
	</tr>
<?php if ($t_coal4->RowType == EW_ROWTYPE_ADD || $t_coal4->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft_coal4grid.UpdateOpts(<?php echo $t_coal4_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t_coal4->CurrentAction <> "gridadd" || $t_coal4->CurrentMode == "copy")
		if (!$t_coal4_grid->Recordset->EOF) $t_coal4_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t_coal4->CurrentMode == "add" || $t_coal4->CurrentMode == "copy" || $t_coal4->CurrentMode == "edit") {
		$t_coal4_grid->RowIndex = '$rowindex$';
		$t_coal4_grid->LoadDefaultValues();

		// Set row properties
		$t_coal4->ResetAttrs();
		$t_coal4->RowAttrs = array_merge($t_coal4->RowAttrs, array('data-rowindex'=>$t_coal4_grid->RowIndex, 'id'=>'r0_t_coal4', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t_coal4->RowAttrs["class"], "ewTemplate");
		$t_coal4->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t_coal4_grid->RenderRow();

		// Render list options
		$t_coal4_grid->RenderListOptions();
		$t_coal4_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t_coal4->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_coal4_grid->ListOptions->Render("body", "left", $t_coal4_grid->RowIndex);
?>
	<?php if ($t_coal4->coal1_id->Visible) { // coal1_id ?>
		<td data-name="coal1_id">
<?php if ($t_coal4->CurrentAction <> "F") { ?>
<?php if ($t_coal4->coal1_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t_coal4_coal1_id" class="form-group t_coal4_coal1_id">
<span<?php echo $t_coal4->coal1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal1_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal4->coal1_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t_coal4_coal1_id" class="form-group t_coal4_coal1_id">
<?php $t_coal4->coal1_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_coal4->coal1_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id"><?php echo (strval($t_coal4->coal1_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal4->coal1_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal4->coal1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal4" data-field="x_coal1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal4->coal1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo $t_coal4->coal1_id->CurrentValue ?>"<?php echo $t_coal4->coal1_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" id="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo $t_coal4->coal1_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t_coal4_coal1_id" class="form-group t_coal4_coal1_id">
<span<?php echo $t_coal4->coal1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal1_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_coal4" data-field="x_coal1_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal4->coal1_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal1_id" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal4->coal1_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_coal4->coal2_id->Visible) { // coal2_id ?>
		<td data-name="coal2_id">
<?php if ($t_coal4->CurrentAction <> "F") { ?>
<?php if ($t_coal4->coal2_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t_coal4_coal2_id" class="form-group t_coal4_coal2_id">
<span<?php echo $t_coal4->coal2_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal2_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo ew_HtmlEncode($t_coal4->coal2_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t_coal4_coal2_id" class="form-group t_coal4_coal2_id">
<?php $t_coal4->coal2_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_coal4->coal2_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id"><?php echo (strval($t_coal4->coal2_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal4->coal2_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal4->coal2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal4" data-field="x_coal2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal4->coal2_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo $t_coal4->coal2_id->CurrentValue ?>"<?php echo $t_coal4->coal2_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" id="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo $t_coal4->coal2_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t_coal4_coal2_id" class="form-group t_coal4_coal2_id">
<span<?php echo $t_coal4->coal2_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal2_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_coal4" data-field="x_coal2_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo ew_HtmlEncode($t_coal4->coal2_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal2_id" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal2_id" value="<?php echo ew_HtmlEncode($t_coal4->coal2_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_coal4->coal3_id->Visible) { // coal3_id ?>
		<td data-name="coal3_id">
<?php if ($t_coal4->CurrentAction <> "F") { ?>
<?php if ($t_coal4->coal3_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t_coal4_coal3_id" class="form-group t_coal4_coal3_id">
<span<?php echo $t_coal4->coal3_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal3_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo ew_HtmlEncode($t_coal4->coal3_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t_coal4_coal3_id" class="form-group t_coal4_coal3_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id"><?php echo (strval($t_coal4->coal3_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal4->coal3_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal4->coal3_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal4" data-field="x_coal3_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal4->coal3_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo $t_coal4->coal3_id->CurrentValue ?>"<?php echo $t_coal4->coal3_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" id="s_x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo $t_coal4->coal3_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t_coal4_coal3_id" class="form-group t_coal4_coal3_id">
<span<?php echo $t_coal4->coal3_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal3_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_coal4" data-field="x_coal3_id" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo ew_HtmlEncode($t_coal4->coal3_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal3_id" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal3_id" value="<?php echo ew_HtmlEncode($t_coal4->coal3_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_coal4->coal4_no->Visible) { // coal4_no ?>
		<td data-name="coal4_no">
<?php if ($t_coal4->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_coal4_coal4_no" class="form-group t_coal4_coal4_no">
<input type="text" data-table="t_coal4" data-field="x_coal4_no" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($t_coal4->coal4_no->getPlaceHolder()) ?>" value="<?php echo $t_coal4->coal4_no->EditValue ?>"<?php echo $t_coal4->coal4_no->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_coal4_coal4_no" class="form-group t_coal4_coal4_no">
<span<?php echo $t_coal4->coal4_no->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal4_no->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_coal4" data-field="x_coal4_no" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" value="<?php echo ew_HtmlEncode($t_coal4->coal4_no->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal4_no" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_no" value="<?php echo ew_HtmlEncode($t_coal4->coal4_no->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_coal4->coal4_nm->Visible) { // coal4_nm ?>
		<td data-name="coal4_nm">
<?php if ($t_coal4->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_coal4_coal4_nm" class="form-group t_coal4_coal4_nm">
<input type="text" data-table="t_coal4" data-field="x_coal4_nm" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_coal4->coal4_nm->getPlaceHolder()) ?>" value="<?php echo $t_coal4->coal4_nm->EditValue ?>"<?php echo $t_coal4->coal4_nm->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_coal4_coal4_nm" class="form-group t_coal4_coal4_nm">
<span<?php echo $t_coal4->coal4_nm->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal4->coal4_nm->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_coal4" data-field="x_coal4_nm" name="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" id="x<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" value="<?php echo ew_HtmlEncode($t_coal4->coal4_nm->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_coal4" data-field="x_coal4_nm" name="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" id="o<?php echo $t_coal4_grid->RowIndex ?>_coal4_nm" value="<?php echo ew_HtmlEncode($t_coal4->coal4_nm->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_coal4_grid->ListOptions->Render("body", "right", $t_coal4_grid->RowCnt);
?>
<script type="text/javascript">
ft_coal4grid.UpdateOpts(<?php echo $t_coal4_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t_coal4->CurrentMode == "add" || $t_coal4->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t_coal4_grid->FormKeyCountName ?>" id="<?php echo $t_coal4_grid->FormKeyCountName ?>" value="<?php echo $t_coal4_grid->KeyCount ?>">
<?php echo $t_coal4_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_coal4->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t_coal4_grid->FormKeyCountName ?>" id="<?php echo $t_coal4_grid->FormKeyCountName ?>" value="<?php echo $t_coal4_grid->KeyCount ?>">
<?php echo $t_coal4_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_coal4->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft_coal4grid">
</div>
<?php

// Close recordset
if ($t_coal4_grid->Recordset)
	$t_coal4_grid->Recordset->Close();
?>
<?php if ($t_coal4_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t_coal4_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t_coal4_grid->TotalRecs == 0 && $t_coal4->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_coal4_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t_coal4->Export == "") { ?>
<script type="text/javascript">
ft_coal4grid.Init();
</script>
<?php } ?>
<?php
$t_coal4_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t_coal4_grid->Page_Terminate();
?>
