var DashboardController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  const data = await MemberService.getMembers();

  let members = "";

  data.map((member) => {
    members += `<tr>
                  <td>${member.firstName} ${member.lastName}</td>
                  <td>${member.membershipStatus}</td>
              </tr>`;
  });

  $("#dashboardTable > tbody").html(members);

  if ($.fn.dataTable.isDataTable("#dashboardTable")) {
    $("#dashboardTable").DataTable().destroy();
  }

  $("#dashboardTable").DataTable({
    columns: [{ data: "name" }, { data: "membership-status" }],
  });
};
