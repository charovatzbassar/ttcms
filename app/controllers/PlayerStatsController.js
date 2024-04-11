var PlayerStatsController = () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();
  $.get("assets/data/players.json").done((data) => {
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
  });
};
