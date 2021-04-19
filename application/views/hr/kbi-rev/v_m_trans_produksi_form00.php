<div class="modal fade" id="formInputEdit" style="display: none;height:720px;width:1050px;">
    <div class="modal-dialog " style="width:100%;height:710px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Form Input/Edit Data Produksi</h4>
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
					<label class="col-sm-2 control-label">Lokasi</label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-4">
								<select id="txtkdlokasi">
								<?php
									foreach($LULokasi as $key=>$value){
										echo "<option value='".$value["KD_LOKASI"]."'>".$value["KET"]."</option>";
									}
								?>
								</option>
								</select>
							</div>
						</div>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 control-label">Lini</label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-12">
								<input id="txtkdlini" readonly style="width:10%;"/>&nbsp;<button type="button" id="btnopenLULini" class="btn btn-primary" value="" onclick="evtOpenLULini()"><i class="fa fa-search"></i></button><input id="txtlini" readonly style="width:80%;"/>
							</div>
						</div>
					</div>
				</div>			
				<div class="form-group">
					<label class="col-sm-2 control-label">Shift</label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-4">
								<select id="txtshift">
								<?php
									$arrShift=array(1=>"1",2=>"2",3=>"3");
									foreach($arrShift as $key=>$value)
									{
										echo "<option value='$key'>$value</option>";
									}
								?>
								</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Produk :</label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-12">
								<input id="txtkdproduk" readonly style="width:20%;"/>&nbsp;<button type="button" id="btnopenLULini" class="btn btn-primary" value="" onclick="evtOpenLU('-1')"><i class="fa fa-search"></i></button><input id="txtproduk" readonly style="width:70%;"/>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">SPPRB :</label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-12">
								<input id="txtnospprb" readonly style="width:90%;"/>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Volume :</label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-12">
								<input id="txtvolbaik" style="width:10%;text-align:right;"/>
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
					<input type="hidden" id="txtjtrans" value="<?php echo $jtrans;?>" />
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