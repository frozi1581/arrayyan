<?php

// id
// topic
// priority
// isi_notif
// action
// tgl_cr
// tgl_upd

?>
<?php if ($tb_notifikasi->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_tb_notifikasimaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($tb_notifikasi->id->Visible) { // id ?>
		<tr id="r_id">
			<td class="col-sm-2"><?php echo $tb_notifikasi->id->FldCaption() ?></td>
			<td<?php echo $tb_notifikasi->id->CellAttributes() ?>>
<span id="el_tb_notifikasi_id">
<span<?php echo $tb_notifikasi->id->ViewAttributes() ?>>
<?php echo $tb_notifikasi->id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_notifikasi->topic->Visible) { // topic ?>
		<tr id="r_topic">
			<td class="col-sm-2"><?php echo $tb_notifikasi->topic->FldCaption() ?></td>
			<td<?php echo $tb_notifikasi->topic->CellAttributes() ?>>
<span id="el_tb_notifikasi_topic">
<span<?php echo $tb_notifikasi->topic->ViewAttributes() ?>>
<?php echo $tb_notifikasi->topic->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_notifikasi->priority->Visible) { // priority ?>
		<tr id="r_priority">
			<td class="col-sm-2"><?php echo $tb_notifikasi->priority->FldCaption() ?></td>
			<td<?php echo $tb_notifikasi->priority->CellAttributes() ?>>
<span id="el_tb_notifikasi_priority">
<span<?php echo $tb_notifikasi->priority->ViewAttributes() ?>>
<?php echo $tb_notifikasi->priority->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_notifikasi->isi_notif->Visible) { // isi_notif ?>
		<tr id="r_isi_notif">
			<td class="col-sm-2"><?php echo $tb_notifikasi->isi_notif->FldCaption() ?></td>
			<td<?php echo $tb_notifikasi->isi_notif->CellAttributes() ?>>
<span id="el_tb_notifikasi_isi_notif">
<span<?php echo $tb_notifikasi->isi_notif->ViewAttributes() ?>>
<?php echo $tb_notifikasi->isi_notif->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_notifikasi->action->Visible) { // action ?>
		<tr id="r_action">
			<td class="col-sm-2"><?php echo $tb_notifikasi->action->FldCaption() ?></td>
			<td<?php echo $tb_notifikasi->action->CellAttributes() ?>>
<span id="el_tb_notifikasi_action">
<span<?php echo $tb_notifikasi->action->ViewAttributes() ?>>
<?php echo $tb_notifikasi->action->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_notifikasi->tgl_cr->Visible) { // tgl_cr ?>
		<tr id="r_tgl_cr">
			<td class="col-sm-2"><?php echo $tb_notifikasi->tgl_cr->FldCaption() ?></td>
			<td<?php echo $tb_notifikasi->tgl_cr->CellAttributes() ?>>
<span id="el_tb_notifikasi_tgl_cr">
<span<?php echo $tb_notifikasi->tgl_cr->ViewAttributes() ?>>
<?php echo $tb_notifikasi->tgl_cr->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_notifikasi->tgl_upd->Visible) { // tgl_upd ?>
		<tr id="r_tgl_upd">
			<td class="col-sm-2"><?php echo $tb_notifikasi->tgl_upd->FldCaption() ?></td>
			<td<?php echo $tb_notifikasi->tgl_upd->CellAttributes() ?>>
<span id="el_tb_notifikasi_tgl_upd">
<span<?php echo $tb_notifikasi->tgl_upd->ViewAttributes() ?>>
<?php echo $tb_notifikasi->tgl_upd->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
