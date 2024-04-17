var ResultsService = {
  getResults: () => {
    return $.ajax({
      url: `${API_BASE_URL}/results`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getResult: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/results/${id}`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  addResult: () => {
    return $.ajax({
      url: `${API_BASE_URL}/results`,
      type: "POST",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  editResult: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/results/${id}?_method=PUT`,
      type: "POST",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  deleteResult: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/results/${id}`,
      type: "DELETE",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getResultsByClubMemberId: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/results?clubMemberID=${id}`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getResultsByTournamentId: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/results?tournamentID=${id}`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
