$(document).ready(() => {
  const app = $.spapp({
    templateDir: "./views/",
  });

  // Dashboard route
  app.route({
    view: "dashboard",
    load: "dashboard.html",

    onReady: DashboardController,
  });

  // Members route
  app.route({
    view: "members",
    load: "members.html",

    onReady: MembersController,
  });

  // Tournaments route
  app.route({
    view: "tournaments",
    load: "tournaments.html",

    onReady: TournamentsController,
  });

  // Player Stats route
  app.route({
    view: "player-stats",
    load: "player-stats.html",

    onReady: PlayerStatsController,
  });

  // Registrations route
  app.route({
    view: "registrations",
    load: "registrations.html",

    onReady: RegistrationsController,
  });

  // Tournament Info route
  app.route({
    view: "tournament-info",
    load: "tournament-info.html",

    onReady: TournamentInfoController,
  });

  // Player Profile route
  app.route({
    view: "player-profile",
    load: "player-profile.html",

    onReady: PlayerProfileController,
  });

  // Login route
  app.route({
    view: "login",
    load: "login.html",

    onReady: LoginController,
  });

  // Register route
  app.route({
    view: "register",
    load: "register.html",

    onReady: RegisterController,
  });

  // Apply route
  app.route({
    view: "apply",
    load: "apply.html",

    onReady: ApplyController,
  });

  app.run();
});
