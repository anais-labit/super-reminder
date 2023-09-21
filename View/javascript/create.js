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

async function displayAddTaskMessage() {
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

displayAddTaskMessage();
