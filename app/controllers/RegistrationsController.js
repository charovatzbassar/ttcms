var RegistrationsController = () => {
  window.handleAccept = (id) => {
    console.log(id);
    toastr.success("Registration accepted");
  };

  window.handleReject = (id) => {
    console.log(id);
    toastr.error("Registration rejected");
  };

  $("#mainNav").show();
  $("#layoutSidenav_nav").show();
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
              <button class="btn btn-success w-50" onclick="handleAccept('${registration.registrationID}')">Accept</button
              ><button class="btn btn-danger w-50" onclick="handleReject('${registration.registrationID}')">Reject</button>
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
};
