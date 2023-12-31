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

async function refreshMessages() {
  setTimeout(function () {
    const container = document.querySelector("#message");
    container.textContent = "";
    container.removeAttribute("class");
  }, 1300);
}

function formatDate(dateString) {
  const options = { day: "2-digit", month: "2-digit", year: "numeric" };
  return new Date(dateString).toLocaleDateString("fr-FR", options);
}
