/**
 * This is a collection of all the functions used on the website
 * Author: Joseph Haley
 */

class Thought {
    id;
    ownerID;
    ownerUsername;
    ownerAge;
    dateCreated;
    text;
    numHuzzahs;

    constructor(id, ownerID, ownerUsername, ownerAge, dateCreated, text, numHuzzahs) {
        this.id = id;
        this.ownerID = ownerID;
        this.ownerUsername = ownerUsername;
        this.ownerAge = ownerAge;
        this.dateCreated = dateCreated;
        this.text = text;
        this.numHuzzahs = numHuzzahs;
    }
}

const thoughts = {
    list: [],
    getList: function() {
        return this.list;
    },
    count: function() {
        return this.list.length;
    },
    /**
     * Recompiles the list of thoughts with thoughts from the database
     * @param {Enum - String} thoughtSet Which thoughts to get from the database (One of: all, user, not_user)
     * @param {Enum - String} orderBy The attribute to sort the list by (One of: date, huzzahs, username)
     * @param {Enum - String} order The order of the results (One of: asc, desc, random)
     * @return {Array} of objects containing thought attributes
     */
    recompileList: function(thoughtSet, orderBy, order) {
        this.list = [];
        return this.db.getMultiple(thoughtSet, orderBy, order)
                .then(thoughts => {
                    for(const th of thoughts) {
                        this.list.push(new Thought( th["thought_id"],
                                                    th["current_owner"],
                                                    th["username"],
                                                    th["age"],
                                                    th["date_created"],
                                                    th["thought_text"],
                                                    th["huzzahs"]))
                    }
                });
    },
    getRandom: function() {
        return this.db.getOne("random");
    },
    getOne: function(thought_id) {
        return this.db.getOne(thought_id);
    },
    recordOne: async function(text) {
        return this.db.record(text)
            .then(result => {
                let value = undefined;
                if (result.success) {
                    const th = result.thought;
                    value = new Thought(th["thought_id"],
                                        th["current_owner"],
                                        th["username"],
                                        th["age"],
                                        th["date_created"],
                                        th["thought_text"],
                                        th["huzzahs"])
                } else {
                    value = false;
                }
                return value;
            })
    },
    trade: function(user_id, thought_id) {
        return this.db.randomTrade(user_id, thought_id)
            .then(result => result);
    },
    getHistory: function(thought_id) {
        return this.db.getHistory(thought_id)
            .then(result => result);
    },
    db: {
        /**
         * Gets one thought record from the database
         * @param {Int} thought_id The id of the thought (or "random" to get a random thought)
         * @return {Array} of one object containing thought attributes
         */
        getOne: async function(thought_id) {
            const url = "./php_scripts/get_one_thought_from_db.php?thought_id=" + thought_id;

            return fetch(url)
                .then(response => response.json())
                .then(result => {
                    const th = result[0];
                    return new Thought( th["thought_id"],
                                        th["current_owner"],
                                        th["username"],
                                        th["age"],
                                        th["date_created"],
                                        th["thought_text"],
                                        th["huzzahs"])
                });
        },
        /**
         * Gets thought records from the database
         * @param {Enum - String} thoughtSet Which thoughts to get from the database (One of: all, user, not_user)
         * @param {Enum - String} orderBy The attribute to sort the list by (One of: date, huzzahs, username)
         * @param {Enum - String} order The order of the results (One of: asc, desc, random)
         * @return {Array} of objects containing thought attributes
         */
        getMultiple: function(thoughtSet, orderBy, order) {
            let url = "./php_scripts/get_thoughts_from_db.php?";
            
            url += "thought_set=" + thoughtSet;
            url += "&";
            url += "order_by=" + orderBy;
            url += "&";
            url += "order=" + order;
            url += "&";

            return fetch(url)
                .then(response => response.json())
                .then(thoughts => thoughts);
        },
        /**
         * Records a thought to the database and returns that new thought
         * @param {String} text The text of the thought
         */
        record: async function(text) {
            return fetch("./php_scripts/record_thought_to_db.php?thought_text=" + text)
                .then(response => response.json())
                .then(result => result);
        },
        /**
         * Trades a user's thought with a random thought of another random user
         * For this function to work, the user must be the owner of the thought being traded
         * @param {Int} user_id The user_id of the current user who is trading a thought
         * @param {Int} thought_id The thought_id of the thought being traded
         * @return {Object {bool, Array[2]}} Object with two properties: "status" (bool) indicates whether the trade was successful; "message" returns an array of two objects containing the thought attributes of the two thoughts that were traded
         */
        randomTrade: function(user_id, thought_id) {
            let url = "./php_scripts/trade_thought_in_db.php?";
            url += "user_id=" + user_id; // the logged in user should be the current owner
            url += "&thought_id=" + thought_id;

            return fetch(url)
                .then(result => result.json())
                .then(status => status);
        },
        /**
         * Gets an array of all trades a thought has been involved in
         * @param {Int} thought_id The ID of the thought
         * @return An array of Objects containing attributes regarding each trade the thought has been in
         */
        getHistory: async function(thought_id) {
            return fetch("./php_scripts/get_thought_history_from_db.php?thought_id=" + thought_id)
                .then(result => result.json())
                .then(tradeRecords => tradeRecords);
        }
    },
};

