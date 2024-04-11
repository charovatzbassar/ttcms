var PlayerProfileController = () => {
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
};
