<?php

// coal1_id
// coal2_id
// coal3_no
// coal3_nm

?>
<?php if ($t_coal3->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t_coal3->TableCaption() ?></h4> -->
<table id="tbl_t_coal3master" class="table table-bordered table-striped ewViewTable">
<?php echo $t_coal3->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t_coal3->coal1_id->Visible) { // coal1_id ?>
		<tr id="r_coal1_id">
			<td><?php echo $t_coal3->coal1_id->FldCaption() ?></td>
			<td<?php echo $t_coal3->coal1_id->CellAttributes() ?>>
<span id="el_t_coal3_coal1_id">
<span<?php echo $t_coal3->coal1_id->ViewAttributes() ?>>
<?php echo $t_coal3->coal1_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_coal3->coal2_id->Visible) { // coal2_id ?>
		<tr id="r_coal2_id">
			<td><?php echo $t_coal3->coal2_id->FldCaption() ?></td>
			<td<?php echo $t_coal3->coal2_id->CellAttributes() ?>>
<span id="el_t_coal3_coal2_id">
<span<?php echo $t_coal3->coal2_id->ViewAttributes() ?>>
<?php echo $t_coal3->coal2_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_coal3->coal3_no->Visible) { // coal3_no ?>
		<tr id="r_coal3_no">
			<td><?php echo $t_coal3->coal3_no->FldCaption() ?></td>
			<td<?php echo $t_coal3->coal3_no->CellAttributes() ?>>
<span id="el_t_coal3_coal3_no">
<span<?php echo $t_coal3->coal3_no->ViewAttributes() ?>>
<?php echo $t_coal3->coal3_no->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_coal3->coal3_nm->Visible) { // coal3_nm ?>
		<tr id="r_coal3_nm">
			<td><?php echo $t_coal3->coal3_nm->FldCaption() ?></td>
			<td<?php echo $t_coal3->coal3_nm->CellAttributes() ?>>
<span id="el_t_coal3_coal3_nm">
<span<?php echo $t_coal3->coal3_nm->ViewAttributes() ?>>
<?php echo $t_coal3->coal3_nm->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