/**
 * Gets a thought from the database, creates a jQuery "thought element" and uses that to replace another jQuery thought element
 * @param {jQuery object} $oldThought jQuery object containing one thought element
 * @param {*} newThoughtId The ID of the new thought which will replace the other thought
 */
function replaceThoughtEle($oldThought, newThoughtId) {
    thoughts.getOne(newThoughtId)
        .then(thought => {
            setTimeout(function() {
                $($oldThought).replaceWith(createThoughtEle(thought, true, true));
            }, 4500) // allow time for showProjectionVisual to complete its animation
        });
};
/**
 * Animates a thought trade between two thoughts
 * @param {Object} oldThought Object that contains thought attributes
 * @param {Object} newThought Object that contains thought attributes
 */
async function showProjectionVisual(oldThought, newThought) {
    const otherUser = oldThought.ownerUsername + " (age " + oldThought.ownerAge + ")";
    const newThoughtText = newThought.text;

    const $window = $("<div>")
                        .addClass("w-100 h-100 fixed-top d-flex justify-content-center align-items-center")
                        .css("background-color", "rgba(108, 117, 125, 0.5");
    $("body").append($window);

        const $visual = $("<div>")
                            .addClass("container-md d-flexbg-info w-100 h-50 rounded border shadow bg-white position-relative")
                            .css("max-width", "576px"); // bootstrap "sm"
        $($window).append($visual);

            const $otherUserContainer = $("<div>")
                                        .addClass("position-absolute")
                                        .css("width", "50%") // (in lieu of Bootstrap) required to make animation work
                                        .css("height", "50%") // (in lieu of Bootstrap) required to make animation work
                                        .css("top", "1em")
                                        .css("right", "1em")
                                        .css("background-image", "url(./images/icon_person.png)")
                                        .css("background-size", "contain")
                                        .css("background-position", "right top")
                                        .css("background-repeat", "no-repeat")
                                        .delay(2000)
                                        .animate({
                                            width: "100%",
                                            height: "100%",
                                        }, 2000);
            $($visual).append($otherUserContainer);
            
            const $userContainer = $("<div>")
                                        .addClass("w-75 h-75 position-absolute")
                                        .css("bottom", "1em")
                                        .css("left", "1em")
                                        .css("background-image", "url(./images/icon_person_02.png)")
                                        .css("background-size", "contain")
                                        .css("background-position", "left bottom")
                                        .css("background-repeat", "no-repeat")
                                        .delay(2000)
                                        .animate({
                                            opacity: 0,
                                        }, 2000);
            $($visual).append($userContainer);

            const $userLabel = $("<div>")
                                    .html("Me")
                                    .addClass("position-absolute bg-secondary display-3 rounded pt-1 pb-1 pl-2 pr-2 text-white")
                                    .css("bottom", "10px")
                                    .css("left", "10px")
                                    .delay(2000)
                                    .animate({
                                        opacity: 0,
                                    }, 2000);
            $($visual).append($userLabel);

            const $otherUserLabel = $("<small>")
                                    .html(otherUser)
                                    .addClass("position-absolute bg-secondary rounded pt-1 pb-1 pl-2 pr-2 text-white")
                                    .css("top", "10px")
                                    .css("right", "10px");
            $($visual).append($otherUserLabel);

            const textPositionUser = {
                top: "25%",
                left: "10px",
            }
            const textPositionOtherUser = {
                top: "40px",
                left: "50%",
            }
            
            const $oldThoughtText = $("<div>")
                                        .html("\"I " + oldThought.text + "\"")
                                        .addClass("position-absolute bg-light text-center p-2 font-italic")
                                        .css("width", "48%")
                                        .css("top", textPositionUser.top)
                                        .css("left", textPositionUser.left)
                                        .delay(2000)
                                        .animate({
                                            top: textPositionOtherUser.top,
                                            left: textPositionOtherUser.left,
                                        }, 2000);
            $($visual).append($oldThoughtText);

            const $newThoughtText = $("<div>")
                                        .html("\"I " + newThought.text + "\"")
                                        .addClass("position-absolute bg-light text-center p-2 font-italic")
                                        .css("width", "48%")
                                        .css("top", textPositionOtherUser.top)
                                        .css("left", textPositionOtherUser.left)
                                        .delay(2000)
                                        .animate({
                                            top: textPositionUser.top,
                                            left: textPositionUser.left,
                                            opacity: 0,
                                        }, 2000);
            $($visual).append($newThoughtText);

    // Clears the DOM of the animation elements when the animation is over
    setTimeout(function() {
        $($visual)
            .animate({
                opacity: 0
            }, 500)
        setTimeout(function() {
            $($window)
                .remove()
        }, 500);
    }, 4500);
}
/**
 * Creates a jQuery object containing one element listing all trades a thought has been in
 * @param {jQuery Object} $targetContainer A jQuery object containing one element
 * @param {Object} tradeRecords An array of Objects containing attributes relating to thought trades
 */
