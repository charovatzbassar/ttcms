var DashboardController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  Utils.getDatatable("dashboardTable", `${API_BASE_URL}/members?page=dashboard`, [
    { data: "name" },
    { data: "membershipStatus" },
  ]);
};
