async function displayLoginUserMessage() {
  try {
    if (window.location.href.endsWith("connexion.php")) {
      const response = await fetch("connexion.php");
      const content = await response.text();

      const signInBtn = document.querySelector("#signInBtn");
      const form = document.querySelector("#loginForm");

      signInBtn.addEventListener("click", async function (event) {
        event.preventDefault();
        const data = new FormData(form);
        data.append("submitForm", "");

        const response = await fetch("connexion.php", {
          method: "POST",
          body: data,
        });

        const jsonResponse = await response.json();

        const container = document.querySelector("#message");
        container.textContent = jsonResponse.message;

        if (
          jsonResponse.message ==
          "Connexion réussie. Vous allez être redirigé(e)."
        ) {
          container.setAttribute("class", "alert alert-success");
          setTimeout(function () {
            window.location.href = "index.php";
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

displayLoginUserMessage();

async function getUserLists() {
  if (window.location.href.endsWith("lists.php")) {
    const response = await fetch("lists.php?getUserLists");
    const jsonLists = await response.json();

    const listsContainer = document.querySelector("#listsContainer");

    jsonLists.forEach((list) => {
      const oneListContainer = document.createElement("li");
      oneListContainer.textContent = list.name;
      listsContainer.appendChild(oneListContainer);

      let listId = list.id;
      getListsTasks(listId, oneListContainer);
    });
  }
}

async function getListsTasks(listId, listContainer) {
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

getUserLists();
