var DashboardController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  Utils.get_datatable("dashboardTable", `${API_BASE_URL}/members?page=dashboard`, [
    { data: "name" },
    { data: "membershipStatus" },
  ]);
};
