/* jshint esversion: 6, browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, document */

// Import dependencies
import lazySizes from 'lazysizes';
import smoothscroll from 'smoothscroll-polyfill';
import 'jquery-ui';

// Import style
import '../styl/site.styl';

class Site {
  constructor() {
    this.mobileThreshold = 720;
    this.scrollOffset = 120;

    this.handleNavTrigger = this.handleNavTrigger.bind(this);
    this.handleDragStart = this.handleDragStart.bind(this);
    this.handleDragStop = this.handleDragStop.bind(this);
    this.handleSectionClose = this.handleSectionClose.bind(this);
    this.positionCustomCursor = this.positionCustomCursor.bind(this);
    this.toggleCursorColor = this.toggleCursorColor.bind(this);
    this.toggleCursorVisibility = this.toggleCursorVisibility.bind(this);
    this.handleOverlayClick = this.handleOverlayClick.bind(this);
    this.triggerHair = this.triggerHair.bind(this);
    this.runHair = this.runHair.bind(this);

    this.$cursor = $('#cursor');

    this.hairRate = 100;
    this.increaseFrame = true;
    this.firstFrame = 1;
    this.lastFrame = 5;
    this.hairFrame = this.firstFrame;

    $(window).resize(this.onResize.bind(this));

    $(document).ready(this.onReady.bind(this));

  }

  onResize() {
    if ($(window).width() < this.mobileThreshold) {
      this.disableDragging(true);
    } else {
      this.disableDragging(false);
    }
  }

  onReady() {
    lazySizes.init();

    smoothscroll.polyfill();

    this.bindNavTriggers();
    this.bindSectionClose();
    this.initDragging();
    this.bindCustomCursor();
    this.bindOverlayClick();
  }

  fixWidows() {
    // utility class mainly for use on headines to avoid widows [single words on a new line]
    $('.js-fix-widows').each(function(){
      var string = $(this).html();
      string = string.replace(/ ([^ ]*)$/,'&nbsp;$1');
      $(this).html(string);
    });
  }

  bindNavTriggers() {
    $('.js-nav-trigger').on('click', this.handleNavTrigger);
  }

  handleNavTrigger(event) {
    const sectionId = $(event.target).attr('data-id');
    const $section = $('.content-overlay#' + sectionId);

    if ($(window).width() < this.mobileThreshold) {
      this.handleScrollTo($section);
    } else {
      this.handleSectionOpen(event.target, $section);
    }
  }

  handleScrollTo($section) {
    window.scroll({
      top: $section.offset().top - this.scrollOffset,
      behavior: 'smooth'
    });
  }

  handleSectionOpen(target, $section) {
    if ($section.hasClass('show')) {
      this.handleSectionClose();
    } else {
      $('.content-overlay.show').removeClass('show');
      $('.nav-item.active').removeClass('active');
      $section.addClass('show');
      $(target).addClass('active');
      $('body').addClass('overlay-active');
    }
  }

  bindSectionClose() {
    $('.section-close').on('click', this.handleSectionClose);
  }

  handleSectionClose() {
    $('.content-overlay.show').removeClass('show');
    $('.nav-item.active').removeClass('active');
    $('body').removeClass('overlay-active');
  }

  initDragging() {
    $('.image-container').draggable({
      stack: '.image-container',
      start: this.handleDragStart,
      stop: this.handleDragStop
    });

    if ($(window).width() < this.mobileThreshold) {
      this.disableDragging(true);
    }
  }

  handleDragStart(event, ui) {
    $('.image-active').removeClass('image-active');
    $(ui.helper).addClass('image-active');
  }

  handleDragStop(event, ui) {
    $(ui.helper).removeClass('image-active');
  }

  disableDragging(disable) {
    $( ".image-container" ).draggable({
      disabled: disable
    });

    if (disable) {
      $( ".image-container" ).css({
        top: 'auto',
        left: 'auto',
      });
    }
  }

  bindCustomCursor() {
    this.cursorHeight = this.$cursor.height();
    this.cursorWidth = this.$cursor.width();

    $(document).on({
      'mousemove': this.positionCustomCursor,
      'mousedown': this.toggleCursorColor,
      'mouseup': this.toggleCursorColor,
    });

    $('a, .nav-item, .section-close').on({
      'mouseenter': this.toggleCursorVisibility,
      'mouseleave': this.toggleCursorVisibility
    });

    this.triggerHair();
  }

  positionCustomCursor(event) {
    const mouseY = event.clientY - (this.cursorHeight / 2);
    const mouseX = event.clientX - (this.cursorWidth / 2);

    this.$cursor.css({
      top: mouseY + 'px',
      left: mouseX + 'px'
    });
  }

  toggleCursorColor(event) {
    if (event.which === 3) { return; } // Right-click
    this.$cursor.toggleClass('down');
  }

  toggleCursorVisibility() {
    console.log('hide');
    this.$cursor.toggleClass('hide');
  }

  bindOverlayClick() {
    $('.section-content-holder').on('click', this.handleOverlayClick);
  }

  handleOverlayClick(event) {
    if (!$(event.target).hasClass('section-content-holder')) { return; }
    this.handleSectionClose();
  }

  // HAIR ANIMATION
  triggerHair() {
    this.hairTimeout = setTimeout(this.runHair, this.hairRate);
  }

  runHair() {
    this.hairRequest = window.requestAnimationFrame(this.triggerHair);
    this.moveHair();
  }

  moveHair() {
    this.$cursor.find('g#frame-' + this.hairFrame).removeClass('show');

    this.hairFrame = this.increaseFrame ? this.hairFrame + 1 : this.hairFrame - 1;

    this.$cursor.find('g#frame-' + this.hairFrame).addClass('show');

    if (this.hairFrame === this.lastFrame) {
      this.increaseFrame = false;
    } else if (this.hairFrame === this.firstFrame) {
      this.increaseFrame = true;
    }
  }
}

new Site();
