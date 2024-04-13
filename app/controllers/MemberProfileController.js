var MemberProfileController = async () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  $("#markAsPaid").click(() => {
    toastr.success("Player marked as paid");
  });

  $("#removePlayerButton").click(() => {
    $("#removePlayerModal").modal("show");
  });

  $("#closeRemovePlayerModalButton").click(() => {
    $("#removePlayerModal").modal("hide");
  });

  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");

  const members = await MemberService.getMembers();

  const member = members.find((m) => m.playerID === id);

  $("#playerName").html(member.name + " " + member.surname);
  $("#playerTournamentScore").html("Tournament Score: " + member.score);
  $("#playerJoinDate").html("Joined on: " + member.joinDate);
  $("#playerDateOfBirth").html("Date Of Birth: " + member.dateOfBirth);
  $("#playerGender").html("Gender: " + member.gender);
  $("#playerBirthplace").html("Birthplace: " + member.birthplace);
  $("#playerCategory").html("Category: " + member.category);
  $("#playerMembershipStatus").html(
    "Membership Status: " + member.membershipStatus
  );

  const badges = Utils.calculateBadges(member.score);

  $("#playerBadges").html("Badges: " + badges);

  $("#updatePlayerButton").click(() => {
    $("#updatePlayerModal").modal("show");
  });

  $("[name='firstName']").val(member.name);
  $("[name='lastName']").val(member.surname);
  $("[name='dateOfBirth']").val(member.dateOfBirth);
  $("select[name='gender']").val(member.gender);

  $("#closeModalButton").click(() => {
    $("#updatePlayerModal").modal("hide");
  });

  Validate.validateUpdateMemberForm();

  const resultsData = await ResultsService.getResults();
  let results = "";

  resultsData.map((result) => {
    results += `<tr>
              <td>${result.opponent}</td>
              <td>${result.status}</td>
          </tr>`;
  });

  $("#playerProfileTable > tbody").html(results);
  $("#playerProfileTable").DataTable({
    columns: [{ data: "opponent" }, { data: "result" }],
  });
};
