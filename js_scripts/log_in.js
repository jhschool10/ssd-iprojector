$("document").ready(function() {
    thoughts.getRandom()
        .then(thought => {
            console.log(thought);
            $("#random_thought").append(createThoughtEle(thought, true));
        })
});