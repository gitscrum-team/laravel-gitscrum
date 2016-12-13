var agile = {

    init:function(){

        if( $(".agile-list").length )
        {
            agile.columns();
            agile.update();
            agile.scroll();
        }

    },

    scroll: function(){
        $('.agile-list').height( $( window ).height()-290 );
        $('.kanban-board-scroll').width( $('.agile').length*385 );
        $('body').css('overflow-y','hidden');
    },

    columns: function(){
        $.each($('.agile-list'), function(){
            $(this).closest('.agile').find('h5').css('border-bottom', '6px solid #'+$(this).data('color'));
            $(this).find('.small-issue-closed').hide();
            if($(this).data('closed')){
                $(this).find('.small-issue-closed').show();
            }
        });
    },

    update: function(){

        $(".agile-column").sortable({
            connectWith: ".connectColumn",
            tolerance: "pointer",
            placeholder: "ui-state-highlight-column",
            forcePlaceholderSize: true,
            handle: ".handle",
            stop: function() {
                var position=[];
                $.each($('.agile-column .agile'), function(k,v){
                    position.push($(v).data('value'));
                });
                $.post( $(this).data('endpoint'), { columns:position });
            }
        }).disableSelection();

        $(".agile-list").sortable({
            connectWith: ".connectList",
            tolerance: 'intersect',
            placeholder: "ui-state-highlight-list",
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
                agile.scroll();
            }
        }).disableSelection();
    }

}
