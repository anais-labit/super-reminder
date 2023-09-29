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

async function getUserLists() {
  if (window.location.href.endsWith("lists.php")) {
    const response = await fetch("lists.php?getUserLists");
    const jsonLists = await response.json();

    const listsContainer = document.querySelector("#listsContainer");

    jsonLists.forEach((list) => {
      let listId = list.id;
      const oneListContainer = document.createElement("li");
      oneListContainer.setAttribute("id", `list-${listId}`);
      oneListContainer.classList.add(
        "list-group-item",
        "d-flex",
        "justify-content-between",
        "align-items-center"
      );

      const listTitle = document.createElement("span");
      listTitle.textContent = list.name;

      const deleteListButton = document.createElement("button");
      deleteListButton.classList.add(
        "btn",
        "btn-danger",
        "deleteListBtns",
        "ml-auto"
      );

      deleteListButton.setAttribute("id", listId);
      const i = document.createElement("i");
      i.setAttribute("class", "fa-solid fa-trash");
      deleteListButton.appendChild(i);

      oneListContainer.appendChild(listTitle);
      oneListContainer.appendChild(deleteListButton);
      listsContainer.appendChild(oneListContainer);

      displayDeleteListMessage();

      getListTasks(listId, oneListContainer);
    });
  }
}

refreshUserLists();

async function refreshUserLists() {
  await getUserLists();
  let onDelete = await displayDeleteListMessage();

  if (onDelete) {
    const listsContainer = document.querySelector("#listsContainer");
    listsContainer.innerHTML = "";
    await refreshUserLists();
  }
}

async function getListTasks(listId, listContainer) {
  if (window.location.href.endsWith("lists.php")) {
    const tasksResponse = await fetch("lists.php?getListTasks&id=" + listId);
    const jsonTasks = await tasksResponse.json();

    const ul = document.createElement("ul");
    listContainer.appendChild(ul);

    jsonTasks.forEach((task) => {
      const oneTaskContainer = document.createElement("li");
      oneTaskContainer.textContent = task.name;
      ul.appendChild(oneTaskContainer);
    });
  }
}

async function displayAddListMessage() {
  if (window.location.href.endsWith("lists.php")) {
    try {
      const addListBtn = document.querySelector("#addListBtn");
      const form = document.querySelector("#addListForm");
      const container = document.querySelector("#message");

      addListBtn.addEventListener("click", async function (event) {
        event.preventDefault();
        const data = new FormData(form);
        data.append("submitAddListForm", "submitAddListForm");

        try {
          const response = await fetch("lists.php", {
            method: "POST",
            body: data,
          });

          if (response.ok) {
            const jsonResponse = await response.json();
            container.textContent = jsonResponse.message;

            if (jsonResponse.message === "Votre liste a bien été créée.") {
              container.setAttribute("class", "alert alert-success");
              refreshMessages();
              const listsContainer = document.querySelector("#listsContainer");
              listsContainer.textContent = "";
              getUserLists();
            } else {
              container.setAttribute("class", "alert alert-danger");
              refreshMessages();
            }
          } else {
            throw new Error("Réponse HTTP non OK");
          }
        } catch (error) {
          console.error("Une erreur s'est produite :", error);
        }
      });
    } catch (error) {
      console.error(
        "Une erreur s'est produite lors de la recherche des éléments DOM :",
        error
      );
    }
  }
}

displayAddListMessage();

// async function addTasksAndDisplayMessage() {
//   if (window.location.href.endsWith("lists.php")) {
//     const addTaskBtns = document.querySelectorAll(".addTaskBtn");

//     addTaskBtns.forEach((button) => {
//       button.addEventListener("click", async function (event) {
//         event.preventDefault();

//         let listId = button.getAttribute("data-list-id");
//         let tasksContainer = document.querySelector(
//           `#tasksContainer-${listId}`
//         );
//         let newTaskNameInput = document.querySelector(`#newTaskName-${listId}`);
//         const dueDateNewTaskInput = document.querySelector(
//           `#dueDateNewTask-${listId}`
//         );

//         const newTaskName = newTaskNameInput.value;
//         const dueDateNewTask = dueDateNewTaskInput.value;

//         const formData = new FormData();
//         formData.append("addTaskBtn", "true");
//         formData.append("newTaskName", newTaskName);
//         formData.append("dueDateNewTask", dueDateNewTask);
//         formData.append("postId", listId);

//         const response = await fetch("lists.php", {
//           method: "POST",
//           body: formData,
//         });

//         const jsonResponse = await response.json();

//         const container = document.querySelector("#message");
//         container.textContent = jsonResponse.message;

//         let taskId = jsonResponse.taskId;

//         if (jsonResponse.message == "La tâche a bien été ajoutée.") {
//           container.setAttribute("class", "alert alert-success");

//           const task = document.createElement("p");
//           task.textContent = newTaskName;
//           task.setAttribute("id", `taskName-${taskId}`);
//           tasksContainer.appendChild(task);

//           const taskDueDate = document.createElement("span");
//           taskDueDate.textContent = " Due date : " + formatDate(dueDateNewTask);
//           task.appendChild(taskDueDate);

// const deleteTaskBtn = document.createElement("button");
// deleteTaskBtn.setAttribute("class", "fa-solid fa-trash");
// task.appendChild(deleteTaskBtn);

//           const taskStatusForm = document.createElement("form");
//           taskStatusForm.setAttribute("class", "checkTaskForm");
//           taskStatusForm.setAttribute("action", "");
//           taskStatusForm.setAttribute("method", "POST");

//           tasksContainer.appendChild(taskStatusForm);

//           const taskStatusBtn = document.createElement("button");
//           taskStatusBtn.setAttribute("class", "btn btn-primary checkTaskBtn");
//           taskStatusBtn.setAttribute("type", "submit");
//           taskStatusBtn.setAttribute("name", "checkTaskBtn");
//           taskStatusBtn.setAttribute("data-task-id", taskId);
//           let taskStatus = jsonResponse.status;
//           taskStatusBtn.setAttribute("value", taskStatus);
//           taskStatusForm.appendChild(taskStatusBtn);

//           let i = document.createElement("i");
//           i.setAttribute("class", "fa-solid fa-check");
//           taskStatusBtn.appendChild(i);

//           updateTaskStatus();
//         } else {
//           container.setAttribute("class", "alert alert-danger");
//         }
//       });
//     });
//   }
// }

// addTasksAndDisplayMessage();

// function formatDate(dateString) {
//   const options = { day: "2-digit", month: "2-digit", year: "numeric" };
//   return new Date(dateString).toLocaleDateString("fr-FR", options);
// }
