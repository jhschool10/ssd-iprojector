$("document").ready(function () {

    let conditionMet = {
        username: false,
        password: false,
        passwordConfirm: false,
        age: false,
    }

    // Init
    $("#usernameTxt").keyup(function() {
        const $tick = $("#usernameTick");
        let userInput = $(this).val();
        let isValid = false;
        clearTimeout(verify.timer);

        if (verify.isEmpty(userInput)) {
            verify.setStatus($tick, "neutral");
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
                                verify.setStatus($tick, "valid");
                                $("#usernameMsg").addClass("d-none")
                                                    .removeClass("d-inline");
                                $("#usernameInstr").addClass("d-inline")
                                                    .removeClass("d-none");
                            } else {
                                isValid = false;
                                verify.setStatus($tick, "invalid");
                                $($("#usernameMsg")).addClass("d-inline")
                                                    .removeClass("d-none");
                                $("#usernameInstr").addClass("d-none")
                                                    .removeClass("d-inline");
                            }
                        });
                }.bind(this), 300);
            } else {
                verify.setStatus($tick, "invalid");
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
                isValid = false;
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
            isValid = false;
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

    function setSubmitBtnState() {
        console.log(conditionMet.username, conditionMet.password, conditionMet.passwordConfirm, conditionMet.age);
        if (conditionMet.username && conditionMet.password && conditionMet.passwordConfirm && conditionMet.age) {
            $("#submitBtn").prop("disabled", false);
        } else {
            $("#submitBtn").prop("disabled", true);
        }
    }
});