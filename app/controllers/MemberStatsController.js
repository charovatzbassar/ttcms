var MemberStatsController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  Utils.getDatatable("memberStatsTable", `${API_BASE_URL}/members?page=stats`, [
    { data: "name" },
    { data: "category" },
    { data: "score" },
  ]);
};
