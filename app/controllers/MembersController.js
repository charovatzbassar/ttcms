var MembersController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  const data = await MemberService.getMembers();
  let members = "";

  data.map((member) => {
    members += `<tr>
                <td><a href="?id=${member.clubMemberID}#member-profile" class="text-black">${member.firstName} ${member.lastName}</a></td>
                <td>${member.dateOfBirth}</td>
                <td>${member.gender}</td>
                <td>${member.birthplace}</td>
                <td>${member.category}</td>
                <td>${member.membershipStatus}</td>
            </tr>`;
  });

  $("#membersTable > tbody").html(members);

  if ($.fn.dataTable.isDataTable("#membersTable")) {
    $("#membersTable").DataTable().destroy();
  }

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
};
