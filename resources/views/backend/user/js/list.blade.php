


<script type="text/javascript">



    $(function(){
        $(document).on('click','#delete', function (e) {
            e.preventDefault();
            var link = $(this).attr("href");

            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "La Suppression du poste sera définitif !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, Supprimer !',
                customClass: {
                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                    cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    window.location.href = link
                    Swal.fire({
                        icon: 'success',
                        title: 'Supprimé!',
                        text: 'Votre fichier a été supprimé.',
                        customClass: {
                            confirmButton: 'btn btn-success waves-effect waves-light'
                        }
                    });
                }
            });

        });
    });

</script>





<!-- Page JS -->
{{--    <script src="{{ asset('backend/js/tables-datatables-basic.js')}}"></script>--}}

<script>
    $("#declaration-table").DataTable({
        "responsive": true,
        "autoWidth": true,
        "paging" : true,
        "searching": true,
        "info":     true,
        "language" : {
            "url" : '{!!asset('backend/plugins/dataTable.french.lang')!!}'
        },
        dom:
            '<"card-header border-bottom p-4"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        lengthMenu: [7, 10, 25, 50, 75, 100],
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn btn-primary waves-effect waves-light',
                text: '<i class="ti ti-file-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Exporter</span>',
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="ti ti-printer me-1" ></i> Imprimer',
                        className: 'dropdown-item',
                        title: 'Liste des utilisateurs',
                        exportOptions: {
                            columns: [0, 1, 2, 3],
                            // prevent avatar to be display
                            format: {
                                body: function (inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function (index, item) {
                                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                                            result = result + item.lastChild.firstChild.textContent;
                                        } else if (item.innerText === undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        },
                        customize: function (win) {
                            //customize print view for dark
                            $(win.document.body)
                                .css('color', config.colors.headingColor)
                                .css('border-color', config.colors.borderColor)
                                .css('background-color', config.colors.bodyBg);
                            $(win.document.body)
                                .find('table')
                                .addClass('compact')
                                .css('color', 'inherit')
                                .css('border-color', 'inherit')
                                .css('background-color', 'inherit');
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="ti ti-file-text me-1" ></i> CSV',
                        className: 'dropdown-item',
                        title: 'Liste des services',
                        exportOptions: {
                            columns: [0, 1, 2, 3],
                            // prevent avatar to be display
                            format: {
                                body: function (inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function (index, item) {
                                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                                            result = result + item.lastChild.firstChild.textContent;
                                        } else if (item.innerText === undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="ti ti-file-spreadsheet me-1"></i> Excel',
                        className: 'dropdown-item',
                        title: 'Liste des services',
                        exportOptions: {
                            columns: [0, 1, 2, 3],
                            // prevent avatar to be display
                            format: {
                                body: function (inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function (index, item) {
                                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                                            result = result + item.lastChild.firstChild.textContent;
                                        } else if (item.innerText === undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="ti ti-file-description me-1"></i> PDF',
                        className: 'dropdown-item',
                        title: 'Liste des services',
                        exportOptions: {
                            columns: [0, 1, 2, 3],
                            // prevent avatar to be display
                            format: {
                                body: function (inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function (index, item) {
                                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                                            result = result + item.lastChild.firstChild.textContent;
                                        } else if (item.innerText === undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        }
                    },
                    {
                        extend: 'copy',
                        text: '<i class="ti ti-copy me-1" ></i> Copier',
                        className: 'dropdown-item',
                        title: 'Liste des services',
                        exportOptions: {
                            columns: [0, 1, 2, 3],
                            // prevent avatar to be display
                            format: {
                                body: function (inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function (index, item) {
                                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                                            result = result + item.lastChild.firstChild.textContent;
                                        } else if (item.innerText === undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        }
                    }
                ]
            },
            /*{
                text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add New User</span>',
                className: 'add-new btn btn-primary waves-effect waves-light ms-3',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#exLargeModal'
                }
            }*/
            /*{
                text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Record</span>',
                className: 'create-new btn btn-primary waves-effect waves-light'
            }*/
        ],

        initComplete: function () {
            // Adding role filter once table initialized
            /*this.api()
                .columns(4)
                .every(function () {
                    var column = this;
                    var select = $(
                        '<select id="UserRole" class="form-select text-capitalize"><option value=""> Select Rôle </option></select>'
                    )
                        .appendTo('.user_role')
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });
                });*/
            // Adding plan filter once table initialized
            /*this.api()
                .columns(3)
                .every(function () {
                    var column = this;
                    var select = $(
                        '<select id="UserPlan" class="form-select text-capitalize"><option value=""> Select Service </option></select>'
                    )
                        .appendTo('.user_plan')
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });
                });*/
            // Adding status filter once table initialized
            this.api()
                .columns(2)
                .every(function () {
                    var column = this;
                    var select = $(
                        '<select id="FilterTransaction" class="form-select text-capitalize"><option value=""> Selectionnez Rôle </option></select>'
                    )
                        .appendTo('.user_role')
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });

                   /* column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append(
                                '<option value="' +
                                statusObj[d].title +
                                '" class="text-capitalize">' +
                                statusObj[d].title +
                                '</option>'
                            );
                        });*/
                });
        }


    });

    $('div.head-label').html('<h5 class="card-title mb-0">DataTable with Buttons</h5>');
</script>
