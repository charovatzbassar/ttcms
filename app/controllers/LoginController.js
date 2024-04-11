var LoginController = () => {
  $("#mainNav").hide();
  $("#layoutSidenav_nav").hide();

  $($("#loginForm")).validate({
    errorElement: "span",
    errorClass: "help-block help-block-error",
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
      },
    },

    messages: {
      email: {
        required: "Please enter an email",
        email: "Please enter a valid email",
      },
      password: {
        required: "Please enter a password",
      },
    },

    submitHandler: function (f, e) {
      e.preventDefault();
      Utils.block_ui("#loginForm .card-body");
      const formData = $(f).serialize();
      console.log(formData);
      Utils.unblock_ui("#loginForm .card-body");
    },
  });
};
