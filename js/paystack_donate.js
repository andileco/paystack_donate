/**
 * @file The integration with Paystack Donate.
 */
(function (Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.payWithPaystack = {
    attach: function (context, settings) {

      let donate_button = document.getElementById('paystack_donate_form_button');
      donate_button.addEventListener("click", donateClick);

      function donateClick(event) {
        let s = this;
        setTimeout(function () {
          s.value = "Please wait...";
          s.disabled = true;
        }, 0.3);
        event.preventDefault();
        payWithPaystack();
      }

      function payWithPaystack() {
        let get_email = document.getElementById('paystack_donate_email');
        let the_email = get_email.value;

        let get_amount = document.getElementById('paystack_donate_amount');
        let the_amount = get_amount.value * 100;

        let handler = PaystackPop.setup({
          key: drupalSettings.paystack_key,
          email: the_email,
          amount: the_amount,
          //ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a
          // pseudo-unique reference. Please replace with a reference you
          // generated. Or remove the line entirely so our API will generate one
          // for you

          callback: function (response) {
            alert(drupalSettings.success_message);
            window.location.replace(window.location.origin);
          },
          onClose: function () {
            //alert('window closed');
          }
        });
        handler.openIframe();
      }
    }
  };

})(Drupal, drupalSettings);
