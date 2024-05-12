var MembersController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  Utils.getDatatable("membersTable", `${API_BASE_URL}/members?page=members`, [
    { data: "name" },
    { data: "dateOfBirth" },
    { data: "gender" },
    { data: "birthplace" },
    { data: "category" },
    { data: "membershipStatus" },
  ]);
};
