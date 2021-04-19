

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
		<li style="margin-left: 30px;">[KPI Level 1]</li>
		<li>[KPI Level 2]</li>
		<li>[KPI Level 3]</li>
		<li>[KPI Level 4]</li>
	</ul>
	<div>
		<table cellpadding="2" cellspacing="2" border="0" style="width:100%;">
			<tr>
				<td style="width:100%;"><div id="jqxGridL1" style="margin-top: 1px;width: 100%; " > </div></td>
			</tr>
		</table>
	</div>
	<div>
		<table cellpadding="2" cellspacing="2" border="0" style="width:100%;">
			<tr>
				<td style="width:100%;"><div id="jqxGridL2" style="margin-top: 1px;width: 100%; " > </div></td>
			</tr>
		</table>
	</div>
	<div>
		<table cellpadding="2" cellspacing="2" border="0" style="width:100%;">
			<tr>
				<td style="width:100%;"><div id="jqxGridL3" style="margin-top: 1px;width: 100%; " > </div></td>
			</tr>
                        
		</table>
	</div>  
	<div>
		<table cellpadding="2" cellspacing="2" border="0" style="width:100%;">
			<tr>
				<td style="width:100%;"><div id="jqxGridL4" style="margin-top: 1px;width: 100%; " > </div></td>
			</tr>
                        
		</table>
	</div>
</div>
