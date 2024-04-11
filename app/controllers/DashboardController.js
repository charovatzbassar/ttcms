var DashboardController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  const data = await MemberService.getMembers();

  let members = "";

  data.map((member) => {
    members += `<tr>
                  <td>${member.name}</td>
                  <td>${member.membershipStatus}</td>
              </tr>`;
  });

  $("#dashboardTable > tbody").html(members);
  $("#dashboardTable").DataTable({
    columns: [{ data: "name" }, { data: "membership-status" }],
  });
};
