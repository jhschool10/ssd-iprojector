async function getThoughts(thoughtSet, orderBy, order) {
    let url = "./php_scripts/get_thoughts_from_db.php?";
    
    url += "thought_set=" + thoughtSet;
    url += "&";
    url += "order_by=" + orderBy;
    url += "&";
    url += "order=" + order;
    url += "&";

    return fetch(url)
        .then(response => response.json())
        .then(result => result);
}

async function getOneThought(thought_id) {
    const url = "./php_scripts/get_one_thought_from_db.php?thought_id=" + thought_id;

    return fetch(url)
        .then(response => response.json())
        .then(result => result);
}
async function projectThought(user_id, thought_id) {
    let url = "./php_scripts/project_thought_in_db.php?";
    url += "user_id=" + user_id; // the logged in user should be the current owner
    url += "&thought_id=" + thought_id;

    return fetch(url)
        .then(result => result.json())
        .then(status => status);
}
function replaceThought(oldThought, newThoughtId) {
    getOneThought(newThoughtId)
        .then(thought => {
            $(oldThought).replaceWith(createThoughtDiv(thought[0], true, true));
        });
};
function showProjectionVisual(oldThought, newThought) {
    const oldThoughtText = oldThought["thought_text"];
    const otherUser = oldThought["username"];
    const newThoughtText = oldThought["thought_text"];

    const $container = $("<div>")
                            .addClass("w-100 h-100 fixed-top d-flex justify-content-center align-items-center")
                            .css("background-color", "rgba(108, 117, 125, 0.2");
    $("body").append($container);

        const $visualContainer = $("<div>")
                                    .addClass("container-md bg-info w-50 h-50");
        $($container).append($visualContainer);

    setTimeout(function() {
        $($container).remove();
    }, 1000);
}
async function getThoughtHistory(thought_id) {
    return fetch("./php_scripts/get_thought_history_from_db.php?thought_id=" + thought_id)
        .then(result => result.json())
        .then(projectionRecords => projectionRecords);
}
function parseThoughtHistory($targetContainer, projectionRecords) {
    $($targetContainer).html("");
    for (record of projectionRecords) {
        let $thing = $("<p>")
                        .html(record);
        $($targetContainer).append($thing);
    }
}
function createThoughtDiv(thought, isAnimated = false, isUserThought = false) {
    const $thoughtContainer = $("<div>")
                        .attr("data-id", thought["thought_id"]) // for finding this particular thought
                        .addClass("thought-container mb-2 p-2 shadow border rounded");

    if (isAnimated) { // Will animate the drawing of the thought to the screen (for when new thoughts are added by a user)
        // Timeout is necessary re: https://stackoverflow.com/questions/24148403/trigger-css-transition-on-appended-element
        setTimeout(function() {
            $($thoughtContainer).addClass("animate__animated animate__rubberBand");
        }, 50);
    }

        const $row1 = $("<div>")
                        .addClass("CLICKABLE-thought d-flex border-bottom p-2");
        $($thoughtContainer).append($row1);

            if (isUserThought) {
                const $projectBtn = $("<button>")
                                        .html("&target; Project")
                                        .addClass("align-self-top btn btn-outline-primary btn-sm mr-3")
                                        .on("click", function() {
                                            const loggedInUser = thought["current_owner"];
                                            projectThought(loggedInUser, thought["thought_id"])
                                                .then(function(status) {
                                                    if (status.success) {
                                                        const thoughts = status.message;
                                                        let userNewThought, userOldThought;
                                                        if (thoughts[0]["new_owner_id"] == loggedInUser) {
                                                            userNewThought = thoughts[0];
                                                            userOldThought = thoughts[1];
                                                        } else {
                                                            userNewThought = thoughts[1];
                                                            userOldThought = thoughts[0];
                                                        }

                                                        replaceThought($thoughtContainer, userNewThought["thought_id"]);
                                                        showProjectionVisual(userOldThought, userNewThought);
                                                    }
                                                })
                                        });
                $($row1).append($projectBtn);
            }

            const $textContainer = $("<div>")
                                    .addClass("d-flex align-self-stretch align-content-center w-100")
                                    .on("click", function() {
                                        const thought_id = thought["thought_id"];
                                        getThoughtHistory(thought_id)
                                            .then(projectionRecords => {
                                                parseThoughtHistory($($row2), projectionRecords);
                                            });
                                    });
            $($row1).append($textContainer);

                const $initial = $("<h2>")
                                .html("I... ")
                                .addClass("pl-3 mr-3 border-left");
                $($textContainer).append($initial);
                    

                const $text = $("<p>")
                                .html(thought["thought_text"])
                                .addClass("font-italic");
                $($textContainer).append($text);
        
        const $row2 = $("<div>")
                        .addClass("w-100");
        $($thoughtContainer).append($row2);


        const $row3 = $("<div>")
                        .addClass("row button justify-content-between align-items-center ml-2 mr-2 pt-2");
        $($thoughtContainer).append($row3);

            const $huzzahBtn = $("<input>")
                                .attr("type", "button")
                                .attr("data-id", thought["thought_id"])
                                .val("Huzzah This Thought!")
                                .addClass("CLICKABLE-huzzah col-md btn btn-info btn-sm")
                                .on("click", function() {
                                    $(this).prop("disabled", true);
                                    const thoughtID = thought["thought_id"];
                                    fetch("./php_scripts/huzzah.php?thought_id=" + thoughtID)
                                        .then(response => response.json())
                                        .then(status => {
                                            if (status.success) {
                                                let numHuzzahsEle = $(this).next().children().first();
                                                numHuzzahsEle.html(parseInt(numHuzzahsEle.html()) + 1);
                                            }
                                        })

                                    $thisHuzzahBtn = $(this); // can't use .bind() with jQuery objects
                                    setTimeout(function() {
                                        $thisHuzzahBtn.prop("disabled", false);
                                    }, 1000);
                                });
            $($row3).append($huzzahBtn);

            const $huzzahNum = $("<div>")
                                .addClass("col-md mt-1")
                                .append($("<span>")
                                            .html(thought["huzzahs"]))
                                .append($("<img>")
                                            .attr("src", "./images/huzzah.png")
                                            .attr("title", thought["huzzahs"] + " huzzahs so far")
                                            .addClass("bg-warning rounded-circle ml-2 p-1")
                                            .css("width", "20px")
                                            .css("height", "20px"));
            $($row3).append($huzzahNum);

            const $user = $("<small>")
                            .html(" by <strong>" + thought["username"] + "</strong> (age " + thought["age"] + ")")
                            .addClass("col-md text-sm mr-2 mt-1");
            $($row3).append($user);

            const $date = $("<small>")
                            .html("on <strong>" + thought["date_created"] + "</strong>")
                            .addClass("col-md text-sm mt-1");
            $($row3).append($date);

    return $thoughtContainer;
}
function setNumThoughts() {
    $("#num_thoughts").html($("#thoughts_container").children().length);
}