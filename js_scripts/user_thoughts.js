$("#thoughts_container").html("");

getThoughts("user", "date", "desc")
    .then(thoughts => {
        for (const thought of thoughts) {
            $("#thoughts_container").append(createThoughtDiv(thought, false, true));
        }
    })
    .then(function() {
        setNumThoughts();
    });

document.forms[0].addEventListener("submit", function(event) {
    event.preventDefault();

    const thoughtText = $("#thoughtTxt").val();

    recordThought(thoughtText);
});

// Functions
function recordThought(text) {
    recordThoughtToDB(text)
        .then(result => {
            console.log(result.success);
            if (result.success) {
                $("#success_message").html("");
                $("#thoughtTxt").val("");
                
                $("#thoughts_container").prepend(createThoughtDiv(result.thought, true, true));
            } else {
                $("#success_message").html("Oops, there was a problem and the thought wasn't registered. Did you really have that thought?");
            }
        })
        .then(function() {
            setNumThoughts();
        });
}
function recordThoughtToDB(text) {
    return fetch("./php_scripts/record_thought_to_db.php?thought_text=" + text)
        .then(response => response.json())
        .then(result => result);
}