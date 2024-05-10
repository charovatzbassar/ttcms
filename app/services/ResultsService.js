var ResultsService = {
  getResults: () => {
    return $.ajax({
      url: `${API_BASE_URL}/results`,
      type: "GET",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getResult: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/results/${id}`,
      type: "GET",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  addResult: (resultData) => {
    return $.ajax({
      url: `${API_BASE_URL}/results`,
      type: "POST",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      data: resultData,
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  editResult: (id, editData) => {
    return $.ajax({
      url: `${API_BASE_URL}/results/${id}?_method=PUT`,
      type: "POST",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      data: editData,
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  deleteResult: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/results/${id}`,
      type: "DELETE",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getResultsByClubMemberId: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/results?clubMemberID=${id}`,
      type: "GET",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getResultsByTournamentId: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/results?tournamentID=${id}`,
      type: "GET",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
