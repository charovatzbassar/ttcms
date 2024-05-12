var RegistrationsController = async () => {
  window.handleAccept = (id) => {
    RegistrationsService.editRegistrationStatus(id, "ACCEPTED")
      .then(() => {
        window.location.hash = "registrations";
        toastr.success("Registration accepted");
      })
      .catch(() => {
        toastr.error("Error accepting registration");
      });
    setTimeout(() => {
      window.location.reload();
    }, 500);
  };

  window.handleReject = (id) => {
    RegistrationsService.editRegistrationStatus(id, "REJECTED")
      .then(() => {
        window.location.hash = "registrations";
        toastr.success("Registration rejected");
      })
      .catch(() => {
        toastr.error("Error rejecting registration");
      });
    setTimeout(() => {
      window.location.reload();
    }, 500);
  };

  $("#mainNav").show();
  $("#layoutSidenav_nav").show();

  Utils.getDatatable("registrationsTable", `${API_BASE_URL}/registrations`, [
    { data: "name" },
    { data: "email" },
    { data: "dateOfBirth" },
    { data: "gender" },
    { data: "birthplace" },
    { data: "actions" },
  ]);
};
