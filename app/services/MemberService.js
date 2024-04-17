var MemberService = {
  getMembers: () => {
    return $.ajax({
      url: `${API_BASE_URL}/members`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getMember: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/members/${id}`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    })
  },
  addMember: () => {
    return $.ajax({
      url: `${API_BASE_URL}/members`,
      type: "POST",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  editMember: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/members/${id}?_method=PUT`,
      type: "POST",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  markMembershipAsPaid: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/members/${id}/paid?_method=PUT`,
      type: "POST",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  deleteMember: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/members/${id}`,
      type: "DELETE",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
