var MemberStatsController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  MemberService.getMemberStatsTable();
};
