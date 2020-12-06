// Init
const thoughtList = document.getElementById("thought_container");
thoughtList.innerHTML = "";

let querySettings = { // initialized to default
    thought_set: "all", // One of: all, user, not_user
    orderBy: "date", // One of: date, huzzahs, username
    order: "asc", // One of: asc, desc, random
}

getThoughts(querySettings.thought_set, querySettings.orderBy, querySettings.order, false)
    .then(thoughts => {
        for (const thought of thoughts) {
            if (thought["user_id"] == this_user_id) {
                thoughtList.appendChild(createThoughtDiv(thought, false, true));
            } else {
                thoughtList.appendChild(createThoughtDiv(thought, false, false));
            }
        }
    });

// Listeners
$("#option_order_date_asc").click(function() {
    querySettings.orderBy = "date";
    querySettings.order = "asc";
});
$("#option_order_date_desc").click(function() {
    querySettings.orderBy = "date";
    querySettings.order = "desc";
});
$("#option_order_huzzahs_asc").click(function() {
    querySettings.orderBy = "huzzahs";
    querySettings.order = "asc";
});
$("#option_order_huzzahs_desc").click(function() {
    querySettings.orderBy = "huzzahs";
    querySettings.order = "desc";
});
$("#option_order_username_asc").click(function() {
    querySettings.orderBy = "username";
    querySettings.order = "asc";
});
$("#option_order_username_desc").click(function() {
    querySettings.orderBy = "username";
    querySettings.order = "desc";
});
$("#option_order_random").click(function() {
    querySettings.orderBy = "";
    querySettings.order = "random";
});
$("#option_set_AllThoughts").click(function() {
    querySettings.thought_set = "all";
});
$("#option_set_UserThoughts").click(function() {
    querySettings.thought_set = "user";
});
$("#option_set_NotUserThoughts").click(function() {
    querySettings.thought_set = "not_user";
});
$("#refresh_thought_list").click(function() {
    getThoughts(querySettings.thought_set, querySettings.orderBy, querySettings.order)
    .then(thoughts => {
        thoughtList.innerHTML = "";
        for (const thought of thoughts) {
            if (thought["user_id"] == this_user_id) {
                thoughtList.appendChild(createThoughtDiv(thought, false, true));
            } else {
                thoughtList.appendChild(createThoughtDiv(thought, false, false));
            }
        }
    });
});