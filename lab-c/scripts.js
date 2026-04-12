let map = L.map('map').setView([53.430127, 14.564802], 18);
L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
  crossOrigin: true
}).addTo(map);


document.getElementById("getCurrLocation").addEventListener("click", getLocation);

function getLocation(){
  navigator.geolocation.getCurrentPosition(position => {
    let x = position.coords.longitude;
    let y = position.coords.latitude;
    map.setView([y, x]);
    let marker = L.marker([y, x]).addTo(map);
    marker.bindPopup("Your localization");
    document.getElementById("x").innerHTML = "X: " + x;
    document.getElementById("y").innerHTML = "Y: " + y;
  });
}

document.getElementById("saveCurrentMap").addEventListener("click", function (){
  document.getElementById("mapSaved").innerHTML = "";
  document.getElementById("puzzleDragDrop").innerHTML = "";

  leafletImage(map, function (err, rasterMapCanvas) {
    let puzzleWidth = rasterMapCanvas.width / 4;
    let puzzleHeight = rasterMapCanvas.height / 4;

    for(let i = 0; i < 4; i++){
      for(let j = 0; j < 4; j++){
        let x = j * puzzleWidth;
        let y = i * puzzleHeight;

        let puzzlePiece = document.createElement('canvas');
        puzzlePiece.width = puzzleWidth;
        puzzlePiece.height = puzzleHeight;
        puzzlePiece.className = "puzzle";
        puzzlePiece.draggable = true;
        puzzlePiece.id = i + "-" + j;
        puzzlePiece.style.order = Math.floor(Math.random() * 100);

        puzzlePiece.addEventListener("dragstart", function (event){
          event.dataTransfer.setData("text", puzzlePiece.id);
        });

        let puzzleContext = puzzlePiece.getContext("2d");
        puzzleContext.drawImage(rasterMapCanvas,
          x, y, puzzleWidth, puzzleHeight,
          0, 0, puzzleWidth, puzzleHeight);
        document.getElementById("mapSaved").appendChild(puzzlePiece);

        let dropDiv = document.createElement("div");
        dropDiv.id = "place" + i + "-" + j;
        dropDiv.className = "dropspots";

        dropDiv.addEventListener("dragover", function(event){
          event.preventDefault();
        });

        dropDiv.addEventListener("drop", function(event){
          event.preventDefault();
          let draggedPuzzleId = event.dataTransfer.getData("text");
          let canvasWithPuzzle = document.getElementById(draggedPuzzleId);
          console.log(event.target);
          console.log("puzel o id", draggedPuzzleId);
          console.log("znaleziony", canvasWithPuzzle);
          if(event.target.classList.contains("dropspots") === true){
            if(event.target.children.length === 0){
              event.target.appendChild(canvasWithPuzzle);
            }
          }else{
            if(event.target.children.length > 0){
              alert("miejsce zajete");
            }
          }
          checkForWin();
        });

        document.getElementById("puzzleDragDrop").appendChild(dropDiv);
      }
    }
  });
  //document.getElementById("map").innerHTML = "";
});


function checkForWin() {
  let win = true;
  for(let i = 0; i < 4; i++){
    for(let j = 0; j < 4; j++){
      let spaceNumber = document.getElementById("place" + i + "-" + j);
      if(spaceNumber.children.length !== 0){
        if(spaceNumber.firstElementChild.id !== i + "-" + j){
          win = false;
          console.log("wrong place")
        }
      }else if (spaceNumber.children.length === 0){
        win = false;
      }
    }
  }
  if(win === true){
    notifyme("Congratulations, you won!");
    console.log("win");
  }
}



document.getElementById("Notif").addEventListener("click", notifyme);

async function notifyme(notificationText) {
  if (Notification.permission === "default") {
    await Notification.requestPermission();
  }
  if(Notification.permission === "granted") {
    await new Notification("Puzzle game", {body: notificationText});
  }
}








