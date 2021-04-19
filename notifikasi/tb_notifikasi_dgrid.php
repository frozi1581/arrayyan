<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tb_notifikasi_d_grid)) $tb_notifikasi_d_grid = new ctb_notifikasi_d_grid();

// Page init
$tb_notifikasi_d_grid->Page_Init();

// Page main
$tb_notifikasi_d_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_notifikasi_d_grid->Page_Render();
?>
<?php if ($tb_notifikasi_d->Export == "") { ?>
<script type="text/javascript">

// Form object
var ftb_notifikasi_dgrid = new ew_Form("ftb_notifikasi_dgrid", "grid");
ftb_notifikasi_dgrid.FormKeyCountName = '<?php echo $tb_notifikasi_d_grid->FormKeyCountName ?>';

// Validate form
ftb_notifikasi_dgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_employee_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_notifikasi_d->employee_id->FldCaption(), $tb_notifikasi_d->employee_id->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ftb_notifikasi_dgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "employee_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bagian", false)) return false;
	if (ew_ValueChanged(fobj, infix, "lokasi_kerja", false)) return false;
	return true;
}

// Form_CustomValidate event
ftb_notifikasi_dgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftb_notifikasi_dgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftb_notifikasi_dgrid.Lists["x_employee_id"] = {"LinkField":"x_employee_id","Ajax":true,"AutoFill":true,"DisplayFields":["x_name","x_lok_kerja","x_bagian",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v_personal"};
ftb_notifikasi_dgrid.Lists["x_employee_id"].Data = "<?php echo $tb_notifikasi_d_grid->employee_id->LookupFilterQuery(FALSE, "grid") ?>";
ftb_notifikasi_dgrid.AutoSuggests["x_employee_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $tb_notifikasi_d_grid->employee_id->LookupFilterQuery(TRUE, "grid"))) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($tb_notifikasi_d->CurrentAction == "gridadd") {
	if ($tb_notifikasi_d->CurrentMode == "copy") {
		$bSelectLimit = $tb_notifikasi_d_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$tb_notifikasi_d_grid->TotalRecs = $tb_notifikasi_d->ListRecordCount();
			$tb_notifikasi_d_grid->Recordset = $tb_notifikasi_d_grid->LoadRecordset($tb_notifikasi_d_grid->StartRec-1, $tb_notifikasi_d_grid->DisplayRecs);
		} else {
			if ($tb_notifikasi_d_grid->Recordset = $tb_notifikasi_d_grid->LoadRecordset())
				$tb_notifikasi_d_grid->TotalRecs = $tb_notifikasi_d_grid->Recordset->RecordCount();
		}
		$tb_notifikasi_d_grid->StartRec = 1;
		$tb_notifikasi_d_grid->DisplayRecs = $tb_notifikasi_d_grid->TotalRecs;
	} else {
		$tb_notifikasi_d->CurrentFilter = "0=1";
		$tb_notifikasi_d_grid->StartRec = 1;
		$tb_notifikasi_d_grid->DisplayRecs = $tb_notifikasi_d->GridAddRowCount;
	}
	$tb_notifikasi_d_grid->TotalRecs = $tb_notifikasi_d_grid->DisplayRecs;
	$tb_notifikasi_d_grid->StopRec = $tb_notifikasi_d_grid->DisplayRecs;
} else {
	$bSelectLimit = $tb_notifikasi_d_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($tb_notifikasi_d_grid->TotalRecs <= 0)
			$tb_notifikasi_d_grid->TotalRecs = $tb_notifikasi_d->ListRecordCount();
	} else {
		if (!$tb_notifikasi_d_grid->Recordset && ($tb_notifikasi_d_grid->Recordset = $tb_notifikasi_d_grid->LoadRecordset()))
			$tb_notifikasi_d_grid->TotalRecs = $tb_notifikasi_d_grid->Recordset->RecordCount();
	}
	$tb_notifikasi_d_grid->StartRec = 1;
	$tb_notifikasi_d_grid->DisplayRecs = $tb_notifikasi_d_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$tb_notifikasi_d_grid->Recordset = $tb_notifikasi_d_grid->LoadRecordset($tb_notifikasi_d_grid->StartRec-1, $tb_notifikasi_d_grid->DisplayRecs);

	// Set no record found message
	if ($tb_notifikasi_d->CurrentAction == "" && $tb_notifikasi_d_grid->TotalRecs == 0) {
		if ($tb_notifikasi_d_grid->SearchWhere == "0=101")
			$tb_notifikasi_d_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$tb_notifikasi_d_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$tb_notifikasi_d_grid->RenderOtherOptions();
?>
<?php $tb_notifikasi_d_grid->ShowPageHeader(); ?>
<?php
$tb_notifikasi_d_grid->ShowMessage();
?>
<?php if ($tb_notifikasi_d_grid->TotalRecs > 0 || $tb_notifikasi_d->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($tb_notifikasi_d_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> tb_notifikasi_d">
<div id="ftb_notifikasi_dgrid" class="ewForm ewListForm form-inline">
<div id="gmp_tb_notifikasi_d" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_tb_notifikasi_dgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$tb_notifikasi_d_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$tb_notifikasi_d_grid->RenderListOptions();

// Render list options (header, left)
$tb_notifikasi_d_grid->ListOptions->Render("header", "left");
?>
<?php if ($tb_notifikasi_d->employee_id->Visible) { // employee_id ?>
	<?php if ($tb_notifikasi_d->SortUrl($tb_notifikasi_d->employee_id) == "") { ?>
		<th data-name="employee_id" class="<?php echo $tb_notifikasi_d->employee_id->HeaderCellClass() ?>"><div id="elh_tb_notifikasi_d_employee_id" class="tb_notifikasi_d_employee_id"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $tb_notifikasi_d->employee_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="employee_id" class="<?php echo $tb_notifikasi_d->employee_id->HeaderCellClass() ?>"><div><div id="elh_tb_notifikasi_d_employee_id" class="tb_notifikasi_d_employee_id">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $tb_notifikasi_d->employee_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_notifikasi_d->employee_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_notifikasi_d->employee_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_notifikasi_d->bagian->Visible) { // bagian ?>
	<?php if ($tb_notifikasi_d->SortUrl($tb_notifikasi_d->bagian) == "") { ?>
		<th data-name="bagian" class="<?php echo $tb_notifikasi_d->bagian->HeaderCellClass() ?>"><div id="elh_tb_notifikasi_d_bagian" class="tb_notifikasi_d_bagian"><div class="ewTableHeaderCaption"><?php echo $tb_notifikasi_d->bagian->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bagian" class="<?php echo $tb_notifikasi_d->bagian->HeaderCellClass() ?>"><div><div id="elh_tb_notifikasi_d_bagian" class="tb_notifikasi_d_bagian">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_notifikasi_d->bagian->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_notifikasi_d->bagian->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_notifikasi_d->bagian->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tb_notifikasi_d->lokasi_kerja->Visible) { // lokasi_kerja ?>
	<?php if ($tb_notifikasi_d->SortUrl($tb_notifikasi_d->lokasi_kerja) == "") { ?>
		<th data-name="lokasi_kerja" class="<?php echo $tb_notifikasi_d->lokasi_kerja->HeaderCellClass() ?>"><div id="elh_tb_notifikasi_d_lokasi_kerja" class="tb_notifikasi_d_lokasi_kerja"><div class="ewTableHeaderCaption"><?php echo $tb_notifikasi_d->lokasi_kerja->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lokasi_kerja" class="<?php echo $tb_notifikasi_d->lokasi_kerja->HeaderCellClass() ?>"><div><div id="elh_tb_notifikasi_d_lokasi_kerja" class="tb_notifikasi_d_lokasi_kerja">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_notifikasi_d->lokasi_kerja->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_notifikasi_d->lokasi_kerja->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_notifikasi_d->lokasi_kerja->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$tb_notifikasi_d_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$tb_notifikasi_d_grid->StartRec = 1;
$tb_notifikasi_d_grid->StopRec = $tb_notifikasi_d_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($tb_notifikasi_d_grid->FormKeyCountName) && ($tb_notifikasi_d->CurrentAction == "gridadd" || $tb_notifikasi_d->CurrentAction == "gridedit" || $tb_notifikasi_d->CurrentAction == "F")) {
		$tb_notifikasi_d_grid->KeyCount = $objForm->GetValue($tb_notifikasi_d_grid->FormKeyCountName);
		$tb_notifikasi_d_grid->StopRec = $tb_notifikasi_d_grid->StartRec + $tb_notifikasi_d_grid->KeyCount - 1;
	}
}
$tb_notifikasi_d_grid->RecCnt = $tb_notifikasi_d_grid->StartRec - 1;
if ($tb_notifikasi_d_grid->Recordset && !$tb_notifikasi_d_grid->Recordset->EOF) {
	$tb_notifikasi_d_grid->Recordset->MoveFirst();
	$bSelectLimit = $tb_notifikasi_d_grid->UseSelectLimit;
	if (!$bSelectLimit && $tb_notifikasi_d_grid->StartRec > 1)
		$tb_notifikasi_d_grid->Recordset->Move($tb_notifikasi_d_grid->StartRec - 1);
} elseif (!$tb_notifikasi_d->AllowAddDeleteRow && $tb_notifikasi_d_grid->StopRec == 0) {
	$tb_notifikasi_d_grid->StopRec = $tb_notifikasi_d->GridAddRowCount;
}

// Initialize aggregate
$tb_notifikasi_d->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tb_notifikasi_d->ResetAttrs();
$tb_notifikasi_d_grid->RenderRow();
if ($tb_notifikasi_d->CurrentAction == "gridadd")
	$tb_notifikasi_d_grid->RowIndex = 0;
if ($tb_notifikasi_d->CurrentAction == "gridedit")
	$tb_notifikasi_d_grid->RowIndex = 0;
while ($tb_notifikasi_d_grid->RecCnt < $tb_notifikasi_d_grid->StopRec) {
	$tb_notifikasi_d_grid->RecCnt++;
	if (intval($tb_notifikasi_d_grid->RecCnt) >= intval($tb_notifikasi_d_grid->StartRec)) {
		$tb_notifikasi_d_grid->RowCnt++;
		if ($tb_notifikasi_d->CurrentAction == "gridadd" || $tb_notifikasi_d->CurrentAction == "gridedit" || $tb_notifikasi_d->CurrentAction == "F") {
			$tb_notifikasi_d_grid->RowIndex++;
			$objForm->Index = $tb_notifikasi_d_grid->RowIndex;
			if ($objForm->HasValue($tb_notifikasi_d_grid->FormActionName))
				$tb_notifikasi_d_grid->RowAction = strval($objForm->GetValue($tb_notifikasi_d_grid->FormActionName));
			elseif ($tb_notifikasi_d->CurrentAction == "gridadd")
				$tb_notifikasi_d_grid->RowAction = "insert";
			else
				$tb_notifikasi_d_grid->RowAction = "";
		}

		// Set up key count
		$tb_notifikasi_d_grid->KeyCount = $tb_notifikasi_d_grid->RowIndex;

		// Init row class and style
		$tb_notifikasi_d->ResetAttrs();
		$tb_notifikasi_d->CssClass = "";
		if ($tb_notifikasi_d->CurrentAction == "gridadd") {
			if ($tb_notifikasi_d->CurrentMode == "copy") {
				$tb_notifikasi_d_grid->LoadRowValues($tb_notifikasi_d_grid->Recordset); // Load row values
				$tb_notifikasi_d_grid->SetRecordKey($tb_notifikasi_d_grid->RowOldKey, $tb_notifikasi_d_grid->Recordset); // Set old record key
			} else {
				$tb_notifikasi_d_grid->LoadRowValues(); // Load default values
				$tb_notifikasi_d_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$tb_notifikasi_d_grid->LoadRowValues($tb_notifikasi_d_grid->Recordset); // Load row values
		}
		$tb_notifikasi_d->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($tb_notifikasi_d->CurrentAction == "gridadd") // Grid add
			$tb_notifikasi_d->RowType = EW_ROWTYPE_ADD; // Render add
		if ($tb_notifikasi_d->CurrentAction == "gridadd" && $tb_notifikasi_d->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$tb_notifikasi_d_grid->RestoreCurrentRowFormValues($tb_notifikasi_d_grid->RowIndex); // Restore form values
		if ($tb_notifikasi_d->CurrentAction == "gridedit") { // Grid edit
			if ($tb_notifikasi_d->EventCancelled) {
				$tb_notifikasi_d_grid->RestoreCurrentRowFormValues($tb_notifikasi_d_grid->RowIndex); // Restore form values
			}
			if ($tb_notifikasi_d_grid->RowAction == "insert")
				$tb_notifikasi_d->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$tb_notifikasi_d->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($tb_notifikasi_d->CurrentAction == "gridedit" && ($tb_notifikasi_d->RowType == EW_ROWTYPE_EDIT || $tb_notifikasi_d->RowType == EW_ROWTYPE_ADD) && $tb_notifikasi_d->EventCancelled) // Update failed
			$tb_notifikasi_d_grid->RestoreCurrentRowFormValues($tb_notifikasi_d_grid->RowIndex); // Restore form values
		if ($tb_notifikasi_d->RowType == EW_ROWTYPE_EDIT) // Edit row
			$tb_notifikasi_d_grid->EditRowCnt++;
		if ($tb_notifikasi_d->CurrentAction == "F") // Confirm row
			$tb_notifikasi_d_grid->RestoreCurrentRowFormValues($tb_notifikasi_d_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$tb_notifikasi_d->RowAttrs = array_merge($tb_notifikasi_d->RowAttrs, array('data-rowindex'=>$tb_notifikasi_d_grid->RowCnt, 'id'=>'r' . $tb_notifikasi_d_grid->RowCnt . '_tb_notifikasi_d', 'data-rowtype'=>$tb_notifikasi_d->RowType));

		// Render row
		$tb_notifikasi_d_grid->RenderRow();

		// Render list options
		$tb_notifikasi_d_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($tb_notifikasi_d_grid->RowAction <> "delete" && $tb_notifikasi_d_grid->RowAction <> "insertdelete" && !($tb_notifikasi_d_grid->RowAction == "insert" && $tb_notifikasi_d->CurrentAction == "F" && $tb_notifikasi_d_grid->EmptyRow())) {
?>
	<tr<?php echo $tb_notifikasi_d->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tb_notifikasi_d_grid->ListOptions->Render("body", "left", $tb_notifikasi_d_grid->RowCnt);
?>
	<?php if ($tb_notifikasi_d->employee_id->Visible) { // employee_id ?>
		<td data-name="employee_id"<?php echo $tb_notifikasi_d->employee_id->CellAttributes() ?>>
<?php if ($tb_notifikasi_d->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_notifikasi_d_grid->RowCnt ?>_tb_notifikasi_d_employee_id" class="form-group tb_notifikasi_d_employee_id">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$tb_notifikasi_d->employee_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_notifikasi_d->employee_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tb_notifikasi_d_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="sv_x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="<?php echo $tb_notifikasi_d->employee_id->EditValue ?>" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->getPlaceHolder()) ?>"<?php echo $tb_notifikasi_d->employee_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_employee_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_notifikasi_d->employee_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ftb_notifikasi_dgrid.CreateAutoSuggest({"id":"x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_notifikasi_d->employee_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($tb_notifikasi_d->employee_id->ReadOnly || $tb_notifikasi_d->employee_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="ln_x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="ln_x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian,x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja">
</span>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_employee_id" name="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_notifikasi_d->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_notifikasi_d_grid->RowCnt ?>_tb_notifikasi_d_employee_id" class="form-group tb_notifikasi_d_employee_id">
<span<?php echo $tb_notifikasi_d->employee_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_notifikasi_d->employee_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_employee_id" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->CurrentValue) ?>">
<?php } ?>
<?php if ($tb_notifikasi_d->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_notifikasi_d_grid->RowCnt ?>_tb_notifikasi_d_employee_id" class="tb_notifikasi_d_employee_id">
<span<?php echo $tb_notifikasi_d->employee_id->ViewAttributes() ?>>
<?php echo $tb_notifikasi_d->employee_id->ListViewValue() ?></span>
</span>
<?php if ($tb_notifikasi_d->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_employee_id" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->FormValue) ?>">
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_employee_id" name="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_employee_id" name="ftb_notifikasi_dgrid$x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="ftb_notifikasi_dgrid$x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->FormValue) ?>">
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_employee_id" name="ftb_notifikasi_dgrid$o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="ftb_notifikasi_dgrid$o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($tb_notifikasi_d->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_id" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_id" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->id->CurrentValue) ?>">
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_id" name="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_id" id="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->id->OldValue) ?>">
<?php } ?>
<?php if ($tb_notifikasi_d->RowType == EW_ROWTYPE_EDIT || $tb_notifikasi_d->CurrentMode == "edit") { ?>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_id" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_id" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($tb_notifikasi_d->bagian->Visible) { // bagian ?>
		<td data-name="bagian"<?php echo $tb_notifikasi_d->bagian->CellAttributes() ?>>
<?php if ($tb_notifikasi_d->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_notifikasi_d_grid->RowCnt ?>_tb_notifikasi_d_bagian" class="form-group tb_notifikasi_d_bagian">
<input type="text" data-table="tb_notifikasi_d" data-field="x_bagian" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($tb_notifikasi_d->bagian->getPlaceHolder()) ?>" value="<?php echo $tb_notifikasi_d->bagian->EditValue ?>"<?php echo $tb_notifikasi_d->bagian->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_bagian" name="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" id="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->bagian->OldValue) ?>">
<?php } ?>
<?php if ($tb_notifikasi_d->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_notifikasi_d_grid->RowCnt ?>_tb_notifikasi_d_bagian" class="form-group tb_notifikasi_d_bagian">
<span<?php echo $tb_notifikasi_d->bagian->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_notifikasi_d->bagian->EditValue ?></p></span>
</span>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_bagian" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->bagian->CurrentValue) ?>">
<?php } ?>
<?php if ($tb_notifikasi_d->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_notifikasi_d_grid->RowCnt ?>_tb_notifikasi_d_bagian" class="tb_notifikasi_d_bagian">
<span<?php echo $tb_notifikasi_d->bagian->ViewAttributes() ?>>
<?php echo $tb_notifikasi_d->bagian->ListViewValue() ?></span>
</span>
<?php if ($tb_notifikasi_d->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_bagian" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->bagian->FormValue) ?>">
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_bagian" name="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" id="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->bagian->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_bagian" name="ftb_notifikasi_dgrid$x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" id="ftb_notifikasi_dgrid$x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->bagian->FormValue) ?>">
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_bagian" name="ftb_notifikasi_dgrid$o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" id="ftb_notifikasi_dgrid$o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->bagian->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tb_notifikasi_d->lokasi_kerja->Visible) { // lokasi_kerja ?>
		<td data-name="lokasi_kerja"<?php echo $tb_notifikasi_d->lokasi_kerja->CellAttributes() ?>>
<?php if ($tb_notifikasi_d->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_notifikasi_d_grid->RowCnt ?>_tb_notifikasi_d_lokasi_kerja" class="form-group tb_notifikasi_d_lokasi_kerja">
<input type="text" data-table="tb_notifikasi_d" data-field="x_lokasi_kerja" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($tb_notifikasi_d->lokasi_kerja->getPlaceHolder()) ?>" value="<?php echo $tb_notifikasi_d->lokasi_kerja->EditValue ?>"<?php echo $tb_notifikasi_d->lokasi_kerja->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_lokasi_kerja" name="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" id="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->lokasi_kerja->OldValue) ?>">
<?php } ?>
<?php if ($tb_notifikasi_d->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_notifikasi_d_grid->RowCnt ?>_tb_notifikasi_d_lokasi_kerja" class="form-group tb_notifikasi_d_lokasi_kerja">
<span<?php echo $tb_notifikasi_d->lokasi_kerja->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_notifikasi_d->lokasi_kerja->EditValue ?></p></span>
</span>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_lokasi_kerja" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->lokasi_kerja->CurrentValue) ?>">
<?php } ?>
<?php if ($tb_notifikasi_d->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_notifikasi_d_grid->RowCnt ?>_tb_notifikasi_d_lokasi_kerja" class="tb_notifikasi_d_lokasi_kerja">
<span<?php echo $tb_notifikasi_d->lokasi_kerja->ViewAttributes() ?>>
<?php echo $tb_notifikasi_d->lokasi_kerja->ListViewValue() ?></span>
</span>
<?php if ($tb_notifikasi_d->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_lokasi_kerja" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->lokasi_kerja->FormValue) ?>">
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_lokasi_kerja" name="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" id="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->lokasi_kerja->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_lokasi_kerja" name="ftb_notifikasi_dgrid$x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" id="ftb_notifikasi_dgrid$x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->lokasi_kerja->FormValue) ?>">
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_lokasi_kerja" name="ftb_notifikasi_dgrid$o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" id="ftb_notifikasi_dgrid$o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->lokasi_kerja->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tb_notifikasi_d_grid->ListOptions->Render("body", "right", $tb_notifikasi_d_grid->RowCnt);
?>
	</tr>
<?php if ($tb_notifikasi_d->RowType == EW_ROWTYPE_ADD || $tb_notifikasi_d->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftb_notifikasi_dgrid.UpdateOpts(<?php echo $tb_notifikasi_d_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($tb_notifikasi_d->CurrentAction <> "gridadd" || $tb_notifikasi_d->CurrentMode == "copy")
		if (!$tb_notifikasi_d_grid->Recordset->EOF) $tb_notifikasi_d_grid->Recordset->MoveNext();
}
?>
<?php
	if ($tb_notifikasi_d->CurrentMode == "add" || $tb_notifikasi_d->CurrentMode == "copy" || $tb_notifikasi_d->CurrentMode == "edit") {
		$tb_notifikasi_d_grid->RowIndex = '$rowindex$';
		$tb_notifikasi_d_grid->LoadRowValues();

		// Set row properties
		$tb_notifikasi_d->ResetAttrs();
		$tb_notifikasi_d->RowAttrs = array_merge($tb_notifikasi_d->RowAttrs, array('data-rowindex'=>$tb_notifikasi_d_grid->RowIndex, 'id'=>'r0_tb_notifikasi_d', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($tb_notifikasi_d->RowAttrs["class"], "ewTemplate");
		$tb_notifikasi_d->RowType = EW_ROWTYPE_ADD;

		// Render row
		$tb_notifikasi_d_grid->RenderRow();

		// Render list options
		$tb_notifikasi_d_grid->RenderListOptions();
		$tb_notifikasi_d_grid->StartRowCnt = 0;
?>
	<tr<?php echo $tb_notifikasi_d->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tb_notifikasi_d_grid->ListOptions->Render("body", "left", $tb_notifikasi_d_grid->RowIndex);
?>
	<?php if ($tb_notifikasi_d->employee_id->Visible) { // employee_id ?>
		<td data-name="employee_id">
<?php if ($tb_notifikasi_d->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_notifikasi_d_employee_id" class="form-group tb_notifikasi_d_employee_id">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$tb_notifikasi_d->employee_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_notifikasi_d->employee_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tb_notifikasi_d_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="sv_x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="<?php echo $tb_notifikasi_d->employee_id->EditValue ?>" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->getPlaceHolder()) ?>"<?php echo $tb_notifikasi_d->employee_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_employee_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_notifikasi_d->employee_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ftb_notifikasi_dgrid.CreateAutoSuggest({"id":"x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_notifikasi_d->employee_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($tb_notifikasi_d->employee_id->ReadOnly || $tb_notifikasi_d->employee_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="ln_x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="ln_x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian,x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja">
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_notifikasi_d_employee_id" class="form-group tb_notifikasi_d_employee_id">
<span<?php echo $tb_notifikasi_d->employee_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_notifikasi_d->employee_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_employee_id" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_employee_id" name="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" id="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_employee_id" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->employee_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_notifikasi_d->bagian->Visible) { // bagian ?>
		<td data-name="bagian">
<?php if ($tb_notifikasi_d->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_notifikasi_d_bagian" class="form-group tb_notifikasi_d_bagian">
<input type="text" data-table="tb_notifikasi_d" data-field="x_bagian" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($tb_notifikasi_d->bagian->getPlaceHolder()) ?>" value="<?php echo $tb_notifikasi_d->bagian->EditValue ?>"<?php echo $tb_notifikasi_d->bagian->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_notifikasi_d_bagian" class="form-group tb_notifikasi_d_bagian">
<span<?php echo $tb_notifikasi_d->bagian->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_notifikasi_d->bagian->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_bagian" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->bagian->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_bagian" name="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" id="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_bagian" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->bagian->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_notifikasi_d->lokasi_kerja->Visible) { // lokasi_kerja ?>
		<td data-name="lokasi_kerja">
<?php if ($tb_notifikasi_d->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_notifikasi_d_lokasi_kerja" class="form-group tb_notifikasi_d_lokasi_kerja">
<input type="text" data-table="tb_notifikasi_d" data-field="x_lokasi_kerja" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($tb_notifikasi_d->lokasi_kerja->getPlaceHolder()) ?>" value="<?php echo $tb_notifikasi_d->lokasi_kerja->EditValue ?>"<?php echo $tb_notifikasi_d->lokasi_kerja->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_notifikasi_d_lokasi_kerja" class="form-group tb_notifikasi_d_lokasi_kerja">
<span<?php echo $tb_notifikasi_d->lokasi_kerja->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_notifikasi_d->lokasi_kerja->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_lokasi_kerja" name="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" id="x<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->lokasi_kerja->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_notifikasi_d" data-field="x_lokasi_kerja" name="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" id="o<?php echo $tb_notifikasi_d_grid->RowIndex ?>_lokasi_kerja" value="<?php echo ew_HtmlEncode($tb_notifikasi_d->lokasi_kerja->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tb_notifikasi_d_grid->ListOptions->Render("body", "right", $tb_notifikasi_d_grid->RowCnt);
?>
<script type="text/javascript">
ftb_notifikasi_dgrid.UpdateOpts(<?php echo $tb_notifikasi_d_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($tb_notifikasi_d->CurrentMode == "add" || $tb_notifikasi_d->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $tb_notifikasi_d_grid->FormKeyCountName ?>" id="<?php echo $tb_notifikasi_d_grid->FormKeyCountName ?>" value="<?php echo $tb_notifikasi_d_grid->KeyCount ?>">
<?php echo $tb_notifikasi_d_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tb_notifikasi_d->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $tb_notifikasi_d_grid->FormKeyCountName ?>" id="<?php echo $tb_notifikasi_d_grid->FormKeyCountName ?>" value="<?php echo $tb_notifikasi_d_grid->KeyCount ?>">
<?php echo $tb_notifikasi_d_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tb_notifikasi_d->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftb_notifikasi_dgrid">
</div>
<?php

// Close recordset
if ($tb_notifikasi_d_grid->Recordset)
	$tb_notifikasi_d_grid->Recordset->Close();
?>
<?php if ($tb_notifikasi_d_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($tb_notifikasi_d_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($tb_notifikasi_d_grid->TotalRecs == 0 && $tb_notifikasi_d->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tb_notifikasi_d_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($tb_notifikasi_d->Export == "") { ?>
<script type="text/javascript">
ftb_notifikasi_dgrid.Init();
</script>
<?php } ?>
<?php
$tb_notifikasi_d_grid->Page_Terminate();
?>
