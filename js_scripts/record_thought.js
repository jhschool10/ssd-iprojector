document.forms[0].addEventListener("submit", function(event) {
    event.preventDefault();

    const thought_text = document.getElementById("thought_text").value;
    recordThought(thought_text);
});

function recordThought(text) {
    fetch("./php_scripts/record_thought_to_db.php?thought_text=" + text)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                document.getElementById("success_message").innerHTML = "You've successfully registered the thought: '" + text + ".'";
                document.getElementById("thought_text").value = "";
            } else {
                document.getElementById("success_message").innerHTML = "Failed to register the thought: '" + text + ".'";
            }
        })
}