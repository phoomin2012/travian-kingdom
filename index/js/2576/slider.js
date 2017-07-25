var sliderConstructor = function (opts) {
    var isRtl = document.dir == 'rtl';
    var mobile = false; //todo MOBILE FLAG

    var self = this;

    if (!opts.el || opts.el.length == 0) {
        throw "Cannot create slider on not existing element";
    }
    self.slider = $(".slider", opts.el);

    if (!self.slider || self.slider.length == 0) {
        throw "Cannot create slider on not existing element";
        return null;
    }
    self.slideSpeed = 1400;
    self.slideSpeedFast = 400;
    self.timeOut = 2500;
    self.needArrows = true;
    self.needControls = true;
    self.pause = false;
    self.leftArrow = $('.left-arrow-wrapper-small');
    self.rightArrow = $('.right-arrow-wrapper-small');
    self.slideNum = 0;
    self.needLightsOff = opts.lightsOff == undefined ? true : opts.lightsOff;
    self.sliderId = opts.sliderId;

    function resizeLineHeight() {
        if (!mobile) {
            self.slider.css({lineHeight: self.slider.height() + "px"})
        }
    }

    $(window).on('resize', resizeLineHeight);
    resizeLineHeight();
    self.slide = self.slider.find('.slide');
    self.appendElem = $(".slide-control", opts.el);
    self.coords = opts.coords || [];
    self.slideCount = self.slide.length;


    self.text = $('.description-wrap');
    $(document).on("pageScrolled", function (e, a) {

        if(!self.pause && a==opts.startOnPage){
        	self.fliper();
        }else{
            clearTimeout(self.slideTime);
        }
    });

    self.pauseAnimation = function () {
        clearTimeout(self.slideTime);
    	self.pause=true;
    };

    self.resumeAnimation = function () {
        clearTimeout(self.slideTime);
    	self.pause=false;
    	self.fliper();
    };

    self.renderControls = function (appendEl) {
        if (self.needControls) {
            appendEl.find("span.slide-btn").remove();
            for (var i = 0; i < self.slide.length; i++) {
                var $linkBtns;
                if (self.coords.length > 0) {
                    $linkBtns = $('<span class="slide-btn" style="left:' + self.coords[i] + '%">' + i + '</span>'); // todo LEFT!!!!!!!
                } else {
                    $linkBtns = $('<span class="slide-btn">' + i + '</span>');
                }
                appendEl.append($linkBtns);
            }
        }
    };
    self.renderSlider = function () {

        self.slide.hide().eq(0).show();
    };

    self.slider.find('.slide').swipe({
        swipeLeft: function (event, direction, distance, fingerCount, fingerData) {
        	self.animSlide("next", "fast");
            clearTimeout(self.slideTime);
            self.pause = true;
        },
        swipeRight: function (event, direction, distance, fingerCount, fingerData) {
        	self.animSlide("prew", "fast");
            clearTimeout(self.slideTime);
            self.pause = true;
        },

        swipeDown : function() {


        },

        swipeUp : function () {

        },

        tap : function(event,target) {
        	event.stopPropagation();
        	if (T5Lightbox.opened) {
        		return;
        	}
        	var slide = $(target).parent();
        	if (!$(slide).attr('full-image')) {
        		return;
        	}

        	var slides = $(slide).parent().find('.slide');
        	self.pauseAnimation();
        	T5Lightbox.show(slides, slide);

        },


        threshold:5
    });

    self.appendArrows = function () {
        if (self.needArrows) {
            self.rightArrow.click(function (e) {
                e.stopPropagation();
                self.animSlide(isRtl ? "prew" : "next", "fast");
                clearTimeout(self.slideTime);
                self.pause = true;
                return false;
            });
            self.leftArrow.click(function (e) {
                e.stopPropagation();
                self.animSlide(isRtl ? "next" : "prew", "fast");
                clearTimeout(self.slideTime);
                self.pause = true;
                return false;
            })
        }
    };


    self.fliper = function () {
        if (!self.pause) {
            clearTimeout(self.slideTime);
            self.slideTime = setTimeout(function () {
                self.animSlide('next')
            }, self.timeOut);
        }
    };

    self.animSlide = function (slide, speed) {

        var sp = (speed || speed == "fast") ? self.slideSpeedFast : self.slideSpeed;


        self.slide.eq(self.slideNum).fadeOut(sp);
        opts.onHideCB && opts.onHideCB(self.slideNum, sp);
        if (slide == "next") {
            if (self.slideNum == (self.slideCount - 1)) {
                self.slideNum = 0;
            }
            else {
                self.slideNum++;
            }
        }
        else if (slide == "prew") {
            if (self.slideNum == 0) {
                self.slideNum = self.slideCount - 1;
            }
            else {
                self.slideNum -= 1;
            }
        }
        else {
            self.slideNum = slide;
        }

        self.slide.eq(self.slideNum).fadeIn(sp, self.fliper);
        opts.onShowCb && opts.onShowCb(self.slideNum, sp);
        self.slider.parent().find("span.slide-btn.active").removeClass("active");
        self.slider.parent().find('span.slide-btn').eq(self.slideNum).addClass('active');
    };
    self.renderSlider();
    if (self.needControls) {
        self.renderControls(self.appendElem);
    }
    if (self.needArrows) {
        self.appendArrows();
    }
    self.control = self.slider.parent().find("span.slide-btn");
    self.control.eq(0).addClass("active");
    self.control.click(function () {
        var goToNum = parseFloat($(this).text());
        clearTimeout(self.slideTime);
        self.pause = true;
        self.animSlide(goToNum, "fast");
    });
    self.destroy = function () {
        self.slideTime && clearTimeout(self.slideTime);
        self.slideNum = 0;
        self.pause = true;
        sliderInstance = null;
    };

    return self;
};



