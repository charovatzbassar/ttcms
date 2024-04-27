var RegistrationsService = {
  getRegistrations: () => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations?userID=${UserService.getLoggedInUser().appUserID}`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getRegistration: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations/${id}?userID=${UserService.getLoggedInUser().appUserID}`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getRegistrationsByStatus: (status) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations?status=${status}&userID=${UserService.getLoggedInUser().appUserID}`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  addRegistration: (registrationData) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations`,
      type: "POST",
      data: registrationData,
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  editRegistration: (id, editData) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations/${id}?userID=${UserService.getLoggedInUser().appUserID}&_method=PUT`,
      type: "POST",
      data: editData,
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  deleteRegistration: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations/${id}?userID=${UserService.getLoggedInUser().appUserID}`,
      type: "DELETE",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  editRegistrationStatus: (id, status) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations/${id}/${status}?userID=${UserService.getLoggedInUser().appUserID}&_method=PUT`,
      type: "POST",
      data: { status },
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
