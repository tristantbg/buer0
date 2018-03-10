/* globals $:false */
var width = $(window).width(),
  height = $(window).height(),
  isMobile = false,
  target,
  lastTarget = false,
  slider,
  players = [],
  $mouseNav,
  $root = '';
$(function() {
  var app = {
    init: function() {
      console.log('Code by Tristan Bagot', 'www.tristanbagot.com');
      $(window).on('resize', function(event) {
        app.sizeSet();
      });
      $(document).ready(function($) {
        $body = $('body');
        $container = $('#container');
        app.sizeSet();
        app.interact();
        // app.smoothState('#main', $container);
        // window.viewportUnitsBuggyfill.init();
        $(document).keyup(function(e) {
          //esc
          if (e.keyCode === 27) app.goBack();
        });
        document.addEventListener('lazybeforeunveil', function(e) {
          $(e.target).parents(".post")[0].classList.add("loaded");
        });
      });
    },
    sizeSet: function() {
      width = $(window).width();
      height = $(window).height();
      $('[data-ratio]').each(function(index, el) {
        ratio = el.getAttribute("data-ratio");
        w = el.querySelector(".post").clientWidth;
        h = w / ratio;
        $(this).find(".post, .flickity-prev-next-button.touch").height(h);
      // padding = el.getAttribute("data-padding");
      // padding = parseFloat(padding, 10); 
      // console.log(padding);
      // if (padding && padding > 0) el.style.padding = "0 " + padding * width + "px";
      });
      if (width < 768)
        isMobile = true;
      if (isMobile) {
        if (width >= 768) {
          //location.reload();
          isMobile = false;
        }
      }
    },
    interact: function() {
      app.plyr();
      app.loadSlider();
      app.texts();
      $(".flickity-prev-next-button").mousemove(function(event) {
        if (!Modernizr.touchevents) {
          var svg = this.querySelector("svg");
          var parentOffset = $(this).offset();
          svg.style.display = "block";
          svg.style.top = event.pageY - parentOffset.top + "px";
          svg.style.left = event.pageX - parentOffset.left + "px";
        }
      });
      setTimeout(function() {
        document.getElementById('loader').style.display = 'none';
      }, 200);
    },
    texts: function() {

      var eventNameTransitionEnd = 'transitionend',
        collapsingCss = "collapsing",
        expandingCss = "expanding",
        collapsedCss = "collapsed";

      function collapse(component, content) {

        component.classList.remove("active");

        function transitionEnd(event) {
          if (event.propertyName === 'height') {
            if (component.classList.contains(collapsingCss)) {
              component.classList.remove(collapsingCss);
              component.classList.add(collapsedCss);
            }

            content.removeEventListener(eventNameTransitionEnd, transitionEnd, false);
          }
        }

        content.style.height = 'auto';
        var BCR = content.getBoundingClientRect(),
          height = BCR.height;

        content.style.height = height + 'px';

        content.addEventListener(eventNameTransitionEnd, transitionEnd, false);

        content.offsetHeight; // reflow to apply transition animation

        content.style.height = '0px';
        content.classList.remove('opened');
      }

      function expand(component, content) {

        /* 
         reflow to apply transition animation
         the content had display:none which made content transform micro-animation not working
         */
        content.offsetHeight;

        component.classList.add("active");

        function transitionEnd(event) {
          if (event.propertyName === 'height') {

            if (component.classList.contains(expandingCss)) {
              component.classList.remove(expandingCss);
              component.classList.add(expandedCss);

              content.style.height = '';
            }

            content.removeEventListener(eventNameTransitionEnd, transitionEnd, false);
          }
        }

        content.style.height = 'auto';

        var BCR = content.getBoundingClientRect();

        content.style.height = '0px';

        content.addEventListener(eventNameTransitionEnd, transitionEnd, false);

        content.offsetHeight; // reflow to apply transition animation

        content.style.height = BCR.height + 'px';
        content.classList.add('opened');
      }
      var headerLinks = document.querySelectorAll('#menu a[data-target]');
      var texts = document.querySelectorAll('#texts .text');
      for (var i = 0; i <= headerLinks.length; i++) {
        var elm = headerLinks[i];
        if (elm) {
          elm.addEventListener('click', function(e) {
            e.preventDefault();
            var current = document.querySelector('#menu [data-target].active');
            if (current && current != e.target) {
              var currentText = document.querySelector('#texts [data-target="' + current.getAttribute('data-target') + '"]');
              collapse(current, currentText);
            }
            var target = e.target.getAttribute('data-target');
            for (var x = 0; x <= texts.length; x++) {
              var tx = texts[x];
              if (tx && tx.getAttribute('data-target') === target) {
                if (tx.classList.contains('opened')) {
                  collapse(e.target, tx);
                } else {
                  expand(e.target, tx);
                }
              }
            }
          });
        }
      }
    },
    plyr: function(loop) {
      var vids = document.querySelectorAll('.post [data-media="video"] video');
      if (vids.length > 0) {
        var hls = [];
        for (var i = vids.length - 1; i >= 0; i--) {
          vids[i].controls = false;
          if (!isMobile && vids[i].getAttribute("data-stream") && Hls.isSupported()) {
            hls[i] = new Hls({
              minAutoBitrate: 1700000
            });
            hls[i].loadSource(vids[i].getAttribute("data-stream"));
            hls[i].attachMedia(vids[i]);
          }
        }
      }
      players = plyr.setup('.js-player', {
        loop: false,
        autoplay: false,
        controls: ['play-large'],
        iconUrl: $root + "/assets/css/plyr/plyr.svg"
      });
      for (var j = vids.length - 1; j >= 0; j--) {
          $("<img class='lazy lazyload video-poster' data-src='"+vids[j].getAttribute('poster')+"'>").insertAfter(vids[j]);
          // if (vids[j].getAttribute("data-stream"))
          //   vids[j].setAttribute('poster', '');
        }
    // for (var i = players.length - 1; i >= 0; i--) {
    //   players[i].on('play', function(event) {
    //     slider.element.classList.remove('play')
    //     slider.element.classList.add('pause');
    //   });
    //   players[i].on('pause', function(event) {
    //     slider.element.classList.remove('pause')
    //     slider.element.classList.add('play');
    //   });
    //   players[i].on('waiting', function(event) {
    //     slider.element.classList.add('loading');
    //   });
    //   players[i].on('canplay', function(event) {
    //     slider.element.classList.remove('loading');
    //   });
    //   players[i].on('ready', function(event) {
    //     $(".plyr__controls").hover(function() {
    //       $mouseNav.css('visibility', 'hidden');
    //     }, function() {
    //       $mouseNav.css('visibility', 'visible');
    //     });
    //   });
    // }
    },
    loadSlider: function() {
      var flickitys = [];
      var elements = document.querySelectorAll('.post');
      if (elements.length > 0) {
        for (var i = 0; i < elements.length; i++) {
          initFlickity(elements[i]);
        }
      }
      function initFlickity(element) {
        var slider = new Flickity(element, {
          cellSelector: '.scene',
          imagesLoaded: true,
          lazyLoad: false,
          setGallerySize: false,
          percentPosition: false,
          accessibility: true,
          wrapAround: true,
          prevNextButtons: !Modernizr.touchevents,
          pageDots: false,
          draggable: Modernizr.touchevents,
          dragThreshold: 30
        });
        slider.slidesCount = slider.slides.length;
        if (slider.slidesCount < 1) return; // Stop if no slides
        slider.element.setAttribute("data-media", slider.selectedElement.getAttribute("data-media"));
        slider.on('select', function() {
          // $('#slide-number').html((slider.selectedIndex + 1) + '/' + slider.slidesCount);
          if (this.selectedElement) {
            this.element.setAttribute("data-media", this.selectedElement.getAttribute("data-media"));
            this.element.parentNode.querySelector(".additional-caption").innerHTML = this.selectedElement.getAttribute("data-caption");
          }
          var adjCellElems = this.getAdjacentCellElements(1);
          $(adjCellElems).find('.lazy:not(".lazyloaded")').addClass('lazyload');
        });
        slider.on('staticClick', function(event, pointer, cellElement, cellIndex) {
          if (!cellElement || cellElement.getAttribute('data-media') == "video" && !slider.element.classList.contains('nav-hover')) {
            return;
          } else {
            this.next();
          }
        });
        if (slider.selectedElement) {
          slider.element.parentNode.querySelector(".additional-caption").innerHTML = slider.selectedElement.getAttribute("data-caption");
          slider.element.parentNode.querySelector(".flickity-prev-next-button.touch.next").addEventListener('click', function() {
            slider.next();
          });
          slider.element.parentNode.querySelector(".flickity-prev-next-button.touch.previous").addEventListener('click', function() {
            slider.previous();
          });
        }
        if (players.length > 0) {
          slider.on('select', function() {
            var isSameIndex = slider.currentIndex == this.selectedIndex;
            $.each(players, function() {
              if(!isSameIndex) this.pause();
            });
            this.element.classList.remove('play', 'pause');
            var svgs = this.element.querySelectorAll(".flickity-prev-next-button svg");
            for (var i = 0; i < svgs.length; i++) {
              svgs[i].style.display = "none";
            }
            slider.currentIndex = this.selectedIndex;
          });
        // if (slider.selectedElement.getAttribute("data-media") == "video") {
        //   if (typeof hls !== "undefined" && typeof hls[0] !== "undefined") {
        //     hls[0].on(Hls.Events.MANIFEST_PARSED, function() {
        //       // vids[0].play();
        //     });
        //   } else {
        //     // vids[0].play();
        //   }
        // }
        }
        if (slider.slidesCount < 2) {
          slider.element.style.cursor = 'auto';
          var prevNext = slider.element.parentNode.querySelectorAll(".flickity-prev-next-button.touch");
          for (var i = 0; i < prevNext.length; i++) {
            prevNext[i].style.display = 'none';
          }
        }
      }
    },
    goIndex: function() {},
    goBack: function() {
      if (window.history && history.length > 0 && !$body.hasClass('projects')) {
        window.history.go(-1);
      } else {
        $('#site-title a').click();
      }
    },
    smoothState: function(container, $target) {
      var options = {
          debug: true,
          scroll: false,
          anchors: '[data-target]',
          loadingClass: 'is-loading',
          prefetch: true,
          cacheLength: 4,
          onAction: function($currentTarget, $container) {
            lastTarget = target;
            target = $currentTarget.data('target');
            if (target === "back") app.goBack();
          // console.log(lastTarget);
          },
          onBefore: function(request, $container) {
            popstate = request.url.replace(/\/$/, '').replace(window.location.origin + $root, '');
          // console.log(popstate);
          },
          onStart: {
            duration: 0, // Duration of our animation
            render: function($container) {
              $body.addClass('is-loading');
            }
          },
          onReady: {
            duration: 0,
            render: function($container, $newContent) {
              // Inject the new content
              $(window).scrollTop(0);
              $container.html($newContent);
            }
          },
          onAfter: function($container, $newContent) {
            app.interact();
            setTimeout(function() {
              $body.removeClass('is-loading');
            // Clear cache for random content
            // smoothState.clear();
            }, 200);
          }
        },
        smoothState = $(container).smoothState(options).data('smoothState');
    }
  };
  app.init();
});