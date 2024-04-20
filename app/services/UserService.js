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
      error: (xhr, status, error) => [],
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
      error: (xhr, status, error) => [],
    });
  },
  logout: () => {
    localStorage.removeItem("user");
    window.location.hash = "login";
  },
  getLoggedInUser: () => {
    return JSON.parse(localStorage.getItem("user"));
  },
};
