var Validate = {
  validateApplyForm: () => {
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
        birthplace: {
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
        birthplace: {
          required: "Please enter your birthplace",
        },
      },

      submitHandler: function (f, e) {
        e.preventDefault();
        grecaptcha.ready(function () {
          grecaptcha
            .execute("6LfDPKspAAAAABrj0BsU6yudlW0Z_pFR3HhR0V_W", {
              action: "submit",
            })
            .then(function (token) {
              Utils.block_ui("#applyForm .card-body");
              const formData = $(f).serialize();
              $.ajax({
                url: `${API_BASE_URL}/registrations`,
                type: "POST",
                data: formData,
                success: function (data) {
                  console.log(data);
                  toastr.success("Application submitted successfully");
                },
                error: function (error) {
                  console.log(error);
                  toastr.error("An error occurred while submitting the application");
                },
              
              })
              Utils.unblock_ui("#applyForm .card-body");
              
            });
        });
      },
    });
  },
  validateAddTournamentForm: () => {
    $($("#addTournamentForm")).validate({
      errorElement: "span",
      errorClass: "help-block help-block-error",
      rules: {
        name: {
          required: true,
        },
        location: {
          required: true,
        },
        date: {
          required: true,
        },
        category: {
          required: true,
        },
      },

      messages: {
        name: {
          required: "Please enter a name",
        },
        date: {
          required: "Please enter a date date",
        },

        location: {
          required: "Please enter a location",
        },
        category: {
          required: "Please select at least one category",
        },
      },

      submitHandler: function (f, e) {
        e.preventDefault();
        Utils.block_ui("#addTournamentModal .modal-content");
        const formData = $(f).serialize().split("&");

        const tournament = {
          name: formData[0].split("=")[1],
          date: formData[1].split("=")[1],
          location: formData[2].split("=")[1],
          categories: formData
            .slice(3)
            .map((category) => category.split("=")[1]),
          status: "UPCOMING",
        };

        $.ajax({
          url: `${API_BASE_URL}/tournaments`,
          type: "POST",
          data: JSON.stringify(tournament),
          contentType: "application/json",
          success: function (data) {
            console.log(data);
            toastr.success("Tournament added successfully");
          },
          error: function (error) {
            console.log(error);
            toastr.error("An error occurred while adding the tournament");
          },
        });
        Utils.unblock_ui("#addTournamentModal .modal-content");
        $("#addTournamentModal").modal("hide");

      },
    });
  },
  validateAddResultForm: () => {
    $($("#addResultForm")).validate({
      errorElement: "span",
      errorClass: "help-block help-block-error",
      rules: {
        member: {
          required: true,
        },
        opponent: {
          required: true,
        },
        result: {
          required: true,
        },
      },

      messages: {
        member: {
          required: "Please select a member",
        },
        opponent: {
          required: "Please select an opponent",
        },
        result: {
          required: "Please select a result",
        },
      },

      submitHandler: function (f, e) {
        e.preventDefault();
        Utils.block_ui("#addResultModal .modal-content");
        const formData = $(f).serialize();
        $.ajax({
          url: `${API_BASE_URL}/results`,
          type: "POST",
          data: formData,
          success: function (data) {
            console.log(data);
            toastr.success("Result added successfully");
          },
          error: function (error) {
            console.log(error);
            toastr.error("An error occurred while adding the result");
          },
        });
        Utils.unblock_ui("#addResultModal .modal-content");
        $("#addResultModal").modal("hide");
      },
    });
  },
  validateUpdateTournamentForm: (id) => {
    $($("#updateTournamentForm")).validate({
      errorElement: "span",
      errorClass: "help-block help-block-error",
      rules: {
        name: {
          required: true,
        },
        location: {
          required: true,
        },
        date: {
          required: true,
        },
        category: {
          required: true,
        },
      },

      messages: {
        name: {
          required: "Please enter a name",
        },
        date: {
          required: "Please enter a date date",
        },

        location: {
          required: "Please enter a location",
        },
        category: {
          required: "Please select at least one category",
        },
      },

      submitHandler: function (f, e) {
        e.preventDefault();
        Utils.block_ui("#updateTournamentModal .modal-content");
        const formData = $(f).serialize().split("&");

        const tournament = {
          name: formData[0].split("=")[1],
          date: formData[1].split("=")[1],
          location: formData[2].split("=")[1],
          categories: formData
            .slice(3)
            .map((category) => category.split("=")[1]),
        };

        

        $.ajax({
          url: `${API_BASE_URL}/results/${id}?_method=PUT`,
          type: "POST",
          data: tournament,
          success: function (data) {
            console.log(data);
            toastr.success("Tournament updated successfully");
          },
          error: function (error) {
            console.log(error);
            toastr.error("An error occurred while updating the tournament");
          },
        });
        Utils.unblock_ui("#updateTournamentModal .modal-content");
        $("#updateTournamentModal").modal("hide");
      },
    });
  },
  validateRegisterForm: () => {
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
        clubName: {
          required: true,
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
        clubName: {
          required: "Please enter a club name",
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
        grecaptcha.ready(function () {
          grecaptcha
            .execute("6LfDPKspAAAAABrj0BsU6yudlW0Z_pFR3HhR0V_W", {
              action: "submit",
            })
            .then(function (token) {
              Utils.block_ui("#registerForm .card-body");
              const formData = $(f).serialize();
              
              $.ajax({
                url: `${API_BASE_URL}/auth/register`,
                type: "POST",
                data: formData,
                success: function (data) {
                  console.log(data);
                  window.location.href = "/#dashboard";
                },
                error: function (error) {
                  console.log(error);
                  toastr.error("An error occurred while registering");

                },
              });

              Utils.unblock_ui("#registerForm .card-body");
            });
        });
      },
    });
  },
  validateUpdateMemberForm: (id) => {
    $($("#updatePlayerForm")).validate({
      errorElement: "span",
      errorClass: "help-block help-block-error",
      rules: {
        firstName: {
          required: true,
        },
        lastName: {
          required: true,
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
        dateOfBirth: {
          required: "Please enter a date of birth",
        },
        gender: {
          required: "Please select gender",
        },
      },

      submitHandler: function (f, e) {
        e.preventDefault();
        Utils.block_ui("#updatePlayerModal .modal-content");
        const formData = $(f).serialize();
        $.ajax({
          url: `${API_BASE_URL}/members/${id}`,
          type: "POST",
          data: formData,
          success: function (data) {
            console.log(data);
            toastr.success("Member updated successfully");
          },
          error: function (error) {
            console.log(error);
            toastr.error("An error occured when updating member.")
          },
        });
        Utils.unblock_ui("#updatePlayerModal .modal-content");
        $("#updatePlayerModal").modal("hide");
      },
    });
  },
  validateLoginForm: () => {
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
        grecaptcha.ready(function () {
          grecaptcha
            .execute("6LfDPKspAAAAABrj0BsU6yudlW0Z_pFR3HhR0V_W", {
              action: "submit",
            })
            .then(function (token) {
              Utils.block_ui("#loginForm .card-body");
              const formData = $(f).serialize();
              $.ajax({
                url: `${API_BASE_URL}/auth/login`,
                type: "POST",
                data: formData,
                success: function (data) {
                  console.log(data);
                  window.location.href = "/#dashboard"
                },
                error: function (error) {
                  console.log(error);
                  toastr.error("An error occured when logging in.")
                },
              });
              Utils.unblock_ui("#loginForm .card-body");
            });
        });
      },
    });
  },
};
