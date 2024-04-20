var ApplyController = () => {
  $("#mainNav").hide();
  $("#layoutSidenav_nav").hide();

  UserService.getAllUsers().then((data) => {
    data.map((user) => {
      $("#clubName").append(
        `<option value="${user.appUserID}">${user.clubName}</option>`
      );
    });
  });

  Validate.validateApplyForm();
};
