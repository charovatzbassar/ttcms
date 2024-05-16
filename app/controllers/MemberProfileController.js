var MemberProfileController = () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  $("#removePlayerButton").click(() => {
    $("#removePlayerModal").modal("show");
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

    $("#playerBadges").html(badges === "" ? "No badges" : "Badges: " + badges);

    $("#updatePlayerButton").click(() => {
      $("#updatePlayerModal").modal("show");
    });

    $("#markAsPaid").click(() => {
      MemberService.markMembershipAsPaid(id)
        .then(() => {
          toastr.success("Membership marked as paid");
        })
        .catch(() => {
          toastr.error("Error marking membership as paid");
        });
    });

    $("[name='firstName']").val(member.firstName);
    $("[name='lastName']").val(member.lastName);
    $("[name='dateOfBirth']").val(member.dateOfBirth);
    $("select[name='gender']").val(member.gender);

    $("#closeModalButton").click(() => {
      $("#updatePlayerModal").modal("hide");
    });

    Validate.validateUpdateMemberForm(id);

    $("#removePlayer").click(() => {
      MemberService.deleteMember(id)
        .then(() => {
          window.location.hash = "dashboard";
          toastr.success("Member removed");
          $("#removePlayerModal").modal("hide");
        })
        .catch(() => {
          toastr.error("Error removing member");
          $("#removePlayerModal").modal("hide");
        });
    });

    ResultsService.getMemberProfileTable(id);
  });
};
