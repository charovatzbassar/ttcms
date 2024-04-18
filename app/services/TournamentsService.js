var TournamentsService = {
  getTournaments: () => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getTournament: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments/${id}`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  addTournament: (tournamentData) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments`,
      type: "POST",
      data: tournamentData,
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  editTournament: (id, editData) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments/${id}?_method=PUT`,
      type: "POST",
      data: editData,
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  deleteTournament: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments/${id}`,
      type: "DELETE",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  markAsCompleted: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments/${id}/complete?_method=PUT`,
      type: "POST",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
