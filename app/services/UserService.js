var UserService = {
  getUsers: () => {
    return $.ajax({
      url: `${API_BASE_URL}/users`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
    getUser: (id) => {
        return $.ajax({
        url: `${API_BASE_URL}/users/${id}`,
        type: "GET",
        dataType: "json",
        success: (data) => data,
        error: (xhr, status, error) => [],
        });
    },
    addUser: () => {
        return $.ajax({
        url: `${API_BASE_URL}/users`,
        type: "POST",
        dataType: "json",
        success: (data) => data,
        error: (xhr, status, error) => [],
        });
    },
    editUser: (id) => {
        return $.ajax({
        url: `${API_BASE_URL}/users/${id}?_method=PUT`,
        type: "POST",
        dataType: "json",
        success: (data) => data,
        error: (xhr, status, error) => [],
        });
    },
    deleteUser: (id) => {
        return $.ajax({
        url: `${API_BASE_URL}/users/${id}`,
        type: "DELETE",
        dataType: "json",
        success: (data) => data,
        error: (xhr, status, error) => [],
        });
    },
};
