$(function() {

	// Nav Menu toggle //
	$('.menu-toggle').on('click', function(e) {
		if ( $(window).width() < 991 ) {
			e.preventDefault();
			$('.navbar').toggleClass("open");
			$('.menu-toggle').toggleClass("open");
		}
	});

	// Sub Menu toggle mobile //
	$('.menu-item-has-children > a').on('click', function(e) {
		e.preventDefault();
		$(this).parent().toggleClass("open");
	});

	// Modal Init
	if ( $('.js-ModalTrigger' ) ) {
		Modal.init();
	}

	// Dropdown toggle //
	$('.accordion-content').hide();
	$('.accordion-header').on('click', function(e) {
		e.preventDefault();
		$(this).toggleClass("open");
		$(this).next('.accordion-content').slideToggle();
	});

	// Flexible sidebar toggle //
	if ( $(window).width() < 767 ) {
		$('.flex-content__sidebar__title-mobile').on('click', function(e) {
			e.preventDefault();
			$(this).toggleClass("open");
			$(this).next('.flex-content__sidebar__links').slideToggle();
		});
		$('.flex-content__sidebar__links a').on('click', function(e) {
			var text = $(this).html();
			$('.flex-content__sidebar__title-mobile').html(text).removeClass("open");
			$('.flex-content__sidebar__links').slideUp();
		});
	}

	// Quotes Carousel //
	var quotesCarousel = $('.quotes-carousel .owl-carousel');
	quotesCarousel.owlCarousel({
		items: 1,
		loop: true,
		autoplay: true,
		smartSpeed: 650,
		nav: true,
		dots: false,
		autoHeight: false,
		onInitialized: quotesController,
		onChanged: quotesController,
		navText: ['<i class="fa fa-arrow-left"></i>','<i class="fa fa-arrow-right"></i>']
	});

	function quotesController(event) {
		if (!event.namespace) {
			return;
		}
		var slides = event.relatedTarget;
		var progressNumber = $('.progress-bar__number');
		var progressBarPercentage = $('.progress-bar__percentage');
		var totalSlides = slides.items().length;
		var currentSlide = slides.relative(slides.current()) + 1;

		progressNumber.text(currentSlide + ' / ' + totalSlides );
		progressBarPercentage.removeClass('is-animating'); 

		setTimeout(function(){ 
			progressBarPercentage.addClass('is-animating'); 
		}, 0);
	}


	// Smooth Scroll Anchor Scroll //
	$('a[href*="#"]').on('click', function(e) {
		e.preventDefault()

		$('html, body').animate({
			scrollTop: $($(this).attr('href')).offset().top,
		}, 500, 'linear')
	});

	// Make sidebar sticky //
	if ($('.has-flexible-sidebar').length > 0) {
		var sidebarContainer = $('.flex-content__sidebar').offset().top;

		$(window).scroll(function() {
			if ( $(window).width() > 768 ) {
				var windowTop = $(window).scrollTop() + (sidebarContainer/2);
				var footerOffset = $(document).height() - $('.footer-flex-content').height() - $('.flex-content__sidebar').height() - 100;

				if (sidebarContainer < windowTop) {
					$('.flex-content__sidebar').addClass('sticky');
				} else {
					$('.flex-content__sidebar').removeClass('sticky');
				}

				if(footerOffset < windowTop) {
					$('.flex-content__sidebar').hide();
				} else {
					$('.flex-content__sidebar').show();
				}
			}
		});

		// Cache selectors //
		var lastId,
			topMenu = $('.flex-content__sidebar__links'),
			topMenuHeight = topMenu.outerHeight()-15,
			// All list items
			menuItems = topMenu.find('a'),
			// Anchors corresponding to menu items
			scrollItems = menuItems.map(function(){
			  var item = $($(this).attr('href'));
			  if (item.length) { return item; }
			});

		// Bind to scroll //
		$(window).scroll(function(){
		   // Get container scroll position //
		   var fromTop = $(this).scrollTop()+topMenuHeight;
		   
		   // Get id of current scroll item //
		   var cur = scrollItems.map(function(){
			 if ($(this).offset().top < fromTop)
			   return this;
		   });
		   // Get the id of the current element //
		   cur = cur[cur.length-1];
		   var id = cur && cur.length ? cur[0].id : "";
		   
		   if (lastId !== id) {
			   lastId = id;
			   // Set/remove active class //
			   menuItems
				 .parent().removeClass("active")
				 .end().filter("[href='#"+id+"']").parent().addClass("active");
		   }                   
		});
	}

});	