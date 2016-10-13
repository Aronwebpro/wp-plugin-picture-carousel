jQuery(document).ready(function($) {
    var sortList = $('ul#custom-type-list');
    var animation = $('#loading-animation');
    var pageTitle = $('#name-title');
    sortList.sortable({
        update: function(event, ui) {
            animation.show();

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action:'save_carousel_order',
                    order: sortList.sortable( 'toArray' ),
                    security: WP_HOME_SLIDER.security
                },
                success: function( response ) {
                    $('#message').remove();
                    animation.hide();
                    if(true === response.success) {
                        pageTitle.after('<div id="message"  class="update-ajax below-h2"><p>'+ WP_HOME_SLIDER.success +'</p></div>');

                    } else {
                        pageTitle.after('<div id="message" class="error-ajax below-h2"><p>'+ WP_HOME_SLIDER.failure +'</p></div>');
                    }

                },
                error: function( error ) {
                    $('#message').remove();
                    animation.hide();
                }

            });
        }
    });
});
