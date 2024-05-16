var TournamentsService = {
  getTournamentsTable: () => {
    Utils.getDatatable("tournamentsTable", `${API_BASE_URL}/tournaments`, [
      { data: "tournamentName" },
      { data: "tournamentDate" },
      { data: "categories" },
      { data: "tournamentLocation" },
      { data: "tournamentStatus" },
    ]);
  },
  getTournaments: () => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments`,
      type: "GET",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getTournament: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments/${id}`,
      type: "GET",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  addTournament: (tournamentData) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments`,
      type: "POST",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
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
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
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
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  markAsCompleted: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/tournaments/${id}/complete?_method=PUT`,
      type: "POST",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
