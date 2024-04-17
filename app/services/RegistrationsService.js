var RegistrationsService = {
  getRegistrations: () => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getRegistration: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations/${id}`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    })
  },
  getRegistrationsByStatus: (status) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations?status=${status}`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  addRegistration: () => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations`,
      type: "POST",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  editRegistration: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations/${id}?_method=PUT`,
      type: "POST",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  deleteRegistration: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations/${id}`,
      type: "DELETE",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
