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
function replaceThought(oldThoughtId, newThoughtId) {
    const thoughtEles = document.getElementById("thought_container").childNodes;

    for (let thoughtEle of thoughtEles) {
        if (parseInt(thoughtEle.getAttribute("data-id")) == oldThoughtId) {
            
            getOneThought(newThoughtId)
                .then(thought => {
                    thoughtEle.replaceWith(createThoughtDiv(thought[0], true, true));

                })
            break;
        }
    }
};
function showProjectionVisual(oldThought, newThought) {

}
async function getThoughtHistory(thought_id) {
    return fetch("./php_scripts/get_thought_history_from_db.php?thought_id=" + thought_id)
        .then(result => result.json())
        .then(projectionRecords => projectionRecords);
}
function parseThoughtHistory(targetContainer, projectionRecords) {
    targetContainer.innerHTML = "";
    for (record of projectionRecords) {
        let thing = document.createElement("P");
        thing.innerHTML = record;
        targetContainer.appendChild(thing);
    }
}
function createThoughtDiv(thought, isAnimated = false, isUserThought = false) {
    setNumThoughts();

    const container = document.createElement("div");
    container.setAttribute("class", "thought-container mb-2 p-2 shadow border rounded");
    container.setAttribute("data-id", thought["thought_id"]); // for finding this particular thought
    if (isAnimated) { // Will animate the drawing of the thought to the screen (for when new thoughts are added by a user)
        // Timeout is necessary re: https://stackoverflow.com/questions/24148403/trigger-css-transition-on-appended-element
        setTimeout(function() {
            container.classList.add("animate__animated");
            container.classList.add("animate__rubberBand");
        }, 50);
    }

        const row1 = {
            ele: document.createElement("div"),
            children: [],
        };
        row1.ele.setAttribute("class", "CLICKABLE-thought d-flex border-bottom p-2");
        row1.ele.addEventListener("click", function() {
            const thought_id = thought["thought_id"];
            getThoughtHistory(thought_id)
                .then(projectionRecords => {
                    parseThoughtHistory(row2.ele, projectionRecords);
                });
        }.bind(this), true);
            const initial = document.createElement("h2");
            initial.setAttribute("class", "align-self-end mr-3");
            initial.innerHTML = "I... ";
            row1.children.push(initial);

            // let initial = $("<h2>")
            //                 .html("I... ")
            //                 .attr("css", "align-self-end mr-3");

            const text = document.createElement("p");
            text.setAttribute("class", "align-self-end font-italic");
            text.innerHTML = thought["thought_text"];
            row1.children.push(text);

            if (isUserThought) {
                const projectBtn = document.createElement("button");
                projectBtn.setAttribute("type", "button");
                projectBtn.innerHTML = "&target; Project";
                projectBtn.setAttribute("class", "ml-3 align-self-center btn btn-outline-primary btn-sm");
                projectBtn.addEventListener("click", function() {
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

                                replaceThought(thought["thought_id"], userNewThought["thought_id"]);
                                showProjectionVisual(userOldThought, userNewThought);
                            }
                        }.bind(this));
                });

                row1.children.push(projectBtn);
            }
        
            row1.ele.append(...row1.children);
        
        const row2 = {
            ele: document.createElement("div"),
            children: [],
        }
        row2.ele.setAttribute("class", "w-100");


        const row3 = {
            ele: document.createElement("div"),
            children: [],
        };
        row3.ele.setAttribute("class", "row button justify-content-between align-items-center ml-2 mr-2 pt-2");
            const huzzahBtn = document.createElement("input");
            huzzahBtn.setAttribute("type", "button");
            huzzahBtn.setAttribute("data-id", thought["thought_id"]);
            huzzahBtn.setAttribute("class", "CLICKABLE-huzzah col-md btn btn-info btn-sm");
            huzzahBtn.setAttribute("value", "Huzzah This Thought!");
            huzzahBtn.addEventListener("click", function() {
                huzzahBtn.disabled = true;
                const thoughtID = thought["thought_id"];
                fetch("./php_scripts/huzzah.php?thought_id=" + thoughtID)
                    .then(response => response.json())
                    .then(status => {
                        if (status.success) {
                            const huzzahNumTextNode = huzzahBtn.nextElementSibling.childNodes[0];
                            const currentHuzzahs = parseInt(huzzahNumTextNode.textContent);
                            huzzahNumTextNode.textContent = currentHuzzahs + 1;
                        }
                    })
                setTimeout(function() {
                    console.log("here");
                    huzzahBtn.disabled = false;
                }, 1000);
            }.bind(this));
            row3.children.push(huzzahBtn);

            const huzzahNum = document.createElement("div");
            huzzahNum.setAttribute("class", "col-md d-flex align-items-center");
                huzzahNum.append(document.createTextNode(thought["huzzahs"]));
                const huzzahImg = document.createElement("img");
                huzzahImg.setAttribute("class", "bg-warning rounded-circle ml-2 p-1");
                huzzahImg.src = "./images/huzzah.png";
                huzzahImg.title = thought["huzzahs"] + " huzzahs so far";
                huzzahImg.style.width = "20px";
                huzzahImg.style.height = "20px";
                huzzahNum.append(huzzahImg);
            row3.children.push(huzzahNum);

            const user = document.createElement("small");
            user.setAttribute("class", "col-md text-sm mr-2");
            user.innerHTML = " by <strong>" + thought["username"] + "</strong> (age " + thought["age"] + ")";
            row3.children.push(user);

            const date = document.createElement("small");
            date.setAttribute("class", "col-md text-sm");
            date.innerHTML = "on <strong>" + thought["date_created"] + "</strong>";
            row3.children.push(date);

            row3.ele.append(...row3.children);
        
        container.append(row1.ele, row2.ele, row3.ele);

    return container;
}
function setNumThoughts() {
    const thoughtContainer = document.getElementById("thought_container");
    const numThoughtsContainer = document.getElementById("num_thoughts");
    if (thoughtContainer !== null && numThoughtsContainer !== null) {
        const numThoughts = thoughtContainer.childNodes.length + 1;
        numThoughtsContainer.innerHTML = numThoughts;
    }
}