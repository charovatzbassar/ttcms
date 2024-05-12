var TournamentInfoController = () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");
  Validate.validateUpdateTournamentForm(id);
  Validate.validateAddResultForm(id);

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

      window.handleEditResult = (
        member,
        opponentFirstName,
        opponentLastName,
        status,
        resultID
      ) => {
        $("#updateResultModal").modal("show");
        $("[name='member']").val(member);
        $("[name='opponentFirstName']").val(opponentFirstName);
        $("[name='opponentLastName']").val(opponentLastName);
        $("[name='result']").val(status.toUpperCase());

        $("#updateResultForm").submit(function (e) {
          e.preventDefault();
          Utils.block_ui("#updateResultModal .modal-content");
          const formData = $(this).serialize();

          const resultData = {
            clubMemberID: Number(formData.split("&")[0].split("=")[1]),
            opponentFirstName: formData.split("&")[1].split("=")[1],
            opponentLastName: formData.split("&")[2].split("=")[1],
            resultStatus: formData.split("&")[3].split("=")[1],
            tournamentID: Number(id),
          };

          ResultsService.editResult(resultID, resultData)
            .then(() => {
              toastr.success("Result updated successfully");
            })
            .catch(() => {
              toastr.error("An error occurred while updating the result");
            });
          Utils.unblock_ui("#updateResultModal .modal-content");
          $("#updateResultModal").modal("hide");
          setTimeout(() => {
            window.location.reload();
          }, 500);
        });
      };

      window.handleRemoveResult = (resultID) => {
        $("#removeResultModal").modal("show");
        $("#removeResult").click(() => {
          ResultsService.deleteResult(resultID)
            .then(() => {
              toastr.success("Result removed");
            })
            .catch(() => {
              toastr.error("Error removing result");
            });
          $("#removeResultModal").modal("hide");
          setTimeout(() => {
            window.location.reload();
          }, 500);
        });
      };

      data.map((result) => {
        results += `<tr>
                <td>${result.firstName} ${result.lastName}</td>
                <td>${result.opponentFirstName} ${result.opponentLastName}</td>
                <td>${result.resultStatus}</td>
                <td><button class="btn btn-warning w-50" id="${result.resultID}" onclick="handleEditResult('${result.clubMemberID}', '${result.opponentFirstName}', '${result.opponentLastName}', '${result.resultStatus}', '${result.resultID}')">Edit</button><button class="btn btn-danger w-50" onclick="handleRemoveResult('${result.resultID}')">Remove</button></td>
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
        $("#addResultForm")[0].reset();
      });

      MemberService.getMembers().then((memberData) => {
        let members = "";

        memberData.map((member) => {
          members += `<option value="${member.clubMemberID}">${member.firstName} ${member.lastName}</option>`;
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
              window.location.hash = "#tournaments";
              toastr.success("Tournament removed");
            })
            .catch(() => {
              toastr.error("Error removing tournament");
            });
          $("#removeTournamentModal").modal("hide");
        });

        $("#closeRemoveTournamentModalButton").click(() => {
          $("#removeTournamentModal").modal("hide");
        });

        $("#removeTournamentButton").click(() => {
          $("#removeTournamentModal").modal("show");
        });

        $("#markAsCompletedButton").click(() => {
          TournamentsService.markAsCompleted(id)
            .then(() => {
              toastr.success("Tournament marked as completed");
            })
            .catch(() => {
              toastr.error(
                "An error occurred while marking the tournament as completed"
              );
            });
        });
      });
    });
  });
};
