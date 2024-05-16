$(document).ready(() => {
  const app = $.spapp({
    templateDir: "./views/",
  });

  // Dashboard route
  app.route({
    view: "dashboard",
    load: "dashboard.html",
    onReady: () => {
      UserService.checkAuth(DashboardController);
    },
  });

  // Members route
  app.route({
    view: "members",
    load: "members.html",

    onReady: () => {
      UserService.checkAuth(MembersController);
    },
  });

  // Tournaments route
  app.route({
    view: "tournaments",
    load: "tournaments.html",

    onReady: () => {
      UserService.checkAuth(TournamentsController);
    },
  });

  // Member Stats route
  app.route({
    view: "member-stats",
    load: "member-stats.html",

    onReady: () => {
      UserService.checkAuth(MemberStatsController);
    },
  });

  // Registrations route
  app.route({
    view: "registrations",
    load: "registrations.html",

    onReady: () => {
      UserService.checkAuth(RegistrationsController);
    },
  });

  // Tournament Info route
  app.route({
    view: "tournament-info",
    load: "tournament-info.html",

    onReady: () => {
      UserService.checkAuth(TournamentInfoController);
    },
  });

  // Player Profile route
  app.route({
    view: "member-profile",
    load: "member-profile.html",

    onReady: () => {
      UserService.checkAuth(MemberProfileController);
    },
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
