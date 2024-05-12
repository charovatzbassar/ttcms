var RegistrationsController = async () => {
  window.handleAccept = (id) => {
    RegistrationsService.editRegistrationStatus(id, "ACCEPTED")
      .then(() => {
        window.location.hash = "registrations";
        toastr.success("Registration accepted");
        RegistrationsService.getRegistrationsTable();
      })
      .catch(() => {
        toastr.error("Error accepting registration");
      });
  };

  window.handleReject = (id) => {
    RegistrationsService.editRegistrationStatus(id, "REJECTED")
      .then(() => {
        window.location.hash = "registrations";
        toastr.success("Registration rejected");
        RegistrationsService.getRegistrationsTable();
      })
      .catch(() => {
        toastr.error("Error rejecting registration");
      });
  };

  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  RegistrationsService.getRegistrationsTable();
};
