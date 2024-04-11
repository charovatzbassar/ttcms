var RegistrationsService = {
  getRegistrations: () => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations.json`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
