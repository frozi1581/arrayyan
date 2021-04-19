

<ul class="nav nav-tabs">
   <?php
		foreach($listbl as $key=>$value){
			if($value["BL"]==$ivalue){
				echo "<li class='active'><a data-toggle='tab' href='#tab-content".$value["BL"]."' value='".$value["BL"]."'>".substr($value["BL"],0,2)." - ".substr($value["BL"],-4)."</a></li>";
			}else{
				echo "<li class=''><a data-toggle='tab' href='#tab-content".$value["BL"]."' value='".$value["BL"]."'>".substr($value["BL"],0,2)." - ".substr($value["BL"],-4)."</a></li>";
			}
		}
  ?>
</ul>

<div id='subtabs'>
	<ul>
		<li style="margin-left: 30px;">[Daftar Peserta KBI]</li>
		<li>[Rekapitulasi]</li>
		<li>[Daftar Belum Mengisi KBI]</li>
		<li>[Daftar Sudah Mengisi KBI]</li>
	</ul>
	<div>
		<table cellpadding="2" cellspacing="2" border="0" style="width:100%;">
			<tr>
				<td style="width:100%;"><div id="jqxgrid" style="margin-top: 1px;width: 100%; " > </div></td>
			</tr>
		</table>
	</div>
	<div>
		<table cellpadding="2" cellspacing="2" border="0" style="width:100%;">
			<tr>
				<td style="width:100%;"><div id="jqxgrid1B" style="margin-top: 1px;width: 100%; " > </div></td>
			</tr>
		</table>
	</div>
	<div>
		<table cellpadding="2" cellspacing="2" border="0" style="width:100%;">
			<tr>
				<td style="width:100%;"><div id="jqxgrid1C" style="margin-top: 1px;width: 100%; " > </div></td>
			</tr>
                        
		</table>
	</div>  
	<div>
		<table cellpadding="2" cellspacing="2" border="0" style="width:100%;">
			<tr>
				<td style="width:100%;"><div id="jqxgrid1D" style="margin-top: 1px;width: 100%; " > </div></td>
			</tr>
                        
		</table>
	</div>
</div>
