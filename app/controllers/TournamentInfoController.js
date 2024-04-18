var TournamentInfoController = () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  Validate.validateAddResultForm();

  $("#updateResultForm").submit(function (e) {
    e.preventDefault();
    Utils.block_ui("#updateResultModal .modal-content");
    const formData = $(this).serialize();
    ResultsService.updateResult(formData)
      .then(() => {
        toastr.success("Result updated successfully");
      })
      .catch(() => {
        toastr.error("An error occurred while updating the result");
      });
    Utils.unblock_ui("#updateResultModal .modal-content");
    $("#updateResultModal").modal("hide");
  });

  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");
  Validate.validateUpdateTournamentForm(id);

  TournamentsService.getTournament(id).then((tournament) => {
    $("#tournamentName").html(tournament.tournamentName);
    $("#tournamentDate").html("Date: " + tournament.tournamentDate);
    $("#tournamentLocation").html("Location: " + tournament.tournamentLocation);
    $("#tournamentCategories").html("Categories: " + tournament.categories);

    $("#updateTournamentButton").click(() => {
      $("#updateTournamentModal").modal("show");
    });

    $("#closeUpdateTournamentModalButton").click(() => {
      $("#updateTournamentModal").modal("hide");
    });

    $("#closeUpdateResultModalButton").click(() => {
      $("#updateResultModal").modal("hide");
    });

    $("[name='name']").val(tournament.tournamentName);
    $("[name='date']").val(tournament.tournamentDate);
    $("[name='location']").val(tournament.tournamentLocation);

    for (let i = 0; i < tournament.categories.split(", ").length; i++) {
      $(
        `[name='category'][value='${tournament.categories[i].toUpperCase()}']`
      ).prop("checked", true);
    }

    ResultsService.getResultsByTournamentId(id).then((data) => {
      let results = "";

      window.handleEditResult = (member, opponent, status) => {
        $("#updateResultModal").modal("show");
        $("[name='member']").val(member);
        $("[name='opponent']").val(opponent);
        $("[name='result']").val(status.toUpperCase());
      };

      window.handleRemoveResult = (resultID) => {
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

      if ($.fn.dataTable.isDataTable("#tournamentInfoTable")) {
        $("#tournamentInfoTable").DataTable().destroy();
      }

      $("#tournamentInfoTable").DataTable({
        columns: [
          { data: "member" },
          { data: "opponent" },
          { data: "result" },
          { data: "actions" },
        ],
      });

      $("#addResultButton").click(() => {
        $("#addResultModal").modal("show");
      });

      MemberService.getMembers().then((memberData) => {
        let members = "";

        memberData.map((member) => {
          members += `<option value="${member.playerID}">${member.firstName} ${member.lastName}</option>`;
        });

        $("select[name='member']").html(members);

        $("#closeAddResultModalButton").click(() => {
          $("#addResultModal").modal("hide");
        });

        $("#closeUpdateResultModalButton").click(() => {
          $("#updateResultModal").modal("hide");
        });

        $("#closeRemoveResultModalButton").click(() => {
          $("#removeResultModal").modal("hide");
        });

        $("#removeTournament").click(() => {
          TournamentsService.deleteTournament(id)
            .then(() => {
              window.location.href = "/#tournaments";
              toastr.success("Tournament removed");
            })
            .catch(() => {
              $("#removeTournamentModal").modal("hide");
              toastr.error("Error removing tournament");
            });
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
      });
    });
  });
};
