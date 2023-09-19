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

async function displayDeleteListMessage() {}
