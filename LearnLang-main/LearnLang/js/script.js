const element = document.querySelector('div,img,p');

// Create an IntersectionObserver instance
const observer = new IntersectionObserver((entries) => {
  // Check if the element is intersecting with the viewport
  const isIntersecting = entries[0].isIntersecting;

  // If the element is intersecting, play the animation
  if (isIntersecting) {
    element.style.animation = 'textAnimation 3s';
  }
}, { threshold: 1 });

// Observe the element
observer.observe(element);