var Modal = (function($) {

    // TODO:
    // Exit by clicking anywhere else
    var _s = {
        modalTrigger: '.js-modalTrigger',
        closeModal: '.js-closeModal',
        overlayClose: '.int-modal__overlay'
    };

    var _init = function() {

        _bindEvents();
    };

    var _bindEvents = function() {
        $( _s.modalTrigger ).click(function(e) {
            e.stopPropagation();
            e.preventDefault();

            var obj = $( $(this).attr('href') );
            var vnoscroll = false;

            if($(this).attr('href') === '#signature-form') {
                vnoscroll = true;
            }

            if ( obj.length > 0 ) {
                _openModal(obj, vnoscroll);

                _escHandler(obj);
            }
        });

        $( _s.closeModal ).click(function(e) {
            e.stopPropagation();
            e.preventDefault();


            _closeModal( $(this).parents('.int-modal' ) );
        });

        $( _s.overlayClose ).click(function(e) {
            e.stopPropagation();
            e.preventDefault();


            _closeModal( $(this).parents('.int-modal' ) );
        });

    };

    var _openModal = function( obj, vnoscroll ) {
        $('body').append(obj);
        obj.css('display', 'block');

        setTimeout(function() {
            obj.addClass('is-open');
            $('body').addClass('modal-is-open');
        }, 100);

        if ( vnoscroll ) {
            var windowsize = $(window).width();
            console.log(windowsize);
            if (windowsize < 599) {
                $('body').addClass('v-noscroll');
            }    
        }
    };

    var _escHandler = function( target, isLightbox ) {
        isLightbox = isLightbox || false;
        $(document).on('keyup.modalListener', function(e) {
            if ( e.which == 27 ) {
                _closeModal( target, isLightbox );
            }
        });
    };

    var _closeModal = function( obj ) {

        var video = obj.find('.vidyard_iframe');

        obj.removeClass( 'is-open');

        video.attr('src', video.attr('src'));

        setTimeout(function() {
            obj.css('display', 'none');
            $('body').removeClass('v-noscroll').removeClass('modal-is-open');
        }, 300);

        $(document).off('keyup.modalListener');
    };

    return {
        init: _init
    };
})(jQuery);