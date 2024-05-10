var MemberService = {
  getMembers: () => {
    return $.ajax({
      url: `${API_BASE_URL}/members`,
      type: "GET",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getMember: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/members/${id}?userID=${
        UserService.getLoggedInUser().appUserID
      }`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  addMember: (memberData) => {
    return $.ajax({
      url: `${API_BASE_URL}/members?userID=${
        UserService.getLoggedInUser().appUserID
      }`,
      type: "POST",
      data: memberData,
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  editMember: (id, editData) => {
    return $.ajax({
      url: `${API_BASE_URL}/members/${id}?userID=${
        UserService.getLoggedInUser().appUserID
      }&_method=PUT`,
      type: "POST",
      data: editData,
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  markMembershipAsPaid: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/members/${id}/paid?userID=${
        UserService.getLoggedInUser().appUserID
      }&_method=PUT`,
      type: "POST",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  deleteMember: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/members/${id}?userID=${
        UserService.getLoggedInUser().appUserID
      }`,
      type: "DELETE",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
