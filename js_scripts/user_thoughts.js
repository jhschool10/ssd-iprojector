/**
 * This is the companion javascript to user_thoughts.php
 * Author: Joseph Haley
*/
$("document").ready(function() {

    // Variables

    // Init
    $("#thoughts_container").html("");

    getThoughts("user", "date", "desc")
        .then(thoughts => {
            for (const thought of thoughts) {
                $("#thoughts_container").append(createThoughtEle(thought, false, true));
            }
        })
        .then(function() {
            $("#num_thoughts").html(getNumThoughts());
        });

    // Listeners
    document.forms[0].addEventListener("submit", function(event) {
        event.preventDefault();

        const thoughtText = $("#thoughtTxt").val();

        recordThought(thoughtText);
    });
});