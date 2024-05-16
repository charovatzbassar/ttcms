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


  TournamentsService.getTournamentsTable();
};
