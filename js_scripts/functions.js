async function getThoughts(orderBy, order, justForUser) {
    let url = "./php_scripts/get_thoughts_from_db.php?";
    
    url += "order_by=" + orderBy;
    url += "&";
    url += "order=" + order;
    url += "&";

    if (justForUser) {
        url += "for_user=true";
    }

    return fetch(url)
        .then(response => response.json())
        .then(result => result);
}
// UNTESTED@!!!!!!!!
async function getOneThought(thought_text) {
    const url = "./php_scripts/get_one_thought_from_db.php?thought_text=" + thought_text;

    return fetch(url)
        .then(response => response.json())
        .then(result => result);
}
function createThoughtDiv(thought, isAnimated = false, isUserThought = false) {
    setNumThoughts();

    const container = document.createElement("div");
    container.setAttribute("class", "mb-2 p-2 shadow border rounded");
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
            const initial = document.createElement("h2");
            initial.setAttribute("class", "align-self-end mr-3");
            initial.innerHTML = "I... "
            row1.children.push(initial);

            const text = document.createElement("p");
            text.setAttribute("class", "align-self-end font-italic");
            text.innerHTML = thought["thought_text"];
            row1.children.push(text);

            if (isUserThought) {
                const project = document.createElement("button");
                project.setAttribute("type", "button");
                project.innerHTML = "Project";
                project.setAttribute("class", "ml-3 align-self-center btn btn-outline-primary btn-sm");
                row1.children.push(project);
            }
        
            row1.ele.append(...row1.children);

        const row2 = {
            ele: document.createElement("div"),
            children: [],
        };
        row2.ele.setAttribute("class", "d-flex button justify-content-between align-items-center ml-2 mr-2 pt-2");
            const huzzahBtn = document.createElement("input");
            huzzahBtn.setAttribute("type", "button");
            huzzahBtn.setAttribute("data-id", thought["thought_id"]);
            huzzahBtn.setAttribute("class", "CLICKABLE-huzzah btn btn-info btn-sm");
            huzzahBtn.setAttribute("value", "Huzzah This Thought!");
            huzzahBtn.addEventListener("click", function() {
                const thoughtID = thought["thought_id"];
                fetch("./php_scripts/huzzah.php?thought_id=" + thoughtID)
                    .then(response => response.json())
                    .then(status => {
                        console.log(status);
                        if (status.success) {
                            const huzzahNumTextNode = huzzahBtn.nextElementSibling.childNodes[0];
                            const currentHuzzahs = parseInt(huzzahNumTextNode.textContent);
                            huzzahNumTextNode.textContent = currentHuzzahs + 1;
                        }
                    })
            }.bind(this));
            row2.children.push(huzzahBtn);

            const huzzahNum = document.createElement("div");
            huzzahNum.setAttribute("class", "d-flex align-items-center");
                huzzahNum.append(document.createTextNode(thought["huzzahs"]));
                const huzzahImg = document.createElement("img");
                huzzahImg.setAttribute("class", "bg-warning rounded-circle ml-2 p-1");
                huzzahImg.src = "./images/huzzah.png";
                huzzahImg.title = thought["huzzahs"] + " huzzahs so far";
                huzzahImg.style.width = "15px";
                huzzahImg.style.height = "15px";
                huzzahNum.append(huzzahImg);
            row2.children.push(huzzahNum);

            const user = document.createElement("small");
            user.setAttribute("class", "text-sm mr-2");
            user.innerHTML = " by <strong>" + thought["username"] + "</strong> (age " + thought["age"] + ")";
            row2.children.push(user);

            const date = document.createElement("small");
            date.setAttribute("class", "text-sm");
            date.innerHTML = "on <strong>" + thought["date_created"] + "</strong>";
            row2.children.push(date);

            row2.ele.append(...row2.children);
        
        container.append(row1.ele, row2.ele);

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