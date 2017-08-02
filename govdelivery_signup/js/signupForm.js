(function ($) {


Drupal.behaviors.govDeliverySignup = {
  'attach': function() {
    $('form#govdelivery-signup .button.form-submit:not(.gdsf-processed)')
    .addClass('gdsf-processed')
    .click(function(event) {
      if ($('form#govdelivery-signup #edit-email').val() !== '') {
        var email = $('form#govdelivery-signup #edit-email').val();
        var url = drupalSettings.govDeliverySignup.url + 'email=' + encodeURIComponent(email);
        console.log(url);
        window.open(url, '_blank');
        event.stopPropagation();
      }
    });
  },
};

})(jQuery);
