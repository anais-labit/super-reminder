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

    return new Promise(async (resolve, reject) => {
      checkTaskBtns.forEach((button) => {
        button.addEventListener("click", async (event) => {
          event.preventDefault();
          let taskId = button.getAttribute("data-task-id");
          let taskStatus = button.getAttribute("value");

          const url = "lists.php";

          try {
            const formData = new FormData();
            formData.append("taskId", taskId);
            formData.append("taskStatus", taskStatus);
            formData.append("checkTaskForm", "checkTaskForm");

            const response = await fetch(url, {
              method: "POST",
              body: formData,
            });

            const jsonResponse = await response.json();

            if (response.ok) {
              taskStatus = taskStatus === "0" ? "1" : "0";
              button.setAttribute("value", taskStatus);

              const taskNameToUpdate = document.querySelector(
                `#taskName-${taskId}`
              );
              const taskDueDateToUpdate = document.querySelector(
                `#taskDueDate-${taskId}`
              );
              const icon = button.querySelector("i");

              if (taskStatus == "1") {
                taskNameToUpdate.classList.add("doneTask");
                taskDueDateToUpdate.classList.add("doneTask");
                icon.classList.remove("fa-check");
                icon.classList.add("fa-arrows-rotate");
              } else {
                if (taskStatus == "0") {
                  taskNameToUpdate.classList.remove("doneTask");
                  taskDueDateToUpdate.classList.remove("doneTask");
                  icon.classList.add("fa-check");
                  icon.classList.remove("fa-arrows-rotate");
                }
              }

              const container = document.querySelector("#message");
              container.setAttribute("class", "alert alert-success");
              container.textContent = jsonResponse.message;

              refreshMessages();
              resolve(true);
            } else {
              reject("Échec de la mise à jour de la tâche");
            }
          } catch (error) {
            reject(error);
          }
        });
      });
    });
  }
}
