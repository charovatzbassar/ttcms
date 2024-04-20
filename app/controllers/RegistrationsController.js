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

  const data = await RegistrationsService.getRegistrationsByStatus("PENDING");

  let registrations = "";

  data.map((registration) => {
    registrations += `<tr>
              <td>${registration.firstName} ${registration.lastName}</td>
              <td>${registration.email}</td>
              <td>${registration.dateOfBirth}</td>
              <td>${registration.gender}</td>
              <td>${registration.birthplace}</td>
              <td><div class="d-flex justify-content-around">
              <button class="btn btn-success w-50" onclick="handleAccept('${registration.registrationID}')">Accept</button
              ><button class="btn btn-danger w-50" onclick="handleReject('${registration.registrationID}')">Reject</button>
            </div></td>
          </tr>`;
  });

  $("#registrationsTable > tbody").html(registrations);

  if ($.fn.dataTable.isDataTable("#registrationsTable")) {
    $("#registrationsTable").DataTable().destroy();
  }

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
};
