function updateGreeting() {
  const hourElement = document.querySelector(".hour");
  const imgElement = document.querySelector("img");
  const bodyElement = document.body;
  const currentHour = new Date().getHours();
  let greeting, imgSrc, bgColor;

  if (currentHour < 12) {
    greeting = `Bom dia! São ${currentHour} horas`;
    imgSrc = "dia.jpg";
    imgElement.style.borderRadius = "200px";
    imgElement.style.width = "250px";
    imgElement.style.height = "250px";
    bgColor = "#FFFAE3";
  } else if (currentHour < 18) {
    greeting = `Boa Tarde! são ${currentHour} horas`;
    imgSrc = "tarde.jpg";
    imgElement.style.borderRadius = "200px";
    imgElement.style.width = "250px";
    imgElement.style.height = "250px";
    bgColor = "#FFE4B5";
  } else if(currentHour >=18 && currentHour <= 23){
    greeting = `Boa Noite! são ${currentHour} horas`;
    imgSrc = "noite.jpg";
    imgElement.style.borderRadius = "200px";
    imgElement.style.width = "250px";
    imgElement.style.height = "250px";
    bgColor = "#2F4F4F";
  }
  else if(currentHour > 23){ 
    alert("Hora inesistente")
  }

  hourElement.textContent = greeting;
  imgElement.src = imgSrc;
  bodyElement.style.backgroundColor = bgColor;
}
document.querySelector("footer").style.display = "none";

document
  .querySelector('a[href=""]')
  .addEventListener("click", function (event) {
    event.preventDefault();
    document.querySelector("footer").style.display = "block";
  });

document.querySelector("button").addEventListener("click", function () {
  const inputHour = parseInt(document.querySelector("input").value);
  const hourElement = document.querySelector(".hour");
  const imgElement = document.querySelector("img");
  const bodyElement = document.body;
  let greeting, imgSrc, bgColor;

  if (inputHour < 12) {
    greeting = `Bom Dia! são ${inputHour} horas`;
    imgSrc = "dia.jpg";
    imgElement.style.width = "250px";
    imgElement.style.height = "250px";
    bgColor = "#FFFAE3";
  } else if (inputHour < 18) {
    greeting = `Boa Tarde! são ${inputHour} horas`;
    imgSrc = "tarde.jpg";
    imgElement.style.width = "50px";
    imgElement.style.height = "50px";
    bgColor = "#FFE4B5";
  } else if(inputHour >=18 && inputHour <= 23) {
    greeting = `Boa Noite! são ${inputHour} horas`;
    imgSrc = "noite.jpg";
    imgElement.style.width = "250px";
    imgElement.style.height = "250px";
    bgColor = "#2F4F4F";
  }
  else if(inputHour >  23){
    alert("Hora inesistente")
  }

  hourElement.textContent = greeting;
  imgElement.src = imgSrc;
  bodyElement.style.backgroundColor = bgColor;
});
updateGreeting();
