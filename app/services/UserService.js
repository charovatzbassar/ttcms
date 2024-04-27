var UserService = {
  login: (loginData) => {
    return $.ajax({
      url: `${API_BASE_URL}/auth/login`,
      type: "POST",
      data: loginData,
      dataType: "json",
      success: (data) => {
        localStorage.setItem("user", JSON.stringify(data));
        window.location.hash = "dashboard";
      },
      error: (xhr, status, error) => {
        toastr.error(xhr.responseJSON.message);
      },
    });
  },
  register: (registerData) => {
    return $.ajax({
      url: `${API_BASE_URL}/auth/register`,
      type: "POST",
      data: registerData,
      dataType: "json",
      success: (data) => {
        localStorage.setItem("user", JSON.stringify(data));
        window.location.hash = "dashboard";
      },
      error: (xhr, status, error) => {
        toastr.error(xhr.responseJSON.message);
      },
    });
  },
  logout: () => {
    localStorage.removeItem("user");
    window.location.hash = "login";
    window.location.reload();
  },
  getLoggedInUser: () => {
    return JSON.parse(localStorage.getItem("user"));
  },
  getAllUsers: () => {
    return $.ajax({
      url: `${API_BASE_URL}/auth/users`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
