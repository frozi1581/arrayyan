<?php if (@!$gbSkipHeaderFooter) { ?>
		<?php if (isset($gTimer)) $gTimer->Stop() ?>
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<!-- Main Footer -->
	<footer class="main-footer">
		<!-- To the right -->
		<div class="pull-right hidden-xs"></div>
		<!-- Default to the left --><!-- ** Note: Only licensed users are allowed to change the copyright statement. ** -->
		<div class="ewFooterText"><?php echo $Language->ProjectPhrase("FooterText") ?></div>
	</footer>
</div>
<!-- ./wrapper -->
<?php } ?>
<script type="text/html" class="ewJsTemplate" data-name="menu" data-data="menu" data-method="appendTo" data-target="#ewMenu.ewHorizontal">
<ul class="nav navbar-nav">
{{include tmpl="#menu"/}}
</ul>
</script>
<script type="text/html" id="menu">
{{if items}}
	{{for items}}
		<li id="{{:id}}" name="{{:name}}" class="{{if isHeader}}{{if parentId > -1}}dropdown-header{{/if}}{{else}}not-header{{if active}} active{{/if}}{{/if}}{{if items}} dropdown{{/if}}{{if items && parentId != -1}} dropdown-submenu{{/if}}">
			{{if isHeader && parentId > -1}}
				{{if icon}}<i class="{{:icon}}"></i>{{/if}}
				<span>{{:text}}</span>
			{{else}}
			<a href="{{:href}}"{{if target}} target="{{:target}}"{{/if}}{{if attrs}}{{:attrs}}{{/if}}{{if items}} class="dropdown-toggle ewDropdown"{{/if}}>
				{{if icon}}<i class="{{:icon}}"></i>{{/if}}
				<span>{{:text}}</span>
				{{if items}}
				<b class="caret"></b>
				{{/if}}
			</a>
			{{/if}}
			{{if items}}
			<ul class="dropdown-menu">
				{{include tmpl="#menu"/}}
			</ul>
			{{/if}}
		</li>
	{{/for}}
{{/if}}
</script>
<script type="text/html" class="ewJsTemplate" data-name="languages" data-data="languages" data-method="<?php echo $Language->Method ?>" data-target="<?php echo ew_HtmlEncode($Language->Target) ?>">
<?php echo $Language->GetTemplate() ?>
</script>
<script type="text/javascript">
ew_RenderJsTemplates();
</script>
<!-- modal dialog -->
<div id="ewModalDialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"></div></div></div></div>
<!-- modal lookup dialog -->
<div id="ewModalLookupDialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"></div></div></div></div>
<!-- message box -->
<div id="ewMsgBox" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ewButton" data-dismiss="modal"><?php echo $Language->Phrase("MessageOK") ?></button></div></div></div></div>
<!-- prompt -->
<div id="ewPrompt" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ewButton"><?php echo $Language->Phrase("MessageOK") ?></button><button type="button" class="btn btn-default ewButton" data-dismiss="modal"><?php echo $Language->Phrase("CancelBtn") ?></button></div></div></div></div>
<!-- session timer -->
<div id="ewTimer" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ewButton" data-dismiss="modal"><?php echo $Language->Phrase("MessageOK") ?></button></div></div></div></div>
<!-- tooltip -->
<div id="ewTooltip"></div>
<script type="text/javascript">
jQuery.get("<?php echo $EW_RELATIVE_PATH ?>phpjs/userevt14.js");
</script>
<script type="text/javascript">

// Write your global startup script here
// document.write("page loaded");

</script>
</body>
</html>
