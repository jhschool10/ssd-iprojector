$("document").ready(async function() {
    const thought = await getOneThought("random");
    console.log(thought);
    $("#random_thought").append(createThoughtDiv(thought[0], true));
});