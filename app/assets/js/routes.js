$(document).ready(() => {
  const app = $.spapp({
    templateDir: "./views/",
  });

  // Dashboard route
  app.route({
    view: "dashboard",
    load: "dashboard.html",

    onReady: () => {
      $("#mainNav").show();
      $("#layoutSidenav_nav").show();
      $.get("assets/data/players.json").done((data) => {
        let members = "";

        data.map((member) => {
          members += `<tr>
                <td>${member.name}</td>
                <td>${member.membershipStatus}</td>
            </tr>`;
        });

        $("#dashboardTable > tbody").html(members);
        $("#dashboardTable").DataTable({
          columns: [{ data: "name" }, { data: "membership-status" }],
        });
      });
    },
  });

  // Members route
  app.route({
    view: "members",
    load: "members.html",

    onReady: () => {
      $("#mainNav").show();
      $("#layoutSidenav_nav").show();
      $.get("assets/data/players.json").done((data) => {
        let members = "";

        data.map((member) => {
          members += `<tr>
                <td><a href="?id=${member.playerID}#player-profile" class="text-black">${member.name} ${member.surname}</a></td>
                <td>${member.dateOfBirth}</td>
                <td>${member.gender}</td>
                <td>${member.birthplace}</td>
                <td>${member.category}</td>
                <td>${member.membershipStatus}</td>
            </tr>`;
        });

        $("#membersTable > tbody").html(members);

        $("#membersTable").DataTable({
          columns: [
            { data: "name" },
            { data: "date-of-birth" },
            { data: "gender" },
            { data: "birthplace" },
            { data: "category" },
            { data: "membership-status" },
          ],
        });
      });
    },
  });

  // Tournaments route
  app.route({
    view: "tournaments",
    load: "tournaments.html",

    onReady: () => {
      $("#mainNav").show();
      $("#layoutSidenav_nav").show();

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

          console.log(tournament);
          Utils.unblock_ui("#addTournamentModal .modal-content");
        },
      });

      $("#addTournamentButton").click(() => {
        $("#addTournamentModal").modal("show");
      });

      $("#closeModalButton").click(() => {
        $("#addTournamentModal").modal("hide");
      });

      $.get("assets/data/tournaments.json").done((data) => {
        let tournaments = "";

        data.map((tournament) => {
          tournaments += `<tr>
                <td><a href="?id=${
                  tournament.tournamentID
                }#tournament-info" class="text-black">${
            tournament.name
          }</a></td>
                <td>${tournament.date}</td>
                <td>${tournament.categories.join(", ")}</td>
                <td>${tournament.location}</td>
                <td>${tournament.status}</td>
            </tr>`;
        });

        $("#tournamentsTable > tbody").html(tournaments);

        $("#tournamentsTable").DataTable({
          columns: [
            { data: "name" },
            { data: "date" },
            { data: "categories" },
            { data: "location" },
            { data: "status" },
          ],
        });
      });
    },
  });

  // Player Stats route
  app.route({
    view: "player-stats",
    load: "player-stats.html",

    onReady: () => {
      $("#mainNav").show();
      $("#layoutSidenav_nav").show();
      $.get("assets/data/players.json").done((data) => {
        let members = "";

        data.map((member) => {
          members += `<tr>
                <td>${member.name} ${member.surname}</td>
                <td>${member.category}</td>
                <td>${member.score}</td>
            </tr>`;
        });

        $("#playerStatsTable > tbody").html(members);
        $("#playerStatsTable").DataTable({
          columns: [{ data: "name" }, { data: "category" }, { data: "score" }],
        });
      });
    },
  });

  // Registrations route
  app.route({
    view: "registrations",
    load: "registrations.html",

    onReady: () => {
      window.handleAccept = (id) => {
        console.log(id);
        toastr.success("Registration accepted");
      };

      window.handleReject = (id) => {
        console.log(id);
        toastr.error("Registration rejected");
      };

      $("#mainNav").show();
      $("#layoutSidenav_nav").show();
      $.get("assets/data/registrations.json").done((data) => {
        let registrations = "";

        data.map((registration) => {
          if (registration.status === "PENDING") {
            registrations += `<tr>
                <td>${registration.firstName} ${registration.lastName}</td>
                <td>${registration.email}</td>
                <td>${registration.dateOfBirth}</td>
                <td>${registration.gender}</td>
                <td>${registration.birthplace}</td>
                <td><div class="d-flex justify-content-around">
                <button class="btn btn-success w-50" onclick="handleAccept('${registration.registrationID}')">Accept</button
                ><button class="btn btn-danger w-50" onclick="handleReject('${registration.registrationID}')">Reject</button>
              </div></td>
            </tr>`;
          }
        });

        $("#registrationsTable > tbody").html(registrations);

        $("#registrationsTable").DataTable({
          columns: [
            { data: "name" },
            { data: "email" },
            { data: "date-of-birth" },
            { data: "gender" },
            { data: "birthplace" },
            { data: "actions" },
          ],
        });
      });
    },
  });

  // Tournament Info route
  app.route({
    view: "tournament-info",
    load: "tournament-info.html",

    onReady: () => {
      $("#mainNav").show();
      $("#layoutSidenav_nav").show();

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
          console.log(formData);
          Utils.unblock_ui("#addResultModal .modal-content");
        },
      });

      $("#updateResultForm").submit(function (e) {
        e.preventDefault();
        Utils.block_ui("#updateResultModal .modal-content");
        const formData = $(this).serialize();
        console.log(formData);
        Utils.unblock_ui("#updateResultModal .modal-content");
      });

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

          console.log(tournament);
          Utils.unblock_ui("#updateTournamentModal .modal-content");
        },
      });

      const urlParams = new URLSearchParams(window.location.search);
      const id = urlParams.get("id");

      $.get("assets/data/tournaments.json").done((data) => {
        const tournament = data.find((t) => t.tournamentID === id);

        $("#tournamentName").html(tournament.name);
        $("#tournamentDate").html("Date: " + tournament.date);
        $("#tournamentLocation").html("Location: " + tournament.location);
        $("#tournamentCategories").html(
          "Categories: " + tournament.categories.join(", ")
        );

        $("#updateTournamentButton").click(() => {
          $("#updateTournamentModal").modal("show");
        });

        $("#closeUpdateTournamentModalButton").click(() => {
          $("#updateTournamentModal").modal("hide");
        });

        $("#closeUpdateResultModalButton").click(() => {
          $("#updateResultModal").modal("hide");
        });

        $("[name='name']").val(tournament.name);
        $("[name='date']").val(tournament.date);
        $("[name='location']").val(tournament.location);

        for (let i = 0; i < tournament.categories.length; i++) {
          $(
            `[name='category'][value='${tournament.categories[
              i
            ].toUpperCase()}']`
          ).prop("checked", true);
        }
      });

      $.get("assets/data/results.json").done((data) => {
        let results = "";

        window.handleEditResult = (member, opponent, status) => {
          console.log(member, opponent, status);
          $("#updateResultModal").modal("show");
          $("[name='member']").val(member);
          $("[name='opponent']").val(opponent);
          $("[name='result']").val(status.toUpperCase());
        };

        window.handleRemoveResult = (resultID) => {
          console.log(resultID);
          $("#removeResultModal").modal("show");
        };

        data.map((result) => {
          results += `<tr>
                <td>${result.member}</td>
                <td>${result.opponent}</td>
                <td>${result.status}</td>
                <td><button class="btn btn-warning w-50" id="${result.resultID}" onclick="handleEditResult('${result.member}', '${result.opponent}', '${result.status}')">Edit</button><button class="btn btn-danger w-50" onclick="handleRemoveResult('${result.resultID}')">Remove</button></td>
            </tr>`;
        });

        $("#tournamentInfoTable > tbody").html(results);

        $("#tournamentInfoTable").DataTable({
          columns: [
            { data: "member" },
            { data: "opponent" },
            { data: "result" },
            { data: "actions" },
          ],
        });
      });

      $("#addResultButton").click(() => {
        $("#addResultModal").modal("show");
      });

      $.get("assets/data/players.json").done((data) => {
        let players = "";

        data.map((player) => {
          players += `<option value="${player.playerID}">${player.name} ${player.surname}</option>`;
        });

        $("select[name='member']").html(players);
      });

      $("#closeAddResultModalButton").click(() => {
        $("#addResultModal").modal("hide");
      });

      $("#closeUpdateResultModalButton").click(() => {
        $("#updateResultModal").modal("hide");
      });

      $("#closeRemoveResultModalButton").click(() => {
        $("#removeResultModal").modal("hide");
      });

      $("#closeRemoveTournamentModalButton").click(() => {
        $("#removeTournamentModal").modal("hide");
      });

      $("#removeTournamentButton").click(() => {
        $("#removeTournamentModal").modal("show");
      });

      $("#markAsCompletedButton").click(() => {
        toastr.success("Tournament marked as completed");
      });
    },
  });

  // Player Profile route
  app.route({
    view: "player-profile",
    load: "player-profile.html",

    onReady: () => {
      $("#mainNav").show();
      $("#layoutSidenav_nav").show();

      $("#markAsPaid").click(() => {
        toastr.success("Player marked as paid");
      });

      $("#removePlayerButton").click(() => {
        $("#removePlayerModal").modal("show");
      });

      $("#closeRemovePlayerModalButton").click(() => {
        $("#removePlayerModal").modal("hide");
      });

      const urlParams = new URLSearchParams(window.location.search);
      const id = urlParams.get("id");

      $.get("assets/data/players.json").done((data) => {
        const player = data.find((p) => p.playerID === id);

        $("#playerName").html(player.name + " " + player.surname);
        $("#playerTournamentScore").html("Tournament Score: " + player.score);
        $("#playerJoinDate").html("Joined on: " + player.joinDate);
        $("#playerDateOfBirth").html("Date Of Birth: " + player.dateOfBirth);
        $("#playerGender").html("Gender: " + player.gender);
        $("#playerBirthplace").html("Birthplace: " + player.birthplace);
        $("#playerCategory").html("Category: " + player.category);
        $("#playerMembershipStatus").html(
          "Membership Status: " + player.membershipStatus
        );

        let badges = "";
        if (player.score >= 10) {
          badges += "&#10020; ";
        }
        if (player.score >= 25) {
          badges += "&#10021; ";
        }
        if (player.score >= 50) {
          badges += "&#10045; ";
        }
        if (player.score >= 100) {
          badges += "&#10051; ";
        }

        $("#playerBadges").html("Badges: " + badges);

        $("#updatePlayerButton").click(() => {
          $("#updatePlayerModal").modal("show");
        });

        $("[name='firstName']").val(player.name);
        $("[name='lastName']").val(player.surname);
        $("[name='dateOfBirth']").val(player.dateOfBirth);
        $("select[name='gender']").val(player.gender);

        $("#closeModalButton").click(() => {
          $("#updatePlayerModal").modal("hide");
        });

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
            console.log(formData);
            Utils.unblock_ui("#updatePlayerModal .modal-content");
          },
        });
      });

      $.get("assets/data/results.json").done((data) => {
        let results = "";

        data.map((result) => {
          results += `<tr>
                <td>${result.opponent}</td>
                <td>${result.status}</td>
            </tr>`;
        });

        $("#playerProfileTable > tbody").html(results);
        $("#playerProfileTable").DataTable({
          columns: [{ data: "opponent" }, { data: "result" }],
        });
      });
    },
  });

  // Login route
  app.route({
    view: "login",
    load: "login.html",

    onReady: () => {
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
    },
  });

  // Register route
  app.route({
    view: "register",
    load: "register.html",

    onReady: () => {
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
    },
  });

  // Apply route
  app.route({
    view: "apply",
    load: "apply.html",

    onReady: () => {
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
    },
  });

  app.run();
});
