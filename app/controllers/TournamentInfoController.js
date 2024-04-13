var TournamentInfoController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  Validate.validateAddResultForm();

  $("#updateResultForm").submit(function (e) {
    e.preventDefault();
    Utils.block_ui("#updateResultModal .modal-content");
    const formData = $(this).serialize();
    console.log(formData);
    Utils.unblock_ui("#updateResultModal .modal-content");
  });

  Validate.validateUpdateTournamentForm();

  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");

  const tournaments = await TournamentsService.getTournaments();

  const tournament = tournaments.find((t) => t.tournamentID === id);

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

  const resultsData = await ResultsService.getResults();
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

  resultsData.map((result) => {
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

  $("#addResultButton").click(() => {
    $("#addResultModal").modal("show");
  });

  const memberData = await MemberService.getMembers();

  let members = "";

  memberData.map((member) => {
    members += `<option value="${member.playerID}">${member.name} ${member.surname}</option>`;
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
