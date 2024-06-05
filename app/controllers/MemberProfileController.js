var MemberProfileController = async () => {
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

  const member = await MemberService.getMember(id);

  const conn = new WebSocket("https://urchin-app-ngh8p.ondigitalocean.app/");

  conn.onmessage = function (e) {
    Utils.updateMemberUI(JSON.parse(e.data));
  };

  Utils.updateMemberUI(member);

  const badges = Utils.calculateBadges(member.score);

  $("#playerBadges").html(badges === "" ? "No badges" : "Badges: " + badges);

  $("#updatePlayerButton").click(() => {
    $("#updatePlayerModal").modal("show");
  });

  $("#markAsPaid").click(() => {
    MemberService.markMembershipAsPaid(id)
      .then(() => {
        toastr.success("Membership marked as paid");
        conn.send(
          JSON.stringify({
            id: Number(id),
            token: localStorage.getItem("token"),
            type: "members",
          })
        );
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

  Validate.validateUpdateMemberForm(id, conn);

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
};
