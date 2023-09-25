async function displayUpdateUserMessage() {
  if (window.location.href.endsWith("profil.php")) {
    const reqUpdate = new FormData(updateForm);

    reqUpdate.append("updateProfile", "updateProfile");

    const options = {
      method: "POST",
      body: reqUpdate,
    };

    const updateUser = await fetch("profil.php?updateProfile", options);
    const jsonResponse = await updateUser.json();

    const container = document.querySelector("#message");
    container.setAttribute("class", "alert alert-success");
    container.textContent = jsonResponse.message;
  }

  if (window.location.href.endsWith("profil.php")) {
    updateButton.addEventListener("click", async (event) => {
      event.preventDefault();
      displayUpdateUserMessage();
    });
  }
}

async function updateTaskStatus() {
  if (window.location.href.endsWith("lists.php")) {
    const checkTaskBtns = document.querySelectorAll(".checkTaskBtn");

    checkTaskBtns.forEach((button) => {
      button.addEventListener("click", async function (event) {
        event.preventDefault();
        const taskId = button.getAttribute("data-task-id");
        let taskStatus = button.getAttribute("value");
        console.log(taskId);
        console.log(taskStatus);

        if (taskStatus == 0) {
          const taskTitleDisplayer = document.querySelector(
            `#taskName-${taskId}`
          );

          taskTitleDisplayer.classList.add("doneTask");
          button.setAttribute("value", 1);
        } else {
          const taskTitleDisplayer = document.querySelector(
            `#taskName-${taskId}`
          );
          taskTitleDisplayer.classList.remove("doneTask");
          button.setAttribute("value", 0);
        }

        // const formData = new FormData();
        // formData.append("taskId", taskId);
        // formData.append("status", taskStatus);

        // const response = await fetch("lists.php", {
        //   method: "POST",
        //   body: formData,
        // });
        // const jsonResponse = await response.text();

        // console.log(jsonResponse);
      });
    });
  }
}

updateTaskStatus();
