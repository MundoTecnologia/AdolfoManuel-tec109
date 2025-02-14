function addTask()
  {
    const taskInput = document.getElementById("taskInput")
    const taskList = document.getElementById("taskList")
   localStorage.setItem(taskInput,taskList)
    if(taskInput.value.trim() !== ""){
      const taskDiv = document.createElement("div")
      taskDiv.className = "task"
      
      const taskText = document.createElement("span")
      taskText.textContent = taskInput.value.trim()
      
      const deleteButton = document.createElement("button")
      deleteButton.className = "deleteButton"
      deleteButton.textContent = "Delete"
      deleteButton.addEventListener("click",()=>{
        taskDiv.remove()
      })
      taskDiv.appendChild(taskText)
      taskDiv.appendChild(deleteButton)
      taskList.appendChild(taskDiv)
      taskInput.value = ""
    }
  }
  function addTaskOnEnter(event){
    if(event.key === "Enter"){
      addTask()
    }
  }
  function higlightBorder(){
    document.getElementById("todoContainer").style.borderColor = "#34495e"
    
  }
  function reseteBorder(){
    document.getElementById("todoContainer").style.borderColor = "transparent"
  }
function getTodoList() {
  const todoListString = localStorage.getItem('todoList');
  return todoListString ? todoListString.split(',') : [];
}

function saveTodoList(todoList) {
  const todoListString = todoList.join(',');
  localStorage.setItem('todoList', todoListString);
}

const todoList = getTodoList();

todoList.push('Nova tarefa');

saveTodoList(todoList);