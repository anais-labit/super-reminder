async function displayRegistrationMessage() {
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

displayRegistrationMessage();

async function fetchUserLists() {
  if (window.location.href.endsWith("lists.php")) {
    const response = await fetch("lists.php?getUserLists");
    const jsonLists = await response.json();

    const listsContainer = document.querySelector("#listsContainer");

    const row = document.createElement("div");
    row.classList.add("row");

    jsonLists.forEach((list) => {
      let listId = list.id;

      const col = document.createElement("div");
      col.classList.add("col-md-4", "mb-4");

      const oneListContainer = document.createElement("div");
      oneListContainer.setAttribute("id", `list-${listId}`);
      oneListContainer.classList.add("card");

      const cardBody = document.createElement("div");
      cardBody.classList.add("card-body");

      const listTitle = document.createElement("h5");
      listTitle.classList.add("card-title");
      listTitle.textContent = list.name;

      cardBody.appendChild(listTitle);

      const cardFooter = document.createElement("div");
      cardFooter.classList.add("card-footer");

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

      cardBody.appendChild(deleteListButton);

      oneListContainer.appendChild(cardBody);
      oneListContainer.appendChild(cardFooter);

      const form = document.createElement("form");
      form.setAttribute("action", "");
      form.setAttribute("method", "POST");
      form.setAttribute("class", "addTaskForm");
      form.setAttribute("data-list-id", listId);
      oneListContainer.appendChild(form);

      const inputGroup = document.createElement("div");
      inputGroup.setAttribute("class", "input-group mx-auto");
      inputGroup.style.width = "95%";
      form.appendChild(inputGroup);

      const taskInput = document.createElement("input");
      taskInput.setAttribute("type", "text");
      taskInput.setAttribute("class", "form-control");
      taskInput.setAttribute("id", `newTaskName-${listId}`);
      taskInput.setAttribute("name", `newTaskName-${listId}`);
      taskInput.setAttribute("placeholder", "Ajouter une tâche");
      inputGroup.appendChild(taskInput);

      const taskDueDateInput = document.createElement("input");
      taskDueDateInput.setAttribute("type", "date");
      taskDueDateInput.setAttribute("class", "form-control");
      taskDueDateInput.setAttribute("id", `dueDateNewTask-${listId}`);
      taskDueDateInput.setAttribute("name", `dueDateNewTask-${listId}`);
      inputGroup.appendChild(taskDueDateInput);

      const addTaskBtn = document.createElement("button");
      addTaskBtn.setAttribute("type", "button");
      addTaskBtn.setAttribute("name", "addTaskBtn");
      addTaskBtn.setAttribute("class", "btn-primary addTaskBtn");
      addTaskBtn.setAttribute("data-list-id", listId);
      inputGroup.appendChild(addTaskBtn);

      const plusIcon = document.createElement("i");
      plusIcon.setAttribute("class", "fa-solid fa-xs fa-plus");
      addTaskBtn.appendChild(plusIcon);

      const tasksContainer = document.createElement("ul");
      tasksContainer.setAttribute("id", `tasksContainer-${listId}`);
      oneListContainer.appendChild(tasksContainer);

      displayDeleteListMessage();

      col.appendChild(oneListContainer);
      row.appendChild(col);
      fetchListTasks(listId);
    });

    listsContainer.appendChild(row);
    displayDeleteListMessage();
    addTasksAndDisplayMessage();
  }
}

refreshUserLists();

async function refreshUserLists() {
  await fetchUserLists();
  let onDelete = await displayDeleteListMessage();

  if (onDelete) {
    const listsContainer = document.querySelector("#listsContainer");
    listsContainer.innerHTML = "";
    await refreshUserLists();
  }
}

async function addListsAndDisplayMessage() {
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

            if (jsonResponse.message === "Liste créée !") {
              container.setAttribute("class", "alert alert-success");
              refreshMessages();
              const listsContainer = document.querySelector("#listsContainer");
              listsContainer.textContent = "";
              fetchUserLists();
            } else {
              container.setAttribute("class", "alert alert-danger");
              displayDeleteListMessage();
              refreshMessages();
            }
          }
        } catch (error) {
          console.error("Une erreur s'est produite :", error);
        }
      });
    } catch (error) {
      console.error("Une erreur s'est produite :", error);
    }
  }
}

addListsAndDisplayMessage();