function createThoughtHistoryEle(tradeRecords) {
    const $container = $("<div>").html("")
                        .addClass("bg-white rounded shadow-small p-2 align-self-left w-100")
                        .css("box-shadow", "0 0 5px 5px rgba(0, 0, 0, 0.03) inset")
                        .css("overflow-x", "visible")
                        .attr("data-isFilled", "true");
    
    const levelWidth = 15;
    for (let i = 0; i < tradeRecords.length; i++) {
        const record = tradeRecords[i];
        
        let $users = $("<small>")
                        .attr("title", "Projection date: " + formatDate(record["trade_date"]))
                        .addClass("d-block text-left")
                        .css("margin-left", (levelWidth * (i + 1)) + "px");

        if (i < tradeRecords.length - 1) {
            $users.html("&#9756; " + record["old_owner_username"]);
        } else {
            $users.html("&bigodot; " + record["old_owner_username"]);
        }

        $($container).append($users);
    }
    return $container;
}

/**
 * Creates a "thought element" component
 * @param {Object} thought a Thought object
 * @param {Boolean} isAnimated Whether the element will be animated when added to the DOM
 * @param {Boolean} isUserThought Whether the thought being created is owned by the current user
 * @return A jQuery Object containing one "thought element"
 */
function createThoughtEle(thought, isAnimated = false, isUserThought = false) {
    const $container = $("<div>")
                        .attr("data-id", thought.id) // for finding this particular thought
                        .addClass("thought-container mb-3 shadow border rounded");

    if (isAnimated) { // Will animate the drawing of the thought to the screen (for when new thoughts are added by a user)
        // Timeout is necessary re: https://stackoverflow.com/questions/24148403/trigger-css-transition-on-appended-element
        setTimeout(function() {
            $($container)
                .addClass("animate__animated animate__rubberBand");
        }, 50);
    }

        const $row1 = $("<div>")
                        .addClass("CLICKABLE-thought d-flex border-bottom pt-2 pr-2 pb-0")
                        .mouseenter(function() {
                            $(this).css("background-color", "rgba(23, 162, 184, 0.1)")
                        })
                        .mouseleave(function() {
                            $(this).css("background-color", "white")
                        });
        $($container).append($row1);

            const $textContainer = $("<div>")
                                    .addClass("d-flex align-self-end w-100 justify-content-left")
                                    .css("cursor", "pointer")
                                    .on("click", function() {
                                        $targetRow = $row2;
                                        if ($targetRow.attr("data-isFilled") === "false") {
                                            thoughts.db.getHistory(thought.id)
                                                .then(projectionRecords => {
                                                    $($targetRow).append(createThoughtHistoryEle(projectionRecords));
                                                });
                                            $($targetRow).attr("data-isFilled", "true");
                                        } else {
                                            $($targetRow).html("")
                                                        .attr("data-isFilled", "false");
                                        }
                                        
                                    });
            $($row1).append($textContainer);

                const $avatar = $("<div>")
                                .html("I... ")
                                .addClass("d-flex mb-0 mr-3 pl-3 pb-0 h4 align-self-end align-items-end text-white")
                                .css("background-image", "url('./images/icon_avatar.png')")
                                .css("background-position", "left bottom")
                                .css("background-size", "60px 60px")
                                .css("background-repeat", "no-repeat")
                                .css("min-width", "60px")
                                .css("min-height", "60px");;
                $($textContainer).append($avatar);
                    

                const $text = $("<p>")
                                .html(thought.text)
                                .addClass("font-italic align-self-center m-0 p-0");
                $($textContainer).append($text);
        
        const $row2 = $("<div>")
                        .addClass("w-100 h-0")
                        .attr("data-isFilled", "false");
        $($container).append($row2);


        const $row3 = $("<div>")
                        .addClass("row button justify-content-between align-items-center ml-1 mr-1 pb-3 pt-3");
        $($container).append($row3);

            const $buttons = $("<div>")
                                .addClass("col-md d-flex");
            $($row3).append($buttons);

                if (isUserThought) { // Add a Project button
                    const $projectBtn = $("<button>")
                                            .html("&#9755; Project")
                                            .addClass("btn btn-success btn-sm mr-2")
                                            .on("click", function() {
                                                const loggedInUser = thought.ownerID;
                                                thoughts.trade(loggedInUser, thought.id)
                                                    .then(function(status) {
                                                        if (status.success) {
                                                            const ths = status.message;
                                                            const th1 = new Thought(ths[0]["thought_id"],
                                                                                    ths[0]["new_owner"],
                                                                                    ths[0]["username"],
                                                                                    ths[0]["age"],
                                                                                    0,
                                                                                    ths[0]["thought_text"],
                                                                                    0);
                                                            const th2 = new Thought(ths[1]["thought_id"],
                                                                                    ths[1]["new_owner"],
                                                                                    ths[1]["username"],
                                                                                    ths[1]["age"],
                                                                                    0,
                                                                                    ths[1]["thought_text"],
                                                                                    0);
                                                            let newThought, oldThought;
                                                            console.log(th1.ownerID, loggedInUser);
                                                            if (th1.ownerID === loggedInUser) {
                                                                newThought = th1;
                                                                oldThought = th2;
                                                            } else {
                                                                newThought = th2;
                                                                oldThought = th1;
                                                            }
                                                            showProjectionVisual(oldThought, newThought)
                                                                .then(() => { replaceThoughtEle($container, newThought.id) });
                                                        }
                                                    })
                                            });
                    $($buttons).append($projectBtn);
                }

                const $huzzahBtn = $("<button>")
                                    .html("<img src='./images/huzzah.png' style='height: 20px; width: 20px;'> Huzzah!")
                                    .attr("type", "button")
                                    .attr("data-id", thought.id)
                                    .attr("title", "It's not like anyone's gonna find out...")
                                    .addClass("CLICKABLE-huzzah btn btn-warning text-white btn-sm")
                                    .on("click", function() {
                                        $(this).prop("disabled", true);
                                        fetch("./php_scripts/huzzah.php?thought_id=" + thought.id)
                                            .then(response => response.json())
                                            .then(status => {
                                                if (status.success) {
                                                    let numHuzzahsEle = $(this).parent().next().children().first();
                                                    numHuzzahsEle.html(parseInt(numHuzzahsEle.html()) + 1);
                                                }
                                            })

                                        $thisHuzzahBtn = $(this); // can't use .bind() with jQuery objects
                                        setTimeout(function() {
                                            $thisHuzzahBtn.prop("disabled", false);
                                        }, 1000);
                                    });
                $($buttons).append($huzzahBtn);

            const $huzzahNum = $("<div>")
                                .addClass("col-md mt-1")
                                .append($("<span>")
                                            .html(thought.numHuzzahs))
                                .append($("<img>")
                                            .attr("src", "./images/huzzah.png")
                                            .attr("title", thought.numHuzzahs + " huzzahs so far")
                                            .addClass("bg-warning rounded-circle ml-2 p-1")
                                            .css("width", "20px")
                                            .css("height", "20px"));
            $($row3).append($huzzahNum);

            const $user = $("<small>")
                            .html("now in the head of <strong>" + thought.ownerUsername + "</strong> (age " + thought.ownerAge + ")")
                            .addClass("col-md text-sm mr-2 mt-1");
            $($row3).append($user);

            const $date = $("<small>")
                            .html("created on <strong>" + formatDate(thought.dateCreated) + "</strong>")
                            .addClass("col-md text-sm mt-1");
            $($row3).append($date);

    return $container;
}
/**
 * Formats a datetime into a nicer format
 * @param {String} datetime A datetime supplied by a MySQL database
 * @return a nicely-formatted string containing a date and time
 */
