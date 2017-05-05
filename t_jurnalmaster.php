<?php

// no_bukti
// tgl
// ket

?>
<?php if ($t_jurnal->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t_jurnal->TableCaption() ?></h4> -->
<table id="tbl_t_jurnalmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t_jurnal->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t_jurnal->no_bukti->Visible) { // no_bukti ?>
		<tr id="r_no_bukti">
			<td><?php echo $t_jurnal->no_bukti->FldCaption() ?></td>
			<td<?php echo $t_jurnal->no_bukti->CellAttributes() ?>>
<span id="el_t_jurnal_no_bukti">
<span<?php echo $t_jurnal->no_bukti->ViewAttributes() ?>>
<?php echo $t_jurnal->no_bukti->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_jurnal->tgl->Visible) { // tgl ?>
		<tr id="r_tgl">
			<td><?php echo $t_jurnal->tgl->FldCaption() ?></td>
			<td<?php echo $t_jurnal->tgl->CellAttributes() ?>>
<span id="el_t_jurnal_tgl">
<span<?php echo $t_jurnal->tgl->ViewAttributes() ?>>
<?php echo $t_jurnal->tgl->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_jurnal->ket->Visible) { // ket ?>
		<tr id="r_ket">
			<td><?php echo $t_jurnal->ket->FldCaption() ?></td>
			<td<?php echo $t_jurnal->ket->CellAttributes() ?>>
<span id="el_t_jurnal_ket">
<span<?php echo $t_jurnal->ket->ViewAttributes() ?>>
<?php echo $t_jurnal->ket->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
