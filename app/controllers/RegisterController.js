var RegisterController = () => {
  $("#mainNav").hide();
  $("#layoutSidenav_nav").hide();

  $($("#registerForm")).validate({
    errorElement: "span",
    errorClass: "help-block help-block-error",
    rules: {
      firstName: {
        required: true,
      },
      lastName: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
      },
      confirmPassword: {
        required: true,
        equalTo: "#password",
      },
    },

    messages: {
      firstName: {
        required: "Please enter a first name",
      },
      lastName: {
        required: "Please enter a last name",
      },
      email: {
        required: "Please enter an email",
        email: "Please enter a valid email",
      },
      password: {
        required: "Please enter a password",
      },
      confirmPassword: {
        required: "Please confirm your password",
        equalTo: "Passwords do not match",
      },
    },

    submitHandler: function (f, e) {
      e.preventDefault();
      Utils.block_ui("#registerForm .card-body");
      const formData = $(f).serialize();
      console.log(formData);
      Utils.unblock_ui("#registerForm .card-body");
    },
  });
};
