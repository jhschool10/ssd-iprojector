$("document").ready(function () {

    let valid = {
        username: false,
        password: false,
        passwordConfirm: false,
        age: false,
    }
    let verifyUsernameTimer = undefined;
    let icon = {
        empty: "&#9744;",
        checked: "&#9745;",
        exed: "&#9746;",
    }

    // Init

    $("#usernameTxt").keyup(function() {
        const $tick = $("#usernameTick");
        let userInput = $(this).val();
        let fails = false;
        clearTimeout(verifyUsernameTimer);

        if (userInput.length === 0) {
            $($tick).html(icon.empty)
                        .addClass("text-muted")
                        .removeClass("text-success text-warning");
        } else {
            if (userInput.length < 5) {
                fails = true;
            }

            if (userInput.search(/[^a-z0-9]/g) != -1) fails = true;

            if (fails) {
                $($tick).html(icon.exed)
                            .addClass("text-warning")
                            .removeClass("text-success text-muted");
                valid.username = false;
            } else {
                // Finally: check uniqueness of username
                verifyUsernameTimer = setTimeout(function() {
                    verifyUniqueUsername(userInput)
                        .then(result => {
                            if (result.success) {
                                $($tick).html(icon.checked)
                                        .addClass("text-success")
                                        .removeClass("text-warning text-muted");
                                $("#usernameMsg").addClass("d-none")
                                                    .removeClass("d-inline");
                                $("#usernameInstr").addClass("d-inline")
                                                    .removeClass("d-none");
                                valid.username = true; 
                            } else {
                                $($tick).html(icon.exed)
                                        .addClass("text-warning")
                                        .removeClass("text-success text-muted");
                                $("#usernameMsg").addClass("d-inline")
                                                    .removeClass("d-none");
                                $("#usernameInstr").addClass("d-none")
                                                    .removeClass("d-inline");
                                valid.username = false; 
                            }
                        });
                }, 300);
            }
        }

        setSubmitBtnState();
    });
    $("#passwordTxt").keyup(function() {
        const $tick = $("#passwordTick");
        const userInput = $(this).val();
        let fails = false;
        
        if (userInput.length === 0) {
            $($tick).html(icon.empty)
                    .addClass("text-muted")
                    .removeClass("text-success text-warning");
            $("#passwordConfirmTick").html(icon.empty)
                                        .addClass("text-muted")
                                        .removeClass("text-success text-warning");
        } else {
            // Length
            if (userInput.length < 8) fails = true;
            // Content
            if (userInput.search(/\s/g) != -1) { fails = true; console.log("here"); };

            if (fails) {
                $($tick).html(icon.exed)
                        .addClass("text-warning")
                        .removeClass("text-success text-muted");
                valid.password = false;
            } else {
                $($tick).html(icon.checked)
                        .addClass("text-success")
                        .removeClass("text-warning text-muted")
                valid.password = true;                        
            }
        }

        setSubmitBtnState();
    });
    $("#passwordConfirmTxt").keyup(function() {
        const $tick = $("#passwordConfirmTick");
        const userInput = $(this).val();
        let fails = false;

        if ($("#passwordTxt").val().length === 0) {
            $($tick).html(icon.empty)
                    .addClass("text-muted")
                    .removeClass("text-success text-warning");
        } else {
            if (userInput !== $("#passwordTxt").val()) fails = true;

            if (fails) {
                $($tick).html(icon.exed)
                        .addClass("text-warning")
                        .removeClass("text-success text-muted");
                valid.passwordConfirm = false;
            } else {
                $($tick).html(icon.checked)
                        .addClass("text-success")
                        .removeClass("text-warning text-muted");
                valid.passwordConfirm = true;
            }
        }

        setSubmitBtnState();
    });
    $("#ageTxt").keyup(function() {
        const $tick = $("#ageTick");
        const userInput = $(this).val();
        let fails = false;

        if (userInput.length === 0) {
            $($tick).html(icon.empty)
                    .addClass("text-muted")
                    .removeClass("text-success text-warning");
        } else {
            if (parseInt(userInput) < 13) fails = true;

            if (fails) {
                $($tick).html(icon.exed)
                        .addClass("text-warning")
                        .removeClass("text-success text-muted");
                valid.age = false;
            } else {
                $($tick).html(icon.checked)
                        .addClass("text-success")
                        .removeClass("text-warning text-muted");
                valid.age = true;
            }
        }

        setSubmitBtnState();
    });

    function setSubmitBtnState() {
        if (valid.username && valid.password && valid.passwordConfirm && valid.age) {
            $("#submitBtn").prop("disabled", false);
            console.log("here");
        } else {
            $("#submitBtn").prop("disabled", true);
        }
    }
    async function verifyUniqueUsername(username) {
        return fetch("./php_scripts/is_username_unique.php?username=" + username)
            .then(result => result.json())
            .then(message => message);
    }

});