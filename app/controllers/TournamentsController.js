var TournamentsController = () => {
  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  $($("#addTournamentForm")).validate({
    errorElement: "span",
    errorClass: "help-block help-block-error",
    rules: {
      name: {
        required: true,
      },
      location: {
        required: true,
      },
      date: {
        required: true,
      },
      category: {
        required: true,
      },
    },

    messages: {
      name: {
        required: "Please enter a name",
      },
      date: {
        required: "Please enter a date date",
      },

      location: {
        required: "Please enter a location",
      },
      category: {
        required: "Please select at least one category",
      },
    },

    submitHandler: function (f, e) {
      e.preventDefault();
      Utils.block_ui("#addTournamentModal .modal-content");
      const formData = $(f).serialize().split("&");

      const tournament = {
        name: formData[0].split("=")[1],
        date: formData[1].split("=")[1],
        location: formData[2].split("=")[1],
        categories: formData.slice(3).map((category) => category.split("=")[1]),
        status: "UPCOMING",
      };

      console.log(tournament);
      Utils.unblock_ui("#addTournamentModal .modal-content");
    },
  });

  $("#addTournamentButton").click(() => {
    $("#addTournamentModal").modal("show");
  });

  $("#closeModalButton").click(() => {
    $("#addTournamentModal").modal("hide");
  });

  $.get("assets/data/tournaments.json").done((data) => {
    let tournaments = "";

    data.map((tournament) => {
      tournaments += `<tr>
              <td><a href="?id=${
                tournament.tournamentID
              }#tournament-info" class="text-black">${tournament.name}</a></td>
              <td>${tournament.date}</td>
              <td>${tournament.categories.join(", ")}</td>
              <td>${tournament.location}</td>
              <td>${tournament.status}</td>
          </tr>`;
    });

    $("#tournamentsTable > tbody").html(tournaments);

    $("#tournamentsTable").DataTable({
      columns: [
        { data: "name" },
        { data: "date" },
        { data: "categories" },
        { data: "location" },
        { data: "status" },
      ],
    });
  });
};
