var ApplyController = () => {
  $("#mainNav").hide();
  $("#layoutSidenav_nav").hide();

  $($("#applyForm")).validate({
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
      dateOfBirth: {
        required: true,
      },
      gender: {
        required: true,
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
      dateOfBirth: {
        required: "Please enter a date of birth",
      },
      gender: {
        required: "Please select gender",
      },
    },

    submitHandler: function (f, e) {
      grecaptcha.ready(function () {
        grecaptcha
          .execute("6LfDPKspAAAAABrj0BsU6yudlW0Z_pFR3HhR0V_W", {
            action: "submit",
          })
          .then(function (token) {
            e.preventDefault();
            Utils.block_ui("#applyForm .card-body");
            const formData = $(f).serialize();
            console.log(formData);
            Utils.unblock_ui("#applyForm .card-body");
          });
      });
    },
  });
};
