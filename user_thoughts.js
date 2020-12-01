const thoughtList = document.getElementById("thoughtListDiv");
document.getElementById("allThoughtsBtn").addEventListener("click", function() {
    thoughtList.innerHTML = "";

    getThoughts()
        .then(thoughts => {
            for (const thought of thoughts) {
                const div = document.createElement("p");
                div.innerHTML = "I... " + thought["thought_text"];
                thoughtList.appendChild(div);
            }
        });
});
document.getElementById("userThoughtsBtn").addEventListener("click", function() {
    thoughtList.innerHTML = "";

    getThoughts(true)
        .then(thoughts => {
            for (const thought of thoughts) {
                const div = document.createElement("p");
                div.innerHTML = "I... " + thought["thought_text"];
                thoughtList.appendChild(div);
            }
        });
});

async function getThoughts(justForUser) {
    let url = "./get_thoughts.php";
    if (justForUser) {
        url += "?for_user=true";
    }

    return fetch(url)
        .then(response => response.json())
        .then(result => result)
}