var T5Lightbox = {

	opened:false,
	slides : null,
	init : false,
	currentSlideIdx : 0,
	windowWidth:0,
	windowHeight:0,

	showSlide : function (slide, move) {
        var isRtl = document.dir == 'rtl';
		this.opened=true;
		var img = new Image();
		img.onload = function () {
			var imgWidth = img.width;
			var imgHeight = img.height;

			for (var newWidth=T5Lightbox.windowWidth-20; newWidth > 0; --newWidth) {

				var newHeight = Math.floor(newWidth * imgHeight / imgWidth);
				if (newHeight < T5Lightbox.windowHeight-20 ) {
					break;
				}
			}

			if (move) {
				$('#lightbox .image2').css('opacity',0).css('display','').html('<img src="' + slide.attr('full-image' ) + '" style="width:' + newWidth + 'px" />');
			} else {

				$('#lightbox .image').html('<img src="' + slide.attr('full-image' ) + '" style="width:' + newWidth + 'px" />');

			}

			$('#lightbox').css('left',(T5Lightbox.windowWidth-newWidth)/2)
				.css('top',(T5Lightbox.windowHeight-newHeight)/2).css('display','');
			if (T5Lightbox.windowWidth < 800) {
				$('#lightbox .left-arrow-wrapper-small').css('display','none');
				$('#lightbox .right-arrow-wrapper-small').css('display','none');
			} else {
				$('#lightbox .left-arrow-wrapper-small').css('top', (newHeight-58)/2+10).css('left',20).css('z-index',2000);
				$('#lightbox .right-arrow-wrapper-small').css('top', (newHeight-58)/2+10).css('left',newWidth+10-40-20).css('z-index',2000);
			}


			if (T5Lightbox.windowWidth - newWidth > 80) {
				$('#lightbox .close').css('left', isRtl ? -50 : newWidth+20);
			} else {
				$('#lightbox .close').css('left', isRtl ? -10 : newWidth-40).css('top',-50);
			}

			if (move) {
				$('#lightbox .image2').animate({opacity:1},600, function() {
					$('#lightbox .image').html($('#lightbox .image2').html());
					$(this).css('display','none');
				});

			}

		};

		img.src = slide.attr('full-image');

	},

	close : function () {

		$('#shadow,#lightbox').css('display','none');
		this.opened=false;
		enable_scroll();

	},

	prev: function () {
		this.currentSlideIdx--;
		if (this.currentSlideIdx < 0) {
			this.currentSlideIdx = this.slides.length-1;
		}

		var slide = $(T5Lightbox.slides[T5Lightbox.currentSlideIdx]);
		T5Lightbox.showSlide(slide, true);
		if (slide.hasClass('screenshots')) {
			screenshotsSlider.animSlide('prew', 'fast');
		}
		if (slide.hasClass('artworks')) {
			artworksSlider.animSlide('prew', 'fast');
		}

	},

	next: function () {
		this.currentSlideIdx++;
		if (this.currentSlideIdx > this.slides.length-1) {
			this.currentSlideIdx = 0;
		}

		var slide = $(T5Lightbox.slides[T5Lightbox.currentSlideIdx]);
		T5Lightbox.showSlide(slide, true);
		if (slide.hasClass('screenshots')) {
			screenshotsSlider.animSlide('next', 'fast');
		}
		if (slide.hasClass('artworks')) {
			artworksSlider.animSlide('next', 'fast');
		}


	},

	show : function(slides, slide) {
		disable_scroll();
        var isRtl = document.dir == "rtl";

		this.slides = slides;
		this.windowWidth = $(window).width();
		this.windowHeight = $(window).height();
		$('#shadow').css('width', this.windowWidth).css('height', this.windowHeight).css('opacity',0.8).css('display','');
		this.showSlide(slide,false);
		this.currentSlideIdx = slide.attr('slide-idx');

		if (!this.init) {

			$('#lightbox .left-arrow-wrapper-small').click(function() {
                T5Lightbox[isRtl ? 'next' : 'prev']();
            });
			$('#lightbox .right-arrow-wrapper-small').click(function() {
                T5Lightbox[isRtl ? 'prev' : 'next']()
            });

			$('#lightbox').swipe ({
				swipeLeft: function () {
					T5Lightbox[isRtl ? 'prev' : 'next']();
				},
				swipeRight: function () {
					T5Lightbox[isRtl ? 'next' : 'prev']();
				}, threshold: 5
			});
		}

		this.init=true;

	}
};
