var TournamentInfoController = () => {
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
        categories: formData.slice(3).map((category) => category.split("=")[1]),
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
        `[name='category'][value='${tournament.categories[i].toUpperCase()}']`
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
};
