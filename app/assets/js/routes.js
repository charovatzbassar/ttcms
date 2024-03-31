$(document).ready(function () {
  const app = $.spapp({
    templateDir: "./views/",
  });

  app.route({
    view: "dashboard",
    load: "dashboard.html",

    onReady: function () {
      $("#dashboardTable").DataTable({
        columns: [{ data: "name" }, { data: "membership-status" }],
      });
    },
  });

  app.route({
    view: "members",
    load: "members.html",

    onReady: function () {
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
    },
  });

  app.route({
    view: "tournaments",
    load: "tournaments.html",

    onReady: function () {
      $("#tournamentsTable").DataTable({
        columns: [
          { data: "name" },
          { data: "date" },
          { data: "categories" },
          { data: "location" },
          { data: "status" },
        ],
      });
    },
  });

  app.route({
    view: "news",
    load: "news.html",

    onReady: function () {
      $("#newsTable").DataTable({
        columns: [{ data: "title" }, { data: "date-added" }],
      });
    },
  });

  app.route({
    view: "player-stats",
    load: "player-stats.html",

    onReady: function () {
      $("#playerStatsTable").DataTable({
        columns: [{ data: "name" }, { data: "category" }, { data: "score" }],
      });
    },
  });

  app.route({
    view: "registrations",
    load: "registrations.html",

    onReady: function () {
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
    },
  });

  app.run();
});
