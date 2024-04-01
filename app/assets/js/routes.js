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
      $("#addTournamentForm").submit(function (e) {
        e.preventDefault();
        Utils.block_ui("#addTournamentModal .modal-content");
        const formData = $(this).serialize().split("&");

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
                <button class="btn btn-success w-50">Accept</button
                ><button class="btn btn-danger w-50">Reject</button>
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
      $("#markAsCompleted").hide();

      $("#markAsCompletedButton").click(() => {
        $("#markAsCompleted").show();
      });

      $("#addResultForm").submit(function (e) {
        e.preventDefault();
        Utils.block_ui("#addResultModal .modal-content");
        const formData = $(this).serialize();
        console.log(formData);
        Utils.unblock_ui("#addResultModal .modal-content");
      });

      $("#updateResultForm").submit(function (e) {
        e.preventDefault();
        Utils.block_ui("#updateResultModal .modal-content");
        const formData = $(this).serialize();
        console.log(formData);
        Utils.unblock_ui("#updateResultModal .modal-content");
      });

      $("#updateTournamentForm").submit(function (e) {
        e.preventDefault();
        Utils.block_ui("#updateTournamentModal .modal-content");
        const formData = $(this).serialize();
        console.log(formData);
        Utils.unblock_ui("#updateTournamentModal .modal-content");
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
    },
  });

  // Player Profile route
  app.route({
    view: "player-profile",
    load: "player-profile.html",

    onReady: () => {
      $("#mainNav").show();
      $("#layoutSidenav_nav").show();
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
    },
  });

  // Register route
  app.route({
    view: "register",
    load: "register.html",

    onReady: () => {
      $("#mainNav").hide();
      $("#layoutSidenav_nav").hide();
    },
  });

  // Apply route
  app.route({
    view: "apply",
    load: "apply.html",

    onReady: () => {
      $("#mainNav").hide();
      $("#layoutSidenav_nav").hide();
    },
  });

  app.run();
});
