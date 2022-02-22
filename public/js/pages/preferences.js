$(function () {
  $('#link-update-username').on('click', function () {
    $('#update-username').toggleClass("d-none");
    $('#form-update-username').toggleClass("d-none");
  });

  $('#cancel-update-username').on('click', function () {
    $('#update-username').toggleClass("d-none");
    $('#form-update-username').toggleClass("d-none");
  });

  $('#link-update-email').on('click', function () {
    $('#update-email').toggleClass("d-none");
    $('#form-update-email').toggleClass("d-none");
  });

  $('#cancel-update-email').on('click', function () {
    $('#update-email').toggleClass("d-none");
    $('#form-update-email').toggleClass("d-none");
  });

  $('#link-update-password').on('click', function () {
    $('#update-password').toggleClass("d-none");
    $('#form-update-password').toggleClass("d-none");
  });

  $('#cancel-update-password').on('click', function () {
    $('#update-password').toggleClass("d-none");
    $('#form-update-password').toggleClass("d-none");
  });

  $('#link-close-account').on('click', function () {
    $('#close-account').toggleClass("d-none");
    $('#form-close-account').toggleClass("d-none");
  });

  $('#cancel-close-account').on('click', function () {
    $('#close-account').toggleClass("d-none");
    $('#form-close-account').toggleClass("d-none");
  });
});