async function displayUpdateUserMessage() {
  const reqUpdate = new FormData(updateForm);

  console.log(updateForm);
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
