/* jshint esversion: 6, browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, document */

// Import dependencies
import lazySizes from 'lazysizes';

// Import style
import '../styl/site.styl';

class Site {
  constructor() {
    this.mobileThreshold = 601;

    this.handleNavTrigger = this.handleNavTrigger.bind(this);

    $(window).resize(this.onResize.bind(this));

    $(document).ready(this.onReady.bind(this));

  }

  onResize() {

  }

  onReady() {
    lazySizes.init();

    this.bindNavTriggers();
    this.bindSectionClose();
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

    if ($section.hasClass('show')) {
      $section.removeClass('show');
    } else {
      $('.content-overlay.show').removeClass('show');
      $section.addClass('show');
    }
  }

  bindSectionClose() {
    $('.section-close').on('click', function(){
      $('.content-overlay.show').removeClass('show');
    });
  }
}

new Site();
