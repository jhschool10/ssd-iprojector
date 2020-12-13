/**
 * This is the companion javascript to create_account.php
 * Author: Joseph Haley
*/

$("document").ready(function () {

    // Variables
    /**
     * Keeps track of the status of any input entered by the user
     */
    let conditionMet = {
        username: false, // true/false
        password: false, // true/false
        passwordConfirm: false, // true/false
        email: "n/a", // true/false/na
        firstname: "n/a", // true/false/na
        lastname: "n/a", // true/false/na
        age: false,
    }

    // Init

    // Listeners
    $("#usernameTxt").keyup(function() {
        const $tick = $("#usernameTick");
        let userInput = $(this).val();
        let isValid = false;
        clearTimeout(verify.timer);

        if (verify.isEmpty(userInput)) {
            verify.setStatus($tick, "neutral", true);
            isValid = false;
        } else {
            isValid = verify.usernameValid(userInput);

            if (isValid) {
                // Finally: check uniqueness of username
                this.timer = setTimeout(function() {
                    verifyUniqueUsername(userInput)
                        .then(result => {
                            if (result.success) {
                                isValid = true;
                                verify.setStatus($tick, "valid", true);
                                $("#usernameMsg").addClass("d-none")
                                                    .removeClass("d-inline");
                                $("#usernameInstr").addClass("d-inline")
                                                    .removeClass("d-none");
                            } else {
                                isValid = false;
                                verify.setStatus($tick, "invalid", true);
                                $($("#usernameMsg")).addClass("d-inline")
                                                    .removeClass("d-none");
                                $("#usernameInstr").addClass("d-none")
                                                    .removeClass("d-inline");
                            }
                        });
                }.bind(this), 300);
            } else {
                verify.setStatus($tick, "invalid", true);
            }
        }
        conditionMet.username = isValid;
        setSubmitBtnState();
    });
    // HERE
    $("#passwordTxt").keyup(function() {
        const $tick = $("#passwordTick");
        const userInput = $(this).val();
        let isValid = false;
        
        if (verify.isEmpty(userInput)) {
            verify.setStatus($tick, "neutral");
            verify.setStatus($("#passwordConfirmTick"), "neutral");
            isValid = false;
        } else {
            isValid = verify.passwordValid(userInput);
    
            if (isValid) {
                verify.setStatus($tick, "valid", true);
            } else {
                verify.setStatus($tick, "invalid", true);
            }
        }
        conditionMet.password = isValid;
        setSubmitBtnState();
    });

    $("#passwordConfirmTxt").keyup(function() {        
        const $tick = $("#passwordConfirmTick");
        const userInput = $(this).val();
        let isValid = false;
    
        if (verify.isEmpty($("#passwordTxt").val())) {
            verify.setStatus($tick, "neutral");
                isValid = false;
        } else {
            isValid = verify.confirmPasswordValid(userInput, $("#passwordTxt").val());
    
            if (isValid) {
                verify.setStatus($tick, "valid", true);
            } else {
                verify.setStatus($tick, "invalid", true);
            }
        }
        conditionMet.passwordConfirm = isValid;
        setSubmitBtnState();
    });

    $("#emailTxt").keyup(function() {
        const $tick = $("#emailTick");
        const userInput = $(this).val();
        let isValid = false;

        if (verify.isEmpty(userInput)) {
            verify.setStatus($tick, "neutral");
            isValid = "n/a"; // n/a because this field is not required
        } else {
            isValid = verify.emailValid(userInput)

            if (isValid) {
                verify.setStatus($tick, "valid");
            } else {
                verify.setStatus($tick, "invalid");
            }
        }
        conditionMet.email = isValid;
        setSubmitBtnState();
    })

    $("#firstnameTxt").keyup(function() {
        const $tick = $("#firstnameTick");
        const userInput = $(this).val();
        let isValid = false;

        if (verify.isEmpty(userInput)) {
            verify.setStatus($tick, "neutral");
            isValid = "n/a"; // n/a because this field is not required
        } else {
            isValid = verify.nameValid(userInput)

            if (isValid) {
                verify.setStatus($tick, "valid");
            } else {
                verify.setStatus($tick, "invalid");
            }
        }
        conditionMet.firstname = isValid;
        setSubmitBtnState();
    })

    $("#lastnameTxt").keyup(function() {
        const $tick = $("#lastnameTick");
        const userInput = $(this).val();
        let isValid = false;

        if (verify.isEmpty(userInput)) {
            verify.setStatus($tick, "neutral");
            isValid = "n/a"; // n/a because this field is not required
        } else {
            isValid = verify.nameValid(userInput)

            if (isValid) {
                verify.setStatus($tick, "valid");
            } else {
                verify.setStatus($tick, "invalid");
            }
        }
        conditionMet.lastname = isValid;
        setSubmitBtnState();
    })

    $("#ageTxt").keyup(function() {
        const $tick = $("#ageTick");
        const userInput = $(this).val();
        let isValid = false;

        if (verify.isEmpty(userInput)) {
            verify.setStatus($tick, "neutral", true);
            isValid = false;
        } else {
            isValid = verify.ageValid(userInput)

            if (isValid) {
                verify.setStatus($tick, "valid", true);
            } else {
                verify.setStatus($tick, "invalid", true);
            }
        }
        conditionMet.age = isValid;
        setSubmitBtnState();
    });

    /**
     * Sets the submit button to disabled or not depending on the state of the conditionMet object
     */
    function setSubmitBtnState() {
        let numFalse = 0;
        for (const condition in conditionMet) {
            let property = conditionMet[condition];
            if (property === false) numFalse++;
        }

        if (numFalse === 0 && conditionMet.username && conditionMet.password && conditionMet.passwordConfirm && conditionMet.age) {
            $("#submitBtn").prop("disabled", false);
        } else {
            $("#submitBtn").prop("disabled", true);
        }
    }
});