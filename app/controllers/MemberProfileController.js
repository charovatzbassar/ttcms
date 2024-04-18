var MemberProfileController = () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  $("#markAsPaid").click(() => {
    toastr.success("Player marked as paid");
  });

  $("#removePlayerButton").click(() => {
    $("#removePlayerModal").modal("show");
  });

  $("#removePlayer").click(() => {
    $.ajax({
      url: `${API_BASE_URL}/members/${id}?_method=DELETE`,
      type: "POST",
      success: function (data) {
        console.log(data);
        toastr.success("Player removed successfully");
      },
      error: function (error) {
        console.log(error);
        toastr.error("An error occurred while removing the player");
      },
    
    })
    $("#removePlayerModal").modal("hide");
  });

  $("#closeRemovePlayerModalButton").click(() => {
    $("#removePlayerModal").modal("hide");
  });

  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");

  MemberService.getMember(id).then((member) => {

    $("#playerName").html(member.firstName + " " + member.lastName);
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

    Validate.validateUpdateMemberForm(id);

    ResultsService.getResultsByClubMemberId(id).then((data) => {
      let results = "";

      data.map((result) => {
        results += `<tr>
                  <td>${result.opponentFirstName} ${result.opponentLastName}</td>
                  <td>${result.resultStatus}</td>
              </tr>`;
      });

      $("#playerProfileTable > tbody").html(results);


      if ($.fn.dataTable.isDataTable("#playerProfileTable")) {
        $("#playerProfileTable").DataTable().destroy();
      }


      $("#playerProfileTable").DataTable({
        columns: [{ data: "opponent" }, { data: "result" }],
      });
    });
  });
};
