$(document).ready(function () {
    $(".delete-record").click(function () {
        var url = '';
        var thisClick = $(this);
        swal({
                title: "Are you sure to delete ?",
                text: "You will not be able to recover this imaginary file !!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it !!",
                closeOnConfirm: false
            },
            function(e){
                swal.close();
                if(e){
                    $.ajax({
                        type:'POST',
                        url:thisClick.data('url'),
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data:{id:thisClick.data('id')},
                        success:function(data){
                            if(data.status == 1){
                                $("#tr-"+thisClick.data('id')).remove();
                                toastr.success(data.message,{
                                    timeOut: 5000,
                                    "closeButton": true,
                                    "debug": false,
                                    "newestOnTop": true,
                                    "progressBar": true,
                                    "positionClass": "toast-top-right",
                                    "preventDuplicates": true,
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut",
                                    "tapToDismiss": false

                                })
                            }
                            if(data.status == 0){
                                toastr.error(data.message,{
                                    "positionClass": "toast-top-right",
                                    timeOut: 5000,
                                    "closeButton": true,
                                    "debug": false,
                                    "newestOnTop": true,
                                    "progressBar": true,
                                    "preventDuplicates": true,
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut",
                                    "tapToDismiss": false

                                })
                            }
                        },
                        error: function (data, textStatus, errorThrown) {

                        }
                    });
                }
            });
    })
})