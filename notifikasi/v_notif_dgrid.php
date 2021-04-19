<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($v_notif_d_grid)) $v_notif_d_grid = new cv_notif_d_grid();

// Page init
$v_notif_d_grid->Page_Init();

// Page main
$v_notif_d_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_notif_d_grid->Page_Render();
?>
<?php if ($v_notif_d->Export == "") { ?>
<script type="text/javascript">

// Form object
var fv_notif_dgrid = new ew_Form("fv_notif_dgrid", "grid");
fv_notif_dgrid.FormKeyCountName = '<?php echo $v_notif_d_grid->FormKeyCountName ?>';

// Validate form
fv_notif_dgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $v_notif_d->id->FldCaption(), $v_notif_d->id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_notif_d->id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_employee_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $v_notif_d->employee_id->FldCaption(), $v_notif_d->employee_id->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fv_notif_dgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "employee_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bagian", false)) return false;
	if (ew_ValueChanged(fobj, infix, "lokasi_kerja", false)) return false;
	if (ew_ValueChanged(fobj, infix, "status", false)) return false;
	return true;
}

// Form_CustomValidate event
fv_notif_dgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_notif_dgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fv_notif_dgrid.Lists["x_employee_id"] = {"LinkField":"x_employee_id","Ajax":true,"AutoFill":true,"DisplayFields":["x_name","x_lok_kerja","x_bagian",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_personal"};
fv_notif_dgrid.Lists["x_employee_id"].Data = "<?php echo $v_notif_d_grid->employee_id->LookupFilterQuery(FALSE, "grid") ?>";
fv_notif_dgrid.AutoSuggests["x_employee_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $v_notif_d_grid->employee_id->LookupFilterQuery(TRUE, "grid"))) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($v_notif_d->CurrentAction == "gridadd") {
	if ($v_notif_d->CurrentMode == "copy") {
		$bSelectLimit = $v_notif_d_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$v_notif_d_grid->TotalRecs = $v_notif_d->ListRecordCount();
			$v_notif_d_grid->Recordset = $v_notif_d_grid->LoadRecordset($v_notif_d_grid->StartRec-1, $v_notif_d_grid->DisplayRecs);
		} else {
			if ($v_notif_d_grid->Recordset = $v_notif_d_grid->LoadRecordset())
				$v_notif_d_grid->TotalRecs = $v_notif_d_grid->Recordset->RecordCount();
		}
		$v_notif_d_grid->StartRec = 1;
		$v_notif_d_grid->DisplayRecs = $v_notif_d_grid->TotalRecs;
	} else {
		$v_notif_d->CurrentFilter = "0=1";
		$v_notif_d_grid->StartRec = 1;
		$v_notif_d_grid->DisplayRecs = $v_notif_d->GridAddRowCount;
	}
	$v_notif_d_grid->TotalRecs = $v_notif_d_grid->DisplayRecs;
	$v_notif_d_grid->StopRec = $v_notif_d_grid->DisplayRecs;
} else {
	$bSelectLimit = $v_notif_d_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($v_notif_d_grid->TotalRecs <= 0)
			$v_notif_d_grid->TotalRecs = $v_notif_d->ListRecordCount();
	} else {
		if (!$v_notif_d_grid->Recordset && ($v_notif_d_grid->Recordset = $v_notif_d_grid->LoadRecordset()))
			$v_notif_d_grid->TotalRecs = $v_notif_d_grid->Recordset->RecordCount();
	}
	$v_notif_d_grid->StartRec = 1;
	$v_notif_d_grid->DisplayRecs = $v_notif_d_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$v_notif_d_grid->Recordset = $v_notif_d_grid->LoadRecordset($v_notif_d_grid->StartRec-1, $v_notif_d_grid->DisplayRecs);

	// Set no record found message
	if ($v_notif_d->CurrentAction == "" && $v_notif_d_grid->TotalRecs == 0) {
		if ($v_notif_d_grid->SearchWhere == "0=101")
			$v_notif_d_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$v_notif_d_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$v_notif_d_grid->RenderOtherOptions();
?>
<?php $v_notif_d_grid->ShowPageHeader(); ?>
<?php
$v_notif_d_grid->ShowMessage();
?>
<?php if ($v_notif_d_grid->TotalRecs > 0 || $v_notif_d->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($v_notif_d_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> v_notif_d">
<div id="fv_notif_dgrid" class="ewForm ewListForm form-inline">
<div id="gmp_v_notif_d" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_v_notif_dgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$v_notif_d_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$v_notif_d_grid->RenderListOptions();

// Render list options (header, left)
$v_notif_d_grid->ListOptions->Render("header", "left");
?>
<?php if ($v_notif_d->id->Visible) { // id ?>
	<?php if ($v_notif_d->SortUrl($v_notif_d->id) == "") { ?>
		<th data-name="id" class="<?php echo $v_notif_d->id->HeaderCellClass() ?>"><div id="elh_v_notif_d_id" class="v_notif_d_id"><div class="ewTableHeaderCaption"><?php echo $v_notif_d->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $v_notif_d->id->HeaderCellClass() ?>"><div><div id="elh_v_notif_d_id" class="v_notif_d_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_notif_d->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_notif_d->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_notif_d->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_notif_d->employee_id->Visible) { // employee_id ?>
	<?php if ($v_notif_d->SortUrl($v_notif_d->employee_id) == "") { ?>
		<th data-name="employee_id" class="<?php echo $v_notif_d->employee_id->HeaderCellClass() ?>"><div id="elh_v_notif_d_employee_id" class="v_notif_d_employee_id"><div class="ewTableHeaderCaption"><?php echo $v_notif_d->employee_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="employee_id" class="<?php echo $v_notif_d->employee_id->HeaderCellClass() ?>"><div><div id="elh_v_notif_d_employee_id" class="v_notif_d_employee_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_notif_d->employee_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_notif_d->employee_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_notif_d->employee_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_notif_d->bagian->Visible) { // bagian ?>
	<?php if ($v_notif_d->SortUrl($v_notif_d->bagian) == "") { ?>
		<th data-name="bagian" class="<?php echo $v_notif_d->bagian->HeaderCellClass() ?>"><div id="elh_v_notif_d_bagian" class="v_notif_d_bagian"><div class="ewTableHeaderCaption"><?php echo $v_notif_d->bagian->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bagian" class="<?php echo $v_notif_d->bagian->HeaderCellClass() ?>"><div><div id="elh_v_notif_d_bagian" class="v_notif_d_bagian">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_notif_d->bagian->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_notif_d->bagian->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_notif_d->bagian->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_notif_d->lokasi_kerja->Visible) { // lokasi_kerja ?>
	<?php if ($v_notif_d->SortUrl($v_notif_d->lokasi_kerja) == "") { ?>
		<th data-name="lokasi_kerja" class="<?php echo $v_notif_d->lokasi_kerja->HeaderCellClass() ?>"><div id="elh_v_notif_d_lokasi_kerja" class="v_notif_d_lokasi_kerja"><div class="ewTableHeaderCaption"><?php echo $v_notif_d->lokasi_kerja->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lokasi_kerja" class="<?php echo $v_notif_d->lokasi_kerja->HeaderCellClass() ?>"><div><div id="elh_v_notif_d_lokasi_kerja" class="v_notif_d_lokasi_kerja">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_notif_d->lokasi_kerja->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_notif_d->lokasi_kerja->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_notif_d->lokasi_kerja->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_notif_d->status->Visible) { // status ?>
	<?php if ($v_notif_d->SortUrl($v_notif_d->status) == "") { ?>
		<th data-name="status" class="<?php echo $v_notif_d->status->HeaderCellClass() ?>"><div id="elh_v_notif_d_status" class="v_notif_d_status"><div class="ewTableHeaderCaption"><?php echo $v_notif_d->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $v_notif_d->status->HeaderCellClass() ?>"><div><div id="elh_v_notif_d_status" class="v_notif_d_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_notif_d->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_notif_d->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_notif_d->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$v_notif_d_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$v_notif_d_grid->StartRec = 1;
$v_notif_d_grid->StopRec = $v_notif_d_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($v_notif_d_grid->FormKeyCountName) && ($v_notif_d->CurrentAction == "gridadd" || $v_notif_d->CurrentAction == "gridedit" || $v_notif_d->CurrentAction == "F")) {
		$v_notif_d_grid->KeyCount = $objForm->GetValue($v_notif_d_grid->FormKeyCountName);
		$v_notif_d_grid->StopRec = $v_notif_d_grid->StartRec + $v_notif_d_grid->KeyCount - 1;
	}
}
$v_notif_d_grid->RecCnt = $v_notif_d_grid->StartRec - 1;
if ($v_notif_d_grid->Recordset && !$v_notif_d_grid->Recordset->EOF) {
	$v_notif_d_grid->Recordset->MoveFirst();
	$bSelectLimit = $v_notif_d_grid->UseSelectLimit;
	if (!$bSelectLimit && $v_notif_d_grid->StartRec > 1)
		$v_notif_d_grid->Recordset->Move($v_notif_d_grid->StartRec - 1);
} elseif (!$v_notif_d->AllowAddDeleteRow && $v_notif_d_grid->StopRec == 0) {
	$v_notif_d_grid->StopRec = $v_notif_d->GridAddRowCount;
}

// Initialize aggregate
$v_notif_d->RowType = EW_ROWTYPE_AGGREGATEINIT;
$v_notif_d->ResetAttrs();
$v_notif_d_grid->RenderRow();
if ($v_notif_d->CurrentAction == "gridadd")
	$v_notif_d_grid->RowIndex = 0;
if ($v_notif_d->CurrentAction == "gridedit")
	$v_notif_d_grid->RowIndex = 0;
while ($v_notif_d_grid->RecCnt < $v_notif_d_grid->StopRec) {
	$v_notif_d_grid->RecCnt++;
	if (intval($v_notif_d_grid->RecCnt) >= intval($v_notif_d_grid->StartRec)) {
		$v_notif_d_grid->RowCnt++;
		if ($v_notif_d->CurrentAction == "gridadd" || $v_notif_d->CurrentAction == "gridedit" || $v_notif_d->CurrentAction == "F") {
			$v_notif_d_grid->RowIndex++;
			$objForm->Index = $v_notif_d_grid->RowIndex;
			if ($objForm->HasValue($v_notif_d_grid->FormActionName))
				$v_notif_d_grid->RowAction = strval($objForm->GetValue($v_notif_d_grid->FormActionName));
			elseif ($v_notif_d->CurrentAction == "gridadd")
				$v_notif_d_grid->RowAction = "insert";
			else
				$v_notif_d_grid->RowAction = "";
		}

		// Set up key count
		$v_notif_d_grid->KeyCount = $v_notif_d_grid->RowIndex;

		// Init row class and style
		$v_notif_d->ResetAttrs();
		$v_notif_d->CssClass = "";
		if ($v_notif_d->CurrentAction == "gridadd") {
			if ($v_notif_d->CurrentMode == "copy") {
				$v_notif_d_grid->LoadRowValues($v_notif_d_grid->Recordset); // Load row values
				$v_notif_d_grid->SetRecordKey($v_notif_d_grid->RowOldKey, $v_notif_d_grid->Recordset); // Set old record key
			} else {
				$v_notif_d_grid->LoadRowValues(); // Load default values
				$v_notif_d_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$v_notif_d_grid->LoadRowValues($v_notif_d_grid->Recordset); // Load row values
		}
		$v_notif_d->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($v_notif_d->CurrentAction == "gridadd") // Grid add
			$v_notif_d->RowType = EW_ROWTYPE_ADD; // Render add
		if ($v_notif_d->CurrentAction == "gridadd" && $v_notif_d->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$v_notif_d_grid->RestoreCurrentRowFormValues($v_notif_d_grid->RowIndex); // Restore form values
		if ($v_notif_d->CurrentAction == "gridedit") { // Grid edit
			if ($v_notif_d->EventCancelled) {
				$v_notif_d_grid->RestoreCurrentRowFormValues($v_notif_d_grid->RowIndex); // Restore form values
			}
			if ($v_notif_d_grid->RowAction == "insert")
				$v_notif_d->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$v_notif_d->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($v_notif_d->CurrentAction == "gridedit" && ($v_notif_d->RowType == EW_ROWTYPE_EDIT || $v_notif_d->RowType == EW_ROWTYPE_ADD) && $v_notif_d->EventCancelled) // Update failed
			$v_notif_d_grid->RestoreCurrentRowFormValues($v_notif_d_grid->RowIndex); // Restore form values
		if ($v_notif_d->RowType == EW_ROWTYPE_EDIT) // Edit row
			$v_notif_d_grid->EditRowCnt++;
		if ($v_notif_d->CurrentAction == "F") // Confirm row
			$v_notif_d_grid->RestoreCurrentRowFormValues($v_notif_d_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$v_notif_d->RowAttrs = array_merge($v_notif_d->RowAttrs, array('data-rowindex'=>$v_notif_d_grid->RowCnt, 'id'=>'r' . $v_notif_d_grid->RowCnt . '_v_notif_d', 'data-rowtype'=>$v_notif_d->RowType));

		// Render row
		$v_notif_d_grid->RenderRow();

		// Render list options
		$v_notif_d_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($v_notif_d_grid->RowAction <> "delete" && $v_notif_d_grid->RowAction <> "insertdelete" && !($v_notif_d_grid->RowAction == "insert" && $v_notif_d->CurrentAction == "F" && $v_notif_d_grid->EmptyRow())) {
?>
	<tr<?php echo $v_notif_d->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_notif_d_grid->ListOptions->Render("body", "left", $v_notif_d_grid->RowCnt);
?>
	<?php if ($v_notif_d->id->Visible) { // id ?>
		<td data-name="id"<?php echo $v_notif_d->id->CellAttributes() ?>>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($v_notif_d->id->getSessionValue() <> "") { ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_id" class="form-group v_notif_d_id">
<span<?php echo $v_notif_d->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_notif_d->id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $v_notif_d_grid->RowIndex ?>_id" name="x<?php echo $v_notif_d_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($v_notif_d->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_id" class="form-group v_notif_d_id">
<input type="text" data-table="v_notif_d" data-field="x_id" name="x<?php echo $v_notif_d_grid->RowIndex ?>_id" id="x<?php echo $v_notif_d_grid->RowIndex ?>_id" size="30" placeholder="<?php echo ew_HtmlEncode($v_notif_d->id->getPlaceHolder()) ?>" value="<?php echo $v_notif_d->id->EditValue ?>"<?php echo $v_notif_d->id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="v_notif_d" data-field="x_id" name="o<?php echo $v_notif_d_grid->RowIndex ?>_id" id="o<?php echo $v_notif_d_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($v_notif_d->id->OldValue) ?>">
<?php } ?>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($v_notif_d->id->getSessionValue() <> "") { ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_id" class="form-group v_notif_d_id">
<span<?php echo $v_notif_d->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_notif_d->id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $v_notif_d_grid->RowIndex ?>_id" name="x<?php echo $v_notif_d_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($v_notif_d->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_id" class="form-group v_notif_d_id">
<input type="text" data-table="v_notif_d" data-field="x_id" name="x<?php echo $v_notif_d_grid->RowIndex ?>_id" id="x<?php echo $v_notif_d_grid->RowIndex ?>_id" size="30" placeholder="<?php echo ew_HtmlEncode($v_notif_d->id->getPlaceHolder()) ?>" value="<?php echo $v_notif_d->id->EditValue ?>"<?php echo $v_notif_d->id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_id" class="v_notif_d_id">
<span<?php echo $v_notif_d->id->ViewAttributes() ?>>
<?php echo $v_notif_d->id->ListViewValue() ?></span>
</span>
<?php if ($v_notif_d->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_notif_d" data-field="x_id" name="x<?php echo $v_notif_d_grid->RowIndex ?>_id" id="x<?php echo $v_notif_d_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($v_notif_d->id->FormValue) ?>">
<input type="hidden" data-table="v_notif_d" data-field="x_id" name="o<?php echo $v_notif_d_grid->RowIndex ?>_id" id="o<?php echo $v_notif_d_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($v_notif_d->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_notif_d" data-field="x_id" name="fv_notif_dgrid$x<?php echo $v_notif_d_grid->RowIndex ?>_id" id="fv_notif_dgrid$x<?php echo $v_notif_d_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($v_notif_d->id->FormValue) ?>">
<input type="hidden" data-table="v_notif_d" data-field="x_id" name="fv_notif_dgrid$o<?php echo $v_notif_d_grid->RowIndex ?>_id" id="fv_notif_dgrid$o<?php echo $v_notif_d_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($v_notif_d->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_notif_d->employee_id->Visible) { // employee_id ?>
		<td data-name="employee_id"<?php echo $v_notif_d->employee_id->CellAttributes() ?>>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_employee_id" class="form-group v_notif_d_employee_id">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$v_notif_d->employee_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$v_notif_d->employee_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" style="white-space: nowrap; z-index: <?php echo (9000 - $v_notif_d_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="sv_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="<?php echo $v_notif_d->employee_id->EditValue ?>" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($v_notif_d->employee_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($v_notif_d->employee_id->getPlaceHolder()) ?>"<?php echo $v_notif_d->employee_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_notif_d" data-field="x_employee_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $v_notif_d->employee_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($v_notif_d->employee_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
fv_notif_dgrid.CreateAutoSuggest({"id":"x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($v_notif_d->employee_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($v_notif_d->employee_id->ReadOnly || $v_notif_d->employee_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="ln_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="ln_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="x<?php echo $v_notif_d_grid->RowIndex ?>_bagian,x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja">
</span>
<input type="hidden" data-table="v_notif_d" data-field="x_employee_id" name="o<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="o<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($v_notif_d->employee_id->OldValue) ?>">
<?php } ?>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_employee_id" class="form-group v_notif_d_employee_id">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$v_notif_d->employee_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$v_notif_d->employee_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" style="white-space: nowrap; z-index: <?php echo (9000 - $v_notif_d_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="sv_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="<?php echo $v_notif_d->employee_id->EditValue ?>" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($v_notif_d->employee_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($v_notif_d->employee_id->getPlaceHolder()) ?>"<?php echo $v_notif_d->employee_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_notif_d" data-field="x_employee_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $v_notif_d->employee_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($v_notif_d->employee_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
fv_notif_dgrid.CreateAutoSuggest({"id":"x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($v_notif_d->employee_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($v_notif_d->employee_id->ReadOnly || $v_notif_d->employee_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="ln_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="ln_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="x<?php echo $v_notif_d_grid->RowIndex ?>_bagian,x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja">
</span>
<?php } ?>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_employee_id" class="v_notif_d_employee_id">
<span<?php echo $v_notif_d->employee_id->ViewAttributes() ?>>
<?php echo $v_notif_d->employee_id->ListViewValue() ?></span>
</span>
<?php if ($v_notif_d->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_notif_d" data-field="x_employee_id" name="x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($v_notif_d->employee_id->FormValue) ?>">
<input type="hidden" data-table="v_notif_d" data-field="x_employee_id" name="o<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="o<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($v_notif_d->employee_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_notif_d" data-field="x_employee_id" name="fv_notif_dgrid$x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="fv_notif_dgrid$x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($v_notif_d->employee_id->FormValue) ?>">
<input type="hidden" data-table="v_notif_d" data-field="x_employee_id" name="fv_notif_dgrid$o<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="fv_notif_dgrid$o<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($v_notif_d->employee_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_notif_d->bagian->Visible) { // bagian ?>
		<td data-name="bagian"<?php echo $v_notif_d->bagian->CellAttributes() ?>>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_bagian" class="form-group v_notif_d_bagian">
<input type="text" data-table="v_notif_d" data-field="x_bagian" name="x<?php echo $v_notif_d_grid->RowIndex ?>_bagian" id="x<?php echo $v_notif_d_grid->RowIndex ?>_bagian" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($v_notif_d->bagian->getPlaceHolder()) ?>" value="<?php echo $v_notif_d->bagian->EditValue ?>"<?php echo $v_notif_d->bagian->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_notif_d" data-field="x_bagian" name="o<?php echo $v_notif_d_grid->RowIndex ?>_bagian" id="o<?php echo $v_notif_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($v_notif_d->bagian->OldValue) ?>">
<?php } ?>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_bagian" class="form-group v_notif_d_bagian">
<input type="text" data-table="v_notif_d" data-field="x_bagian" name="x<?php echo $v_notif_d_grid->RowIndex ?>_bagian" id="x<?php echo $v_notif_d_grid->RowIndex ?>_bagian" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($v_notif_d->bagian->getPlaceHolder()) ?>" value="<?php echo $v_notif_d->bagian->EditValue ?>"<?php echo $v_notif_d->bagian->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_bagian" class="v_notif_d_bagian">
<span<?php echo $v_notif_d->bagian->ViewAttributes() ?>>
<?php echo $v_notif_d->bagian->ListViewValue() ?></span>
</span>
<?php if ($v_notif_d->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_notif_d" data-field="x_bagian" name="x<?php echo $v_notif_d_grid->RowIndex ?>_bagian" id="x<?php echo $v_notif_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($v_notif_d->bagian->FormValue) ?>">
<input type="hidden" data-table="v_notif_d" data-field="x_bagian" name="o<?php echo $v_notif_d_grid->RowIndex ?>_bagian" id="o<?php echo $v_notif_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($v_notif_d->bagian->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_notif_d" data-field="x_bagian" name="fv_notif_dgrid$x<?php echo $v_notif_d_grid->RowIndex ?>_bagian" id="fv_notif_dgrid$x<?php echo $v_notif_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($v_notif_d->bagian->FormValue) ?>">
<input type="hidden" data-table="v_notif_d" data-field="x_bagian" name="fv_notif_dgrid$o<?php echo $v_notif_d_grid->RowIndex ?>_bagian" id="fv_notif_dgrid$o<?php echo $v_notif_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($v_notif_d->bagian->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_notif_d->lokasi_kerja->Visible) { // lokasi_kerja ?>
		<td data-name="lokasi_kerja"<?php echo $v_notif_d->lokasi_kerja->CellAttributes() ?>>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_lokasi_kerja" class="form-group v_notif_d_lokasi_kerja">
<input type="text" data-table="v_notif_d" data-field="x_lokasi_kerja" name="x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" id="x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($v_notif_d->lokasi_kerja->getPlaceHolder()) ?>" value="<?php echo $v_notif_d->lokasi_kerja->EditValue ?>"<?php echo $v_notif_d->lokasi_kerja->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_notif_d" data-field="x_lokasi_kerja" name="o<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" id="o<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($v_notif_d->lokasi_kerja->OldValue) ?>">
<?php } ?>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_lokasi_kerja" class="form-group v_notif_d_lokasi_kerja">
<input type="text" data-table="v_notif_d" data-field="x_lokasi_kerja" name="x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" id="x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($v_notif_d->lokasi_kerja->getPlaceHolder()) ?>" value="<?php echo $v_notif_d->lokasi_kerja->EditValue ?>"<?php echo $v_notif_d->lokasi_kerja->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_lokasi_kerja" class="v_notif_d_lokasi_kerja">
<span<?php echo $v_notif_d->lokasi_kerja->ViewAttributes() ?>>
<?php echo $v_notif_d->lokasi_kerja->ListViewValue() ?></span>
</span>
<?php if ($v_notif_d->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_notif_d" data-field="x_lokasi_kerja" name="x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" id="x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($v_notif_d->lokasi_kerja->FormValue) ?>">
<input type="hidden" data-table="v_notif_d" data-field="x_lokasi_kerja" name="o<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" id="o<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($v_notif_d->lokasi_kerja->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_notif_d" data-field="x_lokasi_kerja" name="fv_notif_dgrid$x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" id="fv_notif_dgrid$x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($v_notif_d->lokasi_kerja->FormValue) ?>">
<input type="hidden" data-table="v_notif_d" data-field="x_lokasi_kerja" name="fv_notif_dgrid$o<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" id="fv_notif_dgrid$o<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($v_notif_d->lokasi_kerja->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_notif_d->status->Visible) { // status ?>
		<td data-name="status"<?php echo $v_notif_d->status->CellAttributes() ?>>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_status" class="form-group v_notif_d_status">
<input type="text" data-table="v_notif_d" data-field="x_status" name="x<?php echo $v_notif_d_grid->RowIndex ?>_status" id="x<?php echo $v_notif_d_grid->RowIndex ?>_status" size="30" maxlength="12" placeholder="<?php echo ew_HtmlEncode($v_notif_d->status->getPlaceHolder()) ?>" value="<?php echo $v_notif_d->status->EditValue ?>"<?php echo $v_notif_d->status->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_notif_d" data-field="x_status" name="o<?php echo $v_notif_d_grid->RowIndex ?>_status" id="o<?php echo $v_notif_d_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($v_notif_d->status->OldValue) ?>">
<?php } ?>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_status" class="form-group v_notif_d_status">
<input type="text" data-table="v_notif_d" data-field="x_status" name="x<?php echo $v_notif_d_grid->RowIndex ?>_status" id="x<?php echo $v_notif_d_grid->RowIndex ?>_status" size="30" maxlength="12" placeholder="<?php echo ew_HtmlEncode($v_notif_d->status->getPlaceHolder()) ?>" value="<?php echo $v_notif_d->status->EditValue ?>"<?php echo $v_notif_d->status->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_notif_d_grid->RowCnt ?>_v_notif_d_status" class="v_notif_d_status">
<span<?php echo $v_notif_d->status->ViewAttributes() ?>>
<?php echo $v_notif_d->status->ListViewValue() ?></span>
</span>
<?php if ($v_notif_d->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_notif_d" data-field="x_status" name="x<?php echo $v_notif_d_grid->RowIndex ?>_status" id="x<?php echo $v_notif_d_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($v_notif_d->status->FormValue) ?>">
<input type="hidden" data-table="v_notif_d" data-field="x_status" name="o<?php echo $v_notif_d_grid->RowIndex ?>_status" id="o<?php echo $v_notif_d_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($v_notif_d->status->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_notif_d" data-field="x_status" name="fv_notif_dgrid$x<?php echo $v_notif_d_grid->RowIndex ?>_status" id="fv_notif_dgrid$x<?php echo $v_notif_d_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($v_notif_d->status->FormValue) ?>">
<input type="hidden" data-table="v_notif_d" data-field="x_status" name="fv_notif_dgrid$o<?php echo $v_notif_d_grid->RowIndex ?>_status" id="fv_notif_dgrid$o<?php echo $v_notif_d_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($v_notif_d->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_notif_d_grid->ListOptions->Render("body", "right", $v_notif_d_grid->RowCnt);
?>
	</tr>
<?php if ($v_notif_d->RowType == EW_ROWTYPE_ADD || $v_notif_d->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fv_notif_dgrid.UpdateOpts(<?php echo $v_notif_d_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($v_notif_d->CurrentAction <> "gridadd" || $v_notif_d->CurrentMode == "copy")
		if (!$v_notif_d_grid->Recordset->EOF) $v_notif_d_grid->Recordset->MoveNext();
}
?>
<?php
	if ($v_notif_d->CurrentMode == "add" || $v_notif_d->CurrentMode == "copy" || $v_notif_d->CurrentMode == "edit") {
		$v_notif_d_grid->RowIndex = '$rowindex$';
		$v_notif_d_grid->LoadRowValues();

		// Set row properties
		$v_notif_d->ResetAttrs();
		$v_notif_d->RowAttrs = array_merge($v_notif_d->RowAttrs, array('data-rowindex'=>$v_notif_d_grid->RowIndex, 'id'=>'r0_v_notif_d', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($v_notif_d->RowAttrs["class"], "ewTemplate");
		$v_notif_d->RowType = EW_ROWTYPE_ADD;

		// Render row
		$v_notif_d_grid->RenderRow();

		// Render list options
		$v_notif_d_grid->RenderListOptions();
		$v_notif_d_grid->StartRowCnt = 0;
?>
	<tr<?php echo $v_notif_d->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_notif_d_grid->ListOptions->Render("body", "left", $v_notif_d_grid->RowIndex);
?>
	<?php if ($v_notif_d->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($v_notif_d->CurrentAction <> "F") { ?>
<?php if ($v_notif_d->id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_v_notif_d_id" class="form-group v_notif_d_id">
<span<?php echo $v_notif_d->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_notif_d->id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $v_notif_d_grid->RowIndex ?>_id" name="x<?php echo $v_notif_d_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($v_notif_d->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_v_notif_d_id" class="form-group v_notif_d_id">
<input type="text" data-table="v_notif_d" data-field="x_id" name="x<?php echo $v_notif_d_grid->RowIndex ?>_id" id="x<?php echo $v_notif_d_grid->RowIndex ?>_id" size="30" placeholder="<?php echo ew_HtmlEncode($v_notif_d->id->getPlaceHolder()) ?>" value="<?php echo $v_notif_d->id->EditValue ?>"<?php echo $v_notif_d->id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_v_notif_d_id" class="form-group v_notif_d_id">
<span<?php echo $v_notif_d->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_notif_d->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_notif_d" data-field="x_id" name="x<?php echo $v_notif_d_grid->RowIndex ?>_id" id="x<?php echo $v_notif_d_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($v_notif_d->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_notif_d" data-field="x_id" name="o<?php echo $v_notif_d_grid->RowIndex ?>_id" id="o<?php echo $v_notif_d_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($v_notif_d->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_notif_d->employee_id->Visible) { // employee_id ?>
		<td data-name="employee_id">
<?php if ($v_notif_d->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_notif_d_employee_id" class="form-group v_notif_d_employee_id">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$v_notif_d->employee_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$v_notif_d->employee_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" style="white-space: nowrap; z-index: <?php echo (9000 - $v_notif_d_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="sv_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="<?php echo $v_notif_d->employee_id->EditValue ?>" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($v_notif_d->employee_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($v_notif_d->employee_id->getPlaceHolder()) ?>"<?php echo $v_notif_d->employee_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_notif_d" data-field="x_employee_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $v_notif_d->employee_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($v_notif_d->employee_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
fv_notif_dgrid.CreateAutoSuggest({"id":"x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($v_notif_d->employee_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($v_notif_d->employee_id->ReadOnly || $v_notif_d->employee_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="ln_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="ln_x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="x<?php echo $v_notif_d_grid->RowIndex ?>_bagian,x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja">
</span>
<?php } else { ?>
<span id="el$rowindex$_v_notif_d_employee_id" class="form-group v_notif_d_employee_id">
<span<?php echo $v_notif_d->employee_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_notif_d->employee_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_notif_d" data-field="x_employee_id" name="x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="x<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($v_notif_d->employee_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_notif_d" data-field="x_employee_id" name="o<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" id="o<?php echo $v_notif_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($v_notif_d->employee_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_notif_d->bagian->Visible) { // bagian ?>
		<td data-name="bagian">
<?php if ($v_notif_d->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_notif_d_bagian" class="form-group v_notif_d_bagian">
<input type="text" data-table="v_notif_d" data-field="x_bagian" name="x<?php echo $v_notif_d_grid->RowIndex ?>_bagian" id="x<?php echo $v_notif_d_grid->RowIndex ?>_bagian" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($v_notif_d->bagian->getPlaceHolder()) ?>" value="<?php echo $v_notif_d->bagian->EditValue ?>"<?php echo $v_notif_d->bagian->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_notif_d_bagian" class="form-group v_notif_d_bagian">
<span<?php echo $v_notif_d->bagian->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_notif_d->bagian->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_notif_d" data-field="x_bagian" name="x<?php echo $v_notif_d_grid->RowIndex ?>_bagian" id="x<?php echo $v_notif_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($v_notif_d->bagian->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_notif_d" data-field="x_bagian" name="o<?php echo $v_notif_d_grid->RowIndex ?>_bagian" id="o<?php echo $v_notif_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($v_notif_d->bagian->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_notif_d->lokasi_kerja->Visible) { // lokasi_kerja ?>
		<td data-name="lokasi_kerja">
<?php if ($v_notif_d->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_notif_d_lokasi_kerja" class="form-group v_notif_d_lokasi_kerja">
<input type="text" data-table="v_notif_d" data-field="x_lokasi_kerja" name="x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" id="x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($v_notif_d->lokasi_kerja->getPlaceHolder()) ?>" value="<?php echo $v_notif_d->lokasi_kerja->EditValue ?>"<?php echo $v_notif_d->lokasi_kerja->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_notif_d_lokasi_kerja" class="form-group v_notif_d_lokasi_kerja">
<span<?php echo $v_notif_d->lokasi_kerja->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_notif_d->lokasi_kerja->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_notif_d" data-field="x_lokasi_kerja" name="x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" id="x<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($v_notif_d->lokasi_kerja->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_notif_d" data-field="x_lokasi_kerja" name="o<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" id="o<?php echo $v_notif_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($v_notif_d->lokasi_kerja->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_notif_d->status->Visible) { // status ?>
		<td data-name="status">
<?php if ($v_notif_d->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_notif_d_status" class="form-group v_notif_d_status">
<input type="text" data-table="v_notif_d" data-field="x_status" name="x<?php echo $v_notif_d_grid->RowIndex ?>_status" id="x<?php echo $v_notif_d_grid->RowIndex ?>_status" size="30" maxlength="12" placeholder="<?php echo ew_HtmlEncode($v_notif_d->status->getPlaceHolder()) ?>" value="<?php echo $v_notif_d->status->EditValue ?>"<?php echo $v_notif_d->status->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_notif_d_status" class="form-group v_notif_d_status">
<span<?php echo $v_notif_d->status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_notif_d->status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_notif_d" data-field="x_status" name="x<?php echo $v_notif_d_grid->RowIndex ?>_status" id="x<?php echo $v_notif_d_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($v_notif_d->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_notif_d" data-field="x_status" name="o<?php echo $v_notif_d_grid->RowIndex ?>_status" id="o<?php echo $v_notif_d_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($v_notif_d->status->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_notif_d_grid->ListOptions->Render("body", "right", $v_notif_d_grid->RowCnt);
?>
<script type="text/javascript">
fv_notif_dgrid.UpdateOpts(<?php echo $v_notif_d_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($v_notif_d->CurrentMode == "add" || $v_notif_d->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $v_notif_d_grid->FormKeyCountName ?>" id="<?php echo $v_notif_d_grid->FormKeyCountName ?>" value="<?php echo $v_notif_d_grid->KeyCount ?>">
<?php echo $v_notif_d_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($v_notif_d->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $v_notif_d_grid->FormKeyCountName ?>" id="<?php echo $v_notif_d_grid->FormKeyCountName ?>" value="<?php echo $v_notif_d_grid->KeyCount ?>">
<?php echo $v_notif_d_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($v_notif_d->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fv_notif_dgrid">
</div>
<?php

// Close recordset
if ($v_notif_d_grid->Recordset)
	$v_notif_d_grid->Recordset->Close();
?>
<?php if ($v_notif_d_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($v_notif_d_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($v_notif_d_grid->TotalRecs == 0 && $v_notif_d->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_notif_d_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($v_notif_d->Export == "") { ?>
<script type="text/javascript">
fv_notif_dgrid.Init();
</script>
<?php } ?>
<?php
$v_notif_d_grid->Page_Terminate();
?>
