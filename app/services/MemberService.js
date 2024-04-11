var MemberService = {
  getMembers: () => {
    return $.ajax({
      url: `${API_BASE_URL}/players.json`,
      type: "GET",
      dataType: "json",
      success: (data) => data,
      error: (xhr, status, error) => [],
    });
  },
  getMember: (id) => {},
  addMember: () => {},
  editMember: (id) => {},
  deleteMember: (id) => {},
};
