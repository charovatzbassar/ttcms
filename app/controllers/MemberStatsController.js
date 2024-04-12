var MemberStatsController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();
  const data = await MemberService.getMembers();
  let members = "";

  data.map((member) => {
    members += `<tr>
              <td>${member.name} ${member.surname}</td>
              <td>${member.category}</td>
              <td>${member.score}</td>
          </tr>`;
  });

  $("#playerStatsTable > tbody").html(members);
  $("#playerStatsTable").DataTable({
    columns: [{ data: "name" }, { data: "category" }, { data: "score" }],
  });
};
