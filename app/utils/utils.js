var Utils = {
  block_ui: function (element) {
    $(element).block({
      message: '<div class="spinner-border text-primary" role="status"></div>',
      css: {
        backgroundColor: "transparent",
        border: "0",
      },
      overlayCSS: {
        backgroundColor: "#000",
        opacity: 0.25,
      },
    });
  },
  unblock_ui: function (element) {
    $(element).unblock({});
  },
  calculateBadges: (score) => {
    let badges = "";
    if (score >= 10) {
      badges += "&#10020; ";
    }
    if (score >= 25) {
      badges += "&#10021; ";
    }
    if (score >= 50) {
      badges += "&#10045; ";
    }
    if (score >= 100) {
      badges += "&#10051; ";
    }
    return badges;
  },
  getDatatable: function (
    table_id,
    url,
    columns,
    disable_sort,
    callback,
    details_callback = null,
    sort_column = null,
    sort_order = null,
    draw_callback = null,
    page_length = 10
  ) {
    if ($.fn.dataTable.isDataTable("#" + table_id)) {
      details_callback = false;
      $("#" + table_id)
        .DataTable()
        .destroy();
    }
    $("#" + table_id).DataTable({
      order: [
        sort_column == null ? 2 : sort_column,
        sort_order == null ? "desc" : sort_order,
      ],
      orderClasses: false,
      columns: columns,
      columnDefs: [{ orderable: false, targets: disable_sort }],
      processing: true,
      serverSide: true,
      orderMulti: true,
      ajax: {
        url: url,
        type: "GET",
        headers: {
          Authorization: localStorage.getItem("token"),
        },
        error: function (xhr, status, error) {
          if (xhr.status === 401) {
            localStorage.removeItem("token");
            window.location.hash = "login";
          }
        },
      },
      lengthMenu: [
        [5, 10, 15, 50, 100, 200, 500, 5000],
        [5, 10, 15, 50, 100, 200, 500, "ALL"],
      ],
      pageLength: page_length,
      initComplete: function () {
        if (callback) callback();
      },
      drawCallback: function (settings) {
        if (draw_callback) draw_callback();
      },
    });
  },
  updateMemberUI: (member) => {
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
  },
  updateTournamentUI: (tournament) => {
    $("#tournamentName").html(tournament.tournamentName);
    $("#tournamentDate").html("Date: " + tournament.tournamentDate);
    $("#tournamentLocation").html("Location: " + tournament.tournamentLocation);
    $("#tournamentCategories").html("Categories: " + tournament.categories);
  },
};
