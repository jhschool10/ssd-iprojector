/**
 * This is the companion javascript to user_profile.php
 * Author: Joseph Haley
*/
$("document").ready(function () {

    // Variables
    /**
     * Keeps track of the status of any input entered by the user
     */
    let conditionMet = {
        password: "n/a", // true, false, "n/a"
        passwordConfirm: "n/a", // true, false, "n/a"
        email: "n/a", // true, false, "n/a"
        firstname: "n/a", // true, false, "n/a"
        lastname: "n/a", // true, false, "n/a"
        age: "n/a", // true, false, "n/a"
    }

    // Init
    setSubmitBtnState();

    // Listeners
    $("#oldPasswordTxt").keyup(function() {
        // validation of old password ("whether it is present or not") is tested in setSubmitBtnState() since
        //  the other fields need to check for its presence as well for the submit button to verify
        setSubmitBtnState();
    });
  
    $("#passwordTxt").keyup(function() {
        const $tick = $("#passwordTick");
        const userInput = $(this).val();
        let isValid = false;
        
        if (verify.isEmpty(userInput)) {
            verify.setStatus($tick, "neutral");
            verify.setStatus($("#passwordConfirmTick"), "neutral");
            conditionMet.passwordConfirm = "n/a";
            isValid = "n/a"; // n/a because an empty field means this attribute won't be changed
        } else {
            isValid = verify.passwordValid(userInput);
    
            if (isValid) {
                verify.setStatus($tick, "valid");
            } else {
                verify.setStatus($tick, "invalid");
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
                isValid = "n/a"; // n/a because it doesn't matter what is in here if the password field is empty
        } else {
            isValid = verify.confirmPasswordValid(userInput, $("#passwordTxt").val());
    
            if (isValid) {
                verify.setStatus($tick, "valid");
            } else {
                verify.setStatus($tick, "invalid");
            }
        }
        conditionMet.passwordConfirm = isValid;
        setSubmitBtnState();
    });

    $("#ageTxt").keyup(function() {
        const $tick = $("#ageTick");
        const userInput = $(this).val();
        let isValid = false;

        if (verify.isEmpty(userInput)) {
            verify.setStatus($tick, "neutral");
            isValid = "n/a"; // n/a because an empty field means this attribute won't be changed
        } else {
            isValid = verify.ageValid(userInput)

            if (isValid) {
                verify.setStatus($tick, "valid");
            } else {
                verify.setStatus($tick, "invalid");
            }
        }
        conditionMet.age = isValid;
        setSubmitBtnState();
    });

    $("#emailTxt").keyup(function() {
        const $tick = $("#emailTick");
        const userInput = $(this).val();
        let isValid = false;

        if (verify.isEmpty(userInput)) {
            verify.setStatus($tick, "neutral");
            isValid = "n/a"; // n/a because an empty field means this attribute won't be changed
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
            isValid = "n/a"; // n/a because an empty field means this attribute won't be changed
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
            isValid = "n/a"; // n/a because an empty field means this attribute won't be changed
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
    /**
     * Sets the submit button to disabled or not depending on the state of the conditionMet object
     */
    function setSubmitBtnState() {
        if ($("#oldPasswordTxt").val().length !== 0) { // Only bother verifying things if the old password is present

            let numTrue = 0, numFalse = 0, numNA = 0;
            for (const condition in conditionMet) {
                let property = conditionMet[condition];
                if (property === true) numTrue++;
                if (property === false) numFalse++;
                if (property === "n/a") numNA++;
            }

            if (numTrue > 0 && numFalse === 0) {
                $("#submitBtn").prop("disabled", false);
            } else {
                $("#submitBtn").prop("disabled", true);
            }

            $("#oldPasswordBox").addClass("alert-warning")
                                .removeClass("alert-danger");
        } else {
            $("#submitBtn").prop("disabled", true);
            $("#oldPasswordBox").addClass("alert-danger")
                                .removeClass("alert-warning");
        }
    }
});