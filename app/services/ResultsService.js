var ResultsService = {
  getResults: () => {
    return $.ajax({
      url: `${API_BASE_URL}/results?userID=${
        UserService.getLoggedInUser().appUserID
      }`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getResult: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/results/${id}?userID=${
        UserService.getLoggedInUser().appUserID
      }`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  addResult: (resultData) => {
    return $.ajax({
      url: `${API_BASE_URL}/results?userID=${
        UserService.getLoggedInUser().appUserID
      }`,
      type: "POST",
      dataType: "json",
      data: resultData,
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  editResult: (id, editData) => {
    return $.ajax({
      url: `${API_BASE_URL}/results/${id}?userID=${
        UserService.getLoggedInUser().appUserID
      }&_method=PUT`,
      type: "POST",
      data: editData,
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  deleteResult: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/results/${id}?userID=${
        UserService.getLoggedInUser().appUserID
      }`,
      type: "DELETE",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getResultsByClubMemberId: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/results?clubMemberID=${id}&userID=${
        UserService.getLoggedInUser().appUserID
      }}`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getResultsByTournamentId: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/results?tournamentID=${id}&userID=${
        UserService.getLoggedInUser().appUserID
      }}`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
