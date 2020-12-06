const thoughtList = document.getElementById("thought_container");
thoughtList.innerHTML = "";

getThoughts("date", "desc", true)
    .then(thoughts => {
        for (const thought of thoughts) {
            thoughtList.appendChild(createThoughtDiv(thought, false, true));
        }
    });

document.forms[0].addEventListener("submit", function(event) {
    event.preventDefault();

    const thoughtText = document.getElementById("thought_text").value;
    recordThought(thoughtText);
});

// Functions
function recordThought(text) {
    recordThoughtToDB(text)
    .then(result => {
        console.log("RESULT: " + result);
        if (result.success) {
            document.getElementById("success_message").innerHTML = "";
            document.getElementById("thought_text").value = "";
            
            thoughtList.appendChild(createThoughtDiv(result.thought, true, true));
        } else {
            document.getElementById("success_message").innerHTML = "Oops, there was a problem and the thought wasn't registered. Did you really have that thought?";
        }
    });
}
function recordThoughtToDB(text) {
    return fetch("./php_scripts/record_thought_to_db.php?thought_text=" + text)
        .then(response => response.json())
        .then(result => result);
}