var locationUrl = $(location).attr("href").split("/"),
    TableDatatablesEditable = function() {
        var e = function() {
            var e = $("#sample_1"),
                t = e.dataTable({
                    dom: "Bfrtip",
                    buttons: [{
                        extend: "print",
                        className: "btn dark btn-outline"
                    }, {
                        extend: "pdf",
                        className: "btn green btn-outline"
                    }, {
                        extend: "csv",
                        className: "btn purple btn-outline "
                    }],
                    language: {
                        lengthMenu: " _MENU_ records"
                    },
                    columnDefs: [{
                        orderable: !0,
                        targets: [0]
                    }, {
                        searchable: !0,
                        targets: [0]
                    },
                     ],
                    order: [
                        [3, "asc"]
                    ],
                    lengthMenu: [
                        [5, 10, 15, 20, -1],
                        [5, 10, 15, 20, "All"]
                    ],
                    pageLength: -1,
                    dom: "<'row' <'col-md-12'B>><'row'<><>r><><'row'<'col-md-5 col-sm-12'i><>>"
                });
            $("#sample_editable_1_wrapper");
            e.on("click", ".delete", function(e) {
                e.preventDefault();
                var a = $(this).parents("tr")[0],
                    l = $(this).closest("tr").attr("id"),
                    n = {
                        _token: $("input[name='_token']").val()
                    };
                n = jQuery.param(n), BootstrapDialog.confirm("Are you sure?", function(e) {
                    if (e) {
                        var o = n,
                            r = "/" + locationUrl[3] + "/" + l;
                        ajaxCall("DELETE", r, o, "result", "", !1, "delete"), t.fnDeleteRow(a)
                    }
                })
            })
        };
        return {
            init: function() {
                e()
            }
        }
    }();
jQuery(document).ready(function() {
    TableDatatablesEditable.init();
});