// Init
const thoughtList = document.getElementById("thought_container");
thoughtList.innerHTML = "";

getThoughts("date", "desc", false)
    .then(thoughts => {
        for (const thought of thoughts) {
            thoughtList.appendChild(createThoughtDiv(thought, false));
        }
    });

// Listeners
document.getElementById("option_set_AllThoughts").addEventListener("click", function() {
    
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