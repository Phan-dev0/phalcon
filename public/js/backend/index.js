window.addEventListener("DOMContentLoaded", (event) => {
  const flashMessages = document.querySelectorAll(".flash-message");
  flashMessages.forEach((msg) => {
    setTimeout(() => {
      msg.classList.add("hide");
    }, 2000); 
  });
});
