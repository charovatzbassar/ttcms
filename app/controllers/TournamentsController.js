var TournamentsController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  Validate.validateAddTournamentForm();

  $("#addTournamentButton").click(() => {
    $("#addTournamentModal").modal("show");
  });

  $("#closeModalButton").click(() => {
    $("#addTournamentModal").modal("hide");
  });

  const data = await TournamentsService.getTournaments();

  let tournaments = "";

  data.map((tournament) => {
    tournaments += `<tr>
            <td><a href="?id=${tournament.tournamentID}#tournament-info" class="text-black">${tournament.tournamentName}</a></td>
            <td>${tournament.tournamentDate}</td>
            <td>${tournament.categories}</td>
            <td>${tournament.tournamentLocation}</td>
            <td>${tournament.tournamentStatus}</td>
        </tr>`;
  });

  $("#tournamentsTable > tbody").html(tournaments);

  if ($.fn.dataTable.isDataTable("#tournamentsTable")) {
    $("#tournamentsTable").DataTable().destroy();
  }

  $("#tournamentsTable").DataTable({
    columns: [
      { data: "name" },
      { data: "date" },
      { data: "categories" },
      { data: "location" },
      { data: "status" },
    ],
  });
};
