document.todo = {
  tasks : [],
  add: function(text,date) {
    this.tasks.push({text: text, date: date});
  },

  filter: function(){
  const filtered = [];
    const filter = document.getElementById('search').value.toLowerCase();

    for(let i = 0; i < document.todo.tasks.length; i++){
      let task = document.todo.tasks[i].text.toLowerCase();

      if (task.includes(filter)){
        filtered.push(document.todo.tasks[i]);
      }

      this.draw(filtered);
    }
  },

  draw: function(arr = document.todo.tasks) {
    const record = document.querySelector('#task-list');
    const searchPhrase = document.getElementById("search").value;
    record.innerHTML = ``;
    for (let i = 0; i < arr.length; i++) {
      let TextFromWord = arr[i].text;

      if(searchPhrase !== ""){
        const regex = RegExp(`(${searchPhrase})`, 'gi');
        TextFromWord = TextFromWord.replace(regex, `<span class="highlight">$1</span>`)
      }

      record.innerHTML += `
        <div class="task" id="task${i}">
            <span>
                <b>${TextFromWord}</b> - <b>${arr[i].date}</b>
             </span>

             <button onclick="document.todo.edit(${i})" class="btn">
                <img class="delete" src="./assets/pen.png" alt="" >
             </button>

             <button class="btn" onclick="document.todo.del(${i})" >
             <img src="./assets/del.png" class="delete" alt="">
             </button>

        </div>`;
    }
  },

  del: function (toDelete) {
    let searchText = document.getElementById("search").value;
    document.todo.tasks.splice(toDelete,1);
    if(document.todo.tasks.length === 0){
      alert("Wyczyszczono liste");
    }
    if(searchText === ""){
      document.todo.draw();
    }
    if(searchText !== "" && document.todo.tasks.length > 0){
      document.todo.filter(searchText);
      document.todo.draw();
    }
    localStorage.setItem('Taski', JSON.stringify(document.todo.tasks));
    document.todo.draw();
  },

  edit: function(elementNr){
    let searchText = document.getElementById("search").value;
    let newText = document.getElementById("dodaj-text").value;
    let newDate = document.getElementById("dodaj-date").value;

    if(newText === document.todo.tasks[elementNr].text && newDate === document.todo.tasks[elementNr].date){
          alert("Nic sie nie zmienilo, zmien wartosci w polach ponizej i wtedy edytuj.");
    }else{
      document.todo.tasks[elementNr].text = newText;
      document.todo.tasks[elementNr].date = newDate;
      if(searchText === ""){
        document.todo.draw();
      }else{
        document.todo.draw();
        document.todo.filter(searchText);
      }
    }
    localStorage.setItem('Taski', JSON.stringify(document.todo.tasks));
  },

}


class Task{
  constructor(text,date){
    this.text = text;
    this.date = date;
  }
}

const buttonAdd = () => {
  let sentText = document.getElementById("dodaj-text").value;
  let sentDate = document.getElementById("dodaj-date").value;
  someEvent = new Task;
  someEvent.text = sentText;
  someEvent.date = sentDate;
  document.todo.add(someEvent.text,someEvent.date);
  document.todo.draw(document.todo.tasks);
  localStorage.setItem('Taski', JSON.stringify(document.todo.tasks));
}
LocalData = localStorage.getItem('Taski');
if(LocalData){
  document.todo.tasks = JSON.parse(LocalData);
}else{
  document.todo.tasks = [];
}

document.todo.draw();
