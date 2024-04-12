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
  getMember: (id) => {
    return $.ajax({
      url: `${API_BASE_URL}/players.json`,
      type: "GET",
      dataType: "json",
      success: (data) => data.find((member) => member.playerID === id),
      error: (xhr, status, error) => [],
    });
  },
  addMember: () => {},
  editMember: (id) => {},
  deleteMember: (id) => {},
};
