var MembersController = () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();
  $.get("assets/data/players.json").done((data) => {
    let members = "";

    data.map((member) => {
      members += `<tr>
                <td><a href="?id=${member.playerID}#player-profile" class="text-black">${member.name} ${member.surname}</a></td>
                <td>${member.dateOfBirth}</td>
                <td>${member.gender}</td>
                <td>${member.birthplace}</td>
                <td>${member.category}</td>
                <td>${member.membershipStatus}</td>
            </tr>`;
    });

    $("#membersTable > tbody").html(members);

    $("#membersTable").DataTable({
      columns: [
        { data: "name" },
        { data: "date-of-birth" },
        { data: "gender" },
        { data: "birthplace" },
        { data: "category" },
        { data: "membership-status" },
      ],
    });
  });
};
