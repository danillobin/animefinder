window.addEventListener("load", (event) => {
  const countMatchesNODE = document.querySelector(".foundblocks-container .count-showed");
  let countMatches = parseInt(document.querySelector(".foundblocks-container .count-showed").innerHTML);
  const foundblocksContainer = document.querySelector(".foundblocks-container");
  const params = new URLSearchParams(location.search);
  let title = params.get("title") || 1;
  let page = params.get("page") || 1;
  const MOREBUTTON = document.querySelector(".more-button");
  MOREBUTTON.addEventListener("click", function(){
    const xhr = new XMLHttpRequest();
    xhr.open("POST", `/find?title=${title}&page=${page+1}`, true);

    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = () => { // Call a function when the state changes.
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        var parser = new DOMParser();
        var doc = parser.parseFromString(xhr.responseText, 'text/html');
        var matches = doc.querySelectorAll(".foundblocks-container li");
        if(matches.length){
          foundblocksContainer.append(...Array.from(matches));
          page++;
          countMatches = countMatches + matches.length;
          countMatchesNODE.innerHTML = countMatches;
        }else{
          alert("Nothing found");
        }
      }
    }
    xhr.send();
  })
});