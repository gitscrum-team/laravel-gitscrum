var attachment = {

    init:function() {

        $('.btn-file-attachment').on('change', function(){
            $("#file-attachment").html($(this).val());
            $("#btn-file-attachment-upload").removeClass("hidden");
        })

    }

};
