$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if ($('[data-toggle="switch"]').length) {
      $('[data-toggle="switch"]').bootstrapSwitch();
    }

    $('[data-toggle="tooltip"]').tooltip(); 

    main.init();
    attachment.init();
    agile.init();

});

var main = {

    init: function(){
        main.modalRemoveData();
        main.modalSwal();
    },

    modalRemoveData: function (){
        $('body').on('hidden.bs.modal', '.modal', function () {
          $(this).removeData('bs.modal');
        });
    },

    modalSwal: function(){

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
    },

}

var agile = {

    columnHeight: 0,

    init:function(){

        if( $(".agile-list").length )
        {
            agile.columns();
            agile.update();
        }

    },

    columns: function(){
        $('.agile-list').removeAttr("style");
        $.each($('.agile-list'), function(){
            $('.agile h5').width($(this).width()+30);
            if(agile.columnHeight<$(this).height())
            {
                agile.columnHeight = $(this).height();
            }
        });
        $('.agile-list').height(agile.columnHeight);
    },

    update: function(){
        $(".agile-list").sortable({
            connectWith: ".connectList",
            placeholder: "ui-state-highlight",
            start: function(e, ui){
                ui.placeholder.height(ui.item.height());
            },
            stop: function( event, ui ) {
                $.each($('.agile-list'), function(k,v){
                    $(v).closest('.agile').find('h5').find('span').text($(v).find('li').length);
                    if($(v).sortable( "toArray" ).length)
                    {
                        $.post( $(v).data('endpoint'), { status_id: $(v).data('value'), json: window.JSON.stringify($(v).sortable( "toArray" )) });
                    }
                });
                agile.columns();
            }
        }).disableSelection();
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
