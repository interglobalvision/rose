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
    this.handleImageClick = this.handleImageClick.bind(this);
    this.handleSectionClose = this.handleSectionClose.bind(this);
    this.positionCustomCursor = this.positionCustomCursor.bind(this);
    this.toggleCursorColor = this.toggleCursorColor.bind(this);
    this.toggleCursorVisibility = this.toggleCursorVisibility.bind(this);

    this.$cursor = $('#cursor');

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
    this.bindImageClick();
    this.bindCustomCursor();
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
    });

    if ($(window).width() < this.mobileThreshold) {
      this.disableDragging(true);
    }
  }

  handleDragStart(event, ui) {
    $('.image-active').removeClass('image-active');
    $(ui.helper).addClass('image-active');
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

  bindImageClick() {
    $('.image-container').on('click', this.handleImageClick);
  }

  handleImageClick(event) {
    const $image = $(event.target).hasClass('image-container') ? $(event.target) : $(event.target).closest('.image-container');
    $('.image-active').removeClass('image-active');
    $image.addClass('image-active');
  }

  bindCustomCursor() {
    this.cursorHeight = this.$cursor.height();
    this.cursorWidth = this.$cursor.width();

    $(document).on({
      'mousemove': this.positionCustomCursor,
      'mousedown': this.toggleCursorColor,
      'mouseup': this.toggleCursorColor,
    });

    /*document.addEventListener('mousemove', this.positionCustomCursor);
    document.addEventListener('mousedown', this.toggleCursorColor);
    document.addEventListener('mouseup', this.toggleCursorColor);*/

    $('a, .nav-item, .section-close').on({
      'mouseenter': this.toggleCursorVisibility,
      'mouseleave': this.toggleCursorVisibility
    });
  }

  positionCustomCursor(event) {
    const mouseY = event.clientY - (this.cursorHeight / 2);
    const mouseX = event.clientX - (this.cursorWidth / 2);

    console.log(mouseY, mouseX);

    this.$cursor.css({
      top: mouseY + 'px',
      left: mouseX + 'px'
    });
  }

  toggleCursorColor() {
    this.$cursor.toggleClass('down');
  }

  toggleCursorVisibility() {
    this.$cursor.toggleClass('hide');
  }
}

new Site();
