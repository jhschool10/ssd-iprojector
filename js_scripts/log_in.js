/**
 * This is the companion javascript to log_in.php
 * Author: Joseph Haley
*/
$("document").ready(function() {
    thoughts.getRandom()
        .then(thought => {
            console.log(thought);
            $("#random_thought").append(createThoughtEle(thought, true));
        })
});