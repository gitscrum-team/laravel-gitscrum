$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    attachment.init();
    agile.init();

    $('.form-delete .btn-submit-form').on('click', function (event) {

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

    $('body').on('hidden.bs.modal', '.modal', function () {
      $(this).removeData('bs.modal');
    });

});

var agile = {

    init:function(){
        if( $(".agile-list").length )
        {
            $(".agile-list").sortable({
                connectWith: ".connectList",
                placeholder: "ui-state-highlight",
                start: function(e, ui){
                    ui.placeholder.height(ui.item.height());
                },
                stop: function( event, ui ) {

                    $.each($('.agile-list'), function(k,v){
                        if($(v).sortable( "toArray" ).length)
                        {

                            $.post( $(v).data('endpoint'), { status_id: $(v).data('value'), json: window.JSON.stringify($(v).sortable( "toArray" )) });

                        }
                    });

                }
            }).disableSelection();
        }
    }

}

var attachment = {

    init:function() {

        $('.btn-file-attachment').on('change', function(){
            $("#file-attachment").html($(this).val());
            $("#btn-file-attachment-upload").removeClass("hidden");
        })

    }

};