function formatDate(datetime) {
    const months = ["Jan.", "Feb.", "Mar.", "Apr.", "May", "June", "July", "Aug.", "Sept.", "Oct.", "Nov.", "Dec."];

    let outputStr = "";
    let date = new Date(datetime);

    outputStr += months[date.getMonth()] + " ";
    outputStr += date.getDate() + ", ";
    outputStr += date.getFullYear() + " (";
    outputStr += date.getHours() + ":";
    outputStr += date.getMinutes() + ")";

    return outputStr;
}

/**
 * An object containing everything needed to verify various user inputs
 */
let verify = {
    /**
     * Icons used to indicate whether a user input is good, bad, or neutral
     */
    icon: {
        empty: "&#9744;",
        checked: "&#9745;",
        exed: "&#9746;",
    },
    /**
     * Variable for containing a Timeout ID
     */
    timer: undefined,
    /**
     * Gets whether a string is empty or not
     * @param {String} str A string
     * @return {boolean} Whether the string is empty or not
     */
    isEmpty(str) {
        return str.length ===0;
    },
    /**
     * Determines whether a username meets criteria or not
     * @param {String} username
     * @return {Boolean}
     */
    usernameValid(username) {
        let isValid = true;

        if (username.length < 5) isValid = false;

        if (username.search(/[^a-z0-9]/g) !== -1) isValid = false;

        return isValid;
    },
    /**
     * Determines whether a password meets criteria or not
     * @param {String} password 
     * @return {Boolean}
     */
    passwordValid: function(password) {
        let isValid = true;

        if (password.length < 8) isValid = false;
        
        if (password.search(/\s/g) !== -1) isValid = false;

        return isValid;
    },
    /**
     * Determines whether a "confirm password" string meets criteria or not
     * @param {String} confirmPassword The "confirm password" string
     * @param {String} password The password string
     * @return {Boolean}
     */
    confirmPasswordValid: function(confirmPassword, password) {
        let isValid = true;

        if (confirmPassword !== password) isValid = false;

        return isValid;
    },
    /**
     * Determines whether an age meets criteria or not
     * @param {String} age 
     * @return {Boolean}
     */
    ageValid: function(age) {
        let isValid = true;
        
        const ageParsed = parseInt(age);
        if (isNaN(ageParsed) || ageParsed < 13) isValid = false;

        return isValid;
    },
    /**
     * Determines whether an email meets criteria or not
     * @param {String} email
     * @return {Boolean}
     */
    emailValid: function(email) {
        let isValid = true;

        if (email.search(/[a-z_.0-9]+@[a-z]+[.][a-z]{2,10}/g) === -1) isValid = false;

        return isValid;
    },
    /**
     * Determines whether a name (first or last or whatever) meets criteria or not
     * @param {String} name 
     * @return {Boolean}
     */
    nameValid: function(name) {
        let isValid = true;

        if (name.search(/^[A-Z][a-z]+$/) === -1) { isValid = false };

        return isValid;
    },
    /**
     * Sets the status of a user input field
     * @param {jQuery object} $tickEle A single element which will display the status of an input
     * @param {Enum - String} status Either "valid", "invalid", or "neutral"
     * @param {*} requiredField Whether the input is for a required field or not
     */
    setStatus: function($tickEle, status, requiredField = false) {
        switch (status) {
            case "valid":
                $($tickEle).html(verify.icon.checked)
                        .addClass("text-success")
                        .removeClass("text-warning text-muted");
                break;
            case "invalid":
                $($tickEle).html(verify.icon.exed)
                        .addClass("text-warning")
                        .removeClass("text-success text-muted");
                break;
            case "neutral":
                if (requiredField) {
                    $($tickEle).html(verify.icon.empty)
                    .addClass("text-muted")
                    .removeClass("text-success text-warning");
                } else {
                    $($tickEle).html(verify.icon.empty)
                    .addClass("text-white")
                    .removeClass("text-success text-warning");
                }
                break;
        }
    }
}
/**
 * Checks a username against all other usernames in the database and determines whether it is unique or not
 * @param {String} username Username to be checked
 * @return {Object} An object containing one property, indicating whether the username is unique or not
 */
async function verifyUniqueUsername(username) {
    return fetch("./php_scripts/is_username_unique.php?username=" + username)
        .then(result => result.json())
        .then(message => message);
}