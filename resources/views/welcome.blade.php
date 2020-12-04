<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Exam</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css">




</head>

<body>


    <div class="container mt-5">

        <div class="row">

            <div class="col-12 action-btn">

                <div class="btn-group float-right mb-3" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-dtr">Add DTR</button>
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".import-dtr">Import DTR</button>
                </div>

            </div>

            <div class="col-12">

                <table class="table table-hover table-striped users-tbl">
                    <thead>
                        <tr>
                            <th scope="col">Employee Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($users as $item)
                        <tr>
                            <td>{{ $item['last_name'] }}, {{ $item['first_name']}}</td>
                            <td>{{ date('M d, Y', strtotime($item['date'])) }}</td>
                            <td>{{ date('g:i A', strtotime($item['time'])) }}</td>
                            <td class="float-right">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target=".edit-dtr" data-id="{{ $item->id }}">Edit</button>
                                    <button type="button" class="btn btn-warning" id="delete-dtr" data-id="{{ $item->id }}">Delete</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="navigation col-6">
                    {{ $users->links("pagination::bootstrap-4") }}
                </div>
            </div>

        </div>
    </div>


    <!-- Modal [start] -->

    <!-- Add DTR [start] -->
    <div class="modal fade add-dtr" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add DTR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="create-dtr-form">
                        @csrf

                        <div class="form-group">

                            <div class="row">
                                <div class="col first-name-wrapper">
                                    <label for="first-name">First Name</label>
                                    <input type="text" class="form-control" name="first_name" id="first-name" placeholder="First name">
                                </div>
                                <div class="col last-name-wrapper">
                                    <label for="last-name">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" id="last-name" placeholder="Last name">
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="row">

                                <div class="col date-wrapper">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" name="date" id="date" value="{{ $raw_date }}">
                                </div>
                                <div class="col time-wrapper">
                                    <label for="time">Time</label>
                                    <input type="time" class="form-control" name="time" id="time" value="{{ $time }}">
                                </div>

                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary" id="btn-submit">Add</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!-- Add DTR [end] -->

    <!-- Edit DTR [start] -->
    <div class="modal fade edit-dtr" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit DTR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="edit-dtr-form">
                        @csrf

                        <div class="form-group">

                            <div class="row">
                                <div class="col edit-first-name-wrapper">
                                    <label for="edit-first-name">First Name</label>
                                    <input type="text" class="form-control" name="first_name" id="edit-first-name" placeholder="First name">
                                </div>
                                <div class="col edit-last-name-wrapper">
                                    <label for="edit-last-name">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" id="edit-last-name" placeholder="Last name">
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="row">

                                <div class="col edit-date-wrapper">
                                    <label for="edit-date">Date</label>
                                    <input type="date" class="form-control" name="date" id="edit-date">
                                </div>
                                <div class="col edit-time-wrapper">
                                    <label for="edit-time">Time</label>
                                    <input type="time" class="form-control" name="time" id="edit-time">
                                </div>

                            </div>

                        </div>

                        <button type="submit" class="btn btn-info" id="btn-update">Update</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!-- Edit DTR [end] -->

    <!-- Import DTR [start] -->
    <div class="modal fade import-dtr" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Import DTR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-dark" role="alert">
                        Download sample template <a href="{{ route('template.dtr') }}" class="btn btn-sm btn-secondary">Download Template</a>
                    </div>
                    <form id="excel-form" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">

                            <div class="col dtr-wrapper">
                                <label for="dtr">Import</label>
                                <input type="file" class="form-control-file " name="dtr" id="dtr">
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary" id="btn-import">Import</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!-- Import DTR [end] -->

    <!-- Modal [end] -->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>



    <script>
        $(document).ready(function() {



            var xhr = null;



            $('#create-dtr-form').submit(function(e) {

                e.preventDefault();

                var formData = new FormData(this);
                var frm_btn = '#btn-submit';

                xhr = $.ajax({
                    url: "{{ route('store.dtr') }}",
                    type: 'POST',
                    dataType: 'JSON',
                    data: formData,
                    processData: false,
                    contentType: false,

                    beforeSend: function() {

                        $(frm_btn).attr('disabled', 'disabled');
                        $(frm_btn).empty();
                        $(frm_btn).append('<span class="spinner-grow spinner-grow-sm" role="status"></span> Please wait.');
                        $('.err_msg_fn, .err_msg_ln, .err_msg_dt, .err_msg_tm').remove();

                        $('#first-name, #last-name, #date, #time').removeClass('is-invalid');
                        if (xhr != null) {
                            xhr.abort();
                        }

                    },

                    success: function(data) {

                        $(frm_btn).removeAttr('disabled');
                        $(frm_btn).empty();
                        $(frm_btn).text('Add');

                        $('#create-dtr-form')[0].reset();

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(function() {
                            $('.add-dtr').modal('toggle');
                        }, 1000);

                        $('.users-tbl').find('.table-primary').removeClass("table-primary");

                        let user_info = '<tr class="table-primary ">' +
                            '<td>' + data.last_name + ', ' + data.first_name + '</td>' +
                            '<td>' + data.date + '</td>' +
                            '<td>' + data.time + '</td>' +
                            '<td><div class="btn-group btn-group-sm float-right" role="group">' +
                            '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".edit-dtr" data-id="' + data.id + '">Edit</button>' +
                            '<button type="button" class="btn btn-warning" id="delete-dtr" data-id="' + data.id + '">Delete</button>' +
                            '</div></td>' +
                            '</tr>';

                        $('.users-tbl').prepend(user_info);

                        $('#first-name, #last-name, #date, #time').removeClass('is-invalid');
                    },

                    error: function(data) {
                        $(frm_btn).removeAttr('disabled');
                        $(frm_btn).empty();
                        $(frm_btn).text('Add');

                        error = data.responseJSON;

                        $.each(error.errors, function(k, v) {

                            // display the error message
                            if (k == 'first_name') {

                                let fn_msg = '<div class="invalid-feedback err_msg_fn">' + v + '</div>';
                                $('#first-name').addClass('is-invalid')
                                $('.first-name-wrapper').append(fn_msg);

                            } else if (k == 'last_name') {

                                let ln_msg = '<div class="invalid-feedback err_msg_ln">' + v + '</div>';
                                $('#last-name').addClass('is-invalid')
                                $('.last-name-wrapper').append(ln_msg);

                            } else if (k == 'date') {

                                let dt_msg = '<div class="invalid-feedback err_msg_dt">' + v + '</div>';
                                $('#date').addClass('is-invalid')
                                $('.date-wrapper').append(dt_msg);

                            } else if (k == 'time') {

                                let tm_msg = '<div class="invalid-feedback err_msg_tm">' + v + '</div>';
                                $('#time').addClass('is-invalid')
                                $('.time-wrapper').append(tm_msg);

                            } else {}

                        })

                    }


                });

            });



            $('#excel-form').off('submit').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var frm_btn = '#btn-import';

                xhr = $.ajax({

                    url: "{{ route('import.dtr') }}",
                    type: "POST",
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,


                    beforeSend: function() {

                        $(frm_btn).attr('disabled', 'disabled');
                        $(frm_btn).empty();
                        $(frm_btn).append('<span class="spinner-grow spinner-grow-sm" role="status"></span> Please wait.');
                        $('.err_msg_dtr').remove();




                        if (xhr != null) {
                            xhr.abort();
                        }

                    },


                    success: function(data) {
                        $(frm_btn).removeAttr('disabled');
                        $(frm_btn).empty();
                        $(frm_btn).text('Import');

                        let user_list = '';
                        $('.users-tbl').find('.table-primary').removeClass("table-primary");


                        $.each(data.users, function(k, v) {


                            user_list = '<tr class="table-primary ">' +
                                '<td>' + v.name + '</td>' +
                                '<td>' + v.date + '</td>' +
                                '<td>' + v.time + '</td>' +
                                '<td><div class="btn-group btn-group-sm float-right" role="group">' +
                                '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".edit-dtr" data-id="' + v.id + '">Edit</button>' +
                                '<button type="button" class="btn btn-warning" id="delete-dtr" data-id="' + v.id + '">Delete</button>' +
                                '</div></td>' +
                                '</tr>';

                            $('.users-tbl').prepend(user_list);

                        });


                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        });


                        setTimeout(function() {
                            $('#dtr').val('');
                            $('.import-dtr').modal('toggle');
                        }, 1000);



                    },


                    error: function(data) {
                        $(frm_btn).removeAttr('disabled');
                        $(frm_btn).empty();
                        $(frm_btn).text('Import');

                        error = data.responseJSON;

                        $.each(error.errors, function(k, v) {

                            if (k == 'dtr') {
                                let dtr_msg = '<div class="invalid-feedback err_msg_dtr">' + v + '</div>';
                                $('#dtr').addClass('is-invalid')
                                $('.dtr-wrapper').append(dtr_msg);
                            }

                        })


                    }


                });

            });



            $('.edit-dtr').off('show.bs.modal').on('show.bs.modal', function(e) {
                var trigger_btn = e.relatedTarget;
                var parent_tr = $(trigger_btn).closest('tr').get(0);

                let id = $(trigger_btn).data('id');

                let name = $(parent_tr).find("td:first").text().split(','),
                    dt = new Date($(parent_tr).find("td:nth-child(2)").text()),
                    time = getTwentyFourHourTime($(parent_tr).find("td:nth-child(3)").text()),
                    first = name[1],
                    last = name[0];

                var date = new Date(dt.getTime() - (dt.getTimezoneOffset() * 60000)).toISOString().split("T")[0];

                console.log(time);

                $('#edit-first-name').val(first);
                $('#edit-last-name').val(last);
                $('#edit-date').val(date);
                $('#edit-time').val(time);
                $('.err_msg_fn, .err_msg_ln, .err_msg_dt, .err_msg_tm').remove();
                $('#edit-first-name, #edit-last-name, #edit-date, #edit-time').removeClass('is-invalid');


                $('#edit-dtr-form').off('submit').on('submit', function(e) {

                    e.preventDefault();

                    var formData = new FormData(this);
                    var frm_btn = '#btn-update';

                    formData.append('id', id);

                    xhr = $.ajax({
                        url: "{{ route('update.dtr') }}",
                        type: 'POST',
                        dataType: 'JSON',
                        data: formData,
                        processData: false,
                        contentType: false,

                        beforeSend: function() {

                            $(frm_btn).attr('disabled', 'disabled');
                            $(frm_btn).empty();
                            $(frm_btn).append('<span class="spinner-grow spinner-grow-sm" role="status"></span> Please wait.');
                            $('.err_msg_fn, .err_msg_ln, .err_msg_dt, .err_msg_tm').remove();


                            if (xhr != null) {
                                xhr.abort();
                            }

                        },

                        success: function(data) {
                            $(frm_btn).removeAttr('disabled');
                            $(frm_btn).empty();
                            $(frm_btn).text('Update');

                            $(parent_tr).find("td:first").text(data.last_name + ', ' + data.first_name);
                            $(parent_tr).find("td:nth-child(2)").text(data.date);
                            $(parent_tr).find("td:nth-child(3)").text(data.time);

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Your work has been saved',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            setTimeout(function() {
                                $('.edit-dtr').modal('toggle');
                            }, 1000);



                        },

                        error: function(data) {
                            $(frm_btn).removeAttr('disabled');
                            $(frm_btn).empty();
                            $(frm_btn).text('Update');

                            error = data.responseJSON;

                            $.each(error.errors, function(k, v) {

                                // display the error message
                                if (k == 'first_name') {

                                    let fn_msg = '<div class="invalid-feedback err_msg_fn">' + v + '</div>';
                                    $('#edit-first-name').addClass('is-invalid')
                                    $('.edit-first-name-wrapper').append(fn_msg);

                                } else if (k == 'last_name') {

                                    let ln_msg = '<div class="invalid-feedback err_msg_ln">' + v + '</div>';
                                    $('#edit-last-name').addClass('is-invalid')
                                    $('.edit-last-name-wrapper').append(ln_msg);

                                } else if (k == 'date') {

                                    let dt_msg = '<div class="invalid-feedback err_msg_dt">' + v + '</div>';
                                    $('#edit-date').addClass('is-invalid')
                                    $('.edit-date-wrapper').append(dt_msg);

                                } else if (k == 'time') {

                                    let tm_msg = '<div class="invalid-feedback err_msg_tm">' + v + '</div>';
                                    $('#edit-time').addClass('is-invalid')
                                    $('.edit-time-wrapper').append(tm_msg);

                                } else {}

                            })

                        }

                    });


                })

            })



            $(document).off('click', '#delete-dtr').on('click', '#delete-dtr', function(e) {
                var trigger_btn = e.target;
                var parent_tr = $(trigger_btn).closest('tr').get(0);

                let id = $(this).data('id')
                name = $(parent_tr).find("td:first").text(),


                    Swal.fire({
                        title: 'Are you sure?',
                        html: 'Delete <b>' + name + '</b>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        showCancelButton: true,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {

                            Swal.fire({
                                title: 'Deleting',
                                type: 'info',
                                html: 'Please wait...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                }
                            });


                            $.ajax({
                                url: "{{ route('delete.dtr') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    id: id,
                                },
                                success: function(data) {
                                    parent_tr.remove();

                                    var btn = '<button class="btn btn-info" data-id="' + data + '" id="restore-delete">Undo Delete</button>'
                                    $('.action-btn').prepend(btn);

                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )

                                    $('#restore-delete').click(function(e) {
                                        let id = $(this).data('id');

                                        frm_btn = '#restore-delete';

                                        xhr = $.ajax({
                                            url: "{{ route('restore.dtr') }}",
                                            type: 'post',
                                            data: {
                                                _token: "{{ csrf_token() }}",
                                                id: id,
                                            },

                                            beforeSend: function() {

                                                $(frm_btn).attr('disabled', 'disabled');
                                                $(frm_btn).empty();
                                                $(frm_btn).append('<span class="spinner-grow spinner-grow-sm" role="status"></span> Please wait.');


                                                if (xhr != null) {
                                                    xhr.abort();
                                                }

                                            },

                                            success: function(data) {

                                                $(frm_btn).removeAttr('disabled');
                                                $(frm_btn).remove();

                                                $('.users-tbl').find('.table-primary').removeClass("table-primary");


                                                let restored = '<tr class="table-primary ">' +
                                                    '<td>' + data.name + '</td>' +
                                                    '<td>' + data.date + '</td>' +
                                                    '<td>' + data.time + '</td>' +
                                                    '<td><div class="btn-group btn-group-sm float-right" role="group">' +
                                                    '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".edit-dtr" data-id="' + data.id + '">Edit</button>' +
                                                    '<button type="button" class="btn btn-warning" id="delete-dtr" data-id="' + data.id + '">Delete</button>' +
                                                    '</div></td>' +
                                                    '</tr>';

                                                $('.users-tbl').prepend(restored);


                                            },

                                            error: function(data) {

                                                $(frm_btn).removeAttr('disabled');
                                                $(frm_btn).empty();
                                                $(frm_btn).text('Undo Delete');

                                            }

                                        })
                                    })

                                }

                            })

                        }
                    })
            })






            function getTwentyFourHourTime(amPmString) {

                var d = new Date("1/1/2020 " + amPmString);

                return ('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2);

            }



        })
    </script>
</body>

</html>