var MemberService = {
  getDashboardTable: () => {
    Utils.getDatatable(
      "dashboardTable",
      `${API_BASE_URL}/members?page=dashboard`,
      [{ data: "name" }, { data: "membershipStatus" }]
    );
  },
  getMembersTable: () => {
    Utils.getDatatable("membersTable", `${API_BASE_URL}/members?page=members`, [
      { data: "name" },
      { data: "dateOfBirth" },
      { data: "gender" },
      { data: "birthplace" },
      { data: "category" },
      { data: "membershipStatus" },
    ]);
  },
  getMemberStatsTable: () => {
    Utils.getDatatable(
      "memberStatsTable",
      `${API_BASE_URL}/members?page=stats`,
      [{ data: "name" }, { data: "category" }, { data: "score" }]
    );
  },
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
      url: `${API_BASE_URL}/members/${id}`,
      type: "GET",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  addMember: (memberData) => {
    return $.ajax({
      url: `${API_BASE_URL}/members`,
      type: "POST",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      data: memberData,
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  editMember: (id, editData) => {
    return $.ajax({
      url: `${API_BASE_URL}/members/${id}?_method=PUT`,
      type: "POST",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      data: editData,
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  markMembershipAsPaid: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/members/${id}/paid?_method=PUT`,
      type: "POST",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  deleteMember: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/members/${id}`,
      type: "DELETE",
      beforeSend: (xhr) =>
        xhr.setRequestHeader("Authorization", localStorage.getItem("token")),
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
};
