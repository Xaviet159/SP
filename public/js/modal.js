const modalToggle = document.querySelector('.modal-open');
console.log(modalToggle);
const showcase = document.querySelector('.showcase');


modalToggle.addEventListener('click', () => {
  menuToggle.classList.toggle('modal-toggle');
  showcase.classList.toggle('modal-toggle');
})