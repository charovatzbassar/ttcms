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
            <td><a href="?id=${
              tournament.tournamentID
            }#tournament-info" class="text-black">${tournament.name}</a></td>
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
};
