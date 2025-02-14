var div = document.querySelector("div");
console.log(div);

var tagLink = document.createElement("a");
tagLink.setAttribute("href", "http://www.google.com");

var textLink = document.createTextNode("Google");
tagLink.appendChild(textLink);

tagLink.style.color = 'red';
tagLink.style.backgroundColor = 'cyan'
tagLink.style.padding = '10px'

div.appendChild(tagLink);

var img = document.createElement("img");
img.setAttribute("src", "image0.png");
img.setAttribute("alt", "Example Image");
img.setAttribute("width", "400");

div.appendChild(img);

function AlterImage() {
  img.setAttribute("src", "Fashion blogging-pana.png");
}

// function AlterImage(){
//     if (img.getAttribute('src') === 'image0.png') {
//         img.setAttribute('src', 'Fashion blogging-pana.png');
//     } else {
//         img.setAttribute('src', 'image0.png');
//     }
//     }
//     div.addEventListener('click', AlterImage);
