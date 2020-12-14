/**
 * This is the companion javascript to user_thoughts.php
 * Author: Joseph Haley
*/
$("document").ready(function() {

    // Variables

    // Init
    $("#thoughts_container").html("");

    thoughts.recompileList("user", "date", "desc")
        .then(() => {
            for (const thought of thoughts.getList()) {
                $("#thoughts_container").append(createThoughtEle(thought, false, true));
            }
        })
        .then(function() {
            $("#num_thoughts").html(thoughts.count());
        });

    // Listeners
    document.forms[0].addEventListener("submit", function(event) {
        event.preventDefault();

        const thoughtText = $("#thoughtTxt").val();

        thoughts.recordOne(thoughtText)
            .then(thought => {
                if (thought === false) {
                    $("#success_message").html("Oops, there was a problem and the thought wasn't registered. Did you really have that thought?");
                } else {
                    $("#success_message").html("");
                    $("#thoughtTxt").val("");
                    
                    $("#thoughts_container").prepend(createThoughtEle(thought, true, true));
                }
            })
            .then(function() {
                $("#num_thoughts").html($("#thoughts_container").children().length);
            });
    });
});