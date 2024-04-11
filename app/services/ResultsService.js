var ResultsService = {
  getResults: () => {
    return $.ajax({
      url: `${API_BASE_URL}/results.json`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
