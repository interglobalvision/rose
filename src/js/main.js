/* jshint esversion: 6, browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, document */

// Import dependencies
import lazySizes from 'lazysizes';
import 'jquery-ui';

// Import style
import '../styl/site.styl';

class Site {
  constructor() {
    this.mobileThreshold = 601;

    this.handleNavTrigger = this.handleNavTrigger.bind(this);
    this.handleDragStart = this.handleDragStart.bind(this);
    this.handleImageClick = this.handleImageClick.bind(this);
    this.handleSectionClose = this.handleSectionClose.bind(this);

    $(window).resize(this.onResize.bind(this));

    $(document).ready(this.onReady.bind(this));

  }

  onResize() {
    if ($(window).width() < 720) {
      this.disableDragging(true);
    } else {
      this.disableDragging(false);
    }
  }

  onReady() {
    lazySizes.init();

    this.bindNavTriggers();
    this.bindSectionClose();
    this.initDragging();
    this.bindImageClick();
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
    const $navItem = $(event.target);
    const sectionId = $navItem.attr('data-id');
    const $section = $('.content-overlay#' + sectionId);

    if ($section.hasClass('show')) {
      this.handleSectionClose();
    } else {
      $('.content-overlay.show').removeClass('show');
      $('.nav-item.active').removeClass('active');
      $section.addClass('show');
      $navItem.addClass('active');
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

    if ($(window).width() < 720) {
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
}

new Site();
