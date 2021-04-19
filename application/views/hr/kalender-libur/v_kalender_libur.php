<?php
	?>
 
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/telerik-php/styles/kendo.common.min.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/telerik-php/styles/kendo.default.min.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/telerik-php/styles/kendo.default.mobile.min.css" />
	
	<script src="<?php echo base_url() ?>assets/telerik-php/js/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>assets/telerik-php/js/kendo.all.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.css">
    <script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.js"></script>

    <style type="text/css">

        .sidebar-toggle{
            display:none;
        }
        

    </style>
    
</head>
<body>
<div id="example">
    <h2 style="padding-left: 10px">Kalender Libur</h2>

    <div id="grid"></div>
    
	<script>
        $(document).ready(function () {
            var addr = "<?php echo base_url(); ?>index.php/hr/kalender-libur/KalenderLiburController/";

            $("#grid").kendoGrid({
                dataSource: {
                    transport: {
                        read: {
                            url: addr + "getAllList",
                            dataType: "json",
                            type: "post"
                        },
                        create: {
                            url: addr + "create",
                            dataType: "json",
                            type: "post",
                            complete: function(e) {
                                $("#grid").data("kendoGrid").dataSource.read(); 
                            }
                        },
                        update: {
                            url: addr + "update",
                            dataType: "json",
                            type: "post",
                            complete: function(e) {
                                $("#grid").data("kendoGrid").dataSource.read(); 
                            }
                        },
                        destroy: {
                            url: addr + "delete",
                            dataType: "json",
                            type: "post"
                        },
                    },
                    pageSize: 20,
                    schema: {
                        model: {
                            id: "TGL",
                            fields: {
                                TGL: { field: "TGL" },
                                KETERANGAN: { field: "KETERANGAN"},
                                STATUS: { field: "STATUS"}
                            }
                        },
                    },
                },
                height: 550,
                sortable: true,
                toolbar: ["create"],
                editable: {
                    mode: "popup",
                    template: kendo.template($("#template").html())
                },
                columns: [{
                    field: "TGL",
                    title: "Tanggal",
                }, {
                    field: "KETERANGAN",
                    title: "Keterangan"
                }, {
                    field: "STATUS",
                    title: "Status",
                    width: 70
                }, 
                { command: ["edit", "destroy"], title: "ACTION", width: "250px" }]
            });
        });
	</script>
    <script type="text/x-kendo-template" id="template">   
        #if(data.isNew()) {#
            #var createTemp = kendo.template($("\#createTemplate").html());#
            #=createTemp(data)#
        #} else {#
            #var editTemp = kendo.template($("\#editTemplate").html());#
            #=editTemp(data)#
        #}#
    </script>
    <script id="createTemplate" type="text/x-kendo-template">
        <div class="form-group formCustom">
            <label for="Rekomendasi">Tanggal:</label>
            <input data-bind="value:TGL" type="date" class="form-control" required>
        </div>
        <div class="form-group formCustom">
            <label for="Rekomendasi">Rekomendasi:</label>
            <textarea data-bind="value:KETERANGAN" class="form-control" rows="5" aria-label="With textarea" required></textarea>
        </div>
        <div class="form-group formCustom">
            <label for="PihakTerkait">Status:</label><br>
            <select data-bind="value:STATUS" required>
                <option value="LN">Libur Nasional (LN)</option>
                <option value="CB">Cuti Bersama (CB)</option>
            </select>
        </div>
    </script>
    <script id="editTemplate" type="text/x-kendo-template">
        <div class="form-group formCustom">
            <label for="Rekomendasi">Tanggal:</label>
            <input data-bind="value:TGL" class="form-control" disabled>
        </div>
        <div class="form-group formCustom">
            <label for="Rekomendasi">Rekomendasi:</label>
            <textarea data-bind="value:KETERANGAN" class="form-control" rows="5" aria-label="With textarea" required></textarea>
        </div>
        <div class="form-group formCustom">
            <label for="PihakTerkait">Status:</label><br>
            <select data-bind="value:STATUS" required>
                <option value="LN">Libur Nasional (LN)</option>
                <option value="CB">Cuti Bersama (CB)</option>
            </select>
        </div>
    </script>
</div>
<style>
    .form-small {
        padding: 0px 5px;
    }
    div.k-edit-form-container {
        width: 500px;
        height: auto;
    }
    .formCustom {
        width: 90%;
        padding: 0 12px;
    }
</style>
</body>
</html>
