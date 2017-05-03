<?php include_once "t_userinfo.php" ?>
<?php

// Create page object
if (!isset($t_coal2_grid)) $t_coal2_grid = new ct_coal2_grid();

// Page init
$t_coal2_grid->Page_Init();

// Page main
$t_coal2_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_coal2_grid->Page_Render();
?>
<?php if ($t_coal2->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft_coal2grid = new ew_Form("ft_coal2grid", "grid");
ft_coal2grid.FormKeyCountName = '<?php echo $t_coal2_grid->FormKeyCountName ?>';

// Validate form
ft_coal2grid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_coal2->coal1_id->FldCaption(), $t_coal2->coal1_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_coal2_no");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_coal2->coal2_no->FldCaption(), $t_coal2->coal2_no->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_coal2_nm");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_coal2->coal2_nm->FldCaption(), $t_coal2->coal2_nm->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft_coal2grid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "coal1_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "coal2_no", false)) return false;
	if (ew_ValueChanged(fobj, infix, "coal2_nm", false)) return false;
	return true;
}

// Form_CustomValidate event
ft_coal2grid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_coal2grid.ValidateRequired = true;
<?php } else { ?>
ft_coal2grid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_coal2grid.Lists["x_coal1_id"] = {"LinkField":"x_coal1_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_coal1_nm","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_coal1"};

// Form object for search
</script>
<?php } ?>
<?php
if ($t_coal2->CurrentAction == "gridadd") {
	if ($t_coal2->CurrentMode == "copy") {
		$bSelectLimit = $t_coal2_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t_coal2_grid->TotalRecs = $t_coal2->SelectRecordCount();
			$t_coal2_grid->Recordset = $t_coal2_grid->LoadRecordset($t_coal2_grid->StartRec-1, $t_coal2_grid->DisplayRecs);
		} else {
			if ($t_coal2_grid->Recordset = $t_coal2_grid->LoadRecordset())
				$t_coal2_grid->TotalRecs = $t_coal2_grid->Recordset->RecordCount();
		}
		$t_coal2_grid->StartRec = 1;
		$t_coal2_grid->DisplayRecs = $t_coal2_grid->TotalRecs;
	} else {
		$t_coal2->CurrentFilter = "0=1";
		$t_coal2_grid->StartRec = 1;
		$t_coal2_grid->DisplayRecs = $t_coal2->GridAddRowCount;
	}
	$t_coal2_grid->TotalRecs = $t_coal2_grid->DisplayRecs;
	$t_coal2_grid->StopRec = $t_coal2_grid->DisplayRecs;
} else {
	$bSelectLimit = $t_coal2_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t_coal2_grid->TotalRecs <= 0)
			$t_coal2_grid->TotalRecs = $t_coal2->SelectRecordCount();
	} else {
		if (!$t_coal2_grid->Recordset && ($t_coal2_grid->Recordset = $t_coal2_grid->LoadRecordset()))
			$t_coal2_grid->TotalRecs = $t_coal2_grid->Recordset->RecordCount();
	}
	$t_coal2_grid->StartRec = 1;
	$t_coal2_grid->DisplayRecs = $t_coal2_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t_coal2_grid->Recordset = $t_coal2_grid->LoadRecordset($t_coal2_grid->StartRec-1, $t_coal2_grid->DisplayRecs);

	// Set no record found message
	if ($t_coal2->CurrentAction == "" && $t_coal2_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t_coal2_grid->setWarningMessage(ew_DeniedMsg());
		if ($t_coal2_grid->SearchWhere == "0=101")
			$t_coal2_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t_coal2_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t_coal2_grid->RenderOtherOptions();
?>
<?php $t_coal2_grid->ShowPageHeader(); ?>
<?php
$t_coal2_grid->ShowMessage();
?>
<?php if ($t_coal2_grid->TotalRecs > 0 || $t_coal2->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t_coal2">
<div id="ft_coal2grid" class="ewForm form-inline">
<?php if ($t_coal2_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($t_coal2_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_t_coal2" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t_coal2grid" class="table ewTable">
<?php echo $t_coal2->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t_coal2_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t_coal2_grid->RenderListOptions();

// Render list options (header, left)
$t_coal2_grid->ListOptions->Render("header", "left");
?>
<?php if ($t_coal2->coal1_id->Visible) { // coal1_id ?>
	<?php if ($t_coal2->SortUrl($t_coal2->coal1_id) == "") { ?>
		<th data-name="coal1_id"><div id="elh_t_coal2_coal1_id" class="t_coal2_coal1_id"><div class="ewTableHeaderCaption"><?php echo $t_coal2->coal1_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="coal1_id"><div><div id="elh_t_coal2_coal1_id" class="t_coal2_coal1_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_coal2->coal1_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_coal2->coal1_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_coal2->coal1_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_coal2->coal2_no->Visible) { // coal2_no ?>
	<?php if ($t_coal2->SortUrl($t_coal2->coal2_no) == "") { ?>
		<th data-name="coal2_no"><div id="elh_t_coal2_coal2_no" class="t_coal2_coal2_no"><div class="ewTableHeaderCaption"><?php echo $t_coal2->coal2_no->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="coal2_no"><div><div id="elh_t_coal2_coal2_no" class="t_coal2_coal2_no">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_coal2->coal2_no->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_coal2->coal2_no->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_coal2->coal2_no->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_coal2->coal2_nm->Visible) { // coal2_nm ?>
	<?php if ($t_coal2->SortUrl($t_coal2->coal2_nm) == "") { ?>
		<th data-name="coal2_nm"><div id="elh_t_coal2_coal2_nm" class="t_coal2_coal2_nm"><div class="ewTableHeaderCaption"><?php echo $t_coal2->coal2_nm->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="coal2_nm"><div><div id="elh_t_coal2_coal2_nm" class="t_coal2_coal2_nm">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_coal2->coal2_nm->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_coal2->coal2_nm->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_coal2->coal2_nm->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t_coal2_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t_coal2_grid->StartRec = 1;
$t_coal2_grid->StopRec = $t_coal2_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t_coal2_grid->FormKeyCountName) && ($t_coal2->CurrentAction == "gridadd" || $t_coal2->CurrentAction == "gridedit" || $t_coal2->CurrentAction == "F")) {
		$t_coal2_grid->KeyCount = $objForm->GetValue($t_coal2_grid->FormKeyCountName);
		$t_coal2_grid->StopRec = $t_coal2_grid->StartRec + $t_coal2_grid->KeyCount - 1;
	}
}
$t_coal2_grid->RecCnt = $t_coal2_grid->StartRec - 1;
if ($t_coal2_grid->Recordset && !$t_coal2_grid->Recordset->EOF) {
	$t_coal2_grid->Recordset->MoveFirst();
	$bSelectLimit = $t_coal2_grid->UseSelectLimit;
	if (!$bSelectLimit && $t_coal2_grid->StartRec > 1)
		$t_coal2_grid->Recordset->Move($t_coal2_grid->StartRec - 1);
} elseif (!$t_coal2->AllowAddDeleteRow && $t_coal2_grid->StopRec == 0) {
	$t_coal2_grid->StopRec = $t_coal2->GridAddRowCount;
}

// Initialize aggregate
$t_coal2->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t_coal2->ResetAttrs();
$t_coal2_grid->RenderRow();
if ($t_coal2->CurrentAction == "gridadd")
	$t_coal2_grid->RowIndex = 0;
if ($t_coal2->CurrentAction == "gridedit")
	$t_coal2_grid->RowIndex = 0;
while ($t_coal2_grid->RecCnt < $t_coal2_grid->StopRec) {
	$t_coal2_grid->RecCnt++;
	if (intval($t_coal2_grid->RecCnt) >= intval($t_coal2_grid->StartRec)) {
		$t_coal2_grid->RowCnt++;
		if ($t_coal2->CurrentAction == "gridadd" || $t_coal2->CurrentAction == "gridedit" || $t_coal2->CurrentAction == "F") {
			$t_coal2_grid->RowIndex++;
			$objForm->Index = $t_coal2_grid->RowIndex;
			if ($objForm->HasValue($t_coal2_grid->FormActionName))
				$t_coal2_grid->RowAction = strval($objForm->GetValue($t_coal2_grid->FormActionName));
			elseif ($t_coal2->CurrentAction == "gridadd")
				$t_coal2_grid->RowAction = "insert";
			else
				$t_coal2_grid->RowAction = "";
		}

		// Set up key count
		$t_coal2_grid->KeyCount = $t_coal2_grid->RowIndex;

		// Init row class and style
		$t_coal2->ResetAttrs();
		$t_coal2->CssClass = "";
		if ($t_coal2->CurrentAction == "gridadd") {
			if ($t_coal2->CurrentMode == "copy") {
				$t_coal2_grid->LoadRowValues($t_coal2_grid->Recordset); // Load row values
				$t_coal2_grid->SetRecordKey($t_coal2_grid->RowOldKey, $t_coal2_grid->Recordset); // Set old record key
			} else {
				$t_coal2_grid->LoadDefaultValues(); // Load default values
				$t_coal2_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t_coal2_grid->LoadRowValues($t_coal2_grid->Recordset); // Load row values
		}
		$t_coal2->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t_coal2->CurrentAction == "gridadd") // Grid add
			$t_coal2->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t_coal2->CurrentAction == "gridadd" && $t_coal2->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t_coal2_grid->RestoreCurrentRowFormValues($t_coal2_grid->RowIndex); // Restore form values
		if ($t_coal2->CurrentAction == "gridedit") { // Grid edit
			if ($t_coal2->EventCancelled) {
				$t_coal2_grid->RestoreCurrentRowFormValues($t_coal2_grid->RowIndex); // Restore form values
			}
			if ($t_coal2_grid->RowAction == "insert")
				$t_coal2->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t_coal2->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t_coal2->CurrentAction == "gridedit" && ($t_coal2->RowType == EW_ROWTYPE_EDIT || $t_coal2->RowType == EW_ROWTYPE_ADD) && $t_coal2->EventCancelled) // Update failed
			$t_coal2_grid->RestoreCurrentRowFormValues($t_coal2_grid->RowIndex); // Restore form values
		if ($t_coal2->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t_coal2_grid->EditRowCnt++;
		if ($t_coal2->CurrentAction == "F") // Confirm row
			$t_coal2_grid->RestoreCurrentRowFormValues($t_coal2_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t_coal2->RowAttrs = array_merge($t_coal2->RowAttrs, array('data-rowindex'=>$t_coal2_grid->RowCnt, 'id'=>'r' . $t_coal2_grid->RowCnt . '_t_coal2', 'data-rowtype'=>$t_coal2->RowType));

		// Render row
		$t_coal2_grid->RenderRow();

		// Render list options
		$t_coal2_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t_coal2_grid->RowAction <> "delete" && $t_coal2_grid->RowAction <> "insertdelete" && !($t_coal2_grid->RowAction == "insert" && $t_coal2->CurrentAction == "F" && $t_coal2_grid->EmptyRow())) {
?>
	<tr<?php echo $t_coal2->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_coal2_grid->ListOptions->Render("body", "left", $t_coal2_grid->RowCnt);
?>
	<?php if ($t_coal2->coal1_id->Visible) { // coal1_id ?>
		<td data-name="coal1_id"<?php echo $t_coal2->coal1_id->CellAttributes() ?>>
<?php if ($t_coal2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t_coal2->coal1_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_coal2_grid->RowCnt ?>_t_coal2_coal1_id" class="form-group t_coal2_coal1_id">
<span<?php echo $t_coal2->coal1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal2->coal1_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal2->coal1_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t_coal2_grid->RowCnt ?>_t_coal2_coal1_id" class="form-group t_coal2_coal1_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id"><?php echo (strval($t_coal2->coal1_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal2->coal1_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal2->coal1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal2" data-field="x_coal1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal2->coal1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo $t_coal2->coal1_id->CurrentValue ?>"<?php echo $t_coal2->coal1_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" id="s_x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo $t_coal2->coal1_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="t_coal2" data-field="x_coal1_id" name="o<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" id="o<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal2->coal1_id->OldValue) ?>">
<?php } ?>
<?php if ($t_coal2->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t_coal2->coal1_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_coal2_grid->RowCnt ?>_t_coal2_coal1_id" class="form-group t_coal2_coal1_id">
<span<?php echo $t_coal2->coal1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal2->coal1_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal2->coal1_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t_coal2_grid->RowCnt ?>_t_coal2_coal1_id" class="form-group t_coal2_coal1_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id"><?php echo (strval($t_coal2->coal1_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal2->coal1_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal2->coal1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal2" data-field="x_coal1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal2->coal1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo $t_coal2->coal1_id->CurrentValue ?>"<?php echo $t_coal2->coal1_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" id="s_x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo $t_coal2->coal1_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($t_coal2->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_coal2_grid->RowCnt ?>_t_coal2_coal1_id" class="t_coal2_coal1_id">
<span<?php echo $t_coal2->coal1_id->ViewAttributes() ?>>
<?php echo $t_coal2->coal1_id->ListViewValue() ?></span>
</span>
<?php if ($t_coal2->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_coal2" data-field="x_coal1_id" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal2->coal1_id->FormValue) ?>">
<input type="hidden" data-table="t_coal2" data-field="x_coal1_id" name="o<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" id="o<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal2->coal1_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_coal2" data-field="x_coal1_id" name="ft_coal2grid$x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" id="ft_coal2grid$x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal2->coal1_id->FormValue) ?>">
<input type="hidden" data-table="t_coal2" data-field="x_coal1_id" name="ft_coal2grid$o<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" id="ft_coal2grid$o<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal2->coal1_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t_coal2_grid->PageObjName . "_row_" . $t_coal2_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t_coal2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t_coal2" data-field="x_coal2_id" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_id" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_id" value="<?php echo ew_HtmlEncode($t_coal2->coal2_id->CurrentValue) ?>">
<input type="hidden" data-table="t_coal2" data-field="x_coal2_id" name="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_id" id="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_id" value="<?php echo ew_HtmlEncode($t_coal2->coal2_id->OldValue) ?>">
<?php } ?>
<?php if ($t_coal2->RowType == EW_ROWTYPE_EDIT || $t_coal2->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t_coal2" data-field="x_coal2_id" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_id" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_id" value="<?php echo ew_HtmlEncode($t_coal2->coal2_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t_coal2->coal2_no->Visible) { // coal2_no ?>
		<td data-name="coal2_no"<?php echo $t_coal2->coal2_no->CellAttributes() ?>>
<?php if ($t_coal2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_coal2_grid->RowCnt ?>_t_coal2_coal2_no" class="form-group t_coal2_coal2_no">
<input type="text" data-table="t_coal2" data-field="x_coal2_no" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($t_coal2->coal2_no->getPlaceHolder()) ?>" value="<?php echo $t_coal2->coal2_no->EditValue ?>"<?php echo $t_coal2->coal2_no->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_coal2" data-field="x_coal2_no" name="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" id="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" value="<?php echo ew_HtmlEncode($t_coal2->coal2_no->OldValue) ?>">
<?php } ?>
<?php if ($t_coal2->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_coal2_grid->RowCnt ?>_t_coal2_coal2_no" class="form-group t_coal2_coal2_no">
<input type="text" data-table="t_coal2" data-field="x_coal2_no" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($t_coal2->coal2_no->getPlaceHolder()) ?>" value="<?php echo $t_coal2->coal2_no->EditValue ?>"<?php echo $t_coal2->coal2_no->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_coal2->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_coal2_grid->RowCnt ?>_t_coal2_coal2_no" class="t_coal2_coal2_no">
<span<?php echo $t_coal2->coal2_no->ViewAttributes() ?>>
<?php echo $t_coal2->coal2_no->ListViewValue() ?></span>
</span>
<?php if ($t_coal2->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_coal2" data-field="x_coal2_no" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" value="<?php echo ew_HtmlEncode($t_coal2->coal2_no->FormValue) ?>">
<input type="hidden" data-table="t_coal2" data-field="x_coal2_no" name="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" id="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" value="<?php echo ew_HtmlEncode($t_coal2->coal2_no->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_coal2" data-field="x_coal2_no" name="ft_coal2grid$x<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" id="ft_coal2grid$x<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" value="<?php echo ew_HtmlEncode($t_coal2->coal2_no->FormValue) ?>">
<input type="hidden" data-table="t_coal2" data-field="x_coal2_no" name="ft_coal2grid$o<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" id="ft_coal2grid$o<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" value="<?php echo ew_HtmlEncode($t_coal2->coal2_no->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_coal2->coal2_nm->Visible) { // coal2_nm ?>
		<td data-name="coal2_nm"<?php echo $t_coal2->coal2_nm->CellAttributes() ?>>
<?php if ($t_coal2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_coal2_grid->RowCnt ?>_t_coal2_coal2_nm" class="form-group t_coal2_coal2_nm">
<input type="text" data-table="t_coal2" data-field="x_coal2_nm" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_coal2->coal2_nm->getPlaceHolder()) ?>" value="<?php echo $t_coal2->coal2_nm->EditValue ?>"<?php echo $t_coal2->coal2_nm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_coal2" data-field="x_coal2_nm" name="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" id="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" value="<?php echo ew_HtmlEncode($t_coal2->coal2_nm->OldValue) ?>">
<?php } ?>
<?php if ($t_coal2->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_coal2_grid->RowCnt ?>_t_coal2_coal2_nm" class="form-group t_coal2_coal2_nm">
<input type="text" data-table="t_coal2" data-field="x_coal2_nm" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_coal2->coal2_nm->getPlaceHolder()) ?>" value="<?php echo $t_coal2->coal2_nm->EditValue ?>"<?php echo $t_coal2->coal2_nm->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_coal2->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_coal2_grid->RowCnt ?>_t_coal2_coal2_nm" class="t_coal2_coal2_nm">
<span<?php echo $t_coal2->coal2_nm->ViewAttributes() ?>>
<?php echo $t_coal2->coal2_nm->ListViewValue() ?></span>
</span>
<?php if ($t_coal2->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_coal2" data-field="x_coal2_nm" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" value="<?php echo ew_HtmlEncode($t_coal2->coal2_nm->FormValue) ?>">
<input type="hidden" data-table="t_coal2" data-field="x_coal2_nm" name="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" id="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" value="<?php echo ew_HtmlEncode($t_coal2->coal2_nm->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_coal2" data-field="x_coal2_nm" name="ft_coal2grid$x<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" id="ft_coal2grid$x<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" value="<?php echo ew_HtmlEncode($t_coal2->coal2_nm->FormValue) ?>">
<input type="hidden" data-table="t_coal2" data-field="x_coal2_nm" name="ft_coal2grid$o<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" id="ft_coal2grid$o<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" value="<?php echo ew_HtmlEncode($t_coal2->coal2_nm->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_coal2_grid->ListOptions->Render("body", "right", $t_coal2_grid->RowCnt);
?>
	</tr>
<?php if ($t_coal2->RowType == EW_ROWTYPE_ADD || $t_coal2->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft_coal2grid.UpdateOpts(<?php echo $t_coal2_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t_coal2->CurrentAction <> "gridadd" || $t_coal2->CurrentMode == "copy")
		if (!$t_coal2_grid->Recordset->EOF) $t_coal2_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t_coal2->CurrentMode == "add" || $t_coal2->CurrentMode == "copy" || $t_coal2->CurrentMode == "edit") {
		$t_coal2_grid->RowIndex = '$rowindex$';
		$t_coal2_grid->LoadDefaultValues();

		// Set row properties
		$t_coal2->ResetAttrs();
		$t_coal2->RowAttrs = array_merge($t_coal2->RowAttrs, array('data-rowindex'=>$t_coal2_grid->RowIndex, 'id'=>'r0_t_coal2', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t_coal2->RowAttrs["class"], "ewTemplate");
		$t_coal2->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t_coal2_grid->RenderRow();

		// Render list options
		$t_coal2_grid->RenderListOptions();
		$t_coal2_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t_coal2->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_coal2_grid->ListOptions->Render("body", "left", $t_coal2_grid->RowIndex);
?>
	<?php if ($t_coal2->coal1_id->Visible) { // coal1_id ?>
		<td data-name="coal1_id">
<?php if ($t_coal2->CurrentAction <> "F") { ?>
<?php if ($t_coal2->coal1_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t_coal2_coal1_id" class="form-group t_coal2_coal1_id">
<span<?php echo $t_coal2->coal1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal2->coal1_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal2->coal1_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t_coal2_coal1_id" class="form-group t_coal2_coal1_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id"><?php echo (strval($t_coal2->coal1_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_coal2->coal1_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_coal2->coal1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_coal2" data-field="x_coal1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_coal2->coal1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo $t_coal2->coal1_id->CurrentValue ?>"<?php echo $t_coal2->coal1_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" id="s_x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo $t_coal2->coal1_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t_coal2_coal1_id" class="form-group t_coal2_coal1_id">
<span<?php echo $t_coal2->coal1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal2->coal1_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_coal2" data-field="x_coal1_id" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal2->coal1_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_coal2" data-field="x_coal1_id" name="o<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" id="o<?php echo $t_coal2_grid->RowIndex ?>_coal1_id" value="<?php echo ew_HtmlEncode($t_coal2->coal1_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_coal2->coal2_no->Visible) { // coal2_no ?>
		<td data-name="coal2_no">
<?php if ($t_coal2->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_coal2_coal2_no" class="form-group t_coal2_coal2_no">
<input type="text" data-table="t_coal2" data-field="x_coal2_no" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($t_coal2->coal2_no->getPlaceHolder()) ?>" value="<?php echo $t_coal2->coal2_no->EditValue ?>"<?php echo $t_coal2->coal2_no->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_coal2_coal2_no" class="form-group t_coal2_coal2_no">
<span<?php echo $t_coal2->coal2_no->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal2->coal2_no->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_coal2" data-field="x_coal2_no" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" value="<?php echo ew_HtmlEncode($t_coal2->coal2_no->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_coal2" data-field="x_coal2_no" name="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" id="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_no" value="<?php echo ew_HtmlEncode($t_coal2->coal2_no->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_coal2->coal2_nm->Visible) { // coal2_nm ?>
		<td data-name="coal2_nm">
<?php if ($t_coal2->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_coal2_coal2_nm" class="form-group t_coal2_coal2_nm">
<input type="text" data-table="t_coal2" data-field="x_coal2_nm" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_coal2->coal2_nm->getPlaceHolder()) ?>" value="<?php echo $t_coal2->coal2_nm->EditValue ?>"<?php echo $t_coal2->coal2_nm->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_coal2_coal2_nm" class="form-group t_coal2_coal2_nm">
<span<?php echo $t_coal2->coal2_nm->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_coal2->coal2_nm->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_coal2" data-field="x_coal2_nm" name="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" id="x<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" value="<?php echo ew_HtmlEncode($t_coal2->coal2_nm->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_coal2" data-field="x_coal2_nm" name="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" id="o<?php echo $t_coal2_grid->RowIndex ?>_coal2_nm" value="<?php echo ew_HtmlEncode($t_coal2->coal2_nm->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_coal2_grid->ListOptions->Render("body", "right", $t_coal2_grid->RowCnt);
?>
<script type="text/javascript">
ft_coal2grid.UpdateOpts(<?php echo $t_coal2_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t_coal2->CurrentMode == "add" || $t_coal2->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t_coal2_grid->FormKeyCountName ?>" id="<?php echo $t_coal2_grid->FormKeyCountName ?>" value="<?php echo $t_coal2_grid->KeyCount ?>">
<?php echo $t_coal2_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_coal2->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t_coal2_grid->FormKeyCountName ?>" id="<?php echo $t_coal2_grid->FormKeyCountName ?>" value="<?php echo $t_coal2_grid->KeyCount ?>">
<?php echo $t_coal2_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_coal2->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft_coal2grid">
</div>
<?php

// Close recordset
if ($t_coal2_grid->Recordset)
	$t_coal2_grid->Recordset->Close();
?>
<?php if ($t_coal2_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t_coal2_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t_coal2_grid->TotalRecs == 0 && $t_coal2->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_coal2_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t_coal2->Export == "") { ?>
<script type="text/javascript">
ft_coal2grid.Init();
</script>
<?php } ?>
<?php
$t_coal2_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t_coal2_grid->Page_Terminate();
?>
