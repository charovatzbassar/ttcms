var MembersController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  MemberService.getMembersTable();
};
