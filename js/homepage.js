document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        // Get the target element
        const target = document.querySelector(this.getAttribute('href'));

        // Scroll to the target element
        target.scrollIntoView({
            behavior: 'smooth'
        });
    });
});




/*for animation*/

const animateOnVisit = document.querySelectorAll('.animate-on-visit');

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('animate__animated', 'animate__' + entry.target.dataset.aos);
    }
  });
});

animateOnVisit.forEach(animate => {
  observer.observe(animate);
});
