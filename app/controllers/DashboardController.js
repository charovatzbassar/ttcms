var DashboardController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  MemberService.getDashboardTable();
};
