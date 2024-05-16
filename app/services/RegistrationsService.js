var RegistrationsService = {
  getRegistrationsTable: () => {
    Utils.getDatatable("registrationsTable", `${API_BASE_URL}/registrations`, [
      { data: "name" },
      { data: "email" },
      { data: "dateOfBirth" },
      { data: "gender" },
      { data: "birthplace" },
      { data: "actions" },
    ]);
  },
  getRegistrations: () => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations`,
      type: "GET",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getRegistration: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations/${id}`,
      type: "GET",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getRegistrationsByStatus: (status) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations?status=${status}`,
      type: "GET",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
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
      url: `${API_BASE_URL}/registrations/${id}?_method=PUT`,
      type: "POST",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      data: editData,
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  deleteRegistration: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations/${id}`,
      type: "DELETE",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  editRegistrationStatus: (id, status) => {
    return $.ajax({
      url: `${API_BASE_URL}/registrations/${id}/${status}?_method=PUT`,
      type: "POST",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      data: { status },
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
