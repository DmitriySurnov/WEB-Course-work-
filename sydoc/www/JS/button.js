  $(".null").hide()
$(".grid-item-numbers").attr('disabled', true);
for (let element of $(".grid-item-numbers")){
    hideButton(element)
}

$("#clear").click(() => {
    for (let element of $(".grid-item")) {
        if (element.classList.contains("error")){
            element.innerText = ""
            element.classList.remove("error")
            ClicCell(element);
        }

    }
})

  function ClicCell(event) {
      $(".grid-item").css("background", "")
      $(".grid-item-numbers").attr('disabled', true);
      if (event.innerText == "" || event.classList.contains("error")) {
          $(".grid-item-numbers").attr('disabled', false);
          if (event.classList.contains("error"))
              highlight(event)
          event.style.background = "#6d6969";
          return
      }
      highlight(event)
  }

$(".grid-item").on("click", (event) => {
    console.log(event.target.id)
    ClicCell(event.target);
})

function highlight(event) {
    for (let element of $(".grid-item")) {
        if (element.innerText == event.innerText)
            element.style.background = "blue";
    }
}

function hideButton(event){
    let count = 0;
    for (let element of $(".grid-item")){
        if (element.innerText == event.innerText && !element.classList.contains("error") ){
            count++;
            if (count == 9){
                event.style.display ="none"
                return;
            }
        }
    }
}

 async function request(element, event){
     await $.ajax({
         type: 'GET',
         url: 'http://localhost/www/IP/CheckingNumbers.php?id='+ element.id + '&number=' + event.target.innerText,
         success: function (result) {
             if (result == "false")
                 element.classList.add("error")
             else {
                 element.classList.remove("error")
                 $(".grid-item-numbers").attr('disabled', true);
             }
         }
     })
 }

$(".grid-item-numbers").on("click", (event) => {
    for (let element of $(".grid-item")){
        if(element.style.background  == "rgb(109, 105, 105)"){
            request(element,event).then( () => {
                $(".grid-item").css("background", "")
                element.innerText = event.target.innerText
                highlight(event.target)
                hideButton(event.target)
            })
            break;
        }
    }
})
