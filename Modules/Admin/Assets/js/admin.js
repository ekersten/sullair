(function( window, $ ) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
    });
})(window, jQuery);
