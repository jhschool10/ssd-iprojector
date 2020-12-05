// Init
const thoughtList = document.getElementById("thought_container");
thoughtList.innerHTML = "";

getThoughts(false, false)
    .then(thoughts => {
        for (const thought of thoughts) {
            thoughtList.appendChild(createThoughtDiv(thought, false));
        }
    });

// Listeners
document.getElementById("").addEventListener("click", function() {
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
document.getElementById("thought_container").addEventListener("click", function(event) {
    if (event.target.classList.contains("CLICKABLE-huzzah")) {
        const thoughtID = parseInt(event.target.getAttribute("data-id"));
        fetch("./php_scripts/huzzah.php?thought_id=" + thoughtID)
            .then(response => response.json())
            .then(status => {
                console.log(status);
                if (status.success) {
                    const currentHuzzahs = parseInt(event.target.nextElementSibling.textContent);
                    event.target.nextElementSibling.textContent = currentHuzzahs + 1;
                }
            })
    }
});