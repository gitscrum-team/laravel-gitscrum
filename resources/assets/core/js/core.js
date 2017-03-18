$(function () {

    $('[data-toggle="modal"]').on('click', function(event) {
        event.preventDefault();

        $('.ui.modal.default-modal')
            .modal('setting', 'transition', 'horizontal flip')
            .modal('show');
    });


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.menu .item').tab();
    $('.progress').progress();
/*
    $('[data-provide="markdown"]').markdown({autofocus:false,savable:false})

    main.init();
    attachment.init();
    agile.init();
    */

});














$(document)
    .ready(function() {

        $('.ui.search')
            .search({
                type          : 'category',
                minCharacters : 3,
                apiSettings   : {
                    onResponse: function(githubResponse) {
                        var
                            response = {
                                results : {}
                            }
                            ;
                        // translate GitHub API response to work with search
                        $.each(githubResponse.items, function(index, item) {
                            var
                                language   = item.language || 'Unknown',
                                maxResults = 8
                                ;
                            if(index >= maxResults) {
                                return false;
                            }
                            // create new language category
                            if(response.results[language] === undefined) {
                                response.results[language] = {
                                    name    : language,
                                    results : []
                                };
                            }
                            // add result to category
                            response.results[language].results.push({
                                title       : item.name,
                                description : item.description,
                                url         : item.html_url
                            });
                        });
                        return response;
                    },
                    url: 'http://api.github.com/search/repositories?q={query}'
                }
            });

        $('.ui.menu .ui.dropdown').dropdown({
            on: 'hover'
        });
        $('.ui.menu a.item')
            .on('click', function() {
                $(this)
                    .addClass('active')
                    .siblings()
                    .removeClass('active')
                ;
            })
        ;


        $('.open__sidebar_notes').on('click', function(){
            $('.ui.sidebar')
                .sidebar('toggle');
        });


    })
;






















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
