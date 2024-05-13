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
        club: {
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
        club: {
          required: "Please select a club",
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

              const registration = {
                firstName: formData.split("&")[0].split("=")[1],
                lastName: formData.split("&")[1].split("=")[1],
                email: formData.split("&")[2].split("=")[1].replace("%40", "@"),
                dateOfBirth: formData.split("&")[3].split("=")[1],
                birthplace: formData
                  .split("&")[4]
                  .split("=")[1]
                  .split("%20")
                  .join(" "),
                gender: formData.split("&")[5].split("=")[1],
                registrationStatus: "PENDING",
                appUserID: formData.split("&")[6].split("=")[1],
              };

              RegistrationsService.addRegistration(registration)
                .then(() => {
                  toastr.success("Application submitted");
                  $("#applyForm")[0].reset();
                })
                .catch(() => {
                  toastr.error("Error submitting application");
                });
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
          tournamentName: formData[0].split("=")[1].split("%20").join(" "),
          tournamentDate: formData[2].split("=")[1],
          tournamentLocation: formData[1].split("=")[1].split("%20").join(" "),
          categories: formData
            .slice(3)
            .map((category) => category.split("=")[1]),
          tournamentStatus: "UPCOMING",
        };

        TournamentsService.addTournament(tournament)
          .then(() => {
            toastr.success("Tournament added");
          })
          .catch(() => {
            toastr.error("Error adding tournament");
          });
        Utils.unblock_ui("#addTournamentModal .modal-content");
        $("#addTournamentModal").modal("hide");
        TournamentsService.getTournamentsTable();
      },
    });
  },
  validateAddResultForm: (tournamentID) => {
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

        const resultData = {
          clubMemberID: formData.split("&")[0].split("=")[1],
          opponentFirstName: formData.split("&")[1].split("=")[1],
          opponentLastName: formData.split("&")[2].split("=")[1],
          resultStatus: formData.split("&")[3].split("=")[1],
          tournamentID,
        };

        ResultsService.addResult(resultData)
          .then(() => {
            toastr.success("Result added");
          })
          .catch(() => {
            toastr.error("Error adding result");
          });
        Utils.unblock_ui("#addResultModal .modal-content");
        $("#addResultModal").modal("hide");
        ResultsService.getTournamentInfoTable(tournamentID);
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
          tournamentName: formData[0].split("=")[1].split("%20").join(" "),
          tournamentDate: formData[2].split("=")[1],
          tournamentLocation: formData[1].split("=")[1],
          categories: formData
            .slice(3)
            .map((category) => category.split("=")[1]),
        };

        TournamentsService.editTournament(id, tournament)
          .then(() => {
            window.location.hash = "tournaments";
            toastr.success("Tournament updated");
          })
          .catch(() => {
            toastr.error("Error updating tournament");
          });
        Utils.unblock_ui("#updateTournamentModal .modal-content");
        $("#updateTournamentModal").modal("hide");
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
        MemberService.editMember(id, formData)
          .then(() => {
            Utils.block_ui("#playerProfileTable");
            window.location.hash = "members";
            toastr.success("Member updated");
          })
          .catch(() => {
            toastr.error("Error updating member");
          });
        Utils.unblock_ui("#updatePlayerModal .modal-content");
        $("#updatePlayerModal").modal("hide");
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

              const registerData = {
                firstName: formData
                  .split("&")[0]
                  .split("=")[1]
                  .split("%20")
                  .join(" "),
                lastName: formData
                  .split("&")[1]
                  .split("=")[1]
                  .split("%20")
                  .join(" "),
                email: formData.split("&")[3].split("=")[1].replace("%40", "@"),
                clubName: formData
                  .split("&")[2]
                  .split("=")[1]
                  .split("%20")
                  .join(" "),
                password: formData.split("&")[4].split("=")[1],
                repeatedPassword: formData.split("&")[5].split("=")[1],
              };

              UserService.register(registerData);

              Utils.unblock_ui("#registerForm .card-body");
            });
        });
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
              UserService.login(formData);
              Utils.unblock_ui("#loginForm .card-body");
            });
        });
      },
    });
  },
};
