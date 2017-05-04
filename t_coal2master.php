<?php

// coal1_id
// coal2_no
// coal2_nm

?>
<?php if ($t_coal2->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t_coal2->TableCaption() ?></h4> -->
<table id="tbl_t_coal2master" class="table table-bordered table-striped ewViewTable">
<?php echo $t_coal2->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t_coal2->coal1_id->Visible) { // coal1_id ?>
		<tr id="r_coal1_id">
			<td><?php echo $t_coal2->coal1_id->FldCaption() ?></td>
			<td<?php echo $t_coal2->coal1_id->CellAttributes() ?>>
<span id="el_t_coal2_coal1_id">
<span<?php echo $t_coal2->coal1_id->ViewAttributes() ?>>
<?php echo $t_coal2->coal1_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_coal2->coal2_no->Visible) { // coal2_no ?>
		<tr id="r_coal2_no">
			<td><?php echo $t_coal2->coal2_no->FldCaption() ?></td>
			<td<?php echo $t_coal2->coal2_no->CellAttributes() ?>>
<span id="el_t_coal2_coal2_no">
<span<?php echo $t_coal2->coal2_no->ViewAttributes() ?>>
<?php echo $t_coal2->coal2_no->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_coal2->coal2_nm->Visible) { // coal2_nm ?>
		<tr id="r_coal2_nm">
			<td><?php echo $t_coal2->coal2_nm->FldCaption() ?></td>
			<td<?php echo $t_coal2->coal2_nm->CellAttributes() ?>>
<span id="el_t_coal2_coal2_nm">
<span<?php echo $t_coal2->coal2_nm->ViewAttributes() ?>>
<?php echo $t_coal2->coal2_nm->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
