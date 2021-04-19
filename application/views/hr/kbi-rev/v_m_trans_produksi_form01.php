<div class="modal fade" id="formInputEdit" style="display: none;height:720px;width:1050px;">
    <div class="modal-dialog " style="width:100%;height:710px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Form Input/Edit Data Pengalihan</h4>
        </div>
		
        <form role="form" class="form-horizontal" action="#" >
			<div class="modal-body">
				<div class="form-group">
					<label class="col-sm-2 control-label">Tanggal</label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-4">
								<div id="txttgl"></div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
				
						
					<label class="col-sm-2 control-label">Produk Tujuan <i>(Penerima) </i> :</label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-12">
								<table style="cellpadding:2px;cellspacing:2px;border:0px; width:100%;">
									<tr style="text-align:center;align:center;">
										<th style="width:5%;">No</th>
										<th style="width:25%;">No SPPrB</th>
										<th style="width:5%;">&nbsp;</th>
										<th style="width:12%;">Kode Produk</th>
										<th>Produk</th>
										<th style="width:15%;">Volume</th>
									</tr>
									<tr>
										<td>1.</td>
										<td><input id="txtnospprb" readonly style="width:99%;"/></td>
										<td><button type="button" id="btnopenLU" class="btn btn-primary" value="-1" onclick="evtOpenLU('-1')"><i class="fa fa-search"></i></button></td>
										<td><input id="txtkdproduk" type="text" readonly style="width:99%;"/></td>
										<td><input id="txtproduk" type="text" readonly style="width:99%;"/></td>
										<td><input id="txtvolbaik" style="text-align:right;width:99%;"/></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Produk Asal  <i>(Pengurang) </i> : </label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-12">
								<table style="cellpadding:2px;cellspacing:2px;border:0px; width:100%;">
								<?php 
								$imaxRow = 1;
								if($ivalue=="61"){
									$imaxRow = 8;
								}
								for($i=0;$i<$imaxRow;$i++)
								{
									?>
										<tr style="height:40px;">
											<td style="width:5%;"><?php echo ($i+1); ?>.</td>
											<td style="width:25%;"><input id="txtnospprbdari<?php echo $i; ?>" style="width:99%;" readonly/></td>
											<td style="width:5%;"><button type="button" id="btnopenLU<?php echo $i;?>" class="btn btn-primary" value="<?php echo $i;?>"  onclick="evtOpenLU('<?php echo $i; ?>')"><i class="fa fa-search"></i></button></td>
											<td style="width:12%;"><input id="txtkdprodukdari<?php echo $i; ?>" style="width:99%;" readonly/></td>
											<td><input id="txtprodukdari<?php echo $i; ?>" style="width:99%;" readonly/></td>
											
											<td style="width:15%;"><input id="txtvolbaikdari<?php echo $i; ?>"  style="text-align:right;width:99%;"/>
											<input type="hidden" id="txttrxiddari<?php echo $i;?>" /></td>
										</tr>
										
								<?php 
								}
								?>
								</table>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-4">
								
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-4">
								
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<div class="row">
							<button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Tutup</button>
							<button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="prosesSaveUpdateEvt()">Simpan</button>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<input type="hidden" id="txtvalue" value="11" />
					<input type="hidden" id="txtrowactive" value="" />
					<input type="hidden" id="txtjtrans" value="12" />
					<input type="hidden" id="txttrxid" value="" />
				</div>        
			</div>
			<div id="dvopenLU" style="width:100%;height:520px;top:0px;left:0px;position:absolute;background-color: #ffffff;border:1px solid grey;z-index:999;display:none;">
				<div  id="jqxgridLU" style="margin-top: 1px;width: 100%; " > </div>
			</div>
			<div id="dvopenLU2" style="width:800px;height:520px;top:0px;left:0px;position:absolute;background-color: #ffffff;border:1px solid grey;z-index:999;display:none;">
				<div  id="jqxgridLU2" style="margin-top: 1px;width: 100%; " > </div>
			</div>
			<div id="dvopenLULini" style="width:100%;height:520px;top:0px;left:0px;position:absolute;background-color: #ffffff;border:1px solid grey;z-index:999;display:none;">
				<div  id="jqxgridLULini" style="margin-top: 1px;width: 100%; " > </div>
			</div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>