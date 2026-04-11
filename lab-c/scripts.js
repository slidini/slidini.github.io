let map = L.map('map').setView([53.430127, 14.564802], 18);
L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
  crossOrigin: true
}).addTo(map);

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
        puzzlePiece.id = "piece-" + i + "-" + j;

        puzzlePiece.addEventListener("dragstart", function (event){
          event.dataTransfer.setData("target", event.target.id)
        })

        let puzzleContext = puzzlePiece.getContext("2d");
        puzzleContext.drawImage(rasterMapCanvas,
          x, y, puzzleWidth, puzzleHeight,
          0, 0, puzzleWidth, puzzleHeight);
        document.getElementById("mapSaved").appendChild(puzzlePiece);
      }
    }
  });
});

let puzzleDropZone = document.getElementById("puzzleDragDrop");

puzzleDropZone.addEventListener("dragover", function (event) {
  event.preventDefault();
});

puzzleDropZone.addEventListener("drop", function (event) {
  event.preventDefault();
  let data = event.dataTransfer.getData("target");
  let piece = document.getElementById(data);
  event.target.appendChild(piece);
})



document.getElementById("Notif").addEventListener("click", notifyme)

async function notifyme() {
  if (Notification.permission === "granted"){
    const NewNotification = new Notification("Good job!");
  }else if(Notification.permission === "denied"){
    await Notification.requestPermission();
    const NewNotification = new Notification("Good job!");
  }

}
