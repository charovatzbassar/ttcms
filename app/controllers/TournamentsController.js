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


  Utils.getDatatable("tournamentsTable", `${API_BASE_URL}/tournaments`, [
    { data: "tournamentName" },
    { data: "tournamentDate" },
    { data: "categories" },
    { data: "tournamentLocation" },
    { data: "tournamentStatus" },
  ]);
};
