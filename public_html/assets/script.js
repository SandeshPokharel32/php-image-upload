var currentPhoto = 0;
var photos = document.querySelectorAll('.gallery img');
const showPhoto = (index) => {
  for (var i = 0; i < photos.length; i++) {
    photos[i].classList.remove('active');
  }
  photos[index].classList.add('active');
};

const nextPhoto = () => {
  currentPhoto++;
  if (currentPhoto >= photos.length) {
    currentPhoto = 0;
  }
  showPhoto(currentPhoto);
};

const prevPhoto = () => {
  currentPhoto--;
  if (currentPhoto < 0) {
    currentPhoto = photos.length - 1;
  }
  showPhoto(currentPhoto);
};