async function fetchListTasks(listId) {
  if (window.location.href.endsWith("lists.php")) {
    const tasksResponse = await fetch("lists.php?getListTasks&id=" + listId);
    const jsonTasks = await tasksResponse.json();

    console.log(jsonTasks);

    jsonTasks.forEach((task) => {
      const tasksContainer = document.querySelector(
        `#tasksContainer-${listId}`
      );

      const oneTaskContainer = document.createElement("li");
      tasksContainer.appendChild(oneTaskContainer);

      let taskId = task.id;

      const taskName = document.createElement("span");
      taskName.textContent = task.name;
      taskName.setAttribute("id", `taskName-${taskId}`);
      taskName.style.marginRight = "10px";
      oneTaskContainer.appendChild(taskName);

      const taskDueDate = document.createElement("span");
      taskDueDate.textContent = " Due date : " + formatDate(task.due_date);
      console.log(task.due_date);
      taskDueDate.setAttribute("id", `taskDueDate-${taskId}`);
      oneTaskContainer.appendChild(taskDueDate);

      const taskStatusForm = document.createElement("form");
      taskStatusForm.setAttribute("class", "checkTaskForm");
      taskStatusForm.setAttribute("action", "");
      taskStatusForm.setAttribute("method", "POST");
      oneTaskContainer.appendChild(taskStatusForm);

      const taskStatusBtn = document.createElement("button");
      taskStatusBtn.setAttribute("class", "btn-primary small-checkTaskBtn");
      taskStatusBtn.setAttribute("type", "button");
      taskStatusBtn.setAttribute("name", "checkTaskBtn");
      taskStatusBtn.style.marginRight = "10px";

      taskStatusBtn.setAttribute("data-task-id", taskId);

      let taskStatus = task.status;
      taskStatusBtn.setAttribute("value", taskStatus);
      taskStatusForm.appendChild(taskStatusBtn);

      let i = document.createElement("i");
      i.setAttribute("class", "fa-solid fa-xs fa-check");
      taskStatusBtn.appendChild(i);
    });
  }
}

async function addTasksAndDisplayMessage() {
  if (window.location.href.endsWith("lists.php")) {
    const addTaskBtns = document.querySelectorAll(".addTaskBtn");

    addTaskBtns.forEach((button) => {
      button.addEventListener("click", async function (event) {
        event.preventDefault();

        const clickedButton = event.target;
        const form = clickedButton.closest("form");

        const listId = form.getAttribute("data-list-id");

        let newTaskNameInput = document.querySelector(`#newTaskName-${listId}`);
        let dueDateNewTaskInput = document.querySelector(
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

        if (jsonResponse.message == "Tâche ajoutée !") {
          container.setAttribute("class", "alert alert-success");

          const tasksContainer = document.querySelector(
            `#tasksContainer-${listId}`
          );
          const oneTaskContainer = document.createElement("li");

          const taskName = document.createElement("span");
          taskName.textContent = newTaskName;
          taskName.style.marginRight = "10px";
          taskName.setAttribute("id", `taskName-${taskId}`);
          oneTaskContainer.appendChild(taskName);

          const taskDueDate = document.createElement("span");
          taskDueDate.textContent = "Due date : " + formatDate(dueDateNewTask);
          taskDueDate.setAttribute("id", `taskDueDate-${taskId}`);
          oneTaskContainer.appendChild(taskDueDate);

          const taskStatusForm = document.createElement("form");
          taskStatusForm.setAttribute("class", "checkTaskForm");
          taskStatusForm.setAttribute("action", "");
          taskStatusForm.setAttribute("method", "POST");
          oneTaskContainer.appendChild(taskStatusForm);

          const taskStatusBtn = document.createElement("button");
          taskStatusBtn.setAttribute("class", "btn-primary small-checkTaskBtn");
          taskStatusBtn.setAttribute("type", "button");
          taskStatusBtn.setAttribute("name", "checkTaskBtn");
          taskStatusBtn.setAttribute("data-task-id", taskId);

          let taskStatus = jsonResponse.status;
          taskStatusBtn.setAttribute("value", taskStatus);
          taskStatusBtn.style.marginRight = "10px";
          taskStatusForm.appendChild(taskStatusBtn);

          let i = document.createElement("i");
          i.setAttribute("class", "fa-solid fa-xs fa-check");
          taskStatusBtn.appendChild(i);

          tasksContainer.appendChild(oneTaskContainer);

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
