async function displayDeleteUserMessage() {
  try {
    if (window.location.href.endsWith("profil.php")) {
      const response = await fetch("profil.php");
      const content = await response.text();

      const deleteBtn = document.querySelector("#deleteButton");
      const form = document.querySelector("#deleteForm");

      deleteBtn.addEventListener("click", async function (event) {
        event.preventDefault();
        const data = new FormData(form);
        data.append("deleteForm", "");

        console.log(data);

        const response = await fetch("profil.php?delete", {
          method: "POST",
          body: data,
        });

        const jsonResponse = await response.json();

        const container = document.querySelector("#message");
        container.textContent = jsonResponse.message;
        container.setAttribute("class", "alert alert-success");

        setTimeout(function () {
          window.location.href = "index.php";
        }, 2000);
      });
    }
  } catch (error) {
    console.error("Une erreur s'est produite :", error);
  }
}

displayDeleteUserMessage();

async function displayDeleteListMessage() {
  if (window.location.href.endsWith("lists.php")) {
    try {
      const deleteListBtns = document.querySelectorAll(".deleteListBtns");

      return new Promise(async (resolve, reject) => {
        deleteListBtns.forEach((button) => {
          button.addEventListener("click", async (event) => {
            event.preventDefault();
            const listId = button.getAttribute("id");
            const url = "lists.php?deleteList=" + listId;
            const request = new Request(url, { method: "DELETE" });
            try {
              const responseData = await fetch(request);
              if (responseData.ok) {
                const jsonResponse = await responseData.json();

                const container = document.querySelector("#message");
                container.setAttribute("class", "alert alert-success");
                container.textContent = jsonResponse.message;

                // const listsContainer =
                //   document.querySelector("#listsContainer");
                // listsContainer.innerHTML = "";

                const listToRemove = document.querySelector(`#list-${listId}`);
                if (listToRemove) {
                  listToRemove.remove();
                }
                refreshMessages();

                resolve(true); // Résoudre la promesse avec true si tout s'est bien passé
              } else {
                reject("Échec de la suppression de la liste");
                container.setAttribute("class", "alert alert-danger");

                refreshMessages();
              }
            } catch (error) {
              reject(error);
            }
          });
        });
      });
    } catch (error) {
      console.error("Une erreur s'est produite :", error);
      return false; // Renvoyer false en cas d'erreur
    }
  }
}
displayDeleteListMessage();
