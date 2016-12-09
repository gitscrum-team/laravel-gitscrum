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
            $('.agile h5').width($(this).width());
            $(this).css('border-top', '6px solid #'+$(this).data('color'));
            $(this).find('.small-issue-closed').hide();
            if($(this).data('closed')){
                $(this).find('.small-issue-closed').show();
            }
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
            stop: function() {
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
