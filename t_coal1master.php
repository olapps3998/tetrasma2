<?php

// coal1_no
// coal1_nm

?>
<?php if ($t_coal1->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t_coal1->TableCaption() ?></h4> -->
<table id="tbl_t_coal1master" class="table table-bordered table-striped ewViewTable">
<?php echo $t_coal1->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t_coal1->coal1_no->Visible) { // coal1_no ?>
		<tr id="r_coal1_no">
			<td><?php echo $t_coal1->coal1_no->FldCaption() ?></td>
			<td<?php echo $t_coal1->coal1_no->CellAttributes() ?>>
<span id="el_t_coal1_coal1_no">
<span<?php echo $t_coal1->coal1_no->ViewAttributes() ?>>
<?php echo $t_coal1->coal1_no->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_coal1->coal1_nm->Visible) { // coal1_nm ?>
		<tr id="r_coal1_nm">
			<td><?php echo $t_coal1->coal1_nm->FldCaption() ?></td>
			<td<?php echo $t_coal1->coal1_nm->CellAttributes() ?>>
<span id="el_t_coal1_coal1_nm">
<span<?php echo $t_coal1->coal1_nm->ViewAttributes() ?>>
<?php echo $t_coal1->coal1_nm->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
