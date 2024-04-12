var TournamentsService = {
  getTournaments: () => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments.json`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getTournament: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments.json`,
      type: "GET",
      dataType: "json",
      success: (data) => data.find((t) => t.tournamentID === id),
      error: (xhr, status, error) => {
        return {};
      },
    });
  },
};
