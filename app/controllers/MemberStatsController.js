var MemberStatsController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();
  const data = await MemberService.getMembers();
  let members = "";

  data.map((member) => {
    members += `<tr>
              <td>${member.firstName} ${member.lastName}</td>
              <td>${member.category}</td>
              <td>${member.score}</td>
          </tr>`;
  });

  $("#playerStatsTable > tbody").html(members);

  if ($.fn.dataTable.isDataTable("#playerStatsTable")) {
    $("#playerStatsTable").DataTable().destroy();
  }

  $("#playerStatsTable").DataTable({
    columns: [{ data: "name" }, { data: "category" }, { data: "score" }],
  });
};
