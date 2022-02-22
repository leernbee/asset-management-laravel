/*
 *  Document   : op_auth_signup.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Sign Up Page
 */

class pageAuthSignUp {
  /*
   * Init Sign Up Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
   *
   */
  static initValidation() {
    // Load default options for jQuery Validation plugin
    One.helpers('validation');

    // Init Form Validation
    jQuery('.js-validation-register').validate({
      rules: {
        'signup-terms': {
          required: true
        }
      },
      messages: {
        'signup-terms': 'You must agree to the service terms!'
      }
    });
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initValidation();
  }
}

// Initialize when page loads
jQuery(() => { pageAuthSignUp.init(); });
