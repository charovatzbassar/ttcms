var UserService = {
  login: (loginData) => {
    return $.ajax({
      url: `${API_BASE_URL}/auth/login`,
      type: "POST",
      data: loginData,
      dataType: "json",
      success: (data) => {
        localStorage.setItem("token", data);
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
        localStorage.setItem("token", data);
        window.location.hash = "dashboard";
      },
      error: (xhr, status, error) => {
        toastr.error(xhr.responseJSON.message);
      },
    });
  },
  logout: () => {
    localStorage.removeItem("token");
    window.location.hash = "login";
    window.location.reload();
  },
  checkAuth: (controller) => {
    if (!localStorage.getItem("token")) {
      window.location.hash = "login";
    } else controller();
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
