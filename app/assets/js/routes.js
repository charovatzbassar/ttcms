$(document).ready(function () {
  const app = $.spapp({
    templateDir: "./views/",
  });

  app.route({
    view: "dashboard",
    load: "dashboard.html",

    onReady: function () {
      $.get("assets/data/players.json").done((data) => {
        let members = "";

        data.map((member) => {
          members += `<tr>
                <td>${member.name}</td>
                <td>${member.membershipStatus}</td>
            </tr>`;
        });

        $("#dashboardTable > tbody").html(members);

        $("#dashboardTable").DataTable({
          columns: [{ data: "name" }, { data: "membership-status" }],
        });
      });
    },
  });

  app.route({
    view: "members",
    load: "members.html",

    onReady: function () {
      $.get("assets/data/players.json").done((data) => {
        let members = "";

        data.map((member) => {
          members += `<tr>
                <td>${member.name} ${member.surname}</td>
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
    },
  });

  app.route({
    view: "tournaments",
    load: "tournaments.html",

    onReady: function () {
      $.get("assets/data/tournaments.json").done((data) => {
        let tournaments = "";

        data.map((tournament) => {
          tournaments += `<tr>
                <td>${tournament.name}</td>
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
    },
  });

  app.route({
    view: "news",
    load: "news.html",

    onReady: function () {
      $.get("assets/data/news-articles.json").done((data) => {
        let articles = "";

        data.map((article) => {
          articles += `<tr>
                <td>${article.title}</td>
                <td>${article.dateAdded}</td>

            </tr>`;
        });

        $("#newsTable > tbody").html(articles);
        $("#newsTable").DataTable({
          columns: [{ data: "title" }, { data: "date-added" }],
        });
      });
    },
  });

  app.route({
    view: "player-stats",
    load: "player-stats.html",

    onReady: function () {
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
    },
  });

  app.route({
    view: "registrations",
    load: "registrations.html",

    onReady: function () {
      $.get("assets/data/registrations.json").done((data) => {
        let registrations = "";

        data.map((registration) => {
          if (registration.status === "PENDING") {
            registrations += `<tr>
                <td>${registration.firstName} ${registration.lastName}</td>
                <td>${registration.email}</td>
                <td>${registration.dateOfBirth}</td>
                <td>${registration.gender}</td>
                <td>${registration.birthplace}</td>
                <td><div class="d-flex justify-content-around">
                <button class="btn btn-success w-50">Accept</button
                ><button class="btn btn-danger w-50">Reject</button>
              </div></td>
            </tr>`;
          }
        });

        $("#registrationsTable > tbody").html(registrations);

        $("#registrationsTable").DataTable({
          columns: [
            { data: "name" },
            { data: "email" },
            { data: "date-of-birth" },
            { data: "gender" },
            { data: "birthplace" },
            { data: "actions" },
          ],
        });
      });
    },
  });

  app.run();
});
