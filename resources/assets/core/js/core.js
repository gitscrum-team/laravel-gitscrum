$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('[data-toggle="tooltip"]').tooltip();

    main.init();
    attachment.init();
    agile.init();

});

var main = {

    init: function(){
        main.modalRemoveData();
        main.modalSwal();
        main.activateTab();
        main.loading();
    },

    activateTab: function(){
        if (location.hash !== '') $('a[href="' + location.hash + '"]').tab('show');
        $('a[data-toggle="tab"]').on('shown', function(e) {
          return location.hash = $(e.target).attr('href').substr(1);
        });
    },

    modalRemoveData: function (){
        $('body').on('hidden.bs.modal', '.modal', function () {
          $(this).removeData('bs.modal');
        });
    },

    modalSwal: function(){

        $('.form-delete button').on('click', function (event) {

            event.preventDefault();
            var button = $(this);

            swal({
                title: "Are you sure about this?",
                text: "You will not be able to recover this information!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, proceed",
                cancelButtonText: "No, cancel it",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    button.closest("form").submit();
                }
            });

        });
    },

    loading: function(){
        var div = $("<div>", {"class": "loader"});
        $('.btn-loader').on('click', function(){
            $('.loader-area').append(div);
        });
    }

}
