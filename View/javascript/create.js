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

      const tasksContainer = document.createElement("ul");
      tasksContainer.setAttribute("id", `tasksContainer-${listId}`);
      oneListContainer.appendChild(tasksContainer);

      const form = document.createElement("form");
      form.setAttribute("action", "");
      form.setAttribute("method", "POST");
      form.setAttribute("class", "addTaskForm");
      form.setAttribute("data-list-id", listId); // Ajoutez un attribut data-list-id pour identifier ce formulaire
      oneListContainer.appendChild(form);

      const taskInput = document.createElement("input");
      taskInput.setAttribute("type", "text");
      taskInput.setAttribute("class", "form-control");
      taskInput.setAttribute("id", `newTaskName-${listId}`);
      taskInput.setAttribute("name", `newTaskName-${listId}`);
      taskInput.setAttribute("placeholder", "Ajouter une tâche");
      form.appendChild(taskInput);

      const taskDueDateInput = document.createElement("input");
      taskDueDateInput.setAttribute("type", "date");
      taskDueDateInput.setAttribute("class", "form-control");
      taskDueDateInput.setAttribute("id", `dueDateNewTask-${listId}`);
      taskDueDateInput.setAttribute("name", `dueDateNewTask-${listId}`);
      form.appendChild(taskDueDateInput);

      const addTaskBtn = document.createElement("button");
      addTaskBtn.setAttribute("type", "button");
      addTaskBtn.setAttribute("name", "addTaskBtn");
      addTaskBtn.setAttribute("class", "btn btn-primary addTaskBtn");
      addTaskBtn.setAttribute("data-list-id", listId);
      form.appendChild(addTaskBtn);

      const plusIcon = document.createElement("i");
      plusIcon.setAttribute("class", "fa-solid fa-plus");
      addTaskBtn.appendChild(plusIcon);

      displayDeleteListMessage();
      addTasksAndDisplayMessage();

      console.log(listId);
      console.log(oneListContainer);
      getListTasks(listId);
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

async function getListTasks(listId) {
  if (window.location.href.endsWith("lists.php")) {
    const tasksResponse = await fetch("lists.php?getListTasks&id=" + listId);
    const jsonTasks = await tasksResponse.json();

    console.log(jsonTasks);

    jsonTasks.forEach((task) => {
      const tasksContainer = document.querySelector(
        `#tasksContainer-${listId}`
      );

      const oneTaskContainer = document.createElement("li");
      oneTaskContainer.textContent = task.name;
      tasksContainer.appendChild(oneTaskContainer);
    });
  }
}

async function addTasksAndDisplayMessage() {
  if (window.location.href.endsWith("lists.php")) {
    const addTaskBtns = document.querySelectorAll(".addTaskBtn");

    addTaskBtns.forEach((button) => {
      button.addEventListener("click", async function (event) {
        event.preventDefault();

        const listId = form.getAttribute("data-list-id");
        let tasksContainer = document.querySelector(
          `#tasksContainer-${listId}`
        );
        let newTaskNameInput = document.querySelector(`#newTaskName-${listId}`);
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

        console.log(jsonResponse);

        const container = document.querySelector("#message");
        container.textContent = jsonResponse.message;

        let taskId = jsonResponse.taskId;

        if (jsonResponse.message == "La tâche a bien été ajoutée.") {
          container.setAttribute("class", "alert alert-success");

          refreshMessages();

          updateTaskStatus();
        } else {
          container.setAttribute("class", "alert alert-danger");
          refreshMessages();
        }
      });
    });
  }
}
