async function displayRegisterUserMessage() {
  try {
    if (window.location.href.endsWith("inscription.php")) {
      const response = await fetch("inscription.php");
      const content = await response.text();

      const signUpBtn = document.querySelector("#signUpBtn");
      const form = document.querySelector("#registerForm");

      signUpBtn.addEventListener("click", async function (event) {
        event.preventDefault();
        const data = new FormData(form);
        data.append("submitForm", "");

        const response = await fetch("inscription.php", {
          method: "POST",
          body: data,
        });

        const jsonResponse = await response.json();

        const container = document.querySelector("#message");
        container.textContent = jsonResponse.message;

        if (
          jsonResponse.message ==
          "Inscription réussie. Vous allez être redirigé(e)."
        ) {
          container.setAttribute("class", "alert alert-success");
          setTimeout(function () {
            window.location.href = "connexion.php";
          }, 2000);
        } else {
          container.setAttribute("class", "alert alert-danger");
        }
      });
    }
  } catch (error) {
    console.error("Une erreur s'est produite :", error);
  }
}

displayRegisterUserMessage();

async function displayAddListMessage() {
  try {
    if (window.location.href.endsWith("lists.php")) {
      const response = await fetch("lists.php");
      const content = await response.text();

      const addListBtn = document.querySelector("#addListBtn");
      const form = document.querySelector("#addListForm");

      addListBtn.addEventListener("click", async function (event) {
        event.preventDefault();
        const data = new FormData(form);
        data.append("submitAddListForm", "");

        const response = await fetch("lists.php", {
          method: "POST",
          body: data,
        });

        const jsonResponse = await response.json();

        const container = document.querySelector("#message");
        container.textContent = jsonResponse.message;

        if (jsonResponse.message == "Votre liste a bien été créée.") {
          container.setAttribute("class", "alert alert-success");
          setTimeout(function () {
            window.location.href = "lists.php";
          }, 1300);
        } else {
          container.setAttribute("class", "alert alert-danger");
        }
      });
    }
  } catch (error) {
    console.error("Une erreur s'est produite :", error);
  }
}

displayAddListMessage();

async function addTasksAndDisplayMessage() {
  if (window.location.href.endsWith("lists.php")) {
    const addTaskBtns = document.querySelectorAll(".addTaskBtn");

    addTaskBtns.forEach((button) => {
      button.addEventListener("click", async function (event) {
        event.preventDefault();

        const listId = button.getAttribute("data-list-id");
        const tasksContainer = document.querySelector(
          `#tasksContainer-${listId}`
        );
        const newTaskNameInput = document.querySelector(
          `#newTaskName-${listId}`
        );
        const dueDateNewTaskInput = document.querySelector(
          `#dueDateNewTask-${listId}`
        );
        const newTaskName = newTaskNameInput.value;
        const dueDateNewTask = dueDateNewTaskInput.value;

        const formData = new FormData();
        formData.append("addTaskBtn", "true");
        formData.append("newTaskName", newTaskName);
        formData.append("dueDateNewTask", dueDateNewTask);
        formData.append("postId", listId);

        const response = await fetch("lists.php", {
          method: "POST",
          body: formData,
        });

        const jsonResponse = await response.json();

        const container = document.querySelector("#message");
        container.textContent = jsonResponse.message;

        if (jsonResponse.message == "La tâche a bien été ajoutée.") {
          container.setAttribute("class", "alert alert-success");
          const task = document.createElement("p");
          task.textContent = newTaskName;
          tasksContainer.appendChild(task);

          const taskDueDate = document.createElement("span");
          taskDueDate.textContent = " Due date : " + dueDateNewTask;
          task.appendChild(taskDueDate);

          const deleteTaskBtn = document.createElement("button");
          deleteTaskBtn.setAttribute("class", "fa-solid fa-trash");
          task.appendChild(deleteTaskBtn);

          const taskStatus = document.createElement("input");
          taskStatus.type = "checkbox";
          task.appendChild(taskStatus);
        } else {
          container.setAttribute("class", "alert alert-danger");
        }
      });
    });
  }
}

addTasksAndDisplayMessage();
