var TournamentsService = {
  getTournaments: () => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments?userID=${
        UserService.getLoggedInUser().appUserID
      }`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getTournament: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments/${id}?userID=${
        UserService.getLoggedInUser().appUserID
      }}`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  addTournament: (tournamentData) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments?userID=${
        UserService.getLoggedInUser().appUserID
      }`,
      type: "POST",
      data: tournamentData,
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  editTournament: (id, editData) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments/${id}?userID=${
        UserService.getLoggedInUser().appUserID
      }&_method=PUT`,
      type: "POST",
      data: editData,
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  deleteTournament: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments/${id}?userID=${
        UserService.getLoggedInUser().appUserID
      }`,
      type: "DELETE",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  markAsCompleted: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments/${id}/complete?userID=${
        UserService.getLoggedInUser().appUserID
      }&_method=PUT`,
      type: "POST",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
