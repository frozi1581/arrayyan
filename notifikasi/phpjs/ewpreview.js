/**
 * Detail Preview Extension for PHPMaker 2018
 * @license (C) 2017 e.World Technology Ltd.
 */
var EW_LOADING_HTML="<div class='ewSpinner'><div></div></div> "+ewLanguage.Phrase("Loading");var EW_PREVIEW_BUTTON_SELECTOR=".ewPreviewRowBtn";function ew_AddRowToTable(t){var e=jQuery,a=e(t),r,o,i=0;var s=a.closest("tbody");if(EW_PREVIEW_SINGLE_ROW)s.find("tr."+EW_TABLE_PREVIEW_ROW_CLASSNAME).remove();e(t.cells).each(function(){i+=this.colSpan});var d=a.nextAll("tr[data-rowindex!="+a.data("rowindex")+"]").first();if(d.hasClass(EW_TABLE_PREVIEW_ROW_CLASSNAME)){return d[0]}else if(r=s[0].insertRow(d[0]?d[0].sectionRowIndex:-1)){e(r).addClass(EW_TABLE_PREVIEW_ROW_CLASSNAME);o=e(r.insertCell(0)).addClass(EW_TABLE_LAST_COL_CLASSNAME).prop("colSpan",i)}return r}function ew_ShowDetails(t){var e=jQuery,a=e(this),r=a.is("tr[data-rowindex]"),o=r?a:a.closest("tr[data-rowindex]"),i=o.closest("table");if(!o[0])return;if(!o.data("preview")){var s=ew_AddRowToTable(o[0]);var d=e(s.cells[0]);var n=o.find("[class$=_preview] div.ewPreview");d.empty();d.append(e("#ewPreview").contents().clone()).find(".nav-tabs").append(n.find("li:has([data-toggle='tab'])").clone(true)).find("[data-toggle='tab']").attr("data-target","#"+d.find(".tab-pane").attr("id",ew_Random()).attr("id")).first().tab("show");(EW_PREVIEW_SINGLE_ROW?i:o).find(EW_PREVIEW_BUTTON_SELECTOR).addClass("icon-expand").removeClass("icon-collapse");o.data("preview",true).find(EW_PREVIEW_BUTTON_SELECTOR).addClass("icon-collapse").removeClass("icon-expand")}else{var l=o.nextAll("tr[data-rowindex!='"+o.data("rowindex")+"']").first();if(l.hasClass(EW_TABLE_PREVIEW_ROW_CLASSNAME))l.remove();o.data("preview",false).find(EW_PREVIEW_BUTTON_SELECTOR).addClass("icon-expand").removeClass("icon-collapse")}ew_SetupTable(-1,i[0],true)}function ew_Detail(t,e){var a=jQuery,r=a(e),o=r.closest(".ewListOptionBody"),i=r.data("placement")||EW_PREVIEW_PLACEMENT,s=o.find(".dropdown-menu"),d=o.find(".btn-group");s.mouseenter(function(t){t.stopPropagation()});if(d[0]){if(i=="right")s.addClass("pull-right");r=d}if(r.data("bs.popover"))return;r.popover({html:true,delay:{show:100,hide:250},placement:i,trigger:"hover",container:a("#ewTooltip")[0],content:EW_LOADING_HTML}).on("show.bs.popover",function(t){a(".popover.ewPreviewOverlay").hide();r.data("bs.popover").tip().css("opacity",0)}).on("shown.bs.popover",function(t){var e=r.data("bs.popover").tip().css({"min-width":"200px","max-width":"1000px"});e.find(".popover-content").html(a("#ewPreview").html());e.find(".nav-tabs").append(o.find("li:has([data-toggle='tab'])").clone(true));e.find("[data-toggle='tab']").attr("data-target","#"+e.find(".tab-pane").attr("id",ew_Random()).attr("id")).data("$element",r).first().tab("show");ew_MoveTip(r);e.fadeTo(0,1).addClass("ewPreviewOverlay")}).data("bs.popover").tip().mouseenter(function(t){clearTimeout(r.data("bs.popover").timeout)}).mouseleave(function(t){var e=r.data("bs.popover");if(e.tip().html().indexOf(EW_LOADING_HTML)>-1)return;e.timeout=setTimeout(function(){e.hide.call(e)},e.options.delay.hide)})}function ew_MoveTip(t){var e=jQuery,a=t.data("placement")||EW_PREVIEW_PLACEMENT;if(a!="left"&&a!="right")return;var r=e(document),o=e(document.body),i=t.data("bs.popover").tip(),s=i.width(),d=i.offset(),n=t.parent();bottom=r.scrollTop()+o.outerHeight()-i.outerHeight();if(n.hasClass("btn-group")){t=n;n=t.parent()}var l=t.offset();d.top=l.top+t.height()/2-i.height()/2;d.top=Math.max(r.scrollTop(),Math.min(bottom,d.top));i.css("top",d.top+"px");if(a=="right"&&t.is(".btn-group"))i.css("left",l.left+t.width());var p=i.find(".arrow");if(a=="left"){left=l.left-i.outerWidth()-p.width();i.css("left",left)}var f=l.top-d.top+t.height()/2-p.height();var w=(parseInt(i.css("border-top-left-radius"),10)||6)-parseInt(p.css("margin-top"),10);var c=i.height()-w-p.height();p.css("top",Math.max(w,Math.min(f,c))+"px")}function ew_TabShow(t){var e=jQuery,a=e(t.currentTarget),r=a.data("target"),o=e(r),i=a.data("table"),s="",d;if(!o[0])return;if(a.data("url")){d=o.data(i)||{};d.url=url=a.data("url");start=d.start||1;sort=d.sort;sortOrder=d.sortOrder}else if(a.data("start")){if(a.tooltip)a.tooltip("hide");d=o.data(i);url=d.url;d.start=start=a.data("start")||1;sort=d.sort;sortOrder=d.sortOrder}else if(a.data("sort")){d=o.data(i);url=d.url;start=d.start||1;d.sort=sort=a.data("sort");d.sortOrder=sortOrder=a.data("sortOrder");if(sort!==d.sort||sortOrder!==d.sortOrder){d.start=start=1;d.sortOrder=sortOrder=""}}o.data(i,d).empty().html(EW_LOADING_HTML);if(e.isNumber(start))s+="&start="+start;if(sort){s+="&sort="+encodeURIComponent(sort);if(sortOrder=="ASC"||sortOrder=="DESC")s+="&sortorder="+sortOrder}e.get(url+s,function(t){o.empty().html(t).append(e("div[data-table='"+i+"'][data-url='"+url+"']:first").clone());o.find(".ewPager > div > .btn-group > .btn:not(.disabled), .ewTableHeader > th > div[data-sort]").data({target:r,table:i}).click(ew_TabShow);e(document).trigger("preview",[{$tabpane:o}]);if(a.data("$element"))ew_MoveTip(a.data("$element"))})}function ew_Preview(t,e){var a=e.$tabpane;a.find("table."+EW_TABLE_CLASSNAME).each(ew_SetupTable);ew_InitIcons();a.find("a.ewTooltipLink").each(ew_Tooltip);$(".ewLightbox").each(function(){var t=$(this);t.colorbox($.extend({rel:t.data("rel")},ewLightboxSettings))})}jQuery(document).on("preview",ew_Preview);jQuery(function(t){if(EW_PREVIEW_OVERLAY)t("div.ewPreview").each(function(){t(this).parent().find("[data-action='view'],[data-action='list']").each(ew_Detail)});t(EW_PREVIEW_BUTTON_SELECTOR).click(ew_ShowDetails);t("div.ewPreview [data-toggle='tab']").on("show.bs.tab",ew_TabShow)});